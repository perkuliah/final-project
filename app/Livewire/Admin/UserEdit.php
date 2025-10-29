<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log; // Tambahkan ini untuk logging

#[Layout('components.layouts.app')]
class UserEdit extends Component
{
    use WithFileUploads;

    public $id;
    public $name;
    public $email;
    public $username;
    public $whatsapp;
    public $alamat;
    public $role;
    public $currentPhoto; // Gunakan untuk menyimpan nama file foto lama
    public $foto; // Untuk file upload baru
    public $password;
    public $password_confirmation;
    public $email_verified;

    // Definisikan aturan dasar, tanpa unique untuk email/username
    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255', // Unique akan ditambahkan di mount
        'username' => 'required|string|max:255', // Unique akan ditambahkan di mount
        'whatsapp' => 'nullable|string|max:20',
        'alamat' => 'nullable|string',
        'role' => 'required|in:admin,user',
        'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'password' => 'nullable|string|min:3|confirmed',
    ];

    public function mount($id)
    {
        $this->id = $id;
        $user = User::findOrFail($id);

        $this->name = $user->name;
        $this->email = $user->email;
        $this->username = $user->username;
        $this->whatsapp = $user->whatsapp;
        $this->alamat = $user->alamat;
        $this->role = $user->role;
        $this->currentPhoto = $user->foto; // Simpan nama file foto lama
        $this->email_verified = !is_null($user->email_verified_at);

        // Tetapkan aturan unique dengan mengabaikan ID user saat ini
        $this->rules['email'] = 'required|email|max:255|unique:users,email,' . $id;
        $this->rules['username'] = 'required|string|max:255|unique:users,username,' . $id;
    }

    public function update()
    {
        Log::info('Update method called for user ID: ' . $this->id); // Log awal

        // Validasi input
        $validatedData = $this->validate();

        Log::info('Validation passed for user ID: ' . $this->id, $validatedData); // Log data yang lolos validasi

        $user = User::findOrFail($this->id);

        // Tangani upload foto
       $fotoPath = $user->foto; // Gunakan foto lama sebagai default
if ($this->foto) {
    // Hapus foto lama jika bukan default dan ada
    if ($user->foto && $user->foto !== 'default.jpg' && Storage::disk('public')->exists($user->foto)) { // Ganti 'default.jpg' sesuai kebutuhan
        if (!Storage::disk('public')->delete($user->foto)) {
            Log::warning('Failed to delete old photo: ' . $user->foto);
        }
    }
    // Simpan foto baru dan ambil path-nya
    $storedPath = $this->foto->store('users', 'public'); // $storedPath = 'users/nama_file.jpg'
    // Simpan path yang dihasilkan langsung ke database
    $fotoPath = $storedPath; // $fotoPath sekarang juga 'users/nama_file.jpg'
    Log::info('New photo stored: ' . $fotoPath);
}

        // Tangani password
        $password = $user->password; // Default ke password lama
        if ($this->password) {
            $password = bcrypt($this->password);
        }

        // Tangani email verification
        $emailVerifiedAt = $this->email_verified ? now() : null; // Jika dicentang, set ke now(), jika tidak, set ke null

        $updateData = [
            'name' => $this->name,
            'email' => $this->email,
            'username' => $this->username,
            'whatsapp' => $this->whatsapp,
            'alamat' => $this->alamat,
            'role' => $this->role,
            'foto' => $fotoPath,
            // 'password' => $password, // Sementara hapus baris ini untuk tes update data lainnya
            // 'email_verified_at' => $emailVerifiedAt, // Sementara hapus baris ini untuk tes update data lainnya
        ];

        // Tambahkan password dan email_verified_at ke updateData jika ada perubahan
        if ($this->password) {
            $updateData['password'] = $password;
        }
        // Perbarui email_verified_at terlepas dari apakah sebelumnya null atau tidak
        $updateData['email_verified_at'] = $emailVerifiedAt;

        Log::info('Data to be updated for user ID ' . $this->id . ': ', $updateData); // Log data yang akan di-update

        $user->update($updateData);

        Log::info('User updated successfully in database for ID: ' . $this->id);

        session()->flash('message', 'User berhasil diperbarui!');

        return redirect()->route('list-user');
    }


    public function removePhoto()
    {
        if ($this->currentPhoto && Storage::disk('public')->exists( $this->currentPhoto)) {
            if (Storage::disk('public')->delete($this->currentPhoto)) {
                 $this->currentPhoto = null; // Hapus referensi foto lama
                 $this->foto = null;         // Hapus file upload baru jika ada
                 session()->flash('message', 'Foto berhasil dihapus!');
            } else {
                 session()->flash('message', 'Gagal menghapus foto lama.');
            }
        } else {
            session()->flash('message', 'Foto tidak ditemukan.');
        }
    }

    public function render()
    {
        return view('livewire.admin.user-edit');
    }
}