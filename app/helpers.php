<?php

use Carbon\Carbon;

if (!function_exists('formatDate')) {
	function formatDate($date) {
		return Carbon::createFromFormat('d/m/Y', (string) trim($date))->format('Ymd');
	}
}
