<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Subscribe extends Authenticatable

{

    protected $table = 'subscribes';

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

        'id', 'code', 'code_security', 'email', 'status', 'created_at', 'updated_at'

    ];


}
