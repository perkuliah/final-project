<?php

namespace App\Livewire\Admin;

use Carbon\Carbon;
use App\Models\Laporan;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\DB;

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
    public $keuanganPerPelapor; // Tambahkan properti baru

    public function mount()
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

        // Ambil pemasukan & pengeluaran per lokasi (hanya status 'Selesai')
        $lokasiData = Laporan::where('status', Laporan::STATUS_Selesai)
            ->selectRaw('lokasi, SUM(pemasukan) as total_pemasukan, SUM(pengeluaran) as total_pengeluaran')
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

        // Ambil jumlah laporan per pelapor (user)
        $laporanUsers = Laporan::with('user:id,name')
            ->select('user_id', DB::raw('COUNT(*) as jumlah_laporan'))
            ->groupBy('user_id')
            ->get();

        $this->laporanPerPelapor = [];
        foreach ($laporanUsers as $item) {
            $nama = $item->user ? $item->user->name : 'Pelapor Tanpa Nama';
            $this->laporanPerPelapor[$nama] = (int) $item->jumlah_laporan;
        }
        arsort($this->laporanPerPelapor);

        // AMBIL DATA KEUANGAN PER PELAPOR - DATA BARU
        $keuanganUsers = Laporan::with('user:id,name')
            ->select('user_id',
                DB::raw('SUM(pemasukan) as total_pemasukan'),
                DB::raw('SUM(pengeluaran) as total_pengeluaran'),
                DB::raw('COUNT(*) as jumlah_laporan')
            )
            ->groupBy('user_id')
            ->get();

        $this->keuanganPerPelapor = [];
        foreach ($keuanganUsers as $item) {
            $nama = $item->user ? $item->user->name : 'Pelapor Tanpa Nama';
            $this->keuanganPerPelapor[$nama] = [
                'pemasukan' => (int) $item->total_pemasukan,
                'pengeluaran' => (int) $item->total_pengeluaran,
                'jumlah_laporan' => (int) $item->jumlah_laporan,
                'saldo' => (int) ($item->total_pemasukan - $item->total_pengeluaran)
            ];
        }
    }

    public function render()
    {
        return view('livewire.admin.dashboard-admin', [
            'laporanPerBulan' => $this->laporanPerBulan,
        ]);
    }
}
