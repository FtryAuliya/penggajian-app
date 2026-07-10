@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<div class="row">
<div class="col-md-4 mb-3">
<div class="card text-white bg-primary shadow">
<div class="card-body">
<div class="d-flex justify-content-between align-items-center">
<div>
<h6 class="card-title">Total Pegawai</h6>
<h2 class="display-4">{{ $totalPegawai }}</h2>
</div>
<i class="fas fa-users fa-3x opacity-50"></i>
</div>
</div>
</div>
</div>
<div class="col-md-4 mb-3">
<div class="card text-white bg-success shadow">
<div class="card-body">
<div class="d-flex justify-content-between align-items-center">
<div>
<h6 class="card-title">Total Golongan</h6>
<h2 class="display-4">{{ $totalGolongan }}</h2>
</div>
<i class="fas fa-layer-group fa-3x opacity-50"></i>
</div>
</div>
</div>
</div>
<div class="col-md-4 mb-3">
<div class="card text-white bg-info shadow">
<div class="card-body">
<div class="d-flex justify-content-between align-items-center">
<div>
<h6 class="card-title">Pegawai Aktif</h6>
<h2 class="display-4">{{ $aktif }}</h2>
</div>
<i class="fas fa-user-check fa-3x opacity-50"></i>
</div>
</div>
</div>
</div>
</div>
<div class="row mt-4">
<div class="col-md-6">
<div class="card shadow">
<div class="card-header bg-secondary text-white">
<i class="fas fa-chart-simple"></i> Menu Cepat
</div>
<div class="card-body">
<div class="d-grid gap-2">
<a href="{{ route('pegawai.index') }}" class="btn btn-outline-primary">
<i class="fas fa-users"></i> Kelola Pegawai
</a>
<a href="{{ route('golongan.index') }}" class="btn btn-outline-success">
<i class="fas fa-layer-group"></i> Kelola Golongan
</a>
</div>
</div>
</div>
</div>
<div class="col-md-6">
<div class="card shadow">
<div class="card-header bg-secondary text-white">
<i class="fas fa-info-circle"></i> Informasi
</div>
<div class="card-body">
<p>Aplikasi Penggajian ini digunakan untuk mengelola:</p>
<ul>
<li>Data Pegawai</li>
<li>Data Golongan dan Komponen Gaji</li>
<li>Proses Penggajian Bulanan</li>
<li>Laporan-Laporan Penggajian</li>
</ul>
</div>
</div>
</div>
</div>
@endsection