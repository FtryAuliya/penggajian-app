@extends('layouts.app')

@section('title', 'Detail Pegawai')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-user-circle"></i> Detail Pegawai</h5>
            <div>
                <a href="{{ route('pegawai.edit', $pegawai->id) }}" class="btn btn-light btn-sm">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <a href="{{ route('pegawai.index') }}" class="btn btn-light btn-sm">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <!-- Informasi Pribadi -->
                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-header bg-light">
                            <strong><i class="fas fa-user"></i> Informasi Pribadi</strong>
                        </div>
                        <div class="card-body">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="35%">NIP</th>
                                    <td>: <span class="badge bg-primary">{{ $pegawai->nip }}</span></td>
                                </tr>
                                <tr>
                                    <th>Nama Lengkap</th>
                                    <td>: <strong>{{ $pegawai->nama }}</strong></td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>: <a href="mailto:{{ $pegawai->email }}">{{ $pegawai->email }}</a></td>
                                </tr>
                                <tr>
                                    <th>No. Telepon</th>
                                    <td>: {{ $pegawai->no_telepon ?: '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Alamat</th>
                                    <td>: {{ $pegawai->alamat ?: '-' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Informasi Pekerjaan -->
                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-header bg-light">
                            <strong><i class="fas fa-briefcase"></i> Informasi Pekerjaan</strong>
                        </div>
                        <div class="card-body">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="40%">Departemen</th>
                                    <td>: {{ $pegawai->departemen }}</td>
                                </tr>
                                <tr>
                                    <th>Jabatan</th>
                                    <td>: {{ $pegawai->jabatan }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Masuk</th>
                                    <td>: {{ \Carbon\Carbon::parse($pegawai->tanggal_masuk)->format('d-m-Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Lama Bekerja</th>
                                    <td>: {{ $pegawai->masa_kerja }} Tahun</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>:
                                        @if($pegawai->status == 'aktif')
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-danger">Nonaktif</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informasi Golongan & Gaji -->
            <div class="card mb-3">
                <div class="card-header bg-light">
                    <strong><i class="fas fa-layer-group"></i> Informasi Golongan & Komponen Gaji</strong>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="40%">Kode Golongan</th>
                                    <td>: <span class="badge bg-info fs-6">{{ $pegawai->golongan->kode }}</span></td>
                                </tr>
                                <tr>
                                    <th>Nama Golongan</th>
                                    <td>: {{ $pegawai->golongan->nama_golongan }}</td>
                                </tr>
                                <tr>
                                    <th>Keterangan</th>
                                    <td>: {{ $pegawai->golongan->keterangan ?: '-' }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="40%">Gaji Pokok</th>
                                    <td>: <strong class="text-success">Rp {{ number_format($pegawai->golongan->gaji_pokok, 0, ',', '.') }}</strong></td>
                                </tr>
                                <tr>
                                    <th>Tunjangan Makan</th>
                                    <td>: Rp {{ number_format($pegawai->golongan->tunjangan_makan, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th>Tunjangan Transport</th>
                                    <td>: Rp {{ number_format($pegawai->golongan->tunjangan_transport, 0, ',', '.') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="alert alert-success mb-0">
                        <div class="row text-center">
                            <div class="col-md-3">
                                <small class="text-muted">Total Tunjangan</small>
                                <h5 class="mb-0">Rp {{ number_format($pegawai->golongan->tunjangan_makan + $pegawai->golongan->tunjangan_transport, 0, ',', '.') }}</h5>
                            </div>
                            <div class="col-md-1 d-flex align-items-center justify-content-center">
                                <i class="fas fa-plus"></i>
                            </div>
                            <div class="col-md-3">
                                <small class="text-muted">Gaji Pokok</small>
                                <h5 class="mb-0">Rp {{ number_format($pegawai->golongan->gaji_pokok, 0, ',', '.') }}</h5>
                            </div>
                            <div class="col-md-1 d-flex align-items-center justify-content-center">
                                <i class="fas fa-equals"></i>
                            </div>
                            <div class="col-md-4">
                                <small class="text-muted">Total Gaji Bersih</small>
                                <h4 class="mb-0 text-success">
                                    <strong>Rp {{ number_format($pegawai->golongan->gaji_pokok + $pegawai->golongan->tunjangan_makan + $pegawai->golongan->tunjangan_transport, 0, ',', '.') }}</strong>
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Riwayat Komponen Gaji -->
            @if($pegawai->komponenGaji->count() > 0)
                <div class="card mb-3">
                    <div class="card-header bg-light">
                        <strong><i class="fas fa-history"></i> Riwayat Komponen Gaji</strong>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Bulan</th>
                                        <th>Tahun</th>
                                        <th>Gaji Pokok</th>
                                        <th>Tunjangan</th>
                                        <th>Potongan</th>
                                        <th>Gaji Bersih</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pegawai->komponenGaji as $komponen)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $komponen->bulan }}</td>
                                            <td>{{ $komponen->tahun }}</td>
                                            <td>Rp {{ number_format($komponen->gaji_pokok, 0, ',', '.') }}</td>
                                            <td>Rp {{ number_format($komponen->total_tunjangan, 0, ',', '.') }}</td>
                                            <td>Rp {{ number_format($komponen->total_potongan, 0, ',', '.') }}</td>
                                            <td><strong class="text-success">Rp {{ number_format($komponen->gaji_bersih, 0, ',', '.') }}</strong></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @else
                <div class="alert alert-secondary">
                    <i class="fas fa-info-circle"></i> Belum ada riwayat komponen gaji untuk pegawai ini.
                </div>
            @endif

            <!-- Tombol Aksi -->
            <div class="d-flex justify-content-between mt-3">
                <a href="{{ route('pegawai.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                </a>
                <div>
                    <a href="{{ route('pegawai.edit', $pegawai->id) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit Pegawai
                    </a>
                    @if($pegawai->komponenGaji->count() == 0)
                        <form action="{{ route('pegawai.destroy', $pegawai->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus pegawai ini?')">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </form>
                    @else
                        <button class="btn btn-secondary" disabled title="Tidak bisa dihapus karena memiliki riwayat gaji">
                            <i class="fas fa-trash"></i> Hapus (Terikat)
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection