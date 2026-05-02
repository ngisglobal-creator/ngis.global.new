@extends('factory.layouts.master')

@section('title', __('dashboard.kpi'))

@section('content')
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body">
            <div class="text-center" style="padding: 50px;">
                <i class="fa fa-chart-line fa-5x text-muted opacity-25 mb-4"></i>
                <h3 class="fw-bold">{{ __('dashboard.kpi') }}</h3>
                <p class="text-muted">{{ __('dashboard.view_performance') }}</p>
                <div class="alert alert-info d-inline-block px-4 rounded-pill">
                    <i class="fa-solid fa-info-circle me-2"></i> {{ __('dashboard.page_under_development') }}
                </div>
            </div>
        </div>
    </div>
@endsection
