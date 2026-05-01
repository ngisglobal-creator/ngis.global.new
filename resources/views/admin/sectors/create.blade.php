@extends('layouts.master')

@section('title', 'إضافة قطاع جديد')

@section('content')
<section class="content-header">
  <h1>
    إدارة القطاعات
    <small>إضافة قطاع جديد</small>
  </h1>
</section>

<section class="content">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">بيانات القطاع</h3>
    </div>
    <form action="{{ route('admin.sectors.store') }}" method="POST">
      @csrf
      <div class="box-body">
        <div class="form-group">
          <label for="name_ar">الاسم (باللغة العربية)</label>
          <input type="text" name="name_ar" class="form-control" id="name_ar" placeholder="أدخل الاسم بالعربي" required>
        </div>
        <div class="form-group">
          <label for="name_en">الاسم (باللغة الإنجليزية)</label>
          <input type="text" name="name_en" class="form-control" id="name_en" placeholder="Enter name in English" required>
        </div>
        <div class="form-group">
          <label for="name_zh">الاسم (باللغة الصينية)</label>
          <input type="text" name="name_zh" class="form-control" id="name_zh" placeholder="输入中文名称" required>
        </div>
      </div>
      <div class="box-footer">
        <button type="submit" class="btn btn-primary">حفظ</button>
        <a href="{{ route('admin.sectors.index') }}" class="btn btn-default">إلغاء</a>
      </div>
    </form>
  </div>
</section>
@endsection
