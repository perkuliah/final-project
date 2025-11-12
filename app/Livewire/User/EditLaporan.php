<?php

namespace App\Livewire\User;

use App\Models\Laporan;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

#[Layout('components.layouts.app')]
class EditLaporan extends Component
{
    public $laporanId;
    public $judul;
    public $pemasukan;
    public $pengeluaran;
    public $deskripsi;
    public $tanggal;
    public $gambarLama; // hanya untuk menampilkan preview
    public $status = 'menunggu';
    public $respon;

    protected $rules = [
        'judul' => 'required|min:3',
        'deskripsi' => 'required|min:10|max:1000',
        'tanggal' => 'required|date|before_or_equal:today',
        'pemasukan' => 'nullable|numeric|min:0',
        'pengeluaran' => 'nullable|numeric|min:0',
    ];

    public function mount($id)
    {
        $laporan = Laporan::findOrFail($id);

        // Pastikan user berhak mengedit
        if ($laporan->user_id != Auth::id() && Auth::user()->role !== 'admin') {
            abort(403, 'Anda tidak diizinkan mengakses laporan ini');
        }

        $this->laporanId = $laporan->id;
        $this->judul = $laporan->judul;
        $this->pemasukan = $laporan->pemasukan;
        $this->pengeluaran = $laporan->pengeluaran;
        $this->deskripsi = $laporan->deskripsi;
        $this->tanggal = $laporan->tanggal;
        $this->gambarLama = $laporan->gambar; // hanya untuk tampilan
        $this->status = $laporan->status;
        $this->respon = $laporan->respon;
    }

    public function update()
    {
        $this->validate();

        $laporan = Laporan::findOrFail($this->laporanId);

        $data = [
            'judul' => $this->judul,
            'deskripsi' => $this->deskripsi,
            'tanggal' => $this->tanggal,
            // ⚠️ Tidak ada field 'gambar' → gambar asli tetap utuh
        ];

        if (Auth::user()->role === 'admin') {
            $data['pemasukan'] = $this->pemasukan ?: 0;
            $data['pengeluaran'] = $this->pengeluaran ?: 0;
            $data['status'] = $this->status;
            $data['respon'] = $this->respon;
        }

        $laporan->update($data);

        session()->flash('success', 'Laporan berhasil diperbarui.');
        return redirect()->route('laporan');
    }

    public function render()
    {
        return view('livewire.user.edit-laporan');
    }
}
