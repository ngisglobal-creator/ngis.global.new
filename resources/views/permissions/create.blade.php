@extends('layouts.master')

@section('title', 'إضافة صلاحية جديدة')

@section('content')
<section class="content-header">
  <h1>إضافة صلاحية جديدة</h1>
</section>

<section class="content">
  <div class="box box-success">
    <div class="box-body">
      <form action="{{ route('admin.permissions.store') }}" method="POST">
        @csrf
        <div class="form-group">
          <label>اسم الصلاحية</label>
          <input type="text" name="name" class="form-control" required>
        </div>
        <button class="btn btn-success"><i class="fa fa-save"></i> حفظ</button>
        <a href="{{ route('admin.permissions.index') }}" class="btn btn-default">رجوع</a>
      </form>
    </div>
  </div>
</section>
@endsection
