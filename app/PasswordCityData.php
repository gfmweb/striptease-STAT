<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PasswordCityData
 * @package App
 * @property int    password_city_id
 * @property int    activations
 * @property Carbon date_from
 * @property Carbon date_to
 */
class PasswordCityData extends Model
{

	protected $table = 'password_city_data';

	protected $attributes = [
		'activations' => 0,
	];
	protected $fillable   = [
		'password_city_id',
		'activations',
		'date_from',
		'date_to',
	];

	protected $dates = [
		'date_from',
		'date_to'
	];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function passwordCity()
	{
		return $this->belongsTo(PasswordCity::class, 'password_city_id');
	}

}
