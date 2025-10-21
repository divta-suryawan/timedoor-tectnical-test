<?php

namespace App\Repositories;

use App\Interface\BookInterfaces;
use App\Models\BookModel;
use App\Traits\HttpResponseTraits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookRepositories implements BookInterfaces
{

    // Use custom trait for standardized JSON responses
    use HttpResponseTraits;

    // Define property to store the injected BookModel instance
    protected $bookModel;

    // Define constructor to inject BookModel instance
    public function __construct(BookModel $bookModel)
    {
        $this->bookModel = $bookModel;
    }

    // get all data from the table book

    public function getAllData()
    {
        try {
            $data = DB::table('books')
                ->select(
                    'books.id',
                    'books.title',
                    'authors.name as author_name',
                    'categories.name as category_name',
                    DB::raw('COUNT(ratings.id) as total_vote'),
                    DB::raw('IFNULL(AVG(ratings.score), 0) as rating_avg_score')
                )
                ->join('authors', 'books.author_id', '=', 'authors.id')
                ->join('categories', 'books.category_id', '=', 'categories.id')
                ->leftJoin('ratings', 'books.id', '=', 'ratings.book_id')
                ->groupBy('books.id', 'books.title', 'authors.name', 'categories.name')
                ->orderByDesc('rating_avg_score')
                ->limit(100)
                ->get();

            return $this->success($data, 'Successfully retrieved all books.');
        } catch (\Throwable $th) {
            return $this->error('Failed to retrieve books data.', 400, $th, class_basename($this), __FUNCTION__);
        }
    }


    // if you need create CRUD in the table book pleade use function bellow
    public function getDataById($id) {}
    public function createData(Request $request) {}
    public function updateData(Request $request, $id) {}
    public function deleteData($id) {}
}
