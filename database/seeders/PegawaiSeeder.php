<?php

namespace Database\Seeders;

use App\Models\Golongan;
use App\Models\Pegawai;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class PegawaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Nonaktifkan foreign key check
        Schema::disableForeignKeyConstraints();
        Pegawai::truncate(); // Kosongkan tabel pegawai
        Schema::enableForeignKeyConstraints();
        $this->command->info(' Memulai pengisian data pegawai...');
        // Buat 100 pegawai dengan data random
        Pegawai::factory()
            ->count(100)
            ->aktif() // Gunakan state aktif
            ->create();
        $this->command->info(' Berhasil membuat 100 pegawai aktif!');
        // Buat 10 pegawai nonaktif
        Pegawai::factory()
            ->count(10)
            ->nonaktif()
            ->create();
        $this->command->info(' Berhasil membuat 10 pegawai nonaktif!');
        // Tampilkan statistik per golongan
        $stats = Pegawai::selectRaw('golongan_id, count(*) as total')
            ->groupBy('golongan_id')
            ->with('golongan')
            ->get();
        $this->command->info("\n Statistik Pegawai per Golongan:");
        foreach ($stats as $stat) {
            $this->command->line("- Golongan {$stat->golongan->kode}: {$stat->total} pegawai");
        }
    }
}
