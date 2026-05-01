@extends('china.layouts.master')

@section('title', 'تعديل المنتج')

@section('content')
<section class="content-header">
    <h1>
        تعديل المنتج
        <small>تحديث بيانات المنتج</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('products.index') }}"><i class="fa fa-list"></i> منتجاتي</a></li>
        <li class="active">تعديل</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-edit text-primary"></i> تعديل بيانات المنتج</h3>
                </div>

                @if($errors->any())
                    <div class="alert alert-danger" style="margin: 15px;">
                        <ul style="margin:0;">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data" id="productEditForm">
                    @csrf
                    @method('PUT')

                    {{-- ── Section 1: Classification ── --}}
                    <div class="box box-solid box-default" style="border-radius:12px; border:1px solid #ddd; box-shadow:0 4px 15px rgba(0,0,0,0.05); margin:20px;">
                        <div class="box-header with-border" style="background:#fcfcfc; border-radius:12px 12px 0 0;">
                            <h3 class="box-title" style="font-weight:bold; color:#333;"><i class="fa fa-info-circle text-primary"></i> المعلومات الأساسية</h3>
                        </div>
                        <div class="box-body" style="padding:25px;">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label style="font-weight:600;">القطاع</label>
                                        <select name="sector_id" id="sector_id" class="form-control select2" required>
                                            <option value="">اختر القطاع</option>
                                            @foreach($sectors as $sector)
                                                <option value="{{ $sector->id }}" {{ $product->sector_id == $sector->id ? 'selected' : '' }}>
                                                    {{ $sector->name_ar }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label style="font-weight:600;">الفرع</label>
                                        <select name="branch_id" id="branch_id" class="form-control select2" required>
                                            <option value="">اختر الفرع</option>
                                            @foreach($branches as $branch)
                                                <option value="{{ $branch->id }}" {{ $product->branch_id == $branch->id ? 'selected' : '' }}>
                                                    {{ $branch->name_ar }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label style="font-weight:600;">القسم</label>
                                        <select name="category_id" id="category_id" class="form-control select2" required>
                                            <option value="">اختر القسم</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name_ar }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="margin-top:15px;">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label style="font-weight:600;">اسم المنتج</label>
                                        <input type="text" name="name" id="name" class="form-control"
                                               value="{{ old('name', $product->name) }}"
                                               placeholder="أدخل اسم المنتج" required style="height:45px; font-size:16px;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ── Section 2: Pricing & Shipping ── --}}
                    <div class="box box-solid box-default" style="border-radius:12px; border:1px solid #ddd; box-shadow:0 4px 15px rgba(0,0,0,0.05); margin:20px;">
                        <div class="box-header with-border" style="background:#fcfcfc;">
                            <h3 class="box-title" style="font-weight:bold; color:#333;"><i class="fa fa-money text-success"></i> السعر وتفاصيل الشحن</h3>
                        </div>
                        <div class="box-body" style="padding:25px;">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label style="font-weight:600;">سعر الطرف</label>
                                        <div class="input-group">
                                            <input type="text" name="price" id="price" class="form-control english-nums"
                                                   value="{{ old('price', $product->price) }}" required style="height:45px; font-weight:bold; font-size:18px;">
                                            <div class="input-group-btn">
                                                <select name="currency_code" id="currency_code" class="btn btn-default" style="height:45px;">
                                                    @foreach(['USD'=>'USD ($)', 'EUR'=>'EUR (€)', 'CNY'=>'CNY (¥)', 'SAR'=>'SAR (ر.س)'] as $code => $label)
                                                        <option value="{{ $code }}" {{ $product->currency_code == $code ? 'selected' : '' }}>{{ $label }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label style="font-weight:600;">الحد الأدنى للطلب</label>
                                        <input type="text" name="min_order_quantity" id="min_order_quantity" class="form-control english-nums"
                                               value="{{ old('min_order_quantity', $product->min_order_quantity) }}" required style="height:45px; font-weight:bold; font-size:18px;">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label style="font-weight:600;">وزن القطعة (KG)</label>
                                        <input type="text" name="piece_weight" id="piece_weight" class="form-control english-nums"
                                               value="{{ old('piece_weight', $product->piece_weight) }}" style="height:45px; font-weight:bold; font-size:18px;">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label style="font-weight:600;">عدد القطع في الكرتونة</label>
                                        <input type="text" name="product_piece_count" id="product_piece_count" class="form-control english-nums"
                                               value="{{ old('product_piece_count', $product->product_piece_count) }}" style="height:45px; font-weight:bold; font-size:18px;">
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="margin-top:20px;">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label style="font-weight:600;">طول الكرتونة (cm)</label>
                                        <input type="text" name="carton_length" id="carton_length" class="form-control english-nums dimension-input"
                                               value="{{ old('carton_length', $product->carton_length) }}" style="height:45px; font-weight:bold; font-size:18px;">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label style="font-weight:600;">عرض الكرتونة (cm)</label>
                                        <input type="text" name="carton_width" id="carton_width" class="form-control english-nums dimension-input"
                                               value="{{ old('carton_width', $product->carton_width) }}" style="height:45px; font-weight:bold; font-size:18px;">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label style="font-weight:600;">ارتفاع الكرتونة (cm)</label>
                                        <input type="text" name="carton_height" id="carton_height" class="form-control english-nums dimension-input"
                                               value="{{ old('carton_height', $product->carton_height) }}" style="height:45px; font-weight:bold; font-size:18px;">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label style="font-weight:600;">حجم الكرتونة CBM</label>
                                        <input type="text" name="carton_volume_cbm" id="carton_volume_cbm" class="form-control english-nums"
                                               value="{{ old('carton_volume_cbm', $product->carton_volume_cbm) }}"
                                               readonly style="height:45px; background:#fff9e6; color:#b8860b; font-weight:900; font-size:18px; border:2px solid #ffcc00; border-radius:8px; text-align:center;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ── Section 3: Description ── --}}
                    <div class="box box-solid box-default" style="border-radius:12px; border:1px solid #ddd; box-shadow:0 4px 15px rgba(0,0,0,0.05); margin:20px;">
                        <div class="box-header with-border" style="background:#fcfcfc;">
                            <h3 class="box-title" style="font-weight:bold; color:#333;"><i class="fa fa-file-text-o text-warning"></i> وصف المنتج</h3>
                        </div>
                        <div class="box-body" style="padding:25px;">
                            <div class="form-group">
                                <textarea name="description" id="editor" class="form-control" rows="6">{{ old('description', $product->description) }}</textarea>
                            </div>
                        </div>
                    </div>

                    {{-- ── Section 4: Existing Images ── --}}
                    <div class="box box-solid box-default" style="border-radius:12px; border:1px solid #ddd; box-shadow:0 4px 15px rgba(0,0,0,0.05); margin:20px;">
                        <div class="box-header with-border" style="background:#fcfcfc;">
                            <h3 class="box-title" style="font-weight:bold; color:#333;"><i class="fa fa-camera text-danger"></i> صور المنتج</h3>
                        </div>
                        <div class="box-body" style="padding:25px;">

                            {{-- Current Images --}}
                            @if($product->images->count() > 0)
                            <h5 style="font-weight:bold; margin-bottom:15px;">الصور الحالية <small class="text-muted">(اضغط على ✕ لحذف صورة)</small></h5>
                            <div class="row" style="margin-bottom:25px;">
                                @foreach($product->images as $image)
                                <div class="col-md-2 col-sm-3" id="img-container-{{ $image->id }}">
                                    <div style="position:relative; margin-bottom:10px;">
                                        <img src="{{ asset('storage/' . $image->image_path) }}"
                                             class="img-responsive img-thumbnail"
                                             style="width:100%; height:120px; object-fit:cover;">
                                        <button type="button"
                                                onclick="deleteImage({{ $image->id }})"
                                                style="position:absolute; top:5px; right:5px; background:rgba(220,53,69,0.9); color:#fff; border:none; border-radius:50%; width:26px; height:26px; font-size:12px; cursor:pointer; line-height:26px; text-align:center;">✕</button>
                                        <input type="hidden" name="existing_images[]" value="{{ $image->id }}" id="keep-{{ $image->id }}">
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @endif

                            {{-- Upload New Images --}}
                            <h5 style="font-weight:bold; margin-bottom:10px;">إضافة صور جديدة</h5>
                            <div class="upload-zone" style="border:2px dashed #ccc; border-radius:12px; padding:30px; text-align:center; background:#fafafa; cursor:pointer;" onclick="document.getElementById('product_images').click()">
                                <i class="fa fa-cloud-upload" style="font-size:40px; color:#bbb;"></i>
                                <h5 style="color:#666; margin-top:10px;">اضغط هنا لرفع صور جديدة</h5>
                                <p style="color:#999;">JPG, PNG – حتى 5MB لكل صورة</p>
                                <input type="file" name="images[]" id="product_images" class="hidden" multiple accept="image/*">
                            </div>
                            <div id="image_preview" class="row" style="margin-top:20px;"></div>
                        </div>
                    </div>

                    {{-- Hidden inputs for delete_images --}}
                    <div id="delete-images-container"></div>

                    {{-- Submit --}}
                    <div style="text-align:center; margin:30px 0 50px;">
                        <a href="{{ route('products.index') }}" class="btn btn-default btn-lg" style="border-radius:30px; padding:12px 40px; margin-left:15px;">
                            <i class="fa fa-times"></i> إلغاء
                        </a>
                        <button type="submit" class="btn btn-primary btn-lg" style="border-radius:30px; padding:12px 50px; font-size:17px; font-weight:bold; box-shadow:0 8px 20px rgba(60,141,188,0.3);">
                            <i class="fa fa-save"></i> حفظ التعديلات
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

@push('css')
<style>
    .upload-zone:hover { border-color:#3c8dbc !important; background:#f0f7ff !important; }
    .upload-zone:hover i { color:#3c8dbc !important; }
    .select2-container--open { z-index:9999 !important; }
</style>
@endpush

@push('scripts')
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script>
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

    if (typeof CKEDITOR !== 'undefined') {
        CKEDITOR.replace('editor', { language: 'ar', contentsLangDirection: 'rtl' });
    }

    // Dynamic branch dropdown on sector change
    $('#sector_id').on('change', function() {
        var sectorId = $(this).val();
        $('#branch_id').empty().append('<option value="">اختر الفرع</option>').prop('disabled', true);
        $('#category_id').empty().append('<option value="">اختر القسم</option>').prop('disabled', true);
        if (sectorId) {
            $.get('/api/branches/' + sectorId, function(data) {
                $('#branch_id').prop('disabled', false);
                $.each(data, function(k, v) {
                    $('#branch_id').append('<option value="' + v.id + '">' + v.name_ar + '</option>');
                });
            });
        }
    });

    $('#branch_id').on('change', function() {
        var branchId = $(this).val();
        $('#category_id').empty().append('<option value="">اختر القسم</option>').prop('disabled', true);
        if (branchId) {
            $.get('/api/categories/' + branchId, function(data) {
                $('#category_id').prop('disabled', false);
                $.each(data, function(k, v) {
                    $('#category_id').append('<option value="' + v.id + '">' + v.name_ar + '</option>');
                });
            });
        }
    });

    // Auto-calculate CBM from dimensions
    $('.dimension-input').on('input', function() {
        var l = parseFloat($('#carton_length').val()) || 0;
        var w = parseFloat($('#carton_width').val()) || 0;
        var h = parseFloat($('#carton_height').val()) || 0;
        if (l > 0 && w > 0 && h > 0) {
            var cbm = (l * w * h) / 1000000;
            $('#carton_volume_cbm').val(cbm.toFixed(4));
        }
    });

    // Image delete handling
    function deleteImage(imageId) {
        if (confirm('هل تريد حذف هذه الصورة؟')) {
            $('#img-container-' + imageId).fadeOut(300, function() { $(this).remove(); });
            $('#delete-images-container').append('<input type="hidden" name="delete_images[]" value="' + imageId + '">');
        }
    }

    // New image preview
    $('#product_images').on('change', function() {
        $('#image_preview').empty();
        var files = $(this)[0].files;
        for (var i = 0; i < files.length; i++) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#image_preview').append('<div class="col-md-2"><img src="' + e.target.result + '" class="img-responsive img-thumbnail" style="margin-bottom:5px;"></div>');
            };
            reader.readAsDataURL(files[i]);
        }
    });
</script>
@endpush
