<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class SubscribesSent extends Authenticatable

{

    protected $table = 'subscribes_sent';

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

        'id', 'subscribes_id', 'email', 'incident_id', 'created_at', 'updated_at'

    ];


}
