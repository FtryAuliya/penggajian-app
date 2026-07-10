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
        Schema::create('pegawai', function (Blueprint $table) {
            $table->id();
            $table->string('nip', 20)->unique(); // NIP unik
            $table->string('nama', 100);
            $table->string('email', 100)->unique(); // Email unik
            $table->string('no_telepon', 30)->nullable();
            $table->text('alamat')->nullable();
            $table->date('tanggal_masuk'); // Tanggal bergabung
            $table->string('departemen', 50);
            $table->string('jabatan', 50);

            // Foreign key ke tabel golongan
            $table->foreignId('golongan_id')
                ->constrained('golongan')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawai');
    }
};
