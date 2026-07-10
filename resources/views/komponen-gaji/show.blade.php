@extends('layouts.app')
@section('title', 'Detail Penggajian')
@section('content')
    <div class="card shadow-sm">

        <div class="card-header bg-info text-white d-flex justify-content-between align-items-
center">

            <h5 class="mb-0"><i class="fas fa-receipt"></i> Detail Slip Gaji</h5>
            <div>
                <a href="{{ route('komponen-gaji.edit', $komponenGaji->id) }}" class="btn btn-light
btn-sm">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <a href="{{ route('komponen-gaji.index') }}" class="btn btn-light btn-sm">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Data Pegawai -->
                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-header bg-light">
                            <strong><i class="fas fa-user"></i> Data Pegawai</strong>
                        </div>
                        <div class="card-body">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="35%">NIP</th>
                                    <td>: {{ $komponenGaji->pegawai->nip }}</td>
                                </tr>
                                <tr>
                                    <th>Nama</th>
                                    <td>: {{ $komponenGaji->pegawai->nama }}</td>
                                </tr>
                                <tr>
                                    <th>Departemen</th>
                                    <td>: {{ $komponenGaji->pegawai->departemen }}</td>
                                </tr>
                                <tr>
                                    <th>Jabatan</th>
                                    <td>: {{ $komponenGaji->pegawai->jabatan }}</td>
                                </tr>
                                <tr>
                                    <th>Golongan</th>
                                    <td>: {{ $komponenGaji->pegawai->golongan->kode }}
                                        - {{ $komponenGaji->pegawai->golongan->nama_golongan }}</td>
                                </tr>
                                <tr>
                                    <th>Periode Gaji</th>
                                    <td>: {{ $komponenGaji->nama_bulan }} {{ $komponenGaji->tahun }}</td>
                                </tr>

                                <tr>
                                    <th>Tanggal Gaji</th>
                                    <td>: {{ $komponenGaji->tanggal_gaji->format('d-
                                    m-Y') }}</td>
                                </tr>

                                <tr>
                                    <th>Status</th>
                                    <td>:
                                        @if ($komponenGaji->status == 'selesai')
                                            <span class="badge bg-success">Selesai</span>
                                        @elseif($komponenGaji->status == 'diproses')
                                            <span class="badge bg-warning">Diproses</span>
                                        @else
                                            <span class="badge bg-secondary">Draft</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- Rincian Gaji -->
                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-header bg-light">
                            <strong><i class="fas fa-chart-line"></i> Rincian Gaji</strong>
                        </div>
                        <div class="card-body">
                            <table class="table table-borderless">
                                <tr>
                                    <th>Gaji Pokok</th>
                                    <td class="text-end">Rp {{ number_format($komponenGaji->gaji_pokok, 0, ',', '.') }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Tunjangan Makan</th>
                                    <td class="text-end">Rp
                                        {{ number_format($komponenGaji->tunjangan_makan, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th>Tunjangan Transport</th>
                                    <td class="text-end">Rp
                                        {{ number_format($komponenGaji->tunjangan_transport, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th>Tunjangan Lainnya</th>
                                    <td class="text-end text-success">+ Rp
                                        {{ number_format($komponenGaji->tunjangan_lainnya, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th><strong>Total Tunjangan</strong></th>
                                    <td class="text-end text-success"><strong>Rp
                                            {{ number_format($totalTunjangan, 0, ',', '.') }}</strong></td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <hr>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Potongan Absensi</th>
                                    <td class="text-end text-danger">- Rp
                                        {{ number_format($komponenGaji->potongan_absensi, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th>Potongan Lainnya</th>
                                    <td class="text-end text-danger">- Rp
                                        {{ number_format($komponenGaji->potongan_lainnya, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th><strong>Total Potongan</strong></th>
                                    <td class="text-end text-danger"><strong>- Rp
                                            {{ number_format($komponenGaji->total_potongan, 0, ',', '.') }}</strong></td>
                                </tr>
                                <tr class="border-top">
                                    <th><strong>GAJI BERSIH</strong></th>
                                    <td class="text-end"><strong class="text-success fs-4">Rp
                                            {{ number_format($komponenGaji->gaji_bersih, 0, ',', '.') }}</strong></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Progress Bar Potongan -->
            <div class="card mb-3">
                <div class="card-header bg-light">
                    <strong><i class="fas fa-chart-pie"></i> Analisis Potongan</strong>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label>Persentase Potongan terhadap Gaji Pokok:</label>
                            <div class="progress" style="height: 30px;">
                                <div class="progress-bar bg-danger" style="width: {{ $persentasePotongan }}%;">
                                    {{ number_format($persentasePotongan, 1) }}%
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label>Efektivitas Gaji (Bersih/Pokok):</label>
                            <div class="progress" style="height: 30px;">
                                <div class="progress-bar bg-success" style="width: {{ 100 - $persentasePotongan }}%;">
                                    {{ number_format(100 - $persentasePotongan, 1) }}%
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <a href="{{ route('komponen-gaji.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <button type="button" class="btn btn-success" onclick="window.print()">
                    <i class="fas fa-print"></i> Cetak Slip
                </button>
            </div>
        </div>
    </div>
@endsection
@push('styles')
    <style media="print">
        .btn,
        nav,
        footer,
        .card-header .btn,
        .d-flex .btn {
            display: none !important;
        }

        .card {
            border: none !important;
        }

        body {
            padding: 0 !important;
            margin: 0 !important;
        }
    </style>
@endpush
