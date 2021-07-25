<?php

use App\Http\Controllers\Api\Book\BookController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('/book')->group(function () {
    Route::get('/populate', [BookController::class, 'index']);
    Route::get('/show/{uuid}', [BookController::class, 'show']);
    Route::post('/create', [BookController::class, 'create']);
    Route::post('/edit/{uuid}', [BookController::class, 'edit']);
    Route::delete('/delete/{uuid}', [BookController::class, 'delete']);
});
