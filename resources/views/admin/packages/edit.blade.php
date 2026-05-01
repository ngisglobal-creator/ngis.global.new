@extends('layouts.master')

@section('title', 'تعديل الباقة')

@section('content')
<section class="content-header">
  <h1>تعديل الباقة: {{ $package->title_ar }}</h1>
</section>

<section class="content">
  <div class="box box-primary">
    <form action="{{ route('admin.packages.update', $package->id) }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label>نوع الباقة</label>
              <select name="type" class="form-control" required>
                <option value="client" {{ $package->type == 'client' ? 'selected' : '' }}>عميل</option>
                <option value="company" {{ $package->type == 'company' ? 'selected' : '' }}>شركة</option>
                <option value="factory" {{ $package->type == 'factory' ? 'selected' : '' }}>مصنع</option>
              </select>
            </div>
          </div>
          
          <div class="col-md-4">
            <div class="form-group">
              <label>العنوان (عربي)</label>
              <input type="text" name="title_ar" class="form-control" value="{{ $package->title_ar }}" required>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>العنوان (English)</label>
              <input type="text" name="title_en" class="form-control" value="{{ $package->title_en }}" required>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>العنوان (中文)</label>
              <input type="text" name="title_zh" class="form-control" value="{{ $package->title_zh }}" required>
            </div>
          </div>

          <div class="col-md-4">
            <div class="form-group">
              <label>الوصف (عربي)</label>
              <textarea name="description_ar" class="form-control" rows="4" required>{{ $package->description_ar }}</textarea>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>الوصف (English)</label>
              <textarea name="description_en" class="form-control" rows="4" required>{{ $package->description_en }}</textarea>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>الوصف (中文)</label>
              <textarea name="description_zh" class="form-control" rows="4" required>{{ $package->description_zh }}</textarea>
            </div>
          </div>

          <div class="col-md-12">
            <div class="form-group">
              <label>صورة الباقة</label>
              @if($package->image)
                <div style="margin-bottom: 10px;">
                  <img src="{{ $package->image_url }}" style="height: 100px; border-radius: 4px; border: 1px solid #ddd;">
                </div>
              @endif
              <input type="file" name="image" class="form-control" accept="image/*">
            </div>
          </div>
        </div>
      </div>
      <div class="box-footer">
        <button type="submit" class="btn btn-primary">تحديث الباقة</button>
        <a href="{{ route('admin.packages.index') }}" class="btn btn-default">إلغاء</a>
      </div>
    </form>
  </div>
</section>
@endsection
