<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\GolonganController;
use App\Http\Controllers\KomponenGajiController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Dashboard berdasarkan role
Route::get('/dashboard/admin', [DashboardController::class, 'index'])
    ->middleware(['auth', 'role:admin'])
    ->name('dashboard.admin');

Route::get('/dashboard/karyawan', [DashboardController::class, 'index'])
    ->middleware(['auth', 'role:karyawan'])
    ->name('dashboard.karyawan');

// Route yang hanya bisa diakses admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('pegawai', PegawaiController::class);
    Route::resource('golongan', GolonganController::class);
    Route::resource('komponen-gaji', KomponenGajiController::class);

    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/', [LaporanController::class, 'index'])->name('index');
        Route::get('/rekap-departemen', [LaporanController::class, 'rekapDepartemen'])->name('rekap-departemen');
        Route::get('/gaji-diatas-rata', [LaporanController::class, 'gajiDiatasRata'])->name('gaji-diatas-rata');
        Route::get('/potongan-terbesar', [LaporanController::class, 'potonganTerbesar'])->name('potongan-terbesar');
        Route::get('/total-gaji-per-bulan', [LaporanController::class, 'totalGajiPerBulan'])->name('total-gaji-per-bulan');
        Route::get('/masa-kerja-5-tahun', [LaporanController::class, 'masaKerjaLimaTahun'])->name('masa-kerja-5-tahun');
        Route::get('/urutan-gaji-bersih', [LaporanController::class, 'urutanGajiBersih'])->name('urutan-gaji-bersih');
        Route::get('/jumlah-pegawai-per-golongan', [LaporanController::class, 'jumlahPegawaiPerGolongan'])->name('jumlah-pegawai-per-golongan');
        Route::get('/rekap-tunjangan', [LaporanController::class, 'rekapTunjangan'])->name('rekap-tunjangan');
        Route::get('/perbandingan-gaji-potongan', [LaporanController::class, 'perbandinganGajiPotongan'])->name('perbandingan-gaji-potongan');
    });
});

// Route yang bisa diakses semua user (termasuk karyawan)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Slip gaji dan export PDF bisa diakses karyawan maupun admin
    Route::get('/laporan/slip-gaji', [LaporanController::class, 'slipGaji'])->name('laporan.slip-gaji');
    Route::get('/laporan/export-pdf/{jenis}', [LaporanController::class, 'exportPdf'])->name('laporan.export-pdf');
});

// Route default redirect ke login
Route::get('/', function () {
    return redirect()->route('login');
});

require __DIR__ . '/auth.php';
