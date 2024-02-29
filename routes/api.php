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


Route::post('/signin', [App\Http\Controllers\api\AuthController::class, 'signin'])->name('signin');


// Route::group(['middleware' => 'auth:api'], function () {
//     // Routes inside this group require authentication
//     Route::get('/get-profile', [App\Http\Controllers\api\ProfileController::class, 'getProfile']);
// });
Route::group(['middleware' => ['user']], function () {


    Route::get('/get-profile', [App\Http\Controllers\api\ProfileController::class, 'getProfile']);
    Route::post('/upload-image', [App\Http\Controllers\api\ProfileController::class, 'uploadImage']);
    Route::post('/switch-active-image', [App\Http\Controllers\api\ProfileController::class, 'switchActiveImage']);
    Route::post('/update-profile', [App\Http\Controllers\api\ProfileController::class, 'updateProfile']);
    Route::post('/switch-party', [App\Http\Controllers\api\ProfileController::class, 'switchParty']);




    Route::get('/get-party', [App\Http\Controllers\api\UserController::class, 'getParty']);
    Route::get('/get-templates', [App\Http\Controllers\api\UserController::class, 'getPartyTemplate']);
    Route::get('/get-state', [App\Http\Controllers\api\UserController::class, 'getState']);
    Route::get('/get-city/{state_id}', [App\Http\Controllers\api\UserController::class, 'getCity']);

    Route::post('/download-party-poster', [App\Http\Controllers\api\UserController::class, 'downloadPartyPoster']);

});