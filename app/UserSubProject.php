<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class UserSubProject extends Model
{
	public function user() {
		return $this->belongsTo('App\User');
	}

	public function subProject() {
		return $this->belongsTo('App\SubProject');
	}
}
