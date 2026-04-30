@extends('regional.layouts.master')

@section('title', 'تفاصيل المكتب | ' . $user->name)

@section('content')
<section class="content-header">
  <h1>تفاصيل المكتب الإقليمي <small>عرض بيانات المكتب والنطاق الجغرافي</small></h1>
  <ol class="breadcrumb">
    <li><a href="{{ url('regional/dashboard') }}"><i class="fa fa-dashboard"></i> الرئيسية</a></li>
    <li class="active">تفاصيل المكتب</li>
  </ol>
</section>

<section class="content">
  <div class="row">
    <!-- User Profile & Wallet Section -->
    <div class="col-md-4">
      <!-- Profile Card -->
      <div class="box box-widget widget-user" style="border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.1);">
        <div class="widget-user-header bg-primary" style="background: linear-gradient(135deg, #3c8dbc 0%, #00c0ef 100%); padding: 30px 20px; height: 120px;">
          <h3 class="widget-user-username" style="font-weight: bold; color: #fff;">{{ $user->name }}</h3>
          <h5 class="widget-user-desc" style="color: rgba(255,255,255,0.8);">مكتب إقليمي</h5>
        </div>
        <div class="widget-user-image" style="top: 80px;">
          <img class="img-circle" src="{{ $user->avatar_url }}" alt="User Avatar" style="width: 90px; height: 90px; border: 3px solid #fff; object-fit: cover; background: #fff;">
        </div>
        <div class="box-footer" style="padding-top: 60px; background: #fff;">
          <div class="row">
            <div class="col-sm-6 border-right">
              <div class="description-block">
                <h5 class="description-header" style="font-size: 20px;">{{ number_format($user->wallet_balance ?? 0, 2) }}</h5>
                <span class="description-text">المحفظة (SAR)</span>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="description-block">
                <h5 class="description-header" style="font-size: 20px;">{{ $user->country ? $user->country->name_ar : '-' }}</h5>
                <span class="description-text">دولة المقر</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Quick Info -->
      <div class="box box-primary" style="margin-top: 20px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
        <div class="box-header with-border">
          <h3 class="box-title">تفاصيل الحساب</h3>
        </div>
        <div class="box-body">
          <ul class="list-group list-group-unbordered">
            <li class="list-group-item">
              <b><i class="fa fa-envelope margin-r-5 text-primary"></i> البريد</b> <a class="pull-left">{{ $user->email }}</a>
            </li>
            <li class="list-group-item">
              <b><i class="fa fa-phone margin-r-5 text-primary"></i> الهاتف</b> <a class="pull-left">{{ $user->phone ?? 'غير متوفر' }}</a>
            </li>
            <li class="list-group-item">
              <b><i class="fa fa-map-marker margin-r-5 text-primary"></i> النطاق</b> 
              <a class="pull-left">
                @if($user->geographicZone)
                  <span class="label label-success">{{ $user->geographicZone->name_ar }}</span>
                @else
                  <span class="label label-warning">لم يتم التعيين</span>
                @endif
              </a>
            </li>
          </ul>
          <a href="{{ route('profile.edit') }}" class="btn btn-primary btn-block"><b>تحديث البيانات</b></a>
        </div>
      </div>
    </div>

    <!-- Geographic Zone & Countries Section -->
    <div class="col-md-8">
      <div class="box box-solid" style="border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
        <div class="box-header" style="background: #fafafa; border-bottom: 1px solid #eee; padding: 20px;">
          <div style="display: flex; align-items: center; gap: 20px;">
            @if($user->geographicZone && $user->geographicZone->image)
              <img src="{{ Str::startsWith($user->geographicZone->image, 'vendor/') ? asset($user->geographicZone->image) : Storage::url($user->geographicZone->image) }}" style="width: 100px; height: 65px; border-radius: 8px; object-fit: cover; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
            @else
              <div style="width: 100px; height: 65px; background: #3c8dbc; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #fff;">
                <i class="fa fa-globe fa-2x"></i>
              </div>
            @endif
            <div>
              <h3 class="box-title" style="font-size: 22px; font-weight: bold; color: #333;">نطاق العمل: {{ $user->geographicZone ? $user->geographicZone->name_ar : 'غير معين' }}</h3>
              <p class="text-muted" style="margin-top: 5px;">الدول المشمولة ضمن صلاحيات مكتبكم</p>
            </div>
          </div>
        </div>
        <div class="box-body" style="padding: 25px; min-height: 400px;">
          @if($user->geographicZone && $user->geographicZone->countries->count() > 0)
            <div class="row">
              @foreach($user->geographicZone->countries as $country)
                <div class="col-sm-6 col-md-4">
                  <div class="country-card" style="display: flex; align-items: center; background: #fff; border: 1px solid #eee; border-radius: 8px; padding: 12px; margin-bottom: 15px; transition: all 0.3s;">
                    <div style="width: 40px; height: 30px; margin-left: 12px; border: 1px solid #f0f0f0; border-radius: 3px; overflow: hidden; flex-shrink: 0;">
                      <img src="{{ asset('vendor/flag-icons/flags/4x3/' . $country->flag_code . '.svg') }}" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <div style="flex: 1; overflow: hidden;">
                      <h5 style="margin: 0; font-weight: bold; color: #444; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $country->name_ar }}</h5>
                      <small class="text-muted" style="direction: ltr; display: inline-block;">{{ $country->name_en }}</small>
                    </div>
                  </div>
                </div>
              @endforeach
            </div>
          @else
            <div class="text-center" style="padding: 60px;">
              <i class="fa fa-map-o fa-4x text-muted" style="opacity: 0.3;"></i>
              <h4 style="margin-top: 20px; color: #777;">لم يتم تعيين نطاق جغرافي لمكتبكم بعد</h4>
              <p class="text-muted">يرجى التواصل مع الإدارة لتعيين نطاق العمل الخاص بكم.</p>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</section>

<style>
.country-card:hover { transform: translateY(-3px); box-shadow: 0 5px 15px rgba(0,0,0,0.05); border-color: #3c8dbc !important; }
.widget-user-header { border-top-left-radius: 12px; border-top-right-radius: 12px; }
.description-text { text-transform: none; color: #888; font-size: 12px; }
</style>
@endsection
