<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use App\Models\Laporan as LaporanModel;
use Illuminate\Support\Facades\Storage;

#[Layout('components.layouts.app')]
class Laporan extends Component
{
    public $search = '';

    public function deleteConfirm($id, $pemasukan)
    {
        $this->dispatch('confirm-delete', id: $id, pemasukan: $pemasukan);
    }

    public function delete($id)
    {
        $laporan = LaporanModel::findOrFail($id);

        // Check authorization
        if($laporan->user_id != Auth::user()->id && Auth::user()->role != 'admin') {
            session()->flash('error', 'Anda tidak memiliki hak untuk menghapus laporan ini');
            return;
        }

        try {
            // Delete file gambar if exists
            if($laporan->gambar) {
                // Get the filename from the gambar path
                $gambarPath = str_replace('/storage/laporan/', '', $laporan->gambar);

                if(Storage::disk('public')->exists('laporan/' . $gambarPath)) {
                    Storage::disk('public')->delete('laporan/' . $gambarPath);
                }
            }

            // Delete the record
            $laporan->delete();

            session()->flash('success', 'Laporan berhasil dihapus');
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal menghapus laporan: ' . $e->getMessage());
        }
    }

    public function getLaporan($id)
{
    $laporan = LaporanModel::with('user')->findOrFail($id);

    // Otorisasi: hanya pemilik atau admin yang boleh lihat
    if ($laporan->user_id !== auth()->id() && auth()->user()->role !== 'admin') {
        abort(403, 'Unauthorized');
    }

    // Pastikan URL gambar lengkap
    if ($laporan->gambar) {
        $laporan->gambar = asset($laporan->gambar);
    }

    // Format tanggal ke ISO untuk JS
    $laporan->tanggal = $laporan->tanggal ? $laporan->tanggal->toIso8601String() : null;

    return $laporan->toArray();
}

  public function render()
{
    $query = LaporanModel::query();

    // 🔒 Filter berdasarkan role: user hanya lihat miliknya
    if (Auth::user()->role === 'user') {
        $query->where('user_id', Auth::id());
    }

    // 🔍 Pencarian (hanya pada kolom yang relevan)
    if (!empty($this->search)) {
        $searchTerm = '%' . $this->search . '%';
        $query->where(function ($q) use ($searchTerm) {
            $q->where('judul', 'like', $searchTerm)
              ->orWhere('deskripsi', 'like', $searchTerm)
              ->orWhere('status', 'like', $searchTerm)
              ->orWhere('pemasukan', 'like', $searchTerm)
              ->orWhere('pengeluaran', 'like', $searchTerm);
        });
    }

    $laporans = $query->with('user')->orderBy('id', 'desc')->get();

    return view('livewire.laporan', compact('laporans'));
}
}
