@extends('client.layouts.master')

@php
    $dashboardTitle = __('dashboard.client_panel');
    if(Auth::user()->type === 'merchant') {
        $dashboardTitle = __('dashboard.merchant_panel');
    } elseif(Auth::user()->type === 'company_owner') {
        $dashboardTitle = __('dashboard.company_owner_panel');
    }
@endphp

@section('title', __('dashboard.home') . ' | ' . $dashboardTitle)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold m-0 text-dark">{{ $dashboardTitle }} <span class="text-muted fs-6 fw-normal ms-2">{{ __('dashboard.welcome') }} {{ Auth::user()->name ?? '' }}</span></h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ url('client/dashboard') }}" class="text-decoration-none"><i class="fa-solid fa-house me-1"></i>{{ __('dashboard.home') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $dashboardTitle }}</li>
        </ol>
    </nav>
</div>

<div class="row g-4">
    <!-- Main Content Area -->
    <div class="col-lg-9">
        
        <!-- Suggested Products -->
        @if($suggestedProducts && $suggestedProducts->count() > 0)
        <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="card-title fw-bold m-0 text-primary">
                    <i class="fa-solid fa-star text-warning me-2"></i> {{ __('dashboard.suggested_products') }}
                </h5>
            </div>
            <div class="card-body bg-light p-4">
                <div class="row g-3">
                    @foreach($suggestedProducts as $product)
                        <div class="col-md-4 col-sm-6">
                            @include('client.products.partials.product_card', ['product' => $product, 'isRecommended' => true])
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <!-- Quick Stats -->
        <div class="row g-3 mb-4">
            <div class="col-sm-6 col-md-3">
                <div class="card border-0 shadow-sm rounded-4 bg-success text-white overflow-hidden h-100 stat-card">
                    <div class="card-body position-relative p-4">
                        <div class="fw-bold fs-2 mb-1">12</div>
                        <div class="fw-semibold">{{ __('dashboard.my_active_orders') }}</div>
                        <i class="fa-solid fa-cart-shopping position-absolute opacity-25" style="font-size: 4rem; top: 1rem; left: 1rem;"></i>
                    </div>
                    <div class="card-footer bg-dark bg-opacity-10 border-0 text-center py-2">
                        <a href="#" class="text-white text-decoration-none small fw-bold">{{ __('dashboard.view_details') }} <i class="fa-solid fa-circle-arrow-left ms-1"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card border-0 shadow-sm rounded-4 bg-info text-white overflow-hidden h-100 stat-card">
                    <div class="card-body position-relative p-4">
                        <div class="fw-bold fs-2 mb-1">5</div>
                        <div class="fw-semibold">{{ __('dashboard.pending_invoices') }}</div>
                        <i class="fa-solid fa-file-invoice position-absolute opacity-25" style="font-size: 4rem; top: 1rem; left: 1rem;"></i>
                    </div>
                    <div class="card-footer bg-dark bg-opacity-10 border-0 text-center py-2">
                        <a href="#" class="text-white text-decoration-none small fw-bold">{{ __('dashboard.view_details') }} <i class="fa-solid fa-circle-arrow-left ms-1"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card border-0 shadow-sm rounded-4 bg-warning text-dark overflow-hidden h-100 stat-card">
                    <div class="card-body position-relative p-4">
                        <div class="fw-bold fs-2 mb-1">3</div>
                        <div class="fw-semibold">{{ __('dashboard.new_messages') }}</div>
                        <i class="fa-solid fa-envelope position-absolute opacity-25" style="font-size: 4rem; top: 1rem; left: 1rem;"></i>
                    </div>
                    <div class="card-footer bg-dark bg-opacity-10 border-0 text-center py-2">
                        <a href="#" class="text-dark text-decoration-none small fw-bold">{{ __('dashboard.view_details') }} <i class="fa-solid fa-circle-arrow-left ms-1"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card border-0 shadow-sm rounded-4 bg-danger text-white overflow-hidden h-100 stat-card">
                    <div class="card-body position-relative p-4">
                        <div class="fw-bold fs-2 mb-1">2</div>
                        <div class="fw-semibold">{{ __('dashboard.open_complaints') }}</div>
                        <i class="fa-solid fa-circle-exclamation position-absolute opacity-25" style="font-size: 4rem; top: 1rem; left: 1rem;"></i>
                    </div>
                    <div class="card-footer bg-dark bg-opacity-10 border-0 text-center py-2">
                        <a href="#" class="text-white text-decoration-none small fw-bold">{{ __('dashboard.view_details') }} <i class="fa-solid fa-circle-arrow-left ms-1"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Latest Orders Table -->
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="card-title fw-bold m-0"><i class="fa-solid fa-clock-rotate-left me-2 text-success"></i> {{ __('dashboard.latest_my_orders') }}</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 text-center align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>{{ __('dashboard.order_number') }}</th>
                                <th>{{ __('dashboard.date') }}</th>
                                <th>{{ __('dashboard.status') }}</th>
                                <th>{{ __('dashboard.amount') }}</th>
                            </tr>
                        </thead>
                        <tbody class="border-top-0">
                            <tr>
                                <td>1</td>
                                <td class="fw-bold text-primary">ORD-001</td>
                                <td class="english-nums">2026-02-01</td>
                                <td><span class="badge bg-success">{{ __('dashboard.completed') }}</span></td>
                                <td class="fw-bold english-nums text-success">1,500 SAR</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td class="fw-bold text-primary">ORD-002</td>
                                <td class="english-nums">2026-02-15</td>
                                <td><span class="badge bg-warning text-dark">{{ __('dashboard.in_progress') }}</span></td>
                                <td class="fw-bold english-nums text-success">3,200 SAR</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td class="fw-bold text-primary">ORD-003</td>
                                <td class="english-nums">2026-02-25</td>
                                <td><span class="badge bg-info">{{ __('dashboard.new_order') }}</span></td>
                                <td class="fw-bold english-nums text-success">800 SAR</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <!-- Sidebar side -->
    <div class="col-lg-3">
        @include('partials.user-status-sidebar')
    </div>
</div>

@include('client.products.partials.detail_modal')

@section('styles')
<style>
    .stat-card { transition: transform 0.3s ease, box-shadow 0.3s ease; }
    .stat-card:hover { transform: translateY(-5px); box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important; }
    .product-card { border-radius: 12px !important; border: 1px solid #f1f5f9 !important; box-shadow: 0 2px 10px rgba(0,0,0,0.02) !important; background: #fff; }
    .product-card:hover { box-shadow: 0 15px 40px rgba(0,0,0,0.1) !important; }
    .product-card .zoom-img { transition: transform 0.5s ease; }
    .product-card:hover .zoom-img { transform: scale(1.08); }
</style>
@endsection

@endsection
