<?php

use Illuminate\Http\Request;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('login', [App\Http\Controllers\AuthController::class, 'login']);
Route::post('register', [App\Http\Controllers\AuthController::class, 'register']);

Route::get('test', [App\Http\Controllers\BlogController::class, 'index']);
Route::post('create_blog', [App\Http\Controllers\BlogController::class, 'createBlog']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('show_all_post', [App\Http\Controllers\BlogController::class, 'index']);
    Route::post('create_blog', [App\Http\Controllers\BlogController::class, 'createBlog']);
});

Route::get('test-auth', function () {
    return 'test';
});