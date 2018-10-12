<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Footer extends Authenticatable

{

    protected $table = 'footers';

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
        'id', 'user_id', 'footer_title', 'footer_url', 'position', 'target_url', 'created_at', 'updated_at'
    ];




}
