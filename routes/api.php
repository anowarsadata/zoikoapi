<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\AuthenticationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Api\ForgotPasswordController;
use App\Http\Controllers\Api\CodeCheckController;
use App\Http\Controllers\Api\ResetPasswordController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;




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
Route::get('/get/page/{id}', [PageController::class, 'index']);  // route for single page
Route::post('/create/page', [PageController::class, 'store'])->middleware('auth:api');
Route::delete('/delete/page/{id}', [PageController::class, 'destroy'])->middleware('auth:api');
Route::post('/get/page/all', [PageController::class, 'all_pages'])->middleware('auth:api');
Route::post('/update/page', [PageController::class, 'update'])->middleware('auth:api');

// Contact us email and entries to database
Route::post('contact-us', [ContactController::class, 'contactusPost']);
Route::post('/get/contact/entries', [ContactController::class, 'get_messages'])->middleware('auth:api');
Route::delete('/delete/contact/entry/{id}', [ContactController::class, 'destroy'])->middleware('auth:api');

Route::group(['namespace' => 'api', 'prefix' => 'v1'], function () {
    Route::post('login', [AuthenticationController::class, 'store']);
    Route::post('register', [AuthenticationController::class, 'register']);
    Route::get('users', [AuthenticationController::class, 'get_all_users'])->middleware('auth:api');
    Route::post('user/update/{id}', [AuthenticationController::class, 'update_user'])->middleware('auth:api');
    Route::delete('user/delete/{id}', [AuthenticationController::class, 'delete_user'])->middleware('auth:api');
    Route::post('logout', [AuthenticationController::class, 'destroy'])->middleware('auth:api');

    Route::post('password/email',  [ForgotPasswordController::class, '__invoke']);
    Route::post('password/code/check', [CodeCheckController::class, '__invoke']);
    Route::post('password/reset', [ResetPasswordController::class, '__invoke'])->middleware('auth:api');

    //Category routes
    //Route::get('product-categories',  [CategoryController::class, 'index']);

    //Product Routes
    Route::get('products',  [ProductController::class, 'index']);
    Route::post('product/create',  [ProductController::class, 'store'])->middleware('auth:api');
    Route::post('product/update/{id}',  [ProductController::class, 'update'])->middleware('auth:api');
    Route::delete('product/delete/{id}',  [ProductController::class, 'destroy'])->middleware('auth:api');
});



