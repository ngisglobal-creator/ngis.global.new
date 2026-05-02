@extends('factory.layouts.master')

@section('title', __('dashboard.add_new_car'))

@section('content')
<style>
/* تعزيز وضوح النص ليصبح باللون الأبيض الكامل والداكن داخل الحاويات المتخصصة */
#section_heavy_vehicles .spec-container-card,
#section_heavy_vehicles .spec-container-card * {
    color: #ffffff !important;
    opacity: 1 !important;
}
#section_heavy_vehicles .spec-container-card .spec-capacity-result * {
    font-weight: bold !important;
}

/* Polished Hero Buttons */
.mode-hero-btn {
    transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
    position: relative;
    overflow: hidden;
    border-width: 3px !important;
}
.mode-hero-btn:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.15) !important;
}
.mode-hero-btn i {
    transition: transform 0.4s ease;
}
.mode-hero-btn:hover i {
    transform: scale(1.15);
}
.mode-hero-btn.active {
    background: #fff !important;
    border-color: currentColor !important;
}
</style>
<section class="content-header">
    <h1>
        {{ __('dashboard.add_new_car') }}
        <small>{{ __('dashboard.add_new_car') }}</small>
    </h1>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary" style="border-radius: 15px; overflow: hidden; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
                <!-- Mode Selection Hero -->
                <div id="mode_selection_hero" style="background: linear-gradient(135deg, #ffffff 0%, #f9f9f9 100%); padding: 50px 20px; border-bottom: 2px solid #eee; text-align: center;">
                    <h2 style="margin-top: 0; margin-bottom: 30px; font-weight: bold; color: #333;">{{ __('dashboard.choose_transport_type') }}</h2>
                    <div style="display: flex; gap: 30px; justify-content: center; flex-wrap: wrap;">
                        <a href="{{ route('cars.create.light', ['custom_order_id' => request('custom_order_id')]) }}" id="btnHeroLight" class="btn mode-hero-btn" style="flex: 1; min-width: 280px; max-width: 450px; padding: 40px; font-size: 28px; font-weight: bold; border-radius: 20px; background: #eef7ff; color: #3c8dbc; border: 4px solid #3c8dbc; transition: all 0.3s ease; box-shadow: 0 10px 30px rgba(60, 141, 188, 0.1); text-decoration: none;">
                            <i class="fa fa-car" style="font-size: 50px; display: block; margin-bottom: 20px;"></i> 
                            {{ __('dashboard.light_vehicles') }}
                            <p style="font-size: 14px; font-weight: normal; margin-top: 15px; opacity: 0.8;">{{ __('dashboard.light_vehicles_desc') }}</p>
                        </a>
                        
                        <a href="{{ route('cars.create.heavy', ['custom_order_id' => request('custom_order_id')]) }}" id="btnHeroHeavy" class="btn mode-hero-btn" style="flex: 1; min-width: 280px; max-width: 450px; padding: 40px; font-size: 28px; font-weight: bold; border-radius: 20px; background: #fff5e6; color: #e67e22; border: 4px solid #e67e22; transition: all 0.3s ease; box-shadow: 0 10px 30px rgba(230, 126, 34, 0.1); text-decoration: none;">
                            <i class="fa fa-truck" style="font-size: 50px; display: block; margin-bottom: 20px;"></i>
                            {{ __('dashboard.heavy_vehicles') }}
                            <p style="font-size: 14px; font-weight: normal; margin-top: 15px; opacity: 0.8;">{{ __('dashboard.heavy_vehicles_desc') }}</p>
                        </a>
                <div id="full_page_content" style="display: none; padding: 20px;">
                    <div style="text-align: left; margin-bottom: 20px;" class="no-print">
                        <button type="button" class="btn btn-default" onclick="returnToHero()" style="border-radius: 20px; font-weight: bold; border: 2px solid #ddd; transition: all 0.3s;">
                            <i class="fa fa-undo"></i> {{ __('dashboard.change_vehicle_type') }}
                        </button>
                    </div>
                    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" id="productForm">
                        @csrf
                        <input type="hidden" name="custom_order_id" value="{{ request('custom_order_id') }}">
                    <!-- Section 1: General Information -->
                    <div class="box box-solid box-default" style="border-radius: 12px; border: 1px solid #ddd; box-shadow: 0 4px 15px rgba(0,0,0,0.05); margin-bottom: 25px;">
                        <div class="box-header with-border" style="background: #fcfcfc; border-radius: 12px 12px 0 0;">
                            <h3 class="box-title" style="font-weight: bold; color: #333;"><i class="fa fa-info-circle text-primary"></i> {{ __('dashboard.basic_info') }}</h3>
                        </div>
                        <div class="box-body" style="padding: 25px;">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label style="font-weight: 600;">{{ __('dashboard.sector') }}</label>
                                        <button type="button" class="btn btn-link pull-left" style="font-size: 13px; padding: 0;" data-toggle="modal" data-target="#sectorModal">
                                            <i class="fa fa-plus-circle"></i> {{ __('dashboard.add_sectors') ?? 'Add Sectors' }}
                                        </button>
                                        <button type="button" class="btn btn-link pull-left" style="font-size: 13px; padding: 0 10px 0 0;" data-toggle="modal" data-target="#quickSectorModal">
                                            <i class="fa fa-magic"></i> {{ __('dashboard.add_new_sector') ?? 'Add New Sector' }}
                                        </button>
                                        <select name="sector_id" id="sector_id" class="form-control select2" required>
                                            <option value="">{{ __('dashboard.select_sector') }}</option>
                                            @foreach($sectors as $sector)
                                                <option value="{{ $sector->id }}">{{ $sector->{'name_'.app()->getLocale()} ?? $sector->name_ar }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div style="display: flex; justify-content: space-between; align-items: center;">
                                            <label style="font-weight: 600;">الفرع</label>
                                            <button type="button" id="btnAddBranch" class="btn btn-link" style="font-size: 13px; padding: 0; display: none;" data-toggle="modal" data-target="#quickBranchModal">
                                                <i class="fa fa-plus-circle"></i> إضافة فرع جديد
                                            </button>
                                        </div>
                                        <select name="branch_id" id="branch_id" class="form-control select2" required disabled>
                                            <option value="">اختر الفرع</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div style="display: flex; justify-content: space-between; align-items: center;">
                                            <label style="font-weight: 600;">القسم</label>
                                            <button type="button" id="btnAddCategory" class="btn btn-link" style="font-size: 13px; padding: 0; display: none;" data-toggle="modal" data-target="#quickCategoryModal">
                                                <i class="fa fa-plus-circle"></i> إضافة قسم جديد
                                            </button>
                                        </div>
                                        <select name="category_id" id="category_id" class="form-control select2" required disabled>
                                            <option value="">اختر القسم</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="margin-top: 15px;">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label style="font-weight: 600;">{{ __('dashboard.car_name') }}</label>
                                        <input type="text" name="name" id="name" class="form-control" placeholder="{{ __('dashboard.enter_car_name') }}" required style="height: 45px; font-size: 16px;">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label style="font-weight: 600;">ID المنتج (SKU)</label>
                                        <input type="text" name="sku_main" id="sku_main" class="form-control" placeholder="مثال: PRD-123" style="height: 45px; font-size: 16px;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Car Specific Details -->
                    
                    <!-- Box 1: Basic Vehicle Information -->
                    <div class="box box-solid box-default" style="border-radius: 12px; border: 1px solid #ddd; box-shadow: 0 4px 15px rgba(0,0,0,0.05); margin-bottom: 25px;">
                        <div class="box-header with-border" style="background: #fcfcfc;">
                            <h3 class="box-title" style="font-weight: bold; color: #333;"><i class="fa fa-car text-blue"></i> {{ __('dashboard.basic_info') }}</h3>
                        </div>
                        <div class="box-body" style="padding: 25px;">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label style="font-weight: 600;">{{ __('dashboard.car_manufacturer') }}</label>
                                        <input type="text" name="car_manufacturer" class="form-control" placeholder="Toyota">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label style="font-weight: 600;">{{ __('dashboard.car_model') }}</label>
                                        <input type="text" name="car_model" class="form-control" placeholder="Camry">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label style="font-weight: 600;">{{ __('dashboard.car_year') }}</label>
                                        <input type="number" name="car_year" class="form-control" placeholder="2024">
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="margin-top: 15px;">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label style="font-weight: 600;">{{ __('dashboard.car_type') }}</label>
                                        <select name="car_type" class="form-control select2">
                                            <option value="car">{{ __('dashboard.car') ?? 'Car' }}</option>
                                            <option value="truck">{{ __('dashboard.truck') ?? 'Truck' }}</option>
                                            <option value="bus">{{ __('dashboard.bus') ?? 'Bus' }}</option>
                                            <option value="bike">{{ __('dashboard.bike') ?? 'Bike' }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label style="font-weight: 600;">الفئة (SUV / Sedan / Pickup...)</label>
                                        <input type="text" name="car_class" class="form-control" placeholder="Sedan">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label style="font-weight: 600;">رقم الهيكل (VIN)</label>
                                        <input type="text" name="car_vin" class="form-control" placeholder="رقم الشاصيه">
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="margin-top: 15px;">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label style="font-weight: 600;">رقم اللوحة (اختياري)</label>
                                        <input type="text" name="car_plate_number" class="form-control" placeholder="1234 ABC">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Box 2: Technical Specifications -->
                    <div class="box box-solid box-default" style="border-radius: 12px; border: 1px solid #ddd; box-shadow: 0 4px 15px rgba(0,0,0,0.05); margin-bottom: 25px;">
                        <div class="box-header with-border" style="background: #fcfcfc;">
                            <h3 class="box-title" style="font-weight: bold; color: #333;"><i class="fa fa-cogs text-grey"></i> {{ __('dashboard.technical_specs') }}</h3>
                        </div>
                        <div class="box-body" style="padding: 25px;">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label style="font-weight: 600;">نوع المحرك</label>
                                        <select name="engine_type" class="form-control select2">
                                            <option value="petrol">بنزين</option>
                                            <option value="diesel">ديزل</option>
                                            <option value="electric">كهرباء</option>
                                            <option value="hybrid">هجين</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label style="font-weight: 600;">سعة المحرك (CC)</label>
                                        <input type="text" name="engine_cc" class="form-control" placeholder="2500">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label style="font-weight: 600;">عدد الأسطوانات</label>
                                        <input type="number" name="cylinders" class="form-control" placeholder="4">
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="margin-top: 15px;">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label style="font-weight: 600;">القوة (HP)</label>
                                        <input type="number" name="horsepower" class="form-control" placeholder="200">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label style="font-weight: 600;">ناقل الحركة</label>
                                        <select name="transmission" class="form-control select2">
                                            <option value="automatic">أوتوماتيك</option>
                                            <option value="manual">عادي</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label style="font-weight: 600;">نظام الدفع</label>
                                        <select name="drive_system" class="form-control select2">
                                            <option value="fwd">أمامي</option>
                                            <option value="rwd">خلفي</option>
                                            <option value="awd">رباعي AWD</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="margin-top: 15px;">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label style="font-weight: 600;">استهلاك الوقود</label>
                                        <input type="text" name="fuel_consumption" class="form-control" placeholder="15 km/l">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label style="font-weight: 600;">السرعة القصوى</label>
                                        <input type="number" name="max_speed" class="form-control" placeholder="220">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label style="font-weight: 600;">التسارع (0-100)</label>
                                        <input type="text" name="acceleration" class="form-control" placeholder="8.5s">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Box 3: Condition & Usage -->
                    <div class="box box-solid box-default" style="border-radius: 12px; border: 1px solid #ddd; box-shadow: 0 4px 15px rgba(0,0,0,0.05); margin-bottom: 25px;">
                        <div class="box-header with-border" style="background: #fcfcfc;">
                            <h3 class="box-title" style="font-weight: bold; color: #333;"><i class="fa fa-info-circle text-orange"></i> الحالة والاستخدام</h3>
                        </div>
                        <div class="box-body" style="padding: 25px;">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label style="font-weight: 600;">الحالة</label>
                                        <select name="car_condition" class="form-control select2">
                                            <option value="new">جديدة</option>
                                            <option value="used">مستعملة</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label style="font-weight: 600;">المسافة المقطوعة (كم)</label>
                                        <input type="number" name="mileage" class="form-control" placeholder="0">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label style="font-weight: 600;">عدد المالكين السابقين</label>
                                        <input type="number" name="previous_owners" class="form-control" placeholder="0">
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="margin-top: 15px;">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label style="font-weight: 600;">حالة المركبة</label>
                                        <select name="vehicle_state" class="form-control select2">
                                            <option value="excellent">ممتازة</option>
                                            <option value="good">جيدة</option>
                                            <option value="maintenance_needed">تحتاج صيانة</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label style="font-weight: 600;">تاريخ آخر صيانة</label>
                                        <input type="date" name="last_maintenance_date" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label style="font-weight: 600;">سجل الحوادث</label>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label><input type="radio" name="accident_history" value="no" checked> لا</label>
                                            </div>
                                            <div class="col-md-6">
                                                <label><input type="radio" name="accident_history" value="yes"> نعم</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="margin-top: 15px;">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label style="font-weight: 600;">تفاصيل سجل الحوادث (إن وجدت)</label>
                                        <textarea name="accident_details" class="form-control" rows="2" placeholder="أدخل التفاصيل هنا..."></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Box 4: Additional Specification (Features) -->
                    <div class="box box-solid box-default" style="border-radius: 12px; border: 1px solid #ddd; box-shadow: 0 4px 15px rgba(0,0,0,0.05); margin-bottom: 25px;">
                        <div class="box-header with-border" style="background: #fcfcfc;">
                            <h3 class="box-title" style="font-weight: bold; color: #333;"><i class="fa fa-list-ul text-green"></i> المواصفات الإضافية (Features)</h3>
                        </div>
                        <div class="box-body" style="padding: 25px;">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="features[]" value="ac"> مكيف</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="features[]" value="sunroof"> فتحة سقف</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="features[]" value="rear_camera"> كاميرا خلفية</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="features[]" value="sensors"> حساسات</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="features[]" value="screen"> شاشة</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="features[]" value="bluetooth"> بلوتوث</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="features[]" value="gps"> GPS</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="features[]" value="leather_seats"> جلد</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="features[]" value="heated_seats"> تدفئة مقاعد</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="features[]" value="abs"> نظام أمان ABS</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="features[]" value="airbags"> Airbags</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section 2: Description (Moved Up) -->
                    <div class="box box-solid box-default" style="border-radius: 12px; border: 1px solid #ddd; box-shadow: 0 4px 15px rgba(0,0,0,0.05); margin-bottom: 25px;">
                        <div class="box-header with-border" style="background: #fcfcfc;">
                            <h3 class="box-title" style="font-weight: bold; color: #333;"><i class="fa fa-file-text-o text-warning"></i> {{ __('dashboard.car_description') }}</h3>
                        </div>
                        <div class="box-body" style="padding: 25px;">
                            <div class="form-group">
                                <textarea name="description" id="editor" class="form-control" rows="6" placeholder="أدخل تفاصيل ومميزات المنتج هنا..."></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Section 3: Pricing & Details (Moved Down) -->
                    <div class="box box-solid box-default" style="border-radius: 12px; border: 1px solid #ddd; box-shadow: 0 4px 15px rgba(0,0,0,0.05); margin-bottom: 25px;">
                        <div class="box-header with-border" style="background: #fcfcfc;">
                            <h3 class="box-title" style="font-weight: bold; color: #333;"><i class="fa fa-money text-success"></i> {{ __('dashboard.pricing_and_details') }}</h3>
                        </div>
                        <div class="box-body" style="padding: 20px;">
                            <input type="hidden" name="upload_mode" id="upload_mode" value="special">

                            <!-- Vehicle Details Table Wrapper -->
                            <div id="vehicle_details_table_wrapper" style="display: none; width: 100%;">
                                <div class="table-responsive">
                                    <table class="table table-bordered text-center" style="margin-bottom: 0; min-width: 1000px;">
                                    <thead style="background: #f9f9f9; font-weight: bold;">
                                        <tr>
                                            <th style="width: 150px;">اسم السيارة</th>
                                            <th style="width: 100px;">ID المنتج</th>
                                            <th style="width: 120px;" id="lbl_unit_price">سعر الوحدة</th>
                                            <th style="width: 100px;" id="lbl_unit_weight">وزن الوحدة</th>
                                            <th style="width: 110px; display: none;" id="lbl_gross_weight">وزن المنتج G.W(KG)</th>
                                            <th style="width: 90px;" id="lbl_carton_length">طول الكرتونة (m)</th>
                                            <th style="width: 90px;" id="lbl_carton_width">عرض الكرتونة (m)</th>
                                            <th style="width: 90px;" id="lbl_carton_height">ارتفاع الكرتونة (m)</th>
                                            <th style="width: 100px; background: #fff9e6;" id="lbl_unit_cbm">CBM الوحدة</th>
                                            <th style="width: 120px;" id="lbl_units_per_carton">عدد الوحدات في الكرتونة</th>
                                            <th style="width: 100px; background: #fff9e6;" id="lbl_carton_cbm">حجم الكرتونة CBM</th>
                                            <th style="width: 100px; background: #fff9e6;" id="lbl_carton_weight_col">وزن الكرتونة (kg)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <input type="text" id="table_product_name" class="form-control" placeholder="اسم المنتج" style="border: none; text-align: center; border-bottom: 1px solid #ddd;">
                                            </td>
                                            <td>
                                                <input type="text" id="sku" class="form-control" placeholder="ID" style="border: none; text-align: center; border-bottom: 1px solid #ddd;">
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm">
                                                    <input type="text" id="price" class="form-control english-nums" placeholder="0.00" oninput="this.value=toWesternNums(this.value)" style="border: none; border-bottom: 1px solid #ddd;">
                                                    <span class="input-group-addon" style="padding: 0; border: none; background: transparent;">
                                                        <select id="currency_code" style="border: none; background: transparent; font-size: 10px; height: 100%;">
                                                            <option value="USD">$</option>
                                                            <option value="EUR">€</option>
                                                            <option value="CNY">¥</option>
                                                            <option value="SAR">ر.س</option>
                                                        </select>
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                <input type="text" id="piece_weight" class="form-control english-nums" placeholder="0.5" oninput="this.value=toWesternNums(this.value)" style="border: none; text-align: center; border-bottom: 1px solid #ddd;">
                                            </td>
                                            <td style="display: none;" id="col_gross_weight">
                                                <input type="text" id="gross_weight_input" class="form-control english-nums" placeholder="0.6" oninput="this.value=toWesternNums(this.value)" style="border: none; text-align: center; border-bottom: 1px solid #ddd;">
                                            </td>
                                            <td>
                                                <input type="number" id="carton_length" step="0.1" class="form-control english-nums dimension-input" placeholder="0.5" style="border: none; text-align: center; border-bottom: 1px solid #ddd;">
                                            </td>
                                            <td>
                                                <input type="number" id="carton_width" step="0.1" class="form-control english-nums dimension-input" placeholder="0.4" style="border: none; text-align: center; border-bottom: 1px solid #ddd;">
                                            </td>
                                            <td>
                                                <input type="number" id="carton_height" step="0.1" class="form-control english-nums dimension-input" placeholder="0.4" style="border: none; text-align: center; border-bottom: 1px solid #ddd;">
                                            </td>
                                            <td style="background: #fff9e6;">
                                                <input type="text" id="carton_volume_cbm" class="form-control english-nums" readonly style="background: transparent; border: none; text-align: center; font-weight: bold; color: #b8860b;">
                                            </td>
                                            <td>
                                                <input type="text" id="product_piece_count" class="form-control english-nums" placeholder="عدد القطع" oninput="this.value=toWesternNums(this.value)" style="border: none; text-align: center; border-bottom: 1px solid #ddd;">
                                            </td>
                                            <td style="background: #fff9e6;" id="col_total_cbm">
                                                <input type="text" id="total_cbm" class="form-control english-nums" readonly style="background: transparent; border: none; text-align: center; font-weight: bold; color: #b8860b;">
                                            </td>
                                            <td style="background: #fff9e6;">
                                                <input type="text" id="total_weight" class="form-control english-nums" readonly style="background: transparent; border: none; text-align: center; font-weight: bold; color: #b8860b;">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            
                            <div class="row" style="margin-top: 20px;">
                                <div class="col-md-6">
                                    <div class="alert alert-info" style="background: #f0f7ff !important; color: #3c8dbc !important; border: 1px dashed #3c8dbc;">
                                        <i class="fa fa-info-circle"></i> <strong>{{ __('dashboard.calc_formula') ?? 'Calculation Formula' }}:</strong> {{ __('dashboard.calc_formula_desc') ?? 'Multiply (Length x Width x Height) to get the carton volume, then multiply by the number of units to get the total carton CBM.' }}
                                    </div>
                                </div>
                                <div class="col-md-6 text-right">
                                    <div style="padding: 10px; background: #f9f9f9; border-radius: 8px; border: 1px solid #eee;">
                                        <span style="font-weight: bold; color: #666;">{{ __('dashboard.min_order_quantity') ?? 'Minimum Order Quantity (MOQ)' }}:</span>
                                        <input type="text" id="min_order_quantity" class="form-control english-nums" placeholder="100" style="display: inline-block; width: 100px; height: 30px; margin-right: 10px;">
                                    </div>
                                </div>
                            </div>

                            </div> <!-- End vehicle_details_table_wrapper -->

                            <!-- Container Stats Widgets Wrapper -->
                            <div id="light_vehicles_wrapper" style="display: none; width: 100%;">
                                <div class="row" style="margin-top: 15px; display: flex; flex-wrap: wrap; justify-content: space-between; gap: 10px; padding: 0 15px;">
                                    <!-- CBM 1 -->
                                <div style="flex: 1; min-width: 160px; background: #007bff; color: white; border-radius: 12px; padding: 15px; position: relative; box-shadow: 0 4px 15px rgba(0,123,255,0.2); border-bottom: 5px solid #0056b3;">
                                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px;">
                                        <span id="widget-item-cbm-title" style="font-weight: bold; font-size: 14px;">item CBM</span>
                                        <i class="fa fa-cube" style="font-size: 18px; opacity: 0.8;"></i>
                                    </div>
                                    <div class="widget-cbm-calc" style="background: rgba(255,255,255,0.1); border-radius: 8px; padding: 8px; font-size: 12px;"></div>
                                </div>
                                <!-- 20FT -->
                                <div style="flex: 1; min-width: 160px; background: #007bff; color: white; border-radius: 12px; padding: 15px; position: relative; box-shadow: 0 4px 15px rgba(0,123,255,0.2); border-bottom: 5px solid #0056b3;">
                                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px;">
                                        <div style="flex-direction: column; display: flex;">
                                            <span style="font-weight: bold; font-size: 14px;">20FT (28 CBM)</span>
                                            <span style="font-size: 9px; opacity: 0.9;">طول: 5.90 | عرض: 2.35 | ارتفاع: 2.39</span>
                                        </div>
                                        <i class="fa fa-truck" style="font-size: 18px; opacity: 0.8;"></i>
                                    </div>
                                    <div class="widget-cbm-calc" style="background: rgba(255,255,255,0.1); border-radius: 8px; padding: 8px; font-size: 12px;"></div>
                                </div>
                                <!-- 40FT -->
                                <div style="flex: 1; min-width: 160px; background: #007bff; color: white; border-radius: 12px; padding: 15px; position: relative; box-shadow: 0 4px 15px rgba(0,123,255,0.2); border-bottom: 5px solid #0056b3;">
                                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px;">
                                        <div style="flex-direction: column; display: flex;">
                                            <span style="font-weight: bold; font-size: 14px;">40FT (58 CBM)</span>
                                            <span style="font-size: 9px; opacity: 0.9;">طول: 12.03 | عرض: 2.35 | ارتفاع: 2.39</span>
                                        </div>
                                        <i class="fa fa-truck" style="font-size: 18px; opacity: 0.8;"></i>
                                    </div>
                                    <div class="widget-cbm-calc" style="background: rgba(255,255,255,0.1); border-radius: 8px; padding: 8px; font-size: 12px;"></div>
                                </div>
                                <!-- 40HQ -->
                                <div style="flex: 1; min-width: 160px; background: #007bff; color: white; border-radius: 12px; padding: 15px; position: relative; box-shadow: 0 4px 15px rgba(0,123,255,0.2); border-bottom: 5px solid #0056b3;">
                                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px;">
                                        <div style="flex-direction: column; display: flex;">
                                            <span style="font-weight: bold; font-size: 14px;">40HQ (68 CBM)</span>
                                            <span style="font-size: 9px; opacity: 0.9;">طول: 12.03 | عرض: 2.35 | ارتفاع: 2.69</span>
                                        </div>
                                        <i class="fa fa-truck" style="font-size: 18px; opacity: 0.8;"></i>
                                    </div>
                                    <div class="widget-cbm-calc" style="background: rgba(255,255,255,0.1); border-radius: 8px; padding: 8px; font-size: 12px;"></div>
                                </div>
                                <!-- 45FT -->
                                <div style="flex: 1; min-width: 160px; background: #007bff; color: white; border-radius: 12px; padding: 15px; position: relative; box-shadow: 0 4px 15px rgba(0,123,255,0.2); border-bottom: 5px solid #0056b3;">
                                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px;">
                                        <div style="flex-direction: column; display: flex;">
                                            <span style="font-weight: bold; font-size: 14px;">45FT (78 CBM)</span>
                                            <span style="font-size: 9px; opacity: 0.9;">طول: 13.55 | عرض: 2.35 | ارتفاع: 2.69</span>
                                        </div>
                                        <i class="fa fa-truck" style="font-size: 18px; opacity: 0.8;"></i>
                                    </div>
                                    <div class="widget-cbm-calc" style="background: rgba(255,255,255,0.1); border-radius: 8px; padding: 8px; font-size: 12px;"></div>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>

                    <!-- Specialized Shipping Containers Section -->
                    <div id="section_heavy_vehicles" class="box box-solid box-default" style="display: none; border-radius: 12px; border: 1px solid #ddd; box-shadow: 0 4px 15px rgba(0,0,0,0.05); margin-bottom: 25px;">
                        <div class="box-header with-border" style="background: #fcfcfc;">
                            <h3 class="box-title" style="font-weight: bold; color: #333;"><i class="fa fa-ship text-primary"></i> أنواع الحاويات والخدمات اللوجستية المتخصصة</h3>
                        </div>
                        <div class="box-body" style="padding: 20px;">
                                <div class="row" style="display: flex; flex-wrap: wrap; gap: 15px; justify-content: center;">
                                    <!-- Open Top 20ft -->
                                <div class="spec-container-card" data-l="5.89" data-w="2.35" data-h="2.35" data-cbm="32" data-roof="false" data-walls="true" data-name="20ft Open Top" style="flex: 1; min-width: 200px; max-width: 250px; background: #007bff; color: white; border-radius: 12px; padding: 15px; position: relative; box-shadow: 0 4px 15px rgba(0,123,255,0.2); border-bottom: 5px solid #0056b3;">
                                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px;">
                                        <div style="flex-direction: column; display: flex;">
                                            <span style="font-weight: bold; font-size: 14px;">20ft Open Top (32 CBM)</span>
                                            <span style="font-size: 9px; color: white;">طول: <span dir="ltr">5.89</span> | عرض: <span dir="ltr">2.35</span> | ارتفاع: <span dir="ltr">2.35</span></span>
                                        </div>
                                        <i class="fa fa-arrow-up" style="font-size: 18px; color: white;"></i>
                                    </div>
                                    <div class="spec-capacity-result widget-cbm-calc" style="background: rgba(255,255,255,0.1); border-radius: 8px; padding: 8px; font-size: 12px;"></div>
                                </div>

                                <!-- Open Top 40ft -->
                                <div class="spec-container-card" data-l="12.02" data-w="2.35" data-h="2.35" data-cbm="66" data-roof="false" data-walls="true" data-name="40ft Open Top" style="flex: 1; min-width: 200px; max-width: 250px; background: #007bff; color: white; border-radius: 12px; padding: 15px; position: relative; box-shadow: 0 4px 15px rgba(0,123,255,0.2); border-bottom: 5px solid #0056b3;">
                                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px;">
                                        <div style="flex-direction: column; display: flex;">
                                            <span style="font-weight: bold; font-size: 14px;">40ft Open Top (66 CBM)</span>
                                            <span style="font-size: 9px; color: white;">طول: <span dir="ltr">12.02</span> | عرض: <span dir="ltr">2.35</span> | ارتفاع: <span dir="ltr">2.35</span></span>
                                        </div>
                                        <i class="fa fa-arrow-up" style="font-size: 18px; color: white;"></i>
                                    </div>
                                    <div class="spec-capacity-result widget-cbm-calc" style="background: rgba(255,255,255,0.1); border-radius: 8px; padding: 8px; font-size: 12px;"></div>
                                </div>

                                <!-- Flat Rack 20ft -->
                                <div class="spec-container-card" data-l="5.94" data-w="2.35" data-h="99.0" data-cbm="28" data-roof="false" data-walls="false" data-name="20ft Flat Rack" style="flex: 1; min-width: 200px; max-width: 250px; background: #f39c12; color: white; border-radius: 12px; padding: 15px; position: relative; box-shadow: 0 4px 15px rgba(243,156,18,0.2); border-bottom: 5px solid #e67e22;">
                                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px;">
                                        <div style="flex-direction: column; display: flex;">
                                            <span style="font-weight: bold; font-size: 14px;">20ft Flat Rack (28 CBM)</span>
                                            <span style="font-size: 9px; color: white;">طول: <span dir="ltr">5.94</span> | عرض: <span dir="ltr">2.35</span> | ارتفاع: &mdash;</span>
                                        </div>
                                        <i class="fa fa-arrows-h" style="font-size: 18px; color: white;"></i>
                                    </div>
                                    <div class="spec-capacity-result widget-cbm-calc" style="background: rgba(255,255,255,0.1); border-radius: 8px; padding: 8px; font-size: 12px;"></div>
                                </div>

                                <!-- Flat Rack 40ft -->
                                <div class="spec-container-card" data-l="12.13" data-w="2.40" data-h="99.0" data-cbm="60" data-roof="false" data-walls="false" data-name="40ft Flat Rack" style="flex: 1; min-width: 200px; max-width: 250px; background: #f39c12; color: white; border-radius: 12px; padding: 15px; position: relative; box-shadow: 0 4px 15px rgba(243,156,18,0.2); border-bottom: 5px solid #e67e22;">
                                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px;">
                                        <div style="flex-direction: column; display: flex;">
                                            <span style="font-weight: bold; font-size: 14px;">40ft Flat Rack (60 CBM)</span>
                                            <span style="font-size: 9px; color: white;">طول: <span dir="ltr">12.13</span> | عرض: <span dir="ltr">2.40</span> | ارتفاع: &mdash;</span>
                                        </div>
                                        <i class="fa fa-arrows-h" style="font-size: 18px; color: white;"></i>
                                    </div>
                                    <div class="spec-capacity-result widget-cbm-calc" style="background: rgba(255,255,255,0.1); border-radius: 8px; padding: 8px; font-size: 12px;"></div>
                                </div>

                                <!-- Platform 20ft -->
                                <div class="spec-container-card" data-l="6.06" data-w="2.44" data-h="99.0" data-cbm="28" data-roof="false" data-walls="false" data-name="20ft Platform" style="flex: 1; min-width: 200px; max-width: 250px; background: #00a65a; color: white; border-radius: 12px; padding: 15px; position: relative; box-shadow: 0 4px 15px rgba(0,166,90,0.2); border-bottom: 5px solid #008d4c;">
                                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px;">
                                        <div style="flex-direction: column; display: flex;">
                                            <span style="font-weight: bold; font-size: 14px;">20ft Platform (28 CBM)</span>
                                            <span style="font-size: 9px; color: white;">طول: <span dir="ltr">6.06</span> | عرض: <span dir="ltr">2.44</span> | ارتفاع: &mdash;</span>
                                        </div>
                                        <i class="fa fa-square-o" style="font-size: 18px; color: white;"></i>
                                    </div>
                                    <div class="spec-capacity-result widget-cbm-calc" style="background: rgba(255,255,255,0.1); border-radius: 8px; padding: 8px; font-size: 12px;"></div>
                                </div>

                                <!-- Platform 40ft -->
                                <div class="spec-container-card" data-l="12.19" data-w="2.44" data-h="99.0" data-cbm="70" data-roof="false" data-walls="false" data-name="40ft Platform" style="flex: 1; min-width: 200px; max-width: 250px; background: #00a65a; color: white; border-radius: 12px; padding: 15px; position: relative; box-shadow: 0 4px 15px rgba(0,166,90,0.2); border-bottom: 5px solid #008d4c;">
                                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px;">
                                        <div style="flex-direction: column; display: flex;">
                                            <span style="font-weight: bold; font-size: 14px;">40ft Platform (70 CBM)</span>
                                            <span style="font-size: 9px; color: white;">طول: <span dir="ltr">12.19</span> | عرض: <span dir="ltr">2.44</span> | ارتفاع: &mdash;</span>
                                        </div>
                                        <i class="fa fa-square-o" style="font-size: 18px; color: white;"></i>
                                    </div>
                                    <div class="spec-capacity-result widget-cbm-calc" style="background: rgba(255,255,255,0.1); border-radius: 8px; padding: 8px; font-size: 12px;"></div>
                                </div>

                                <!-- Reefer -->
                                <div class="spec-container-card" data-l="11.58" data-w="2.29" data-h="2.40" data-cbm="59" data-roof="true" data-walls="true" data-name="40ft Reefer" style="flex: 1; min-width: 200px; max-width: 250px; background: #00c0ef; color: white; border-radius: 12px; padding: 15px; position: relative; box-shadow: 0 4px 15px rgba(0,192,239,0.2); border-bottom: 5px solid #00a7d0;">
                                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px;">
                                        <div style="flex-direction: column; display: flex;">
                                            <span style="font-weight: bold; font-size: 14px;">40ft Reefer (59 CBM)</span>
                                            <span style="font-size: 9px; color: white;">طول: <span dir="ltr">11.58</span> | عرض: <span dir="ltr">2.29</span> | ارتفاع: <span dir="ltr">2.40</span></span>
                                        </div>
                                        <i class="fa fa-snowflake-o" style="font-size: 18px; color: white;"></i>
                                    </div>
                                    <div class="spec-capacity-result widget-cbm-calc" style="background: rgba(255,255,255,0.1); border-radius: 8px; padding: 8px; font-size: 12px;"></div>
                                </div>

                                <!-- RoRo -->
                                <div class="spec-container-card" data-roro="true" data-name="RoRo Shipping" style="flex: 1; min-width: 200px; max-width: 250px; background: #d81b60; color: white; border-radius: 12px; padding: 15px; position: relative; box-shadow: 0 4px 15px rgba(216,27,96,0.2); border-bottom: 5px solid #a01546;">
                                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px;">
                                        <div style="flex-direction: column; display: flex;">
                                            <span style="font-weight: bold; font-size: 14px;">شحن دحرجة (RoRo)</span>
                                            <span style="font-size: 9px; color: white;">Direct Drive-on</span>
                                        </div>
                                        <i class="fa fa-truck" style="font-size: 18px; color: white;"></i>
                                    </div>
                                    <div class="spec-capacity-result widget-cbm-calc" style="background: rgba(255,255,255,0.1); border-radius: 8px; padding: 8px; font-size: 12px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section 5: Media -->
                    <div class="box box-solid box-default" style="border-radius: 12px; border: 1px solid #ddd; box-shadow: 0 4px 15px rgba(0,0,0,0.05); margin-bottom: 25px;">
                        <div class="box-header with-border" style="background: #fcfcfc;">
                            <h3 class="box-title" style="font-weight: bold; color: #333;"><i class="fa fa-camera text-danger"></i> صور وفيديوهات المنتج</h3>
                        </div>
                        <div class="box-body" style="padding: 25px;">
                            <div class="upload-zone" style="border: 2px dashed #ccc; border-radius: 12px; padding: 40px; text-align: center; background: #fafafa; cursor: pointer;" onclick="document.getElementById('product_images').click()">
                                <i class="fa fa-cloud-upload" style="font-size: 48px; color: #bbb;"></i>
                                <h4 style="color: #666; font-weight: 600;">اضغط هنا لرفع صور المنتج</h4>
                                <p style="color: #999;">يمكنك رفع حتى 10 صور (JPG, PNG)</p>
                                <input type="file" name="images[]" id="product_images" class="hidden" multiple required accept="image/*">
                            </div>
                            <div id="image_preview" class="row" style="margin-top: 20px;"></div>
                        </div>
                    </div>

                    <div style="text-align: center; margin-bottom: 50px;" class="no-print">
                        <button type="button" id="btnAddToList" class="btn btn-warning" style="width: 300px; height: 55px; border-radius: 30px; font-size: 20px; font-weight: bold; box-shadow: 0 10px 20px rgba(243, 156, 18, 0.3);">
                            <i class="fa fa-plus-circle"></i> {{ __('dashboard.add_product_to_list') }}
                        </button>
                    </div>
                </form>

                <!-- Batch Products Table Section -->
                <div class="row" id="batch_section" style="display: none; margin-top: 30px;">
                    <div class="col-md-12">
                        <div class="box box-solid" style="border: 2px solid #3c8dbc; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.1); margin-bottom: 25px;">
                            <div class="box-header with-border" style="background: #eef7ff;">
                                <h3 class="box-title" style="font-weight: bold; color: #3c8dbc;"><i class="fa fa-list"></i> {{ __('dashboard.added_products_list') }}</h3>
                            </div>
                            <div class="box-body no-padding">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped text-center" id="batch_table" style="margin-bottom: 0; font-size: 14px;">
                                        <thead style="background: #3c8dbc; color: white;">
                                            <tr>
                                                <th style="vertical-align: middle;">الصورة</th>
                                                <th style="vertical-align: middle;">اسم وتفاصيل المنتج</th>
                                                <th style="vertical-align: middle;">SKU</th>
                                                <th style="vertical-align: middle;">السعر</th>
                                                <th style="vertical-align: middle;">وزن الوحدة</th>
                                                <th style="vertical-align: middle;">تفاصيل الحاويات ومعايير الأمان</th>
                                                <th style="vertical-align: middle;">الكمية</th>
                                                <th style="vertical-align: middle;">إجمالي CBM</th>
                                                <th style="vertical-align: middle;">إجمالي الوزن</th>
                                                <th style="vertical-align: middle;" class="no-print">إجراء</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Rows dynamically added -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="box-footer text-center no-print" style="padding: 20px; background: #fcfcfc;">
                                <button type="button" class="btn btn-default btn-lg" onclick="window.print()" style="margin-left: 15px; border-radius: 30px; font-weight: bold; padding: 10px 30px;">
                                    <i class="fa fa-print"></i> {{ __('dashboard.print_preview') ?? 'Print Preview' }}
                                </button>
                                <button type="button" class="btn btn-success btn-lg" id="btnSaveAll" style="border-radius: 30px; font-weight: bold; padding: 10px 40px; box-shadow: 0 5px 15px rgba(0,166,90,0.3);">
                                    <i class="fa fa-check-circle"></i> {{ __('dashboard.save_all_and_upload') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Amazon Style Images Modal -->
                <div class="modal fade" id="imagesModal" tabindex="-1" role="dialog" style="z-index: 10000; background: rgba(0,0,0,0.85);">
                    <div class="modal-dialog modal-lg" role="document" style="width: 90%; max-width: 1100px; margin-top: 50px;">
                        <div class="modal-content" style="border-radius: 12px; overflow: hidden; border: none; background: #fff; box-shadow: 0 20px 50px rgba(0,0,0,0.5);">
                            <div class="modal-header" style="background: #f8f9fa; border-bottom: 1px solid #eee; padding: 15px 25px; display: flex; align-items: center; justify-content: space-between;">
                                <h4 class="modal-title" style="color: #333; font-weight: 700; font-size: 18px;">
                                    <i class="fa fa-image text-primary"></i> <span style="margin-right: 10px;">معرض الصور (أسلوب أمازون)</span>
                                    <span id="gallery-counter" style="background: #3c8dbc; color: white; padding: 3px 12px; border-radius: 20px; font-size: 13px; font-weight: 700; margin-right: 15px;">1 / 1</span>
                                </h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #333; opacity: 1; text-shadow: none; font-size: 28px; margin: 0;">&times;</button>
                            </div>
                            <div class="modal-body" style="padding: 0; display: flex; height: 650px;">
                                <!-- Left Sidebar: Thumbnails -->
                                <div class="gallery-sidebar" style="width: 120px; border-left: 1px solid #eee; background: #fdfdfd; overflow-y: auto; padding: 15px; display: flex; flex-direction: column; gap: 10px;">
                                    <div id="gallery-thumbnails-container" style="display: flex; flex-direction: column; gap: 10px;"></div>
                                </div>
                                
                                <!-- Main Display -->
                                <div class="gallery-main-container" style="flex: 1; background: #fff; position: relative; display: flex; align-items: center; justify-content: center; padding: 20px; overflow: hidden;">
                                    <img id="gallery-main-image" src="" style="max-width: 100%; max-height: 100%; object-fit: contain; transition: all 0.3s ease-in-out; border-radius: 4px; box-shadow: 0 5px 15px rgba(0,0,0,0.08);">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Quick Sector Modal -->
<div class="modal fade" id="quickSectorModal" tabindex="-1" role="dialog" aria-labelledby="quickSectorModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="border-radius: 12px; overflow: hidden; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
            <div class="modal-header" style="background: linear-gradient(135deg, #3c8dbc 0%, #2b6688 100%); color: white; border-bottom: none; padding: 20px;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white; opacity: 1;"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="quickSectorModalLabel" style="font-weight: 800; font-size: 20px;">
                    <i class="fa fa-bolt"></i> اضافة قطاع وفرع وقسم جديد
                </h4>
            </div>
            <form id="quickSectorForm">
                @csrf
                <div class="modal-body" style="padding: 30px; background: #fefefe;">
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label style="font-weight: 700; color: #444; margin-bottom: 8px;">اسم القطاع</label>
                            <input type="text" name="sector_name" class="form-control english-nums" placeholder="مثال: مواد البناء" required style="height: 45px; border-radius: 6px;">
                        </div>
                    </div>
                    <div class="form-group row" style="margin-top: 15px;">
                        <div class="col-md-6">
                            <label style="font-weight: 700; color: #444; margin-bottom: 8px;">اسم الفرع</label>
                            <input type="text" name="branch_name" class="form-control english-nums" placeholder="مثال: حديد" required style="height: 45px; border-radius: 6px;">
                        </div>
                        <div class="col-md-6">
                            <label style="font-weight: 700; color: #444; margin-bottom: 8px;">اسم القسم</label>
                            <input type="text" name="category_name" class="form-control english-nums" placeholder="مثال: حديد تسليح" required style="height: 45px; border-radius: 6px;">
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="background: #f9f9f9; border-top: 1px solid #eee; padding: 20px 30px;">
                    <button type="button" class="btn btn-default btn-lg" data-dismiss="modal" style="border-radius: 30px; padding: 8px 30px; font-weight: 600;">إلغاء</button>
                    <button type="submit" class="btn btn-primary btn-lg" id="btnSaveQuick" style="background: #3c8dbc; border: none; border-radius: 30px; padding: 8px 40px; font-weight: bold; box-shadow: 0 4px 10px rgba(60, 141, 188, 0.3);">
                        موافقة وإضافة
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Sector Modal -->
<div class="modal fade" id="sectorModal" tabindex="-1" role="dialog" aria-labelledby="sectorModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="border-radius: 12px; overflow: hidden; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
            <div class="modal-header" style="background: linear-gradient(135deg, #3c8dbc 0%, #2b6688 100%); color: white; border-bottom: none; padding: 20px;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white; opacity: 1;"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="sectorModalLabel" style="font-weight: 800; font-size: 20px;">
                    <i class="fa fa-plus-circle"></i> إضافة قطاعات لملفك
                </h4>
            </div>
            <form id="ajaxSectorForm">
                @csrf
                <div class="modal-body" style="padding: 30px; background: #fefefe;">
                    <div class="form-group">
                        <label style="font-weight: 700; color: #444; margin-bottom: 8px;">اختر القطاعات التي تعمل بها</label>
                        <select name="sector_ids[]" id="modal_sector_ids" class="form-control select2" multiple="multiple" style="width: 100%;">
                            @foreach($allSectors as $s)
                                <option value="{{ $s->id }}" {{ in_array($s->id, $sectors->pluck('id')->toArray()) ? 'selected' : '' }}>
                                    {{ $s->name_ar }}
                                </option>
                            @endforeach
                        </select>
                        <p class="help-block" style="margin-top: 10px; color: #888;">يمكنك اختيار أكثر من قطاع ليتم عرض الفروع والأقسام التابعة لها.</p>
                    </div>
                </div>
                <div class="modal-footer" style="background: #f9f9f9; border-top: 1px solid #eee; padding: 20px 30px;">
                    <button type="button" class="btn btn-default btn-lg" data-dismiss="modal" style="border-radius: 30px; padding: 8px 30px; font-weight: 600;">إلغاء</button>
                    <button type="submit" class="btn btn-primary btn-lg" id="saveSectorsBtn" style="background: #3c8dbc; border: none; border-radius: 30px; padding: 8px 40px; font-weight: bold; box-shadow: 0 4px 10px rgba(60, 141, 188, 0.3);">
                        حفظ التغييرات
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Quick Branch Modal -->
<div class="modal fade" id="quickBranchModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="border-radius: 12px; overflow: hidden; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
            <div class="modal-header" style="background: linear-gradient(135deg, #00a65a 0%, #008d4c 100%); color: white; border-bottom: none; padding: 20px;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white; opacity: 1;"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" style="font-weight: 800; font-size: 20px;">
                    <i class="fa fa-plus-circle"></i> إضافة فرع جديد للقطاع
                </h4>
            </div>
            <form id="quickBranchForm">
                @csrf
                <input type="hidden" name="sector_id" id="modal_sector_id">
                <div class="modal-body" style="padding: 30px; background: #fefefe;">
                    <div class="form-group">
                        <label id="selectedSectorName" style="display: block; margin-bottom: 10px; font-weight: bold; color: #3c8dbc;"></label>
                        <label style="font-weight: 700; color: #444; margin-bottom: 8px;">اسم الفرع الجديد</label>
                        <input type="text" name="branch_name" class="form-control" placeholder="مثال: حديد" required style="height: 45px; border-radius: 6px;">
                    </div>
                </div>
                <div class="modal-footer" style="background: #f9f9f9; border-top: 1px solid #eee; padding: 20px 30px;">
                    <button type="button" class="btn btn-default" data-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-success" id="btnSaveQuickBranch" style="border-radius: 30px; padding: 8px 40px; font-weight: bold;">حفظ وإضافة</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Quick Category Modal -->
<div class="modal fade" id="quickCategoryModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="border-radius: 12px; overflow: hidden; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
            <div class="modal-header" style="background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%); color: white; border-bottom: none; padding: 20px;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white; opacity: 1;"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" style="font-weight: 800; font-size: 20px;">
                    <i class="fa fa-plus-circle"></i> إضافة قسم جديد للفرع
                </h4>
            </div>
            <form id="quickCategoryForm">
                @csrf
                <input type="hidden" name="branch_id" id="modal_branch_id">
                <div class="modal-body" style="padding: 30px; background: #fefefe;">
                    <div class="form-group">
                        <label id="selectedBranchName" style="display: block; margin-bottom: 10px; font-weight: bold; color: #f39c12;"></label>
                        <label style="font-weight: 700; color: #444; margin-bottom: 8px;">اسم القسم الجديد</label>
                        <input type="text" name="category_name" class="form-control" placeholder="مثال: حديد تسليح" required style="height: 45px; border-radius: 6px;">
                    </div>
                </div>
                <div class="modal-footer" style="background: #f9f9f9; border-top: 1px solid #eee; padding: 20px 30px;">
                    <button type="button" class="btn btn-default" data-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-warning" id="btnSaveQuickCategory" style="border-radius: 30px; padding: 8px 40px; font-weight: bold; color: white;">حفظ وإضافة</button>
                </div>
            </form>
        </div>
    </div>
</div>

    <!-- Logistics Details Modal -->
    <div class="modal fade" id="logisticsModal" tabindex="-1" role="dialog" aria-labelledby="logisticsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document" style="width: 90%; max-width: 1000px;">
            <div class="modal-content" style="border-radius: 15px; border: none; overflow: hidden;">
                <div class="modal-header" style="background: #3c8dbc; color: white; display: flex; align-items: center; justify-content: space-between; padding: 15px 20px;">
                    <h4 class="modal-title" id="logisticsModalLabel" style="font-weight: bold;">
                        <i class="fa fa-ship"></i> تفاصيل الحاويات ومعايير الأمان
                    </h4>
                    <div style="text-align: left;">
                        <span id="logistics_modal_title" style="font-size: 14px; opacity: 0.9;"></span>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white; opacity: 1; font-size: 24px; margin-right: 15px;">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <div class="modal-body" id="logistics_modal_body" style="background: #f4f7f6; padding: 25px; max-height: 70vh; overflow-y: auto;">
                    <!-- Content will be injected by JS -->
                </div>
                <div class="modal-footer" style="padding: 10px 20px;">
                    <button type="button" class="btn btn-secondary btn-flat" data-dismiss="modal" style="border-radius: 5px; padding: 8px 25px;">إغلاق</button>
                </div>
            </div>
        </div>
    </div>
@endsection

<!-- Edit Product Modal -->
<div class="modal fade" id="editProductModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 12px; overflow: hidden; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
            <div class="modal-header" style="background: linear-gradient(135deg, #3c8dbc 0%, #2b6688 100%); color: white; border-bottom: none; padding: 20px;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white; opacity: 1;"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" style="font-weight: 800; font-size: 20px;">
                    <i class="fa fa-edit"></i> تعديل بيانات المنتج في القائمة
                </h4>
            </div>
            <div class="modal-body" style="padding: 25px; background: #fff;">
                <input type="hidden" id="edit_product_idx">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label style="font-weight: 700;">القطاع</label>
                            <select id="edit_sector_id" class="form-control select2" style="width: 100%;">
                                @foreach($sectors as $s)
                                    <option value="{{ $s->id }}">{{ $s->name_ar }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label style="font-weight: 700;">الفرع</label>
                            <select id="edit_branch_id" class="form-control select2" style="width: 100%"></select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label style="font-weight: 700;">القسم</label>
                            <select id="edit_category_id" class="form-control select2" style="width: 100%"></select>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label style="font-weight: 700;">اسم المنتج</label>
                            <input type="text" id="edit_name" class="form-control" style="height: 40px;">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label style="font-weight: 700;">ID المنتج (SKU)</label>
                            <input type="text" id="edit_sku" class="form-control" style="height: 40px;">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label style="font-weight: 700;">السعر</label>
                            <div class="input-group">
                                <input type="number" id="edit_price" class="form-control" step="0.01">
                                <span class="input-group-addon" id="edit_currency_label"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label style="font-weight: 700;">وزن القطعة (kg)</label>
                            <input type="number" id="edit_piece_weight" class="form-control" step="0.01">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label style="font-weight: 700;">عدد القطع في الكرتونة</label>
                            <input type="number" id="edit_product_piece_count" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label style="font-weight: 700;">طول الكرتونة (m)</label>
                            <input type="number" id="edit_carton_length" class="form-control dimension-input-edit" step="0.01">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label style="font-weight: 700;">عرض الكرتونة (m)</label>
                            <input type="number" id="edit_carton_width" class="form-control dimension-input-edit" step="0.01">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label style="font-weight: 700;">ارتفاع الكرتونة (m)</label>
                            <input type="number" id="edit_carton_height" class="form-control dimension-input-edit" step="0.01">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label style="font-weight: 700;">وصف المنتج</label>
                    <textarea id="edit_description" class="form-control" rows="4"></textarea>
                </div>
                <hr>
                <div class="form-group">
                    <label style="font-weight: 700;">الصور الحالية</label>
                    <div id="edit_images_preview" class="row" style="margin-bottom: 10px;"></div>
                    <label style="font-weight: 700; display: block; margin-top: 15px;">إضافة صور جديدة</label>
                    <input type="file" id="edit_new_images" class="form-control" multiple accept="image/*">
                </div>
            </div>
            <div class="modal-footer" style="background: #f9f9f9; border-top: 1px solid #eee; padding: 20px 30px;">
                <button type="button" class="btn btn-default" data-dismiss="modal">إلغاء</button>
                <button type="button" class="btn btn-primary" onclick="saveBatchProductEdit()" style="border-radius: 30px; padding: 8px 40px; font-weight: bold;">حفظ التعديلات</button>
            </div>
        </div>
    </div>
</div>
@push('css')
<link href="https://fonts.googleapis.com/css2?family=Almarai:wght@300;400;700;800&display=swap" rel="stylesheet">
<style>
    body {
        font-family: 'Almarai', sans-serif !important;
    }
    
    .upload-zone:hover {
        border-color: #3c8dbc !important;
        background: #f0f7ff !important;
    }
    
    .upload-zone:hover i {
        color: #3c8dbc !important;
    }
    
    input::placeholder {
        color: #ccc !important;
        opacity: 0.6;
    }
    
    .nav-tabs-custom > .nav-tabs > li.active {
        border-top-color: #3c8dbc;
    }

    #btnAddToList {
        background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
        border: none;
        color: white;
        transition: all 0.3s;
    }

    #btnAddToList:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 25px rgba(230, 126, 34, 0.4);
    }
    
    #batch_table thead th {
        background: linear-gradient(135deg, #1e3a5f 0%, #3c8dbc 100%);
        color: white;
        text-transform: uppercase;
        font-size: 13px;
        letter-spacing: 0.5px;
        border: none;
    }

    #batch_table tbody td {
        vertical-align: middle !important;
        border: 1px solid #f4f4f4;
    }

    /* Premium Cinema Mode Carousel Styles */
    #carouselInner .item {
        background: #0a0a0a;
        height: 600px;
        position: relative;
        overflow: hidden;
    }
    
    .item-bg-blur {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        filter: blur(25px) brightness(0.35);
        transform: scale(1.1);
        z-index: 1;
        pointer-events: none;
    }
    
    #carouselInner .item > img.main-img {
        max-height: 560px;
        max-width: 90%;
        width: auto;
        height: auto;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 2;
        box-shadow: 0 15px 35px rgba(0,0,0,0.4);
        border: 2px solid rgba(255,255,255,0.05);
        border-radius: 4px;
        object-fit: contain;
    }
    
    .carousel-indicators li {
        width: 10px;
        height: 10px;
        background: rgba(255,255,255,0.3);
        border: none;
        margin: 0 5px;
    }
    
    .carousel-indicators .active {
        width: 12px;
        height: 12px;
        background: #3c8dbc;
        margin: -1px 5px;
    }
    
    .carousel-control:hover .fa {
        color: #3c8dbc !important;
        transform: translateY(-50%) scale(1.1);
        transition: all 0.2s;
    }

    .batch-img {
        width: 45px !important;
        height: 45px !important;
        object-fit: cover !important;
        border-radius: 8px !important;
        border: 1px solid #eee !important;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05) !important;
    }

    .cbm-badge {
        background: #f0f7ff;
        color: #3c8dbc;
        padding: 4px 8px;
        border-radius: 6px;
        font-weight: bold;
    }

    .container-badge {
        font-weight: 800;
        font-size: 16px;
        color: #333;
    }

    /* Amazon Style Gallery Styles */
    .gallery-sidebar {
        scrollbar-width: thin;
        scrollbar-color: #ddd transparent;
    }
    .gallery-thumb {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border: 2px solid transparent;
        border-radius: 4px;
        cursor: pointer;
        transition: all 0.2s;
    }
    .gallery-thumb.active {
        border-color: #f39c12;
        box-shadow: 0 0 8px rgba(243, 156, 18, 0.5);
    }
    .gallery-main-container img {
        max-width: 100%;
        max-height: 500px;
        object-fit: contain;
    }
    .logistics-cell {
        font-size: 11px;
        text-align: right;
        background: #fff;
        padding: 5px !important;
        border: 1px solid #eee;
    }
    .logistics-cell div {
        display: flex;
        justify-content: space-between;
        margin-bottom: 2px;
    }
    .logistics-cell span:last-child {
        font-weight: bold;
        color: #3c8dbc;
    }
    
    /* Fix Select2 in Modal */
    .select2-container--open {
        z-index: 9999 !important;
    }
    
    @media print {
        body * {
            visibility: hidden;
        }
        #batch_section, #batch_section * {
            visibility: visible;
        }
        #batch_section {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }
        .no-print {
            display: none !important;
        }
        .main-header, .main-sidebar, .content-header, .box-header:not(#batch_section .box-header) {
            display: none !important;
        }
        body {
            background-color: white !important;
        }
        th, td {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
    }
    .gallery-sidebar::-webkit-scrollbar {
        width: 5px;
    }
    .gallery-sidebar::-webkit-scrollbar-thumb {
        background: #ccc;
        border-radius: 10px;
    }
    .gallery-thumb {
        width: 100%;
        height: 90px;
        object-fit: cover;
        border-radius: 6px;
        cursor: pointer;
        border: 2px solid transparent;
        transition: all 0.2s;
        background: #fff;
    }
    .gallery-thumb:hover {
        border-color: #3c8dbc;
        transform: scale(1.02);
    }
    /* Mode Card Styling */
    .mode-card.active {
        background: #f0f7ff !important;
        border-color: #3c8dbc !important;
        box-shadow: 0 4px 15px rgba(60, 141, 188, 0.15);
    }
    .mode-card.active h4 {
        color: #3c8dbc !important;
    }
    .mode-card.active .mode-icon i {
        color: #3c8dbc !important;
        opacity: 1 !important;
    }
    .mode-card:hover:not(.active) {
        border-color: #3c8dbc !important;
        transform: translateY(-2px);
    }
</style>
@endpush

@push('scripts')
<!-- TinyMCE 6 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.2/tinymce.min.js"></script>
<script>
    // Mode Switching Logic
    function switchUploadMode(mode) {
        $('#upload_mode').val(mode);
        $('.mode-card').removeClass('active');
        $('.mode-card .check-mark').hide();
        $('.mode-card .mode-icon i').css('color', '#999');
        
        $(`#mode_${mode}`).addClass('active');
        $(`#mode_${mode} .check-mark`).show();
        $(`#mode_${mode} .mode-icon i').css('color', '#3c8dbc');

        if (mode === 'special') {
            $('#lbl_unit_price').text('سعر المنتج');
            $('#lbl_unit_weight').text('وزن المنتج قبل التغليف / N.W.(KG)');
            $('#lbl_gross_weight').text('وزن المنتج بعد التغليف / G.W.(KG)');
            $('#lbl_unit_cbm').text('حجم المنتج CBM');
            $('#lbl_gross_weight, #col_gross_weight').show();
            $('#lbl_carton_weight_col').hide();
            
            $('#lbl_batch_price').text('سعر المنتج');
            $('#lbl_batch_weight').text('وزن المنتج N.W');
            $('#lbl_batch_gross_weight').show();
            $('#lbl_carton_length').text('طول المنتج (m)');
            $('#lbl_carton_width').text('عرض المنتج (m)');
            $('#lbl_carton_height').text('ارتفاع المنتج (m)');
            $('#lbl_units_per_carton').text('حجم المنتج مع التغليف / Total CBM');
            $('#lbl_batch_units').text('حجم المنتج مع التغليف / Total CBM');
            
            $('#lbl_carton_cbm, #col_total_cbm').hide();
            $('#lbl_batch_total_cbm').hide();
            
            $('#lbl_batch_total_weight').hide();
            $('#product_piece_count').attr('placeholder', 'مثال: 0.5');
        } else {
            $('#lbl_unit_price').text('سعر الوحدة');
            $('#lbl_unit_weight').text('وزن الوحدة');
            $('#lbl_gross_weight').text('وزن المنتج G.W(KG)');
            $('#lbl_unit_cbm').text('CBM الوحدة');
            $('#lbl_gross_weight, #col_gross_weight').hide();
            $('#lbl_carton_weight_col').show();

            $('#lbl_batch_price').text('سعر الوحدة');
            $('#lbl_batch_weight').text('وزن الوحدة');
            $('#lbl_batch_gross_weight').hide();
            $('#lbl_carton_length').text('طول الكرتونة (m)');
            $('#lbl_carton_width').text('عرض الكرتونة (m)');
            $('#lbl_carton_height').text('ارتفاع الكرتونة (m)');
            $('#lbl_units_per_carton').text('عدد الوحدات في الكرتونة');
            $('#lbl_batch_units').text('عدد الوحدات في الكرتونة');
            
            $('#lbl_carton_cbm, #col_total_cbm').show();
            $('#lbl_batch_total_cbm').show();

            $('#lbl_batch_total_weight').show();
            $('#product_piece_count').attr('placeholder', 'عدد القطع');
        }
    }

    // TinyMCE Initialization
    function initTinyMCE(selector, height = 250, isTableOnly = false) {
        let plugins = 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table code help wordcount';
        let toolbar = 'undo redo | blocks | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | table help';
        
        if (isTableOnly) {
            toolbar = 'table | undo redo | bold italic forecolor backcolor | alignleft aligncenter alignright | removeformat';
        }

        tinymce.init({
            selector: selector,
            height: height,
            language: 'ar',
            directionality: 'rtl',
            plugins: plugins,
            toolbar: toolbar,
            branding: false,
            promotion: false,
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
        });
    }

    $(document).ready(function() {
        // Auto-collapse sidebar for more space
        $('body').addClass('sidebar-collapse');
        
        initTinyMCE('#editor', 300);
        
        // Initialize with 'special' mode (Vehicle Details)
        switchUploadMode('special');

        window.returnToHero = function() {
            $('#full_page_content').fadeOut(400, function() {
                $('#mode_selection_hero').fadeIn(400);
                $('.mode-hero-btn').removeClass('active').css({ 'box-shadow': '', 'transform': '' });
                // Optional: clear form data if needed
            });
            $('html, body').animate({ scrollTop: 0 }, 500);
        };

        function selectMode(mode) {
            $('#mode_selection_hero').fadeOut(400, function() {
                $('.mode-hero-btn').removeClass('active').css({ 'box-shadow': '', 'transform': '' });
                
                if (mode === 'light') {
                    $('#btnHeroLight').addClass('active').css({ 'background': 'white', 'color': '#3c8dbc', 'box-shadow': '0 15px 35px rgba(60, 141, 188, 0.2)' });
                    $('#btnHeroHeavy').css({ 'background': '#fff5e6', 'color': '#e67e22' });
                    
                    $('#section_heavy_vehicles').hide();
                    $('#light_vehicles_wrapper').show();
                    $('#upload_mode').val('special');
                } else {
                    $('#btnHeroHeavy').addClass('active').css({ 'background': 'white', 'color': '#e67e22', 'box-shadow': '0 15px 35px rgba(230, 126, 34, 0.2)' });
                    $('#btnHeroLight').css({ 'background': '#eef7ff', 'color': '#3c8dbc' });
                    
                    $('#light_vehicles_wrapper').hide();
                    $('#section_heavy_vehicles').show();
                    $('#upload_mode').val('special');
                }

                $('#full_page_content').fadeIn(600);
                $('#vehicle_details_table_wrapper').fadeIn(600);
                
                // Recalculate immediately
                calculateNewTable();

                // Scroll to form smoothly
                $('html, body').animate({
                    scrollTop: $("#full_page_content").offset().top - 20
                }, 800);
            });
        }

        $('#btnHeroLight').on('click', function() { selectMode('light'); });
        $('#btnHeroHeavy').on('click', function() { selectMode('heavy'); });

        function checkTableVisibility() {
            if (!$('#light_vehicles_wrapper').is(':visible') && !$('#section_heavy_vehicles').is(':visible')) {
                $('#vehicle_details_table_wrapper').slideUp();
            }
        }

        // Automatic mode selection based on controller parameter
        var modeParam = "{{ $mode ?? '' }}";
        if (modeParam === 'light') {
            selectMode('light');
        } else if (modeParam === 'heavy') {
            selectMode('heavy');
        }
    });

    // CSRF Token workaround
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Dynamic Dropdowns
    $('#sector_id').on('change', function() {
        var sectorId = $(this).val();
        $('#branch_id').empty().append('<option value="">اختر الفرع</option>').prop('disabled', true);
        $('#category_id').empty().append('<option value="">اختر القسم</option>').prop('disabled', true);
        $('#btnAddBranch').hide();
        $('#btnAddCategory').hide();
        
        if (sectorId) {
            $('#btnAddBranch').show();
            $('#modal_sector_id').val(sectorId);
            $('#selectedSectorName').text('القطاع: ' + $('#sector_id option:selected').text());

            $.ajax({
                url: '/api/branches/' + sectorId,
                type: 'GET',
                success: function(data) {
                    $('#branch_id').prop('disabled', false);
                    $.each(data, function(key, value) {
                        $('#branch_id').append('<option value="' + value.id + '">' + value.name_ar + '</option>');
                    });
                }
            });
        }
    });

    $('#branch_id').on('change', function() {
        var branchId = $(this).val();
        $('#category_id').empty().append('<option value="">اختر القسم</option>').prop('disabled', true);
        $('#btnAddCategory').hide();
        
        if (branchId) {
            $('#btnAddCategory').show();
            $('#modal_branch_id').val(branchId);
            $('#selectedBranchName').text('الفرع: ' + $('#branch_id option:selected').text());

            $.ajax({
                url: '/api/categories/' + branchId,
                type: 'GET',
                success: function(data) {
                    $('#category_id').prop('disabled', false);
                    $.each(data, function(key, value) {
                        $('#category_id').append('<option value="' + value.id + '">' + value.name_ar + '</option>');
                    });
                }
            });
        }
    });

    // Quick Branch Ajax Submission
    $('#quickBranchForm').on('submit', function(e) {
        e.preventDefault();
        var btn = $('#btnSaveQuickBranch');
        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> جاري الحفظ...');
        
        $.ajax({
            url: "{{ route('api.quick-branch') }}",
            type: "POST",
            data: $(this).serialize(),
            success: function(res) {
                if (res.success) {
                    var newOption = new Option(res.branch.name_ar, res.branch.id, true, true);
                    $('#branch_id').append(newOption).trigger('change');
                    $('#quickBranchModal').modal('hide');
                    $('#quickBranchForm')[0].reset();
                }
                btn.prop('disabled', false).html('حفظ وإضافة');
            },
            error: function() {
                alert('حدث خطأ أثناء حفظ الفرع الجديد.');
                btn.prop('disabled', false).html('حفظ وإضافة');
            }
        });
    });

    // Quick Category Ajax Submission
    $('#quickCategoryForm').on('submit', function(e) {
        e.preventDefault();
        var btn = $('#btnSaveQuickCategory');
        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> جاري الحفظ...');
        
        $.ajax({
            url: "{{ route('api.quick-category') }}",
            type: "POST",
            data: $(this).serialize(),
            success: function(res) {
                if (res.success) {
                    var newOption = new Option(res.category.name_ar, res.category.id, true, true);
                    $('#category_id').append(newOption).trigger('change');
                    $('#quickCategoryModal').modal('hide');
                    $('#quickCategoryForm')[0].reset();
                }
                btn.prop('disabled', false).html('حفظ وإضافة');
            },
            error: function() {
                alert('حدث خطأ أثناء حفظ القسم الجديد.');
                btn.prop('disabled', false).html('حفظ وإضافة');
            }
        });
    });

    // Batch variables
    var productsBatch = [];
    var initialSelectedImagesData = [];

    // Image Preview & Store
    $('#product_images').on('change', function() {
        $('#image_preview').empty();
        var files = Array.from($(this)[0].files);
        initialSelectedImagesData = [];

        for (var i = 0; i < files.length; i++) {
            (function(file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#image_preview').append('<div class="col-md-2"><img src="' + e.target.result + '" class="img-responsive img-thumbnail" style="margin-bottom: 5px;"></div>');
                    initialSelectedImagesData.push({
                        name: file.name,
                        dataURL: e.target.result
                    });
                }
                reader.readAsDataURL(file);
            })(files[i]);
        }
    });

    // Add Product To Batch Logic
    $('#btnAddToList').on('click', function() {
        var form = $('#productForm')[0];
        
        // Manual validation since it's a type="button"
        if(!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        var description = (typeof tinymce !== 'undefined' && tinymce.get('editor')) 
            ? tinymce.get('editor').getContent() 
            : $('#editor').val();

        var plainDesc = description.replace(/(<([^>]+)>)/ig, "").replace(/&nbsp;/ig, "").trim();
        if (!plainDesc) {
            alert('يجب إدخال التفاصيل في خانة وصف المنتج.');
            return;
        }

        if(initialSelectedImagesData.length === 0) {
            alert('يجب اختيار صورة واحدة على الأقل، (يرجى الانتظار ثانية ليتم تحميل الصورة في المتصفح).');
            return;
        }

        var priceStr = parseFloat($('#price').val()) || 0;
        var currency = $('#currency_code').val() || '';
        
        // Capture Logistics Results
        var logistics = {
            cap_20ft: 0, cap_40ft: 0, cap_40hq: 0, cap_45ft: 0,
            spec_open_top_20: 0, spec_open_top_40: 0, spec_flat_rack_20: 0, spec_flat_rack_40: 0,
            spec_platform_20: 0, spec_platform_40: 0, spec_reefer_40: 0, spec_roro: false,
            details: {}
        };

        // Standard containers
        $('.widget-cbm-calc').each(function(idx){
            var val = $(this).find('span[style*="font-size: 15px"]').text();
            if(idx === 1) logistics.cap_20ft = parseFloat(val) || 0;
            if(idx === 2) logistics.cap_40ft = parseFloat(val) || 0;
            if(idx === 3) logistics.cap_40hq = parseFloat(val) || 0;
            if(idx === 4) logistics.cap_45ft = parseFloat(val) || 0;
        });

        // Specialized
        var heavyVehicleData = [];
        $('.spec-container-card').each(function(){
            var card = $(this);
            var name = card.data('name');
            var meta = card.data('logistics-meta') ? JSON.parse(card.data('logistics-meta')) : null;
            if (meta) {
                heavyVehicleData.push(meta);
            }
            
            // Legacy mapping
            var val = card.find('span[style*="font-size: 14px"]').first().text();
            if(name === '20ft Open Top') logistics.spec_open_top_20 = parseFloat(val) || 0;
            if(name === '40ft Open Top') logistics.spec_open_top_40 = parseFloat(val) || 0;
            if(name === '20ft Flat Rack') logistics.spec_flat_rack_20 = parseFloat(val) || 0;
            if(name === '40ft Flat Rack') logistics.spec_flat_rack_40 = parseFloat(val) || 0;
            if(name === '20ft Platform') logistics.spec_platform_20 = parseFloat(val) || 0;
            if(name === '40ft Platform') logistics.spec_platform_40 = parseFloat(val) || 0;
            if(name === '40ft Reefer') logistics.spec_reefer_40 = parseFloat(val) || 0;
            if(card.data('roro')) logistics.spec_roro = true;
        });

        // Determine actual display mode based on active section
        var isHeavySelection = $('#section_heavy_vehicles').is(':visible');
        
        // Capture Vehicle Technical Details (All Fields requested by User)
        var vehicle_info = {
            // Basic Vehicle Info
            manufacturer: $('input[name="car_manufacturer"]').val() || '',
            model: $('input[name="car_model"]').val() || '',
            year: $('input[name="car_year"]').val() || '',
            type: $('select[name="car_type"]').val() || 'car',
            class: $('input[name="car_class"]').val() || '',
            vin: $('input[name="car_vin"]').val() || '',
            plate: $('input[name="car_plate_number"]').val() || '',
            
            // Technical Specifications
            engine_type: $('select[name="engine_type"]').val() || '',
            engine_cc: $('input[name="engine_cc"]').val() || '',
            cylinders: $('input[name="cylinders"]').val() || '',
            horsepower: $('input[name="horsepower"]').val() || '',
            transmission: $('select[name="transmission"]').val() || '',
            drive_system: $('select[name="drive_system"]').val() || '',
            fuel_consumption: $('input[name="fuel_consumption"]').val() || '',
            max_speed: $('input[name="max_speed"]').val() || '',
            acceleration: $('input[name="acceleration"]').val() || '',
            
            // Condition & Usage
            condition: $('select[name="car_condition"]').val() || 'new',
            mileage: $('input[name="mileage"]').val() || 0,
            previous_owners: $('input[name="previous_owners"]').val() || 0,
            vehicle_state: $('select[name="vehicle_state"]').val() || 'excellent',
            last_maintenance_date: $('input[name="last_maintenance_date"]').val() || '',
            accident_history: $('input[name="accident_history"]:checked').val() || 'no',
            accident_details: $('textarea[name="accident_details"]').val() || '',
            features: []
        };
        $('input[name="features[]"]:checked').each(function(){
            vehicle_info.features.push($(this).val());
        });

        var product = {
            id: Date.now(),
            vehicle_group: isHeavySelection ? 'heavy' : 'light',
            sector_id: $('#sector_id').val(),
            branch_id: $('#branch_id').val(),
            category_id: $('#category_id').val(),
            sector_name: $('#sector_id option:selected').text(),
            branch_name: $('#branch_id option:selected').text(),
            category_name: $('#category_id option:selected').text(),
            name: $('#table_product_name').val() || $('#name').val(),
            sku: $('#sku').val() || $('#sku_main').val(),
            price: priceStr,
            currency_code: currency,
            min_order_quantity: $('#min_order_quantity').val() || 1,
            piece_weight: $('#piece_weight').val(),
            product_piece_count: $('#product_piece_count').val(),
            carton_length: $('#carton_length').val(),
            carton_width: $('#carton_width').val(),
            carton_height: $('#carton_height').val(),
            carton_volume_cbm: $('#carton_volume_cbm').val(),
            total_cbm: $('#total_cbm').val(),
            total_weight: $('#total_weight').val(),
            description: description,
            custom_info: '',
            product_catalog: '',
            images: initialSelectedImagesData,
            logistics: logistics,
            heavy_logistics: heavyVehicleData, 
            vehicle_info: vehicle_info, // Store technical data
            upload_mode: $('#upload_mode').val()
        };

        // Also capture detailed standard margins if light
        if (!isHeavySelection) {
            var lightLogistics = [];
            $('.widget-cbm-calc').each(function(idx){
                if (idx > 0) { // Skip item CBM
                    var meta = $(this).data('logistics-meta') ? JSON.parse($(this).data('logistics-meta')) : null;
                    if (meta) {
                        lightLogistics.push(meta);
                    }
                }
            });
            product.light_logistics = lightLogistics;
        }

        productsBatch.push(product);
        renderBatchTable();
        
        // Reset table inputs
        $('#table_product_name').val('');
        $('#sku').val('');
        $('#price').val('');
        $('#piece_weight').val('');
        $('#product_piece_count').val('');
        $('#carton_length').val('');
        $('#carton_width').val('');
        $('#carton_height').val('');
        $('#carton_volume_cbm').val('');
        $('#total_cbm').val('');
        $('#total_weight').val('');

        if (typeof tinymce !== 'undefined') {
            if(tinymce.get('editor')) tinymce.get('editor').setContent('');
        }
        
        calculateNewTable();
        
        // Reset images
        initialSelectedImagesData = [];
        $('#image_preview').empty();
        $('#product_images').val('');

        // Scroll to batch table
        $('html, body').animate({
            scrollTop: $("#batch_section").offset().top - 50
        }, 500);
    });

    function renderBatchTable() {
        var tbody = $('#batch_table tbody');
        tbody.empty();
        
        if(productsBatch.length === 0) {
            $('#batch_section').hide();
            return;
        }

        $('#batch_section').show();

        productsBatch.forEach(function(p, index) {
            var imgUrl = p.images[0] ? p.images[0].dataURL : '';
            var row = `
                <tr style="background: ${index % 2 === 0 ? '#fff' : '#fcfcfc'};">
                    <td style="text-align: center; width: 60px; cursor: pointer;" onclick="openImagesModal(${p.id})">
                        <div style="position: relative;">
                            <img src="${imgUrl}" class="batch-img" style="width: 55px !important; height: 55px !important; border: 2px solid #3c8dbc;">
                            <div style="position: absolute; bottom: -5px; right: -5px; background: #3c8dbc; color: white; border-radius: 50%; width: 22px; height: 22px; font-size: 10px; display: flex; align-items: center; justify-content: center;">
                                <i class="fa fa-search-plus"></i>
                            </div>
                        </div>
                    </td>
                    <td style="text-align: right; min-width: 180px;">
                        <div style="font-weight: bold; color: #333; font-size: 14px;">${p.name}</div>
                        <div style="font-size: 10px; color: #777;">${p.sector_name} > ${p.category_name}</div>
                        <div style="font-size: 10px; color: #888; margin-top: 4px;">L:${Number(p.carton_length).toFixed(2)} W:${Number(p.carton_width).toFixed(2)} H:${Number(p.carton_height).toFixed(2)}</div>
                    </td>
                    <td style="text-align: center;">
                        <div style="font-weight: bold; color: #333;">${p.sku || '-'}</div>
                    </td>
                    <td style="text-align: center;">
                        <div style="color: #d9534f; font-weight: bold;">
                            ${p.currency_code} <span class="english-nums">${Number(p.price).toLocaleString()}</span>
                        </div>
                    </td>
                    <td style="text-align: center;">
                        <div class="english-nums">${p.piece_weight} كجم</div>
                    </td>
                    <td class="logistics-cell" style="text-align: center; vertical-align: middle;">
                        <button type="button" class="btn btn-sm btn-info btn-flat" 
                                style="border-radius: 20px; padding: 5px 15px; font-weight: bold; box-shadow: 0 2px 5px rgba(0,192,239,0.3);"
                                onclick="viewLogisticsDetails(${p.id})">
                             عرض تفاصيل الحاويات
                        </button>
                    </td>
                    <td style="text-align: center;">
                        <div class="english-nums" style="font-weight: bold;">${p.product_piece_count}</div>
                    </td>
                    <td style="text-align: center; background: #fff9e6;">
                        <div class="cbm-badge english-nums">${p.total_cbm}</div>
                    </td>
                    <td style="text-align: center; background: #fff9e6;">
                        <div class="english-nums" style="font-weight: bold; color: #b8860b;">${p.total_weight} كجم</div>
                    </td>
                    <td style="text-align: center;" class="no-print">
                        <button type="button" class="btn btn-sm btn-primary btn-flat" style="border-radius: 5px; margin-bottom: 5px;" onclick="openEditProductModal(${p.id})">
                            <i class="fa fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-danger btn-flat" style="border-radius: 5px;" onclick="removeProduct(${p.id})">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `;
            tbody.append(row);
        });
    }

    window.viewLogisticsDetails = function(id) {
        var p = productsBatch.find(p => p.id === id);
        if(!p) return;

        $('#logistics_modal_title').text(p.name + ' - (' + p.sku + ')');
        var container = $('#logistics_modal_body');
        container.empty();

        var logistics = (p.vehicle_group === 'light' ? (p.light_logistics || []) : (p.heavy_logistics || []));
        
        if (logistics.length === 0) {
            container.html('<div style="text-align:center; padding:40px; color:#999;"><i class="fa fa-info-circle fa-2x"></i><br>لا توجد بيانات لوجستية محفوظة لهذا المنتج</div>');
        } else {
            var html = '<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 15px;">';
            logistics.forEach(lc => {
                html += `
                    <div style="border: 1px solid #ddd; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.08); background: #fff;">
                        <div style="background: linear-gradient(135deg, #3c8dbc, #2b6699); color: white; padding: 12px 15px; font-weight: bold; display: flex; justify-content: space-between; align-items: center;">
                            <span>${lc.label || lc.name}</span>
                            <span style="font-size: 11px; background: rgba(255,255,255,0.2); padding: 2px 8px; border-radius: 10px;">${lc.factor} CBM</span>
                        </div>
                        <div style="padding: 15px; font-size: 13px; display: flex; flex-direction: column; gap: 6px;">
                            <div style="color: #666; font-size: 11px; border-bottom: 1px solid #eee; padding-bottom: 6px; margin-bottom: 6px; text-align:center;">
                                <i class="fa fa-arrows"></i> طول: <b>${lc.dims.l}</b> | عرض: <b>${lc.dims.w}</b> | ارتفاع: <b>${lc.dims.h}</b>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span style="color: #888;">الحاويات المطلوبة:</span>
                                <span style="font-weight: bold; color: #3c8dbc; font-size: 16px;">${lc.numContainers}</span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span style="color: #888;">إجمالي القطع:</span>
                                <span style="font-weight: bold;">${Number(lc.totalPcs).toLocaleString()}</span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span style="color: #888;">الوزن الكلي:</span>
                                <span style="font-weight: bold;">${Number(lc.totalWeight).toLocaleString()} kg</span>
                            </div>
                            
                            <div style="background: #f8f9fa; border: 1px solid #e9ecef; border-radius: 8px; padding: 12px; margin-top: 8px;">
                                <div style="border-bottom: 2px solid #3c8dbc; width: fit-content; margin-bottom: 10px; padding-bottom: 2px; font-weight: bold; font-size: 12px; color: #333;">
                                    <i class="fa fa-shield"></i> معايير الأمان مطبقة
                                </div>
                                <div style="display: grid; grid-template-columns: 1fr; gap: 6px; font-size: 12px;">
                                    <div style="display:flex; justify-content:space-between;"><span>الأرضي (Flat):</span> <b style="color: #2b6699;">${lc.margins.flat} سيارة</b></div>
                                    <div style="display:flex; justify-content:space-between;"><span>المائل (Rack):</span> <b style="color: #2b6699;">${lc.margins.rack} سيارة</b></div>
                                    <div style="display:flex; justify-content:space-between;"><span>فولاذي (Steel):</span> <b style="color: #2b6699;">${lc.margins.steel} سيارة</b></div>
                                    <div style="display:flex; justify-content:space-between;"><span>منصات (Cassette):</span> <b style="color: #2b6699;">${lc.margins.cassette} سيارة</b></div>
                                    <div style="display:flex; justify-content:space-between;"><span>الخشبي (Timber):</span> <b style="color: #2b6699;">${lc.margins.timber} سيارة</b></div>
                                </div>
                            </div>
                            
                            <div style="display: flex; justify-content: space-between; margin-top: 10px; padding-top: 10px; border-top: 2px solid #f4f4f4; align-items: center;">
                                <span style="color: #888;">السعر الإجمالي:</span>
                                <span style="font-weight: bold; color: #d9534f; font-size: 16px;">${Number(lc.totalPrice).toLocaleString()} ${lc.currency}</span>
                            </div>
                            ${lc.weightNote ? `<div style="background: #fff3cd; color: #856404; padding: 8px; border-radius: 6px; font-size: 11px; margin-top: 5px; border-right: 4px solid #ffc107;"><b>تنبيه:</b> ${lc.weightNote}</div>` : ''}
                        </div>
                    </div>
                `;
            });
            html += '</div>';
            container.html(html);
        }

        $('#logisticsModal').modal('show');
    };

    window.removeProduct = function(id) {
        if(confirm('هل أنت متأكد من حذف هذا المنتج من القائمة؟')) {
            productsBatch = productsBatch.filter(p => p.id !== id);
            renderBatchTable();
        }
    };

    window.openImagesModal = function(id) {
        var product = productsBatch.find(p => p.id === id);
        if(!product) return;

        var thumbContainer = $('#gallery-thumbnails-container');
        var mainImg = $('#gallery-main-image');
        thumbContainer.empty();

        var total = product.images.length;
        $('#gallery-counter').text('1 / ' + total);

        product.images.forEach(function(imgData, index) {
            var activeClass = index === 0 ? 'active' : '';
            var thumb = $(`<img src="${imgData.dataURL}" class="gallery-thumb ${activeClass}" data-index="${index}">`);
            
            thumb.on('click hover', function() {
                $('.gallery-thumb').removeClass('active');
                $(this).addClass('active');
                mainImg.attr('src', imgData.dataURL);
                $('#gallery-counter').text((index + 1) + ' / ' + total);
            });

            thumbContainer.append(thumb);
            
            if(index === 0) {
                mainImg.attr('src', imgData.dataURL);
            }
        });

        $('#imagesModal').modal('show');
    };

    // Dynamic Dropdowns Fix for Select2 in modals
    $('#sectorModal').on('shown.bs.modal', function() {
        $('#modal_sector_ids').select2({
            dropdownParent: $('#sectorModal'),
            width: '100%'
        });
    });

    // Sector Modal Ajax Submission
    $('#ajaxSectorForm').on('submit', function(e) {
        e.preventDefault();
        var btn = $('#saveSectorsBtn');
        btn.prop('disabled', true).text('جاري الحفظ...');
        
        $.ajax({
            url: "{{ route('user-sectors.store') }}",
            type: "POST",
            data: $(this).serialize(),
            success: function(response) {
                btn.prop('disabled', false).text('حفظ التغييرات');
                $('#sectorModal').modal('hide');
                location.reload(); 
            },
            error: function(xhr) {
                btn.prop('disabled', false).text('حفظ التغييرات');
                alert('حدث خطأ أثناء حفظ القطاعات.');
            }
        });
    });

    // Quick Sector Ajax Submission
    $('#quickSectorForm').on('submit', function(e) {
        e.preventDefault();
        var btn = $('#btnSaveQuick');
        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> جاري الحفظ...');
        
        $.ajax({
            url: "{{ route('api.quick-sector') }}",
            type: "POST",
            data: $(this).serialize(),
            success: function(res) {
                if (res.success) {
                    var newOption = new Option(res.sector.name_ar, res.sector.id, true, true);
                    $('#sector_id').append(newOption).trigger('change');
                    
                    setTimeout(function() {
                        $('#branch_id').empty().append(new Option(res.branch.name_ar, res.branch.id, true, true)).prop('disabled', false).trigger('change');
                        $('#category_id').empty().append(new Option(res.category.name_ar, res.category.id, true, true)).prop('disabled', false).trigger('change');
                    }, 500);

                    $('#quickSectorModal').modal('hide');
                    $('#quickSectorForm')[0].reset();
                }
                btn.prop('disabled', false).html('موافقة وإضافة');
            },
            error: function() {
                alert('حدث خطأ أثناء الحفظ السريع.');
                btn.prop('disabled', false).html('موافقة وإضافة');
            }
        });
    });

    // Calculation logic
    function calculateNewTable() {
        var length = parseFloat($('#carton_length').val()) || 0;
        var width = parseFloat($('#carton_width').val()) || 0;
        var height = parseFloat($('#carton_height').val()) || 0;
        var qty = parseFloat($('#product_piece_count').val()) || 0;
        var unitWeight = parseFloat($('#piece_weight').val()) || 0;
        var unitPrice = parseFloat($('#price').val()) || 0;

        // (L * W * H) is the Volume of ONE Unit (PIECE)
        var unitCbm = (length * width * height);
        $('#carton_volume_cbm').val(unitCbm.toFixed(6));

        // Carton Volume is (Unit CBM * Units per Carton)
        var cartonCbm = unitCbm * qty;
        $('#total_cbm').val(cartonCbm.toFixed(6));

        // Total weight per carton (Unit weight * Units per Carton)
        var cartonTotalWeight = unitWeight * qty;
        
        if ($('#upload_mode').val() === 'special') {
            var gw = parseFloat($('#gross_weight_input').val()) || unitWeight;
            $('#total_weight').val(gw.toFixed(2));
        } else {
            $('#total_weight').val(cartonTotalWeight.toFixed(2));
        }

        // Trigger calculations if we have at least length or volume
        if (length > 0 || unitCbm > 0) {
            const widgets = $('.widget-cbm-calc');
            const currency = $('#currency_code').val() || '$';

            // Base comparison: how many of these CARTONS fit in the container
            // If qty is 0, we treat the unit itself as the object to fit for preview
            const effectiveCartonCbm = cartonCbm > 0 ? cartonCbm : unitCbm;
            const effectiveQty = qty > 0 ? qty : 1;

            // Containers with requested factors
            const containers = [
                { label: 'item CBM', factor: effectiveCartonCbm, weightNote: null,                              maxWeightKg: null,  intL: 0,     intW: 0,    intH: 0 },
                { label: '20ft',  factor: 28, weightNote: 'الحد الأقصى للوزن: 18 - 22 طن', maxWeightKg: 22000, intL: 5.90,  intW: 2.35, intH: 2.39 },
                { label: '40ft',  factor: 58, weightNote: 'الحد الأقصى للوزن: 20 - 24 طن', maxWeightKg: 24000, intL: 12.03, intW: 2.35, intH: 2.39 },
                { label: '40HQ',  factor: 68, weightNote: 'الحد الأقصى للوزن: 20 - 24 طن', maxWeightKg: 24000, intL: 12.03, intW: 2.35, intH: 2.69 },
                { label: '45ft',  factor: 78, weightNote: 'الحد الأقصى للوزن: 15 - 20 طن', maxWeightKg: 20000, intL: 13.55, intW: 2.35, intH: 2.69 },
            ];

            // Update item CBM title with the calculated value
            $('#widget-item-cbm-title').text(`item CBM (${effectiveCartonCbm.toFixed(4)})`);

            // Total Order Data
            const totalOrderPcs = effectiveQty;
            const totalOrderWeight = unitWeight * totalOrderPcs;
            const totalOrderPrice = unitPrice * totalOrderPcs;

            containers.forEach((c, index) => {
                let displayMainLabel = '';
                let displayMainValue = '';

                let capFlat = 0, capRack = 0, capSteel = 0, capCassette = 0, capTimber = 0;
                
                // Safety Margins (in meters)
                const BUMPER_GAP = 0.25;
                const WALL_GAP = 0.10;
                const ROOF_GAP = 0.15;
                const VERT_GAP = 0.15;

                if (index > 0 && length > 0 && width > 0 && height > 0) {
                    // Check Width and Height safety first
                    if ((width + (WALL_GAP * 2)) <= c.intW && (height + ROOF_GAP) <= c.intH) {
                        
                        // Formula with bumper gap: floor((L_container + gap) / (L_product + gap))
                        capFlat = Math.floor((c.intL + BUMPER_GAP) / (length + BUMPER_GAP));
                        
                        // For specialized systems, we apply the safety gap to the efficiency-adjusted length
                        capRack = Math.floor((c.intL + BUMPER_GAP) / ((length * 0.72) + BUMPER_GAP));
                        capSteel = Math.floor((c.intL + BUMPER_GAP) / ((length * 0.68) + BUMPER_GAP));
                        capCassette = Math.floor((c.intL + BUMPER_GAP) / ((length * 0.62) + BUMPER_GAP));
                        capTimber = Math.floor((c.intL + BUMPER_GAP) / ((length * 0.82) + BUMPER_GAP));
                        
                        // Small car bonus for racking (if length is small, 4 is extremely common in 40ft/HQ)
                        if (index >= 2 && length <= 4.8) {
                            capRack = Math.max(capRack, 3);
                            capSteel = Math.max(capSteel, 4);
                            capCassette = Math.max(capCassette, 4);
                        }
                    }
                }

                if (index === 0) {
                    displayMainLabel = 'إجمالي الحجم (CBM):';
                    displayMainValue = effectiveCartonCbm.toFixed(4);
                } else {
                    displayMainLabel = 'عدد الحاويات المطلوبة:';
                    displayMainValue = (effectiveCartonCbm / c.factor).toFixed(2);
                }

                const capacityHtml = index > 0 ? `
                    <div style="margin-top: 8px; border-top: 1px solid rgba(255,255,255,0.2); padding-top: 5px; font-size: 11px; display: flex; flex-direction: column; gap: 2px;">
                        <div style="background: rgba(0,0,0,0.1); border-radius: 4px; padding: 2px 5px; margin-bottom: 5px; display: flex; align-items: center; gap: 4px;">
                            <i class="fa fa-shield" style="font-size: 10px; color: white;"></i>
                            <span style="font-size: 9px; color: white; font-weight: bold;">معايير الأمان مطبقة</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; color: white;">
                            <span>الأرضي (Flat):</span>
                            <span style="font-weight: bold;">${capFlat > 0 ? capFlat + ' سيارة' : '---'}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; color: white;">
                            <span>المائل (Racking):</span>
                            <span style="font-weight: bold;">${capRack > 0 ? capRack + ' سيارة' : '---'}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; color: white;">
                            <span>فولاذي (Steel):</span>
                            <span style="font-weight: bold;">${capSteel > 0 ? capSteel + ' سيارة' : '---'}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; color: white;">
                            <span>منصات (Cassette):</span>
                            <span style="font-weight: bold;">${capCassette > 0 ? capCassette + ' سيارة' : '---'}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; color: white;">
                            <span>الخشبي (Timber):</span>
                            <span style="font-weight: bold;">${capTimber > 0 ? capTimber.toLocaleString('en-US') + ' سيارة' : '---'}</span>
                        </div>
                        ${capFlat === 0 && length > 0 ? '<div style="color: #ff6b6b; font-size: 10px; margin-top: 2px; font-weight: bold;">تنبيه: الأبعاد مع هوامش الأمان تتجاوز السعة</div>' : ''}
                    </div>` : '';

                const isOverweight = c.maxWeightKg !== null && totalOrderWeight > c.maxWeightKg;

                const weightNoteHtml = c.weightNote && !isOverweight ? `
                    <div style="margin-top: 6px; padding: 5px 8px; background: rgba(255,220,0,0.2); border-radius: 5px; border: 1px solid rgba(255,220,0,0.4); display: flex; align-items: center; gap: 5px;">
                        <i class="fa fa-exclamation-triangle" style="font-size: 11px; color: #ffe066;"></i>
                        <span style="font-size: 11px; color: #ffe066;">${c.weightNote}</span>
                    </div>` : '';

                const overweightHtml = isOverweight ? `
                    <div style="margin-top: 6px; padding: 6px 10px; background: rgba(255,193,7,0.25); border-radius: 5px; border: 1px solid rgba(255,193,7,0.6); display: flex; align-items: center; gap: 6px;">
                        <i class="fa fa-exclamation-triangle" style="font-size: 13px; color: #ffc107;"></i>
                        <span style="font-size: 11px; color: #ffc107; font-weight: bold;">تنبيه: تجاوز الوزن القياسي! (${(totalOrderWeight/1000).toLocaleString('en-US', {maximumFractionDigits: 1})} طن)</span>
                    </div>` : '';

                const meta = {
                    label: c.label,
                    factor: c.factor,
                    dims: { l: c.intL, w: c.intW, h: c.intH },
                    weightNote: c.weightNote,
                    maxWeightKg: c.maxWeightKg,
                    numContainers: displayMainValue,
                    totalPcs: totalOrderPcs,
                    totalWeight: totalOrderWeight,
                    totalPrice: totalOrderPrice,
                    currency: currency,
                    margins: {
                        flat: capFlat,
                        rack: capRack,
                        steel: capSteel,
                        cassette: capCassette,
                        timber: capTimber
                    }
                };

                widgets.eq(index).data('logistics-meta', JSON.stringify(meta));

                widgets.eq(index).html(`
                    <div style="display: flex; flex-direction: column; gap: 4px;">
                        <div style="display: flex; justify-content: space-between; border-bottom: 1px dashed rgba(255,255,255,0.3); padding-bottom: 4px; margin-bottom: 4px;">
                            <span>${displayMainLabel}</span>
                            <span style="font-weight: bold; font-size: 15px;">${displayMainValue}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <span>إجمالي القطع:</span>
                            <span style="font-weight: bold;">${totalOrderPcs.toLocaleString('en-US')}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <span>الوزن الكلي:</span>
                            <span style="font-weight: bold; color: ${isOverweight ? '#ff6b6b' : 'inherit'};">${totalOrderWeight.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})} kg</span>
                        </div>
                        ${capacityHtml}
                        <div style="display: flex; justify-content: space-between; margin-top: 4px; padding-top: 4px; border-top: 1px solid rgba(255,255,255,0.2);">
                            <span>السعر الإجمالي:</span>
                            <span style="font-weight: bold;">${totalOrderPrice.toLocaleString('en-US')} ${currency}</span>
                        </div>
                        ${weightNoteHtml}
                        ${overweightHtml}
                    </div>
                `);

                widgets.eq(index).closest('div[style*="background"]').css(
                    'background', isOverweight ? 'linear-gradient(135deg, #f39c12, #e67e22)' : '#007bff'
                );
            });

            // Update Specialized Containers Section
            $('.spec-container-card').each(function() {
                const card = $(this);
                const resultsDiv = card.find('.spec-capacity-result');
                
                // Read specs
                const L_c = parseFloat(card.data('l')) || 0;
                const W_c = parseFloat(card.data('w')) || 0;
                const H_c = parseFloat(card.data('h')) || 0;
                const cFactor = parseFloat(card.data('cbm')) || 1; // Correct CBM factor
                const hasRoof = card.data('roof') !== false;
                const hasWalls = card.data('walls') !== false;
                const isRoRo = card.data('roro') === true;

                if (isRoRo) {
                    resultsDiv.html(`
                        <div style="display: flex; flex-direction: column; gap: 4px;">
                             <div style="display: flex; justify-content: space-between; border-bottom: 1px dashed rgba(255,255,255,0.3); padding-bottom: 4px; margin-bottom: 4px;">
                                <span>حالة الشحن:</span>
                                <span style="font-weight: bold; font-size: 13px;">مباشر (RoRo)</span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span>إجمالي القطع:</span>
                                <span style="font-weight: bold;">${totalOrderPcs.toLocaleString('en-US')}</span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span>الوزن الكلي:</span>
                                <span style="font-weight: bold;">${totalOrderWeight.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})} kg</span>
                            </div>
                            <div style="margin-top: 4px; padding: 5px; background: rgba(0,0,0,0.1); border-radius: 4px; font-size: 10px; line-height: 1.3;">
                                يُسمح بشحن المركبات بالقيادة المباشرة لسطح السفينة. لا قيود أبعاد.
                            </div>
                        </div>
                    `);
                    return;
                }

                const BUMPER_GAP = 0.25;
                const WALL_GAP = 0.10;
                const ROOF_GAP = 0.15;

                let fitsW = true;
                if (hasWalls) fitsW = (width + (WALL_GAP * 2)) <= W_c;

                let fitsH = true;
                if (hasRoof) fitsH = (height + ROOF_GAP) <= H_c;

                let sCapFlat = 0, sCapRack = 0, sCapSteel = 0, sCapCassette = 0, sCapTimber = 0;

                if (length > 0) {
                    // We calculate even if it doesn't fit W/H to show the user the potential, 
                    // but we will show warnings in the UI.
                    sCapFlat = Math.floor((L_c + BUMPER_GAP) / (length + BUMPER_GAP));
                    sCapRack = Math.floor((L_c + BUMPER_GAP) / ((length * 0.72) + BUMPER_GAP));
                    sCapSteel = Math.floor((L_c + BUMPER_GAP) / ((length * 0.68) + BUMPER_GAP));
                    sCapCassette = Math.floor((L_c + BUMPER_GAP) / ((length * 0.62) + BUMPER_GAP));
                    sCapTimber = Math.floor((L_c + BUMPER_GAP) / ((length * 0.82) + BUMPER_GAP));

                    if (L_c > 11.5 && length <= 4.8) {
                        sCapRack = Math.max(sCapRack, 3);
                        sCapSteel = Math.max(sCapSteel, 4);
                        sCapCassette = Math.max(sCapCassette, 4);
                    }
                }

                const displayNumC = cFactor > 0 ? (effectiveCartonCbm / cFactor).toFixed(2) : '0.00';

                if (length > 0) {
                    const meta = {
                        name: card.data('name'),
                        factor: cFactor,
                        dims: { l: L_c, w: W_c, h: H_c },
                        numContainers: displayNumC,
                        totalPcs: totalOrderPcs,
                        totalWeight: totalOrderWeight,
                        totalPrice: totalOrderPrice,
                        currency: currency,
                        margins: {
                            flat: sCapFlat,
                            rack: sCapRack,
                            steel: sCapSteel,
                            cassette: sCapCassette,
                            timber: sCapTimber
                        }
                    };
                    card.data('logistics-meta', JSON.stringify(meta));

                    resultsDiv.html(`
                        <div style="display: flex; flex-direction: column; gap: 4px;">
                            <div style="background: rgba(0,0,0,0.1); border-radius: 4px; padding: 2px 5px; margin-bottom: 4px; display: flex; align-items: center; gap: 4px;">
                                <i class="fa fa-shield" style="font-size: 10px; color: white;"></i>
                                <span style="font-size: 9px; color: white; font-weight: bold;">معايير الأمان مطبقة</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; border-bottom: 1px dashed rgba(255,255,255,0.3); padding-bottom: 4px; margin-bottom: 4px; color: white;">
                                <span>الحاويات المطلوبة:</span>
                                <span style="font-weight: bold; font-size: 14px;">${displayNumC}</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; color: white;">
                                <span>إجمالي القطع:</span>
                                <span style="font-weight: bold;">${totalOrderPcs.toLocaleString('en-US')}</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; color: white;">
                                <span>الوزن الكلي:</span>
                                <span style="font-weight: bold;">${totalOrderWeight.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})} kg</span>
                            </div>
                            
                            <!-- Capacity Breakdown -->
                            <div style="margin-top: 5px; border-top: 1px solid rgba(255,255,255,0.15); padding-top: 5px; display: flex; flex-direction: column; gap: 2px; font-size: 11px;">
                                <div style="display: flex; justify-content: space-between; color: white;">
                                    <span>الأرضي (Flat):</span>
                                    <span style="font-weight: bold;" dir="ltr">${sCapFlat > 0 ? sCapFlat.toLocaleString('en-US') + ' سيارة' : '---'}</span>
                                </div>
                                <div style="display: flex; justify-content: space-between; color: white;">
                                    <span>المائل (Racking):</span>
                                    <span style="font-weight: bold;" dir="ltr">${sCapRack > 0 ? sCapRack.toLocaleString('en-US') + ' سيارة' : '---'}</span>
                                </div>
                                <div style="display: flex; justify-content: space-between; color: white;">
                                    <span>فولاذي (Steel):</span>
                                    <span style="font-weight: bold;" dir="ltr">${sCapSteel > 0 ? sCapSteel.toLocaleString('en-US') + ' سيارة' : '---'}</span>
                                </div>
                                <div style="display: flex; justify-content: space-between; color: white;">
                                    <span>منصات (Cassette):</span>
                                    <span style="font-weight: bold;" dir="ltr">${sCapCassette > 0 ? sCapCassette.toLocaleString('en-US') + ' سيارة' : '---'}</span>
                                </div>
                                <div style="display: flex; justify-content: space-between; color: white;">
                                    <span>الخشبي (Timber):</span>
                                    <span style="font-weight: bold;" dir="ltr">${sCapTimber > 0 ? sCapTimber.toLocaleString('en-US') + ' سيارة' : '---'}</span>
                                </div>
                            </div>

                            <div style="display: flex; justify-content: space-between; margin-top: 4px; padding-top: 4px; border-top: 1px solid rgba(255,255,255,0.2); color: white;">
                                <span>السعر الإجمالي:</span>
                                <span style="font-weight: bold;">${totalOrderPrice.toLocaleString('en-US')} ${currency}</span>
                            </div>
                            ${(!fitsH || !fitsW) ? '<div style="color: #ffcccc; font-size: 9px; margin-top: 3px; font-weight: bold; text-align: center; background: rgba(0,0,0,0.2); border-radius: 4px; padding: 2px;">تنبيه: الأبعاد تتجاوز الحدود الآمنة</div>' : ''}
                        </div>
                    `);
                } else {
                    resultsDiv.empty();
                    card.removeData('logistics-meta');
                }
            });

            $('#btnAddToList')
                .prop('disabled', false)
                .html('<i class="fa fa-plus-circle"></i> إضافة المنتج للقائمة')
                .css({ 'background': '' });
        } else {
            // Optional: don't clear everything aggressively
            $('.widget-cbm-calc').filter(':not(.spec-capacity-result)').html('');
        }
    }

    $('#name').on('input', function() { $('#table_product_name').val($(this).val()); });
    $('#table_product_name').on('input', function() { $('#name').val($(this).val()); });
    $('#sku_main').on('input', function() { $('#sku').val($(this).val()); });
    $('#sku').on('input', function() { $('#sku_main').val($(this).val()); });
    $('input.english-nums, .dimension-input').on('input change', calculateNewTable);

    $('.dimension-input').on('blur', function() {
        var val = parseFloat($(this).val());
        if (!isNaN(val)) {
            $(this).val(val.toFixed(2));
        }
    });

    // Edit Batch Product Logic
    var currentEditImages = [];
    
    window.openEditProductModal = function(id) {
        var product = productsBatch.find(p => p.id === id);
        if(!product) return;

        $('#edit_product_idx').val(id);
        $('#edit_sector_id').val(product.sector_id).trigger('change');
        $('#edit_name').val(product.name);
        $('#edit_sku').val(product.sku);
        $('#edit_price').val(product.price);
        $('#edit_currency_label').text(product.currency_code);
        $('#edit_piece_weight').val(product.piece_weight);
        $('#edit_product_piece_count').val(product.product_piece_count);
        $('#edit_carton_length').val(product.carton_length);
        $('#edit_carton_width').val(product.carton_width);
        $('#edit_carton_height').val(product.carton_height);
        $('#edit_description').val(product.description.replace(/(<([^>]+)>)/ig, "")); // Simple text for modal textarea
        
        currentEditImages = JSON.parse(JSON.stringify(product.images)); // Clone
        renderEditImages();

        // Handle dependent dropdowns for edit modal
        setTimeout(function() {
            $('#edit_branch_id').val(product.branch_id).trigger('change');
            setTimeout(function() {
                $('#edit_category_id').val(product.category_id).trigger('change');
            }, 300);
        }, 300);

        $('#editProductModal').modal('show');
    };

    $('#edit_sector_id').on('change', function() {
        var sid = $(this).val();
        $('#edit_branch_id').empty().append('<option value="">اختر الفرع</option>').prop('disabled', true);
        if(sid) {
            $.ajax({
                url: '/api/branches/' + sid,
                type: 'GET',
                success: function(data) {
                    $('#edit_branch_id').prop('disabled', false);
                    $.each(data, function(k, v) {
                        $('#edit_branch_id').append('<option value="' + v.id + '">' + v.name_ar + '</option>');
                    });
                }
            });
        }
    });

    $('#edit_branch_id').on('change', function() {
        var bid = $(this).val();
        $('#edit_category_id').empty().append('<option value="">اختر القسم</option>').prop('disabled', true);
        if(bid) {
            $.ajax({
                url: '/api/categories/' + bid,
                type: 'GET',
                success: function(data) {
                    $('#edit_category_id').prop('disabled', false);
                    $.each(data, function(k, v) {
                        $('#edit_category_id').append('<option value="' + v.id + '">' + v.name_ar + '</option>');
                    });
                }
            });
        }
    });

    function renderEditImages() {
        var container = $('#edit_images_preview');
        container.empty();
        currentEditImages.forEach(function(img, idx) {
            container.append(`
                <div class="col-md-3" style="position: relative; margin-bottom: 15px;">
                    <img src="${img.dataURL}" class="img-responsive img-thumbnail" style="height: 80px; width: 100%; object-fit: cover;">
                    <button type="button" class="btn btn-xs btn-danger" style="position: absolute; top: 0; right: 15px; border-radius: 0 0 0 8px;" onclick="removeEditImage(${idx})">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
            `);
        });
    }

    window.removeEditImage = function(idx) {
        currentEditImages.splice(idx, 1);
        renderEditImages();
    };

    $('#edit_new_images').on('change', function() {
        var files = Array.from($(this)[0].files);
        files.forEach(function(file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                currentEditImages.push({
                    name: file.name,
                    dataURL: e.target.result
                });
                renderEditImages();
            }
            reader.readAsDataURL(file);
        });
        $(this).val('');
    });

    window.saveBatchProductEdit = function() {
        var id = parseInt($('#edit_product_idx').val());
        var idx = productsBatch.findIndex(p => p.id === id);
        if(idx === -1) return;

        var length = parseFloat($('#edit_carton_length').val()) || 0;
        var width = parseFloat($('#edit_carton_width').val()) || 0;
        var height = parseFloat($('#edit_carton_height').val()) || 0;
        var qty = parseFloat($('#edit_product_piece_count').val()) || 0;
        var unitWeight = parseFloat($('#edit_piece_weight').val()) || 0;
        
        var unitCbm = (length * width * height);
        var cartonCbm = unitCbm * qty;
        var cartonTotalWeight = unitWeight * qty;

        productsBatch[idx] = {
            ...productsBatch[idx],
            sector_id: $('#edit_sector_id').val(),
            branch_id: $('#edit_branch_id').val(),
            category_id: $('#edit_category_id').val(),
            sector_name: $('#edit_sector_id option:selected').text(),
            branch_name: $('#edit_branch_id option:selected').text(),
            category_name: $('#edit_category_id option:selected').text(),
            name: $('#edit_name').val(),
            sku: $('#edit_sku').val(),
            price: $('#edit_price').val(),
            piece_weight: $('#edit_piece_weight').val(),
            product_piece_count: $('#edit_product_piece_count').val(),
            carton_length: $('#edit_carton_length').val(),
            carton_width: $('#edit_carton_width').val(),
            carton_height: $('#edit_carton_height').val(),
            carton_volume_cbm: unitCbm.toFixed(6),
            total_cbm: cartonCbm.toFixed(6),
            total_weight: cartonTotalWeight.toFixed(2),
            description: $('#edit_description').val(),
            images: currentEditImages
        };

        renderBatchTable();
        $('#editProductModal').modal('hide');
    };

    $('.dimension-input-edit').on('blur', function() {
        var val = parseFloat($(this).val());
        if (!isNaN(val)) $(this).val(val.toFixed(2));
    });
    $('#btnSaveAll').on('click', async function() {
        if(productsBatch.length === 0) return;
        
        var btn = $(this);
        var originalText = btn.html();
        btn.html('<i class="fa fa-spinner fa-spin"></i> جاري الحفظ والرفع (' + productsBatch.length + ' منتج)... يرجى الانتظار').prop('disabled', true);
        
        var successCount = 0;
        var token = $('input[name="_token"]').first().val();
        
        for (var i = 0; i < productsBatch.length; i++) {
            var p = productsBatch[i];
            var formData = new FormData();
            
            formData.append('_token', token);
            formData.append('sector_id', p.sector_id);
            formData.append('branch_id', p.branch_id);
            formData.append('category_id', p.category_id);
            formData.append('name', p.name);
            formData.append('sku', p.sku);
            formData.append('price', p.price);
            formData.append('currency_code', p.currency_code);
            formData.append('min_order_quantity', p.min_order_quantity);
            formData.append('piece_weight', p.piece_weight);
            formData.append('product_piece_count', p.product_piece_count);
            formData.append('carton_length', p.carton_length);
            formData.append('carton_width', p.carton_width);
            formData.append('carton_height', p.carton_height);
            formData.append('carton_volume_cbm', p.carton_volume_cbm);
            formData.append('description', p.description);
            formData.append('custom_info', p.custom_info);
            formData.append('product_catalog', p.product_catalog);

            // Container Data for Vehicles
            if (p.upload_mode === 'special') {
                formData.append('cap_20ft', p.logistics.cap_20ft);
                formData.append('cap_40ft', p.logistics.cap_40ft);
                formData.append('cap_40hq', p.logistics.cap_40hq);
                formData.append('cap_45ft', p.logistics.cap_45ft);
                formData.append('unit_cbm', p.carton_volume_cbm);
                formData.append('total_cbm', p.total_cbm);
                formData.append('total_weight', p.total_weight);
                
                // Store all specialized values as JSON
                var combinedLogistics = {
                    ...p.logistics,
                    light_margin_details: p.light_logistics,
                    heavy_margin_details: p.heavy_logistics,
                    vehicle_info: p.vehicle_info, // Include technical data
                    vehicle_group: p.vehicle_group
                };
                formData.append('logistics_details', JSON.stringify(combinedLogistics));
            }
            
            p.images.forEach(function(imgData) {
                var arr = imgData.dataURL.split(','),
                    mime = arr[0].match(/:(.*?);/)[1],
                    bstr = atob(arr[1]), 
                    n = bstr.length, 
                    u8arr = new Uint8Array(n);
                while(n--){ u8arr[n] = bstr.charCodeAt(n); }
                var blob = new Blob([u8arr], {type: mime});
                formData.append('images[]', blob, imgData.name);
            });

            try {
                var targetUrl = (p.upload_mode === 'special') ? '{{ route("products.store-vehicle") }}' : '{{ route("products.store") }}';
                var res = await fetch(targetUrl, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': token
                    }
                });
                
                var data = await res.json();
                
                if(res.ok && data.success) { 
                    successCount++; 
                } else {
                    var errorMsg = 'خطأ في المنتج رقم ' + (i+1) + ': ' + (p.name || '');
                    if (data.errors) {
                        var details = Object.values(data.errors).flat().join('\n- ');
                        errorMsg += '\n\nالأخطاء:\n- ' + details;
                    } else if (data.message) {
                        errorMsg += '\n\n' + data.message;
                    }
                    alert(errorMsg);
                    console.error('Save Error:', data);
                }
            } catch (err) { 
                console.error('Network Error:', err);
                alert('خطأ في الاتصال بالخادم عند حفظ المنتج رقم ' + (i+1));
            }
        }
        
        if(successCount === productsBatch.length) {
            alert('تم حفظ ' + successCount + ' منتج بنجاح!');
            window.location.href = '{{ route("products.index") }}';
        } else {
            alert('اكتملت العملية: تم حفظ ' + successCount + ' من أصل ' + productsBatch.length + ' منتجات.\nيرجى مراجعة الأخطاء المذكورة أعلاه.');
            btn.html(originalText).prop('disabled', false);
            
            // Optional: remove already saved products from batch
            // if (successCount > 0) { ... }
        }
    });

</script>
@endpush
