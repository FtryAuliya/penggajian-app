@extends('layouts.app')
@section('title', 'Dashboard Karyawan')
@section('content')
    <h2>Dashboard Karyawan</h2>
    @if ($pegawai)
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h5>Data Diri</h5>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <th>Nama</th>
                                <td>{{ $pegawai->nama }}</td>
                            </tr>
                            <tr>
                                <th>NIP</th>
                                <td>{{ $pegawai->nip }}</td>
                            </tr>
                            <tr>
                                <th>Departemen</th>
                                <td>{{ $pegawai->departemen }}</td>
                            </tr>
                            <tr>
                                <th>Jabatan</th>
                                <td>{{ $pegawai->jabatan }}</td>
                            </tr>
                            <tr>
                                <th>Golongan</th>
                                <td>{{ $pegawai->golongan->kode ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h5>Gaji Terakhir</h5>
                    </div>
                    <div class="card-body">
                        @if ($gajiTerakhir)
                            <table class="table">
                                <tr>
                                    <th>Periode</th>
                                    <td>{{ $gajiTerakhir->getNamaBulanAttribute() }} {{ $gajiTerakhir->tahun }}</td>
                                </tr>
                                <tr>
                                    <th>Gaji Pokok</th>
                                    <td>Rp {{ number_format($gajiTerakhir->gaji_pokok, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th>Total Tunjangan</th>
                                    <td>Rp {{ number_format($gajiTerakhir->total_tunjangan, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th>Total Potongan</th>
                                    <td>Rp {{ number_format($gajiTerakhir->total_potongan, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th><strong>Gaji Bersih</strong></th>
                                    <td><strong>Rp {{ number_format($gajiTerakhir->gaji_bersih, 0, ',', '.') }}</strong>
                                    </td>
                                </tr>
                            </table>
                        @else
                            <p class="text-muted">Belum ada data penggajian.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-warning">Data pegawai belum terhubung dengan akun ini. Silakan
            hubungi admin.</div>
    @endif
@endsection
