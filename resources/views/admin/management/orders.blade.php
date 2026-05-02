@extends('layouts.master')

@section('title', __('dashboard.customer_orders'))

@section('content')
<section class="content-header">
    <h1>{{ __('dashboard.manage_orders') }} <small>{{ __('dashboard.view_customer_orders_desc') }}</small></h1>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ __('dashboard.purchase_and_service_orders') }}</h3>
                </div>
                <div class="box-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h4><i class="icon fa fa-check"></i> {{ __('dashboard.success') }}!</h4>
                            {{ session('success') }}
                        </div>
                    @endif
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>{{ __('dashboard.customer_name') }}</th>
                                <th>{{ __('dashboard.product') }}</th>
                                <th>{{ __('dashboard.product_owner') }}</th>
                                <th>{{ __('dashboard.order_date') }}</th>
                                <th>{{ __('dashboard.status') }}</th>
                                <th>{{ __('dashboard.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                            <tr>
                                <td>
                                    <div style="display: flex; align-items: center;">
                                        <img src="{{ $order->user->avatar_url }}" class="img-circle" style="width: 35px; height: 35px; border: 1px solid #ddd;">
                                        <div style="margin-right: 8px;">
                                            <strong style="display: block; font-size: 13px;">{{ $order->user->name }}</strong>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <strong style="color: #3c8dbc;">{{ $order->product->name }}</strong><br>
                                    <small class="text-muted">{{ number_format($order->product->price, 2) }} ر.س</small>
                                </td>
                                <td>
                                    <strong>{{ $order->product->user->name }}</strong><br>
                                    <span class="label label-default" style="font-size: 10px;">{{ $order->product->user->type == 'company' ? (__('dashboard.company') ?? 'Company') : (__('dashboard.factory') ?? 'Factory') }}</span>
                                </td>
                                <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                                <td>
                                    @if($order->status == 'pending')
                                        <span class="label label-warning">{{ __('dashboard.pending_status') }}</span>
                                    @elseif($order->status == 'accepted')
                                        <span class="label label-success">{{ __('dashboard.accepted_status') }}</span>
                                    @else
                                        <span class="label label-danger">{{ __('dashboard.rejected_status') }}</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.clients.orders.show', $order) }}" class="btn btn-primary btn-xs" title="{{ __('dashboard.view') }}">
                                        <i class="fa fa-eye"></i> {{ __('dashboard.view') }}
                                    </a>
                                    @if($order->status == 'accepted' && !$order->assigned_to_regional)
                                    <a href="{{ route('admin.clients.orders.send-to-regional', $order) }}" class="btn btn-success btn-xs" title="{{ __('dashboard.send_to_regional') }}">
                                        <i class="fa fa-paper-plane"></i> {{ __('dashboard.send_to_regional') }}
                                    </a>
                                    @endif
                                    @if($order->assigned_to_regional)
                                        <span class="label label-info" style="margin-left: 5px;"><i class="fa fa-check"></i> {{ __('dashboard.sent_to_regional') }}</span>
                                    @endif
                                    <form action="{{ route('admin.clients.orders.destroy', $order) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('{{ __('dashboard.confirm_delete') }}');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-xs" title="{{ __('dashboard.delete') }}">
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
        </div>
    </div>
</section>
@endsection
