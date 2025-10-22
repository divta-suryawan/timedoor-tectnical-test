<?php

namespace App\Interface;

use Illuminate\Http\Request;

interface AuthorInterfaces
{
    public function getAllAuthors();
    public function getTopAuthors();
    public function getBooksByAuthor($authorId);
    // if you need to create CRUD in the author use the Funcion below
    public function getDataById($id);
    public function createData(Request $request);
    public function updateData(Request $request, $id);
    public function deleteData($id);
}
