@extends('layouts.master')

@section('title', 'رفع مركبة/معدة ثقيلة - الطلب #' . $order->id)

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
</style>

<section class="content-header">
    <h1>
        رفع مركبات ومعدات ثقيلة
        <small>الطلب المتخصص #{{ $order->id }}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('global_forwarding.dashboard') }}"><i class="fa fa-dashboard"></i> لوحة التحكم</a></li>
        <li><a href="{{ route('global_forwarding.orders.custom') }}">الطلبات المتخصصة</a></li>
        <li><a href="{{ route('global_forwarding.orders.custom.show', $order->id) }}">تفاصيل الطلب #{{ $order->id }}</a></li>
        <li class="active">مركبات ومعدات ثقيلة</li>
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
                        <div class="box-header with-border" style="background: #fcfcfc;">
                            <h3 class="box-title" style="font-weight: bold; color: #333;"><i class="fa fa-info-circle text-primary"></i> المعلومات الأساسية</h3>
                        </div>
                        <div class="box-body" style="padding: 25px;">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>القطاع</label>
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
                                        <label>الفرع</label>
                                        <select name="branch_id" id="branch_id" class="form-control select2" required disabled>
                                            <option value="">اختر الفرع</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>القسم</label>
                                        <select name="category_id" id="category_id" class="form-control select2" required disabled>
                                            <option value="">اختر القسم</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="margin-top: 15px;">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>اسم المعدة / المركبة الثقيلة</label>
                                        <input type="text" name="name" id="name" class="form-control" placeholder="مثال: جرافة كوماتسو D155" required style="height: 45px; font-size: 16px;">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>ID المنتج (SKU)</label>
                                        <input type="text" name="sku_main" id="sku_main" class="form-control" placeholder="مثال: HVY-001" style="height: 45px; font-size: 16px;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Heavy Specific Details -->
                    <div class="box box-solid box-default" style="border-radius: 12px; border: 1px solid #ddd; box-shadow: 0 4px 15px rgba(0,0,0,0.05); margin-bottom: 25px;">
                        <div class="box-header with-border" style="background: #fcfcfc;">
                            <h3 class="box-title" style="font-weight: bold; color: #333;"><i class="fa fa-truck text-orange"></i> مواصفات المعدة الثقيلة</h3>
                        </div>
                        <div class="box-body" style="padding: 25px;">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>الشركة المصنعة</label>
                                        <input type="text" name="car_manufacturer" class="form-control" placeholder="كاتربيلر">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>الموديل</label>
                                        <input type="text" name="car_model" class="form-control" placeholder="D8T">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>سنة الصنع</label>
                                        <input type="number" name="car_year" class="form-control" placeholder="2022">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>ساعات العمل / المسافة</label>
                                        <input type="number" name="mileage" class="form-control" placeholder="5000">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pricing & Specialized Logistics -->
                    <div class="box box-solid box-default" style="border-radius: 12px; border: 1px solid #ddd; box-shadow: 0 4px 15px rgba(0,0,0,0.05); margin-bottom: 25px;">
                        <div class="box-header with-border" style="background: #fcfcfc;">
                            <h3 class="box-title" style="font-weight: bold; color: #333;"><i class="fa fa-money text-success"></i> السعر وتفاصيل الشحن المتخصص</h3>
                        </div>
                        <div class="box-body" style="padding: 20px;">
                            <input type="hidden" name="upload_mode" id="upload_mode" value="special">

                            <div class="row">
                                <div class="col-md-3"><label>السعر</label><input type="text" id="price" class="form-control" placeholder="0.00"></div>
                                <div class="col-md-2">
                                    <label>العملة</label>
                                    <select id="currency_code" class="form-control">
                                        <option value="USD">USD</option>
                                        <option value="EUR">EUR</option>
                                        <option value="SAR">SAR</option>
                                    </select>
                                </div>
                                <div class="col-md-2"><label>الوزن (Tons)</label><input type="text" id="piece_weight" class="form-control" placeholder="25"></div>
                                <div class="col-md-5">
                                    <div class="row">
                                        <div class="col-md-4"><label>طول (m)</label><input type="number" id="carton_length" step="0.1" class="form-control dimension-input" placeholder="8.5"></div>
                                        <div class="col-md-4"><label>عرض (m)</label><input type="number" id="carton_width" step="0.1" class="form-control dimension-input" placeholder="3.2"></div>
                                        <div class="col-md-4"><label>ارتفاع (m)</label><input type="number" id="carton_height" step="0.1" class="form-control dimension-input" placeholder="3.5"></div>
                                    </div>
                                </div>
                            </div>

                            <div id="section_heavy_vehicles" style="margin-top: 30px;">
                                <h4 style="font-weight: bold; color: #3c8dbc; margin-bottom: 20px;"><i class="fa fa-ship"></i> أنواع الحاويات والخدمات اللوجستية المتخصصة</h4>
                                <div class="row" style="display: flex; flex-wrap: wrap; gap: 15px; justify-content: center;">
                                    <!-- Open Top 20ft -->
                                    <div class="spec-container-card" data-l="5.89" data-w="2.35" data-h="2.35" data-cbm="32" data-name="20ft Open Top" style="flex: 1; min-width: 200px; max-width: 250px; background: #007bff; color: white; border-radius: 12px; padding: 15px; box-shadow: 0 4px 15px rgba(0,123,255,0.2);">
                                        <div style="font-weight: bold;">20ft Open Top (32 CBM)</div>
                                        <div class="spec-capacity-result widget-cbm-calc" style="margin-top: 10px; background: rgba(255,255,255,0.1); padding: 8px; border-radius: 8px; font-size: 12px;">أدخل الأبعاد للتحليل</div>
                                    </div>
                                    <!-- Open Top 40ft -->
                                    <div class="spec-container-card" data-l="12.02" data-w="2.35" data-h="2.35" data-cbm="66" data-name="40ft Open Top" style="flex: 1; min-width: 200px; max-width: 250px; background: #007bff; color: white; border-radius: 12px; padding: 15px; box-shadow: 0 4px 15px rgba(0,123,255,0.2);">
                                        <div style="font-weight: bold;">40ft Open Top (66 CBM)</div>
                                        <div class="spec-capacity-result widget-cbm-calc" style="margin-top: 10px; background: rgba(255,255,255,0.1); padding: 8px; border-radius: 8px; font-size: 12px;"></div>
                                    </div>
                                    <!-- Flat Rack 20ft -->
                                    <div class="spec-container-card" data-l="5.94" data-w="2.35" data-h="99.0" data-cbm="28" data-name="20ft Flat Rack" style="flex: 1; min-width: 200px; max-width: 250px; background: #f39c12; color: white; border-radius: 12px; padding: 15px; box-shadow: 0 4px 15px rgba(243,156,18,0.2);">
                                        <div style="font-weight: bold;">20ft Flat Rack (28 CBM)</div>
                                        <div class="spec-capacity-result widget-cbm-calc" style="margin-top: 10px; background: rgba(255,255,255,0.1); padding: 8px; border-radius: 8px; font-size: 12px;"></div>
                                    </div>
                                    <!-- Flat Rack 40ft -->
                                    <div class="spec-container-card" data-l="12.13" data-w="2.40" data-h="99.0" data-cbm="60" data-name="40ft Flat Rack" style="flex: 1; min-width: 200px; max-width: 250px; background: #f39c12; color: white; border-radius: 12px; padding: 15px; box-shadow: 0 4px 15px rgba(243,156,18,0.2);">
                                        <div style="font-weight: bold;">40ft Flat Rack (60 CBM)</div>
                                        <div class="spec-capacity-result widget-cbm-calc" style="margin-top: 10px; background: rgba(255,255,255,0.1); padding: 8px; border-radius: 8px; font-size: 12px;"></div>
                                    </div>
                                    <!-- RoRo -->
                                    <div class="spec-container-card" data-roro="true" data-name="RoRo Shipping" style="flex: 1; min-width: 200px; max-width: 250px; background: #d81b60; color: white; border-radius: 12px; padding: 15px; box-shadow: 0 4px 15px rgba(216,27,96,0.2);">
                                        <div style="font-weight: bold;">RoRo Shipping</div>
                                        <div class="spec-capacity-result widget-cbm-calc" style="margin-top: 10px; background: rgba(255,255,255,0.1); padding: 8px; border-radius: 8px; font-size: 12px;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section: Media -->
                    <div class="box box-solid box-default" style="border-radius: 12px; border: 1px solid #ddd; box-shadow: 0 4px 15px rgba(0,0,0,0.05); margin-bottom: 25px;">
                        <div class="box-header with-border" style="background: #fcfcfc;">
                            <h3 class="box-title" style="font-weight: bold; color: #333;"><i class="fa fa-camera text-danger"></i> صور وفيديوهات المعدة</h3>
                        </div>
                        <div class="box-body" style="padding: 25px;">
                            <div class="upload-zone" style="border: 2px dashed #ccc; border-radius: 12px; padding: 40px; text-align: center; background: #fafafa; cursor: pointer;" onclick="document.getElementById('product_images').click()">
                                <i class="fa fa-cloud-upload" style="font-size: 48px; color: #bbb;"></i>
                                <h4 style="color: #666; font-weight: 600;">اضغط هنا لرفع صور المعدة</h4>
                                <input type="file" name="images[]" id="product_images" class="hidden" multiple required accept="image/*">
                            </div>
                            <div id="image_preview" class="row" style="margin-top: 20px;"></div>
                        </div>
                    </div>

                    <div style="text-align: center; margin-bottom: 50px;">
                        <button type="button" id="btnAddToList" class="btn btn-warning" style="width: 300px; height: 55px; border-radius: 30px; font-size: 20px; font-weight: bold;">
                            <i class="fa fa-plus-circle"></i> إضافة المعدة للقائمة
                        </button>
                    </div>
                </form>

                <!-- Batch Table -->
                <div class="row" id="batch_section" style="display: none; margin-top: 30px;">
                    <div class="col-md-12">
                        <div class="box box-solid" style="border: 2px solid #3c8dbc; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                            <div class="box-header with-border" style="background: #eef7ff;">
                                <h3 class="box-title" style="font-weight: bold; color: #3c8dbc;"><i class="fa fa-list"></i> قائمة المعدات المضافة</h3>
                            </div>
                            <div class="box-body no-padding">
                                <table class="table table-bordered table-striped text-center" id="batch_table">
                                    <thead style="background: #3c8dbc; color: white;">
                                        <tr>
                                            <th>الصورة</th><th>اسم المعدة</th><th>SKU</th><th>السعر</th><th>الوزن</th><th>الأبعاد</th><th>إجراء</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                            <div class="box-footer text-center">
                                <button type="button" class="btn btn-success btn-lg" id="btnSaveAll" style="border-radius: 30px; padding: 10px 50px;">
                                    <i class="fa fa-check-circle"></i> حفظ الجميع
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

@include('global_forwarding.orders.upload_types.partials.car_modals')

@endsection

@push('scripts')
<script>
    var productsBatch = [];
    var initialSelectedImagesData = [];

    $(document).ready(function() {
        $('.select2').select2({ dir: "rtl", width: '100%' });
        $('#sector_id').on('change', function() {
            var sid = $(this).val();
            $('#branch_id, #category_id').empty().append('<option value="">اختر...</option>').prop('disabled', true);
            if (sid) { $.get('/api/branches/' + sid, data => { $('#branch_id').prop('disabled', false); data.forEach(v => $('#branch_id').append('<option value="'+v.id+'">'+v.name_ar+'</option>')); }); }
        });

        $('#branch_id').on('change', function() {
            var bid = $(this).val();
            $('#category_id').empty().append('<option value="">اختر...</option>').prop('disabled', true);
            if (bid) { $.get('/api/categories/' + bid, data => { $('#category_id').prop('disabled', false); data.forEach(v => $('#category_id').append('<option value="'+v.id+'">'+v.name_ar+'</option>')); }); }
        });

        $('#product_images').on('change', function() {
            $('#image_preview').empty(); initialSelectedImagesData = [];
            Array.from(this.files).forEach(file => {
                var reader = new FileReader();
                reader.onload = e => {
                    $('#image_preview').append('<div class="col-md-2"><img src="'+e.target.result+'" class="img-thumbnail"></div>');
                    initialSelectedImagesData.push({ name: file.name, dataURL: e.target.result });
                };
                reader.readAsDataURL(file);
            });
        });

        function calculateHeavy() {
            var l = parseFloat($('#carton_length').val()) || 0,
                w = parseFloat($('#carton_width').val()) || 0,
                h = parseFloat($('#carton_height').val()) || 0;
            
            $('.spec-container-card').each(function() {
                var card = $(this), res = card.find('.spec-capacity-result');
                var cl = card.data('l'), cw = card.data('w'), ch = card.data('h'), roro = card.data('roro');
                
                if (roro) { res.html('<i class="fa fa-check text-green"></i> متوافق (شحن دحرجة)'); return; }
                if (l === 0 || w === 0) { res.text('أدخل الأبعاد'); return; }
                
                var fits = (l <= cl && w <= cw);
                var heightNote = (h > ch) ? ' (مكشوف الرأس)' : '';
                res.html(fits ? `<i class="fa fa-check text-green"></i> متوافق${heightNote}` : '<i class="fa fa-times text-red"></i> غير متوافق');
            });
        }

        $('input.dimension-input').on('input', calculateHeavy);

        $('#btnAddToList').on('click', function() {
            var p = {
                id: Date.now(),
                name: $('#name').val(), sku: $('#sku_main').val(), price: $('#price').val(), currency_code: $('#currency_code').val(),
                piece_weight: $('#piece_weight').val(),
                carton_length: $('#carton_length').val(), carton_width: $('#carton_width').val(), carton_height: $('#carton_height').val(),
                images: [...initialSelectedImagesData],
                sector_id: $('#sector_id').val(), branch_id: $('#branch_id').val(), category_id: $('#category_id').val()
            };
            if (!p.name || !p.sector_id) { alert('أدخل البيانات الأساسية'); return; }
            productsBatch.push(p); renderTable();
            $('#productForm')[0].reset(); $('#image_preview').empty(); initialSelectedImagesData = [];
        });

        function renderTable() {
            var b = $('#batch_table tbody').empty();
            productsBatch.forEach(p => {
                b.append(`<tr>
                    <td><img src="${p.images[0]?.dataURL}" style="width:50px;"></td>
                    <td>${p.name}</td><td>${p.sku}</td><td>${p.price} ${p.currency_code}</td><td>${p.piece_weight} T</td><td>${p.carton_length}x${p.carton_width}x${p.carton_height}</td>
                    <td><button type="button" class="btn btn-xs btn-danger" onclick="removeP(${p.id})">حذف</button></td>
                </tr>`);
            });
            $('#batch_section').toggle(productsBatch.length > 0);
        }
        window.removeP = id => { productsBatch = productsBatch.filter(x => x.id !== id); renderTable(); };

        $('#btnSaveAll').on('click', async function() {
            $(this).prop('disabled', true).text('جاري الحفظ...');
            for (let p of productsBatch) {
                let fd = new FormData();
                fd.append('_token', '{{ csrf_token() }}');
                fd.append('custom_order_id', '{{ $order->id }}');
                fd.append('name', p.name); fd.append('sku_main', p.sku); fd.append('price', p.price); fd.append('currency_code', p.currency_code);
                fd.append('piece_weight', p.piece_weight); fd.append('product_piece_count', 1); fd.append('min_order_quantity', 1);
                fd.append('sector_id', p.sector_id); fd.append('branch_id', p.branch_id);
                fd.append('category_id', p.category_id); fd.append('upload_mode', 'heavy');
                for (let img of p.images) {
                    let res = await fetch(img.dataURL);
                    fd.append('images[]', await res.blob(), img.name);
                }
                let resp = await fetch("{{ route('products.store') }}", { method: 'POST', body: fd, headers: { 'X-Requested-With': 'XMLHttpRequest' } });
                if(!resp.ok) {
                    let errData = await resp.json();
                    throw new Error(errData.message || 'خطأ في حفظ البيانات');
                }
            } catch(e) {
                alert(e.message);
                $(this).prop('disabled', false).text('حفظ جميع البيانات وإرسالها');
                return;
            }
        }
        alert('تم الحفظ بنجاح'); window.location.href = "{{ route('global_forwarding.orders.matched_products') }}";
        });
    });
</script>
@endpush
