<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            CREATE OR REPLACE VIEW book_ratings_summary AS
            SELECT
                b.id AS book_id,
                COUNT(r.id) AS total_vote,
                AVG(r.score) AS rating_avg_score
            FROM books b
            LEFT JOIN ratings r ON r.book_id = b.id
            GROUP BY b.id
        ");
    }

    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS book_ratings_summary');
    }
};
