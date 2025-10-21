<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Http\Requests\RatingRequest;
use App\Repositories\RatingRepositories;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    // Define property to store the injected RatingRepositories instance
    protected $ratingRepo;
    // Define constructor to inject the RatingRepositories instance
    public function __construct(RatingRepositories $ratingRepo)
    {
        $this->ratingRepo = $ratingRepo;
    }
    // Define method to handle the create data request
    public function createData(RatingRequest $request)
    {
        return $this->ratingRepo->createData($request);
    }

    // if you need to read,update, and delete please use function bellow
    public function getAllData() {}
    public function getDataById($id) {}
    public function updateData(RatingRequest $request, $id) {}
    public function deleteData($id) {}
}
