<?php

use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\MataKuliahController;
use App\Http\Controllers\ProdiController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');
Route::resource('prodi', ProdiController::class);
Route::resource('mahasiswa', MahasiswaController::class);
Route::resource('mata-kuliah', MataKuliahController::class)->parameters(['mata-kuliah' => 'mataKuliah']);
