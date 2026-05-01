@extends('layouts.master')

@section('title', 'لوحة التحكم - الرئيسية')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    لوحة التحكم
    <small>الإحصائيات العامة</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> الرئيسية</a></li>
    <li class="active">لوحة التحكم</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <!-- Small boxes (Stat box) -->
  <div class="row">
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-aqua">
        <div class="inner">
          <h3>{{ $stats['users'] }}</h3>
          <p>إجمالي المستخدمين</p>
        </div>
        <div class="icon">
          <i class="fa fa-users"></i>
        </div>
        <a href="{{ route('admin.users.index') }}" class="small-box-footer">المزيد من التفاصيل <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-green">
        <div class="inner">
          <h3>{{ $stats['admins'] }}</h3>
          <p>المدراء</p>
        </div>
        <div class="icon">
          <i class="fa fa-user-secret"></i>
        </div>
        <a href="#" class="small-box-footer">المزيد من التفاصيل <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
  </div>
  <!-- /.row -->

  <div class="row">
    <div class="col-md-12">
      <div class="box box-info">
        <div class="box-header with-border">
          <h3 class="box-title">أهلاً بك في لوحة تحكم الإدارة</h3>
        </div>
        <div class="box-body">
          <p>من هنا يمكنك إدارة جميع جوانب النظام، بما في ذلك المستخدمين، الأدوار، والصلاحيات، وإعدادات الموقع العامة.</p>
        </div>
      </div>
    </div>
  </div>

</section>
<!-- /.content -->
@endsection
