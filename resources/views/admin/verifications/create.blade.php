@extends('layouts.master')

@section('title', 'إضافة توثيق جديد')

@section('content')
<section class="content-header">
  <h1>إضافة توثيق جديد</h1>
</section>

<section class="content">
  <div class="box box-primary">
    <div class="box-body">
      @if($errors->any())
        <div class="alert alert-danger alert-dismissible">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <ul class="mb-0">
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form action="{{ route('admin.verifications.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label>صورة التوثيق</label>
              <input type="file" name="image" class="form-control" required accept="image/*" id="image_input">
              <div id="image-preview" style="margin-top: 15px; display: none;">
                <img src="#" id="preview-src" class="img-responsive img-thumbnail" style="max-height: 200px;">
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label>النوع</label>
              <select name="type" class="form-control" required>
                <option value="">-- اختر النوع --</option>
                @foreach($types as $key => $label)
                  <option value="{{ $key }}" {{ old('type') == $key ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
              </select>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label>الوصف (عربي)</label>
              <textarea name="description_ar" class="form-control" rows="3">{{ old('description_ar') }}</textarea>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>الوصف (English)</label>
              <textarea name="description_en" class="form-control" rows="3">{{ old('description_en') }}</textarea>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>الوصف (中文)</label>
              <textarea name="description_zh" class="form-control" rows="3">{{ old('description_zh') }}</textarea>
            </div>
          </div>
        </div>

        <div class="box-footer" style="padding-left: 0;">
          <button type="submit" class="btn btn-primary btn-lg"><i class="fa fa-save"></i> حفظ التوثيق</button>
          <a href="{{ route('admin.verifications.index') }}" class="btn btn-default btn-lg">إلغاء</a>
        </div>
      </form>
    </div>
  </div>
</section>
@endsection

@push('scripts')
<script>
document.getElementById('image_input').addEventListener('change', function(e) {
    const reader = new FileReader();
    const preview = document.getElementById('image-preview');
    const previewImg = document.getElementById('preview-src');
    
    reader.onload = function(e) {
        previewImg.src = e.target.result;
        preview.style.display = 'block';
    }
    
    if (this.files && this.files[0]) {
        reader.readAsDataURL(this.files[0]);
    }
});
</script>
@endpush
