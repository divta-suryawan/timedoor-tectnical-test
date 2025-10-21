<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        // cerate 100000 books
        $faker = Factory::create();

        // get author and category id
        $authorIds = DB::table('authors')->pluck('id')->toArray();
        $categoryIds = DB::table('categories')->pluck('id')->toArray();

        // create books
        $books = [];
        $batchSize = 5000;
        // loop 100000 times
        for ($i = 0; $i < 100000; $i++) {
            $books[] = [
                'id' => Str::uuid(),
                'title' => $faker->sentence(3),
                'author_id' => $faker->randomElement($authorIds),
                'category_id' => $faker->randomElement($categoryIds),
                'created_at' => now(),
                'updated_at' => now(),
            ];
            // insert 5000 books at a time
            if (count($books) >= $batchSize) {
                DB::table('books')->insert($books);
                $books = [];
            }
        }
        // insert remaining books
        if (!empty($books)) {
            DB::table('books')->insert($books);
        }
    }
}
