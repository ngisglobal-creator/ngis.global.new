<aside class="main-sidebar">

  <!-- الشريط الجانبي -->
  <section class="sidebar">

    <!-- لوحة المستخدم -->
    <div class="user-panel">
      <div class="pull-right image">
        <img src="{{ Auth::user()->avatar ? \Illuminate\Support\Facades\Storage::url(Auth::user()->avatar) : asset('dist/img/user4-128x128.jpg') }}" class="img-circle" alt="User Image">
      </div>
      <div class="pull-right info">
        <p>{{ Auth::user()->name ?? 'مستخدم' }}</p>
        <a href="{{ route('profile.edit') }}"><i class="fa fa-circle text-success"></i> {{ __('dashboard.profile') }}</a>
      </div>
    </div>

    <!-- نموذج البحث -->
    <form action="#" method="get" class="sidebar-form">
      <div class="input-group">
        <input type="text" name="q" class="form-control" placeholder="بحث...">
        <span class="input-group-btn">
          <button type="submit" name="search" id="search-btn" class="btn btn-flat">
            <i class="fa fa-search"></i>
          </button>
        </span>
      </div>
    </form>

    <!-- قائمة الشريط الجانبي -->
    <ul class="sidebar-menu" data-widget="tree">
      <li class="header">{{ __('dashboard.home') }}</li>

      <!-- الرئيسية -->
      <li class="{{ (request()->is('admin') || request()->is('client/dashboard') || request()->is('company/dashboard') || request()->is('factory/dashboard') || request()->is('regional/dashboard')) ? 'active' : '' }}">
        <a href="{{ url(auth()->user()->panel_type . '/dashboard') }}">
          <i class="fa fa-dashboard"></i> <span>{{ __('dashboard.home') }}</span>
        </a>
      </li>

      <!-- الإشعارات -->
      <li class="{{ request()->is('*/notifications*') ? 'active' : '' }}">
        @php
            $unreadCount = auth()->user()->unreadNotifications->count();
        @endphp
        <a href="{{ route(auth()->user()->panel_type . '.notifications.index') }}">
          <i class="fa fa-bell"></i> <span>الإشعارات</span>
          @if($unreadCount > 0)
            <span class="pull-left-container">
              <span class="label label-danger pull-left">{{ $unreadCount }}</span>
            </span>
          @endif
        </a>
      </li>

      <!-- الملف الشخصي -->
      <li class="{{ request()->is('profile*') ? 'active' : '' }}">
        <a href="{{ route('profile.edit') }}">
          <i class="fa fa-user"></i> <span>{{ __('dashboard.profile') }}</span>
        </a>
      </li>

      @if(auth()->user() && (auth()->user()->type === 'global_forwarding' || auth()->user()->hasRole('admin')))
      <li class="header">إدارة الشحن الدولي</li>
      
      <li class="{{ request()->is('global-forwarding/dashboard') ? 'active' : '' }}">
        <a href="{{ route('global_forwarding.dashboard') }}">
          <i class="fa fa-dashboard"></i> <span>لوحة التحكم (الشحن)</span>
        </a>
      </li>

      <li class="{{ request()->is('global-forwarding/orders/standard') ? 'active' : '' }}">
        <a href="{{ route('global_forwarding.orders.standard') }}">
          <i class="fa fa-box"></i> <span>الطلبات العامة</span>
        </a>
      </li>

      <li class="{{ request()->is('global-forwarding/orders/custom') ? 'active' : '' }}">
        <a href="{{ route('global_forwarding.orders.custom') }}">
          <i class="fa fa-search-plus"></i> <span>الطلبات الخاصة</span>
        </a>
      </li>

      <li class="{{ request()->is('global-forwarding/orders/matched-products') ? 'active' : '' }}">
        <a href="{{ route('global_forwarding.orders.matched_products') }}">
          <i class="fa fa-check-square-o"></i> <span>المنتجات المطابقة</span>
        </a>
      </li>

      <li class="{{ request()->is('global-forwarding/qr-passport') ? 'active' : '' }}">
        <a href="{{ route('global_forwarding.qr_passport') }}">
          <i class="fa fa-qrcode"></i> <span>التوثيق الرقمي</span>
        </a>
      </li>

      <li class="{{ request()->is('global-forwarding/insurance') ? 'active' : '' }}">
        <a href="{{ route('global_forwarding.insurance') }}">
          <i class="fa fa-shield"></i> <span>التأمين والامتثال</span>
        </a>
      </li>

      <li class="{{ request()->is('global-forwarding/liability-risk') ? 'active' : '' }}">
        <a href="{{ route('global_forwarding.liability_risk') }}">
          <i class="fa fa-balance-scale"></i> <span>إدارة المخاطر</span>
        </a>
      </li>

      <li class="{{ request()->is('global-forwarding/regional-integration') ? 'active' : '' }}">
        <a href="{{ route('global_forwarding.regional_integration') }}">
          <i class="fa fa-link"></i> <span>الربط اللوجستي</span>
        </a>
      </li>
      @endif

      @if(auth()->user() && (in_array(auth()->user()->type, ['client', 'merchant', 'company_owner', 'company']) || auth()->user()->hasRole('admin')))
      <li class="header">خدمات العميل</li>
      <li class="{{ request()->is('client/special-order') ? 'active' : '' }}">
        <a href="{{ route('client.special_order') }}">
          <i class="fa fa-star-o"></i> <span>طلب خاص (Sourcing)</span>
        </a>
      </li>
      <li class="{{ request()->is('client/subscription-plans') ? 'active' : '' }}">
        <a href="{{ route('client.subscription.plans') }}">
          <i class="fa fa-cubes"></i> <span>باقات الاشتراك</span>
        </a>
      </li>
      <li class="{{ request()->is('client/my-wallet') ? 'active' : '' }}">
        <a href="{{ route('client.wallet') }}">
          <i class="fa fa-google-wallet"></i> <span>محفظتي</span>
        </a>
      </li>
      @endif

      @if(auth()->user() && auth()->user()->hasRole('admin'))
      <li class="treeview {{ request()->is('admin/wallets*') || request()->is('admin/invoices*') ? 'active' : '' }}">
        <a href="#">
          <i class="fa fa-money"></i> <span>قسم عمليات المالية</span>
          <span class="pull-left-container"><i class="fa fa-angle-right pull-left"></i></span>
        </a>
        <ul class="treeview-menu">
          <li class="{{ request()->is('admin/wallets*') ? 'active' : '' }}">
            <a href="{{ route('admin.wallets.index') }}">
              <i class="fa fa-google-wallet"></i> المحافظ
            </a>
          </li>
          <li class="{{ request()->is('admin/invoices') ? 'active' : '' }}">
            <a href="{{ route('admin.invoices.index') }}">
              <i class="fa fa-file-text-o"></i> الفواتير
            </a>
          </li>
          <li class="{{ request()->is('admin/invoices/payment-status') ? 'active' : '' }}">
            <a href="{{ route('admin.invoices.payment_status') }}">
              <i class="fa fa-credit-card"></i> حالات دفع الفواتير
            </a>
          </li>
          <li class="{{ request()->is('admin/invoices/paid') ? 'active' : '' }}">
            <a href="{{ route('admin.invoices.paid') }}">
              <i class="fa fa-check-circle"></i> الفواتير المدفوعة
            </a>
          </li>
        </ul>
      </li>

      {{-- ===== قسم الباقات ===== --}}
      <li class="treeview {{ request()->is('admin/packages*') || request()->is('admin/user-packages*') ? 'active' : '' }}">
        <a href="#">
          <i class="fa fa-cubes"></i> <span>قسم الباقات</span>
          <span class="pull-left-container"><i class="fa fa-angle-right pull-left"></i></span>
        </a>
        <ul class="treeview-menu">
          <li class="{{ request()->is('admin/packages*') ? 'active' : '' }}">
            <a href="{{ route('admin.packages.index') }}">
              <i class="fa fa-cubes"></i> الباقات
            </a>
          </li>
          <li class="{{ request()->is('admin/user-packages*') ? 'active' : '' }}">
            <a href="{{ route('admin.user-packages.index') }}">
              <i class="fa fa-star"></i> إعدادات الباقات للمستخدمين
            </a>
          </li>
        </ul>
      </li>

      {{-- ===== قسم القطاعات ===== --}}
      <li class="treeview {{ request()->is('admin/sectors*') || request()->is('admin/branches*') || request()->is('admin/categories*') ? 'active' : '' }}">
        <a href="#">
          <i class="fa fa-th"></i> <span>قسم القطاعات</span>
          <span class="pull-left-container"><i class="fa fa-angle-right pull-left"></i></span>
        </a>
        <ul class="treeview-menu">
          <li class="{{ request()->is('admin/sectors*') ? 'active' : '' }}">
            <a href="{{ route('admin.sectors.index') }}">
              <i class="fa fa-th"></i> القطاعات
            </a>
          </li>
          <li class="{{ request()->is('admin/branches*') ? 'active' : '' }}">
            <a href="{{ route('admin.branches.index') }}">
              <i class="fa fa-code-fork"></i> فروع القطاعات
            </a>
          </li>
          <li class="{{ request()->is('admin/categories*') ? 'active' : '' }}">
            <a href="{{ route('admin.categories.index') }}">
              <i class="fa fa-list"></i> أقسام الفروع
            </a>
          </li>
        </ul>
      </li>

      {{-- ===== إدارة التتبع ===== --}}
      <li class="treeview {{ request()->is('admin/factories*') || request()->is('admin/companies*') || request()->is('admin/clients*') || request()->is('admin/regional*') ? 'active' : '' }}">
        <a href="#">
          <i class="fa fa-briefcase"></i> <span>إدارة تتبع النظام</span>
          <span class="pull-left-container"><i class="fa fa-angle-right pull-left"></i></span>
        </a>
        <ul class="treeview-menu">
          <li class="treeview {{ request()->is('admin/factories*') ? 'active' : '' }}">
            <a href="#">
              <i class="fa fa-industry"></i> إدارة المصانع
              <span class="pull-left-container"><i class="fa fa-angle-right pull-left"></i></span>
            </a>
            <ul class="treeview-menu">
              <li><a href="{{ route('admin.factories.index') }}"><i class="fa fa-circle-o"></i> عرض المصانع</a></li>
              <li><a href="{{ route('admin.factories.products') }}"><i class="fa fa-circle-o"></i> منتجات المصانع</a></li>
            </ul>
          </li>
          <li class="treeview {{ request()->is('admin/companies*') ? 'active' : '' }}">
            <a href="#">
              <i class="fa fa-building"></i> إدارة الشركات
              <span class="pull-left-container"><i class="fa fa-angle-right pull-left"></i></span>
            </a>
            <ul class="treeview-menu">
              <li><a href="{{ route('admin.companies.index') }}"><i class="fa fa-circle-o"></i> عرض الشركات</a></li>
              <li><a href="{{ route('admin.companies.products') }}"><i class="fa fa-circle-o"></i> منتجات الشركات</a></li>
            </ul>
          </li>
          <li class="treeview {{ request()->is('admin/clients*') ? 'active' : '' }}">
            <a href="#">
              <i class="fa fa-users"></i> إدارة العملاء
              <span class="pull-left-container"><i class="fa fa-angle-right pull-left"></i></span>
            </a>
            <ul class="treeview-menu">
              <li><a href="{{ route('admin.clients.index') }}"><i class="fa fa-circle-o"></i> عرض العملاء</a></li>
              <li><a href="{{ route('admin.clients.orders') }}"><i class="fa fa-circle-o"></i> طلبات العملاء</a></li>
            </ul>
          </li>
          <li class="{{ request()->is('admin/regional*') ? 'active' : '' }}">
            <a href="{{ route('admin.regional.index') }}">
              <i class="fa fa-globe"></i> المكاتب الإقليمية
            </a>
          </li>
          <li class="{{ request()->is('admin/order-statuses*') ? 'active' : '' }}">
            <a href="{{ route('admin.order-statuses.index') }}">
              <i class="fa fa-list-ol"></i> مسميات حالة الطلب
            </a>
          </li>
        </ul>
      </li>

      <li class="treeview {{ request()->is('admin/china*') ? 'active' : '' }}">
        <a href="#">
          <i class="fa fa-flag"></i> <span>إدارة الصين</span>
          <span class="pull-left-container"><i class="fa fa-angle-right pull-left"></i></span>
        </a>
        <ul class="treeview-menu">
          <li class="{{ request()->is('china/invoices*') ? 'active' : '' }}">
            <a href="{{ route('china.invoices') }}"><i class="fa fa-file-text-o"></i> الفواتير الموجهة</a>
          </li>
          <li class="{{ request()->is('china/regional-offices*') ? 'active' : '' }}">
            <a href="{{ route('china.regional_offices') }}"><i class="fa fa-globe"></i> مكاتب الأقاليم</a>
          </li>
          <li class="{{ request()->is('china/customers*') ? 'active' : '' }}">
            <a href="{{ route('china.customers') }}"><i class="fa fa-users"></i> العملاء</a>
          </li>
          <li class="{{ request()->is('china/product-status*') ? 'active' : '' }}">
            <a href="{{ route('china.product_status') }}"><i class="fa fa-ship"></i> حالات المنتجات</a>
          </li>
        </ul>
      </li>

      {{-- ===== الدول ونطاقات العمل الجغرافي ===== --}}
      <li class="treeview {{ request()->is('admin/countries*') || request()->is('admin/geographic-zones*') || request()->is('admin/office-zones*') ? 'active' : '' }}">
        <a href="#">
          <i class="fa fa-map"></i> <span>نطاقات العمل الجغرافي</span>
          <span class="pull-left-container"><i class="fa fa-angle-right pull-left"></i></span>
        </a>
        <ul class="treeview-menu">
          <li class="{{ request()->is('admin/countries*') ? 'active' : '' }}"><a href="{{ route('admin.countries.index') }}"><i class="fa fa-circle-o"></i> إدارة الدول</a></li>
          <li class="{{ request()->is('admin/geographic-zones*') ? 'active' : '' }}"><a href="{{ route('admin.geographic-zones.index') }}"><i class="fa fa-circle-o"></i> إدارة النطاقات</a></li>
          <li class="{{ request()->is('admin/office-zones*') ? 'active' : '' }}"><a href="{{ route('admin.office-zones.index') }}"><i class="fa fa-circle-o"></i> اختيار نطاقات للمكاتب</a></li>
        </ul>
      </li>

      {{-- ===== قسم العملات ===== --}}
      <li class="{{ request()->is('admin/currencies*') ? 'active' : '' }}">
        <a href="{{ route('admin.currencies.index') }}">
          <i class="fa fa-dollar"></i> <span>قسم العملات</span>
        </a>
      </li>

      {{-- ===== إدارة التوثيق ===== --}}
      <li class="treeview {{ request()->is('admin/verifications*') || request()->is('admin/user-verifications*') ? 'active' : '' }}">
        <a href="#">
          <i class="fa fa-shield"></i> <span>إدارة التوثيق</span>
          <span class="pull-left-container"><i class="fa fa-angle-right pull-left"></i></span>
        </a>
        <ul class="treeview-menu">
          <li class="{{ request()->is('admin/verifications*') ? 'active' : '' }}">
            <a href="{{ route('admin.verifications.index') }}">
              <i class="fa fa-check-circle"></i> التوثيقات
            </a>
          </li>
          <li class="{{ request()->is('admin/user-verifications*') ? 'active' : '' }}">
            <a href="{{ route('admin.user-verifications.index') }}">
              <i class="fa fa-id-badge"></i> إعطاء توثيقات
            </a>
          </li>
        </ul>
      </li>

      <li class="treeview {{ request()->is('admin/users*') || request()->is('admin/roles*') || request()->is('admin/permissions*') || request()->is('admin/settings*') ? 'active' : '' }}">
        <a href="#">
          <i class="fa fa-cogs"></i> <span>{{ __('dashboard.settings') }}</span>
          <span class="pull-left-container">
            <i class="fa fa-angle-right pull-left"></i>
          </span>
        </a>

        <ul class="treeview-menu">

          <li class="{{ request()->is('admin/users*') ? 'active' : '' }}">
            <a href="{{ route('admin.users.index') }}">
              <i class="fa fa-users"></i> {{ __('dashboard.users') }}
            </a>
          </li>

          <li class="{{ request()->is('admin/roles*') ? 'active' : '' }}">
            <a href="{{ route('admin.roles.index') }}">
              <i class="fa fa-id-badge"></i> {{ __('dashboard.roles') }}
            </a>
          </li>

          <li class="{{ request()->is('admin/permissions*') ? 'active' : '' }}">
            <a href="{{ route('admin.permissions.index') }}">
              <i class="fa fa-lock"></i> {{ __('dashboard.permissions') }}
            </a>
          </li>

          <li class="{{ request()->is('admin/settings*') ? 'active' : '' }}">
            <a href="{{ route('admin.settings.index') }}">
              <i class="fa fa-gear"></i> {{ __('dashboard.settings') }}
            </a>
          </li>

        </ul>
      </li>
      @endif
    </ul>
    <!-- /قائمة الشريط الجانبي -->

  </section>
  <!-- /الشريط الجانبي -->
</aside>
