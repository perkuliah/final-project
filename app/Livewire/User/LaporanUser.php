<?php

namespace App\Livewire\User;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use App\Models\Laporan as LaporanModel;
use Illuminate\Support\Facades\Storage;

#[Layout('components.layouts.app')]
class LaporanUser extends Component
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

    public function render()
    {
        $laporans = LaporanModel::query();

        if(Auth::user()->role == 'user') {
            $laporans->where('user_id', Auth::user()->id);
        }

        if(!empty($this->search)) {
            $laporans->where(function ($query) {
                $query->where('pemasukan', 'like', '%' . $this->search . '%')
                    ->orWhere('pengeluaran', 'like', '%' . $this->search . '%')
                    ->orWhere('judul', 'like', '%' . $this->search . '%')
                    ->orWhere('deskripsi', 'like', '%' . $this->search . '%')
                    ->orWhere('status', 'like', '%' . $this->search . '%');
            });
        }

        return view('livewire.user.laporan-user',[
            'laporans' => $laporans->orderBy('id', 'desc')->get()
        ]);
    }
}
