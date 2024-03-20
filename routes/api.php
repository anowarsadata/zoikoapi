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
use App\Http\Controllers\Api\ProductCategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\DiscountTypeController;
use App\Http\Controllers\Api\ProductAttributeController;


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
Route::get('/get/pages/all', [PageController::class, 'all_pages'])->middleware('auth:api');
Route::post('/update/page', [PageController::class, 'update'])->middleware('auth:api');

// Contact us email and entries to database
Route::post('contact-us', [ContactController::class, 'contactusPost']);
Route::post('/get/contact/entries', [ContactController::class, 'get_messages'])->middleware('auth:api');
Route::delete('/delete/contact/entry/{id}', [ContactController::class, 'destroy'])->middleware('auth:api');

Route::group(['namespace' => 'api', 'prefix' => 'v1'], function () {
    Route::post('login', [AuthenticationController::class, 'store']);
    Route::post('register', [AuthenticationController::class, 'register']);
    Route::get('users', [AuthenticationController::class, 'get_all_users'])->middleware('auth:api');
    Route::get('user/{id}', [AuthenticationController::class, 'show'])->middleware('auth:api');
    Route::post('user/update/{id}', [AuthenticationController::class, 'update_user'])->middleware('auth:api');
    Route::delete('user/delete/{id}', [AuthenticationController::class, 'delete_user'])->middleware('auth:api');
    Route::post('logout', [AuthenticationController::class, 'destroy'])->middleware('auth:api');

    Route::post('password/email', [ForgotPasswordController::class, '__invoke']);
    Route::post('password/code/check', [CodeCheckController::class, '__invoke']);
    Route::post('password/reset', [ResetPasswordController::class, '__invoke'])->middleware('auth:api');

    //Product Routes
    Route::get('products', [ProductController::class, 'index']);
    Route::get('product/get/{id}', [ProductController::class, 'show']);
    Route::post('product/create', [ProductController::class, 'store'])->middleware('auth:api');
    Route::post('product/update/{id}', [ProductController::class, 'update'])->middleware('auth:api');
    Route::delete('product/delete/{id}', [ProductController::class, 'destroy'])->middleware('auth:api');

    //Product Category routes
    Route::get('product/categories/', [ProductCategoryController::class, 'index']);
    Route::get('product/category/{id}', [ProductCategoryController::class, 'show']);
    Route::post('product/category/create', [ProductCategoryController::class, 'store'])->middleware('auth:api');
    Route::post('product/category/update/{id}', [ProductCategoryController::class, 'update'])->middleware('auth:api');
    Route::delete('product/category/delete/{id}', [ProductCategoryController::class, 'destroy'])->middleware('auth:api');

    // Product Discount type
    Route::get('discount/types', [DiscountTypeController::class, 'index']);
    Route::get('discount/type/{id}', [DiscountTypeController::class, 'show']);
    Route::post('discount/type/create', [DiscountTypeController::class, 'store'])->middleware('auth:api');
    Route::post('discount/type/update/{id}', [DiscountTypeController::class, 'update'])->middleware('auth:api');
    Route::delete('discount/type/delete/{id}', [DiscountTypeController::class, 'destroy'])->middleware('auth:api');

    // Product Attributes
    Route::get('pro/attributes', [ProductAttributeController::class, 'index']);
    Route::get('pro/attribute/{id}', [ProductAttributeController::class, 'show']);
    Route::post('pro/attribute/create', [ProductAttributeController::class, 'store'])->middleware('auth:api');
    Route::post('pro/attribute/update/{id}', [ProductAttributeController::class, 'update'])->middleware('auth:api');
    Route::delete('pro/attribute/delete/{id}', [ProductAttributeController::class, 'destroy'])->middleware('auth:api');
});



