<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $pages = array('Hakkımda');

        foreach($pages as $key => $page) {
            DB::table('pages')->insert(array(
                'title'         => $page,
                'image'         => $faker->imageUrl($width = 640, $height = 480),
                'content'       => $faker->paragraph(6),
                'slug'          => Str::slug($page),
                'order'         => 1,
                'created_at'    => now(),
                'updated_at'    => now()
            ));
        }
    }
}
