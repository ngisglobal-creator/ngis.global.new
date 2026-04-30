@extends('layouts.master')

@section('title', 'تعديل القطاع')

@section('content')
<section class="content-header">
  <h1>
    إدارة القطاعات
    <small>تعديل القطاع</small>
  </h1>
</section>

<section class="content">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">تعديل بيانات القطاع: {{ $sector->name_ar }}</h3>
    </div>
    <form action="{{ route('admin.sectors.update', $sector->id) }}" method="POST">
      @csrf
      @method('PUT')
      <div class="box-body">
        <div class="form-group">
          <label for="name_ar">الاسم (باللغة العربية)</label>
          <input type="text" name="name_ar" class="form-control" id="name_ar" value="{{ $sector->name_ar }}" required>
        </div>
        <div class="form-group">
          <label for="name_en">الاسم (باللغة الإنجليزية)</label>
          <input type="text" name="name_en" class="form-control" id="name_en" value="{{ $sector->name_en }}" required>
        </div>
        <div class="form-group">
          <label for="name_zh">الاسم (باللغة الصينية)</label>
          <input type="text" name="name_zh" class="form-control" id="name_zh" value="{{ $sector->name_zh }}" required>
        </div>
      </div>
      <div class="box-footer">
        <button type="submit" class="btn btn-primary">تحديث</button>
        <a href="{{ route('admin.sectors.index') }}" class="btn btn-default">إلغاء</a>
      </div>
    </form>
  </div>
</section>
@endsection
