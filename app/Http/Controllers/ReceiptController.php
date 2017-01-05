<?php

namespace App\Http\Controllers;
use App\Contract;
use App\Limit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use PDF;

class ReceiptController extends Controller {

    private $options;

    public function __construct()
    {
        $this->options = array(
            'page-size' => 'letter',
            'margin-left' => 0,
            'margin-right' => 0,
            'user-style-sheet' => public_path() . '/assets/css/receipt.css',
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function receipts($year, $period, $sector, $route) 
    {
        ini_set('max_execution_time', 5000);
        ini_set('memory_limit', '14G');

        $dateOfIssue = Carbon::now()->toDateString();
        $paydayLimit = trim(Limit::find('MSG')->f_limite_pago);

        if ($wantTheLatest = true || is_null(cache('contracts'))) {
            $this->cacheReceipts($year, $period, $sector, $route);
            die;
        }

        $contracts = cache('contracts');
        $lectures = cache('lectures');
        $dues = cache('dues');
        $normalHeaders = cache('normalHeaders');
        $normalDetails = cache('normalDetails');
        $details = cache('details');

        $lectures = $lectures->groupBy('contrato');
        $dues = $dues->groupBy('contrato');
        $normalHeaders = $normalHeaders->groupBy('contrato');
        $normalDetails = $normalDetails->groupBy('contrato');
        $details = $details->groupBy('contrato');

        $contracts->transform(function($contract, $index) use ($lectures, $dues, $normalHeaders, $normalDetails, $details) {
            $contract->lecture = (($contractLecture = $lectures->pull($contract->contrato)) ? $contractLecture->first() : null);
            $contract->due = (($contractDue = $dues->pull($contract->contrato)) ? $contractDue->first() : null);
            $contract->normalHeader = ($contractNormalHeaders = $normalHeaders->pull($contract->contrato)) ? $contractNormalHeaders->first() : null;
            $contract->normalDetails = ($contractNormalDetails = $normalDetails->pull($contract->contrato)) ? : null;
            $contract->details = ($contractDetails = $details->pull($contract->contrato)) ? : null;

            return $contract;
        });

        // $contracts = $contracts->take(10);

        $pdf = PDF::loadView('receipts.test', compact(
            'contracts',
            'dateOfIssue',
            'paydayLimit'
        ));

        $pdf->setOptions($this->options);
        $receiptsName = 'Receipts-' . $sector .'-'. $route .'-'. Carbon::now()->format('Y-m-d') . '.pdf';

        return $pdf->stream($receiptsName);
    }

    // private function filterReduce($collection, )

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

        Cache::forever('contracts', $contracts);
        Cache::forever('lectures', $lectures);
        Cache::forever('dues', $dues);
        Cache::forever('normalHeaders', $normalHeaders);
        Cache::forever('normalDetails', $normalDetails);
        Cache::forever('details', $details);
    }
}
