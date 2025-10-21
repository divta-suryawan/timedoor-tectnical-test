<?php

namespace App\Interface;

use Illuminate\Http\Request;

interface RatingInterfaces
{
    public function getAllData();
    public function createData(Request $request);
    // if you need to update and rating  use the Funcion below
    public function getDataById($id);
    public function updateData(Request $request, $id);
    public function deleteData($id);
}
