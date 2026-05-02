@extends('layouts.master')

@section('title', 'لوحة تحكم شركة الشحن الدولية')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold m-0 text-dark">شركة الشحن الدولية <span class="text-muted fs-6 fw-normal ms-2">Global Forwarding & Procurement Hub</span></h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="#" class="text-decoration-none"><i class="fa-solid fa-house me-1"></i>الرئيسية</a></li>
            <li class="breadcrumb-item active" aria-current="page">لوحة التحكم</li>
        </ol>
    </nav>
</div>

<!-- Info boxes -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 h-100 bg-white p-3 d-flex flex-row align-items-center gap-3">
            <div class="bg-info bg-opacity-10 text-info p-3 rounded-4">
                <i class="fa-solid fa-ship fs-2"></i>
            </div>
            <div>
                <div class="text-muted small fw-bold">طلبات عامة</div>
                <div class="fs-4 fw-bold english-nums">0</div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 h-100 bg-white p-3 d-flex flex-row align-items-center gap-3">
            <div class="bg-danger bg-opacity-10 text-danger p-3 rounded-4">
                <i class="fa-solid fa-magnifying-glass fs-2"></i>
            </div>
            <div>
                <div class="text-muted small fw-bold">طلبات Sourcing</div>
                <div class="fs-4 fw-bold english-nums">0</div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 h-100 bg-white p-3 d-flex flex-row align-items-center gap-3">
            <div class="bg-success bg-opacity-10 text-success p-3 rounded-4">
                <i class="fa-solid fa-qrcode fs-2"></i>
            </div>
            <div>
                <div class="text-muted small fw-bold">QR Passports</div>
                <div class="fs-4 fw-bold english-nums">0</div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 h-100 bg-white p-3 d-flex flex-row align-items-center gap-3">
            <div class="bg-warning bg-opacity-10 text-warning p-3 rounded-4">
                <i class="fa-solid fa-triangle-exclamation fs-2"></i>
            </div>
            <div>
                <div class="text-muted small fw-bold">نزاعات نشطة</div>
                <div class="fs-4 fw-bold english-nums">0</div>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <div class="card-header bg-white border-bottom py-3">
        <h5 class="card-title fw-bold m-0"><i class="fa-solid fa-layer-group text-primary me-2"></i> الأقسام الرئيسية والخدمات</h5>
    </div>
    <div class="card-body p-4">
        <div class="row g-4">
            <div class="col-md-4">
                <a href="{{ route('global_forwarding.orders.standard') }}" class="card border shadow-sm rounded-4 text-decoration-none text-dark h-100 hover-card p-4 text-center">
                    <i class="fa-solid fa-box text-primary fs-1 mb-3"></i>
                    <h5 class="fw-bold">مسار الطلبات العامة</h5>
                    <p class="text-muted small mb-0">استقبال الطلبات الموثقة وإصدار بوالص الشحن</p>
                </a>
            </div>
            <div class="col-md-4">
                <a href="{{ route('global_forwarding.orders.custom') }}" class="card border shadow-sm rounded-4 text-decoration-none text-dark h-100 hover-card p-4 text-center">
                    <i class="fa-solid fa-magnifying-glass-plus text-danger fs-1 mb-3"></i>
                    <h5 class="fw-bold">مسار الطلبات الخاصة</h5>
                    <p class="text-muted small mb-0">البحث الميداني ومطابقة المصادر (Custom Sourcing)</p>
                </a>
            </div>
            <div class="col-md-4">
                <a href="{{ route('global_forwarding.qr_passport') }}" class="card border shadow-sm rounded-4 text-decoration-none text-dark h-100 hover-card p-4 text-center">
                    <i class="fa-solid fa-qrcode text-success fs-1 mb-3"></i>
                    <h5 class="fw-bold">التوثيق الرقمي والوسم</h5>
                    <p class="text-muted small mb-0">إصدار QR Code والأرشفة المرئية</p>
                </a>
            </div>
        </div>
    </div>
</div>

@section('styles')
<style>
    .hover-card {
        transition: all 0.3s ease;
    }
    .hover-card:hover {
        transform: translateY(-5px);
        background-color: #f8f9fa;
        border-color: #0d6efd !important;
    }
</style>
@endsection
@endsection
