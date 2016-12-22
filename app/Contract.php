<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model {
	protected $table = 'tabla051';

	protected $primaryKey = 'contrato';

	protected $keyType = 'string';

	private $months = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

	public static function searchContract($contract) {
		return static::find(str_pad($contract, 9, '0', STR_PAD_LEFT));
	}

	public function rate() {
		return $this->belongsTo('App\Rate', 'tarifa');
	}

	public function getRateDescriptionAttribute() {
		return $this->tarifa . " " . trim($this->rate->descripcion);
	}

	public function getInvoicedMonthAttribute() {
		try {
			return strtoupper($this->months[$this->periodo - 1]) . "/" . substr((String) Carbon::now()->year, 2);
		} catch (Exception $e) {
			return "";
		}
	}

}
