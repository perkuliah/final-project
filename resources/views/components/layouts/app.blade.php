<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assetss/img/apple-icon.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('assetss/img/favicon.png') }}">
    <title>@yield('title', 'Dashboard')</title>

    <!-- Fonts and icons -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <link href="{{ asset('assetss/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('assetss/css/nucleo-svg.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- CSS Files -->
    <link id="pagestyle" href="{{ asset('assetss/css/soft-ui-dashboard.css') }}" rel="stylesheet" />
    @livewireStyles
    @stack('css')
</head>

<body class="g-sidenav-show bg-gray-100">
    <!-- Sidebar tetap di luar main-content -->
    <livewire:atom.sidebar />

    <!-- Main content (termasuk navbar) -->
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <!-- Navbar di dalam main-content -->
        <livewire:atom.navbar />

        <div class="container-fluid py-4">
            {{ $slot }}
        </div>
    </main>

    <!-- Core JS Files -->
    <script src="{{ asset('assetss/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('assetss/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assetss/js/plugins/smooth-scrollbar.min.js') }}"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Toast Container -->
    <div id="toast" class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999;"></div>

    <script>
        function initUIComponents() {
            // Scrollbar untuk sidebar (Windows)
            if (navigator.platform.indexOf('Win') > -1 && document.querySelector('#sidenav-scrollbar')) {
                const Scrollbar = window.Scrollbar;
                if (Scrollbar) {
                    const el = document.querySelector('#sidenav-scrollbar');
                    const oldScrollbar = Scrollbar.get(el);
                    if (oldScrollbar) oldScrollbar.destroy();
                    Scrollbar.init(el, { damping: '0.5' });
                }
            }

            // Re-init Bootstrap components
            document.querySelectorAll('[data-bs-toggle="dropdown"]').forEach(el => {
                const dropdown = bootstrap.Dropdown.getInstance(el);
                if (!dropdown) new bootstrap.Dropdown(el);
            });

            // Burger button toggle (jika masih diperlukan di mobile)
            const burgerBtn = document.querySelector('.sidenav-toggler'); // gunakan class asli dari template
            if (burgerBtn) {
                burgerBtn.addEventListener('click', () => {
                    document.body.classList.toggle('g-sidenav-pinned');
                });
            }
        }

        document.addEventListener('livewire:initialized', () => {
            Livewire.on('show-alert', (data) => {
                const toastEl = document.createElement('div');
                toastEl.className = 'toast align-items-center text-white border-0';
                toastEl.setAttribute('role', 'alert');
                toastEl.setAttribute('aria-live', 'assertive');
                toastEl.setAttribute('aria-atomic', 'true');
                toastEl.innerHTML = `
                    <div class="d-flex">
                        <div class="toast-body">${data.message}</div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                    </div>
                `;

                const container = document.getElementById('toast');
                container.innerHTML = '';
                container.appendChild(toastEl);

                toastEl.classList.add(data.type === 'success' ? 'bg-success' : 'bg-danger');

                const bsToast = new bootstrap.Toast(toastEl, { delay: 5000 });
                bsToast.show();
            });
        });

        document.addEventListener('DOMContentLoaded', initUIComponents);
        document.addEventListener('livewire:navigated', initUIComponents);
    </script>

    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <script src="{{ asset('assetss/js/soft-ui-dashboard.js') }}"></script>

    @stack('scripts')
    @livewireScripts
</body>
</html>
