<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\User;

#[Layout('components.layouts.auth')]
class Login extends Component
{
    public $email;
    public $password;
    public $remember = false;
    public $showVerificationMessage = false;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required|min:4',
    ];

    public function login()
    {
        $this->validate();
        $this->showVerificationMessage = false;

        // Cari user dan verifikasi status email
        $user = User::where('email', $this->email)->first();

        // Cek jika user tidak ditemukan
        if (!$user) {
            $this->addError('email', 'Email atau password salah.');
            return;
        }

        // Cek jika email belum diverifikasi
        if (is_null($user->email_verified_at)) {
            $this->showVerificationMessage = true;
            $this->addError('email', 'Email Anda belum diverifikasi. Silakan verifikasi email terlebih dahulu sebelum login.');
            return;
        }

        // Cek jika password salah
        if (!Auth::attempt([
            'email' => $this->email,
            'password' => $this->password
        ], $this->remember)) {
            $this->addError('email', 'Email atau password salah.');
            return;
        }

        session()->regenerate();

        $user = Auth::user();

        // Redirect berdasarkan role
        if ($user->role === 'admin') {
            return $this->redirectRoute('dashboard-admin', navigate: false);
        } elseif ($user->role === 'user') {
            return $this->redirectRoute('dashboard-user', navigate: false);
        }

        return $this->redirectRoute('home', navigate: false);
    }

    // Method untuk reset pesan verifikasi
    public function resetVerificationMessage()
    {
        $this->showVerificationMessage = false;
    }
}
