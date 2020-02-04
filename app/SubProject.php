<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class User
 * @package App
 */
class SubProject extends Model
{

	protected $table = 'sub_projects';

	protected $fillable = [
		'name',
		'project_id',
		'url'
	];

	public function city()
	{
		return $this->belongsTo('App\City', 'city_id');
	}

}
