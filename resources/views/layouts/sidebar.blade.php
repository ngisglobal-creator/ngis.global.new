<div class="main-sidebar bg-white shadow-sm" id="sidebar">
    <!-- Logo / Brand -->
    <div class="p-3 border-bottom d-flex align-items-center justify-content-center" style="height: var(--topbar-height); background: linear-gradient(135deg, #050d1f 0%, #18335c 50%, #050d1f 100%); background-size: 200% 200%; animation: gradientWave 5s ease infinite;">
        <a href="{{ url(auth()->user()->panel_type . '/dashboard') }}" class="text-decoration-none d-flex align-items-center gap-2">
            <img src="{{ asset('assets/images/logo-ngis.png') }}" alt="NGIS LOGO" style="height: 40px; object-fit: contain; filter: drop-shadow(0 0 5px rgba(255,255,255,0.2));">
            <div class="d-flex flex-column text-start">
                <span class="fw-bold text-white" style="font-family: 'Arial Black', Impact, sans-serif; font-size: 1.2rem; letter-spacing: 2px; line-height: 1;">NGIS</span>
                <span class="fw-bold" style="font-size: 0.5rem; letter-spacing: 1px; color: #d4af37;">GLOBAL INTEGRATED SERVICES</span>
            </div>
        </a>
    </div>

    <!-- User Info -->
    <div class="p-3 border-bottom text-center bg-white">
        <div class="text-uppercase fw-bold text-dark mb-2" style="font-size: 0.85rem; letter-spacing: 1px;">
            @if(auth()->user()->hasRole('admin'))
                {{ __('dashboard.admin_panel') }}
            @elseif(auth()->user()->type == 'global_forwarding')
                {{ __('dashboard.global_forwarding_panel') }}
            @else
                {{ __('dashboard.dashboard') }}
            @endif
        </div>
        <div class="fw-bold fs-5 text-dark mb-1">{{ Auth::user()->name ?? 'User' }}</div>
        <small class="text-success fw-bold"><i class="fa-solid fa-circle fa-xs me-1"></i> {{ __('dashboard.online') }}</small>
    </div>

    <!-- Navigation -->
    <div class="p-2 overflow-auto" style="flex: 1;">
        <ul class="nav flex-column gap-1 p-1" id="sidebarAccordion">

            {{-- ============== الرئيسية ============== --}}
            <li class="nav-item">
                <a href="{{ url(auth()->user()->panel_type . '/dashboard') }}" class="nav-link sidebar-link {{ (request()->is('admin') || request()->is('*/dashboard')) ? 'active-link' : '' }}">
                    <i class="fa-solid fa-house fa-fw me-2"></i> {{ __('dashboard.home') }}
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.notifications.index') }}" class="nav-link sidebar-link d-flex justify-content-between align-items-center {{ request()->is('admin/notifications*') ? 'active-link' : '' }}">
                    <div><i class="fa-solid fa-bell fa-fw me-2"></i> {{ __('dashboard.notifications') }}</div>
                    @if(auth()->user()->unreadNotifications->count() > 0)
                        <span class="badge bg-danger rounded-pill">{{ auth()->user()->unreadNotifications->count() }}</span>
                    @endif
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('profile.edit') }}" class="nav-link sidebar-link {{ request()->is('profile*') ? 'active-link' : '' }}">
                    <i class="fa-solid fa-user fa-fw me-2"></i> {{ __('dashboard.profile') }}
                </a>
            </li>

            @if(auth()->user() && auth()->user()->hasRole('admin'))

            {{-- ============== قسم الشحن الدولي ============== --}}
            @php $shippingActive = request()->is('global-forwarding/*'); @endphp
            <li class="nav-item mt-2">
                <button class="nav-link sidebar-section-btn w-100 d-flex justify-content-between align-items-center {{ $shippingActive ? 'active-link' : '' }}"
                    data-bs-toggle="collapse" data-bs-target="#sec-shipping" aria-expanded="{{ $shippingActive ? 'true' : 'false' }}">
                    <div><i class="fa-solid fa-ship fa-fw me-2 text-info"></i> <span>{{ __('dashboard.global_forwarding') }}</span></div>
                    <i class="fa-solid fa-chevron-left section-arrow"></i>
                </button>
                <div class="collapse {{ $shippingActive ? 'show' : '' }}" id="sec-shipping" data-bs-parent="#sidebarAccordion">
                    <ul class="nav flex-column gap-1 sub-menu">
                        <li><a href="{{ route('global_forwarding.orders.standard') }}" class="nav-link sidebar-sub-link {{ request()->is('global-forwarding/orders/standard') ? 'active-link' : '' }}"><i class="fa-solid fa-box fa-fw me-2"></i> {{ __('dashboard.general_orders') }}</a></li>
                        <li><a href="{{ route('global_forwarding.orders.custom') }}" class="nav-link sidebar-sub-link {{ request()->is('global-forwarding/orders/custom') ? 'active-link' : '' }}"><i class="fa-solid fa-magnifying-glass-plus fa-fw me-2"></i> {{ __('dashboard.custom_orders') }}</a></li>
                        <li><a href="{{ route('global_forwarding.orders.matched_products') }}" class="nav-link sidebar-sub-link {{ request()->is('global-forwarding/orders/matched-products') ? 'active-link' : '' }}"><i class="fa-solid fa-check-double fa-fw me-2"></i> {{ __('dashboard.matched_products') }}</a></li>
                        <li><a href="{{ route('global_forwarding.qr_passport') }}" class="nav-link sidebar-sub-link {{ request()->is('global-forwarding/qr-passport') ? 'active-link' : '' }}"><i class="fa-solid fa-qrcode fa-fw me-2"></i> {{ __('dashboard.qr_passport') }}</a></li>
                        <li><a href="{{ route('global_forwarding.insurance') }}" class="nav-link sidebar-sub-link {{ request()->is('global-forwarding/insurance') ? 'active-link' : '' }}"><i class="fa-solid fa-shield fa-fw me-2"></i> {{ __('dashboard.insurance_compliance') }}</a></li>
                        <li><a href="{{ route('global_forwarding.liability_risk') }}" class="nav-link sidebar-sub-link {{ request()->is('global-forwarding/liability-risk') ? 'active-link' : '' }}"><i class="fa-solid fa-scale-balanced fa-fw me-2"></i> {{ __('dashboard.liability_risk') }}</a></li>
                        <li><a href="{{ route('global_forwarding.regional_integration') }}" class="nav-link sidebar-sub-link {{ request()->is('global-forwarding/regional-integration') ? 'active-link' : '' }}"><i class="fa-solid fa-link fa-fw me-2"></i> {{ __('dashboard.regional_integration') }}</a></li>
                    </ul>
                </div>
            </li>

            {{-- ============== قسم المالية ============== --}}
            @php $financeActive = request()->is('admin/wallets*') || request()->is('admin/invoices*'); @endphp
            <li class="nav-item mt-1">
                <button class="nav-link sidebar-section-btn w-100 d-flex justify-content-between align-items-center {{ $financeActive ? 'active-link' : '' }}"
                    data-bs-toggle="collapse" data-bs-target="#sec-finance" aria-expanded="{{ $financeActive ? 'true' : 'false' }}">
                    <div><i class="fa-solid fa-coins fa-fw me-2 text-success"></i> <span>{{ __('dashboard.finance_section') }}</span></div>
                    <i class="fa-solid fa-chevron-left section-arrow"></i>
                </button>
                <div class="collapse {{ $financeActive ? 'show' : '' }}" id="sec-finance" data-bs-parent="#sidebarAccordion">
                    <ul class="nav flex-column gap-1 sub-menu">
                        <li><a href="{{ route('admin.wallets.index') }}" class="nav-link sidebar-sub-link {{ request()->is('admin/wallets*') ? 'active-link' : '' }}"><i class="fa-solid fa-wallet fa-fw me-2"></i> {{ __('dashboard.wallets') }}</a></li>
                        <li><a href="{{ route('admin.invoices.index') }}" class="nav-link sidebar-sub-link {{ request()->is('admin/invoices') ? 'active-link' : '' }}"><i class="fa-solid fa-file-invoice-dollar fa-fw me-2"></i> {{ __('dashboard.invoices') }}</a></li>
                        <li><a href="{{ route('admin.invoices.payment_status') }}" class="nav-link sidebar-sub-link {{ request()->is('admin/invoices/payment-status') ? 'active-link' : '' }}"><i class="fa-solid fa-money-bill-transfer fa-fw me-2"></i> {{ __('dashboard.payment_status') }}</a></li>
                        <li><a href="{{ route('admin.invoices.paid') }}" class="nav-link sidebar-sub-link {{ request()->is('admin/invoices/paid') ? 'active-link' : '' }}"><i class="fa-solid fa-circle-check fa-fw me-2"></i> {{ __('dashboard.paid_invoices') }}</a></li>
                    </ul>
                </div>
            </li>

            {{-- ============== قسم الباقات ============== --}}
            @php $packagesActive = request()->is('admin/packages*') || request()->is('admin/user-packages*'); @endphp
            <li class="nav-item mt-1">
                <button class="nav-link sidebar-section-btn w-100 d-flex justify-content-between align-items-center {{ $packagesActive ? 'active-link' : '' }}"
                    data-bs-toggle="collapse" data-bs-target="#sec-packages" aria-expanded="{{ $packagesActive ? 'true' : 'false' }}">
                    <div><i class="fa-solid fa-cubes fa-fw me-2 text-primary"></i> <span>{{ __('dashboard.packages_section') }}</span></div>
                    <i class="fa-solid fa-chevron-left section-arrow"></i>
                </button>
                <div class="collapse {{ $packagesActive ? 'show' : '' }}" id="sec-packages" data-bs-parent="#sidebarAccordion">
                    <ul class="nav flex-column gap-1 sub-menu">
                        <li><a href="{{ route('admin.packages.index') }}" class="nav-link sidebar-sub-link {{ request()->is('admin/packages*') ? 'active-link' : '' }}"><i class="fa-solid fa-cubes fa-fw me-2"></i> {{ __('dashboard.packages') }}</a></li>
                        <li><a href="{{ route('admin.user-packages.index') }}" class="nav-link sidebar-sub-link {{ request()->is('admin/user-packages*') ? 'active-link' : '' }}"><i class="fa-solid fa-star fa-fw me-2"></i> {{ __('dashboard.user_packages') }}</a></li>
                    </ul>
                </div>
            </li>

            {{-- ============== قسم القطاعات ============== --}}
            @php $sectorsActive = request()->is('admin/sectors*') || request()->is('admin/branches*') || request()->is('admin/categories*'); @endphp
            <li class="nav-item mt-1">
                <button class="nav-link sidebar-section-btn w-100 d-flex justify-content-between align-items-center {{ $sectorsActive ? 'active-link' : '' }}"
                    data-bs-toggle="collapse" data-bs-target="#sec-sectors" aria-expanded="{{ $sectorsActive ? 'true' : 'false' }}">
                    <div><i class="fa-solid fa-layer-group fa-fw me-2 text-warning"></i> <span>{{ __('dashboard.sectors_section') }}</span></div>
                    <i class="fa-solid fa-chevron-left section-arrow"></i>
                </button>
                <div class="collapse {{ $sectorsActive ? 'show' : '' }}" id="sec-sectors" data-bs-parent="#sidebarAccordion">
                    <ul class="nav flex-column gap-1 sub-menu">
                        <li><a href="{{ route('admin.sectors.index') }}" class="nav-link sidebar-sub-link {{ request()->is('admin/sectors*') ? 'active-link' : '' }}"><i class="fa-solid fa-layer-group fa-fw me-2"></i> {{ __('dashboard.sectors') }}</a></li>
                        <li><a href="{{ route('admin.branches.index') }}" class="nav-link sidebar-sub-link {{ request()->is('admin/branches*') ? 'active-link' : '' }}"><i class="fa-solid fa-code-branch fa-fw me-2"></i> {{ __('dashboard.branches') }}</a></li>
                        <li><a href="{{ route('admin.categories.index') }}" class="nav-link sidebar-sub-link {{ request()->is('admin/categories*') ? 'active-link' : '' }}"><i class="fa-solid fa-list fa-fw me-2"></i> {{ __('dashboard.categories') }}</a></li>
                    </ul>
                </div>
            </li>

            {{-- ============== إدارة الحسابات ============== --}}
            @php $accountsActive = request()->is('admin/factories*') || request()->is('admin/companies*') || request()->is('admin/clients*') || request()->is('admin/regional*') || request()->is('admin/china*') || request()->is('admin/order-statuses*'); @endphp
            <li class="nav-item mt-1">
                <button class="nav-link sidebar-section-btn w-100 d-flex justify-content-between align-items-center {{ $accountsActive ? 'active-link' : '' }}"
                    data-bs-toggle="collapse" data-bs-target="#sec-accounts" aria-expanded="{{ $accountsActive ? 'true' : 'false' }}">
                    <div><i class="fa-solid fa-briefcase fa-fw me-2 text-danger"></i> <span>{{ __('dashboard.accounts_management') }}</span></div>
                    <i class="fa-solid fa-chevron-left section-arrow"></i>
                </button>
                <div class="collapse {{ $accountsActive ? 'show' : '' }}" id="sec-accounts" data-bs-parent="#sidebarAccordion">
                    <ul class="nav flex-column gap-1 sub-menu">
                        <li><a href="{{ route('admin.factories.index') }}" class="nav-link sidebar-sub-link {{ request()->is('admin/factories') ? 'active-link' : '' }}"><i class="fa-solid fa-industry fa-fw me-2"></i> {{ __('dashboard.factories') }}</a></li>
                        <li><a href="{{ route('admin.factories.products') }}" class="nav-link sidebar-sub-link {{ request()->is('admin/factories/products') ? 'active-link' : '' }}"><i class="fa-solid fa-boxes-stacked fa-fw me-2"></i> {{ __('dashboard.factory_products') }}</a></li>
                        <li><a href="{{ route('admin.companies.index') }}" class="nav-link sidebar-sub-link {{ request()->is('admin/companies') ? 'active-link' : '' }}"><i class="fa-solid fa-building fa-fw me-2"></i> {{ __('dashboard.companies') }}</a></li>
                        <li><a href="{{ route('admin.companies.products') }}" class="nav-link sidebar-sub-link {{ request()->is('admin/companies/products') ? 'active-link' : '' }}"><i class="fa-solid fa-bag-shopping fa-fw me-2"></i> {{ __('dashboard.company_products') }}</a></li>
                        <li><a href="{{ route('admin.clients.index') }}" class="nav-link sidebar-sub-link {{ request()->is('admin/clients') ? 'active-link' : '' }}"><i class="fa-solid fa-users fa-fw me-2"></i> {{ __('dashboard.clients') }}</a></li>
                        <li><a href="{{ route('admin.clients.orders') }}" class="nav-link sidebar-sub-link {{ request()->is('admin/clients/orders*') ? 'active-link' : '' }}"><i class="fa-solid fa-cart-shopping fa-fw me-2"></i> {{ __('dashboard.client_orders') }}</a></li>
                        <li><a href="{{ route('admin.regional.index') }}" class="nav-link sidebar-sub-link {{ request()->is('admin/regional*') ? 'active-link' : '' }}"><i class="fa-solid fa-globe fa-fw me-2"></i> {{ __('dashboard.regional_offices') }}</a></li>
                        <li><a href="{{ route('admin.china.index') }}" class="nav-link sidebar-sub-link {{ request()->is('admin/china*') ? 'active-link' : '' }}"><i class="fa-solid fa-flag fa-fw me-2"></i> {{ __('dashboard.china_office') }}</a></li>
                        <li><a href="{{ route('admin.order-statuses.index') }}" class="nav-link sidebar-sub-link {{ request()->is('admin/order-statuses*') ? 'active-link' : '' }}"><i class="fa-solid fa-list-ol fa-fw me-2"></i> {{ __('dashboard.order_statuses') }}</a></li>
                    </ul>
                </div>
            </li>

            {{-- ============== إدارة التوثيق ============== --}}
            @php $verifActive = request()->is('admin/verifications*') || request()->is('admin/user-verifications*'); @endphp
            <li class="nav-item mt-1">
                <button class="nav-link sidebar-section-btn w-100 d-flex justify-content-between align-items-center {{ $verifActive ? 'active-link' : '' }}"
                    data-bs-toggle="collapse" data-bs-target="#sec-verif" aria-expanded="{{ $verifActive ? 'true' : 'false' }}">
                    <div><i class="fa-solid fa-shield-halved fa-fw me-2 text-teal"></i> <span>{{ __('dashboard.verification_management') }}</span></div>
                    <i class="fa-solid fa-chevron-left section-arrow"></i>
                </button>
                <div class="collapse {{ $verifActive ? 'show' : '' }}" id="sec-verif" data-bs-parent="#sidebarAccordion">
                    <ul class="nav flex-column gap-1 sub-menu">
                        <li><a href="{{ route('admin.verifications.index') }}" class="nav-link sidebar-sub-link {{ request()->is('admin/verifications') ? 'active-link' : '' }}"><i class="fa-solid fa-shield-halved fa-fw me-2"></i> {{ __('dashboard.verifications') }}</a></li>
                        <li><a href="{{ route('admin.user-verifications.index') }}" class="nav-link sidebar-sub-link {{ request()->is('admin/user-verifications*') ? 'active-link' : '' }}"><i class="fa-solid fa-id-badge fa-fw me-2"></i> {{ __('dashboard.grant_verifications') }}</a></li>
                    </ul>
                </div>
            </li>

            {{-- ============== نطاقات العمل ============== --}}
            @php $geoActive = request()->is('admin/countries*') || request()->is('admin/geographic-zones*') || request()->is('admin/office-zones*') || request()->is('admin/currencies*'); @endphp
            <li class="nav-item mt-1">
                <button class="nav-link sidebar-section-btn w-100 d-flex justify-content-between align-items-center {{ $geoActive ? 'active-link' : '' }}"
                    data-bs-toggle="collapse" data-bs-target="#sec-geo" aria-expanded="{{ $geoActive ? 'true' : 'false' }}">
                    <div><i class="fa-solid fa-earth-americas fa-fw me-2" style="color:#20c997;"></i> <span>{{ __('dashboard.work_zones') }}</span></div>
                    <i class="fa-solid fa-chevron-left section-arrow"></i>
                </button>
                <div class="collapse {{ $geoActive ? 'show' : '' }}" id="sec-geo" data-bs-parent="#sidebarAccordion">
                    <ul class="nav flex-column gap-1 sub-menu">
                        <li><a href="{{ route('admin.countries.index') }}" class="nav-link sidebar-sub-link {{ request()->is('admin/countries*') ? 'active-link' : '' }}"><i class="fa-solid fa-earth-americas fa-fw me-2"></i> {{ __('dashboard.countries') }}</a></li>
                        <li><a href="{{ route('admin.geographic-zones.index') }}" class="nav-link sidebar-sub-link {{ request()->is('admin/geographic-zones*') ? 'active-link' : '' }}"><i class="fa-solid fa-map-location-dot fa-fw me-2"></i> {{ __('dashboard.geographic_zones') }}</a></li>
                        <li><a href="{{ route('admin.office-zones.index') }}" class="nav-link sidebar-sub-link {{ request()->is('admin/office-zones*') ? 'active-link' : '' }}"><i class="fa-solid fa-location-pin fa-fw me-2"></i> {{ __('dashboard.office_zones') }}</a></li>
                        <li><a href="{{ route('admin.currencies.index') }}" class="nav-link sidebar-sub-link {{ request()->is('admin/currencies*') ? 'active-link' : '' }}"><i class="fa-solid fa-coins fa-fw me-2"></i> {{ __('dashboard.currencies') }}</a></li>
                    </ul>
                </div>
            </li>

            {{-- ============== الإعدادات والأذونات ============== --}}
            @php $settingsActive = request()->is('admin/users*') || request()->is('admin/roles*') || request()->is('admin/permissions*') || request()->is('admin/settings*'); @endphp
            <li class="nav-item mt-1">
                <button class="nav-link sidebar-section-btn w-100 d-flex justify-content-between align-items-center {{ $settingsActive ? 'active-link' : '' }}"
                    data-bs-toggle="collapse" data-bs-target="#sec-settings" aria-expanded="{{ $settingsActive ? 'true' : 'false' }}">
                    <div><i class="fa-solid fa-gears fa-fw me-2 text-secondary"></i> <span>{{ __('dashboard.settings_permissions') }}</span></div>
                    <i class="fa-solid fa-chevron-left section-arrow"></i>
                </button>
                <div class="collapse {{ $settingsActive ? 'show' : '' }}" id="sec-settings" data-bs-parent="#sidebarAccordion">
                    <ul class="nav flex-column gap-1 sub-menu">
                        <li><a href="{{ route('admin.users.index') }}" class="nav-link sidebar-sub-link {{ request()->is('admin/users*') ? 'active-link' : '' }}"><i class="fa-solid fa-users-gear fa-fw me-2"></i> {{ __('dashboard.users') }}</a></li>
                        <li><a href="{{ route('admin.roles.index') }}" class="nav-link sidebar-sub-link {{ request()->is('admin/roles*') ? 'active-link' : '' }}"><i class="fa-solid fa-user-tag fa-fw me-2"></i> {{ __('dashboard.roles') }}</a></li>
                        <li><a href="{{ route('admin.permissions.index') }}" class="nav-link sidebar-sub-link {{ request()->is('admin/permissions*') ? 'active-link' : '' }}"><i class="fa-solid fa-lock fa-fw me-2"></i> {{ __('dashboard.permissions') }}</a></li>
                        <li><a href="{{ route('admin.settings.index') }}" class="nav-link sidebar-sub-link {{ request()->is('admin/settings*') ? 'active-link' : '' }}"><i class="fa-solid fa-gears fa-fw me-2"></i> {{ __('dashboard.general_settings') }}</a></li>
                    </ul>
                </div>
            </li>

            @endif

            <li class="nav-item mt-3 pt-3 border-top">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="nav-link sidebar-link text-danger w-100 text-start bg-transparent border-0">
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

    /* Regular nav links */
    .sidebar-link {
        font-weight: 500;
        font-size: 14px;
        padding: 0.45rem 0.75rem;
        border-radius: 8px;
        transition: all 0.2s ease;
        color: #374151;
    }
    .sidebar-link:hover {
        background-color: #f0f4ff;
        color: #0d6efd !important;
    }

    /* Section toggle buttons */
    .sidebar-section-btn {
        font-weight: 600;
        font-size: 14px;
        padding: 0.5rem 0.75rem;
        border-radius: 8px;
        border: none;
        background: transparent;
        color: #111827;
        text-align: right;
        transition: all 0.2s ease;
    }
    html[dir="ltr"] .sidebar-section-btn {
        text-align: left;
    }
    
    .sidebar-section-btn:hover {
        background-color: #f3f4f6;
    }

    /* Arrow rotation */
    .section-arrow {
        font-size: 0.7rem;
        color: #9ca3af;
        transition: transform 0.3s ease;
    }
    .sidebar-section-btn[aria-expanded="true"] .section-arrow {
        transform: rotate(-90deg);
        color: #0d6efd;
    }
    html[dir="ltr"] .sidebar-section-btn[aria-expanded="true"] .section-arrow {
        transform: rotate(90deg);
    }
    .sidebar-section-btn[aria-expanded="true"] {
        background-color: #eef3ff;
        color: #0d6efd;
    }

    /* Sub-menu links */
    .sub-menu {
        padding: 4px 0 4px 12px;
        margin-top: 2px;
        border-right: 2px solid #e5e7eb;
        margin-right: 12px;
    }
    html[dir="ltr"] .sub-menu {
        padding: 4px 12px 4px 0;
        border-right: none;
        border-left: 2px solid #e5e7eb;
        margin-right: 0;
        margin-left: 12px;
    }
    
    .sidebar-sub-link {
        font-weight: 500;
        font-size: 13px;
        padding: 0.35rem 0.6rem;
        border-radius: 6px;
        color: #4b5563;
        transition: all 0.2s ease;
    }
    .sidebar-sub-link:hover {
        background-color: #f0f4ff;
        color: #0d6efd !important;
        padding-right: 1rem;
    }
    html[dir="ltr"] .sidebar-sub-link:hover {
        padding-right: 0.6rem;
        padding-left: 1rem;
    }

    /* Active state */
    .active-link {
        background-color: #eef3ff !important;
        color: #0d6efd !important;
        font-weight: 600 !important;
    }

    /* Force all icons black */
    .main-sidebar .fa-fw,
    .main-sidebar .fa-solid,
    .main-sidebar .fa-regular {
        color: #111827 !important;
    }
    /* Keep icons blue on active links */
    .main-sidebar .active-link .fa-fw,
    .main-sidebar .active-link .fa-solid,
    .main-sidebar [aria-expanded="true"] .fa-fw,
    .main-sidebar [aria-expanded="true"] .fa-solid {
        color: #0d6efd !important;
    }
    /* Keep logout icon red */
    .main-sidebar .text-danger .fa-solid,
    .main-sidebar .text-danger .fa-fw {
        color: #dc3545 !important;
    }

    .hover-bg-light:hover {
        background-color: #fff5f5;
    }
</style>
