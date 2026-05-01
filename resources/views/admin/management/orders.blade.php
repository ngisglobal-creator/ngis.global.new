@extends('layouts.master')

@section('title', 'طلبات العملاء')

@section('content')
<section class="content-header">
    <h1>إدارة الطلبات <small>عرض طلبات العملاء من الشركات والمصانع</small></h1>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">طلبات الشراء والخدمات</h3>
                </div>
                <div class="box-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h4><i class="icon fa fa-check"></i> تم!</h4>
                            {{ session('success') }}
                        </div>
                    @endif
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>العميل (صاحب الطلب)</th>
                                <th>المنتج</th>
                                <th>صاحب المنتج (البائع)</th>
                                <th>تاريخ الطلب</th>
                                <th>الحالة</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                            <tr>
                                <td>
                                    <div style="display: flex; align-items: center;">
                                        <img src="{{ $order->user->avatar_url }}" class="img-circle" style="width: 35px; height: 35px; border: 1px solid #ddd;">
                                        <div style="margin-right: 8px;">
                                            <strong style="display: block; font-size: 13px;">{{ $order->user->name }}</strong>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <strong style="color: #3c8dbc;">{{ $order->product->name }}</strong><br>
                                    <small class="text-muted">{{ number_format($order->product->price, 2) }} ر.س</small>
                                </td>
                                <td>
                                    <strong>{{ $order->product->user->name }}</strong><br>
                                    <span class="label label-default" style="font-size: 10px;">{{ $order->product->user->type == 'company' ? 'شركة' : 'مصنع' }}</span>
                                </td>
                                <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                                <td>
                                    @if($order->status == 'pending')
                                        <span class="label label-warning">قيد الانتظار</span>
                                    @elseif($order->status == 'accepted')
                                        <span class="label label-success">تم القبول</span>
                                    @else
                                        <span class="label label-danger">تم الرفض</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.clients.orders.show', $order) }}" class="btn btn-primary btn-xs" title="عرض">
                                        <i class="fa fa-eye"></i> عرض
                                    </a>
                                    @if($order->status == 'accepted' && !$order->assigned_to_regional)
                                    <a href="{{ route('admin.clients.orders.send-to-regional', $order) }}" class="btn btn-success btn-xs" title="إرسال للمكتب الإقليمي">
                                        <i class="fa fa-paper-plane"></i> إرسال للإقليمي
                                    </a>
                                    @endif
                                    @if($order->assigned_to_regional)
                                        <span class="label label-info" style="margin-left: 5px;"><i class="fa fa-check"></i> تم الإرسال</span>
                                    @endif
                                    <form action="{{ route('admin.clients.orders.destroy', $order) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('هل أنت متأكد من حذف هذا الطلب؟');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-xs" title="حذف">
                                            <i class="fa fa-trash"></i> حذف
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
