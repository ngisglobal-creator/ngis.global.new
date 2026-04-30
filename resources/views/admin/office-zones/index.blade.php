@extends('layouts.master')

@section('title', 'اختيار نطاقات للمكاتب')

@section('content')
<section class="content-header">
    <h1>إدارة نطاقات المكاتب <small>تعيين المناطق الجغرافية لمكاتب الصين والأقاليم</small></h1>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary" style="border-radius: 10px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                <div class="box-header with-border">
                    <h3 class="box-title">قائمة المكاتب (الصين والأقاليم)</h3>
                </div>
                <div class="box-body no-padding">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible" style="margin: 15px;">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h4><i class="icon fa fa-check"></i> تم!</h4>
                            {{ session('success') }}
                        </div>
                    @endif

                    <table class="table table-hover">
                        <thead>
                            <tr style="background: #f9f9f9;">
                                <th style="width: 60px;">الصورة</th>
                                <th>اسم المكتب</th>
                                <th>نوع المكتب</th>
                                <th>الدولة الأصلية</th>
                                <th>النطاق الجغرافي المعين</th>
                                <th>الدول في النطاق</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($offices as $office)
                            <tr>
                                <td>
                                    <img src="{{ $office->avatar_url }}" class="img-circle" style="width: 40px; height: 40px; object-fit: cover; border: 2px solid #3c8dbc;">
                                </td>
                                <td>
                                    <strong style="font-size: 15px; color: #333;">{{ $office->name }}</strong><br>
                                    <small class="text-muted">{{ $office->email }}</small>
                                </td>
                                <td>
                                    @if($office->type == 'china')
                                        <span class="label label-primary">مكتب الصين</span>
                                    @else
                                        <span class="label label-info">مكتب إقليمي</span>
                                    @endif
                                </td>
                                <td>
                                    @if($office->country)
                                        <div style="display: flex; align-items: center;">
                                            <span style="font-size: 20px; margin-left: 8px;">{!! mb_convert_encoding('&#' . (127397 + ord($office->country->flag_code[0])) . ';', 'UTF-8', 'HTML-ENTITIES') !!}{!! mb_convert_encoding('&#' . (127397 + ord($office->country->flag_code[1])) . ';', 'UTF-8', 'HTML-ENTITIES') !!}</span>
                                            {{ $office->country->name_ar }}
                                        </div>
                                    @else
                                        <span class="text-muted">غير محدد</span>
                                    @endif
                                </td>
                                <td>
                                    @if($office->geographicZone)
                                        <span class="label label-success" style="font-size: 13px; padding: 5px 10px;">
                                            <i class="fa fa-map-marker"></i> {{ $office->geographicZone->name_ar }}
                                        </span>
                                    @else
                                        <span class="label label-warning" style="font-size: 12px; padding: 5px 10px;">لم يتم التعيين بعد</span>
                                    @endif
                                </td>
                                <td>
                                    @if($office->geographicZone)
                                        <div style="display: flex; flex-wrap: wrap; gap: 5px; max-width: 250px;">
                                            @foreach($office->geographicZone->countries->take(4) as $country)
                                                <span class="label label-default" style="font-size: 11px;">
                                                    {{ $country->name_ar }}
                                                </span>
                                            @endforeach
                                            @if($office->geographicZone->countries->count() > 4)
                                                <span class="text-muted small">+ {{ $office->geographicZone->countries->count() - 4 }} أخرى</span>
                                            @endif
                                        </div>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.office-zones.assign', $office) }}" class="btn btn-primary btn-sm" title="اختيار نطاقات الجغرافي للمكتب">
                                        <i class="fa fa-edit"></i> اختيار نطاق المكتب
                                    </a>
                                    @if($office->geographicZone)
                                    <a href="{{ route('admin.office-zones.show', $office) }}" class="btn btn-info btn-sm" title="عرض التفاصيل">
                                        <i class="fa fa-eye"></i> تفاصيل
                                    </a>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center" style="padding: 30px;">
                                    <i class="fa fa-info-circle fa-2x text-muted"></i>
                                    <p class="text-muted">لا يوجد مكاتب مسجلة حالياً</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
