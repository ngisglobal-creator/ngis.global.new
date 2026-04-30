@extends('layouts.master')

@section('title', 'المسؤولية وإدارة المخاطر')

@section('content')
<section class="content-header">
  <h1>
    إدارة المخاطر
    <small>المطابقة، النزاعات، والتعويضات (Liability & Risk Control)</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('global_forwarding.dashboard') }}"><i class="fa fa-dashboard"></i> لوحة التحكم</a></li>
    <li class="active">المخاطر والنزاعات</li>
  </ol>
</section>

<section class="content">
  <div class="box box-danger">
    <div class="box-header with-border">
      <h3 class="box-title">لوحة التحكم بالمسؤولية القانونية والتشغيلية</h3>
    </div>
    <div class="box-body">
      
      <div class="row" style="margin-bottom: 20px;">
        <div class="col-md-4">
          <div class="info-box bg-red">
            <span class="info-box-icon"><i class="fa fa-balance-scale"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">مسؤولية المطابقة</span>
              <span class="info-box-number">الالتزام بالمواصفات</span>
            </div>
          </div>
          <p class="text-muted">تحمل المسؤولية المادية والقانونية عند أي مخالفة للمواصفات المتفق عليها مع العميل.</p>
        </div>
        
        <div class="col-md-4">
          <div class="info-box bg-yellow">
            <span class="info-box-icon"><i class="fa fa-comments-o"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">إدارة النزاعات</span>
              <span class="info-box-number">تسوية المطالبات</span>
            </div>
          </div>
          <p class="text-muted">نظام متكامل لتسوية المطالبات وفض النزاعات بين العميل والموردين.</p>
        </div>

        <div class="col-md-4">
          <div class="info-box bg-green">
            <span class="info-box-icon"><i class="fa fa-money"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">نظام التعويضات</span>
              <span class="info-box-number">إعادة شحن / تعويض</span>
            </div>
          </div>
          <p class="text-muted">إعادة الشحن للمنتجات المعيبة أو تقديم تعويض فوري في حال الأخطاء التشغيلية.</p>
        </div>
      </div>

      <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">النزاعات المفتوحة</a></li>
          <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false">التعويضات المدفوعة</a></li>
        </ul>
        <div class="tab-content">
          <div class="tab-pane active" id="tab_1">
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>رقم التذكرة</th>
                  <th>رقم الطلب</th>
                  <th>العميل</th>
                  <th>سبب النزاع (مخالفة مواصفات/تأخير)</th>
                  <th>المبلغ المتنازع عليه</th>
                  <th>حالة التذكرة</th>
                  <th>الإجراءات</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td colspan="7" class="text-center">لا توجد نزاعات مفتوحة حالياً</td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="tab-pane" id="tab_2">
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>رقم التعويض</th>
                  <th>رقم الطلب</th>
                  <th>طبيعة التعويض (نقدي/إعادة شحن)</th>
                  <th>العميل المستفيد</th>
                  <th>تاريخ التنفيذ</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td colspan="5" class="text-center">لا توجد تعويضات سابقة</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>
@endsection
