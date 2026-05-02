@extends('layouts.master')

@section('title', __('dashboard.packages'))

@section('content')
<section class="content-header">
  <h1>
    {{ __('dashboard.manage_packages') }}
    <small>{{ __('dashboard.all_packages') }}</small>
  </h1>
</section>

<section class="content">
  <div class="box box-primary">
    <div class="box-header with-border">
      <a href="{{ route('admin.packages.create') }}" class="btn btn-primary btn-sm">
        <i class="fa fa-plus"></i> {{ __('dashboard.add_new_package') }}
      </a>
    </div>
    <div class="box-body">
      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>{{ __('dashboard.image') }}</th>
            <th>{{ __('dashboard.type') }}</th>
            <th>{{ __('dashboard.title_ar') }}</th>
            <th>{{ __('dashboard.title_en') }}</th>
            <th>{{ __('dashboard.title_zh') }}</th>
            <th style="width: 150px;">{{ __('dashboard.actions') }}</th>
          </tr>
        </thead>
        <tbody>
          @foreach($packages as $package)
          <tr>
            <td class="text-center">
              <img src="{{ $package->image_url }}" style="height: 40px; border-radius: 4px;">
            </td>
            <td>
              <span class="label label-info">
                @if($package->type == 'client') {{ __('dashboard.client') }}
                @elseif($package->type == 'company') {{ __('dashboard.company') }}
                @elseif($package->type == 'factory') {{ __('dashboard.factory') }}
                @else {{ $package->type }} @endif
              </span>
            </td>
            <td>{{ $package->title_ar }}</td>
            <td>{{ $package->title_en }}</td>
            <td>{{ $package->title_zh }}</td>
            <td>
              <a href="{{ route('admin.packages.edit', $package->id) }}" class="btn btn-primary btn-xs">
                <i class="fa fa-edit"></i> {{ __('dashboard.edit') }}
              </a>
              <form action="{{ route('admin.packages.destroy', $package->id) }}" method="POST" style="display:inline-block">
                @csrf
                @method('DELETE')
                <button onclick="return confirm('{{ __('dashboard.confirm_delete') }}')" class="btn btn-danger btn-xs">
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
