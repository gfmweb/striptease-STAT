<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class User
 * @package App
 * @property int    user_target_id
 * @property int    coverage
 * @property int    transition
 * @property int    clicks
 * @property int    leads
 * @property int    activations
 * @property float  price
 * @property Carbon date_from
 * @property Carbon date_to
 */
class UserTargetData extends Model
{
	public static $values = [
		'coverage',
		'transition',
		'clicks',
		'leads',
		'activations',
		'price',
	];

	protected $table = 'user_target_data';

	protected $attributes = [
		'coverage'    => 0,
		'transition'  => 0,
		'clicks'      => 0,
		'leads'       => 0,
		'activations' => 0,
		'price'       => 0.00,
	];
	protected $fillable   = [
		'user_target_id',
		'coverage',
		'transition',
		'clicks',
		'leads',
		'activations',
		'price',
		'date_from',
		'date_to',
	];

	protected $dates = [
		'date_from',
		'date_to'
	];

	public function onlyValues()
	{
		return $this->only(self::$values);
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function userTarget()
	{
		return $this->belongsTo(UserTarget::class);
	}

}
