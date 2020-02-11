<?php

namespace App;

use App\Traits\ListForSelectTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Project
 * @package App
 * @property  string name
 */
class Project extends Model
{

	use ListForSelectTrait, SoftDeletes;

	protected $table = 'projects';

	protected $fillable = [
		'name',
		'city_id',
		'partner_id'
	];

	public function subProjects()
	{
		return $this->hasMany('App\SubProject');
	}

}
