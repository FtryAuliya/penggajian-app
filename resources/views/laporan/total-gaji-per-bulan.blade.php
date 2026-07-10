@extends('layouts.app')
@section('title', 'Total Gaji per Bulan')
@section('content')
    <div class="card shadow-sm">

        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-
center">

            <h5 class="mb-0"><i class="fas fa-chart-bar"></i> Total Gaji per Bulan</h5>
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
                <canvas id="gajiChart" height="100"></canvas>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">No</th>
                            <th>Periode</th>
                            <th>Jumlah Transaksi</th>
                            <th>Total Gaji</th>
                            <th>Rata-rata Gaji</th>
                            <th>Total Potongan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $key => $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><strong>{{ $bulanList[$item->bulan] }} {{ $item->tahun }}</strong></td>
                                <td class="text-center">{{ $item->jumlah_transaksi }} pegawai</td>
                                <td class="text-success fw-bold">Rp {{ number_format($item->total_gaji, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($item->rata_rata_gaji, 0, ',', '.') }}</td>
                                <td class="text-danger">Rp {{ number_format($item->total_potongan, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
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
        const ctx = document.getElementById('gajiChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($chartLabels),
                datasets: [{
                    label: 'Total Gaji (Rp)',
                    data: @json($chartData),
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
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
                                return 'Total: Rp ' + context.raw.toLocaleString('id-ID');
                            }
                        }
                    }
                }
            }
        });
    </script>
@endpush
