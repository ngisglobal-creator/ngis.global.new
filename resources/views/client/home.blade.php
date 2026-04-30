@extends('client.layouts.master')

@php
    $dashboardTitle = 'لوحة تحكم العميل';
    if(Auth::user()->type === 'merchant') {
        $dashboardTitle = 'لوحة تحكم التاجر';
    } elseif(Auth::user()->type === 'company_owner') {
        $dashboardTitle = 'لوحة تحكم صاحب الشركة';
    }
@endphp

@section('title', 'الرئيسية | ' . $dashboardTitle)

@section('content')
<section class="content-header">
  <h1>{{ $dashboardTitle }} <small>مرحباً {{ Auth::user()->name ?? 'عميل' }}</small></h1>
  <ol class="breadcrumb">
    <li><a href="{{ url('client/dashboard') }}"><i class="fa fa-dashboard"></i> الرئيسية</a></li>
    <li class="active">{{ $dashboardTitle }}</li>
  </ol>
</section>

<section class="content">

  <div class="row">
    <div class="col-md-9">
      
      <!-- المنتجات المقترحة (نقلت للأعلى) -->
      @if($suggestedProducts->count() > 0)
      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary" style="border-top-color: #3c8dbc; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
            <div class="box-header with-border" style="padding: 15px;">
              <h3 class="box-title" style="font-weight: bold; color: #3c8dbc; font-size: 20px;">
                <i class="fa fa-star text-yellow"></i> منتجات مقترحة لك بناءً على اهتماماتك
              </h3>
            </div>
            <div class="box-body" style="background: #fdfdfd; padding: 20px;">
                <div class="row">
                    @foreach($suggestedProducts as $product)
                        <div class="col-md-4 col-sm-6">
                            @include('client.products.partials.product_card', ['product' => $product, 'isRecommended' => true])
                        </div>
                    @endforeach
                </div>
            </div>
          </div>
        </div>
      </div>
      @endif

      <!-- إحصائيات سريعة -->
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-green">
            <div class="inner">
              <h3>12</h3>
              <p>طلباتي النشطة</p>
            </div>
            <div class="icon"><i class="fa fa-shopping-cart"></i></div>
            <a href="#" class="small-box-footer">عرض التفاصيل <i class="fa fa-arrow-circle-left"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>5</h3>
              <p>فواتير معلقة</p>
            </div>
            <div class="icon"><i class="fa fa-file-text"></i></div>
            <a href="#" class="small-box-footer">عرض التفاصيل <i class="fa fa-arrow-circle-left"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>3</h3>
              <p>رسائل جديدة</p>
            </div>
            <div class="icon"><i class="fa fa-envelope"></i></div>
            <a href="#" class="small-box-footer">عرض التفاصيل <i class="fa fa-arrow-circle-left"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-red">
            <div class="inner">
              <h3>2</h3>
              <p>شكاوى مفتوحة</p>
            </div>
            <div class="icon"><i class="fa fa-exclamation-circle"></i></div>
            <a href="#" class="small-box-footer">عرض التفاصيل <i class="fa fa-arrow-circle-left"></i></a>
          </div>
        </div>
      </div>

      <!-- جدول الطلبات الأخيرة -->
      <div class="row">
        <div class="col-md-12">
          <div class="box box-green">
            <div class="box-header with-border">
              <h3 class="box-title">آخر الطلبات</h3>
            </div>
            <div class="box-body">
              <table class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>رقم الطلب</th>
                    <th>التاريخ</th>
                    <th>الحالة</th>
                    <th>المبلغ</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>1</td>
                    <td>ORD-001</td>
                    <td>2026-02-01</td>
                    <td><span class="label label-success">مكتمل</span></td>
                    <td>1,500 ر.س</td>
                  </tr>
                  <tr>
                    <td>2</td>
                    <td>ORD-002</td>
                    <td>2026-02-15</td>
                    <td><span class="label label-warning">قيد التنفيذ</span></td>
                    <td>3,200 ر.س</td>
                  </tr>
                  <tr>
                    <td>3</td>
                    <td>ORD-003</td>
                    <td>2026-02-25</td>
                    <td><span class="label label-info">جديد</span></td>
                    <td>800 ر.س</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

    </div>

    <!-- Sidebar side -->
    <div class="col-md-3">
        @include('partials.user-status-sidebar')
    </div>
  </div>

</section>

@include('client.products.partials.detail_modal')

@push('scripts')
<style>
    /* Dashboard Specific Premium Overrides */
    .small-box {
        border-radius: 15px !important;
        overflow: hidden;
        border: none !important;
        box-shadow: 0 8px 20px rgba(0,0,0,0.08) !important;
        transition: all 0.3s ease;
    }
    .small-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 30px rgba(0,0,0,0.12) !important;
    }
    .small-box .inner h3 {
        font-weight: 900;
        font-size: 32px;
    }
    .small-box .icon {
        top: 10px;
        right: 15px;
        font-size: 70px;
        opacity: 0.15;
    }
    .small-box-footer {
        background: rgba(0,0,0,0.05) !important;
        padding: 8px !important;
        font-weight: 700 !important;
        text-transform: uppercase;
        font-size: 11px !important;
        letter-spacing: 0.5px;
    }
    
    /* Gradients for stats */
    .bg-green { background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%) !important; }
    .bg-aqua { background: linear-gradient(135deg, #17a2b8 0%, #117a8b 100%) !important; }
    .bg-yellow { background: linear-gradient(135deg, #ffc107 0%, #d39e00 100%) !important; }
    .bg-red { background: linear-gradient(135deg, #dc3545 0%, #bd2130 100%) !important; }

    /* Product Card Polish */
    .product-card {
        border-radius: 12px !important;
        border: 1px solid #f1f5f9 !important;
        box-shadow: 0 2px 10px rgba(0,0,0,0.02) !important;
    }
    .product-card:hover {
        box-shadow: 0 15px 40px rgba(0,0,0,0.1) !important;
    }
    .product-card .zoom-img {
        transition: transform 0.5s ease;
    }
    .product-card:hover .zoom-img {
        transform: scale(1.08);
    }
</style>
@endpush

@endsection
