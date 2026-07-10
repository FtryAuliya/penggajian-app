<?php

namespace App\Http\Requests;

use App\Models\Pegawai;
use Illuminate\Foundation\Http\FormRequest;

class KomponenGajiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    /**
     * Prepare the data for validation
     * Method ini dipanggil SEBELUM validasi dilakukan
     */
    protected function prepareForValidation(): void
    {
        // Ambil data pegawai untuk mendapatkan komponen gaji dari golongan
        $pegawai = Pegawai::with('golongan')->find($this->pegawai_id);
        if ($pegawai && $pegawai->golongan) {
            // Isi otomatis komponen gaji dari golongan jika belum diisi
            if (!$this->filled('gaji_pokok')) {
                $this->merge([
                    'gaji_pokok' => $pegawai->golongan->gaji_pokok,
                ]);
            }
            if (!$this->filled('tunjangan_makan')) {
                $this->merge([
                    'tunjangan_makan' => $pegawai->golongan->tunjangan_makan,
                ]);
            }
            if (!$this->filled('tunjangan_transport')) {
                $this->merge([
                    'tunjangan_transport' => $pegawai->golongan->tunjangan_transport,
                ]);
            }
        }
        // Set default nilai jika kosong
        $this->merge([
            'tunjangan_lainnya' => $this->tunjangan_lainnya ?? 0,
            'potongan_absensi' => $this->potongan_absensi ?? 0,
            'potongan_lainnya' => $this->potongan_lainnya ?? 0,
            'status' => $this->status ?? 'selesai',
            'tanggal_gaji' => $this->tanggal_gaji ?? date('Y-m-d'),
        ]);
    }
    public function rules(): array
    {
        $komponenGajiId = $this->route('komponen_gaji');
        return [
            'pegawai_id' => 'required|exists:pegawai,id',
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer|min:2000|max:' . (date('Y') + 1),
            'gaji_pokok' => 'required|numeric|min:0',
            'tunjangan_makan' => 'nullable|numeric|min:0',
            'tunjangan_transport' => 'nullable|numeric|min:0',
            'tunjangan_lainnya' => 'nullable|numeric|min:0',
            'potongan_absensi' => 'nullable|numeric|min:0',
            'potongan_lainnya' => 'nullable|numeric|min:0',
            'status' => 'nullable|in:draft,diproses,selesai',
            'tanggal_gaji' => 'required|date',
        ];
    }
    public function messages(): array
    {
        return [
            'pegawai_id.required' => 'Pegawai wajib dipilih',
            'pegawai_id.exists' => 'Pegawai tidak ditemukan',
            'bulan.required' => 'Bulan wajib dipilih',
            'bulan.min' => 'Bulan harus antara 1-12',
            'bulan.max' => 'Bulan harus antara 1-12',
            'tahun.required' => 'Tahun wajib diisi',
            'tahun.min' => 'Tahun minimal 2000',
            'tahun.max' => 'Tahun maksimal ' . (date('Y') + 1),
            'gaji_pokok.required' => 'Gaji pokok wajib diisi',
            'gaji_pokok.min' => 'Gaji pokok tidak boleh negatif',
            'tanggal_gaji.required' => 'Tanggal gaji wajib diisi',
        ];
    }
    /**
     * Additional validation after rules pass
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            // Cek apakah pegawai sudah digaji di bulan dan tahun ini (kecuali untuk update)
            $komponenGajiId = $this->route('komponen_gaji');
            if (!$komponenGajiId) {
                $pegawai = Pegawai::find($this->pegawai_id);
                if ($pegawai && $pegawai->sudahDigaji($this->bulan, $this->tahun)) {
                    $validator->errors()->add(
                        'pegawai_id',
                        'Pegawai sudah digaji pada bulan ' . $this->bulan . ' tahun ' . $this->tahun
                    );
                }
            }
        });
    }
}
