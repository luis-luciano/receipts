<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NormalHeader extends Model {
	protected $table = 'tabla110';

	protected $primaryKey = 'contrato';

	protected $keyType = 'string';

	public function normalDetails() {
		return $this->hasMany('App\NormalDetail', 'contrato');
	}

	public function scopeLatest($query, $contracts, $year, $period) {
		return $query->where("num_cia", "01")
			->whereIn("contrato", $contracts)
		// ->whereIn("contrato", (string) $this->getContractFormat($contract))
			->where("año", (string) $year)
			->where("periodo", (string) $period)
			->where("status", "A")
			->where("bandera_pa", "A");
	}
	private function getContractFormat($contract) {
		return str_pad($contract, 9, "0", STR_PAD_LEFT);
	}
}
