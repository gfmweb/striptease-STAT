<?php

namespace App;

use App\Traits\ListForSelectTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Class User
 * @package App
 * @property int    $role
 * @property int    id
 * @property string name
 * @property string login
 * @property string password
 * @method  Builder onlyPartners
 */
class User extends Authenticatable
{
	use Notifiable, ListForSelectTrait;

	const ROLE_USER        = 1;
	const ROLE_ADMIN       = 2;
	const ROLE_SUPER_ADMIN = 3;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name', 'email', 'login', 'password', 'role',
	];

	protected $guarded = [
		'password'
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

	public function isSuperAdmin()
	{
		return $this->role == self::ROLE_SUPER_ADMIN;
	}

	public function isPartner()
	{
		return $this->role == self::ROLE_ADMIN || $this->role == self::ROLE_USER;
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

	public function scopeOnlyPartners(Builder $builder)
	{
		return $builder->whereIn('role', [self::ROLE_USER, self::ROLE_ADMIN]);
	}
}
