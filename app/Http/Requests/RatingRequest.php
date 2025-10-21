<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class RatingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'book_id'   => 'required|exists:books,id',
            'author_id' => 'required|exists:authors,id',
            'score'     => 'required|integer|between:1,10',
        ];
    }

    public function messages(): array
    {
        return [
            'book_id.required'   => 'Book Name is required.',
            'book_id.exists'     => 'Book Name not found in the database.',
            'author_id.required' => 'Author Name is required.',
            'author_id.exists'   => 'Author Name not found in the database.',
            'score.required'     => 'Score is required.',
            'score.integer'      => 'Score must be an integer.',
            'score.between'      => 'Score must be between 1 and 10.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'code'    => 422,
            'message' => 'Please check your input.',
            'data'    => $validator->errors()
        ], 422));
    }
}
