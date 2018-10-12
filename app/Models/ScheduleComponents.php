<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class ScheduleComponents extends Authenticatable

{

    protected $table = 'scheduled_maintenances_components';

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

        'id', 'scheduled_id', 'components_id', 'created_at', 'updated_at'

    ];


    public function schedule()
    {
        return $this->HasOne('App\Models\Schedule', 'scheduled_id');
    }

    public function create($data)
    {
        $this->insert($data);
    }

    public function subscribes()
    {
        return $this->HasOne('App\Models\Subscribe', 'id', 'subscribes_id');
    }

    public function component_name()
    {
        return $this->HasOne('App\Models\Components', 'id', 'components_id');
    }


}
