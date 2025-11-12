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
    public $laporanPerPelapor; // Tambahkan properti ini

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

    // Inisialisasi array dengan semua lokasi (agar konsisten urutan & tampil meski 0)
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
    $laporanUsers = Laporan::with('user:id,name') // hanya ambil id dan name untuk efisiensi
        ->select('user_id', DB::raw('COUNT(*) as jumlah_laporan'))
        ->groupBy('user_id')
        ->get();

    // Siapkan array: nama pelapor => jumlah laporan
    $this->laporanPerPelapor = [];

    foreach ($laporanUsers as $item) {
        $nama = $item->user ? $item->user->name : 'Pelapor Tanpa Nama';
        $this->laporanPerPelapor[$nama] = (int) $item->jumlah_laporan;
    }

    // Opsional: urutkan dari tertinggi ke terendah
    arsort($this->laporanPerPelapor);

    }

    public function render()
    {
        return view('livewire.admin.dashboard-admin', [
            'laporanPerBulan' => $this->laporanPerBulan,]);
    }
}
