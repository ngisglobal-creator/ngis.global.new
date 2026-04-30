@extends('layouts.master')

@section('title', 'لوحة تحكم شركة الشحن الدولية')

@section('content')
<section class="content-header">
  <h1>
    شركة الشحن الدولية
    <small>لوحة التحكم والإحصائيات (Global Forwarding & Procurement Hub)</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> الرئيسية</a></li>
    <li class="active">لوحة التحكم</li>
  </ol>
</section>

<section class="content">
  <!-- Info boxes -->
  <div class="row">
    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-aqua"><i class="fa fa-ship"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">طلبات عامة</span>
          <span class="info-box-number">0</span>
        </div>
      </div>
    </div>
    
    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-red"><i class="fa fa-search"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">طلبات Sourcing خاصة</span>
          <span class="info-box-number">0</span>
        </div>
      </div>
    </div>

    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-green"><i class="fa fa-qrcode"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">QR Passports مُصدرة</span>
          <span class="info-box-number">0</span>
        </div>
      </div>
    </div>

    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-yellow"><i class="fa fa-exclamation-triangle"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">نزاعات ومطالبات نشطة</span>
          <span class="info-box-number">0</span>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">الأقسام الرئيسية</h3>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-4">
              <a href="{{ route('global_forwarding.orders.standard') }}" class="btn btn-app" style="width:100%; height:auto; padding:15px;">
                <i class="fa fa-box" style="font-size:30px; margin-bottom:10px;"></i>
                <h4>مسار الطلبات العامة</h4>
                <p class="text-muted">استقبال الطلبات الموثقة وإصدار بوالص الشحن</p>
              </a>
            </div>
            <div class="col-md-4">
              <a href="{{ route('global_forwarding.orders.custom') }}" class="btn btn-app" style="width:100%; height:auto; padding:15px;">
                <i class="fa fa-search-plus" style="font-size:30px; margin-bottom:10px;"></i>
                <h4>مسار الطلبات الخاصة</h4>
                <p class="text-muted">البحث الميداني ومطابقة المصادر (Custom Sourcing)</p>
              </a>
            </div>
            <div class="col-md-4">
              <a href="{{ route('global_forwarding.qr_passport') }}" class="btn btn-app" style="width:100%; height:auto; padding:15px;">
                <i class="fa fa-qrcode" style="font-size:30px; margin-bottom:10px;"></i>
                <h4>التوثيق الرقمي والوسم</h4>
                <p class="text-muted">إصدار QR Code والأرشفة المرئية</p>
              </a>
            </div>
          </div>
          
          <div class="row" style="margin-top: 15px;">
            <div class="col-md-4">
              <a href="{{ route('global_forwarding.orders.matched_products') }}" class="btn btn-app" style="width:100%; height:auto; padding:15px; border: 2px solid #3c8dbc; background: #f0f7ff;">
                <i class="fa fa-check-square-o text-primary" style="font-size:30px; margin-bottom:10px;"></i>
                <h4>المنتجات المطابقة</h4>
                <p class="text-muted">عرض جميع المنتجات التي تم مطابقتها ورفع بياناتها اللوجستية</p>
              </a>
            </div>
            <div class="col-md-4">
              <a href="{{ route('global_forwarding.insurance') }}" class="btn btn-app" style="width:100%; height:auto; padding:15px;">
                <i class="fa fa-shield" style="font-size:30px; margin-bottom:10px;"></i>
                <h4>التأمين والامتثال</h4>
                <p class="text-muted">بوليصة التأمين الإلزامية وربط الوثائق</p>
              </a>
            </div>
            <div class="col-md-4">
              <a href="{{ route('global_forwarding.liability_risk') }}" class="btn btn-app" style="width:100%; height:auto; padding:15px;">
                <i class="fa fa-balance-scale" style="font-size:30px; margin-bottom:10px;"></i>
                <h4>المسؤولية وإدارة المخاطر</h4>
                <p class="text-muted">إدارة النزاعات والمطالبات والتعويضات</p>
              </a>
            </div>
          </div>

          <div class="row" style="margin-top: 15px;">
            <div class="col-md-4 col-md-offset-4">
              <a href="{{ route('global_forwarding.regional_integration') }}" class="btn btn-app" style="width:100%; height:auto; padding:15px;">
                <i class="fa fa-link" style="font-size:30px; margin-bottom:10px;"></i>
                <h4>الربط اللوجستي الإقليمي</h4>
                <p class="text-muted">نظام التنبيهات المبكرة والتكامل الإلكتروني</p>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
