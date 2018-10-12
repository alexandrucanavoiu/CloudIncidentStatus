<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class IncidentComponents extends Authenticatable

{

    protected $table = 'incident_components';

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

        'id', 'incidents_id', 'components_id', 'component_statuses_id', 'created_at', 'updated_at'

    ];


    public function component_name()
    {
        return $this->HasOne('App\Models\Components', 'id', 'components_id');
    }

    public function create($data)
    {
        $this->insert($data);
    }


}
