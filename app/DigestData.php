<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class DigestData extends Model
{

	protected $table = 'digest_data';

	/*protected $attributes = [
		'activations' => 0,
	];*/

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

}
