@extends('layouts.master')

@section('title', 'إدارة التوثيقات')

@section('content')
<section class="content-header">
  <h1>
    إدارة التوثيقات
    <small>عرض وإدارة صور التوثيق</small>
  </h1>
</section>

<section class="content">
  <div class="box box-primary">
    <div class="box-header with-border">
      <a href="{{ route('admin.verifications.create') }}" class="btn btn-primary btn-sm">
        <i class="fa fa-plus"></i> إضافة توثيق جديد
      </a>
    </div>
    <div class="box-body">
      @if(session('success'))
        <div class="alert alert-success alert-dismissible">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          {{ session('success') }}
        </div>
      @endif

      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th style="width: 150px;">الصورة</th>
            <th>النوع</th>
            <th>الوصف</th>
            <th style="width: 150px;">تاريخ الإضافة</th>
            <th style="width: 100px;">التحكم</th>
          </tr>
        </thead>
        <tbody>
          @foreach($verifications as $item)
          <tr>
            <td class="text-center">
              <a href="{{ $item->image_url }}" target="_blank">
                <img src="{{ $item->image_url }}" style="height: 60px; border-radius: 4px; border: 1px solid #ddd;">
              </a>
            </td>
            <td>
              @php
                $types = [
                  'client'          => 'عميل',
                  'company'         => 'شركة',
                  'factory'         => 'مصنع',
                  'china'           => 'الصين',
                  'regional_office' => 'مكتب اقليمي',
                ];
              @endphp
              <span class="label label-info" style="font-size: 13px;">{{ $types[$item->type] ?? $item->type }}</span>
            </td>
            <td>{{ $item->created_at->format('Y-m-d') }}</td>
            <td>
              <a href="{{ route('admin.verifications.edit', $item->id) }}" class="btn btn-primary btn-xs">
                <i class="fa fa-edit"></i>
              </a>
              <form action="{{ route('admin.verifications.destroy', $item->id) }}" method="POST" style="display:inline-block">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-xs" onclick="return confirm('هل أنت متأكد من الحذف؟')">
                  <i class="fa fa-trash"></i>
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
