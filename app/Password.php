<?php

namespace App;

use App\Traits\ListForSelectTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Password extends Model
{
	use ListForSelectTrait, SoftDeletes;

	protected $fillable = [
		'name',
		'comment',
	];

	public function passwordCities()
	{
		return $this->hasMany('App\PasswordCity');
	}

	public function tags()
	{
		return $this->belongsToMany('App\Tag');
	}

}
