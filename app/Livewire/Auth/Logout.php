<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Logout extends Component
{
    public function logout()
    {
        Auth::logout();

        // invalidate session agar aman
        session()->invalidate();
        session()->regenerateToken();

        // redirect ke halaman login
        return redirect()->route('login');
    }

    public function render()
    {
        return view('livewire.auth.logout');
    }
}
