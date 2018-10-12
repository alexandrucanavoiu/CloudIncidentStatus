<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class ComponentStatus extends Authenticatable

{

    protected $table = 'component_statuses';

    /**

     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [

        'id', 'component_status_name'

    ];



}
