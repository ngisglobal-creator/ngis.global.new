@extends('regional.layouts.master')

@section('title', __('dashboard.home') . ' | ' . __('dashboard.regional_panel'))

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold m-0 text-dark">{{ __('dashboard.regional_panel') }} <span class="text-muted fs-6 fw-normal ms-2">{{ __('dashboard.coordinate_logistics') }}</span></h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ url('regional/dashboard') }}" class="text-decoration-none"><i class="fa-solid fa-house me-1"></i>{{ __('dashboard.home') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('dashboard.breadcrumb_dashboard') }}</li>
        </ol>
    </nav>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 bg-primary text-white stat-card h-100">
            <div class="card-body p-4 position-relative overflow-hidden">
                <div class="fs-2 fw-bold mb-1">24</div>
                <div class="fw-semibold">{{ __('dashboard.active_clients') }}</div>
                <i class="fa-solid fa-users position-absolute opacity-25" style="font-size: 4rem; top: 1rem; left: 1rem;"></i>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 bg-info text-white stat-card h-100">
            <div class="card-body p-4 position-relative overflow-hidden">
                <div class="fs-2 fw-bold mb-1">156</div>
                <div class="fw-semibold">{{ __('dashboard.assigned_orders') }}</div>
                <i class="fa-solid fa-shopping-cart position-absolute opacity-25" style="font-size: 4rem; top: 1rem; left: 1rem;"></i>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 bg-success text-white stat-card h-100">
            <div class="card-body p-4 position-relative overflow-hidden">
                <div class="fs-2 fw-bold mb-1">92%</div>
                <div class="fw-semibold">{{ __('dashboard.completion_rate') }}</div>
                <i class="fa-solid fa-check-double position-absolute opacity-25" style="font-size: 4rem; top: 1rem; left: 1rem;"></i>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 bg-warning text-dark stat-card h-100">
            <div class="card-body p-4 position-relative overflow-hidden">
                <div class="fs-2 fw-bold mb-1 english-nums">4.8</div>
                <div class="fw-semibold">{{ __('dashboard.performance_kpi') }}</div>
                <i class="fa-solid fa-star position-absolute opacity-25" style="font-size: 4rem; top: 1rem; left: 1rem;"></i>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <div class="card-header bg-white border-bottom py-3">
        <h5 class="card-title fw-bold m-0"><i class="fa-solid fa-toolbox text-primary me-2"></i> {{ __('dashboard.operations_panel') }}</h5>
    </div>
    <div class="card-body p-4">
        <div class="row g-4">
            <div class="col-md-6 col-lg-3">
                <a href="{{ route('regional.management.assigned_orders') }}" class="card border shadow-sm rounded-4 text-decoration-none text-dark h-100 hover-card p-3 text-center">
                    <i class="fa-solid fa-clipboard-list text-primary fs-2 mb-2"></i>
                    <h6 class="fw-bold mb-1">{{ __('dashboard.order_management') }}</h6>
                    <p class="text-muted small mb-0">{{ __('dashboard.follow_assigned') }}</p>
                </a>
            </div>
            <div class="col-md-6 col-lg-3">
                <a href="{{ route('regional.management.shipping') }}" class="card border shadow-sm rounded-4 text-decoration-none text-dark h-100 hover-card p-3 text-center">
                    <i class="fa-solid fa-truck-moving text-info fs-2 mb-2"></i>
                    <h6 class="fw-bold mb-1">{{ __('dashboard.shipping_management') }}</h6>
                    <p class="text-muted small mb-0">{{ __('dashboard.coordinate_logistics') }}</p>
                </a>
            </div>
            <div class="col-md-6 col-lg-3">
                <a href="{{ route('regional.management.financial_treasury') }}" class="card border shadow-sm rounded-4 text-decoration-none text-dark h-100 hover-card p-3 text-center">
                    <i class="fa-solid fa-vault text-success fs-2 mb-2"></i>
                    <h6 class="fw-bold mb-1">{{ __('dashboard.financial_treasury') }}</h6>
                    <p class="text-muted small mb-0">{{ __('dashboard.track_financial_flows') }}</p>
                </a>
            </div>
            <div class="col-md-6 col-lg-3">
                <a href="{{ route('regional.performance_kpi.index') }}" class="card border shadow-sm rounded-4 text-decoration-none text-dark h-100 hover-card p-3 text-center">
                    <i class="fa-solid fa-chart-pie text-warning fs-2 mb-2"></i>
                    <h6 class="fw-bold mb-1">{{ __('dashboard.kpi') }}</h6>
                    <p class="text-muted small mb-0">{{ __('dashboard.view_performance') }}</p>
                </a>
            </div>
        </div>
    </div>
</div>

@section('styles')
<style>
    .stat-card { transition: transform 0.3s ease; }
    .stat-card:hover { transform: translateY(-5px); }
    .hover-card { transition: all 0.2s ease; }
    .hover-card:hover { background-color: #f8f9fa; border-color: #0d6efd !important; }
</style>
@endsection
@endsection
