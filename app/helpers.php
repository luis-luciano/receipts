<?php

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