<div class="main-sidebar bg-white shadow-sm" id="sidebar">
    <!-- Logo / Brand -->
    <div class="p-3 border-bottom d-flex align-items-center justify-content-center" style="height: var(--topbar-height); background: linear-gradient(135deg, #050d1f 0%, #18335c 50%, #050d1f 100%); background-size: 200% 200%; animation: gradientWave 5s ease infinite;">
        <a href="{{ url('china/dashboard') }}" class="text-decoration-none d-flex align-items-center gap-2">
            <img src="{{ asset('assets/images/logo-ngis.png') }}" alt="NGIS LOGO" style="height: 40px; object-fit: contain; filter: drop-shadow(0 0 5px rgba(255,255,255,0.2));">
            <div class="d-flex flex-column text-start">
                <span class="fw-bold text-white" style="font-family: 'Arial Black', Impact, sans-serif; font-size: 1.2rem; letter-spacing: 2px; line-height: 1;">NGIS</span>
                <span class="fw-bold" style="font-size: 0.5rem; letter-spacing: 1px; color: #d4af37;">CHINA HUB</span>
            </div>
        </a>
    </div>

    <!-- User Info -->
    <div class="p-3 border-bottom text-center bg-white">
        <div class="text-uppercase fw-bold mb-2" style="font-size: 0.85rem; letter-spacing: 1px; color: #856404;">{{ __('dashboard.china_panel') }}</div>
        <div class="fw-bold fs-5 text-dark mb-1">{{ Auth::user()->name ?? 'China Office' }}</div>
        <small class="text-success fw-bold"><i class="fa-solid fa-circle fa-xs me-1"></i> {{ __('dashboard.online') }}</small>
    </div>

    <!-- Navigation -->
    <div class="p-3 overflow-auto">
        <div class="text-muted small fw-bold mb-2 text-uppercase">{{ __('dashboard.main_nav') }}</div>
        <ul class="nav flex-column gap-1">
            <li class="nav-item">
                <a href="{{ url('china/dashboard') }}" class="nav-link text-dark rounded {{ request()->is('china/dashboard') ? 'bg-light fw-bold text-primary' : '' }}">
                    <i class="fa-solid fa-house fa-fw me-2"></i> {{ __('dashboard.home') }}
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('china.notifications.index') }}" class="nav-link text-dark rounded d-flex justify-content-between align-items-center {{ request()->is('china/notifications*') ? 'bg-light fw-bold text-primary' : '' }}">
                    <div><i class="fa-solid fa-bell fa-fw me-2"></i> {{ __('dashboard.notifications') }}</div>
                    @if(auth()->user()->unreadNotifications->count() > 0)
                        <span class="badge bg-danger rounded-pill">{{ auth()->user()->unreadNotifications->count() }}</span>
                    @endif
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('china.details') }}" class="nav-link text-dark rounded {{ request()->is('china/details') ? 'bg-light fw-bold text-primary' : '' }}">
                    <i class="fa-solid fa-circle-info fa-fw me-2"></i> {{ __('dashboard.ngis_details') }}
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('profile.edit') }}" class="nav-link text-dark rounded {{ request()->is('profile*') ? 'bg-light fw-bold text-primary' : '' }}">
                    <i class="fa-solid fa-globe fa-fw me-2"></i> {{ __('dashboard.profile') }}
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('china.wallet') }}" class="nav-link text-dark rounded {{ request()->is('china/my-wallet') ? 'bg-light fw-bold text-primary' : '' }}">
                    <i class="fa-solid fa-wallet fa-fw me-2"></i> {{ __('dashboard.wallet') }}
                </a>
            </li>

            <div class="text-muted small fw-bold mt-3 mb-2 text-uppercase">{{ __('dashboard.operations_reports') }}</div>
            <li class="nav-item">
                <a href="{{ route('products.index') }}" class="nav-link text-dark rounded {{ request()->is('products*') ? 'bg-light fw-bold text-primary' : '' }}">
                    <i class="fa-solid fa-cubes fa-fw me-2"></i> {{ __('dashboard.products_and_orders', 'Products & Orders') }}
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('china.invoices') }}" class="nav-link text-dark rounded {{ request()->is('china/invoices*') ? 'bg-light fw-bold text-primary' : '' }}">
                    <i class="fa-solid fa-file-invoice fa-fw me-2"></i> {{ __('dashboard.invoices') }}
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('china.regional_offices') }}" class="nav-link text-dark rounded {{ request()->is('china/regional-offices*') ? 'bg-light fw-bold text-primary' : '' }}">
                    <i class="fa-solid fa-building-user fa-fw me-2"></i> {{ __('dashboard.regional_offices') }}
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('china.customers') }}" class="nav-link text-dark rounded {{ request()->is('china/customers*') ? 'bg-light fw-bold text-primary' : '' }}">
                    <i class="fa-solid fa-users-viewfinder fa-fw me-2"></i> {{ __('dashboard.clients') }}
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('china.product_status') }}" class="nav-link text-dark rounded {{ request()->is('china/product-status*') ? 'bg-light fw-bold text-primary' : '' }}">
                    <i class="fa-solid fa-ship fa-fw me-2"></i> {{ __('dashboard.product_statuses', 'Product Statuses') }}
                </a>
            </li>

            <li class="nav-item mt-3 pt-3 border-top">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="nav-link text-danger w-100 text-start bg-transparent border-0 rounded hover-bg-light">
                        <i class="fa-solid fa-right-from-bracket fa-fw me-2"></i> {{ __('dashboard.logout') }}
                    </button>
                </form>
            </li>
        </ul>
    </div>
</div>

<style>
    @keyframes gradientWave {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
    .nav-link {
        font-weight: 600 !important;
        font-size: 15px;
        transition: all 0.2s ease;
    }
    .nav-link:hover {
        background-color: #f8f9fa;
        transform: translateX(-3px);
    }
    html[dir="ltr"] .nav-link:hover {
        transform: translateX(3px);
    }
    .hover-bg-light:hover {
        background-color: #f8f9fa;
    }
</style>
