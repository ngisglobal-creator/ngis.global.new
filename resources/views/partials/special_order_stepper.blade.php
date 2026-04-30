@php
    $steps = [
        ['status' => 'pending', 'label' => 'قيد المراجعة', 'image' => 'under_review.png', 'icon' => 'fa-clock-o'],
        ['status' => 'processing', 'label' => 'البحث الميداني', 'image' => 'office_review.png', 'icon' => 'fa-search'],
        ['status' => 'matched', 'label' => 'رفع المنتج', 'image' => 'approved.png', 'icon' => 'fa-upload'],
        ['status' => 'shipped', 'label' => 'جاري الشحن', 'image' => 'manufacturing.png', 'icon' => 'fa-truck'],
        ['status' => 'completed', 'label' => 'تم التسليم', 'image' => 'ready.png', 'icon' => 'fa-check-circle'],
    ];

    $statusOrder = ['pending', 'processing', 'matched', 'shipped', 'completed'];
    $currentStatusIndex = array_search($order->status, $statusOrder);
    if ($currentStatusIndex === false && $order->status != 'cancelled') {
        $currentStatusIndex = 0; // Default to first if not found
    }

    $isCancelled = $order->status == 'cancelled';
@endphp

<div class="stepper-container" dir="rtl">
    <!-- The Line -->
    <div class="stepper-line"></div>
    
    <!-- The Active Line -->
    @php
        $totalSteps = count($steps);
        if ($isCancelled) {
             $progressPercentage = 100; // Show full red line or just stop? Let's show red line.
             $activeColor = '#d9534f';
        } else {
             $progressPercentage = ($currentStatusIndex / ($totalSteps - 1)) * 100;
             $activeColor = '#00c0ef';
        }
    @endphp
    <div class="stepper-line-active" style="width: {{ $progressPercentage }}%; background-color: {{ $activeColor }};"></div>

    <!-- The Steps -->
    @foreach($steps as $index => $step)
        @php
            $stepClass = '';
            if ($isCancelled) {
                $stepClass = 'cancelled';
            } elseif ($index < $currentStatusIndex) {
                $stepClass = 'completed';
            } elseif ($index == $currentStatusIndex) {
                $stepClass = 'active';
            }
        @endphp
        <div class="stepper-step {{ $stepClass }}">
            <div class="icon-circle">
                @if(file_exists(public_path('storage/order_statuses/' . $step['image'])))
                    <img src="{{ asset('storage/order_statuses/' . $step['image']) }}" alt="{{ $step['label'] }}">
                @else
                    <i class="fa {{ $step['icon'] }}" style="font-size: 30px; margin-top: 15px; color: #cbd5e0;"></i>
                @endif
            </div>
            <div class="stepper-title">
                @if($step['status'] == 'matched')
                    @if(request()->is('global-forwarding/orders/custom*'))
                        <a href="{{ route('global_forwarding.orders.custom.upload_match', $order->id) }}" 
                           class="btn btn-xs btn-primary" 
                           style="border-radius: 10px; font-weight: bold; padding: 2px 10px; margin-top: -5px;">
                           رفع المنتج
                        </a>
                    @elseif(request()->is('client/special-orders*') && $order->matchedProducts->count() > 0)
                        <a href="{{ route('site.products.show', $order->matchedProducts->first()->id) }}" 
                           class="btn btn-xs btn-success" 
                           style="border-radius: 10px; font-weight: bold; padding: 2px 10px; margin-top: -5px;">
                           رؤية المنتج المطابق
                        </a>
                    @else
                        {{ $step['label'] }}
                    @endif
                @else
                    {{ $step['label'] }}
                @endif
            </div>
        </div>
    @endforeach
</div>

@if($isCancelled)
<div class="text-center" style="margin-top: 15px; color: #d9534f; font-weight: bold;">
    <i class="fa fa-times-circle"></i> نأسف، تم إلغاء هذا الطلب. راجع ملاحظات الإدارة للتفاصيل.
</div>
@endif

<style>
.stepper-container {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    position: relative;
    max-width: 100%;
    margin: 0 auto;
    direction: rtl;
}
.stepper-line {
    position: absolute;
    top: 35px;
    left: 40px;
    right: 40px;
    height: 4px;
    background-color: #e2e8f0;
    z-index: 1;
}
.stepper-line-active {
    position: absolute;
    top: 35px;
    right: 40px;
    height: 4px;
    z-index: 2;
    transition: width 0.5s ease;
}
.stepper-step {
    position: relative;
    z-index: 3;
    text-align: center;
    width: 18%;
}
.stepper-step .icon-circle {
    display: inline-block;
    width: 76px;
    height: 76px;
    border-radius: 50%;
    background: #fff;
    border: 3px solid #e2e8f0;
    padding: 8px;
    transition: all 0.3s ease;
    filter: grayscale(100%);
    opacity: 0.5;
}
.stepper-step .icon-circle img {
    width: 100%;
    height: 100%;
    object-fit: contain;
}
.stepper-step.completed .icon-circle {
    border-color: #00c0ef;
    filter: none;
    opacity: 1;
}
.stepper-step.active .icon-circle {
    border-color: #3c8dbc;
    filter: none;
    opacity: 1;
    box-shadow: 0 4px 15px rgba(60, 141, 188, 0.3);
    transform: scale(1.1);
}
.stepper-step.cancelled .icon-circle {
    border-color: #d9534f;
    filter: none;
    opacity: 0.7;
}
.stepper-title {
    margin-top: 15px;
    font-size: 13px;
    font-weight: bold;
    color: #a0aec0;
    line-height: 1.4;
}
.stepper-step.completed .stepper-title { color: #00c0ef; }
.stepper-step.active .stepper-title { color: #3c8dbc; }
.stepper-step.cancelled .stepper-title { color: #d9534f; }
</style>
