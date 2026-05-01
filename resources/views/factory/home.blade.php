@extends('factory.layouts.master')

@section('title', 'الرئيسية | لوحة المصنع')

@section('content')
<section class="content-header">
  <h1>لوحة تحكم المصنع <small>مرحباً {{ Auth::user()->name ?? 'مصنع' }}</small></h1>
  <ol class="breadcrumb">
    <li><a href="{{ url('factory/dashboard') }}"><i class="fa fa-dashboard"></i> الرئيسية</a></li>
    <li class="active">لوحة التحكم</li>
  </ol>
</section>

<section class="content">

  <div class="row">
    <div class="col-md-9">
      
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-red">
            <div class="inner">
              <h3>320</h3>
              <p>المنتجات المصنعة اليوم</p>
            </div>
            <div class="icon"><i class="fa fa-cubes"></i></div>
            <a href="#" class="small-box-footer">عرض التفاصيل <i class="fa fa-arrow-circle-left"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>18</h3>
              <p>طلبيات جارية</p>
            </div>
            <div class="icon"><i class="fa fa-shopping-cart"></i></div>
            <a href="#" class="small-box-footer">عرض التفاصيل <i class="fa fa-arrow-circle-left"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>5</h3>
              <p>خطوط إنتاج نشطة</p>
            </div>
            <div class="icon"><i class="fa fa-cogs"></i></div>
            <a href="#" class="small-box-footer">عرض التفاصيل <i class="fa fa-arrow-circle-left"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-green">
            <div class="inner">
              <h3>98%</h3>
              <p>كفاءة الإنتاج</p>
            </div>
            <div class="icon"><i class="fa fa-bar-chart"></i></div>
            <a href="#" class="small-box-footer">عرض التفاصيل <i class="fa fa-arrow-circle-left"></i></a>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">آخر الطلبيات</h3>
            </div>
            <div class="box-body">
              <table class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>رقم الطلبية</th>
                    <th>العميل</th>
                    <th>المنتج</th>
                    <th>الكمية</th>
                    <th>الحالة</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>1</td>
                    <td>ORD-F-001</td>
                    <td>شركة الفجر</td>
                    <td>قضبان حديد</td>
                    <td>500 طن</td>
                    <td><span class="label label-success">منجز</span></td>
                  </tr>
                  <tr>
                    <td>2</td>
                    <td>ORD-F-002</td>
                    <td>مكتب الجنوب</td>
                    <td>ألمنيوم</td>
                    <td>200 طن</td>
                    <td><span class="label label-warning">قيد الإنتاج</span></td>
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
