<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AuthorSeeder extends Seeder
{
    public function run(): void
    {
        DB::disableQueryLog();
        $faker = Factory::create();
        $totalAuthors = 1000;
        $batchSize = 500;
        // generate data
        for ($i = 0; $i < $totalAuthors; $i += $batchSize) {
            $currentBatch = min($batchSize, $totalAuthors - $i);
            $batchData = [];

            for ($j = 0; $j < $currentBatch; $j++) {
                $batchData[] = [
                    'id' => Str::orderedUuid(),
                    'name' => $faker->name(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            // insert data
            DB::table('authors')->insert($batchData);
            // read the proses generate data
            $this->command->info("Authors: " . ($i + $currentBatch) . "/{$totalAuthors}");
        }

        $this->command->info("✅ Authors completed!");
    }
}
