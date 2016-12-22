<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Measuring extends Model {
	protected $table = 'tabla053';

	protected $primaryKey = 'contrato';

	protected $keyType = 'string';

	public static function searchContract($contract) {
		return static::find(str_pad($contract, 9, '0', STR_PAD_LEFT));
	}
}