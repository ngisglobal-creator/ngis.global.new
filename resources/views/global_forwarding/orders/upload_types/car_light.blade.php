@extends('layouts.master')

@section('title', 'رفع بيانات المركبة (خفيفة) - الطلب #' . $order->id)

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
        رفع بيانات المركبات الخفيفة
        <small>الطلب المتخصص #{{ $order->id }}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('global_forwarding.dashboard') }}"><i class="fa fa-dashboard"></i> لوحة التحكم</a></li>
        <li><a href="{{ route('global_forwarding.orders.custom') }}">الطلبات المتخصصة</a></li>
        <li><a href="{{ route('global_forwarding.orders.custom.show', $order->id) }}">تفاصيل الطلب #{{ $order->id }}</a></li>
        <li class="active">مركبات خفيفة</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary" style="border-radius: 15px; overflow: hidden; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
                
                <div id="full_page_content" style="padding: 20px;">
                    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" id="productForm">
                        @csrf
                        <input type="hidden" name="custom_order_id" value="{{ $order->id }}">
                    
                    <!-- Section 1: General Information -->
                    <div class="box box-solid box-default" style="border-radius: 12px; border: 1px solid #ddd; box-shadow: 0 4px 15px rgba(0,0,0,0.05); margin-bottom: 25px;">
                        <div class="box-header with-border" style="background: #fcfcfc; border-radius: 12px 12px 0 0;">
                            <h3 class="box-title" style="font-weight: bold; color: #333;"><i class="fa fa-info-circle text-primary"></i> المعلومات الأساسية</h3>
                        </div>
                        <div class="box-body" style="padding: 25px;">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label style="font-weight: 600;">القطاع</label>
                                        <select name="sector_id" id="sector_id" class="form-control select2" required>
                                            <option value="">اختر القطاع</option>
                                            @foreach($sectors as $sector)
                                                <option value="{{ $sector->id }}">{{ $sector->name_ar }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label style="font-weight: 600;">الفرع</label>
                                        <select name="branch_id" id="branch_id" class="form-control select2" required disabled>
                                            <option value="">اختر الفرع</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label style="font-weight: 600;">القسم</label>
                                        <select name="category_id" id="category_id" class="form-control select2" required disabled>
                                            <option value="">اختر القسم</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="margin-top: 15px;">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label style="font-weight: 600;">اسم السيارة</label>
                                        <input type="text" name="name" id="name" class="form-control" placeholder="أدخل اسم السيارة بدقة" required style="height: 45px; font-size: 16px;">
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
                    <div class="box box-solid box-default" style="border-radius: 12px; border: 1px solid #ddd; box-shadow: 0 4px 15px rgba(0,0,0,0.05); margin-bottom: 25px;">
                        <div class="box-header with-border" style="background: #fcfcfc;">
                            <h3 class="box-title" style="font-weight: bold; color: #333;"><i class="fa fa-car text-blue"></i> المعلومات الأساسية للمركبة</h3>
                        </div>
                        <div class="box-body" style="padding: 25px;">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label style="font-weight: 600;">الشركة المصنعة</label>
                                        <input type="text" name="car_manufacturer" class="form-control" placeholder="مثال: تويوتا">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label style="font-weight: 600;">الموديل</label>
                                        <input type="text" name="car_model" class="form-control" placeholder="مثال: كامري">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label style="font-weight: 600;">سنة الصنع</label>
                                        <input type="number" name="car_year" class="form-control" placeholder="2024">
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="margin-top: 15px;">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label style="font-weight: 600;">نوع المركبة</label>
                                        <select name="car_type" class="form-control select2">
                                            <option value="car">سيارة</option>
                                            <option value="truck">شاحنة</option>
                                            <option value="bus">حافلة</option>
                                            <option value="bike">دراجة</option>
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

                    <!-- Technical Specifications -->
                    <div class="box box-solid box-default" style="border-radius: 12px; border: 1px solid #ddd; box-shadow: 0 4px 15px rgba(0,0,0,0.05); margin-bottom: 25px;">
                        <div class="box-header with-border" style="background: #fcfcfc;">
                            <h3 class="box-title" style="font-weight: bold; color: #333;"><i class="fa fa-cogs text-grey"></i> المواصفات الفنية</h3>
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
                        </div>
                    </div>

                    <!-- Pricing & Details -->
                    <div class="box box-solid box-default" style="border-radius: 12px; border: 1px solid #ddd; box-shadow: 0 4px 15px rgba(0,0,0,0.05); margin-bottom: 25px;">
                        <div class="box-header with-border" style="background: #fcfcfc;">
                            <h3 class="box-title" style="font-weight: bold; color: #333;"><i class="fa fa-money text-success"></i> السعر وتفاصيل الأبعاد</h3>
                        </div>
                        <div class="box-body" style="padding: 20px;">
                            <input type="hidden" name="upload_mode" id="upload_mode" value="special">

                            <div id="vehicle_details_table_wrapper" style="width: 100%;">
                                <div class="table-responsive">
                                    <table class="table table-bordered text-center" style="margin-bottom: 0; min-width: 1000px;">
                                    <thead style="background: #f9f9f9; font-weight: bold;">
                                        <tr>
                                            <th style="width: 150px;">اسم السيارة</th>
                                            <th style="width: 100px;">ID المنتج</th>
                                            <th style="width: 120px;">سعر الوحدة</th>
                                            <th style="width: 100px;">وزن الوحدة (kg)</th>
                                            <th style="width: 90px;">طول السيارة (m)</th>
                                            <th style="width: 90px;">عرض السيارة (m)</th>
                                            <th style="width: 90px;">ارتفاع السيارة (m)</th>
                                            <th style="width: 100px; background: #fff9e6;">CBM الوحدة</th>
                                            <th style="width: 120px;">الكمية</th>
                                            <th style="width: 100px; background: #fff9e6;">إجمالي CBM</th>
                                            <th style="width: 100px; background: #fff9e6;">إجمالي الوزن (kg)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><input type="text" id="table_product_name" class="form-control" placeholder="اسم المنتج" style="border: none; text-align: center; border-bottom: 1px solid #ddd;"></td>
                                            <td><input type="text" id="sku" class="form-control" placeholder="ID" style="border: none; text-align: center; border-bottom: 1px solid #ddd;"></td>
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
                                            <td><input type="text" id="piece_weight" class="form-control english-nums" placeholder="1500" oninput="this.value=toWesternNums(this.value)" style="border: none; text-align: center; border-bottom: 1px solid #ddd;"></td>
                                            <td><input type="number" id="carton_length" step="0.1" class="form-control english-nums dimension-input" placeholder="4.5" style="border: none; text-align: center; border-bottom: 1px solid #ddd;"></td>
                                            <td><input type="number" id="carton_width" step="0.1" class="form-control english-nums dimension-input" placeholder="1.8" style="border: none; text-align: center; border-bottom: 1px solid #ddd;"></td>
                                            <td><input type="number" id="carton_height" step="0.1" class="form-control english-nums dimension-input" placeholder="1.5" style="border: none; text-align: center; border-bottom: 1px solid #ddd;"></td>
                                            <td style="background: #fff9e6;"><input type="text" id="carton_volume_cbm" class="form-control english-nums" readonly style="background: transparent; border: none; text-align: center; font-weight: bold; color: #b8860b;"></td>
                                            <td><input type="text" id="product_piece_count" class="form-control english-nums" placeholder="1" oninput="this.value=toWesternNums(this.value)" style="border: none; text-align: center; border-bottom: 1px solid #ddd;"></td>
                                            <td style="background: #fff9e6;"><input type="text" id="total_cbm" class="form-control english-nums" readonly style="background: transparent; border: none; text-align: center; font-weight: bold; color: #b8860b;"></td>
                                            <td style="background: #fff9e6;"><input type="text" id="total_weight" class="form-control english-nums" readonly style="background: transparent; border: none; text-align: center; font-weight: bold; color: #b8860b;"></td>
                                        </tr>
                                    </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Logistics Widgets -->
                            <div id="light_vehicles_wrapper" style="width: 100%; margin-top: 25px;">
                                <div class="row" style="display: flex; flex-wrap: wrap; justify-content: space-between; gap: 10px; padding: 0 15px;">
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
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section: Media -->
                    <div class="box box-solid box-default" style="border-radius: 12px; border: 1px solid #ddd; box-shadow: 0 4px 15px rgba(0,0,0,0.05); margin-bottom: 25px;">
                        <div class="box-header with-border" style="background: #fcfcfc;">
                            <h3 class="box-title" style="font-weight: bold; color: #333;"><i class="fa fa-camera text-danger"></i> صور وفيديوهات المركبة</h3>
                        </div>
                        <div class="box-body" style="padding: 25px;">
                            <div class="upload-zone" style="border: 2px dashed #ccc; border-radius: 12px; padding: 40px; text-align: center; background: #fafafa; cursor: pointer;" onclick="document.getElementById('product_images').click()">
                                <i class="fa fa-cloud-upload" style="font-size: 48px; color: #bbb;"></i>
                                <h4 style="color: #666; font-weight: 600;">اضغط هنا لرفع صور المركبة</h4>
                                <input type="file" name="images[]" id="product_images" class="hidden" multiple required accept="image/*">
                            </div>
                            <div id="image_preview" class="row" style="margin-top: 20px;"></div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="box box-solid box-default" style="border-radius: 12px; border: 1px solid #ddd; box-shadow: 0 4px 15px rgba(0,0,0,0.05); margin-bottom: 25px;">
                        <div class="box-header with-border" style="background: #fcfcfc;">
                            <h3 class="box-title" style="font-weight: bold; color: #333;"><i class="fa fa-file-text-o text-warning"></i> وصف المركبة وتفاصيل إضافية</h3>
                        </div>
                        <div class="box-body" style="padding: 25px;">
                            <textarea name="description" id="editor" class="form-control" rows="6"></textarea>
                        </div>
                    </div>

                    <div style="text-align: center; margin-bottom: 50px;">
                        <button type="button" id="btnAddToList" class="btn btn-warning" style="width: 300px; height: 55px; border-radius: 30px; font-size: 20px; font-weight: bold; box-shadow: 0 10px 20px rgba(243, 156, 18, 0.3);">
                            <i class="fa fa-plus-circle"></i> إضافة المركبة للقائمة
                        </button>
                    </div>
                </form>

                <!-- Batch Table -->
                <div class="row" id="batch_section" style="display: none; margin-top: 30px;">
                    <div class="col-md-12">
                        <div class="box box-solid" style="border: 2px solid #3c8dbc; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.1); margin-bottom: 25px;">
                            <div class="box-header with-border" style="background: #eef7ff;">
                                <h3 class="box-title" style="font-weight: bold; color: #3c8dbc;"><i class="fa fa-list"></i> قائمة المركبات المضافة</h3>
                            </div>
                            <div class="box-body no-padding">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped text-center" id="batch_table" style="margin-bottom: 0;">
                                        <thead style="background: #3c8dbc; color: white;">
                                            <tr>
                                                <th>الصورة</th>
                                                <th>اسم المركبة</th>
                                                <th>SKU</th>
                                                <th>السعر</th>
                                                <th>الوزن</th>
                                                <th>تفاصيل الحاويات</th>
                                                <th>الكمية</th>
                                                <th>إجمالي CBM</th>
                                                <th>إجراء</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="box-footer text-center" style="padding: 20px;">
                                <button type="button" class="btn btn-success btn-lg" id="btnSaveAll" style="border-radius: 30px; padding: 10px 50px;">
                                    <i class="fa fa-check-circle"></i> حفظ جميع البيانات وإرسالها
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modals & CSS/Scripts same as factory template but adapted -->
@include('global_forwarding.orders.upload_types.partials.car_modals')

@endsection

@push('css')
<style>
    .upload-zone:hover { border-color: #3c8dbc !important; background: #f0f7ff !important; }
    .batch-img { width: 55px; height: 55px; border-radius: 8px; object-fit: cover; }
    .cbm-badge { background: #f0f7ff; color: #3c8dbc; padding: 4px 8px; border-radius: 6px; font-weight: bold; }
</style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.2/tinymce.min.js"></script>
<script>
    var productsBatch = [];
    var initialSelectedImagesData = [];

    $(document).ready(function() {
        $('.select2').select2({ dir: "rtl", width: '100%' });
        tinymce.init({ selector: '#editor', height: 250, language: 'ar', directionality: 'rtl' });

        $('#sector_id').on('change', function() {
            var sectorId = $(this).val();
            $('#branch_id').empty().append('<option value="">اختر الفرع</option>').prop('disabled', true);
            $('#category_id').empty().append('<option value="">اختر القسم</option>').prop('disabled', true);
            if (sectorId) {
                $.get('/api/branches/' + sectorId, function(data) {
                    $('#branch_id').prop('disabled', false);
                    $.each(data, function(k, v) { $('#branch_id').append('<option value="'+v.id+'">'+v.name_ar+'</option>'); });
                });
            }
        });

        $('#branch_id').on('change', function() {
            var branchId = $(this).val();
            $('#category_id').empty().append('<option value="">اختر القسم</option>').prop('disabled', true);
            if (branchId) {
                $.get('/api/categories/' + branchId, function(data) {
                    $('#category_id').prop('disabled', false);
                    $.each(data, function(k, v) { $('#category_id').append('<option value="'+v.id+'">'+v.name_ar+'</option>'); });
                });
            }
        });

        $('#product_images').on('change', function() {
            $('#image_preview').empty();
            var files = Array.from($(this)[0].files);
            files.forEach(file => {
                var reader = new FileReader();
                reader.onload = e => {
                    $('#image_preview').append('<div class="col-md-2"><img src="'+e.target.result+'" class="img-responsive img-thumbnail"></div>');
                    initialSelectedImagesData.push({ name: file.name, dataURL: e.target.result });
                };
                reader.readAsDataURL(file);
            });
        });

        function calculateNewTable() {
            var l = parseFloat($('#carton_length').val()) || 0,
                w = parseFloat($('#carton_width').val()) || 0,
                h = parseFloat($('#carton_height').val()) || 0,
                qty = parseFloat($('#product_piece_count').val()) || 0,
                weight = parseFloat($('#piece_weight').val()) || 0,
                price = parseFloat($('#price').val()) || 0;

            var unitCbm = l * w * h;
            $('#carton_volume_cbm').val(unitCbm.toFixed(4));
            var totalCbm = unitCbm * qty;
            $('#total_cbm').val(totalCbm.toFixed(4));
            $('#total_weight').val((weight * qty).toFixed(2));

            if (l > 0 && w > 0 && h > 0) {
                updateLogisticsWidgets(l, w, h, totalCbm, qty, weight, price);
            }
        }

        function updateLogisticsWidgets(l, w, h, totalCbm, qty, weight, price) {
            const containers = [
                { label: 'item CBM', factor: totalCbm || (l*w*h) },
                { label: '20ft', factor: 28, L: 5.90, W: 2.35, H: 2.39 },
                { label: '40ft', factor: 58, L: 12.03, W: 2.35, H: 2.39 },
                { label: '40HQ', factor: 68, L: 12.03, W: 2.35, H: 2.69 }
            ];

            const BUMPER = 0.25, WALL = 0.10, ROOF = 0.15;

            containers.forEach((c, idx) => {
                let mainVal = idx === 0 ? c.factor.toFixed(4) : (totalCbm / c.factor).toFixed(2);
                let capHtml = '';
                if (idx > 0) {
                    let capFlat = 0, capRack = 0;
                    if ((w + WALL*2) <= c.W && (h + ROOF) <= c.H) {
                        capFlat = Math.floor((c.L + BUMPER) / (l + BUMPER));
                        capRack = Math.floor((c.L + BUMPER) / ((l*0.72) + BUMPER));
                    }
                    capHtml = `<div style="font-size:10px; margin-top:5px; border-top:1px solid rgba(255,255,255,0.2);">
                        أرضي: ${capFlat} | مائل: ${capRack}
                    </div>`;
                }

                $('.widget-cbm-calc').eq(idx).html(`
                    <div style="display:flex; justify-content:space-between; font-weight:bold;">
                        <span>${idx === 0 ? 'الحجم:' : 'الحاويات:'}</span>
                        <span>${mainVal}</span>
                    </div>
                    ${capHtml}
                `);
            });
        }

        $('input, select').on('input change', calculateNewTable);

        $('#btnAddToList').on('click', function() {
            var p = {
                id: Date.now(),
                name: $('#table_product_name').val() || $('#name').val(),
                sku: $('#sku').val() || $('#sku_main').val(),
                price: $('#price').val(),
                currency_code: $('#currency_code').val(),
                piece_weight: $('#piece_weight').val(),
                product_piece_count: $('#product_piece_count').val(),
                total_cbm: $('#total_cbm').val(),
                images: [...initialSelectedImagesData],
                sector_id: $('#sector_id').val(),
                branch_id: $('#branch_id').val(),
                category_id: $('#category_id').val(),
                description: tinymce.get('editor').getContent()
            };
            if (!p.name || !p.sector_id) { alert('يرجى إكمال البيانات الأساسية'); return; }
            productsBatch.push(p);
            renderTable();
            // Reset
            $('#productForm')[0].reset();
            $('#image_preview').empty();
            initialSelectedImagesData = [];
            tinymce.get('editor').setContent('');
        });

        function renderTable() {
            var b = $('#batch_table tbody').empty();
            productsBatch.forEach(p => {
                b.append(`<tr>
                    <td><img src="${p.images[0]?.dataURL}" class="batch-img"></td>
                    <td>${p.name}</td>
                    <td>${p.sku}</td>
                    <td>${p.price} ${p.currency_code}</td>
                    <td>${p.piece_weight} kg</td>
                    <td><button type="button" class="btn btn-xs btn-info">عرض</button></td>
                    <td>${p.product_piece_count}</td>
                    <td><span class="cbm-badge">${p.total_cbm}</span></td>
                    <td><button type="button" class="btn btn-xs btn-danger" onclick="removeP(${p.id})">حذف</button></td>
                </tr>`);
            });
            $('#batch_section').toggle(productsBatch.length > 0);
        }

        window.removeP = id => { productsBatch = productsBatch.filter(x => x.id !== id); renderTable(); };

        $('#btnSaveAll').on('click', async function() {
            $(this).prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> جاري الحفظ...');
            for (let p of productsBatch) {
                let fd = new FormData();
                fd.append('_token', '{{ csrf_token() }}');
                fd.append('custom_order_id', '{{ $order->id }}');
                fd.append('name', p.name);
                fd.append('sku_main', p.sku);
                fd.append('price', p.price);
                fd.append('currency_code', p.currency_code);
                fd.append('piece_weight', p.piece_weight);
                fd.append('product_piece_count', p.product_piece_count);
                fd.append('min_order_quantity', 1);
                fd.append('sector_id', p.sector_id);
                fd.append('branch_id', p.branch_id);
                fd.append('category_id', p.category_id);
                fd.append('description', p.description);
                fd.append('upload_mode', 'special');
                
                // Convert dataURL to Blob for images
                for (let img of p.images) {
                    let res = await fetch(img.dataURL);
                    let blob = await res.blob();
                    fd.append('images[]', blob, img.name);
                }

                let resp = await fetch("{{ route('products.store') }}", { method: 'POST', body: fd, headers: { 'X-Requested-With': 'XMLHttpRequest' } });
                if(!resp.ok) {
                    let errData = await resp.json();
                    throw new Error(errData.message || 'خطأ في حفظ البيانات');
                }
            } catch(e) {
                alert(e.message);
                $(this).prop('disabled', false).html('<i class="fa fa-check-circle"></i> حفظ جميع البيانات وإرسالها');
                return;
            }
        }
        alert('تم حفظ جميع المنتجات بنجاح');
        window.location.href = "{{ route('global_forwarding.orders.matched_products') }}";
        });
    });
</script>
@endpush
