<?php

namespace App\Livewire\Admin;

use Carbon\Carbon;
use App\Models\Laporan;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Barryvdh\DomPDF\Facade\Pdf;

#[Layout('components.layouts.app')]
class DashboardAdmin extends Component
{
    public $totalLaporan;
    public $laporanPending;
    public $laporanProses;
    public $laporanSelesai;
    public $totalPemasukan;
    public $totalPengeluaran;
    public $jumlahPelapor;
    public $laporanPerBulan;
    public $pemasukanPerLokasi;
    public $pengeluaranPerLokasi;
    public $laporanPerPelapor;
    public $keuanganPerPelapor;

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        $this->totalLaporan = Laporan::count();
        $this->laporanPending = Laporan::where('status', 'menunggu')->count();
        $this->laporanProses = Laporan::where('status', 'diproses')->count();
        $this->laporanSelesai = Laporan::where('status', 'selesai')->count();

        $this->totalPemasukan = (float) Laporan::sum('pemasukan');
        $this->totalPengeluaran = (float) Laporan::sum('pengeluaran');
        $this->jumlahPelapor = (int) Laporan::distinct('user_id')->count('user_id');

        // Ambil laporan per bulan (tahun ini)
        $this->laporanPerBulan = Laporan::whereYear('tanggal', now()->year)
            ->get()
            ->groupBy(function ($item) {
                return Carbon::parse($item->tanggal)->format('m');
            })
            ->map->count()
            ->toArray();

        // Ambil pemasukan & pengeluaran per lokasi
        $lokasiData = Laporan::selectRaw('lokasi, SUM(pemasukan) as total_pemasukan, SUM(pengeluaran) as total_pengeluaran')
            ->groupBy('lokasi')
            ->get();

        // Inisialisasi array dengan semua lokasi
        $allLokasi = Laporan::getLokasiOptions();
        $this->pemasukanPerLokasi = array_fill_keys($allLokasi, 0);
        $this->pengeluaranPerLokasi = array_fill_keys($allLokasi, 0);

        foreach ($lokasiData as $item) {
            if (in_array($item->lokasi, $allLokasi)) {
                $this->pemasukanPerLokasi[$item->lokasi] = (int) $item->total_pemasukan;
                $this->pengeluaranPerLokasi[$item->lokasi] = (int) $item->total_pengeluaran;
            }
        }

        // AMBIL DATA KEUANGAN PER PELAPOR
        $this->keuanganPerPelapor = $this->getKeuanganPerPelapor();

        // Ambil jumlah laporan per pelapor (user)
        $this->laporanPerPelapor = $this->getLaporanPerPelapor();
    }

    protected function getKeuanganPerPelapor()
    {
        $keuanganUsers = Laporan::with('user:id,name')
            ->select('user_id',
                DB::raw('SUM(pemasukan) as total_pemasukan'),
                DB::raw('SUM(pengeluaran) as total_pengeluaran'),
                DB::raw('COUNT(*) as jumlah_laporan')
            )
            ->groupBy('user_id')
            ->get();

        $data = [];
        foreach ($keuanganUsers as $item) {
            $nama = $item->user ? $this->cleanString($item->user->name) : 'Pelapor Tanpa Nama';
            $data[$nama] = [
                'pemasukan' => (int) $item->total_pemasukan,
                'pengeluaran' => (int) $item->total_pengeluaran,
                'jumlah_laporan' => (int) $item->jumlah_laporan,
                'saldo' => (int) ($item->total_pemasukan - $item->total_pengeluaran)
            ];
        }

        return $data;
    }

    protected function getLaporanPerPelapor()
    {
        $laporanUsers = Laporan::with('user:id,name')
            ->select('user_id', DB::raw('COUNT(*) as jumlah_laporan'))
            ->groupBy('user_id')
            ->get();

        $data = [];
        foreach ($laporanUsers as $item) {
            $nama = $item->user ? $this->cleanString($item->user->name) : 'Pelapor Tanpa Nama';
            $data[$nama] = (int) $item->jumlah_laporan;
        }

        arsort($data);
        return $data;
    }

    protected function cleanString($string)
    {
        // Bersihkan string dari karakter non-UTF-8
        $string = mb_convert_encoding($string, 'UTF-8', 'UTF-8');
        $string = iconv('UTF-8', 'UTF-8//IGNORE', $string);
        return preg_replace('/[^\x20-\x7E\xA0-\xFF]/u', '', $string);
    }

    public function downloadExcel()
    {
        $filename = 'laporan-keuangan-pelapor-' . now()->format('Y-m-d') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        $callback = function() {
            $file = fopen('php://output', 'w');

            // Add BOM for UTF-8
            fwrite($file, "\xEF\xBB\xBF");

            // Header
            fputcsv($file, [
                'No',
                'Nama Pelapor',
                'Jumlah Laporan',
                'Total Pemasukan',
                'Total Pengeluaran',
                'Saldo',
                'Status Saldo'
            ]);

            // Data
            $counter = 1;
            foreach ($this->keuanganPerPelapor as $nama => $item) {
                fputcsv($file, [
                    $counter++,
                    $nama,
                    $item['jumlah_laporan'],
                    'Rp ' . number_format($item['pemasukan'], 0, ',', '.'),
                    'Rp ' . number_format($item['pengeluaran'], 0, ',', '.'),
                    'Rp ' . number_format($item['saldo'], 0, ',', '.'),
                    $item['saldo'] >= 0 ? 'Positif' : 'Negatif'
                ]);
            }

            // Total
            $totalSaldo = $this->totalPemasukan - $this->totalPengeluaran;
            fputcsv($file, [
                'TOTAL',
                '',
                $this->totalLaporan,
                'Rp ' . number_format($this->totalPemasukan, 0, ',', '.'),
                'Rp ' . number_format($this->totalPengeluaran, 0, ',', '.'),
                'Rp ' . number_format($totalSaldo, 0, ',', '.'),
                $totalSaldo >= 0 ? 'Positif' : 'Negatif'
            ]);

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    public function downloadPdf()
    {
        $data = [
            'data' => $this->keuanganPerPelapor,
            'totalPemasukan' => $this->totalPemasukan,
            'totalPengeluaran' => $this->totalPengeluaran,
            'totalLaporan' => $this->totalLaporan,
            'totalSaldo' => $this->totalPemasukan - $this->totalPengeluaran,
            'tanggal' => now()->format('d F Y')
        ];

        $pdf = Pdf::loadView('exports.keuangan-pelapor-pdf', $data);
        return $pdf->download('laporan-keuangan-pelapor-' . now()->format('Y-m-d') . '.pdf');
    }

    public function render()
    {
        return view('livewire.admin.dashboard-admin');
    }
}
