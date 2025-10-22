<?php

namespace App\Interface;

use Illuminate\Http\Request;

interface BookInterfaces
{
    public function getAllData(Request $request);
    // if you need to create CRUD in the book use the Funcion below
    public function getDataById($id);
    public function createData(Request $request);
    public function updateData(Request $request, $id);
    public function deleteData($id);
}
