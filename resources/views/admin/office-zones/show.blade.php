@extends('layouts.master')

@section('title', 'تفاصيل نطاق مكتب: ' . $user->name)

@section('content')
<section class="content-header">
    <h1>تفاصيل نطاق عمل المكتب الإقليمي <small>عرض النطاق والدول التابعة</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> الرئيسية</a></li>
        <li><a href="{{ route('admin.office-zones.index') }}">إدارة نطاقات المكاتب</a></li>
        <li class="active">التفاصيل</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <!-- Dashboard Summary -->
        <div class="col-md-4">
            <!-- User Info Card -->
            <div class="box box-widget widget-user" style="border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.1);">
                <div class="widget-user-header bg-aqua-active" style="background: linear-gradient(135deg, #3c8dbc 0%, #00c0ef 100%); padding: 30px 20px; height: 120px;">
                    <h3 class="widget-user-username" style="font-weight: bold;">{{ $user->name }}</h3>
                    <h5 class="widget-user-desc">مكتب إقليمي</h5>
                </div>
                <div class="widget-user-image" style="top: 80px;">
                    <img class="img-circle" src="{{ $user->avatar_url }}" alt="User Avatar" style="width: 90px; height: 90px; border: 3px solid #fff;">
                </div>
                <div class="box-footer" style="padding-top: 60px; background: #fff;">
                    <div class="row">
                        <div class="col-sm-6 border-right">
                            <div class="description-block">
                                <h5 class="description-header">{{ $user->geographicZone ? $user->geographicZone->countries->count() : 0 }}</h5>
                                <span class="description-text">عدد الدول</span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="description-block">
                                <h5 class="description-header">{{ $user->country ? $user->country->name_ar : '-' }}</h5>
                                <span class="description-text">دولة المقر</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact/Details Box -->
            <div class="box box-primary" style="margin-top: 20px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
                <div class="box-header with-border">
                    <h3 class="box-title">معلومات التواصل</h3>
                </div>
                <div class="box-body">
                    <strong><i class="fa fa-envelope margin-r-5"></i> البريد الإلكتروني</strong>
                    <p class="text-muted">{{ $user->email }}</p>
                    <hr>
                    <strong><i class="fa fa-phone margin-r-5"></i> رقم الهاتف</strong>
                    <p class="text-muted">{{ $user->phone ?? 'غير متوفر' }}</p>
                    <hr>
                    <strong><i class="fa fa-map-marker margin-r-5"></i> النطاق المعين</strong>
                    <p>
                        <span class="label label-success" style="font-size: 14px; padding: 5px 15px;">
                            {{ $user->geographicZone ? $user->geographicZone->name_ar : 'لم يتم التعيين' }}
                        </span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Zone Countries List -->
        <div class="col-md-8">
            <div class="box box-solid" style="border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
                <div class="box-header" style="background: #fafafa; border-bottom: 1px solid #eee; padding: 20px;">
                    <div style="display: flex; align-items: center; gap: 20px;">
                        @if($user->geographicZone && $user->geographicZone->image)
                            <img src="{{ Str::startsWith($user->geographicZone->image, 'vendor/') ? asset($user->geographicZone->image) : Storage::url($user->geographicZone->image) }}" style="width: 120px; height: 80px; border-radius: 8px; object-fit: cover; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
                        @endif
                        <div>
                            <h3 class="box-title" style="font-size: 24px; font-weight: bold; color: #333;">نطاق العمل: {{ $user->geographicZone ? $user->geographicZone->name_ar : '-' }}</h3>
                            <p class="text-muted" style="margin-top: 5px;">قائمة الدول التابعة لهذا النطاق الجغرافي للمكتب</p>
                        </div>
                    </div>
                </div>
                <div class="box-body" style="padding: 25px;">
                    <div class="row">
                        @if($user->geographicZone)
                            @foreach($user->geographicZone->countries as $country)
                            <div class="col-sm-6 col-md-4">
                                <div style="display: flex; align-items: center; background: #fff; border: 1px solid #eee; border-radius: 8px; padding: 12px; margin-bottom: 15px; transition: all 0.2s;">
                                    <div style="width: 45px; height: 35px; margin-left: 12px; border: 1px solid #f0f0f0; border-radius: 3px; overflow: hidden;">
                                        <img src="{{ asset('vendor/flag-icons/flags/4x3/' . $country->flag_code . '.svg') }}" style="width: 100%; height: 100%; object-fit: cover;">
                                    </div>
                                    <div style="flex: 1;">
                                        <h5 style="margin: 0; font-weight: bold; color: #444;">{{ $country->name_ar }}</h5>
                                        <small class="text-muted" style="direction: ltr; display: inline-block;">{{ $country->name_en }}</small>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <div class="col-xs-12 text-center" style="padding: 50px;">
                                <i class="fa fa-map-o fa-3x text-muted"></i>
                                <p class="text-muted" style="margin-top: 15px;">لا يوجد نطاق معين لهذا المكتب حالياً</p>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="box-footer" style="background: #fdfdfd; padding: 20px;">
                    <a href="{{ route('admin.office-zones.assign', $user) }}" class="btn btn-primary btn-flat" style="border-radius: 6px;">
                        <i class="fa fa-edit"></i> تعديل النطاق
                    </a>
                    <a href="{{ route('admin.office-zones.index') }}" class="btn btn-default btn-flat pull-left" style="border-radius: 6px;">
                        <i class="fa fa-arrow-right"></i> العودة للقائمة
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.box-widget.widget-user .widget-user-header { border-top-left-radius: 12px; border-top-right-radius: 12px; }
.description-block > .description-text { text-transform: none; font-size: 13px; color: #888; }
.description-block > .description-header { font-size: 22px; font-weight: 900; }
</style>
@endsection
