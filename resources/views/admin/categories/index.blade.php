@extends('layouts.master')

@section('title', __('dashboard.manage_categories'))

@section('content')
<section class="content-header">
  <h1>
    {{ __('dashboard.manage_categories') }}
    <small>{{ __('dashboard.all_categories') }}</small>
  </h1>
</section>

<section class="content">
  @if(session('success'))
    <div class="alert alert-success mt-3">
        {{ session('success') }}
    </div>
  @endif

  <div class="box box-primary">
    <div class="box-header with-border">
      <a href="{{ route('admin.categories.create') }}" class="btn btn-primary btn-sm">
        <i class="fa fa-plus"></i> {{ __('dashboard.add_category') }}
      </a>
    </div>
    <div class="box-body">
      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>#</th>
            <th>{{ __('dashboard.branch') }}</th>
            <th>{{ __('dashboard.parent_category') }}</th>
            <th>{{ __('dashboard.name_ar') }}</th>
            <th>{{ __('dashboard.name_en') }}</th>
            <th>{{ __('dashboard.name_zh') }}</th>
            <th style="width: 150px;">{{ __('dashboard.actions') }}</th>
          </tr>
        </thead>
        <tbody>
          @foreach($categories as $category)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>
              @if(app()->getLocale() == 'ar')
                {{ $category->branch->name_ar ?? 'N/A' }}
              @elseif(app()->getLocale() == 'zh')
                {{ $category->branch->name_zh ?? $category->branch->name_en ?? 'N/A' }}
              @else
                {{ $category->branch->name_en ?? 'N/A' }}
              @endif
            </td>
            <td>
              @if($category->parent)
                @if(app()->getLocale() == 'ar')
                  {{ $category->parent->name_ar }}
                @elseif(app()->getLocale() == 'zh')
                  {{ $category->parent->name_zh ?? $category->parent->name_en }}
                @else
                  {{ $category->parent->name_en }}
                @endif
              @else
                -
              @endif
            </td>
            <td>{{ $category->name_ar }}</td>
            <td>{{ $category->name_en }}</td>
            <td>{{ $category->name_zh }}</td>
            <td>
              <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-primary btn-xs">
                <i class="fa fa-edit"></i> {{ __('dashboard.edit') }}
              </a>
              <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" style="display:inline-block">
                @csrf
                @method('DELETE')
                <button onclick="return confirm('{{ __('dashboard.confirm_are_you_sure') }}')" class="btn btn-danger btn-xs">
                  <i class="fa fa-trash"></i> {{ __('dashboard.delete') }}
                </button>
              </form>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</section>
@endsection
