<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Rekap Gaji per Departemen</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h1 {
            margin: 0;
            font-size: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f0f0f0;
        }

        .text-right {
            text-align: right;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>REKAPITULASI GAJI PER DEPARTEMEN</h1>
        <p>Periode: {{ request('bulan') ? $bulanList[request('bulan')] : 'Semua Bulan' }}
            {{ request('tahun') ?: 'Semua Tahun' }}</p>
    </div>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Departemen</th>
                <th class="text-right">Jumlah Pegawai</th>
                <th class="text-right">Total Gaji</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rekap as $key => $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->departemen }}</td>
                    <td class="text-right">{{ $item->jumlah_pegawai }}</td>
                    <td class="text-right">Rp {{ number_format($item->total_gaji, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="footer">
        <p>Dicetak pada: {{ date('d-m-Y H:i:s') }}</p>
    </div>
</body>

</html>
