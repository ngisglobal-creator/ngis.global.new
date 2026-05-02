<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', __('dashboard.factory_panel') . ' | NGIS')</title>

    <!-- Bootstrap 5 -->
    @if(app()->getLocale() == 'ar')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css">
    @else
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    @endif
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- Custom Clean Styles -->
    <style>
        :root {
            --sidebar-width: 260px;
            --topbar-height: 70px;
        }
        body {
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background-color: #f4f6f9;
            color: #212529;
            overflow-x: hidden;
        }
        
        /* Layout Grid */
        .wrapper {
            display: flex;
            width: 100%;
            min-height: 100vh;
        }

        /* Sidebar Styling */
        .main-sidebar {
            width: var(--sidebar-width);
            background: #fff;
            border-left: 1px solid #dee2e6;
            display: flex;
            flex-direction: column;
            transition: all 0.3s;
            z-index: 1040;
            box-shadow: -2px 0 10px rgba(0,0,0,0.02);
        }
        
        /* Content Area */
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
            overflow-y: auto;
        }

        /* Header Styling */
        .main-header {
            height: var(--topbar-height);
            background: #fff;
            border-bottom: 1px solid #dee2e6;
            display: flex;
            align-items: center;
            padding: 0 1.5rem;
            justify-content: space-between;
            z-index: 1030;
            box-shadow: 0 2px 10px rgba(0,0,0,0.02);
        }

        /* Utilities */
        .english-nums {
            font-family: Arial, Helvetica, sans-serif !important;
            direction: ltr;
            unicode-bidi: isolate;
        }
        
        @media (max-width: 991.98px) {
            .main-sidebar {
                position: fixed;
                height: 100vh;
                box-shadow: 0 0 15px rgba(0,0,0,0.1);
            }
            html[dir="rtl"] .main-sidebar {
                right: calc(-1 * var(--sidebar-width));
                left: auto;
            }
            html[dir="rtl"] .main-sidebar.show {
                right: 0;
            }
            html[dir="ltr"] .main-sidebar {
                left: calc(-1 * var(--sidebar-width));
                right: auto;
            }
            html[dir="ltr"] .main-sidebar.show {
                left: 0;
            }
        }

        /* Page Loader CSS */
        .page-loader-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(244, 246, 249, 0.8);
            backdrop-filter: blur(8px);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: opacity 0.5s ease, visibility 0.5s ease;
        }
        .page-loader-overlay.hidden {
            opacity: 0;
            visibility: hidden;
        }
        .loader-wrapper {
            position: relative;
            width: 120px;
            height: 120px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .loader-logo {
            width: 60px;
            height: 60px;
            object-fit: contain;
            z-index: 10;
            filter: drop-shadow(0 0 10px rgba(13, 110, 253, 0.2));
            animation: pulse 2s ease-in-out infinite;
        }
        .spinner-ring {
            position: absolute;
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 3px solid transparent;
            border-top-color: #0d6efd;
            border-bottom-color: #0d6efd;
            animation: rotate 1.5s linear infinite;
        }
        .spinner-ring-inner {
            position: absolute;
            width: 80px;
            height: 80px;
            border-radius: 50%;
            border: 3px solid transparent;
            border-left-color: #d4af37;
            border-right-color: #d4af37;
            animation: rotate-reverse 1s linear infinite;
        }
        @keyframes rotate {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        @keyframes rotate-reverse {
            0% { transform: rotate(360deg); }
            100% { transform: rotate(0deg); }
        }
        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.1); opacity: 0.8; }
        }
    </style>
    @yield('styles')
    @stack('styles')
</head>
<body>
    <!-- Page Loader -->
    <div id="page-loader" class="page-loader-overlay">
        <div class="loader-wrapper">
            <img src="{{ asset('assets/images/logo-ngis.png') }}" class="loader-logo" alt="NGIS">
            <div class="spinner-ring"></div>
            <div class="spinner-ring-inner"></div>
        </div>
    </div>
    <div class="wrapper">
        <!-- Sidebar -->
        @include('factory.layouts.sidebar')

        <!-- Main Content Wrapper -->
        <div class="main-content">
            <!-- Header -->
            @include('factory.layouts.header')

            <!-- Page Content -->
            <div class="container-fluid p-4">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Core Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        // Page Loader Logic
        window.addEventListener('load', function() {
            const loader = document.getElementById('page-loader');
            if (loader) {
                setTimeout(() => {
                    loader.classList.add('hidden');
                    setTimeout(() => loader.style.display = 'none', 500); 
                }, 400);
            }
        });

        // Handle BFCache (Browser Back Button)
        window.addEventListener('pageshow', function(event) {
            const loader = document.getElementById('page-loader');
            if (loader) {
                loader.classList.add('hidden');
                loader.style.display = 'none';
            }
        });

        document.addEventListener('click', function(e) {
            const target = e.target.closest('a');
            if (target && target.href && !target.getAttribute('href').startsWith('#') && !target.target && target.hostname === window.location.hostname) {
                const loader = document.getElementById('page-loader');
                if (loader) {
                    loader.style.display = 'flex';
                    setTimeout(() => loader.classList.remove('hidden'), 10);
                }
            }
        });

        // Sidebar Toggle Logic for Mobile
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.getElementById('sidebarToggle');
            const sidebar = document.querySelector('.main-sidebar');
            if(toggleBtn && sidebar) {
                toggleBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    sidebar.classList.toggle('show');
                });
                
                document.addEventListener('click', function(e) {
                    if (window.innerWidth <= 991.98 && sidebar.classList.contains('show')) {
                        if (!sidebar.contains(e.target) && !toggleBtn.contains(e.target)) {
                            sidebar.classList.remove('show');
                        }
                    }
                });
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
