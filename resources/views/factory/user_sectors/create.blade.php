@extends('factory.layouts.master')

@section('title', __('dashboard.edit_sector_selection'))

@section('content')
<section class="content-header">
    <h1>
        {{ __('dashboard.select_sectors') }}
        <small>{{ __('dashboard.choose_sectors_desc') }}</small>
    </h1>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ __('dashboard.available_sectors') }}</h3>
                </div>
                
                <form action="{{ route('user-sectors.store') }}" method="POST">
                    @csrf
                    <div class="box-body">
                        <div class="form-group">
                            <label>{{ __('dashboard.choose_sectors_desc') }}</label>
                            <div class="row">
                                @foreach($allSectors as $sector)
                                    <div class="col-md-4">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="sector_ids[]" value="{{ $sector->id }}" 
                                                       {{ in_array($sector->id, $userSectorsIds) ? 'checked' : '' }}>
                                                {{ $sector->name_ar }} ({{ $sector->name_en }})
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary btn-lg">{{ __('dashboard.save') }}</button>
                        <a href="{{ route('user-sectors.index') }}" class="btn btn-default btn-lg">{{ __('dashboard.cancel') }}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
