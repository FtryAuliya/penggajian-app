@extends('layouts.app')
@section('title', 'Edit Penggajian')
@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-warning text-dark">
        <h5 class="mb-0"><i class="fas fa-edit"></i> Edit Penggajian</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('komponen-gaji.update', $komponenGaji->id) }}" method="POST" id="formPenggajian">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Pegawai</label>
                        <input type="text" class="form-control" value="{{ $komponenGaji->pegawai->nama }} ({{ $komponenGaji->pegawai->nip }})" readonly>
                        <input type="hidden" name="pegawai_id" value="{{ $komponenGaji->pegawai_id }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">Periode</label>
                        <input type="text" class="form-control" value="{{ $komponenGaji->nama_bulan }} {{ $komponenGaji->tahun }}" readonly>
                        <input type="hidden" name="bulan" value="{{ $komponenGaji->bulan }}">
                        <input type="hidden" name="tahun" value="{{ $komponenGaji->tahun }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="tanggal_gaji" class="form-label">Tanggal Gaji</label>
                        <input type="date" class="form-control @error('tanggal_gaji') is-invalid @enderror" id="tanggal_gaji" name="tanggal_gaji" value="{{ old('tanggal_gaji', $komponenGaji->tanggal_gaji->format('Y-m-d')) }}">
                        @error('tanggal_gaji')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <hr>
            <h6 class="mb-3"><i class="fas fa-chart-line"></i> Komponen Gaji</h6>
            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="gaji_pokok" class="form-label">Gaji Pokok</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" class="form-control @error('gaji_pokok') is-invalid @enderror" id="gaji_pokok" name="gaji_pokok" value="{{ old('gaji_pokok', $komponenGaji->gaji_pokok) }}" readonly style="background-color: #e9ecef;">
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="tunjangan_makan" class="form-label">Tunjangan Makan</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" class="form-control" id="tunjangan_makan" name="tunjangan_makan" value="{{ old('tunjangan_makan', $komponenGaji->tunjangan_makan) }}" readonly style="background-color: #e9ecef;">
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="tunjangan_transport" class="form-label">Tunjangan Transport</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" class="form-control" id="tunjangan_transport" name="tunjangan_transport" value="{{ old('tunjangan_transport', $komponenGaji->tunjangan_transport) }}" readonly style="background-color: #e9ecef;">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="tunjangan_lainnya" class="form-label">Tunjangan Lainnya (Bonus/Lembur)</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" class="form-control @error('tunjangan_lainnya') is-invalid @enderror" id="tunjangan_lainnya" name="tunjangan_lainnya" value="{{ old('tunjangan_lainnya', $komponenGaji->tunjangan_lainnya) }}" min="0" step="50000">
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <h6 class="mb-3"><i class="fas fa-minus-circle text-danger"></i> Potongan</h6>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="potongan_absensi" class="form-label">Potongan Absensi</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" class="form-control @error('potongan_absensi') is-invalid @enderror" id="potongan_absensi" name="potongan_absensi" value="{{ old('potongan_absensi', $komponenGaji->potongan_absensi) }}" min="0" step="50000">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="potongan_lainnya" class="form-label">Potongan Lainnya</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" class="form-control @error('potongan_lainnya') is-invalid @enderror" id="potongan_lainnya" name="potongan_lainnya" value="{{ old('potongan_lainnya', $komponenGaji->potongan_lainnya) }}" min="0" step="50000">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                            <option value="draft" {{ old('status', $komponenGaji->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="diproses" {{ old('status', $komponenGaji->status) == 'diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="selesai" {{ old('status', $komponenGaji->status) == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </div>
                </div>
            </div>
            <hr>

            <!-- Ringkasan Perhitungan -->
            <div class="row">
                <div class="col-md-6 offset-md-6">
                    <div class="alert alert-info">
                        <h6 class="mb-2"><i class="fas fa-info-circle"></i> Ringkasan Perhitungan:</h6>
                        <table class="table table-sm table-borderless mb-0">
                            <tr>
                                <td>Gaji Pokok:</td>
                                <td class="text-end" id="summary_gaji_pokok">Rp 0</td>
                            </tr>
                            <tr>
                                <td>Tunjangan (Makan + Transport):</td>
                                <td class="text-end" id="summary_tunjangan_tetap">Rp 0</td>
                            </tr>
                            <tr>
                                <td>Tunjangan Lainnya:</td>
                                <td class="text-end" id="summary_tunjangan_lainnya">Rp 0</td>
                            </tr>
                            <tr>
                                <td><strong>Total Tunjangan:</strong></td>
                                <td class="text-end text-success" id="summary_total_tunjangan">Rp 0</td>
                            </tr>
                            <tr>
                                <td>Potongan Absensi:</td>
                                <td class="text-end text-danger" id="summary_potongan_absensi">Rp 0</td>
                            </tr>
                            <tr>
                                <td>Potongan Lainnya:</td>
                                <td class="text-end text-danger" id="summary_potongan_lainnya">Rp 0</td>
                            </tr>
                            <tr>
                                <td><strong>Total Potongan:</strong></td>
                                <td class="text-end text-danger" id="summary_total_potongan">Rp 0</td>
                            </tr>
                            <tr class="border-top">
                                <td><strong>GAJI BERSIH:</strong></td>
                                <td class="text-end"><strong class="text-success fs-5" id="summary_gaji_bersih">Rp 0</strong></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <a href="{{ route('komponen-gaji.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function formatRupiah(angka) {
        return 'Rp ' + new Intl.NumberFormat('id-ID').format(angka);
    }
    function hitungSemua() {
        let gajiPokok = parseInt(document.getElementById('gaji_pokok').value) || 0;
        let tunjanganMakan = parseInt(document.getElementById('tunjangan_makan').value) || 0;
        let tunjanganTransport = parseInt(document.getElementById('tunjangan_transport').value) || 0;
        let tunjanganLainnya = parseInt(document.getElementById('tunjangan_lainnya').value) || 0;
        let potonganAbsensi = parseInt(document.getElementById('potongan_absensi').value) || 0;
        let potonganLainnya = parseInt(document.getElementById('potongan_lainnya').value) || 0;
        
        let totalTunjanganTetap = tunjanganMakan + tunjanganTransport;
        let totalTunjangan = totalTunjanganTetap + tunjanganLainnya;
        let totalPotongan = potonganAbsensi + potonganLainnya;
        let gajiBersih = gajiPokok + totalTunjangan - totalPotongan;
        
        document.getElementById('summary_gaji_pokok').innerHTML = formatRupiah(gajiPokok);
        document.getElementById('summary_tunjangan_tetap').innerHTML = formatRupiah(totalTunjanganTetap);
        document.getElementById('summary_tunjangan_lainnya').innerHTML = formatRupiah(tunjanganLainnya);
        document.getElementById('summary_total_tunjangan').innerHTML = formatRupiah(totalTunjangan);
        document.getElementById('summary_potongan_absensi').innerHTML = formatRupiah(potonganAbsensi);
        document.getElementById('summary_potongan_lainnya').innerHTML = formatRupiah(potonganLainnya);
        document.getElementById('summary_total_potongan').innerHTML = formatRupiah(totalPotongan);
        document.getElementById('summary_gaji_bersih').innerHTML = formatRupiah(gajiBersih);
    }
    document.getElementById('tunjangan_lainnya').addEventListener('input', hitungSemua);
    document.getElementById('potongan_absensi').addEventListener('input', hitungSemua);
    document.getElementById('potongan_lainnya').addEventListener('input', hitungSemua);
    // Initial calculation
    hitungSemua();
</script>
@endpush