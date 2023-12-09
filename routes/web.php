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
Route::post('/loginProses', 'App\Http\Controllers\AuthController@loginProses');

Route::get('/', function(){
    return view('frontend.landing');
});

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

    //MATRIK
    Route::get('/matrik', 'App\Http\Controllers\MatrikController@index')->middleware('checkRole:Admin');
    Route::get('/data-matrik', 'App\Http\Controllers\MatrikController@data')->middleware('checkRole:Admin');
    Route::post('/store-matrik', 'App\Http\Controllers\MatrikController@store')->middleware('checkRole:Admin');
    
    //PERIODE
    Route::get('/jadwal', 'App\Http\Controllers\JadwalController@index')->middleware('checkRole:Admin');
    Route::get('/data-jadwal', 'App\Http\Controllers\JadwalController@data')->middleware('checkRole:Admin');
    Route::post('/store-jadwal', 'App\Http\Controllers\JadwalController@store')->middleware('checkRole:Admin');
    Route::post('/update-jadwal', 'App\Http\Controllers\JadwalController@update')->middleware('checkRole:Admin');
    Route::post('/delete-jadwal', 'App\Http\Controllers\JadwalController@delete')->middleware('checkRole:Admin');

    //UNIT
    Route::get('/unit', 'App\Http\Controllers\UnitController@index')->middleware('checkRole:Admin');
    Route::get('/data-unit', 'App\Http\Controllers\UnitController@data')->middleware('checkRole:Admin');
    Route::post('/store-unit', 'App\Http\Controllers\UnitController@store')->middleware('checkRole:Admin');
    Route::post('/update-unit', 'App\Http\Controllers\UnitController@update')->middleware('checkRole:Admin');
    Route::post('/delete-unit', 'App\Http\Controllers\UnitController@delete')->middleware('checkRole:Admin');

    //RISIKO
    Route::get('/risiko', 'App\Http\Controllers\RisikoController@index')->middleware('checkRole:Admin');
    Route::get('/data-risiko', 'App\Http\Controllers\RisikoController@data')->middleware('checkRole:Admin');
    Route::post('/store-risiko', 'App\Http\Controllers\RisikoController@store')->middleware('checkRole:Admin');
    Route::post('/update-risiko', 'App\Http\Controllers\RisikoController@update')->middleware('checkRole:Admin');
    Route::post('/delete-risiko', 'App\Http\Controllers\RisikoController@delete')->middleware('checkRole:Admin');

    //PROFIL RISIKO
    Route::get('/profil-risk', 'App\Http\Controllers\ProfilRisikoController@index')->middleware('checkRole:Admin');
    Route::get('/data-profil-risk', 'App\Http\Controllers\ProfilRisikoController@data')->middleware('checkRole:Admin');
    Route::post('/store-profil-risk', 'App\Http\Controllers\ProfilRisikoController@store')->middleware('checkRole:Admin');
    Route::post('/update-profil-risk', 'App\Http\Controllers\ProfilRisikoController@update')->middleware('checkRole:Admin');
    Route::post('/delete-profil-risk', 'App\Http\Controllers\ProfilRisikoController@delete')->middleware('checkRole:Admin');

    //NILAI EFEKTIVITAS
    Route::get('/nilai-efektivitas', 'App\Http\Controllers\NilaiEfektivitasController@index')->middleware('checkRole:Admin');
    Route::get('/data-nilai-efektivitas', 'App\Http\Controllers\NilaiEfektivitasController@data')->middleware('checkRole:Admin');
    Route::post('/store-nilai-efektivitas', 'App\Http\Controllers\NilaiEfektivitasController@store')->middleware('checkRole:Admin');
    Route::post('/update-nilai-efektivitas', 'App\Http\Controllers\NilaiEfektivitasController@update')->middleware('checkRole:Admin');
    Route::post('/delete-nilai-efektivitas', 'App\Http\Controllers\NilaiEfektivitasController@delete')->middleware('checkRole:Admin');

    //KEMUNGKINAN
    Route::get('/kemungkinan', 'App\Http\Controllers\KemungkinanController@index')->middleware('checkRole:Admin');
    Route::get('/data-kemungkinan', 'App\Http\Controllers\KemungkinanController@data')->middleware('checkRole:Admin');
    Route::post('/store-kemungkinan', 'App\Http\Controllers\KemungkinanController@store')->middleware('checkRole:Admin');
    Route::post('/update-kemungkinan', 'App\Http\Controllers\KemungkinanController@update')->middleware('checkRole:Admin');
    Route::post('/delete-kemungkinan', 'App\Http\Controllers\KemungkinanController@delete')->middleware('checkRole:Admin');

    //DAMPAK
    Route::get('/dampak', 'App\Http\Controllers\DampakController@index')->middleware('checkRole:Admin');
    Route::get('/data-dampak', 'App\Http\Controllers\DampakController@data')->middleware('checkRole:Admin');
    Route::post('/store-dampak', 'App\Http\Controllers\DampakController@store')->middleware('checkRole:Admin');
    Route::post('/update-dampak', 'App\Http\Controllers\DampakController@update')->middleware('checkRole:Admin');
    Route::post('/delete-dampak', 'App\Http\Controllers\DampakController@delete')->middleware('checkRole:Admin');

    //NILAI RISIKO
    Route::get('/nilai-risk', 'App\Http\Controllers\NilaiRisikoController@index')->middleware('checkRole:Admin');
    Route::get('/data-nilai-risk', 'App\Http\Controllers\NilaiRisikoController@data')->middleware('checkRole:Admin');

    //RENCANA PENANGANAN
    Route::get('/rencana-penanganan', 'App\Http\Controllers\RencanaPenangananController@index')->middleware('checkRole:Admin');
    Route::get('/data-rencana-penanganan', 'App\Http\Controllers\RencanaPenangananController@data')->middleware('checkRole:Admin');
    Route::post('/store-rencana-penanganan', 'App\Http\Controllers\RencanaPenangananController@store')->middleware('checkRole:Admin');
    Route::post('/update-rencana-penanganan', 'App\Http\Controllers\RencanaPenangananController@update')->middleware('checkRole:Admin');
    Route::post('/delete-rencana-penanganan', 'App\Http\Controllers\RencanaPenangananController@delete')->middleware('checkRole:Admin');

    //BERKAS AUDIT
    Route::get('/berkas-audit', 'App\Http\Controllers\BerkasAuditController@index')->middleware('checkRole:Admin');
    Route::get('/data-berkas-audit', 'App\Http\Controllers\BerkasAuditController@data')->middleware('checkRole:Admin');
    Route::post('/store-berkas-audit', 'App\Http\Controllers\BerkasAuditController@store')->middleware('checkRole:Admin');
    Route::post('/update-berkas-audit', 'App\Http\Controllers\BerkasAuditController@update')->middleware('checkRole:Admin');
    Route::post('/delete-berkas-audit', 'App\Http\Controllers\BerkasAuditController@delete')->middleware('checkRole:Admin');
    Route::post('/response-berkas-audit', 'App\Http\Controllers\BerkasAuditController@response')->middleware('checkRole:Admin');
    
    //BERKAS REVIEW
    Route::get('/berkas-review', 'App\Http\Controllers\BerkasReviewController@index')->middleware('checkRole:Admin');
    Route::get('/data-berkas-review', 'App\Http\Controllers\BerkasReviewController@data')->middleware('checkRole:Admin');
    Route::post('/response-berkas-review', 'App\Http\Controllers\BerkasReviewController@response')->middleware('checkRole:Admin');
    
    //BERKAS EVALUASI
    Route::get('/berkas-evaluasi', 'App\Http\Controllers\BerkasEvaluasiController@index')->middleware('checkRole:Admin');
    Route::get('/data-berkas-evaluasi', 'App\Http\Controllers\BerkasEvaluasiController@data')->middleware('checkRole:Admin');

    //DOKUMEN SPI
    Route::get('/dokumen-spi', 'App\Http\Controllers\DokumenSpiController@index')->middleware('checkRole:Admin');
    Route::get('/data-dokumen-spi', 'App\Http\Controllers\DokumenSpiController@data')->middleware('checkRole:Admin');
    Route::post('/store-dokumen-spi', 'App\Http\Controllers\DokumenSpiController@store')->middleware('checkRole:Admin');
    Route::post('/update-dokumen-spi', 'App\Http\Controllers\DokumenSpiController@update')->middleware('checkRole:Admin');
    Route::post('/delete-dokumen-spi', 'App\Http\Controllers\DokumenSpiController@delete')->middleware('checkRole:Admin');
    
});

//LOGOUT
Route::get('/logout', function () {
    Auth::logout();
    return redirect('login');
})->name('logout');