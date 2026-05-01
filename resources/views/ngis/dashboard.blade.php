@extends('ngis.layouts.master')

@section('title', 'لوحة تحكم NGIS')

@section('content-header')
    <h1>لوحة تحكم مكتب NGIS</h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> الرئيسية</a></li>
        <li class="active">لوحة التحكم</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <!-- القسم الأول: مكتب إقليمي داخلي -->
        <div class="col-md-6">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">مكتب إقليمي داخلي</h3>
                </div>
                <div class="box-body">
                    <p>إدارة العمليات المحلية والعملاء داخل الإقليم.</p>
                    <div class="row">
                        <div class="col-sm-6">
                            <a href="{{ route('ngis.internal.clients') }}" class="btn btn-app btn-block"><i class="fa fa-users"></i> العملاء</a>
                        </div>
                        <div class="col-sm-6">
                            <a href="{{ route('ngis.internal.orders') }}" class="btn btn-app btn-block"><i class="fa fa-shopping-cart"></i> الطلبات</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- القسم الثاني: مكتب توريد دولي -->
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">مكتب توريد دولي</h3>
                </div>
                <div class="box-body">
                    <p>إدارة سلاسل الإمداد العالمية والمصانع والامتثال الدولي.</p>
                    <div class="row">
                        <div class="col-sm-6">
                            <a href="{{ route('ngis.international.factories') }}" class="btn btn-app btn-block"><i class="fa fa-industry"></i> المصانع</a>
                        </div>
                        <div class="col-sm-6">
                            <a href="{{ route('ngis.international.shipping') }}" class="btn btn-app btn-block"><i class="fa fa-globe"></i> الشحن الدولي</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-body text-center" style="padding: 40px;">
                    <i class="fa fa-building fa-5x text-muted"></i>
                    <h2>مرحباً بك في نظام إدارة NGIS</h2>
                    <p>استخدم القائمة الجانبية للوصول إلى كافة الأقسام التابعة للمكتب الإقليمي ومكتب التوريد الدولي.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
