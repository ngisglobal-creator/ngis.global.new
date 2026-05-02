@extends('client.layouts.master')

@section('title', 'تفاصيل الإشعار')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">تفاصيل الإشعار</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('client.dashboard') }}" class="text-decoration-none">الرئيسية</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('client.notifications.index') }}" class="text-decoration-none">الإشعارات</a></li>
                    <li class="breadcrumb-item active" aria-current="page">تفاصيل</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('client.notifications.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3 shadow-sm bg-white">
            <i class="fa-solid fa-arrow-right-long me-2"></i> العودة للقائمة
        </a>
    </div>

    <div class="row g-4">
        <!-- User/Sender Info -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 20px;">
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <img src="{{ $notification->data['user_avatar'] ?? asset('dist/img/user2-160x160.jpg') }}" 
                             class="rounded-circle shadow-sm border p-1 bg-white mb-3" 
                             style="width: 100px; height: 100px; object-fit: cover;">
                        <h4 class="fw-bold text-dark mb-1">{{ $notification->data['user_name'] ?? 'مرسل مجهول' }}</h4>
                        <span class="badge bg-light text-primary rounded-pill px-3 py-2 border small">
                            <i class="fa-solid fa-user-tag me-1"></i> {{ $notification->data['user_type'] ?? 'عميل' }}
                        </span>
                    </div>

                    <div class="bg-light rounded-4 p-3 mb-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="small text-muted">التاريخ:</span>
                            <span class="small fw-bold">{{ $notification->created_at->format('Y/m/d') }}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="small text-muted">الوقت:</span>
                            <span class="small fw-bold">{{ $notification->created_at->format('H:i A') }}</span>
                        </div>
                    </div>

                    <div class="notification-content p-3 border rounded-4 bg-white shadow-sm">
                        <h6 class="fw-bold mb-2"><i class="fa-solid fa-comment-dots me-2 text-primary"></i> نص الإشعار</h6>
                        <p class="text-muted small mb-0" style="line-height: 1.6;">{{ $notification->data['message'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Linked Content/Product -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 20px;">
                <div class="card-header bg-white border-bottom-0 p-4 pb-0">
                    <h5 class="fw-bold text-dark mb-0"><i class="fa-solid fa-link me-2 text-primary"></i> المحتوى المرتبط</h5>
                </div>
                <div class="card-body p-4">
                    @if(isset($notification->data['product_id']))
                        <div class="row g-4 align-items-center">
                            <div class="col-md-5">
                                <div class="ratio ratio-1x1 rounded-4 overflow-hidden shadow-sm">
                                    <img src="{{ $notification->data['product_image'] ?? asset('dist/img/boxed-bg.jpg') }}" 
                                         class="object-fit-cover" 
                                         alt="Product">
                                </div>
                            </div>
                            <div class="col-md-7">
                                <span class="badge bg-soft-primary text-primary rounded-pill mb-2 px-3 py-2 fw-bold">منتج متميز</span>
                                <h2 class="fw-bold text-dark mb-3">{{ $notification->data['product_name'] }}</h2>
                                
                                @if(isset($notification->data['order_id']))
                                    <div class="mb-4">
                                        <span class="text-muted small d-block mb-1">رقم الطلب المرتبط:</span>
                                        <span class="badge bg-light text-dark px-3 py-2 border rounded-3 fw-bold">#{{ $notification->data['order_id'] }}</span>
                                    </div>
                                @endif

                                <div class="d-flex gap-2 mt-5">
                                    @if(isset($notification->data['action_url']))
                                        <a href="{{ $notification->data['action_url'] }}" class="btn btn-primary px-4 py-3 fw-bold rounded-3 shadow-sm flex-grow-1">
                                            <i class="fa-solid fa-arrow-up-right-from-square me-2"></i> عرض تفاصيل المنتج
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3 shadow-sm" style="width: 80px; height: 80px;">
                                <i class="fa-solid fa-circle-info text-muted fs-2"></i>
                            </div>
                            <h5 class="fw-bold text-dark">لا يوجد محتوى مرتبط</h5>
                            <p class="text-muted small">هذا الإشعار لا يحتوي على تفاصيل منتج أو طلب محددة</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-soft-primary {
        background-color: rgba(13, 110, 253, 0.1);
    }
    .card {
        transition: transform 0.3s ease;
    }
</style>
@endsection
