<?php

namespace App\Http\Controllers;
use App\Contract;
use App\Detail;
use App\Lecture;
use Illuminate\Http\Request;

class ReceiptController extends Controller {
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

		$all = Contract::where('status', 'A')->where('total', '>', 0)->limit(1)->pluck('contrato')->toArray();

		$contracts = Collect();

		foreach ($all as $contract) {
			$user = [
				'contract' => Contract::searchContract($contract),
				'lecture' => Lecture::latest($contract, 2016, 11)->first(),
				'details' => Detail::latest($contract, 2016, 11)->get(),
			];

			$contracts->put($contract, $user);
		}

		return view('receipts.receipt', compact('contracts'));
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
