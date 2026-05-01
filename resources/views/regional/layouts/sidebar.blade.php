<aside class="main-sidebar">
  <section class="sidebar">
    <div class="user-panel">
      <div class="pull-right image">
        <img src="{{ Auth::user()->avatar ? \Illuminate\Support\Facades\Storage::url(Auth::user()->avatar) : asset('dist/img/user4-128x128.jpg') }}" class="img-circle" alt="User Image">
      </div>
      <div class="pull-right info">
        <p>{{ Auth::user()->name ?? __('dashboard.regional_office') }}</p>
        <a href="{{ route('profile.edit') }}"><i class="fa fa-circle text-success"></i> {{ __('dashboard.online') }}</a>
      </div>
    </div>
    <ul class="sidebar-menu" data-widget="tree">
      <li class="header">{{ __('dashboard.main_nav') }}</li>
      <li class="{{ request()->is('regional/dashboard') ? 'active' : '' }}">
        <a href="{{ url('regional/dashboard') }}">
          <i class="fa fa-dashboard"></i> <span>{{ __('dashboard.home') }}</span>
        </a>
      </li>
      <li class="{{ request()->is('regional/details') ? 'active' : '' }}">
        <a href="{{ route('regional.details') }}">
          <i class="fa fa-info-circle"></i> <span>{{ __('dashboard.office_details') }}</span>
        </a>
      </li>
      <li class="{{ request()->is('regional/notifications*') ? 'active' : '' }}">
        <a href="{{ route('regional.notifications.index') }}">
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
          <i class="fa fa-map-marker"></i> <span>{{ __('dashboard.office_profile') }}</span>
        </a>
      </li>
      <li class="{{ request()->is('regional/my-wallet') ? 'active' : '' }}">
        <a href="{{ route('regional.wallet') }}">
          <i class="fa fa-google-wallet"></i> <span>محفظتي</span>
        </a>
      </li>
      <li class="{{ request()->is('regional/clients*') ? 'active' : '' }}">
        <a href="{{ route('regional.clients.index') }}">
          <i class="fa fa-users"></i> <span>العملاء</span>
        </a>
      </li>
      <li class="{{ request()->is('regional/chat*') ? 'active' : '' }}">
        <a href="{{ route('regional.chat.index') }}">
          <i class="fa fa-comments"></i> <span>خدمة العملاء</span>
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
      <li class="{{ request()->is('regional/invoices') ? 'active' : '' }}">
        <a href="{{ route('regional.invoices.index') }}">
          <i class="fa fa-file-text-o"></i> <span>الفواتير</span>
        </a>
      </li>
      <li class="{{ request()->is('regional/invoices/payment-status*') ? 'active' : '' }}">
        <a href="{{ route('regional.invoices.payment_status') }}">
          <i class="fa fa-credit-card"></i> <span>حالات دفع الفواتير</span>
        </a>
      </li>
      <li class="{{ request()->is('regional/management/assigned-orders*') ? 'active' : '' }}">
        <a href="{{ route('regional.management.assigned_orders') }}">
          <i class="fa fa-shopping-cart"></i> <span>الطلبات الموكلة من العملاء</span>
        </a>
      </li>
      <li class="{{ request()->is('regional/management/financial-treasury*') ? 'active' : '' }}">
        <a href="{{ route('regional.management.financial_treasury') }}">
          <i class="fa fa-money"></i> <span>الخزينة المالية</span>
        </a>
      </li>
      <li class="{{ request()->is('regional/management/shipping*') ? 'active' : '' }}">
        <a href="{{ route('regional.management.shipping') }}">
          <i class="fa fa-truck"></i> <span>إدارة الشحن</span>
        </a>
      </li>
      <li class="{{ request()->is('regional/management/operational-status*') ? 'active' : '' }}">
        <a href="{{ route('regional.management.operational_status') }}">
          <i class="fa fa-refresh"></i> <span>تحديث الحالة التشغيلية</span>
        </a>
      </li>
      <li class="{{ request()->is('regional/management/linked-clients*') ? 'active' : '' }}">
        <a href="{{ route('regional.management.linked_clients') }}">
          <i class="fa fa-users"></i> <span>إدارة العملاء المرتبطين</span>
        </a>
      </li>
      <li class="{{ request()->is('regional/management/campaigns*') ? 'active' : '' }}">
        <a href="{{ route('regional.management.campaigns') }}">
          <i class="fa fa-bullhorn"></i> <span>الحملات التشغيلية</span>
        </a>
      </li>
      <li class="{{ request()->is('regional/management/reports*') ? 'active' : '' }}">
        <a href="{{ route('regional.management.reports') }}">
          <i class="fa fa-bar-chart"></i> <span>التقارير التشغيلية</span>
        </a>
      </li>
      <li class="{{ request()->is('regional/management/documentation*') ? 'active' : '' }}">
        <a href="{{ route('regional.management.documentation') }}">
          <i class="fa fa-file-text-o"></i> <span>التوثيق والتعاقد</span>
        </a>
      </li>
      <li class="{{ request()->is('regional/management/logistics-risk*') ? 'active' : '' }}">
        <a href="{{ route('regional.management.logistics_risk') }}">
          <i class="fa fa-shield"></i> <span>إدارة المخاطر اللوجستية</span>
        </a>
      </li>
      <li class="{{ request()->is('regional/management/sla*') ? 'active' : '' }}">
        <a href="{{ route('regional.management.sla') }}">
          <i class="fa fa-handshake-o"></i> <span>إدارة SLA</span>
        </a>
      </li>
      <li class="{{ request()->is('regional/performance-kpi*') ? 'active' : '' }}">
        <a href="{{ route('regional.performance_kpi.index') }}">
          <i class="fa fa-line-chart"></i> <span>تقييم الأداء التشغيلي (KPI)</span>
        </a>
      </li>
    </ul>
  </section>
</aside>
