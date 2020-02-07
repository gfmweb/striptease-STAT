<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\ListForSelectTrait;

class Status extends Model
{
	use ListForSelectTrait;

	protected $table = 'statuses';


}
