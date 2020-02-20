<?php

namespace App;

use App\Traits\ListForSelectTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * Class User
 * @package App
 * @property int     id
 * @property string  name
 * @property string  fullName
 * @property string  url
 * @property string  fullUrl
 * @property string  shortUrl
 * @property Project project
 * @property City    city
 * @property Tag     tags
 */
class SubProject extends Model
{

	use ListForSelectTrait;

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

	public function userSubProject()
	{
		return $this->hasMany(UserSubProject::class);
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

	public function getShortUrlAttribute()
	{
		return preg_replace('/(^http:\/\/|^https:\/\/|\/$)/', '', $this->url);
	}

	public function getFullUrlAttribute()
	{
		return preg_match('/^http/', $this->url) ? $this->url : 'http://' . $this->url;
	}

	/** Возвращает теги в подготовленной форме массива
	 * @return array
	 */
	public function tagsForLabel()
	{
		$tags = [];
		/** @var Tag $tag */
		foreach ($this->tags as $tag) {
			$tags[] = [
				'name'  => $tag->name,
				'class' => 'badge-warning',
				'short' => substr($tag->name, 0, 2),
			];
		}
		return $tags;
	}
}
