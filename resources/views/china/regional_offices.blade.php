@extends('china.layouts.master')

@section('title', 'مكاتب الأقاليم | لوحة الصين')

@section('content')
<section class="content-header">
    <h1>مكاتب الأقاليم <small>المكاتب المرتبطة بالفواتير الموجهة</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('china/dashboard') }}"><i class="fa fa-dashboard"></i> الرئيسية</a></li>
        <li class="active">مكاتب الأقاليم</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-warning" style="border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                <div class="box-header">
                    <h3 class="box-title">بيانات مكاتب الأقاليم</h3>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr style="background: #f4f4f4;">
                                    <th># ID</th>
                                    <th>الشعار</th>
                                    <th>اسم المكتب</th>
                                    <th>البريد الإلكتروني</th>
                                    <th>الدولة</th>
                                    <th>عدد الفواتير الموجهة</th>
                                    <th>تاريخ الانضمام</th>
                                    <th>العمليات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($regionalOffices as $office)
                                <tr>
                                    <td style="font-family: Arial; font-weight: bold; font-size: 16px; color: #000;">{{ $office->id }}</td>
                                    <td>
                                        <img src="{{ $office->avatar_url }}" width="50" height="50" class="img-circle">
                                    </td>
                                    <td style="font-weight: bold;">{{ $office->name }}</td>
                                    <td style="font-family: Arial; color: #000;">{{ $office->email }}</td>
                                    <td>{{ $office->country->name_ar ?? '---' }}</td>
                                    <td>
                                        <span class="badge bg-blue" style="font-family: Arial; font-size: 16px; font-weight: bold;">{{ $office->products->flatMap->orders->where('forward_to_china', true)->count() }}</span>
                                    </td>
                                    <td style="font-family: Arial; font-weight: bold; color: #000;">{{ $office->created_at->format('Y-m-d') }}</td>
                                    <td>
                                        <a href="{{ route('china.regional_offices.show', $office) }}" class="btn btn-warning btn-xs btn-flat"><i class="fa fa-eye"></i> عرض التفاصيل</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">لا توجد مكاتب أقاليم مرتبطة حالياً</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
