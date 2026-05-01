@extends('layouts.master')

@section('title', __('dashboard.packages') ?? 'الباقات')

@section('content')
<section class="content-header">
  <h1>
    إدارة الباقات
    <small>عرض جميع الباقات</small>
  </h1>
</section>

<section class="content">
  <div class="box box-primary">
    <div class="box-header with-border">
      <a href="{{ route('admin.packages.create') }}" class="btn btn-primary btn-sm">
        <i class="fa fa-plus"></i> إضافة باقة جديدة
      </a>
    </div>
    <div class="box-body">
      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>الصورة</th>
            <th>النوع</th>
            <th>العنوان (عربي)</th>
            <th>العنوان (EN)</th>
            <th>العنوان (中文)</th>
            <th style="width: 150px;">التحكم</th>
          </tr>
        </thead>
        <tbody>
          @foreach($packages as $package)
          <tr>
            <td class="text-center">
              <img src="{{ $package->image_url }}" style="height: 40px; border-radius: 4px;">
            </td>
            <td>
              @php
                $types = ['client'=>'عميل','company'=>'شركة','factory'=>'مصنع'];
              @endphp
              <span class="label label-info">{{ $types[$package->type] ?? $package->type }}</span>
            </td>
            <td>{{ $package->title_ar }}</td>
            <td>{{ $package->title_en }}</td>
            <td>{{ $package->title_zh }}</td>
            <td>
              <a href="{{ route('admin.packages.edit', $package->id) }}" class="btn btn-primary btn-xs">
                <i class="fa fa-edit"></i> تعديل
              </a>
              <form action="{{ route('admin.packages.destroy', $package->id) }}" method="POST" style="display:inline-block">
                @csrf
                @method('DELETE')
                <button onclick="return confirm('هل أنت متأكد؟')" class="btn btn-danger btn-xs">
                  <i class="fa fa-trash"></i> حذف
                </button>
              </form>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</section>
@endsection
