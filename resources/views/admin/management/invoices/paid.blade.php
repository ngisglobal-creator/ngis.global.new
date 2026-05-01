@extends('layouts.master')

@section('title', 'الفواتير المدفوعة')

@section('content')
<section class="content-header">
    <h1>الفواتير المدفوعة <small>عرض جميع العمليات المكتملة الدفع</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> الرئيسية</a></li>
        <li class="active">الفواتير المدفوعة</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-success" style="border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                <div class="box-header">
                    <h3 class="box-title">سجل الفواتير المدفوعة بالكامل</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr style="background: #f4f4f4;">
                                    <th>#</th>
                                    <th>الصورة</th>
                                    <th>المنتج</th>
                                    <th>العميل</th>
                                    <th>المكتب الإقليمي</th>
                                    <th>السعر الكلي</th>
                                    <th>المبلغ المدفوع</th>
                                    <th>حالة الدفع</th>
                                    <th>إدارة الصين</th>
                                    <th>العمليات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
                                <tr>
                                    <td style="font-family: Arial; font-weight: bold;">{{ $order->id }}</td>
                                    <td>
                                        @if($order->product->images->first())
                                            <img src="{{ asset('storage/' . $order->product->images->first()->image_path) }}" width="50" height="50" style="object-fit: cover; border-radius: 4px;">
                                        @endif
                                    </td>
                                    <td>{{ $order->product->name }}</td>
                                    <td>{{ $order->user->name }}</td>
                                    <td>{{ $order->product->user->name }}</td>
                                    <td><strong style="font-family: Arial; font-size: 16px; color: #000;">{{ number_format($order->product->price, 2) }}</strong></td>
                                    <td><strong style="font-family: Arial; font-size: 16px; color: #27ae60;">{{ number_format($order->paid_amount, 2) }}</strong></td>
                                    <td><span class="label label-success">مدفوع بالكامل</span></td>
                                    <td>
                                        @if($order->forward_to_china)
                                            <span class="badge bg-green"><i class="fa fa-check"></i> تم التوجيه</span>
                                        @else
                                            <form action="{{ route('admin.invoices.forward', $order) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-primary btn-xs btn-flat"><i class="fa fa-paper-plane"></i> توجيه لمكتب الصين</button>
                                            </form>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.invoices.show', $order) }}" class="btn btn-info btn-xs"><i class="fa fa-eye"></i> تفاصيل</a>
                                        <a href="{{ route('admin.invoices.edit', $order) }}" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i> تعديل</a>
                                        <form action="{{ route('admin.clients.orders.destroy', $order) }}" method="POST" style="display:inline;" onsubmit="return confirm('هل أنت متأكد من حذف هذا الطلب؟');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> حذف</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="10" class="text-center">لا توجد فواتير مدفوعة حالياً</td>
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
