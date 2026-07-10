@extends('layouts.app')
@section('title', 'Data Golongan')
@section('content')
<div class="card">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0"><i class="fas fa-layer-group"></i> Data Golongan</h5>
    </div>
    <div class="card-body">
        <a href="{{ route('golongan.create') }}" class="btn btn-success mb-3">
            <i class="fas fa-plus"></i> Tambah Golongan
        </a>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Nama Golongan</th>
                        <th>Gaji Pokok</th>
                        <th>Tunjangan Makan</th>
                        <th>Tunjangan Transport</th>
                        <th>Jumlah Pegawai</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($golongan as $key => $item)
                        <tr>
                            <td>{{ $golongan->firstItem() + $key }}</td>
                            <td><span class="badge bg-info">{{ $item->kode }}</span></td>
                            <td>{{ $item->nama_golongan }}</td>
                            <td>Rp {{ number_format($item->gaji_pokok, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($item->tunjangan_makan, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($item->tunjangan_transport, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge bg-secondary">{{ $item->pegawai_count ?? 0 }} pegawai</span>
                            </td>
                            <td>
                                <a href="{{ route('golongan.show', $item->id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('golongan.edit', $item->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('golongan.destroy', $item->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">Belum ada data golongan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-3">
            {{ $golongan->links() }}
        </div>
    </div>
</div>
@endsection