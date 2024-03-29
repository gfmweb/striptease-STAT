<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Class UserTarget
 * @package App
 * @property int                         id
 * @property Channel                     channel
 * @property Status                      status
 * @property int                         channel_id
 * @property Collection | UserTargetData data
 */
class UserTarget extends Model
{

	protected $fillable = [
		'user_sub_project_id',
		'channel_id',
		'status_id',
	];

	protected $dates = ['started_at', 'moderated_at'];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function userSubProject()
	{
		return $this->belongsTo('App\UserSubProject');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function channel()
	{
		return $this->belongsTo('App\Channel');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function status()
	{
		return $this->belongsTo('App\Status');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function data()
	{
		return $this->hasMany(UserTargetData::class);
	}

	public function lastHistory()
	{
		return $this->hasOne('App\StatusHistory')->latest();
	}
}
