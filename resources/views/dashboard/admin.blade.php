@extends('layouts.app')
@section('title', 'Dashboard Admin')
@section('content')
    <h2>Dashboard Admin</h2>
    <div class="row">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5>Total Pegawai</h5>
                    <h2>{{ $totalPegawai }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5>Pegawai Aktif</h5>
                    <h2>{{ $pegawaiAktif }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h5>Total Gaji Bulan Ini</h5>
                    <h5>Rp {{ number_format($totalGajiBulanIni, 0, ',', '.') }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-dark">
                <div class="card-body">
                    <h5>Total Golongan</h5>
                    <h2>{{ $totalGolongan }}</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-4">
        <h5>Top 5 Gaji Tertinggi Bulan Ini</h5>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Gaji Bersih</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($topGaji as $key => $item)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $item->pegawai->nama }}</td>
                        <td>Rp {{ number_format($item->gaji_bersih, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
