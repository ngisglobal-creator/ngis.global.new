@extends('layouts.master')

@section('title', 'إضافة فرع جديد')

@section('content')
<section class="content-header">
  <h1>
    إدارة فروع القطاعات
    <small>إضافة فرع جديد</small>
  </h1>
</section>

<section class="content">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">بيانات الفرع</h3>
    </div>
    <form action="{{ route('admin.branches.store') }}" method="POST">
      @csrf
      <div class="box-body">
        <div class="form-group">
          <label for="sector_id">القطاع الرئيسي</label>
          <select name="sector_id" id="sector_id" class="form-control" required>
            <option value="">اختر القطاع</option>
            @foreach($sectors as $sector)
              <option value="{{ $sector->id }}">{{ $sector->name_ar }} ({{ $sector->name_en }})</option>
            @endforeach
          </select>
        </div>
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
        <a href="{{ route('admin.branches.index') }}" class="btn btn-default">إلغاء</a>
      </div>
    </form>
  </div>
</section>
@endsection
