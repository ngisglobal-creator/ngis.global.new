<div class="main-sidebar bg-white shadow-sm" id="sidebar">
    <!-- Logo / Brand -->
    <div class="p-3 border-bottom d-flex align-items-center justify-content-center" style="height: var(--topbar-height); background: linear-gradient(135deg, #050d1f 0%, #18335c 50%, #050d1f 100%); background-size: 200% 200%; animation: gradientWave 5s ease infinite;">
        <a href="{{ url('factory/dashboard') }}" class="text-decoration-none d-flex align-items-center gap-2">
            <img src="{{ asset('assets/images/logo-ngis.png') }}" alt="NGIS LOGO" style="height: 40px; object-fit: contain; filter: drop-shadow(0 0 5px rgba(255,255,255,0.2));">
            <div class="d-flex flex-column text-start">
                <span class="fw-bold text-white" style="font-family: 'Arial Black', Impact, sans-serif; font-size: 1.2rem; letter-spacing: 2px; line-height: 1;">NGIS</span>
                <span class="fw-bold" style="font-size: 0.5rem; letter-spacing: 1px; color: #d4af37;">GLOBAL INTEGRATED SERVICES</span>
            </div>
        </a>
    </div>

    <!-- User Info -->
    <div class="p-3 border-bottom text-center bg-white">
        <div class="text-uppercase fw-bold text-danger mb-2" style="font-size: 0.85rem; letter-spacing: 1px;">{{ __('dashboard.factory_panel') }}</div>
        <div class="fw-bold fs-5 text-dark mb-1">{{ Auth::user()->name ?? 'Factory' }}</div>
        <small class="text-success fw-bold"><i class="fa-solid fa-circle fa-xs me-1"></i> {{ __('dashboard.online') }}</small>
    </div>

    <!-- Navigation -->
    <div class="p-3 overflow-auto">
        <div class="text-muted small fw-bold mb-2 text-uppercase">{{ __('dashboard.main_nav') }}</div>
        <ul class="nav flex-column gap-1">
            <li class="nav-item">
                <a href="{{ url('factory/dashboard') }}" class="nav-link text-dark rounded {{ request()->is('factory/dashboard') ? 'bg-light fw-bold text-primary' : '' }}">
                    <i class="fa-solid fa-house fa-fw me-2"></i> {{ __('dashboard.home') }}
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('factory.notifications.index') }}" class="nav-link text-dark rounded d-flex justify-content-between align-items-center {{ request()->is('factory/notifications*') ? 'bg-light fw-bold text-primary' : '' }}">
                    <div><i class="fa-solid fa-bell fa-fw me-2"></i> {{ __('dashboard.notifications') }}</div>
                    @if(auth()->user()->unreadNotifications->count() > 0)
                        <span class="badge bg-danger rounded-pill">{{ auth()->user()->unreadNotifications->count() }}</span>
                    @endif
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('profile.edit') }}" class="nav-link text-dark rounded {{ request()->is('profile*') ? 'bg-light fw-bold text-primary' : '' }}">
                    <i class="fa-solid fa-industry fa-fw me-2"></i> {{ __('dashboard.profile') }}
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('factory.wallet') }}" class="nav-link text-dark rounded {{ request()->is('factory/my-wallet') ? 'bg-light fw-bold text-primary' : '' }}">
                    <i class="fa-solid fa-wallet fa-fw me-2"></i> {{ __('dashboard.wallet') }}
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('user-sectors.index') }}" class="nav-link text-dark rounded {{ request()->is('user-sectors*') ? 'bg-light fw-bold text-primary' : '' }}">
                    <i class="fa-solid fa-list fa-fw me-2"></i> {{ __('dashboard.sector_selection') }}
                </a>
            </li>
            
            <div class="text-muted small fw-bold mt-3 mb-2 text-uppercase">{{ __('dashboard.product_management') }}</div>
            <li class="nav-item">
                <a href="{{ route('products.create') }}" class="nav-link text-dark rounded {{ request()->is('products/create') ? 'bg-light fw-bold text-primary' : '' }}">
                    <i class="fa-solid fa-plus-circle fa-fw me-2"></i> {{ __('dashboard.upload_products') }}
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('cars.create') }}" class="nav-link text-dark rounded {{ request()->is('cars/create') ? 'bg-light fw-bold text-primary' : '' }}">
                    <i class="fa-solid fa-car fa-fw me-2"></i> {{ __('dashboard.add_car') }}
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('products.index') }}" class="nav-link text-dark rounded {{ request()->is('products') ? 'bg-light fw-bold text-primary' : '' }}">
                    <i class="fa-solid fa-cubes fa-fw me-2"></i> {{ __('dashboard.product_management') }}
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('orders.received') }}" class="nav-link text-dark rounded {{ request()->is('received-orders*') ? 'bg-light fw-bold text-primary' : '' }}">
                    <i class="fa-solid fa-shopping-cart fa-fw me-2"></i> {{ __('dashboard.order_management') }}
                </a>
            </li>

            <div class="text-muted small fw-bold mt-3 mb-2 text-uppercase">{{ __('dashboard.management_reports') }}</div>
            <li class="nav-item">
                <a href="{{ route('factory.management.inventory') }}" class="nav-link text-dark rounded {{ request()->is('factory/management/inventory*') ? 'bg-light fw-bold text-primary' : '' }}">
                    <i class="fa-solid fa-archive fa-fw me-2"></i> {{ __('dashboard.inventory_management') }}
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('factory.management.production_supply_reports') }}" class="nav-link text-dark rounded {{ request()->is('factory/management/production-supply-reports*') ? 'bg-light fw-bold text-primary' : '' }}">
                    <i class="fa-solid fa-chart-area fa-fw me-2"></i> {{ __('dashboard.production_reports') }}
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('factory.management.performance_kpi') }}" class="nav-link text-dark rounded {{ request()->is('factory/management/performance-kpi*') ? 'bg-light fw-bold text-primary' : '' }}">
                    <i class="fa-solid fa-chart-line fa-fw me-2"></i> {{ __('dashboard.kpi') }}
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('factory.management.risk_management') }}" class="nav-link text-dark rounded {{ request()->is('factory/management/risk-management*') ? 'bg-light fw-bold text-primary' : '' }}">
                    <i class="fa-solid fa-shield-halved fa-fw me-2"></i> {{ __('dashboard.liability_risk') }}
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('factory.management.support') }}" class="nav-link text-dark rounded {{ request()->is('factory/management/support*') ? 'bg-light fw-bold text-primary' : '' }}">
                    <i class="fa-solid fa-headset fa-fw me-2"></i> {{ __('dashboard.support_followup') }}
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
