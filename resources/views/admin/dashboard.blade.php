@extends('layouts.master')

@section('title', __('dashboard.dashboard') . ' | ' . __('dashboard.admin_panel'))

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold m-0 text-dark">{{ __('dashboard.dashboard_title') }} <span class="text-muted fs-6 fw-normal ms-2">{{ __('dashboard.dashboard_subtitle') }}</span></h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="#" class="text-decoration-none"><i class="fa-solid fa-house me-1"></i>{{ __('dashboard.home') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('dashboard.breadcrumb_dashboard') }}</li>
        </ol>
    </nav>
</div>

<div class="row g-4">
    <!-- Stat Cards -->
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 bg-primary text-white h-100 stat-card">
            <div class="card-body p-4 position-relative overflow-hidden">
                <div class="fs-2 fw-bold mb-1 english-nums">{{ $stats['users'] }}</div>
                <div class="fw-semibold">{{ __('dashboard.total_users') }}</div>
                <i class="fa-solid fa-users position-absolute opacity-25" style="font-size: 4rem; top: 1rem; left: 1rem;"></i>
            </div>
            <div class="card-footer bg-dark bg-opacity-10 border-0 text-center py-2">
                <a href="{{ route('admin.users.index') }}" class="text-white text-decoration-none small fw-bold">{{ __('dashboard.manage_users') }} <i class="fa-solid fa-circle-arrow-left ms-1"></i></a>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 bg-success text-white h-100 stat-card">
            <div class="card-body p-4 position-relative overflow-hidden">
                <div class="fs-2 fw-bold mb-1 english-nums">{{ $stats['admins'] }}</div>
                <div class="fw-semibold">{{ __('dashboard.admins') }}</div>
                <i class="fa-solid fa-user-shield position-absolute opacity-25" style="font-size: 4rem; top: 1rem; left: 1rem;"></i>
            </div>
            <div class="card-footer bg-dark bg-opacity-10 border-0 text-center py-2">
                <a href="#" class="text-white text-decoration-none small fw-bold">{{ __('dashboard.view_list') }} <i class="fa-solid fa-circle-arrow-left ms-1"></i></a>
            </div>
        </div>
    </div>

    <!-- Info Box -->
    <div class="col-md-6">
        <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
            <div class="card-body p-4 d-flex align-items-center">
                <div class="flex-shrink-0 bg-light p-3 rounded-4 me-4">
                    <i class="fa-solid fa-info-circle text-primary fs-1"></i>
                </div>
                <div>
                    <h5 class="fw-bold mb-2">{{ __('dashboard.welcome_admin') }}</h5>
                    <p class="text-muted mb-0">{{ __('dashboard.welcome_admin_desc') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

@section('styles')
<style>
    .stat-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
    }
</style>
@endsection
@endsection
