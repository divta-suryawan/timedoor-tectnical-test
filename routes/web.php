<?php

use App\Http\Controllers\CMS\BookController;
use Illuminate\Support\Facades\Route;

Route::prefix('timedoor-test')->group(function () {
    // route api book
    Route::prefix('book')->controller(BookController::class)->group(function () {
        Route::get('/', 'getAllData');

        // if you already funtion CRUD Book use the route bellow
        Route::post('/create', 'createData');
        Route::get('/get/{id}', 'getDataById');
        Route::post('/update/{id}', 'updateData');
        Route::delete('/delete/{id}', 'deleteData');
    });
});
