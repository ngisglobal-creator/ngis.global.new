@extends('layouts.master')

@section('title', 'فروع القطاعات')

@section('content')
<section class="content-header">
  <h1>
    إدارة فروع القطاعات
    <small>عرض جميع الفروع</small>
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
      <a href="{{ route('admin.branches.create') }}" class="btn btn-primary btn-sm">
        <i class="fa fa-plus"></i> إضافة فرع جديد
      </a>
    </div>
    <div class="box-body">
      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>#</th>
            <th>القطاع الرئيسي</th>
            <th>الاسم (عربي)</th>
            <th>الاسم (EN)</th>
            <th>الاسم (中文)</th>
            <th style="width: 150px;">التحكم</th>
          </tr>
        </thead>
        <tbody>
          @foreach($branches as $branch)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $branch->sector->name_ar ?? 'N/A' }}</td>
            <td>{{ $branch->name_ar }}</td>
            <td>{{ $branch->name_en }}</td>
            <td>{{ $branch->name_zh }}</td>
            <td>
              <a href="{{ route('admin.branches.edit', $branch->id) }}" class="btn btn-primary btn-xs">
                <i class="fa fa-edit"></i> تعديل
              </a>
              <form action="{{ route('admin.branches.destroy', $branch->id) }}" method="POST" style="display:inline-block">
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
