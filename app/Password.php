<?php

namespace App;

use App\Traits\ListForSelectTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Password
 * @package App
 * @property Collection cities
 * @property string     name
 * @property string     comment
 */
class Password extends Model
{
	use ListForSelectTrait, SoftDeletes;

	/**
	 * @var array
	 */
	protected $fillable = [
		'name',
		'comment',
	];

	public function passwordCities()
	{
		return $this->hasMany('App\PasswordCity');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function cities()
	{
		return $this->belongsToMany('App\City', 'password_city')->withTimestamps();
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function tags()
	{
		return $this->belongsToMany('App\Tag');
	}

}
