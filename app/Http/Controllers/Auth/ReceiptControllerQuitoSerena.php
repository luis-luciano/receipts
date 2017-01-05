<?php

namespace App\Http\Controllers;
use App\Contract;
use App\Limit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class ReceiptControllerQuitoSerena extends Controller {

	private $options;

    public function __construct()
    {
        $this->options = array(
            'page-size' => 'letter',
            'margin-left' => 0,
            'margin-right' => 0,
            //'user-style-sheet' => public_path() . 'assets/css/receipt.css'
        );
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function test($year, $period, $sector, $route) 
	{
		/*
			$year = 2016, $period = 12, $sector = '009', $route = '04'
			$contracts = Contract::searchContract(1208);
			$currentLecture = Lecture::latest(1208, 2016, 11)->first();
			$details = Detail::latest(1208, 2016, 11)->get();
		*/
		ini_set('max_execution_time', 5000);
		ini_set('memory_limit', '14G');

		$dateOfIssue = Carbon::now()->toDateString();
		$paydayLimit = trim(Limit::find('MSG')->f_limite_pago);

		if ($wantTheLatest = false || is_null(cache('contracts'))) {
			$this->cacheReceipts($year, $period, $sector, $route);
		}

		$contracts = cache('contracts');
		dd($contracts);
		$lectures = cache('lectures');
		$dues = cache('dues');
		$normalHeaders = cache('normalHeaders');
		$normalDetails = cache('normalDetails');
		$details = cache('details');

		/*$data = array();

		foreach ($contracts as $contract) {
			$lects = array();

			foreach ($lectures->where('contrato', $contract->contrato) as $lecture) {
				array_push($lects, $lecture);
			}

			$data=[
				'contract' => $contract,
				'lectures' => $lects
			];
		}

		dd($data);*/

		$contracts = $contracts->take(1);

		$pdf = PDF::loadView('receipts.test');
		$pdf->setOptions($this->options);
		return $pdf->stream("prueba");

		$pdf = PDF::loadView('receipts.receipt', compact(
			'contracts',
			'lectures',
			'dues',
			'normalHeaders',
			'normalDetails',
			'details',
			'dateOfIssue',
			'paydayLimit'
		));
        $pdf->setOptions($this->options);
        $receiptsName = 'Receipts-' . $sector .'-'. $route .'-'. Carbon::now()->format('Y-m-d') . '.pdf';
        return $pdf->stream($receiptsName);
	}

	private function cacheReceipts($year, $period, $sector, $route) 
	{
		$contracts = Contract::where('status', 'A')->where('total', '>', 0)->where('sector', $sector)->where('ruta', $route)->orderBy('folio', 'asc')->get();

		$normalHeaders = DB::select(DB::raw("
			select *
			from tabla110
			where num_cia='01'
			and año = '2016'
			and periodo = '12'
			and status = 'A'
			and bandera_pa = 'A'
			and exists (
				select 1
				from tabla051
				where total > 0 and sector = $sector and status = 'A' and ruta = $route
			)
		"));

		$normalDetails = DB::select(DB::raw("
			select tabla111.*
			from tabla111
			where tabla111.num_cia='01'
			and tabla111.año = '2016'
			and tabla111.periodo = '12'
			and tabla111.status = 'A'
			and exists (
				select 1
				from tabla110
				where num_cia='01'
				and año = '2016'
				and periodo = '12'
				and status = 'A'
				and bandera_pa = 'A'
				and tabla111.recibo = tabla110.recibo
				and exists (
					select 1
					from tabla051
					where total > 0 and sector = $sector and status = 'A' and ruta = $route
				)
			)
		"));

		$dues = DB::select(DB::raw("
			select tabla111.contrato, SUM(tabla111.cargo_mes) - SUM(tabla111.abono) as totalAPagar
			from tabla111
			where tabla111.num_cia='01'
			and tabla111.año = '2016'
			and tabla111.periodo = '12'
			and tabla111.status = 'A'
			and exists (
				select 1
				from tabla110
				where num_cia='01'
				and tabla110.status = 'A'
				and tabla110.bandera_pa = 'A'
				and tabla111.recibo = tabla110.recibo
				and tabla110.año = '2016'
				and tabla110.periodo = '12'
				and exists (
					select 1
					from tabla051
					where total > 0 and sector = $sector and status = 'A' and ruta = $route
				)
			)
			group by tabla111.contrato
		"));

		$lectures = DB::select(DB::raw("
			select *
			from tabla053
			where num_cia = '01'
			and año = '2016'
			and periodo = '12'
			and status = 'A'
			and exists (
				select 1
				from tabla051
				where total > 0 and sector = $sector and status = 'A' and ruta = $route
				and contrato = tabla053.contrato
			)
		"));

		$details = DB::select(DB::raw("
			select tabla059.*, tabla001.descripcion
			from tabla059
			inner join tabla001
			on tabla001.concepto = tabla059.concepto
			where tabla059.num_cia = '01'
			and tabla059.status = 'A'
			and año = '2016'
			and periodo = '12'
			and exists (
				select 1
				from tabla051
				where total > 0 and sector = $sector and status = 'A' and ruta = $route
				and contrato = tabla059.contrato
			)
		"));

		$lectures = collect($lectures);
		$dues = collect($dues);
		$normalHeaders = collect($normalHeaders);
		$normalDetails = collect($normalDetails);
		$details = collect($details);

		cache(['contracts' => $contracts], 60);
		cache(['lectures' => $lectures], 60);
		cache(['dues' => $dues], 60);
		cache(['normalHeaders' => $normalHeaders], 60);
		cache(['normalDetails' => $normalDetails], 60);
		cache(['details' => $details], 60);
	}
}
