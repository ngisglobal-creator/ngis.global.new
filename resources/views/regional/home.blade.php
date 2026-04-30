@extends('regional.layouts.master')

@section('title', 'الرئيسية | مكتب الاقليم')

@section('content')
<section class="content-header">
  <h1>لوحة تحكم مكتب الاقليم <small>مرحباً {{ Auth::user()->name ?? 'مكتب اقليم' }}</small></h1>
  <ol class="breadcrumb">
    <li><a href="{{ url('regional/dashboard') }}"><i class="fa fa-dashboard"></i> الرئيسية</a></li>
    <li class="active">لوحة التحكم</li>
  </ol>
</section>

<section class="content">

  {{-- Stats Row --}}
  <div class="row">
    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-yellow">
        <div class="inner"><h3>{{ $clients->count() }}</h3><p>العملاء</p></div>
        <div class="icon"><i class="fa fa-users"></i></div>
        <a href="{{ route('regional.clients.index') }}" class="small-box-footer">عرض التفاصيل <i class="fa fa-arrow-circle-left"></i></a>
      </div>
    </div>
    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-aqua">
        <div class="inner"><h3>{{ $invoices->count() }}</h3><p>فواتير مرفوعة</p></div>
        <div class="icon"><i class="fa fa-file-text"></i></div>
        <a href="{{ route('regional.invoices.index') }}" class="small-box-footer">عرض التفاصيل <i class="fa fa-arrow-circle-left"></i></a>
      </div>
    </div>
    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-green">
        <div class="inner">
          <h3>{{ $clients->where('payment_status','paid')->count() }}</h3>
          <p>طلبات مدفوعة</p>
        </div>
        <div class="icon"><i class="fa fa-check-circle"></i></div>
        <a href="{{ route('regional.invoices.payment_status') }}" class="small-box-footer">عرض التفاصيل <i class="fa fa-arrow-circle-left"></i></a>
      </div>
    </div>
    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-red">
        <div class="inner">
          <h3>{{ $clients->whereIn('payment_status',['unpaid','partial'])->count() }}</h3>
          <p>طلبات غير مكتملة</p>
        </div>
        <div class="icon"><i class="fa fa-clock-o"></i></div>
        <a href="{{ route('regional.invoices.payment_status') }}" class="small-box-footer">عرض التفاصيل <i class="fa fa-arrow-circle-left"></i></a>
      </div>
    </div>
  </div>

  {{-- Clients Table --}}
  <div class="row">
    <div class="col-md-12">
      <div class="box box-warning" style="border-radius:10px;overflow:hidden;">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-users"></i> العملاء</h3>
          <div class="box-tools pull-right">
            <a href="{{ route('regional.clients.index') }}" class="btn btn-warning btn-xs">عرض الكل</a>
          </div>
        </div>
        <div class="box-body no-padding">
          <table class="table table-hover" style="margin:0;">
            <thead>
              <tr style="background:#fdfdfd;">
                <th>العميل</th>
                <th>المنتج</th>
                <th>الدولة</th>
                <th>السعر</th>
                <th>المدفوع</th>
                <th>حالة الدفع</th>
                <th>تاريخ الطلب</th>
              </tr>
            </thead>
            <tbody>
              @forelse($clients as $order)
              <tr>
                <td>
                  <div style="display:flex;align-items:center;">
                    <img src="{{ $order->user->avatar_url }}" class="img-circle" style="width:30px;height:30px;margin-left:8px;border:1px solid #ddd;">
                    <strong>{{ $order->user->name }}</strong>
                  </div>
                </td>
                <td>
                  <div style="display:flex;align-items:center;">
                    @if($order->product->images->first())
                      <img src="{{ asset('storage/'.$order->product->images->first()->image_path) }}" style="width:30px;height:22px;border-radius:3px;object-fit:cover;margin-left:6px;">
                    @endif
                    <span style="color:#3c8dbc;">{{ $order->product->name }}</span>
                  </div>
                </td>
                <td>
                  @if($order->user->country)
                    <img src="{{ asset('vendor/flag-icons/flags/4x3/'.strtolower($order->user->country->flag_code ?? '').'.svg') }}" style="width:15px;height:11px;margin-left:4px;">
                    {{ $order->user->country->name_ar }}
                  @else — @endif
                </td>
                <td><strong style="font-family:Arial;">{{ number_format($order->product->price,2) }} ر.س</strong></td>
                <td><strong style="font-family:Arial;color:#27ae60;">{{ number_format($order->paid_amount,2) }} ر.س</strong></td>
                <td>
                  @if($order->payment_status == 'paid') <span class="label label-success">مدفوع</span>
                  @elseif($order->payment_status == 'partial') <span class="label label-warning">جزئي</span>
                  @else <span class="label label-danger">غير مدفوع</span>
                  @endif
                </td>
                <td><small>{{ $order->created_at->format('Y-m-d') }}</small></td>
              </tr>
              @empty
              <tr><td colspan="7" class="text-center text-muted" style="padding:20px;">لا توجد طلبات عملاء حالياً</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  {{-- Invoices Table --}}
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary" style="border-radius:10px;overflow:hidden;">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-file-text-o"></i> أحدث الفواتير المرفوعة</h3>
          <div class="box-tools pull-right">
            <a href="{{ route('regional.invoices.index') }}" class="btn btn-primary btn-xs">عرض الكل</a>
          </div>
        </div>
        <div class="box-body no-padding">
          <table class="table table-hover" style="margin:0;">
            <thead>
              <tr style="background:#fdfdfd;">
                <th>العميل</th>
                <th>المنتج</th>
                <th>الفاتورة</th>
                <th>العقد</th>
                <th>السعر</th>
                <th>حالة الدفع</th>
                <th>الإجراءات</th>
              </tr>
            </thead>
            <tbody>
              @forelse($invoices as $order)
              <tr>
                <td>
                  <div style="display:flex;align-items:center;">
                    <img src="{{ $order->user->avatar_url }}" class="img-circle" style="width:30px;height:30px;margin-left:8px;border:1px solid #ddd;">
                    <strong>{{ $order->user->name }}</strong>
                  </div>
                </td>
                <td>
                  <div style="display:flex;align-items:center;">
                    @if($order->product->images->first())
                      <img src="{{ asset('storage/'.$order->product->images->first()->image_path) }}" style="width:30px;height:22px;border-radius:3px;object-fit:cover;margin-left:6px;">
                    @endif
                    <span style="color:#3c8dbc;">{{ $order->product->name }}</span>
                  </div>
                </td>
                <td>
                  @php $ext = strtolower(pathinfo($order->invoice_file ?? '', PATHINFO_EXTENSION)); @endphp
                  @if($order->invoice_file)
                    @if(in_array($ext,['jpg','jpeg','png']))
                      <a href="{{ asset('storage/'.$order->invoice_file) }}" target="_blank">
                        <img src="{{ asset('storage/'.$order->invoice_file) }}" style="width:40px;height:40px;object-fit:cover;border-radius:4px;border:1px solid #ddd;">
                      </a>
                    @else
                      <a href="{{ asset('storage/'.$order->invoice_file) }}" target="_blank">
                        <i class="fa fa-file-text-o fa-lg text-warning"></i>
                        <small class="text-warning" style="display:block;font-size:10px;">PDF</small>
                      </a>
                    @endif
                  @else <span class="text-muted">—</span> @endif
                </td>
                <td>
                  @php $ext2 = strtolower(pathinfo($order->contract_file ?? '', PATHINFO_EXTENSION)); @endphp
                  @if($order->contract_file)
                    @if(in_array($ext2,['jpg','jpeg','png']))
                      <a href="{{ asset('storage/'.$order->contract_file) }}" target="_blank">
                        <img src="{{ asset('storage/'.$order->contract_file) }}" style="width:40px;height:40px;object-fit:cover;border-radius:4px;border:1px solid #ddd;">
                      </a>
                    @else
                      <a href="{{ asset('storage/'.$order->contract_file) }}" target="_blank">
                        <i class="fa fa-file-pdf-o fa-lg text-danger"></i>
                        <small class="text-danger" style="display:block;font-size:10px;">PDF</small>
                      </a>
                    @endif
                  @else <span class="text-muted">—</span> @endif
                </td>
                <td><strong style="font-family:Arial;">{{ number_format($order->product->price,2) }} ر.س</strong></td>
                <td>
                  @if($order->payment_status == 'paid') <span class="label label-success">مدفوع</span>
                  @elseif($order->payment_status == 'partial') <span class="label label-warning">جزئي</span>
                  @else <span class="label label-danger">غير مدفوع</span>
                  @endif
                </td>
                <td>
                  <a href="{{ route('regional.clients.show', $order) }}" class="btn btn-info btn-xs"><i class="fa fa-eye"></i></a>
                  <a href="{{ route('regional.invoices.edit_payment', $order) }}" class="btn btn-warning btn-xs"><i class="fa fa-money"></i></a>
                </td>
              </tr>
              @empty
              <tr><td colspan="7" class="text-center text-muted" style="padding:20px;">لا توجد فواتير مرفوعة حالياً</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

</section>
@endsection
