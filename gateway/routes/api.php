<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\Author\AuthorController;
use App\Http\Controllers\Api\Book\BookController;
use App\Http\Controllers\Api\UserController;
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


Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

/**
 * Forgot password routes
 */
Route::group(['middleware' => 'auth:api'], function () {
    Route::prefix('/user')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/me', [AuthController::class, 'getUserLoggedIn']);
        Route::get('/populate/all', [UserController::class, 'populate']);
        
    });

    Route::prefix('/author')->group(function () {
        Route::get('/getId/{uuid}', [AuthorController::class, 'getDataId']);
        Route::get('/populate', [AuthorController::class, 'index']);
        Route::get('/show/{uuid}', [AuthorController::class, 'show']);
        Route::post('/create', [AuthorController::class, 'create']);
        Route::post('/edit/{uuid}', [AuthorController::class, 'edit']);
        Route::delete('/delete/{uuid}', [AuthorController::class, 'delete']);
    });
    
    Route::prefix('/book')->group(function () {
        Route::get('/populate', [BookController::class, 'index']);
        Route::get('/show/{uuid}', [BookController::class, 'show']);
        Route::post('/create', [BookController::class, 'create']);
        Route::post('/edit/{uuid}', [BookController::class, 'edit']);
        Route::delete('/delete/{uuid}', [BookController::class, 'delete']);
    });
});
