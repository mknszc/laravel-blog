<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert(array(
            'name'          => "Özcan Çamoğlu",
            'email'         => "ozcan.camoglu@gmail.com",
            'password'      => bcrypt("blogadmin"),
            'created_at'    => now(),
            'updated_at'    => now()
        ));
    }
}
