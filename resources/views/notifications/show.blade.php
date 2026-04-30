@extends(auth()->user()->panel_type == 'admin' ? 'layouts.master' : (view()->exists(auth()->user()->panel_type . '.layouts.master') ? auth()->user()->panel_type . '.layouts.master' : 'layouts.master'))

@section('title', 'تفاصيل الإشعار')

@section('content')
<section class="content-header">
    <h1>تفاصيل الإشعار <small>{{ $notification->data['user_name'] }}</small></h1>
</section>

<section class="content">
    <div class="box box-solid" style="border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
        <div class="box-body" style="padding: 30px;">
            <div class="row">
                <!-- User Info Column -->
                <div class="col-md-4">
                    <div class="box box-widget widget-user-2">
                        <div class="widget-user-header bg-primary" style="border-radius: 8px;">
                            <div class="widget-user-image">
                                <img class="img-circle" src="{{ $notification->data['user_avatar'] ?? asset('dist/img/user2-160x160.jpg') }}" alt="User Avatar" style="width: 70px; height: 70px; object-fit: cover;">
                            </div>
                            <h3 class="widget-user-username" style="margin-right: 85px;">{{ $notification->data['user_name'] }}</h3>
                            <h5 class="widget-user-desc" style="margin-right: 85px;">{{ $notification->data['user_type'] ?? 'عميل' }} - {{ $notification->data['user_country'] ?? '' }}</h5>
                        </div>
                        <div class="box-footer no-padding">
                            <ul class="nav nav-stacked">
                                <li><a><b>التاريخ</b> <span class="pull-left badge bg-blue">{{ $notification->created_at->format('Y-m-d H:i') }}</span></a></li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="box box-solid" style="background: #f8f9fa; border-radius: 8px; margin-top: 20px;">
                        <div class="box-body">
                            <h4 style="font-weight: bold; margin-bottom: 15px;">نص الإشعار</h4>
                            <p style="font-size: 16px; line-height: 1.6;">{{ $notification->data['message'] }}</p>
                        </div>
                    </div>
                </div>

                <!-- Product Detail Column -->
                <div class="col-md-8">
                    @if(isset($notification->data['product_id']))
                    <div class="box box-solid" style="border: 1px solid #f0f0f0; border-radius: 8px;">
                        <div class="box-header with-border">
                            <h3 class="box-title">تفاصيل المنتج المرتبط</h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-sm-5">
                                    <img src="{{ $notification->data['product_image'] ?? asset('dist/img/boxed-bg.jpg') }}" class="img-responsive img-bordered" style="border-radius: 8px; max-height: 300px; width: 100%; object-fit: cover;">
                                </div>
                                <div class="col-sm-7">
                                    <h2 style="margin-top: 0; font-weight: 900; color: #3c8dbc;">{{ $notification->data['product_name'] }}</h2>
                                    <hr>
                                    @if(isset($notification->data['order_id']))
                                        <p style="font-size: 18px;"><b>رقم الطلب:</b> <span class="label label-default">{{ $notification->data['order_id'] }}</span></p>
                                    @endif
                                    
                                    <div style="margin-top: 30px; display: flex; gap: 10px;">
                                        @if(isset($notification->data['action_url']))
                                            <a href="{{ $notification->data['action_url'] }}" class="btn btn-primary btn-lg btn-flat" style="border-radius: 6px; font-weight: bold; flex: 2;">
                                                <i class="fa fa-external-link"></i> عرض التفاصيل الكاملة
                                            </a>
                                        @endif
                                        <a href="{{ route(auth()->user()->panel_type . '.notifications.index') }}" class="btn btn-default btn-lg btn-flat" style="border-radius: 6px; flex: 1;">
                                            <i class="fa fa-arrow-right"></i> رجوع
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="alert alert-info">لا يوجد منتج مرتبط بهذا الإشعار.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
