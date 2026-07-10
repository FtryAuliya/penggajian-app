<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\GolonganController;
use App\Http\Controllers\KomponenGajiController;
use App\Http\Controllers\LaporanController;

Route::get('/', function () {
    return view('welcome');
});

// Halaman dashboard
Route::get('/dashboard', function () {
    $totalPegawai = App\Models\Pegawai::count();
    $totalGolongan = App\Models\Golongan::count();
    $aktif = App\Models\Pegawai::where('status', 'aktif')->count();
    return view('dashboard', compact('totalPegawai', 'totalGolongan', 'aktif'));
})->name('dashboard');

// Resource routes untuk CRUD
Route::resource('pegawai', PegawaiController::class);
Route::resource('golongan', GolonganController::class);
Route::resource('komponen-gaji', KomponenGajiController::class);

// Routes Laporan
Route::prefix('laporan')->name('laporan.')->group(function () {
    Route::get('/', [LaporanController::class, 'index'])->name('index');
    Route::get('/slip-gaji', [LaporanController::class, 'slipGaji'])->name('slip-gaji');
    Route::get('/rekap-departemen', [LaporanController::class, 'rekapDepartemen'])->name('rekap-departemen');
    Route::get('/gaji-diatas-rata', [LaporanController::class, 'gajiDiatasRata'])->name('gaji-diatas-rata');
    Route::get('/potongan-terbesar', [LaporanController::class, 'potonganTerbesar'])->name('potongan-terbesar');
    Route::get('/total-gaji-per-bulan', [LaporanController::class, 'totalGajiPerBulan'])->name('total-gaji-per-bulan');
    Route::get('/export-pdf/{jenis}', [LaporanController::class, 'exportPdf'])->name('export-pdf');
});
