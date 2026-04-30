@extends('regional.layouts.master')

@section('title', 'إضافة / تعديل دفعة')

@section('content')
<section class="content-header">
    <h1>إضافة دفعة جديدة <small>{{ $order->user->name }}</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('regional/dashboard') }}"><i class="fa fa-dashboard"></i> الرئيسية</a></li>
        <li><a href="{{ route('regional.invoices.payment_status') }}">حالات الدفع</a></li>
        <li class="active">تعديل الدفع</li>
    </ol>
</section>

<section class="content">
    <div class="row">

        {{-- Payment History --}}
        <div class="col-md-5">
            {{-- Order Summary --}}
            <div class="box box-primary" style="border-radius:10px;overflow:hidden;">
                <div class="box-header with-border bg-primary">
                    <h3 class="box-title" style="color:#fff;"><i class="fa fa-info-circle"></i> ملخص الطلب</h3>
                </div>
                <div class="box-body">
                    <div style="display:flex;align-items:center;margin-bottom:12px;">
                        <img src="{{ $order->user->avatar_url }}" class="img-circle" style="width:50px;height:50px;border:2px solid #3c8dbc;margin-left:12px;">
                        <div>
                            <strong style="font-size:16px;">{{ $order->user->name }}</strong><br>
                            <small class="text-muted">{{ $order->user->country->name_ar ?? '' }}</small>
                        </div>
                    </div>
                    @if($order->product->images->first())
                        <img src="{{ asset('storage/'.$order->product->images->first()->image_path) }}" class="img-responsive" style="border-radius:8px;margin-bottom:12px;max-height:150px;width:100%;object-fit:cover;">
                    @endif
                    <table class="table table-condensed" style="margin:0;">
                        <tr><th>المنتج</th><td><strong style="color:#3c8dbc;">{{ $order->product->name }}</strong></td></tr>
                        <tr><th>المصنع</th><td>{{ $order->product->user->name }}</td></tr>
                        <tr><th>السعر الكلي</th><td><strong style="font-size:18px;font-family:Arial;">{{ number_format($order->product->price,2) }} ر.س</strong></td></tr>
                        <tr><th>إجمالي المدفوع</th><td><strong style="font-size:18px;color:#27ae60;font-family:Arial;">{{ number_format($order->paid_amount,2) }} ر.س</strong></td></tr>
                        <tr><th>المتبقي</th><td><strong style="font-size:18px;color:#e74c3c;font-family:Arial;">{{ number_format(max(0,$order->product->price - $order->paid_amount),2) }} ر.س</strong></td></tr>
                    </table>
                </div>
            </div>

            {{-- Full Payment History --}}
            <div class="box box-solid" style="border-radius:10px;overflow:hidden;">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-history"></i> سجل الدفعات السابقة</h3>
                </div>
                <div class="box-body no-padding">
                    @if($order->payments->count() > 0)
                    <table class="table table-condensed" style="margin:0;">
                        <thead><tr style="background:#f9f9f9;"><th>#</th><th>المبلغ</th><th>الحالة</th><th>التاريخ</th><th>ملاحظات</th></tr></thead>
                        <tbody>
                        @foreach($order->payments as $i => $p)
                        <tr>
                            <td><small class="text-muted">{{ $i + 1 }}</small></td>
                            <td><strong style="font-family:Arial;color:#27ae60;">{{ number_format($p->amount,2) }} ر.س</strong></td>
                            <td>
                                @if($p->status=='paid') <span class="label label-success">مكتمل</span>
                                @elseif($p->status=='partial') <span class="label label-warning">جزئي</span>
                                @else <span class="label label-danger">غير مدفوع</span>
                                @endif
                            </td>
                            <td><small>{{ $p->payment_date }}</small></td>
                            <td><small class="text-muted">{{ $p->notes ?? '—' }}</small></td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                    @else
                        <p class="text-center text-muted" style="padding:20px;">لا توجد دفعات مسجلة بعد</p>
                    @endif
                </div>
            </div>
        </div>

        {{-- New Payment Form --}}
        <div class="col-md-7">
            <div class="box box-success" style="border-radius:10px;overflow:hidden;">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-plus-circle"></i> تسجيل دفعة جديدة</h3>
                    <p class="box-subtitle text-muted" style="margin-top:4px;font-size:12px;">سيتم جمع المبلغ الجديد مع ما سبق دفعه تلقائياً</p>
                </div>
                <div class="box-body">
                    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
                    @if($errors->any())
                        <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
                    @endif

                    <form action="{{ route('regional.invoices.store_payment', $order) }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label style="font-size:15px;font-weight:bold;">قيمة الدفعة الجديدة (ر.س)</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-money"></i></span>
                                <input type="number" name="amount" class="form-control input-lg" placeholder="أدخل المبلغ" step="0.01" min="0" required>
                                <span class="input-group-addon">ر.س</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label style="font-size:15px;font-weight:bold;">حالة الدفع</label>
                            <select name="status" class="form-control input-lg">
                                <option value="partial">دفع جزئي</option>
                                <option value="paid">مدفوع بالكامل</option>
                                <option value="unpaid">غير مدفوع</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label style="font-size:15px;font-weight:bold;">تاريخ الدفع</label>
                            <input type="date" name="payment_date" class="form-control input-lg" value="{{ date('Y-m-d') }}" required>
                        </div>

                        <div class="form-group">
                            <label>ملاحظات (اختياري)</label>
                            <textarea name="notes" class="form-control" rows="3" placeholder="أي ملاحظات حول هذه الدفعة..."></textarea>
                        </div>

                        <div style="margin-top:20px;">
                            <div class="callout callout-info" style="margin-bottom:15px;">
                                <h4><i class="fa fa-info-circle"></i> تنبيه</h4>
                                <p>بعد الحفظ، سيصبح إجمالي المدفوع = <strong>{{ number_format($order->paid_amount,2) }}</strong> + المبلغ الجديد</p>
                            </div>
                            <button type="submit" class="btn btn-success btn-lg btn-block"><i class="fa fa-save"></i> حفظ الدفعة</button>
                            <a href="{{ route('regional.invoices.payment_status') }}" class="btn btn-default btn-lg btn-block" style="margin-top:10px;"><i class="fa fa-arrow-right"></i> رجوع</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</section>
@endsection
