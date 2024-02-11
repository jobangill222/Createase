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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post('/signin', [App\Http\Controllers\Api\AuthController::class, 'signin'])->name('signin');


Route::middleware(['auth:sanctum'])->group(function () {
    // Routes inside this group require authentication
    Route::get('/get-profile', [App\Http\Controllers\Api\ProfileController::class, 'getProfile']);
});