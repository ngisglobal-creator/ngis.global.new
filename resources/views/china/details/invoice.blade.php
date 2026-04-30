@extends('china.layouts.master')

@section('title', 'تفاصيل الفاتورة | لوحة الصين')

@section('content')
<section class="content-header">
    <h1>تفاصيل الفاتورة <small>رقم #<span style="font-family: Arial; font-weight: bold; color: #000;">{{ $order->id }}</span></small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('china/dashboard') }}"><i class="fa fa-dashboard"></i> الرئيسية</a></li>
        <li><a href="{{ route('china.invoices') }}">الفواتير الموجهة</a></li>
        <li class="active">تفاصيل الفاتورة</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <!-- معلومات المنتج -->
        <div class="col-md-4">
            <div class="box box-primary">
                <div class="box-body box-profile">
                    @if($order->product->images->first())
                        <img class="profile-user-img img-responsive img-bordered" src="{{ asset('storage/' . $order->product->images->first()->image_path) }}" alt="Product picture" style="width: 150px; height: 150px; object-fit: cover;">
                    @endif
                    <h3 class="profile-username text-center">{{ $order->product->name }}</h3>
                    <p class="text-muted text-center">{{ $order->product->sector->name_ar ?? '---' }}</p>

                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                            <b>السعر الأصلي</b> <a class="pull-left"><span style="font-family: Arial; font-weight: bold; font-size: 18px; color: #000;">{{ number_format($order->product->price, 2) }}</span> ر.س</a>
                        </li>
                        <li class="list-group-item">
                            <b>الكمية المطلوبة</b> <a class="pull-left"><span style="font-family: Arial; font-weight: bold; font-size: 18px; color: #000;">{{ number_format($order->product->quantity ?? 1) }}</span></a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- المرفقات -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">المرفقات والوثائق</h3>
                </div>
                <div class="box-body">
                    <strong><i class="fa fa-file-pdf-o margin-r-5"></i> الفاتورة المصاحبة</strong>
                    <p class="text-muted">
                        @if($order->invoice_file)
                            <a href="{{ asset('storage/' . $order->invoice_file) }}" target="_blank" class="btn btn-default btn-xs"><i class="fa fa-download"></i> تحميل الفاتورة</a>
                        @else
                            <span class="text-danger">لا يوجد ملف فاتورة</span>
                        @endif
                    </p>
                    <hr>
                    <strong><i class="fa fa-file-text-o margin-r-5"></i> عقد التوريد</strong>
                    <p class="text-muted">
                        @if($order->contract_file)
                            <a href="{{ asset('storage/' . $order->contract_file) }}" target="_blank" class="btn btn-default btn-xs"><i class="fa fa-download"></i> تحميل العقد</a>
                        @else
                            <span class="text-danger">لا يوجد ملف عقد</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <!-- معلومات العميل والمكتب -->
        <div class="col-md-8">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs pull-right">
                    <li class="active"><a href="#financials" data-toggle="tab">البيانات المالية</a></li>
                    <li><a href="#parties" data-toggle="tab">الأطراف المعنية</a></li>
                    <li><a href="#history" data-toggle="tab">سجل الدفعات</a></li>
                </ul>
                <div class="tab-content">
                    <div class="active tab-pane" id="financials">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="small-box bg-green">
                                    <div class="inner">
                                        <h3 style="font-family: Arial; font-weight: bold;">{{ number_format($order->paid_amount, 2) }}</h3>
                                        <p>المبلغ المدفوع (ر.س)</p>
                                    </div>
                                    <div class="icon"><i class="fa fa-money"></i></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="small-box bg-yellow">
                                    <div class="inner">
                                        <h3 style="font-family: Arial; font-weight: bold;">{{ number_format($order->product->price - $order->paid_amount, 2) }}</h3>
                                        <p>المبلغ المتبقي (ر.س)</p>
                                    </div>
                                    <div class="icon"><i class="fa fa-calculator"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="box no-border">
                            <div class="box-body">
                                <strong><i class="fa fa-info-circle margin-r-5"></i> حالة الدفع الحالية</strong>
                                <p>
                                    @if($order->payment_status == 'paid') <span class="label label-success" style="font-size: 14px;">مدفوع بالكامل</span>
                                    @elseif($order->payment_status == 'partial') <span class="label label-warning" style="font-size: 14px;">دفع جزئي</span>
                                    @else <span class="label label-danger" style="font-size: 14px;">غير مدفوع</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane" id="parties">
                        <div class="row">
                            <div class="col-sm-6">
                                <h4>بيانات العميل</h4>
                                <div class="well">
                                    <p><b>الاسم:</b> {{ $order->user->name }}</p>
                                    <p><b>البريد:</b> {{ $order->user->email }}</p>
                                    <p><b>الدولة:</b> {{ $order->user->country->name_ar ?? '---' }}</p>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <h4>المكتب الإقليمي المسئول</h4>
                                <div class="well">
                                    <p><b>اسم المكتب:</b> {{ $order->product->user->name }}</p>
                                    <p><b>البريد:</b> {{ $order->product->user->email }}</p>
                                    <p><b>معرف المكتب:</b> <span style="font-family: Arial; font-weight: bold;">{{ $order->product->user->id }}</span></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane" id="history">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>المبلغ</th>
                                    <th>التاريخ</th>
                                    <th>ملاحظات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($order->payments as $payment)
                                <tr>
                                    <td style="font-family: Arial; font-weight: bold;">{{ $loop->iteration }}</td>
                                    <td><strong style="font-family: Arial; font-size: 16px; color: #000;">{{ number_format($payment->amount, 2) }}</strong></td>
                                    <td style="font-family: Arial; font-weight: bold; color: #000;">{{ $payment->created_at->format('Y-m-d H:i') }}</td>
                                    <td>{{ $payment->notes ?? '---' }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">لا يوجد سجل دفعات</td>
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
