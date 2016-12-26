<?php

namespace App;

use App\Formatters\NumberFormatter;
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

	public function receipt() {
		return $this->hasOne('App\Receipt', 'contrato');
	}

	public function lectures() {
		return $this->hasMany('App\Lecture', 'contrato');
	}

	public function getReceiptNumberAttribute() {
		return $this->receipt->recibo;
	}

	public function getDueDateAttribute() {
		return trim($this->receipt->f_vencimiento);
	}

	public function getServiceAddressAttribute() {
		return trim($this->direccion) . "<br>" . trim($this->colonia);
	}

	public function getRateDescriptionAttribute() {
		return $this->tarifa . " " . trim($this->rate->descripcion);
	}

	public function getFiscalAddressAttribute() {
		return trim($this->direccion_fiscal) . " " . trim($this->colonia_fiscal);
	}

	public function getYearAttribute() {
		return array_values($this->attributes)[41];
	}

	public function getInvoicedMonthAttribute() {
		try {
			return strtoupper($this->months[$this->periodo - 1]) . "/" . substr((String) $this->year, 2);
		} catch (Exception $e) {
			return "";
		}
	}

	public function getTotalFormatAttribute() {
		$total = (float) $this->total;
		$numbersFormatter = app(NumberFormatter::class);
		$currency = ($total == 1) ? 'PESO' : 'PESOS';
		return "(" . strtoupper($numbersFormatter->toWords($total)) . " " . $currency . " 00/100 M.N)";
	}
}