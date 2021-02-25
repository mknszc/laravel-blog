<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for($i = 0; $i < 5; $i++) {
            $title = $faker->sentence($nbWords = 6, $variableNbWords = true);

            DB::table('articles')->insert([
                'category_id'   => rand(1, 2),
                'title'         => $title,
                'image'         => $faker->imageUrl($width = 640, $height = 480, 'cats', true),
                'content'       => $faker->paragraph(6),
                'slug'          => Str::slug($title),
                'created_at'    => now(),
                'updated_at'    => now()
            ]);
        }
    }
}
