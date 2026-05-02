@extends('layouts.master')

@section('title', __('dashboard.edit'))

@section('content')
<section class="content-header">
  <h1>
    {{ __('dashboard.manage_branches') }}
    <small>{{ __('dashboard.edit') }}</small>
  </h1>
</section>

<section class="content">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">{{ __('dashboard.edit') }}: {{ $branch->{'name_'.app()->getLocale()} ?? $branch->name_en }}</h3>
    </div>
    <form action="{{ route('admin.branches.update', $branch->id) }}" method="POST">
      @csrf
      @method('PUT')
      <div class="box-body">
        <div class="form-group">
          <label for="sector_id">{{ __('dashboard.main_sector') }}</label>
          <select name="sector_id" id="sector_id" class="form-control" required>
            @foreach($sectors as $sector)
              <option value="{{ $sector->id }}" {{ $branch->sector_id == $sector->id ? 'selected' : '' }}>
                @if(app()->getLocale() == 'ar') {{ $sector->name_ar }}
                @elseif(app()->getLocale() == 'zh') {{ $sector->name_zh ?? $sector->name_en }}
                @else {{ $sector->name_en }} @endif
              </option>
            @endforeach
          </select>
        </div>
        <div class="form-group">
          <label for="name_ar">{{ __('dashboard.name_ar') }}</label>
          <input type="text" name="name_ar" class="form-control" id="name_ar" value="{{ $branch->name_ar }}" required>
        </div>
        <div class="form-group">
          <label for="name_en">{{ __('dashboard.name_en') }}</label>
          <input type="text" name="name_en" class="form-control" id="name_en" value="{{ $branch->name_en }}" required>
        </div>
        <div class="form-group">
          <label for="name_zh">{{ __('dashboard.name_zh') }}</label>
          <input type="text" name="name_zh" class="form-control" id="name_zh" value="{{ $branch->name_zh }}" required>
        </div>
      </div>
      <div class="box-footer">
        <button type="submit" class="btn btn-primary">{{ __('dashboard.update') }}</button>
        <a href="{{ route('admin.branches.index') }}" class="btn btn-default">{{ __('dashboard.cancel') }}</a>
      </div>
    </form>
  </div>
</section>
@endsection
