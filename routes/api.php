<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Models\Page;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
//Route::get('/get', [PageController::class, 'index']); //route for all records/pages
Route::get('/get/{id}', [PageController::class, 'index']);  // route for single page
Route::post('/page', [PageController::class, 'store']);

Route::delete('/delete/{id}', [PageController::class, 'destroy']);
