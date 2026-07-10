<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\KomponenGaji;
use App\Models\Golongan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
}
