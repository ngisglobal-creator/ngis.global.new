@extends('china.layouts.master')

@section('title', 'تفاصيل العميل | لوحة الصين')

@section('content')
<section class="content-header">
    <h1>تفاصيل العميل <small>{{ $user->name }}</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('china/dashboard') }}"><i class="fa fa-dashboard"></i> الرئيسية</a></li>
        <li><a href="{{ route('china.customers') }}">العملاء</a></li>
        <li class="active">تفاصيل العميل</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-4">
            <div class="box box-info">
                <div class="box-body box-profile">
                    <img class="profile-user-img img-responsive img-circle" src="{{ $user->avatar_url }}" alt="Customer profile picture">
                    <h3 class="profile-username text-center">{{ $user->name }}</h3>
                    <p class="text-muted text-center">{{ $user->country->name_ar ?? '---' }}</p>

                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                            <b>الطلبات الموجهة للصين</b> <a class="pull-left"><span style="font-family: Arial; font-weight: bold; font-size: 18px; color: #000;">{{ $orders->count() }}</span></a>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">بيانات التواصل</h3>
                </div>
                <div class="box-body">
                    <strong><i class="fa fa-envelope margin-r-5"></i> البريد الإلكتروني</strong>
                    <p class="text-muted">{{ $user->email }}</p>
                    <hr>
                    <strong><i class="fa fa-map-marker margin-r-5"></i> الدولة</strong>
                    <p class="text-muted">{{ $user->country->name_ar ?? '---' }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">تاريخ الطلبات الموجهة لهذا العميل</h3>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr style="background: #f4f4f4;">
                                    <th># ID الطلب</th>
                                    <th>صورة المنتج</th>
                                    <th>اسم المنتج</th>
                                    <th>المكتب الإقليمي</th>
                                    <th>سعر الطلب</th>
                                    <th>حالة الدفع</th>
                                    <th>العمليات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
                                <tr>
                                    <td style="font-family: Arial; font-weight: bold; color: #000;">{{ $order->id }}</td>
                                    <td>
                                        @if($order->product->images->first())
                                            <img src="{{ asset('storage/' . $order->product->images->first()->image_path) }}" width="40" height="40" style="object-fit: cover; border-radius: 4px;">
                                        @endif
                                    </td>
                                    <td>{{ $order->product->name }}</td>
                                    <td>{{ $order->product->user->name }}</td>
                                    <td><strong style="font-family: Arial; font-size: 16px; color: #000;">{{ number_format($order->product->price, 2) }}</strong></td>
                                    <td>
                                        @if($order->payment_status == 'paid') <span class="label label-success">مدفوع</span>
                                        @else <span class="label label-warning">جزئي</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('china.invoices.show', $order) }}" class="btn btn-default btn-xs btn-flat">التفاصيل</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">لا يوجد طلبات موجهة لهذا العميل</td>
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
