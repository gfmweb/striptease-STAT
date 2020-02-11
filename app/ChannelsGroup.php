<?php

namespace App;

use App\Traits\ListForSelectTrait;
use Illuminate\Database\Eloquent\Model;


class ChannelsGroup extends Model
{
	use ListForSelectTrait;

	protected $fillable = [
		'name',
	];


	public function channels()
	{
		return $this->hasMany(Channel::class, 'group_id');
	}

	/**
	 * @return bool
	 */
	public function hasChannels()
	{
		return $this->channels()->exists();
	}
}
