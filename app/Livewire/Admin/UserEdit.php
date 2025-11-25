<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

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
    public $currentPhoto;
    public $foto;
    public $password;
    public $password_confirmation;
    public $email_verified;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'username' => 'required|string|max:255',
        'whatsapp' => 'nullable|string|max:20',
        'alamat' => 'nullable|string',
        'role' => 'required|in:admin,user',
        'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'password' => 'nullable|string|min:3|confirmed',
        'email_verified' => 'nullable|boolean',
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
        $this->currentPhoto = $user->foto;
        $this->email_verified = !is_null($user->email_verified_at);

        // Set aturan unique dengan mengabaikan ID user saat ini
        $this->rules['email'] = 'required|email|max:255|unique:users,email,' . $id;
        $this->rules['username'] = 'required|string|max:255|unique:users,username,' . $id;
    }

    public function update()
    {
        Log::info('🔥 Tombol Simpan DIKLIK!');
        Log::info('Nilai email_verified:', [$this->email_verified]);

        try {
            // Validasi input
            $this->validate();

            $user = User::findOrFail($this->id);

            // Handle upload foto
            $fotoPath = $user->foto;
            if ($this->foto) {
                // Hapus foto lama jika ada dan bukan default
                if ($user->foto && $user->foto !== 'default.jpg' && Storage::disk('public')->exists($user->foto)) {
                    Storage::disk('public')->delete($user->foto);
                }

                // Simpan foto baru
                $fotoPath = $this->foto->store('users', 'public');
                Log::info('New photo stored: ' . $fotoPath);
            }

            // Handle password
            $updateData = [
                'name' => $this->name,
                'email' => $this->email,
                'username' => $this->username,
                'whatsapp' => $this->whatsapp,
                'alamat' => $this->alamat,
                'role' => $this->role,
                'foto' => $fotoPath,
                'email_verified_at' => $this->email_verified ? now() : null,
            ];

            // Update password hanya jika diisi
            if (!empty($this->password)) {
                $updateData['password'] = bcrypt($this->password);
            }

            Log::info('Data to be updated:', $updateData);

            // Update user
            $user->update($updateData);

            Log::info('User updated successfully');

            session()->flash('message', 'User berhasil diperbarui!');
            return redirect()->route('list-user');

        } catch (\Exception $e) {
            Log::error('Error updating user: ' . $e->getMessage());
            session()->flash('error', 'Terjadi kesalahan saat memperbarui user: ' . $e->getMessage());
        }
    }

    public function removePhoto()
    {
        try {
            $user = User::findOrFail($this->id);

            if ($user->foto && $user->foto !== 'default.jpg' && Storage::disk('public')->exists($user->foto)) {
                Storage::disk('public')->delete($user->foto);
            }

            // Update database
            $user->update(['foto' => null]);

            $this->currentPhoto = null;
            $this->foto = null;

            session()->flash('message', 'Foto berhasil dihapus!');
        } catch (\Exception $e) {
            Log::error('Error removing photo: ' . $e->getMessage());
            session()->flash('error', 'Terjadi kesalahan saat menghapus foto');
        }
    }

    public function render()
    {
        return view('livewire.admin.user-edit');
    }
}
