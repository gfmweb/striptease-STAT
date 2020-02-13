<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StatusHistory extends Model
{
	protected $table = 'statuses_history';

	public function userTarget()
	{
		return $this->belongsTo(UserTarget::class);
	}

	public function status()
	{
		return $this->belongsTo(Status::class);
	}
}
