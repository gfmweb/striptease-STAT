<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;


/**
 * Class UserSubProject
 * @package App
 * @property SubProject subProject
 * @property User       user
 * @property Collection userTargets
 * @property int        id
 * @property int        user_id
 * @property int        sub_project_id
 */
class UserSubProject extends Model
{
	public function user()
	{
		return $this->belongsTo('App\User');
	}

	public function subProject()
	{
		return $this->belongsTo('App\SubProject');
	}

	public function userTargets()
	{
		return $this->hasMany(UserTarget::class, 'user_sub_project_id');
	}
}
