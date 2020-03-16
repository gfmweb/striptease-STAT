<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class DigestData extends Model
{

	protected $table = 'digest_data';

	// для того, чтобы при создании пустой модели в ней были нули
	protected $attributes = [
		'coverage'    => 0,
		'leads'       => 0,
		'activations' => 0,
		'budget'      => 0,
	];

	public static $values = [
		'coverage',
		'leads',
		'activations',
		'budget',
	];

	protected $fillable   = [
		'digest_id',
		'city_id',
		'coverage',
		'leads',
		'activations',
		'budget',
		'date_from',
		'date_to',
	];

	protected $dates = [
		'date_from',
		'date_to'
	];

	public function digest()
	{
		return $this->belongsTo(Digest::class);
	}

	public function onlyValues()
	{
		return $this->only(self::$values);
	}

}
