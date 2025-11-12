<?php

namespace App\Livewire\User;

use App\Models\Laporan;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class DashboardUser extends Component
{
    public $totalLaporan;
    public $laporanPending;
    public $laporanProses;
    public $laporanSelesai;
    public $totalPemasukan;
    public $totalPengeluaran;
    public $laporanPerBulan;

    public function mount()
    {
        $userId = auth()->id();

        $this->totalLaporan = Laporan::where('user_id', $userId)->count();
        $this->laporanPending = Laporan::where('user_id', $userId)->where('status', 'menunggu')->count();
        $this->laporanProses = Laporan::where('user_id', $userId)->where('status', 'diproses')->count();
        $this->laporanSelesai = Laporan::where('user_id', $userId)->where('status', 'selesai')->count();

        $this->totalPemasukan = (float) Laporan::where('user_id', $userId)->sum('pemasukan');
        $this->totalPengeluaran = (float) Laporan::where('user_id', $userId)->sum('pengeluaran');

        // Ambil laporan per bulan (tahun ini) milik user ini
        $this->laporanPerBulan = Laporan::where('user_id', $userId)
            ->whereYear('tanggal', now()->year)
            ->get()
            ->groupBy(function ($item) {
                return Carbon::parse($item->tanggal)->format('m');
            })
            ->map->count()
            ->toArray();
    }

    public function render()
    {
        return view('livewire.user.dashboard-user', [
            'laporanPerBulan' => $this->laporanPerBulan,
        ]);
    }
}
