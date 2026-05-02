@extends('layouts.master')

@section('title', __('dashboard.manage_geographic_zones'))

@section('content')
<section class="content-header">
    <h1>
        {{ __('dashboard.geographic_zones') }}
        <small>{{ __('dashboard.all_zones') }}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('admin') }}"><i class="fa fa-dashboard"></i> {{ __('dashboard.home') }}</a></li>
        <li class="active">{{ __('dashboard.geographic_zones') }}</li>
    </ol>
</section>

<section class="content">
    <div class="row" style="margin-bottom: 10px;">
        <div class="col-xs-12">
            <a href="{{ route('admin.geographic-zones.create') }}" class="btn btn-success">
                <i class="fa fa-plus"></i> {{ __('dashboard.add_new_zone') }}
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <h4><i class="icon fa fa-check"></i> {{ __('dashboard.success') }}!</h4>
        {{ session('success') }}
    </div>
    @endif

    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">{{ __('dashboard.all_zones') }}</h3>
                </div>
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>{{ __('dashboard.image') }}</th>
                            <th>{{ __('dashboard.name_ar') }}</th>
                            <th>{{ __('dashboard.name_en') }}</th>
                            <th>{{ __('dashboard.name_zh') }}</th>
                            <th>{{ __('dashboard.associated_countries') }}</th>
                            <th>{{ __('dashboard.actions') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($zones as $zone)
                        <tr>
                            <td>
                                @if($zone->image)
                                    @php
                                        $imgUrl = Str::startsWith($zone->image, 'vendor/')
                                            ? asset($zone->image)
                                            : Storage::url($zone->image);
                                    @endphp
                                    <img src="{{ $imgUrl }}" alt="{{ $zone->name_ar }}"
                                         style="width:60px;height:42px;object-fit:cover;border-radius:4px;border:1px solid #ddd;">
                                @else
                                    <span class="label label-default">{{ __('dashboard.no_image') }}</span>
                                @endif
                            </td>
                            <td><strong>{{ $zone->name_ar }}</strong></td>
                            <td>{{ $zone->name_en }}</td>
                            <td>{{ $zone->name_zh }}</td>
                            <td>
                                <div style="display:flex;flex-wrap:wrap;gap:4px;max-width:300px;">
                                    @foreach($zone->countries->take(8) as $country)
                                        <span title="{{ $country->{'name_'.app()->getLocale()} ?? $country->name_en }}" style="display:inline-flex;align-items:center;background:#f4f4f4;border:1px solid #ddd;border-radius:3px;padding:2px 5px;font-size:11px;gap:4px;">
                                            <img src="{{ asset('vendor/flag-icons/flags/4x3/' . $country->flag_code . '.svg') }}"
                                                 style="width:16px;height:12px;object-fit:cover;border-radius:1px;">
                                            {{ $country->{'name_'.app()->getLocale()} ?? $country->name_en }}
                                        </span>
                                    @endforeach
                                    @if($zone->countries->count() > 8)
                                        <span class="label label-info">+{{ $zone->countries->count() - 8 }} {{ __('dashboard.other') }}</span>
                                    @endif
                                    @if($zone->countries->isEmpty())
                                        <span class="text-muted" style="font-size:12px;">{{ __('dashboard.no_countries_found') }}</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <a href="{{ route('admin.geographic-zones.edit', $zone->id) }}" class="btn btn-warning btn-xs">
                                    <i class="fa fa-edit"></i> {{ __('dashboard.edit') }}
                                </a>
                                <form action="{{ route('admin.geographic-zones.destroy', $zone->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-xs"
                                             onclick="return confirm('{{ __('dashboard.confirm_delete') }}')">
                                        <i class="fa fa-trash"></i> {{ __('dashboard.delete') }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">{{ __('dashboard.no_zones_found') }}</td>
                        </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    $(function () {
        $('.select2-countries').select2({
            placeholder: 'اختر الدول...',
            allowClear: true,
            dir: 'rtl',
        });
    });
</script>
@endpush
