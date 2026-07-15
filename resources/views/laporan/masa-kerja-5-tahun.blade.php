@extends('layouts.app')
@section('title', 'Pegawai Masa Kerja > 5 Tahun')
@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-info text-white d-flex justify-content-between align-itemscenter">
            <h5 class="mb-0"><i class="fas fa-calendar-alt"></i> Pegawai dengan Masa Kerja > 5
                Tahun</h5>
            <a href="{{ route('laporan.index') }}" class="btn btn-light btn-sm">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
        <div class="card-body">
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i>
                Menampilkan pegawai aktif yang telah bekerja lebih dari 5 tahun.
                <strong>Total: {{ count($data) }} pegawai</strong>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">No</th>
                            <th>NIP</th>
                            <th>Nama Pegawai</th>
                            <th>Departemen</th>
                            <th>Golongan</th>
                            <th>Tanggal Masuk</th>
                            <th>Masa Kerja</th>
                            <th>Gaji Terakhir</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $key => $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->pegawai->nip }}</td>
                                <td>
                                    <strong>{{ $item->pegawai->nama }}</strong>
                                </td>
                                <td>{{ $item->pegawai->departemen }}</td>
                                <td>{{ $item->pegawai->golongan->kode }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->tanggal_masuk)->format('d-m-Y') }}</td>
                                <td>
                                    <span class="badge bg-success">
                                        {{ $item->masa_kerja_tahun }} tahun
                                        @if ($item->masa_kerja_bulan > 0)
                                            {{ $item->masa_kerja_bulan }} bulan
                                        @endif
                                    </span>
                                </td>
                                <td class="text-success">
                                    Rp {{ number_format($item->gaji_terakhir, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <i class="fas fa-database fa-2x text-muted mb-2 d-block"></i>
                                    Tidak ada pegawai dengan masa kerja > 5 tahun
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- Statistik Ringkasan -->
            @if (count($data) > 0)
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6><i class="fas fa-chart-bar"></i> Statistik Masa Kerja</h6>
                                <hr>
                                @php
                                    $totalTahun = collect($data)->sum('masa_kerja_tahun');
                                    $rataTahun = $totalTahun / count($data);
                                @endphp
                                <p>Rata-rata masa kerja: <strong>{{ number_format($rataTahun, 1) }}
                                        tahun</strong></p>
                                <p>Pegawai terlama:
                                    <strong>{{ $data[0]->pegawai->nama }}</strong>
                                    ({{ $data[0]->masa_kerja_tahun }} tahun)
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6><i class="fas fa-building"></i> Per Departemen</h6>
                                <hr>
                                @php
                                    $deptCount = collect($data)
                                        ->groupBy(function ($item) {
                                            return $item->pegawai->departemen;
                                        })
                                        ->map->count();
                                @endphp
                                <ul>
                                    @foreach ($deptCount as $dept => $count)
                                        <li>{{ $dept }}: {{ $count }} pegawai</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
