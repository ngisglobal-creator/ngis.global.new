<aside class="main-sidebar">
  <section class="sidebar">
    <div class="user-panel">
      <div class="pull-right image">
        <img src="{{ Auth::user()->avatar_url }}" class="img-circle" alt="User Image">
      </div>
      <div class="pull-right info">
        <p>{{ Auth::user()->name }}</p>
        <a href="#"><i class="fa fa-circle text-success"></i> متصل</a>
      </div>
    </div>
    <ul class="sidebar-menu" data-widget="tree">
      <li class="header">الرئيسية</li>
      <li class="{{ request()->is('ngis/dashboard') ? 'active' : '' }}">
        <a href="{{ route('ngis.dashboard') }}">
          <i class="fa fa-dashboard"></i> <span>لوحة التحكم</span>
        </a>
      </li>

      <!-- القسم الأول: مكتب إقليمي داخلي -->
      <li class="header">مكتب إقليمي داخلي</li>
      <li class="{{ request()->is('ngis/internal/clients*') ? 'active' : '' }}">
        <a href="{{ route('ngis.internal.clients') }}"><i class="fa fa-users"></i> <span>إدارة العمــــــلاء</span></a>
      </li>
      <li class="{{ request()->is('ngis/internal/orders*') ? 'active' : '' }}">
        <a href="{{ route('ngis.internal.orders') }}"><i class="fa fa-shopping-cart"></i> <span>إدارة الطلبــــــات</span></a>
      </li>
      <li class="{{ request()->is('ngis/internal/auctions*') ? 'active' : '' }}">
        <a href="{{ route('ngis.internal.auctions') }}"><i class="fa fa-gavel"></i> <span>إدارة المزادــــــات الدولية</span></a>
      </li>
      <li class="{{ request()->is('ngis/internal/treasury*') ? 'active' : '' }}">
        <a href="{{ route('ngis.internal.treasury') }}"><i class="fa fa-money"></i> <span>الخزينــــــة الماليــــــة</span></a>
      </li>
      <li class="{{ request()->is('ngis/internal/campaigns*') ? 'active' : '' }}">
        <a href="{{ route('ngis.internal.campaigns') }}"><i class="fa fa-bullhorn"></i> <span>الحملــــــات الإعلانيــــــة</span></a>
      </li>
      <li class="{{ request()->is('ngis/internal/shipping*') ? 'active' : '' }}">
        <a href="{{ route('ngis.internal.shipping') }}"><i class="fa fa-truck"></i> <span>إدارة شركــــــات الشحــــــن</span></a>
      </li>
      <li class="{{ request()->is('ngis/internal/suppliers*') ? 'active' : '' }}">
        <a href="{{ route('ngis.internal.suppliers') }}"><i class="fa fa-building"></i> <span>إدارة المورديــــــن والشركات</span></a>
      </li>
      <li class="{{ request()->is('ngis/internal/bi*') ? 'active' : '' }}">
        <a href="{{ route('ngis.internal.bi') }}"><i class="fa fa-bar-chart"></i> <span>التقاريــــــر التشغيليــــــة (BI)</span></a>
      </li>
      <li class="{{ request()->is('ngis/internal/client-auth*') ? 'active' : '' }}">
        <a href="{{ route('ngis.internal.client_auth') }}"><i class="fa fa-id-card"></i> <span>إدارة توكيلات العملاء</span></a>
      </li>
      <li class="{{ request()->is('ngis/internal/contracts*') ? 'active' : '' }}">
        <a href="{{ route('ngis.internal.contracts') }}"><i class="fa fa-file-text"></i> <span>إدارة التوثيــــــق والتعاقــــــد</span></a>
      </li>
      <li class="{{ request()->is('ngis/internal/risk*') ? 'active' : '' }}">
        <a href="{{ route('ngis.internal.risk') }}"><i class="fa fa-shield"></i> <span>إدارة المخاطر</span></a>
      </li>
      <li class="{{ request()->is('ngis/internal/compliance*') ? 'active' : '' }}">
        <a href="{{ route('ngis.internal.compliance') }}"><i class="fa fa-check-square"></i> <span>إدارة الامتثال التجاري</span></a>
      </li>
      <li class="{{ request()->is('ngis/internal/support*') ? 'active' : '' }}">
        <a href="{{ route('ngis.internal.support') }}"><i class="fa fa-support"></i> <span>إدارة الدعــــــم والمتابعــــــة</span></a>
      </li>

      <!-- القسم الثاني: مكتب توريد دولي -->
      <li class="header">مكتب توريد دولي</li>
      <li class="{{ request()->is('ngis/international/contracts*') ? 'active' : '' }}">
        <a href="{{ route('ngis.international.contracts') }}"><i class="fa fa-file-pdf-o"></i> <span>قسم التوثيــــــق والتعاقــــــد</span></a>
      </li>
      <li class="{{ request()->is('ngis/international/factories*') ? 'active' : '' }}">
        <a href="{{ route('ngis.international.factories') }}"><i class="fa fa-industry"></i> <span>قسم إدارة المصانــــــع</span></a>
      </li>
      <li class="{{ request()->is('ngis/international/orders*') ? 'active' : '' }}">
        <a href="{{ route('ngis.international.orders') }}"><i class="fa fa-tasks"></i> <span>قسم إدارة الطلبــــــات</span></a>
      </li>
      <li class="{{ request()->is('ngis/international/treasury*') ? 'active' : '' }}">
        <a href="{{ route('ngis.international.treasury') }}"><i class="fa fa-bank"></i> <span>الخزينــــــة الماليــــــة NGIS</span></a>
      </li>
      <li class="{{ request()->is('ngis/international/shipping*') ? 'active' : '' }}">
        <a href="{{ route('ngis.international.shipping') }}"><i class="fa fa-globe"></i> <span>قسم إدارة الشحــــــن الدولي</span></a>
      </li>
      <li class="{{ request()->is('ngis/international/investments*') ? 'active' : '' }}">
        <a href="{{ route('ngis.international.investments') }}"><i class="fa fa-briefcase"></i> <span>قسم إدارة الاستثمارات</span></a>
      </li>
      <li class="{{ request()->is('ngis/international/auctions*') ? 'active' : '' }}">
        <a href="{{ route('ngis.international.auctions') }}"><i class="fa fa-legal"></i> <span>قسم إدارة المزادــــــات NGIS</span></a>
      </li>
      <li class="{{ request()->is('ngis/international/legal-risk*') ? 'active' : '' }}">
        <a href="{{ route('ngis.international.legal_risk') }}"><i class="fa fa-balance-scale"></i> <span>القسم القانونــــــي والمخاطر</span></a>
      </li>
      <li class="{{ request()->is('ngis/international/supply-chain*') ? 'active' : '' }}">
        <a href="{{ route('ngis.international.supply_chain') }}"><i class="fa fa-link"></i> <span>إدارة سلاسل الإمداد</span></a>
      </li>
      <li class="{{ request()->is('ngis/international/compliance*') ? 'active' : '' }}">
        <a href="{{ route('ngis.international.compliance') }}"><i class="fa fa-certificate"></i> <span>إدارة الامتثال الدولي</span></a>
      </li>
      <li class="{{ request()->is('ngis/international/support*') ? 'active' : '' }}">
        <a href="{{ route('ngis.international.support') }}"><i class="fa fa-phone"></i> <span>قسم إدارة الدعــــــم</span></a>
      </li>
    </ul>
  </section>
</aside>
