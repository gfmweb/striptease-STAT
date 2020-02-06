<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Project
 * @package App
 * @property string name
 */
class Project extends Model
{

	protected $table = 'projects';

	protected $fillable = [
		'name',
		'city_id',
		'partner_id'
	];

	public function subProjects()	{
		return $this->hasMany('App\SubProject');
	}

}
