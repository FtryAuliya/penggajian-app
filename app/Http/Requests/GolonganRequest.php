<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GolonganRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Izin untuk semua user (sementara)
    }
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $golongan = $this->route('golongan');

        return [
            'kode' => [
                'required',
                'string',
                'max:10',
                \Illuminate\Validation\Rule::unique('golongan', 'kode')->ignore($golongan),
            ],
            'nama_golongan' => 'required|string|max:50',
            'gaji_pokok' => 'required|numeric|min:0',
            'tunjangan_makan' => 'required|numeric|min:0',
            'tunjangan_transport' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
        ];
    }
    /**
     * Custom error messages
     */
    public function messages(): array
    {
        return [
            'kode.required' => 'Kode golongan wajib diisi',
            'kode.unique' => 'Kode golongan sudah terdaftar',
            'nama_golongan.required' => 'Nama golongan wajib diisi',
            'gaji_pokok.required' => 'Gaji pokok wajib diisi',
            'gaji_pokok.min' => 'Gaji pokok tidak boleh kurang dari 0',
            'tunjangan_makan.required' => 'Tunjangan makan wajib diisi',
            'tunjangan_transport.required' => 'Tunjangan transport wajib diisi',
        ];
    }
}
