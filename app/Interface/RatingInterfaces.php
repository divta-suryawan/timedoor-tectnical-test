<?php

namespace App\Interface;

use App\Http\Requests\RatingRequest;
use Illuminate\Http\Request;

interface RatingInterfaces
{
    public function createData(RatingRequest $request);
    // if you need to read,upadate,and delete rating  use the Function below
    public function getAllData();
    public function getDataById($id);
    public function updateData(RatingRequest $request, $id);
    public function deleteData($id);
}
