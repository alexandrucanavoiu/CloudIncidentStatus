<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class IncidentTemplates extends Authenticatable

{

    protected $table = 'incident_templates';

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

        'id', 'user_id', 'incident_template_title', 'incident_template_body', 'created_at', 'updated_at'

    ];

    public function author()
    {
        return $this->belongsTo('App\User', 'user_id');
    }


}
