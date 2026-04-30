@extends('layouts.master')

@section('title', 'رفع منتجات (خاصة) - مطابقة الطلب #' . $order->id)

@section('content')
<section class="content-header">
    <h1>
        رفع منتجات (خاصة)
        <small>مطابقة الطلب الخاص #{{ $order->id }}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('global_forwarding.dashboard') }}"><i class="fa fa-dashboard"></i> الرئيسية</a></li>
        <li><a href="{{ route('global_forwarding.orders.custom') }}">الطلبات الخاصة</a></li>
        <li><a href="{{ route('global_forwarding.orders.custom.show', $order->id) }}">طلب #{{ $order->id }}</a></li>
        <li><a href="{{ route('global_forwarding.orders.custom.upload_match', $order->id) }}">المطابقة</a></li>
        <li class="active">رفع منتج خاص</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div style="text-align: left; margin-bottom: 20px;" class="no-print">
                <a href="{{ route('global_forwarding.orders.custom.upload_match', $order->id) }}" class="btn btn-default" style="border-radius: 20px; font-weight: bold; border: 2px solid #ddd; transition: all 0.3s; padding: 8px 25px;">
                    <i class="fa fa-undo"></i> عودة لخيارات المطابقة
                </a>
            </div>

            <div class="box box-primary" style="border-radius: 15px; overflow: hidden; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
                <div id="full_page_content" style="padding: 20px;">
                    <h2 id="page_mode_title" style="margin-top: 0; margin-bottom: 25px; font-weight: bold; color: #333;">
                        <i class="fa fa-star text-warning"></i> رفع منتجات خاصة (Special Mode)
                    </h2>
                    
                    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" id="productForm">
                        @csrf
                        <input type="hidden" name="custom_order_id" value="{{ $order->id }}">
                        <input type="hidden" name="upload_mode" id="upload_mode" value="special">

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
                                            <button type="button" class="btn btn-link pull-left" style="font-size: 13px; padding: 0;" data-toggle="modal" data-target="#sectorModal">
                                                <i class="fa fa-plus-circle"></i> إضافة قطاعات
                                            </button>
                                            <button type="button" class="btn btn-link pull-left" style="font-size: 13px; padding: 0 10px 0 0;" data-toggle="modal" data-target="#quickSectorModal">
                                                <i class="fa fa-magic"></i> اضافة قطاع جديد
                                            </button>
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
                                            <label style="font-weight: 600;">اسم المنتج</label>
                                            <input type="text" name="name" id="name" class="form-control" placeholder="أدخل اسم المنتج بدقة" required style="height: 45px; font-size: 16px;">
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

                        <!-- Section 2: Description -->
                        <div class="box box-solid box-default" style="border-radius: 12px; border: 1px solid #ddd; box-shadow: 0 4px 15px rgba(0,0,0,0.05); margin-bottom: 25px;">
                            <div class="box-header with-border" style="background: #fcfcfc;">
                                <h3 class="box-title" style="font-weight: bold; color: #333;"><i class="fa fa-file-text-o text-warning"></i> وصف المنتج</h3>
                            </div>
                            <div class="box-body" style="padding: 25px;">
                                <div class="form-group">
                                    <textarea name="description" id="editor" class="form-control" rows="6" placeholder="أدخل تفاصيل ومميزات المنتج هنا..."></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Section 3: Pricing & Details -->
                        <div class="box box-solid box-default" style="border-radius: 12px; border: 1px solid #ddd; box-shadow: 0 4px 15px rgba(0,0,0,0.05); margin-bottom: 25px;">
                            <div class="box-header with-border" style="background: #fcfcfc;">
                                <h3 class="box-title" style="font-weight: bold; color: #333;"><i class="fa fa-money text-success"></i> السعر وتفاصيل</h3>
                            </div>
                            <div class="box-body" style="padding: 20px;">
                                <div class="table-responsive">
                                    <table class="table table-bordered text-center" style="margin-bottom: 0; min-width: 1000px;">
                                        <thead style="background: #f9f9f9; font-weight: bold;">
                                            <tr>
                                                <th style="width: 150px;">اسم المنتج</th>
                                                <th style="width: 100px;">ID المنتج</th>
                                                <th style="width: 120px;" id="lbl_unit_price">سعر المنتج</th>
                                                <th style="width: 100px;" id="lbl_unit_weight">N.W.(KG)</th>
                                                <th style="width: 110px;" id="lbl_gross_weight">وزن المنتج G.W(KG)</th>
                                                <th style="width: 90px;" id="lbl_carton_length">طول (m)</th>
                                                <th style="width: 90px;" id="lbl_carton_width">عرض (m)</th>
                                                <th style="width: 90px;" id="lbl_carton_height">ارتفاع (m)</th>
                                                <th style="width: 100px; background: #fff9e6;" id="lbl_unit_cbm">حجم القطعة CBM</th>
                                                <th style="width: 120px;" id="lbl_units_per_carton">الكمية الإجمالية</th>
                                                <th style="width: 100px; background: #fff9e6;" id="lbl_carton_cbm">إجمالي CBM</th>
                                                <th style="width: 100px; background: #fff9e6;" id="lbl_carton_weight_col" style="display:none">وزن الإجمالي</th>
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
                                                <td id="col_gross_weight">
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
                                                <td style="background: #fff9e6; display:none">
                                                    <input type="text" id="total_weight" class="form-control english-nums" readonly style="background: transparent; border: none; text-align: center; font-weight: bold; color: #b8860b;">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                
                                <div class="row" style="margin-top: 20px;">
                                    <div class="col-md-6">
                                        <div class="alert alert-info" style="background: #f0f7ff !important; color: #3c8dbc !important; border: 1px dashed #3c8dbc;">
                                            <i class="fa fa-info-circle"></i> <strong>معادلة الحساب:</strong> يتم ضرب (الطول × العرض × الارتفاع) للحصول على حجم القطعة، ثم يضرب في الكمية للحصول على إجمالي CBM.
                                        </div>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <div style="padding: 10px; background: #f9f9f9; border-radius: 8px; border: 1px solid #eee;">
                                            <span style="font-weight: bold; color: #666;">تكلفة الحد الأدنى (MOQ):</span>
                                            <input type="text" id="min_order_quantity" class="form-control english-nums" placeholder="100" style="display: inline-block; width: 100px; height: 30px; margin-right: 10px;">
                                        </div>
                                    </div>
                                </div>

                                <!-- Container Stats Widgets -->
                                <div class="row" style="margin-top: 30px; display: flex; flex-wrap: wrap; justify-content: space-between; gap: 10px; padding: 0 15px;">
                                    <!-- CBM 1 -->
                                    <div style="flex: 1; min-width: 160px; background: #007bff; color: white; border-radius: 12px; padding: 15px; position: relative; box-shadow: 0 4px 15px rgba(0,123,255,0.2); border-bottom: 5px solid #0056b3;">
                                        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px;">
                                            <span style="font-weight: bold; font-size: 14px;">CBM 1</span>
                                            <i class="fa fa-cube" style="font-size: 18px; opacity: 0.8;"></i>
                                        </div>
                                        <div class="widget-cbm-calc" style="background: rgba(255,255,255,0.1); border-radius: 8px; padding: 8px; font-size: 12px;"></div>
                                    </div>
                                    <!-- 20FT -->
                                    <div style="flex: 1; min-width: 160px; background: #007bff; color: white; border-radius: 12px; padding: 15px; position: relative; box-shadow: 0 4px 15px rgba(0,123,255,0.2); border-bottom: 5px solid #0056b3;">
                                        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px;">
                                            <span style="font-weight: bold; font-size: 14px;">20FT (28 CBM)</span>
                                            <i class="fa fa-truck" style="font-size: 18px; opacity: 0.8;"></i>
                                        </div>
                                        <div class="widget-cbm-calc" style="background: rgba(255,255,255,0.1); border-radius: 8px; padding: 8px; font-size: 12px;"></div>
                                    </div>
                                    <!-- 40FT -->
                                    <div style="flex: 1; min-width: 160px; background: #007bff; color: white; border-radius: 12px; padding: 15px; position: relative; box-shadow: 0 4px 15px rgba(0,123,255,0.2); border-bottom: 5px solid #0056b3;">
                                        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px;">
                                            <span style="font-weight: bold; font-size: 14px;">40FT (40 CBM)</span>
                                            <i class="fa fa-truck" style="font-size: 18px; opacity: 0.8;"></i>
                                        </div>
                                        <div class="widget-cbm-calc" style="background: rgba(255,255,255,0.1); border-radius: 8px; padding: 8px; font-size: 12px;"></div>
                                    </div>
                                    <!-- 40HQ -->
                                    <div style="flex: 1; min-width: 160px; background: #007bff; color: white; border-radius: 12px; padding: 15px; position: relative; box-shadow: 0 4px 15px rgba(0,123,255,0.2); border-bottom: 5px solid #0056b3;">
                                        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px;">
                                            <span style="font-weight: bold; font-size: 14px;">40HQ (68 CBM)</span>
                                            <i class="fa fa-truck" style="font-size: 18px; opacity: 0.8;"></i>
                                        </div>
                                        <div class="widget-cbm-calc" style="background: rgba(255,255,255,0.1); border-radius: 8px; padding: 8px; font-size: 12px;"></div>
                                    </div>
                                    <!-- 45FT -->
                                    <div style="flex: 1; min-width: 160px; background: #007bff; color: white; border-radius: 12px; padding: 15px; position: relative; box-shadow: 0 4px 15px rgba(0,123,255,0.2); border-bottom: 5px solid #0056b3;">
                                        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px;">
                                            <span style="font-weight: bold; font-size: 14px;">45FT (78 CBM)</span>
                                            <i class="fa fa-truck" style="font-size: 18px; opacity: 0.8;"></i>
                                        </div>
                                        <div class="widget-cbm-calc" style="background: rgba(255,255,255,0.1); border-radius: 8px; padding: 8px; font-size: 12px;"></div>
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
                                <i class="fa fa-plus-circle"></i> إضافة المنتج للقائمة
                            </button>
                        </div>
                    </form>

                    <!-- Batch Products Table Section -->
                    <div class="row" id="batch_section" style="display: none; margin-top: 30px;">
                        <div class="col-md-12">
                            <div class="box box-solid" style="border: 2px solid #3c8dbc; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.1); margin-bottom: 25px;">
                                <div class="box-header with-border" style="background: #eef7ff;">
                                    <h3 class="box-title" style="font-weight: bold; color: #3c8dbc;"><i class="fa fa-list"></i> قائمة المنتجات المُضافة</h3>
                                </div>
                                <div class="box-body no-padding">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped text-center" id="batch_table" style="margin-bottom: 0; font-size: 14px;">
                                            <thead style="background: #3c8dbc; color: white;">
                                                <tr>
                                                    <th style="vertical-align: middle;">الصورة</th>
                                                    <th style="vertical-align: middle;">اسم المنتج</th>
                                                    <th style="vertical-align: middle;">SKU</th>
                                                    <th style="vertical-align: middle;" id="lbl_batch_price">سعر المنتج</th>
                                                    <th style="vertical-align: middle;" id="lbl_batch_weight">N.W</th>
                                                    <th style="vertical-align: middle;" id="lbl_batch_gross_weight">وزن G.W</th>
                                                    <th style="vertical-align: middle;">الطول</th>
                                                    <th style="vertical-align: middle;">العرض</th>
                                                    <th style="vertical-align: middle;">الارتفاع</th>
                                                    <th style="vertical-align: middle;" id="lbl_batch_total_cbm">إجمالي CBM</th>
                                                    <th style="vertical-align: middle;" id="lbl_batch_units">الكمية</th>
                                                    <th style="vertical-align: middle; background: #fff9e6; color: #333;">إجمالي CBM</th>
                                                    <th style="vertical-align: middle; background: #fff9e6; color: #333;">إجمالي الوزن</th>
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
                                        <i class="fa fa-print"></i> طباعة القائمة كمعاينة
                                    </button>
                                    <button type="button" class="btn btn-success btn-lg" id="btnSaveAll" style="border-radius: 30px; font-weight: bold; padding: 10px 40px; box-shadow: 0 5px 15px rgba(0,166,90,0.3);">
                                        <i class="fa fa-check-circle"></i> حفظ جميع المنتجات ورفعها للسيرفر
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

<!-- Modals -->
<div class="modal fade" id="quickSectorModal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 12px; overflow: hidden;">
            <div class="modal-header" style="background: linear-gradient(135deg, #3c8dbc, #2b6688); color: white;">
                <h4 class="modal-title">اضافة قطاع جديد</h4>
            </div>
            <form id="quickSectorForm">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>اسم القطاع</label>
                        <input type="text" name="sector_name" class="form-control" placeholder="مثال: قطع غيار سيارات" required>
                    </div>
                    <div class="form-group">
                        <label>اسم الفرع</label>
                        <input type="text" name="branch_name" class="form-control" placeholder="مثال: فرع دبي" required>
                    </div>
                    <div class="form-group">
                        <label>اسم القسم</label>
                        <input type="text" name="category_name" class="form-control" placeholder="مثال: فلاتر زيت" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">إلغاء</button>
                    <button type="submit" id="btnSaveQuick" class="btn btn-primary">موافقة وإضافة</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="sectorModal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 12px; overflow: hidden;">
            <div class="modal-header">
                <h4 class="modal-title">إضافة قطاعات لملفك</h4>
            </div>
            <form id="ajaxSectorForm">
                @csrf
                <div class="modal-body">
                    <p class="text-muted">اختر القطاعات التي ترغب في تفعيلها في حسابك:</p>
                    <select name="sector_ids[]" id="modal_sector_ids" class="form-control select2" multiple style="width: 100%;">
                        @foreach($allSectors as $s)
                            <option value="{{ $s->id }}">{{ $s->name_ar }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">إغلاق</button>
                    <button type="submit" id="saveSectorsBtn" class="btn btn-primary">حفظ التغييرات</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="quickBranchModal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 12px;">
            <div class="modal-header">
                <h4 class="modal-title">إضافة فرع جديد</h4>
            </div>
            <form id="quickBranchForm">
                @csrf
                <input type="hidden" name="sector_id" id="modal_sector_id">
                <div class="modal-body">
                    <p id="selectedSectorName" style="font-weight: bold; color: #3c8dbc;"></p>
                    <div class="form-group">
                        <label>اسم الفرع (بالعربية)</label>
                        <input type="text" name="name_ar" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">إلغاء</button>
                    <button type="submit" id="btnSaveQuickBranch" class="btn btn-primary">حفظ وإضافة</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="quickCategoryModal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 12px;">
            <div class="modal-header">
                <h4 class="modal-title">إضافة قسم جديد</h4>
            </div>
            <form id="quickCategoryForm">
                @csrf
                <input type="hidden" name="branch_id" id="modal_branch_id">
                <div class="modal-body">
                    <p id="selectedBranchName" style="font-weight: bold; color: #3c8dbc;"></p>
                    <div class="form-group">
                        <label>اسم القسم (بالعربية)</label>
                        <input type="text" name="name_ar" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">إلغاء</button>
                    <button type="submit" id="btnSaveQuickCategory" class="btn btn-primary">حفظ وإضافة</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="imagesModal" tabindex="-1" role="dialog" style="z-index: 10000; background: rgba(0,0,0,0.85);">
    <div class="modal-dialog modal-lg" role="document" style="width: 90%; max-width: 1100px; margin-top: 50px;">
        <div class="modal-content" style="border-radius: 12px; overflow: hidden; border: none; background: #fff; box-shadow: 0 20px 50px rgba(0,0,0,0.5);">
            <div class="modal-header" style="background: #f8f9fa; border-bottom: 1px solid #eee; padding: 15px 25px; display: flex; align-items: center; justify-content: space-between;">
                <h4 class="modal-title" style="color: #333; font-weight: 700; font-size: 18px;">
                    <i class="fa fa-image text-primary"></i> <span style="margin-right: 10px;">معرض الصور</span>
                    <span id="gallery-counter" style="background: #3c8dbc; color: white; padding: 3px 12px; border-radius: 20px; font-size: 13px; font-weight: 700; margin-right: 15px;">1 / 1</span>
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #333; opacity: 1; text-shadow: none; font-size: 28px; margin: 0;">&times;</button>
            </div>
            <div class="modal-body" style="padding: 0; display: flex; height: 650px;">
                <div class="gallery-sidebar" style="width: 120px; border-left: 1px solid #eee; background: #fdfdfd; overflow-y: auto; padding: 15px; display: flex; flex-direction: column; gap: 10px;">
                    <div id="gallery-thumbnails-container" style="display: flex; flex-direction: column; gap: 10px;"></div>
                </div>
                <div class="gallery-main-container" style="flex: 1; background: #fff; position: relative; display: flex; align-items: center; justify-content: center; padding: 20px; overflow: hidden;">
                    <img id="gallery-main-image" src="" style="max-width: 100%; max-height: 100%; object-fit: contain; border-radius: 4px;">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editProductModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius: 12px;">
            <div class="modal-header" style="background: #3c8dbc; color: white;">
                <h4 class="modal-title">تعديل بيانات المنتج</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="edit_product_idx">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>القطاع</label>
                            <select id="edit_sector_id" class="form-control">
                                @foreach($sectors as $s) <option value="{{ $s->id }}">{{ $s->name_ar }}</option> @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group"><label>الفرع</label><select id="edit_branch_id" class="form-control"></select></div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group"><label>القسم</label><select id="edit_category_id" class="form-control"></select></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6"><div class="form-group"><label>اسم المنتج</label><input type="text" id="edit_name" class="form-control"></div></div>
                    <div class="col-md-3"><div class="form-group"><label>SKU</label><input type="text" id="edit_sku" class="form-control"></div></div>
                    <div class="col-md-3"><div class="form-group"><label>السعر (<span id="edit_currency_label"></span>)</label><input type="text" id="edit_price" class="form-control"></div></div>
                </div>
                <div class="row">
                    <div class="col-md-3"><div class="form-group"><label>وزن الوحدة</label><input type="text" id="edit_piece_weight" class="form-control"></div></div>
                    <div class="col-md-3"><div class="form-group"><label>الكمية</label><input type="text" id="edit_product_piece_count" class="form-control"></div></div>
                    <div class="col-md-2"><div class="form-group"><label>طول</label><input type="text" id="edit_carton_length" class="form-control dimension-input-edit"></div></div>
                    <div class="col-md-2"><div class="form-group"><label>عرض</label><input type="text" id="edit_carton_width" class="form-control dimension-input-edit"></div></div>
                    <div class="col-md-2"><div class="form-group"><label>ارتفاع</label><input type="text" id="edit_carton_height" class="form-control dimension-input-edit"></div></div>
                </div>
                <div class="form-group"><label>وصف المنتج</label><textarea id="edit_description" class="form-control" rows="4"></textarea></div>
                <div class="form-group">
                    <label>الصور</label>
                    <input type="file" id="edit_new_images" class="form-control" multiple accept="image/*">
                    <div id="edit_images_preview" class="row" style="margin-top: 15px;"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">إلغاء</button>
                <button type="button" class="btn btn-primary" onclick="saveBatchProductEdit()">حفظ التغييرات</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('css')
<style>
    .upload-zone:hover { border-color: #3c8dbc !important; background: #f0f7ff !important; }
    .upload-zone:hover i { color: #3c8dbc !important; }
    #btnAddToList { background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%); border: none; color: white; transition: all 0.3s; }
    #btnAddToList:hover { transform: translateY(-2px); box-shadow: 0 12px 25px rgba(230, 126, 34, 0.4); }
    .batch-img { width: 45px; height: 45px; object-fit: cover; border-radius: 8px; border: 1px solid #eee; cursor: pointer; }
    .cbm-badge { background: #f0f7ff; color: #3c8dbc; padding: 4px 8px; border-radius: 6px; font-weight: bold; }
    
    @media print {
        body * { visibility: hidden; }
        #batch_section, #batch_section * { visibility: visible; }
        #batch_section { position: absolute; left: 0; top: 0; width: 100%; }
        .no-print { display: none !important; }
    }
    .gallery-sidebar::-webkit-scrollbar { width: 5px; }
    .gallery-sidebar::-webkit-scrollbar-thumb { background: #ccc; border-radius: 10px; }
    .gallery-thumb { width: 100%; height: 90px; object-fit: cover; border-radius: 6px; cursor: pointer; border: 2px solid transparent; transition: all 0.2s; background: #fff; }
    .gallery-thumb:hover, .gallery-thumb.active { border-color: #3c8dbc; transform: scale(1.02); }
</style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.2/tinymce.min.js"></script>
<script>
    var productsBatch = [];
    var initialSelectedImagesData = [];

    function switchUploadMode(mode) {
        $('#upload_mode').val(mode);
        if (mode === 'special') {
            $('#lbl_unit_price').text('سعر المنتج');
            $('#lbl_unit_weight').text('N.W.(KG)');
            $('#lbl_gross_weight, #col_gross_weight').show();
            $('#lbl_carton_weight_col').hide();
            $('#lbl_batch_price').text('سعر المنتج');
            $('#lbl_batch_weight').text('N.W');
            $('#lbl_batch_gross_weight').show();
            $('#lbl_batch_units').text('Total CBM');
            $('#lbl_batch_total_cbm').show();
        } else {
            $('#lbl_unit_price').text('سعر الوحدة');
            $('#lbl_unit_weight').text('وزن الوحدة');
            $('#lbl_gross_weight, #col_gross_weight').hide();
            $('#lbl_carton_weight_col').show();
            $('#lbl_batch_price').text('سعر الوحدة');
            $('#lbl_batch_weight').text('وزن الوحدة');
            $('#lbl_batch_gross_weight').hide();
            $('#lbl_batch_units').text('وحدات/كرتونة');
            $('#lbl_batch_total_cbm').show();
        }
    }

    $(document).ready(function() {
        $('body').addClass('sidebar-collapse');
        $('.select2').select2({ dir: "rtl", width: '100%' });
        tinymce.init({
            selector: '#editor', height: 300, language: 'ar', directionality: 'rtl',
            plugins: 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table help wordcount',
            toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | bullist numlist | table'
        });
        switchUploadMode('special');
    });

    // Dropdowns
    $('#sector_id').on('change', function() {
        var sid = $(this).val();
        $('#branch_id, #category_id').empty().append('<option value="">اختر...</option>').prop('disabled', true);
        if (sid) {
            $.get('/api/branches/' + sid, function(data) {
                $('#branch_id').prop('disabled', false);
                $.each(data, function(k, v) { $('#branch_id').append('<option value="'+v.id+'">'+v.name_ar+'</option>'); });
            });
            $('#modal_sector_id').val(sid);
            $('#selectedSectorName').text('القطاع: ' + $('#sector_id option:selected').text());
        }
    });

    $('#branch_id').on('change', function() {
        var bid = $(this).val();
        $('#category_id').empty().append('<option value="">اختر...</option>').prop('disabled', true);
        if (bid) {
            $.get('/api/categories/' + bid, function(data) {
                $('#category_id').prop('disabled', false);
                $.each(data, function(k, v) { $('#category_id').append('<option value="'+v.id+'">'+v.name_ar+'</option>'); });
            });
            $('#modal_branch_id').val(bid);
            $('#selectedBranchName').text('الفرع: ' + $('#branch_id option:selected').text());
        }
    });

    // Quick Store Modals
    $('#quickSectorForm').on('submit', function(e) {
        e.preventDefault(); var btn = $('#btnSaveQuick'); btn.prop('disabled', true).text('جاري الحفظ...');
        $.post('{{ route("api.quick-sector") }}', $(this).serialize(), function(res) {
            if(res.success) {
                $('#sector_id').append(new Option(res.sector.name_ar, res.sector.id, true, true)).trigger('change');
                $('#quickSectorModal').modal('hide');
            }
            btn.prop('disabled', false).text('موافقة وإضافة');
        });
    });

    // Image Preview
    $('#product_images').on('change', function() {
        $('#image_preview').empty(); initialSelectedImagesData = [];
        Array.from(this.files).forEach(file => {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#image_preview').append('<div class="col-md-2"><img src="'+e.target.result+'" class="img-thumbnail" style="margin-bottom:5px;"></div>');
                initialSelectedImagesData.push({ name: file.name, dataURL: e.target.result });
            }
            reader.readAsDataURL(file);
        });
    });

    // Calculation logic
    function calculateNewTable() {
        var l = parseFloat($('#carton_length').val()) || 0, w = parseFloat($('#carton_width').val()) || 0, h = parseFloat($('#carton_height').val()) || 0;
        var q = parseFloat($('#product_piece_count').val()) || 0, unitWeight = parseFloat($('#piece_weight').val()) || 0;
        var unitPrice = parseFloat($('#price').val()) || 0;

        var unitCbm = l * w * h; $('#carton_volume_cbm').val(unitCbm.toFixed(6));
        var totalCbm = unitCbm * q; $('#total_cbm').val(totalCbm.toFixed(6));
        var totalW = unitWeight * q; $('#total_weight').val(totalW.toFixed(2));

        if (unitCbm > 0) {
            const widgets = $('.widget-cbm-calc');
            const currency = $('#currency_code').val() || '$';
            const effCbm = totalCbm || unitCbm;
            const containers = [
                { f: 1 }, { f: 28, max: 22000, note: '18 - 22 طن' }, { f: 40, max: 24000, note: '20 - 24 طن' },
                { f: 68, max: 24000, note: '20 - 24 طن' }, { f: 78, max: 20000, note: '15 - 20 طن' }
            ];

            const baseCartons = 1 / effCbm;
            const baseUnits = baseCartons * (q || 1);
            const baseWeight = baseUnits * unitWeight;
            const basePrice = baseUnits * unitPrice;

            containers.forEach((c, i) => {
                const tc = baseCartons * c.f;
                const tu = baseUnits * c.f;
                const tw = baseWeight * c.f;
                const tp = basePrice * c.f;
                const isOver = c.max && tw > c.max;

                widgets.eq(i).html(`
                    <div style="font-size: 11px;">
                        <div>القطع: <b>${c.f === 1 ? tu.toFixed(3) : Math.floor(tu).toLocaleString()}</b></div>
                        <div>الوزن: <b style="color:${isOver ? '#ff6b6b' : 'inherit'}">${tw.toLocaleString()} kg</b></div>
                        <div style="border-top:1px solid rgba(255,255,255,0.2); margin-top:4px; padding-top:4px;">السعر: <b>${tp.toLocaleString()} ${currency}</b></div>
                        ${isOver ? `<div style="color:#ffc107; font-weight:bold; font-size:9px;">تجاوز الوزن القياسي!</div>` : ''}
                    </div>
                `);
                widgets.eq(i).closest('div').css('background', isOver ? 'linear-gradient(135deg, #f39c12, #e67e22)' : '#007bff');
            });
        }
    }
    $('input.english-nums, .dimension-input').on('input change', calculateNewTable);

    // Add To List
    $('#btnAddToList').on('click', function() {
        var form = $('#productForm')[0]; if(!form.checkValidity()) { form.reportValidity(); return; }
        var desc = tinymce.get('editor').getContent();
        if(!desc.trim().replace(/(<([^>]+)>)/ig, "")) { alert('الوصف مطلوب'); return; }
        if(initialSelectedImagesData.length === 0) { alert('الصور مطلوبة'); return; }

        var p = {
            id: Date.now(),
            sector_id: $('#sector_id').val(), sector_name: $('#sector_id option:selected').text(),
            branch_id: $('#branch_id').val(), branch_name: $('#branch_id option:selected').text(),
            category_id: $('#category_id').val(), category_name: $('#category_id option:selected').text(),
            name: $('#table_product_name').val() || $('#name').val(),
            sku: $('#sku').val() || $('#sku_main').val(),
            price: $('#price').val(), currency_code: $('#currency_code').val(),
            piece_weight: $('#piece_weight').val(), product_piece_count: $('#product_piece_count').val(),
            carton_length: $('#carton_length').val(), carton_width: $('#carton_width').val(), carton_height: $('#carton_height').val(),
            carton_volume_cbm: $('#carton_volume_cbm').val(), total_cbm: $('#total_cbm').val(), total_weight: $('#total_weight').val(),
            min_order_quantity: $('#min_order_quantity').val() || 1,
            description: desc, images: JSON.parse(JSON.stringify(initialSelectedImagesData)), upload_mode: 'special'
        };
        productsBatch.push(p); renderBatchTable();
        // Reset
        $('#table_product_name, #sku, #price, #piece_weight, #product_piece_count, #carton_length, #carton_width, #carton_height').val('');
        tinymce.get('editor').setContent(''); $('#image_preview').empty(); initialSelectedImagesData = [];
    });

    function renderBatchTable() {
        var tbody = $('#batch_table tbody').empty();
        if(productsBatch.length === 0) { $('#batch_section').hide(); return; }
        $('#batch_section').show();
        productsBatch.forEach(p => {
            tbody.append(`<tr>
                <td><img src="${p.images[0].dataURL}" class="batch-img" onclick="openImagesModal(${p.id})"></td>
                <td><b>${p.name}</b><br><small>${p.sector_name}</small></td>
                <td>${p.sku || '-'}</td>
                <td>${p.price} ${p.currency_code}</td>
                <td>${p.piece_weight}</td>
                <td>${p.total_weight}</td>
                <td>${p.carton_length}</td><td>${p.carton_width}</td><td>${p.carton_height}</td>
                <td>${p.total_cbm}</td>
                <td>${p.product_piece_count}</td>
                <td><span class="cbm-badge">${p.total_cbm}</span></td>
                <td><b>${p.total_weight} kg</b></td>
                <td class="no-print">
                    <button onclick="openEditProductModal(${p.id})" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></button>
                    <button onclick="removeProduct(${p.id})" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>
                </td>
            </tr>`);
        });
    }

    window.removeProduct = function(id) { productsBatch = productsBatch.filter(p => p.id !== id); renderBatchTable(); };
    window.openImagesModal = function(id) {
        var p = productsBatch.find(p => p.id === id); if(!p) return;
        var tc = $('#gallery-thumbnails-container').empty();
        $('#gallery-counter').text('1 / ' + p.images.length);
        p.images.forEach((img, i) => {
            var t = $(`<img src="${img.dataURL}" class="gallery-thumb ${i===0?'active':''}">`);
            t.on('click', function() { $('.gallery-thumb').removeClass('active'); $(this).addClass('active'); $('#gallery-main-image').attr('src', img.dataURL); $('#gallery-counter').text((i+1)+' / '+p.images.length); });
            tc.append(t); if(i===0) $('#gallery-main-image').attr('src', img.dataURL);
        });
        $('#imagesModal').modal('show');
    };

    // Edit logic (simplified for batch)
    window.openEditProductModal = function(id) {
        var p = productsBatch.find(p => p.id === id); if(!p) return;
        $('#edit_product_idx').val(id); $('#edit_name').val(p.name); $('#edit_sku').val(p.sku); $('#edit_price').val(p.price);
        $('#edit_piece_weight').val(p.piece_weight); $('#edit_product_piece_count').val(p.product_piece_count);
        $('#edit_carton_length').val(p.carton_length); $('#edit_carton_width').val(p.carton_width); $('#edit_carton_height').val(p.carton_height);
        $('#edit_description').val(p.description.replace(/(<([^>]+)>)/ig, ""));
        $('#edit_images_preview').empty();
        p.images.forEach((img, i) => {
            $('#edit_images_preview').append(`<div class="col-md-3"><img src="${img.dataURL}" class="img-thumbnail"></div>`);
        });
        $('#editProductModal').modal('show');
    };

    window.saveBatchProductEdit = function() {
        var id = parseInt($('#edit_product_idx').val());
        var idx = productsBatch.findIndex(p => p.id === id); if(idx === -1) return;
        var p = productsBatch[idx];
        p.name = $('#edit_name').val(); p.sku = $('#edit_sku').val(); p.price = $('#edit_price').val();
        p.piece_weight = $('#edit_piece_weight').val(); p.product_piece_count = $('#edit_product_piece_count').val();
        p.carton_length = $('#edit_carton_length').val(); p.carton_width = $('#edit_carton_width').val(); p.carton_height = $('#edit_carton_height').val();
        p.description = $('#edit_description').val();
        
        var unitCbm = p.carton_length * p.carton_width * p.carton_height;
        p.carton_volume_cbm = unitCbm.toFixed(6);
        p.total_cbm = (unitCbm * p.product_piece_count).toFixed(6);
        p.total_weight = (p.piece_weight * p.product_piece_count).toFixed(2);
        
        renderBatchTable(); $('#editProductModal').modal('hide');
    };

    $('#btnSaveAll').on('click', async function() {
        var btn = $(this); btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> جاري الحفظ...');
        var token = '{{ csrf_token() }}';
        for (var p of productsBatch) {
            var fd = new FormData();
            fd.append('_token', token); fd.append('custom_order_id', '{{ $order->id }}');
            fd.append('name', p.name); fd.append('sku', p.sku); fd.append('price', p.price); fd.append('currency_code', p.currency_code);
            fd.append('sector_id', p.sector_id); fd.append('branch_id', p.branch_id); fd.append('category_id', p.category_id);
            fd.append('piece_weight', p.piece_weight); fd.append('product_piece_count', p.product_piece_count);
            fd.append('carton_length', p.carton_length); fd.append('carton_width', p.carton_width); fd.append('carton_height', p.carton_height);
            fd.append('carton_volume_cbm', p.carton_volume_cbm); fd.append('description', p.description);
            fd.append('min_order_quantity', p.min_order_quantity);
            
            for (var img of p.images) {
                var arr = img.dataURL.split(','), mime = arr[0].match(/:(.*?);/)[1], bstr = atob(arr[1]), n = bstr.length, u8arr = new Uint8Array(n);
                while(n--){ u8arr[n] = bstr.charCodeAt(n); }
                fd.append('images[]', new Blob([u8arr], {type: mime}), img.name);
            }
            try { 
                let resp = await fetch('{{ route("products.store") }}', { method: 'POST', body: fd, headers: { 'X-Requested-With': 'XMLHttpRequest' } }); 
                if(!resp.ok) {
                    let errData = await resp.json();
                    throw new Error(errData.message || 'خطأ في حفظ المنتج: ' + p.name);
                }
            } catch(e) {
                alert(e.message);
                btn.prop('disabled', false).html('<i class="fa fa-check-circle"></i> حفظ جميع المنتجات ورفعها للسيرفر');
                return;
            }
        }
        alert('تم الحفظ بنجاح'); window.location.href = '{{ route("global_forwarding.orders.matched_products") }}';
    });
</script>
@endpush
