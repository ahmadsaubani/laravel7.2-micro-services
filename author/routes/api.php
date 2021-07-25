<?php

use App\Http\Controllers\Api\Author\AuthorController;
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

Route::prefix('/author')->group(function () {
    Route::get('/getId/{uuid}', [AuthorController::class, 'getDataId']);
    Route::get('/populate', [AuthorController::class, 'index']);
    Route::get('/show/{uuid}', [AuthorController::class, 'show']);
    Route::post('/create', [AuthorController::class, 'create']);
    Route::post('/edit/{uuid}', [AuthorController::class, 'edit']);
    Route::delete('/delete/{uuid}', [AuthorController::class, 'delete']);
});