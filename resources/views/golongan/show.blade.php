@extends('layouts.app')

@section('title', 'Detail Golongan')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-layer-group"></i> Detail Golongan</h5>
            <div>
                <a href="{{ route('golongan.edit', $golongan->id) }}" class="btn btn-light btn-sm">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <a href="{{ route('golongan.index') }}" class="btn btn-light btn-sm">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <!-- Informasi Golongan -->
                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-header bg-light">
                            <strong><i class="fas fa-info-circle"></i> Informasi Golongan</strong>
                        </div>
                        <div class="card-body">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="35%">Kode Golongan</th>
                                    <td>: <span class="badge bg-info">{{ $golongan->kode }}</span></td>
                                </tr>
                                <tr>
                                    <th>Nama Golongan</th>
                                    <td>: {{ $golongan->nama_golongan }}</td>
                                </tr>
                                <tr>
                                    <th>Keterangan</th>
                                    <td>: {{ $golongan->keterangan ?: '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Dibuat pada</th>
                                    <td>: {{ $golongan->created_at ? $golongan->created_at->format('d-m-Y H:i:s') : '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Terakhir diupdate</th>
                                    <td>: {{ $golongan->updated_at ? $golongan->updated_at->format('d-m-Y H:i:s') : '-' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Komponen Gaji -->
                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-header bg-light">
                            <strong><i class="fas fa-chart-line"></i> Komponen Gaji</strong>
                        </div>
                        <div class="card-body">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="40%">Gaji Pokok</th>
                                    <td>: <strong class="text-success">Rp {{ number_format($golongan->gaji_pokok, 0, ',', '.') }}</strong></td>
                                </tr>
                                <tr>
                                    <th>Tunjangan Makan</th>
                                    <td>: Rp {{ number_format($golongan->tunjangan_makan, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th>Tunjangan Transport</th>
                                    <td>: Rp {{ number_format($golongan->tunjangan_transport, 0, ',', '.') }}</td>
                                </tr>
                                <tr class="border-top">
                                    <th>Total Tunjangan</th>
                                    <td>: <strong>Rp {{ number_format($golongan->tunjangan_makan + $golongan->tunjangan_transport, 0, ',', '.') }}</strong></td>
                                </tr>
                                <tr>
                                    <th>Total Gaji (Pokok + Tunjangan)</th>
                                    <td>: <strong class="text-success fs-5">Rp {{ number_format($golongan->gaji_pokok + $golongan->tunjangan_makan + $golongan->tunjangan_transport, 0, ',', '.') }}</strong></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistik Pegawai -->
            <div class="row">
                <div class="col-md-4">
                    <div class="card text-white bg-primary mb-3">
                        <div class="card-body text-center">
                            <h1 class="display-4">{{ $golongan->pegawai->count() }}</h1>
                            <p class="mb-0">Jumlah Pegawai</p>
                        </div>
                    </div>
                </div>

                @php
                    $totalGajiDibayarkan = $golongan->pegawai->sum(function($pegawai) {
                        return $pegawai->komponenGaji()->sum('gaji_bersih');
                    });
                    $rataGaji = $golongan->pegawai->count() > 0 ? $totalGajiDibayarkan / $golongan->pegawai->count() : 0;
                @endphp

                <div class="col-md-4">
                    <div class="card text-white bg-success mb-3">
                        <div class="card-body text-center">
                            <h5 class="mb-0">Total Gaji Dibayarkan</h5>
                            <h3 class="mt-2">Rp {{ number_format($totalGajiDibayarkan, 0, ',', '.') }}</h3>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card text-white bg-info mb-3">
                        <div class="card-body text-center">
                            <h5 class="mb-0">Rata-rata Gaji per Pegawai</h5>
                            <h3 class="mt-2">Rp {{ number_format($rataGaji, 0, ',', '.') }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Daftar Pegawai dalam Golongan ini -->
            @if($golongan->pegawai->count() > 0)
                <div class="card mt-3">
                    <div class="card-header bg-light">
                        <strong><i class="fas fa-users"></i> Daftar Pegawai dalam Golongan {{ $golongan->kode }}</strong>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>NIP</th>
                                        <th>Nama Pegawai</th>
                                        <th>Departemen</th>
                                        <th>Jabatan</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($golongan->pegawai as $key => $pegawai)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $pegawai->nip }}</td>
                                            <td>{{ $pegawai->nama }}</td>
                                            <td>{{ $pegawai->departemen }}</td>
                                            <td>{{ $pegawai->jabatan }}</td>
                                            <td>
                                                @if($pegawai->status == 'aktif')
                                                    <span class="badge bg-success">Aktif</span>
                                                @else
                                                    <span class="badge bg-danger">Nonaktif</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('pegawai.show', $pegawai->id) }}" class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @else
                <div class="alert alert-secondary mt-3">
                    <i class="fas fa-info-circle"></i> Belum ada pegawai yang memiliki golongan ini.
                </div>
            @endif

            <!-- Tombol Aksi -->
            <div class="d-flex justify-content-between mt-3">
                <a href="{{ route('golongan.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <div>
                    <a href="{{ route('golongan.edit', $golongan->id) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit Golongan
                    </a>
                    @if($golongan->pegawai->count() == 0)
                        <form action="{{ route('golongan.destroy', $golongan->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus?')">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </form>
                    @else
                        <button class="btn btn-secondary" disabled title="Tidak bisa dihapus karena masih ada pegawai">
                            <i class="fas fa-trash"></i> Hapus (Terikat)
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection