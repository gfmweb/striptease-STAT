<?php

namespace App;

use App\Traits\ListForSelectTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class User
 * @package App
 * @property int     id
 * @property string  name
 * @property string  fullName
 * @property string  url
 * @property Project project
 * @property City    city
 */
class SubProject extends Model
{

	use ListForSelectTrait;

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

	public function userTarget()
	{
		return $this->hasMany(UserTarget::class);
	}

	public function fullName()
	{
		return ($this->project ? $this->project->name : '') . ' : ' . $this->name;
	}

	public function getFullNameAttribute()
	{
		return $this->fullName();
	}
}
