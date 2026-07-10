<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Slip Gaji - {{ $data->pegawai->nama }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .info-table td {
            padding: 8px;
            border: 1px solid #ddd;
        }
        .info-table td:first-child {
            width: 30%;
            background-color: #f5f5f5;
            font-weight: bold;
        }
        .gaji-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .gaji-table th, .gaji-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        .gaji-table th {
            background-color: #f0f0f0;
        }
        .total-row {
            background-color: #e8f4e8;
            font-weight: bold;
        }
        .text-right {
            text-align: right;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 10px;
            color: #999;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>SLIP GAJI</h1>
        <p>Periode: {{ $data->nama_bulan }} {{ $data->tahun }}</p>
    </div>
    <table class="info-table">
        <tr>
            <td>NIP</td>
            <td>{{ $data->pegawai->nip }}</td>
        </tr>
        <tr>
            <td>Nama Pegawai</td>
            <td>{{ $data->pegawai->nama }}</td>
        </tr>
        <tr>
            <td>Departemen</td>
            <td>{{ $data->pegawai->departemen }}</td>
        </tr>
        <tr>
            <td>Jabatan</td>
            <td>{{ $data->pegawai->jabatan }}</td>
        </tr>
        <tr>
            <td>Golongan</td>
            <td>{{ $data->pegawai->golongan->kode }} - {{ $data->pegawai->golongan->nama_golongan }}</td>
        </tr>
    </table>
    <table class="gaji-table">
        <thead>
            <tr>
                <th>Komponen</th>
                <th class="text-right">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Gaji Pokok</td>
                <td class="text-right">Rp {{ number_format($data->gaji_pokok, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Tunjangan Makan</td>
                <td class="text-right">Rp {{ number_format($data->tunjangan_makan, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Tunjangan Transport</td>
                <td class="text-right">Rp {{ number_format($data->tunjangan_transport, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Tunjangan Lainnya</td>
                <td class="text-right">Rp {{ number_format($data->tunjangan_lainnya, 0, ',', '.') }}</td>
            </tr>
            <tr style="color: #28a745;">
                <td><strong>+ Total Tunjangan</strong></td>
                <td class="text-right"><strong>Rp {{ number_format($data->tunjangan_makan + $data->tunjangan_transport + $data->tunjangan_lainnya, 0, ',', '.') }}</strong></td>
            </tr>
            <tr style="color: #dc3545;">
                <td>Potongan Absensi</td>
                <td class="text-right">- Rp {{ number_format($data->potongan_absensi, 0, ',', '.') }}</td>
            </tr>
            <tr style="color: #dc3545;">
                <td>Potongan Lainnya</td>
                <td class="text-right">- Rp {{ number_format($data->potongan_lainnya, 0, ',', '.') }}</td>
            </tr>
            <tr style="color: #dc3545;">
                <td><strong>= Total Potongan</strong></td>
                <td class="text-right"><strong>- Rp {{ number_format($data->total_potongan, 0, ',', '.') }}</strong></td>
            </tr>
            <tr class="total-row">
                <td><strong>GAJI BERSIH</strong></td>
                <td class="text-right"><strong>Rp {{ number_format($data->gaji_bersih, 0, ',', '.') }}</strong></td>
            </tr>
        </tbody>
    </table>
    <div class="footer">
        <p>Dicetak pada: {{ date('d-m-Y H:i:s') }}</p>
        <p>Dokumen ini adalah bukti sah penggajian</p>
    </div>
</body>
</html>