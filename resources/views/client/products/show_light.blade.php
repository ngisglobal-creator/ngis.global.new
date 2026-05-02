@extends('client.layouts.master')

@section('title', $product->name . ' | تفاصيل المركبة')

@section('content')
<!-- Import modern font for numbers -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet">
<style>
    .vehicle-spec-card {
        background: #fff;
        border-radius: 15px;
        padding: 20px;
        border: 1px solid #eef0f2;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        height: 100%;
        transition: transform 0.3s ease;
    }
    .vehicle-spec-card:hover { transform: translateY(-5px); border-color: #f39c12; }
    .spec-icon { font-size: 24px; color: #f39c12; margin-bottom: 10px; display: block; }
    .spec-label { font-size: 12px; color: #888; display: block; text-transform: uppercase; }
    .spec-value { font-size: 16px; font-weight: 800; color: #333; }
</style>

<section class="content-header">
    <h1>تفاصيل المركبة <small>{{ $product->name }}</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('client.dashboard') }}"><i class="fa fa-dashboard"></i> الرئيسية</a></li>
        <li><a href="{{ route('site.products.index') }}">المركبات</a></li>
        <li class="active">{{ $product->name }}</li>
    </ol>
</section>

<section class="content">
    <div class="box box-solid" style="border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
        <div class="box-body" style="padding: 30px;">
            <div class="row">
                <!-- Product Gallery -->
                <div class="col-md-7">
                    <div class="row">
                        <div class="col-md-2 hidden-xs hidden-sm">
                            <div class="thumbnails-container" style="display: flex; flex-direction: column; gap: 10px;">
                                @foreach($product->images as $index => $image)
                                    <img src="{{ asset('storage/' . $image->image_path) }}" 
                                         class="img-thumbnail thumb-gallery {{ $index === 0 ? 'active' : '' }}" 
                                         style="width: 100%; aspect-ratio: 1/1; object-fit: cover; cursor: pointer; border: 2px solid {{ $index === 0 ? '#f39c12' : '#eee' }}; transition: padding 0.2s;"
                                         onclick="changeMainImage(this, '{{ asset('storage/' . $image->image_path) }}')">
                                @endforeach
                            </div>
                        </div>
                        
                        <div class="col-md-10">
                            <div id="main-image-display" class="zoom-container" style="border: 1px solid #eee; border-radius: 8px; overflow: hidden; width: 100%; aspect-ratio: 4/3; background: #fafafa; display: flex; align-items: center; justify-content: center; cursor: zoom-in; position: relative;">
                                @php $firstImage = $product->images->first(); @endphp
                                <img id="primaryImage" src="{{ $firstImage ? asset('storage/' . $firstImage->image_path) : asset('dist/img/boxed-bg.jpg') }}" 
                                     style="max-width: 100%; max-height: 100%; object-fit: contain; transition: transform 0.1s ease-out; transform-origin: center center;">
                            </div>
                        </div>
                    </div>

                    <!-- Vehicle Technical Highlights -->
                    <div class="row" style="margin-top: 30px;">
                        @php 
                            $vInfo = $product->logistics_details['vehicle_info'] ?? [];
                        @endphp
                        <div class="col-md-3 col-sm-6" style="margin-bottom: 15px;">
                            <div class="vehicle-spec-card text-center">
                                <i class="fa fa-car spec-icon"></i>
                                <span class="spec-label">المصنع</span>
                                <span class="spec-value">{{ $vInfo['manufacturer'] ?? '-' }}</span>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6" style="margin-bottom: 15px;">
                            <div class="vehicle-spec-card text-center">
                                <i class="fa fa-info-circle spec-icon"></i>
                                <span class="spec-label">الموديل</span>
                                <span class="spec-value">{{ $vInfo['model'] ?? '-' }}</span>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6" style="margin-bottom: 15px;">
                            <div class="vehicle-spec-card text-center">
                                <i class="fa fa-calendar spec-icon"></i>
                                <span class="spec-label">السنة</span>
                                <span class="spec-value english-nums">{{ $vInfo['manufacturing_year'] ?? '-' }}</span>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6" style="margin-bottom: 15px;">
                            <div class="vehicle-spec-card text-center">
                                <i class="fa fa-dashboard spec-icon"></i>
                                <span class="spec-label">الممشى</span>
                                <span class="spec-value english-nums">{{ number_format($vInfo['mileage'] ?? 0) }} KM</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product Information -->
                <div class="col-md-5">
                    <div style="padding: 0 15px;">
                        <span class="label label-warning" style="font-size: 14px; padding: 5px 12px; border-radius: 20px;">
                            <i class="fa fa-car"></i> مركبة خفيفة
                        </span>
                        <h2 style="font-weight: 900; color: #2c3e50; font-size: 32px; margin: 15px 0;">{{ $product->name }}</h2>
                        
                        <div style="margin-bottom: 25px;">
                            <span style="font-size: 48px; font-weight: 900; color: #000; direction: ltr; display: inline-block; font-family: 'Inter', sans-serif;" class="english-nums">
                                {{ number_format($product->price, 2, '.', '') }} <small style="font-size: 22px; color: #333;">{{ $product->currency_code }}</small>
                            </span>
                        </div>

                        <!-- Main Action Buttons Moved to Top -->
                        <div style="margin-bottom: 30px; display: flex; gap: 15px;">
                            <button id="btnOrderModalTop" class="btn btn-warning btn-flat w-100" style="flex: 3; border-radius: 8px; font-weight: 900; font-size: 24px; padding: 15px; background: #f39c12; border: none; box-shadow: 0 4px 15px rgba(243, 156, 18, 0.4); color: #000; transition: all 0.3s;" data-bs-toggle="modal" data-bs-target="#orderModal">
                                <i class="fa fa-shopping-cart fa-lg"></i> احجز الآن
                            </button>
                            <a href="{{ route('site.products.index') }}" class="btn btn-default btn-flat" style="flex: 1; border-radius: 8px; font-weight: bold; font-size: 18px; padding: 15px; display: flex; align-items: center; justify-content: center;">
                                <i class="fa fa-arrow-right"></i> رجوع
                            </a>
                        </div>

                        <div style="background: #fdfdfd; padding: 20px; border-radius: 8px; border: 1px solid #f0f0f0; margin-bottom: 25px;">
                            <h4 style="font-weight: bold; color: #555; margin-top: 0; border-bottom: 2px solid #f39c12; display: inline-block; padding-bottom: 5px;">وصف المركبة</h4>
                            <div style="font-size: 17px; line-height: 1.8; color: #444; text-align: justify; margin-top: 15px;">
                                {!! $product->description !!}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-6">
                                <p class="text-muted"><i class="fa fa-tint"></i> نوع المحرك: <b class="text-black">{{ $vInfo['motor_type'] ?? '-' }}</b></p>
                                <p class="text-muted"><i class="fa fa-paint-brush"></i> اللون: <b class="text-black">{{ $vInfo['color'] ?? '-' }}</b></p>
                            </div>
                            <div class="col-xs-6">
                                <p class="text-muted"><i class="fa fa-check-circle"></i> الحالة: <b class="text-black">{{ $vInfo['condition'] ?? '-' }}</b></p>
                                <p class="text-muted"><i class="fa fa-barcode"></i> رقم الهيكل: <b class="text-black english-nums">{{ $vInfo['vin'] ?? '-' }}</b></p>
                            </div>
                        </div>

                        <ul class="list-group list-group-unbordered" style="margin-top: 20px;">
                            <li class="list-group-item">
                                <b>ID المنتج</b> <a class="pull-left english-nums">{{ $product->sku ?: $product->id }}</a>
                            </li>
                            <li class="list-group-item">
                                <b>الوزن</b> <a class="pull-left text-bold english-nums">{{ number_format($product->piece_weight) }} KG</a>
                            </li>
                            <li class="list-group-item">
                                <b>الأبعاد (ط×ع×ا)</b> <a class="pull-left english-nums">{{ $product->carton_length }}x{{ $product->carton_width }}x{{ $product->carton_height }} m</a>
                            </li>
                        </ul>


                </div>
            </div>

            <!-- 8 Containers Logistics Section -->
            <div class="row" style="margin-top: 50px;">
                <div class="col-md-12">
                    <div style="background: #f8f9fa; border-radius: 25px; padding: 40px; border: 1px solid #eee; box-shadow: 0 10px 40px rgba(0,0,0,0.05);">
                        <div class="text-center mb-5">
                            <h2 style="font-weight: 900; color: #1e3a5f; margin-bottom: 10px;"><i class="fa fa-ship"></i> نظام تفاصيل شحن الحاويات المتقدم</h2>
                            <p style="color: #888;">يتم حساب سعة كل حاوية بناءً على أبعاد المنتج الفعلي مع تطبيق كافة معايير الأمان الدولية</p>
                        </div>

                        <div class="row" style="display: flex; flex-wrap: wrap; gap: 0;">
                             @php
                                $L = $product->carton_length; 
                                $W = $product->carton_width;
                                $H = $product->carton_height;
                                
                                $BUMPER_GAP = 0.25;
                                $WALL_GAP = 0.10;
                                $ROOF_GAP = 0.15;

                                $allContainers = [
                                    ['name' => '40ft Platform', 'cbm' => 70, 'color' => '#28a745', 'icon' => 'fa-th', 'intL' => 12.19, 'intW' => 2.44, 'intH' => 10, 'hasRoof' => false, 'hasWalls' => false],
                                    ['name' => '20ft Platform', 'cbm' => 28, 'color' => '#28a745', 'icon' => 'fa-th', 'intL' => 6.06,  'intW' => 2.44, 'intH' => 10, 'hasRoof' => false, 'hasWalls' => false],
                                    ['name' => '40ft Flat Rack', 'cbm' => 60, 'color' => '#fd7e14', 'icon' => 'fa-minus-square-o', 'intL' => 12.13, 'intW' => 2.40, 'intH' => 10, 'hasRoof' => false, 'hasWalls' => false],
                                    ['name' => '20ft Flat Rack', 'cbm' => 28, 'color' => '#fd7e14', 'icon' => 'fa-minus-square-o', 'intL' => 5.94,  'intW' => 2.35, 'intH' => 10, 'hasRoof' => false, 'hasWalls' => false],
                                    ['name' => '40ft Open Top', 'cbm' => 66, 'color' => '#007bff', 'icon' => 'fa-cube', 'intL' => 12.02, 'intW' => 2.35, 'intH' => 10, 'hasRoof' => false],
                                    ['name' => '20ft Open Top', 'cbm' => 32, 'color' => '#007bff', 'icon' => 'fa-cube', 'intL' => 5.89,  'intW' => 2.35, 'intH' => 10, 'hasRoof' => false],
                                    ['name' => 'RoRo (شحن دحرجة)', 'cbm' => 0,  'color' => '#d81b60', 'icon' => 'fa-truck', 'roro' => true],
                                    ['name' => '40ft Reefer',   'cbm' => 59, 'color' => '#17a2b8', 'icon' => 'fa-snowflake-o', 'intL' => 11.58, 'intW' => 2.29, 'intH' => 2.40]
                                ];

                                $productCbm = ($product->carton_length * $product->carton_width * $product->carton_height);
                                $productCbm = $productCbm > 0 ? $productCbm : 1;
                            @endphp

                            @foreach($allContainers as $c)
                                @php
                                    $warning = null;
                                    if (isset($c['roro'])) {
                                        $req = 1;
                                        $qty = 'مباشر';
                                        $capFlat = 1; $capRack = 1; $capSteel = 1; $capCassette = 1; $capTimber = 1;
                                    } else {
                                        $hasRoof = $c['hasRoof'] ?? true;
                                        $hasWalls = $c['hasWalls'] ?? true;
                                        
                                        $fitsW = !$hasWalls || (($W + ($WALL_GAP * 2)) <= $c['intW']);
                                        $fitsH = !$hasRoof || (($H + $ROOF_GAP) <= $c['intH']);
                                        
                                        if ($fitsW && $fitsH && $L > 0) {
                                            $capFlat = floor(($c['intL'] + $BUMPER_GAP) / ($L + $BUMPER_GAP));
                                            $capRack = floor(($c['intL'] + $BUMPER_GAP) / (($L * 0.72) + $BUMPER_GAP));
                                            $capSteel = floor(($c['intL'] + $BUMPER_GAP) / (($L * 0.68) + $BUMPER_GAP));
                                            $capCassette = floor(($c['intL'] + $BUMPER_GAP) / (($L * 0.62) + $BUMPER_GAP));
                                            $capTimber = floor(($c['intL'] + $BUMPER_GAP) / (($L * 0.82) + $BUMPER_GAP));
                                            
                                            if ($c['intL'] > 11.5 && $L <= 4.8) {
                                                $capRack = max($capRack, 3);
                                                $capSteel = max($capSteel, 4);
                                            }
                                        } else {
                                            $capFlat = 0; $capRack = 0; $capSteel = 0; $capCassette = 0; $capTimber = 0;
                                        }
                                        
                                        // Required containers for ONE piece
                                        $req = $c['cbm'] > 0 ? round($productCbm / $c['cbm'], 2) : 0;
                                        if (!$fitsW || !$fitsH) $warning = "الأبعاد تتجاوز الحدود الآمنة";
                                    }
                                @endphp
                                <div class="col-md-3" style="padding: 10px;">
                                    <div style="background: {{ $c['color'] }}; border-radius: 15px; overflow: hidden; box-shadow: 0 8px 25px rgba(0,0,0,0.1); color: white; height: 100%; transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-10px)'" onmouseout="this.style.transform='translateY(0)'">
                                        <div style="padding: 15px; background: rgba(0,0,0,0.1); display: flex; justify-content: space-between; align-items: center;">
                                            <div>
                                                <h4 style="margin: 0; font-weight: 800; font-size: 15px;">{{ $c['name'] }} @if($c['cbm'] > 0)({{ $c['cbm'] }} CBM) @endif</h4>
                                                @if(!isset($c['roro']))
                                                    <span style="font-size: 10px; opacity: 0.8;" class="english-nums">طول: {{ $c['intL'] }} | عرض: {{ $c['intW'] }} | ارتفاع: {{ $c['intH'] }}</span>
                                                @else
                                                    <span style="font-size: 10px; opacity: 0.8;">Direct Drive-on</span>
                                                @endif
                                            </div>
                                            <i class="fa {{ $c['icon'] }} {{ isset($c['roro']) ? 'fa-truck' : ($c['name'] === '40ft Reefer' ? 'fa-snowflake-o' : '') }}" style="font-size: 20px; opacity: 0.6;"></i>
                                        </div>
                                        
                                        <div style="padding: 15px;">
                                            <div style="background: rgba(255,255,255,0.15); border-radius: 8px; padding: 5px 10px; margin-bottom: 12px; display: inline-block;">
                                                <i class="fa fa-shield" style="font-size: 11px;"></i> <span style="font-size: 11px; font-weight: bold;">معايير الأمان مطبقة</span>
                                            </div>
                                            
                                            <div style="display: flex; flex-direction: column; gap: 8px;">
                                                <div style="display: flex; justify-content: space-between; border-bottom: 1px dashed rgba(255,255,255,0.3); padding-bottom: 5px;">
                                                    <span style="font-size: 12px; opacity: 0.9;">الحاويات المطلوبة:</span>
                                                    <span style="font-weight: 800; font-size: 16px;" class="english-nums">{{ $req }}</span>
                                                </div>
                                                <div style="display: flex; justify-content: space-between;">
                                                    <span style="font-size: 12px; opacity: 0.9;">إجمالي القطع:</span>
                                                    <span style="font-weight: 800;" class="english-nums">1</span>
                                                </div>
                                                <div style="display: flex; justify-content: space-between;">
                                                    <span style="font-size: 12px; opacity: 0.9;">الوزن الكلي:</span>
                                                    <span style="font-weight: 800;" class="english-nums">{{ number_format($product->piece_weight, 2) }} kg</span>
                                                </div>
                                            </div>

                                            <div style="margin-top: 15px; background: rgba(0,0,0,0.05); border-radius: 10px; padding: 10px;">
                                                <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                                    <span style="font-size: 11px;">الأرضي (Flat):</span>
                                                    <span style="font-weight: bold; font-size: 11px;" class="english-nums">{{ $capFlat ?: '---' }} سيارة</span>
                                                </div>
                                                <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                                    <span style="font-size: 11px;">المائل (Racking):</span>
                                                    <span style="font-weight: bold; font-size: 11px;" class="english-nums">{{ $capRack ?: '---' }} سيارة</span>
                                                </div>
                                                <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                                    <span style="font-size: 11px;">فولاذي (Steel):</span>
                                                    <span style="font-weight: bold; font-size: 11px;" class="english-nums">{{ $capSteel ?: '---' }} سيارة</span>
                                                </div>
                                                <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                                    <span style="font-size: 11px;">منصات (Cassette):</span>
                                                    <span style="font-weight: bold; font-size: 11px;" class="english-nums">{{ $capCassette ?: '---' }} سيارة</span>
                                                </div>
                                                <div style="display: flex; justify-content: space-between;">
                                                    <span style="font-size: 11px;">الخشبي (Timber):</span>
                                                    <span style="font-weight: bold; font-size: 11px;" class="english-nums">{{ $capTimber ?: '---' }} سيارة</span>
                                                </div>
                                            </div>

                                            <div style="display: flex; justify-content: space-between; margin-top: 15px; padding-top: 10px; border-top: 2px solid rgba(255,255,255,0.2);">
                                                <span style="font-weight: bold;">السعر الإجمالي:</span>
                                                <span style="font-weight: 900; font-size: 16px;" class="english-nums">{{ number_format($product->price) }} {{ $product->currency_code }}</span>
                                            </div>

                                            @if($warning)
                                                <div style="margin-top: 10px; background: rgba(0,0,0,0.2); padding: 5px; border-radius: 5px; text-align: center; font-size: 10px; font-weight: bold;">
                                                    {{ $warning }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
        <div class="box box-default" style="margin-top: 40px; background: transparent; border: none; box-shadow: none;">
            <div class="box-header" style="padding: 10px 0;">
                <h3 class="box-title" style="font-weight: bold; font-size: 24px;">مركبات مشابهة</h3>
            </div>
            <div class="box-body" style="padding: 0;">
                <div class="row">
                    @foreach($relatedProducts as $related)
                        <div class="col-md-3 col-sm-6">
                            @include('client.products.partials.product_card', ['product' => $related])
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <!-- Order Modal -->
    <div class="modal fade" id="orderModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content" style="border-radius: 15px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                <div class="modal-header" style="background: #f39c12; color: white; border-radius: 15px 15px 0 0;">
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" style="font-weight: 800; color: #fff;">تأكيد طلب حجز المركبات</h4>
                </div>
                <form id="orderForm">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <div class="modal-body" style="padding: 30px;">
                        <div class="form-group">
                            <label style="font-weight: bold;">الكمية المطلوبة (عدد المركبات)</label>
                            <input type="number" name="quantity" id="order_quantity" class="form-control" value="1" min="1" required style="height: 50px; font-size: 20px; font-weight: bold;">
                        </div>
                        <div class="form-group">
                            <label style="font-weight: bold;">خيار الشحن المفضل</label>
                            <select name="shipping_unit_type" class="form-control" style="height: 50px;">
                                <option value="RoRo">RoRo (شحن دحرجة)</option>
                                <option value="Container">Container (في حاوية)</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label style="font-weight: bold;">ملاحظات</label>
                            <textarea name="notes" class="form-control" rows="3" placeholder="أي مواصفات إضافية ترغب بطلبها..."></textarea>
                        </div>
                        
                        <div style="background: #fff9e6; padding: 20px; border-radius: 10px; border: 1px solid #ffeeba; margin-top: 20px; text-align: center;">
                            <span style="display: block; color: #856404; font-weight: bold; margin-bottom: 5px;">إجمالي التكلفة التقديرية</span>
                            <div id="total_price_display" class="english-nums" style="font-size: 28px; font-weight: 900; color: #c0392b;">
                                {{ number_format($product->price) }} {{ $product->currency_code }}
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer" style="padding: 20px;">
                        <button type="button" class="btn btn-default" data-bs-dismiss="modal">إلغاء</button>
                        <button type="submit" class="btn btn-warning" style="font-weight: bold; border-radius: 30px; padding: 10px 30px; color: #000;">تأكيد الطلب</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function changeMainImage(el, src) {
    document.getElementById('primaryImage').src = src;
    $('.thumb-gallery').css('border-color', '#eee').removeClass('active');
    $(el).css('border-color', '#f39c12').addClass('active');
}

$(document).ready(function() {
    const unitPrice = parseFloat("{{ $product->price }}") || 0;
    const currency = "{{ $product->currency_code }}";

    $('#order_quantity').on('input', function() {
        let qty = parseFloat($(this).val()) || 0;
        let total = qty * unitPrice;
        $('#total_price_display').text(total.toLocaleString() + ' ' + currency);
    });

    $('#orderForm').on('submit', function(e) {
        e.preventDefault();
        const btn = $(this).find('button[type="submit"]');
        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> جاري الإرسال...');

        $.ajax({
            url: "{{ route('orders.store') }}",
            method: 'POST',
            data: $(this).serialize(),
            success: function(res) {
                Swal.fire({
                    icon: 'success',
                    title: 'تم إرسال الطلب',
                    text: 'سيتواصل معك المسؤول قريباً لتأكيد التفاصيل.',
                    confirmButtonText: 'حسناً'
                }).then(() => { location.reload(); });
            },
            error: function(err) {
                btn.prop('disabled', false).text('تأكيد الطلب');
                Swal.fire({ icon: 'error', title: 'فشل الإرسال', text: 'حدث خطأ ما، يرجى المحاولة لاحقاً.' });
            }
        });
    });
});
</script>
@endpush
@endsection
