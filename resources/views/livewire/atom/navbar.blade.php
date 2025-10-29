
    <main class="main-content mt-1 border-radius-lg">
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur"
        navbar-scroll="true">
        <div class="container-fluid py-1 px-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                    <li class="breadcrumb-item text-md"><a class="opacity-5 text-dark" href="javascript:;">Pages</a>
                    </li>
                    <li class="breadcrumb-item text-sm text-dark active text-capitalize" aria-current="page">
                        {{ str_replace('-', ' ', Route::currentRouteName()) }}</li>
                </ol>
                <h6 class="font-weight-bolder mb-0 text-capitalize">
                    {{ str_replace('-', ' ', Route::currentRouteName()) }}</h6>
            </nav>
            <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4 d-flex justify-content-end" id="navbar">
                
                <ul class="navbar-nav justify-content-end">
                    <li class="nav-item d-flex align-items-center">
                        <a href="javascript:;" class="nav-link text-body font-weight-bold px-0">
                        </a>
                    </li>
                    <li class="nav-item d-xl-none ps-3 d-flex align-items-center me-3">
                        <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                            <div class="sidenav-toggler-inner">
                                <i class="sidenav-toggler-line"></i>
                                <i class="sidenav-toggler-line"></i>
                                <i class="sidenav-toggler-line"></i>
                            </div>
                        </a>
                    </li>
                    
                    <li class="nav-item dropdown pe-2 d-flex align-items-center me-3">
                        <a href="javascript:;" class="nav-link text-body p-0" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-bell cursor-pointer"></i>
                        </a>
                    </li>
                    <!-- User Dropdown -->
<li class="nav-item dropdown pe-2 d-flex align-items-center ">
    <a href="javascript:;" class="nav-link text-body p-0" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
        <div class="avatar avatar-sm rounded-circle bg-gradient-primary d-flex align-items-center justify-content-center">
            <span class="text-white text-sm font-weight-bold">
                {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 2)) }}
            </span>
        </div>
    </a>
    <ul class="dropdown-menu dropdown-menu-end px-1 py-2 me-sm-n4" aria-labelledby="dropdownUser">
        <li class="mb-2">
            <a class="dropdown-item border-radius-md" href="{{ route('profile') }}">
                <div class="d-flex py-1">
                    <div class="my-auto">
                        <i class="fa fa-user text-sm text-primary me-3"></i>
                    </div>
                    <div class="d-flex flex-column justify-content-center">
                        <h6 class="text-sm font-weight-normal mb-1">My Profile</h6>
                    </div>
                </div>
            </a>
        </li>
        <li class="mb-2">
            <a class="dropdown-item border-radius-md" href="{{ route('profile') }}">
                <div class="d-flex py-1">
                    <div class="my-auto">
                        <i class="fa fa-cog text-sm text-primary me-3"></i>
                    </div>
                    <div class="d-flex flex-column justify-content-center">
                        <h6 class="text-sm font-weight-normal mb-1">Settings</h6>
                    </div>
                </div>
            </a>
        </li>
        <li>
            <hr class="dropdown-divider">
        </li>
        <li>
            <form method="POST" action="{{ route('logout') }}" class="m-0">
                @csrf
                <button type="submit" class="dropdown-item border-radius-md text-danger">
                    <div class="d-flex py-1">
                        <div class="my-auto">
                            <i class="fa fa-sign-out-alt text-sm text-danger me-3"></i>
                        </div>
                        <div class="d-flex flex-column justify-content-center">
                            <h6 class="text-sm font-weight-normal mb-1">Log Out</h6>
                        </div>
                    </div>
                </button>
            </form>
        </li>
    </ul>
</li>
                </ul>
            </div>
            <!-- User Dropdown -->
           
        </div>
    </nav>

