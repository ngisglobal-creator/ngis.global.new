@extends('layouts.master')

@section('title', 'تعديل التوثيق')

@section('content')
<section class="content-header">
  <h1>تعديل التوثيق</h1>
</section>

<section class="content">
  <div class="box box-success">
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

      <form action="{{ route('admin.verifications.update', $verification->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label>صورة التوثيق (اتركها فارغة إذا لم ترد تغييرها)</label>
              <input type="file" name="image" class="form-control" accept="image/*" id="image_input">
              <div id="image-preview" style="margin-top: 15px;">
                <img src="{{ $verification->image_url }}" id="preview-src" class="img-responsive img-thumbnail" style="max-height: 200px;">
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label>النوع</label>
              <select name="type" class="form-control" required>
                <option value="">-- اختر النوع --</option>
                @foreach($types as $key => $label)
                  <option value="{{ $key }}" {{ old('type', $verification->type) == $key ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
              </select>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label>الوصف (عربي)</label>
              <textarea name="description_ar" class="form-control" rows="3">{{ old('description_ar', $verification->description_ar) }}</textarea>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>الوصف (English)</label>
              <textarea name="description_en" class="form-control" rows="3">{{ old('description_en', $verification->description_en) }}</textarea>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>الوصف (中文)</label>
              <textarea name="description_zh" class="form-control" rows="3">{{ old('description_zh', $verification->description_zh) }}</textarea>
            </div>
          </div>
        </div>

        <div class="box-footer" style="padding-left: 0;">
          <button type="submit" class="btn btn-success btn-lg"><i class="fa fa-save"></i> حفظ التعديلات</button>
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
    const previewImg = document.getElementById('preview-src');
    
    reader.onload = function(e) {
        previewImg.src = e.target.result;
    }
    
    if (this.files && this.files[0]) {
        reader.readAsDataURL(this.files[0]);
    }
});
</script>
@endpush
