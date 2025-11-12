<?php

namespace App\Livewire\User;

use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

#[Layout('components.layouts.app')]
class ProfileUser extends Component
{
    use WithFileUploads;

    public $name, $username, $email, $whatsapp, $alamat, $foto, $password, $newFoto;

    public function mount()
    {
        $user           = Auth::user();

        $this->name     = $user->name;
        $this->username = $user->username;
        $this->email    = $user->email;
        $this->whatsapp = $user->whatsapp;
        $this->alamat   = $user->alamat;
        $this->foto     = $user->foto;
    }

    public function updateProfile()
    {
        $user = User::findOrFail(Auth::user()->id);

        $this->validate([
            'name'      => 'required|string|max:255',
            'username'  => 'nullable|string|max:255|unique:users,username,' . $user->id,
            'email'     => 'required|email|unique:users,email,' . $user->id,
            'whatsapp'  => 'required|string|unique:users,whatsapp,' . $user->id,
            'alamat'    => 'nullable|string',
            'newFoto'   => 'nullable|image|max:2048',
            'password'  => 'nullable'
        ]);

        if ($this->newFoto) {
            if ($user->foto && Storage::disk('public')->exists('users/' . $user->foto)) {
                Storage::disk('public')->delete('users/' . $user->foto);
            }
            $this->newFoto->storeAs('public/users', $this->newFoto->hashName());
            $user->foto = $this->newFoto->hashName();
        }

        $user->name = $this->name;
        $user->username = $this->username;
        $user->email = $this->email;
        $user->whatsapp = $this->whatsapp;
        $user->alamat = $this->alamat;

        if ($this->password) {
            $user->password = Hash::make($this->password);
        }

        $user->save();

        // $this->redirectIntended(route('user.profile'), navigate: true);

        $this->dispatch('profileUpdated');

        // 1. Emit / Dispatch   = Orang yang pencet bell rumah
        // 2. Listener          = Orang rumah yang mendengar bell
        // 3. Handler           = Orang rumah yang merespon bell (membuka pintu rumah)
    }

    public function render()
    {
        return view('livewire.user.profile-user');
    }
}
