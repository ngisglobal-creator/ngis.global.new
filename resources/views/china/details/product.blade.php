@extends('china.layouts.master')

@section('title', 'تفاصيل حالة المنتج | لوحة الصين')

@section('content')
<section class="content-header">
    <h1>تفاصيل حالة المنتج <small>{{ $order->product->name }}</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('china/dashboard') }}"><i class="fa fa-dashboard"></i> الرئيسية</a></li>
        <li><a href="{{ route('china.product_status') }}">حالات المنتجات</a></li>
        <li class="active">تفاصيل المنتج</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-success" style="border-top: 3px solid #00a65a;">
                <div class="box-header with-border">
                    <h3 class="box-title">معلومات فنية وتوريدية شاملة للكود #<span style="font-family: Arial; font-weight: bold;">{{ $order->product->id }}</span></h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-4 text-center">
                            @if($order->product->images->first())
                                <img src="{{ asset('storage/' . $order->product->images->first()->image_path) }}" class="img-thumbnail" style="max-height: 250px; width: 100%; object-fit: contain;">
                            @endif
                        </div>
                        <div class="col-sm-8">
                            <h2 style="margin-top: 0; color: #00a65a;">{{ $order->product->name }}</h2>
                            <p class="lead">{{ $order->product->description }}</p>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <ul class="list-unstyled">
                                        <li><strong><i class="fa fa-tag"></i> القطاع:</strong> {{ $order->product->sector->name_ar ?? '---' }}</li>
                                        <li><strong><i class="fa fa-cube"></i> الكمية المتاحة:</strong> <span style="font-family: Arial; font-weight: bold; font-size: 18px; color: #000;">{{ number_format($order->product->quantity) }}</span></li>
                                        <li><strong><i class="fa fa-bank"></i> السعر التوريدي:</strong> <span style="font-family: Arial; font-weight: bold; font-size: 22px; color: #000;">{{ number_format($order->product->price, 2) }}</span> ر.س</li>
                                    </ul>
                                </div>
                                <div class="col-md-6" style="border-right: 1px solid #eee;">
                                    <ul class="list-unstyled">
                                        <li><strong><i class="fa fa-user"></i> المورد (المكتب):</strong> {{ $order->product->user->name }}</li>
                                        <li><strong><i class="fa fa-envelope"></i> تواصل المورد:</strong> {{ $order->product->user->email }}</li>
                                        <li><strong><i class="fa fa-clock-o"></i> تاريخ عرض المنتج:</strong> <span style="font-family: Arial;">{{ $order->product->created_at->format('Y-m-d') }}</span></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <div class="text-left">
                        <a href="{{ route('china.invoices.show', $order) }}" class="btn btn-primary"><i class="fa fa-file-text-o"></i> عرض الفاتورة الكاملة لهذا المنتج</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
