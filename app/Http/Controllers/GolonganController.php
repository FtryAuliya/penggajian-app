<?php

namespace App\Http\Controllers;

use App\Models\Golongan;
use App\Http\Requests\GolonganRequest;
use Illuminate\Http\Request;

class GolonganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $golongan = Golongan::paginate(10); // Pagination 10 data per halaman
        return view('golongan.index', compact('golongan'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('golongan.create');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(GolonganRequest $request)
    {
        Golongan::create($request->validated());
        return redirect()
            ->route('golongan.index')
            ->with('success', 'Data golongan berhasil ditambahkan!');
    }
    /**
     * Display the specified resource.
     */
    public function show(Golongan $golongan)
    {
        return view('golongan.show', compact('golongan'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Golongan $golongan)
    {
        return view('golongan.edit', compact('golongan'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(GolonganRequest $request, Golongan $golongan)
    {
        $golongan->update($request->validated());
        return redirect()
            ->route('golongan.index')
            ->with('success', 'Data golongan berhasil diupdate!');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Golongan $golongan)
    {
        // Cek apakah golongan memiliki pegawai
        if ($golongan->pegawai()->count() > 0) {
            return redirect()
                ->route('golongan.index')
                ->with('error', 'Golongan tidak dapat dihapus karena masih memiliki pegawai!');
        }
        $golongan->delete();
        return redirect()
            ->route('golongan.index')
            ->with('success', 'Data golongan berhasil dihapus!');
    }
}
