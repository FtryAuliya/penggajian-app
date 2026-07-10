<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class PegawaiRequest extends FormRequest
{
public function authorize(): bool
{
return true;
}
public function rules(): array
{
$pegawaiId = $this->route('pegawai') ? $this->route('pegawai')->id : null;
return [
'nip' => 'required|string|max:20|unique:pegawai,nip,' . $pegawaiId,
'nama' => 'required|string|max:100',
'email' => 'required|email|max:100|unique:pegawai,email,' . $pegawaiId,
'no_telepon' => 'nullable|string|max:15',
'alamat' => 'nullable|string',
'tanggal_masuk' => 'required|date',
'departemen' => 'required|string|max:50',
'jabatan' => 'required|string|max:50',
'golongan_id' => 'required|integer|exists:golongan,id',
'status' => 'required|in:aktif,nonaktif',
];
}
public function messages(): array
{
return [
'nip.required' => 'NIP wajib diisi',
'nip.unique' => 'NIP sudah terdaftar',
'nama.required' => 'Nama pegawai wajib diisi',
'email.required' => 'Email wajib diisi',
'email.email' => 'Format email tidak valid',
'email.unique' => 'Email sudah terdaftar',
'tanggal_masuk.required' => 'Tanggal masuk wajib diisi',
'departemen.required' => 'Departemen wajib diisi',
'jabatan.required' => 'Jabatan wajib diisi',
'golongan_id.required' => 'Golongan wajib dipilih',
'golongan_id.exists' => 'Golongan yang dipilih tidak valid',
'status.required' => 'Status wajib dipilih',
];
}
}