<?php

namespace App;

use App\Traits\ListForSelectTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PasswordCity extends Model
{

	use ListForSelectTrait, SoftDeletes;

	protected $table = 'password_city';

	public function password()
	{
		return $this->belongsTo('App\Password');
	}



}
