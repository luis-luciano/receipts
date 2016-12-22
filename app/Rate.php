<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rate extends Model {
	protected $table = 'tabla006';

	protected $primaryKey = 'tarifa';

	public function rates() {
		return $this->hasMany('App\Contract', 'tarifa');
	}
}
