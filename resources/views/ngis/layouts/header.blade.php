<header class="main-header">
  <a href="{{ route('ngis.dashboard') }}" class="logo">
    <span class="logo-mini"><b>N</b>GIS</span>
    <span class="logo-lg">{{ config('app.name', 'نظام NGIS') }}</span>
  </a>
  <nav class="navbar navbar-static-top">
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
      <span class="sr-only">Toggle navigation</span>
    </a>
    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
        <li class="dropdown user user-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <img src="{{ Auth::user()->avatar_url }}" class="user-image" alt="User Image">
            <span class="hidden-xs">{{ Auth::user()->name }}</span>
          </a>
          <ul class="dropdown-menu">
            <li class="user-header">
              <img src="{{ Auth::user()->avatar_url }}" class="img-circle" alt="User Image">
              <p>
                {{ Auth::user()->name }} - مكتب NGIS
                <small>عضو منذ {{ Auth::user()->created_at->format('M. Y') }}</small>
              </p>
            </li>
            <li class="user-footer">
              <div class="pull-right">
                <a href="{{ route('profile.edit') }}" class="btn btn-default btn-flat">الملف الشخصي</a>
              </div>
              <div class="pull-left">
                <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <button type="submit" class="btn btn-default btn-flat">تسجيل الخروج</button>
                </form>
              </div>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </nav>
</header>
