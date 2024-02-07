<?php

use Illuminate\Support\Facades\Route;

Route::get('/not_verified', 'DashboardController@not_verified');

Route::group(['middleware' => ['auth:sanctum', 'cekrole:3']], function () {

    Route::post('/dashboard/ajax', 'DashboardController@ajax')->name('operator_dashboard.ajax');

    Route::get('/dashboard', 'DashboardController@index');

    Route::group(['prefix' => 'opd/',], function () {
        Route::get('/display', 'OpdController@index');
        Route::get('/edit', 'OpdController@edit');
        Route::post('/update', 'OpdController@update')->name('operator_opd.edit');
    });

    Route::group(['prefix' => 'gedung/',], function () {

        Route::get('/display', 'AkunController@display_listrik');
    });


    Route::group(['prefix' => 'kwh/',], function () {

        Route::get('/display', 'KwhController@display');
        Route::post('/add', 'KwhController@add')->name('operator_kwh.add');
        Route::post('/edit', 'KwhController@edit')->name('operator_kwh.edit');
    });

    Route::group(['prefix' => 'penghematan'], function () {

        Route::get('/listrik/display', 'PenghematanController@display');
        Route::get('/listrik/detail', 'PenghematanController@detail');

        Route::get('/air/display', 'PenghematanController@display_air');
        Route::get('/air/detail', 'PenghematanController@detail_air');
    });

    Route::group(['prefix' => 'listrik/',], function () {
        Route::get('/kriteria', 'KriteriaController@display_listrik');

        Route::get('/akun/display_listrik', 'AkunController@display_listrik');
        Route::post('/akun/hapus', 'AkunController@delete')->name('operator_akun.hapus');
        Route::post('/akun/add', 'AkunController@add')->name('operator_akun.add');
        Route::post('/akun/edit', 'AkunController@edit')->name('operator_akun.edit');
        Route::get('/akun/filter', 'AkunController@filter')->name('operator_akun.filter');

        Route::get('/penggunaan/display', 'PenggunaanController@display_listrik');
        Route::get('/penggunaan/tambah', 'PenggunaanController@tambah_listrik')->name('operator_penggunaan.tambah');
        Route::get('/penggunaan/ubah/{id_laporan}', 'PenggunaanController@ubah_penggunaan_listrik');
        Route::get('/penggunaan/filter_penggunaan', 'PenggunaanController@penggunaan_listrik_filter')->name('operator_penggunaan.filter');
        Route::get('/penggunaan/export_excel', 'PenggunaanController@export_excel_penggunaan');
        Route::get('/penggunaan/export_pdf', 'PenggunaanController@export_pdf_penggunaan');
        Route::get('/penggunaan/detail/{tagihan}', 'PenggunaanController@detail_penggunaan');

        Route::get('/record/display', 'PenggunaanController@display_record_listrik');
        Route::get('/record/detail/{id_record}', 'PenggunaanController@detail_record_listrik');
        Route::get('/record/detail_pdf/{id_record}', 'PenggunaanController@detail_record_listrik_pdf');
        Route::get('/record/penggunaan/filter', 'PenggunaanController@filter_record')->name('operator_record.filter');
        Route::get('/record/export_excel', 'PenggunaanController@export_record');
        Route::get('/record/export_pdf', 'PenggunaanController@export_pdf');

        Route::post('/add_penggunaan', 'PenggunaanController@add_penggunaan')->name('operator_penggunaan.add');
        Route::post('/edit_penggunaan', 'PenggunaanController@edit_penggunaan')->name('operator_penggunaan.edit');
        Route::post('/hapus_penggunaan', 'PenggunaanController@hapus_penggunaan')->name('operator_penggunaan.hapus');
    });

    Route::group(['prefix' => 'air/',], function () {
        Route::get('/kriteria', 'KriteriaController@display_air');

        Route::get('/penggunaan/display', 'PenggunaanController@display_air');
        Route::post('/add_penggunaan', 'PenggunaanController@add_penggunaan_air')->name('operator_pennggunaan_air.add');
        Route::post('/edit_penggunaan', 'PenggunaanController@edit_penggunaan_air')->name('operator_penggunaan_air.edit');
        Route::post('/hapus_penggunaan', 'PenggunaanController@hapus_penggunaan_air')->name('operator_penggunaan_air.hapus');
        Route::get('/penggunaan/detail/{tagihan}', 'PenggunaanController@detail_penggunaan_air');

        Route::get('/penggunaan/filter', 'PenggunaanController@filter_penggunaan_air')->name('operator_penggunaan_air.filter');

        Route::get('/penggunaan/export_excel', 'PenggunaanController@export_excel_air');
        Route::get('/penggunaan/export_pdf', 'PenggunaanController@export_pdf_air');

        Route::get('/record/display', 'PenggunaanController@record_air_display');
        Route::get('/record/filter', 'PenggunaanController@record_air_filter')->name('operator_record_air.filter');
        Route::get('/record/detail/{id_record}', 'PenggunaanController@record_air_detail');
        Route::get('/record/detail_air_pdf/{id_record}', 'PenggunaanController@record_air_detail_pdf');

        Route::get('/record/export_pdf', 'PenggunaanController@record_air_export_pdf');
        Route::get('/record/export_excel', 'PenggunaanController@record_air_export_excel');
    });


    Route::group(['prefix' => 'ac/',], function () {
        Route::get('/display', 'AcController@display');
        Route::get('/filter', 'AcController@filter')->name('operator_ac.filter');

        Route::post('/add', 'AcController@add')->name('operator_ac.add');
        Route::post('/edit', 'AcController@edit')->name('operator_ac.edit');
        Route::post('/hapus', 'AcController@hapus')->name('operator_ac.hapus');
    });
});
