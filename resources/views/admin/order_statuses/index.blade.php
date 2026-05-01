@extends('layouts.master')

@section('title', 'مسميات حالة الطلب')

@section('content')
<section class="content-header">
  <h1>
    مسميات حالة الطلب
    <small>عرض جميع الحالات</small>
  </h1>
</section>

<section class="content">
  @if(session('success'))
    <div class="alert alert-success mt-3">
        {{ session('success') }}
    </div>
  @endif

  <div class="box box-primary">
    <div class="box-header with-border">
      <a href="{{ route('admin.order-statuses.create') }}" class="btn btn-primary btn-sm">
        <i class="fa fa-plus"></i> إضافة حالة جديدة
      </a>
    </div>
    <div class="box-body">
      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>#</th>
            <th>الصورة</th>
            <th>الاسم (عربي)</th>
            <th>الاسم (EN)</th>
            <th>الاسم (中文)</th>
            <th style="width: 150px;">التحكم</th>
          </tr>
        </thead>
        <tbody>
          @foreach($statuses as $status)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>
              @if($status->image)
                <img src="{{ asset('storage/' . $status->image) }}" alt="" style="width: 50px; height: 50px; object-fit: cover;">
              @else
                <span class="text-muted">لا توجد صورة</span>
              @endif
            </td>
            <td>{{ $status->name_ar }}</td>
            <td>{{ $status->name_en }}</td>
            <td>{{ $status->name_zh }}</td>
            <td>
              <a href="{{ route('admin.order-statuses.edit', $status->id) }}" class="btn btn-primary btn-xs">
                <i class="fa fa-edit"></i> تعديل
              </a>
              <form action="{{ route('admin.order-statuses.destroy', $status->id) }}" method="POST" style="display:inline-block">
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
