@extends('client.layouts.master')

@section('title', $product->name . ' | تفاصيل المنتج')

@section('content')
<!-- Import modern font for numbers -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet">
<section class="content-header">
    <h1>تفاصيل المنتج <small>{{ $product->name }}</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('client.dashboard') }}"><i class="fa fa-dashboard"></i> الرئيسية</a></li>
        <li><a href="{{ route('site.products.index') }}">منتجات الموقع</a></li>
        <li class="active">تفاصيل المنتج</li>
    </ol>
</section>

<section class="content">
    <div class="box box-solid" style="border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
        <div class="box-body" style="padding: 30px;">
            <div class="row">
                <!-- Product Gallery (Amazon Style) -->
                <div class="col-md-7">
                    <div class="row">
                        <!-- Vertical Thumbnails -->
                        <div class="col-md-2 hidden-xs hidden-sm">
                            <div class="thumbnails-container" style="display: flex; flex-direction: column; gap: 10px;">
                                @foreach($product->images as $index => $image)
                                    <img src="{{ asset('storage/' . $image->image_path) }}" 
                                         class="img-thumbnail thumb-gallery {{ $index === 0 ? 'active' : '' }}" 
                                         style="width: 100%; aspect-ratio: 1/1; object-fit: cover; cursor: pointer; border: 2px solid {{ $index === 0 ? '#3c8dbc' : '#eee' }}; transition: padding 0.2s;"
                                         onclick="changeMainImage(this, '{{ asset('storage/' . $image->image_path) }}')">
                                @endforeach
                            </div>
                        </div>
                        
                        <!-- Main Display Image -->
                        <div class="col-md-10">
                            <div id="main-image-display" class="zoom-container" style="border: 1px solid #eee; border-radius: 8px; overflow: hidden; width: 100%; aspect-ratio: 4/3; background: #fafafa; display: flex; align-items: center; justify-content: center; cursor: zoom-in; position: relative;">
                                @php $firstImage = $product->images->first(); @endphp
                                <img id="primaryImage" src="{{ $firstImage ? asset('storage/' . $firstImage->image_path) : asset('dist/img/boxed-bg.jpg') }}" 
                                     style="max-width: 100%; max-height: 100%; object-fit: contain; transition: transform 0.1s ease-out; transform-origin: center center;">
                            </div>
                            
                            <!-- Mobile Thumbnails -->
                            <div class="visible-xs visible-sm" style="margin-top: 15px;">
                                <div style="display: flex; gap: 10px; overflow-x: auto; padding-bottom: 10px;">
                                    @foreach($product->images as $image)
                                        <img src="{{ asset('storage/' . $image->image_path) }}" 
                                             class="img-thumbnail" 
                                             style="width: 80px; height: 80px; object-fit: cover; flex-shrink: 0;"
                                             onclick="document.getElementById('primaryImage').src = this.src">
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product Information -->
                <div class="col-md-5">
                    <div style="padding: 0 15px;">
                        <span class="label label-info" style="font-size: 14px; padding: 5px 12px;">{{ $product->sector->name_ar }}</span>
                        <h2 style="font-weight: 900; color: #2c3e50; font-size: 32px; margin: 15px 0;">{{ $product->name }}</h2>
                        
                        <div style="margin-bottom: 25px;">
                            <span style="font-size: 48px; font-weight: 900; color: #000; direction: ltr; display: inline-block; font-family: 'Inter', sans-serif;" class="english-nums">
                                {{ number_format($product->price, 2, '.', '') }} <small style="font-size: 22px; color: #333;">{{ $product->currency_code }}</small>
                            </span>
                        </div>

                        <!-- Main Action Buttons Moved to Top -->
                        <div style="margin-bottom: 30px; display: flex; gap: 15px;">
                            <button id="btnOrderModalTop" class="btn btn-success btn-flat w-100" style="flex: 3; border-radius: 8px; font-weight: 900; font-size: 24px; padding: 15px; background: #00a65a; border: none; box-shadow: 0 4px 15px rgba(0, 166, 90, 0.4); transition: all 0.3s;" data-bs-toggle="modal" data-bs-target="#orderModal">
                                <i class="fa fa-shopping-cart fa-lg"></i> اطلب الآن
                            </button>
                            <a href="{{ route('site.products.index') }}" class="btn btn-default btn-flat" style="flex: 1; border-radius: 8px; font-weight: bold; font-size: 18px; padding: 15px; display: flex; align-items: center; justify-content: center;">
                                <i class="fa fa-arrow-right"></i> رجوع
                            </a>
                        </div>

                        <div style="background: #fdfdfd; padding: 20px; border-radius: 8px; border: 1px solid #f0f0f0; margin-bottom: 25px;">
                            <h4 style="font-weight: bold; color: #555; margin-top: 0; border-bottom: 2px solid #3c8dbc; display: inline-block; padding-bottom: 5px;">وصف المنتج</h4>
                            <div style="font-size: 17px; line-height: 1.8; color: #444; text-align: justify; margin-top: 15px;">
                                {!! $product->description !!}
                            </div>
                        </div>

                        <ul class="list-group list-group-unbordered">
                            <li class="list-group-item">
                                <b>الفرع</b> <a class="pull-left">{{ $product->branch->name_ar ?? 'N/A' }}</a>
                            </li>
                            <li class="list-group-item">
                                <b>القسم</b> <a class="pull-left">{{ $product->category->name_ar ?? 'N/A' }}</a>
                            </li>
                            <li class="list-group-item">
                                <b>الحد الأدنى للطلبية</b> <a class="pull-left text-bold english-nums" style="font-size: 16px;">{{ number_format($product->min_order_quantity) }}</a>
                            </li>
                            <li class="list-group-item">
                                <b>عدد القطع/الكرتونة</b> <a class="pull-left text-bold english-nums">{{ $product->product_piece_count }}</a>
                            </li>
                            <li class="list-group-item">
                                <b>وزن القطعة</b> <a class="pull-left text-bold english-nums">{{ $product->piece_weight }} KG</a>
                            </li>
                            <li class="list-group-item">
                                <b>حجم CBM</b> <a class="pull-left text-bold text-primary english-nums" style="direction: ltr;">{{ $product->carton_volume_cbm }}</a>
                            </li>
                            <li class="list-group-item">
                                <b>مقاس الكرتونة (ط×ع×ا)</b> <a class="pull-left english-nums">{{ $product->carton_length }}x{{ $product->carton_width }}x{{ $product->carton_height }} cm</a>
                            </li>
                            <li class="list-group-item">
                                <b>وحدة الشحن الافتراضية</b> <a class="pull-left">{{ $product->shipping_unit_type }}</a>
                            </li>
                            <li class="list-group-item">
                                <b>الكمية المتاحة</b> <a class="pull-left text-bold text-primary english-nums" style="font-size: 18px; direction: ltr;">{{ number_format($product->quantity) }}</a>
                            </li>
                            <li class="list-group-item">
                                <b>تاريخ الإضافة</b> <a class="pull-left text-muted">{{ $product->created_at->format('Y-m-d') }}</a>
                            </li>
                        </ul>


                </div>
            </div>

            <!-- Shipping Capacity Section -->
            <div class="row" style="margin-top: 25px;">
                <div class="col-md-12">
                    <div style="background: #fcfcfc; border: 1px solid #eee; border-radius: 12px; padding: 25px; box-shadow: 0 2px 10px rgba(0,0,0,0.02);">
                        <h4 style="font-weight: 800; color: #3c8dbc; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
                            <i class="fa fa-ship"></i> سعة الشحن المتوقعة للحاويات
                        </h4>
                        <div class="row">
                            @php
                                $unitCbm = $product->total_cbm > 0 ? $product->total_cbm : ($product->carton_volume_cbm * ($product->product_piece_count > 0 ? $product->product_piece_count : 1));
                                $unitCbm = $unitCbm > 0 ? $unitCbm : 1; 
                                $piecesPerCarton = $product->product_piece_count > 0 ? $product->product_piece_count : 1;
                                
                                $containers = [
                                    ['name' => 'CBM 1',          'cap' => 1,  'icon' => 'fa-cube',       'maxWeight' => null],
                                    ['name' => '20FT (28 CBM)',  'cap' => 28, 'icon' => 'fa-th-large',  'maxWeight' => 22000],
                                    ['name' => '40FT (40 CBM)',  'cap' => 40, 'icon' => 'fa-th-large',  'maxWeight' => 24000],
                                    ['name' => '40HQ (68 CBM)',  'cap' => 68, 'icon' => 'fa-truck',     'maxWeight' => 24000],
                                    ['name' => '45FT (78 CBM)',  'cap' => 78, 'icon' => 'fa-ship',      'maxWeight' => 20000]
                                ];
                            @endphp

                            @foreach($containers as $container)
                                @php
                                    $cartonsPer1Cbm = floor(1 / $unitCbm);
                                    $cartons = ($container['name'] === 'CBM 1') ? $cartonsPer1Cbm : ($cartonsPer1Cbm * $container['cap']);
                                    
                                    $totalPieces = $cartons * $piecesPerCarton;
                                    $totalWeightKg = $totalPieces * $product->piece_weight;
                                    $isOverweight = $container['maxWeight'] && ($totalWeightKg > $container['maxWeight']);
                                    
                                    $weightStr = $totalWeightKg > 1000 ? number_format($totalWeightKg / 1000, 2) . ' Ton' : number_format($totalWeightKg, 2) . ' KG';
                                    $bgGradient = $isOverweight ? 'linear-gradient(135deg, #f39c12, #e67e22)' : 'linear-gradient(135deg, #3c8dbc, #2980b9)';
                                @endphp
                                <div class="col-md-4 col-sm-6 col-xs-12" style="margin-bottom: 20px;">
                                    <div style="background: #fff; border: none; border-radius: 15px; overflow: hidden; transition: all 0.3s ease; box-shadow: 0 10px 20px rgba(0,0,0,0.1); height: 100%;">
                                        <div style="background: {{ $bgGradient }}; color: white; padding: 15px; font-weight: bold; display: flex; align-items: center; justify-content: space-between;">
                                            <span style="font-size: 16px;"><i class="fa {{ $container['icon'] }}"></i> {{ $container['name'] }}</span>
                                            @if($container['name'] !== 'CBM 1')
                                                <span style="font-size: 11px; background: rgba(255,255,255,0.25); padding: 3px 10px; border-radius: 20px; text-transform: uppercase; letter-spacing: 0.5px;">{{ $container['cap'] }} CBM</span>
                                            @endif
                                        </div>
                                        <div style="padding: 20px; background: {{ $isOverweight ? '#fffef9' : '#fff' }};">
                                            <div style="display: flex; justify-content: space-between; margin-bottom: 10px; border-bottom: 1px solid #f8f8f8; padding-bottom: 8px;">
                                                <span style="color: #777;">عدد الكراتين:</span>
                                                <span class="english-nums" style="font-weight: 800; color: #333; font-size: 16px;">{{ number_format($cartons) }}</span>
                                            </div>
                                            <div style="display: flex; justify-content: space-between; margin-bottom: 10px; border-bottom: 1px solid #f8f8f8; padding-bottom: 8px;">
                                                <span style="color: #777;">إجمالي القطع:</span>
                                                <span class="english-nums" style="font-weight: 800; color: #333; font-size: 16px;">{{ number_format($totalPieces) }}</span>
                                            </div>
                                            <div style="display: flex; justify-content: space-between; margin-bottom: 10px; border-bottom: 1px solid #f8f8f8; padding-bottom: 8px;">
                                                <span style="color: #777;">الوزن الكلي:</span>
                                                <span class="english-nums" style="font-weight: 800; color: {{ $isOverweight ? '#e67e22' : '#d9534f' }}; font-size: 16px;">{{ $totalWeightKg > 1000 ? number_format($totalWeightKg , 2) . ' kg' : number_format($totalWeightKg, 2) . ' kg' }}</span>
                                            </div>
                                            <div style="display: flex; justify-content: space-between; margin-top: 15px; padding: 10px; background: {{ $isOverweight ? '#fff3cd' : '#f8fbff' }}; border-radius: 8px; border: 1px {{ $isOverweight ? 'dashed #f39c12' : 'solid #ebf2ff' }};">
                                                <span style="color: {{ $isOverweight ? '#856404' : '#3c8dbc' }}; font-weight: bold;">السعر الإجمالي:</span>
                                                <span class="english-nums" style="font-weight: 900; color: {{ $isOverweight ? '#856404' : '#1e3a5f' }}; font-size: 17px;">
                                                    {{ $product->currency_code }} {{ number_format($totalPieces * $product->price) }}
                                                </span>
                                            </div>

                                            @if($isOverweight)
                                                <div style="margin-top: 12px; padding: 8px 12px; background: rgba(243, 156, 18, 0.1); border-radius: 8px; border: 1px solid rgba(243, 156, 18, 0.3); display: flex; align-items: center; gap: 8px;">
                                                    <i class="fa fa-exclamation-triangle" style="color: #f39c12; font-size: 14px;"></i>
                                                    <span style="font-size: 11px; color: #856404; font-weight: bold;">تنبيه: تجاوز الوزن القياسي! ({{ number_format($totalWeightKg/1000, 1) }} طن)</span>
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

            <!-- Logistics Summary Table -->
            <div class="row" style="margin-top: 30px;">
                <div class="col-md-12">
                    <div class="box box-solid" style="border: 2px solid #3c8dbc; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.1); margin-bottom: 25px;">
                        <div class="box-header with-border" style="background: #eef7ff; padding: 15px 20px;">
                            <h3 class="box-title" style="font-weight: bold; color: #3c8dbc; font-size: 18px;">
                                <i class="fa fa-list"></i> ملخص المواصفات والبيانات اللوجستية
                            </h3>
                        </div>
                        <div class="box-body no-padding">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped text-center" id="batch_table" style="margin-bottom: 0; font-size: 14px; border: none;">
                                    <thead style="background: linear-gradient(135deg, #1e3a5f 0%, #3c8dbc 100%); color: white;">
                                        <tr>
                                            <th style="vertical-align: middle; border: none; padding: 12px 8px;">الصورة</th>
                                            <th style="vertical-align: middle; border: none; padding: 12px 8px;">اسم المنتج</th>
                                            <th style="vertical-align: middle; border: none; padding: 12px 8px;">ID المنتج</th>
                                            <th style="vertical-align: middle; border: none; padding: 12px 8px;">سعر الوحدة</th>
                                            <th style="vertical-align: middle; border: none; padding: 12px 8px;">وزن الوحدة</th>
                                            <th style="vertical-align: middle; border: none; padding: 12px 8px;">طول الكرتونة (m)</th>
                                            <th style="vertical-align: middle; border: none; padding: 12px 8px;">عرض الكرتونة (m)</th>
                                            <th style="vertical-align: middle; border: none; padding: 12px 8px;">ارتفاع الكرتونة (m)</th>
                                            <th style="vertical-align: middle; border: none; padding: 12px 8px;">CBM الوحدة</th>
                                            <th style="vertical-align: middle; border: none; padding: 12px 8px;">عدد الوحدات في الكرتونة</th>
                                            <th style="vertical-align: middle; border: none; background: #2b6688; padding: 12px 8px;">حجم الكرتونة CBM</th>
                                            <th style="vertical-align: middle; border: none; background: #2b6688; padding: 12px 8px;">وزن الكرتونة (kg)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style="vertical-align: middle;">
                                                @if($product->images->isNotEmpty())
                                                    <img src="{{ url('storage/'.$product->images->first()->image_path) }}" 
                                                         style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px; border: 1px solid #ddd;">
                                                @else
                                                    <div style="width: 50px; height: 50px; background: #f4f4f4; display: flex; align-items: center; justify-content: center; border-radius: 5px;">
                                                        <i class="fa fa-image text-muted"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td style="vertical-align: middle; font-weight: bold; color: #333;">{{ $product->name }}</td>
                                            <td style="vertical-align: middle;">
                                                <div style="font-weight: bold; color: #333;">{{ $product->sku ?: '-' }}</div>
                                            </td>
                                            <td style="vertical-align: middle;">
                                                <div style="color: #d9534f; font-weight: bold;">
                                                    {{ $product->currency_code }} <span class="english-nums">{{ number_format($product->price, 2) }}</span>
                                                </div>
                                            </td>
                                            <td style="vertical-align: middle;">
                                                <div class="english-nums">{{ number_format($product->piece_weight, 2) }} كجم</div>
                                            </td>
                                            <td style="vertical-align: middle;">
                                                <div class="english-nums">{{ number_format($product->carton_length, 2) }}</div>
                                            </td>
                                            <td style="vertical-align: middle;">
                                                <div class="english-nums">{{ number_format($product->carton_width, 2) }}</div>
                                            </td>
                                            <td style="vertical-align: middle;">
                                                <div class="english-nums">{{ number_format($product->carton_height, 2) }}</div>
                                            </td>
                                            <td style="vertical-align: middle;">
                                                <div class="english-nums">{{ number_format($product->carton_volume_cbm, 4) }}</div>
                                            </td>
                                            <td style="vertical-align: middle;">
                                                <div class="english-nums" style="font-weight: bold;">{{ $product->product_piece_count }}</div>
                                            </td>
                                            <td style="vertical-align: middle; background: #fff9e6;">
                                                <div class="english-nums" style="font-weight: bold; color: #b8860b;">{{ number_format($product->total_cbm, 4) }}</div>
                                            </td>
                                            <td style="vertical-align: middle; background: #fff9e6;">
                                                <div class="english-nums" style="font-weight: bold; color: #b8860b;">{{ number_format($product->total_weight, 2) }} كجم</div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

    <!-- Specifications Sections Stacked -->
    <div class="row" style="margin-top: 30px;">
        <!-- Custom Info Table -->
        <div class="col-md-12">
            <div class="box box-primary" style="border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border: none;">
                <div class="box-header with-border" style="background: #fcfcfc; border-radius: 12px 12px 0 0;">
                    <h3 class="box-title" style="font-weight: 800; color: #333;"><i class="fa fa-info-circle text-primary"></i> معلومات مخصصة</h3>
                </div>
                <div class="box-body no-padding">
                    @php $customInfo = is_array($product->custom_info) ? $product->custom_info : json_decode($product->custom_info, true); @endphp
                    @if($customInfo && isset($customInfo['headers']) && count($customInfo['headers']) > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" style="margin-bottom: 0;">
                                <thead style="background: #f4f7f9;">
                                    <tr>
                                        @foreach($customInfo['headers'] as $header)
                                            @if($header) <th style="padding: 15px; border-bottom: 2px solid #eee;">{{ $header }}</th> @endif
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($customInfo['rows'] as $row)
                                        <tr>
                                            @foreach($row as $cell)
                                                <td style="padding: 12px 15px;" class="english-nums">{{ $cell }}</td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
            <div class="box box-info" style="border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border: none;">
                <div class="box-header with-border" style="background: #fcfcfc; border-radius: 12px 12px 0 0;">
                    <h3 class="box-title" style="font-weight: 800; color: #333;"><i class="fa fa-th-list text-info"></i> خصائص المنتج (الكتالوج)</h3>
                </div>
                <div class="box-body no-padding">
                    @php $catalog = is_array($product->product_catalog) ? $product->product_catalog : json_decode($product->product_catalog, true); @endphp
                    @if($catalog && isset($catalog['headers']) && count($catalog['headers']) > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" style="margin-bottom: 0;">
                                <thead style="background: #f0faff;">
                                    <tr>
                                        @foreach($catalog['headers'] as $header)
                                            @if($header) <th style="padding: 15px; border-bottom: 2px solid #eee;">{{ $header }}</th> @endif
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($catalog['rows'] as $row)
                                        <tr>
                                            @foreach($row as $cell)
                                                <td style="padding: 12px 15px;" class="english-nums">{{ $cell }}</td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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

    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
        <div class="box box-default" style="margin-top: 40px; background: transparent; border: none; box-shadow: none;">
            <div class="box-header" style="padding: 10px 0;">
                <h3 class="box-title" style="font-weight: bold; font-size: 24px;">منتجات مشابهة</h3>
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
    <div class="modal fade" id="orderModal" tabindex="-1" role="dialog" aria-labelledby="orderModalLabel">
        <div class="modal-dialog modal-lg" role="document" style="width: 98% !important; max-width: 98vw; margin: 10px auto;">
            <div class="modal-content" style="border-radius: 12px; overflow: hidden; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                <div class="modal-header" style="background: linear-gradient(135deg, #1e3a5f 0%, #3c8dbc 100%); color: white; border-bottom: none; padding: 20px;">
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close" style="color: white; opacity: 1;"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="orderModalLabel" style="font-weight: 800; font-size: 20px; display: flex; align-items: center; justify-content: space-between; width: 100%; padding-right: 30px;">
                        <span><i class="fa fa-shopping-cart"></i> إضافة للسلة وتحديد القياسات اللوجستية</span>
                        <button type="button" id="btnToggleSpecialView" class="btn btn-sm" style="background: rgba(255,255,255,0.2); color: white; border: 1px solid rgba(255,255,255,0.4); border-radius: 20px; padding: 5px 15px; font-weight: bold; transition: all 0.3s;">
                            <i class="fa fa-th-large"></i> حاويات خاصة
                        </button>
                    </h4>
                </div>
                <form id="orderForm">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <div class="modal-body" style="padding: 30px; background: #fefefe; max-height: 85vh; overflow-y: auto;">
                        <div id="standardOrderView">
                            <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label style="font-weight: 700; color: #444; margin-bottom: 8px;">الكمية المطلوبة (قطع)</label>
                                    <input type="number" name="quantity" id="order_quantity" class="form-control" value="{{ $product->min_order_quantity }}" min="{{ $product->min_order_quantity }}" required style="height: 45px; border-radius: 6px; font-size: 18px; font-weight: bold;">
                                    <small class="text-muted">أدنى كمية: <span class="english-nums">{{ number_format($product->min_order_quantity) }}</span></small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label style="font-weight: 700; color: #444; margin-bottom: 8px;">عدد الكرتونات</label>
                                    <input type="number" id="order_cartons" class="form-control" value="{{ ceil($product->min_order_quantity / ($product->product_piece_count >0 ? $product->product_piece_count : 1)) }}" min="1" required style="height: 45px; border-radius: 6px; font-size: 18px; font-weight: bold;">
                                    <small class="text-muted">الحد الأدنى للكراتين: <span class="english-nums">{{ ceil($product->min_order_quantity / ($product->product_piece_count >0 ? $product->product_piece_count : 1)) }}</span></small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label style="font-weight: 700; color: #444; margin-bottom: 8px;">حجم الـ CBM المطلوب</label>
                                    <input type="number" step="0.001" id="order_cbm_input" class="form-control english-nums" placeholder="0.000" style="height: 45px; border-radius: 6px; font-size: 18px; font-weight: bold; border: 2px solid #3c8dbc; background: #f0f7ff;">
                                    <small class="text-muted">أو اطلب بناءً على الحجم</small>
                                </div>
                            </div>
                            <div class="col-md-6" style="margin-top: 15px;">
                                <div class="form-group">
                                    <label style="font-weight: 700; color: #444; margin-bottom: 8px;">إجمالي الوزن (كيلو)</label>
                                    <input type="text" id="order_weight_display" class="form-control english-nums" readonly style="height: 45px; border-radius: 6px; font-size: 18px; font-weight: bold; background: #fdfdfd; border: 1px solid #ddd;">
                                    <small class="text-muted">الوزن الكلي المقدر للطلب</small>
                                </div>
                            </div>
                            <div class="col-md-6" style="margin-top: 15px;">
                                <div class="form-group">
                                    <label style="font-weight: 700; color: #444; margin-bottom: 8px;">إجمالي السعر</label>
                                    <input type="text" id="order_price_display" class="form-control english-nums" readonly style="height: 45px; border-radius: 6px; font-size: 18px; font-weight: bold; background: #fffcf0; border: 1px solid #ffeeba; color: #856404;">
                                    <small class="text-muted">التكلفة الإجمالية للمنتجات</small>
                                </div>
                            </div>
                        </div>

                        <!-- CBM Status Alert -->
                        <div id="cbm_status_box" style="display: none; margin-bottom: 15px; padding: 12px; border-radius: 8px; font-weight: bold; text-align: center; border: 1px solid transparent;">
                        </div>
                        
                        @if(in_array(auth()->user()->type ?? '', ['merchant', 'company_owner']))
                        <div class="shipping-visuals-container" style="margin-top: 20px; margin-bottom: 15px;">
                            <label style="font-weight: 700; color: #444; margin-bottom: 12px; display: block;">عرض سريع للحاويات المتاحة</label>
                            <input type="hidden" name="shipping_unit_type" id="shipping_unit_type" value="{{ $product->shipping_unit_type ?? 'CBM' }}">
                            <div style="display: flex; gap: 8px; justify-content: space-between; flex-wrap: wrap;">
                                <!-- CBM Option -->
                                <div class="container-option-item" data-value="CBM" style="flex: 1; min-width: 100px; cursor: pointer; text-align: center; background: #f9f9f9; border: 2px solid #eee; border-radius: 12px; padding: 20px 10px; transition: all 0.3s ease;">
                                    <div style="font-size: 45px; color: #3c8dbc; margin-bottom: 8px;"><i class="fa fa-cube"></i></div>
                                    <div style="font-size: 14px; font-weight: bold; color: #444;">CBM</div>
                                </div>
                                <!-- 20FT Option -->
                                <div class="container-option-item" data-value="20ft" style="flex: 1; min-width: 100px; cursor: pointer; text-align: center; background: #f9f9f9; border: 2px solid #eee; border-radius: 12px; padding: 20px 10px; transition: all 0.3s ease;">
                                    <img src="{{ asset('storage/حاوية.png') }}" style="height: 50px; width: auto; object-fit: contain; margin-bottom: 8px; filter: drop-shadow(0 4px 4px rgba(0,0,0,0.1));" alt="20ft">
                                    <div style="font-size: 14px; font-weight: bold; color: #444;">20FT</div>
                                </div>
                                <!-- 40FT Option -->
                                <div class="container-option-item" data-value="40ft" style="flex: 1; min-width: 100px; cursor: pointer; text-align: center; background: #f9f9f9; border: 2px solid #eee; border-radius: 12px; padding: 20px 10px; transition: all 0.3s ease;">
                                    <img src="{{ asset('storage/حاوية.png') }}" style="height: 60px; width: auto; object-fit: contain; margin-bottom: 5px; filter: drop-shadow(0 4px 4px rgba(0,0,0,0.1));" alt="40ft">
                                    <div style="font-size: 14px; font-weight: bold; color: #444;">40FT</div>
                                </div>
                                <!-- 40HQ Option -->
                                <div class="container-option-item" data-value="40hq" style="flex: 1; min-width: 100px; cursor: pointer; text-align: center; background: #f9f9f9; border: 2px solid #eee; border-radius: 12px; padding: 20px 10px; transition: all 0.3s ease;">
                                    <img src="{{ asset('storage/حاوية.png') }}" style="height: 75px; width: auto; object-fit: contain; margin-bottom: 2px; filter: drop-shadow(0 4px 5px rgba(0,0,0,0.1));" alt="40hq">
                                    <div style="font-size: 14px; font-weight: bold; color: #444;">40HQ</div>
                                </div>
                                <!-- 45FT Option -->
                                <div class="container-option-item" data-value="45ft" style="flex: 1; min-width: 100px; cursor: pointer; text-align: center; background: #f9f9f9; border: 2px solid #eee; border-radius: 12px; padding: 20px 10px; transition: all 0.3s ease;">
                                    <img src="{{ asset('storage/حاوية.png') }}" style="height: 85px; width: auto; object-fit: contain; margin-bottom: -5px; filter: drop-shadow(0 4px 5px rgba(0,0,0,0.1));" alt="45ft">
                                    <div style="font-size: 14px; font-weight: bold; color: #444;">45FT</div>
                                </div>
                            </div>

                            <!-- Container Capacity Summary (Merchant/Company Only) -->
                            <div id="container-capacity-summary" style="margin-top: 15px; background: #fff; border: 1px solid #e0e0e0; border-radius: 8px; padding: 12px; display: none;">
                                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 10px; border-bottom: 1px solid #f0f0f0; padding-bottom: 5px;">
                                    <i class="fa fa-info-circle" style="color: #3c8dbc;"></i>
                                    <span style="font-weight: bold; color: #444; font-size: 13px;">سعة الحاوية المختارة بالضبط</span>
                                </div>
                                <div class="row text-center" style="display: flex; justify-content: space-between;">
                                    <div style="flex: 1; border-right: 1px solid #eee;">
                                        <div style="font-size: 10px; color: #888;">CBM</div>
                                        <div id="cap_total_cbm" style="font-weight: 800; color: #3c8dbc; font-size: 13px;" class="english-nums">0</div>
                                    </div>
                                    <div style="flex: 1; border-right: 1px solid #eee;">
                                        <div style="font-size: 10px; color: #888;">الوزن</div>
                                        <div id="cap_total_weight" style="font-weight: 800; color: #f39c12; font-size: 13px;" class="english-nums">0</div>
                                    </div>
                                    <div style="flex: 1; border-right: 1px solid #eee;">
                                        <div style="font-size: 10px; color: #888;">كرتون</div>
                                        <div id="cap_total_cartons" style="font-weight: 800; color: #d9534f; font-size: 13px;" class="english-nums">0</div>
                                    </div>
                                    <div style="flex: 1; border-right: 1px solid #eee;">
                                        <div style="font-size: 10px; color: #888;">قطع</div>
                                        <div id="cap_total_pieces" style="font-weight: 800; color: #28a745; font-size: 13px;" class="english-nums">0</div>
                                    </div>
                                    <div style="flex: 1;">
                                        <div style="font-size: 10px; color: #888;">إجمالي السعر</div>
                                        <div id="cap_total_price" style="font-weight: 800; color: #856404; font-size: 12px;" class="english-nums">0</div>
                                        <div id="cap_total_price_words" style="font-size: 9px; color: #999; margin-top: 2px; line-height: 1; font-weight: bold; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">-</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="form-group" style="margin-top: 15px;">
                            <label style="font-weight: 700; color: #444; margin-bottom: 8px;">نوع الحاوية / وحدة الشحن</label>
                            <select name="shipping_unit_type" id="shipping_unit_type" class="form-control" required style="height: 45px; border-radius: 6px; font-weight: 600;">
                                <option value="CBM" {{ $product->shipping_unit_type == 'CBM' ? 'selected' : '' }}>CBM (متر مكعب)</option>
                                <option value="20ft" {{ $product->shipping_unit_type == '20ft' ? 'selected' : '' }}>20ft (حاوية 20 قدم)</option>
                                <option value="40ft" {{ $product->shipping_unit_type == '40ft' ? 'selected' : '' }}>40ft (حاوية 40 قدم)</option>
                                <option value="40hq" {{ $product->shipping_unit_type == '40hq' ? 'selected' : '' }}>40HQ (حاوية 40 HQ)</option>
                                <option value="45ft" {{ $product->shipping_unit_type == '45ft' ? 'selected' : '' }}>45ft (حاوية 45 قدم)</option>
                            </select>
                        </div>
                        @endif

                        <div class="form-group" style="margin-top: 15px;">
                            <label style="font-weight: 700; color: #444; margin-bottom: 8px;">ملاحظات إضافية</label>
                            <textarea name="notes" class="form-control" rows="3" placeholder="اكتب هنا أي تفاصيل أو مواصفات خاصة للطلب..." style="border-radius: 6px;"></textarea>
                        </div>

                        <!-- Dynamic Calculation Summary Table -->
                        <div id="order_results_panel" style="margin-top: 20px; border: 1px solid #e0e0e0; border-radius: 8px; overflow: hidden; background: #fff;">
                            <div class="table-responsive" style="margin-bottom: 0;">
                                <table class="table table-bordered table-striped text-center" style="margin-bottom: 0; font-size: 13px; border: none;">
                                    <thead style="background: linear-gradient(135deg, #1e3a5f 0%, #3c8dbc 100%); color: white;">
                                        <tr>
                                            <th style="vertical-align: middle; border: none; padding: 12px 8px;">ID المنتج</th>
                                            <th style="vertical-align: middle; border: none; padding: 12px 8px;">سعر الوحدة</th>
                                            <th style="vertical-align: middle; border: none; padding: 12px 8px;">وزن الوحدة</th>
                                            <th style="vertical-align: middle; border: none; padding: 12px 8px;">CBM الوحدة</th>
                                            <th style="vertical-align: middle; border: none; padding: 12px 8px;">الكمية (قطعة)</th>
                                            <th style="vertical-align: middle; border: none; background: #2b6688; padding: 12px 8px;">إجمالي CBM</th>
                                            <th style="vertical-align: middle; border: none; background: #2b6688; padding: 12px 8px;">إجمالي الوزن</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style="vertical-align: middle; font-weight: bold; color: #333;"><div class="english-nums">{{ $product->sku ?: $product->id }}</div></td>
                                            <td style="vertical-align: middle; font-weight: bold; color: #d9534f;">
                                                <div class="english-nums">{{ number_format($product->price, 2) }}</div>
                                                <small style="color: #666;">{{ $product->currency_code }}</small>
                                            </td>
                                            <td style="vertical-align: middle;"><div class="english-nums">{{ $product->piece_weight }} كجم</div></td>
                                            <td style="vertical-align: middle;"><div class="english-nums">{{ number_format($product->carton_volume_cbm, 4) }}</div></td>
                                            <td style="vertical-align: middle;">
                                                <div id="res_total_pieces" class="english-nums" style="font-weight: 800; font-size: 16px; color: #1e3a5f;">0</div>
                                                <div id="res_total_cartons_wrapper" style="font-size: 10px; color: #888; margin-top: 2px;"><span id="res_total_cartons" class="english-nums">0</span> كرتونة</div>
                                            </td>
                                            <td style="vertical-align: middle; background: #fff9e6;">
                                                <div id="res_total_cbm" class="english-nums" style="font-weight: 800; font-size: 16px; color: #b8860b;">0</div>
                                            </td>
                                            <td style="vertical-align: middle; background: #fff9e6;">
                                                <div id="res_total_weight" class="english-nums" style="font-weight: 800; font-size: 16px; color: #b8860b;">0 KG</div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div id="cost_estimate" style="margin-top: 20px; padding: 15px; background: #f0f7ff; border: 1px solid #d0e7ff; border-radius: 8px; text-align: center;">
                            <span style="font-weight: bold; color: #3c8dbc; font-size: 15px;">إجمالي التكلفة المتوقعة لمشترياتك:</span>
                            <div id="total_cost_calc" class="english-nums" style="font-size: 26px; font-weight: 900; color: #1e3a5f; margin-top: 5px;">
                                {{ number_format($product->price * $product->min_order_quantity, 2) }} {{ $product->currency_code }}
                            </div>
                        </div>
                        </div> <!-- End standardOrderView -->

                        <div id="specialContainersView" style="display: none; padding-top: 10px;">
                            <div class="text-center" style="margin-bottom: 20px; background: #fcfcfc; padding: 15px; border-radius: 15px; border: 1px dashed #ddd;">
                                <h2 style="font-weight: 800; color: #1e3a5f; margin-bottom: 5px; font-size: 20px;">دليل أنواع الحاويات الخاصة</h2>
                                <p class="text-muted" style="font-size: 13px;">اختر نوع الحاوية من الشريط أدناه لعرض مواصفاتها الكاملة</p>
                            </div>

                            <!-- Horizontal Carousel Strip -->
                            <div id="special-carousel-strip" style="display: flex; overflow-x: auto; gap: 12px; padding: 10px 5px 20px; border-bottom: 1px solid #f0f0f0; margin-bottom: 25px; scrollbar-width: thin; -webkit-overflow-scrolling: touch;">
                                <!-- Items will be injected by JS or rendered by Blade loop -->
                                @php
                                    $tanks = [
                                        ['name' => 'حاوية الصهريج القياسي (ISO Tank)', 'code' => 'TANK / T11', 'unit' => 'لتر (Liter)', 'capacity' => '21,000 - 26,000 L', 'load' => '25,000 KG', 'usage' => 'نقل السوائل الكيميائية والغذائية والزيوت.', 'icon' => 'fa-flask', 'color' => '#3c8dbc', 'numeric_cbm' => 26.0],
                                        ['name' => 'حاوية صهريج الغاز (Gas Tank)', 'code' => 'GAS TANK / T50', 'unit' => 'لتر / متر مكعب (m³)', 'capacity' => '24,000 L تقريباً', 'load' => 'تعتمد على كثافة الغاز المشحون وضغط التشغيل.', 'usage' => 'الغازات المسالة تحت ضغط عالٍ.', 'icon' => 'fa-tint', 'color' => '#3c8dbc', 'numeric_cbm' => 24.0],
                                        ['name' => 'حاوية صهريج الأسفلت (Bitumen Tank)', 'code' => 'BITU TANK', 'unit' => 'لتر (Liter)', 'capacity' => '20,000 - 24,000 L', 'load' => '24,000 KG', 'usage' => 'الأسفلت السائل (مزودة بنظام تسخين داخلي).', 'icon' => 'fa-flask', 'color' => '#3c8dbc', 'numeric_cbm' => 24.0]
                                    ];
                                    $platforms = [
                                        ['name' => 'حاوية السقف المفتوح 20 قدم (20ft Open Top)', 'code' => '20OT', 'unit' => 'متر مكعب (CBM)', 'capacity' => '32.2 CBM', 'load' => '21,500 KG', 'usage' => 'البضائع المرتفعة أو التي تُحمل من الأعلى بالكرين.', 'icon' => 'fa-cube', 'color' => '#f39c12', 'numeric_cbm' => 32.2],
                                        ['name' => 'حاوية السقف المفتوح 40 قدم (40ft Open Top)', 'code' => '40OT', 'unit' => 'متر مكعب (CBM)', 'capacity' => '65.5 CBM', 'load' => '26,000 KG', 'usage' => 'المعدات الطويلة والمرتفعة التي تتجاوز سقف الحاوية القياسي.', 'icon' => 'fa-cube', 'color' => '#f39c12', 'numeric_cbm' => 65.5],
                                        ['name' => 'حاوية الرف المسطح 20 قدم (20ft Flat Rack)', 'code' => '20FR', 'unit' => 'أبعاد الشحنة والوزن', 'capacity' => 'مفتوحة (Open Dimension)', 'load' => '28,000 KG', 'usage' => 'الآلات الثقيلة والطرود عريضة الحجم (OOG).', 'icon' => 'fa-minus-square-o', 'color' => '#f39c12', 'numeric_cbm' => 28.0],
                                        ['name' => 'حاوية الرف المسطح 40 قدم (40ft Flat Rack)', 'code' => '40FR', 'unit' => 'أبعاد الشحنة والوزن', 'capacity' => 'مفتوحة (Open Dimension)', 'load' => '35,000 KG', 'usage' => 'المولدات والآليات العملاقة فائقة الوزن.', 'icon' => 'fa-minus-square-o', 'color' => '#f39c12', 'numeric_cbm' => 60.0],
                                        ['name' => 'حاوية المنصة (Platform Container)', 'code' => '40PL / PL', 'unit' => 'الوزن الصافي', 'capacity' => 'مفتوحة تماماً', 'load' => '31,000 - 40,000 KG', 'usage' => 'أرضية فولاذية فقط للأوزان الاستثنائية التي لا تتناسب مع الأطر.', 'icon' => 'fa-th-large', 'color' => '#f39c12', 'numeric_cbm' => 30.0]
                                    ];
                                    $specials = [
                                        ['name' => 'الحاوية المبردة 20 قدم (20ft Reefer)', 'code' => '20RF', 'unit' => 'متر مكعب (CBM)', 'capacity' => '28.3 CBM', 'load' => '21,000 KG', 'usage' => 'الأدوية والأغذية التي تتطلب نظام تبريد نشط.', 'icon' => 'fa-snowflake-o', 'color' => '#28a745', 'numeric_cbm' => 28.3],
                                        ['name' => 'الحاوية المبردة العالية 40 قدم (40ft HC Reefer)', 'code' => '40RH / 40HCRF', 'unit' => 'متر مكعب (CBM)', 'capacity' => '67.5 CBM', 'load' => '26,000 KG', 'usage' => 'سعة تبريد ضخمة بارتفاع إضافي للشحنات الحساسة.', 'icon' => 'fa-snowflake-o', 'color' => '#28a745', 'numeric_cbm' => 67.5],
                                        ['name' => 'الحاوية المعزولة (Insulated Container)', 'code' => '20IN / 40IN', 'unit' => 'متر مكعب (CBM)', 'capacity' => '26.0 - 28.0 CBM', 'load' => '21,500 KG', 'usage' => 'الحفاظ على استقرار درجة الحرارة بدون محرك تبريد نشط.', 'icon' => 'fa-shield', 'color' => '#28a745', 'numeric_cbm' => 28.0],
                                        ['name' => 'الحاوية المهواة (Ventilated Container)', 'code' => '20VE', 'unit' => 'متر مكعب (CBM)', 'capacity' => '33.0 CBM', 'load' => '21,500 KG', 'usage' => 'البن والكاكاو (مزودة بفتحات تهوية طبيعية لمنع الرطوبة).', 'icon' => 'fa-refresh', 'color' => '#28a745', 'numeric_cbm' => 33.0]
                                    ];
                                    $operationals = [
                                        ['name' => 'حاوية الجوانب المفتوحة (Open Side Container)', 'code' => '20OS / 40OS', 'unit' => 'متر مكعب (CBM)', 'capacity' => '31.0 CBM', 'load' => '21,000 KG', 'usage' => 'تحميل جانبي كامل للبضائع الطويلة جداً التي لا تمر من الباب الخلفي.', 'icon' => 'fa-columns', 'color' => '#d9534f', 'numeric_cbm' => 31.0],
                                        ['name' => 'حاوية البضائع السائبة (Bulk Container)', 'code' => '20BU / 40BU', 'unit' => 'متر مكعب (CBM)', 'capacity' => '32.8 CBM', 'load' => '21,500 KG', 'usage' => 'شحن الحبوب والرمل والمواد الصب (تعبئة من السقف وتفريغ من الأسفل).', 'icon' => 'fa-truck', 'color' => '#d9534f', 'numeric_cbm' => 32.8]
                                    ];
                                    $allSpecialContainers = array_merge($tanks, $platforms, $specials, $operationals);
                                @endphp
                                @foreach($allSpecialContainers as $index => $item)
                                    <div class="special-nav-item {{ $index === 0 ? 'active' : '' }}" 
                                         data-index="{{ $index }}"
                                         style="flex: 0 0 120px; cursor: pointer; text-align: center; background: #fff; border: 2px solid #eee; border-radius: 12px; padding: 12px 8px; transition: all 0.3s ease; box-shadow: 0 2px 5px rgba(0,0,0,0.02);">
                                        <div style="font-size: 24px; color: {{ $item['color'] }}; margin-bottom: 8px; height: 35px; display: flex; align-items: center; justify-content: center;">
                                            <i class="fa {{ $item['icon'] }}"></i>
                                        </div>
                                        <div class="english-nums" style="font-size: 11px; font-weight: 800; color: #555; white-space: normal; line-height: 1.2; height: 26px; overflow: hidden;">{{ $item['name'] }}</div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Dynamic Detail Viewer -->
                            <div id="special-details-viewer" style="background: #fff; border: 1px solid #eef0f2; border-radius: 20px; padding: 35px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); min-height: 350px;">
                                <div id="special-detail-content" style="display: flex; gap: 40px; align-items: flex-start; flex-wrap: wrap;">
                                    <!-- Content Injected by JS -->
                                    <div class="text-center" style="width: 100%; padding: 50px; color: #ccc;">
                                        <i class="fa fa-refresh fa-spin" style="font-size: 40px; margin-bottom: 15px;"></i>
                                        <p>جاري تحميل البيانات...</p>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- End specialContainersView -->
                    </div>
                    <div class="modal-footer" style="background: #f9f9f9; border-top: 1px solid #eee; padding: 20px 30px;">
                        <button type="button" class="btn btn-default btn-lg" data-bs-dismiss="modal" style="border-radius: 30px; padding: 8px 30px; font-weight: 600;">إلغاء</button>
                        <button type="submit" class="btn btn-success btn-lg" id="btnSubmitOrder" style="background: #00a65a; border: none; border-radius: 30px; padding: 8px 40px; font-weight: bold; box-shadow: 0 4px 10px rgba(0, 166, 90, 0.3);">
                            وضع في سلة
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
// Global Arabic to English numeral conversion for the whole page
function convertToWesternNumerals(str) {
    const arabicNumerals = [/٠/g, /١/g, /٢/g, /٣/g, /٤/g, /٥/g, /٦/g, /٧/g, /٨/g, /٩/g];
    const westernNumerals = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
    if (typeof str === 'string') {
        for (let i = 0; i < 10; i++) {
            str = str.replace(arabicNumerals[i], westernNumerals[i]);
        }
    }
    return str;
}

function processTextNodes(node) {
    if (node.nodeName === 'SCRIPT' || node.nodeName === 'STYLE') return;
    if (node.nodeType === 3) {
        const originalValue = node.nodeValue;
        const convertedValue = convertToWesternNumerals(originalValue);
        if (originalValue !== convertedValue) {
            node.nodeValue = convertedValue;
        }
    } else {
        for (var i = 0; i < node.childNodes.length; i++) {
            processTextNodes(node.childNodes[i]);
        }
    }
}

function changeMainImage(el, src) {
    document.getElementById('primaryImage').src = src;
    $('.thumb-gallery').css('border-color', '#eee').removeClass('active');
    $(el).css('border-color', '#3c8dbc').addClass('active');
}

$(document).ready(function() {
    processTextNodes(document.body);
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            mutation.addedNodes.forEach(function(node) {
                processTextNodes(node);
            });
        });
    });
    observer.observe(document.body, { childList: true, subtree: true });

    // Image Zoom Logic
    const container = document.getElementById('main-image-display');
    const img = document.getElementById('primaryImage');

    container.addEventListener('mousemove', (e) => {
        const x = e.clientX - container.offsetLeft;
        const y = e.clientY - container.offsetTop;

        const xPercent = (e.offsetX / container.offsetWidth) * 100;
        const yPercent = (e.offsetY / container.offsetHeight) * 100;

        img.style.transformOrigin = `${xPercent}% ${yPercent}%`;
        img.style.transform = "scale(1.5)";
    });

    container.addEventListener('mouseleave', () => {
        img.style.transform = "scale(1)";
        img.style.transformOrigin = "center center";
    });

    const piecesPerCarton = parseFloat("{{ $product->product_piece_count }}") || 1;
    const pieceWeight = parseFloat("{{ $product->piece_weight }}") || 0;
    const cartonVolume = parseFloat("{{ $product->carton_volume_cbm }}") || 0;
    const cbm1Capacity = parseInt("{{ $product->cbm_1_capacity }}") || 0;
    const unitPrice = parseFloat("{{ $product->price }}") || 0;
    const currency = "{{ $product->currency_code }}";
    const cartonsIn1Cbm = cbm1Capacity || (cartonVolume > 0 ? Math.floor(1 / cartonVolume) : 1);
    const productImageUrl = "{{ $firstImage ? asset('storage/' . $firstImage->image_path) : asset('dist/img/boxed-bg.jpg') }}";

    // Tafgeet Arabic Logic
    function tafgeet(number) {
        if (isNaN(number) || number === "") return "";
        let val = Math.floor(number);
        if (val === 0) return "صفر";
        
        const ones = ["", "واحد", "اثنان", "ثلاثة", "أربعة", "خمسة", "ستة", "سبعة", "ثمانية", "تسعة", "عشرة", "أحد عشر", "اثنا عشر", "ثلاثة عشر", "أربعة عشر", "خمسة عشر", "ستة عشر", "سبعة عشر", "ثمانية عشر", "تسعة عشر"];
        const tens = ["", "", "عشرون", "ثلاثون", "أربعون", "خمسون", "ستون", "سبعون", "ثمانون", "تسعون"];
        const hundreds = ["", "مائة", "مائتان", "ثلاثمائة", "أربعمائة", "خمسمائة", "ستمائة", "سبعمائة", "ثمانمائة", "تسعمائة"];

        function convertThreeDigits(n) {
            let res = "";
            let h = Math.floor(n / 100);
            let rem = n % 100;
            if (h > 0) res += hundreds[h];
            if (rem > 0) {
                if (res !== "") res += " و ";
                if (rem < 20) res += ones[rem];
                else {
                    let t = Math.floor(rem / 10);
                    let o = rem % 10;
                    if (o > 0) res += ones[o] + " و ";
                    res += tens[t];
                }
            }
            return res;
        }

        let result = "";
        let million = Math.floor(val / 1000000);
        let thousand = Math.floor((val % 1000000) / 1000);
        let remainder = val % 100; // Not used for this scale but for completeness
        let hundredRemainder = val % 1000;

        if (million > 0) {
            if (million === 1) result += "مليون";
            else if (million === 2) result += "مليونان";
            else result += convertThreeDigits(million) + " ملايين";
        }

        if (thousand > 0) {
            if (result !== "") result += " و ";
            if (thousand === 1) result += "ألف";
            else if (thousand === 2) result += "ألفان";
            else if (thousand >= 3 && thousand <= 10) result += convertThreeDigits(thousand) + " آلاف";
            else result += convertThreeDigits(thousand) + " ألفاً";
        }

        if (hundredRemainder > 0) {
            if (result !== "") result += " و ";
            result += convertThreeDigits(hundredRemainder);
        }

        return result + " " + (currency === 'USD' ? 'دولار' : currency) + " فقط لا غير";
    }

    function updateOrderCalculations(source) {
        let qty = parseFloat($('#order_quantity').val()) || 0;
        let cartons = parseFloat($('#order_cartons').val()) || 0;
        let cbmVal = parseFloat($('#order_cbm_input').val()) || 0;

        if (source === 'qty') {
            cartons = Math.ceil(qty / piecesPerCarton);
            $('#order_cartons').val(cartons);
            cbmVal = cartons * cartonVolume;
            $('#order_cbm_input').val(cbmVal.toFixed(3));
        } else if (source === 'cartons') {
            qty = cartons * piecesPerCarton;
            $('#order_quantity').val(qty);
            cbmVal = cartons * cartonVolume;
            $('#order_cbm_input').val(cbmVal.toFixed(3));
        } else if (source === 'cbm') {
            cartons = Math.ceil(cbmVal / (cartonVolume || 1));
            $('#order_cartons').val(cartons);
            qty = cartons * piecesPerCarton;
            $('#order_quantity').val(qty);
        }

        const totalWeightKg = qty * pieceWeight;
        const totalCbm = cartons * cartonVolume;
        const totalCost = qty * unitPrice;

        // CBM Status Logic
        const statusBox = $('#cbm_status_box');
        if (totalCbm > 0) {
            statusBox.show();
            // Calculation based on cbm1Capacity (cartons per 1 CBM)
            const cbmTarget = cbm1Capacity || (cartonVolume > 0 ? Math.floor(1 / cartonVolume) : 1);
            
            if (cartons === cbmTarget) {
                statusBox.css({'background': '#dff0d8', 'color': '#3c763d', 'border-color': '#d6e9c6'})
                         .html('<i class="fa fa-check-circle"></i> مبروك! طلبك يعادل 1 CBM بالكامل.');
            } else if (cartons > cbmTarget) {
                const extra = cartons - cbmTarget;
                statusBox.css({'background': '#f2dede', 'color': '#a94442', 'border-color': '#ebccd1'})
                         .html('<i class="fa fa-exclamation-triangle"></i> تنبيه: تجاوزت 1 CBM بمقدار ' + extra + ' كرتونة زافدة.');
            } else {
                const remaining = cbmTarget - cartons;
                statusBox.css({'background': '#d9edf7', 'color': '#31708f', 'border-color': '#bce8f1'})
                         .html('<i class="fa fa-info-circle"></i> متبقي ' + remaining + ' كرتونة لإكمال 1 CBM.');
            }
        } else {
            statusBox.hide();
        }

        const weightStr = totalWeightKg > 1000 ? (totalWeightKg / 1000).toLocaleString(undefined, {maximumFractionDigits: 2}) + ' Ton' : totalWeightKg.toLocaleString() + ' KG';

        $('#res_total_pieces').text(qty.toLocaleString());
        $('#res_total_cartons').text(cartons.toLocaleString());
        $('#res_total_weight').text(weightStr);
        $('#res_total_cbm').text(totalCbm.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 3}));
        $('#total_cost_calc').text(totalCost.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2}) + ' ' + currency);

        // Update New Top Fields
        $('#order_weight_display').val(totalWeightKg.toLocaleString(undefined, {maximumFractionDigits: 2}) + ' KG');
        $('#order_price_display').val(totalCost.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2}) + ' ' + currency);
    }

    $('#order_quantity').on('input', function() {
        updateOrderCalculations('qty');
    });

    $('#order_cartons').on('input', function() {
        updateOrderCalculations('cartons');
    });

    $('#order_cbm_input').on('input', function() {
        updateOrderCalculations('cbm');
    });

    // Sync Container Visuals with Select
    function syncContainerVisuals(val) {
        $('.container-option-item').css({
            'border-color': '#eee',
            'background': '#f9f9f9',
            'transform': 'scale(1)',
            'box-shadow': 'none'
        });
        const active = $(`.container-option-item[data-value="${val}"]`);
        active.css({
            'border-color': '#3c8dbc',
            'background': '#f0f7ff',
            'transform': 'scale(1.05)',
            'box-shadow': '0 4px 10px rgba(60, 141, 188, 0.2)'
        });
        updateContainerCapacitySummary(val);
    }

    // Container Capacity Calculator
    function updateContainerCapacitySummary(type) {
        const capacities = {
            'CBM': 1,
            '20ft': 28,
            '40ft': 58,
            '40hq': 68,
            '45ft': 78
        };
        const multiplier = capacities[type] || 1;
        const panel = $('#container-capacity-summary');
        
        if (panel.length === 0) return;
        panel.show();

        // Use the baseline (cartons in 1 CBM) multiplied by the container capacity
        const totalCbm = multiplier;
        const totalCartons = Math.floor(cartonsIn1Cbm * totalCbm);
        const totalPieces = totalCartons * piecesPerCarton;
        const totalWeightKg = totalPieces * pieceWeight;
        const totalCost = totalPieces * unitPrice;

        const weightStr = totalWeightKg > 1000 ? (totalWeightKg / 1000).toFixed(2) + ' Ton' : Math.floor(totalWeightKg) + ' KG';

        $('#cap_total_cbm').text(totalCbm);
        $('#cap_total_weight').text(weightStr);
        $('#cap_total_cartons').text(totalCartons.toLocaleString());
        $('#cap_total_pieces').text(totalPieces.toLocaleString());
        $('#cap_total_price').text(totalCost.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2}) + ' ' + currency);
        $('#cap_total_price_words').text(tafgeet(totalCost)).attr('title', tafgeet(totalCost));
    }

    // Modal View Toggler
    $('#btnToggleSpecialView').on('click', function() {
        const standardView = $('#standardOrderView');
        const specialView = $('#specialContainersView');
        const btn = $(this);
        const footer = $('.modal-footer');

        if (standardView.is(':visible')) {
            standardView.hide();
            specialView.fadeIn();
            btn.html('<i class="fa fa-arrow-right"></i> العودة للطلب');
            footer.hide(); // Hide footer in catalog mode
            
            // Auto-load first container details
            loadSpecialContainerDetails(0);
        } else {
            specialView.hide();
            standardView.fadeIn();
            btn.html('<i class="fa fa-th-large"></i> حاويات خاصة');
            footer.show();
        }
    });

    // Special Container Data and Logic
    const specialContainersData = [
        @foreach($allSpecialContainers as $item)
        {
            name: "{{ $item['name'] }}",
            code: "{{ $item['code'] }}",
            unit: "{{ $item['unit'] }}",
            capacity: "{{ $item['capacity'] }}",
            load: "{{ $item['load'] }}",
            usage: "{{ $item['usage'] }}",
            icon: "{{ $item['icon'] }}",
            color: "{{ $item['color'] }}",
            numeric_cbm: {{ $item['numeric_cbm'] }}
        },
        @endforeach
    ];

    function loadSpecialContainerDetails(index) {
        const data = specialContainersData[index];
        if (!data) return;

        // Perform Logistical Calculations based on product metrics
        const containerCbm = data.numeric_cbm;
        const totalCartons = Math.floor(cartonsIn1Cbm * containerCbm);
        const totalPieces = totalCartons * piecesPerCarton;
        const totalWeightKg = totalPieces * pieceWeight;
        const totalCost = totalPieces * unitPrice;

        const weightStr = totalWeightKg > 1000 ? (totalWeightKg / 1000).toFixed(2) + ' Ton' : Math.floor(totalWeightKg) + ' KG';

        // SYNC: Update main form fields (Standard View) with these calculated values
        $('#order_quantity').val(totalPieces);
        $('#order_cartons').val(totalCartons);
        $('#order_cbm_input').val(containerCbm.toFixed(3));
        
        // Trigger main calculations to update standard view UI summaries
        updateOrderCalculations('qty');

        // Highlight active item
        $('.special-nav-item').removeClass('active').css({
            'border-color': '#eee',
            'background': '#fff',
            'transform': 'scale(1)'
        });
        const activeItem = $(`.special-nav-item[data-index="${index}"]`);
        activeItem.addClass('active').css({
            'border-color': data.color,
            'background': '#fdfdfd',
            'transform': 'scale(1.05)'
        });

        // Inject content into viewer
        const content = `
            <div style="flex: 1; min-width: 300px; text-align: center; background: #fcfcfc; padding: 30px; border-radius: 20px;">
                <div style="font-size: 120px; color: ${data.color}; margin-bottom: 25px; filter: drop-shadow(0 15px 30px rgba(0,0,0,0.1));">
                    <i class="fa ${data.icon}"></i>
                </div>
                <h3 class="english-nums" style="margin-top: 15px; font-weight: 900; color: #1e3a5f;">${data.name}</h3>
                <span class="english-nums" style="background: ${data.color}; color: white; padding: 5px 15px; border-radius: 20px; font-size: 13px; font-weight: bold;">${data.code}</span>
            </div>
            <div style="flex: 1.5; min-width: 350px;">
                <!-- NEW: Product Logistical Summary Section -->
                <h4 style="font-weight: 800; color: ${data.color}; margin-bottom: 20px;"><i class="fa fa-calculator"></i> نتائج شحن المنتج في هذه الحاوية</h4>
                <div style="background: #fff; border: 1px solid #eee; border-radius: 15px; padding: 25px; margin-bottom: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
                    <div style="display: flex; gap: 25px; direction: rtl; align-items: flex-start;">
                        <!-- Product Image thumbnail -->
                        <div style="width: 120px; flex-shrink: 0; border: 1px solid #eee; border-radius: 12px; overflow: hidden; background: #fafafa; padding: 5px; box-shadow: 0 5px 15px rgba(0,0,0,0.05);">
                            <img src="${productImageUrl}" style="width: 100%; height: auto; border-radius: 8px; object-fit: contain;">
                            <div style="text-align: center; font-size: 10px; color: #888; margin-top: 5px; font-weight: bold;">المنتج المستهدف</div>
                        </div>

                        <!-- Fields Grid -->
                        <div style="flex: 1; display: flex; gap: 15px; flex-wrap: wrap;">
                            <!-- Container Capacity Field -->
                            <div style="flex: 1; min-width: 140px;">
                                <label style="display: block; font-size: 12px; color: ${data.color}; font-weight: 800; margin-bottom: 8px;">سعة الحاوية (CBM)</label>
                                <input type="text" class="english-nums form-control text-center" value="${containerCbm}" readonly style="height: 55px; background: #f8f9fa; border: 2px solid #eee; border-radius: 10px; font-size: 20px; font-weight: 900; color: ${data.color}; cursor: default;">
                            </div>
                            <!-- Total Cartons Field -->
                            <div style="flex: 1; min-width: 140px;">
                                <label style="display: block; font-size: 12px; color: #555; font-weight: 800; margin-bottom: 8px;">إجمالي الكراتين (Cartons)</label>
                                <input type="text" class="english-nums form-control text-center" value="${totalCartons.toLocaleString()}" readonly style="height: 55px; background: #f8f9fa; border: 2px solid #eee; border-radius: 10px; font-size: 20px; font-weight: 900; color: #333; cursor: default;">
                            </div>
                            <!-- Total Pieces Field -->
                            <div style="flex: 1; min-width: 140px;">
                                <label style="display: block; font-size: 12px; color: #555; font-weight: 800; margin-bottom: 8px;">إجمالي عدد القطع</label>
                                <input type="text" class="english-nums form-control text-center" value="${totalPieces.toLocaleString()}" readonly style="height: 55px; background: #f8f9fa; border: 2px solid #eee; border-radius: 10px; font-size: 20px; font-weight: 900; color: #333; cursor: default;">
                            </div>
                            <!-- Total Weight Field -->
                            <div style="flex: 1; min-width: 140px;">
                                <label style="display: block; font-size: 12px; color: #d9534f; font-weight: 800; margin-bottom: 8px;">إجمالي الوزن</label>
                                <input type="text" class="english-nums form-control text-center" value="${weightStr}" readonly style="height: 55px; background: #f8f9fa; border: 2px solid #eee; border-radius: 10px; font-size: 20px; font-weight: 900; color: #d9534f; cursor: default;">
                            </div>
                        </div>
                    </div>

                    <!-- Total Price Card -->
                    <div style="margin-top: 25px; background: ${data.color}; border-radius: 15px; padding: 30px; color: white; text-align: center; position: relative; overflow: hidden; box-shadow: 0 8px 25px rgba(0,0,0,0.15);">
                        <div style="position: absolute; right: -15px; bottom: -15px; font-size: 100px; opacity: 0.1; transform: rotate(-15deg);"><i class="fa fa-money"></i></div>
                        <div style="font-size: 14px; opacity: 0.9; margin-bottom: 8px;">إجمالي تكلفة المشتريات المتوقعة لهذه الحاوية:</div>
                        <div class="english-nums" style="font-size: 40px; font-weight: 900; margin-bottom: 10px;">${totalCost.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2})} ${currency}</div>
                        <div style="font-size: 16px; font-weight: bold; background: rgba(255,255,255,0.25); padding: 8px 30px; border-radius: 50px; display: inline-block; border: 1px solid rgba(255,255,255,0.3); backdrop-filter: blur(5px);">
                            <i class="fa fa-info-circle"></i> ${tafgeet(totalCost)}
                        </div>
                    </div>
                </div>

                <h4 style="font-weight: 800; color: #333; margin-bottom: 20px; border-bottom: 2px solid ${data.color}; padding-bottom: 10px;">المواصفات الفنية للحاوية</h4>
                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-bottom: 30px;">
                    <div style="background: #fff; padding: 15px; border-radius: 12px; border: 1px solid #eee;">
                        <small style="color: #999; display: block; margin-bottom: 5px;">وحدة القياس</small>
                        <strong style="font-size: 16px; color: #444;">${data.unit}</strong>
                    </div>
                    <div style="background: #fff; padding: 15px; border-radius: 12px; border: 1px solid #eee;">
                        <small style="color: #999; display: block; margin-bottom: 5px;">السعة الحجمية</small>
                        <strong style="font-size: 16px; color: #444;" class="english-nums">${data.capacity}</strong>
                    </div>
                </div>
                <div style="background: #1e3a5f; color: white; padding: 25px; border-radius: 15px; box-shadow: 0 10px 20px rgba(30,58,95,0.2);">
                    <h5 style="margin: 0 0 10px; font-weight: bold; opacity: 0.8;"><i class="fa fa-info-circle"></i> توجيهات الاستخدام:</h5>
                    <p style="margin: 0; font-size: 15px; line-height: 1.6;">${data.usage}</p>
                </div>
            </div>
        `;
        
        $('#special-detail-content').hide().html(content).fadeIn(400);
    }

    $(document).on('click', '.special-nav-item', function() {
        const index = $(this).data('index');
        loadSpecialContainerDetails(index);
    });

    $('.container-option-item').on('click', function() {
        const val = $(this).data('value');
        $('#shipping_unit_type').val(val).trigger('change');
    });

    $('#shipping_unit_type').on('change', function() {
        const val = $(this).val();
        syncContainerVisuals(val);
        
        // NEW: Sync real input fields with container capacity using multiplication logic
        const capacities = { 'CBM': 1, '20ft': 28, '40ft': 58, '40hq': 68, '45ft': 78 };
        if (capacities[val] !== undefined) {
            const containerCbm = capacities[val];
            const totalCartons = Math.floor(cartonsIn1Cbm * containerCbm);
            const totalPieces = totalCartons * piecesPerCarton;
            
            $('#order_quantity').val(totalPieces);
            $('#order_cartons').val(totalCartons);
            $('#order_cbm_input').val(containerCbm.toFixed(3));
        }

        updateOrderCalculations('qty');
    });

    // Initialize on load
    $('#shipping_unit_type').trigger('change');

    $('#orderForm').on('submit', function(e) {
        e.preventDefault();
        const btn = $('#btnSubmitOrder');
        const minQty = parseInt("{{ $product->min_order_quantity }}");
        const currentQty = parseInt($('#order_quantity').val());

        if (currentQty < minQty) {
            Swal.fire({
                icon: 'warning',
                title: 'خطأ في الكمية',
                text: 'الكمية يجب أن لا تقل عن ' + minQty
            });
            return;
        }

        const cartons = parseInt($('#order_cartons').val());
        const totalCbm = (cartons * cartonVolume);
        const totalWeight = (currentQty * pieceWeight);

        const cartItem = {
            id: "{{ $product->id }}",
            name: "{{ $product->name }}",
            sku: "{{ $product->sku ?: '-' }}",
            image: "{{ $product->images->isNotEmpty() ? url('storage/'.$product->images->first()->image_path) : asset('dist/img/default-image.png') }}",
            images: [
                @foreach($product->images as $img)
                    "{{ url('storage/'.$img->image_path) }}",
                @endforeach
            ],
            qty: currentQty,
            cartons: cartons,
            unit_price: unitPrice,
            unit_weight: pieceWeight,
            unit_cbm: cartonVolume,
            piece_count: piecesPerCarton,
            total_cbm: totalCbm,
            total_weight: totalWeight,
            currency: currency,
            shipping_unit_type: $('#shipping_unit_type').val() || 'CBM',
            url: window.location.href
        };

        if (typeof CBMCart !== 'undefined') {
            CBMCart.add(cartItem);
            $('#orderModal').modal('hide');
            Swal.fire({
                icon: 'success',
                title: 'تمت الإضافة للسلة!',
                text: 'تمت إضافة المنتج بنجاح إلى قائمة الـ CBM في الأعلى.',
                confirmButtonText: 'حسناً',
                timer: 2000,
                showConfirmButton: false
            });
        } else {
            console.error('CBMCart is not defined. Make sure it is included in the header layouts.');
        }
    });
});
</script>
<style>
.thumb-gallery:hover {
    border-color: #3c8dbc !important;
    padding: 2px;
}
.thumb-gallery.active {
    box-shadow: 0 0 10px rgba(60, 141, 188, 0.3);
}

.container-option-item:hover {
    border-color: #3c8dbc !important;
    background: #fff !important;
}

.english-nums {
    font-family: 'Inter', sans-serif !important;
    font-variant-numeric: tabular-nums;
}

/* Zoom Effect CSS */
.zoom-container {
    overflow: hidden;
}
.zoom-container img {
    pointer-events: none;
}
</style>
@endpush
@endsection
