<?php

namespace App;

use App\Traits\ListForSelectTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class DigestGroup extends Model
{
	use ListForSelectTrait;

	public function digests()
	{
		return $this->hasMany('App\Digest');
	}

}
