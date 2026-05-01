@extends('china.layouts.master')

@section('title', 'الفواتير الموجهة | لوحة الصين')

@section('content')
<section class="content-header">
    <h1>الفواتير الموجهة <small>الفواتير المرسلة من المدير العام</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('china/dashboard') }}"><i class="fa fa-dashboard"></i> الرئيسية</a></li>
        <li class="active">الفواتير الموجهة</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary" style="border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                <div class="box-header">
                    <h3 class="box-title">سجل الفواتير المستلمة</h3>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr style="background: #f4f4f4;">
                                    <th># ID</th>
                                    <th>صورة المنتج</th>
                                    <th>اسم المنتج</th>
                                    <th>القطاع</th>
                                    <th>العميل</th>
                                    <th>المكتب الإقليمي</th>
                                    <th>السعر (ر.س)</th>
                                    <th>حالة الدفع</th>
                                    <th>التاريخ</th>
                                    <th>العمليات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
                                <tr>
                                    <td style="font-family: Arial; font-weight: bold; font-size: 16px; color: #000;">{{ $order->id }}</td>
                                    <td>
                                        @if($order->product->images->first())
                                            <img src="{{ asset('storage/' . $order->product->images->first()->image_path) }}" width="60" height="60" style="object-fit: cover; border-radius: 8px;">
                                        @endif
                                    </td>
                                    <td style="font-weight: bold;">{{ $order->product->name }}</td>
                                    <td><span class="label label-default">{{ $order->product->sector->name_ar ?? '---' }}</span></td>
                                    <td>{{ $order->user->name }}</td>
                                    <td>{{ $order->product->user->name }}</td>
                                    <td>
                                        <strong style="font-family: Arial; font-size: 18px; color: #000;">{{ number_format($order->product->price, 2) }}</strong>
                                    </td>
                                    <td>
                                        @if($order->payment_status == 'paid') <span class="label label-success">مدفوع</span>
                                        @elseif($order->payment_status == 'partial') <span class="label label-warning">جزئي</span>
                                        @else <span class="label label-danger">غير مدفوع</span>
                                        @endif
                                    </td>
                                    <td style="font-family: Arial; font-weight: bold; color: #000;">{{ $order->created_at->format('Y-m-d') }}</td>
                                    <td>
                                        <a href="{{ route('china.invoices.show', $order) }}" class="btn btn-info btn-sm btn-flat"><i class="fa fa-eye"></i> تفاصيل الفاتورة</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="10" class="text-center text-muted">لا توجد فواتير موجهة حالياً</td>
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
