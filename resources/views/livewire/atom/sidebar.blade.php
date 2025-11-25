<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-2"
    id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a wire:navigate class="align-items-center d-flex m-0 navbar-brand text-wrap" href="{{ auth()->check() && auth()->user()->role === 'admin' ? route('dashboard-admin') : route('dashboard-user') }}">
            <img src="{{ asset('assetss/img/profil-pondok.png') }}" class="navbar-brand-img h-100" alt="...">
            <span class="ms-3 font-weight-bold">Laziss-App</span>
        </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            @if(auth()->check() && auth()->user()->role === 'admin')
            <li class="nav-item pb-2">
                <a wire:navigate class="nav-link {{ Route::currentRouteName() == 'dashboard-admin' ? 'active' : '' }}"
                    href="{{ route('dashboard-admin') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <img src="{{ asset('assetss/img/dashboard-logo.png') }}" alt="Image" class="img-fluid" style="width: 35px; height: 20px;">
                    </div>
                    <span class="nav-link-text ms-1">Dashboard admin</span>
                </a>
            </li>

            <li class="nav-item pb-2">
                <a wire:navigate class="nav-link {{ Route::currentRouteName() == 'profile' ? 'active' : '' }}"
                    href="{{ route('profile') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <img src="{{ asset('assetss/img/profile-logo.png') }}" alt="Image" class="img-fluid" style="width: 35px; height: 20px;">
                    </div>
                    <span class="nav-link-text ms-1">Profile</span>
                </a>
            </li>
            <li class="nav-item pb-2">
                <a wire:navigate class="nav-link {{ Route::currentRouteName() == 'register' ? 'active' : '' }}"
                    href="{{ route('register') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <img src="{{ asset('assetss/img/register-logo.png') }}" alt="Image" class="img-fluid" style="width: 40px; height: 20px;">
                    </div>
                    <span class="nav-link-text ms-1">Daftarkan Anggota</span>
                </a>
            </li>
            <li class="nav-item pb-2">
                <a wire:navigate class="nav-link {{ Route::currentRouteName() == 'list-user' ? 'active' : '' }}"
                    href="{{ route('list-user') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <img src="{{ asset('assetss/img/list-logo.png') }}" alt="Image" class="img-fluid" style="width: 40px; height: 20px;">
                    </div>
                    <span class="nav-link-text ms-1">Daftar Anggota</span>
                </a>
            </li>
            <li class="nav-item pb-2">
                <a wire:navigate class="nav-link {{ Route::currentRouteName() == 'laporan' ? 'active' : '' }}"
                    href="{{ route('laporan') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <img src="{{ asset('assetss/img/report-logo.png') }}" alt="Image" class="img-fluid" style="width: 40px; height: 20px;">
                    </div>
                    <span class="nav-link-text ms-1">Lapor</span>
                </a>
            </li>

            <li class="nav-item pb-2">
                <a wire:navigate class="nav-link {{ Route::currentRouteName() == 'admin.tasks' ? 'active' : '' }}"
                    href="{{ route('admin.tasks') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <img src="{{ asset('assetss/img/tasks-logo.png') }}" alt="Image" class="img-fluid" style="width: 40px; height: 20px;">
                    </div>
                    <span class="nav-link-text ms-1">Beri Tugas</span>
                </a>
            </li>
            @endif

            @if(auth()->check() && auth()->user()->role === 'user')
            <li class="nav-item pb-2">
                <a wire:navigate class="nav-link {{ Route::currentRouteName() == 'dashboard-user' ? 'active' : '' }}"
                    href="{{ route('dashboard-user') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <img src="{{ asset('assetss/img/dashboard-logo.png') }}" alt="Image" class="img-fluid" style="width: 35px; height: 20px;">
                    </div>
                    <span class="nav-link-text ms-1">Dashboard-user</span>
                </a>
            </li>
            <li class="nav-item pb-2">
                <a wire:navigate class="nav-link {{ Route::currentRouteName() == 'profile-user' ? 'active' : '' }}"
                    href="{{ route('profile-user') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <img src="{{ asset('assetss/img/profile-logo.png') }}" alt="Image" class="img-fluid" style="width: 35px; height: 20px;">
                    </div>
                    <span class="nav-link-text ms-1">Profile</span>
                </a>
            </li>
            <li class="nav-item pb-2">
                <a wire:navigate class="nav-link {{ Route::currentRouteName() == 'tasks.user' ? 'active' : '' }}"
                    href="{{ route('tasks.user') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <img src="{{ asset('assetss/img/tasks-logo.png') }}" alt="Image" class="img-fluid" style="width: 40px; height: 20px;">
                    </div>
                    <span class="nav-link-text ms-1">Tugas</span>
                </a>
            </li>
            <li class="nav-item pb-2">
                <a wire:navigate class="nav-link {{ Route::currentRouteName() == 'laporan-user' ? 'active' : '' }}"
                    href="{{ route('laporan-user') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <img src="{{ asset('assetss/img/report-logo.png') }}" alt="Image" class="img-fluid" style="width: 40px; height: 20px;">
                    </div>
                    <span class="nav-link-text ms-1">Lapor</span>
                </a>
            </li>
            @endif
            <li class="nav-link mb-0">
                    <livewire:auth.logout/>
            </li>
        </ul>
    </div>
</aside>
