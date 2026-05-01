@extends('layouts.master')

@section('title', 'حالات دفع الفواتير الإقليمية')

@section('content')
<section class="content-header">
    <h1>حالات دفع الفواتير <small>متابعة مدفوعات جميع عملاء المكاتب الإقليمية</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> الرئيسية</a></li>
        <li class="active">حالات الدفع الإقليمية</li>
    </ol>
</section>

<section class="content">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">×</button>
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        <div class="col-md-12">
            <div class="box box-warning" style="border-radius:10px;overflow:hidden;box-shadow:0 4px 10px rgba(0,0,0,0.08);">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-credit-card"></i> جدول حالات الدفع</h3>
                </div>
                <div class="box-body no-padding">
                    <table class="table table-hover">
                        <thead>
                            <tr style="background:#fdfdfd;">
                                <th>العميل</th>
                                <th>المنتج وصورته</th>
                                <th>الدولة</th>
                                <th>السعر الكلي</th>
                                <th>إجمالي المدفوع</th>
                                <th>المتبقي</th>
                                <th style="text-align:center;">العقد / الفاتورة</th>
                                <th>حالة الدفع</th>
                                <th>عدد الدفعات</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($orders as $order)
                            @php
                                $price = $order->product->price;
                                $paid = $order->paid_amount;
                                $remaining = max(0, $price - $paid);
                            @endphp
                            <tr>
                                <td>
                                    <div style="display:flex;align-items:center;">
                                        <img src="{{ $order->user->avatar_url }}" class="img-circle" style="width:32px;height:32px;border:1px solid #ddd;margin-left:8px;">
                                        <div>
                                            <strong>{{ $order->user->name }}</strong><br>
                                            <small class="text-muted">{{ $order->user->email }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div style="display:flex;align-items:center;">
                                        @if($order->product->images->first())
                                            <img src="{{ asset('storage/'.$order->product->images->first()->image_path) }}" style="width:40px;height:30px;border-radius:4px;object-fit:cover;margin-left:8px;">
                                        @endif
                                        <strong style="color:#3c8dbc;font-size:13px;">{{ $order->product->name }}</strong>
                                    </div>
                                </td>
                                <td>
                                    @if($order->user->country)
                                        <img src="{{ asset('vendor/flag-icons/flags/4x3/'.strtolower($order->user->country->flag_code ?? '').'.svg') }}" style="width:16px;height:12px;margin-left:4px;">
                                        {{ $order->user->country->name_ar }}
                                    @else - @endif
                                </td>
                                <td><strong style="font-family:Arial;font-size:15px;">{{ number_format($price,2) }} ر.س</strong></td>
                                <td><strong style="font-family:Arial;font-size:15px;color:#27ae60;">{{ number_format($paid,2) }} ر.س</strong></td>
                                <td><strong style="font-family:Arial;font-size:15px;color:{{ $remaining > 0 ? '#e74c3c' : '#27ae60' }};">{{ number_format($remaining,2) }} ر.س</strong></td>
                                <td style="text-align:center;">
                                    <div style="display:flex;justify-content:center;gap:5px;">
                                        @if($order->contract_file)
                                            @php $e1 = strtolower(pathinfo($order->contract_file, PATHINFO_EXTENSION)); @endphp
                                            <a href="{{ asset('storage/'.$order->contract_file) }}" target="_blank" title="عقد">
                                                @if(in_array($e1,['jpg','jpeg','png']))<img src="{{ asset('storage/'.$order->contract_file) }}" style="width:36px;height:36px;object-fit:cover;border-radius:4px;border:1px solid #ddd;">@else<i class="fa fa-file-pdf-o fa-lg text-danger"></i>@endif
                                            </a>
                                        @endif
                                        @if($order->invoice_file)
                                            @php $e2 = strtolower(pathinfo($order->invoice_file, PATHINFO_EXTENSION)); @endphp
                                            <a href="{{ asset('storage/'.$order->invoice_file) }}" target="_blank" title="فاتورة">
                                                @if(in_array($e2,['jpg','jpeg','png']))<img src="{{ asset('storage/'.$order->invoice_file) }}" style="width:36px;height:36px;object-fit:cover;border-radius:4px;border:1px solid #ddd;">@else<i class="fa fa-file-text-o fa-lg text-warning"></i>@endif
                                            </a>
                                        @endif
                                        @if(!$order->contract_file && !$order->invoice_file)<span class="text-muted">—</span>@endif
                                    </div>
                                </td>
                                <td>
                                    @if($order->payment_status == 'paid') <span class="label label-success" style="font-size:12px;">مدفوع بالكامل</span>
                                    @elseif($order->payment_status == 'partial') <span class="label label-warning" style="font-size:12px;">دفع جزئي</span>
                                    @else <span class="label label-danger" style="font-size:12px;">غير مدفوع</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-blue" style="font-size:13px;">{{ $order->payments->count() }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.invoices.show', $order) }}" class="btn btn-info btn-sm">
                                        <i class="fa fa-eye"></i> التفاصيل
                                    </a>
                                    <a href="{{ route('admin.invoices.edit', $order) }}" class="btn btn-warning btn-sm">
                                        <i class="fa fa-edit"></i> تعديل
                                    </a>
                                    <form action="{{ route('admin.clients.orders.destroy', $order) }}" method="POST" style="display:inline;" onsubmit="return confirm('هل أنت متأكد من حذف هذا الطلب؟');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> حذف</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="10" class="text-center" style="padding:40px;">
                                <i class="fa fa-credit-card fa-3x text-muted" style="opacity:0.3;"></i>
                                <p class="text-muted" style="margin-top:10px;">لا توجد طلبات موكلة حالياً</p>
                            </td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
