@extends('company.layouts.master')

@section('title', 'الرئيسية | لوحة الشركة')

@section('content')
<section class="content-header">
  <h1>لوحة تحكم الشركة <small>مرحباً {{ Auth::user()->name ?? 'شركة' }}</small></h1>
  <ol class="breadcrumb">
    <li><a href="{{ url('company/dashboard') }}"><i class="fa fa-dashboard"></i> الرئيسية</a></li>
    <li class="active">لوحة التحكم</li>
  </ol>
</section>

<section class="content">

  <div class="row">
    <div class="col-md-9">
      
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-purple">
            <div class="inner">
              <h3>48</h3>
              <p>إجمالي الطلبات</p>
            </div>
            <div class="icon"><i class="fa fa-shopping-cart"></i></div>
            <a href="#" class="small-box-footer">عرض التفاصيل <i class="fa fa-arrow-circle-left"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>15</h3>
              <p>الموظفون</p>
            </div>
            <div class="icon"><i class="fa fa-users"></i></div>
            <a href="#" class="small-box-footer">عرض التفاصيل <i class="fa fa-arrow-circle-left"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>7</h3>
              <p>عقود نشطة</p>
            </div>
            <div class="icon"><i class="fa fa-file-text-o"></i></div>
            <a href="#" class="small-box-footer">عرض التفاصيل <i class="fa fa-arrow-circle-left"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-green">
            <div class="inner">
              <h3>125,000</h3>
              <p>الإيرادات الشهرية</p>
            </div>
            <div class="icon"><i class="fa fa-money"></i></div>
            <a href="#" class="small-box-footer">عرض التفاصيل <i class="fa fa-arrow-circle-left"></i></a>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">آخر العقود والطلبات</h3>
            </div>
            <div class="box-body">
              <table class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>رقم العقد</th>
                    <th>الطرف الثاني</th>
                    <th>تاريخ الانتهاء</th>
                    <th>الحالة</th>
                    <th>القيمة</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>1</td>
                    <td>CTR-2026-001</td>
                    <td>مصنع الأمل</td>
                    <td>2026-12-31</td>
                    <td><span class="label label-success">ساري</span></td>
                    <td>500,000 ر.س</td>
                  </tr>
                  <tr>
                    <td>2</td>
                    <td>CTR-2026-002</td>
                    <td>شركة النور</td>
                    <td>2026-06-30</td>
                    <td><span class="label label-warning">قيد التجديد</span></td>
                    <td>250,000 ر.س</td>
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
@endsection
