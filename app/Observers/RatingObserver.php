<?php

namespace App\Observers;

use App\Models\RatingModel;
use Illuminate\Support\Facades\DB;

class RatingObserver
{
    public function created(RatingModel $rating): void
    {
        // Update book_ratings_summary table
        DB::statement("
            INSERT INTO book_ratings_summary (book_id, total_vote, rating_avg_score, updated_at)
            SELECT
                r.book_id,
                COUNT(*) AS total_vote,
                AVG(score) AS rating_avg_score,
                NOW()
            FROM ratings r
            WHERE r.book_id = '{$rating->book_id}'
            GROUP BY r.book_id
            ON DUPLICATE KEY UPDATE
                total_vote = VALUES(total_vote),
                rating_avg_score = VALUES(rating_avg_score),
                updated_at = NOW()
        ");
    }
}
