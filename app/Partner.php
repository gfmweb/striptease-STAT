<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class User
 * @package App
 */
class Partner extends Model
{

    protected $table = 'partners';

    protected $fillable = [
        'name',
    ];

}
