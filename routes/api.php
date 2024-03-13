<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Api\AuthenticationController;
use App\Http\Controllers\UserController;




/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('user/update/{id}', [UserController::class, 'update'])->middleware('auth:api');

//Route::get('/get', [PageController::class, 'index']); //route for all records/pages
Route::get('/get/{id}', [PageController::class, 'index']);  // route for single page
Route::post('/page', [PageController::class, 'store']);
Route::delete('/delete/{id}', [PageController::class, 'destroy']);

Route::group(['namespace' => 'api', 'prefix' => 'v1'], function () {
    Route::post('login', [AuthenticationController::class, 'store']);
    Route::post('register', [AuthenticationController::class, 'register']);
    Route::get('users', [AuthenticationController::class, 'get_all_users'])->middleware('auth:api');
    Route::post('user/update/{id}', [AuthenticationController::class, 'update_user'])->middleware('auth:api');
    Route::post('user/delete/{id}', [AuthenticationController::class, 'delete_user'])->middleware('auth:api');
    Route::post('logout', [AuthenticationController::class, 'destroy'])->middleware('auth:api');
});


