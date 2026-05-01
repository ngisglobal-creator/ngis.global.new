<header class="main-header">
    <!-- الشعار -->
    <a href="{{ url('/') }}" class="logo">
      <!-- شعار مصغّر يظهر في القائمة الجانبية (حجمه 50x50 بكسل) -->
      <span class="logo-mini">
        <img src="{{ \App\Models\Setting::logoUrl() }}" style="height: 30px;">
      </span>
      <!-- الشعار الكامل للعرض العادي والجوال -->
      <span class="logo-lg"><b>{{ \App\Models\Setting::get('site_name', 'لوحة تحكم') }}</b></span>
    </a>

    <!-- شريط التنقل العلوي -->
    <nav class="navbar navbar-static-top">
      <!-- زر إظهار/إخفاء القائمة الجانبية -->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">تبديل القائمة</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">

          <!-- المحفظة -->
          <li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" title="المحفظة" style="display: flex; align-items: center; gap: 10px; padding: 10px 15px;">
              <i class="fa fa-google-wallet" style="font-size: 24px; color: #fff;"></i>
              <span class="wallet-balance" style="font-size: 18px; font-weight: bold; font-family: 'Arial', sans-serif; color: #fff; direction: ltr;">
                @if(auth()->user()->hasRole('admin') && request()->routeIs('admin.wallets.*'))
                  {{ number_format(\App\Models\User::sum('wallet_balance'), 2, '.', '') }}
                @else
                  {{ number_format(auth()->user()->wallet_balance, 2, '.', '') }}
                @endif
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
                  <li>
                    <a href="javascript:void(0)" onclick="event.preventDefault(); document.getElementById('lang-ar').submit();">
                      {{ __('dashboard.arabic') }}
                    </a>
                  </li>
                  <li>
                    <a href="javascript:void(0)" onclick="event.preventDefault(); document.getElementById('lang-en').submit();">
                      {{ __('dashboard.english') }}
                    </a>
                  </li>
                  <li>
                    <a href="javascript:void(0)" onclick="event.preventDefault(); document.getElementById('lang-zh').submit();">
                      {{ __('dashboard.chinese') }}
                    </a>
                  </li>
                </ul>
              </li>
            </ul>
            <form id="lang-ar" action="{{ route('language.set') }}" method="POST" style="display: none;">@csrf<input type="hidden" name="locale" value="ar"></form>
            <form id="lang-en" action="{{ route('language.set') }}" method="POST" style="display: none;">@csrf<input type="hidden" name="locale" value="en"></form>
            <form id="lang-zh" action="{{ route('language.set') }}" method="POST" style="display: none;">@csrf<input type="hidden" name="locale" value="zh"></form>
          </li>

          <!-- الرسائل -->
          <li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-envelope-o"></i>
              <span class="label label-success">4</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">4 رسائل غير مقروءة</li>
              <li>
                <!-- القائمة الداخلية للرسائل -->
                <ul class="menu">
                  <li>
                    <a href="#">
                      <div class="pull-right">
               <img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="img-circle" alt="صورة المستخدم">
                      </div>
                      <h4>
                        علي
                        <small><i class="fa fa-clock-o"></i> قبل 5 دقائق</small>
                      </h4>
                      <p>نص الرسالة</p>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="pull-right">
                   <img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="img-circle" alt="صورة المستخدم">
                      </div>
                      <h4>
                        ندى
                        <small><i class="fa fa-clock-o"></i> قبل ساعتين</small>
                      </h4>
                      <p>نص الرسالة</p>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="pull-right">
                        <img src="dist/img/user4-128x128.jpg" class="img-circle" alt="صورة المستخدم">
                      </div>
                      <h4>
                        نسرين
                        <small><i class="fa fa-clock-o"></i> اليوم</small>
                      </h4>
                      <p>نص الرسالة</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="footer"><a href="#">عرض جميع الرسائل</a></li>
            </ul>
          </li>

          <!-- الإشعارات -->
          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning">10</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">10 إشعارات جديدة</li>
              <li>
                <ul class="menu">
                  <li>
                    <a href="#"><i class="fa fa-users text-aqua"></i> تم تسجيل 5 مستخدمين جدد</a>
                  </li>
                  <li>
                    <a href="#"><i class="fa fa-warning text-yellow"></i> تحذير: يرجى الانتباه</a>
                  </li>
                  <li>
                    <a href="#"><i class="fa fa-shopping-cart text-green"></i> 25 طلب جديد</a>
                  </li>
                  <li>
                    <a href="#"><i class="fa fa-user text-red"></i> تم تغيير اسم المستخدم</a>
                  </li>
                </ul>
              </li>
              <li class="footer"><a href="#">عرض الكل</a></li>
            </ul>
          </li>

          <!-- المهام -->
          <li class="dropdown tasks-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-flag-o"></i>
              <span class="label label-danger">9</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">لديك 9 مهام للإنجاز</li>
              <li>
                <ul class="menu">
                  <li>
                    <a href="#">
                      <h3>إنشاء زر <small class="pull-left">20%</small></h3>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-aqua" style="width:20%"></div>
                      </div>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <h3>تصميم قالب جديد <small class="pull-left">40%</small></h3>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-green" style="width:40%"></div>
                      </div>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <h3>الترويج والإعلانات <small class="pull-left">60%</small></h3>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-red" style="width:60%"></div>
                      </div>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <h3>إنشاء صفحة هبوط <small class="pull-left">80%</small></h3>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-yellow" style="width:80%"></div>
                      </div>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="footer"><a href="#">عرض جميع المهام</a></li>
            </ul>
          </li>

          <!-- حساب المستخدم -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
<img src="{{ asset('dist/img/user4-128x128.jpg') }}" class="user-image" alt="صورة المستخدم">

              <span class="hidden-xs">عبد الرحمن أحمد</span>
            </a>
            <ul class="dropdown-menu">
              <!-- صورة المستخدم -->
              <li class="user-header">
<img src="{{ asset('dist/img/user4-128x128.jpg') }}" class="user-image" alt="صورة المستخدم">
                <p>
                  عبد الرحمن أحمد
                  <small>مدير النظام</small>
                </p>
              </li>

              <!-- محتوى القائمة -->
              <li class="user-body">
                <div class="row">
                  <div class="text-center col-xs-4"><a href="#">صفحتي</a></div>
                  <div class="text-center col-xs-4"><a href="#">المبيعات</a></div>
                  <div class="text-center col-xs-4"><a href="#">الأصدقاء</a></div>
                </div>
              </li>

              <!-- الفوتر -->
              <li class="user-footer">
                <div class="pull-right">
                  <a href="#" class="btn btn-default btn-flat">الملف الشخصي</a>
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

          <!-- زر إعدادات إضافية -->
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>

        </ul>
      </div>
    </nav>
</header>
