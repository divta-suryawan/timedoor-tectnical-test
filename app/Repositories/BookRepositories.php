<?php

namespace App\Repositories;

use App\Interface\BookInterfaces;
use Illuminate\Http\Request;

class BookRepositories implements BookInterfaces
{
    public function getAllData() {}
    public function getDataById($id) {}
    public function createData(Request $request) {}
    public function updateData(Request $request, $id) {}
    public function deleteData($id) {}
}
