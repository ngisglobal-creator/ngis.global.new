@extends('layouts.master')

@section('title', 'التوثيق الرقمي والوسم')

@section('content')
<section class="content-header">
  <h1>
    التوثيق الرقمي والوسم
    <small>إصدار وتتبع (Digital QR Passport)</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('global_forwarding.dashboard') }}"><i class="fa fa-dashboard"></i> لوحة التحكم</a></li>
    <li class="active">التوثيق الرقمي</li>
  </ol>
</section>

<section class="content">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">إدارة الجواز الرقمي للمنتجات والشحنات</h3>
    </div>
    <div class="box-body">
      <div class="row">
        <div class="col-md-4">
          <div class="info-box bg-aqua">
            <span class="info-box-icon"><i class="fa fa-qrcode"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">توليد الرموز الفريدة</span>
              <span class="info-box-number">QR Code لكل شحنة</span>
            </div>
          </div>
          <p class="text-muted text-center">ربط بيانات العميل والمصنع والمواصفات برقم الطلب.</p>
        </div>
        
        <div class="col-md-4">
          <div class="info-box bg-yellow">
            <span class="info-box-icon"><i class="fa fa-tags"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">إلزامية التوسيم</span>
              <span class="info-box-number">طباعة ولصق QR</span>
            </div>
          </div>
          <p class="text-muted text-center">استخدام مواد مقاومة للظروف المناخية لضمان المسح.</p>
        </div>

        <div class="col-md-4">
          <div class="info-box bg-green">
            <span class="info-box-icon"><i class="fa fa-camera"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">الأرشفة المرئية</span>
              <span class="info-box-number">صور وفيديوهات</span>
            </div>
          </div>
          <p class="text-muted text-center">رفع الفحص النهائي قبل إغلاق الحاوية كمرجع قانوني.</p>
        </div>
      </div>

      <hr>

      <div class="text-right" style="margin-bottom: 15px;">
        <button class="btn btn-primary"><i class="fa fa-qrcode"></i> توليد جواز رقمي (QR Passport) جديد</button>
      </div>

      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>QR Code</th>
            <th>رقم الشحنة/الطلب</th>
            <th>تاريخ الإصدار</th>
            <th>حالة التوسيم</th>
            <th>الأرشفة المرئية</th>
            <th>الإجراءات</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td colspan="6" class="text-center">لا توجد جوازات رقمية حالياً</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</section>
@endsection
