<aside class="main-sidebar">
  <section class="sidebar">
    <div class="user-panel">
      <div class="pull-right image">
        <img src="{{ Auth::user()->avatar ? \Illuminate\Support\Facades\Storage::url(Auth::user()->avatar) : asset('dist/img/user4-128x128.jpg') }}" class="img-circle" alt="User Image">
      </div>
      <div class="pull-right info">
        <p>{{ Auth::user()->name ?? __('dashboard.china') }}</p>
        <a href="{{ route('profile.edit') }}"><i class="fa fa-circle text-success"></i> {{ __('dashboard.online') }}</a>
      </div>
    </div>
    <ul class="sidebar-menu" data-widget="tree">
      <li class="header">{{ __('dashboard.main_nav') }}</li>
      <li class="{{ request()->is('china/dashboard') ? 'active' : '' }}">
        <a href="{{ url('china/dashboard') }}">
          <i class="fa fa-dashboard"></i> <span>{{ __('dashboard.home') }}</span>
        </a>
      </li>
      <li class="{{ request()->is('china/details') ? 'active' : '' }}">
        <a href="{{ route('china.details') }}">
          <i class="fa fa-info-circle"></i> <span>تفاصيل ngis</span>
        </a>
      </li>
      <li class="{{ request()->is('profile*') ? 'active' : '' }}">
        <a href="{{ route('profile.edit') }}">
          <i class="fa fa-globe"></i> <span>{{ __('dashboard.china_profile') }}</span>
        </a>
      </li>
      <li class="{{ request()->is('china/my-wallet') ? 'active' : '' }}">
        <a href="{{ route('china.wallet') }}">
          <i class="fa fa-google-wallet"></i> <span>محفظتي</span>
        </a>
      </li>
      <li class="treeview {{ request()->is('products*') || request()->is('received-orders*') ? 'active' : '' }}">
        <a href="#">
          <i class="fa fa-cubes"></i> <span>قسم المنتجات</span>
          <span class="pull-left-container">
            <i class="fa fa-angle-right pull-left"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li class="{{ request()->is('user-sectors*') ? 'active' : '' }}">
            <a href="{{ route('user-sectors.index') }}">
              <i class="fa fa-list"></i> <span>اختيار القطاعات</span>
            </a>
          </li>
          <li class="{{ request()->is('products/create') ? 'active' : '' }}">
            <a href="{{ route('products.create') }}"><i class="fa fa-plus-circle"></i> رفع منتج</a>
          </li>
          <li class="{{ request()->is('products') && !request()->is('products/create') ? 'active' : '' }}">
            <a href="{{ route('products.index') }}"><i class="fa fa-circle-o"></i> منتجاتي</a>
          </li>
          <li class="{{ request()->is('received-orders*') ? 'active' : '' }}">
            <a href="{{ route('orders.received') }}"><i class="fa fa-shopping-cart"></i> استقبال الطلبات</a>
          </li>
        </ul>
      </li>
      <li class="{{ request()->is('china/suppliers*') ? 'active' : '' }}">
        <a href="#">
          <i class="fa fa-industry"></i> <span>{{ __('dashboard.suppliers') }}</span>
        </a>
      </li>
      <li class="{{ request()->is('china/shipments*') ? 'active' : '' }}">
        <a href="#">
          <i class="fa fa-ship"></i> <span>{{ __('dashboard.shipments') }}</span>
        </a>
      </li>
      <li class="{{ request()->is('china/invoices*') ? 'active' : '' }}">
        <a href="{{ route('china.invoices') }}">
          <i class="fa fa-file-text-o"></i> <span>الفواتير الموجهة</span>
        </a>
      </li>
      <li class="{{ request()->is('china/regional-offices*') ? 'active' : '' }}">
        <a href="{{ route('china.regional_offices') }}">
          <i class="fa fa-globe"></i> <span>مكاتب الأقاليم</span>
        </a>
      </li>
      <li class="{{ request()->is('china/customers*') ? 'active' : '' }}">
        <a href="{{ route('china.customers') }}">
          <i class="fa fa-users"></i> <span>العملاء</span>
        </a>
      </li>
      <li class="{{ request()->is('china/product-status*') ? 'active' : '' }}">
        <a href="{{ route('china.product_status') }}">
          <i class="fa fa-ship"></i> <span>حالات المنتجات</span>
        </a>
      </li>
      <li class="header">أدوات إضافية</li>
    </ul>
  </section>
</aside>
