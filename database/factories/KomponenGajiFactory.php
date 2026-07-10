<?php

namespace Database\Factories;

use App\Models\KomponenGaji;
use App\Models\Pegawai;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\KomponenGaji>
 */
class KomponenGajiFactory extends Factory
{
    protected $model = KomponenGaji::class;
    public function definition(): array
    {
        // Ambil ID pegawai random
        $pegawai = Pegawai::inRandomOrder()->first();
        // Jika belum ada pegawai, buat pegawai baru
        if (!$pegawai) {
            $pegawai = Pegawai::factory()->create();
        }
        // Ambil data golongan dari pegawai
        $golongan = $pegawai->golongan;
        // Komponen gaji dari golongan
        $gajiPokok = $golongan->gaji_pokok;
        $tunjanganMakan = $golongan->tunjangan_makan;
        $tunjanganTransport = $golongan->tunjangan_transport;
        // Tunjangan lainnya (random 0 - 500.000)
        $tunjanganLainnya = fake()->numberBetween(0, 500000);
        // Potongan absensi (random 0 - 200.000, berdasarkan kehadiran)
        $potonganAbsensi = fake()->numberBetween(0, 200000);
        // Potongan lainnya (random 0 - 300.000)
        $potonganLainnya = fake()->numberBetween(0, 300000);
        // Total potongan
        $totalPotongan = $potonganAbsensi + $potonganLainnya;
        // Gaji bersih
        $gajiBersih = $gajiPokok + $tunjanganMakan + $tunjanganTransport +
            $tunjanganLainnya - $totalPotongan;
        // Bulan dan tahun
        $bulan = fake()->numberBetween(1, 12);
        $tahun = fake()->numberBetween(2023, 2025);
        $tanggalGaji = fake()->dateTimeBetween("$tahun-$bulan-01", "$tahun-$bulan-28")->format('Y-m-d');
        return [
            'pegawai_id' => $pegawai->id,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'gaji_pokok' => $gajiPokok,
            'tunjangan_makan' => $tunjanganMakan,
            'tunjangan_transport' => $tunjanganTransport,
            'tunjangan_lainnya' => $tunjanganLainnya,
            'potongan_absensi' => $potonganAbsensi,
            'potongan_lainnya' => $potonganLainnya,
            'total_potongan' => $totalPotongan,
            'gaji_bersih' => $gajiBersih,
            'status' => fake()->randomElement(['draft', 'diproses', 'selesai']),
            'tanggal_gaji' => $tanggalGaji,
        ];
    }
    /**
     * State untuk bulan tertentu
     */
    public function bulanTahun(int $bulan, int $tahun): static
    {
        return $this->state(fn(array $attributes) => [
            'bulan' => $bulan,
            'tahun' => $tahun,
            'tanggal_gaji' => fake()->dateTimeBetween("$tahun-$bulan-01", "$tahun-$bulan-28")->format('Y-m-d'),
        ]);
    }
    /**
     * State untuk status selesai
     */
    public function selesai(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'selesai',
        ]);
    }
}
