<?php


use App\Livewire\Profile;
use App\Livewire\Dashboard;
use App\Livewire\Admin\Show;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Logout;
use App\Livewire\Auth\Register;
use App\Livewire\Admin\ListUser;
use App\Livewire\Admin\UserEdit;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});





Route::get('/login', Login::class)->name('login')->middleware('guest');
Route::get('/register', Register::class)->name('register')->middleware('auth');
Route::get('/logout', Logout::class)->name('logout')->middleware('auth');



Route::get('/dashboard', Dashboard::class)->name('dashboard')->middleware('auth');
Route::get('/profile', Profile::class)->name('profile')->middleware('auth');
Route::get('/list-user', ListUser::class)->name('list-user')->middleware('auth');
Route::get('/list-user/{id}', ListUser::class)->name('list-user')->middleware('auth');
Route::get('/list-user/{id}/edit', UserEdit::class)->name('list-user-edit')->middleware('auth');



