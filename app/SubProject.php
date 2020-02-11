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
 * @property string  fullUrl
 * @property Project project
 * @property City    city
 */
class SubProject extends Model
{

	use ListForSelectTrait, SoftDeletes;

	protected $table = 'sub_projects';

	protected $fillable = [
		'name',
		'project_id',
		'url',
		'city_id',
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

	public function userTargets()
	{
		return $this->hasManyThrough(UserTarget::class, UserSubProject::class, 'sub_project_id', 'user_sub_project_id');
	}

	// проект подпроекта
	public function userSubProjects()
	{
		return $this->hasMany(UserSubProject::class);
	}


	public function fullName()
	{
		return ($this->project ? $this->project->name : '') . ' : ' . $this->name;
	}

	public function getFullNameAttribute()
	{
		return $this->fullName();
	}

	public function tags()
	{
		return $this->belongsToMany('App\Tag');
	}

	public function getFullUrlAttribute()
	{
		return preg_match('/^http/', $this->url) ? $this->url : 'http://' . $this->url;
	}
}
