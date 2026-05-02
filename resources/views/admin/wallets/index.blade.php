@extends('layouts.master')

@section('title', __('dashboard.wallets_management'))

@section('content')
<section class="content-header">
  <h1>{{ __('dashboard.wallets_management') }}</h1>
</section>

<section class="content">
  <div class="row">
    <div class="col-md-3">
      <div class="info-box bg-aqua">
        <span class="info-box-icon"><i class="fa fa-google-wallet"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">{{ __('dashboard.total_wallet_balances') }}</span>
          <span class="info-box-number" style="font-family: 'Arial', sans-serif; direction: ltr;">
            {{ number_format($totalBalance, 2, '.', '') }}
          </span>
        </div>
      </div>
    </div>
  </div>

  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">{{ __('dashboard.all_users') }}</h3>
    </div>
    <div class="box-body">
      <div class="table-responsive">
        <table class="table table-bordered table-striped datatable">
          <thead>
            <tr>
              <th>{{ __('dashboard.image') }}</th>
              <th>{{ __('dashboard.name') }}</th>
              <th>{{ __('dashboard.type') }}</th>
              <th>{{ __('dashboard.business_zones') }}</th>
              <th>{{ __('dashboard.country') }}</th>
              <th>{{ __('dashboard.current_balance') }}</th>
              <th>{{ __('dashboard.actions') }}</th>
            </tr>
          </thead>
          <tbody>
            @foreach($users as $user)
            <tr>
              <td>
                <img src="{{ $user->avatar_url }}" class="img-circle" style="width: 40px; height: 40px; object-fit: cover;">
              </td>
              <td>{{ $user->name }}</td>
              <td>{{ \App\Http\Controllers\Admin\UserController::userTypes()[$user->type] ?? $user->type }}</td>
              <td>
                @if($user->country && $user->country->geographicZones->count() > 0)
                  @foreach($user->country->geographicZones as $zone)
                    <span class="label label-info">{{ $zone->{'name_'.app()->getLocale()} ?? $zone->name_ar }}</span>
                  @endforeach
                @else
                  <span class="text-muted">{{ __('dashboard.not_specified') }}</span>
                @endif
              </td>
              <td>
                @if($user->country)
                  <img src="{{ asset('vendor/flag-icons/flags/4x3/' . $user->country->flag_code . '.svg') }}" style="width: 20px; vertical-align: middle;">
                  {{ $user->country->{'name_'.app()->getLocale()} ?? $user->country->name_ar }}
                @else
                  -
                @endif
              </td>
              <td>
                <span style="font-size: 20px; font-weight: bold; color: #000; font-family: 'Arial', sans-serif; direction: ltr; display: inline-block;">
                  {{ number_format($user->wallet_balance, 2, '.', '') }}
                </span>
              </td>
              <td>
                <a href="{{ route('admin.wallets.edit', $user->id) }}" class="btn btn-warning btn-xs">
                  <i class="fa fa-edit"></i> {{ __('dashboard.edit_wallet') }}
                </a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>
@endsection

@push('scripts')
<script>
  $(function () {
    $('.datatable').DataTable({
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false,
      'language': {
          "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/{{ app()->getLocale() == 'ar' ? 'Arabic' : (app()->getLocale() == 'zh' ? 'Chinese' : 'English') }}.json"
      }
    });
  });
</script>
@endpush
