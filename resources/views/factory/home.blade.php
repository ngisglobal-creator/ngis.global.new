@extends('factory.layouts.master')

@section('title', __('dashboard.home') . ' | ' . __('dashboard.factory_panel'))

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold m-0 text-dark">{{ __('dashboard.factory_panel') }} <span class="text-muted fs-6 fw-normal ms-2">{{ __('dashboard.welcome') }} {{ Auth::user()->name ?? '' }}</span></h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ url('factory/dashboard') }}" class="text-decoration-none"><i class="fa-solid fa-house me-1"></i>{{ __('dashboard.home') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('dashboard.breadcrumb_dashboard') }}</li>
        </ol>
    </nav>
</div>

<div class="row g-4">
    <div class="col-lg-9">
        
        <!-- Quick Stats -->
        <div class="row g-3 mb-4">
            <div class="col-sm-6 col-md-3">
                <div class="card border-0 shadow-sm rounded-4 bg-primary text-white overflow-hidden h-100 stat-card">
                    <div class="card-body position-relative p-4">
                        <div class="fw-bold fs-2 mb-1">320</div>
                        <div class="fw-semibold">{{ __('dashboard.todays_products') }}</div>
                        <i class="fa-solid fa-cubes position-absolute opacity-25" style="font-size: 4rem; top: 1rem; left: 1rem;"></i>
                    </div>
                    <div class="card-footer bg-dark bg-opacity-10 border-0 text-center py-2">
                        <a href="#" class="text-white text-decoration-none small fw-bold">{{ __('dashboard.view_details') }} <i class="fa-solid fa-circle-arrow-left ms-1"></i></a>
                    </div>
                </div>
            </div>
            
            <div class="col-sm-6 col-md-3">
                <div class="card border-0 shadow-sm rounded-4 bg-info text-white overflow-hidden h-100 stat-card">
                    <div class="card-body position-relative p-4">
                        <div class="fw-bold fs-2 mb-1">18</div>
                        <div class="fw-semibold">{{ __('dashboard.active_orders') }}</div>
                        <i class="fa-solid fa-shopping-cart position-absolute opacity-25" style="font-size: 4rem; top: 1rem; left: 1rem;"></i>
                    </div>
                    <div class="card-footer bg-dark bg-opacity-10 border-0 text-center py-2">
                        <a href="#" class="text-white text-decoration-none small fw-bold">{{ __('dashboard.view_details') }} <i class="fa-solid fa-circle-arrow-left ms-1"></i></a>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-3">
                <div class="card border-0 shadow-sm rounded-4 bg-warning text-dark overflow-hidden h-100 stat-card">
                    <div class="card-body position-relative p-4">
                        <div class="fw-bold fs-2 mb-1">5</div>
                        <div class="fw-semibold">{{ __('dashboard.production_lines') }}</div>
                        <i class="fa-solid fa-gears position-absolute opacity-25" style="font-size: 4rem; top: 1rem; left: 1rem;"></i>
                    </div>
                    <div class="card-footer bg-dark bg-opacity-10 border-0 text-center py-2">
                        <a href="#" class="text-dark text-decoration-none small fw-bold">{{ __('dashboard.view_details') }} <i class="fa-solid fa-circle-arrow-left ms-1"></i></a>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-3">
                <div class="card border-0 shadow-sm rounded-4 bg-success text-white overflow-hidden h-100 stat-card">
                    <div class="card-body position-relative p-4">
                        <div class="fw-bold fs-2 mb-1">98%</div>
                        <div class="fw-semibold">{{ __('dashboard.production_efficiency') }}</div>
                        <i class="fa-solid fa-chart-line position-absolute opacity-25" style="font-size: 4rem; top: 1rem; left: 1rem;"></i>
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
                <h5 class="card-title fw-bold m-0"><i class="fa-solid fa-clock-rotate-left me-2 text-primary"></i> {{ __('dashboard.latest_orders') }}</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 text-center align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>{{ __('dashboard.order_number') }}</th>
                                <th>{{ __('dashboard.client') }}</th>
                                <th>{{ __('dashboard.product') }}</th>
                                <th>{{ __('dashboard.quantity') }}</th>
                                <th>{{ __('dashboard.status') }}</th>
                            </tr>
                        </thead>
                        <tbody class="border-top-0">
                            <tr>
                                <td>1</td>
                                <td class="fw-bold text-primary">ORD-F-001</td>
                                <td>Al-Fajr Company</td>
                                <td>Steel Rods</td>
                                <td class="english-nums">500 T</td>
                                <td><span class="badge bg-success">{{ __('dashboard.completed') }}</span></td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td class="fw-bold text-primary">ORD-F-002</td>
                                <td>South Office</td>
                                <td>Aluminum</td>
                                <td class="english-nums">200 T</td>
                                <td><span class="badge bg-warning text-dark">{{ __('dashboard.in_production') }}</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <div class="col-lg-3">
        @include('partials.user-status-sidebar')
    </div>
</div>

@section('styles')
<style>
    .stat-card { transition: transform 0.3s ease, box-shadow 0.3s ease; }
    .stat-card:hover { transform: translateY(-5px); box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important; }
</style>
@endsection
@endsection
