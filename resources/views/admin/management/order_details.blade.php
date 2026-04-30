@extends('layouts.master')

@section('title', 'تفاصيل الطلب | ' . $order->product->name)

@section('content')
<section class="content-header">
    <h1>تفاصيل الطلب <small style="color: #000; font-family: Arial; font-weight: bold; font-size: 16px;">رقم #{{ $order->id }}</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> الرئيسية</a></li>
        <li><a href="{{ route('admin.clients.orders') }}">إدارة الطلبات</a></li>
        <li class="active">تفاصيل الطلب</li>
    </ol>
</section>

<section class="content">
    <div class="box box-solid" style="border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
        <div class="box-body" style="padding: 30px;">
            <div class="row">
                <!-- Product Gallery -->
                <div class="col-md-7">
                    <div class="row">
                        <!-- Vertical Thumbnails -->
                        <div class="col-md-2 hidden-xs hidden-sm">
                            <div class="thumbnails-container" style="display: flex; flex-direction: column; gap: 10px;">
                                @foreach($order->product->images as $index => $image)
                                    <img src="{{ asset('storage/' . $image->image_path) }}" 
                                         class="img-thumbnail thumb-gallery {{ $index === 0 ? 'active' : '' }}" 
                                         style="width: 100%; aspect-ratio: 1/1; object-fit: cover; cursor: pointer; border: 2px solid {{ $index === 0 ? '#3c8dbc' : '#eee' }}; transition: padding 0.2s;"
                                         onclick="changeMainImage(this, '{{ asset('storage/' . $image->image_path) }}')">
                                @endforeach
                            </div>
                        </div>
                        
                        <!-- Main Display Image -->
                        <div class="col-md-10">
                            <div id="main-image-display" class="zoom-container" style="border: 1px solid #eee; border-radius: 8px; overflow: hidden; width: 100%; aspect-ratio: 4/3; background: #fafafa; display: flex; align-items: center; justify-content: center; cursor: zoom-in; position: relative;">
                                @php $firstImage = $order->product->images->first(); @endphp
                                <img id="primaryImage" src="{{ $firstImage ? asset('storage/' . $firstImage->image_path) : asset('dist/img/boxed-bg.jpg') }}" 
                                     style="max-width: 100%; max-height: 100%; object-fit: contain; transition: transform 0.1s ease-out; transform-origin: center center;">
                            </div>
                            
                            <!-- Mobile Thumbnails -->
                            <div class="visible-xs visible-sm" style="margin-top: 15px;">
                                <div style="display: flex; gap: 10px; overflow-x: auto; padding-bottom: 10px;">
                                    @foreach($order->product->images as $image)
                                        <img src="{{ asset('storage/' . $image->image_path) }}" 
                                             class="img-thumbnail" 
                                             style="width: 80px; height: 80px; object-fit: cover; flex-shrink: 0;"
                                             onclick="document.getElementById('primaryImage').src = this.src">
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order & Product Information -->
                <div class="col-md-5">
                    <div style="padding: 0 15px;">
                        <span class="label label-info" style="font-size: 14px; padding: 5px 12px;">{{ $order->product->sector->name_ar }}</span>
                        <h2 style="font-weight: 900; color: #2c3e50; font-size: 32px; margin: 15px 0;">{{ $order->product->name }}</h2>
                        
                        <div style="margin-bottom: 25px;">
                            <span style="font-size: 48px; font-weight: 900; color: #000; direction: ltr; display: inline-block; font-family: 'Arial', sans-serif;">
                                {{ number_format($order->product->price, 2, '.', '') }} <small style="font-size: 22px; color: #000; font-weight: bold;">SAR</small>
                            </span>
                        </div>

                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#tab_product" data-toggle="tab">تفاصيل المنتج</a></li>
                                <li><a href="#tab_client" data-toggle="tab">بيانات العميل</a></li>
                                <li><a href="#tab_seller" data-toggle="tab">بيانات البائع</a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab_product">
                                    <p style="font-size: 16px; line-height: 1.6; color: #444;">{{ $order->product->description }}</p>
                                    <ul class="list-group list-group-unbordered">
                                        <li class="list-group-item">
                                            <b>الفرع</b> <a class="pull-left">{{ $order->product->branch->name_ar ?? 'N/A' }}</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>القسم</b> <a class="pull-left">{{ $order->product->category->name_ar ?? 'N/A' }}</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="tab-pane" id="tab_client">
                                    <div style="display: flex; align-items: center; margin-bottom: 15px;">
                                        <img src="{{ $order->user->avatar_url }}" class="img-circle" style="width: 60px; height: 60px; border: 2px solid #3c8dbc; margin-left: 15px;">
                                        <div>
                                            <h4 style="margin: 0; font-weight: bold;">{{ $order->user->name }}</h4>
                                            <p class="text-muted" style="margin: 0;">{{ $order->user->email }}</p>
                                        </div>
                                    </div>
                                    <ul class="list-group list-group-unbordered">
                                        <li class="list-group-item">
                                            <b>رقم الهاتف</b> <a class="pull-left">{{ $order->user->phone ?? 'غير متوفر' }}</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="tab-pane" id="tab_seller">
                                    <div style="display: flex; align-items: center; margin-bottom: 15px;">
                                        <img src="{{ $order->product->user->avatar_url }}" class="img-circle" style="width: 60px; height: 60px; border: 2px solid #f39c12; margin-left: 15px;">
                                        <div>
                                            <h4 style="margin: 0; font-weight: bold;">{{ $order->product->user->name }}</h4>
                                            <span class="label label-warning">{{ $order->product->user->type == 'company' ? 'شركة' : 'مصنع' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div style="margin-top: 25px; padding: 15px; background: #f8f9fa; border-radius: 8px; border-right: 5px solid 
                            @if($order->status == 'pending') #f39c12 @elseif($order->status == 'accepted') #00a65a @else #dd4b39 @endif">
                            <h4 style="margin-top: 0; font-weight: bold;">حالة الطلب</h4>
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <span>
                                    @if($order->status == 'pending')
                                        <span class="label label-warning" style="font-size: 14px;">قيد الانتظار</span>
                                    @elseif($order->status == 'accepted')
                                        <span class="label label-success" style="font-size: 14px;">تم القبول</span>
                                    @else
                                        <span class="label label-danger" style="font-size: 14px;">تم الرفض</span>
                                    @endif
                                </span>
                                <span class="text-muted"><i class="fa fa-calendar"></i> {{ $order->created_at->format('Y-m-d H:i') }}</span>
                            </div>
                        </div>

                        <div style="margin-top: 30px; display: flex; gap: 10px;">
                            <form action="{{ route('admin.clients.orders.destroy', $order) }}" method="POST" style="flex: 1;" onsubmit="return confirm('هل أنت متأكد من حذف هذا الطلب؟');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-lg btn-block btn-flat" style="border-radius: 6px; font-weight: bold;">
                                    <i class="fa fa-trash"></i> حذف الطلب
                                </button>
                            </form>
                            <a href="{{ route('admin.clients.orders') }}" class="btn btn-default btn-lg btn-flat" style="flex: 1; border-radius: 6px;">
                                <i class="fa fa-arrow-right"></i> رجوع للقائمة
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
function changeMainImage(el, src) {
    document.getElementById('primaryImage').src = src;
    $('.thumb-gallery').css('border-color', '#eee').removeClass('active');
    $(el).css('border-color', '#3c8dbc').addClass('active');
}

$(document).ready(function() {
    const container = document.getElementById('main-image-display');
    const img = document.getElementById('primaryImage');

    container.addEventListener('mousemove', (e) => {
        const xPercent = (e.offsetX / container.offsetWidth) * 100;
        const yPercent = (e.offsetY / container.offsetHeight) * 100;
        img.style.transformOrigin = `${xPercent}% ${yPercent}%`;
        img.style.transform = "scale(2)";
    });

    container.addEventListener('mouseleave', () => {
        img.style.transform = "scale(1)";
        img.style.transformOrigin = "center center";
    });
});
</script>
<style>
.thumb-gallery:hover { border-color: #3c8dbc !important; padding: 2px; }
.thumb-gallery.active { box-shadow: 0 0 10px rgba(60, 141, 188, 0.3); }
.zoom-container { overflow: hidden; }
.zoom-container img { pointer-events: none; }
.nav-tabs-custom { box-shadow: none; border: 1px solid #f0f0f0; border-radius: 8px; margin-top: 20px; }
.nav-tabs-custom > .nav-tabs { border-bottom-color: #f4f4f4; }
.nav-tabs-custom > .nav-tabs > li.active { border-top-color: #3c8dbc; }
</style>
@endpush
@endsection
