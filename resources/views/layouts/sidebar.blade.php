<aside class="main-sidebar">

  <!-- الشريط الجانبي -->
  <section class="sidebar">

    <!-- لوحة المستخدم -->
    <div class="user-panel">
      <div class="pull-right image">
<img src="{{ asset('dist/img/user4-128x128.jpg') }}" class="user-image" alt="صورة المستخدم">
      </div>
      <div class="pull-right info">
        <p>{{ Auth::user()->name ?? 'مستخدم غير معروف' }}</p>
        <a href="#"><i class="fa fa-circle text-success"></i> متصل الآن</a>
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
      <li class="header">القائمة الرئيسية</li>

      <!-- الرئيسية -->
      <li class="{{ request()->is('admin') ? 'active' : '' }}">
        <a href="{{ url('admin') }}">
          <i class="fa fa-dashboard"></i> <span>الرئيسية</span>
        </a>
      </li>

      <!-- إدارة النظام -->
      @if(auth()->user() && auth()->user()->hasRole('admin'))
      <li class="treeview {{ request()->is('admin/users*') || request()->is('admin/roles*') || request()->is('admin/permissions*') ? 'active' : '' }}">
        <a href="#">
          <i class="fa fa-cogs"></i> <span>إدارة النظام</span>
          <span class="pull-left-container">
            <i class="fa fa-angle-right pull-left"></i>
          </span>
        </a>

        <ul class="treeview-menu">

          <li class="{{ request()->is('admin/users*') ? 'active' : '' }}">
            <a href="{{ route('users.index') }}">
              <i class="fa fa-users"></i> المستخدمين
            </a>
          </li>

          <li class="{{ request()->is('admin/roles*') ? 'active' : '' }}">
            <a href="{{ route('roles.index') }}">
              <i class="fa fa-id-badge"></i> الأدوار
            </a>
          </li>

          <li class="{{ request()->is('admin/permissions*') ? 'active' : '' }}">
            <a href="{{ route('permissions.index') }}">
              <i class="fa fa-lock"></i> الصلاحيات
            </a>
          </li>

        </ul>
      </li>
      @endif

      <!-- صفحات أخرى -->
      <li>
        <a href="#">
          <i class="fa fa-info-circle"></i> <span>حول النظام</span>
        </a>
      </li>
    </ul>
    <!-- /قائمة الشريط الجانبي -->

  </section>
  <!-- /الشريط الجانبي -->
</aside>
