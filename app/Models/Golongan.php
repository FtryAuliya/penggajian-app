<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Golongan extends Model
{
    protected $table = 'golongan';
    // Kolom yang boleh diisi (mass assignment)
    protected $fillable = [
        'kode',
        'nama_golongan',
        'gaji_pokok',
        'tunjangan_makan',
        'tunjangan_transport',
        'keterangan'
    ];


    /**
     * Relasi One-to-Many ke Pegawai
     * Satu Golongan memiliki banyak Pegawai
     */
    public function pegawai(): HasMany
    {
        return $this->hasMany(Pegawai::class, 'golongan_id');
    }
}
