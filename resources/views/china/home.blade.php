@extends('china.layouts.master')

@section('title', __('dashboard.home') . ' | ' . __('dashboard.china_panel'))

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold m-0 text-dark">{{ __('dashboard.china_panel') }} <span class="text-muted fs-6 fw-normal ms-2">{{ __('dashboard.welcome') }}</span></h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ url('china/dashboard') }}" class="text-decoration-none"><i class="fa-solid fa-house me-1"></i>{{ __('dashboard.home') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('dashboard.breadcrumb_dashboard') }}</li>
        </ol>
    </nav>
</div>

<div class="row g-4">
    <div class="col-lg-12">
        <div class="row g-3 mb-4">
            <div class="col-sm-6 col-md-3">
                <div class="card border-0 shadow-sm rounded-4 bg-primary text-white overflow-hidden h-100 stat-card">
                    <div class="card-body position-relative p-4">
                        <div class="fw-bold fs-2 mb-1 english-nums">124</div>
                        <div class="fw-semibold">{{ __('dashboard.active_products') }}</div>
                        <i class="fa-solid fa-cubes position-absolute opacity-25" style="font-size: 4rem; top: 1rem; left: 1rem;"></i>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card border-0 shadow-sm rounded-4 bg-info text-white overflow-hidden h-100 stat-card">
                    <div class="card-body position-relative p-4">
                        <div class="fw-bold fs-2 mb-1 english-nums">56</div>
                        <div class="fw-semibold">{{ __('dashboard.pending_orders') }}</div>
                        <i class="fa-solid fa-clock-rotate-left position-absolute opacity-25" style="font-size: 4rem; top: 1rem; left: 1rem;"></i>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card border-0 shadow-sm rounded-4 bg-warning text-dark overflow-hidden h-100 stat-card">
                    <div class="card-body position-relative p-4">
                        <div class="fw-bold fs-2 mb-1 english-nums">12</div>
                        <div class="fw-semibold">{{ __('dashboard.connected_offices') }}</div>
                        <i class="fa-solid fa-globe position-absolute opacity-25" style="font-size: 4rem; top: 1rem; left: 1rem;"></i>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card border-0 shadow-sm rounded-4 bg-success text-white overflow-hidden h-100 stat-card">
                    <div class="card-body position-relative p-4">
                        <div class="fw-bold fs-2 mb-1 english-nums">890</div>
                        <div class="fw-semibold">{{ __('dashboard.total_shipments') }}</div>
                        <i class="fa-solid fa-ship position-absolute opacity-25" style="font-size: 4rem; top: 1rem; left: 1rem;"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="card-title fw-bold m-0"><i class="fa-solid fa-circle-info text-primary me-2"></i> {{ __('dashboard.current_operations') }}</h5>
            </div>
            <div class="card-body p-4">
                <p class="text-muted">{{ __('dashboard.china_desc') }}</p>
                <div class="d-flex gap-2 flex-wrap">
                    <a href="{{ route('china.details') }}" class="btn btn-primary">{{ __('dashboard.view_ngis_details') }}</a>
                    <a href="{{ route('china.invoices') }}" class="btn btn-outline-secondary">{{ __('dashboard.manage_invoices') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>

@section('styles')
<style>
    .stat-card { transition: transform 0.3s ease; }
    .stat-card:hover { transform: translateY(-5px); }
</style>
@endsection
@endsection
