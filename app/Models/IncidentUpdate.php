<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class IncidentUpdate extends Authenticatable

{

    protected $table = 'incidents_updates';

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

        'id', 'user_id', 'incidents_id', 'incident_statuses_id', 'component_statuses_id', 'incidents_description', 'created_at', 'updated_at'

    ];

    public function author()
    {
        return $this->belongsTo('App\User', 'user_id');
    }


    public function incident_status()
    {
        return $this->belongsTo('App\Models\IncidentStatus', 'incident_statuses_id');
    }


    public function component_status()
    {
        return $this->belongsTo('App\Models\ComponentStatus', 'component_statuses_id');
    }

    public function incident()
    {
        return $this->BelongsTo('App\Models\Incident', 'incidents_id','id');
    }

}
