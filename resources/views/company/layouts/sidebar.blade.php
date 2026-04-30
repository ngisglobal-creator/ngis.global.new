<aside class="main-sidebar">
  <section class="sidebar">
    <div class="user-panel">
      <div class="pull-right image">
        <img src="{{ Auth::user()->avatar ? \Illuminate\Support\Facades\Storage::url(Auth::user()->avatar) : asset('dist/img/user4-128x128.jpg') }}" class="img-circle" alt="User Image">
      </div>
      <div class="pull-right info">
        <p>{{ Auth::user()->name ?? __('dashboard.company') }}</p>
        <a href="{{ route('profile.edit') }}"><i class="fa fa-circle text-success"></i> {{ __('dashboard.online') }}</a>
      </div>
    </div>
    <ul class="sidebar-menu" data-widget="tree">
      <li class="header">{{ __('dashboard.main_nav') }}</li>
      <li class="{{ request()->is('company/dashboard') ? 'active' : '' }}">
        <a href="{{ url('company/dashboard') }}">
          <i class="fa fa-dashboard"></i> <span>{{ __('dashboard.home') }}</span>
        </a>
      </li>
      <li class="{{ request()->is('company/notifications*') ? 'active' : '' }}">
        <a href="{{ route('company.notifications.index') }}">
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
          <i class="fa fa-building"></i> <span>{{ __('dashboard.company_profile') }}</span>
        </a>
      </li>
      <li class="{{ request()->is('company/my-wallet') ? 'active' : '' }}">
        <a href="{{ route('company.wallet') }}">
          <i class="fa fa-google-wallet"></i> <span>المحفظة المالية</span>
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
          <i class="fa fa-cubes"></i> <span>منتجاتي</span>
        </a>
      </li>
      <li class="{{ request()->is('received-orders*') ? 'active' : '' }}">
        <a href="{{ route('orders.received') }}">
          <i class="fa fa-shopping-cart"></i> <span>إدارة الطلبات</span>
        </a>
      </li>
      <li class="{{ request()->is('company/contracts*') ? 'active' : '' }}">
        <a href="{{ route('company.contracts.management') }}">
          <i class="fa fa-file-text-o"></i> <span>{{ __('dashboard.contracts') }}</span>
        </a>
      </li>
      <li class="{{ request()->is('company/auctions*') ? 'active' : '' }}">
        <a href="{{ route('company.auctions.index') }}">
          <i class="fa fa-gavel"></i> <span>إدارة المزادات</span>
        </a>
      </li>
      <li class="{{ request()->is('company/commercial-products*') ? 'active' : '' }}">
        <a href="{{ route('company.commercial_products.index') }}">
          <i class="fa fa-shopping-bag"></i> <span>إدارة المنتجات التجارية</span>
        </a>
      </li>
      <li class="{{ request()->is('company/inventory*') ? 'active' : '' }}">
        <a href="{{ route('company.inventory.index') }}">
          <i class="fa fa-archive"></i> <span>إدارة المخزون</span>
        </a>
      </li>
      <li class="{{ request()->is('company/reports*') ? 'active' : '' }}">
        <a href="{{ route('company.reports.index') }}">
          <i class="fa fa-bar-chart"></i> <span>التقارير التشغيلية</span>
        </a>
      </li>
      <li class="{{ request()->is('company/contracts-management*') ? 'active' : '' }}">
        <a href="{{ route('company.contracts.management') }}">
          <i class="fa fa-handshake-o"></i> <span>التوثيق والتعاقد</span>
        </a>
      </li>
      <li class="{{ request()->is('company/supplier-evaluation*') ? 'active' : '' }}">
        <a href="{{ route('company.supplier_evaluation.index') }}">
          <i class="fa fa-star-half-o"></i> <span>نظام تقييم المورد</span>
        </a>
      </li>
      <li class="{{ request()->is('company/risk-management*') ? 'active' : '' }}">
        <a href="{{ route('company.risk_management.index') }}">
          <i class="fa fa-shield"></i> <span>إدارة المخاطر</span>
        </a>
      </li>
      <li class="{{ request()->is('company/support-and-followup*') ? 'active' : '' }}">
        <a href="{{ route('company.support.index') }}">
          <i class="fa fa-support"></i> <span>الدعم والمتابعة</span>
        </a>
      </li>
      <li class="{{ request()->is('company/employees*') ? 'active' : '' }}">
        <a href="#">
          <i class="fa fa-users"></i> <span>{{ __('dashboard.employees') }}</span>
        </a>
      </li>
    </ul>
  </section>
</aside>
