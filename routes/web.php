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


//LOGIN
Route::get('/login', 'App\Http\Controllers\AuthController@login')->name('login');
Route::get('/', 'App\Http\Controllers\AuthController@login')->name('login');
Route::post('/loginProses', 'App\Http\Controllers\AuthController@loginProses');

//BACKEND
Route::group(['middleware' => 'auth'], function () {

    //DASHBOARD
    Route::get('/dashboard', 'App\Http\Controllers\DashboardController@index');

    //USER
    Route::get('/user', 'App\Http\Controllers\UserController@index')->middleware('checkRole:Admin');
    Route::get('/data-user', 'App\Http\Controllers\UserController@data')->middleware('checkRole:Admin');
    Route::post('/store-user', 'App\Http\Controllers\UserController@store')->middleware('checkRole:Admin');
    Route::post('/update-user', 'App\Http\Controllers\UserController@update')->middleware('checkRole:Admin');
    Route::post('/delete-user', 'App\Http\Controllers\UserController@delete')->middleware('checkRole:Admin');

});

//LOGOUT
Route::get('/logout', function () {
    Auth::logout();
    return redirect('login');
})->name('logout');