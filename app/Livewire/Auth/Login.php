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

    public $success = false;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required|min:4',
    ];

    public function login()
    {
        $this->validate();

        // Coba login user
        if (Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            session()->regenerate();

            $this->success = true;

            

            // Redirect ke dashboard
            return redirect()->route('dashboard');
        }

        // Jika gagal
        $this->addError('email', 'Email or password is incorrect.');
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
