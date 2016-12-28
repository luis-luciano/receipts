<?php

namespace App;

use App\Formatters\NumberFormatter;
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

	public function details() {
		return $this->hasMany('App\Detail', 'contrato');
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

	public function getCutoffDateAttribute() {
		return trim($this->receipt->fecha_cte);
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

	public function getMonthsOfLagAttribute() {
		return ($this->pagos_ven > 0) ? substr(strtoupper($this->months[$this->date_of_last_payment->month]), 0, 3) . "-" . $this->date_of_last_payment->year . " A " . substr(strtoupper($this->months[$this->last_period->month]), 0, 3) . "-" . $this->year : "";
	}

	public function getDateOfLastPaymentAttribute() {
		$today = Carbon::create((int) $this->year, (int) $this->periodo);
		return $today->subMonths($this->pagos_ven + 1);
	}

	public function getLastPeriodAttribute() {
		return Carbon::create((int) $this->year, (int) $this->periodo)->subMonths(1);
	}

	public function getMonthlyPaymentReferenceAttribute() {
		return '23' . substr(trim($this->contrato), -5) . $this->receipt_number .
		Carbon::createFromFormat('d/m/Y', (string) $this->cutoff_date)->format('Ymd') .
		str_pad((int) $this->total, 5, "0", STR_PAD_LEFT) . '001';
	}

	public function getInvoicedMonthAttribute() {
		try {
			return strtoupper($this->months[$this->last_period->month]) . "/" . substr((String) $this->year, 2);
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