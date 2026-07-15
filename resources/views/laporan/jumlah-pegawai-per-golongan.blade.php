@extends('layouts.app')
@section('title', 'Jumlah Pegawai per Golongan')
@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-success text-white d-flex justify-content-between align-itemscenter">
            <h5 class="mb-0"><i class="fas fa-chart-pie"></i> Jumlah Pegawai per Golongan</h5>
            <a href="{{ route('laporan.index') }}" class="btn btn-light btn-sm">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>Kode</th>
                                    <th>Nama Golongan</th>
                                    <th class="text-center">Jumlah Pegawai</th>
                                    <th class="text-center">Persentase</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $totalPegawai = $data->sum('pegawai_count');
                                @endphp
                                @foreach ($data as $item)
                                    <tr>
                                        <td><span class="badge bg-info">{{ $item->kode }}</span></td>
                                        <td>{{ $item->nama_golongan }}</td>
                                        <td class="text-center fw-bold">{{ $item->pegawai_count }} orang</td>
                                        <td class="text-center">
                                            @if ($totalPegawai > 0)
                                                {{ round(($item->pegawai_count / $totalPegawai) * 100, 1) }}%
                                            @else
                                                0%
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-secondary">
                                <tr>
                                    <th colspan="2">TOTAL</th>
                                    <th class="text-center">{{ $totalPegawai }} orang</th>
                                    <th class="text-center">100%</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="col-md-6">
                    <!-- Pie Chart -->
                    <canvas id="golonganChart" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('golonganChart').getContext('2d');
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: @json($chartLabels),
                datasets: [{
                    data: @json($chartData),
                    backgroundColor: [
                        '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0',
                        '#9966FF', '#FF9F40', '#C9CBCF', '#7C9D8E'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.raw || 0;
                                const total = @json($totalPegawai);
                                const percentage = ((value / total) * 100).toFixed(1);
                                return `${label}: ${value} pegawai (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });
    </script>
@endpush
