<?php

namespace App;

use App\Traits\ListForSelectTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class User
 * @package App
 * @property int          id
 * @property string       name
 * @property int          group_id
 * @property ChannelGroup group
 */
class Channel extends Model
{
	use ListForSelectTrait, SoftDeletes;

	protected $table = 'channels';

	protected $fillable = [
		'name',
		'group_id'
	];

	public function group()
	{
		return $this->belongsTo('App\ChannelsGroup', 'group_id');
	}
}
