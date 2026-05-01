<header class="main-header">
    <nav class="navbar navbar-static-top" style="background-color: #fff; border-bottom: 1px solid #ddd;">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="{{ url('/') }}" class="navbar-brand" style="color: #333; font-weight: 800; font-size: 24px;">
                    <b>{{ \App\Models\Setting::get('site_name', 'الشركة') }}</b>
                </a>
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" style="border-color: #eee;">
                    <i class="fa fa-bars" style="color: #333;"></i>
                </button>
            </div>

            <!-- Auth Buttons (Left side in RTL, which is left side of screen) -->
            <div class="navbar-custom-menu pull-left">
                <ul class="nav navbar-nav">
                    @guest
                        <li><a href="{{ route('login') }}" style="color: #333; font-weight: bold;">تسجيل الدخول</a></li>
                        <li><a href="{{ route('register') }}" style="color: #333; font-weight: bold;">تسجيل</a></li>
                    @else
                        <li>
                            <a href="{{ route(Auth::user()->panel_type . '.dashboard') }}" style="color: #3b8dbc; font-weight: bold;">
                                <i class="fa fa-dashboard"></i> لوحة التحكم
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="color: #d9534f; font-weight: bold;">
                                <i class="fa fa-sign-out"></i> خروج
                            </a>
                        </li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
                    @endguest
                </ul>
            </div>

            <!-- Centered Navigation Links -->
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav navbar-center-custom">
                    <li class="{{ request()->is('/') ? 'active' : '' }}"><a href="{{ url('/') }}" style="color: #333; font-weight: 500;">الرئيسية</a></li>
                    <li class="{{ request()->routeIs('home.products') ? 'active' : '' }}"><a href="{{ route('home.products') }}" style="color: #333; font-weight: 500;">المنتجات</a></li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<style>
    @media (min-width: 768px) {
        .navbar-center-custom {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            margin: 0;
        }
    }
    .main-header .navbar-nav > li > a {
        padding: 15px 20px;
    }
    .main-header .navbar-nav > .active > a {
        background: transparent !important;
        color: #3b8dbc !important;
        border-bottom: 2px solid #3b8dbc;
    }
    @media (max-width: 767px) {
        .navbar-center-custom {
            text-align: center;
        }
        .navbar-custom-menu {
            float: right !important; /* In mobile, move auth to right or keep top */
            margin-right: 10px;
        }
        .navbar-header {
            float: left !important;
        }
    }
</style>
