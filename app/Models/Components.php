<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Components extends Authenticatable

{

    protected $table = 'components';

    /**

     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [

        'id', 'user_id', 'component_groups_id', 'component_statuses_id', 'component_name', 'component_description', 'position', 'status', 'created_at', 'updated_at'

    ];


    public function component_group()
    {
        return $this->belongsTo('App\Models\ComponentsGroup', 'component_groups_id');
    }

    public function component_status()
    {
        return $this->belongsTo('App\Models\ComponentStatus', 'component_statuses_id');
    }

}
