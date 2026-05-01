@extends('client.layouts.master')

@section('title', 'طلباتي')

@section('content')
<!-- Import modern font for numbers -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet">
@php
    $orderStatuses = \App\Models\OrderStatus::orderBy('id')->get();
@endphp
<section class="content-header">
    <h1>طلباتي <small>عرض المنتجات التي قمت بطلبها</small></h1>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">قائمة مشترياتي وطلباتي</h3>
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>صورة المنتج</th>
                                <th>اسم المنتج</th>
                                <th>اسم النطاق</th>
                                <th>المعلومات العامة</th>
                                <th style="min-width: 380px;">نتائج اللوجستيات (سعة الحاوية المختارة المعتمدة للطلب)</th>
                                <th>تاريخ الطلب</th>
                                <th>الحالة</th>
                                <th>العمليات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                                <tr>
                                    <td style="width: 100px;">
                                        @php $firstImage = $order->product->images->first(); @endphp
                                        <img src="{{ $firstImage ? asset('storage/' . $firstImage->image_path) : asset('dist/img/boxed-bg.jpg') }}" 
                                             style="width: 80px; height: 80px; object-fit: cover; border-radius: 4px;">
                                    </td>
                                    <td>
                                        <strong style="font-size: 16px;">{{ $order->product->name }}</strong><br>
                                        <span class="text-muted english-nums" style="direction: ltr; display: inline-block;">
                                            {{ number_format($order->product->price, 2, '.', '') }} <small>{{ $order->product->currency_code }}</small>
                                        </span>
                                    </td>
                                    <td>
                                        <div style="display: flex; align-items: center;">
                                            <div class="label label-primary" style="font-size: 14px; padding: 5px 10px;">
                                                {{ $order->product->sector->name_ar }}
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div style="background: #fff; border: 1px solid #e0e0e0; border-radius: 8px; padding: 12px; min-width: 350px;">
                                            <div style="display: flex; align-items: center; margin-bottom: 10px; border-bottom: 1px solid #f0f0f0; padding-bottom: 5px;">
                                                <i class="fa fa-info-circle text-info" style="margin-left: 5px;"></i>
                                                <span style="font-weight: bold; color: #444; font-size: 13px;">توزيع الطلب على وحدة الشحن المحددة ({{ $order->shipping_unit_type }})</span>
                                            </div>
                                            <div class="row text-center" style="display: flex; justify-content: space-between; margin: 0;">
                                                <div style="flex: 1; border-left: 1px solid #eee;">
                                                    <div style="font-size: 11px; color: #888;">CBM</div>
                                                    <div style="font-weight: 800; color: #3c8dbc; font-size: 14px;" class="english-nums">{{ number_format($order->total_cbm, 3) }}</div>
                                                </div>
                                                <div style="flex: 1; border-left: 1px solid #eee;">
                                                    <div style="font-size: 11px; color: #888;">الوزن</div>
                                                    <div style="font-weight: 800; color: #f39c12; font-size: 14px;" class="english-nums">{{ $order->total_weight > 1000 ? number_format($order->total_weight / 1000, 2) . ' Ton' : number_format($order->total_weight) . ' KG' }}</div>
                                                </div>
                                                <div style="flex: 1; border-left: 1px solid #eee;">
                                                    <div style="font-size: 11px; color: #888;">كرتون</div>
                                                    <div style="font-weight: 800; color: #d9534f; font-size: 14px;" class="english-nums">{{ number_format($order->cartons_count) }}</div>
                                                </div>
                                                <div style="flex: 1; border-left: 1px solid #eee;">
                                                    <div style="font-size: 11px; color: #888;">قطع</div>
                                                    <div style="font-weight: 800; color: #28a745; font-size: 14px;" class="english-nums">{{ number_format($order->quantity) }}</div>
                                                </div>
                                                <div style="flex: 1;">
                                                    <div style="font-size: 11px; color: #888;">السعر الإجمالي</div>
                                                    <div style="font-weight: 800; color: #856404; font-size: 13px;" class="english-nums">{{ number_format($order->total_cost ?: ($order->quantity * $order->product->price), 2) }} <span style="font-size: 10px;">{{ $order->product->currency_code }}</span></div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="english-nums" style="direction: ltr; text-align: right;">{{ $order->created_at->format('Y-m-d H:i') }}</td>
                                    <td>
                                        @if(in_array($order->status, ['pending', 'pending_approval']))
                                            <span class="label label-warning" style="font-size: 13px;">{{ $order->status == 'pending' ? 'قيد الانتظار' : 'تحت الموافقة' }}</span>
                                            <div style="margin-top: 5px; font-size: 11px; color: #777;">انتظار الموافقة</div>
                                        @elseif($order->status == 'accepted')
                                            <span class="label label-success" style="font-size: 13px;">تم القبول</span>
                                            <div style="margin-top: 5px; font-size: 11px; color: #777;">تمت الموافقة على طلبك</div>
                                        @else
                                            <span class="label label-danger" style="font-size: 13px;">تم الرفض</span>
                                            <div style="margin-top: 5px; font-size: 11px; color: #777;">نأسف، تم رفض طلبك</div>
                                            @if($order->rejection_reason)
                                                <div style="margin-top: 6px; padding: 5px 8px; background: #fff0f0; border: 1px solid #f5c6cb; border-radius: 4px; font-size: 11px; color: #721c24;">
                                                    <i class="fa fa-exclamation-circle"></i> <strong>سبب الرفض:</strong><br>{{ $order->rejection_reason }}
                                                </div>
                                            @endif
                                        @endif
                                    </td>
                                        <button class="btn btn-info btn-sm btn-detail-modal" 
                                            data-id="{{ $order->product->id }}"
                                            data-name="{{ $order->product->name }}"
                                            data-price="{{ number_format($order->product->price, 2, '.', '') }}"
                                            data-currency="{{ $order->product->currency_code }}"
                                            data-desc="{{ $order->product->description }}"
                                            data-qty="{{ $order->product->quantity }}"
                                            data-order-qty="{{ $order->quantity }}"
                                            data-unit="{{ $order->shipping_unit_type }}"
                                            data-notes="{{ $order->notes }}"
                                            data-sector="{{ $order->product->sector->name_ar }}"
                                            data-rejection-reason="{{ $order->rejection_reason }}"
                                            data-status-label="{{ in_array($order->status, ['pending', 'pending_approval']) ? ($order->status == 'pending' ? 'قيد الانتظار' : 'تحت الموافقة') : ($order->status == 'accepted' ? 'تم القبول' : 'تم الرفض') }}"
                                            data-status-class="{{ in_array($order->status, ['pending', 'pending_approval']) ? 'warning' : ($order->status == 'accepted' ? 'success' : 'danger') }}"
                                            data-status-text="{{ in_array($order->status, ['pending', 'pending_approval']) ? 'انتظار الموافقة' : ($order->status == 'accepted' ? 'تمت الموافقة على طلبك' : 'نأسف، تم رفض طلبك') }}"
                                            data-images="{{ $order->product->images->map(fn($img) => asset('storage/' . $img->image_path)) }}">
                                            <i class="fa fa-eye"></i> عرض
                                        </button>
                                        <form action="{{ route('orders.destroy', $order) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('هل أنت متأكد من حذف هذا الطلب؟ لا يمكن التراجع عن هذا الإجراء.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="حذف الطلب">
                                                <i class="fa fa-trash"></i> حذف
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                <!-- Order Stepper Row -->
                                <tr>
                                    <td colspan="9" style="background-color: #fcfcfc; padding: 25px 40px; border-bottom: 2px solid #3c8dbc;">
                                        @include('partials.order_stepper', ['order' => $order, 'orderStatuses' => $orderStatuses])
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">لم تقم بإجراء أي طلبات حتى الآن. <a href="{{ route('client.dashboard') }}">تصفح المنتجات الآن</a></td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

<!-- Product Detail Modal -->
<div class="modal fade" id="productDetailModal" tabindex="-1" role="dialog" aria-labelledby="productDetailModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 12px; overflow: hidden; border: none; box-shadow: 0 10px 40px rgba(0,0,0,0.2);">
            <div class="modal-header" style="background-color: #3c8dbc; color: white; border-bottom: none; padding: 20px;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white; opacity: 0.8;"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modalProductName" style="font-weight: bold; font-size: 24px;">اسم المنتج</h4>
            </div>
            <div class="modal-body" style="padding: 30px;">
                <div class="row">
                    <!-- Image Gallery Column -->
                    <div class="col-md-6">
                        <div id="mainImageContainer" style="margin-bottom: 20px; border: 1px solid #eee; border-radius: 8px; overflow: hidden; height: 350px;">
                            <img id="modalMainImage" src="" alt="Main Image" style="width: 100%; height: 100%; object-fit: contain; background: #fafafa;">
                        </div>
                        <div id="thumbnailContainer" class="row" style="margin-left: -5px; margin-right: -5px;">
                            <!-- Thumbnails will be injected here -->
                        </div>
                    </div>
                    <!-- Details Column -->
                    <div class="col-md-6">
                        <div style="margin-bottom: 25px;">
                            <h3 style="color: #3c8dbc; font-size: 36px; font-weight: 900; margin: 0;">
                                <span id="modalProductPrice">0</span> <small style="font-size: 18px; color: #777;" id="modalProductCurrency">SAR</small>
                            </h3>
                            <div id="modalProductSector" class="label label-info" style="font-size: 16px; margin-top: 10px; display: inline-block; padding: 5px 15px;">القطاع</div>
                        </div>

                        <div style="background: #fff; padding: 0;">
                            <h5 style="font-weight: bold; color: #2c3e50; font-size: 22px; margin-bottom: 15px; border-bottom: 3px solid #3c8dbc; display: inline-block; padding-bottom: 5px;">وصف المنتج</h5>
                            <p id="modalProductDesc" style="font-size: 18px; line-height: 1.8; color: #444; text-align: justify; margin-bottom: 25px;">
                                تفاصيل المنتج ستظهر هنا...
                            </p>
                        </div>

                        <div style="padding: 20px; background: #f9f9f9; border-radius: 10px; border: 1px dashed #ccc;">
                            <p style="margin: 0; font-size: 16px; color: #666; margin-bottom: 10px;">
                                <i class="fa fa-cubes text-primary"></i> الكمية المتاحة في المخزن: 
                                <strong id="modalProductQty" class="english-nums" style="color: #333; font-size: 18px;">0</strong> وحدة
                            </p>
                            <hr style="margin: 10px 0; border-color: #eee;">
                            <p style="margin: 0; font-size: 18px; color: #2c3e50; font-weight: bold;">
                                <i class="fa fa-shopping-basket text-success"></i> الكمية المطلوبة: 
                                <span id="modalOrderQty" class="english-nums" style="font-size: 24px;">0</span> 
                                <span id="modalOrderUnit" class="label label-default english-nums" style="font-size: 14px; margin-right: 10px;">CBM</span>
                            </p>
                            <div id="modalOrderNotesContainer" style="margin-top: 15px; padding-top: 10px; border-top: 1px solid #eee;">
                                <small style="display: block; color: #777; margin-bottom: 5px; font-weight: bold;">ملاحظات طلبك:</small>
                                <div id="modalOrderNotes" style="font-style: italic; color: #555; background: #fff; padding: 10px; border-radius: 4px; font-size: 14px;">لا توجد ملاحظات.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="background: #f4f7f6; border-top: 1px solid #eee; padding: 25px 30px;">
                <div class="pull-right">
                    <span style="font-size: 16px; margin-left: 10px; font-weight: bold; color: #555;">حالة الطلب:</span>
                    <span id="modalOrderStatusLabel" class="label label-warning" style="font-size: 16px; padding: 5px 15px;">قيد الانتظار</span>
                    <small id="modalOrderStatusText" style="display: block; margin-top: 5px; color: #777;">انتظار الموافقة</small>
                    <div id="modalRejectionReasonContainer" style="display: none; margin-top: 10px; padding: 10px 15px; background: #fff0f0; border: 1px solid #f5c6cb; border-radius: 6px; text-align: right;">
                        <strong style="color: #c0392b;"><i class="fa fa-exclamation-circle"></i> سبب الرفض:</strong>
                        <p id="modalRejectionReason" style="margin: 5px 0 0; color: #721c24; font-size: 13px;"></p>
                    </div>
                </div>
                <button type="button" class="btn btn-default btn-lg" data-dismiss="modal" style="border-radius: 6px; padding: 10px 30px;">إغلاق</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    $('.btn-detail-modal').on('click', function() {
        const btn = $(this);
        const name = btn.data('name');
        const price = btn.data('price');
        const currency = btn.data('currency');
        const desc = btn.data('desc');
        const qty = btn.data('qty');
        const orderQty = btn.data('order-qty');
        const unit = btn.data('unit');
        const notes = btn.data('notes');
        const sector = btn.data('sector');
        const images = btn.data('images');
        
        const statusLabel = btn.data('status-label');
        const statusClass = btn.data('status-class');
        const statusText = btn.data('status-text');
        const rejectionReason = btn.data('rejection-reason');

        // Populate Modal Fields
        $('#modalProductName').text(name);
        $('#modalProductPrice').text(qtyToString(price));
        $('#modalProductCurrency').text(currency || 'SAR');
        $('#modalProductDesc').html(desc);
        $('#modalProductQty').text(qtyToString(qty));
        $('#modalOrderQty').text(qtyToString(orderQty));
        $('#modalOrderUnit').text(unit);
        $('#modalOrderNotes').text(notes || 'لا توجد ملاحظات.');
        $('#modalProductSector').text(sector);
        
        // Status Update
        $('#modalOrderStatusLabel').text(statusLabel)
            .removeClass('label-warning label-success label-danger')
            .addClass('label-' + statusClass);
        $('#modalOrderStatusText').text(statusText);

        // Show rejection reason if rejected
        if (statusClass === 'danger' && rejectionReason) {
            $('#modalRejectionReason').text(rejectionReason);
            $('#modalRejectionReasonContainer').show();
        } else {
            $('#modalRejectionReasonContainer').hide();
            $('#modalRejectionReason').text('');
        }

        // Populate Image Gallery
        if (images && images.length > 0) {
            $('#modalMainImage').attr('src', images[0]);
            
            let thumbHtml = '';
            images.forEach((img, index) => {
                thumbHtml += `
                    <div class="col-xs-3" style="padding: 5px;">
                        <img src="${img}" class="img-thumbnail img-gallery-thumb" 
                             style="width: 100%; height: 75px; object-fit: cover; cursor: pointer; border: 2px solid ${index === 0 ? '#3c8dbc' : '#eee'}" 
                             onclick="changeModalImage(this, '${img}')">
                    </div>
                `;
            });
            $('#thumbnailContainer').html(thumbHtml);
        } else {
            $('#modalMainImage').attr('src', "{{ asset('dist/img/boxed-bg.jpg') }}");
            $('#thumbnailContainer').html('');
        }
        
        $('#productDetailModal').modal('show');
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

    function qtyToString(qty) {
        return parseFloat(qty).toLocaleString(undefined, {minimumFractionDigits: 0, maximumFractionDigits: 2});
    }

    // Initial and periodic numeral purge
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

function changeModalImage(el, src) {
    $('#modalMainImage').attr('src', src);
    $('.img-gallery-thumb').css('border-color', '#eee');
    $(el).css('border-color', '#3c8dbc');
}
</script>
<style>
.img-gallery-thumb:hover {
    border-color: #3c8dbc !important;
}
.english-nums {
    font-family: 'Inter', sans-serif !important;
    font-variant-numeric: tabular-nums;
}

</style>
@endpush
