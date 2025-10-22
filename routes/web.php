<?php

use App\Http\Controllers\CMS\AuthorController;
use App\Http\Controllers\CMS\BookController;
use App\Http\Controllers\CMS\RatingController;
use Illuminate\Support\Facades\Route;

// web route
Route::get('/', function () {
    return view('pages.book');
});

Route::get('/author', function () {
    return view('pages.author');
});

Route::get('/rating', function () {
    return view('pages.rating');
});

// api route
Route::prefix('timedoor-test')->group(function () {
    // route api book
    Route::prefix('books')->controller(BookController::class)->group(function () {
        Route::get('/', 'getAllData');

        // if you already funtion CRUD Book use the route bellow
        Route::post('/create', 'createData');
        Route::get('/get/{id}', 'getDataById');
        Route::post('/update/{id}', 'updateData');
        Route::delete('/delete/{id}', 'deleteData');
    });
    Route::prefix('authors')->controller(AuthorController::class)->group(function () {
        Route::get('/', 'getAllAuthors');
        Route::get('/top', 'getTopAuthors');
        Route::get('/{id}/books', 'getBooksByAuthor');

        // if you already funtion CRUD author use the route bellow
        Route::post('/create', 'createData');
        Route::get('/get/{id}', 'getDataById');
        Route::post('/update/{id}', 'updateData');
        Route::delete('/delete/{id}', 'deleteData');
    });

    Route::prefix('ratings')->controller(RatingController::class)->group(function () {
        Route::post('/create', 'createData');

        // if you already funtion  read,update,and delete use the route bellow
        Route::get('/', 'getAllData');
        Route::get('/get/{id}', 'getDataById');
        Route::post('/update/{id}', 'updateData');
        Route::delete('/delete/{id}', 'deleteData');
    });
});
