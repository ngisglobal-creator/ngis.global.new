@extends('layouts.master')

@section('title', __('dashboard.edit_wallet') . ': ' . $user->name)

@section('content')
<section class="content-header">
  <h1>{{ __('dashboard.edit_wallet') }}: <strong>{{ $user->name }}</strong></h1>
</section>

<section class="content">
  <div class="row">
    <div class="col-md-6 col-md-offset-3">
      <div class="box box-warning">
        <div class="box-header with-border text-center">
           <img src="{{ $user->avatar_url }}" class="img-circle" style="width: 100px; height: 100px; border: 3px solid #f39c12; margin-bottom: 15px;">
           <h3 class="box-title" style="display: block;">{{ $user->name }}</h3>
           <p class="text-muted">{{ \App\Http\Controllers\Admin\UserController::userTypes()[$user->type] ?? $user->type }}</p>
        </div>
        <div class="box-body">
          <form action="{{ route('admin.wallets.update', ['user' => $user->id]) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group">
              <label>{{ __('dashboard.current_balance_value') ?? 'Current Balance Value' }}</label>
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-money"></i></span>
                <input type="number" step="0.01" name="wallet_balance" class="form-control input-lg" value="{{ old('wallet_balance', $user->wallet_balance) }}" required placeholder="0.00">
              </div>
              <p class="help-block">{{ __('dashboard.wallet_help_text') ?? 'Enter the total financial value you want to assign to this user.' }}</p>
            </div>

            <div class="box-footer text-center" style="background: transparent;">
              <button type="submit" class="btn btn-warning btn-lg px-5 text-bold"><i class="fa fa-save"></i> {{ __('dashboard.save_balance') ?? 'Save Balance' }}</button>
              <a href="{{ route('admin.wallets.index') }}" class="btn btn-default btn-lg px-5">{{ __('dashboard.cancel') }}</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
