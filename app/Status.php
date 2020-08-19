<?php

namespace App;

use App\Traits\ListForSelectTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Status
 * @package App
 * @property int    id
 * @property string name
 * @property string class
 */
class Status extends Model
{
	use ListForSelectTrait;

	protected $table = 'statuses';

	protected $fillable = [
		'id',
		'name',
		'class'
	];

}
