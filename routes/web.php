<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\KehadiranGuruController;
use App\Http\Controllers\JamMengajarController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PelatihanPrestasiController;

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
Route::get('/logout', function () {
    return view('auth.login');
})->name('logout');


// ===== HALAMAN FITUR =====
Route::get('/jam-mengajar', [JamMengajarController::class, 'index'])->name('jam-mengajar');
Route::get('/kehadiran-guru', [KehadiranGuruController::class, 'index'])->name('kehadiran-guru');
Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan');
Route::get('/pelatihan-prestasi', [PelatihanPrestasiController::class, 'index'])->name('pelatihan-prestasi');

// ===== PENGATURAN =====
Route::get('/pengaturan', function () {
    return view('pengaturan');
})->name('pengaturan');

// ===== RESOURCE ROUTES (CRUD) =====

Route::get('/dashboard/detail-bulan', [DashboardController::class, 'detailBulan'])
    ->name('dashboard.detail-bulan');

Route::get('/jam-mengajar/detail-guru', [JamMengajarController::class, 'detailGuru'])
    ->name('jam-mengajar.detail-guru');

     
// ── Halaman Laporan (Download Center) ────────────────────────────────
Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan');
 
// ── Export: Rekap Kinerja (Dashboard) ────────────────────────────────
Route::get('/laporan/export/dashboard/pdf',   [LaporanController::class, 'exportDashboardPdf'])
    ->name('laporan.export.dashboard.pdf');
 
Route::get('/laporan/export/dashboard/excel', [LaporanController::class, 'exportDashboardExcel'])
    ->name('laporan.export.dashboard.excel');
 
// ── Export: Jam Mengajar ──────────────────────────────────────────────
Route::get('/laporan/export/jam/pdf',   [LaporanController::class, 'exportJamPdf'])
    ->name('laporan.export.jam.pdf');
 
Route::get('/laporan/export/jam/excel', [LaporanController::class, 'exportJamExcel'])
    ->name('laporan.export.jam.excel');
 
// ── Export: Kehadiran Guru ────────────────────────────────────────────
Route::get('/laporan/export/kehadiran/pdf',   [LaporanController::class, 'exportKehadiranPdf'])
    ->name('laporan.export.kehadiran.pdf');
 
Route::get('/laporan/export/kehadiran/excel', [LaporanController::class, 'exportKehadiranExcel'])
    ->name('laporan.export.kehadiran.excel');