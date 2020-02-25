<?php

namespace App;

use App\Traits\ListForSelectTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * Class City
 * @package App
 * @property string name
 * @property string slug
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
