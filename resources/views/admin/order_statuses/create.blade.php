@extends('layouts.master')

@section('title', 'إضافة حالة طلب جديدة')

@section('content')
<section class="content-header">
  <h1>
    إضافة حالة طلب جديدة
  </h1>
</section>

<section class="content">
  <div class="box box-primary">
    <form action="{{ route('admin.order-statuses.store') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="box-body">
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label>الاسم (عربي)</label>
              <input type="text" name="name_ar" class="form-control" placeholder="أدخل الاسم بالعربي" required>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>الاسم (EN)</label>
              <input type="text" name="name_en" class="form-control" placeholder="أدخل الاسم بالإنجليزي" required>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>الاسم (中文)</label>
              <input type="text" name="name_zh" class="form-control" placeholder="أدخل الاسم بالصيني" required>
            </div>
          </div>
        </div>

        <div class="form-group">
          <label>أيقونة / صورة الحالة</label>
          <input type="file" name="image" class="form-control">
          <p class="help-block">يفضل استخدام صور بخلفية شفافة</p>
        </div>
      </div>

      <div class="box-footer">
        <button type="submit" class="btn btn-primary">حفظ</button>
        <a href="{{ route('admin.order-statuses.index') }}" class="btn btn-default">إلغاء</a>
      </div>
    </form>
  </div>
</section>
@endsection
