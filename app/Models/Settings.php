<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Settings extends Authenticatable

{

    protected $table = 'settings';

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

        'id', 'time_zone_interface', 'title_app', 'settings_logo', 'days_of_incidents', 'bulk_emails', 'bulk_emails_sleep', 'queue_name_incidents', 'queue_name_maintenance', 'from_address', 'from_name', 'google_analytics_code', 'allow_subscribers', 'created_at', 'updated_at'

    ];




}
