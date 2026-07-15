@extends('layouts.app')
@section('title', 'Menu Laporan')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-chart-line"></i> Laporan Penggajian</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <i class="fas fa-receipt fa-3x text-info mb-3"></i>
                                    <h5>Slip Gaji Pegawai</h5>
                                    <p class="text-muted">Detail gaji per pegawai per periode</p>
                                    <a href="{{ route('laporan.slip-gaji') }}" class="btn btn-info">
                                        <i class="fas fa-eye"></i> Lihat Laporan
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <i class="fas fa-building fa-3x text-success mb-3"></i>
                                    <h5>Rekap Gaji per Departemen</h5>
                                    <p class="text-muted">Total gaji per departemen</p>
                                    <a href="{{ route('laporan.rekap-departemen') }}" class="btn btn-success">
                                        <i class="fas fa-eye"></i> Lihat Laporan
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <i class="fas fa-arrow-up fa-3x text-warning mb-3"></i>
                                    <h5>Gaji di Atas Rata-rata</h5>
                                    <p class="text-muted">Pegawai dengan gaji > rata-rata</p>
                                    <a href="{{ route('laporan.gaji-diatas-rata') }}" class="btn btn-warning">
                                        <i class="fas fa-eye"></i> Lihat Laporan
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <i class="fas fa-minus-circle fa-3x text-danger mb-3"></i>
                                    <h5>Potongan Terbesar</h5>
                                    <p class="text-muted">Potongan terbesar per pegawai</p>
                                    <a href="{{ route('laporan.potongan-terbesar') }}" class="btn btn-danger">
                                        <i class="fas fa-eye"></i> Lihat Laporan
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <i class="fas fa-chart-bar fa-3x text-primary mb-3"></i>
                                    <h5>Total Gaji per Bulan</h5>
                                    <p class="text-muted">Grafik total gaji per bulan</p>
                                    <a href="{{ route('laporan.total-gaji-per-bulan') }}" class="btn btn-primary">
                                        <i class="fas fa-eye"></i> Lihat Laporan
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="card h-100 bg-light">
                                <div class="card-body text-center">
                                    <i class="fas fa-calendar-alt fa-3x text-info mb-3"></i>
                                    <h5>Masa Kerja > 5 Tahun</h5>
                                    <p class="text-muted">Pegawai dengan pengalaman > 5 tahun</p>
                                    <a href="{{ route('laporan.masa-kerja-5-tahun') }}" class="btn btn-info">
                                        <i class="fas fa-eye"></i> Lihat Laporan
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="card h-100 bg-light">
                                <div class="card-body text-center">
                                    <i class="fas fa-trophy fa-3x text-warning mb-3"></i>
                                    <h5>Urutan Gaji Tertinggi</h5>
                                    <p class="text-muted">Top 10 pegawai dengan gaji tertinggi</p>
                                    <a href="{{ route('laporan.urutan-gaji-bersih') }}" class="btn btn-warning">
                                        <i class="fas fa-eye"></i> Lihat Laporan
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="card h-100 bg-light">
                                <div class="card-body text-center">
                                    <i class="fas fa-chart-pie fa-3x text-success mb-3"></i>
                                    <h5>Jumlah Pegawai per Golongan</h5>
                                    <p class="text-muted">Distribusi pegawai berdasarkan golongan</p>
                                    <a href="{{ route('laporan.jumlah-pegawai-per-golongan') }}" class="btn btn-success">
                                        <i class="fas fa-eye"></i> Lihat Laporan
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="card h-100 bg-light">
                                <div class="card-body text-center">
                                    <i class="fas fa-utensils fa-3x text-primary mb-3"></i>
                                    <h5>Rekap Tunjangan</h5>
                                    <p class="text-muted">Total tunjangan makan & transport per bulan</p>
                                    <a href="{{ route('laporan.rekap-tunjangan') }}" class="btn btn-primary">
                                        <i class="fas fa-eye"></i> Lihat Laporan
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="card h-100 bg-light">
                                <div class="card-body text-center">
                                    <i class="fas fa-chart-line fa-3x text-danger mb-3"></i>
                                    <h5>Perbandingan Gaji & Potongan</h5>
                                    <p class="text-muted">Perbandingan per golongan</p>
                                    <a href="{{ route('laporan.perbandingan-gaji-potongan') }}" class="btn btndanger">
                                        <i class="fas fa-eye"></i> Lihat Laporan
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
