@extends('layouts.app')
@section('title', 'Rekap Tunjangan Makan & Transport')
@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-utensils"></i> Rekap Tunjangan Makan & Transport per
                Bulan</h5>
            <a href="{{ route('laporan.index') }}" class="btn btn-light btn-sm">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
        <div class="card-body">
            <!-- Filter Tahun -->
            <form method="GET" class="row mb-4">
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
            <!-- Grafik -->
            <div class="mb-4">
                <canvas id="tunjanganChart" height="100"></canvas>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">No</th>
                            <th>Periode</th>
                            <th>Jumlah Pegawai</th>
                            <th>Total Tunjangan Makan</th>
                            <th>Total Tunjangan Transport</th>
                            <th>Total Tunjangan Lainnya</th>
                            <th>Total Keseluruhan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $key => $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><strong>{{ $bulanList[$item->bulan] }} {{ $item->tahun }}</strong></td>
                                <td class="text-center">{{ $item->jumlah_pegawai }} pegawai</td>
                                <td class="text-success">Rp {{ number_format($item->total_tunjangan_makan, 0, ',', '.') }}
                                </td>
                                <td class="text-info">Rp {{ number_format($item->total_tunjangan_transport, 0, ',', '.') }}
                                </td>
                                <td class="text-warning">Rp
                                    {{ number_format($item->total_tunjangan_lainnya, 0, ',', '.') }}
                                </td>
                                <td class="fw-bold">
                                    Rp
                                    {{ number_format($item->total_tunjangan_makan + $item->total_tunjangan_transport + $item->total_tunjangan_lainnya, 0, ',', '.') }}
                                </td>
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
                </table>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('tunjanganChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($chartBulan),
                datasets: [{
                        label: 'Tunjangan Makan',
                        data: @json($chartMakan),
                        borderColor: '#28a745',
                        backgroundColor: 'rgba(40, 167, 69, 0.1)',
                        fill: true,
                        tension: 0.4
                    },
                    {
                        label: 'Tunjangan Transport',
                        data: @json($chartTransport),
                        borderColor: '#17a2b8',
                        backgroundColor: 'rgba(23, 162, 184, 0.1)',
                        fill: true,
                        tension: 0.4
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': Rp ' + context.raw.toLocaleString('id-ID');
                            }
                        }
                    }
                }
            }
        });
    </script>
@endpush
