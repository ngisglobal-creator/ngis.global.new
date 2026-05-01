@extends('regional.layouts.master')

@section('title', 'عقد البيع والدفع')

@section('content')
<section class="content-header">
    <h1>عقد البيع والدفع <small>{{ $order->user->name }}</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('regional/dashboard') }}"><i class="fa fa-dashboard"></i> الرئيسية</a></li>
        <li><a href="{{ route('regional.clients.index') }}">العملاء</a></li>
        <li class="active">عقد البيع والدفع</li>
    </ol>
</section>

<section class="content">
    <div class="row">

        {{-- Order Summary --}}
        <div class="col-md-4">
            <div class="box box-primary" style="border-radius:10px;overflow:hidden;">
                <div class="box-header with-border bg-primary">
                    <h3 class="box-title" style="color:#fff;"><i class="fa fa-info-circle"></i> تفاصيل الطلب</h3>
                </div>
                <div class="box-body">
                    @if($order->product->images->first())
                        <img src="{{ asset('storage/' . $order->product->images->first()->image_path) }}" class="img-responsive" style="border-radius:8px;margin-bottom:15px;max-height:180px;width:100%;object-fit:cover;">
                    @endif
                    <table class="table table-condensed" style="margin-bottom:0;">
                        <tr><th>المنتج</th><td><strong style="color:#3c8dbc;">{{ $order->product->name }}</strong></td></tr>
                        <tr><th>المصنع/الشركة</th><td>{{ $order->product->user->name }}</td></tr>
                        <tr><th>العميل</th><td>{{ $order->user->name }}</td></tr>
                        <tr><th>الدولة</th><td>{{ $order->user->country->name_ar ?? '-' }}</td></tr>
                        <tr><th>تاريخ الطلب</th><td>{{ $order->created_at->format('Y-m-d') }}</td></tr>
                        <tr>
                            <th>السعر الإجمالي</th>
                            <td><strong style="font-size:20px;color:#000;font-family:Arial;direction:ltr;">{{ number_format($order->product->price, 2) }} ر.س</strong></td>
                        </tr>
                        <tr>
                            <th>المدفوع حتى الآن</th>
                            <td><strong style="font-size:18px;color:#27ae60;font-family:Arial;direction:ltr;">{{ number_format($order->paid_amount, 2) }} ر.س</strong></td>
                        </tr>
                        <tr>
                            <th>المتبقي</th>
                            <td><strong style="font-size:18px;color:#e74c3c;font-family:Arial;direction:ltr;">{{ number_format(max(0, $order->product->price - $order->paid_amount), 2) }} ر.س</strong></td>
                        </tr>
                    </table>
                </div>
            </div>

            {{-- Payment History --}}
            @if($order->payments->count() > 0)
            <div class="box box-solid" style="border-radius:10px;overflow:hidden;">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-history"></i> سجل الدفعات</h3>
                </div>
                <div class="box-body no-padding">
                    <table class="table table-condensed" style="margin:0;">
                        <thead><tr><th>المبلغ</th><th>الحالة</th><th>التاريخ</th></tr></thead>
                        <tbody>
                        @foreach($order->payments as $p)
                        <tr>
                            <td style="font-family:Arial;direction:ltr;font-weight:bold;color:#27ae60;">{{ number_format($p->amount, 2) }} ر.س</td>
                            <td>
                                @if($p->status == 'paid') <span class="label label-success">مكتمل</span>
                                @elseif($p->status == 'partial') <span class="label label-warning">جزئي</span>
                                @else <span class="label label-danger">غير مدفوع</span>
                                @endif
                            </td>
                            <td><small>{{ $p->payment_date }}</small></td>
                        </tr>
                        @if($p->notes)
                        <tr><td colspan="3" class="text-muted" style="font-size:12px;padding-top:0;">{{ $p->notes }}</td></tr>
                        @endif
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        </div>

        {{-- Upload + Payment Form --}}
        <div class="col-md-8">
            <div class="box box-success" style="border-radius:10px;overflow:hidden;">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-upload"></i> رفع الملفات وتسجيل الدفع</h3>
                </div>
                <div class="box-body">
                    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
                    @if($errors->any())
                        <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
                    @endif

                    <form action="{{ route('regional.clients.contract.store', $order) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><i class="fa fa-file-pdf-o text-danger"></i> عقد البيع (PDF أو صورة)</label>
                                    <input type="file" name="contract_file" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                                    @if($order->contract_file)
                                        <p class="help-block text-success"><i class="fa fa-check"></i> <a href="{{ asset('storage/' . $order->contract_file) }}" target="_blank">عرض الملف الحالي</a></p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><i class="fa fa-file-text-o text-warning"></i> الفاتورة (PDF أو صورة)</label>
                                    <input type="file" name="invoice_file" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                                    @if($order->invoice_file)
                                        <p class="help-block text-success"><i class="fa fa-check"></i> <a href="{{ asset('storage/' . $order->invoice_file) }}" target="_blank">عرض الملف الحالي</a></p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <hr>
                        <h4 style="font-weight:bold;"><i class="fa fa-money"></i> تسجيل دفعة جديدة</h4>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>قيمة الدفعة (ر.س)</label>
                                    <input type="number" name="paid_amount" class="form-control" placeholder="0.00" step="0.01" min="0">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>حالة الدفع</label>
                                    <select name="payment_status" class="form-control">
                                        <option value="unpaid" {{ $order->payment_status == 'unpaid' ? 'selected' : '' }}>غير مدفوع</option>
                                        <option value="partial" {{ $order->payment_status == 'partial' ? 'selected' : '' }}>دفع جزئي</option>
                                        <option value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>مدفوع بالكامل</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>تاريخ الدفع</label>
                                    <input type="date" name="payment_date" class="form-control" value="{{ date('Y-m-d') }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>ملاحظات (اختياري)</label>
                            <textarea name="notes" class="form-control" rows="2" placeholder="ملاحظات حول هذه الدفعة..."></textarea>
                        </div>

                        <div style="margin-top:20px;display:flex;gap:10px;">
                            <button type="submit" class="btn btn-success btn-lg"><i class="fa fa-save"></i> حفظ</button>
                            <a href="{{ route('regional.clients.index') }}" class="btn btn-default btn-lg"><i class="fa fa-arrow-right"></i> رجوع</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</section>
@endsection
