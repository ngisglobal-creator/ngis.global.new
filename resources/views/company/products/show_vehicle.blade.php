@extends('company.layouts.master')

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
        --border-color: #e3e8ec;
    }

    .vehicle-header {
        background: linear-gradient(135deg, var(--primary-dark) 0%, var(--secondary-blue) 100%);
        color: white;
        padding: 40px;
        border-radius: 20px;
        margin-bottom: 30px;
        box-shadow: 0 15px 35px rgba(30, 58, 95, 0.2);
        position: relative;
        overflow: hidden;
    }

    .vehicle-header::before {
        content: '\f1b9';
        font-family: FontAwesome;
        position: absolute;
        right: -30px;
        bottom: -40px;
        font-size: 200px;
        color: rgba(255, 255, 255, 0.07);
        transform: rotate(-15deg);
        pointer-events: none;
    }

    .spec-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 15px;
        margin-bottom: 30px;
    }

    .spec-card {
        background: white;
        border-radius: 15px;
        padding: 20px;
        text-align: center;
        border: 1px solid var(--border-color);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 6px rgba(0,0,0,0.02);
    }

    .spec-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 20px rgba(0,0,0,0.06);
        border-color: var(--secondary-blue);
    }

    .spec-icon {
        font-size: 28px;
        color: var(--secondary-blue);
        margin-bottom: 12px;
        display: block;
    }

    .spec-value {
        font-size: 22px;
        font-weight: 900;
        color: var(--primary-dark);
        display: block;
        margin-bottom: 4px;
    }

    .spec-label {
        font-size: 11px;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 700;
    }

    .logistics-hero {
        background: #fff;
        border-radius: 20px;
        border: 1px solid var(--border-color);
        padding: 30px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.03);
    }

    .container-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 25px;
    }

    .container-card {
        background: white;
        border-radius: 18px;
        border: 1px solid var(--border-color);
        overflow: hidden;
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
    }

    .container-card:hover {
        box-shadow: 0 15px 30px rgba(0,0,0,0.08);
        border-color: var(--secondary-blue);
    }

    .card-head {
        background: #f8fafc;
        padding: 15px 20px;
        border-bottom: 1px solid var(--border-color);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .card-body {
        padding: 20px;
    }

    .safety-margin-table {
        width: 100%;
        margin-top: 15px;
        background: #fcfdfe;
        border-radius: 10px;
        padding: 10px;
        border: 1px solid #f1f5f9;
    }

    .margin-row {
        display: flex;
        justify-content: space-between;
        padding: 10px;
        border-bottom: 1px solid #f1f5f9;
        font-size: 13px;
    }

    .margin-row:last-child {
        border-bottom: none;
    }

    .margin-name {
        color: #64748b;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .margin-num {
        font-weight: 800;
        color: var(--primary-dark);
        background: #eef7ff;
        padding: 2px 10px;
        border-radius: 6px;
    }

    .main-v-img {
        width: 100%;
        height: 500px;
        object-fit: contain;
        background: white;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    }

    .thumb-tray {
        display: flex;
        gap: 12px;
        margin-top: 20px;
        overflow-x: auto;
        padding-bottom: 10px;
    }

    .tray-item {
        width: 90px;
        height: 90px;
        border: 2px solid transparent;
        border-radius: 10px;
        cursor: pointer;
        object-fit: cover;
        transition: all 0.2s;
        background: white;
    }

    .tray-item.active {
        border-color: var(--secondary-blue);
        box-shadow: 0 0 10px rgba(60, 141, 188, 0.3);
    }

    .total-price-badge {
        background: var(--primary-dark);
        color: white;
        padding: 15px;
        border-radius: 12px;
        margin-top: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .vehicle-type-badge {
        padding: 6px 16px;
        border-radius: 100px;
        font-weight: 800;
        font-size: 12px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 15px;
    }

    .badge-light { background: #fff3cd; color: #856404; border: 1px solid #ffeeba; }
    .badge-heavy { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }

    .sticky-box {
        position: sticky;
        top: 20px;
    }
</style>

<section class="content">
    <div class="vehicle-header">
        <div class="row align-items-center">
            <div class="col-md-7">
                <div class="vehicle-type-badge {{ $product->vehicle_group === 'light' ? 'badge-light' : 'badge-heavy' }}">
                    <i class="fa {{ $product->vehicle_group === 'light' ? 'fa-car' : 'fa-truck' }}"></i>
                    {{ $product->vehicle_group === 'light' ? 'مركبة خفيفة' : 'معدات ثقيلة' }}
                </div>
                <h1 style="margin: 0; font-weight: 900; font-size: 42px; letter-spacing: -0.5px;">{{ $product->name }}</h1>
                <div style="margin-top: 15px; display: flex; gap: 20px; opacity: 0.9; font-size: 15px;">
                    <span><i class="fa fa-tag"></i> {{ $product->sku ?? 'VN-'.str_pad($product->id, 5, '0', STR_PAD_LEFT) }}</span>
                    <span><i class="fa fa-th-large"></i> {{ $product->category->name_ar }}</span>
                    <span><i class="fa fa-calendar"></i> المضافة في: {{ $product->created_at->format('Y/m/d') }}</span>
                </div>
            </div>
            <div class="col-md-5 text-right">
                <div style="background: rgba(255,255,255,0.15); backdrop-filter: blur(5px); padding: 25px; border-radius: 18px; display: inline-block; border: 1px solid rgba(255,255,255,0.2);">
                    <div style="font-size: 13px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px; opacity: 0.8;">سعر الوحدة الحالي</div>
                    <div class="english-nums" style="font-size: 48px; font-weight: 950; line-height: 1;">
                        {{ number_format($product->price, 2) }} <small style="font-size: 18px; color: #fff; font-weight: 600;">{{ $product->currency_code }}</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Main Content -->
        <div class="col-md-7">
            <!-- Dimensions Cards -->
            <div class="spec-grid">
                <div class="spec-card">
                    <i class="fa fa-arrows-h spec-icon"></i>
                    <span class="spec-value english-nums">{{ $product->carton_length }}</span>
                    <span class="spec-label">الطول (cm)</span>
                </div>
                <div class="spec-card">
                    <i class="fa fa-arrows-v spec-icon"></i>
                    <span class="spec-value english-nums">{{ $product->carton_width }}</span>
                    <span class="spec-label">العرض (cm)</span>
                </div>
                <div class="spec-card">
                    <i class="fa fa-long-arrow-up spec-icon"></i>
                    <span class="spec-value english-nums">{{ $product->carton_height }}</span>
                    <span class="spec-label">الارتفاع (cm)</span>
                </div>
                <div class="spec-card">
                    <i class="fa fa-dashboard spec-icon"></i>
                    <span class="spec-value english-nums">{{ number_format($product->piece_weight) }}</span>
                    <span class="spec-label">الوزن (kg)</span>
                </div>
            </div>

            <!-- Ultimate Vehicle Technical Report -->
            @php
                $vInfo = $logistics['vehicle_info'] ?? null;
            @endphp
            
            @if($vInfo)
            <!-- Section 1: Vehicle Identity -->
            <div style="background: white; border-radius: 20px; border: 1px solid #eef2f6; padding: 25px; margin-bottom: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.04);">
                <h4 style="font-weight: 900; color: var(--primary-dark); margin-top: 0; margin-bottom: 25px; border-bottom: 2px solid #f8fafc; padding-bottom: 15px; display: flex; align-items: center; gap: 12px;">
                    <i class="fa fa-id-card text-primary" style="background: #f0f7ff; padding: 10px; border-radius: 12px;"></i> المعلومات التعريفية الأساسية
                </h4>
                <div class="row">
                    <div class="col-md-4">
                        <div style="margin-bottom: 20px;">
                            <span style="font-size: 11px; color: #94a3b8; font-weight: 600; text-transform: uppercase; margin-bottom: 5px; display: block;">الشركة المصنعة والموديل</span>
                            <b style="font-size: 18px; color: #1e293b;">{{ $vInfo['manufacturer'] ?? '---' }} {{ $vInfo['model'] ?? '' }} ({{ $vInfo['year'] ?? '' }})</b>
                        </div>
                        <div style="margin-bottom: 0;">
                            <span style="font-size: 11px; color: #94a3b8; font-weight: 600; text-transform: uppercase; margin-bottom: 5px; display: block;">رقم الهيكل (VIN)</span>
                            <b class="english-nums" style="color: #475569; font-size: 15px;">{{ $vInfo['vin'] ?: '---' }}</b>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div style="margin-bottom: 20px;">
                            <span style="font-size: 11px; color: #94a3b8; font-weight: 600; text-transform: uppercase; margin-bottom: 5px; display: block;">الفئة ونوع المركبة</span>
                            <b style="color: #1e293b; font-size: 16px;">{{ $vInfo['class'] ?: '---' }} | {{ $vInfo['type'] ?: '---' }}</b>
                        </div>
                        <div style="margin-bottom: 0;">
                            <span style="font-size: 11px; color: #94a3b8; font-weight: 600; text-transform: uppercase; margin-bottom: 5px; display: block;">رقم اللوحة</span>
                            <b class="english-nums" style="color: #475569; font-size: 15px;">{{ $vInfo['plate'] ?: '---' }}</b>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div style="background: #f8fafc; border-radius: 15px; padding: 20px; text-align: center; border: 2px dashed #e2e8f0;">
                            <span style="font-size: 11px; color: #64748b; font-weight: 700; text-transform: uppercase; margin-bottom: 10px; display: block;">حالة المنتج الحالية</span>
                            <span class="label {{ ($vInfo['condition'] ?? 'new') === 'new' ? 'label-success' : 'label-info' }}" style="font-size: 15px; padding: 8px 20px; border-radius: 8px; display: inline-block;">
                                {{ ($vInfo['condition'] ?? 'new') === 'new' ? 'جديدة (Brand New)' : 'مستعملة (Pre-owned)' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 2: Technical Specs (Engine & Performance) -->
            <div style="background: white; border-radius: 20px; border: 1px solid #eef2f6; padding: 25px; margin-bottom: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.04);">
                <h4 style="font-weight: 900; color: var(--primary-dark); margin-top: 0; margin-bottom: 25px; border-bottom: 2px solid #f8fafc; padding-bottom: 15px; display: flex; align-items: center; gap: 12px;">
                    <i class="fa fa-cogs text-success" style="background: #f0fdf4; padding: 10px; border-radius: 12px;"></i> المواصفات الفنية والأداء
                </h4>
                <div class="row text-center">
                    <div class="col-md-3" style="border-left: 1px solid #f1f5f9;">
                        <i class="fa fa-fire" style="color: #f97316; font-size: 24px; margin-bottom: 10px;"></i>
                        <div style="font-size: 11px; color: #94a3b8; font-weight: 700;">نوع الوقود</div>
                        <b style="color: #1e293b; font-size: 16px;">{{ $vInfo['engine_type'] ?: '---' }}</b>
                    </div>
                    <div class="col-md-3" style="border-left: 1px solid #f1f5f9;">
                        <i class="fa fa-cube" style="color: #3b82f6; font-size: 24px; margin-bottom: 10px;"></i>
                        <div style="font-size: 11px; color: #94a3b8; font-weight: 700;">سعة المحرك</div>
                        <b class="english-nums" style="color: #1e293b; font-size: 16px;">{{ $vInfo['engine_cc'] ?: '---' }} <small>CC</small></b>
                    </div>
                    <div class="col-md-3" style="border-left: 1px solid #f1f5f9;">
                        <i class="fa fa-bolt" style="color: #eab308; font-size: 24px; margin-bottom: 10px;"></i>
                        <div style="font-size: 11px; color: #94a3b8; font-weight: 700;">القوة الحصانية</div>
                        <b class="english-nums" style="color: #1e293b; font-size: 16px;">{{ $vInfo['horsepower'] ?: '---' }} <small>HP</small></b>
                    </div>
                    <div class="col-md-3">
                        <i class="fa fa-cog" style="color: #8b5cf6; font-size: 24px; margin-bottom: 10px;"></i>
                        <div style="font-size: 11px; color: #94a3b8; font-weight: 700;">ناقل الحركة</div>
                        <b style="color: #1e293b; font-size: 16px;">{{ $vInfo['transmission'] ?: '---' }}</b>
                    </div>
                </div>
                <div class="row" style="margin-top: 30px; padding-top: 25px; border-top: 1px solid #f8fafc;">
                    <div class="col-md-4">
                        <div style="display: flex; gap: 15px;">
                            <div style="font-size: 20px; color: #ef4444;"><i class="fa fa-arrows-alt"></i></div>
                            <div>
                                <span style="font-size: 11px; color: #94a3b8; font-weight: 700;">نظام الدفع</span>
                                <b style="display: block; color: #1e293b;">{{ $vInfo['drive_system'] ?: '---' }}</b>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div style="display: gap: 15px; display: flex;">
                            <div style="font-size: 20px; color: #10b981;"><i class="fa fa-gas-pump"></i></div>
                            <div>
                                <span style="font-size: 11px; color: #94a3b8; font-weight: 700;">استهلاك الوقود</span>
                                <b class="english-nums" style="display: block; color: #1e293b;">{{ $vInfo['fuel_consumption'] ?: '---' }}</b>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div style="display: gap: 15px; display: flex;">
                            <div style="font-size: 20px; color: #f59e0b;"><i class="fa fa-gauge"></i></div>
                            <div>
                                <span style="font-size: 11px; color: #94a3b8; font-weight: 700;">السرعة / التسارع</span>
                                <b class="english-nums" style="display: block; color: #1e293b;">{{ $vInfo['max_speed'] ?? '---' }} km/h | {{ $vInfo['acceleration'] ?? '---' }}</b>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 3: History & Condition -->
            <div style="background: white; border-radius: 20px; border: 1px solid #eef2f6; padding: 25px; margin-bottom: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.04);">
                <h4 style="font-weight: 900; color: var(--primary-dark); margin-top: 0; margin-bottom: 25px; border-bottom: 2px solid #f8fafc; padding-bottom: 15px; display: flex; align-items: center; gap: 12px;">
                    <i class="fa fa-calendar-check text-info" style="background: #ecfeff; padding: 10px; border-radius: 12px;"></i> تاريخ الاستخدام والحالة الفنية
                </h4>
                <div class="row text-center">
                    <div class="col-md-3" style="border-left: 1px solid #f1f5f9;">
                        <div style="font-size: 11px; color: #94a3b8; font-weight: 700;">المسافة المقطوعة</div>
                        <div class="english-nums" style="font-size: 20px; font-weight: 900; color: #1e293b;">{{ number_format($vInfo['mileage'] ?? 0) }} <small style="font-size: 11px; color: #64748b;">KM</small></div>
                    </div>
                    <div class="col-md-3" style="border-left: 1px solid #f1f5f9;">
                        <div style="font-size: 11px; color: #94a3b8; font-weight: 700;">المالكين السابقين</div>
                        <div class="english-nums" style="font-size: 20px; font-weight: 900; color: #1e293b;">{{ $vInfo['previous_owners'] ?? 0 }}</div>
                    </div>
                    <div class="col-md-3" style="border-left: 1px solid #f1f5f9;">
                        <div style="font-size: 11px; color: #94a3b8; font-weight: 700;">الحالة الفنية</div>
                        @php
                            $states = ['excellent' => 'ممتازة', 'good' => 'جيدة', 'maintenance_needed' => 'تحتاج صيانة'];
                            $state = $vInfo['vehicle_state'] ?? 'excellent';
                        @endphp
                        <div style="font-size: 16px; font-weight: 900; color: {{ $state === 'excellent' ? '#10b981' : ($state === 'good' ? '#f59e0b' : '#ef4444') }};">
                            {{ $states[$state] ?? $state }}
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div style="font-size: 11px; color: #94a3b8; font-weight: 700;">آخر صيانة</div>
                        <div class="english-nums" style="font-size: 14px; font-weight: 800; color: #1e293b;">{{ $vInfo['last_maintenance_date'] ?: 'غير مسجل' }}</div>
                    </div>
                </div>

                @if(isset($vInfo['accident_history']) && $vInfo['accident_history'] === 'yes')
                <div style="margin-top: 25px; background: linear-gradient(to right, #fff5f5, #fffcfc); border: 1px solid #fee2e2; border-radius: 12px; padding: 18px; display: flex; gap: 15px; align-items: flex-start;">
                    <div style="background: #fee2e2; color: #ef4444; width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i class="fa fa-exclamation-triangle"></i>
                    </div>
                    <div>
                        <b style="color: #991b1b; display: block; margin-bottom: 5px;">تنبيه: سجل الحوادث</b>
                        <p style="font-size: 13px; margin: 0; color: #7f1d1d; line-height: 1.6;">{{ $vInfo['accident_details'] ?: 'توجد حوادث مسجلة لهذه المركبة.' }}</p>
                    </div>
                </div>
                @endif
            </div>

            <!-- Section 4: Smart Features -->
            @if(isset($vInfo['features']) && is_array($vInfo['features']) && count($vInfo['features']) > 0)
            <div style="background: white; border-radius: 20px; border: 1px solid #eef2f6; padding: 25px; margin-bottom: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.04);">
                <h4 style="font-weight: 900; color: var(--primary-dark); margin-top: 0; margin-bottom: 25px; border-bottom: 2px solid #f8fafc; padding-bottom: 15px;">
                    <i class="fa fa-list-check text-primary"></i> المواصفات الذكية والإضافات المتوفرة
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
                        <span style="background: #f1f5f9; border: 1px solid #e2e8f0; border-radius: 12px; padding: 10px 20px; font-size: 13px; color: #475569; display: flex; align-items: center; gap: 10px; font-weight: 600; box-shadow: 0 2px 5px rgba(0,0,0,0.02);">
                            <i class="fa {{ $featureMap[$fKey]['icon'] }} text-primary"></i> {{ $featureMap[$fKey]['name'] }}
                        </span>
                        @endif
                    @endforeach
                </div>
            </div>
            @endif
            @endif

            <!-- Section 5: Logistics & Pricing Summary Table -->
            <div style="background: white; border-radius: 20px; border: 1px solid #eef2f6; padding: 25px; margin-bottom: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.04);">
                <h4 style="font-weight: 900; color: var(--primary-dark); margin-top: 0; margin-bottom: 25px; border-bottom: 2px solid #f8fafc; padding-bottom: 15px; display: flex; align-items: center; gap: 12px;">
                    <i class="fa fa-table text-primary" style="background: #f0f7ff; padding: 10px; border-radius: 12px;"></i> ملخص البيانات اللوجستية والوزن
                </h4>
                <div class="table-responsive">
                    <table class="table table-bordered text-center" style="margin-bottom: 0; background: #fff;">
                        <thead style="background: #f8fafc;">
                            <tr style="font-size: 11px; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">
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
                            <tr style="font-weight: 800; color: #1e293b;">
                                <td>{{ $product->name }}</td>
                                <td class="english-nums">{{ $product->sku ?: '---' }}</td>
                                <td class="english-nums" style="color: #3b82f6;">{{ number_format($product->price, 2) }} {{ $product->currency_code }}</td>
                                <td class="english-nums">{{ number_format($product->piece_weight) }}</td>
                                <td class="english-nums" style="color: #ef4444;">{{ number_format($product->total_weight) }}</td>
                                <td class="english-nums">{{ $product->carton_length }}</td>
                                <td class="english-nums">{{ $product->carton_width }}</td>
                                <td class="english-nums">{{ $product->carton_height }}</td>
                                <td class="english-nums">{{ $product->carton_volume_cbm }}</td>
                                <td class="english-nums" style="color: #10b981;">{{ $product->total_cbm }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="logistics-hero">
                <h3 style="font-weight: 900; color: var(--primary-dark); margin-bottom: 25px; display: flex; align-items: center; gap: 12px; border-bottom: 2px solid var(--light-gray); padding-bottom: 15px;">
                    <i class="fa fa-ship text-primary"></i> تحليل الشحن اللوجستي والقدرة الاستيعابية
                </h3>

                <div class="container-grid">
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
                            <div class="container-card">
                                <div class="card-head">
                                    <div style="font-weight: 800; font-size: 16px; color: var(--primary-dark);">{{ $lc['label'] ?? $lc['name'] ?? $key }}</div>
                                    <span class="badge badge-info english-nums" style="background: #3c8dbc;">{{ $lc['factor'] }} CBM</span>
                                </div>
                                <div class="card-body">
                                    <div style="background: #f8fafc; border: 1px solid #eef2f6; border-radius: 12px; padding: 12px; text-align: center; margin-bottom: 20px;">
                                        <div style="font-size: 11px; color: #94a3b8; margin-bottom: 3px;">أبعاد الحاوية المتوفرة</div>
                                        <b class="english-nums" style="color: var(--primary-dark);">{{ $lc['dims']['l'] }}m × {{ $lc['dims']['w'] }}m × {{ $lc['dims']['h'] }}m</b>
                                    </div>

                                    <div class="safety-margin-table">
                                        <div class="margin-row">
                                            <span class="margin-name"><i class="fa fa-square-o"></i> الأرضي (Flat)</span>
                                            <span class="margin-num">{{ $lc['margins']['flat'] }} سيارة</span>
                                        </div>
                                        <div class="margin-row">
                                            <span class="margin-name"><i class="fa fa-level-up"></i> المائل (Racking)</span>
                                            <span class="margin-num">{{ $lc['margins']['rack'] }} سيارة</span>
                                        </div>
                                        <div class="margin-row">
                                            <span class="margin-name"><i class="fa fa-chain"></i> فولاذي (Steel)</span>
                                            <span class="margin-num">{{ $lc['margins']['steel'] }} سيارة</span>
                                        </div>
                                        <div class="margin-row">
                                            <span class="margin-name"><i class="fa fa-th-list"></i> منصات (Cassette)</span>
                                            <span class="margin-num">{{ $lc['margins']['cassette'] }} سيارة</span>
                                        </div>
                                        <div class="margin-row">
                                            <span class="margin-name"><i class="fa fa-tree"></i> الخشبي (Timber)</span>
                                            <span class="margin-num">{{ $lc['margins']['timber'] }} سيارة</span>
                                        </div>
                                    </div>

                                    <div style="margin-top: 20px; padding-top: 15px; border-top: 1px solid #f1f5f9;">
                                        <div style="display: flex; justify-content: space-between; font-size: 14px; margin-bottom: 6px;">
                                            <span style="color: #64748b;">إجمالي القطع المخططة:</span>
                                            <b class="english-nums">{{ number_format($lc['totalPcs']) }} قطعة</b>
                                        </div>
                                        <div style="display: flex; justify-content: space-between; font-size: 14px; margin-bottom: 15px;">
                                            <span style="color: #64748b;">حمولة الوزن:</span>
                                            <b class="english-nums" style="color: var(--danger-red);">{{ number_format($lc['totalWeight']) }} KG</b>
                                        </div>
                                        <div class="total-price-badge">
                                            <span style="font-size: 12px; font-weight: 600; opacity: 0.9;">تكلفة الحمولة الكاملة:</span>
                                            <b class="english-nums" style="font-size: 20px;">{{ number_format($lc['totalPrice']) }} <small style="font-size: 12px; color: #fff;">{{ $product->currency_code }}</small></b>
                                        </div>
                                        @if(isset($lc['weightNote']) && $lc['weightNote'])
                                            <div style="margin-top: 10px; background: #fffbe6; color: #d48806; padding: 8px 12px; border-radius: 8px; font-size: 11px; border: 1px solid #ffe58f; display: flex; gap: 8px;">
                                                <i class="fa fa-exclamation-triangle"></i>
                                                {{ $lc['weightNote'] }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                        @endforeach
                    @else
                        <!-- Fallback to Standard Logistics if Specialized is Missing -->
                        <div class="col-md-12" style="grid-column: 1 / -1;">
                            <div style="background: #f8fafc; border: 1px solid var(--border-color); border-radius: 15px; padding: 25px;">
                                <h4 style="font-weight: 900; color: var(--primary-dark); margin-bottom: 20px; border-bottom: 1px solid #e2e8f0; padding-bottom: 15px;">
                                    <i class="fa fa-ship"></i> سعة الشحن القياسية
                                </h4>
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
                                        <div class="col-md-6" style="margin-bottom: 20px;">
                                            <div style="background: white; border: 1px solid #e2e8f0; border-radius: 12px; padding: 20px;">
                                                <div style="font-weight: 800; color: var(--primary-dark); margin-bottom: 15px; font-size: 16px;">
                                                    <i class="fa {{ $container['icon'] }} text-primary"></i> {{ $container['name'] }}
                                                </div>
                                                <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                                                    <span style="color: #64748b;">إجمالي القطع:</span>
                                                    <b class="english-nums">{{ number_format($totalPieces) }}</b>
                                                </div>
                                                <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                                                    <span style="color: #64748b;">إجمالي الوزن:</span>
                                                    <b class="english-nums" style="color: var(--danger-red);">{{ $weightStr }}</b>
                                                </div>
                                                <div style="border-top: 1px solid #f1f5f9; margin-top: 10px; padding-top: 10px; display: flex; justify-content: space-between;">
                                                    <span style="font-weight: bold; color: var(--secondary-blue);">التكلفة الإجمالية:</span>
                                                    <b class="english-nums" style="color: var(--secondary-blue);">{{ number_format($totalPieces * $product->price, 2) }} {{ $product->currency_code }}</b>
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
            
            <div style="margin-top: 40px;">
                <h4 style="font-weight: 900; color: var(--primary-dark); margin-bottom: 20px;"><i class="fa fa-file-text-o"></i> تفاصيل إضافية</h4>
                <div style="background: white; border-radius: 15px; padding: 25px; border: 1px solid var(--border-color); line-height: 1.8; color: #475569;">
                    {!! $product->description !!}
                </div>
            </div>
        </div>

        <!-- Sidebar / Media -->
        <div class="col-md-5">
            <div class="sticky-box">
                <div class="image-gallery">
                    @if($product->images->count() > 0)
                        <div id="v-zoom-container" style="background: white; border-radius: 20px; border: 1px solid var(--border-color); overflow: hidden; position: relative;">
                            <img id="main-vehicle-display" src="{{ asset('storage/' . $product->images->first()->image_path) }}" class="main-v-img">
                        </div>
                        
                        @if($product->images->count() > 1)
                        <div class="thumb-tray">
                            @foreach($product->images as $image)
                                <img src="{{ asset('storage/' . $image->image_path) }}" 
                                     class="tray-item {{ $loop->first ? 'active' : '' }}"
                                     onclick="switchMainImg('{{ asset('storage/' . $image->image_path) }}', this)">
                            @endforeach
                        </div>
                        @endif
                    @else
                        <div style="height: 400px; background: #f8fafc; border-radius: 20px; border: 2px dashed #cbd5e1; display: flex; flex-direction: column; align-items: center; justify-content: center; color: #94a3b8;">
                            <i class="fa fa-picture-o" style="font-size: 60px; margin-bottom: 15px;"></i>
                            <b>لا توجد صور للمركبة</b>
                        </div>
                    @endif
                </div>

                <div class="quick-stats" style="margin-top: 30px; display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <div style="background: #eff6ff; padding: 20px; border-radius: 15px; border: 1px solid #dbeafe;">
                        <span style="color: #1e40af; font-weight: 700; font-size: 13px; display: block;">القطاع</span>
                        <b style="color: #1e3a8a; font-size: 16px;">{{ $product->sector->name_ar }}</b>
                    </div>
                    <div style="background: #f0fdf4; padding: 20px; border-radius: 15px; border: 1px solid #dcfce7;">
                        <span style="color: #166534; font-weight: 700; font-size: 13px; display: block;">أدنى كمية طلب</span>
                        <b style="color: #14532d; font-size: 16px;" class="english-nums">{{ $product->min_order_quantity }}</b>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row" style="margin-top: 30px;">
        <!-- Custom Info Table -->
        <div class="col-md-12">
            <div class="box box-primary" style="border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); background: white;">
                <div class="box-header with-border" style="padding: 15px 20px;">
                    <h3 class="box-title" style="font-weight: 800; color: var(--primary-dark);"><i class="fa fa-info-circle text-primary"></i> معلومات مخصصة</h3>
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
                        <div class="table-responsive" style="padding: 20px;">
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
        <div class="col-md-12" style="margin-top: 20px;">
            <div class="box box-info" style="border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); background: white;">
                <div class="box-header with-border" style="padding: 15px 20px;">
                    <h3 class="box-title" style="font-weight: 800; color: var(--primary-dark);"><i class="fa fa-th-list text-info"></i> خصائص المنتج (الكتالوج)</h3>
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
                        <div class="table-responsive" style="padding: 20px;">
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
    function switchMainImg(src, el) {
        document.getElementById('main-vehicle-display').src = src;
        document.querySelectorAll('.tray-item').forEach(i => i.classList.remove('active'));
        el.classList.add('active');
    }
</script>
@endpush

@endsection
