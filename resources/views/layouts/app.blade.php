<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Aplikasi Penggajian - @yield('title', 'Dashboard')</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    @stack('styles')
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                <i class="fas fa-money-bill-wave"></i> Aplikasi Penggajian
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                            <i class="fas fa-home"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pegawai.*') ? 'active' : '' }}" href="{{ route('pegawai.index') }}">
                            <i class="fas fa-users"></i> Pegawai
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('golongan.*') ? 'active' : '' }}" href="{{ route('golongan.index') }}">
                            <i class="fas fa-layer-group"></i> Golongan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('komponen-gaji.*') ? 'active' : '' }}" href="{{ route('komponen-gaji.index') }}">
                            <i class="fas fa-calculator"></i> Penggajian
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->routeIs('laporan.*') ? 'active' : '' }}" href="#" id="laporanDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-chart-line"></i> Laporan
                        </a>
                        <ul class="dropdown-menu">
                            <li><h6 class="dropdown-header">Laporan Dasar</h6></li>
                            <li><a class="dropdown-item" href="{{ route('laporan.slip-gaji') }}">
                                <i class="fas fa-receipt"></i> Slip Gaji</a>
                            </li>
                            <li><a class="dropdown-item" href="{{ route('laporan.rekap-departemen') }}">
                                <i class="fas fa-building"></i> Rekap per Departemen</a>
                            </li>
                            <li><a class="dropdown-item" href="{{ route('laporan.gaji-diatas-rata') }}">
                                <i class="fas fa-arrow-up"></i> Gaji > Rata-rata</a>
                            </li>
                            <li><a class="dropdown-item" href="{{ route('laporan.potongan-terbesar') }}">
                                <i class="fas fa-minus-circle"></i> Potongan Terbesar</a>
                            </li>
                            <li><a class="dropdown-item" href="{{ route('laporan.total-gaji-per-bulan') }}">
                                <i class="fas fa-chart-bar"></i> Total Gaji per Bulan</a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li><h6 class="dropdown-header">Laporan Lanjutan</h6></li>
                            <li><a class="dropdown-item" href="{{ route('laporan.masa-kerja-5-tahun') }}">
                                <i class="fas fa-calendar-alt"></i> Masa Kerja > 5 Tahun</a>
                            </li>
                            <li><a class="dropdown-item" href="{{ route('laporan.urutan-gaji-bersih') }}">
                                <i class="fas fa-trophy"></i> Urutan Gaji Tertinggi</a>
                            </li>
                            <li><a class="dropdown-item" href="{{ route('laporan.jumlah-pegawai-per-golongan') }}">
                                <i class="fas fa-chart-pie"></i> Jumlah per Golongan</a>
                            </li>
                            <li><a class="dropdown-item" href="{{ route('laporan.rekap-tunjangan') }}">
                                <i class="fas fa-utensils"></i> Rekap Tunjangan</a>
                            </li>
                            <li><a class="dropdown-item" href="{{ route('laporan.perbandingan-gaji-potongan') }}">
                                <i class="fas fa-chart-line"></i> Perbandingan Gaji & Potongan</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Main Content -->
    <div class="container-fluid mt-4">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <i class="fas fa-chart-simple"></i> Menu Utama
                    </div>
                    <div class="list-group list-group-flush">
                        <a href="{{ route('dashboard') }}" class="list-group-item list-group-item-action {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <i class="fas fa-home"></i> Dashboard
                        </a>
                        <a href="{{ route('pegawai.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('pegawai.*') ? 'active' : '' }}">
                            <i class="fas fa-users"></i> Data Pegawai
                        </a>
                        <a href="{{ route('golongan.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('golongan.*') ? 'active' : '' }}">
                            <i class="fas fa-layer-group"></i> Data Golongan
                        </a>
                        <a href="{{ route('komponen-gaji.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('komponen-gaji.*') ? 'active' : '' }}">
                            <i class="fas fa-calculator"></i> Penggajian
                        </a>
                        <a href="#laporanCollapse" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center {{ request()->routeIs('laporan.*') ? 'active' : '' }}" data-bs-toggle="collapse">
                            <span><i class="fas fa-chart-line"></i> Laporan</span>
                            <i class="fas fa-chevron-down small"></i>
                        </a>
                        <div class="collapse {{ request()->routeIs('laporan.*') ? 'show' : '' }}" id="laporanCollapse">
                            <div class="list-group list-group-flush ps-3 bg-light">
                                <a href="{{ route('laporan.slip-gaji') }}" class="list-group-item list-group-item-action py-2 {{ request()->routeIs('laporan.slip-gaji') ? 'active' : '' }}">
                                    <i class="fas fa-receipt me-1"></i> Slip Gaji
                                </a>
                                <a href="{{ route('laporan.rekap-departemen') }}" class="list-group-item list-group-item-action py-2 {{ request()->routeIs('laporan.rekap-departemen') ? 'active' : '' }}">
                                    <i class="fas fa-building me-1"></i> Rekap per Dept
                                </a>
                                <a href="{{ route('laporan.gaji-diatas-rata') }}" class="list-group-item list-group-item-action py-2 {{ request()->routeIs('laporan.gaji-diatas-rata') ? 'active' : '' }}">
                                    <i class="fas fa-arrow-up me-1"></i> Gaji > Rata-rata
                                </a>
                                <a href="{{ route('laporan.potongan-terbesar') }}" class="list-group-item list-group-item-action py-2 {{ request()->routeIs('laporan.potongan-terbesar') ? 'active' : '' }}">
                                    <i class="fas fa-minus-circle me-1"></i> Potongan Terbesar
                                </a>
                                <a href="{{ route('laporan.total-gaji-per-bulan') }}" class="list-group-item list-group-item-action py-2 {{ request()->routeIs('laporan.total-gaji-per-bulan') ? 'active' : '' }}">
                                    <i class="fas fa-chart-bar me-1"></i> Gaji per Bulan
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Content Area -->
            <div class="col-md-10">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                @yield('content')
            </div>
        </div>
    </div>
    <!-- Footer -->
    <footer class="bg-light text-center text-muted py-3 mt-5">
        <div class="container">
            <span>&copy; {{ date('Y') }} Aplikasi Penggajian - Praktikum Pemrograman
                Web</span>
        </div>
    </footer>
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>
