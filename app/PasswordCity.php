<?php

namespace App;

use App\Traits\ListForSelectTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class PasswordCity
 * @package App
 * @property integer    id
 * @property City       city
 * @property Password   password
 * @property Collection data
 */
class PasswordCity extends Model
{

	use ListForSelectTrait, SoftDeletes;

	protected $table = 'password_city';

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function password()
	{
		return $this->belongsTo('App\Password');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function city()
	{
		return $this->belongsTo('App\City');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function data()
	{
		return $this->hasMany('App\PasswordCityData');
	}


}
