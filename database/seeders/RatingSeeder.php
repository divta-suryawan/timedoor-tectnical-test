<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RatingSeeder extends Seeder
{
    public function run(): void
    {
        DB::disableQueryLog();
        $totalRatings = 500000;
        $batchSize = 5000;
        $bookIds = [];
        $authorMap = [];
        // get all books and authors
        $books = DB::table('books')->select('id')->cursor();
        // loop through books and get the author id
        foreach ($books as $book) {
            $bookIds[] = $book->id;
        }
        // generate ratings
        $ratings = [];
        for ($i = 1; $i <= $totalRatings; $i++) {
            $randomBookId = $bookIds[array_rand($bookIds)];
            //
            $ratings[] = [
                'id' => Str::orderedUuid(),
                'book_id' => $randomBookId,
                'score' => rand(1, 10),
                'created_at' => now(),
                'updated_at' => now(),
            ];

            if (count($ratings) >= $batchSize) {
                // insert the ratings
                DB::table('ratings')->insert($ratings);
                $ratings = [];
                // read the proses generate data
                $this->command->info("Ratings: {$i}/{$totalRatings}");
            }
        }
        // insert the remaining ratings
        if (!empty($ratings)) {
            DB::table('ratings')->insert($ratings);
        }
        $this->command->info("✅ Ratings completed!");

        // update book_ratings_summary otomatis
        DB::statement("
            INSERT INTO book_ratings_summary (book_id, total_vote, rating_avg_score, updated_at)
            SELECT
                book_id,
                COUNT(*) AS total_vote,
                ROUND(AVG(score),2) AS rating_avg_score,
                NOW()
            FROM ratings
            GROUP BY book_id
            ON DUPLICATE KEY UPDATE
                total_vote=VALUES(total_vote),
                rating_avg_score=VALUES(rating_avg_score),
                updated_at=NOW()
        ");

        $this->command->info("✅ Book ratings summary updated!");
    }
}
