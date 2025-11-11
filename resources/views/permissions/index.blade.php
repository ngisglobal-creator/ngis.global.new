@extends('layouts.master')

@section('title', 'الصلاحيات')

@section('content')
<style>
  /* تصغير حجم الخط العام في الصفحة */
  body, table, th, td, h1, h2, h3, h4, h5, h6, .btn {
    font-size: 13px !important;
  }

  /* تحسين مظهر رأس الجدول */
  table thead {
    background-color: #3c8dbc;
    color: #fff;
    font-size: 13px;
  }

  table tbody td {
    font-size: 13px;
    vertical-align: middle;
  }

  /* تصغير أزرار التحكم */
  .btn-sm {
    padding: 4px 8px !important;
    font-size: 12px !important;
  }

  /* تصغير العنوان الفرعي */
  .content-header h1 small {
    font-size: 12px;
  }
</style>

<section class="content-header">
  <h1>
    إدارة الصلاحيات
  </h1>
</section>

<section class="content">
  <div class="box box-primary">
    <div class="box-header with-border">
      <a href="{{ route('permissions.create') }}" class="btn btn-primary btn-sm">
        <i class="fa fa-plus"></i> إضافة صلاحية
      </a>
    </div>
    <div class="box-body">
      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>اسم الصلاحية</th>
            <th>التحكم</th>
          </tr>
        </thead>
        <tbody>
          @foreach($permissions as $perm)
          <tr>
            <td>{{ $perm->name }}</td>
            <td>
              <a href="{{ route('permissions.edit', $perm->id) }}" style="background-color: #3c8dbc; color: white;" class="btn btn-sm">
                <i class="fa fa-edit"></i>
              </a>
              <form action="{{ route('permissions.destroy', $perm->id) }}" method="POST" style="display:inline-block">
                @csrf
                @method('DELETE')
                <button onclick="return confirm('هل تريد الحذف؟')" style="background-color: #3c8dbc; color: white;" class="btn btn-sm">
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
