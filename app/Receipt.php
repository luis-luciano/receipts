<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Receipt extends Model {
	protected $table = 'tabla062';

	protected $primaryKey = 'contrato';

	protected $keyType = 'string';

	public static function searchContract($contract) {
		return static::find(str_pad($contract, 9, '0', STR_PAD_LEFT));
	}

	public function contract()
	{
		return $this->belongsTo('App\Contract','contrato');
	}
}
