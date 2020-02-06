<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubProject extends Model
{

	protected $table = 'sub_projects';

	protected $fillable = [
		'name',
		'project_id',
		'url'
	];

	use SoftDeletes;

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
