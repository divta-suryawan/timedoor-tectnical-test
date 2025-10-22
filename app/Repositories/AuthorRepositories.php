<?php

namespace App\Repositories;

use App\Interface\AuthorInterfaces;
use App\Models\AuthorModel;
use App\Models\BookModel;
use App\Traits\HttpResponseTraits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthorRepositories implements AuthorInterfaces
{

    // Use custom trait for standardized JSON responses
    use HttpResponseTraits;

    // Define property to store the injected AuthorModel instance
    protected $authorModel;

    // Define property to store the injected BookModel instance
    protected $bookModel;

    // Define constructor to inject AuthorModel instance
    public function __construct(AuthorModel $authorModel, BookModel $bookModel)
    {
        $this->authorModel = $authorModel;
        $this->bookModel = $bookModel;
    }
    // get all authors
    public function getAllAuthors()
    {
        try {
            $authors = $this->authorModel::select('id', 'name')
                ->orderBy('name', 'asc')
                ->get();

            return $this->success($authors, 'List of authors retrieved successfully.');
        } catch (\Throwable $th) {
            return $this->error(
                'Failed to retrieve authors.',
                400,
                $th,
                class_basename($this),
                __FUNCTION__
            );
        }
    }

    // get book bu author
    public function getBooksByAuthor($authorId)
    {
        try {
            $books = $this->bookModel::select('id', 'title')
                ->where('author_id', $authorId)
                ->orderBy('title', 'asc')
                ->get();

            return $this->success($books, 'Books retrieved successfully.');
        } catch (\Throwable $th) {
            return $this->error(
                'Failed to retrieve books by author.',
                400,
                $th,
                class_basename($this),
                __FUNCTION__
            );
        }
    }


    // get top author
    public function getTopAuthors()
    {
        try {
            $data = DB::table('authors')
                ->select(
                    'authors.id',
                    'authors.name',
                    DB::raw('SUM(brs.total_vote) as total_vote'),
                    DB::raw('ROUND(AVG(brs.rating_avg_score), 2) as avg_rating')
                )
                ->join('books', 'books.author_id', '=', 'authors.id')
                ->join('book_ratings_summary as brs', 'brs.book_id', '=', 'books.id')
                ->where('brs.rating_avg_score', '>', 5)
                ->groupBy('authors.id', 'authors.name')
                ->orderByDesc('total_vote')
                ->orderByDesc('avg_rating')
                ->limit(10)
                ->get();

            return $this->success($data, 'Successfully retrieved top authors.');
        } catch (\Throwable $th) {
            return $this->error(
                'Failed to retrieve top authors.',
                400,
                $th,
                class_basename($this),
                __FUNCTION__
            );
        }
    }

    // if you need create CRUD in the table book pleade use function bellow
    public function getDataById($id) {}
    public function createData(Request $request) {}
    public function updateData(Request $request, $id) {}
    public function deleteData($id) {}
}
