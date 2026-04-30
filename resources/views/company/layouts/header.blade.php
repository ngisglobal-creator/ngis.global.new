<header class="main-header">
  <a href="{{ url('company/dashboard') }}" class="logo">
    <span class="logo-mini">
        <img src="{{ \App\Models\Setting::logoUrl() }}" style="height: 30px;">
    </span>
    <span class="logo-lg"><b>{{ \App\Models\Setting::get('site_name', __('dashboard.company')) }}</b></span>
  </a>
  <nav class="navbar navbar-static-top">
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
      <span class="sr-only">تبديل القائمة</span>
    </a>
    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
        <!-- المحفظة -->
        <li class="dropdown messages-menu">
          <a href="{{ route('company.wallet') }}" class="dropdown-toggle" title="المحفظة" style="display: flex; align-items: center; gap: 10px; padding: 10px 15px;">
            <i class="fa fa-google-wallet" style="font-size: 24px; color: #fff;"></i>
            <span class="wallet-balance" style="font-size: 18px; font-weight: bold; font-family: 'Arial', sans-serif; color: #fff; direction: ltr;">
              {{ number_format(auth()->user()->wallet_balance, 2, '.', '') }}
            </span>
          </a>
        </li>
        <!-- تبديل اللغة -->
        <li class="dropdown tasks-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <i class="fa fa-language"></i>
            <span class="label label-info">{{ strtoupper(app()->getLocale()) }}</span>
          </a>
          <ul class="dropdown-menu">
            <li class="header">{{ __('dashboard.language') }}</li>
            <li>
              <ul class="menu">
                <li><a href="javascript:void(0)" onclick="event.preventDefault(); document.getElementById('lang-ar').submit();">{{ __('dashboard.arabic') }}</a></li>
                <li><a href="javascript:void(0)" onclick="event.preventDefault(); document.getElementById('lang-en').submit();">{{ __('dashboard.english') }}</a></li>
                <li><a href="javascript:void(0)" onclick="event.preventDefault(); document.getElementById('lang-zh').submit();">{{ __('dashboard.chinese') }}</a></li>
              </ul>
            </li>
          </ul>
          <form id="lang-ar" action="{{ route('language.set') }}" method="POST" style="display: none;">@csrf<input type="hidden" name="locale" value="ar"></form>
          <form id="lang-en" action="{{ route('language.set') }}" method="POST" style="display: none;">@csrf<input type="hidden" name="locale" value="en"></form>
          <form id="lang-zh" action="{{ route('language.set') }}" method="POST" style="display: none;">@csrf<input type="hidden" name="locale" value="zh"></form>
        </li>
        <li class="dropdown user user-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <img src="{{ asset('dist/img/user4-128x128.jpg') }}" class="user-image" alt="صورة المستخدم">
            <span class="hidden-xs">{{ Auth::user()->name ?? 'شركة' }}</span>
          </a>
          <ul class="dropdown-menu">
            <li class="user-header">
              <img src="{{ asset('dist/img/user4-128x128.jpg') }}" class="user-image" alt="صورة المستخدم">
              <p>
                {{ Auth::user()->name ?? 'شركة' }}
                <small>شركة</small>
              </p>
            </li>
            <li class="user-footer">
              <div class="pull-left">
                <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <button type="submit" class="btn btn-default btn-flat">تسجيل الخروج</button>
                </form>
              </div>
            </li>
          </ul>
        </li>
        <li>
          <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
        </li>
      </ul>
    </div>
  </nav>
</header>
