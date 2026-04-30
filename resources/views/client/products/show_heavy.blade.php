@extends('client.layouts.master')

@section('title', $product->name . ' | تفاصيل المعدات الثقيلة')

@section('content')
@push('styles')
<style>
    /* =====================================================
       PAGE-LEVEL OVERRIDE: Force Western Latin Digits ONLY
       This page must NEVER show Persian/Eastern numerals
    ===================================================== */

    /*
     * Intercept digit unicode range with a Latin font.
     * The browser will use Inter for 0-9 even inside Arabic text.
     */
    @font-face {
        font-family: 'ForceLatinDigits';
        src: url('https://fonts.gstatic.com/s/inter/v13/UcCO3FwrK3iLTeHuS_fvQtMwCp50KnMw2boKoduKmMEVuLyfAZ9hiJ-Ek-_EeA.woff2') format('woff2'),
             local('Inter'), local('Arial');
        unicode-range: U+0030-0039, U+002E, U+002C, U+0025;
    }

    /*
     * Apply the digit-intercepting font as FIRST in stack on EVERY element.
     */
    .content-wrapper *,
    .content-wrapper *::before,
    .content-wrapper *::after {
        font-family: 'ForceLatinDigits', 'Inter', 'Almarai', Arial, sans-serif !important;
        font-variant-numeric: lining-nums tabular-nums !important;
        -webkit-font-feature-settings: "lnum" 1, "tnum" 1, "arab" 0 !important;
        font-feature-settings: "lnum" 1, "tnum" 1, "arab" 0 !important;
    }

    /* Arabic text containers — keep Almarai for Arabic letters only */
    .content-wrapper h1, .content-wrapper h2, .content-wrapper h3,
    .content-wrapper h4, .content-wrapper h5, .content-wrapper h6,
    .content-wrapper p, .content-wrapper span, .content-wrapper label,
    .content-wrapper td, .content-wrapper th, .content-wrapper div {
        font-family: 'ForceLatinDigits', 'Almarai', 'Inter', Arial, sans-serif !important;
    }

    /* Explicit numeric elements — use pure Latin font */
    .english-nums, .price, .qty, .amount,
    [class*="english"], [class*="num"], b, strong {
        font-family: 'ForceLatinDigits', 'Inter', Arial, sans-serif !important;
        font-variant-numeric: lining-nums !important;
        direction: ltr;
        unicode-bidi: isolate;
    }

    /* =====================================================
       ORIGINAL PAGE STYLES
    ===================================================== */
    .heavy-spec-card {
        background: #fff;
        border-radius: 12px;
        padding: 15px;
        border-right: 4px solid #d9534f;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        margin-bottom: 20px;
    }
    .heavy-spec-card h5 { color: #888; font-size: 11px; text-transform: uppercase; margin-bottom: 5px; font-weight: bold; }
    .heavy-spec-card p { color: #333; font-size: 15px; font-weight: 800; margin: 0; }
    
    .logistics-card {
        background: #fff;
        border-radius: 15px;
        overflow: hidden;
        border: 1px solid #eee;
        transition: all 0.3s ease;
        height: 100%;
    }
    .logistics-card:hover { transform: translateY(-5px); box-shadow: 0 10px 25px rgba(0,0,0,0.1); border-color: #d9534f; }
    .logistics-header { background: #fdf2f2; padding: 15px; border-bottom: 1px solid #fee; }
    .logistics-header h4 { margin: 0; font-size: 16px; font-weight: 800; color: #c0392b; }
    .logistics-body { padding: 20px; }
</style>
@endpush


<section class="content-header">
    <h1>تفاصيل المعدات الثقيلة <small>{{ $product->name }}</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('client.dashboard') }}"><i class="fa fa-dashboard"></i> الرئيسية</a></li>
        <li><a href="{{ route('site.products.index') }}">المعدات</a></li>
        <li class="active">{{ $product->name }}</li>
    </ol>
</section>

<section class="content">
    <div class="box box-solid" style="border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.1);">
        <div class="box-body" style="padding: 30px;">
            <div class="row">
                <!-- Product Gallery -->
                <div class="col-md-7">
                    <div id="main-image-display" class="zoom-container" style="border: 1px solid #eee; border-radius: 12px; overflow: hidden; width: 100%; aspect-ratio: 16/9; background: #fafafa; display: flex; align-items: center; justify-content: center; cursor: zoom-in; position: relative; margin-bottom: 20px;">
                                @php $firstImage = $product->images->first(); @endphp
                                <img id="primaryImage" src="{{ $firstImage ? asset('storage/' . $firstImage->image_path) : asset('dist/img/boxed-bg.jpg') }}" 
                                     style="max-width: 100%; max-height: 100%; object-fit: contain; transition: transform 0.1s ease-out; transform-origin: center center;">
                    </div>
                    
                    <div style="display: flex; gap: 10px; overflow-x: auto; padding-bottom: 10px;">
                        @foreach($product->images as $image)
                            <img src="{{ asset('storage/' . $image->image_path) }}" 
                                 class="img-thumbnail" 
                                 style="width: 100px; height: 100px; object-fit: cover; cursor: pointer;"
                                 onclick="document.getElementById('primaryImage').src = this.src">
                        @endforeach
                    </div>

                    <!-- Technical Specs Grid -->
                    @php $vInfo = $product->logistics_details['vehicle_info'] ?? []; @endphp
                    <div class="row" style="margin-top: 30px;">
                        <div class="col-md-4 col-sm-6">
                            <div class="heavy-spec-card">
                                <h5>الشركة المصنعة</h5>
                                <p>{{ $vInfo['manufacturer'] ?? '-' }}</p>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <div class="heavy-spec-card">
                                <h5>الموديل / النوع</h5>
                                <p>{{ $vInfo['model'] ?? '-' }}</p>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <div class="heavy-spec-card">
                                <h5>سنة التصنيع</h5>
                                <p class="english-nums">{{ $vInfo['manufacturing_year'] ?? '-' }}</p>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <div class="heavy-spec-card">
                                <h5>نوع المحرك / القدرة</h5>
                                <p>{{ $vInfo['motor_type'] ?? '-' }}</p>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <div class="heavy-spec-card">
                                <h5>الوزن الكلي</h5>
                                <p class="english-nums">{{ number_format($product->piece_weight) }} KG</p>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <div class="heavy-spec-card">
                                <h5>الحالة الفنية</h5>
                                <p>{{ $vInfo['condition'] ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Info Column -->
                <div class="col-md-5">
                    <div style="padding: 0 15px;">
                        <span class="label label-danger" style="font-size: 14px; padding: 6px 15px; border-radius: 20px; background: #c0392b !important;">
                            <i class="fa fa-truck"></i> معدات ثقيلة
                        </span>
                        <h2 style="font-weight: 900; color: #2c3e50; font-size: 36px; margin: 20px 0;">{{ $product->name }}</h2>
                        
                        <div style="background: #f8f9fa; border-radius: 12px; padding: 25px; margin-bottom: 30px; border: 1px solid #eee;">
                            <span class="text-muted" style="display: block; margin-bottom: 5px;">السعر التقديري للوحدة</span>
                            <span style="font-size: 44px; font-weight: 900; color: #1e3a5f; direction: ltr; display: inline-block; font-family: 'Inter', sans-serif;" class="english-nums">
                                {{ number_format($product->price, 2, '.', '') }} <small style="font-size: 20px; color: #c0392b; font-weight: bold;">{{ $product->currency_code }}</small>
                            </span>
                        </div>

                        <div style="margin-bottom: 30px;">
                            <h4 style="font-weight: 800; color: #333; border-right: 4px solid #c0392b; padding-right: 10px; margin-bottom: 15px;">الوصف العام</h4>
                            <div style="font-size: 16px; line-height: 1.8; color: #555; text-align: justify;">
                                {!! $product->description !!}
                            </div>
                        </div>

                        <div class="well well-sm" style="background: #fff; border: 1px solid #ddd; border-radius: 10px;">
                            <div class="row text-center">
                                <div class="col-xs-4" style="border-left: 1px solid #eee;">
                                    <span class="spec-label">الطول</span>
                                    <p class="english-nums mb-0"><b>{{ $product->carton_length }} m</b></p>
                                </div>
                                <div class="col-xs-4" style="border-left: 1px solid #eee;">
                                    <span class="spec-label">العرض</span>
                                    <p class="english-nums mb-0"><b>{{ $product->carton_width }} m</b></p>
                                </div>
                                <div class="col-xs-4">
                                    <span class="spec-label">الارتفاع</span>
                                    <p class="english-nums mb-0"><b>{{ $product->carton_height }} m</b></p>
                                </div>
                            </div>
                        </div>

                        <div style="margin-top: 40px; display: flex; gap: 15px;">
                            <button id="btnOrderModal" class="btn btn-danger btn-lg btn-flat" style="flex: 2; border-radius: 30px; font-weight: bold; font-size: 20px; padding: 12px; background: #c0392b; border: none; box-shadow: 0 4px 15px rgba(192, 57, 43, 0.3);" data-toggle="modal" data-target="#orderModal">
                                <i class="fa fa-shopping-cart"></i> اطلب الآن
                            </button>
                            <a href="{{ route('site.products.index') }}" class="btn btn-default btn-lg btn-flat" style="flex: 1; border-radius: 30px; padding: 12px; font-weight: bold;">
                                <i class="fa fa-arrow-right"></i> رجوع
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 8 Containers Logistics Section -->
            <div class="row" style="margin-top: 50px;">
                <div class="col-md-12">
                    <div style="background: #f8f9fa; border-radius: 25px; padding: 40px; border: 1px solid #eee; box-shadow: 0 10px 40px rgba(0,0,0,0.05);">
                        <div class="text-center mb-5">
                            <h2 style="font-weight: 900; color: #1e3a5f; margin-bottom: 10px;"><i class="fa fa-ship"></i> نظام تفاصيل شحن الحاويات المتقدم</h2>
                            <p style="color: #888;">يتم حساب سعة كل حاوية بناءً على أبعاد المنتج الفعلي مع تطبيق كافة معايير الأمان الدولية</p>
                            <div class="english-nums" style="font-size: 0.65rem;">{{ $product->carton_length }}x{{ $product->carton_width }}x{{ $product->carton_height }} m</div>
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

    <!-- Order Modal -->
    <div class="modal fade" id="orderModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="border-radius: 25px; overflow: hidden; border: none;">
                <div class="modal-header" style="background: #c0392b; color: white; padding: 25px;">
                    <button type="button" class="close" data-dismiss="modal" style="color: white; opacity: 1;">&times;</button>
                    <h4 class="modal-title" style="font-weight: 900; font-size: 22px;"><i class="fa fa-truck"></i> طلب تزويد معدات ثقيلة</h4>
                </div>
                <form id="orderForm">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <div class="modal-body" style="padding: 40px; background: #fefefe;">

                        {{-- Product Summary Card --}}
                        <div style="background: linear-gradient(135deg, #1e3a5f 0%, #2c5282 100%); border-radius: 16px; padding: 20px; margin-bottom: 25px; color: white; display: flex; gap: 20px; align-items: center;">
                            @php $firstImage = $product->images->first(); @endphp
                            @if($firstImage)
                            <img src="{{ asset('storage/' . $firstImage->image_path) }}" style="width: 90px; height: 90px; object-fit: cover; border-radius: 12px; border: 3px solid rgba(255,255,255,0.2); flex-shrink: 0;">
                            @endif
                            <div style="flex: 1; min-width: 0;">
                                <h4 style="margin: 0 0 6px; font-weight: 900; font-size: 18px; color: white;">{{ $product->name }}</h4>
                                @if($product->description)
                                <p style="margin: 0 0 12px; font-size: 12px; opacity: 0.85; line-height: 1.5; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                                    {{ strip_tags($product->description) }}
                                </p>
                                @endif
                                <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                                    <span style="background: rgba(255,255,255,0.15); border-radius: 8px; padding: 4px 10px; font-size: 12px; font-weight: bold;">
                                        <i class="fa fa-arrows-h"></i> <span class="english-nums">{{ $product->carton_length }} m</span>
                                    </span>
                                    <span style="background: rgba(255,255,255,0.15); border-radius: 8px; padding: 4px 10px; font-size: 12px; font-weight: bold;">
                                        <i class="fa fa-arrows-v"></i> <span class="english-nums">{{ $product->carton_width }} m</span>
                                    </span>
                                    <span style="background: rgba(255,255,255,0.15); border-radius: 8px; padding: 4px 10px; font-size: 12px; font-weight: bold;">
                                        <i class="fa fa-sort-amount-asc"></i> <span class="english-nums">{{ $product->carton_height }} m</span>
                                    </span>
                                    <span style="background: rgba(192,57,43,0.6); border-radius: 8px; padding: 4px 10px; font-size: 12px; font-weight: bold;">
                                        <i class="fa fa-balance-scale"></i> <span class="english-nums">{{ number_format($product->piece_weight) }} KG</span>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label style="font-weight: 800; color: #444;">العدد المطلوب</label>
                                    <input type="number" name="quantity" id="order_quantity" class="form-control" value="1" min="1" required style="height: 55px; font-size: 22px; font-weight: 900; border-radius: 12px;">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label style="font-weight: 800; color: #444;">نظام الشحن المقترح</label>
                                    <select name="shipping_unit_type" class="form-control" style="height: 55px; border-radius: 12px; font-weight: bold;">
                                        <option value="RoRo">RoRo (دحرجة)</option>
                                        <option value="FlatRack">Flat Rack (رف مسطح)</option>
                                        <option value="OpenTop">Open Top (سقف مفتوح)</option>
                                        <option value="Container">Container (حاوية قياسية)</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row" style="margin-top: 25px;">
                            <div class="col-md-6">
                                <div style="background: #fdf2f2; border: 1px dashed #d9534f; border-radius: 15px; padding: 15px; text-align: center; height: 100%;">
                                    <h5 style="color: #c0392b; font-weight: 800; margin-top: 0; font-size: 13px;">إجمالي القيمة التقديرية</h5>
                                    <div id="total_price_display" class="english-nums" style="font-size: 28px; font-weight: 950; color: #1e3a5f;">
                                        {{ number_format($product->price) }} {{ $product->currency_code }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div style="background: #f0f7ff; border: 1px dashed #3498db; border-radius: 15px; padding: 15px; text-align: center; height: 100%;">
                                    <h5 style="color: #2980b9; font-weight: 800; margin-top: 0; font-size: 13px;">إجمالي الوزن التقديري</h5>
                                    <div id="total_weight_display" class="english-nums" style="font-size: 28px; font-weight: 950; color: #1e3a5f;">
                                        {{ number_format($product->piece_weight) }} KG
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Logistics Recommendation Grid in Modal -->
                        <div style="margin-top: 30px;">
                            <h4 style="font-weight: 800; color: #333; border-right: 4px solid #f39c12; padding-right: 10px; margin-bottom: 20px; font-size: 16px;">
                                <i class="fa fa-ship"></i> تحليل الحاويات المقترحة للطلب
                            </h4>
                            <div id="modal_logistics_grid" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px;">
                                <!-- Will be populated by JS -->
                            </div>
                        </div>

                        <div class="form-group" style="margin-top: 30px;">
                            <label style="font-weight: 800; color: #444;">ملاحظات خاصة بالتجهيز أو الشحن</label>
                            <textarea name="notes" class="form-control" rows="4" style="border-radius: 15px;" placeholder="اكتب هنا أي تفاصيل تقنية أو متطلبات خاصة بالوجهة..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer" style="padding: 25px; background: #f9f9f9;">
                        <button type="button" class="btn btn-default btn-lg" data-dismiss="modal" style="border-radius: 30px; font-weight: bold;">إلغاء</button>
                        <button type="submit" class="btn btn-danger btn-lg" style="background: #c0392b; border: none; border-radius: 30px; padding: 12px 50px; font-weight: 900; box-shadow: 0 5px 15px rgba(192, 57, 43, 0.4);">
                            تأكيد وإرسال الطلب
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    const L = parseFloat("{{ $product->carton_length }}") || 0;
    const W = parseFloat("{{ $product->carton_width }}") || 0;
    const H = parseFloat("{{ $product->carton_height }}") || 0;
    const unitPrice = parseFloat("{{ $product->price }}") || 0;
    const unitWeight = parseFloat("{{ $product->piece_weight }}") || 0;
    const currency = "{{ $product->currency_code }}";
    
    // Safety Margins (m)
    const BUMPER_GAP = 0.25;
    const WALL_GAP = 0.10;
    const ROOF_GAP = 0.15;

    // Containers Metadata from PHP
    const containerProtocols = @json($allContainers);

    function updateModalLogistics() {
        let qty = parseFloat($('#order_quantity').val()) || 0;
        let totalPrice = unitPrice * qty;
        let totalWeight = unitWeight * qty;

        // Update basic displays
        $('#total_price_display').text(totalPrice.toLocaleString() + ' ' + currency);
        $('#total_weight_display').text(totalWeight.toLocaleString() + ' KG');

        // Update Logistics Grid (Container Finder Mode)
        let grid = $('#modal_logistics_grid');
        grid.empty();
        let foundCount = 0;

        containerProtocols.forEach(c => {
            let capFlat = 0, capRack = 0, capSteel = 0, capCassette = 0, capTimber = 0;
            
            if (!c.roro) {
                let hasRoof = c.hasRoof !== false;
                let hasWalls = c.hasWalls !== false;
                
                let fitsW = !hasWalls || ((W + (WALL_GAP * 2)) <= c.intW);
                let fitsH = !hasRoof || ((H + ROOF_GAP) <= c.intH);
                
                if (fitsW && fitsH && L > 0) {
                    capFlat     = Math.floor((c.intL + BUMPER_GAP) / (L + BUMPER_GAP));
                    capRack     = Math.floor((c.intL + BUMPER_GAP) / ((L * 0.72) + BUMPER_GAP));
                    capSteel    = Math.floor((c.intL + BUMPER_GAP) / ((L * 0.68) + BUMPER_GAP));
                    capCassette = Math.floor((c.intL + BUMPER_GAP) / ((L * 0.62) + BUMPER_GAP));
                    capTimber   = Math.floor((c.intL + BUMPER_GAP) / ((L * 0.82) + BUMPER_GAP));
                    
                    if (c.intL > 11.5 && L <= 4.8) {
                        capRack  = Math.max(capRack, 3);
                        capSteel = Math.max(capSteel, 4);
                    }
                }
            }

            // Helper: required containers for this qty using this system
            function reqFor(cap) {
                if (!cap || cap <= 0) return null;
                return Math.ceil(qty / cap);
            }

            function containerLabel(n) {
                if (n === 1) return 'حاوية';
                if (n === 2) return 'حاويتان';
                return 'حاويات';
            }

            function systemRow(label, cap) {
                if (!cap || cap <= 0) return '';
                const needed = reqFor(cap);
                const word = containerLabel(needed);
                return `
                    <div style="background:rgba(0,0,0,0.08); border-radius:8px; padding:8px 10px; margin-bottom:5px;">
                        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:5px;">
                            <span style="font-size:11px; font-weight:bold;">${label}</span>
                            <span style="font-size:10px; opacity:0.75;">سعة الحاوية: <b class="english-nums">${cap}</b> قطعة</span>
                        </div>
                        <div style="background:rgba(255,255,255,0.2); border-radius:6px; padding:5px 0; text-align:center; font-size:15px; font-weight:900; display:flex; align-items:center; justify-content:center; gap:8px;">
                            <span style="font-size:22px; line-height:1;">🚢</span>
                            <span><span class="english-nums">${needed}</span> ${word}</span>
                        </div>
                    </div>
                `;
            }

            let bodyHtml = '';
            if (c.roro) {
                bodyHtml = `
                    <div style="text-align:center; padding:15px 0;">
                        <div style="font-size:28px; margin-bottom:5px;">🚢</div>
                        <div style="font-weight:bold; margin-bottom:4px;">شحن دحرجة (RoRo)</div>
                        <div style="font-size:11px; opacity:0.8;">تحميل مباشر على السفينة</div>
                        ${qty > 0 ? `<div style="margin-top:10px; background:rgba(255,255,255,0.2); border-radius:8px; padding:6px 10px; font-size:13px; font-weight:bold;">إجمالي القطع: <span class="english-nums">${qty}</span> قطعة</div>` : ''}
                    </div>
                `;
            } else {
                const systems = [
                    { label: 'الأرضي (Flat)',    cap: capFlat },
                    { label: 'المائل (Racking)', cap: capRack },
                    { label: 'فولاذي (Steel)',   cap: capSteel },
                    { label: 'الخشبي (Timber)',  cap: capTimber },
                ];
                const hasAny = systems.some(s => s.cap > 0);

                bodyHtml = `
                    <div style="font-size:11px; font-weight:bold; opacity:0.85; margin-bottom:6px; border-bottom:1px solid rgba(255,255,255,0.15); padding-bottom:4px;">
                        الحاويات المطلوبة لـ <span class="english-nums" style="font-size:14px; font-weight:900;">${qty || '?'}</span> قطعة:
                    </div>
                    ${hasAny
                        ? systems.map(s => systemRow(s.label, s.cap)).join('')
                        : `<div style="text-align:center; opacity:0.7; font-size:11px; padding:10px 0;">الأبعاد تتجاوز حدود هذه الحاوية</div>`
                    }
                `;
            }

            let html = `
                <div style="background: ${c.color}; border-radius: 12px; overflow: hidden; color: white; box-shadow: 0 4px 15px rgba(0,0,0,0.1); display: flex; flex-direction: column;">
                    <div style="padding: 10px 15px; background: rgba(0,0,0,0.12); display: flex; justify-content: space-between; align-items: center;">
                        <h6 style="margin: 0; font-weight: 800; font-size: 13px;">${c.name}</h6>
                        <i class="fa ${c.icon}" style="font-size: 16px; opacity: 0.6;"></i>
                    </div>
                    <div style="padding: 12px;">
                        ${bodyHtml}
                    </div>
                </div>
            `;
            grid.append(html);
        });
    }

    $('#order_quantity').on('input change', updateModalLogistics);
    
    $('#orderModal').on('shown.bs.modal', function() {
        updateModalLogistics();
    });

    $('#orderForm').on('submit', function(e) {
        e.preventDefault();
        const btn = $(this).find('button[type="submit"]');
        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> جاري الإرسال...');

        const qty = parseInt($('#order_quantity').val()) || 1;

        $.ajax({
            url: "{{ route('orders.store') }}",
            method: 'POST',
            data: $(this).serialize(),
            success: function(res) {
                // Save to HeavyCart localStorage
                if (window.HeavyCart) {
                    @php $firstImg = $product->images->first(); @endphp
                    HeavyCart.add({
                        id:          "{{ $product->id }}",
                        name:        "{{ addslashes($product->name) }}",
                        image:       "{{ $firstImg ? asset('storage/' . $firstImg->image_path) : asset('dist/img/boxed-bg.jpg') }}",
                        L:           {{ $product->carton_length }},
                        W:           {{ $product->carton_width }},
                        H:           {{ $product->carton_height }},
                        unitWeight:  {{ $product->piece_weight }},
                        unitPrice:   {{ $product->price }},
                        currency:    "{{ $product->currency_code }}",
                        qty:         qty,
                        totalWeight: {{ $product->piece_weight }} * qty,
                        totalPrice:  {{ $product->price }} * qty,
                        containers:  @json($allContainers),
                    });
                }

                $('#orderModal').modal('hide');

                Swal.fire({
                    icon: 'success',
                    title: 'تم إرسال الطلب',
                    text: 'تمت إضافة طلبك إلى السلة. سيتم التواصل معك قريباً.',
                    confirmButtonColor: '#c0392b',
                    showCancelButton: true,
                    confirmButtonText: 'عرض السلة',
                    cancelButtonText: 'إغلاق',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#cbmInfoModal').modal('show');
                        setTimeout(() => $('a[href="#tab_heavy"]').tab('show'), 400);
                    }
                });

                btn.prop('disabled', false).text('تأكيد وإرسال الطلب');
            },
            error: function(err) {
                btn.prop('disabled', false).text('تأكيد وإرسال الطلب');
                Swal.fire({ icon: 'error', title: 'خطأ', text: 'فشل إرسال الطلب، حاول ثانية.' });
            }
        });
    });
});
</script>
@endpush
@endsection
