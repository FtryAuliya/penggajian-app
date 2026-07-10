<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('komponen_gaji', function (Blueprint $table) {
            $table->id();
            // Foreign key ke pegawai
            $table->foreignId('pegawai_id')
                ->constrained('pegawai')
                ->onDelete('cascade');
            // Periode
            $table->integer('bulan');
            $table->integer('tahun');
            // Komponen gaji
            $table->bigInteger('gaji_pokok');
            $table->bigInteger('tunjangan_makan')->default(0);
            $table->bigInteger('tunjangan_transport')->default(0);
            $table->bigInteger('tunjangan_lainnya')->default(0);
            // Potongan
            $table->bigInteger('potongan_absensi')->default(0);
            $table->bigInteger('potongan_lainnya')->default(0);
            $table->bigInteger('total_potongan')->default(0);
            // Hasil akhir
            $table->bigInteger('gaji_bersih');
            // Status penggajian
            $table->enum('status', ['draft', 'diproses', 'selesai'])->default('draft');
            // Tanggal gaji (kapan gaji ini dibayarkan)
            $table->date('tanggal_gaji');
            $table->timestamps();
            // Unique constraint: satu pegawai hanya sekali digaji per bulan
            $table->unique(['pegawai_id', 'bulan', 'tahun'], 'unique_penggajian');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('komponen_gaji');
    }
};
