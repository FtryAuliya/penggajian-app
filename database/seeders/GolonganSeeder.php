<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class GolonganSeeder extends Seeder
{
    public function run(): void
    {
        // Kosongkan tabel sebelum mengisi (opsional)
        Schema::disableForeignKeyConstraints();
        DB::table('golongan')

            ->truncate();
        Schema::enableForeignKeyConstraints();

        // Data golongan
        $golongan = [
            [
                'kode' => 'I',
                'nama_golongan' => 'Golongan I (Junior Staff)',
                'gaji_pokok' => 3500000,
                'tunjangan_makan' => 500000,
                'tunjangan_transport' => 300000,
                'keterangan' => 'Fresh graduate / Entry level',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'II',
                'nama_golongan' => 'Golongan II (Staff)',
                'gaji_pokok' => 5000000,
                'tunjangan_makan' => 600000,
                'tunjangan_transport' => 400000,
                'keterangan' => '1-3 tahun pengalaman',

                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'III',
                'nama_golongan' => 'Golongan III (Senior Staff)',
                'gaji_pokok' => 7500000,
                'tunjangan_makan' => 750000,
                'tunjangan_transport' => 500000,
                'keterangan' => '3-7 tahun pengalaman',

                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'IV',
                'nama_golongan' => 'Golongan IV (Manager)',
                'gaji_pokok' => 12000000,
                'tunjangan_makan' => 1000000,
                'tunjangan_transport' => 750000,
                'keterangan' => 'Manager / Supervisor',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        DB::table('golongan')->insert($golongan);
        $this->command->info('Data golongan berhasil diisi!');
    }
}
