<?php

namespace App\Models;


class SubscribeCheck

{

    protected $table = 'subscribes';

    /**

     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $dates = [
    ];

    protected $fillable = [

        'id', 'subscribe_id', 'queue_name'

    ];


}
