@extends('layouts.app')
@section('title', 'Data Penggajian')
@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-calculator"></i> Data Penggajian</h5>
        <a href="{{ route('komponen-gaji.create') }}" class="btn btn-light btn-sm">
            <i class="fas fa-plus"></i> Tambah Penggajian
        </a>
    </div>
    <div class="card-body">
        <!-- Statistik Cards -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <small>Total Gaji Bersih</small>
                                <h5>Rp {{ number_format($totalGajiBersih, 0, ',', '.') }}</h5>
                            </div>
                            <i class="fas fa-money-bill fa-2x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <small>Total Pegawai Digaji</small>
                                <h5>{{ $totalPegawaiDigaji }} orang</h5>
                            </div>
                            <i class="fas fa-users fa-2x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-warning text-dark">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <small>Rata-rata Gaji</small>
                                <h5>Rp {{ number_format($rataRaji = $rataRataGaji ?? 0, 0, ',', '.') }}</h5>
                            </div>
                            <i class="fas fa-chart-line fa-2x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Form -->
        <form method="GET" class="row mb-3">
            <div class="col-md-3">
                <select name="pegawai_id" class="form-select">
                    <option value="">Semua Pegawai</option>
                    @foreach($pegawaiList as $pegawai)
                        <option value="{{ $pegawai->id }}" {{ request('pegawai_id') == $pegawai->id ? 'selected' : '' }}>
                            {{ $pegawai->nama }} ({{ $pegawai->nip }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="bulan" class="form-select">
                    <option value="">Semua Bulan</option>
                    @foreach($bulanList as $key => $nama)
                        <option value="{{ $key }}" {{ request('bulan') == $key ? 'selected' : '' }}>
                            {{ $nama }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="tahun" class="form-select">
                    <option value="">Semua Tahun</option>
                    @foreach($tahunList as $tahun)
                        <option value="{{ $tahun }}" {{ request('tahun') == $tahun ? 'selected' : '' }}>
                            {{ $tahun }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
                    @foreach($statusList as $status)
                        <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                            {{ ucfirst($status) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-filter"></i> Filter
                </button>
            </div>
            <div class="col-md-1">
                <a href="{{ route('komponen-gaji.index') }}" class="btn btn-secondary w-100">
                    <i class="fas fa-sync-alt"></i>
                </a>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th width="5%">No</th>
                        <th>Pegawai</th>
                        <th>Departemen</th>
                        <th>Periode</th>
                        <th>Gaji Pokok</th>
                        <th>Tunjangan</th>
                        <th>Potongan</th>
                        <th>Gaji Bersih</th>
                        <th>Status</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($komponenGaji as $key => $item)
                        <tr>
                            <td>{{ $komponenGaji->firstItem() + $key }}</td>
                            <td>
                                <strong>{{ $item->pegawai->nama }}</strong><br>
                                <small class="text-muted">{{ $item->pegawai->nip }}</small>
                            </td>
                            <td>{{ $item->pegawai->departemen }}</td>
                            <td>
                                <span class="badge bg-secondary">{{ $item->nama_bulan }} {{ $item->tahun }}</span>
                            </td>
                            <td class="text-end">Rp {{ number_format($item->gaji_pokok, 0, ',', '.') }}</td>
                            <td class="text-end text-info">
                                Rp {{ number_format($item->total_tunjangan, 0, ',', '.') }}
                            </td>
                            <td class="text-end text-danger">
                                Rp {{ number_format($item->total_potongan, 0, ',', '.') }}
                            </td>
                            <td class="text-end fw-bold text-success">
                                Rp {{ number_format($item->gaji_bersih, 0, ',', '.') }}
                            </td>
                            <td>
                                @if($item->status == 'selesai')
                                    <span class="badge bg-success">Selesai</span>
                                @elseif($item->status == 'diproses')
                                    <span class="badge bg-warning">Diproses</span>
                                @else
                                    <span class="badge bg-secondary">Draft</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('komponen-gaji.show', $item->id) }}" class="btn btn-sm btn-info" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('komponen-gaji.edit', $item->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('komponen-gaji.destroy', $item->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus data penggajian ini?')" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center py-4">
                                <i class="fas fa-database fa-2x text-muted mb-2 d-block"></i>
                                Belum ada data penggajian. Silakan tambah data!
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot class="table-secondary">
                    <tr>
                        <th colspan="7" class="text-end">TOTAL:</th>
                        <th class="text-end text-success">Rp {{ number_format($komponenGaji->sum('gaji_bersih'), 0, ',', '.') }}</th>
                        <th colspan="2"></th>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-3">
            {{ $komponenGaji->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection