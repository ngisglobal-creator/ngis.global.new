<aside class="main-sidebar">
  <section class="sidebar">
    <div class="user-panel">
      <div class="pull-right image">
        <img src="{{ Auth::user()->avatar ? \Illuminate\Support\Facades\Storage::url(Auth::user()->avatar) : asset('dist/img/user4-128x128.jpg') }}" class="img-circle" alt="User Image">
      </div>
      <div class="pull-right info">
        <p>{{ Auth::user()->name ?? __('dashboard.client') }}</p>
        <a href="{{ route('profile.edit') }}"><i class="fa fa-circle text-success"></i> {{ __('dashboard.online') }}</a>
      </div>
    </div>
    <ul class="sidebar-menu" data-widget="tree">
      <li class="header">{{ __('dashboard.main_nav') }}</li>
      <li class="{{ request()->is('client/dashboard') ? 'active' : '' }}">
        <a href="{{ url('client/dashboard') }}">
          <i class="fa fa-dashboard"></i> <span>{{ __('dashboard.home') }}</span>
        </a>
      </li>
      <li class="{{ request()->is('client/notifications*') ? 'active' : '' }}">
        <a href="{{ route('client.notifications.index') }}">
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
          <i class="fa fa-user"></i> <span>{{ __('dashboard.profile') }}</span>
        </a>
      </li>
      <li class="{{ request()->is('client/my-wallet') ? 'active' : '' }}">
        <a href="{{ route('client.wallet') }}">
          <i class="fa fa-google-wallet"></i> <span>محفظة المالية</span>
        </a>
      </li>
      <li class="{{ request()->is('site-products*') ? 'active' : '' }}">
        <a href="{{ route('site.products.index') }}">
          <i class="fa fa-shopping-bag"></i> <span>منتجات الموقع</span>
        </a>
      </li>
      <li class="{{ request()->is('user-sectors*') ? 'active' : '' }}">
        <a href="{{ route('user-sectors.index') }}">
          <i class="fa fa-list"></i> <span>اختيار القطاعات</span>
        </a>
      </li>
      <li class="{{ request()->is('my-orders*') ? 'active' : '' }}">
        <a href="{{ route('client.orders.index') }}">
          <i class="fa fa-shopping-cart"></i> <span>إدارة الطلبات</span>
        </a>
      </li>
      <li class="{{ request()->is('client/special-order') ? 'active' : '' }}">
        <a href="{{ route('client.special_order') }}">
          <i class="fa fa-magic"></i> <span>طلب استيراد خاص</span>
        </a>
      </li>
      <li class="{{ request()->is('client/special-orders*') ? 'active' : '' }}">
        <a href="{{ route('client.special_orders.index') }}">
          <i class="fa fa-list-alt"></i> <span>طلباتي الخاصة</span>
        </a>
      </li>
      <li class="{{ request()->is('client/invoices*') ? 'active' : '' }}">
        <a href="#">
          <i class="fa fa-file-text"></i> <span>{{ __('dashboard.my_invoices') }}</span>
        </a>
      </li>
      <li class="{{ request()->is('client/chat*') ? 'active' : '' }}">
        <a href="{{ route('client.chat.index') }}">
          <i class="fa fa-envelope"></i> <span>الدعم والمتابعة</span>
          @php
            $unreadMessages = \App\Models\Message::where('receiver_id', auth()->id())->where('is_read', false)->count();
          @endphp
          @if($unreadMessages > 0)
            <span class="pull-left-container">
              <span class="label label-success pull-left">{{ $unreadMessages }}</span>
            </span>
          @endif
        </a>
      </li>
      <li class="{{ request()->is('client/auctions*') ? 'active' : '' }}">
        <a href="{{ route('client.auctions.index') }}">
          <i class="fa fa-gavel"></i> <span>إدارة المزادات</span>
        </a>
      </li>
      <li class="{{ request()->is('client/risk-management*') ? 'active' : '' }}">
        <a href="{{ route('client.risk_management.index') }}">
          <i class="fa fa-exclamation-triangle"></i> <span>إدارة المخاطر</span>
        </a>
      </li>
      <li class="{{ request()->is('client/supplier-evaluation*') ? 'active' : '' }}">
        <a href="{{ route('client.supplier_evaluation.index') }}">
          <i class="fa fa-star"></i> <span>تقييم الموردين</span>
        </a>
      </li>
    </ul>
  </section>
</aside>
