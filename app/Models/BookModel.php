<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookModel extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'books';
    protected $fillable = [
        'id',
        'title',
        'author_id',
        'category_id',
        'created_at',
        'updated_at',
    ];

    public function author()
    {
        return $this->belongsTo(AuthorModel::class, 'author_id');
    }

    public function category()
    {
        return $this->belongsTo(CategoryModel::class, 'category_id');
    }

    public function rating()
    {
        return $this->hasMany(RatingModel::class, 'book_id');
    }
}
