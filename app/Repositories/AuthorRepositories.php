<?php

namespace App\Repositories;

use App\Interface\AuthorInterfaces;
use App\Models\AuthorModel;
use App\Traits\HttpResponseTraits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthorRepositories implements AuthorInterfaces
{

    // Use custom trait for standardized JSON responses
    use HttpResponseTraits;

    // Define property to store the injected AuthorModel instance
    protected $authorModel;

    // Define constructor to inject AuthorModel instance
    public function __construct(AuthorModel $authorModel)
    {
        $this->authorModel = $authorModel;
    }
    // get top author
    public function getTopAuthors()
    {
        try {
            $data = $this->authorModel
                ->select('authors.id', 'authors.name', DB::raw('COUNT(ratings.id) as total_voter'))
                ->join('books', 'books.author_id', '=', 'authors.id')
                ->join('ratings', 'ratings.book_id', '=', 'books.id')
                ->where('ratings.score', '>', 5)
                ->groupBy('authors.id', 'authors.name')
                ->orderByDesc('total_voter')
                ->limit(10)
                ->get();

            return $this->success($data, 'Successfully retrieved top authors.');
        } catch (\Throwable $th) {
            return $this->error('Failed to retrieve top authors.', 400, $th, class_basename($this), __FUNCTION__);
        }
    }



    // if you need create CRUD in the table book pleade use function bellow
    public function getDataById($id) {}
    public function createData(Request $request) {}
    public function updateData(Request $request, $id) {}
    public function deleteData($id) {}
}
