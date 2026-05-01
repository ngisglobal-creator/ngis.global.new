@extends('layouts.master')

@section('title', 'تفاصيل المالية | ' . $order->product->name)

@section('content')
<section class="content-header">
    <h1>تفاصيل المالية <small style="color: #000; font-family: Arial; font-weight: bold; font-size: 16px;">الطلب رقم #{{ $order->id }}</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> الرئيسية</a></li>
        <li><a href="{{ route('admin.invoices.index') }}">الفواتير</a></li>
        <li class="active">تفاصيل المالية</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <!-- Main Info -->
        <div class="col-md-4">
            <!-- Order Summary -->
            <div class="box box-primary">
                <div class="box-body box-profile">
                    @if($order->product->images->first())
                        <img class="profile-user-img img-responsive img-bordered" src="{{ asset('storage/' . $order->product->images->first()->image_path) }}" alt="Product Image" style="width: 150px; height: 150px; object-fit: cover;">
                    @endif
                    <h3 class="profile-username text-center">{{ $order->product->name }}</h3>
                    <p class="text-muted text-center">{{ $order->product->sector->name_ar }}</p>

                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                            <b>السعر الكلي</b> <a class="pull-left"><strong style="color: #000; font-family: Arial; font-size: 20px;">{{ number_format($order->product->price, 2) }} ر.س</strong></a>
                        </li>
                        <li class="list-group-item">
                            <b>إجمالي المدفوع</b> <a class="pull-left"><strong style="color: #000; font-family: Arial; font-size: 20px;">{{ number_format($order->paid_amount, 2) }} ر.س</strong></a>
                        </li>
                        <li class="list-group-item">
                            @php $remaining = max(0, $order->product->price - $order->paid_amount); @endphp
                            <b>المتبقي</b> <a class="pull-left"><strong style="color: #000; font-family: Arial; font-size: 20px;">{{ number_format($remaining, 2) }} ر.س</strong></a>
                        </li>
                        <li class="list-group-item">
                            <b>حالة الدفع</b> 
                            <span class="pull-left">
                                @if($order->payment_status == 'paid') <span class="label label-success">مدفوع بالكامل</span>
                                @elseif($order->payment_status == 'partial') <span class="label label-warning">دفع جزئي</span>
                                @else <span class="label label-danger">غير مدفوع</span>
                                @endif
                            </span>
                        </li>
                    </ul>

                    <div style="display: flex; gap: 5px; margin-top: 15px;">
                        <a href="{{ route('admin.invoices.edit', $order) }}" class="btn btn-warning btn-block" style="margin-top: 0;"><b>تعديل البيانات</b></a>
                        <form action="{{ route('admin.clients.orders.destroy', $order) }}" method="POST" style="flex: 1;" onsubmit="return confirm('هل أنت متأكد من حذف هذا الطلب؟');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-block"><b>حذف</b></button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Documents -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">المستندات المرفقة</h3>
                </div>
                <div class="box-body">
                    <strong><i class="fa fa-file-text-o margin-r-5"></i> الفاتورة</strong>
                    <p>
                        @if($order->invoice_file)
                            <a href="{{ asset('storage/'.$order->invoice_file) }}" target="_blank" class="btn btn-xs btn-default"><i class="fa fa-download"></i> عرض ملف الفاتورة</a>
                        @else
                            <span class="text-muted">لا يوجد ملف فاتورة</span>
                        @endif
                    </p>
                    <hr>
                    <strong><i class="fa fa-file-signature margin-r-5"></i> العقد</strong>
                    <p>
                        @if($order->contract_file)
                            <a href="{{ asset('storage/'.$order->contract_file) }}" target="_blank" class="btn btn-xs btn-default"><i class="fa fa-download"></i> عرض ملف العقد</a>
                        @else
                            <span class="text-muted">لا يوجد ملف عقد</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <!-- Payment History -->
        <div class="col-md-8">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-history"></i> سجل الدفعات</h3>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr style="background: #f4f4f4;">
                                    <th>#</th>
                                    <th>قيمة الدفعة</th>
                                    <th>تاريخ الدفعة</th>
                                    <th>الحالة بعد الدفعة</th>
                                    <th>ملاحظات</th>
                                    <th>تاريخ التسجيل</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($order->payments as $index => $payment)
                                <tr>
                                    <td style="font-family: Arial; font-weight: bold; color: #000;">{{ $index + 1 }}</td>
                                    <td><strong style="color: #000; font-family: Arial; font-size: 18px;">{{ number_format($payment->amount, 2) }} ر.س</strong></td>
                                    <td style="font-family: Arial; font-weight: bold; color: #000;">{{ $payment->payment_date }}</td>
                                    <td>
                                        @if($payment->status == 'paid') <span class="label label-success">مدفوع</span>
                                        @elseif($payment->status == 'partial') <span class="label label-warning">جزئي</span>
                                        @else <span class="label label-danger">غير مدفوع</span>
                                        @endif
                                    </td>
                                    <td>{{ $payment->notes ?? '---' }}</td>
                                    <td><small class="text-muted">{{ $payment->created_at->format('Y-m-d H:i') }}</small></td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted" style="padding: 20px;">لا يوجد سجل دفعات لهذا الطلب حتى الآن.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Client & Seller Quick Info -->
            <div class="row">
                <div class="col-sm-6">
                    <div class="box box-widget widget-user-2">
                        <div class="widget-user-header bg-aqua-active">
                            <div class="widget-user-image">
                                <img class="img-circle" src="{{ $order->user->avatar_url }}" alt="Client Avatar">
                            </div>
                            <h3 class="widget-user-username">{{ $order->user->name }}</h3>
                            <h5 class="widget-user-desc">العميل</h5>
                        </div>
                        <div class="box-footer no-padding">
                            <ul class="nav nav-stacked">
                                <li><a>البريد <span class="pull-left">{{ $order->user->email }}</span></a></li>
                                <li><a>الدولة <span class="pull-left">{{ $order->user->country->name_ar ?? '---' }}</span></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="box box-widget widget-user-2">
                        <div class="widget-user-header bg-yellow-active">
                            <div class="widget-user-image">
                                <img class="img-circle" src="{{ $order->product->user->avatar_url }}" alt="Seller Avatar">
                            </div>
                            <h3 class="widget-user-username">{{ $order->product->user->name }}</h3>
                            <h5 class="widget-user-desc">البائع ({{ $order->product->user->type == 'company' ? 'شركة' : 'مصنع' }})</h5>
                        </div>
                        <div class="box-footer no-padding">
                            <ul class="nav nav-stacked">
                                <li><a>البريد <span class="pull-left">{{ $order->product->user->email }}</span></a></li>
                                <li><a>تاريخ التسجيل <span class="pull-left">{{ $order->product->user->created_at->format('Y-m-d') }}</span></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
