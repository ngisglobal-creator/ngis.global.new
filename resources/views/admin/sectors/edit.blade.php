@extends('layouts.master')

@section('title', __('dashboard.edit_sector'))

@section('content')
<section class="content-header">
  <h1>
    {{ __('dashboard.manage_sectors') }}
    <small>{{ __('dashboard.edit_sector') }}</small>
  </h1>
</section>

<section class="content">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">{{ __('dashboard.edit_sector') }}: {{ $sector->{'name_'.app()->getLocale()} ?? $sector->name_en }}</h3>
    </div>
    <form action="{{ route('admin.sectors.update', $sector->id) }}" method="POST">
      @csrf
      @method('PUT')
      <div class="box-body">
        <div class="form-group">
          <label for="name_ar">{{ __('dashboard.name_ar') }}</label>
          <input type="text" name="name_ar" class="form-control" id="name_ar" value="{{ $sector->name_ar }}" required>
        </div>
        <div class="form-group">
          <label for="name_en">{{ __('dashboard.name_en') }}</label>
          <input type="text" name="name_en" class="form-control" id="name_en" value="{{ $sector->name_en }}" required>
        </div>
        <div class="form-group">
          <label for="name_zh">{{ __('dashboard.name_zh') }}</label>
          <input type="text" name="name_zh" class="form-control" id="name_zh" value="{{ $sector->name_zh }}" required>
        </div>
      </div>
      <div class="box-footer">
        <button type="submit" class="btn btn-primary">{{ __('dashboard.update') }}</button>
        <a href="{{ route('admin.sectors.index') }}" class="btn btn-default">{{ __('dashboard.cancel') }}</a>
      </div>
    </form>
  </div>
</section>
@endsection
