<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class IncidentStatus extends Authenticatable

{

    protected $table = 'incident_status';

    /**

     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [

        'id', 'incident_name'

    ];

}
