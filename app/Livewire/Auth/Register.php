<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

#[Layout('components.layouts.app')]
class Register extends Component
{
    public $name;
    public $email;
    public $password;
    public $password_confirmation;
    public $role = ''; // JANGAN set default user/admin di sini
    public $whatsapp = '08';

    public function register()
    {
        $this->validate([
            'name' => 'required|string|min:3|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:3|same:password_confirmation',
            'role' => 'required|in:user,admin',
            'whatsapp' => 'required|starts_with:08',
        ]);

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'role' => $this->role, // ini sekarang akan ambil dari input dropdown
            'whatsapp' => $this->whatsapp,
        ]);

        // event(new Registered($user));

        session()->flash('success', 'Registrasi berhasil!');

        // reset hanya sebagian (biar gak override default)
        $this->reset(['name', 'email', 'password', 'password_confirmation', 'whatsapp', 'role']);
    }

    public function render()
    {
        return view('livewire.auth.register');
    }
}
