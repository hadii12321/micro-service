<?php

use App\Http\Controllers\Api\AlmtController;
use App\Http\Controllers\Api\MasterController;
use App\Http\Controllers\Api\RefController;
use Illuminate\Support\Facades\Route;

Route::prefix('almt')->group(function () {
    Route::get('provinsi', [AlmtController::class, 'provinsi'])
        ->name('api.almt.provinsi');
    Route::get('kabupaten/{id}', [AlmtController::class, 'kabupaten'])
        ->name('api.almt.kabupaten')
        ->whereNumber('id');
    Route::get('kecamatan/{id}', [AlmtController::class, 'kecamatan'])
        ->name('api.almt.kecamatan')
        ->whereNumber('id');
    Route::get('desa/{id}', [AlmtController::class, 'desa'])
        ->name('api.almt.desa')
        ->whereNumber('id');
});

Route::prefix('ref')->group(function () {
    Route::get('jenjang-pendidikan', [RefController::class, 'jenjangPendidikan'])->name('api.ref.jenjang-pendidikan');
    Route::get('hubungan-keluarga', [RefController::class, 'hubunganKeluarga'])->name('api.ref.hubungan-keluarga');
    Route::get('jenis-asuransi', [RefController::class, 'jenisAsuransi'])->name('api.ref.jenis-asuransi');
    Route::get('eselon', [RefController::class, 'eselon'])->name('api.ref.eselon');
});

Route::prefix('master')->group(function () {
    Route::get('periode', [MasterController::class, 'periode'])->name('api.master.periode');
    Route::get('unit', [MasterController::class, 'unit'])->name('api.master.unit');
    Route::get('jabatan', [MasterController::class, 'jabatan'])->name('api.master.jabatan');
});