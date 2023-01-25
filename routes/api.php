<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\DislikeController;
use App\Http\Controllers\VotesController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(AuthController::class)->group(
    function () {
        Route::post('/register', 'register');
        Route::post('/login', 'login');
        Route::get('/me', 'getActiveUser');
        Route::post('/logout', 'logout');
    }
);

Route::controller(MovieController::class)->group(
    function () {
        Route::get('/movies', 'index');
        Route::post('/movies', 'store');
        Route::get('/movies/{id}', 'show');
    }
);

Route::get('/genres', [GenreController::class, 'index']);

Route::controller(VotesController::class)->group(
    function () {
        Route::put('/movies/{id}/like', 'createLike');
        Route::put('/movies/{id}/dislike', 'createDislike');
    }
);

Route::controller(CommentsController::class)->group(
    function () {
        Route::get('movies/{id}/comments', 'index');
        Route::post('movies/{id}/comments', 'store');
    }
);
