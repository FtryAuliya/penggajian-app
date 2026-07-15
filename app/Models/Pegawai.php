<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pegawai extends Model
{
    protected $table = 'pegawai';
    protected $fillable = [
        'nip',
        'nama',
        'email',
        'no_telepon',
        'alamat',
        'tanggal_masuk',
        'departemen',
        'jabatan',
        'golongan_id',
        'status'
    ];
    protected $casts = [
        'tanggal_masuk' => 'date',
    ];
    public function golongan(): BelongsTo
    {
        return $this->belongsTo(Golongan::class, 'golongan_id');
    }
    // Relasi ke KomponenGaji
    public function komponenGaji(): HasMany
    {
        return $this->hasMany(KomponenGaji::class, 'pegawai_id');
    }
    /**
     * Cek apakah pegawai sudah digaji di bulan dan tahun tertentu
     */
    public function sudahDigaji(int $bulan, int $tahun): bool
    {
        return $this->komponenGaji()
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->exists();
    }
    /**
     * Mendapatkan gaji terakhir pegawai
     */
    public function getGajiTerakhirAttribute()
    {
        return $this->komponenGaji()
            ->orderBy('tahun', 'desc')
            ->orderBy('bulan', 'desc')
            ->first();
    }
    /**
     * Mendapatkan masa kerja pegawai dalam tahun
     */
    public function getMasaKerjaAttribute(): int
    {
        return $this->tanggal_masuk ? $this->tanggal_masuk->diffInYears(now()) : 0;
    }
}
