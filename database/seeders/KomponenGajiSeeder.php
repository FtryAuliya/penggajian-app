<?php

namespace Database\Seeders;

use App\Models\KomponenGaji;
use App\Models\Pegawai;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class KomponenGajiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        KomponenGaji::truncate();
        Schema::enableForeignKeyConstraints();
        $this->command->info(' Memulai pengisian data penggajian...');
        $pegawaiList = Pegawai::all();
        // Untuk setiap pegawai, buat riwayat gaji 12 bulan terakhir
        foreach ($pegawaiList as $pegawai) {
            $this->command->line("Memproses pegawai: {$pegawai->nama}");
            // Buat data gaji untuk 12 bulan (Januari - Desember 2024)
            for ($bulan = 1; $bulan <= 12; $bulan++) {
                KomponenGaji::factory()
                    ->bulanTahun($bulan, 2024)
                    ->selesai()
                    ->create([
                        'pegawai_id' => $pegawai->id
                    ]);
            }
        }
        $totalGaji = KomponenGaji::count();
        $this->command->info(" Berhasil membuat {$totalGaji} data penggajian!");
        // Tampilkan total gaji per bulan
        $this->command->info("\n Ringkasan Total Gaji per Bulan (2024):");
        $summary = KomponenGaji::selectRaw('bulan, SUM(gaji_bersih) as total')
            ->where('tahun', 2024)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();
        $namaBulan = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'];
        foreach ($summary as $item) {
            $this->command->line("- {$namaBulan[$item->bulan - 1]}: Rp " .
                number_format($item->total, 0, ',', '.'));
        }
    }
}
