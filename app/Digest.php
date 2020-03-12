<?php

namespace App;

use App\Traits\ListForSelectTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Digest extends Model
{
	use ListForSelectTrait;

	public function group()
	{
		return $this->belongsTo('App\DigestGroup', 'digest_group_id');
	}

	public function data()
	{
		return $this->hasMany('App\DigestData');
	}
}