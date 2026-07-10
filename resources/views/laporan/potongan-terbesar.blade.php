@extends('layouts.app')
@section('title', 'Potongan Terbesar per Pegawai')
@section('content')
    <div class="card shadow-sm">

        <div class="card-header bg-danger text-white d-flex justify-content-between align-items-
center">

            <h5 class="mb-0"><i class="fas fa-minus-circle"></i> Potongan Terbesar per
                Pegawai</h5>
            <a href="{{ route('laporan.index') }}" class="btn btn-light btn-sm">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
        <div class="card-body">
            <!-- Filter Periode -->
            <form method="GET" class="row mb-4">
                <div class="col-md-2">
                    <select name="bulan" class="form-select">
                        <option value="">Semua Bulan</option>
                        @foreach ($bulanList as $key => $nama)
                            <option value="{{ $key }}" {{ request('bulan') == $key ? 'selected' : '' }}>
                                {{ $nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="tahun" class="form-select">
                        <option value="">Semua Tahun</option>
                        @foreach ($tahunList as $tahun)
                            <option value="{{ $tahun }}" {{ request('tahun') == $tahun ? 'selected' : '' }}>
                                {{ $tahun }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                </div>
            </form>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">No</th>
                            <th>Pegawai</th>
                            <th>Departemen</th>
                            <th>Periode</th>
                            <th>Potongan Absensi</th>
                            <th>Potongan Lainnya</th>
                            <th>Total Potongan</th>
                            <th>Gaji Bersih</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $key => $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <strong>{{ $item->pegawai->nama }}</strong><br>
                                    <small class="text-muted">{{ $item->pegawai->nip }}</small>
                                </td>
                                <td>{{ $item->pegawai->departemen }}</td>
                                <td>{{ $bulanList[$item->bulan] }} {{ $item->tahun }}</td>
                                <td>Rp {{ number_format($item->potongan_absensi, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($item->potongan_lainnya, 0, ',', '.') }}</td>
                                <td class="text-danger fw-bold">Rp {{ number_format($item->total_potongan, 0, ',', '.') }}
                                </td>
                                <td class="text-success">Rp {{ number_format($item->gaji_bersih, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <i class="fas fa-database fa-2x text-muted mb-2 d-block"></i>
                                    Belum ada data
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
