<?php

use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\MataKuliahController;
use App\Http\Controllers\ProdiController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');
Route::resource('prodi', ProdiController::class)->except('show');
Route::resource('mahasiswa', MahasiswaController::class)->except('show');
Route::resource('mata-kuliah', MataKuliahController::class)->parameters(['mata-kuliah' => 'mataKuliah'])->except('show');
