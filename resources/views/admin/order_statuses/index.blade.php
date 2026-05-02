@extends('layouts.master')

@section('title', __('dashboard.manage_order_statuses'))

@section('content')
<section class="content-header">
  <h1>
    {{ __('dashboard.order_statuses') }}
    <small>{{ __('dashboard.all_statuses') }}</small>
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
      <a href="{{ route('admin.order-statuses.create') }}" class="btn btn-primary btn-sm">
        <i class="fa fa-plus"></i> {{ __('dashboard.add_new_status') }}
      </a>
    </div>
    <div class="box-body">
      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>#</th>
            <th>{{ __('dashboard.image') }}</th>
            <th>{{ __('dashboard.name_ar') }}</th>
            <th>{{ __('dashboard.name_en') }}</th>
            <th>{{ __('dashboard.name_zh') }}</th>
            <th style="width: 150px;">{{ __('dashboard.actions') }}</th>
          </tr>
        </thead>
        <tbody>
          @foreach($statuses as $status)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>
              @if($status->image)
                <img src="{{ asset('storage/' . $status->image) }}" alt="" style="width: 50px; height: 50px; object-fit: cover;">
              @else
                <span class="text-muted">{{ __('dashboard.no_image') }}</span>
              @endif
            </td>
            <td>{{ $status->name_ar }}</td>
            <td>{{ $status->name_en }}</td>
            <td>{{ $status->name_zh }}</td>
            <td>
              <a href="{{ route('admin.order-statuses.edit', $status->id) }}" class="btn btn-primary btn-xs">
                <i class="fa fa-edit"></i> {{ __('dashboard.edit') }}
              </a>
              <form action="{{ route('admin.order-statuses.destroy', $status->id) }}" method="POST" style="display:inline-block">
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
