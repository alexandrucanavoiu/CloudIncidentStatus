<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Footer extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $array_to_insert = array(
            array('id' => 1, 'user_id' => 1, 'footer_title' => 'Demo 1', 'footer_url' => 'http:/www.google.com', 'position' => 1, 'target_url' => 1),
            array('id' => 2, 'user_id' => 1, 'footer_title' => 'Demo 2', 'footer_url' => 'http:/www.google.com', 'position' => 1, 'target_url' => 1),
        );

        foreach ($array_to_insert as $item){
            DB::table('footers')->insert($item);
        }
    }
}
