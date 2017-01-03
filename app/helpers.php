<?php

use App\Formatters\NumberFormatter;
use Carbon\Carbon;

if (!function_exists('formatDate')) {
	function formatDate($date) {
		return Carbon::createFromFormat('d/m/Y', (string) trim($date))->format('Ymd');
	}
}

if (!function_exists('transConcept')) {
	function transConcept($conceptId, $description) {
		$conceptId = (int) $conceptId;

		$concepts = [
			50 => 'REDONDEO',
			45 => 'CONTRIBUCION ADICIONAL',
		];

		if (array_key_exists($conceptId, $concepts)) {
			return $concepts[$conceptId];
		}

		return $description;
	}
}

if (!function_exists('descriptiveAmount')) {
	function descriptiveAmount(int $amount) {
		$numbersFormatter = app(NumberFormatter::class);
		$currency = ($amount == 1) ? 'PESO' : 'PESOS';
		return "(" . strtoupper($numbersFormatter->toWords($amount)) . " " . $currency . " 00/100 M.N)";
	}
}

if (!function_exists('annualPaymentReference')) {
	function annualPaymentReference(int $contract, $receipt, $cutoffDate, int $total) {
		return "16" . str_pad((int) $contract, 5, "0", STR_PAD_LEFT) . $receipt . Carbon::createFromFormat('d/m/Y', (string) $cutoffDate)->format('Ymd') . str_pad((int) $total, 5, "0", STR_PAD_LEFT) . "003";
	}
}