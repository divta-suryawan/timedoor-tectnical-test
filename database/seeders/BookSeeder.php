<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        DB::disableQueryLog();
        $faker = Factory::create();
        $totalBooks = 100000;
        $batchSize = 5000;

        // get all author and category id
        $authorIds = DB::table('authors')->pluck('id')->toArray();
        $categoryIds = DB::table('categories')->pluck('id')->toArray();

        for ($i = 0; $i < $totalBooks; $i += $batchSize) {
            $books = [];
            $currentBatch = min($batchSize, $totalBooks - $i);
            // generate data
            for ($j = 0; $j < $currentBatch; $j++) {
                $books[] = [
                    'id' => Str::orderedUuid(),
                    'title' => $faker->sentence(3),
                    'author_id' => $authorIds[array_rand($authorIds)],
                    'category_id' => $categoryIds[array_rand($categoryIds)],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            // insert data
            DB::table('books')->insert($books);
            // read the proses generate data
            $this->command->info("Books: " . ($i + $currentBatch) . "/{$totalBooks}");

            unset($books);
        }

        $this->command->info("✅ Books completed!");
    }
}
