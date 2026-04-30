@extends('china.layouts.master')

@section('title', 'تفاصيل المكتب الإقليمي | لوحة الصين')

@section('content')
<section class="content-header">
    <h1>تفاصيل المكتب الإقليمي <small>{{ $user->name }}</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('china/dashboard') }}"><i class="fa fa-dashboard"></i> الرئيسية</a></li>
        <li><a href="{{ route('china.regional_offices') }}">مكاتب الأقاليم</a></li>
        <li class="active">تفاصيل المكتب</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-3">
            <div class="box box-warning">
                <div class="box-body box-profile">
                    <img class="profile-user-img img-responsive img-circle" src="{{ $user->avatar_url }}" alt="Office profile picture">
                    <h3 class="profile-username text-center">{{ $user->name }}</h3>
                    <p class="text-muted text-center">{{ $user->country->name_ar ?? '---' }}</p>

                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                            <b>إجمالي الطلبات الموجهة</b> <a class="pull-left"><span style="font-family: Arial; font-weight: bold; font-size: 18px; color: #000;">{{ $orders->count() }}</span></a>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">معلومات الاتصال</h3>
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

        <div class="col-md-9">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">سجل الطلبات الموجهة من هذا المكتب</h3>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr style="background: #f4f4f4;">
                                    <th># ID الطلب</th>
                                    <th>المنتج</th>
                                    <th>العميل</th>
                                    <th>إجمالي السعر</th>
                                    <th>المبلغ المحصل</th>
                                    <th>تاريخ التوجيه</th>
                                    <th>العمليات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
                                <tr>
                                    <td style="font-family: Arial; font-weight: bold; color: #000;">{{ $order->id }}</td>
                                    <td>{{ $order->product->name }}</td>
                                    <td>{{ $order->user->name }}</td>
                                    <td><strong style="font-family: Arial; font-size: 16px; color: #000;">{{ number_format($order->product->price, 2) }}</strong></td>
                                    <td><strong style="font-family: Arial; font-size: 16px; color: #27ae60;">{{ number_format($order->paid_amount, 2) }}</strong></td>
                                    <td style="font-family: Arial;">{{ $order->updated_at->format('Y-m-d') }}</td>
                                    <td>
                                        <a href="{{ route('china.invoices.show', $order) }}" class="btn btn-info btn-xs btn-flat">عرض الفاتورة</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">لا توجد طلبات موجهة لهذا المكتب</td>
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
