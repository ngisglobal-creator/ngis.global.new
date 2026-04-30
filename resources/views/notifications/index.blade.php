@extends(auth()->user()->panel_type == 'admin' ? 'layouts.master' : (view()->exists(auth()->user()->panel_type . '.layouts.master') ? auth()->user()->panel_type . '.layouts.master' : 'layouts.master'))

@section('title', 'الإشعارات')

@section('content')
<section class="content-header">
    <h1>الإشعارات <small>أحدث التنبيهات والطلبات</small></h1>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">قائمة الإشعارات</h3>
                    <div class="box-tools pull-left">
                        <form action="{{ route(auth()->user()->panel_type . '.notifications.mark-all-as-read') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-default btn-sm">تحديد الكل كمقروء</button>
                        </form>
                    </div>
                </div>
                <div class="box-body">
                    <ul class="products-list product-list-in-box">
                        @forelse($notifications as $notification)
                            <li class="item {{ $notification->unread() ? 'unread-notification' : '' }}" style="{{ $notification->unread() ? 'background: #fdfdfd; border-right: 3px solid #3c8dbc;' : '' }}">
                                <div class="product-img">
                                    @if(auth()->user()->type == 'client' && isset($notification->data['product_image']))
                                        <img src="{{ $notification->data['product_image'] }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;" alt="Product Image">
                                    @else
                                        <img src="{{ $notification->data['user_avatar'] ?? asset('dist/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">
                                    @endif
                                </div>
                                <div class="product-info">
                                    <a href="{{ route(auth()->user()->panel_type . '.notifications.show', $notification->id) }}" class="product-title">
                                        @if(auth()->user()->type == 'client' && isset($notification->data['product_name']))
                                            {{ $notification->data['product_name'] }}
                                        @else
                                            {{ $notification->data['user_name'] }}
                                        @endif
                                        <span class="label label-info pull-left">{{ $notification->created_at->diffForHumans() }}</span>
                                    </a>
                                    <span class="product-description">
                                        {{ $notification->data['message'] }}
                                    </span>
                                </div>
                            </li>
                        @empty
                            <p class="text-center padding">لا توجد إشعارات حالياً.</p>
                        @endforelse
                    </ul>
                    <div class="text-center">
                        {{ $notifications->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.unread-notification { font-weight: bold; }
.product-list-in-box > .item { padding: 15px; border-bottom: 1px solid #f4f4f4; }
.product-list-in-box > .item:last-child { border-bottom: 0; }
</style>
@endsection
