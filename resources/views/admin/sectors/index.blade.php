@extends('layouts.master')

@section('title', __('dashboard.manage_sectors'))

@section('content')
<section class="content-header">
  <h1>
    {{ __('dashboard.manage_sectors') }}
    <small>{{ __('dashboard.all_sectors') }}</small>
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
      <a href="{{ route('admin.sectors.create') }}" class="btn btn-primary btn-sm">
        <i class="fa fa-plus"></i> {{ __('dashboard.add_sector') }}
      </a>
    </div>
    <div class="box-body">
      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>#</th>
            <th>{{ __('dashboard.name_ar') }}</th>
            <th>{{ __('dashboard.name_en') }}</th>
            <th>{{ __('dashboard.name_zh') }}</th>
            <th style="width: 150px;">{{ __('dashboard.actions') }}</th>
          </tr>
        </thead>
        <tbody>
          @foreach($sectors as $sector)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $sector->name_ar }}</td>
            <td>{{ $sector->name_en }}</td>
            <td>{{ $sector->name_zh }}</td>
            <td>
              <a href="{{ route('admin.sectors.edit', $sector->id) }}" class="btn btn-primary btn-xs">
                <i class="fa fa-edit"></i> {{ __('dashboard.edit') }}
              </a>
              <form action="{{ route('admin.sectors.destroy', $sector->id) }}" method="POST" style="display:inline-block">
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
