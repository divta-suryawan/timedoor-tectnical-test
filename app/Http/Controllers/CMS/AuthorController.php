<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Repositories\AuthorRepositories;
use Illuminate\Http\Request;

class AuthorController extends Controller
{

    // Define property to store the injected BookRepositories instance
    protected $authorRepo;
    // Define constructor to inject the BookRepositories instance
    public function __construct(AuthorRepositories $authorRepo)
    {
        $this->authorRepo = $authorRepo;
    }
    public function getAllAuthors()
    {
        return $this->authorRepo->getAllAuthors();
    }
    public function getTopAuthors()
    {
        return $this->authorRepo->getTopAuthors();
    }
    public function getBooksByAuthor($authorId)
    {
        return $this->authorRepo->getBooksByAuthor($authorId);
    }
    // if you need create CRUD in the table Author pleade use function bellow
    public function getDataById($id) {}
    public function createData(Request $request) {}
    public function updateData(Request $request, $id) {}
    public function deleteData($id) {}
}
