@php
    // If $orderStatuses is not passed, fetch it.
    if (!isset($orderStatuses)) {
        $orderStatuses = \App\Models\OrderStatus::orderBy('id')->get();
    }

    $currentStep = 1;
    $isRejected = false;

    // Map string statuses to step numbers
    if ($order->status == 'pending') {
        $currentStep = 1;
    } elseif ($order->status == 'pending_approval') {
        $currentStep = 2;
    } elseif ($order->status == 'accepted') {
        $currentStep = 3;
    } elseif ($order->status == 'rejected') {
        $currentStep = 4;
        $isRejected = true;
    } elseif ($order->status == 'office_review') {
        $currentStep = 5;
    } elseif ($order->status == 'manufacturing') {
        $currentStep = 6;
    } elseif ($order->status == 'ready') {
        $currentStep = 7;
    }
@endphp

<div class="stepper-container" dir="rtl">
    <!-- The Line -->
    <div class="stepper-line"></div>
    <!-- The Active Line -->
    @php
        $totalSteps = count($orderStatuses);
        $progressPercentage = $totalSteps > 1 ? (($currentStep - 1) / ($totalSteps - 1)) * 100 : 0;
        $activeColor = $isRejected ? '#d9534f' : '#f39c12';
    @endphp
    <div class="stepper-line-active" style="width: {{ $progressPercentage }}%; background-color: {{ $activeColor }};"></div>

    <!-- The Steps -->
    @foreach($orderStatuses as $index => $statusObj)
        @php
            $stepNum = $index + 1;
            $stepClass = '';
            if ($stepNum < $currentStep) {
                $stepClass = 'completed';
            } elseif ($stepNum == $currentStep) {
                $stepClass = $isRejected ? 'rejected active' : 'active';
            }
        @endphp
        <div class="stepper-step {{ $stepClass }}">
            <div class="icon-circle">
                @if($statusObj->image)
                    <img src="{{ asset('storage/' . $statusObj->image) }}" alt="{{ $statusObj->name_ar }}">
                @else
                    <i class="fa fa-circle"></i>
                @endif
            </div>
            <div class="stepper-title">{{ $statusObj->name_ar }}</div>
        </div>
    @endforeach
</div>

<style>
/* Stepper UI Shared Styles */
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
    background-color: #e0e0e0;
    z-index: 1;
}
.stepper-line-active {
    position: absolute;
    top: 35px;
    right: 40px; /* starts from right in RTL */
    height: 4px;
    z-index: 2;
    transition: width 0.5s ease;
}
.stepper-step {
    position: relative;
    z-index: 3;
    text-align: center;
    width: 12%; /* dynamically spacing up to 7 steps */
}
.stepper-step .icon-circle {
    display: inline-block;
    width: 76px;
    height: 76px;
    border-radius: 50%;
    background: #fff;
    border: 3px solid #e0e0e0;
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
    border-color: #3c8dbc;
    filter: none;
    opacity: 1;
}
.stepper-step.active .icon-circle {
    border-color: #f39c12;
    filter: none;
    opacity: 1;
    box-shadow: 0 4px 15px rgba(243, 156, 18, 0.4);
    transform: scale(1.1);
}
.stepper-step.rejected.active .icon-circle {
    border-color: #d9534f;
    box-shadow: 0 4px 15px rgba(217, 83, 79, 0.4);
}
.stepper-title {
    margin-top: 15px;
    font-size: 13px;
    font-weight: bold;
    color: #999;
    line-height: 1.4;
}
.stepper-step.completed .stepper-title {
    color: #3c8dbc;
}
.stepper-step.active .stepper-title {
    color: #f39c12;
}
.stepper-step.rejected.active .stepper-title {
    color: #d9534f;
}
</style>
