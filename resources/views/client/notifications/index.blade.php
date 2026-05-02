@extends('client.layouts.master')

@section('title', 'الإشعارات')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">الإشعارات</h2>
            <p class="text-muted small mb-0">ابقَ على اطلاع بأحدث التنبيهات والطلبات</p>
        </div>
        <div class="box-tools">
            <form action="{{ route('client.notifications.mark-all-as-read') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-outline-primary btn-sm rounded-pill px-4 fw-bold shadow-sm">
                    <i class="fa-solid fa-check-double me-2"></i> تحديد الكل كمقروء
                </button>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 20px;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 border-0 text-muted small fw-bold text-uppercase py-3" style="width: 80px;">الصورة</th>
                            <th class="border-0 text-muted small fw-bold text-uppercase py-3">العنوان / المنتج</th>
                            <th class="border-0 text-muted small fw-bold text-uppercase py-3">الرسالة</th>
                            <th class="border-0 text-muted small fw-bold text-uppercase py-3 text-center" style="width: 150px;">التوقيت</th>
                            <th class="pe-4 border-0 text-muted small fw-bold text-uppercase py-3 text-end" style="width: 120px;">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($notifications as $notification)
                            <tr class="{{ $notification->unread() ? 'bg-light-primary fw-bold' : '' }}">
                                <td class="ps-4 py-3" style="width: 60px !important;">
                                    <div class="position-relative d-inline-block">
                                        @if(isset($notification->data['product_image']))
                                            <img src="{{ $notification->data['product_image'] }}" 
                                                 class="rounded-2 shadow-sm border" 
                                                 style="width: 32px !important; height: 32px !important; min-width: 32px !important; object-fit: cover;" 
                                                 alt="Product">
                                        @else
                                            <div class="bg-light rounded-circle d-flex align-items-center justify-content-center border shadow-sm" style="width: 32px !important; height: 32px !important; min-width: 32px !important;">
                                                <i class="fa-solid fa-bell text-primary" style="font-size: 12px;"></i>
                                            </div>
                                        @endif
                                        @if($notification->unread())
                                            <span class="position-absolute top-0 start-0 translate-middle p-1 bg-danger border border-light rounded-circle" style="z-index: 1;"></span>
                                        @endif
                                    </div>
                                </td>
                                <td class="py-3">
                                    <div class="fw-bold text-dark mb-0">
                                        @if(isset($notification->data['product_name']))
                                            {{ $notification->data['product_name'] }}
                                        @else
                                            {{ $notification->data['user_name'] ?? 'تنبيه للنظام' }}
                                        @endif
                                    </div>
                                    <div class="x-small text-muted">{{ $notification->data['user_type'] ?? 'إشعار' }}</div>
                                </td>
                                <td class="py-3">
                                    <div class="text-muted small text-truncate" style="max-width: 400px;">
                                        {{ $notification->data['message'] }}
                                    </div>
                                </td>
                                <td class="py-3 text-center">
                                    <span class="badge bg-light text-muted fw-normal px-2 py-1" style="font-size: 10px;">
                                        <i class="fa-regular fa-clock me-1"></i> {{ $notification->created_at->diffForHumans() }}
                                    </span>
                                </td>
                                <td class="pe-4 py-3 text-end">
                                    <a href="{{ route('client.notifications.show', $notification->id) }}" class="btn btn-light btn-sm rounded-pill px-3 border shadow-sm">
                                        <i class="fa-solid fa-eye me-1"></i> عرض
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                                        <i class="fa-solid fa-bell-slash text-muted fs-2"></i>
                                    </div>
                                    <h5 class="fw-bold text-dark">لا توجد إشعارات</h5>
                                    <p class="text-muted small">ستظهر تنبيهاتك هنا بمجرد توفرها</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($notifications->hasPages())
            <div class="card-footer bg-white border-0 py-3">
                <div class="d-flex justify-content-center mt-2">
                    {{ $notifications->links() }}
                </div>
            </div>
        @endif
    </div>
</div>

<style>
    .bg-light-primary {
        background-color: rgba(13, 110, 253, 0.03) !important;
        border-right: 4px solid #0d6efd !important;
    }
    .list-group-item:hover {
        background-color: #f8f9fa;
    }
    .x-small { font-size: 11px; }
</style>
@endsection
