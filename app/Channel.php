<?php

namespace App;

use App\Traits\ListForSelectTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * Class User
 * @package App
 * @property int     id
 * @property string  name
 * @property int     parent_id
 * @property Channel parentChannel
 */
class Channel extends Model
{
	use ListForSelectTrait;

	protected $table = 'channels';

	protected $fillable = [
		'name',
		'parent_id'
	];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function parentChannel()
	{
		return $this->belongsTo(self::class, 'parent_id', 'id');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function subChannels()
	{
		return $this->hasMany(self::class, 'parent_id', 'id');
	}

	/**
	 * @return bool
	 */
	public function hasSubChannels()
	{
		return $this->subChannels()->exists();
	}

}
