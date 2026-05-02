<div class="main-sidebar bg-white shadow-sm" id="sidebar">
    <!-- Logo / Brand -->
    <div class="p-3 border-bottom d-flex align-items-center justify-content-center" style="height: var(--topbar-height); background: linear-gradient(135deg, #050d1f 0%, #18335c 50%, #050d1f 100%); background-size: 200% 200%; animation: gradientWave 5s ease infinite;">
        <a href="{{ url('client/dashboard') }}" class="text-decoration-none d-flex align-items-center gap-2">
            <img src="{{ asset('assets/images/logo-ngis.png') }}" alt="NGIS LOGO" style="height: 40px; object-fit: contain; filter: drop-shadow(0 0 5px rgba(255,255,255,0.2));">
            <div class="d-flex flex-column text-start">
                <span class="fw-bold text-white" style="font-family: 'Arial Black', Impact, sans-serif; font-size: 1.2rem; letter-spacing: 2px; line-height: 1;">NGIS</span>
                <span class="fw-bold" style="font-size: 0.5rem; letter-spacing: 1px; color: #d4af37;">GLOBAL INTEGRATED SERVICES</span>
            </div>
        </a>
    </div>

    <!-- User Info -->
    <div class="p-3 border-bottom text-center bg-white">
        <div class="text-uppercase fw-bold text-primary mb-2" style="font-size: 0.85rem; letter-spacing: 1px;">
            @if(auth()->user()->type == 'client')
                {{ __('dashboard.client_panel') }}
            @elseif(auth()->user()->type == 'merchant')
                {{ __('dashboard.merchant_panel') }}
            @elseif(auth()->user()->type == 'company_owner')
                {{ __('dashboard.company_owner_panel') }}
            @else
                {{ __('dashboard.client_panel') }}
            @endif
        </div>
        <div class="fw-bold fs-5 text-dark mb-1">{{ Auth::user()->name ?? 'Client' }}</div>
        <small class="text-success fw-bold"><i class="fa-solid fa-circle fa-xs me-1"></i> {{ __('dashboard.online') }}</small>
    </div>

    <!-- Navigation -->
    <div class="p-3 overflow-auto">
        <div class="text-muted small fw-bold mb-2 text-uppercase">{{ __('dashboard.main_nav') }}</div>
        <ul class="nav flex-column gap-1">
            <li class="nav-item">
                <a href="{{ url('client/dashboard') }}" class="nav-link text-dark rounded {{ request()->is('client/dashboard') ? 'bg-light fw-bold text-primary' : '' }}">
                    <i class="fa-solid fa-house fa-fw me-2"></i> {{ __('dashboard.home') }}
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('client.notifications.index') }}" class="nav-link text-dark rounded d-flex justify-content-between align-items-center {{ request()->is('client/notifications*') ? 'bg-light fw-bold text-primary' : '' }}">
                    <div><i class="fa-solid fa-bell fa-fw me-2"></i> {{ __('dashboard.notifications') }}</div>
                    @if(auth()->user()->unreadNotifications->count() > 0)
                        <span class="badge bg-danger rounded-pill">{{ auth()->user()->unreadNotifications->count() }}</span>
                    @endif
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('client.profile') }}" class="nav-link text-dark rounded {{ request()->is('client/profile*') ? 'bg-light fw-bold text-primary' : '' }}">
                    <i class="fa-solid fa-user fa-fw me-2"></i> {{ __('dashboard.profile') }}
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('client.wallet') }}" class="nav-link text-dark rounded {{ request()->is('client/my-wallet') ? 'bg-light fw-bold text-primary' : '' }}">
                    <i class="fa-solid fa-wallet fa-fw me-2"></i> {{ __('dashboard.wallet') }}
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('site.products.index') }}" class="nav-link text-dark rounded {{ request()->is('site-products*') ? 'bg-light fw-bold text-primary' : '' }}">
                    <i class="fa-solid fa-bag-shopping fa-fw me-2"></i> {{ __('dashboard.site_products') }}
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('user-sectors.index') }}" class="nav-link text-dark rounded {{ request()->is('user-sectors*') ? 'bg-light fw-bold text-primary' : '' }}">
                    <i class="fa-solid fa-list fa-fw me-2"></i> {{ __('dashboard.sector_selection') }}
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('client.orders.index') }}" class="nav-link text-dark rounded {{ request()->is('my-orders*') ? 'bg-light fw-bold text-primary' : '' }}">
                    <i class="fa-solid fa-cart-shopping fa-fw me-2"></i> {{ __('dashboard.order_management') }}
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('client.special_order') }}" class="nav-link text-dark rounded {{ request()->is('client/special-order') ? 'bg-light fw-bold text-primary' : '' }}">
                    <i class="fa-solid fa-wand-magic-sparkles fa-fw me-2"></i> {{ __('dashboard.special_import_request') }}
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('client.special_orders.index') }}" class="nav-link text-dark rounded {{ request()->is('client/special-orders*') ? 'bg-light fw-bold text-primary' : '' }}">
                    <i class="fa-solid fa-list-check fa-fw me-2"></i> {{ __('dashboard.my_special_orders') }}
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link text-dark rounded {{ request()->is('client/invoices*') ? 'bg-light fw-bold text-primary' : '' }}">
                    <i class="fa-solid fa-file-invoice fa-fw me-2"></i> {{ __('dashboard.my_invoices') }}
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('client.chat.index') }}" class="nav-link text-dark rounded d-flex justify-content-between align-items-center {{ request()->is('client/chat*') ? 'bg-light fw-bold text-primary' : '' }}">
                    <div><i class="fa-solid fa-envelope fa-fw me-2"></i> {{ __('dashboard.support_followup') }}</div>
                    @php
                        $unreadMessages = \App\Models\Message::where('receiver_id', auth()->id())->where('is_read', false)->count();
                    @endphp
                    @if($unreadMessages > 0)
                        <span class="badge bg-success rounded-pill">{{ $unreadMessages }}</span>
                    @endif
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('client.auctions.index') }}" class="nav-link text-dark rounded {{ request()->is('client/auctions*') ? 'bg-light fw-bold text-primary' : '' }}">
                    <i class="fa-solid fa-gavel fa-fw me-2"></i> {{ __('dashboard.auction_management') }}
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('client.risk_management.index') }}" class="nav-link text-dark rounded {{ request()->is('client/risk-management*') ? 'bg-light fw-bold text-primary' : '' }}">
                    <i class="fa-solid fa-triangle-exclamation fa-fw me-2"></i> {{ __('dashboard.liability_risk') }}
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('client.supplier_evaluation.index') }}" class="nav-link text-dark rounded {{ request()->is('client/supplier-evaluation*') ? 'bg-light fw-bold text-primary' : '' }}">
                    <i class="fa-solid fa-star fa-fw me-2"></i> {{ __('dashboard.supplier_evaluation') }}
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
