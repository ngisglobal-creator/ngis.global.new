@extends('regional.layouts.master')

@section('title', 'الفواتير')

@section('content')
<section class="content-header">
    <h1>الفواتير <small>العملاء الذين قاموا برفع فواتير</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('regional/dashboard') }}"><i class="fa fa-dashboard"></i> الرئيسية</a></li>
        <li class="active">الفواتير</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary" style="border-radius:10px;overflow:hidden;box-shadow:0 4px 10px rgba(0,0,0,0.08);">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-file-text-o"></i> قائمة الفواتير المرفوعة</h3>
                </div>
                <div class="box-body no-padding">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible" style="margin:15px;">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            {{ session('success') }}
                        </div>
                    @endif
                    <table class="table table-hover">
                        <thead>
                            <tr style="background:#fdfdfd;">
                                <th>العميل</th>
                                <th>المنتج</th>
                                <th>الدولة</th>
                                <th>السعر</th>
                                <th>تاريخ الطلب</th>
                                <th style="text-align:center;">العقد</th>
                                <th style="text-align:center;">الفاتورة</th>
                                <th>حالة الدفع</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                            <tr>
                                <td>
                                    <div style="display:flex;align-items:center;">
                                        <img src="{{ $order->user->avatar_url }}" class="img-circle" style="width:32px;height:32px;border:1px solid #ddd;margin-left:8px;">
                                        <div>
                                            <strong>{{ $order->user->name }}</strong><br>
                                            <small class="text-muted">{{ $order->user->email }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div style="display:flex;align-items:center;">
                                        @if($order->product->images->first())
                                            <img src="{{ asset('storage/'.$order->product->images->first()->image_path) }}" style="width:38px;height:28px;border-radius:4px;object-fit:cover;margin-left:8px;">
                                        @endif
                                        <strong style="color:#3c8dbc;">{{ $order->product->name }}</strong>
                                    </div>
                                </td>
                                <td>
                                    @if($order->user->country)
                                        <img src="{{ asset('vendor/flag-icons/flags/4x3/'.strtolower($order->user->country->flag_code ?? '').'.svg') }}" style="width:16px;height:12px;margin-left:4px;">
                                        {{ $order->user->country->name_ar }}
                                    @else - @endif
                                </td>
                                <td><strong style="font-size:16px;font-family:Arial;color:#000;">{{ number_format($order->product->price, 2) }} ر.س</strong></td>
                                <td><small>{{ $order->created_at->format('Y-m-d') }}</small></td>
                                <td style="text-align:center;">
                                    @if($order->contract_file)
                                        @php $ext = strtolower(pathinfo($order->contract_file, PATHINFO_EXTENSION)); @endphp
                                        @if(in_array($ext,['jpg','jpeg','png']))
                                            <a href="{{ asset('storage/'.$order->contract_file) }}" target="_blank"><img src="{{ asset('storage/'.$order->contract_file) }}" style="width:48px;height:48px;object-fit:cover;border-radius:5px;border:1px solid #ddd;"></a>
                                        @else
                                            <a href="{{ asset('storage/'.$order->contract_file) }}" target="_blank"><i class="fa fa-file-pdf-o fa-2x text-danger"></i><small class="text-danger" style="display:block;font-size:10px;">PDF</small></a>
                                        @endif
                                    @else <span class="text-muted">—</span> @endif
                                </td>
                                <td style="text-align:center;">
                                    @if($order->invoice_file)
                                        @php $ext2 = strtolower(pathinfo($order->invoice_file, PATHINFO_EXTENSION)); @endphp
                                        @if(in_array($ext2,['jpg','jpeg','png']))
                                            <a href="{{ asset('storage/'.$order->invoice_file) }}" target="_blank"><img src="{{ asset('storage/'.$order->invoice_file) }}" style="width:48px;height:48px;object-fit:cover;border-radius:5px;border:1px solid #ddd;"></a>
                                        @else
                                            <a href="{{ asset('storage/'.$order->invoice_file) }}" target="_blank"><i class="fa fa-file-text-o fa-2x text-warning"></i><small class="text-warning" style="display:block;font-size:10px;">PDF</small></a>
                                        @endif
                                    @else <span class="text-muted">—</span> @endif
                                </td>
                                <td>
                                    @if($order->payment_status == 'paid') <span class="label label-success">مدفوع</span>
                                    @elseif($order->payment_status == 'partial') <span class="label label-warning">جزئي</span>
                                    @else <span class="label label-danger">غير مدفوع</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('regional.clients.show', $order) }}" class="btn btn-info btn-xs"><i class="fa fa-eye"></i> تفاصيل</a>
                                    <a href="{{ route('regional.clients.contract', $order) }}" class="btn btn-success btn-xs"><i class="fa fa-upload"></i> عقد/دفع</a>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="9" class="text-center" style="padding:40px;">
                                <i class="fa fa-file-o fa-3x text-muted" style="opacity:0.3;"></i>
                                <p class="text-muted" style="margin-top:10px;">لا توجد فواتير مرفوعة حالياً</p>
                            </td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
