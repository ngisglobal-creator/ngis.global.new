@extends('client.layouts.master')

@section('title', 'طلباتي')

@section('styles')
<style>
    .order-thumbnail {
        width: 60px !important;
        height: 60px !important;
        object-fit: contain;
        background: #fff;
    }
    .logistics-info {
        font-size: 13px;
        line-height: 1.5;
    }
    /* Fixed Table Layout */
    .orders-table { table-layout: fixed; width: 100%; }
    .orders-table th, .orders-table td { overflow: hidden; text-overflow: ellipsis; vertical-align: middle !important; }
</style>
@endsection

@section('content')
@php $orderStatuses = \App\Models\OrderStatus::orderBy('id')->get(); @endphp

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold m-0 text-dark">طلباتي <span class="text-muted fs-6 fw-normal ms-2">سجل مشترياتك</span></h3>
</div>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <div class="card-header bg-white border-bottom py-3">
        <h5 class="card-title fw-bold m-0"><i class="fa-solid fa-list-check me-2 text-primary"></i> قائمة الطلبات</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover orders-table mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 80px;" class="text-center">الصورة</th>
                        <th style="width: 250px;">المنتج</th>
                        <th style="width: 120px;">القطاع</th>
                        <th style="width: 280px;">بيانات اللوجستيات</th>
                        <th style="width: 130px;">الحالة</th>
                        <th style="width: 120px;" class="text-center">إجراءات</th>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    @forelse($orders as $order)
                        <tr>
                            <td class="text-center">
                                @php $firstImage = $order->product->images->first(); @endphp
                                <img src="{{ $firstImage ? asset('storage/' . $firstImage->image_path) : asset('dist/img/boxed-bg.jpg') }}" class="order-thumbnail rounded border shadow-sm p-1">
                            </td>
                            <td>
                                <div class="fw-bold text-dark">{{ $order->product->name }}</div>
                                <div class="english-nums text-danger small fw-semibold">{{ number_format($order->product->price, 2) }} {{ $order->product->currency_code }}</div>
                            </td>
                            <td>
                                <span class="badge bg-secondary">{{ $order->product->sector->name_ar }}</span>
                            </td>
                            <td>
                                <div class="logistics-info text-muted">
                                    <div class="row g-1">
                                        <div class="col-6"><span class="text-dark">CBM:</span> <span class="english-nums fw-bold">{{ number_format($order->total_cbm, 2) }}</span></div>
                                        <div class="col-6"><span class="text-dark">الوزن:</span> <span class="english-nums fw-bold">{{ number_format($order->total_weight) }} KG</span></div>
                                    </div>
                                    <div class="row g-1 mt-1">
                                        <div class="col-6"><span class="text-dark">الكمية:</span> <span class="english-nums fw-bold">{{ number_format($order->quantity) }}</span></div>
                                        <div class="col-6"><span class="text-dark">التكلفة:</span> <span class="english-nums text-success fw-bold">{{ number_format($order->total_cost ?: ($order->quantity * $order->product->price), 0) }}</span></div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if(in_array($order->status, ['pending', 'pending_approval']))
                                    <span class="badge bg-warning text-dark"><i class="fa-solid fa-clock me-1"></i> قيد الانتظار</span>
                                @elseif($order->status == 'accepted')
                                    <span class="badge bg-success"><i class="fa-solid fa-check me-1"></i> تم القبول</span>
                                @else
                                    <span class="badge bg-danger"><i class="fa-solid fa-xmark me-1"></i> مرفوض</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="btn-group shadow-sm">
                                    <button class="btn btn-outline-primary btn-sm btn-detail-modal" 
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
                                        data-images="{{ $order->product->images->map(fn($img) => asset('storage/' . $img->image_path)) }}">
                                        <i class="fa-solid fa-eye"></i> التفاصيل
                                    </button>
                                    <form action="{{ route('orders.destroy', $order) }}" method="POST" style="display:inline;" onsubmit="return confirm('هل أنت متأكد من الحذف؟');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm"><i class="fa-solid fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="6" class="p-3 bg-light">
                                @include('partials.order_stepper', ['order' => $order, 'orderStatuses' => $orderStatuses])
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center py-5 text-muted"><i class="fa-solid fa-folder-open fs-2 mb-2"></i><br>لا توجد طلبات.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Detail Modal (Bootstrap 5) -->
<div class="modal fade" id="productDetailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white border-0">
                <h5 class="modal-title fw-bold" id="modalProductName">تفاصيل المنتج</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row">
                    <div class="col-md-5 mb-3 mb-md-0">
                        <div class="border rounded p-2 mb-2 bg-light text-center" style="height: 250px;">
                            <img id="modalMainImage" src="" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                        </div>
                        <div id="thumbnailContainer" class="row g-2"></div>
                    </div>
                    <div class="col-md-7">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <h3 id="modalProductPrice" class="english-nums text-danger fw-bold m-0">0</h3>
                            <span id="modalProductSector" class="badge bg-secondary"></span>
                        </div>
                        <hr class="text-muted">
                        <div class="d-flex justify-content-between mb-3 bg-light p-2 rounded">
                            <strong class="text-dark">الكمية المطلوبة:</strong> 
                            <span id="modalOrderQty" class="english-nums fw-bold text-primary fs-5">0</span>
                        </div>
                        <h6 class="fw-bold text-dark">وصف المنتج:</h6>
                        <div id="modalProductDesc" class="text-muted mb-3" style="max-height: 150px; overflow-y: auto; font-size: 14px;"></div>
                        
                        <div class="alert alert-warning border-0 shadow-sm p-3 mb-0">
                            <h6 class="fw-bold mb-1"><i class="fa-solid fa-note-sticky me-1"></i> ملاحظاتك:</h6>
                            <p id="modalOrderNotes" class="mb-0 text-dark small"></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light border-0 py-2">
                <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">إغلاق</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    $('.btn-detail-modal').on('click', function() {
        const d = $(this).data();
        $('#modalProductName').text(d.name);
        $('#modalProductPrice').text(parseFloat(d.price).toLocaleString() + ' ' + (d.currency || 'SAR'));
        $('#modalProductDesc').html(d.desc);
        $('#modalOrderQty').text(parseFloat(d.orderQty).toLocaleString());
        $('#modalOrderNotes').text(d.notes || 'لا يوجد ملاحظات.');
        $('#modalProductSector').text(d.sector);
        
        if (d.images && d.images.length > 0) {
            $('#modalMainImage').attr('src', d.images[0]);
            let h = '';
            d.images.forEach((img) => {
                h += `<div class="col-3"><img src="${img}" class="img-thumbnail w-100 p-1 cursor-pointer" style="height:60px; object-fit:contain;" onclick="$('#modalMainImage').attr('src', '${img}')" style="cursor: pointer;"></div>`;
            });
            $('#thumbnailContainer').html(h);
        } else {
            $('#modalMainImage').attr('src', "{{ asset('dist/img/boxed-bg.jpg') }}");
            $('#thumbnailContainer').html('');
        }
        
        // Use Bootstrap 5 modal syntax
        const modal = new bootstrap.Modal(document.getElementById('productDetailModal'));
        modal.show();
    });
});
</script>
@endpush
@endsection
