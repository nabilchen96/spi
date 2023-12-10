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
    Route::get('/user', 'App\Http\Controllers\UserController@index');
    Route::get('/data-user', 'App\Http\Controllers\UserController@data');
    Route::post('/store-user', 'App\Http\Controllers\UserController@store');
    Route::post('/update-user', 'App\Http\Controllers\UserController@update');
    Route::post('/delete-user', 'App\Http\Controllers\UserController@delete');

    //MATRIK
    Route::get('/matrik', 'App\Http\Controllers\MatrikController@index');
    Route::get('/data-matrik', 'App\Http\Controllers\MatrikController@data');
    Route::post('/store-matrik', 'App\Http\Controllers\MatrikController@store');
    
    //PERIODE
    Route::get('/jadwal', 'App\Http\Controllers\JadwalController@index');
    Route::get('/data-jadwal', 'App\Http\Controllers\JadwalController@data');
    Route::post('/store-jadwal', 'App\Http\Controllers\JadwalController@store');
    Route::post('/update-jadwal', 'App\Http\Controllers\JadwalController@update');
    Route::post('/delete-jadwal', 'App\Http\Controllers\JadwalController@delete');

    //UNIT
    Route::get('/unit', 'App\Http\Controllers\UnitController@index');
    Route::get('/data-unit', 'App\Http\Controllers\UnitController@data');
    Route::post('/store-unit', 'App\Http\Controllers\UnitController@store');
    Route::post('/update-unit', 'App\Http\Controllers\UnitController@update');
    Route::post('/delete-unit', 'App\Http\Controllers\UnitController@delete');

    //RISIKO
    Route::get('/risiko', 'App\Http\Controllers\RisikoController@index');
    Route::get('/data-risiko', 'App\Http\Controllers\RisikoController@data');
    Route::post('/store-risiko', 'App\Http\Controllers\RisikoController@store');
    Route::post('/update-risiko', 'App\Http\Controllers\RisikoController@update');
    Route::post('/delete-risiko', 'App\Http\Controllers\RisikoController@delete');

    //PROFIL RISIKO
    Route::get('/profil-risk', 'App\Http\Controllers\ProfilRisikoController@index');
    Route::get('/data-profil-risk', 'App\Http\Controllers\ProfilRisikoController@data');
    Route::post('/store-profil-risk', 'App\Http\Controllers\ProfilRisikoController@store');
    Route::post('/update-profil-risk', 'App\Http\Controllers\ProfilRisikoController@update');
    Route::post('/delete-profil-risk', 'App\Http\Controllers\ProfilRisikoController@delete');

    //NILAI EFEKTIVITAS
    Route::get('/nilai-efektivitas', 'App\Http\Controllers\NilaiEfektivitasController@index');
    Route::get('/data-nilai-efektivitas', 'App\Http\Controllers\NilaiEfektivitasController@data');
    Route::post('/store-nilai-efektivitas', 'App\Http\Controllers\NilaiEfektivitasController@store');
    Route::post('/update-nilai-efektivitas', 'App\Http\Controllers\NilaiEfektivitasController@update');
    Route::post('/delete-nilai-efektivitas', 'App\Http\Controllers\NilaiEfektivitasController@delete');

    //KEMUNGKINAN
    Route::get('/kemungkinan', 'App\Http\Controllers\KemungkinanController@index');
    Route::get('/data-kemungkinan', 'App\Http\Controllers\KemungkinanController@data');
    Route::post('/store-kemungkinan', 'App\Http\Controllers\KemungkinanController@store');
    Route::post('/update-kemungkinan', 'App\Http\Controllers\KemungkinanController@update');
    Route::post('/delete-kemungkinan', 'App\Http\Controllers\KemungkinanController@delete');

    //DAMPAK
    Route::get('/dampak', 'App\Http\Controllers\DampakController@index');
    Route::get('/data-dampak', 'App\Http\Controllers\DampakController@data');
    Route::post('/store-dampak', 'App\Http\Controllers\DampakController@store');
    Route::post('/update-dampak', 'App\Http\Controllers\DampakController@update');
    Route::post('/delete-dampak', 'App\Http\Controllers\DampakController@delete');

    //NILAI RISIKO
    Route::get('/nilai-risk', 'App\Http\Controllers\NilaiRisikoController@index');
    Route::get('/data-nilai-risk', 'App\Http\Controllers\NilaiRisikoController@data');

    //RENCANA PENANGANAN
    Route::get('/rencana-penanganan', 'App\Http\Controllers\RencanaPenangananController@index');
    Route::get('/data-rencana-penanganan', 'App\Http\Controllers\RencanaPenangananController@data');
    Route::post('/store-rencana-penanganan', 'App\Http\Controllers\RencanaPenangananController@store');
    Route::post('/update-rencana-penanganan', 'App\Http\Controllers\RencanaPenangananController@update');
    Route::post('/delete-rencana-penanganan', 'App\Http\Controllers\RencanaPenangananController@delete');

    //BERKAS AUDIT
    Route::get('/berkas-audit', 'App\Http\Controllers\BerkasAuditController@index');
    Route::get('/data-berkas-audit', 'App\Http\Controllers\BerkasAuditController@data');
    Route::post('/store-berkas-audit', 'App\Http\Controllers\BerkasAuditController@store');
    Route::post('/update-berkas-audit', 'App\Http\Controllers\BerkasAuditController@update');
    Route::post('/delete-berkas-audit', 'App\Http\Controllers\BerkasAuditController@delete');
    Route::post('/response-berkas-audit', 'App\Http\Controllers\BerkasAuditController@response');
    
    //BERKAS REVIEW
    Route::get('/berkas-review', 'App\Http\Controllers\BerkasReviewController@index');
    Route::get('/data-berkas-review', 'App\Http\Controllers\BerkasReviewController@data');
    Route::post('/response-berkas-review', 'App\Http\Controllers\BerkasReviewController@response');
    
    //BERKAS EVALUASI
    Route::get('/berkas-evaluasi', 'App\Http\Controllers\BerkasEvaluasiController@index');
    Route::get('/data-berkas-evaluasi', 'App\Http\Controllers\BerkasEvaluasiController@data');

    //DOKUMEN SPI
    Route::get('/dokumen-spi', 'App\Http\Controllers\DokumenSpiController@index');
    Route::get('/data-dokumen-spi', 'App\Http\Controllers\DokumenSpiController@data');
    Route::post('/store-dokumen-spi', 'App\Http\Controllers\DokumenSpiController@store');
    Route::post('/update-dokumen-spi', 'App\Http\Controllers\DokumenSpiController@update');
    Route::post('/delete-dokumen-spi', 'App\Http\Controllers\DokumenSpiController@delete');
    
});

//LOGOUT
Route::get('/logout', function () {
    Auth::logout();
    return redirect('login');
})->name('logout');