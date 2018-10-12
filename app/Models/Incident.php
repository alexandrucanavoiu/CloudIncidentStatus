<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Incident extends Authenticatable

{

    protected $table = 'incidents';

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

        'id', 'user_id', 'incident_title', 'incident_statuses_id', 'component_statuses_id', 'incidents_status', 'created_at', 'updated_at'

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


    public function update_incident()
    {
        return $this->hasMany('App\Models\IncidentUpdate', 'incidents_id','id');
    }

    public function update_incident_sort_by_id()
    {
        return $this->hasMany('App\Models\IncidentUpdate', 'incidents_id','id')->OrderBy('id', 'DESC');
    }

    public function incident_components()
    {
        return $this->hasMany('App\Models\IncidentComponents',  'incidents_id', 'id');
    }

    public function component_name()
    {
        return $this->HasOne('App\Models\Components', 'id', 'components_id');
    }

    public function create($data)
    {
        return $this->insertGetId($data);
    }



}
