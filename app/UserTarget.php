<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserTarget extends Model
{

	public function userSubProject() {
		return $this->belongsTo('App\UserSubProject');
	}

	public function channel() {
		return $this->belongsTo('App\Channel');
	}

	public function status() {
		return $this->belongsTo('App\Status');
	}

	public function lastHistory() {
		return $this->hasOne('App\StatusHistory')->latest();
	}
}
