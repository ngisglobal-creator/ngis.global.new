<header class="main-header">
    <div class="d-flex align-items-center w-100">
        <!-- Sidebar Toggle -->
        <button id="sidebarToggle" class="btn btn-link text-dark d-lg-none me-2">
            <i class="fa-solid fa-bars fs-4"></i>
        </button>

        <div class="ms-auto d-flex align-items-center gap-3">
            <!-- Wallet -->
            <a href="{{ route('company.wallet') }}" class="text-decoration-none d-flex align-items-center gap-2 px-3 py-2 rounded bg-light border">
                <i class="fa-solid fa-wallet text-primary fs-5"></i>
                <span class="fw-bold english-nums">{{ number_format(auth()->user()->wallet_balance, 2, '.', '') }}</span>
            </a>

            <!-- Language Dropdown -->
            <div class="dropdown">
                <button class="btn btn-light border dropdown-toggle d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown">
                    <i class="fa-solid fa-language text-secondary"></i>
                    <span class="badge bg-secondary">{{ strtoupper(app()->getLocale()) }}</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                    <li class="dropdown-header">{{ __('dashboard.language') }}</li>
                    <li><a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('lang-ar').submit();">{{ __('dashboard.arabic') }}</a></li>
                    <li><a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('lang-en').submit();">{{ __('dashboard.english') }}</a></li>
                    <li><a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('lang-zh').submit();">{{ __('dashboard.chinese') }}</a></li>
                </ul>
                <form id="lang-ar" action="{{ route('language.set') }}" method="POST" class="d-none">@csrf<input type="hidden" name="locale" value="ar"></form>
                <form id="lang-en" action="{{ route('language.set') }}" method="POST" class="d-none">@csrf<input type="hidden" name="locale" value="en"></form>
                <form id="lang-zh" action="{{ route('language.set') }}" method="POST" class="d-none">@csrf<input type="hidden" name="locale" value="zh"></form>
            </div>
        </div>
    </div>
</header>
