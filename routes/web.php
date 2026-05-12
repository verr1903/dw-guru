<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\KehadiranGuruController;
use App\Http\Controllers\JamMengajarController;
use App\Http\Controllers\LaporanController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ===== HALAMAN UTAMA (Dashboard) =====
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// ===== AUTH =====
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// ===== HALAMAN FITUR =====
Route::get('/jam-mengajar', [JamMengajarController::class, 'index'])->name('jam-mengajar');
Route::get('/kehadiran-guru', [KehadiranGuruController::class, 'index'])->name('kehadiran-guru');
Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan');

// ===== PENGATURAN =====
Route::get('/pengaturan', function () {
    return view('pengaturan');
})->name('pengaturan');

// ===== RESOURCE ROUTES (CRUD) =====
Route::resource('guru', GuruController::class);