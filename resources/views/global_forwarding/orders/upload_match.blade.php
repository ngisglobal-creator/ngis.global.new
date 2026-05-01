@extends('layouts.master')

@section('title', 'رفع المنتج - ' . $order->title)

@section('content')
<section class="content-header">
    <h1 style="font-weight: 900; color: #1a202c;">
        رفع المنتج <small>Product Upload System</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('global_forwarding.dashboard') }}"><i class="fa fa-dashboard"></i> الرئيسية</a></li>
        <li><a href="{{ route('global_forwarding.orders.custom') }}">الطلبات الخاصة</a></li>
        <li class="active">رفع المنتج</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <!-- قسم تفاصيل الطلب الأصلي (في الأعلى) -->
        <div class="col-md-12">
            <div class="box box-solid" style="border-radius: 15px; border-right: 5px solid #00c0ef; background: #f0f9ff;">
                <div class="box-header with-border">
                    <h3 class="box-title" style="font-weight: 800; color: #0369a1;">
                        <i class="fa fa-info-circle"></i> تفاصيل طلب العميل الأصلي
                    </h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-2 text-center">
                            @if($order->images && count($order->images) > 0)
                                <img src="{{ Storage::url($order->images[0]) }}" style="width: 120px; height: 120px; object-fit: cover; border-radius: 10px; border: 2px solid #fff; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                            @endif
                        </div>
                        <div class="col-md-4">
                            <h4 style="font-weight: 700; color: #1e40af;">{{ $order->title }}</h4>
                            <p style="color: #475569;">{{ $order->description }}</p>
                        </div>
                        <div class="col-md-3">
                            <ul class="list-unstyled" style="font-size: 14px; color: #334155;">
                                <li><strong><i class="fa fa-cube"></i> الكمية:</strong> {{ $order->quantity }} {{ $order->unit }}</li>
                                <li><strong><i class="fa fa-money"></i> السعر المستهدف:</strong> {{ number_format($order->target_price, 2) }} USD</li>
                                <li><strong><i class="fa fa-globe"></i> المنشأ المفضل:</strong> {{ ucfirst($order->origin) }}</li>
                            </ul>
                        </div>
                        <div class="col-md-3">
                            <div class="label label-info" style="font-size: 14px; display: block; margin-bottom: 5px; text-align: right;">العميل: {{ $order->user->name ?? 'N/A' }}</div>
                            <div class="label label-default" style="font-size: 14px; display: block; text-align: right;">التصنيف: {{ ucfirst($order->category_type) }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- قسم رفع المنتج (في الأسفل) -->
        <div class="col-md-12" style="margin-top: 20px;">
            <div class="box box-primary" style="border-radius: 15px; box-shadow: 0 10px 15px rgba(0,0,0,0.05);">
                <div class="box-header with-border">
                    <h3 class="box-title" style="font-weight: 700;">رفع بيانات المنتج المعتمد</h3>
                </div>
                <div class="box-body" style="padding: 40px; text-align: center;">
                    <h4 style="margin-bottom: 30px; font-weight: 800; color: #475569;">اختر نوع المنتج المراد رفعه للمطابقة:</h4>
                    
                    <div class="row">
                        <!-- المنتج العادي (كرتونة) -->
                        <div class="col-md-3">
                            <a href="{{ route('global_forwarding.orders.custom.upload.carton', $order->id) }}" class="upload-mode-card">
                                <div class="upload-icon-circle" style="background: #e0f2fe; color: #0369a1;">
                                    <i class="fa fa-cubes"></i>
                                </div>
                                <h4 style="font-weight: 700;">منتج (بالكرتونة)</h4>
                                <p class="text-muted small">للمنتجات التي تُباع بالوحدة داخل كراتين شحن</p>
                            </a>
                        </div>

                        <!-- منتج خاص -->
                        <div class="col-md-3">
                            <a href="{{ route('global_forwarding.orders.custom.upload.special', $order->id) }}" class="upload-mode-card">
                                <div class="upload-icon-circle" style="background: #f0fdf4; color: #15803d;">
                                    <i class="fa fa-star"></i>
                                </div>
                                <h4 style="font-weight: 700;">منتج (رفع خاص)</h4>
                                <p class="text-muted small">للمعدات والمنتجات ذات الأبعاد والأوزان الخاصة</p>
                            </a>
                        </div>

                        <!-- سيارة خفيفة -->
                        <div class="col-md-3">
                            <a href="{{ route('global_forwarding.orders.custom.upload.car_light', $order->id) }}" class="upload-mode-card">
                                <div class="upload-icon-circle" style="background: #fff7ed; color: #c2410c;">
                                    <i class="fa fa-car"></i>
                                </div>
                                <h4 style="font-weight: 700;">سيارة (خفيفة)</h4>
                                <p class="text-muted small">سيارات الركوب، الدفع الرباعي، والمركبات الصغيرة</p>
                            </a>
                        </div>

                        <!-- سيارة ثقيلة -->
                        <div class="col-md-3">
                            <a href="{{ route('global_forwarding.orders.custom.upload.car_heavy', $order->id) }}" class="upload-mode-card">
                                <div class="upload-icon-circle" style="background: #fdf2f8; color: #be185d;">
                                    <i class="fa fa-truck"></i>
                                </div>
                                <h4 style="font-weight: 700;">سيارة/معدات (ثقيلة)</h4>
                                <p class="text-muted small">الشاحنات، الحافلات، والمعدات الإنشائية الثقيلة</p>
                            </a>
                        </div>
                    </div>

                    <style>
                        .upload-mode-card {
                            display: block;
                            padding: 25px 15px;
                            border: 2px solid #f1f5f9;
                            border-radius: 20px;
                            transition: all 0.3s ease;
                            text-decoration: none !important;
                            color: #334155;
                            height: 100%;
                        }
                        .upload-mode-card:hover {
                            border-color: #3c8dbc;
                            background: #fff;
                            transform: translateY(-5px);
                            box-shadow: 0 10px 25px rgba(60, 141, 188, 0.1);
                        }
                        .upload-icon-circle {
                            width: 70px;
                            height: 70px;
                            line-height: 70px;
                            border-radius: 50%;
                            font-size: 30px;
                            margin: 0 auto 15px;
                            transition: all 0.3s ease;
                        }
                        .upload-mode-card:hover .upload-icon-circle {
                            transform: scale(1.1);
                        }
                    </style>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
