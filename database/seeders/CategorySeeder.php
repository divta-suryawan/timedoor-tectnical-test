<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run()
    {
        // create 3000 categories
        $faker = Factory::create();
        $categories = [];

        for ($i = 0; $i < 3000; $i++) {
            $categories[] = [
                'id' => Str::uuid(),
                'name' => ucfirst($faker->word()),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        // insert to table categories
        DB::table('categories')->insert($categories);
    }
}
