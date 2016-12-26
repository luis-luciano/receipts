<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lecture extends Model {
	protected $table = 'tabla053';

	protected $primaryKey = 'contrato';

	protected $keyType = 'string';

	public function contract() {
		return $this->belongsTo('App\Contract', 'contrato', 'año');
	}

	public function getContractFormat($contract) {
		return str_pad($contract, 9, "0", STR_PAD_LEFT);
	}

	public function scopeLatest($query, $contract, $year, $period) {
		return $query->where("num_cia", "01")
			->where("contrato", (string) $this->getContractFormat($contract))
			->where("año", (string) $year)
			->where("periodo", (string) $period)
			->where("status", "A");
	}
}
