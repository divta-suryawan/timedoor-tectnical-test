<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Repositories\BookRepositories;
use Illuminate\Http\Request;

class BookController extends Controller
{
    // Define property to store the injected BookRepositories instance
    protected $bookRepositories;
    // Define constructor to inject the BookRepositories instance
    public function __construct(BookRepositories $bookRepositories)
    {
        $this->bookRepositories = $bookRepositories;
    }
    // Define a method to get all data from the database
    public function getAllData()
    {
        return $this->bookRepositories->getAllData();
    }

    // if you need create CRUD in the table book pleade use function bellow
    public function getDataById($id) {}
    public function createData(Request $request) {}
    public function updateData(Request $request, $id) {}
    public function deleteData($id) {}
}
