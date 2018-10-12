<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class SubscribeComponents extends Authenticatable

{

    protected $table = 'subscribes_components';

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

        'id', 'subscribes_id', 'components_id','created_at', 'updated_at'

    ];

    public function create($data)
    {
        $this->insert($data);
    }

    public function subscribes()
    {
        return $this->HasOne('App\Models\Subscribe', 'id', 'subscribes_id');
    }


}
