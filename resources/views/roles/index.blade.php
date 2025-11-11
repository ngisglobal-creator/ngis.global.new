@extends('layouts.master')

@section('title', 'الأدوار')

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
    إدارة الأدوار
    <small>عرض وتعديل الأدوار</small>
  </h1>
</section>

<section class="content">
  <div class="box box-primary">
    <div class="box-header with-border">
      <a href="{{ route('roles.create') }}" class="btn btn-primary btn-sm">
        <i class="fa fa-plus"></i> إضافة دور
      </a>
    </div>
    <div class="box-body">
      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>اسم الدور</th>
            <th>الصلاحيات</th>
            <th>التحكم</th>
          </tr>
        </thead>
        <tbody>
          @foreach($roles as $role)
          <tr>
            <td>{{ $role->name }}</td>
            <td>
              @foreach($role->permissions as $perm)
                <span class="label label-info">{{ $perm->name }}</span>
              @endforeach
            </td>
            <td>
              <a href="{{ route('roles.edit', $role->id) }}" style="background-color: #3c8dbc; color: white;" class="btn btn-sm">
                <i class="fa fa-edit"></i>
              </a>
              <form action="{{ route('roles.destroy', $role->id) }}" method="POST" style="display:inline-block">
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
