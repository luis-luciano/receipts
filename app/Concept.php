<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Concept extends Model {
	protected $table = 'tabla001';

	protected $primaryKey = 'concepto';

	protected $keyType = 'string';

	public static function searchContract($contract) {
		return static::find(str_pad($contract, 9, '0', STR_PAD_LEFT));
	}

	public function details() {
		return $this->hasMany('App\Detail', 'concepto');
	}

}