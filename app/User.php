<?php

namespace App;

use App\Traits\ListForSelectTrait;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User
 * @package App
 * @property int    $role
 * @property int    id
 * @property string name
 * @property string login
 * @property string password
 */
class User extends Authenticatable
{
	use Notifiable, ListForSelectTrait;

	const ROLE_USER  = 1;
	const ROLE_ADMIN = 2;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name', 'email', 'login', 'password', 'role',
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token', 'role',
	];

	public function isAdmin()
	{
		return $this->role == self::ROLE_ADMIN;
	}

	// подпроекты юзеров
	public function subProjects()
	{
		return $this->belongsToMany(SubProject::class, 'user_sub_projects');
	}

	public function userTargets()
	{
		return $this->hasManyThrough(UserTarget::class, UserSubProject::class, 'user_id', 'user_sub_project_id');
	}


}
