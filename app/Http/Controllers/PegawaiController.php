<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Golongan;
use Illuminate\Http\Request;

class PegawaiController extends Controller
{
public function index()
{
$pegawai = Pegawai::with('golongan')->paginate(10);
return view('pegawai.index', compact('pegawai'));
}
public function create()
{
$golongan = Golongan::all();
return view('pegawai.create', compact('golongan'));
}
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nip' => 'required|string|max:20|unique:pegawai,nip',
            'nama' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:pegawai,email',
            'no_telepon' => 'nullable|string|max:15',
            'alamat' => 'nullable|string',
            'tanggal_masuk' => 'required|date',
            'departemen' => 'required|string|max:50',
            'jabatan' => 'required|string|max:50',
            'golongan_id' => 'required|integer|exists:golongan,id',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        Pegawai::create($validated);

        return redirect()
            ->route('pegawai.index')
            ->with('success', 'Data pegawai berhasil ditambahkan!');
    }
public function show(Pegawai $pegawai)
{
$pegawai->load('golongan');
return view('pegawai.show', compact('pegawai'));
}
public function edit(Pegawai $pegawai)
{
$golongan = Golongan::all();
return view('pegawai.edit', compact('pegawai', 'golongan'));
}
    public function update(Request $request, Pegawai $pegawai)
    {
        $validated = $request->validate([
            'nip' => 'required|string|max:20|unique:pegawai,nip,' . $pegawai->id,
            'nama' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:pegawai,email,' . $pegawai->id,
            'no_telepon' => 'nullable|string|max:15',
            'alamat' => 'nullable|string',
            'tanggal_masuk' => 'required|date',
            'departemen' => 'required|string|max:50',
            'jabatan' => 'required|string|max:50',
            'golongan_id' => 'required|integer|exists:golongan,id',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $pegawai->update($validated);

        return redirect()
            ->route('pegawai.index')
            ->with('success', 'Data pegawai berhasil diupdate!');
    }
public function destroy(Pegawai $pegawai)
{
// Cek apakah pegawai memiliki riwayat gaji
if ($pegawai->komponenGaji()->count() > 0) {
return redirect()
->route('pegawai.index')
->with('error', 'Pegawai tidak dapat dihapus karena sudah memiliki riwayat gaji!');
}
$pegawai->delete();
return redirect()
->route('pegawai.index')
->with('success', 'Data pegawai berhasil dihapus!');
}
}