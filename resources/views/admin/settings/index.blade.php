@extends('layouts.master')

@section('title', __('dashboard.settings'))

@section('content')
<section class="content-header">
  <h1>{{ __('dashboard.settings') }}</h1>
</section>

<section class="content">
  <div class="row">
    <div class="col-md-6">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">{{ __('dashboard.settings') }}</h3>
        </div>
        <form action="{{ route('admin.settings.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="box-body">
            <div class="form-group text-center">
              <label style="display: block;">{{ __('dashboard.site_logo') }}</label>
              <div class="logo-preview-container" style="margin-bottom: 20px;">
                <img id="logo-preview" src="{{ \App\Models\Setting::logoUrl() }}" 
                     alt="Logo Preview" class="img-thumbnail" 
                     style="max-height: 150px; background-color: #f4f4f4; padding: 10px;">
              </div>
              <div class="input-group" style="width: 100%;">
                <input type="file" name="site_logo" id="site_logo_input" class="form-control" accept="image/*" style="display: none;">
                <button type="button" class="btn btn-default btn-block" onclick="document.getElementById('site_logo_input').click();">
                  <i class="fa fa-camera"></i> {{ __('dashboard.upload_logo') ?? 'اختر شعار' }}
                </button>
              </div>
            </div>

            <hr>

            <div class="form-group">
              <label>{{ __('dashboard.site_name') }}</label>
              <input type="text" name="site_name" class="form-control input-lg" value="{{ $settings['site_name'] ?? '' }}" placeholder="{{ __('dashboard.enter_site_name') ?? 'أدخل اسم الموقع' }}">
            </div>
          </div>
          <div class="box-footer">
            <button type="submit" class="btn btn-primary btn-lg btn-block">
              <i class="fa fa-save"></i> {{ __('dashboard.save') }}
            </button>
          </div>
        </form>
      </div>
    </div>

    <div class="col-md-6">
      <div class="box box-success">
        <div class="box-header with-border">
          <h3 class="box-title">{{ __('dashboard.language') }} ({{ __('dashboard.profile') }})</h3>
        </div>
        <form action="{{ route('language.set') }}" method="POST">
          @csrf
          <div class="box-body">
            <div class="form-group">
              <label>{{ __('dashboard.language') }}</label>
              <select name="locale" class="form-control" onchange="this.form.submit()">
                <option value="ar" {{ auth()->user()->locale == 'ar' ? 'selected' : '' }}>{{ __('dashboard.arabic') }}</option>
                <option value="en" {{ auth()->user()->locale == 'en' ? 'selected' : '' }}>{{ __('dashboard.english') }}</option>
                <option value="zh" {{ auth()->user()->locale == 'zh' ? 'selected' : '' }}>{{ __('dashboard.chinese') }}</option>
              </select>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
@push('scripts')
<script>
document.getElementById('site_logo_input').addEventListener('change', function(e) {
    const reader = new FileReader();
    reader.onload = function(e) {
        document.getElementById('logo-preview').src = e.target.result;
    }
    if (this.files && this.files[0]) {
        reader.readAsDataURL(this.files[0]);
    }
});
</script>
@endpush
@endsection
