<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Settings extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $array_to_insert = array(
            array('id' => 1, 'time_zone_interface' => "UTC", 'title_app' => 'Cloud VPS Hosting', 'settings_logo' => 'logo.png', 'days_of_incidents' => 7, 'bulk_emails' => 20, 'bulk_emails_sleep' => 10, 'queue_name_incidents' => 'Incidents', 'queue_name_maintenance' => 'Maintenance', 'from_address' => 'demo@example.org', 'from_name' => 'Demo Name', 'allow_subscribers' => 1 )
        );

        foreach ($array_to_insert as $item){
            DB::table('settings')->insert($item);
        }
    }
}
