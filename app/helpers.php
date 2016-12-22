<?php

use Carbon\Carbon;

if (!function_exists('formatDate')) {
	function formatDate($date) {
		return Carbon::createFromFormat('d/m/Y', (string) trim($date))->format('Ymd');
	}
}

if (!function_exists('formatPeriod')) {
	function formatPeriod($month) {
		try {
			$months = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
			return $months[$month - 1] . "/" . substr((String) Carbon::now()->year, 2);
		} catch (Exception $e) {
			return "";
		}
	}
}
