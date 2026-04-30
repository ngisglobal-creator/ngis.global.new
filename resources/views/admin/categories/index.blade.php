@extends('layouts.master')

@section('title', 'أقسام الفروع')

@section('content')
<section class="content-header">
  <h1>
    إدارة أقسام الفروع
    <small>عرض جميع الأقسام</small>
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
      <a href="{{ route('admin.categories.create') }}" class="btn btn-primary btn-sm">
        <i class="fa fa-plus"></i> إضافة قسم جديد
      </a>
    </div>
    <div class="box-body">
      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>#</th>
            <th>الفرع</th>
            <th>القسم الأب</th>
            <th>الاسم (عربي)</th>
            <th>الاسم (EN)</th>
            <th>الاسم (中文)</th>
            <th style="width: 150px;">التحكم</th>
          </tr>
        </thead>
        <tbody>
          @foreach($categories as $category)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $category->branch->name_ar ?? 'N/A' }}</td>
            <td>{{ $category->parent->name_ar ?? '-' }}</td>
            <td>{{ $category->name_ar }}</td>
            <td>{{ $category->name_en }}</td>
            <td>{{ $category->name_zh }}</td>
            <td>
              <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-primary btn-xs">
                <i class="fa fa-edit"></i> تعديل
              </a>
              <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" style="display:inline-block">
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
