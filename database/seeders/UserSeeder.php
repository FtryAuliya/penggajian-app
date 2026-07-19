<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Buat admin default
        User::updateOrCreate(
            ['email' => 'admin@perusahaan.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );
        // Buat karyawan sample
        User::updateOrCreate(
            ['email' => 'karyawan@perusahaan.com'],
            [
                'name' => 'Karyawan Sample',
                'password' => Hash::make('password'),
                'role' => 'karyawan',
            ]
        );
    }
}
