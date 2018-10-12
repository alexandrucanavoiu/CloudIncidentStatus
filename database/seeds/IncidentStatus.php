<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IncidentStatus extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $array_to_insert = array(
            array('id' => 1, 'incident_name' => 'Investigating'),
            array('id' => 2, 'incident_name' => 'Identified'),
            array('id' => 3, 'incident_name' => 'Monitoring'),
            array('id' => 4, 'incident_name' => 'Resolved'),
            array('id' => 5, 'incident_name' => 'Update'),
        );

        foreach ($array_to_insert as $item){
            DB::table('incident_status')->insert($item);
        }
    }
}
