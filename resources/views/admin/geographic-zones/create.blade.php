@extends('layouts.master')

@section('title', __('dashboard.add_new_zone'))

@section('content')
<section class="content-header">
    <h1>
        {{ __('dashboard.add_new_zone') }}
        <small>{{ __('dashboard.add_new_zone') }}</small>
    </h1>
</section>

<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">{{ __('dashboard.zone_data') }}</h3>
        </div>
        <form action="{{ route('admin.geographic-zones.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="box-body">

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group @error('name_ar') has-error @enderror">
                            <label>{{ __('dashboard.name_ar') }}</label>
                            <input type="text" name="name_ar" class="form-control" value="{{ old('name_ar') }}" placeholder="{{ __('dashboard.name_ar') }}" required>
                            @error('name_ar') <span class="help-block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group @error('name_en') has-error @enderror">
                            <label>{{ __('dashboard.name_en') }}</label>
                            <input type="text" name="name_en" class="form-control" value="{{ old('name_en') }}" placeholder="{{ __('dashboard.name_en') }}" required>
                            @error('name_en') <span class="help-block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group @error('name_zh') has-error @enderror">
                            <label>{{ __('dashboard.name_zh') }}</label>
                            <input type="text" name="name_zh" class="form-control" value="{{ old('name_zh') }}" placeholder="{{ __('dashboard.name_zh') }}" required>
                            @error('name_zh') <span class="help-block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group @error('image') has-error @enderror">
                    <label>{{ __('dashboard.zone_image') }}</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                    @error('image') <span class="help-block">{{ $message }}</span> @enderror
                </div>

                <div class="form-group @error('countries') has-error @enderror">
                    <label>{{ __('dashboard.associated_countries') }}</label>
                    <select name="countries[]" id="countries-select" class="form-control select2-countries" multiple>
                        @foreach($countries as $country)
                            <option value="{{ $country->id }}"
                                    data-flag="{{ asset('vendor/flag-icons/flags/4x3/' . $country->flag_code . '.svg') }}"
                                    {{ in_array($country->id, old('countries', [])) ? 'selected' : '' }}>
                                {{ $country->{'name_'.app()->getLocale()} ?? $country->name_en }}
                            </option>
                        @endforeach
                    </select>
                    @error('countries') <span class="help-block">{{ $message }}</span> @enderror
                </div>

            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary">{{ __('dashboard.save') }}</button>
                <a href="{{ route('admin.geographic-zones.index') }}" class="btn btn-default">{{ __('dashboard.cancel') }}</a>
            </div>
        </form>
    </div>
</section>
@endsection

@push('styles')
<style>
    .country-option { display: flex; align-items: center; gap: 8px; }
    .country-option img { width: 22px; height: 16px; object-fit: cover; border-radius: 2px; }
    .select2-container--default .select2-results__option { padding: 6px 8px; }
    .select2-container { width: 100% !important; }
    .select2-container--default .select2-selection--multiple {
        min-height: 42px;
        border: 1px solid #ccd0d2;
        border-radius: 4px;
    }
</style>
@endpush

@push('scripts')
<script>
function formatCountry(option) {
    if (!option.id) return option.text;
    var flag = $(option.element).data('flag');
    return $('<span class="country-option"><img src="' + flag + '" onerror="this.style.display=\'none\'"> ' + option.text + '</span>');
}
$(function () {
    $('#countries-select').select2({
        placeholder: '{{ __('dashboard.select_countries') }}',
        allowClear: true,
        dir: '{{ app()->getLocale() == "ar" ? "rtl" : "ltr" }}',
        templateResult: formatCountry,
        templateSelection: formatCountry,
    });
});
</script>
@endpush
