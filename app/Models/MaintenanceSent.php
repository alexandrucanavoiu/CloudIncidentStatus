<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class MaintenanceSent extends Authenticatable

{

    protected $table = 'scheduled_maintenance_sent';

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

        'id', 'subscribes_id', 'scheduled_id', 'email', 'created_at', 'updated_at'

    ];


}
