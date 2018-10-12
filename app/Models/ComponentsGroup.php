<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class ComponentsGroup extends Authenticatable

{

    protected $table = 'component_groups';

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

        'id', 'user_id', 'component_groups_name', 'visibility_group', 'position', 'status', 'created_at', 'updated_at'

    ];


    public function components()
    {
        return $this->HasMany('App\Models\Components', 'component_groups_id');
    }
    

}
