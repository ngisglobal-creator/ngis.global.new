<header class="main-header">
  <a href="{{ url('client/dashboard') }}" class="logo">
    <span class="logo-mini">
        <img src="{{ \App\Models\Setting::logoUrl() }}" style="height: 30px;">
    </span>
    <span class="logo-lg"><b>{{ \App\Models\Setting::get('site_name', __('dashboard.client')) }}</b></span>
  </a>
  <nav class="navbar navbar-static-top">
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
      <span class="sr-only">تبديل القائمة</span>
    </a>
    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
        <!-- المحفظة -->
        <li class="dropdown messages-menu">
          <a href="{{ route('client.wallet') }}" class="dropdown-toggle" title="المحفظة" style="display: flex; align-items: center; gap: 10px; padding: 10px 15px;">
            <i class="fa fa-google-wallet" style="font-size: 24px; color: #fff;"></i>
            <span class="wallet-balance" style="font-size: 18px; font-weight: bold; font-family: 'Arial', sans-serif; color: #fff; direction: ltr;">
              {{ number_format(auth()->user()->wallet_balance, 2, '.', '') }}
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
                <li><a href="javascript:void(0)" onclick="event.preventDefault(); document.getElementById('lang-ar').submit();">{{ __('dashboard.arabic') }}</a></li>
                <li><a href="javascript:void(0)" onclick="event.preventDefault(); document.getElementById('lang-en').submit();">{{ __('dashboard.english') }}</a></li>
                <li><a href="javascript:void(0)" onclick="event.preventDefault(); document.getElementById('lang-zh').submit();">{{ __('dashboard.chinese') }}</a></li>
              </ul>
            </li>
          </ul>
          <form id="lang-ar" action="{{ route('language.set') }}" method="POST" style="display: none;">@csrf<input type="hidden" name="locale" value="ar"></form>
          <form id="lang-en" action="{{ route('language.set') }}" method="POST" style="display: none;">@csrf<input type="hidden" name="locale" value="en"></form>
          <form id="lang-zh" action="{{ route('language.set') }}" method="POST" style="display: none;">@csrf<input type="hidden" name="locale" value="zh"></form>
        </li>
        <!-- CBM Tool & Cart -->
        <li class="dropdown notifications-menu">
          <a href="#" class="dropdown-toggle" data-toggle="modal" data-target="#cbmInfoModal" title="CBM Guide & Selected Products" style="height: 50px; display: flex; align-items: center; padding: 0 15px; position: relative;">
            @if(in_array(Auth::user()->type ?? '', ['merchant', 'company_owner']))
                <div style="display: flex; align-items: center; gap: 6px;">
                    <i class="fa fa-shopping-cart" style="font-size: 22px; color: #fff;"></i>
                    <img src="{{ asset('storage/حاوية.png') }}" style="height: 20px; filter: drop-shadow(0 2px 3px rgba(0,0,0,0.4)); object-fit: contain; margin-bottom: 5px; margin-left: -12px; z-index: 10;" alt="20ft Container">
                </div>
            @else
                <i class="fa fa-shopping-cart" style="font-size: 20px; color: #fff; margin-right: 5px;"></i>
                <span style="font-weight: 900; color: #fff; letter-spacing: 1px; font-size: 14px;">CBM</span>
            @endif
            <span id="cbm-cart-badge" class="label label-danger" style="position: absolute; top: 5px; left: 5px; border-radius: 50%; width: 20px; height: 20px; line-height: 15px; text-align: center; font-size: 12px; font-weight: bold; border: 1px solid #fff; box-shadow: 0 2px 5px rgba(0,0,0,0.5); padding: 0; padding-top: 2px; display: none;">0</span>
          </a>
        </li>
        <li class="dropdown user user-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <img src="{{ asset('dist/img/user4-128x128.jpg') }}" class="user-image" alt="صورة المستخدم">
            <span class="hidden-xs">{{ Auth::user()->name ?? 'عميل' }}</span>
          </a>
          <ul class="dropdown-menu">
            <li class="user-header">
              <img src="{{ asset('dist/img/user4-128x128.jpg') }}" class="user-image" alt="صورة المستخدم">
              <p>
                {{ Auth::user()->name ?? 'عميل' }}
                <small>عميل</small>
              </p>
            </li>
            <li class="user-footer">
              <div class="pull-left">
                <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <button type="submit" class="btn btn-default btn-flat">تسجيل الخروج</button>
                </form>
              </div>
            </li>
          </ul>
        </li>
        <li>
          <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
        </li>
      </ul>
    </div>
  </nav>
</header>

<!-- CBM Info Modal -->
<div class="modal fade" id="cbmInfoModal" tabindex="-1" role="dialog" aria-labelledby="cbmInfoModalLabel">
    <div class="modal-dialog modal-full-width" role="document" style="width: 100% !important; max-width: 100% !important; margin: 0 !important; padding: 0 !important; height: 100% !important;">
        <div class="modal-content" style="border-radius: 0; overflow: hidden; border: none; box-shadow: 0 15px 40px rgba(0,0,0,0.2); width: 100% !important; min-height: 100vh !important;">
            <div class="modal-header" style="background: linear-gradient(135deg, #1e3a5f 0%, #3c8dbc 100%); color: white; border-bottom: none; padding: 20px;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white; opacity: 1;">
                    <span aria-hidden="true" style="font-size: 28px;">&times;</span>
                </button>
                <h4 class="modal-title" id="cbmInfoModalLabel" style="font-weight: 800; font-size: 22px; display: flex; align-items: center; gap: 12px;">
                    <i class="fa fa-cube"></i>  السلة 
                </h4>
            </div>
            <div class="modal-body" style="padding: 0; background: #fff;">
                <!-- Modern Tabbed Interface -->
                <ul class="nav nav-tabs nav-justified" style="background: #f8f9fa; border-bottom: 2px solid #eee;">
                    <li class="active"><a href="#tab_cart" data-toggle="tab" style="padding: 15px; font-weight: bold; color: #3c8dbc; border: none;"><i class="fa fa-shopping-cart"></i> تفاصيل السلة اللوجستية</a></li>
                    <li><a href="#tab_heavy" data-toggle="tab" style="padding: 15px; font-weight: bold; color: #c0392b; border: none;"><i class="fa fa-truck"></i> طلبات المعدات الثقيلة <span id="heavy-cart-count" class="label label-danger" style="margin-right:5px;">0</span></a></li>
                </ul>

                <div class="tab-content" style="padding: 0;">
                    <!-- Cart Tab -->
                    <div class="tab-pane active" id="tab_cart">
                        <div id="cbm-cart-empty" style="padding: 60px 20px; text-align: center; color: #999;">
                            <i class="fa fa-shopping-basket" style="font-size: 60px; opacity: 0.2; margin-bottom: 20px;"></i>
                            <h4>سلتك فارغة حالياً</h4>
                            <p>قم بإضافة منتجات من صفحة التفاصيل لتظهر هنا.</p>
                        </div>
                        <div id="cbm-cart-content" style="display: none; padding: 20px;">
                            <!-- Print Header (Hidden on screen) -->
                            <div class="table-responsive printable-area">
                                <table class="table table-bordered table-striped text-center" style="font-size: 13px; border-radius: 8px; overflow: hidden; border: 1px solid #ddd;">
                                    <thead style="background: linear-gradient(135deg, #1e3a5f 0%, #3c8dbc 100%); color: white;">
                                        <tr>
                                            <th style="padding: 12px 5px;">الصورة</th>
                                            <th style="padding: 12px 5px;">المنتج</th>
                                            <th style="padding: 12px 5px;">ID المنتج</th>
                                            <th style="padding: 12px 5px;">سعر الوحدة</th>
                                            <th style="padding: 12px 5px;">وزن الوحدة</th>
                                            <th style="padding: 12px 5px;">CBM الوحدة</th>
                                            <th style="padding: 12px 5px;">الكمية (قطعة)</th>
                                            <th style="padding: 12px 5px; background: #2b6688;">إجمالي CBM</th>
                                            <th style="padding: 12px 5px; background: #2b6688;">إجمالي الوزن</th>
                                            <th style="padding: 12px 5px; background: #2b6688;">إجمالي السعر</th>
                                            <th style="padding: 12px 5px; background: #2b6688;">نوع الحاوية</th>
                                            <th class="no-print">إجراء</th>
                                        </tr>
                                    </thead>
                                    <tbody id="cbm-cart-items">
                                        <!-- Items filled by JS -->
                                    </tbody>
                                    <tfoot style="background: #fcfcfc; font-weight: bold; border-top: 2px solid #3c8dbc;">
                                        <tr>
                                            <td colspan="7" style="text-align: left; padding: 15px;">إجمالي سلة الشحن المخطط لها:</td>
                                            <td style="color: #3c8dbc; font-size: 16px; background: #fff9e6;"><span id="cart-total-cbm" class="english-nums">0</span></td>
                                            <td style="color: #d9534f; font-size: 16px; background: #fff9e6;"><span id="cart-total-weight" class="english-nums">0 KG</span></td>
                                            <td style="color: #856404; font-size: 16px; background: #fff9e6;"><span id="cart-total-price" class="english-nums">0</span></td>
                                            <td class="no-print" style="background: #fff9e6;"></td>
                                            <td class="no-print" style="background: #fff9e6;"></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            
                            <!-- Interactive CBM 3D Visualization & Summary -->
                            <div id="cbm-visualization-panel" style="display: none; margin-top: 25px; background: linear-gradient(145deg, #ffffff, #f0f4f8); border-radius: 12px; padding: 20px; border: 1px solid #dce4ec; box-shadow: 0 8px 15px rgba(0,0,0,0.05);">
                                <div style="display: flex; align-items: center; gap: 30px; flex-wrap: wrap;">
                                    <!-- 3D CBM Icon Container -->
                                    <div style="flex-shrink: 0; text-align: center; position: relative; width: 120px;">
                                        <div id="cbm-cube-icon" style="font-size: 80px; color: #3c8dbc; transition: all 0.4s ease; text-shadow: 2px 5px 10px rgba(60, 141, 188, 0.3);">
                                            <i class="fa fa-cubes"></i>
                                        </div>
                                        <div style="font-weight: 900; font-size: 16px; color: #1e3a5f; margin-top: 10px; letter-spacing: 1px;">CBM Tracker</div>
                                    </div>
                                    
                                    <!-- Summary Stats -->
                                    <div style="flex-grow: 1; min-width: 300px;">
                                        <h4 style="margin: 0 0 15px 0; color: #1e3a5f; font-weight: bold;"><i class="fa fa-bar-chart"></i> الإحصائيات اللوجستية للسلة بالمجمل</h4>
                                        
                                        <div style="display: flex; gap: 15px; margin-bottom: 20px; flex-wrap: wrap;">
                                            <div style="flex: 1; min-width: 120px; background: #fff; padding: 15px; border-radius: 8px; border-right: 4px solid #3c8dbc; box-shadow: 0 2px 5px rgba(0,0,0,0.03);">
                                                <div style="font-size: 11px; color: #888; text-transform: uppercase;">إجمالي الحجم (CBM)</div>
                                                <div style="font-weight: 800; font-size: 22px; color: #3c8dbc;"><span id="vis-total-cbm" class="english-nums">0.000</span></div>
                                            </div>
                                            <div style="flex: 1; min-width: 120px; background: #fff; padding: 15px; border-radius: 8px; border-right: 4px solid #f39c12; box-shadow: 0 2px 5px rgba(0,0,0,0.03);">
                                                <div style="font-size: 11px; color: #888; text-transform: uppercase;">إجمالي الوزن</div>
                                                <div style="font-weight: 800; font-size: 22px; color: #f39c12;"><span id="vis-total-weight" class="english-nums">0</span> <small>KG</small></div>
                                            </div>
                                            <div style="flex: 1; min-width: 120px; background: #fff; padding: 15px; border-radius: 8px; border-right: 4px solid #28a745; box-shadow: 0 2px 5px rgba(0,0,0,0.03);">
                                                <div style="font-size: 11px; color: #888; text-transform: uppercase;">القيمة التقريبية</div>
                                                <div style="font-weight: 800; font-size: 22px; color: #28a745;"><span id="vis-total-price" class="english-nums">0.00</span></div>
                                            </div>
                                        </div>

                                        <!-- Over 1 CBM Warning Alert -->
                                        <div id="cbm-warning-alert" style="display: none; background: #fff3f3; border: 1px solid #f5c6cb; color: #721c24; border-radius: 8px; padding: 15px; font-weight: bold; align-items: center; gap: 10px;">
                                            <i class="fa fa-exclamation-triangle" style="font-size: 24px; color: #dc3545;"></i>
                                            <div>
                                                <div style="font-size: 15px; margin-bottom: 3px;">تنبيه هام: حجم الشحنة يتخطى سعة 1 متر مكعب (CBM)!</div>
                                                <div style="font-size: 12px; font-weight: normal; color: #666;">يجب الانتباه وتوفير مسار شحن أكبر، أو تقسيم المنتجات لضمان شحن سلس وناجح.</div>
                                            </div>
                                        </div>
                                        
                                        <!-- Safe CBM Alert -->
                                        <div id="cbm-safe-alert" style="display: flex; background: #f0fdf4; border: 1px solid #c3e6cb; color: #155724; border-radius: 8px; padding: 15px; font-weight: bold; align-items: center; gap: 10px;">
                                            <i class="fa fa-check-circle" style="font-size: 24px; color: #28a745;"></i>
                                            <div>
                                                <div style="font-size: 15px; margin-bottom: 3px;">حجم الشحنة مثالي وآمن</div>
                                                <div style="font-size: 12px; font-weight: normal; color: #666;">إجمالي مساحة الشحنة متوافقة تماماً ضمن مقياس أقل من أو يساوي 1 CBM.</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Amazon Style Gallery Preview (Hidden by default) -->
                            <div id="modal-gallery-preview" class="no-print" style="display: none; margin-top: 20px; padding: 20px; background: #fdfdfd; border: 1px solid #eee; border-radius: 8px;">
                                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 15px; border-bottom: 1px solid #eee; padding-bottom: 10px;">
                                    <h5 style="font-weight: bold; color: #3c8dbc; margin: 0;"><i class="fa fa-camera"></i> معاينة صور المنتج</h5>
                                    <button type="button" onclick="CBMCart.closeGallery()" class="btn btn-xs btn-danger"><i class="fa fa-times"></i> إغلاق المعاينة</button>
                                </div>
                                <div style="display: flex; gap: 20px;">
                                    <!-- Sidebar Thumbnails -->
                                    <div id="gallery-thumbs" style="display: flex; flex-direction: column; gap: 10px; max-height: 400px; overflow-y: auto; padding-right: 5px; width: 80px;">
                                        <!-- Thumbnails here -->
                                    </div>
                                    <!-- Large Preview -->
                                    <div style="flex: 1; display: flex; align-items: center; justify-content: center; background: #fff; border: 1px solid #f0f0f0; border-radius: 6px; height: 400px; position: relative; overflow: hidden;">
                                        <img id="gallery-main-img" src="" style="max-width: 100%; max-height: 100%; object-fit: contain; transition: transform 0.3s ease;">
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Disabled Container Estimation Visuals -->
                            @if(!in_array(Auth::user()->type ?? '', ['merchant', 'company_owner']))
                            <div style="margin-top: 30px; border-top: 1px dashed #dce4ec; padding-top: 25px;">
                                <h5 style="color: #666; font-weight: bold; text-align: center; margin-bottom: 20px;">
                                    <i class="fa fa-ship"></i> تقدير أحجام الحاويات (تتطلب باقة النقل الشامل)
                                </h5>
                                <div style="display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
                                    
                                    <!-- 20FT -->
                                    <div style="flex: 1; min-width: 100px; max-width: 130px; background: #fbfbfb; border: 1px solid #eee; border-radius: 8px; padding: 15px 10px; text-align: center; color: #aaa; opacity: 0.6; filter: grayscale(100%);">
                                        <img src="{{ asset('storage/حاوية.png') }}" style="max-height: 35px; width: auto; margin-bottom: 8px; object-fit: contain; filter: drop-shadow(0 2px 2px rgba(0,0,0,0.1));" alt="20FT Container">
                                        <div style="font-weight: bold; font-size: 14px;">20FT</div>
                                        <div class="english-nums" style="font-size: 11px; margin-top: 2px;">(28 CBM)</div>
                                    </div>
                                    
                                    <!-- 40FT -->
                                    <div style="flex: 1; min-width: 100px; max-width: 130px; background: #fbfbfb; border: 1px solid #eee; border-radius: 8px; padding: 15px 10px; text-align: center; color: #aaa; opacity: 0.6; filter: grayscale(100%);">
                                        <img src="{{ asset('storage/حاوية.png') }}" style="max-height: 42px; width: auto; margin-bottom: 8px; object-fit: contain; filter: drop-shadow(0 2px 2px rgba(0,0,0,0.1));" alt="40FT Container">
                                        <div style="font-weight: bold; font-size: 14px;">40FT</div>
                                        <div class="english-nums" style="font-size: 11px; margin-top: 2px;">(40 CBM)</div>
                                    </div>
                                    
                                    <!-- 40HQ -->
                                    <div style="flex: 1; min-width: 100px; max-width: 130px; background: #fbfbfb; border: 1px solid #eee; border-radius: 8px; padding: 15px 10px; text-align: center; color: #aaa; opacity: 0.6; filter: grayscale(100%);">
                                        <img src="{{ asset('storage/حاوية.png') }}" style="max-height: 48px; width: auto; margin-bottom: 8px; object-fit: contain; filter: drop-shadow(0 2px 2px rgba(0,0,0,0.1));" alt="40HQ Container">
                                        <div style="font-weight: bold; font-size: 14px;">40HQ</div>
                                        <div class="english-nums" style="font-size: 11px; margin-top: 2px;">(68 CBM)</div>
                                    </div>
                                    
                                    <!-- 45FT -->
                                    <div style="flex: 1; min-width: 100px; max-width: 130px; background: #fbfbfb; border: 1px solid #eee; border-radius: 8px; padding: 15px 10px; text-align: center; color: #aaa; opacity: 0.6; filter: grayscale(100%);">
                                        <img src="{{ asset('storage/حاوية.png') }}" style="max-height: 56px; width: auto; margin-bottom: 8px; object-fit: contain; filter: drop-shadow(0 2px 2px rgba(0,0,0,0.1));" alt="45FT Container">
                                        <div style="font-weight: bold; font-size: 14px;">45FT</div>
                                        <div class="english-nums" style="font-size: 11px; margin-top: 2px;">(78 CBM)</div>
                                    </div>
                                    
                                </div>
                                
                                <div style="text-align: center; margin-top: 25px;">
                                    <div style="font-size: 18px; color: #222; font-weight: bold; background: #eef5ff; padding: 18px 25px; border-radius: 8px; display: inline-block; border: 2px solid #d1e3ff; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
                                        <i class="fa fa-info-circle" style="color: #3c8dbc; margin-left: 5px;"></i> إذا أردت طلب منتجات أكثر لحجم حاوية أو أكثر، يجب ترقية الحساب
                                        <a href="{{ route('client.subscription.plans') }}" style="font-weight: 900; color: #1e3a5f; text-decoration: underline; margin-right: 12px; display: inline-block;">اضغط هنا لترقية</a>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Heavy Equipment Tab -->
                    <div class="tab-pane" id="tab_heavy">
                        <div id="heavy-cart-empty" style="padding: 60px 20px; text-align: center; color: #999;">
                            <i class="fa fa-truck" style="font-size: 60px; opacity: 0.2; margin-bottom: 20px;"></i>
                            <h4>لا توجد طلبات معدات ثقيلة بعد</h4>
                            <p>قم بإرسال طلب من صفحة تفاصيل معدة ثقيلة لتظهر هنا.</p>
                        </div>
                        <div id="heavy-cart-content" style="display: none; padding: 20px;">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped text-center" style="font-size: 13px; border-radius: 8px; overflow: hidden;">
                                    <thead style="background: linear-gradient(135deg, #c0392b 0%, #922b21 100%); color: white;">
                                        <tr>
                                            <th style="padding: 12px 5px;">الصورة</th>
                                            <th style="padding: 12px 5px;">المنتج</th>
                                            <th style="padding: 12px 5px;">الأبعاد (م)</th>
                                            <th style="padding: 12px 5px;">الكمية</th>
                                            <th style="padding: 12px 5px;">إجمالي الوزن</th>
                                            <th style="padding: 12px 5px;">إجمالي السعر</th>
                                            <th style="padding: 12px 5px;">الحاويات</th>
                                            <th class="no-print">إجراء</th>
                                        </tr>
                                    </thead>
                                    <tbody id="heavy-cart-items"></tbody>
                                    <tfoot style="background: #fcfcfc; font-weight: bold; border-top: 2px solid #c0392b;">
                                        <tr>
                                            <td colspan="4" style="text-align:left; padding:15px;">إجماليات الطلبات:</td>
                                            <td style="color:#c0392b; font-size:16px; background:#fff4f4;"><span id="heavy-total-weight" class="english-nums">0 KG</span></td>
                                            <td style="color:#856404; font-size:16px; background:#fff4f4;"><span id="heavy-total-price" class="english-nums">0</span></td>
                                            <td colspan="2" style="background:#fff4f4;"></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer" style="padding: 15px 30px; background: #f9f9f9;">
                <a href="{{ route('cbm.print.preview') }}" target="_blank" class="btn btn-default pull-left" style="border-radius: 30px; padding: 8px 25px; font-weight: bold; border: 1px solid #ddd;">
                    <i class="fa fa-print"></i> طباعة القائمة
                </a>
                <button type="button" id="btnCompleteOrder" class="btn btn-success" onclick="CBMCart.submitBulkOrder()" style="border-radius: 30px; padding: 8px 40px; font-weight: bold; background: #00a65a; border: none; box-shadow: 0 4px 10px rgba(0, 166, 90, 0.3);">
                    <i class="fa fa-check-circle"></i> اتمام الطلب
                </button>
                <button type="button" class="btn btn-primary" data-dismiss="modal" style="border-radius: 30px; padding: 8px 30px; font-weight: bold;">إغلاق</button>
            </div>
        </div>
    </div>
</div>

<!-- Heavy Container Details Modal -->
<div class="modal fade" id="heavyContainerModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius:20px;overflow:hidden;border:none;">
            <div class="modal-header" style="background:linear-gradient(135deg,#c0392b,#922b21);color:white;padding:20px;">
                <button type="button" class="close" data-dismiss="modal" style="color:white;opacity:1;">&times;</button>
                <h4 class="modal-title" style="font-weight:900;"><i class="fa fa-ship"></i> تحليل الحاويات المقترحة للطلب</h4>
            </div>
            <div class="modal-body" id="heavy-container-modal-body" style="padding:25px;background:#fefefe;max-height:75vh;overflow-y:auto;">
                <!-- Populated by JS -->
            </div>
            <div class="modal-footer" style="background:#f9f9f9;">
                <button type="button" class="btn btn-danger" data-dismiss="modal" style="border-radius:20px;font-weight:bold;">إغلاق</button>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    #cbmInfoModal {
        padding-right: 0 !important;
        padding-left: 0 !important;
    }
    #cbmInfoModal .modal-dialog.modal-full-width {
        width: 100% !important;
        max-width: 100% !important;
        margin: 0 !important;
    }
    #cbmInfoModal .modal-content {
        border-radius: 0 !important;
    }
    .notifications-menu > a:hover {
        background: rgba(255,255,255,0.1) !important;
    }
    .modal-backdrop {
        background-color: rgba(30, 58, 95, 0.4);
    }
    .nav-tabs.nav-justified > li > a {
        border-radius: 0;
        margin-bottom: 0;
    }
    .nav-tabs.nav-justified > .active > a, .nav-tabs.nav-justified > .active > a:focus, .nav-tabs.nav-justified > .active > a:hover {
        border: none;
        background-color: #fff;
        color: #3c8dbc;
        border-top: 3px solid #3c8dbc !important;
    }
    .modal-thumb {
        width: 40px !important;
        height: 40px !important;
        max-width: 40px !important;
        max-height: 40px !important;
        object-fit: cover !important;
        border-radius: 5px;
        cursor: pointer;
        border: 1px solid #eee;
        transition: all 0.2s;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }
    .modal-thumb:hover {
        border-color: #3c8dbc;
        transform: scale(1.1);
    }
    .gallery-thumb-item {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 4px;
        cursor: pointer;
        border: 2px solid #eee;
        transition: all 0.2s;
    }
    .gallery-thumb-item:hover, .gallery-thumb-item.active {
        border-color: #3c8dbc;
        transform: scale(1.05);
    }
    
    @media print {
        body * {
            visibility: hidden;
        }
        #cbmInfoModal, #cbmInfoModal * {
            visibility: visible;
        }
        #cbmInfoModal {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            margin: 0;
            padding: 0;
        }
        .modal-header, .modal-footer, .no-print, .nav-tabs {
            display: none !important;
        }
        .printable-area {
            visibility: visible;
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }
    }
    
    @keyframes pulseWarningCube {
        0% { transform: scale(1); text-shadow: 0 0 10px rgba(220,53,69,0.3); }
        50% { transform: scale(1.1); text-shadow: 0 0 25px rgba(220,53,69,0.8); }
        100% { transform: scale(1); text-shadow: 0 0 10px rgba(220,53,69,0.3); }
    }
    .cube-warning-active {
        animation: pulseWarningCube 1.5s infinite;
        color: #dc3545 !important;
    }
</style>
@endpush

@push('scripts')
<script>
    window.CBMCart = {
        key: 'cbm_cart_items',
        get() {
            return JSON.parse(localStorage.getItem(this.key)) || [];
        },
        add(item) {
            let cart = this.get();
            cart.push(item);
            localStorage.setItem(this.key, JSON.stringify(cart));
            this.updateUI();
        },
        remove(index) {
            let cart = this.get();
            cart.splice(index, 1);
            localStorage.setItem(this.key, JSON.stringify(cart));
            this.updateUI();
        },
        updateUI() {
            const cart = this.get();
            const badge = document.getElementById('cbm-cart-badge');
            if(badge) {
                badge.innerText = cart.length;
                badge.style.display = cart.length > 0 ? 'block' : 'none';
            }
            this.renderTable();
        },
        renderTable() {
            const cart = this.get();
            const itemsBody = document.getElementById('cbm-cart-items');
            const emptyHint = document.getElementById('cbm-cart-empty');
            const content = document.getElementById('cbm-cart-content');

            if(!itemsBody) return;

            if(cart.length === 0) {
                emptyHint.style.display = 'block';
                content.style.display = 'none';
                return;
            }

            emptyHint.style.display = 'none';
            content.style.display = 'block';
            
            itemsBody.innerHTML = html;
            document.getElementById('cart-total-cbm').innerText = totalCbm.toFixed(3);
            document.getElementById('cart-total-weight').innerText = totalWeight.toFixed(2) + ' KG';
        },
        renderTable() {
            const cart = this.get();
            const itemsBody = document.getElementById('cbm-cart-items');
            const emptyHint = document.getElementById('cbm-cart-empty');
            const content = document.getElementById('cbm-cart-content');

            if(!itemsBody) return;

            if(cart.length === 0) {
                emptyHint.style.display = 'block';
                content.style.display = 'none';
                return;
            }

            emptyHint.style.display = 'none';
            content.style.display = 'block';
            
            let html = '';
            let totalCbm = 0;
            let totalWeight = 0;
            let totalPrice = 0;
            let firstCurrency = '';

                cart.forEach((item, index) => {
                    totalCbm += parseFloat(item.total_cbm);
                    totalWeight += parseFloat(item.total_weight);
                    
                    let qtyInt = parseFloat(item.qty) || 0;
                    let pPrice = parseFloat(item.unit_price) || 0;
                    totalPrice += (qtyInt * pPrice);
                    if (index === 0) firstCurrency = item.currency || '';
                    const itemImg = item.images && item.images.length > 0 ? item.images[0] : item.image;
                    html += `
                        <tr style="background: ${index % 2 === 0 ? '#fff' : '#f9f9f9'}">
                            <td style="vertical-align: middle; width: 60px; text-align: center;">
                                <div style="width: 40px; height: 40px; margin: 0 auto; overflow: hidden; border-radius: 5px;">
                                    <img src="${itemImg}" class="modal-thumb" onclick="CBMCart.showGallery(${index})" title="اضغط للمعاينة" style="display: block; width: 40px; height: 40px; object-fit: cover;">
                                </div>
                            </td>
                            <td style="vertical-align: middle; text-align: right; min-width: 150px; font-weight: bold; color: #333; font-size: 13px;">
                                ${item.name}
                            </td>
                            <td style="vertical-align: middle; font-size: 12px; color: #555;">
                                ${item.sku}
                            </td>
                            <td style="vertical-align: middle; font-weight: 600; font-size: 12px; color: #d9534f; white-space: nowrap;"><span class="english-nums">${item.currency} ${parseFloat(item.unit_price).toFixed(2)}</span></td>
                            <td style="vertical-align: middle; font-size: 12px; white-space: nowrap;"><span class="english-nums">${parseFloat(item.unit_weight).toFixed(2)}</span> كجم</td>
                            <td style="vertical-align: middle; font-size: 12px; white-space: nowrap;"><span class="english-nums">${parseFloat(item.unit_cbm).toFixed(4)}</span></td>
                            <td style="vertical-align: middle; font-size: 12px; font-weight: bold;"><span class="english-nums">${item.qty}</span> <br><small class="text-muted" style="font-size: 9px;">(<span class="english-nums">${item.cartons}</span> كرتونة)</small></td>
                            <td style="vertical-align: middle; font-weight: 800; color: #3c8dbc; background: #fdfdfd; font-size: 14px;"><span class="english-nums">${item.total_cbm.toFixed(3)}</span></td>
                            <td style="vertical-align: middle; font-weight: 800; color: #d9534f; background: #fdfdfd; font-size: 14px;"><span class="english-nums">${item.total_weight.toFixed(2)}</span> كجم</td>
                            <td style="vertical-align: middle; font-weight: 800; color: #856404; background: #fdfdfd; font-size: 14px;">
                                <span class="english-nums">${item.currency} ${(item.qty * item.unit_price).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2})}</span>
                            </td>
                            <td style="vertical-align: middle; background: #fdfdfd;">
                                <span class="label label-primary" style="font-size: 11px; padding: 4px 8px; border-radius: 4px; text-transform: uppercase;">
                                    ${item.shipping_unit_type || 'CBM'}
                                </span>
                            </td>
                            <td style="vertical-align: middle;" class="no-print">
                                <button onclick="CBMCart.remove(${index})" class="btn btn-xs btn-link text-danger" title="حذف" style="padding: 0;">
                                    <i class="fa fa-trash-o" style="font-size: 18px;"></i>
                                </button>
                            </td>
                        </tr>
                    `;
                });

            itemsBody.innerHTML = html;
            
            const totalCbmStr = totalCbm.toFixed(3);
            const totalWeightStr = totalWeight.toFixed(2);
            document.getElementById('cart-total-cbm').innerText = totalCbmStr;
            document.getElementById('cart-total-weight').innerText = totalWeightStr + ' KG';
            document.getElementById('cart-total-price').innerText = firstCurrency + ' ' + totalPrice.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
            
            // Visualizer Updates
            document.getElementById('cbm-visualization-panel').style.display = 'block';
            document.getElementById('vis-total-cbm').innerText = totalCbmStr;
            document.getElementById('vis-total-weight').innerText = totalWeightStr;
            document.getElementById('vis-total-price').innerText = firstCurrency + ' ' + totalPrice.toFixed(2);
            
            const warningAlert = document.getElementById('cbm-warning-alert');
            const safeAlert = document.getElementById('cbm-safe-alert');
            const cubeIcon = document.getElementById('cbm-cube-icon');
            
            if (totalCbm > 1) {
                warningAlert.style.display = 'flex';
                safeAlert.style.display = 'none';
                cubeIcon.classList.add('cube-warning-active');
                cubeIcon.style.color = ''; // Let css take over
            } else {
                warningAlert.style.display = 'none';
                safeAlert.style.display = 'flex';
                cubeIcon.classList.remove('cube-warning-active');
                cubeIcon.style.color = '#3c8dbc';
            }
        },
        showGallery(index) {
            const cart = this.get();
            const item = cart[index];
            const galleryDiv = document.getElementById('modal-gallery-preview');
            const mainImg = document.getElementById('gallery-main-img');
            const thumbsDiv = document.getElementById('gallery-thumbs');
            
            if(!item || !item.images || item.images.length === 0) return;
            
            let thumbsHtml = '';
            item.images.forEach((imgUrl, i) => {
                thumbsHtml += `<img src="${imgUrl}" class="gallery-thumb-item ${i===0?'active':''}" onclick="CBMCart.setLargeImage(this, '${imgUrl}')">`;
            });
            
            thumbsDiv.innerHTML = thumbsHtml;
            mainImg.src = item.images[0];
            galleryDiv.style.display = 'block';
            galleryDiv.scrollIntoView({ behavior: 'smooth' });
        },
        setLargeImage(el, url) {
            document.getElementById('gallery-main-img').src = url;
            document.querySelectorAll('.gallery-thumb-item').forEach(t => t.classList.remove('active'));
            el.classList.add('active');
        },
        closeGallery() {
            document.getElementById('modal-gallery-preview').style.display = 'none';
        },
        print() {
            window.print();
        },
        submitBulkOrder() {
            const standardItems = this.get();
            const heavyItems = window.HeavyCart.get();
            const allItems = [];

            if (standardItems.length === 0 && heavyItems.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'السلة فارغة',
                    text: 'يرجى إضافة منتجات إلى السلة أولاً قبل إتمام الطلب.'
                });
                return;
            }

            // Map standard items
            standardItems.forEach(item => {
                allItems.push({
                    id: item.id,
                    qty: item.qty,
                    shipping_unit_type: item.shipping_unit_type,
                    cartons: item.cartons,
                    total_weight: item.total_weight,
                    total_cbm: item.total_cbm,
                    unit_price: item.unit_price,
                    total_cost: item.qty * item.unit_price,
                    notes: item.notes || ''
                });
            });

            // Map heavy items
            heavyItems.forEach(item => {
                allItems.push({
                    id: item.id,
                    qty: item.qty,
                    shipping_unit_type: item.shipping_unit_type || 'RoRo',
                    total_weight: item.totalWeight,
                    total_cost: item.totalPrice,
                    notes: item.notes || ''
                });
            });

            const btn = document.getElementById('btnCompleteOrder');
            const originalContent = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> جاري إرسال الطلب...';

            $.ajax({
                url: "{{ route('orders.bulk-store') }}",
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    items: allItems
                },
                success: function(res) {
                    if (res.success) {
                        localStorage.removeItem(CBMCart.key);
                        localStorage.removeItem(window.HeavyCart.key);
                        CBMCart.updateUI();
                        window.HeavyCart.updateUI();
                        
                        $('#cbmInfoModal').modal('hide');
                        
                        Swal.fire({
                            icon: 'success',
                            title: 'تم بنجاح!',
                            text: res.message,
                            confirmButtonText: 'حسناً'
                        }).then(() => {
                            window.location.href = "{{ route('orders.received') }}"; // Or maybe client.orders
                        });
                    }
                },
                error: function(err) {
                    btn.disabled = false;
                    btn.innerHTML = originalContent;
                    Swal.fire({
                        icon: 'error',
                        title: 'خطأ',
                        text: 'حدث خطأ أثناء إتمام الطلب. يرجى المحاولة مرة أخرى.'
                    });
                }
            });
        }
    };
    
    // Init on load
    document.addEventListener('DOMContentLoaded', () => {
        CBMCart.updateUI();
        HeavyCart.updateUI();
    });

    // ===============================================
    // HEAVY EQUIPMENT CART
    // ===============================================
    window.HeavyCart = {
        key: 'heavy_equipment_cart',
        get() {
            return JSON.parse(localStorage.getItem(this.key)) || [];
        },
        add(item) {
            let cart = this.get();
            cart.push(item);
            localStorage.setItem(this.key, JSON.stringify(cart));
            this.updateUI();
        },
        remove(index) {
            let cart = this.get();
            cart.splice(index, 1);
            localStorage.setItem(this.key, JSON.stringify(cart));
            this.updateUI();
        },
        updateUI() {
            const cart = this.get();
            const badge = document.getElementById('heavy-cart-count');
            if (badge) {
                badge.innerText = cart.length;
                badge.style.display = cart.length > 0 ? 'inline-block' : 'none';
            }
            this.renderTable();
        },
        renderTable() {
            const cart = this.get();
            const body   = document.getElementById('heavy-cart-items');
            const empty  = document.getElementById('heavy-cart-empty');
            const content = document.getElementById('heavy-cart-content');
            if (!body) return;

            if (cart.length === 0) {
                empty.style.display = 'block';
                content.style.display = 'none';
                return;
            }
            empty.style.display = 'none';
            content.style.display = 'block';

            let html = '';
            let totalWeight = 0;
            let totalPrice = 0;
            let currency = '';

            cart.forEach((item, idx) => {
                totalWeight += parseFloat(item.totalWeight) || 0;
                totalPrice  += parseFloat(item.totalPrice) || 0;
                if (idx === 0) currency = item.currency || '';

                html += `
                    <tr style="background: ${idx % 2 === 0 ? '#fff' : '#fdf5f5'}">
                        <td style="vertical-align:middle; width:60px; text-align:center;">
                            <img src="${item.image}" style="width:50px; height:50px; object-fit:cover; border-radius:8px; border:2px solid #eee;">
                        </td>
                        <td style="vertical-align:middle; text-align:right; font-weight:bold; color:#333; min-width:130px;">
                            ${item.name}
                        </td>
                        <td style="vertical-align:middle; font-size:12px; color:#555; white-space:nowrap;">
                            <span class="english-nums">${item.L}×${item.W}×${item.H}</span> م
                        </td>
                        <td style="vertical-align:middle; font-weight:bold; font-size:15px;">
                            <span class="english-nums">${item.qty}</span>
                        </td>
                        <td style="vertical-align:middle; color:#c0392b; font-weight:bold;">
                            <span class="english-nums">${parseFloat(item.totalWeight).toLocaleString()}</span> KG
                        </td>
                        <td style="vertical-align:middle; color:#856404; font-weight:bold;">
                            <span class="english-nums">${parseFloat(item.totalPrice).toLocaleString()}</span> ${item.currency}
                        </td>
                        <td style="vertical-align:middle;">
                            <button onclick='HeavyCart.showContainerDetails(${idx})' class="btn btn-xs btn-warning" style="border-radius:20px; font-weight:bold; white-space:nowrap;">
                                <i class="fa fa-ship"></i> تفاصيل الحاويات
                            </button>
                        </td>
                        <td style="vertical-align:middle;" class="no-print">
                            <button onclick="HeavyCart.remove(${idx})" class="btn btn-xs btn-link text-danger">
                                <i class="fa fa-trash-o" style="font-size:18px;"></i>
                            </button>
                        </td>
                    </tr>
                `;
            });

            body.innerHTML = html;
            document.getElementById('heavy-total-weight').innerText = totalWeight.toLocaleString() + ' KG';
            document.getElementById('heavy-total-price').innerText  = currency + ' ' + totalPrice.toLocaleString();
        },
        showContainerDetails(idx) {
            const item = this.get()[idx];
            if (!item) return;

            const BUMPER = 0.25, WALL = 0.10, ROOF = 0.15;
            const L = parseFloat(item.L), W = parseFloat(item.W), H = parseFloat(item.H);
            const qty = parseInt(item.qty);
            const containers = item.containers || [];

            function containerLabel(n) {
                if (n === 1) return 'حاوية';
                if (n === 2) return 'حاويتان';
                return 'حاويات';
            }

            let cardsHtml = '';
            containers.forEach(c => {
                let capFlat=0, capRack=0, capSteel=0, capTimber=0;
                if (!c.roro) {
                    const hasRoof  = c.hasRoof  !== false;
                    const hasWalls = c.hasWalls !== false;
                    const fitsW = !hasWalls || ((W + WALL*2) <= c.intW);
                    const fitsH = !hasRoof  || ((H + ROOF)  <= c.intH);
                    if (fitsW && fitsH && L > 0) {
                        capFlat  = Math.floor((c.intL+BUMPER) / (L+BUMPER));
                        capRack  = Math.floor((c.intL+BUMPER) / ((L*0.72)+BUMPER));
                        capSteel = Math.floor((c.intL+BUMPER) / ((L*0.68)+BUMPER));
                        capTimber= Math.floor((c.intL+BUMPER) / ((L*0.82)+BUMPER));
                        if (c.intL > 11.5 && L <= 4.8) { capRack=Math.max(capRack,3); capSteel=Math.max(capSteel,4); }
                    }
                }

                function sysRow(label, cap) {
                    if (!cap || cap <= 0) return '';
                    const n = Math.ceil(qty / cap);
                    const word = containerLabel(n);
                    return `<div style="background:rgba(0,0,0,0.08);border-radius:8px;padding:7px 10px;margin-bottom:4px;">
                        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:4px;">
                            <span style="font-size:11px;font-weight:bold;">${label}</span>
                            <span style="font-size:10px;opacity:0.75;">سعة: <b class="english-nums">${cap}</b> قطعة</span>
                        </div>
                        <div style="background:rgba(255,255,255,0.2);border-radius:6px;padding:4px;text-align:center;font-size:13px;font-weight:900;">
                            🚢 <span class="english-nums">${n}</span> ${word}
                        </div>
                    </div>`;
                }

                const body = c.roro
                    ? `<div style="text-align:center;padding:15px 0;"><div style="font-size:24px;">🚢</div><div style="font-weight:bold;">شحن دحرجة (RoRo)</div><div style="font-size:11px;opacity:0.8;">تحميل مباشر - إجمالي: <span class="english-nums">${qty}</span> قطعة</div></div>`
                    : [sysRow('الأرضي (Flat)',capFlat), sysRow('المائل (Racking)',capRack), sysRow('فولاذي (Steel)',capSteel), sysRow('الخشبي (Timber)',capTimber)].join('');

                cardsHtml += `
                    <div style="background:${c.color};border-radius:12px;overflow:hidden;color:white;box-shadow:0 4px 15px rgba(0,0,0,0.1);margin-bottom:10px;">
                        <div style="padding:10px 15px;background:rgba(0,0,0,0.12);display:flex;justify-content:space-between;align-items:center;">
                            <h6 style="margin:0;font-weight:800;font-size:13px;">${c.name}</h6>
                            <i class="fa ${c.icon}" style="font-size:16px;opacity:0.6;"></i>
                        </div>
                        <div style="padding:12px;">
                            <div style="font-size:11px;font-weight:bold;opacity:0.85;margin-bottom:6px;border-bottom:1px solid rgba(255,255,255,0.15);padding-bottom:4px;">
                                الحاويات لـ <span class="english-nums" style="font-size:14px;font-weight:900;">${qty}</span> قطعة:
                            </div>
                            ${body}
                        </div>
                    </div>
                `;
            });

            const modalBody = document.getElementById('heavy-container-modal-body');
            if (modalBody) {
                modalBody.innerHTML = `
                    <div style="background:linear-gradient(135deg,#1e3a5f,#2c5282);border-radius:12px;padding:15px;color:white;margin-bottom:20px;display:flex;gap:15px;align-items:center;">
                        <img src="${item.image}" style="width:70px;height:70px;object-fit:cover;border-radius:10px;border:2px solid rgba(255,255,255,0.2);">
                        <div>
                            <h4 style="margin:0 0 5px;font-weight:900;color:white;">${item.name}</h4>
                            <div style="display:flex;gap:8px;flex-wrap:wrap;font-size:12px;">
                                <span style="background:rgba(255,255,255,0.15);border-radius:6px;padding:3px 8px;" class="english-nums">${item.L}×${item.W}×${item.H} م</span>
                                <span style="background:rgba(192,57,43,0.5);border-radius:6px;padding:3px 8px;" class="english-nums">${qty} قطعة | ${parseFloat(item.totalWeight).toLocaleString()} KG</span>
                            </div>
                        </div>
                    </div>
                    <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:10px;">${cardsHtml}</div>
                `;
            }
            $('#heavyContainerModal').modal('show');
        }
    };
</script>
@endpush
