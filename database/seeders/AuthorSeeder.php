<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AuthorSeeder extends Seeder
{
    public function run()
    {
        // create 1000 authors
        $faker = Factory::create();
        $authors = [];

        for ($i = 0; $i < 1000; $i++) {
            $authors[] = [
                'id' => Str::uuid(),
                'name' => $faker->name(),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        // insert to  table authros
        DB::table('authors')->insert($authors);
    }
}
