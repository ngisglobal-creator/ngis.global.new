@extends('company.layouts.master')

@section('title', 'تفاصيل المنتج: ' . $product->name)

@section('content')
<section class="content-header">
    <h1>
        تفاصيل المنتج
        <small>{{ $product->name }}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('company.dashboard') }}"><i class="fa fa-dashboard"></i> الرئيسية</a></li>
        <li><a href="{{ route('products.index') }}">منتجاتي</a></li>
        <li class="active">تفاصيل المنتج</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <!-- Product Gallery Section -->
        <div class="col-md-6">
            <div class="box box-solid" style="border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
                <div class="box-body">
                    <!-- Main Image with Inner Zoom -->
                    <div class="main-image-wrapper" style="position: relative; width: 100%; height: 500px; background: #fff; border-radius: 8px; overflow: hidden; display: flex; align-items: center; justify-content: center; border: 1px solid #f0f0f0;">
                        @if($product->images->count() > 0)
                            <div id="zoom-container" class="img-zoom-container" style="position: relative; width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; cursor: zoom-in;">
                                <img id="main-product-image" src="{{ asset('storage/' . $product->images->first()->image_path) }}" 
                                     style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                <div id="zoom-lens" style="position: absolute; border: 1px solid #d4d4d4; width: 160px; height: 160px; visibility: hidden; background: rgba(255,255,255,0.4); pointer-events: none;"></div>
                            </div>
                            <!-- Zoom Result (shown on top when hovering) -->
                            <div id="zoom-result" class="img-zoom-result" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-repeat: no-repeat; visibility: hidden; z-index: 100; background-color: #fff; pointer-events: none; border-radius: 8px;"></div>
                        @else
                            <img src="{{ asset('img/default-product.png') }}" style="max-width: 150px; opacity: 0.3;">
                        @endif
                    </div>

                    <!-- Thumbnails -->
                    @if($product->images->count() > 1)
                        <div class="thumbnail-wrapper" style="margin-top: 15px; display: flex; gap: 10px; overflow-x: auto; padding: 5px 2px;">
                            @foreach($product->images as $image)
                                <div class="thumb-item {{ $loop->first ? 'active' : '' }}" 
                                     onclick="changeMainImage('{{ asset('storage/' . $image->image_path) }}', this)"
                                     style="flex: 0 0 80px; height: 80px; border: 2px solid {{ $loop->first ? '#3c8dbc' : '#eee' }}; border-radius: 6px; cursor: pointer; background: #fff; overflow: hidden; display: flex; align-items: center; justify-content: center; transition: all 0.2s;">
                                    <img src="{{ asset('storage/' . $image->image_path) }}" style="max-width: 100%; max-height: 100%; object-fit: cover;">
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Product Info Section -->
        <div class="col-md-6">
            <div class="box box-solid" style="border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); padding: 25px; min-height: 500px;">
                <h2 style="font-weight: 900; color: #1a1a1a; margin-top: 0; line-height: 1.4;">{{ $product->name }}</h2>
                <div class="product-meta" style="margin-bottom: 25px; display: flex; flex-wrap: wrap; gap: 15px; align-items: center;">
                    <span class="label label-primary" style="font-size: 14px; padding: 6px 15px; border-radius: 20px;">{{ $product->sector->name_ar }}</span>
                    <span style="color: #666;"><i class="fa fa-folder-open text-primary"></i> {{ $product->category->name_ar }}</span>
                    <span style="color: #999; font-size: 12px;"><i class="fa fa-calendar"></i> {{ $product->created_at->format('Y-m-d') }}</span>
                </div>

                <div class="price-card" style="background: linear-gradient(135deg, #f0f7ff 0%, #e6f2ff 100%); border: 1px solid #cce3ff; border-radius: 12px; padding: 25px; margin-bottom: 30px; position: relative; overflow: hidden;">
                    <div style="position: absolute; right: -20px; top: -20px; font-size: 100px; color: rgba(60, 141, 188, 0.05); transform: rotate(-15deg); pointer-events: none;">
                        <i class="fa fa-money"></i>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: end;">
                        <div>
                            <div style="font-size: 15px; color: #3c8dbc; font-weight: bold; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">سعر القطعة</div>
                            <div style="font-size: 42px; font-weight: 900; color: #1e3a5f; line-height: 1;">
                                <span class="english-nums">{{ number_format($product->price, 2) }}</span> 
                                <small style="font-size: 18px; font-weight: bold;">{{ $product->currency_code }}</small>
                            </div>
                        </div>
                        <div style="text-align: left;">
                            <div style="font-size: 13px; color: #777; margin-bottom: 5px;">أدنى كمية</div>
                            <div style="font-size: 26px; font-weight: 800; color: #333;" class="english-nums">
                                {{ $product->min_order_quantity }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row" style="margin-bottom: 30px;">
                    <div class="col-xs-6 col-md-4">
                        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 10px;">
                            <div style="width: 35px; height: 35px; background: #f8f9fa; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #3c8dbc;">
                                <i class="fa fa-balance-scale"></i>
                            </div>
                            <div>
                                <div style="color: #888; font-size: 12px;">وزن القطعة</div>
                                <div style="font-weight: 800; font-size: 16px;" class="english-nums">{{ $product->piece_weight }} KG</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-4">
                        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 10px;">
                            <div style="width: 35px; height: 35px; background: #f8f9fa; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #3c8dbc;">
                                <i class="fa fa-cubes"></i>
                            </div>
                            <div>
                                <div style="color: #888; font-size: 12px;">عدد القطع/الكرتونة</div>
                                <div style="font-weight: 800; font-size: 16px;" class="english-nums">{{ $product->product_piece_count }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-4">
                        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 10px;">
                            <div style="width: 35px; height: 35px; background: #f8f9fa; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #3c8dbc;">
                                <i class="fa fa-truck"></i>
                            </div>
                            <div>
                                <div style="color: #888; font-size: 12px;">حجم CBM</div>
                                <div style="font-weight: 800; font-size: 16px;" class="english-nums">{{ $product->carton_volume_cbm }}</div>
                                          @if($product->logistics_details)
                <!-- Specialized Vehicle Logistics Report -->
                <div class="row" style="margin-bottom: 30px;">
                    <div class="col-md-12">
                        <div style="background: #fff; border-radius: 12px; border: 1px solid #e0e0e0; box-shadow: 0 4px 20px rgba(0,0,0,0.08); overflow: hidden;">
                            <div style="background: linear-gradient(135deg, #1e3a5f 0%, #3c8dbc 100%); color: white; padding: 15px 20px; display: flex; justify-content: space-between; align-items: center;">
                                <h4 style="margin: 0; font-weight: 800;"><i class="fa fa-ship"></i> تقرير الحاويات ومعايير الأمان للنقل</h4>
                                <span class="label label-warning" style="font-size: 12px;">{{ $product->vehicle_group === 'light' ? 'مركبة خفيفة' : 'معدات ثقيلة' }}</span>
                            </div>
                            <div style="padding: 20px; background: #f8f9fa;">
                                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px;">
                                    @foreach($product->logistics_details as $key => $lc)
                                        @if(is_array($lc) && isset($lc['margins']))
                                        <div style="background: #fff; border: 1px solid #ddd; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.05); transition: transform 0.2s;">
                                            <div style="background: #3c8dbc; color: white; padding: 10px 15px; font-weight: bold; display: flex; justify-content: space-between; align-items: center;">
                                                <span>{{ $lc['label'] ?? $lc['name'] ?? $key }}</span>
                                                <span style="font-size: 11px; opacity: 0.9;">{{ $lc['factor'] }} CBM</span>
                                            </div>
                                            <div style="padding: 15px;">
                                                <div style="text-align: center; color: #666; font-size: 11px; margin-bottom: 10px; border-bottom: 1px solid #eee; padding-bottom: 5px;">
                                                    طول: <b>{{ $lc['dims']['l'] }}</b> | عرض: <b>{{ $lc['dims']['w'] }}</b> | ارتفاع: <b>{{ $lc['dims']['h'] }}</b>
                                                </div>
                                                <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                                    <span style="color: #888; font-size: 12px;">الحاويات المطلوبة:</span>
                                                    <span style="font-weight: bold; color: #3c8dbc; font-size: 15px;" class="english-nums">{{ $lc['numContainers'] }}</span>
                                                </div>
                                                <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                                    <span style="color: #888; font-size: 12px;">إجمالي القطع:</span>
                                                    <span style="font-weight: bold;" class="english-nums">{{ number_format($lc['totalPcs']) }}</span>
                                                </div>
                                                <div style="display: flex; justify-content: space-between; margin0-bottom: 10px;">
                                                    <span style="color: #888; font-size: 12px;">الوزن الكلي:</span>
                                                    <span style="font-weight: bold;" class="english-nums">{{ number_format($lc['totalWeight']) }} kg</span>
                                                </div>
                                                
                                                <div style="background: #fcfcfc; border: 1px solid #eee; border-radius: 8px; padding: 10px; margin-top: 5px;">
                                                    <div style="border-bottom: 1px dashed #ddd; margin-bottom: 8px; padding-bottom: 3px; font-weight: bold; font-size: 11px; color: #555;">
                                                        <i class="fa fa-shield"></i> معايير الأمان (سعة السيارات)
                                                    </div>
                                                    <div style="display: grid; grid-template-columns: 1fr; gap: 4px; font-size: 11px;">
                                                        <div style="display:flex; justify-content:space-between;"><span>الأرضي (Flat):</span> <b style="color: #3c8dbc;">{{ $lc['margins']['flat'] }} سيارة</b></div>
                                                        <div style="display:flex; justify-content:space-between;"><span>المائل (Rack):</span> <b style="color: #3c8dbc;">{{ $lc['margins']['rack'] }} سيارة</b></div>
                                                        <div style="display:flex; justify-content:space-between;"><span>فولاذي (Steel):</span> <b style="color: #3c8dbc;">{{ $lc['margins']['steel'] }} سيارة</b></div>
                                                        <div style="display:flex; justify-content:space-between;"><span>منصات (Cassette):</span> <b style="color: #3c8dbc;">{{ $lc['margins']['cassette'] }} سيارة</b></div>
                                                        <div style="display:flex; justify-content:space-between;"><span>الخشبي (Timber):</span> <b style="color: #3c8dbc;">{{ $lc['margins']['timber'] }} سيارة</b></div>
                                                    </div>
                                                </div>
                                                
                                                <div style="display: flex; justify-content: space-between; margin-top: 10px; padding-top: 10px; border-top: 1px solid #eee;">
                                                    <span style="color: #888; font-size: 13px;">السعر الإجمالي:</span>
                                                    <span style="font-weight: bold; color: #d9534f; font-size: 15px;" class="english-nums">{{ number_format($lc['totalPrice']) }} {{ $product->currency_code }}</span>
                                                </div>
                                                @if(isset($lc['weightNote']) && $lc['weightNote'])
                                                    <div style="background: #fff9e6; color: #856404; padding: 5px 8px; border-radius: 4px; font-size: 10px; margin-top: 5px; border: 1px solid #ffeeba;"><b>تنبيه حرج:</b> {{ $lc['weightNote'] }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                <div class="row" style="margin-bottom: 25px;">
                    <div class="col-md-12">
                        <div style="background: #fcfcfc; border: 1px solid #eee; border-radius: 12px; padding: 20px;">
                            <h5 style="font-weight: 800; color: #3c8dbc; margin-bottom: 15px; border-bottom: 1px solid #efefef; padding-bottom: 10px;">
                                <i class="fa fa-ship"></i> سعة الشحن المتوقعة لهذه الكرتونة
                            </h5>
                            <div class="row">
                                @php
                                    $unitCbm = $product->carton_volume_cbm > 0 ? $product->carton_volume_cbm : 1;
                                    $piecesPerCarton = $product->product_piece_count > 0 ? $product->product_piece_count : 1;
                                    
                                    $containers = [
                                        ['name' => 'حاوية 20 قدم', 'cap' => 28, 'icon' => 'fa-th-large', 'saved' => $product->container_20ft_capacity],
                                        ['name' => 'حاوية 40 قدم', 'cap' => 40, 'icon' => 'fa-th-large', 'saved' => $product->container_40ft_capacity],
                                        ['name' => 'حاوية 40 قدم HQ', 'cap' => 68, 'icon' => 'fa-truck', 'saved' => $product->container_40hq_capacity],
                                        ['name' => 'حاوية 45 قدم', 'cap' => 78, 'icon' => 'fa-ship', 'saved' => $product->container_45ft_capacity]
                                    ];
                                @endphp

                                @foreach($containers as $container)
                                    @php
                                        // Use saved capacity if available, otherwise calculate on fly (for old products)
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
                                                <span>عدد الكراتين:</span>
                                                <span class="english-nums" style="font-weight: bold;">{{ number_format($cartons) }}</span>
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
                                                <span style="color: #3c8dbc; font-weight: bold;">التكلفة الإجمالية:</span>
                                                <span class="english-nums" style="font-weight: bold; color: #3c8dbc;">
                                                    {{ $product->currency_code }} {{ number_format($cartons * $piecesPerCarton * $product->price, 2) }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row" style="margin-bottom: 30px;">
                    <div class="col-md-12">
                        <div class="box box-solid" style="border: 1px solid #eee; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.02);">
                            <div class="box-header with-border" style="background: #fcfcfc;">
                                <h4 style="font-weight: 800; color: #3c8dbc; margin: 0; display: flex; align-items: center; gap: 10px;">
                                    <i class="fa fa-table"></i> ملخص المواصفات والبيانات اللوجستية
                                </h4>
                            </div>
                            <div class="box-body no-padding">
                                <div class="table-responsive">
                                    <table class="table table-bordered text-center" style="margin-bottom: 0; font-size: 13px;">
                                        <thead style="background: #f9f9f9; color: #555;">
                                            <tr>
                                                <th style="vertical-align: middle;">اسم المنتج</th>
                                                <th style="vertical-align: middle;">السعر</th>
                                                <th style="vertical-align: middle;">القطع/الكرتونة</th>
                                                <th style="vertical-align: middle;">وزن القطعة</th>
                                                <th style="vertical-align: middle;">أدنى طلب</th>
                                                <th style="vertical-align: middle;">الطول</th>
                                                <th style="vertical-align: middle;">العرض</th>
                                                <th style="vertical-align: middle;">الارتفاع</th>
                                                <th style="vertical-align: middle;">CBM</th>
                                                <th style="vertical-align: middle; background: #eef7ff;">حاوية 20</th>
                                                <th style="vertical-align: middle; background: #eef7ff;">حاوية 40</th>
                                                <th style="vertical-align: middle; background: #eef7ff;">حاوية 40HQ</th>
                                                <th style="vertical-align: middle; background: #eef7ff;">حاوية 45</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td style="font-weight: bold; color: #333;">{{ $product->name }}</td>
                                                <td class="english-nums" style="font-weight: bold;">{{ number_format($product->price, 2) }} {{ $product->currency_code }}</td>
                                                <td class="english-nums">{{ $product->product_piece_count }}</td>
                                                <td class="english-nums">{{ $product->piece_weight }} KG</td>
                                                <td class="english-nums">{{ $product->min_order_quantity }}</td>
                                                <td class="english-nums">{{ $product->carton_length }} cm</td>
                                                <td class="english-nums">{{ $product->carton_width }} cm</td>
                                                <td class="english-nums">{{ $product->carton_height }} cm</td>
                                                <td class="english-nums" style="font-weight: bold; color: #3c8dbc;">{{ $product->carton_volume_cbm }}</td>
                                                <td class="english-nums" style="font-weight: 800; color: #1e3a5f; background: #fcfdff;">{{ number_format($product->container_20ft_capacity ?? floor(28 / ($product->carton_volume_cbm > 0 ? $product->carton_volume_cbm : 1))) }}</td>
                                                <td class="english-nums" style="font-weight: 800; color: #1e3a5f; background: #fcfdff;">{{ number_format($product->container_40ft_capacity ?? floor(40 / ($product->carton_volume_cbm > 0 ? $product->carton_volume_cbm : 1))) }}</td>
                                                <td class="english-nums" style="font-weight: 800; color: #1e3a5f; background: #fcfdff;">{{ number_format($product->container_40hq_capacity ?? floor(68 / ($product->carton_volume_cbm > 0 ? $product->carton_volume_cbm : 1))) }}</td>
                                                <td class="english-nums" style="font-weight: 800; color: #1e3a5f; background: #fcfdff;">{{ number_format($product->container_45ft_capacity ?? floor(78 / ($product->carton_volume_cbm > 0 ? $product->carton_volume_cbm : 1))) }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <div class="description-box">
                    <h4 style="font-weight: 800; color: #333; margin-bottom: 15px; display: flex; align-items: center; gap: 10px;">
                        <span style="width: 4px; height: 20px; background: #3c8dbc; border-radius: 2px;"></span>
                        وصف المنتج
                    </h4>
                    <div style="font-size: 16px; line-height: 1.8; color: #4a4a4a; padding: 10px; background: #fcfcfc; border-radius: 8px;">
                        {!! $product->description !!}
                    </div>
                </div>
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

<style>
    .img-zoom-container:hover .img-zoom-result {
        visibility: visible;
    }
    .thumb-item:hover {
        border-color: #3c8dbc !important;
        transform: translateY(-2px);
    }
    
    .main-image-wrapper {
        box-shadow: 0 10px 30px rgba(0,0,0,0.08) !important;
    }
</style>

@push('scripts')
<script>
    function processTextNodes(node) {
        // Redundant - handled by global layout
    }

    function changeMainImage(src, element) {
        const mainImg = document.getElementById('main-product-image');
        mainImg.style.opacity = '0.5';
        setTimeout(() => {
            mainImg.src = src;
            mainImg.style.opacity = '1';
            imageZoom("main-product-image", "zoom-result");
        }, 150);
        
        document.querySelectorAll('.thumb-item').forEach(item => {
            item.style.borderColor = '#eee';
            item.classList.remove('active');
        });
        element.style.borderColor = '#3c8dbc';
        element.classList.add('active');
    }

    function imageZoom(imgID, resultID) {
        var img, lens, result, cx, cy;
        img = document.getElementById(imgID);
        result = document.getElementById(resultID);
        lens = document.getElementById('zoom-lens');
        
        if (!img || !result || !lens) return;

        /* Calculate the ratio between result DIV and lens: */
        cx = result.offsetWidth / lens.offsetWidth;
        cy = result.offsetHeight / lens.offsetHeight;

        /* Set background properties for the result DIV */
        result.style.backgroundImage = "url('" + img.src + "')";
        result.style.backgroundSize = (img.width * cx) + "px " + (img.height * cy) + "px";

        /* Execute a function when someone moves the cursor over the image, or the lens: */
        img.parentNode.addEventListener("mousemove", moveLens);
        img.parentNode.addEventListener("mouseenter", () => {
             lens.style.visibility = "visible";
             result.style.visibility = "visible";
        });
        img.parentNode.addEventListener("mouseleave", () => {
             lens.style.visibility = "hidden";
             result.style.visibility = "hidden";
        });

        function moveLens(e) {
            var pos, x, y;
            /* Prevent any other actions that may occur when moving over the image */
            e.preventDefault();
            /* Get the cursor's x and y positions: */
            pos = getCursorPos(e);
            /* Calculate the position of the lens: */
            x = pos.x - (lens.offsetWidth / 2);
            y = pos.y - (lens.offsetHeight / 2);
            /* Prevent the lens from being positioned outside the image: */
            if (x > img.width - lens.offsetWidth) {x = img.width - lens.offsetWidth;}
            if (x < 0) {x = 0;}
            if (y > img.height - lens.offsetHeight) {y = img.height - lens.offsetHeight;}
            if (y < 0) {y = 0;}
            /* Set the position of the lens: */
            lens.style.left = x + "px";
            lens.style.top = y + "px";
            /* Display what the lens "sees": */
            result.style.backgroundPosition = "-" + (x * cx) + "px -" + (y * cy) + "px";
        }

        function getCursorPos(e) {
            var a, x = 0, y = 0;
            e = e || window.event;
            /* Get the x and y positions of the image: */
            a = img.getBoundingClientRect();
            /* Calculate the cursor's x and y positions, relative to the image: */
            x = e.pageX - a.left;
            y = e.pageY - a.top;
            /* Consider any page scrolling: */
            x = x - window.pageXOffset;
            y = y - window.pageYOffset;
            return {x : x, y : y};
        }
    }

        // Init Zoom
        if(document.getElementById('main-product-image')) {
            imageZoom("main-product-image", "zoom-result");
        }
</script>
@endpush
@endsection
