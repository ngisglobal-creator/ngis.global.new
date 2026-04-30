@extends('layouts.master')

@section('title', 'التأمين والامتثال')

@section('content')
<section class="content-header">
  <h1>
    التأمين والامتثال
    <small>الربط الرقمي للوثائق (Insurance & Compliance)</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('global_forwarding.dashboard') }}"><i class="fa fa-dashboard"></i> لوحة التحكم</a></li>
    <li class="active">التأمين والامتثال</li>
  </ol>
</section>

<section class="content">
  <div class="box box-warning">
    <div class="box-header with-border">
      <h3 class="box-title">إدارة بوالص التأمين والوثائق الإلزامية</h3>
    </div>
    <div class="box-body">
      
      <div class="row">
        <div class="col-md-6">
          <div class="callout callout-warning">
            <h4><i class="fa fa-shield"></i> بوليصة التأمين الإلزامية</h4>
            <p>إصدار Cargo Insurance كشرط أساسي لتفعيل عملية الشحن. لا يمكن شحن أي بضائع بدون هذه الوثيقة.</p>
          </div>
        </div>
        <div class="col-md-6">
          <div class="callout callout-success">
            <h4><i class="fa fa-link"></i> الربط الرقمي للوثائق</h4>
            <p>دمج بوليصة التأمين، بوليصة الشحن، وشهادات المنشأ (Certificate of Origin) رقمياً داخل الـ QR Code الخاص بالشحنة.</p>
          </div>
        </div>
      </div>

      <hr>

      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>رقم الطلب / الشحنة</th>
            <th>بوليصة التأمين (Cargo Insurance)</th>
            <th>بوليصة الشحن (BL)</th>
            <th>شهادة المنشأ (CO)</th>
            <th>الربط بالـ QR</th>
            <th>حالة الامتثال</th>
            <th>الإجراءات</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td colspan="7" class="text-center">لا توجد سجلات امتثال حالياً</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</section>
@endsection
