@extends('layouts.app')

@section('title', 'Data Pegawai')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fas fa-users"></i> Data Pegawai</h5>
        </div>

        <div class="card-body">
            <a href="{{ route('pegawai.create') }}" class="btn btn-success mb-3">
                <i class="fas fa-plus"></i> Tambah Pegawai
            </a>

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">No</th>
                            <th width="10%">NIP</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Departemen</th>
                            <th>Jabatan</th>
                            <th>Golongan</th>
                            <th>Status</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pegawai as $key => $item)
                            <tr>
                                <td>{{ $pegawai->firstItem() + $key }}</td>
                                <td><code>{{ $item->nip }}</code></td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->email }}</td>
                                <td>{{ $item->departemen }}</td>
                                <td>{{ $item->jabatan }}</td>
                                <td>
                                    <span class="badge bg-info">{{ $item->golongan->kode ?? '-' }}</span>
                                </td>
                                <td>
                                    @if($item->status == 'aktif')
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-danger">Nonaktif</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('pegawai.show', $item->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('pegawai.edit', $item->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('pegawai.destroy', $item->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus pegawai {{ $item->nama }}?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-4">
                                    <i class="fas fa-users-slash fa-2x text-muted mb-2 d-block"></i>
                                    Belum ada data pegawai. Silakan tambah data!
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-3">
                {{ $pegawai->links() }}
            </div>
        </div>
    </div>
@endsection