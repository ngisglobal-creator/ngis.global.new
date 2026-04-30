@extends('layouts.public')

@section('title', $product->name . ' | تفاصيل المنتج')

@section('content')
<!-- Import modern font for numbers -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet">
<section class="content-header">
    <h1 dir="rtl">تفاصيل المنتج <small>{{ $product->name }}</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-home"></i> الرئيسية</a></li>
        <li><a href="{{ route('home.products') }}">المنتجات</a></li>
        <li class="active">تفاصيل المنتج</li>
    </ol>
</section>

<section class="content" dir="rtl">
    <div class="box box-solid" style="border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
        <div class="box-body" style="padding: 30px;">
            <div class="row">
                <!-- Product Gallery -->
                <div class="col-md-7">
                    <div class="row">
                        <!-- Vertical Thumbnails -->
                        <div class="col-md-2 hidden-xs hidden-sm">
                            <div class="thumbnails-container" style="display: flex; flex-direction: column; gap: 10px;">
                                @foreach($product->images as $index => $image)
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
                                @php $firstImage = $product->images->first(); @endphp
                                <img id="primaryImage" src="{{ $firstImage ? asset('storage/' . $firstImage->image_path) : asset('dist/img/boxed-bg.jpg') }}" 
                                     style="max-width: 100%; max-height: 100%; object-fit: contain; transition: transform 0.1s ease-out; transform-origin: center center;">
                            </div>
                            
                            <!-- Mobile Thumbnails -->
                            <div class="visible-xs visible-sm" style="margin-top: 15px;">
                                <div style="display: flex; gap: 10px; overflow-x: auto; padding-bottom: 10px;">
                                    @foreach($product->images as $image)
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

                <!-- Product Information -->
                <div class="col-md-5">
                    <div style="padding: 0 15px;">
                        <span class="label label-info" style="font-size: 14px; padding: 5px 12px;">{{ $product->sector->name_ar }}</span>
                        <h2 style="font-weight: 900; color: #2c3e50; font-size: 32px; margin: 15px 0;">{{ $product->name }}</h2>
                        
                        <div style="margin-bottom: 25px;">
                            <span style="font-size: 48px; font-weight: 900; color: #000; direction: ltr; display: inline-block; font-family: 'Inter', sans-serif;" class="english-nums">
                                {{ number_format($product->price, 2, '.', '') }} <small style="font-size: 22px; color: #333;">{{ $product->currency_code }}</small>
                            </span>
                        </div>

                        <div style="background: #fdfdfd; padding: 20px; border-radius: 8px; border: 1px solid #f0f0f0; margin-bottom: 25px;">
                            <h4 style="font-weight: bold; color: #555; margin-top: 0; border-bottom: 2px solid #3c8dbc; display: inline-block; padding-bottom: 5px;">وصف المنتج</h4>
                            <div style="font-size: 17px; line-height: 1.8; color: #444; text-align: justify; margin-top: 15px;">
                                {!! $product->description !!}
                            </div>
                        </div>

                        <ul class="list-group list-group-unbordered">
                            <li class="list-group-item">
                                <b>الفرع</b> <span class="pull-left">{{ $product->branch->name_ar ?? 'N/A' }}</span>
                            </li>
                            <li class="list-group-item">
                                <b>القسم</b> <span class="pull-left">{{ $product->category->name_ar ?? 'N/A' }}</span>
                            </li>
                            <li class="list-group-item">
                                <b>الحد الأدنى للطلبية</b> <span class="pull-left text-bold english-nums" style="font-size: 16px;">{{ number_format($product->min_order_quantity) }}</span>
                            </li>
                            <li class="list-group-item">
                                <b>وحدة الشحن</b> <span class="pull-left">{{ $product->shipping_unit_type }}</span>
                            </li>
                            <li class="list-group-item">
                                <b>الكمية المتاحة</b> <span class="pull-left text-bold text-primary english-nums" style="font-size: 18px; direction: ltr;">{{ number_format($product->quantity) }}</span>
                            </li>
                            <li class="list-group-item">
                                <b>الشركة المصنعة</b>
                                <span class="pull-left">
                                    <a href="{{ route('home.profile', $product->user->id) }}" style="color: inherit; font-weight: bold; text-decoration: none;" onmouseover="this.style.color='#3c8dbc'" onmouseout="this.style.color='inherit'">
                                        {{ $product->user->name }}
                                    </a>
                                    @foreach($product->user->verifications as $verification)
                                        <img src="{{ $verification->image_url }}" title="{{ $verification->type }}" style="height: 18px; vertical-align: middle;" alt="verified">
                                    @endforeach
                                </span>
                            </li>
                        </ul>

                        <div style="margin-top: 35px; display: flex; gap: 15px;">
                            @auth
                                <button id="btnOrderNow" class="btn btn-success btn-lg btn-flat" data-toggle="modal" data-target="#orderModal" style="flex: 2; border-radius: 6px; font-weight: bold; font-size: 20px;">
                                    <i class="fa fa-shopping-cart"></i> اطلب الآن
                                </button>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-primary btn-lg btn-flat" style="flex: 2; border-radius: 6px; font-weight: bold; font-size: 20px;">
                                    <i class="fa fa-sign-in"></i> سجل للدخول للطلب
                                </a>
                            @endauth
                            <a href="{{ route('home.products') }}" class="btn btn-default btn-lg btn-flat" style="flex: 1; border-radius: 6px;">
                                <i class="fa fa-arrow-right"></i> رجوع
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Specifications Sections -->
    <div class="row" style="margin-top: 30px;">
        <div class="col-md-12">
            <div class="box box-primary" style="border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border: none;">
                <div class="box-header with-border" style="background: #fcfcfc; border-radius: 12px 12px 0 0;">
                    <h3 class="box-title" style="font-weight: 800; color: #333;"><i class="fa fa-info-circle text-primary"></i> معلومات مخصصة</h3>
                </div>
                <div class="box-body no-padding">
                    @php $customInfo = is_array($product->custom_info) ? $product->custom_info : json_decode($product->custom_info, true); @endphp
                    @if($customInfo && isset($customInfo['headers']) && count($customInfo['headers']) > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" style="margin-bottom: 0;">
                                <thead style="background: #f4f7f9;">
                                    <tr>
                                        @foreach($customInfo['headers'] as $header)
                                            @if($header) <th style="padding: 15px;">{{ $header }}</th> @endif
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($customInfo['rows'] as $row)
                                        <tr>
                                            @foreach($row as $cell)
                                                <td style="padding: 12px 15px;" class="english-nums">{{ $cell }}</td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center" style="padding: 40px; color: #999;">لا توجد معلومات مخصصة.</div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="box box-info" style="border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border: none;">
                <div class="box-header with-border" style="background: #fcfcfc; border-radius: 12px 12px 0 0;">
                    <h3 class="box-title" style="font-weight: 800; color: #333;"><i class="fa fa-th-list text-info"></i> خصائص المنتج</h3>
                </div>
                <div class="box-body no-padding">
                    @php $catalog = is_array($product->product_catalog) ? $product->product_catalog : json_decode($product->product_catalog, true); @endphp
                    @if($catalog && isset($catalog['headers']) && count($catalog['headers']) > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" style="margin-bottom: 0;">
                                <thead style="background: #f0faff;">
                                    <tr>
                                        @foreach($catalog['headers'] as $header)
                                            @if($header) <th style="padding: 15px;">{{ $header }}</th> @endif
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($catalog['rows'] as $row)
                                        <tr>
                                            @foreach($row as $cell)
                                                <td style="padding: 12px 15px;" class="english-nums">{{ $cell }}</td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center" style="padding: 40px; color: #999;">لا توجد خصائص مضافة.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
        <div class="box box-default" style="margin-top: 40px; background: transparent; border: none; box-shadow: none;">
            <div class="box-header" style="padding: 10px 0;">
                <h3 class="box-title" style="font-weight: bold; font-size: 24px;">منتجات مشابهة</h3>
            </div>
            <div class="box-body" style="padding: 0;">
                <div class="row">
                    @foreach($relatedProducts as $related)
                        <div class="col-md-5th col-sm-6">
                            @include('client.products.partials.product_card', ['product' => $related, 'public_view' => true])
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</section>

<!-- Order Modal -->
<div class="modal fade" id="orderModal" tabindex="-1" role="dialog" aria-labelledby="orderModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="border-radius: 12px; overflow: hidden; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
            <div class="modal-header" style="background: linear-gradient(135deg, #00a65a 0%, #008d4c 100%); color: white; border-bottom: none; padding: 20px;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white; opacity: 1;"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="orderModalLabel" style="font-weight: 800; font-size: 20px;">
                    <i class="fa fa-shopping-basket"></i> إرسال طلب جديد
                </h4>
            </div>
            <form id="orderForm">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <div class="modal-body" style="padding: 30px; background: #fefefe;">
                    <div class="form-group">
                        <label style="font-weight: 700; color: #444; margin-bottom: 8px;">الكمية المطلوبة</label>
                        <input type="number" name="quantity" id="order_quantity" class="form-control"
                               value="{{ $product->min_order_quantity }}"
                               min="{{ $product->min_order_quantity }}"
                               required
                               style="height: 45px; border-radius: 6px; font-size: 18px; font-weight: bold;">
                        <small class="text-muted">الحد الأدنى للطلب: <span class="english-nums">{{ number_format($product->min_order_quantity) }}</span></small>
                    </div>

                    <div class="form-group" style="margin-top: 15px;">
                        <label style="font-weight: 700; color: #444; margin-bottom: 8px;">نوع الحاوية / وحدة الشحن</label>
                        <select name="shipping_unit_type" class="form-control" required style="height: 45px; border-radius: 6px; font-weight: 600;">
                            <option value="CBM" {{ $product->shipping_unit_type == 'CBM' ? 'selected' : '' }}>CBM (متر مكعب)</option>
                            <option value="20ft" {{ $product->shipping_unit_type == '20ft' ? 'selected' : '' }}>20ft (حاوية 20 قدم)</option>
                            <option value="40ft" {{ $product->shipping_unit_type == '40ft' ? 'selected' : '' }}>40ft (حاوية 40 قدم)</option>
                            <option value="60ft" {{ $product->shipping_unit_type == '60ft' ? 'selected' : '' }}>60ft (حاوية 60 قدم)</option>
                        </select>
                    </div>

                    <div class="form-group" style="margin-top: 15px;">
                        <label style="font-weight: 700; color: #444; margin-bottom: 8px;">ملاحظات إضافية</label>
                        <textarea name="notes" class="form-control" rows="4" placeholder="اكتب هنا أي تفاصيل أو مواصفات خاصة للطلب..." style="border-radius: 6px;"></textarea>
                    </div>

                    <div id="cost_estimate" style="margin-top: 20px; padding: 15px; background: #f0f7ff; border: 1px solid #d0e7ff; border-radius: 8px; text-align: center;">
                        <span style="font-weight: bold; color: #3c8dbc; font-size: 16px;">إجمالي التكلفة المتوقعة:</span>
                        <div id="total_cost_calc" class="english-nums" style="font-size: 24px; font-weight: 900; color: #2c3e50;">
                            {{ number_format($product->price * $product->min_order_quantity, 2) }} {{ $product->currency_code }}
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="background: #f9f9f9; border-top: 1px solid #eee; padding: 20px 30px;">
                    <button type="button" class="btn btn-default btn-lg" data-dismiss="modal" style="border-radius: 30px; padding: 8px 30px; font-weight: 600;">إلغاء</button>
                    <button type="submit" class="btn btn-success btn-lg" id="btnSubmitOrder" style="background: #00a65a; border: none; border-radius: 30px; padding: 8px 40px; font-weight: bold; box-shadow: 0 4px 10px rgba(0, 166, 90, 0.3);">
                        إرسال الطلب
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
        img.style.transform = "scale(1.5)";
    });

    container.addEventListener('mouseleave', () => {
        img.style.transform = "scale(1)";
        img.style.transformOrigin = "center center";
    });

    // Real-time cost calculation
    $('#order_quantity').on('input', function() {
        const qty = parseFloat($(this).val()) || 0;
        const price = parseFloat("{{ $product->price }}") || 0;
        const currency = "{{ $product->currency_code }}";
        const total = qty * price;
        $('#total_cost_calc').text(total.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2}) + ' ' + currency);
    });

    // AJAX Order Submission
    $('#orderForm').on('submit', function(e) {
        e.preventDefault();
        const btn = $('#btnSubmitOrder');
        const minQty = parseInt("{{ $product->min_order_quantity }}");
        const currentQty = parseInt($('#order_quantity').val());

        if (currentQty < minQty) {
            Swal.fire({
                icon: 'warning',
                title: 'خطأ في الكمية',
                text: 'الكمية يجب أن تكون أكبر من أو تساوي ' + minQty,
                confirmButtonText: 'حسناً'
            });
            return;
        }

        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> جاري الإرسال...');

        $.ajax({
            url: "{{ route('orders.store') }}",
            method: "POST",
            data: $(this).serialize(),
            success: function(response) {
                if(response.success) {
                    $('#orderModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'تم إرسال طلبك بنجاح!',
                        text: 'سيتم مراجعة طلبك من قبل التاجر قريباً.',
                        confirmButtonText: 'حسناً',
                        timer: 3000
                    }).then(() => {
                        location.reload();
                    });
                }
            },
            error: function(xhr) {
                btn.prop('disabled', false).text('إرسال الطلب');
                let errorMsg = 'حدث خطأ أثناء إرسال الطلب. يرجى المحاولة مرة أخرى.';
                if(xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                }
                Swal.fire({
                    icon: 'error',
                    title: 'فشل العملية',
                    text: errorMsg,
                    confirmButtonText: 'إغلاق'
                });
            }
        });
    });
});
</script>
<style>
.thumb-gallery:hover { border-color: #3c8dbc !important; padding: 2px; }
.thumb-gallery.active { box-shadow: 0 0 10px rgba(60, 141, 188, 0.3); }
.english-nums { font-family: 'Inter', sans-serif !important; }
.zoom-container { overflow: hidden; }
.zoom-container img { pointer-events: none; }
</style>
@endpush
@endsection
