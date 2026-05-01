@extends('china.layouts.master')

@section('title', 'الرئيسية | لوحة الصين')

@section('content')
<section class="content-header">
  <h1>لوحة تحكم الصين <small>مرحباً {{ Auth::user()->name ?? 'الصين' }}</small></h1>
  <ol class="breadcrumb">
    <li><a href="{{ url('china/dashboard') }}"><i class="fa fa-dashboard"></i> الرئيسية</a></li>
    <li class="active">لوحة التحكم</li>
  </ol>
</section>

<section class="content">

  <div class="row">
    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-aqua">
        <div class="inner">
          <h3>65</h3>
          <p>الموردون</p>
        </div>
        <div class="icon"><i class="fa fa-industry"></i></div>
        <a href="#" class="small-box-footer">عرض التفاصيل <i class="fa fa-arrow-circle-left"></i></a>
      </div>
    </div>
    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-red">
        <div class="inner">
          <h3>14</h3>
          <p>شحنات جارية</p>
        </div>
        <div class="icon"><i class="fa fa-ship"></i></div>
        <a href="#" class="small-box-footer">عرض التفاصيل <i class="fa fa-arrow-circle-left"></i></a>
      </div>
    </div>
    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-yellow">
        <div class="inner">
          <h3>9</h3>
          <p>طلبات استيراد</p>
        </div>
        <div class="icon"><i class="fa fa-exchange"></i></div>
        <a href="#" class="small-box-footer">عرض التفاصيل <i class="fa fa-arrow-circle-left"></i></a>
      </div>
    </div>
    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-green">
        <div class="inner">
          <h3>3.2M</h3>
          <p>قيمة الصادرات (ر.س)</p>
        </div>
        <div class="icon"><i class="fa fa-money"></i></div>
        <a href="#" class="small-box-footer">عرض التفاصيل <i class="fa fa-arrow-circle-left"></i></a>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">آخر الشحنات</h3>
        </div>
        <div class="box-body">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>#</th>
                <th>رقم الشحنة</th>
                <th>المورد</th>
                <th>المنتج</th>
                <th>تاريخ الوصول</th>
                <th>الحالة</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1</td>
                <td>SHP-2026-014</td>
                <td>Shanghai Co.</td>
                <td>إلكترونيات</td>
                <td>2026-03-10</td>
                <td><span class="label label-info">في الطريق</span></td>
              </tr>
              <tr>
                <td>2</td>
                <td>SHP-2026-013</td>
                <td>Beijing Manufacturing</td>
                <td>قطع غيار</td>
                <td>2026-02-28</td>
                <td><span class="label label-success">وصلت</span></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

</section>
@endsection
