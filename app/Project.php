<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\ListForSelectTrait;

class Project extends Model
{

	use ListForSelectTrait;

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
