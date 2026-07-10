@extends('layouts.app')

@section('title', 'Edit Pegawai')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-warning text-dark">
            <h5 class="mb-0"><i class="fas fa-edit"></i> Edit Pegawai</h5>
        </div>

        <div class="card-body">
            <form action="{{ route('pegawai.update', $pegawai->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nip" class="form-label">NIP <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nip') is-invalid @enderror" id="nip" name="nip" value="{{ old('nip', $pegawai->nip) }}" readonly>
                            <small class="text-muted">NIP tidak dapat diubah</small>
                            @error('nip')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama', $pegawai->nama) }}">
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $pegawai->email) }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="no_telepon" class="form-label">No. Telepon</label>
                            <input type="text" class="form-control @error('no_telepon') is-invalid @enderror" id="no_telepon" name="no_telepon" value="{{ old('no_telepon', $pegawai->no_telepon) }}">
                            @error('no_telepon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="2">{{ old('alamat', $pegawai->alamat) }}</textarea>
                    @error('alamat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="tanggal_masuk" class="form-label">Tanggal Masuk <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('tanggal_masuk') is-invalid @enderror" id="tanggal_masuk" name="tanggal_masuk" value="{{ old('tanggal_masuk', $pegawai->tanggal_masuk instanceof \Carbon\Carbon ? $pegawai->tanggal_masuk->format('Y-m-d') : $pegawai->tanggal_masuk) }}">
                            @error('tanggal_masuk')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="departemen" class="form-label">Departemen <span class="text-danger">*</span></label>
                            <select class="form-select @error('departemen') is-invalid @enderror" id="departemen" name="departemen">
                                <option value="">Pilih Departemen</option>
                                @php
                                    $departemens = ['IT', 'HRD', 'Keuangan', 'Marketing', 'Operasional', 'Research & Development', 'Sales'];
                                @endphp
                                @foreach($departemens as $dept)
                                    <option value="{{ $dept }}" {{ old('departemen', $pegawai->departemen) == $dept ? 'selected' : '' }}>
                                        {{ $dept }}
                                    </option>
                                @endforeach
                            </select>
                            @error('departemen')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="jabatan" class="form-label">Jabatan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('jabatan') is-invalid @enderror" id="jabatan" name="jabatan" value="{{ old('jabatan', $pegawai->jabatan) }}">
                            @error('jabatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="golongan_id" class="form-label">Golongan <span class="text-danger">*</span></label>
                            <select class="form-select @error('golongan_id') is-invalid @enderror" id="golongan_id" name="golongan_id">
                                <option value="">Pilih Golongan</option>
                                @foreach($golongan as $item)
                                    <option value="{{ $item->id }}" {{ old('golongan_id', $pegawai->golongan_id) == $item->id ? 'selected' : '' }}>
                                        {{ $item->kode }} - {{ $item->nama_golongan }} (Rp {{ number_format($item->gaji_pokok, 0, ',', '.') }})
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
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                                <option value="">Pilih Status</option>
                                <option value="aktif" {{ old('status', $pegawai->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="nonaktif" {{ old('status', $pegawai->status) == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <hr>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('pegawai.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection