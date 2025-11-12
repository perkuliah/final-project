<?php

namespace App\Livewire\User;

use App\Models\Laporan;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

#[Layout('components.layouts.app')]
class CreateLaporan extends Component
{
    use WithFileUploads;

    public $judul;
    public $pemasukan;
    public $pengeluaran;
    public $deskripsi;
    public $tanggal;
    public $gambar;
    public $status = 'menunggu';
    public $lokasi; // Tambahkan property lokasi

    // Properti hanya untuk binding tampilan
    public $formattedPemasukan;
    public $formattedPengeluaran;

    protected $rules = [
        'judul' => 'required|min:3|max:255',
        'deskripsi' => 'required|min:10|max:1000',
        'tanggal' => 'required|date|before_or_equal:today',
        'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:5048',
        'pemasukan' => 'nullable|numeric|min:0',
        'pengeluaran' => 'nullable|numeric|min:0',
        'lokasi' => 'required|in:Salem,Bentar,Bentarsari,Bumiayu,Cilacap', // Validasi lokasi
    ];

    protected $messages = [
        'judul.required' => 'Judul laporan wajib diisi.',
        'judul.min' => 'Judul minimal 3 karakter.',
        'judul.max' => 'Judul maksimal 255 karakter.',
        'deskripsi.required' => 'Deskripsi laporan wajib diisi.',
        'deskripsi.min' => 'Deskripsi minimal 10 karakter.',
        'deskripsi.max' => 'Deskripsi maksimal 1000 karakter.',
        'tanggal.required' => 'Tanggal laporan wajib diisi.',
        'tanggal.before_or_equal' => 'Tanggal tidak boleh melebihi hari ini.',
        'gambar.image' => 'File harus berupa gambar.',
        'gambar.mimes' => 'Gambar harus format JPG, JPEG, atau PNG.',
        'gambar.max' => 'Ukuran gambar maksimal 5 MB.',
        'pemasukan.numeric' => 'Pemasukan harus berupa angka.',
        'pemasukan.min' => 'Pemasukan tidak boleh negatif.',
        'pengeluaran.numeric' => 'Pengeluaran harus berupa angka.',
        'pengeluaran.min' => 'Pengeluaran tidak boleh negatif.',
        'lokasi.required' => 'Lokasi wajib dipilih.',
        'lokasi.in' => 'Lokasi yang dipilih tidak valid.',
    ];

    public function mount()
    {
        // Set default values
        $this->tanggal = now()->format('Y-m-d');
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    // Method untuk mendapatkan daftar lokasi
    public function getLokasiOptionsProperty()
    {
        return Laporan::getLokasiOptions();
    }

    public function save()
    {
        $this->validate();

        // Validasi minimal salah satu isi (pemasukan atau pengeluaran)
        if (empty($this->pemasukan) && empty($this->pengeluaran)) {
            $this->addError('pemasukan', 'Minimal isi pemasukan atau pengeluaran.');
            $this->addError('pengeluaran', 'Minimal isi pemasukan atau pengeluaran.');
            return;
        }

        // Proses upload gambar
        $gambarName = null;
        if ($this->gambar) {
            $gambarName = Str::uuid() . '.' . $this->gambar->getClientOriginalExtension();
            $this->gambar->storeAs('public/laporan/', $gambarName);
        }

        // Create laporan
        Laporan::create([
            'user_id' => Auth::id(),
            'judul' => $this->judul,
            'pemasukan' => $this->pemasukan ? (int) $this->pemasukan : 0,
            'pengeluaran' => $this->pengeluaran ? (int) $this->pengeluaran : 0,
            'deskripsi' => $this->deskripsi,
            'tanggal' => $this->tanggal,
            'gambar' => $gambarName,
            'status' => $this->status,
            'lokasi' => $this->lokasi, // Simpan lokasi
        ]);

        session()->flash('success', 'Laporan berhasil dibuat dan menunggu verifikasi.');

        // Reset form
        $this->reset([
            'judul',
            'pemasukan',
            'pengeluaran',
            'deskripsi',
            'tanggal',
            'gambar',
            'lokasi',
            'formattedPemasukan',
            'formattedPengeluaran'
        ]);

        $this->tanggal = now()->format('Y-m-d'); // Set kembali tanggal default
    }

    public function render()
    {
        return view('livewire.user.create-laporan-user');
    }
}
