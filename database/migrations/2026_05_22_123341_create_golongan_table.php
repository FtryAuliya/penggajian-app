<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('golongan', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 10)->unique(); // Kode golongan (I, II, III)
            $table->string('nama_golongan', 50); // Nama golongan
            $table->bigInteger('gaji_pokok'); // Gaji pokok
            $table->bigInteger('tunjangan_makan'); // Tunjangan makan
            $table->bigInteger('tunjangan_transport'); // Tunjangan transport
            $table->text('keterangan')->nullable(); // Keterangan (opsional)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('golongan');
    }
};
