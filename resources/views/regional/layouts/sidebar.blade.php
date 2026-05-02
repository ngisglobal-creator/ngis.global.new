<div class="main-sidebar bg-white shadow-sm" id="sidebar">
    <!-- Logo / Brand -->
    <div class="p-3 border-bottom d-flex align-items-center justify-content-center" style="height: var(--topbar-height); background: linear-gradient(135deg, #050d1f 0%, #18335c 50%, #050d1f 100%); background-size: 200% 200%; animation: gradientWave 5s ease infinite;">
        <a href="{{ url('regional/dashboard') }}" class="text-decoration-none d-flex align-items-center gap-2">
            <img src="{{ asset('assets/images/logo-ngis.png') }}" alt="NGIS LOGO" style="height: 40px; object-fit: contain; filter: drop-shadow(0 0 5px rgba(255,255,255,0.2));">
            <div class="d-flex flex-column text-start">
                <span class="fw-bold text-white" style="font-family: 'Arial Black', Impact, sans-serif; font-size: 1.2rem; letter-spacing: 2px; line-height: 1;">NGIS</span>
                <span class="fw-bold" style="font-size: 0.5rem; letter-spacing: 1px; color: #d4af37;">REGIONAL OFFICE</span>
            </div>
        </a>
    </div>

    <!-- User Info -->
    <div class="p-3 border-bottom text-center bg-white">
        <div class="text-uppercase fw-bold text-info mb-2" style="font-size: 0.85rem; letter-spacing: 1px;">{{ __('dashboard.regional_panel') }}</div>
        <div class="fw-bold fs-5 text-dark mb-1">{{ Auth::user()->name ?? 'Regional Office' }}</div>
        <small class="text-success fw-bold"><i class="fa-solid fa-circle fa-xs me-1"></i> {{ __('dashboard.online') }}</small>
    </div>

    <!-- Navigation -->
    <div class="p-3 overflow-auto">
        <div class="text-muted small fw-bold mb-2 text-uppercase">{{ __('dashboard.main_nav') }}</div>
        <ul class="nav flex-column gap-1">
            <li class="nav-item">
                <a href="{{ url('regional/dashboard') }}" class="nav-link text-dark rounded {{ request()->is('regional/dashboard') ? 'bg-light fw-bold text-primary' : '' }}">
                    <i class="fa-solid fa-house fa-fw me-2"></i> {{ __('dashboard.home') }}
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('regional.details') }}" class="nav-link text-dark rounded {{ request()->is('regional/details') ? 'bg-light fw-bold text-primary' : '' }}">
                    <i class="fa-solid fa-circle-info fa-fw me-2"></i> {{ __('dashboard.ngis_details') }}
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('regional.notifications.index') }}" class="nav-link text-dark rounded d-flex justify-content-between align-items-center {{ request()->is('regional/notifications*') ? 'bg-light fw-bold text-primary' : '' }}">
                    <div><i class="fa-solid fa-bell fa-fw me-2"></i> {{ __('dashboard.notifications') }}</div>
                    @if(auth()->user()->unreadNotifications->count() > 0)
                        <span class="badge bg-danger rounded-pill">{{ auth()->user()->unreadNotifications->count() }}</span>
                    @endif
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('regional.wallet') }}" class="nav-link text-dark rounded {{ request()->is('regional/my-wallet') ? 'bg-light fw-bold text-primary' : '' }}">
                    <i class="fa-solid fa-wallet fa-fw me-2"></i> {{ __('dashboard.wallet') }}
                </a>
            </li>

            <div class="text-muted small fw-bold mt-3 mb-2 text-uppercase">{{ __('dashboard.client_orders', 'Client Orders') }}</div>
            <li class="nav-item">
                <a href="{{ route('regional.clients.index') }}" class="nav-link text-dark rounded {{ request()->is('regional/clients*') ? 'bg-light fw-bold text-primary' : '' }}">
                    <i class="fa-solid fa-users fa-fw me-2"></i> {{ __('dashboard.clients') }}
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('regional.chat.index') }}" class="nav-link text-dark rounded d-flex justify-content-between align-items-center {{ request()->is('regional/chat*') ? 'bg-light fw-bold text-primary' : '' }}">
                    <div><i class="fa-solid fa-comments fa-fw me-2"></i> {{ __('dashboard.customer_service', 'Customer Service') }}</div>
                    @php
                        $unreadMessages = \App\Models\Message::where('receiver_id', auth()->id())->where('is_read', false)->count();
                    @endphp
                    @if($unreadMessages > 0)
                        <span class="badge bg-success rounded-pill">{{ $unreadMessages }}</span>
                    @endif
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('regional.management.assigned_orders') }}" class="nav-link text-dark rounded {{ request()->is('regional/management/assigned-orders*') ? 'bg-light fw-bold text-primary' : '' }}">
                    <i class="fa-solid fa-shopping-cart fa-fw me-2"></i> {{ __('dashboard.assigned_orders', 'Assigned Orders') }}
                </a>
            </li>

            <div class="text-muted small fw-bold mt-3 mb-2 text-uppercase">{{ __('dashboard.operations_reports') }}</div>
            <li class="nav-item">
                <a href="{{ route('regional.invoices.index') }}" class="nav-link text-dark rounded {{ request()->is('regional/invoices') ? 'bg-light fw-bold text-primary' : '' }}">
                    <i class="fa-solid fa-file-invoice-dollar fa-fw me-2"></i> {{ __('dashboard.invoices') }}
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('regional.invoices.payment_status') }}" class="nav-link text-dark rounded {{ request()->is('regional/invoices/payment-status*') ? 'bg-light fw-bold text-primary' : '' }}">
                    <i class="fa-solid fa-money-bill-transfer fa-fw me-2"></i> {{ __('dashboard.payment_status_details') }}
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('regional.management.financial_treasury') }}" class="nav-link text-dark rounded {{ request()->is('regional/management/financial-treasury*') ? 'bg-light fw-bold text-primary' : '' }}">
                    <i class="fa-solid fa-vault fa-fw me-2"></i> {{ __('dashboard.financial_treasury') }}
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('regional.management.shipping') }}" class="nav-link text-dark rounded {{ request()->is('regional/management/shipping*') ? 'bg-light fw-bold text-primary' : '' }}">
                    <i class="fa-solid fa-truck-fast fa-fw me-2"></i> {{ __('dashboard.shipping_management') }}
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('regional.management.operational_status') }}" class="nav-link text-dark rounded {{ request()->is('regional/management/operational-status*') ? 'bg-light fw-bold text-primary' : '' }}">
                    <i class="fa-solid fa-circle-nodes fa-fw me-2"></i> {{ __('dashboard.operational_status') }}
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('regional.management.linked_clients') }}" class="nav-link text-dark rounded {{ request()->is('regional/management/linked-clients*') ? 'bg-light fw-bold text-primary' : '' }}">
                    <i class="fa-solid fa-users-between-lines fa-fw me-2"></i> {{ __('dashboard.linked_clients') }}
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('regional.management.campaigns') }}" class="nav-link text-dark rounded {{ request()->is('regional/management/campaigns*') ? 'bg-light fw-bold text-primary' : '' }}">
                    <i class="fa-solid fa-bullhorn fa-fw me-2"></i> {{ __('dashboard.operational_campaigns') }}
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('regional.management.reports') }}" class="nav-link text-dark rounded {{ request()->is('regional/management/reports*') ? 'bg-light fw-bold text-primary' : '' }}">
                    <i class="fa-solid fa-chart-line fa-fw me-2"></i> {{ __('dashboard.operational_reports') }}
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('regional.management.documentation') }}" class="nav-link text-dark rounded {{ request()->is('regional/management/documentation*') ? 'bg-light fw-bold text-primary' : '' }}">
                    <i class="fa-solid fa-file-contract fa-fw me-2"></i> {{ __('dashboard.contracting_documentation') }}
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('regional.management.logistics_risk') }}" class="nav-link text-dark rounded {{ request()->is('regional/management/logistics-risk*') ? 'bg-light fw-bold text-primary' : '' }}">
                    <i class="fa-solid fa-shield-halved fa-fw me-2"></i> {{ __('dashboard.logistics_risk') }}
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('regional.management.sla') }}" class="nav-link text-dark rounded {{ request()->is('regional/management/sla*') ? 'bg-light fw-bold text-primary' : '' }}">
                    <i class="fa-solid fa-handshake fa-fw me-2"></i> {{ __('dashboard.sla_management') }}
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('regional.performance_kpi.index') }}" class="nav-link text-dark rounded {{ request()->is('regional/management/performance-kpi*') ? 'bg-light fw-bold text-primary' : '' }}">
                    <i class="fa-solid fa-chart-pie fa-fw me-2"></i> {{ __('dashboard.kpi') }}
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
