@extends('layouts.master')

@section('title', 'إدارة الطلبات الخاصة - Global Forwarding')

@section('content')
    <!-- Import modern font for numbers -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet">

    <section class="content-header">
        <h1 style="font-weight: 900; color: #1a202c;">
            إدارة الطلبات الخاصة <small>Global Custom Sourcing Management</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('global_forwarding.dashboard') }}"><i class="fa fa-dashboard"></i> الرئيسية</a></li>
            <li class="active">الطلبات الخاصة</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary"
                    style="border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); border-top: 5px solid #3c8dbc;">
                    <div class="box-header with-border" style="padding: 15px 20px;">
                        <h3 class="box-title" style="font-weight: 700;">قائمة طلبات التوريد الميداني (نظام المتابعة
                            المركزية)</h3>
                    </div>
                    <div class="box-body table-responsive">
                        <table class="table table-bordered table-striped" style="vertical-align: middle;">
                            <thead>
                                <tr class="bg-navy">
                                    <th style="width: 80px;">الصورة</th>
                                    <th>صاحب الطلب</th>
                                    <th>معلومات المنتج</th>
                                    <th>التصنيف والمنشأ</th>
                                    <th style="min-width: 250px;">التفاصيل اللوجستية</th>
                                    <th>الحالة التشغيلية</th>
                                    <th style="width: 150px;">العمليات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
                                    <tr>
                                        <td class="text-center">
                                            @if($order->images && count($order->images) > 0)
                                                <img src="{{ Storage::url($order->images[0]) }}"
                                                    style="width: 70px; height: 70px; object-fit: cover; border-radius: 8px; border: 1px solid #eee;">
                                            @else
                                                <div
                                                    style="width: 70px; height: 70px; background: #f4f4f4; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #ccc;">
                                                    <i class="fa fa-image fa-2x"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            <strong style="color: #3c8dbc;">{{ $order->user->name ?? 'N/A' }}</strong><br>
                                            <span class="label label-default">{{ $order->user->type ?? '' }}</span>
                                        </td>
                                        <td>
                                            <strong style="font-size: 16px; color: #2c3e50;">{{ $order->title }}</strong><br>
                                            <small class="text-muted"><i class="fa fa-calendar"></i>
                                                {{ $order->created_at->format('Y-m-d') }}</small>
                                        </td>
                                        <td>
                                            <span class="label label-primary"
                                                style="display: inline-block; margin-bottom: 5px;">{{ ucfirst($order->category_type) }}</span><br>
                                            <span class="text-muted"><i class="fa fa-globe"></i> المنشأ:
                                                {{ ucfirst($order->origin) }}</span>
                                        </td>
                                        <td>
                                            <div
                                                style="background: #fff; border: 1px solid #e2e8f0; border-radius: 10px; padding: 10px; display: flex; justify-content: space-between;">
                                                <div class="text-center" style="flex: 1; border-left: 1px solid #f0f0f0;">
                                                    <div style="font-size: 10px; color: #718096; font-weight: bold;">الكمية
                                                    </div>
                                                    <div style="font-weight: 800; color: #3182ce;" class="english-nums">
                                                        {{ $order->quantity }}</div>
                                                    <div style="font-size: 9px; color: #a0aec0;">{{ $order->unit }}</div>
                                                </div>
                                                <div class="text-center" style="flex: 1;">
                                                    <div style="font-size: 10px; color: #718096; font-weight: bold;">السعر
                                                        المستهدف</div>
                                                    <div style="font-weight: 800; color: #38a169;" class="english-nums">
                                                        {{ number_format($order->target_price, 2) }}</div>
                                                    <div style="font-size: 9px; color: #a0aec0;">USD</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="label label-{{ $order->status_color }}"
                                                style="font-size: 12px; padding: 5px 10px;">
                                                {{ $order->status_label }}
                                            </span>
                                            @if($order->admin_notes)
                                                <div style="margin-top: 5px; font-size: 11px; color: #e67e22;">
                                                    <i class="fa fa-commenting"></i> تم إضافة ملاحظات
                                                </div>
                                            @endif
                                        </td>
                                <td>
                                    <div class="btn-group" style="display: flex; gap: 5px;">
                                        <a href="{{ route('global_forwarding.orders.custom.show', $order->id) }}" class="btn btn-action-white" title="عرض التفاصيل الكاملة">
                                            عرض
                                        </a>
                                        <button type="button" class="btn btn-action-white" data-toggle="modal" data-target="#editModal{{ $order->id }}" title="تعديل الحالة">
                                            تعديل
                                        </button>
                                        <form action="{{ route('global_forwarding.orders.custom.delete', $order->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('هل أنت متأكد من حذف هذا الطلب؟')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-action-white" title="حذف">
                                                حذف
                                            </button>
                                        </form>
                                    </div>

                                            <!-- Quick Status Update Modal -->
                                            <div class="modal fade" id="editModal{{ $order->id }}">
                                                <div class="modal-dialog">
                                                    <form
                                                        action="{{ route('global_forwarding.orders.custom.update', $order->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <div class="modal-content" style="border-radius: 12px;">
                                                            <div class="modal-header bg-navy">
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    style="color:white; opacity:1;">&times;</button>
                                                                <h4 class="modal-title">تحديث حالة الطلب #{{ $order->id }}</h4>
                                                            </div>
                                                            <div class="modal-body" style="padding: 20px;">
                                                                <div class="form-group">
                                                                    <label>تغيير الحالة التشغيلية</label>
                                                                    <select name="status" class="form-control">
                                                                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>قيد المراجعة</option>
                                                                        <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>
                                                                            جاري البحث الميداني</option>
                                                                        <option value="matched" {{ $order->status == 'matched' ? 'selected' : '' }}>تمت المطابقة</option>
                                                                        <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>تم الشحن</option>
                                                                        <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>مكتمل</option>
                                                                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>ملغي</option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>ملاحظات الإدارة (تظهر للعميل)</label>
                                                                    <textarea name="admin_notes" class="form-control" rows="4"
                                                                        placeholder="اكتب تحديثاتك للعميل هنا...">{{ $order->admin_notes }}</textarea>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="submit" class="btn btn-primary">تحديث
                                                                    الحالة</button>
                                                                <button type="button" class="btn btn-default"
                                                                    data-dismiss="modal">إلغاء</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- Admin Stepper Row -->
                                    <tr>
                                        <td colspan="7"
                                            style="background: #fcfcfc; padding: 25px 50px; border-bottom: 3px solid #3c8dbc;">
                                            @include('partials.special_order_stepper', ['order' => $order])
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-5">لا توجد طلبات خاصة حالياً</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .english-nums {
            font-family: 'Inter', sans-serif !important;
        }

        .table>tbody>tr>td {
            vertical-align: middle !important;
        }

        .btn-action-white {
            background: #ffffff !important;
            color: #000000 !important;
            border: 2px solid #000000 !important;
            border-radius: 8px !important;
            padding: 6px 12px !important;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1) !important;
            transition: all 0.2s !important;
        }

        .btn-action-white i, 
        .btn-action-white i::before, 
        .btn-action-white i::after {
            color: #000000 !important;
        }

        .btn-action-white:hover {
            background: #000000 !important;
            color: #ffffff !important;
            transform: translateY(-2px) !important;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2) !important;
        }
        .btn-action-white:hover i, 
        .btn-action-white:hover i::before {
            color: #ffffff !important;
        }
    </style>
@endsection