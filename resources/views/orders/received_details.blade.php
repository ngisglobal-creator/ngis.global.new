@extends(view()->exists(auth()->user()->panel_type . '.layouts.master') ? auth()->user()->panel_type . '.layouts.master' : 'layouts.master')

@section('title', 'تفاصيل الطلب المستلم | ' . $order->product->name)

@section('content')
<!-- Import modern font for numbers -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet">
@php
    $orderStatuses = \App\Models\OrderStatus::orderBy('id')->get();
@endphp
<section class="content-header">
    <h1>تفاصيل الطلب المستلم <small>رقم #{{ $order->id }}</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route(auth()->user()->panel_type . '.dashboard') }}"><i class="fa fa-dashboard"></i> الرئيسية</a></li>
        <li><a href="{{ route('orders.received') }}">الطلبات المستلمة</a></li>
        <li class="active">تفاصيل الطلب</li>
    </ol>
</section>

<section class="content">
    <div class="box box-solid" style="border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
        <div class="box-body" style="padding: 30px;">
            <div class="row" style="margin-bottom: 30px;">
                <div class="col-md-12">
                    <div style="background-color: #fcfcfc; padding: 25px 40px; border: 1px solid #eee; border-radius: 8px;">
                        @include('partials.order_stepper', ['order' => $order, 'orderStatuses' => $orderStatuses])
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Product Gallery -->
                <div class="col-md-7">
                    <div class="row">
                        <!-- Vertical Thumbnails -->
                        <div class="col-md-2 hidden-xs hidden-sm">
                            <div class="thumbnails-container" style="display: flex; flex-direction: column; gap: 10px;">
                                @foreach($order->product->images as $index => $image)
                                    <img src="{{ asset('storage/' . $image->image_path) }}" 
                                         class="img-thumbnail thumb-gallery {{ $index === 0 ? 'active' : '' }}" 
                                         style="width: 100%; aspect-ratio: 1/1; object-fit: cover; cursor: pointer; border: 2px solid {{ $index === 0 ? '#3c8dbc' : '#eee' }}; transition: padding 0.2s;"
                                         onclick="changeMainImage(this, '{{ asset('storage/' . $image->image_path) }}')">
                                @endforeach
                            </div>
                        </div>
                        
                        <!-- Main Display Image -->
                        <div class="col-md-10">
                            <div id="main-image-display" class="zoom-container" style="border: 1px solid #eee; border-radius: 8px; overflow: hidden; width: 100%; aspect-ratio: 4/3; background: #fafafa; display: flex; align-items: center; justify-content: center; cursor: zoom-in; position: relative;">
                                @php $firstImage = $order->product->images->first(); @endphp
                                <img id="primaryImage" src="{{ $firstImage ? asset('storage/' . $firstImage->image_path) : asset('dist/img/boxed-bg.jpg') }}" 
                                     style="max-width: 100%; max-height: 100%; object-fit: contain; transition: transform 0.1s ease-out; transform-origin: center center;">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-5">
                    <div style="padding: 0 15px;">
                        <span class="label label-info" style="font-size: 14px; padding: 5px 12px;">{{ $order->product->sector->name_ar }}</span>
                        <h2 style="font-weight: 900; color: #2c3e50; font-size: 32px; margin: 15px 0;">{{ $order->product->name }}</h2>
                        
                        <div style="margin-bottom: 25px;">
                            <span class="english-nums" style="font-size: 48px; font-weight: 900; color: #000; direction: ltr; display: inline-block; font-family: 'Inter', 'Roboto', sans-serif;">
                                {{ number_format($order->product->price, 2, '.', '') }} <small style="font-size: 22px; color: #333;">{{ $order->product->currency_code }}</small>
                            </span>
                            <span class="text-muted" style="font-size: 12px; display: block; margin-top: 2px;">سعر الوحدة (قطعة)</span>
                        </div>

                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#tab_order" data-toggle="tab"><i class="fa fa-list-alt"></i> طلب العميل <span class="label label-danger">جديد</span></a></li>
                                <li><a href="#tab_product" data-toggle="tab">تفاصيل المنتج</a></li>
                                <li><a href="#tab_client" data-toggle="tab">بيانات العميل</a></li>
                            </ul>
                            <div class="tab-content">
                                {{-- ORDER TAB (now the default) --}}
                                <div class="tab-pane active" id="tab_order">
                                    {{-- Main Metrics Strip --}}
                                    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 0; border: 1px solid #e8e8e8; border-radius: 6px; overflow: hidden; margin-bottom: 15px;">
                                        <div style="padding: 14px 12px; text-align: center; border-left: 1px solid #e8e8e8; background: #f8f9fa;">
                                            <span class="text-muted" style="font-size: 11px; display: block; text-transform: uppercase; letter-spacing: 0.05em;">الكمية (قطعة)</span>
                                            <span class="english-nums" style="font-size: 26px; font-weight: 900; color: #3c8dbc;">{{ number_format($order->quantity) }}</span>
                                        </div>
                                        <div style="padding: 14px 12px; text-align: center; border-left: 1px solid #e8e8e8; background: #f8f9fa;">
                                            <span class="text-muted" style="font-size: 11px; display: block; text-transform: uppercase; letter-spacing: 0.05em;">عدد الكرتونات</span>
                                            <span class="english-nums" style="font-size: 26px; font-weight: 900; color: #555;">{{ number_format($order->cartons_count ?? ceil($order->quantity / max($order->product->product_piece_count,1))) }}</span>
                                        </div>
                                        <div style="padding: 14px 12px; text-align: center; background: #f8f9fa;">
                                            <span class="text-muted" style="font-size: 11px; display: block; text-transform: uppercase; letter-spacing: 0.05em;">نوع الحاوية</span>
                                            <span class="english-nums" style="font-size: 18px; font-weight: 800; color: #333;">{{ $order->shipping_unit_type }}</span>
                                        </div>
                                    </div>

                                    {{-- Detailed Logistics Cards --}}
                                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 15px;">
                                        <div style="background: #eaf4ff; border: 1px solid #b8d9f5; border-radius: 6px; padding: 12px 15px;">
                                            <span style="font-size: 11px; color: #3c8dbc; font-weight: 700; text-transform: uppercase; display: block; margin-bottom: 4px;">
                                                <i class="fa fa-cube"></i> إجمالي الحجم (CBM)
                                            </span>
                                            @php
                                                $cbmDisplay = $order->total_cbm ?? round(ceil($order->quantity / max($order->product->product_piece_count,1)) * $order->product->carton_volume_cbm, 3);
                                            @endphp
                                            <span class="english-nums" style="font-size: 22px; font-weight: 900; color: #2471a3;">{{ number_format($cbmDisplay, 3) }} <small style="font-size: 12px; font-weight: 400;">CBM</small></span>
                                        </div>
                                        <div style="background: #eafaf1; border: 1px solid #a9dfbf; border-radius: 6px; padding: 12px 15px;">
                                            <span style="font-size: 11px; color: #27ae60; font-weight: 700; text-transform: uppercase; display: block; margin-bottom: 4px;">
                                                <i class="fa fa-balance-scale"></i> إجمالي الوزن
                                            </span>
                                            @php
                                                $weightDisplay = $order->total_weight ?? round($order->quantity * $order->product->piece_weight, 2);
                                                $weightStr = $weightDisplay >= 1000 ? number_format($weightDisplay / 1000, 2) . ' طن' : number_format($weightDisplay, 2) . ' كجم';
                                            @endphp
                                            <span class="english-nums" style="font-size: 22px; font-weight: 900; color: #1e8449;">{{ $weightStr }}</span>
                                        </div>
                                    </div>

                                    {{-- Total Cost Banner --}}
                                    @php
                                        $costDisplay = $order->total_cost ?? round($order->quantity * $order->product->price, 2);
                                    @endphp
                                    <div style="background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%); border-radius: 6px; padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                                        <div>
                                            <span style="font-size: 11px; color: #aaa; text-transform: uppercase; letter-spacing: 0.1em; display: block;">إجمالي قيمة الطلب</span>
                                            <span class="english-nums" style="font-size: 28px; font-weight: 900; color: #fff;">{{ number_format($costDisplay, 2) }} <small style="font-size: 14px; color: #aaa;">{{ $order->product->currency_code }}</small></span>
                                        </div>
                                        <i class="fa fa-money" style="font-size: 36px; color: rgba(255,255,255,0.15);"></i>
                                    </div>

                                    {{-- Notes --}}
                                    <div style="padding-top: 10px; border-top: 1px solid #eee;">
                                        <h5 style="font-weight: bold; color: #444; margin-bottom: 8px;"><i class="fa fa-pencil"></i> ملاحظات العميل:</h5>
                                        <div style="background: #fdfae3; padding: 12px 15px; border-radius: 6px; border: 1px solid #f1e49d; color: #856404; font-style: italic; font-size: 14px; line-height: 1.6;">
                                            {{ $order->notes ?: 'لا يوجد ملاحظات من العميل.' }}
                                        </div>
                                    </div>
                                </div>

                                {{-- PRODUCT TAB --}}
                                <div class="tab-pane" id="tab_product">
                                    <div style="font-size: 16px; line-height: 1.6; color: #444;">{!! $order->product->description !!}</div>
                                    <ul class="list-group list-group-unbordered">
                                        <li class="list-group-item">
                                            <b>الفرع</b> <a class="pull-left">{{ $order->product->branch->name_ar ?? 'N/A' }}</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>القسم</b> <a class="pull-left">{{ $order->product->category->name_ar ?? 'N/A' }}</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>القطع في الكرتونة</b> <a class="pull-left english-nums">{{ $order->product->product_piece_count }}</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>CBM للكرتونة</b> <a class="pull-left english-nums">{{ $order->product->carton_volume_cbm }} CBM</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>وزن القطعة</b> <a class="pull-left english-nums">{{ $order->product->piece_weight }} كجم</a>
                                        </li>
                                    </ul>
                                </div>

                                {{-- CLIENT TAB --}}
                                <div class="tab-pane" id="tab_client">
                                    <div style="display: flex; align-items: center; margin-bottom: 15px;">
                                        <img src="{{ $order->user->avatar_url }}" class="img-circle" style="width: 60px; height: 60px; border: 2px solid #3c8dbc; margin-left: 15px;">
                                        <div>
                                            <h4 style="margin: 0; font-weight: bold;">{{ $order->user->name }}</h4>
                                            <p class="text-muted" style="margin: 0;">{{ $order->user->email }}</p>
                                        </div>
                                    </div>
                                    <ul class="list-group list-group-unbordered">
                                        <li class="list-group-item">
                                            <b>رقم الهاتف</b> <a class="pull-left">{{ $order->user->phone ?? 'غير متوفر' }}</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>تاريخ الطلب</b> <a class="pull-left english-nums">{{ $order->created_at->format('Y-m-d H:i') }}</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div style="margin-top: 20px; padding: 12px 15px; background: #f8f9fa; border-radius: 8px; border-right: 5px solid 
                            @if(in_array($order->status, ['pending', 'pending_approval'])) #f39c12 @elseif($order->status == 'accepted') #00a65a @else #dd4b39 @endif">
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <span>
                                    @if(in_array($order->status, ['pending', 'pending_approval']))
                                        <span class="label label-warning" style="font-size: 14px;">تحت الموافقة</span>
                                    @elseif($order->status == 'accepted')
                                        <span class="label label-success" style="font-size: 14px;">تم القبول</span>
                                    @else
                                        <span class="label label-danger" style="font-size: 14px;">تم الرفض</span>
                                    @endif
                                </span>
                                <span class="text-muted english-nums"><i class="fa fa-calendar"></i> {{ $order->created_at->format('Y-m-d H:i') }}</span>
                            </div>
                            @if($order->status == 'rejected' && $order->rejection_reason)
                                <div style="margin-top: 12px; padding: 10px 15px; background: #fff0f0; border: 1px solid #f5c6cb; border-radius: 6px;">
                                    <strong style="color: #c0392b;"><i class="fa fa-exclamation-circle"></i> سبب الرفض:</strong>
                                    <p style="margin: 5px 0 0; color: #721c24;">{{ $order->rejection_reason }}</p>
                                </div>
                            @endif
                        </div>

                        <div style="margin-top: 20px; display: flex; gap: 10px;">
                            @if(in_array($order->status, ['pending', 'pending_approval']))
                                <form action="{{ route('orders.update-status', $order) }}" method="POST" style="flex: 1;">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="accepted">
                                    <button type="submit" class="btn btn-success btn-lg btn-block btn-flat" style="border-radius: 6px; font-weight: bold;">
                                        <i class="fa fa-check"></i> قبول الطلب
                                    </button>
                                </form>
                                <button type="button" class="btn btn-danger btn-lg btn-flat" style="flex: 1; border-radius: 6px; font-weight: bold; width: 100%;" data-toggle="modal" data-target="#rejectReasonModal">
                                    <i class="fa fa-times"></i> رفض مع تعليق
                                </button>
                            @endif
                            <a href="{{ route('orders.received') }}" class="btn btn-default btn-lg btn-flat" style="flex: 1; border-radius: 6px;">
                                <i class="fa fa-arrow-right"></i> رجوع
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Rejection Reason Modal -->
<div class="modal fade" id="rejectReasonModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="border-radius: 12px; overflow: hidden;">
            <div class="modal-header" style="background: linear-gradient(135deg, #dd4b39 0%, #a93226 100%); color: white; border-bottom: none; padding: 20px;">
                <button type="button" class="close" data-dismiss="modal" style="color: white; opacity: 1;"><span>&times;</span></button>
                <h4 class="modal-title" style="font-weight: 800;"><i class="fa fa-times-circle"></i> رفض الطلب</h4>
            </div>
            <form action="{{ route('orders.update-status', $order) }}" method="POST">
                @csrf
                @method('PATCH')
                <input type="hidden" name="status" value="rejected">
                <div class="modal-body" style="padding: 25px;">
                    <div class="form-group">
                        <label style="font-weight: 700; font-size: 15px;">سبب الرفض <span class="text-danger">*</span></label>
                        <textarea name="rejection_reason" class="form-control" rows="4" required
                            placeholder="يرجى كتابة سبب رفض الطلب بوضوح..."
                            style="border-radius: 8px; font-size: 15px; resize: vertical;"></textarea>
                        <small class="text-muted">سيتم إرسال هذا السبب للعميل.</small>
                    </div>
                </div>
                <div class="modal-footer" style="background: #f9f9f9; padding: 15px 25px;">
                    <button type="button" class="btn btn-default btn-lg" data-dismiss="modal" style="border-radius: 30px; padding: 8px 25px;">إلغاء</button>
                    <button type="submit" class="btn btn-danger btn-lg" style="border-radius: 30px; padding: 8px 30px; font-weight: bold;">
                        <i class="fa fa-times"></i> تأكيد الرفض
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function changeMainImage(el, src) {
    document.getElementById('primaryImage').src = src;
    $('.thumb-gallery').css('border-color', '#eee').removeClass('active');
    $(el).css('border-color', '#3c8dbc').addClass('active');
}

$(document).ready(function() {
    const container = document.getElementById('main-image-display');
    const img = document.getElementById('primaryImage');

    container.addEventListener('mousemove', (e) => {
        const xPercent = (e.offsetX / container.offsetWidth) * 100;
        const yPercent = (e.offsetY / container.offsetHeight) * 100;
        img.style.transformOrigin = `${xPercent}% ${yPercent}%`;
        img.style.transform = "scale(2)";
    });

    container.addEventListener('mouseleave', () => {
        img.style.transform = "scale(1)";
        img.style.transformOrigin = "center center";
    });

    // Numeral conversion logic
    function convertToWesternNumerals(str) {
        const arabicNumerals = [/٠/g, /١/g, /٢/g, /٣/g, /٤/g, /٥/g, /٦/g, /٧/g, /٨/g, /٩/g];
        const westernNumerals = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        if (typeof str === 'string') {
            for (let i = 0; i < 10; i++) {
                str = str.replace(arabicNumerals[i], westernNumerals[i]);
            }
        }
        return str;
    }

    function processTextNodes(node) {
        if (node.nodeName === 'SCRIPT' || node.nodeName === 'STYLE') return;
        if (node.nodeType === 3) {
            const originalValue = node.nodeValue;
            const convertedValue = convertToWesternNumerals(originalValue);
            if (originalValue !== convertedValue) {
                node.nodeValue = convertedValue;
            }
        } else {
            for (var i = 0; i < node.childNodes.length; i++) {
                processTextNodes(node.childNodes[i]);
            }
        }
    }

    processTextNodes(document.body);
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            mutation.addedNodes.forEach(function(node) {
                processTextNodes(node);
            });
        });
    });
    observer.observe(document.body, { childList: true, subtree: true });
});
</script>
<style>
.thumb-gallery:hover { border-color: #3c8dbc !important; padding: 2px; }
.thumb-gallery.active { box-shadow: 0 0 10px rgba(60, 141, 188, 0.3); }
.zoom-container { overflow: hidden; }
.zoom-container img { pointer-events: none; }
.nav-tabs-custom { box-shadow: none; border: 1px solid #f0f0f0; border-radius: 8px; margin-top: 20px; }
.nav-tabs-custom > .nav-tabs { border-bottom-color: #f4f4f4; }
.nav-tabs-custom > .nav-tabs > li.active { border-top-color: #3c8dbc; }
.english-nums {
    font-family: 'Inter', sans-serif !important;
}
body {
    font-feature-settings: "tnum";
    font-variant-numeric: tabular-nums;
}
</style>
@endpush
@endsection
