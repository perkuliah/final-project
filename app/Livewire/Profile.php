<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

#[Layout('components.layouts.app')]
class Profile extends Component
{
    use WithFileUploads;

    public $name;
    public $username;
    public $email;
    public $whatsapp;
    public $alamat;
    public $foto;
    public $password;
    public $newFoto;

    public function mount()
    {
        $user = Auth::user();

        $this->name     = $user->name;
        $this->username = $user->username;
        $this->email    = $user->email;
        $this->whatsapp = $user->whatsapp;
        $this->alamat   = $user->alamat;
        $this->foto     = $user->foto;
    }

    public function updateProfile()
    {
        $user = Auth::user();

        $rules = [
            'name'      => 'required|string|max:255',
            'username'  => 'nullable|string|max:255|unique:users,username,' . $user->id,
            'email'     => 'required|email|unique:users,email,' . $user->id,
            'whatsapp'  => 'required|string|max:20|unique:users,whatsapp,' . $user->id,
            'alamat'    => 'nullable|string|max:500',
            'newFoto'   => 'nullable|image|mimes:png,jpg,jpeg|max:5000', // max 2MB
            'password'  => 'nullable|string|min:8',
        ];

        $messages = [
            'whatsapp.unique' => 'Nomor WhatsApp sudah digunakan oleh pengguna lain.',
            'email.unique'    => 'Email sudah digunakan oleh pengguna lain.',
            'username.unique' => 'Username sudah digunakan.',
            'password.min'    => 'Password minimal 8 karakter.',
        ];

        $this->validate($rules, $messages);

        // Handle foto upload
        if ($this->newFoto) {
            // Hapus foto lama jika ada
            if ($user->foto && Storage::disk('public')->exists('users/' . $user->foto)) {
                Storage::disk('public')->delete('users/' . $user->foto);
            }

            $filename = $this->newFoto->hashName();
            $this->newFoto->storeAs('public/users', $filename);
            $user->foto = $filename;
        }

        // Update data user
        $user->fill([
            'name'      => $this->name,
            'username'  => $this->username,
            'email'     => $this->email,
            'whatsapp'  => $this->whatsapp,
            'alamat'    => $this->alamat,
        ]);

        // Update password hanya jika diisi
        if (!empty($this->password)) {
            $user->password = Hash::make($this->password);
        }

        $user->save();

        // Dispatch event untuk SweetAlert + Redirect
        $this->dispatch('profileUpdated');

        // Reset password input agar tidak tersimpan di form
        $this->password = '';
        $this->newFoto = null;
    }

    public function render()
    {
        return view('livewire.profile');
    }
}
