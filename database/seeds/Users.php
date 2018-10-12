<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Users extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $array_to_insert = array(
            array('id' => 1, 'level' => 10, 'name' => 'Demo Admin', 'email' => 'demo@example.org', 'password' => '$2y$10$sD2uIkgmJN31jfT4H0c1LeaOyIIhMzIdpvkDLtEnbHG10WfnCPEja', 'remember_token' => str_random(10))
        );

        foreach ($array_to_insert as $item){
            DB::table('users')->insert($item);
        }
    }
}
