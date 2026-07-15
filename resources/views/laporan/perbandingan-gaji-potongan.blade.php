@extends('layouts.app')
@section('title', 'Perbandingan Gaji Pokok & Potongan')
@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-chart-line"></i> Perbandingan Gaji Pokok vs Potongan
                per Golongan</h5>
            <a href="{{ route('laporan.index') }}" class="btn btn-light btn-sm">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
        <div class="card-body">
            <!-- Ringkasan -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card bg-light">
                        <div class="card-body text-center">
                            <h6>Rata-rata Gaji Pokok</h6>
                            <h3 class="text-success">Rp {{ number_format($totalRataGaji, 0, ',', '.') }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-light">
                        <div class="card-body text-center">
                            <h6>Rata-rata Potongan</h6>
                            <h3 class="text-danger">Rp {{ number_format($totalRataPotongan, 0, ',', '.') }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-light">
                        <div class="card-body text-center">
                            <h6>Persentase Potongan</h6>
                            <h3 class="text-warning">{{ number_format($persentasePotongan, 1) }}%</h3>
                            <small>dari gaji pokok</small>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Grafik Perbandingan -->
            <div class="mb-4">
                <canvas id="perbandinganChart" height="100"></canvas>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">No</th>
                            <th>Golongan</th>
                            <th>Jumlah Pegawai</th>
                            <th>Rata-rata Gaji Pokok</th>
                            <th>Rata-rata Potongan</th>
                            <th>Selisih</th>
                            <th>Efektivitas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($perbandingan as $key => $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <span class="badge bg-info">{{ $item->golongan->kode }}</span>
                                    <br><small>{{ $item->golongan->nama_golongan }}</small>
                                </td>
                                <td class="text-center">{{ $item->jumlah_pegawai }} orang</td>
                                <td class="text-success">Rp {{ number_format($item->rata_gaji_pokok, 0, ',', '.') }}</td>
                                <td class="text-danger">Rp {{ number_format($item->rata_potongan, 0, ',', '.') }}</td>
                                <td>
                                    @php $selisih = $item->rata_gaji_pokok - $item->rata_potongan; @endphp
                                    Rp {{ number_format($selisih, 0, ',', '.') }}
                                </td>
                                <td>
                                    @php
                                        $efektivitas =
                                            $item->rata_gaji_pokok > 0
                                                ? (($item->rata_gaji_pokok - $item->rata_potongan) /
                                                        $item->rata_gaji_pokok) *
                                                    100
                                                : 0;
                                    @endphp
                                    <div class="progress">
                                        <div class="progress-bar bg-success" style="width: {{ $efektivitas }}%">
                                            {{ number_format($efektivitas, 1) }}%
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('perbandinganChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($chartLabels),
                datasets: [{
                        label: 'Rata-rata Gaji Pokok',
                        data: @json($chartGajiPokok),
                        backgroundColor: 'rgba(40, 167, 69, 0.7)',
                        borderColor: '#28a745',
                        borderWidth: 1
                    },
                    {
                        label: 'Rata-rata Potongan',
                        data: @json($chartPotongan),
                        backgroundColor: 'rgba(220, 53, 69, 0.7)',
                        borderColor: '#dc3545',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Jumlah (Rp)'
                        },
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Golongan'
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
