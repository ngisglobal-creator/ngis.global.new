@extends('layouts.master')

@section('title', __('dashboard.add_branch'))

@section('content')
<section class="content-header">
  <h1>
    {{ __('dashboard.manage_branches') }}
    <small>{{ __('dashboard.add_branch') }}</small>
  </h1>
</section>

<section class="content">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">{{ __('dashboard.branch_data') }}</h3>
    </div>
    <form action="{{ route('admin.branches.store') }}" method="POST">
      @csrf
      <div class="box-body">
        <div class="form-group">
          <label for="sector_id">{{ __('dashboard.main_sector') }}</label>
          <select name="sector_id" id="sector_id" class="form-control" required>
            <option value="">{{ __('dashboard.select_sector') }}</option>
            @foreach($sectors as $sector)
              <option value="{{ $sector->id }}">
                @if(app()->getLocale() == 'ar') {{ $sector->name_ar }}
                @elseif(app()->getLocale() == 'zh') {{ $sector->name_zh ?? $sector->name_en }}
                @else {{ $sector->name_en }} @endif
              </option>
            @endforeach
          </select>
        </div>
        <div class="form-group">
          <label for="name_ar">{{ __('dashboard.name_ar') }}</label>
          <input type="text" name="name_ar" class="form-control" id="name_ar" placeholder="{{ __('dashboard.name_ar') }}" required>
        </div>
        <div class="form-group">
          <label for="name_en">{{ __('dashboard.name_en') }}</label>
          <input type="text" name="name_en" class="form-control" id="name_en" placeholder="{{ __('dashboard.name_en') }}" required>
        </div>
        <div class="form-group">
          <label for="name_zh">{{ __('dashboard.name_zh') }}</label>
          <input type="text" name="name_zh" class="form-control" id="name_zh" placeholder="{{ __('dashboard.name_zh') }}" required>
        </div>
      </div>
      <div class="box-footer">
        <button type="submit" class="btn btn-primary">{{ __('dashboard.save') }}</button>
        <a href="{{ route('admin.branches.index') }}" class="btn btn-default">{{ __('dashboard.cancel') }}</a>
      </div>
    </form>
  </div>
</section>
@endsection
