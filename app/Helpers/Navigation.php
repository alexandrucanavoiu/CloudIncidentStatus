<?php

namespace App\Helpers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Models\Settings;
use Illuminate\Support\Facades\Schema;

class Navigation
{
    public static function isActiveRoute($routes, $output = 'active')
    {
        if (!is_array($routes)) {
            $routes = [$routes];
        }
        foreach ($routes as $route) {
            if (Route::currentRouteName() == $route) {
                return $output;
            }
        }
        return ''; // Route is not active, return default result
    }

    public static function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public static function generateRandomStringSubscribe($length = 20) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }



    public static function time_zone_global_set() {

        if(Schema::hasTable('settings')) {
        $time_zone_interface = Settings::where('id', 1)->get()->first();
        if(!empty($time_zone_interface)){
            date_default_timezone_set($time_zone_interface->time_zone_interface);
                }
            }
    }

    public static function site_name() {
        if(Schema::hasTable('settings')) {
            $settings = Settings::where('id', 1)->get()->first();
            $site_name = $settings->title_app;
            return $site_name;
        }
    }


    public static function google_analytics_code() {
        if(Schema::hasTable('settings')) {
            $settings = Settings::where('id', 1)->get()->first();
            $google_analytics_code = $settings->google_analytics_code;
            return $google_analytics_code;
        }
    }

}
