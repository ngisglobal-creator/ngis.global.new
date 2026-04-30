@extends('layouts.master')

@section('title', 'مسار الطلبات العامة')

@section('content')
<section class="content-header">
  <h1>
    الطلبات العامة
    <small>استقبال الطلبات وإصدار بوالص الشحن (Standard Orders)</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('global_forwarding.dashboard') }}"><i class="fa fa-dashboard"></i> لوحة التحكم</a></li>
    <li class="active">الطلبات العامة</li>
  </ol>
</section>

<section class="content">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">إدارة مسار الطلبات الموثقة آلياً</h3>
    </div>
    <div class="box-body">
      <p class="text-muted">هنا يتم استقبال الطلبات القادمة من المكاتب الإقليمية والمنصة.</p>
      
      <div class="row" style="margin-top:20px;">
        <div class="col-md-4">
          <div class="info-box bg-blue">
            <span class="info-box-icon"><i class="fa fa-search"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">الفحص الظاهري</span>
              <span class="info-box-number">توثيق الحاويات والتعبئة</span>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="info-box bg-green">
            <span class="info-box-icon"><i class="fa fa-file-text-o"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">بوالص الشحن</span>
              <span class="info-box-number">إصدار الوثائق الدولية</span>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="info-box bg-yellow">
            <span class="info-box-icon"><i class="fa fa-map-marker"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">التتبع المركزي</span>
              <span class="info-box-number">تفعيل نظام التتبع</span>
            </div>
          </div>
        </div>
      </div>

      <table class="table table-bordered table-striped" style="margin-top: 20px;">
        <thead>
          <tr>
            <th>رقم الطلب</th>
            <th>العميل / المكتب الإقليمي</th>
            <th>حالة الفحص والتعبئة</th>
            <th>بوليصة الشحن</th>
            <th>التتبع</th>
            <th>الإجراءات</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td colspan="6" class="text-center">لا توجد طلبات عامة حالياً</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</section>
@endsection
