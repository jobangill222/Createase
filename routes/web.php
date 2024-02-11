<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {return view('welcome');});
Route::get('/home', function () {
    return redirect()->route('redirect');
});

Auth::routes(['verify' => true]);

Route::get('/', [App\Http\Controllers\SiteController::class, 'index'])->name('home');

Route::get('/redirect', [App\Http\Controllers\ProfileController::class, 'index'])->name('redirect');

Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'profile'])->name('profile');
    Route::post('/update-password', [App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('updatePassword');

    Route::group(['middleware' => ['admin']], function () {
        Route::get('/admin/dashboard', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.dashboard');
        Route::resource('user', \App\Http\Controllers\UserController::class);
        Route::get('/user/list/data-table', [\App\Http\Controllers\UserController::class, 'dataTable'])->name('user.dataTable');
        Route::get('/user/login-as/{id}', [\App\Http\Controllers\UserController::class, 'loginAs'])->name('user.loginAs');
        Route::get('/user/mark-email-verified/{id}', [\App\Http\Controllers\UserController::class, 'markEmailVerified'])->name('user.markEmailVerified');

        Route::resource('setting', \App\Http\Controllers\SettingController::class);
        Route::get('/setting/list/data-table', [\App\Http\Controllers\SettingController::class, 'dataTable'])->name('setting.dataTable');

        Route::get('/parties', [App\Http\Controllers\PartyController::class, 'index'])->name('parties');
        Route::match(['GET', 'POST'], '/parties/create', [App\Http\Controllers\PartyController::class, 'create'])->name('parties.create');

        Route::get('/state', [App\Http\Controllers\StateCityController::class, 'index'])->name('state');
        Route::match(['GET', 'POST'], '/state/create', [App\Http\Controllers\StateCityController::class, 'create'])->name('state.create');

        Route::match(['GET', 'POST'], '/add-city/{id}', [App\Http\Controllers\StateCityController::class, 'addCity']);
        Route::match(['GET', 'POST'], '/city-list/{state_id}', [App\Http\Controllers\StateCityController::class, 'cityList']);




    });
});
