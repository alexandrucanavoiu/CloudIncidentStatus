<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Schedule extends Authenticatable

{

    protected $table = 'scheduled_maintenances';

    /**

     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $dates = [
        'scheduled_start',
        'scheduled_end',
        'created_at',
        'updated_at',
    ];

    protected $fillable = [

        'id', 'user_id', 'components_id', 'scheduled_title', 'scheduled_description', 'scheduled_start', 'scheduled_end', 'archived', 'created_at', 'updated_at'

    ];

    public function author()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function component()
    {
        return $this->belongsTo('App\Models\Components', 'components_id');
    }

    public function schedule_components()
    {
        return $this->hasMany('App\Models\ScheduleComponents',  'scheduled_id', 'id');
    }


}
