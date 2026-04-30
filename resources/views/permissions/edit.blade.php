@extends('layouts.master')

@section('title', 'تعديل الصلاحية')

@section('content')
<section class="content-header">
  <h1>تعديل الصلاحية: {{ $permission->name }}</h1>
</section>

<section class="content">
  <div class="box box-warning">
    <div class="box-body">
      <form action="{{ route('admin.permissions.update', $permission->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
          <label>اسم الصلاحية</label>
          <input type="text" name="name" value="{{ $permission->name }}" class="form-control" required>
        </div>
        <button class="btn btn-success"><i class="fa fa-save"></i> حفظ</button>
        <a href="{{ route('admin.permissions.index') }}" class="btn btn-default">رجوع</a>
      </form>
    </div>
  </div>
</section>
@endsection
