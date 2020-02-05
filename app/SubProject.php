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

	// проект подпроекта
	public function project()
	{
		return $this->belongsTo('App\Project');
	}


	// город подпроекта
	public function city()
	{
		return $this->belongsTo('App\City', 'city_id');
	}

}
