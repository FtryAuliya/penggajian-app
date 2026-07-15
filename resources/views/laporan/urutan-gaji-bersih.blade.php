@extends('layouts.app')
@section('title', 'Urutan Gaji Bersih Tertinggi')
@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-warning text-dark d-flex justify-content-between align-itemscenter">
            <h5 class="mb-0"><i class="fas fa-trophy"></i> Top 10 Gaji Bersih Tertinggi</h5>
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
                            <th width="5%">Peringkat</th>
                            <th>Pegawai</th>
                            <th>Departemen</th>
                            <th>Golongan</th>
                            <th>Periode</th>
                            <th>Gaji Bersih</th>
                            <th>Potongan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $item)
                            <tr>
                                <td class="text-center">
                                    @if ($item->peringkat == 1)
                                        <span class="badge bg-warning fs-6"> #1</span>
                                    @elseif($item->peringkat == 2)
                                        <span class="badge bg-secondary fs-6"> #2</span>
                                    @elseif($item->peringkat == 3)
                                        <span class="badge bg-danger fs-6"> #3</span>
                                    @else
                                        <span class="badge bg-info">#{{ $item->peringkat }}</span>
                                    @endif
                                </td>
                                <td>
                                    <strong>{{ $item->pegawai->nama }}</strong><br>
                                    <small class="text-muted">{{ $item->pegawai->nip }}</small>
                                </td>
                                <td>{{ $item->pegawai->departemen }}</td>
                                <td><span class="badge bg-info">{{ $item->pegawai->golongan->kode }}</span></td>
                                <td>{{ $bulanList[$item->bulan] }} {{ $item->tahun }}</td>
                                <td class="fw-bold text-success fs-5">
                                    Rp {{ number_format($item->gaji_bersih, 0, ',', '.') }}
                                </td>
                                <td class="text-danger">
                                    Rp {{ number_format($item->total_potongan, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <i class="fas fa-database fa-2x text-muted mb-2 d-block"></i>
                                    Belum ada data penggajian
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
