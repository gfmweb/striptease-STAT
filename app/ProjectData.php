<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class User
 * @package App
 * @property int    channel_id
 * @property int    sub_project_id
 * @property int    coverage
 * @property int    transition
 * @property int    clicks
 * @property int    leads
 * @property int    activations
 * @property float  price
 * @property Carbon date_from
 * @property Carbon date_to
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

    protected $dates = [
        'date_from',
        'date_to'
    ];

}
