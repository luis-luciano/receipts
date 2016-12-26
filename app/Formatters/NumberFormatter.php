<?php

namespace App\Formatters;

use Numbers_Words;

class NumberFormatter {
	private $formatter;
	private $locale = 'es_MX';

	public function __construct(Numbers_Words $formatter) {
		$this->formatter = $formatter;
	}

	public function toWords($number) {
		return $this->formatter->toWords($number, $this->locale);
	}
}