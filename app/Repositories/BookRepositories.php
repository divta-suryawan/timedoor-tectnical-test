<?php

namespace App\Repositories;

use App\Interface\BookInterfaces;
use App\Models\BookModel;
use App\Traits\HttpResponseTraits;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
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

    public function getAllData(Request $request)
    {
        try {
            $search = $request->query('search', null);
            $perPage = (int) $request->query('per_page', 10);

            $allowed = [10, 20, 30, 40, 50, 60, 70, 80, 90, 100];
            if (!in_array($perPage, $allowed)) {
                $perPage = 10;
            }

            $query = DB::table('books')
                ->select(
                    'books.id as book_id',
                    'books.title',
                    'authors.id as author_id',
                    'authors.name as author_name',
                    'categories.name as category_name',
                    DB::raw('COALESCE(brs.total_vote, 0) as total_vote'),
                    DB::raw('COALESCE(brs.rating_avg_score, 0) as rating_avg_score')
                )
                ->join('authors', 'books.author_id', '=', 'authors.id')
                ->join('categories', 'books.category_id', '=', 'categories.id')
                ->leftJoin('book_ratings_summary as brs', 'books.id', '=', 'brs.book_id');

            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('books.title', 'like', "%{$search}%")
                        ->orWhere('authors.name', 'like', "%{$search}%");
                });
            }

            $query->orderByDesc('brs.rating_avg_score')
                ->orderByDesc('brs.total_vote');


            $data = $query->paginate($perPage);

            return $this->success($data, 'Successfully retrieved books.');
        } catch (\Throwable $th) {
            return $this->error(
                'Failed to retrieve books data.',
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
