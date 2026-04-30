@extends('china.layouts.master')

@section('title', 'حالات المنتجات | لوحة الصين')

@section('content')
<section class="content-header">
    <h1>حالات المنتجات <small>تتبع المنتجات الموجهة لمكتب الصين</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('china/dashboard') }}"><i class="fa fa-dashboard"></i> الرئيسية</a></li>
        <li class="active">حالات المنتجات</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-success" style="border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                <div class="box-header">
                    <h3 class="box-title">تتبع حالة المنتج والتوريد</h3>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr style="background: #f4f4f4;">
                                    <th># ID المنتج</th>
                                    <th>الصورة</th>
                                    <th>اسم المنتج</th>
                                    <th>المورد (المكتب الإقليمي)</th>
                                    <th>السعر الأصلي</th>
                                    <th>القطاع</th>
                                    <th>العمليات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
                                <tr>
                                    <td style="font-family: Arial; font-weight: bold; font-size: 16px; color: #000;">{{ $order->product->id }}</td>
                                    <td>
                                        @if($order->product->images->first())
                                            <img src="{{ asset('storage/' . $order->product->images->first()->image_path) }}" width="60" height="60" style="object-fit: cover; border-radius: 8px;">
                                        @endif
                                    </td>
                                    <td style="font-weight: bold;">{{ $order->product->name }}</td>
                                    <td>{{ $order->product->user->name }}</td>
                                    <td>
                                        <strong style="font-family: Arial; font-size: 18px; color: #000;">{{ number_format($order->product->price, 2) }} ر.س</strong>
                                    </td>
                                    <td>{{ $order->product->sector->name_ar ?? '---' }}</td>
                                    <td>
                                        <a href="{{ route('china.product_status.show', $order) }}" class="btn btn-success btn-xs btn-flat"><i class="fa fa-eye"></i> تفاصيل حالة المنتج</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">لا توجد منتجات موجهة حالياً</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
