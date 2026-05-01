@extends('layouts.master')

@section('title', 'الربط اللوجستي الإقليمي')

@section('content')
<section class="content-header">
  <h1>
    الربط اللوجستي
    <small>التكامل مع المكاتب الإقليمية (Regional Integration Bridge)</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('global_forwarding.dashboard') }}"><i class="fa fa-dashboard"></i> لوحة التحكم</a></li>
    <li class="active">الربط اللوجستي</li>
  </ol>
</section>

<section class="content">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">جسر التكامل الإلكتروني ونظام التنبيهات</h3>
    </div>
    <div class="box-body">
      
      <div class="row">
        <div class="col-md-6">
          <div class="callout callout-info">
            <h4><i class="fa fa-bell"></i> نظام التنبيهات المبكرة</h4>
            <p>بمجرد إغلاق الحاوية في نقطة الانطلاق، يتم إرسال جميع الوثائق والإشعارات فوراً إلى شركات الشحن المحلية والمكاتب الإقليمية المعنية للاستعداد للاستلام.</p>
          </div>
        </div>
        <div class="col-md-6">
          <div class="callout callout-success">
            <h4><i class="fa fa-plug"></i> التكامل الإلكتروني</h4>
            <p>ربط مباشر ولحظي مع لوحات التحكم الخاصة بالمكاتب الإقليمية (Regional Dashboards) لضمان الشفافية الكاملة وتحديث حالات الشحن (Live Tracking).</p>
          </div>
        </div>
      </div>

      <hr>
      <h4>سجل الإشعارات ونقل البيانات</h4>
      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>رقم الحاوية / الشحنة</th>
            <th>المكتب الإقليمي المستهدف</th>
            <th>وقت إغلاق الحاوية</th>
            <th>حالة نقل الوثائق</th>
            <th>استجابة المكتب الإقليمي</th>
            <th>الإجراءات</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td colspan="6" class="text-center">لا توجد عمليات ربط نشطة حالياً</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</section>
@endsection
