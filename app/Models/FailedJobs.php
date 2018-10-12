<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class FailedJobs extends Authenticatable

{

    protected $table = 'failed_jobs';

    /**

     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $dates = [
        'failed_at'
    ];

    protected $fillable = [
        'id', 'connection', 'queue', 'payload', 'exception', 'failed_at'
    ];




}
