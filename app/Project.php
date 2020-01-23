<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class User
 * @package App
 */
class Project extends Model
{

    protected $table = 'projects';

    protected $fillable = [
        'name',
        'city_id',
        'partner_id'
    ];

}
