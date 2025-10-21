<?php

namespace App\Repositories;

use App\Http\Requests\RatingRequest;
use App\Interface\RatingInterfaces;
use App\Models\RatingModel;
use App\Traits\HttpResponseTraits;

class RatingRepositories implements RatingInterfaces
{
    // Use custom trait for standardized JSON responses
    use HttpResponseTraits;

    // Define property to store the injected AuthorModel instance
    protected $ratingModel;

    // Define constructor to inject ratingModel instance
    public function __construct(RatingModel $ratingModel)
    {
        $this->ratingModel = $ratingModel;
    }
    // create rating
    public function createData(RatingRequest $request)
    {
        try {
            $data = new $this->ratingModel;
            $data->book_id = $request->input('book_id');
            $data->author_id = $request->input('author_id');
            $data->score = $request->input('score');
            $data->save();
            return $this->success($data, 'Rating created successfully');
        } catch (\Throwable $th) {
            return $this->error('Failed to created rating.', 400, $th, class_basename($this), __FUNCTION__);
        }
    }

    // if you need read,update,delete rating please use funtion bellow
    public function getAllData() {}
    public function getDataById($id) {}
    public function updateData(RatingRequest $request, $id) {}
    public function deleteData($id) {}
}
