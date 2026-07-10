@extends('layouts.app')
@section('title', 'Tambah Pegawai')
@section('content')
<div class="card shadow-sm">
<div class="card-header bg-primary text-white">
<h5 class="mb-0"><i class="fas fa-user-plus"></i> Tambah Pegawai</h5>
</div>
<div class="card-body">
<form action="{{ route('pegawai.store') }}" method="POST">
@csrf
<div class="row">
<div class="col-md-6">
<div class="mb-3">

<label for="nip" class="form-label">NIP <span class="text-
danger">*</span></label>

<input type="text" class="form-control @error('nip') is-invalid @enderror"
id="nip" name="nip" value="{{ old('nip') }}" placeholder="PEG2024001">
@error('nip')
<div class="invalid-feedback">{{ $message }}</div>
@enderror
</div>
</div>
<div class="col-md-6">
<div class="mb-3">

<label for="nama" class="form-label">Nama Lengkap <span class="text-
danger">*</span></label>

<input type="text" class="form-control @error('nama') is-invalid @enderror"
id="nama" name="nama" value="{{ old('nama') }}" placeholder="Budi
Santoso">
@error('nama')
<div class="invalid-feedback">{{ $message }}</div>
@enderror
</div>
</div>
</div>
<div class="row">
<div class="col-md-6">
<div class="mb-3">

<label for="email" class="form-label">Email <span class="text-
danger">*</span></label>

<input type="email" class="form-control @error('email') is-invalid @enderror"
id="email" name="email" value="{{ old('email') }}"
placeholder="budi@perusahaan.com">
@error('email')
<div class="invalid-feedback">{{ $message }}</div>
@enderror
</div>
</div>
<div class="col-md-6">
<div class="mb-3">
<label for="no_telepon" class="form-label">No. Telepon</label>
<input type="text" class="form-control @error('no_telepon') is-invalid
@enderror"
id="no_telepon" name="no_telepon" value="{{ old('no_telepon') }}"
placeholder="08123456789">
@error('no_telepon')
<div class="invalid-feedback">{{ $message }}</div>
@enderror
</div>
</div>
</div>
<div class="mb-3">
<label for="alamat" class="form-label">Alamat</label>
<textarea class="form-control @error('alamat') is-invalid @enderror"
id="alamat" name="alamat" rows="2" placeholder="Jl. Contoh No. 123,
Jakarta">{{ old('alamat') }}</textarea>
@error('alamat')
<div class="invalid-feedback">{{ $message }}</div>
@enderror
</div>
<div class="row">
<div class="col-md-4">
<div class="mb-3">
<label for="tanggal_masuk" class="form-label">Tanggal Masuk <span
class="text-danger">*</span></label>
<input type="date" class="form-control @error('tanggal_masuk') is-invalid
@enderror"
id="tanggal_masuk" name="tanggal_masuk" value="{{ old('tanggal_masuk')
}}">
@error('tanggal_masuk')
<div class="invalid-feedback">{{ $message }}</div>
@enderror
</div>
</div>
<div class="col-md-4">
<div class="mb-3">

<label for="departemen" class="form-label">Departemen <span class="text-
danger">*</span></label>

<select class="form-select @error('departemen') is-invalid @enderror"
id="departemen" name="departemen">
<option value="">Pilih Departemen</option>
<option value="IT" {{ old('departemen') == 'IT' ? 'selected' : '' }}>IT</option>
<option value="HRD" {{ old('departemen') == 'HRD' ? 'selected' : ''
}}>HRD</option>
<option value="Keuangan" {{ old('departemen') == 'Keuangan' ? 'selected' : ''
}}>Keuangan</option>
<option value="Marketing" {{ old('departemen') == 'Marketing' ? 'selected' : ''
}}>Marketing</option>
<option value="Operasional" {{ old('departemen') == 'Operasional' ? 'selected'
: '' }}>Operasional</option>
</select>
@error('departemen')
<div class="invalid-feedback">{{ $message }}</div>
@enderror
</div>
</div>
<div class="col-md-4">
<div class="mb-3">

<label for="jabatan" class="form-label">Jabatan <span class="text-
danger">*</span></label>

<input type="text" class="form-control @error('jabatan') is-invalid @enderror"
id="jabatan" name="jabatan" value="{{ old('jabatan') }}"
placeholder="Staff/Supervisor/Manager">
@error('jabatan')
<div class="invalid-feedback">{{ $message }}</div>
@enderror
</div>
</div>
</div>
<div class="row">
<div class="col-md-6">
<div class="mb-3">

<label for="golongan_id" class="form-label">Golongan <span class="text-
danger">*</span></label>

<select class="form-select @error('golongan_id') is-invalid @enderror"
id="golongan_id" name="golongan_id">
<option value="">Pilih Golongan</option>
@foreach($golongan as $item)
<option value="{{ $item->id }}" {{ old('golongan_id') == $item->id ? 'selected'
: '' }}>
{{ $item->kode }} - {{ $item->nama_golongan }}
</option>
@endforeach
</select>
@error('golongan_id')
<div class="invalid-feedback">{{ $message }}</div>
@enderror
</div>
</div>
<div class="col-md-6">
<div class="mb-3">

<label for="status" class="form-label">Status <span class="text-
danger">*</span></label>

<select class="form-select @error('status') is-invalid @enderror"
id="status" name="status">
<option value="">Pilih Status</option>
<option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
<option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : ''
}}>Nonaktif</option>
</select>
@error('status')
<div class="invalid-feedback">{{ $message }}</div>
@enderror
</div>
</div>
</div>
<div class="d-flex justify-content-between">
<a href="{{ route('pegawai.index') }}" class="btn btn-secondary">
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