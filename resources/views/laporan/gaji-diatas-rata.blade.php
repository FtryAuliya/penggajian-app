@extends('layouts.app')
@section('title', 'Pegawai dengan Gaji di Atas Rata-rata')
@section('content')
    <div class="card shadow-sm">

        <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-
center">

            <h5 class="mb-0"><i class="fas fa-arrow-up"></i> Pegawai dengan Gaji di Atas Rata-
                rata</h5>

            <a href="{{ route('laporan.index') }}" class="btn btn-light btn-sm">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
        <div class="card-body">
            <!-- Informasi Rata-rata -->
            <div class="alert alert-info">
                <i class="fas fa-chart-line"></i> Rata-rata gaji seluruh pegawai:
                <strong>Rp {{ number_format($rataRata, 0, ',', '.') }}</strong>
            </div>
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
                            <th>Gaji Bersih</th>
                            <th>Selisih dari Rata-rata</th>
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
                                <td class="text-success fw-bold">Rp {{ number_format($item->gaji_bersih, 0, ',', '.') }}
                                </td>
                                <td class="text-info">
                                    + Rp {{ number_format($item->gaji_bersih - $rataRata, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <i class="fas fa-database fa-2x text-muted mb-2 d-block"></i>
                                    Tidak ada data pegawai dengan gaji di atas rata-rata
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
