<?php


use App\Livewire\Laporan;
use App\Livewire\Profile;
use App\Livewire\Admin\Task;
use App\Livewire\Auth\Login;
use App\Livewire\Admin\Tasks;
use App\Livewire\Auth\Logout;
use App\Livewire\Auth\Register;
use App\Livewire\Admin\ListUser;
use App\Livewire\Admin\UserEdit;
use App\Livewire\User\EditLaporan;
use App\Livewire\User\LaporanUser;
use App\Livewire\User\ProfileUser;
use App\Livewire\User\CreateLaporan;
use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\DashboardAdmin;
use App\Livewire\User\DashboardUser;
use App\Livewire\User\Tasks as UserTasks;

Route::get('/', function () {
    return view('welcome');
});



Route::get('/login', Login::class)->name('login')->middleware('guest');
Route::get('/logout', Logout::class)->name('logout')->middleware('guest');



Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
    Route::get('/dashboard-admin', DashboardAdmin::class)->name('dashboard-admin');
    Route::get('/list-user', ListUser::class)->name('list-user');
    Route::get('/list-user/{id}/edit', UserEdit::class)->name('list-user-edit');
    Route::get('/laporan', Laporan::class)->name('laporan');
    Route::get('/laporan/create-laporan', CreateLaporan::class)->name('createlaporan');
    Route::get('/laporan/edit-laporan/{id}', EditLaporan::class)->name('editlaporan');
    Route::get('/logout', Logout::class)->name('logout');
    Route::get('/register', Register::class)->name('register');
    Route::get('/profile', Profile::class)->name('profile');
    Route::get('/admin/tasks', Tasks::class)->name('admin.tasks');
});

Route::get('/laporan/edit-laporan/{id}', EditLaporan::class)->name('editlaporan');

Route::middleware(['auth', 'verified', 'role:user'])->group(function () {
    Route::get('/profile-user', ProfileUser::class)->name('profile-user');
    Route::get('/laporan-user', LaporanUser::class)->name('laporan-user');
    Route::get('/dashboard-user', DashboardUser::class)->name('dashboard-user');
    Route::get('/laporan/create-laporan-user', CreateLaporan::class)->name('createlaporanuser');
    Route::get('/Task', UserTasks::class)->name('tasks.user');
    Route::get('/logout', Logout::class)->name('logout');
});
