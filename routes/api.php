<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataAbsensiGuruController;
use App\Http\Controllers\DataJamMengajarGuruController;
use App\Http\Controllers\DataPrestasiGuruController;
use App\Http\Controllers\DataKegiatanPelatihanGuruController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| CRUD API endpoints for data warehouse tables.
| Prefix: /api
|
*/

Route::prefix('v1')->group(function () {
    Route::apiResource('data-absensi-guru', DataAbsensiGuruController::class);
    Route::apiResource('data-jam-mengajar-guru', DataJamMengajarGuruController::class);
    Route::apiResource('data-prestasi-guru', DataPrestasiGuruController::class);
    Route::apiResource('data-kegiatan-pelatihan-guru', DataKegiatanPelatihanGuruController::class);
});
