<?php

namespace App;

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
	use Notifiable;

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
		return $this->belongsToMany('App\SubProject', 'user_sub_projects');
	}
}
