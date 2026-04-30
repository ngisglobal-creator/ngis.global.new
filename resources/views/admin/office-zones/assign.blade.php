@extends('layouts.master')

@section('title', 'تعيين نطاق عمل لـ ' . $user->name)

@section('content')
<section class="content-header">
    <h1>تعيين نطاق العمل الجغرافي <small>{{ $user->name }}</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> الرئيسية</a></li>
        <li><a href="{{ route('admin.office-zones.index') }}">إدارة نطاقات المكاتب</a></li>
        <li class="active">تعيين نطاق</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <!-- User Info Sidebar -->
        <div class="col-md-3">
            <div class="box box-primary" style="border-radius: 10px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                <div class="box-body box-profile">
                    <img class="profile-user-img img-responsive img-circle" src="{{ $user->avatar_url }}" alt="User profile picture" style="width: 100px; height: 100px; border: 3px solid #3c8dbc;">
                    <h3 class="profile-username text-center">{{ $user->name }}</h3>
                    <p class="text-muted text-center">مكتب إقليمي</p>

                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                            <b>البريد</b> <a class="pull-left">{{ $user->email }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>الدولة</b> 
                            <a class="pull-left">
                                @if($user->country)
                                    <span style="font-size: 16px;">{!! mb_convert_encoding('&#' . (127397 + ord($user->country->flag_code[0])) . ';', 'UTF-8', 'HTML-ENTITIES') !!}{!! mb_convert_encoding('&#' . (127397 + ord($user->country->flag_code[1])) . ';', 'UTF-8', 'HTML-ENTITIES') !!}</span>
                                    {{ $user->country->name_ar }}
                                @else
                                    -
                                @endif
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="box box-primary" style="border-radius: 10px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                <div class="box-header with-border">
                    <h3 class="box-title">اختر نطاق العمل الجغرافي من القائمة</h3>
                </div>
                <div class="box-body">
                    <form action="{{ route('admin.office-zones.update', $user) }}" method="POST">
                        @csrf
                        <div class="row">
                            @foreach($zones as $zone)
                            <div class="col-md-6">
                                <div class="zone-card @if($user->geographic_zone_id == $zone->id) active @endif" onclick="selectZone({{ $zone->id }}, this)" style="border: 2px solid @if($user->geographic_zone_id == $zone->id) #3c8dbc @else #eee @endif; border-radius: 12px; padding: 20px; margin-bottom: 20px; cursor: pointer; transition: all 0.3s; position: relative; background: #fff;">
                                    <div style="display: flex; align-items: flex-start; gap: 15px;">
                                        @if($zone->image)
                                            <img src="{{ Str::startsWith($zone->image, 'vendor/') ? asset($zone->image) : Storage::url($zone->image) }}" style="width: 80px; height: 50px; border-radius: 4px; object-fit: cover;">
                                        @else
                                            <div style="width: 80px; height: 50px; background: #eee; border-radius: 4px; display: flex; align-items: center; justify-content: center;">
                                                <i class="fa fa-map-marker text-muted"></i>
                                            </div>
                                        @endif
                                        <div style="flex: 1;">
                                            <h4 style="margin-top: 0; font-weight: bold; color: #333;">{{ $zone->name_ar }}</h4>
                                            <div style="display: flex; flex-wrap: wrap; gap: 4px; margin-top: 8px;">
                                                @foreach($zone->countries->take(6) as $country)
                                                    <span style="display:inline-flex;align-items:center;background:#f9f9f9;border:1px solid #ddd;border-radius:3px;padding:2px 5px;font-size:10px;gap:3px;">
                                                        <img src="{{ asset('vendor/flag-icons/flags/4x3/' . $country->flag_code . '.svg') }}" style="width:12px;height:9px;object-fit:cover;">
                                                        {{ $country->name_ar }}
                                                    </span>
                                                @endforeach
                                                @if($zone->countries->count() > 6)
                                                    <span class="text-muted small">+{{ $zone->countries->count() - 6 }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @if($user->geographic_zone_id == $zone->id)
                                        <div class="selection-check" style="position: absolute; top: -10px; left: -10px; background: #3c8dbc; color: white; width: 25px; height: 25px; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 5px rgba(0,0,0,0.2);">
                                            <i class="fa fa-check"></i>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <input type="hidden" name="geographic_zone_id" id="geographic_zone_id" value="{{ $user->geographic_zone_id }}">
                        
                        <div class="form-group text-left" style="margin-top: 20px;">
                            <button type="submit" class="btn btn-primary btn-lg" style="padding: 10px 40px; border-radius: 8px; font-weight: bold;">
                                <i class="fa fa-save"></i> حفظ التعيين
                            </button>
                            <a href="{{ route('admin.office-zones.index') }}" class="btn btn-default btn-lg" style="margin-right: 10px; border-radius: 8px;">إلغاء</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.zone-card:hover { border-color: #3c8dbc !important; transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.05); }
.zone-card.selected { border-color: #3c8dbc !important; background: #f0f7ff !important; }
</style>

<script>
function selectZone(id, el) {
    document.getElementById('geographic_zone_id').value = id;
    $('.zone-card').css('border-color', '#eee').css('background', '#fff').removeClass('selected');
    $('.selection-check').remove();
    
    $(el).css('border-color', '#3c8dbc').css('background', '#f0f7ff').addClass('selected');
    $(el).append('<div class="selection-check" style="position: absolute; top: -10px; left: -10px; background: #3c8dbc; color: white; width: 25px; height: 25px; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 5px rgba(0,0,0,0.2);"><i class="fa fa-check"></i></div>');
}
</script>
@endsection
