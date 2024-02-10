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

// Route::get('/home', 'HomeController@home');
// Route::get('/', 'HomeController@home');



Route::get('/register', 'AuthController@register');
Route::post('/register', 'AuthController@do_register')->name('pendaftaran');


Route::group(['middleware' => ['auth:sanctum', 'cekrole:1|2']], function () {
    // Route::get('/', 'DashboardController@index');

    // Route::middleware(['auth:sanctum', ''])->get('/dashboard', 'DashboardController@index')->name('dashboard');

    // Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function(){
    //     return view('dashboard');
    // })->name('dashboard');
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    Route::post('/dashboard/ajax', 'DashboardController@ajax')->name('dashboard.ajax');

    Route::group(['prefix' => 'users', 'middleware' => ['auth:sanctum', 'cekrole:1']], function () {

        Route::get('/display', 'UsersController@display');
        Route::post('/add', 'UsersController@add')->name('user.add');
        Route::post('/edit', 'UsersController@edit')->name('user.edit');
        Route::post('/hapus', 'UsersController@hapus')->name('user.hapus');

        Route::get('/display/filter', 'UsersController@filter')->name('user.filter');
        Route::get('/export_excel', 'UsersController@export_excel');
        Route::get('/export_pdf', 'UsersController@export_pdf');
    });


    Route::group(['prefix' => 'tingkat', 'middleware' => ['auth:sanctum', 'cekrole:1']], function () {

        Route::get('/display', 'TingkatController@display');
        Route::post('/add', 'TingkatController@add')->name('tingkat.add');
        Route::post('/edit', 'TingkatController@edit')->name('tingkat.edit');
        Route::post('/hapus', 'TingkatController@hapus')->name('tingkat.hapus');

        Route::get('/display/filter', 'TingkatsController@filter')->name('tingkat.filter');
        Route::get('/export_excel', 'TingkatUsersController@export_excel');
        Route::get('/export_pdf', 'TingkatsController@export_pdf');
    });


    Route::group(['prefix' => 'jurusan', 'middleware' => ['auth:sanctum', 'cekrole:1']], function () {

        Route::get('/display', 'JurusanController@display');
        Route::post('/add', 'JurusanController@add')->name('jurusan.add');
        Route::post('/edit', 'JurusanController@edit')->name('jurusan.edit');
        Route::post('/hapus', 'JurusanController@hapus')->name('jurusan.hapus');
    });

    Route::group(['prefix' => 'jenis', 'middleware' => ['auth:sanctum', 'cekrole:1']], function () {

        Route::get('/display', 'JenisController@display');
        Route::post('/add', 'JenisController@add')->name('jenis.add');
        Route::post('/edit', 'JenisController@edit')->name('jenis.edit');
        Route::post('/hapus', 'JenisController@hapus')->name('jenis.hapus');
    });

    Route::group(['prefix' => 'kelompok', 'middleware' => ['auth:sanctum', 'cekrole:1']], function () {

        Route::get('/display', 'KelompokController@display');
        Route::post('/add', 'KelompokController@add')->name('kelompok.add');
        Route::post('/edit', 'KelompokController@edit')->name('kelompok.edit');
        Route::post('/hapus', 'KelompokController@hapus')->name('kelompok.hapus');
    });

    Route::group(['prefix' => 'pelatihan', 'middleware' => ['auth:sanctum', 'cekrole:1']], function () {

        Route::get('/display', 'PelatihanController@display');
        Route::post('/add', 'PelatihanController@add')->name('pelatihan.add');
        Route::post('/edit', 'PelatihanController@edit')->name('pelatihan.edit');
        Route::post('/hapus', 'PelatihanController@hapus')->name('pelatihan.hapus');
    });

    Route::group(['prefix' => 'sample', 'middleware' => ['auth:sanctum', 'cekrole:1']], function () {

        Route::get('/display', 'SampleController@display')->name('sample.display');
        Route::post('/add', 'SampleController@add')->name('sample.add');
        Route::get('/edit/{id}', 'SampleController@edit')->name('sample.edit');
        Route::post('/update', 'SampleController@update')->name('sample.update');
        Route::get('/delete/{id}', 'SampleController@delete')->name('sample.delete');
    });


    Route::group(['prefix' => 'probabilitas', 'middleware' => ['auth:sanctum', 'cekrole:1']], function () {

        Route::get('/display', 'ProbabilitasController@display');
    });

    Route::group(['prefix' => 'tenagakerja', 'middleware' => ['auth:sanctum', 'cekrole:1']], function () {

        Route::get('/display', 'TenagakerjaController@display');
        Route::post('/add', 'TenagakerjaController@add')->name('tenagakerja.add');
        Route::get('/edit/{id}', 'TenagakerjaController@edit')->name('tenagakerja.edit');
        Route::get('/delete/{id}', 'TenagakerjaController@delete')->name('tenagakerja.delete');
    });

    Route::group(['prefix' => 'rekomendasi', 'middleware' => ['auth:sanctum', 'cekrole:1']], function () {

        Route::get('/display', 'RekomendasiController@display');
        Route::post('/proses', 'RekomendasiController@proses')->name('rekomendasi.proses');
        Route::get('/detail/{id}', 'RekomendasiController@detail');
    });

    Route::prefix('/laporan')->group(function () {
        Route::get('/display', 'LaporanController@display');
        Route::post('/rekomendasi', 'LaporanController@rekomendasi')->name('laporan.rekomendasi');
    });
});
