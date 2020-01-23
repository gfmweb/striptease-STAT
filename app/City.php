<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class User
 * @package App
 */
class City extends Model
{

    protected $table = 'cities';

    protected $fillable = [
        'name'
    ];

    public $timestamps = false;

}
