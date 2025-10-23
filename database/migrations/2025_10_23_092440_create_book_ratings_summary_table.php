<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('book_ratings_summary', function (Blueprint $table) {
            $table->uuid('book_id')->primary();
            $table->unsignedInteger('total_vote')->default(0);
            $table->decimal('rating_avg_score', 5, 2)->default(0);
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('book_ratings_summary');
    }
};
