<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->timestamps();

            $table->foreignUuid('author_id')->references('id')->on('authors')->onDelete('cascade');
            $table->foreignUuid('category_id')->references('id')->on('categories')->onDelete('cascade');

            $table->index('author_id');
            $table->index('category_id');
            $table->index(['author_id', 'category_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
