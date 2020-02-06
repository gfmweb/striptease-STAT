<?php

namespace App;

use App\Traits\ListForSelectTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * Class User
 * @package App
 * @property string name
 */
class City extends Model
{
	use ListForSelectTrait;

	protected $table = 'cities';

	protected $fillable = [
		'name'
	];

	public $timestamps = false;

}
