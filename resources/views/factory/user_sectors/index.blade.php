@extends('factory.layouts.master')

@section('title', __('dashboard.select_sectors'))

@section('content')
<section class="content-header">
    <h1>
        {{ __('dashboard.select_sectors') }}
        <small>{{ __('dashboard.sectors_you_work_in') }}</small>
    </h1>
</section>

<section class="content">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-check"></i> {{ __('dashboard.success') }}!</h4>
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ __('dashboard.my_data_and_sectors') }}</h3>
                    <div class="box-tools">
                        <a href="{{ route('user-sectors.create') }}" class="btn btn-sm btn-success">
                            <i class="fa fa-plus"></i> {{ __('dashboard.edit_sector_selection') }}
                        </a>
                    </div>
                </div>
                
                <div class="box-body">
                    <div class="user-block" style="margin-bottom: 20px; border-bottom: 1px solid #f4f4f4; padding-bottom: 15px;">
                        <img class="img-circle img-bordered-sm" 
                             src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('img/default-avatar.png') }}" 
                             alt="user image" style="width: 50px; height: 50px;">
                        <span class="username" style="font-size: 18px; margin-right: 15px;">
                            {{ $user->name }}
                        </span>
                        <span class="description" style="margin-right: 15px;">{{ $user->email }}</span>
                    </div>

                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>{{ __('dashboard.sector_name_ar') }}</th>
                                <th>{{ __('dashboard.sector_name_en') }}</th>
                                <th>{{ __('dashboard.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sectors as $sector)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $sector->name_ar }}</td>
                                    <td>{{ $sector->name_en }}</td>
                                    <td>
                                        <form action="{{ route('user-sectors.destroy', $sector->id) }}" method="POST" 
                                              onsubmit="return confirm('{{ __('dashboard.confirm_delete') }}');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-xs">
                                                <i class="fa fa-trash"></i> {{ __('dashboard.delete') }}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">{{ __('dashboard.no_sectors_selected') }}</td>
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
