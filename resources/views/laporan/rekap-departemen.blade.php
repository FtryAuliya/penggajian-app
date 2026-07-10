@extends('layouts.app')
@section('title', 'Rekap Gaji per Departemen')
@section('content')
    <div class="card shadow-sm">

        <div class="card-header bg-success text-white d-flex justify-content-between align-items-
center">

            <h5 class="mb-0"><i class="fas fa-building"></i> Rekap Gaji per Departemen</h5>
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
                            <th>Departemen</th>
                            <th>Jumlah Pegawai</th>
                            <th>Total Gaji</th>
                            <th>Rata-rata Gaji</th>
                            <th>Gaji Tertinggi</th>
                            <th>Gaji Terendah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $key => $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><strong>{{ $item->departemen }}</strong></td>
                                <td class="text-center">{{ $item->jumlah_pegawai }} orang</td>
                                <td class="text-success fw-bold">Rp {{ number_format($item->total_gaji, 0, ',', '.') }}
                                </td>
                                <td>Rp {{ number_format($item->rata_rata_gaji, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($item->gaji_tertinggi, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($item->gaji_terendah, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <i class="fas fa-database fa-2x text-muted mb-2 d-block"></i>
                                    Belum ada data
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot class="table-secondary">
                        <tr>
                            <th colspan="3" class="text-end">TOTAL KESELURUHAN:</th>
                            <th class="text-success">Rp {{ number_format($data->sum('total_gaji'), 0, ',', '.') }}</th>
                            <th colspan="3"></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection
