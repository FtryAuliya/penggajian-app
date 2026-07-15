<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\KomponenGaji;
use App\Models\Golongan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LaporanController extends Controller
{
    /**
     * Dashboard laporan (menampilkan semua menu laporan)
     */
    public function index()
    {
        return view('laporan.index');
    }
    /**
     * LAPORAN 1: Slip Gaji Pegawai
     * Menampilkan detail gaji per pegawai per periode
     */
    public function slipGaji(Request $request)
    {
        $query = KomponenGaji::with('pegawai.golongan');
        // Filter berdasarkan pegawai
        if ($request->filled('pegawai_id')) {
            $query->where('pegawai_id', $request->pegawai_id);
        }
        // Filter berdasarkan periode
        if ($request->filled('bulan')) {
            $query->where('bulan', $request->bulan);
        }
        if ($request->filled('tahun')) {
            $query->where('tahun', $request->tahun);
        }
        $slipGaji = $query->orderBy('tahun', 'desc')
            ->orderBy('bulan', 'desc')
            ->paginate(15);
        $pegawaiList = Pegawai::where('status', 'aktif')->get();
        $bulanList = $this->getBulanList();
        $tahunList = range(2023, date('Y'));
        return view('laporan.slip-gaji', compact('slipGaji', 'pegawaiList', 'bulanList', 'tahunList'));
    }
    /**
     * LAPORAN 2: Rekap Gaji per Departemen
     * Total gaji bersih per departemen
     */
    public function rekapDepartemen(Request $request)
    {
        // Query menggunakan join dan agregasi
        $rekap = KomponenGaji::select(
            'pegawai.departemen',
            DB::raw('COUNT(DISTINCT komponen_gaji.pegawai_id) as jumlah_pegawai'),
            DB::raw('SUM(komponen_gaji.gaji_bersih) as total_gaji'),
            DB::raw('AVG(komponen_gaji.gaji_bersih) as rata_rata_gaji'),
            DB::raw('MAX(komponen_gaji.gaji_bersih) as gaji_tertinggi'),
            DB::raw('MIN(komponen_gaji.gaji_bersih) as gaji_terendah')
        )
            ->join('pegawai', 'komponen_gaji.pegawai_id', '=', 'pegawai.id')
            ->groupBy('pegawai.departemen')
            ->orderBy('total_gaji', 'desc');
        // Filter periode
        if ($request->filled('bulan')) {
            $rekap->where('komponen_gaji.bulan', $request->bulan);
        }
        if ($request->filled('tahun')) {
            $rekap->where('komponen_gaji.tahun', $request->tahun);
        }
        $data = $rekap->get();
        $bulanList = $this->getBulanList();
        $tahunList = range(2023, date('Y'));
        return view('laporan.rekap-departemen', compact('data', 'bulanList', 'tahunList'));
    }
    /**
     * LAPORAN 3: Pegawai dengan Gaji di Atas Rata-rata
     */
    public function gajiDiatasRata(Request $request)
    {
        // Hitung rata-rata gaji seluruh pegawai
        $rataRata = KomponenGaji::avg('gaji_bersih');
        $query = KomponenGaji::with('pegawai.golongan')
            ->where('gaji_bersih', '>', $rataRata);
        // Filter periode
        if ($request->filled('bulan')) {
            $query->where('bulan', $request->bulan);
        }
        if ($request->filled('tahun')) {
            $query->where('tahun', $request->tahun);
        }
        $data = $query->orderBy('gaji_bersih', 'desc')->get();
        $bulanList = $this->getBulanList();
        $tahunList = range(2023, date('Y'));
        return view('laporan.gaji-diatas-rata', compact('data', 'rataRata', 'bulanList', 'tahunList'));
    }
    /**
     * LAPORAN 4: Potongan Terbesar per Pegawai
     */
    public function potonganTerbesar(Request $request)
    {
        // Menggunakan subquery untuk mendapatkan potongan terbesar per pegawai
        $subquery = KomponenGaji::select('pegawai_id', DB::raw('MAX(total_potongan) as
max_potongan'))
            ->groupBy('pegawai_id');
        $query = KomponenGaji::with('pegawai.golongan')
            ->joinSub($subquery, 'max_potongan', function ($join) {
                $join->on('komponen_gaji.pegawai_id', '=', 'max_potongan.pegawai_id')
                    ->on('komponen_gaji.total_potongan', '=', 'max_potongan.max_potongan');
            });
        // Filter periode
        if ($request->filled('bulan')) {
            $query->where('komponen_gaji.bulan', $request->bulan);
        }
        if ($request->filled('tahun')) {
            $query->where('komponen_gaji.tahun', $request->tahun);
        }
        $data = $query->orderBy('komponen_gaji.total_potongan', 'desc')->get();
        $bulanList = $this->getBulanList();
        $tahunList = range(2023, date('Y'));
        return view('laporan.potongan-terbesar', compact('data', 'bulanList', 'tahunList'));
    }
    /**
     * LAPORAN 5: Total Gaji per Bulan
     */
    public function totalGajiPerBulan(Request $request)
    {
        $query = KomponenGaji::select(
            'tahun',
            'bulan',
            DB::raw('COUNT(*) as jumlah_transaksi'),
            DB::raw('SUM(gaji_bersih) as total_gaji'),
            DB::raw('AVG(gaji_bersih) as rata_rata_gaji'),
            DB::raw('SUM(total_potongan) as total_potongan')
        )
            ->groupBy('tahun', 'bulan')
            ->orderBy('tahun', 'desc')
            ->orderBy('bulan', 'desc');
        // Filter tahun
        if ($request->filled('tahun')) {
            $query->where('tahun', $request->tahun);
        }
        $data = $query->get();
        $tahunList = range(2023, date('Y'));
        $bulanList = $this->getBulanList();
        // Data untuk chart
        $chartLabels = [];
        $chartData = [];
        foreach ($data as $item) {
            $chartLabels[] = $bulanList[$item->bulan] . ' ' . $item->tahun;
            $chartData[] = $item->total_gaji;
        }
        return view('laporan.total-gaji-per-bulan', compact(
            'data',
            'tahunList',
            'bulanList',
            'chartLabels',
            'chartData'
        ));
    }
    /**
     * Export ke PDF untuk semua laporan
     */
    public function exportPdf(Request $request, $jenis)
    {
        switch ($jenis) {
            case 'slip-gaji':
                $data = KomponenGaji::with('pegawai.golongan')
                    ->when($request->id, fn($q) => $q->where('id', $request->id))
                    ->firstOrFail();
                $pdf = Pdf::loadView('laporan.pdf.slip-gaji', compact('data'));
                return $pdf->download('slip-gaji-' . $data->pegawai->nip . '-' . $data->bulan . '-' .
                    $data->tahun . '.pdf');
            case 'rekap-departemen':
                $rekap = KomponenGaji::select(
                    'pegawai.departemen',
                    DB::raw('COUNT(DISTINCT komponen_gaji.pegawai_id) as jumlah_pegawai'),
                    DB::raw('SUM(komponen_gaji.gaji_bersih) as total_gaji')
                )
                    ->join('pegawai', 'komponen_gaji.pegawai_id', '=', 'pegawai.id')
                    ->groupBy('pegawai.departemen')
                    ->get();
                $pdf = Pdf::loadView('laporan.pdf.rekap-departemen', compact('rekap'));
                return $pdf->download('rekap-gaji-departemen.pdf');
            case 'urutan-gaji':
                $data = KomponenGaji::with('pegawai')
                    ->orderBy('gaji_bersih', 'desc')
                    ->take(10)
                    ->get();
                $pdf = Pdf::loadView('laporan.pdf.urutan-gaji', compact('data'));
                return $pdf->download('urutan-gaji-tertinggi.pdf');
            case 'jumlah-pegawai-golongan':
                $data = Golongan::withCount('pegawai')->get();
                $pdf = Pdf::loadView('laporan.pdf.jumlah-pegawai-golongan', compact('data'));
                return $pdf->download('jumlah-pegawai-per-golongan.pdf');
            default:
                return redirect()->back()->with('error', 'Laporan tidak ditemukan');
        }
    }

    /**
     * Helper: Daftar bulan
     */
    private function getBulanList()
    {
        return [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];
    }

    /**
     * LAPORAN 6: Pegawai dengan Masa Kerja > 5 Tahun
     */
    public function masaKerjaLimaTahun(Request $request)
    {
        // Ambil semua pegawai aktif
        $pegawaiList = Pegawai::with('golongan')
            ->where('status', 'aktif')
            ->get();
        // Filter pegawai dengan masa kerja > 5 tahun
        $data = [];
        foreach ($pegawaiList as $pegawai) {
            $tanggalMasuk = Carbon::parse($pegawai->tanggal_masuk);
            $masaKerjaTahun = $tanggalMasuk->diffInYears(Carbon::now());
            $masaKerjaBulan = $tanggalMasuk->diffInMonths(Carbon::now()) % 12;
            if ($masaKerjaTahun > 5) {
                // Ambil gaji terakhir pegawai
                $gajiTerakhir = KomponenGaji::where('pegawai_id', $pegawai->id)
                    ->orderBy('tahun', 'desc')
                    ->orderBy('bulan', 'desc')
                    ->first();
                $data[] = (object) [
                    'pegawai' => $pegawai,
                    'masa_kerja_tahun' => $masaKerjaTahun,
                    'masa_kerja_bulan' => $masaKerjaBulan,
                    'gaji_terakhir' => $gajiTerakhir->gaji_bersih ?? 0,
                    'tanggal_masuk' => $pegawai->tanggal_masuk,
                ];
            }
        }
        // Urutkan berdasarkan masa kerja tertinggi
        usort($data, function ($a, $b) {
            return $b->masa_kerja_tahun <=> $a->masa_kerja_tahun;
        });
        return view('laporan.masa-kerja-5-tahun', compact('data'));
    }

    /**
     * LAPORAN 7: Urutan Gaji Bersih Tertinggi (Top 10)
     */
    public function urutanGajiBersih(Request $request)
    {
        $query = KomponenGaji::with('pegawai.golongan')
            ->where('status', 'selesai');
        // Filter periode
        if ($request->filled('bulan')) {
            $query->where('bulan', $request->bulan);
        }
        if ($request->filled('tahun')) {
            $query->where('tahun', $request->tahun);
        }
        // Ambil 10 gaji tertinggi
        $data = $query->orderBy('gaji_bersih', 'desc')
            ->take(10)
            ->get();
        // Tambahkan peringkat
        $ranking = 1;
        foreach ($data as $item) {
            $item->peringkat = $ranking++;
        }
        $bulanList = $this->getBulanList();
        $tahunList = range(2023, date('Y'));
        return view('laporan.urutan-gaji-bersih', compact('data', 'bulanList', 'tahunList'));
    }

    /**
     * LAPORAN 8: Jumlah Pegawai per Golongan
     */
    public function jumlahPegawaiPerGolongan(Request $request)
    {
        // Menggunakan withCount untuk menghitung jumlah pegawai per golongan
        $data = Golongan::withCount(['pegawai' => function ($query) {
            $query->where('status', 'aktif');
        }])
            ->orderBy('kode')
            ->get();
        // Data untuk chart
        $chartLabels = [];
        $chartData = [];
        foreach ($data as $item) {
            $chartLabels[] = $item->kode . ' - ' . $item->nama_golongan;
            $chartData[] = $item->pegawai_count;
        }
        return view('laporan.jumlah-pegawai-per-golongan', compact(
            'data',
            'chartLabels',
            'chartData'
        ));
    }

    /**
     * LAPORAN 9: Rekap Tunjangan Makan & Transport per Bulan
     */
    public function rekapTunjangan(Request $request)
    {
        $query = KomponenGaji::select(
            'tahun',
            'bulan',
            DB::raw('SUM(tunjangan_makan) as total_tunjangan_makan'),
            DB::raw('SUM(tunjangan_transport) as total_tunjangan_transport'),
            DB::raw('SUM(tunjangan_lainnya) as total_tunjangan_lainnya'),
            DB::raw('COUNT(*) as jumlah_pegawai')
        )->groupBy('tahun', 'bulan')
            ->orderBy('tahun', 'desc')
            ->orderBy('bulan', 'desc');
        // Filter tahun
        if ($request->filled('tahun')) {
            $query->where('tahun', $request->tahun);
        }
        $data = $query->get();
        $tahunList = range(2023, date('Y'));
        $bulanList = $this->getBulanList();
        // Data untuk chart
        $chartBulan = [];
        $chartMakan = [];
        $chartTransport = [];
        foreach ($data->reverse() as $item) {
            $chartBulan[] = $bulanList[$item->bulan] . ' ' . $item->tahun;
            $chartMakan[] = $item->total_tunjangan_makan;
            $chartTransport[] = $item->total_tunjangan_transport;
        }
        return view('laporan.rekap-tunjangan', compact(
            'data',
            'tahunList',
            'bulanList',
            'chartBulan',
            'chartMakan',
            'chartTransport'
        ));
    }

    /**
     * LAPORAN 10: Perbandingan Gaji Pokok & Potongan
     */
    public function perbandinganGajiPotongan(Request $request)
    {
        // Hitung rata-rata gaji pokok dan potongan per golongan
        $data = Golongan::with(['pegawai' => function ($query) {
            $query->where('status', 'aktif');
        }])
            ->get();
        $perbandingan = [];
        foreach ($data as $golongan) {
            // Ambil data penggajian untuk pegawai golongan ini
            $pegawaiIds = $golongan->pegawai->pluck('id')->toArray();
            $stats = KomponenGaji::whereIn('pegawai_id', $pegawaiIds)
                ->select(
                    DB::raw('AVG(gaji_pokok) as rata_gaji_pokok'),
                    DB::raw('AVG(total_potongan) as rata_potongan')
                )->first();
            $perbandingan[] = (object) [
                'golongan' => $golongan,
                'rata_gaji_pokok' => $stats->rata_gaji_pokok ?? 0,
                'rata_potongan' => $stats->rata_potongan ?? 0,
                'jumlah_pegawai' => $golongan->pegawai->count(),
            ];
        }
        // Data untuk chart
        $chartLabels = [];
        $chartGajiPokok = [];
        $chartPotongan = [];
        foreach ($perbandingan as $item) {
            $chartLabels[] = $item->golongan->kode;
            $chartGajiPokok[] = $item->rata_gaji_pokok;
            $chartPotongan[] = $item->rata_potongan;
        }
        // Hitung rata-rata keseluruhan
        $totalRataGaji = KomponenGaji::avg('gaji_pokok');
        $totalRataPotongan = KomponenGaji::avg('total_potongan');
        $persentasePotongan = $totalRataGaji > 0 ? ($totalRataPotongan / $totalRataGaji) * 100 :
            0;
        return view('laporan.perbandingan-gaji-potongan', compact(
            'perbandingan',
            'chartLabels',
            'chartGajiPokok',
            'chartPotongan',
            'totalRataGaji',
            'totalRataPotongan',
            'persentasePotongan'
        ));
    }
}
