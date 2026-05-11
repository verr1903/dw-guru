<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GuruController;

Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/jam-mengajar', function () {
    return view('jam-mengajar');
})->name('jam-mengajar');

Route::get('/kehadiran-guru', function () {
    return view('kehadiran-guru');
})->name('kehadiran-guru');

Route::get('/laporan', function () {
    return view('laporan');
})->name('laporan');

Route::get('/pengaturan', function () {
    return view('pengaturan');
})->name('pengaturan');

Route::resource('guru', GuruController::class);