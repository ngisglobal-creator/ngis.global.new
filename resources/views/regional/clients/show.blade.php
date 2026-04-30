@extends('regional.layouts.master')

@section('title', 'تفاصيل الطلب')

@section('content')
<section class="content-header">
    <h1>تفاصيل الطلب <small>{{ $order->user->name }}</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('regional/dashboard') }}"><i class="fa fa-dashboard"></i> الرئيسية</a></li>
        <li><a href="{{ route('regional.clients.index') }}">العملاء</a></li>
        <li class="active">تفاصيل الطلب</li>
    </ol>
</section>

<section class="content">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            {{ session('success') }}
        </div>
    @endif

    <div class="row">

        {{-- Client Info --}}
        <div class="col-md-4">
            <div class="box box-widget widget-user-2" style="border-radius: 10px; overflow:hidden;">
                <div class="widget-user-header bg-primary" style="border-radius: 0;">
                    <div class="widget-user-image">
                        <img class="img-circle" src="{{ $order->user->avatar_url }}" alt="User Avatar" style="width:65px;height:65px;object-fit:cover;">
                    </div>
                    <h3 class="widget-user-username" style="margin-right:80px;">{{ $order->user->name }}</h3>
                    <h5 class="widget-user-desc" style="margin-right:80px;">عميل — {{ $order->user->country->name_ar ?? '' }}</h5>
                </div>
                <div class="box-footer no-padding">
                    <ul class="nav nav-stacked">
                        <li><a><b>البريد الإلكتروني</b> <span class="pull-left text-muted">{{ $order->user->email }}</span></a></li>
                        <li><a><b>الهاتف</b> <span class="pull-left text-muted">{{ $order->user->phone ?? '-' }}</span></a></li>
                        <li><a><b>الدولة</b>
                            <span class="pull-left">
                                @if($order->user->country)
                                    <img src="{{ asset('vendor/flag-icons/flags/4x3/' . strtolower($order->user->country->flag_code ?? '') . '.svg') }}" style="width:16px;height:12px;margin-left:4px;">
                                    {{ $order->user->country->name_ar }}
                                @else - @endif
                            </span>
                        </a></li>
                        <li><a><b>تاريخ الطلب</b> <span class="pull-left text-muted">{{ $order->created_at->format('Y-m-d H:i') }}</span></a></li>
                    </ul>
                </div>
            </div>

            {{-- Uploaded Documents --}}
            <div class="box box-solid" style="border-radius: 10px; overflow:hidden;">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-paperclip"></i> المستندات المرفوعة</h3>
                </div>
                <div class="box-body">
                    <div style="margin-bottom: 15px;">
                        <h5 style="font-weight:bold;"><i class="fa fa-file-pdf-o text-danger"></i> عقد البيع</h5>
                        @if($order->contract_file)
                            @php $ext = pathinfo($order->contract_file, PATHINFO_EXTENSION); @endphp
                            @if(in_array(strtolower($ext), ['jpg','jpeg','png']))
                                <a href="{{ asset('storage/' . $order->contract_file) }}" target="_blank">
                                    <img src="{{ asset('storage/' . $order->contract_file) }}" class="img-responsive img-bordered" style="border-radius:6px;max-height:150px;margin-top:5px;">
                                </a>
                            @else
                                <a href="{{ asset('storage/' . $order->contract_file) }}" target="_blank" class="btn btn-danger btn-sm btn-flat" style="margin-top:5px;">
                                    <i class="fa fa-file-pdf-o"></i> عرض عقد البيع (PDF)
                                </a>
                            @endif
                        @else
                            <p class="text-muted"><i class="fa fa-times"></i> لم يُرفع بعد</p>
                        @endif
                    </div>
                    <hr>
                    <div>
                        <h5 style="font-weight:bold;"><i class="fa fa-file-text-o text-warning"></i> الفاتورة</h5>
                        @if($order->invoice_file)
                            @php $ext2 = pathinfo($order->invoice_file, PATHINFO_EXTENSION); @endphp
                            @if(in_array(strtolower($ext2), ['jpg','jpeg','png']))
                                <a href="{{ asset('storage/' . $order->invoice_file) }}" target="_blank">
                                    <img src="{{ asset('storage/' . $order->invoice_file) }}" class="img-responsive img-bordered" style="border-radius:6px;max-height:150px;margin-top:5px;">
                                </a>
                            @else
                                <a href="{{ asset('storage/' . $order->invoice_file) }}" target="_blank" class="btn btn-warning btn-sm btn-flat" style="margin-top:5px;">
                                    <i class="fa fa-file-text-o"></i> عرض الفاتورة (PDF)
                                </a>
                            @endif
                        @else
                            <p class="text-muted"><i class="fa fa-times"></i> لم يُرفع بعد</p>
                        @endif
                    </div>
                    <hr>
                    <a href="{{ route('regional.clients.contract', $order) }}" class="btn btn-success btn-block btn-flat">
                        <i class="fa fa-upload"></i> رفع / تحديث الملفات
                    </a>
                </div>
            </div>

            {{-- Payment Summary + History --}}
            <div class="box box-solid" style="border-radius:10px;overflow:hidden;">
                <div class="box-header with-border" style="background:#f39c12;color:#fff;">
                    <h3 class="box-title" style="color:#fff;"><i class="fa fa-money"></i> تفاصيل الدفع</h3>
                </div>
                <div class="box-body">
                    @php
                        $price     = $order->product->price;
                        $paid      = $order->paid_amount;
                        $remaining = max(0, $price - $paid);
                    @endphp
                    <div style="display:flex;justify-content:space-between;margin-bottom:12px;flex-wrap:wrap;gap:8px;">
                        <div style="text-align:center;flex:1;">
                            <small class="text-muted">السعر الكلي</small>
                            <strong style="display:block;font-size:17px;font-family:Arial;">{{ number_format($price,2) }} ر.س</strong>
                        </div>
                        <div style="text-align:center;flex:1;border-right:1px solid #eee;border-left:1px solid #eee;">
                            <small class="text-muted">المدفوع</small>
                            <strong style="display:block;font-size:17px;font-family:Arial;color:#27ae60;">{{ number_format($paid,2) }} ر.س</strong>
                        </div>
                        <div style="text-align:center;flex:1;">
                            <small class="text-muted">المتبقي</small>
                            <strong style="display:block;font-size:17px;font-family:Arial;color:{{ $remaining > 0 ? '#e74c3c' : '#27ae60' }};">{{ number_format($remaining,2) }} ر.س</strong>
                        </div>
                    </div>

                    <div style="margin-bottom:8px;">
                        @if($order->payment_status == 'paid') <span class="label label-success label-lg" style="font-size:13px;padding:5px 12px;">مدفوع بالكامل</span>
                        @elseif($order->payment_status == 'partial') <span class="label label-warning label-lg" style="font-size:13px;padding:5px 12px;">دفع جزئي</span>
                        @else <span class="label label-danger label-lg" style="font-size:13px;padding:5px 12px;">غير مدفوع</span>
                        @endif
                    </div>

                    @if($order->payments->count() > 0)
                    <hr>
                    <h5 style="font-weight:bold;"><i class="fa fa-history"></i> سجل الدفعات</h5>
                    <table class="table table-condensed table-bordered" style="margin-top:8px;">
                        <thead>
                            <tr style="background:#fafafa;">
                                <th style="text-align:center;">دفعة</th>
                                <th>المبلغ</th>
                                <th>الحالة</th>
                                <th>التاريخ</th>
                                <th>ملاحظات</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($order->payments->sortBy('created_at')->values() as $i => $p)
                        <tr>
                            <td style="text-align:center;">
                                <span class="badge bg-blue" style="font-size:12px;">{{ $i + 1 }}</span>
                            </td>
                            <td><strong style="font-family:Arial;color:#27ae60;font-size:14px;">{{ number_format($p->amount,2) }} ر.س</strong></td>
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
                        <p class="text-muted text-center" style="margin-top:10px;"><i class="fa fa-info-circle"></i> لا توجد دفعات مسجلة بعد</p>
                    @endif

                    <a href="{{ route('regional.invoices.edit_payment', $order) }}" class="btn btn-warning btn-block btn-flat" style="margin-top:8px;">
                        <i class="fa fa-plus-circle"></i> إضافة دفعة جديدة
                    </a>
                </div>
            </div>
        </div>

        {{-- Product Info + Gallery --}}
        <div class="col-md-8">
            <div class="box box-solid" style="border-radius:10px;overflow:hidden;border:1px solid #f0f0f0;">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-cube"></i> تفاصيل المنتج</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        {{-- Main Image --}}
                        <div class="col-md-5">
                            @if($order->product->images->first())
                                <img src="{{ asset('storage/' . $order->product->images->first()->image_path) }}" class="img-responsive img-bordered" style="border-radius:8px;width:100%;max-height:280px;object-fit:cover;">
                            @endif
                        </div>
                        <div class="col-md-7">
                            <h2 style="margin-top:0;font-weight:900;color:#3c8dbc;">{{ $order->product->name }}</h2>
                            <hr>
                            <table class="table table-condensed">
                                <tr>
                                    <th>المصنع / الشركة</th>
                                    <td><strong>{{ $order->product->user->name }}</strong>
                                        <span class="label label-default" style="font-size:10px;">{{ $order->product->user->type == 'factory' ? 'مصنع' : 'شركة' }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>رقم الطلب</th>
                                    <td><span class="label label-default" style="font-size:13px;">#{{ $order->id }}</span></td>
                                </tr>
                                @if($order->product->sector)
                                <tr>
                                    <th>القطاع</th>
                                    <td>{{ $order->product->sector->name }}</td>
                                </tr>
                                @endif
                                <tr>
                                    <th>السعر</th>
                                    <td>
                                        <strong style="font-size:28px;color:#000;font-family:Arial,sans-serif;direction:ltr;display:block;">
                                            {{ number_format($order->product->price, 2) }} ر.س
                                        </strong>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    {{-- Product Gallery --}}
                    @if($order->product->images->count() > 1)
                    <hr>
                    <h4 style="font-weight:bold;"><i class="fa fa-images"></i> صور المنتج</h4>
                    <div class="row" style="margin-top:10px;">
                        @foreach($order->product->images as $img)
                        <div class="col-xs-6 col-sm-3" style="margin-bottom:10px;">
                            <a href="{{ asset('storage/' . $img->image_path) }}" target="_blank">
                                <img src="{{ asset('storage/' . $img->image_path) }}" class="img-responsive img-bordered img-thumbnail" style="border-radius:6px;height:100px;width:100%;object-fit:cover;">
                            </a>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>

            <a href="{{ route('regional.clients.index') }}" class="btn btn-default btn-lg btn-flat" style="border-radius:6px;">
                <i class="fa fa-arrow-right"></i> رجوع إلى القائمة
            </a>
        </div>

    </div>
</section>
@endsection
