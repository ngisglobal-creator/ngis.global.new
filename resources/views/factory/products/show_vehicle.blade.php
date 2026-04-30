@extends('factory.layouts.master')

@section('title', 'تفاصيل المركبة: ' . $product->name)

@section('content')
<style>
    :root {
        --primary-dark: #1e3a5f;
        --secondary-blue: #3c8dbc;
        --accent-orange: #f39c12;
        --danger-red: #dd4b39;
        --success-green: #00a65a;
        --light-gray: #f4f7f9;
    }

    .vehicle-header {
        background: linear-gradient(135deg, var(--primary-dark) 0%, var(--secondary-blue) 100%);
        color: white;
        padding: 30px;
        border-radius: 15px;
        margin-bottom: 25px;
        box-shadow: 0 10px 30px rgba(30, 58, 95, 0.15);
        position: relative;
        overflow: hidden;
    }

    .vehicle-header::after {
        content: '\f1b9';
        font-family: FontAwesome;
        position: absolute;
        right: -20px;
        bottom: -30px;
        font-size: 180px;
        color: rgba(255, 255, 255, 0.05);
        transform: rotate(-15deg);
    }

    .spec-card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        text-align: center;
        border: 1px solid #eee;
        transition: all 0.3s ease;
        height: 100%;
    }

    .spec-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 15px rgba(0,0,0,0.05);
        border-color: var(--secondary-blue);
    }

    .spec-icon {
        font-size: 24px;
        color: var(--secondary-blue);
        margin-bottom: 10px;
    }

    .spec-value {
        font-size: 20px;
        font-weight: 800;
        color: #333;
        display: block;
    }

    .spec-label {
        font-size: 12px;
        color: #888;
        text-transform: uppercase;
    }

    .container-card {
        background: white;
        border-radius: 15px;
        border: 1px solid #e0e0e0;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .container-card-header {
        background: var(--light-gray);
        padding: 15px 20px;
        border-bottom: 1px solid #eee;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .container-card-body {
        padding: 20px;
        flex-grow: 1;
    }

    .margin-item {
        display: flex;
        justify-content: space-between;
        padding: 8px 0;
        border-bottom: 1px dashed #eee;
        font-size: 13px;
    }

    .margin-item:last-child {
        border-bottom: none;
    }

    .margin-label {
        color: #666;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .margin-value {
        font-weight: bold;
        color: var(--primary-dark);
    }

    .img-zoom-container {
        position: relative;
        cursor: crosshair;
    }

    .main-vehicle-img {
        width: 100%;
        height: 450px;
        object-fit: contain;
        background: #fff;
        border-radius: 12px;
    }

    .thumb-scroll {
        display: flex;
        gap: 10px;
        overflow-x: auto;
        padding: 10px 0;
    }

    .thumb-item {
        width: 80px;
        height: 80px;
        border: 2px solid transparent;
        border-radius: 8px;
        cursor: pointer;
        object-fit: cover;
        transition: all 0.2s;
    }

    .thumb-item.active {
        border-color: var(--secondary-blue);
    }

    .price-tag {
        font-size: 32px;
        font-weight: 900;
        color: var(--primary-dark);
    }

    .label-premium {
        padding: 5px 15px;
        border-radius: 20px;
        font-weight: bold;
        text-transform: uppercase;
        font-size: 12px;
    }
</style>

<section class="content">
    <!-- Premium Header -->
    <div class="vehicle-header">
        <div class="row">
            <div class="col-md-8">
                <span class="label {{ $product->vehicle_group === 'light' ? 'label-warning' : 'label-danger' }} label-premium" style="margin-bottom: 15px; display: inline-block;">
                    <i class="fa {{ $product->vehicle_group === 'light' ? 'fa-car' : 'fa-truck' }}"></i> 
                    {{ $product->vehicle_group === 'light' ? 'مركبة خفيفة' : 'معدات ثقيلة' }}
                </span>
                <h1 style="margin: 0; font-weight: 900; font-size: 36px;">{{ $product->name }}</h1>
                <p style="opacity: 0.8; margin-top: 10px; font-size: 16px;">
                    <i class="fa fa-barcode"></i> SKU: {{ $product->sku ?? 'N/A' }} | 
                    <i class="fa fa-folder"></i> {{ $product->category->name_ar }}
                </p>
            </div>
            <div class="col-md-4 text-right">
                <div style="background: rgba(255,255,255,0.1); padding: 20px; border-radius: 12px; display: inline-block; min-width: 200px;">
                    <div style="font-size: 14px; opacity: 0.8;">السعر الأساسي المنتج</div>
                    <div class="english-nums" style="font-size: 40px; font-weight: 900;">
                        {{ number_format($product->price, 2) }} <small style="font-size: 16px; color: #fff;">{{ $product->currency_code }}</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Visuals Column -->
        <div class="col-md-5">
            <div class="box box-solid" style="border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
                <div class="box-body">
                    <div class="img-zoom-container">
                        @if($product->images->count() > 0)
                            <img id="main-vehicle-image" src="{{ asset('storage/' . $product->images->first()->image_path) }}" class="main-vehicle-img">
                        @else
                            <div class="main-vehicle-img" style="display: flex; align-items: center; justify-content: center; background: #f9f9f9;">
                                <i class="fa fa-picture-o" style="font-size: 80px; color: #ddd;"></i>
                            </div>
                        @endif
                    </div>
                    
                    @if($product->images->count() > 1)
                        <div class="thumb-scroll">
                            @foreach($product->images as $image)
                                <img src="{{ asset('storage/' . $image->image_path) }}" 
                                     class="thumb-item {{ $loop->first ? 'active' : '' }}"
                                     onclick="updateGallery('{{ asset('storage/' . $image->image_path) }}', this)">
                            @endforeach
                        </div>
                    @endif

                    <hr>
                    <div class="description">
                        <h4 style="font-weight: bold; color: var(--primary-dark);"><i class="fa fa-info-circle"></i> وصف المركبة</h4>
                        <div style="line-height: 1.8; color: #555;">
                            {!! $product->description !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Technical Specs Column -->
        <div class="col-md-7">
            <!-- Dimensions Bar -->
            <div class="row" style="margin-bottom: 25px;">
                <div class="col-md-3">
                    <div class="spec-card">
                        <i class="fa fa-arrows-h spec-icon"></i>
                        <span class="spec-value english-nums">{{ $product->carton_length }} <small>cm</small></span>
                        <span class="spec-label">الطول</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="spec-card">
                        <i class="fa fa-arrows-v spec-icon"></i>
                        <span class="spec-value english-nums">{{ $product->carton_width }} <small>cm</small></span>
                        <span class="spec-label">العرض</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="spec-card">
                        <i class="fa fa-expand spec-icon"></i>
                        <span class="spec-value english-nums">{{ $product->carton_height }} <small>cm</small></span>
                        <span class="spec-label">الارتفاع</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="spec-card">
                        <i class="fa fa-balance-scale spec-icon"></i>
                        <span class="spec-value english-nums">{{ number_format($product->piece_weight) }} <small>kg</small></span>
                        <span class="spec-label">الوزن</span>
            </div>

            <!-- Ultimate Vehicle Technical Report -->
            @php
                $vInfo = $logistics['vehicle_info'] ?? null;
            @endphp
            
            @if($vInfo)
            <!-- Section 1: Vehicle Identity -->
            <div style="background: white; border-radius: 15px; border: 1px solid #eef2f6; padding: 25px; margin-bottom: 25px; box-shadow: 0 4px 15px rgba(0,0,0,0.03);">
                <h4 style="font-weight: 800; color: var(--primary-dark); margin-top: 0; margin-bottom: 20px; border-bottom: 2px solid #f8fafc; padding-bottom: 12px;">
                    <i class="fa fa-id-card text-primary"></i> المعلومات التعريفية للمركبة
                </h4>
                <div class="row">
                    <div class="col-md-4">
                        <div style="margin-bottom: 15px;">
                            <span style="font-size: 11px; color: #94a3b8; display: block;">الشركة المصنعة / الموديل</span>
                            <b style="font-size: 16px; color: #334155;">{{ $vInfo['manufacturer'] ?? '---' }} {{ $vInfo['model'] ?? '' }} ({{ $vInfo['year'] ?? '' }})</b>
                        </div>
                        <div style="margin-bottom: 15px;">
                            <span style="font-size: 11px; color: #94a3b8; display: block;">رقم الهيكل (VIN)</span>
                            <b class="english-nums" style="color: #334155;">{{ $vInfo['vin'] ?: '---' }}</b>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div style="margin-bottom: 15px;">
                            <span style="font-size: 11px; color: #94a3b8; display: block;">الفئة والنوع</span>
                            <b style="color: #334155;">{{ $vInfo['class'] ?: '---' }} | {{ $vInfo['type'] ?: '---' }}</b>
                        </div>
                        <div style="margin-bottom: 15px;">
                            <span style="font-size: 11px; color: #94a3b8; display: block;">رقم اللوحة</span>
                            <b class="english-nums" style="color: #334155;">{{ $vInfo['plate'] ?: '---' }}</b>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div style="background: #f8fafc; border-radius: 10px; padding: 15px; text-align: center; border: 1px solid #edf2f7;">
                            <span style="font-size: 11px; color: #94a3b8; display: block;">حالة الاستخدام</span>
                            <span class="label {{ ($vInfo['condition'] ?? 'new') === 'new' ? 'label-success' : 'label-info' }}" style="font-size: 14px; padding: 5px 15px; border-radius: 5px;">
                                {{ ($vInfo['condition'] ?? 'new') === 'new' ? 'جديدة (New)' : 'مستعملة (Used)' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 2: Engine & Power (The Heart) -->
            <div style="background: white; border-radius: 15px; border: 1px solid #eef2f6; padding: 25px; margin-bottom: 25px; box-shadow: 0 4px 15px rgba(0,0,0,0.03);">
                <h4 style="font-weight: 800; color: var(--primary-dark); margin-top: 0; margin-bottom: 25px; border-bottom: 2px solid #f8fafc; padding-bottom: 12px;">
                    <i class="fa fa-cogs text-primary"></i> المحرك والأداء (Technical Engine Specs)
                </h4>
                <div class="row">
                    <div class="col-md-3 text-center" style="border-left: 1px solid #f0f0f0;">
                        <i class="fa fa-fire" style="color: #e67e22; font-size: 20px; margin-bottom: 8px;"></i>
                        <div style="font-size: 11px; color: #94a3b8;">نوع المحرك</div>
                        <b style="color: #334155;">{{ $vInfo['engine_type'] ?: '---' }}</b>
                    </div>
                    <div class="col-md-3 text-center" style="border-left: 1px solid #f0f0f0;">
                        <i class="fa fa-cube" style="color: #3c8dbc; font-size: 20px; margin-bottom: 8px;"></i>
                        <div style="font-size: 11px; color: #94a3b8;">سعة المحرك</div>
                        <b class="english-nums" style="color: #334155;">{{ $vInfo['engine_cc'] ?: '---' }} <small>CC</small></b>
                    </div>
                    <div class="col-md-3 text-center" style="border-left: 1px solid #f0f0f0;">
                        <i class="fa fa-flash" style="color: #f1c40f; font-size: 20px; margin-bottom: 8px;"></i>
                        <div style="font-size: 11px; color: #94a3b8;">القوة الحصانية</div>
                        <b class="english-nums" style="color: #334155;">{{ $vInfo['horsepower'] ?: '---' }} <small>HP</small></b>
                    </div>
                    <div class="col-md-3 text-center">
                        <i class="fa fa-circle-o-notch" style="color: #9b59b6; font-size: 20px; margin-bottom: 8px;"></i>
                        <div style="font-size: 11px; color: #94a3b8;">الأسطوانات</div>
                        <b class="english-nums" style="color: #334155;">{{ $vInfo['cylinders'] ?: '---' }}</b>
                    </div>
                </div>
                <div class="row" style="margin-top: 25px; padding-top: 20px; border-top: 1px solid #f8fafc;">
                    <div class="col-md-4">
                        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 15px;">
                            <div style="width: 35px; height: 35px; background: #f0f7ff; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #3c8dbc;">
                                <i class="fa fa-toggle-on"></i>
                            </div>
                            <div>
                                <span style="font-size: 11px; color: #94a3b8; display: block;">ناقل الحركة</span>
                                <b style="color: #334155;">{{ $vInfo['transmission'] ?: '---' }}</b>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 15px;">
                            <div style="width: 35px; height: 35px; background: #fff5e6; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #e67e22;">
                                <i class="fa fa-arrows"></i>
                            </div>
                            <div>
                                <span style="font-size: 11px; color: #94a3b8; display: block;">نظام الدفع</span>
                                <b style="color: #334155;">{{ $vInfo['drive_system'] ?: '---' }}</b>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 15px;">
                            <div style="width: 35px; height: 35px; background: #f4faf2; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #00a65a;">
                                <i class="fa fa-tint"></i>
                            </div>
                            <div>
                                <span style="font-size: 11px; color: #94a3b8; display: block;">استهلاك الوقود</span>
                                <b class="english-nums" style="color: #334155;">{{ $vInfo['fuel_consumption'] ?: '---' }}</b>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div style="display: flex; align-items: center; gap: 12px; margin-top: 5px;">
                            <div style="width: 35px; height: 35px; background: #fffcf0; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #f1c40f;">
                                <i class="fa fa-dashboard"></i>
                            </div>
                            <div>
                                <span style="font-size: 11px; color: #94a3b8; display: block;">السرعة القصوى / التسارع</span>
                                <b class="english-nums" style="color: #334155;">{{ $vInfo['max_speed'] ?? '---' }} km/h | {{ $vInfo['acceleration'] ?? '---' }}</b>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 3: Usage History -->
            <div style="background: white; border-radius: 15px; border: 1px solid #eef2f6; padding: 25px; margin-bottom: 25px; box-shadow: 0 4px 15px rgba(0,0,0,0.03);">
                <h4 style="font-weight: 800; color: var(--primary-dark); margin-top: 0; margin-bottom: 20px; border-bottom: 2px solid #f8fafc; padding-bottom: 12px;">
                    <i class="fa fa-history text-primary"></i> السجل والاستخدام (Condition & History)
                </h4>
                <div class="row">
                    <div class="col-md-3 text-center" style="border-left: 1px solid #f0f0f0;">
                        <div style="font-size: 11px; color: #94a3b8;">المسافة المقطوعة</div>
                        <div class="english-nums" style="font-size: 18px; font-weight: 800; color: #333;">{{ number_format($vInfo['mileage'] ?? 0) }} <small style="font-size: 10px;">KM</small></div>
                    </div>
                    <div class="col-md-3 text-center" style="border-left: 1px solid #f0f0f0;">
                        <div style="font-size: 11px; color: #94a3b8;">المالكين السابقين</div>
                        <div class="english-nums" style="font-size: 18px; font-weight: 800; color: #333;">{{ $vInfo['previous_owners'] ?? 0 }}</div>
                    </div>
                    <div class="col-md-3 text-center" style="border-left: 1px solid #f0f0f0;">
                        <div style="font-size: 11px; color: #94a3b8;">الحالة الفنية</div>
                        @php
                            $states = ['excellent' => 'ممتازة', 'good' => 'جيدة', 'maintenance_needed' => 'تحتاج صيانة'];
                            $state = $vInfo['vehicle_state'] ?? 'excellent';
                        @endphp
                        <div style="font-size: 16px; font-weight: 800; color: {{ $state === 'excellent' ? '#00a65a' : ($state === 'good' ? '#f39c12' : '#dd4b39') }};">
                            {{ $states[$state] ?? $state }}
                        </div>
                    </div>
                    <div class="col-md-3 text-center">
                        <div style="font-size: 11px; color: #94a3b8;">آخر صيانة</div>
                        <div class="english-nums" style="font-size: 15px; font-weight: 700;">{{ $vInfo['last_maintenance_date'] ?: 'غير مسجل' }}</div>
                    </div>
                </div>

                @if(isset($vInfo['accident_history']) && $vInfo['accident_history'] === 'yes')
                <div style="margin-top: 15px; background: #fff5f5; border: 1px solid #ffdada; border-radius: 8px; padding: 12px; display: flex; gap: 15px; align-items: flex-start;">
                    <i class="fa fa-warning" style="color: #dd4b39; font-size: 18px;"></i>
                    <div>
                        <b style="color: #dd4b39; display: block; margin-bottom: 3px;">تنبيه: يوجد سجل حوادث سابق</b>
                        <p style="font-size: 12px; margin: 0; color: #666;">{{ $vInfo['accident_details'] ?: 'لا توجد تفاصيل إرشادية إضافية.' }}</p>
                    </div>
                </div>
                @endif
            </div>

            <!-- Section 4: Features Icons -->
            @if(isset($vInfo['features']) && is_array($vInfo['features']) && count($vInfo['features']) > 0)
            <div style="background: white; border-radius: 15px; border: 1px solid #eef2f6; padding: 25px; margin-bottom: 25px; box-shadow: 0 4px 15px rgba(0,0,0,0.03);">
                <h4 style="font-weight: 800; color: var(--primary-dark); margin-top: 0; margin-bottom: 20px;">
                    <i class="fa fa-star text-primary"></i> المواصفات والإضافات الذكية (Smart Features)
                </h4>
                <div style="display: flex; flex-wrap: wrap; gap: 12px;">
                    @php
                        $featureMap = [
                            'ac' => ['name' => 'مكيف', 'icon' => 'fa-snowflake-o'],
                            'sunroof' => ['name' => 'فتحة سقف', 'icon' => 'fa-external-link'],
                            'rear_camera' => ['name' => 'كاميرا خلفية', 'icon' => 'fa-video-camera'],
                            'sensors' => ['name' => 'حساسات', 'icon' => 'fa-rss'],
                            'screen' => ['name' => 'شاشة', 'icon' => 'fa-tv'],
                            'bluetooth' => ['name' => 'بلوتوث', 'icon' => 'fa-bluetooth'],
                            'gps' => ['name' => 'GPS', 'icon' => 'fa-map-marker'],
                            'leather_seats' => ['name' => 'مقاعد جلدية', 'icon' => 'fa-id-card-o'],
                            'heated_seats' => ['name' => 'تدفئة مقاعد', 'icon' => 'fa-thermometer-three-quarters'],
                            'abs' => ['name' => 'ABS', 'icon' => 'fa-shield'],
                            'airbags' => ['name' => 'Airbags', 'icon' => 'fa-circle-o-notch'],
                        ];
                    @endphp
                    @foreach($vInfo['features'] as $fKey)
                        @if(isset($featureMap[$fKey]))
                        <span style="background: #f8fafc; border: 1px solid #edf2f7; border-radius: 20px; padding: 8px 15px; font-size: 13px; color: #334155; display: flex; align-items: center; gap: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
                            <i class="fa {{ $featureMap[$fKey]['icon'] }} text-primary"></i> {{ $featureMap[$fKey]['name'] }}
                        </span>
                        @endif
                    @endforeach
                </div>
            </div>
            @endif
            @endif

            <!-- Section 5: Logistics & Pricing Summary Table -->
            <div style="background: white; border-radius: 15px; border: 1px solid #eef2f6; padding: 25px; margin-bottom: 25px; box-shadow: 0 4px 15px rgba(0,0,0,0.03);">
                <h4 style="font-weight: 800; color: var(--primary-dark); margin-top: 0; margin-bottom: 20px; border-bottom: 2px solid #f8fafc; padding-bottom: 12px;">
                    <i class="fa fa-table text-primary"></i> ملخص البيانات اللوجستية والوزن (Logistics Specs)
                </h4>
                <div class="table-responsive">
                    <table class="table table-bordered text-center" style="margin-bottom: 0;">
                        <thead style="background: #fcfcfc;">
                            <tr style="font-size: 11px; color: #64748b;">
                                <th>اسم المنتج</th>
                                <th>ID المنتج</th>
                                <th>السعر</th>
                                <th>N.W (KG)</th>
                                <th>G.W (KG)</th>
                                <th>L (cm)</th>
                                <th>W (cm)</th>
                                <th>H (cm)</th>
                                <th>Unit CBM</th>
                                <th>Total CBM</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr style="font-weight: bold; color: #334155;">
                                <td>{{ $product->name }}</td>
                                <td class="english-nums">{{ $product->sku ?: '---' }}</td>
                                <td class="english-nums" style="color: #3c8dbc;">{{ number_format($product->price, 2) }} {{ $product->currency_code }}</td>
                                <td class="english-nums">{{ number_format($product->piece_weight) }}</td>
                                <td class="english-nums" style="color: #e74c3c;">{{ number_format($product->total_weight) }}</td>
                                <td class="english-nums">{{ $product->carton_length }}</td>
                                <td class="english-nums">{{ $product->carton_width }}</td>
                                <td class="english-nums">{{ $product->carton_height }}</td>
                                <td class="english-nums">{{ $product->carton_volume_cbm }}</td>
                                <td class="english-nums" style="color: #00a65a;">{{ $product->total_cbm }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Specialized Logistics Report -->
            <h3 style="font-weight: 800; color: var(--primary-dark); margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
                <span style="width: 5px; height: 25px; background: var(--secondary-blue); border-radius: 3px;"></span>
                تقرير الحاويات المتخصصة ومعايير الأمان
            </h3>

            <div class="row">
                @php
                    $logistics = $product->logistics_details;
                    $displayContainers = [];
                    if (is_array($logistics)) {
                        if (isset($logistics['light_margin_details']) || isset($logistics['heavy_margin_details'])) {
                            $displayContainers = ($product->vehicle_group === 'light') 
                                ? ($logistics['light_margin_details'] ?? []) 
                                : ($logistics['heavy_margin_details'] ?? []);
                        } else {
                            // Support direct array format if exists
                            $displayContainers = $logistics;
                        }
                    }
                @endphp

                @if(count($displayContainers) > 0)
                    @foreach($displayContainers as $key => $lc)
                        @if(is_array($lc) && (isset($lc['margins']) || isset($lc['dims'])))
                        <div class="col-md-6" style="margin-bottom: 20px;">
                            <div class="container-card">
                                <div class="container-card-header">
                                    <span style="font-weight: 800; color: var(--primary-dark);"><i class="fa fa-ship"></i> {{ $lc['label'] ?? $lc['name'] ?? $key }}</span>
                                    <span class="label label-primary english-nums">{{ $lc['factor'] }} CBM</span>
                                </div>
                                <div class="container-card-body">
                                    <div style="background: #fcfcfc; border: 1px solid #eee; border-radius: 8px; padding: 10px; margin-bottom: 15px;">
                                        <div style="font-size: 11px; color: #999; text-align: center; margin-bottom: 8px;">أبعاد الحاوية المتخصصة</div>
                                        <div class="english-nums" style="text-align: center; font-weight: bold; font-size: 13px;">
                                            {{ $lc['dims']['l'] }} × {{ $lc['dims']['w'] }} × {{ $lc['dims']['h'] }}
                                        </div>
                                    </div>

                                    <div class="margins-section">
                                        <div style="font-size: 12px; font-weight: bold; color: var(--secondary-blue); margin-bottom: 10px;">سعة السيارات حسب معايير الأمان:</div>
                                        <div class="margin-item">
                                            <span class="margin-label"><i class="fa fa-square-o"></i> الأرضي (Flat):</span>
                                            <span class="margin-value">{{ $lc['margins']['flat'] }} سيارة</span>
                                        </div>
                                        <div class="margin-item">
                                            <span class="margin-label"><i class="fa fa-chevron-up"></i> المائل (Racking):</span>
                                            <span class="margin-value">{{ $lc['margins']['rack'] }} سيارة</span>
                                        </div>
                                        <div class="margin-item">
                                            <span class="margin-label"><i class="fa fa-link"></i> فولاذي (Steel):</span>
                                            <span class="margin-value">{{ $lc['margins']['steel'] }} سيارة</span>
                                        </div>
                                        <div class="margin-item">
                                            <span class="margin-label"><i class="fa fa-clone"></i> منصات (Cassette):</span>
                                            <span class="margin-value">{{ $lc['margins']['cassette'] }} سيارة</span>
                                        </div>
                                        <div class="margin-item">
                                            <span class="margin-label"><i class="fa fa-tree"></i> الخشبي (Timber):</span>
                                            <span class="margin-value">{{ $lc['margins']['timber'] }} سيارة</span>
                                        </div>
                                    </div>

                                    <div style="margin-top: 20px; padding-top: 15px; border-top: 2px solid var(--light-gray);">
                                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 5px;">
                                            <span style="color: #888;">القطع الكلية:</span>
                                            <span class="english-nums" style="font-weight: 800;">{{ number_format($lc['totalPcs']) }}</span>
                                        </div>
                                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                                            <span style="color: #888;">الوزن الإجمالي:</span>
                                            <span class="english-nums" style="font-weight: 800; color: var(--danger-red);">{{ number_format($lc['totalWeight']) }} kg</span>
                                        </div>
                                        <div style="background: var(--primary-dark); color: white; padding: 12px; border-radius: 8px; display: flex; justify-content: space-between; align-items: center;">
                                            <span style="font-size: 12px; opacity: 0.8;">السعر الإجمالي:</span>
                                            <span class="english-nums" style="font-size: 18px; font-weight: 900;">
                                                {{ number_format($lc['totalPrice']) }} <small style="color: #fff; font-size: 11px;">{{ $product->currency_code }}</small>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    @endforeach
                @else
                    <!-- Fallback to Standard Logistics if Specialized is Missing -->
                    <div class="col-md-12">
                        <div style="background: #fcfcfc; border: 1px solid #eee; border-radius: 12px; padding: 20px;">
                            <h5 style="font-weight: 800; color: #3c8dbc; margin-bottom: 15px; border-bottom: 1px solid #efefef; padding-bottom: 10px;">
                                <i class="fa fa-ship"></i> سعة الشحن القياسية (لحين توفر تفاصيل متخصصة)
                            </h5>
                            <div class="row">
                                @php
                                    $unitCbm = $product->carton_volume_cbm > 0 ? $product->carton_volume_cbm : 1;
                                    $piecesPerCarton = $product->product_piece_count > 0 ? $product->product_piece_count : 1;
                                    
                                    $containers = [
                                        ['name' => 'حاوية 20 قدم', 'cap' => 28, 'icon' => 'fa-th-large', 'saved' => $product->container_20ft_capacity],
                                        ['name' => 'حاوية 40 قدم', 'cap' => 40, 'icon' => 'fa-th-large', 'saved' => $product->container_40ft_capacity],
                                        ['name' => 'حاوية 40 قدم HQ', 'cap' => 68, 'icon' => 'fa-truck', 'saved' => $product->container_4hq_capacity],
                                        ['name' => 'حاوية 45 قدم', 'cap' => 78, 'icon' => 'fa-ship', 'saved' => $product->container_45ft_capacity]
                                    ];
                                @endphp

                                @foreach($containers as $container)
                                    @php
                                        $cartons = $container['saved'] ?? floor($container['cap'] / $unitCbm);
                                        $totalPieces = $cartons * $piecesPerCarton;
                                        $totalWeightKg = $totalPieces * $product->piece_weight;
                                        $weightStr = $totalWeightKg > 1000 ? number_format($totalWeightKg / 1000, 2) . ' Ton' : number_format($totalWeightKg, 2) . ' KG';
                                    @endphp
                                    <div class="col-md-4 col-xs-12" style="margin-bottom: 15px;">
                                        <div style="background: #fff; border: 1px solid #f0f0f0; border-radius: 8px; padding: 15px;">
                                            <div style="font-weight: bold; color: #555; margin-bottom: 10px; font-size: 14px;">
                                                <i class="fa {{ $container['icon'] }} text-blue"></i> {{ $container['name'] }}
                                            </div>
                                            <div style="display: flex; justify-content: space-between; font-size: 13px; margin-bottom: 5px;">
                                                <span>إجمالي القطع:</span>
                                                <span class="english-nums" style="font-weight: bold;">{{ number_format($totalPieces) }}</span>
                                            </div>
                                            <div style="display: flex; justify-content: space-between; font-size: 13px; margin-bottom: 5px;">
                                                <span>إجمالي الوزن:</span>
                                                <span class="english-nums" style="font-weight: bold; color: #d9534f;">{{ $weightStr }}</span>
                                            </div>
                                            <div style="display: flex; justify-content: space-between; font-size: 13px; border-top: 1px solid #f9f9f9; padding-top: 5px; margin-top: 5px;">
                                                <span style="color: #3c8dbc; font-weight: bold;">التكلفة المتوقعة:</span>
                                                <span class="english-nums" style="font-weight: bold; color: #3c8dbc;">
                                                    {{ $product->currency_code }} {{ number_format($totalPieces * $product->price, 2) }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <!-- Specifications Sections Stacked -->
    <div class="row" style="margin-top: 20px;">
        <!-- Custom Info Table -->
        <div class="col-md-12">
            <div class="box box-primary" style="border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
                <div class="box-header with-border">
                    <h3 class="box-title" style="font-weight: 800;"><i class="fa fa-info-circle text-primary"></i> معلومات مخصصة</h3>
                </div>
                <div class="box-body no-padding">
                    @php 
                        $customInfoRaw = $product->custom_info;
                        $customInfoJson = is_string($customInfoRaw) ? json_decode($customInfoRaw, true) : null;
                        $isCustomLegacyJson = is_array($customInfoJson) && isset($customInfoJson['headers']);
                    @endphp
                    @if($isCustomLegacyJson && count($customInfoJson['headers']) > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" style="margin-bottom: 0;">
                                <thead style="background: #f4f7f9;">
                                    <tr>
                                        @foreach($customInfoJson['headers'] as $header)
                                            @if($header) <th style="padding: 15px; border-bottom: 2px solid #eee;">{{ $header }}</th> @endif
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($customInfoJson['rows'] as $row)
                                        <tr>
                                            @foreach($row as $cell)
                                                <td style="padding: 12px 15px;" class="english-nums">{{ $cell }}</td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @elseif(!empty($customInfoRaw) && strip_tags(trim($customInfoRaw)) !== '')
                        <div class="table-responsive description-box-content" style="padding: 20px;">
                            {!! $customInfoRaw !!}
                        </div>
                    @else
                        <div class="text-center" style="padding: 40px; color: #999;">
                            <i class="fa fa-file-text-o" style="font-size: 40px; margin-bottom: 10px; display: block;"></i>
                            لا توجد معلومات مخصصة مضافة.
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Product Catalog Table -->
        <div class="col-md-12">
            <div class="box box-info" style="border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
                <div class="box-header with-border">
                    <h3 class="box-title" style="font-weight: 800;"><i class="fa fa-th-list text-info"></i> خصائص المنتج (الكتالوج)</h3>
                </div>
                <div class="box-body no-padding">
                    @php 
                        $catalogRaw = $product->product_catalog;
                        $catalogJson = is_string($catalogRaw) ? json_decode($catalogRaw, true) : null;
                        $isCatalogLegacyJson = is_array($catalogJson) && isset($catalogJson['headers']);
                    @endphp
                    @if($isCatalogLegacyJson && count($catalogJson['headers']) > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" style="margin-bottom: 0;">
                                <thead style="background: #f0faff;">
                                    <tr>
                                        @foreach($catalogJson['headers'] as $header)
                                            @if($header) <th style="padding: 15px; border-bottom: 2px solid #eee;">{{ $header }}</th> @endif
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($catalogJson['rows'] as $row)
                                        <tr>
                                            @foreach($row as $cell)
                                                <td style="padding: 12px 15px;" class="english-nums">{{ $cell }}</td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @elseif(!empty($catalogRaw) && strip_tags(trim($catalogRaw)) !== '')
                        <div class="table-responsive description-box-content" style="padding: 20px;">
                            {!! $catalogRaw !!}
                        </div>
                    @else
                        <div class="text-center" style="padding: 40px; color: #999;">
                            <i class="fa fa-list-alt" style="font-size: 40px; margin-bottom: 10px; display: block;"></i>
                            لا توجد خصائص مضافة للكتالوج.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    function updateGallery(src, el) {
        document.getElementById('main-vehicle-image').src = src;
        document.querySelectorAll('.thumb-item').forEach(item => item.classList.remove('active'));
        el.classList.add('active');
    }
</script>
@endpush
@endsection
