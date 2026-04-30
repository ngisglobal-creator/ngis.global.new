@extends('layouts.master')

@section('title', 'إضافة باقة جديدة')

@section('content')
<section class="content-header">
  <h1>إضافة باقة جديدة</h1>
</section>

<section class="content">
  <div class="box box-primary">
    <form action="{{ route('admin.packages.store') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label>نوع الباقة</label>
              <select name="type" class="form-control" required>
                <option value="client">عميل</option>
                <option value="company">شركة</option>
                <option value="factory">مصنع</option>
              </select>
            </div>
          </div>
          
          <div class="col-md-4">
            <div class="form-group">
              <label>العنوان (عربي)</label>
              <input type="text" name="title_ar" class="form-control" required>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>العنوان (English)</label>
              <input type="text" name="title_en" class="form-control" required>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>العنوان (中文)</label>
              <input type="text" name="title_zh" class="form-control" required>
            </div>
          </div>

          <div class="col-md-4">
            <div class="form-group">
              <label>الوصف (عربي)</label>
              <textarea name="description_ar" class="form-control" rows="4" required></textarea>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>الوصف (English)</label>
              <textarea name="description_en" class="form-control" rows="4" required></textarea>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>الوصف (中文)</label>
              <textarea name="description_zh" class="form-control" rows="4" required></textarea>
            </div>
          </div>

          <div class="col-md-12">
            <div class="form-group">
              <label>صورة الباقة</label>
              <input type="file" name="image" class="form-control" accept="image/*">
            </div>
          </div>
        </div>
      </div>
      <div class="box-footer">
        <button type="submit" class="btn btn-primary">حفظ الباقة</button>
        <a href="{{ route('admin.packages.index') }}" class="btn btn-default">إلغاء</a>
      </div>
    </form>
  </div>
</section>
@endsection
