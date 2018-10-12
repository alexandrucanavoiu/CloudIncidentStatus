<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ComponentStatuses extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $array_to_insert = array(
            array('id' => 1, 'component_status_name' => 'Operational'),
            array('id' => 2, 'component_status_name' => 'Performance Issues'),
            array('id' => 3, 'component_status_name' => 'Partial Outage'),
            array('id' => 4, 'component_status_name' => 'Major Outage'),
        );

        foreach ($array_to_insert as $item){
            DB::table('component_statuses')->insert($item);
        }
    }
}
