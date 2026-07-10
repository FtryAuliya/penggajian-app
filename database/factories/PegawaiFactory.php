<?php

namespace Database\Factories;

use App\Models\Golongan;
use App\Models\Pegawai;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pegawai>
 */
class PegawaiFactory extends Factory
{
    protected $model = Pegawai::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Ambil semua ID golongan yang tersedia
        $golonganIds = Golongan::pluck('id')->toArray();
        // Daftar departemen dan jabatan
        $departemens = ['IT', 'HRD', 'Keuangan', 'Marketing', 'Operasional', 'Sales', 'Research & Development'];
        $jabatans = ['Staff', 'Senior Staff', 'Supervisor', 'Manager', 'Assistant Manager', 'Junior Staff'];
        return [
            'nip' => 'PEG' . fake()->unique()->numerify('##########'), // PEG + 10 angka unik
            'nama' => fake()->name(), // Nama orang Indonesia
            'email' => fake()->unique()->safeEmail(), // Email unik
            'no_telepon' => fake()->phoneNumber(), // Nomor telepon
            'alamat' => fake()->address(), // Alamat Indonesia
            'tanggal_masuk' => fake()->dateTimeBetween('-10 years', 'now')->format('Y-m-d'), //10 tahun terakhir
            'departemen' => fake()->randomElement($departemens), // Pilih randomdepartemen
            'jabatan' => fake()->randomElement($jabatans), // Pilih random jabatan
            'golongan_id' => fake()->randomElement($golonganIds), // Pilih random golongan
            'status' => fake()->randomElement(['aktif', 'nonaktif']), // Status random
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
    /**
     * State untuk pegawai dengan status aktif
     */
    public function aktif(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'aktif',
        ]);
    }
    /**
     * State untuk pegawai dengan status nonaktif
     */
    public function nonaktif(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'nonaktif',
        ]);
    }
    /**
     * State untuk pegawai berdasarkan departemen tertentu
     */
    public function departemen(string $dept): static
    {
        return $this->state(fn(array $attributes) => [
            'departemen' => $dept,
        ]);
    }
}
