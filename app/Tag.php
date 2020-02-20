<?php

namespace App;

use App\Traits\ListForSelectTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Tag
 * @package App
 * @property string name
 */
class Tag extends Model
{
	use ListForSelectTrait;
}
