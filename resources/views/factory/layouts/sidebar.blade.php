<aside class="main-sidebar">
  <section class="sidebar">
    <div class="user-panel">
      <div class="pull-right image">
        <img src="{{ Auth::user()->avatar ? \Illuminate\Support\Facades\Storage::url(Auth::user()->avatar) : asset('dist/img/user4-128x128.jpg') }}" class="img-circle" alt="User Image">
      </div>
      <div class="pull-right info">
        <p>{{ Auth::user()->name ?? __('dashboard.factory') }}</p>
        <a href="{{ route('profile.edit') }}"><i class="fa fa-circle text-success"></i> {{ __('dashboard.online') }}</a>
      </div>
    </div>
    <ul class="sidebar-menu" data-widget="tree">
      <li class="header">{{ __('dashboard.main_nav') }}</li>
      <li class="{{ request()->is('factory/dashboard') ? 'active' : '' }}">
        <a href="{{ url('factory/dashboard') }}">
          <i class="fa fa-dashboard"></i> <span>{{ __('dashboard.home') }}</span>
        </a>
      </li>
      <li class="{{ request()->is('factory/notifications*') ? 'active' : '' }}">
        <a href="{{ route('factory.notifications.index') }}">
          <i class="fa fa-bell"></i> <span>الإشعارات</span>
          @if(auth()->user()->unreadNotifications->count() > 0)
            <span class="pull-left-container">
              <span class="label label-danger pull-left">{{ auth()->user()->unreadNotifications->count() }}</span>
            </span>
          @endif
        </a>
      </li>
      <li class="{{ request()->is('profile*') ? 'active' : '' }}">
        <a href="{{ route('profile.edit') }}">
          <i class="fa fa-industry"></i> <span>{{ __('dashboard.factory_profile') }}</span>
        </a>
      </li>
      <li class="{{ request()->is('factory/my-wallet') ? 'active' : '' }}">
        <a href="{{ route('factory.wallet') }}">
          <i class="fa fa-google-wallet"></i> <span>محفظة المالية</span>
        </a>
      </li>
      <li class="{{ request()->is('user-sectors*') ? 'active' : '' }}">
        <a href="{{ route('user-sectors.index') }}">
          <i class="fa fa-list"></i> <span>اختيار القطاعات</span>
        </a>
      </li>
      <li class="{{ request()->is('products/create') ? 'active' : '' }}">
        <a href="{{ route('products.create') }}">
          <i class="fa fa-plus-circle"></i> <span>رفع منتجات</span>
        </a>
      </li>
      <li class="{{ request()->is('cars/create') ? 'active' : '' }}">
        <a href="{{ route('cars.create') }}">
          <i class="fa fa-car"></i> <span>إضافة سيارة جديدة</span>
        </a>
      </li>
      <li class="{{ request()->is('products') ? 'active' : '' }}">
        <a href="{{ route('products.index') }}">
          <i class="fa fa-cubes"></i> <span>إدارة المنتجات</span>
        </a>
      </li>
      <li class="{{ request()->is('received-orders*') ? 'active' : '' }}">
        <a href="{{ route('orders.received') }}">
          <i class="fa fa-shopping-cart"></i> <span>إدارة الطلبات</span>
        </a>
      </li>
      <li class="{{ request()->is('factory/management/inventory*') ? 'active' : '' }}">
        <a href="{{ route('factory.management.inventory') }}">
          <i class="fa fa-archive"></i> <span>إدارة المخزون</span>
        </a>
      </li>
      <li class="{{ request()->is('factory/management/production-supply-reports*') ? 'active' : '' }}">
        <a href="{{ route('factory.management.production_supply_reports') }}">
          <i class="fa fa-area-chart"></i> <span>تقارير الإنتاج والتوريد</span>
        </a>
      </li>
      <li class="{{ request()->is('factory/management/performance-kpi*') ? 'active' : '' }}">
        <a href="{{ route('factory.management.performance_kpi') }}">
          <i class="fa fa-line-chart"></i> <span>مؤشرات الأداء الإنتاجي (KPI)</span>
        </a>
      </li>
      <li class="{{ request()->is('factory/management/risk-management*') ? 'active' : '' }}">
        <a href="{{ route('factory.management.risk_management') }}">
          <i class="fa fa-shield"></i> <span>إدارة المخاطر</span>
        </a>
      </li>
      <li class="{{ request()->is('factory/management/support*') ? 'active' : '' }}">
        <a href="{{ route('factory.management.support') }}">
          <i class="fa fa-support"></i> <span>الدعم والمتابعة</span>
        </a>
      </li>
    </ul>
  </section>
</aside>
