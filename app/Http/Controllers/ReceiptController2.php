<?php

namespace App\Http\Controllers;
use App\Contract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReceiptController2 extends Controller {

	private $options, $optionsAgreement;

	public function __construct() {
		/*$this->options = array(
			'page-size' => 'executive',
			'margin-top' => 0,
			'margin-left' => 0,
			'user-style-sheet' => public_path() . '\assets\css\receipt.css',
		);*/
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
/*
$contracts = Contract::where('status', 'A')
->where('total', '>', 0)
->select(['contrato',
'nombre',
'colonia',
'direccion',
'tarifa',
'sector',
'ruta',
'folio',
'medidor',
'servicio',
'pagos_ven',
'total',
'rfc_u',
'cve_dren',
'año',
'periodo',
'cons_promedio',
'direccion_fiscal',
'colonia_fiscal',
'cve_ubica'])
->limit(1)
->orderBy('sector', 'asc')
->orderBy('ruta', 'asc')
->orderBy('folio', 'asc')
->orderBy('contrato', 'asc')
->get()->toArray();
$list_contracts = array();

dd($contracts[0]);

foreach ($contracts as $contract) {

$receipt = Receipt::where('año', "2016")
->where('periodo', "11")
->where('contrato', $contract['contrato'])
->select(['recibo', 'tot_apagar', 'f_vencimiento', 'm3_facturados'])
->get()->toArray();

//dd($receipt);
$concepts = Concept::where('año', "2016")
->where('periodo', "11")
->where('contrato', $contract['contrato'])
->select(['concepto', 'importe_a', 'importe_v'])
->get()->toArray();

$contract['conceptos'] = $concepts;

$measuring = Measuring::where('año', "2016")
->where('periodo', "11")
->where('contrato', $contract['contrato'])
->select(['lec_anterior', 'lec_actual', 'consumo'])
->get()->toArray();

if (isset($measuring[0])) {
$contract = array_merge($contract, $measuring[0]);
}

$contract = array_merge($contract, $receipt[0]);

$barcodeRN = '23' . substr($contract['contrato'], -5) . $contract['recibo'] . Carbon::createFromFormat('d/m/Y', (string) trim($contract['f_vencimiento']))->format('Ymd') . str_pad((int) $contract['tot_apagar'], 10, "0", STR_PAD_LEFT) . '001';

$barcodePA = '23' . substr($contract['contrato'], -5) . $contract['recibo'] . Carbon::createFromFormat('d/m/Y', (string) trim($contract['f_vencimiento']))->format('Ymd') . str_pad((int) $contract['tot_apagar'], 10, "0", STR_PAD_LEFT) . '012';

$contract['barcode-rn'] = $barcodeRN;

$contract['barcode-pa'] = $barcodePA;

// dd( $contract);

array_push($list_contracts, $contract);

//dd( $contract);

}*/
		/*
			$contracts = Contract::searchContract(1208);
			$currentLecture = Lecture::latest(1208, 2016, 11)->first();
			$details = Detail::latest(1208, 2016, 11)->get();
		*/
		ini_set('max_execution_time', 3500);
		ini_set('memory_limit', '38G');

		if ($wantTheLatest = false || is_null(cache('contracts'))) {
			$this->cacheReceipts();
		}

		$contracts = cache('contracts');
		$lectures = cache('lectures');
		$dues = cache('dues');
		$normalHeaders = cache('normalHeaders');
		$normalDetails = cache('normalDetails');
		$details = cache('details');

		$contracts = $contracts->take(10);
		//dd($details->where('contrato', '000050203'));

		/*$datos = [];
			foreach ($contracts as $contract) {
				$cont = $details->where('contrato', $contract->contrato);
				array_push($datos, $cont);
			}

		*/

		return view('receipts.receipt', compact(
			'contracts',
			'lectures',
			'dues',
			'normalHeaders',
			'normalDetails',
			'details'
		));
	}

	private function cacheReceipts() {
		$year = 2016;
		$period = 12;
		$sector = '020';
		$route = '01';

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
				where num_cia='01' and total > 0 and sector = $sector and status = 'A' and ruta = $route
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
				where num_cia='01' and total > 0 and sector = $sector and status = 'A' and ruta = $route
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

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id) {
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id) {
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id) {
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		//
	}
}
