@extends('layouts.master')

@section('title', __('dashboard.edit_category'))

@section('content')
<section class="content-header">
  <h1>
    {{ __('dashboard.manage_categories') }}
    <small>{{ __('dashboard.edit_category') }}</small>
  </h1>
</section>

<section class="content">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">{{ __('dashboard.edit_category') }}: {{ $category->{'name_'.app()->getLocale()} ?? $category->name_en }}</h3>
    </div>
    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
      @csrf
      @method('PUT')
      <div class="box-body">
        <div class="form-group">
          <label for="branch_id">{{ __('dashboard.branch') }}</label>
          <select name="branch_id" id="branch_id" class="form-control" required>
            @foreach($branches as $branch)
              <option value="{{ $branch->id }}" {{ $category->branch_id == $branch->id ? 'selected' : '' }}>
                @if(app()->getLocale() == 'ar') {{ $branch->name_ar }}
                @elseif(app()->getLocale() == 'zh') {{ $branch->name_zh ?? $branch->name_en }}
                @else {{ $branch->name_en }} @endif
              </option>
            @endforeach
          </select>
        </div>
        <div class="form-group">
          <label for="parent_id">{{ __('dashboard.parent_category') }}</label>
          <select name="parent_id" id="parent_id" class="form-control">
            <option value="">{{ __('dashboard.select_parent_category') }}</option>
            @foreach($parentCategories as $parent)
              <option value="{{ $parent->id }}" {{ $category->parent_id == $parent->id ? 'selected' : '' }}>
                @if(app()->getLocale() == 'ar') {{ $parent->name_ar }}
                @elseif(app()->getLocale() == 'zh') {{ $parent->name_zh ?? $parent->name_en }}
                @else {{ $parent->name_en }} @endif
              </option>
            @endforeach
          </select>
        </div>
        <div class="form-group">
          <label for="name_ar">{{ __('dashboard.name_ar') }}</label>
          <input type="text" name="name_ar" class="form-control" id="name_ar" value="{{ $category->name_ar }}" required>
        </div>
        <div class="form-group">
          <label for="name_en">{{ __('dashboard.name_en') }}</label>
          <input type="text" name="name_en" class="form-control" id="name_en" value="{{ $category->name_en }}" required>
        </div>
        <div class="form-group">
          <label for="name_zh">{{ __('dashboard.name_zh') }}</label>
          <input type="text" name="name_zh" class="form-control" id="name_zh" value="{{ $category->name_zh }}" required>
        </div>
      </div>
      <div class="box-footer">
        <button type="submit" class="btn btn-primary">{{ __('dashboard.update') }}</button>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-default">{{ __('dashboard.cancel') }}</a>
      </div>
    </form>
  </div>
</section>
@endsection
