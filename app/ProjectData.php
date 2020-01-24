<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class User
 * @package App
 */
class ProjectData extends Model
{

    protected $table = 'project_data';

    protected $fillable = [
        'channel_id',
        'sub_project_id',
        'coverage',
        'transition',
        'clicks',
        'leads',
        'activations',
        'price',
        'date_from',
        'date_to',
    ];

}
