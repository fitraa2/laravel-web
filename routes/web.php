<?php

use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\MatakuliahController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\CvController;

//p6p5
use App\Http\Controllers\DashboardController;
//p7p6
use App\Http\Controllers\PelangganController;
//p10p9
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/pcr', function () {
    return 'Selamat Datang di Website Kampus PCR!';
});

Route::get('/mahasiswa', function () {
    return 'Halo Mahasiswa';
});

Route::get('/nama/{param1}', function ($param1) {
    return 'Nama saya: '.$param1;
});

Route::get('/nim/{param1?}', function ($param1 = '') {
    return 'NIM saya: '.$param1;
});

Route::get('/mahasiswa', function () {
    return 'Halo Mahasiswa';
})->name('mahasiswa.show');

Route::get('/matakuliah', function () {
    return 'Masukkan Kode Matakuliah!';
})->name('matakuliah.show');

Route::get('/mahasiswa/{param1}', [MahasiswaController::class, 'show']);

Route::get('/matakuliah/{param2}', [MatakuliahController::class, 'show']);

Route::get('/home', [HomeController::class, 'index']);

Route::post('question/store', [QuestionController::class, 'store'])
		->name('question.store');

//p6p5
Route::get('dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

//p7p6r
Route::resource('pelanggan', PelangganController::class);

//uts p9p8 - CV (index, create, store, show, edit, update, destroy)
// Route::resource('cv', CvController::class)->parameters(['cv' => 'biodata']);

//p10p9
Route::resource('user', UserController::class);

Route::get('/about', function () {
    return view('halaman-about');
});
