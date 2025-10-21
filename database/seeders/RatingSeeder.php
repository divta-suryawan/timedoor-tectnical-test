<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RatingSeeder extends Seeder
{
    public function run(): void
    {
        // Generate random ratings for 500000 books
        $faker = Factory::create();
        // Get all book IDs
        $bookIds = DB::table('books')->pluck('id')->toArray();

        // Create 500000 ratings
        $ratings = [];
        $batchSize = 5000;
        // Loop through the books and generate ratings
        for ($i = 0; $i < 500000; $i++) {
            $ratings[] = [
                'id' => Str::uuid(),
                'book_id' => $faker->randomElement($bookIds),
                'score' => rand(1, 10),
                'created_at' => now(),
                'updated_at' => now(),
            ];
            // Insert the ratings in batches
            if (count($ratings) >= $batchSize) {
                DB::table('ratings')->insert($ratings);
                $ratings = [];
            }
        }
        // Insert any remaining ratings
        if (!empty($ratings)) {
            DB::table('ratings')->insert($ratings);
        }
    }
}
