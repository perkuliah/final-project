<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
    <title>
        @yield('title', 'Dashboard')
    </title>
    <!-- Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="{{ asset('assetss/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('assetss/css/nucleo-svg.css') }}" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="{{ asset('assetss/css/nucleo-svg.css') }}" rel="stylesheet" />
    <!-- CSS Files -->
    <link id="pagestyle" href="{{ asset('assetss/css/soft-ui-dashboard.css') }}" rel="stylesheet" />
    @livewireStyles

</head>

<body class="g-sidenav-show bg-gray-100">


<div id="app">

        <livewire:atom.sidebar/>
        <livewire:atom.navbar/>
        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>
            
            <main>
                @yield('content')
                {{ $slot }}
            </main>

            


        </div>
    </div>

    <!--   Core JS Files   -->
    <script src="{{ asset('assetss/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('assetss/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assetss/js/plugins/smooth-scrollbar.min.js') }}"></script>
    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>
    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="{{ asset('assetss/js/soft-ui-dashboard.js') }}"></script>
    <script src="{{ asset('brutalist/script.js') }}"></script>
    <script src="{{ asset('brutalist/form-utils.js') }}"></script>
    
    @livewireScripts
</body>

</html>
