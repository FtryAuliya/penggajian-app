<nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm">
    <div class="container">
        <!-- Brand/Logo -->
        <a class="navbar-brand" href="#">
            <i class="fas fa-money-bill-wave me-2"></i>
            {{ config('app.name', 'Penggajian') }}
        </a>

        <!-- Hamburger -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarNav" aria-controls="navbarNav"
            aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <!-- Left Menu -->
            <ul class="navbar-nav me-auto">
                @auth
                    @if(auth()->user()->isAdmin())
                        {{-- Menu Admin --}}
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('dashboard.admin') ? 'active' : '' }}"
                                href="{{ route('dashboard.admin') }}">
                                <i class="fas fa-tachometer-alt me-1"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('pegawai.*') ? 'active' : '' }}"
                                href="{{ route('pegawai.index') }}">
                                <i class="fas fa-users me-1"></i> Pegawai
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('golongan.*') ? 'active' : '' }}"
                                href="{{ route('golongan.index') }}">
                                <i class="fas fa-layer-group me-1"></i> Golongan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('komponen-gaji.*') ? 'active' : '' }}"
                                href="{{ route('komponen-gaji.index') }}">
                                <i class="fas fa-file-invoice-dollar me-1"></i> Penggajian
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('laporan.*') ? 'active' : '' }}"
                                href="{{ route('laporan.index') }}">
                                <i class="fas fa-chart-line me-1"></i> Laporan
                            </a>
                        </li>
                    @else
                        {{-- Menu Karyawan --}}
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('dashboard.karyawan') ? 'active' : '' }}"
                                href="{{ route('dashboard.karyawan') }}">
                                <i class="fas fa-home me-1"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('laporan.slip-gaji') ? 'active' : '' }}"
                                href="{{ route('laporan.slip-gaji') }}">
                                <i class="fas fa-receipt me-1"></i> Slip Gaji
                            </a>
                        </li>
                    @endif
                @endauth
            </ul>

            <!-- Right Menu -->
            <ul class="navbar-nav ms-auto">
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle me-1"></i>
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                    <i class="fas fa-id-card me-2"></i> Profil
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
