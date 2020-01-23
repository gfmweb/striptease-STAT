<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class User
 * @package App
 */
class Channel extends Model
{

    protected $table = 'channels';

    protected $fillable = [
        'name',
        'parent_id'
    ];

}
