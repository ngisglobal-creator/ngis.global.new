<div class="box box-widget widget-user-2 product-card" 
     onclick="window.location.href='{{ isset($public_view) && $public_view ? route('home.products.show', $product->id) : route('site.products.show', $product->id) }}'"
     style="cursor: pointer; border: 1px solid #ddd; border-radius: 8px; transition: transform 0.3s; box-shadow: 0 2px 5px rgba(0,0,0,0.1); background: #fff; margin-bottom: 20px;">
    
    <div class="widget-user-header" style="padding: 0; position: relative; overflow: hidden;">
        @php $firstImage = $product->images->first(); @endphp
        <div class="product-img-wrapper" style="height: 180px; overflow: hidden; border-top-left-radius: 8px; border-top-right-radius: 8px;">
            <img class="zoom-img" src="{{ $firstImage ? asset('storage/' . $firstImage->image_path) : asset('dist/img/boxed-bg.jpg') }}" 
                 style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94);">
        </div>
        @if(isset($isRecommended) && $isRecommended)
            <span class="label label-warning" style="position: absolute; top: 10px; right: 10px; padding: 5px 10px; font-size: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.2); z-index: 10;">
                <i class="fa fa-star"></i> مقترح لك
            </span>
        @endif

        {{-- Product Type Badge --}}
        @if($product->vehicle_group === 'light')
            <span class="label label-warning" style="position: absolute; top: 10px; left: 10px; padding: 5px 10px; font-size: 11px; box-shadow: 0 2px 4px rgba(0,0,0,0.2); z-index: 10; font-weight: bold;">
                <i class="fa fa-car"></i> مركبة خفيفة
            </span>
        @elseif($product->vehicle_group === 'heavy')
            <span class="label label-danger" style="position: absolute; top: 10px; left: 10px; padding: 5px 10px; font-size: 11px; box-shadow: 0 2px 4px rgba(0,0,0,0.2); z-index: 10; font-weight: bold;">
                <i class="fa fa-truck"></i> معدات ثقيلة
            </span>
        @else
            <span class="label label-default" style="position: absolute; top: 10px; left: 10px; padding: 5px 10px; font-size: 11px; box-shadow: 0 2px 4px rgba(0,0,0,0.2); z-index: 10; font-weight: bold; background-color: rgba(100, 100, 100, 0.7) !important;">
                <i class="fa fa-cube"></i> منتج عادي
            </span>
        @endif
    </div>
    
    <div class="box-footer" style="padding: 15px; background: #fff; border-bottom-left-radius: 8px; border-bottom-right-radius: 8px;">
        <h4 style="font-weight: bold; margin-top: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; color: #333;" title="{{ $product->name }}">
            {{ $product->name }}
        </h4>
        <div style="margin-bottom: 10px;">
            <span class="label label-info">{{ $product->sector->name_ar }}</span>
            <span class="pull-left" style="font-weight: 900; color: #000; font-size: 20px; direction: ltr; display: inline-block; font-family: 'Inter', 'Roboto', sans-serif;">
                {{ number_format($product->price, 2, '.', '') }} <small style="font-size: 13px; color: #555;">{{ $product->currency_code }}</small>
            </span>
        </div>
        <p class="text-muted" style="height: 40px; overflow: hidden; font-size: 13px; line-height: 1.4; margin-bottom: 15px;">
            {{ Str::limit(strip_tags($product->description), 60) }}
        </p>
        <div style="margin-bottom: 10px; font-size: 13px; color: #555; display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
            <img src="{{ $product->user->avatar_url }}" class="img-circle" style="width: 24px; height: 24px; object-fit: cover; border: 1px solid #eee;">
            <a href="{{ route('home.profile', $product->user->id) }}" style="color: inherit; text-decoration: none;" class="manufacturer-link">
                <strong>{{ $product->user->name }}</strong>
            </a>
            @foreach($product->user->verifications as $verification)
                <img src="{{ $verification->image_url }}" title="{{ $verification->type }}" style="height: 18px; width: auto; object-fit: contain; vertical-align: middle;" alt="verified">
            @endforeach
        </div>
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <a href="{{ isset($public_view) && $public_view ? route('home.products.show', $product->id) : route('site.products.show', $product->id) }}" 
               class="btn btn-primary btn-sm btn-flat btn-detail-modal" 
               style="border-radius: 4px; padding: 5px 15px; font-weight: bold;"
               data-id="{{ $product->id }}"
               data-name="{{ $product->name }}"
               data-price="{{ number_format($product->price, 2, '.', '') }}"
               data-currency="{{ $product->currency_code }}"
               data-desc="{{ $product->description }}"
               data-qty="{{ $product->quantity }}"
               data-sector="{{ $product->sector->name_ar }}"
               data-images="{{ $product->images->map(fn($img) => asset('storage/' . $img->image_path)) }}">
                <i class="fa fa-eye"></i> عرض التفاصيل
            </a>
            <span class="text-muted" style="font-size: 11px;">
                <i class="fa fa-clock-o"></i> {{ $product->created_at->diffForHumans() }}
            </span>
        </div>
    </div>
</div>

<style>
    .product-card:hover .zoom-img {
        transform: scale(1.1);
    }
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 15px rgba(0,0,0,0.15) !important;
    }
</style>
