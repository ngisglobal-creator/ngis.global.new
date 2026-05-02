@extends('client.layouts.master')

@section('title', 'طلباتي الخاصة - Sourcing')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold m-0 text-dark">طلباتي الخاصة <span class="text-muted fs-6 fw-normal ms-2">Global Sourcing & Procurement</span></h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('client.dashboard') }}" class="text-decoration-none"><i class="fa-solid fa-house me-1"></i>الرئيسية</a></li>
            <li class="breadcrumb-item active" aria-current="page">طلباتي الخاصة</li>
        </ol>
    </nav>
</div>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
        <h5 class="card-title fw-bold m-0"><i class="fa-solid fa-list-check me-2 text-info"></i> سجل طلبات التوريد الميداني</h5>
        <a href="{{ route('client.special_order') }}" class="btn btn-primary rounded-pill fw-bold shadow-sm px-4">
            <i class="fa-solid fa-circle-plus me-1"></i> تقديم طلب جديد
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 text-center align-middle">
                <thead class="table-light">
                    <tr>
                        <th style="width: 80px;">الصورة</th>
                        <th>معلومات المنتج</th>
                        <th>التصنيف والمنشأ</th>
                        <th style="min-width: 250px;">التفاصيل اللوجستية</th>
                        <th>الحالة</th>
                        <th style="width: 200px;">العمليات</th>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    @forelse($orders as $order)
                        <tr>
                            <td>
                                @if($order->images && count($order->images) > 0)
                                    <img src="{{ Storage::url($order->images[0]) }}" class="rounded border shadow-sm" style="width: 60px; height: 60px; object-fit: cover;">
                                @else
                                    <div class="rounded border bg-light d-flex align-items-center justify-content-center text-muted" style="width: 60px; height: 60px; margin: 0 auto;">
                                        <i class="fa-regular fa-image fs-3"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="text-start">
                                <div class="fw-bold text-dark fs-6">{{ $order->title }}</div>
                                <div class="text-muted small"><i class="fa-solid fa-circle-info me-1"></i>{{ Str::limit($order->description, 50) }}</div>
                            </td>
                            <td>
                                <span class="badge bg-primary mb-1">{{ ucfirst($order->category_type) }}</span><br>
                                <span class="text-muted small"><i class="fa-solid fa-globe me-1"></i> {{ ucfirst($order->origin) }}</span>
                            </td>
                            <td>
                                <div class="d-flex bg-light border rounded-3 p-2">
                                    <div class="flex-fill border-end pe-2">
                                        <div class="text-muted small fw-bold">الكمية</div>
                                        <div class="fw-bold text-primary fs-5 english-nums">{{ $order->quantity }}</div>
                                        <div class="small text-muted">{{ $order->unit }}</div>
                                    </div>
                                    <div class="flex-fill ps-2">
                                        <div class="text-muted small fw-bold">السعر المستهدف</div>
                                        <div class="fw-bold text-success fs-5 english-nums">{{ number_format($order->target_price, 2) }}</div>
                                        <div class="small text-muted">USD</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-{{ str_replace('label-', '', $order->status_color) }} fs-6">
                                    {{ $order->status_label }}
                                </span>
                                @if($order->admin_notes)
                                    <div class="mt-2 small text-primary fw-bold">
                                        <i class="fa-solid fa-comment-dots me-1"></i> رد من الإدارة
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group shadow-sm">
                                    <button class="btn btn-outline-dark btn-sm fw-bold btn-special-detail" 
                                        data-order="{{ json_encode($order) }}"
                                        data-images="{{ json_encode(array_map(fn($img) => Storage::url($img), $order->images ?? [])) }}"
                                        data-spec="{{ $order->spec_file ? Storage::url($order->spec_file) : '' }}">
                                        <i class="fa-solid fa-eye me-1"></i> عرض
                                    </button>
                                    <a href="{{ route('client.special_orders.edit', $order->id) }}" class="btn btn-outline-dark btn-sm fw-bold">
                                        <i class="fa-solid fa-pen-to-square me-1"></i> تعديل
                                    </a>
                                    <form action="{{ route('client.special_orders.delete', $order->id) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد من الحذف؟')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm fw-bold">
                                            <i class="fa-solid fa-trash me-1"></i> حذف
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <!-- Stepper Row -->
                        <tr>
                            <td colspan="6" class="bg-light p-4 border-bottom border-3 border-info">
                                @include('partials.special_order_stepper', ['order' => $order])
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="fa-solid fa-folder-open text-muted opacity-50 mb-3" style="font-size: 5rem;"></i>
                                <h4 class="text-muted fw-bold">لا توجد طلبات خاصة حالياً</h4>
                                <p class="text-muted">ابدأ في استيراد منتجاتك المخصصة الآن.</p>
                                <a href="{{ route('client.special_order') }}" class="btn btn-primary rounded-pill px-4 mt-2">تقديم أول طلب</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Special Order Details Modal -->
<div class="modal fade" id="specialDetailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-dark text-white border-0 py-3">
                <h5 class="modal-title fw-bold"><i class="fa-solid fa-wand-magic-sparkles me-2 text-warning"></i> تفاصيل طلب الاستيراد المخصص</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 bg-white">
                <div class="row g-4">
                    <div class="col-md-5">
                        <div class="bg-light border rounded mb-3 text-center" style="height: 300px; padding: 10px;">
                            <img id="modalMainImg" src="" style="width: 100%; height: 100%; object-fit: contain;">
                        </div>
                        <div id="modalThumbContainer" class="row g-2"></div>
                    </div>
                    <div class="col-md-7">
                        <h4 id="modalTitle" class="fw-bold text-dark mb-3"></h4>
                        <div class="mb-3">
                            <span id="modalCategory" class="badge bg-primary fs-6 me-2"></span>
                            <span id="modalOrigin" class="badge bg-info text-dark fs-6"></span>
                        </div>

                        <div class="bg-light border-start border-4 border-info p-3 mb-4 rounded text-muted">
                            <strong class="text-dark d-block mb-1">المواصفات الفنية:</strong>
                            <p id="modalDesc" class="mb-0" style="font-size: 14px; line-height: 1.6;"></p>
                        </div>

                        <div class="row g-3 text-center mb-4">
                            <div class="col-6">
                                <div class="bg-primary bg-opacity-10 border border-primary border-opacity-25 rounded-3 p-3 h-100">
                                    <div class="text-primary small fw-bold">الكمية المطلوبة</div>
                                    <div id="modalQty" class="fs-3 fw-bold text-primary english-nums"></div>
                                    <div id="modalUnit" class="small text-muted"></div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="bg-success bg-opacity-10 border border-success border-opacity-25 rounded-3 p-3 h-100">
                                    <div class="text-success small fw-bold">السعر المستهدف</div>
                                    <div id="modalPrice" class="fs-3 fw-bold text-success english-nums"></div>
                                    <div class="small text-muted">USD</div>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-warning border-warning border-opacity-50 shadow-sm p-3 mb-3">
                            <strong class="text-dark"><i class="fa-solid fa-comment-dots me-2 text-warning"></i>رد الإدارة والملاحظات:</strong>
                            <p id="modalAdminNotes" class="mt-2 mb-0 text-muted fst-italic small"></p>
                        </div>

                        <a id="modalSpecLink" href="" target="_blank" class="btn btn-outline-danger w-100 fw-bold rounded-pill" style="display: none;">
                            <i class="fa-regular fa-file-pdf me-2"></i> عرض ملف المواصفات المرفق (PDF/CAD)
                        </a>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light border-top-0 d-flex justify-content-between py-3">
                <div>
                    <span class="fw-bold text-muted me-2">حالة الطلب الحالية:</span>
                    <span id="modalStatusLabel" class="badge fs-6 px-3 py-2 rounded-pill"></span>
                </div>
                <button type="button" class="btn btn-secondary rounded-pill px-4 fw-bold" data-bs-dismiss="modal">إغلاق</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function () {
    $('.btn-special-detail').on('click', function () {
        let order = $(this).data('order');
        let images = $(this).data('images');
        let specUrl = $(this).data('spec');

        $('#modalTitle').text(order.title);
        $('#modalDesc').text(order.description);
        $('#modalCategory').text(order.category_type.toUpperCase());
        $('#modalOrigin').text(order.origin.toUpperCase());
        $('#modalQty').text(order.quantity);
        $('#modalUnit').text(order.unit);
        $('#modalPrice').text(parseFloat(order.target_price).toLocaleString());
        $('#modalAdminNotes').text(order.admin_notes || 'لم يتم كتابة ملاحظات من الإدارة بعد. طلبك قيد المراجعة.');

        let statusMap = {
            'pending': { label: 'قيد المراجعة', class: 'bg-warning text-dark' },
            'processing': { label: 'جاري البحث الميداني', class: 'bg-info text-dark' },
            'matched': { label: 'تمت المطابقة', class: 'bg-primary' },
            'shipped': { label: 'تم الشحن', class: 'bg-success' },
            'completed': { label: 'مكتمل', class: 'bg-success' },
            'cancelled': { label: 'ملغي', class: 'bg-danger' }
        };

        let status = statusMap[order.status] || { label: order.status, class: 'bg-secondary' };
        $('#modalStatusLabel').text(status.label).removeClass().addClass('badge fs-6 px-3 py-2 rounded-pill ' + status.class);

        if (specUrl) {
            $('#modalSpecLink').attr('href', specUrl).show();
        } else {
            $('#modalSpecLink').hide();
        }

        // Images
        if (images && images.length > 0) {
            $('#modalMainImg').attr('src', images[0]);
            let thumbs = '';
            images.forEach((img, i) => {
                thumbs += `
                <div class="col-3">
                    <img src="${img}" class="img-thumbnail w-100 p-1 cursor-pointer" style="height: 60px; object-fit: contain; cursor:pointer;" onclick="$('#modalMainImg').attr('src', '${img}')">
                </div>
            `;
            });
            $('#modalThumbContainer').html(thumbs);
        } else {
            $('#modalMainImg').attr('src', "{{ asset('dist/img/boxed-bg.jpg') }}");
            $('#modalThumbContainer').empty();
        }

        const modal = new bootstrap.Modal(document.getElementById('specialDetailModal'));
        modal.show();
    });
});
</script>
@endpush
@endsection