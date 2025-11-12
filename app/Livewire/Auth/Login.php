<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

#[Layout('components.layouts.auth')]
class Login extends Component
{
    public $email;
    public $password;
    public $remember = false;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required|min:4',
    ];

    public function login()
    {
        $this->validate();

        $credentials = [
            'email' => $this->email,
            'password' => $this->password,
        ];

        if (Auth::attempt($credentials, $this->remember)) {
            session()->regenerate();

            $user = Auth::user();

            // Redirect berdasarkan role
            if ($user->role === 'admin') {
                return $this->redirectRoute('dashboard-admin', ['id' => $user->id], navigate: false);
            } elseif ($user->role === 'user') {
                return $this->redirectRoute('profile-user', ['id' => $user->id], navigate: false);
            }

            // Fallback: ke home jika role tidak dikenali
            return $this->redirectRoute('home', navigate: false);
        }

        // Jika gagal login
        $this->addError('email', 'Email atau password salah.');
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}