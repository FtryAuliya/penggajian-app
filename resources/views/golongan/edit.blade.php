@extends('layouts.app')
@section('title', isset($golongan) ? 'Edit Golongan' : 'Tambah Golongan')
@section('content')
<div class="card">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">
            <i class="fas {{ isset($golongan) ? 'fa-edit' : 'fa-plus' }}"></i>
            {{ isset($golongan) ? 'Edit Golongan' : 'Tambah Golongan' }}
        </h5>
    </div>
    <div class="card-body">
        <form action="{{ isset($golongan) ? route('golongan.update', $golongan->id) : route('golongan.store') }}" method="POST">
            @csrf
            @if(isset($golongan))
            @method('PUT')
            @endif
            <div class="mb-3">
                <label for="kode" class="form-label">Kode Golongan <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('kode') is-invalid @enderror" id="kode" name="kode" value="{{ old('kode', $golongan->kode ?? '') }}">
                @error('kode')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="nama_golongan" class="form-label">Nama Golongan <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('nama_golongan') is-invalid @enderror" id="nama_golongan" name="nama_golongan" value="{{ old('nama_golongan', $golongan->nama_golongan ?? '') }}">
                @error('nama_golongan')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="gaji_pokok" class="form-label">Gaji Pokok <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('gaji_pokok') is-invalid @enderror" id="gaji_pokok" name="gaji_pokok" value="{{ old('gaji_pokok', $golongan->gaji_pokok ?? '') }}">
                        @error('gaji_pokok')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="tunjangan_makan" class="form-label">Tunjangan Makan</label>
                        <input type="number" class="form-control @error('tunjangan_makan') is-invalid @enderror" id="tunjangan_makan" name="tunjangan_makan" value="{{ old('tunjangan_makan', $golongan->tunjangan_makan ?? '') }}">
                        @error('tunjangan_makan')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="tunjangan_transport" class="form-label">Tunjangan Transport</label>
                        <input type="number" class="form-control @error('tunjangan_transport') is-invalid @enderror" id="tunjangan_transport" name="tunjangan_transport" value="{{ old('tunjangan_transport', $golongan->tunjangan_transport ?? '') }}">
                        @error('tunjangan_transport')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan</label>
                <textarea class="form-control" id="keterangan" name="keterangan" rows="3">{{ old('keterangan', $golongan->keterangan ?? '') }}</textarea>
            </div>
            <div class="d-flex justify-content-between">
                <a href="{{ route('golongan.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection