<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NormalDetail extends Model {
	protected $table = 'tabla111';

	protected $primaryKey = 'contrato';

	protected $keyType = 'string';

	public function concept() {
		return $this->belongsTo('App\Concept', 'concepto');
	}

	public function normalHeader() {
		return $this->belongsTo('App\NormalHeader', 'contrato', 'recibo');
	}

	public function scopeLatest($query, $contracts, $year, $period) {
		return $query->where("num_cia", "01")
			->where("año", (string) $year)
			->where("periodo", (string) $period)
			->where("status", "A")
			->whereIn("contrato", $contracts);
	}
	private function getContractFormat($contract) {
		return str_pad($contract, 9, "0", STR_PAD_LEFT);
	}
}
