<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        DB::disableQueryLog();
        $faker = Factory::create();
        $totalCategories = 3000;
        $batchSize = 500;
        // generate unique words for categories
        $uniqueWords = $this->generateUniqueWords($totalCategories, $faker);

        for ($i = 0; $i < $totalCategories; $i += $batchSize) {
            $currentBatch = min($batchSize, $totalCategories - $i);
            $batchData = [];
            // generate data for each batch
            for ($j = 0; $j < $currentBatch; $j++) {
                $index = $i + $j;
                $batchData[] = [
                    'id' => Str::orderedUuid(),
                    'name' => ucfirst($uniqueWords[$index]),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            // insert data
            DB::table('categories')->insert($batchData);
            // read the proses generate data
            $this->command->info("Categories: " . ($i + $currentBatch) . "/{$totalCategories}");
        }

        $this->command->info("✅ Categories completed!");
    }

    private function generateUniqueWords($count, $faker): array
    {
        $words = [];
        $attempts = 0;
        $maxAttempts = $count * 3;

        while (count($words) < $count && $attempts < $maxAttempts) {
            $word = $faker->word();
            if (!in_array($word, $words)) {
                $words[] = $word;
            }
            $attempts++;
        }

        while (count($words) < $count) {
            $words[] = $faker->word() . '_' . count($words);
        }

        return $words;
    }
}
