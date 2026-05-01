@extends('layouts.master')

@section('title', 'نطاقات العمل الجغرافي')

@section('content')
<section class="content-header">
    <h1>
        نطاقات العمل الجغرافي
        <small>عرض جميع النطاقات</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('admin') }}"><i class="fa fa-dashboard"></i> الرئيسية</a></li>
        <li class="active">نطاقات العمل الجغرافي</li>
    </ol>
</section>

<section class="content">
    <div class="row" style="margin-bottom: 10px;">
        <div class="col-xs-12">
            <a href="{{ route('admin.geographic-zones.create') }}" class="btn btn-success">
                <i class="fa fa-plus"></i> إضافة نطاق جديد
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <h4><i class="icon fa fa-check"></i> نجاح!</h4>
        {{ session('success') }}
    </div>
    @endif

    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">قائمة نطاقات العمل الجغرافي</h3>
                </div>
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>الصورة</th>
                            <th>الاسم بالعربية</th>
                            <th>الاسم بالإنجليزية</th>
                            <th>الاسم بالصينية</th>
                            <th>الدول المرتبطة</th>
                            <th>العمليات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($zones as $zone)
                        <tr>
                            <td>
                                @if($zone->image)
                                    @php
                                        $imgUrl = Str::startsWith($zone->image, 'vendor/')
                                            ? asset($zone->image)
                                            : Storage::url($zone->image);
                                    @endphp
                                    <img src="{{ $imgUrl }}" alt="{{ $zone->name_ar }}"
                                         style="width:60px;height:42px;object-fit:cover;border-radius:4px;border:1px solid #ddd;">
                                @else
                                    <span class="label label-default">لا توجد صورة</span>
                                @endif
                            </td>
                            <td><strong>{{ $zone->name_ar }}</strong></td>
                            <td>{{ $zone->name_en }}</td>
                            <td>{{ $zone->name_zh }}</td>
                            <td>
                                <div style="display:flex;flex-wrap:wrap;gap:4px;max-width:300px;">
                                    @foreach($zone->countries->take(8) as $country)
                                        <span title="{{ $country->name_ar }}" style="display:inline-flex;align-items:center;background:#f4f4f4;border:1px solid #ddd;border-radius:3px;padding:2px 5px;font-size:11px;gap:4px;">
                                            <img src="{{ asset('vendor/flag-icons/flags/4x3/' . $country->flag_code . '.svg') }}"
                                                 style="width:16px;height:12px;object-fit:cover;border-radius:1px;">
                                            {{ $country->name_ar }}
                                        </span>
                                    @endforeach
                                    @if($zone->countries->count() > 8)
                                        <span class="label label-info">+{{ $zone->countries->count() - 8 }} أخرى</span>
                                    @endif
                                    @if($zone->countries->isEmpty())
                                        <span class="text-muted" style="font-size:12px;">لا توجد دول</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <a href="{{ route('admin.geographic-zones.edit', $zone->id) }}" class="btn btn-warning btn-xs">
                                    <i class="fa fa-edit"></i> تعديل
                                </a>
                                <form action="{{ route('admin.geographic-zones.destroy', $zone->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-xs"
                                            onclick="return confirm('هل أنت متأكد من حذف هذا النطاق؟')">
                                        <i class="fa fa-trash"></i> حذف
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">لا توجد نطاقات جغرافية بعد</td>
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

@push('scripts')
<script>
    $(function () {
        $('.select2-countries').select2({
            placeholder: 'اختر الدول...',
            allowClear: true,
            dir: 'rtl',
        });
    });
</script>
@endpush
