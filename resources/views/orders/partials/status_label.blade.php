@php
    $statusClass = 'default';
    $statusText = $status;
    $statusIcon = 'clock-o';

    switch($status) {
        case 'pending':
        case 'pending_approval':
            $statusClass = 'warning';
            $statusText = 'قيد الانتظار';
            $statusIcon = 'hourglass-half';
            break;
        case 'accepted':
            $statusClass = 'info';
            $statusText = 'مقبول / جاري التجهيز';
            $statusIcon = 'cogs';
            break;
        case 'shipped':
            $statusClass = 'primary';
            $statusText = 'تم الشحن';
            $statusIcon = 'ship';
            break;
        case 'delivered':
            $statusClass = 'success';
            $statusText = 'تم التسليم';
            $statusIcon = 'check-circle';
            break;
        case 'rejected':
            $statusClass = 'danger';
            $statusText = 'مرفوض';
            $statusIcon = 'times-circle';
            break;
        case 'cancelled':
            $statusClass = 'default';
            $statusText = 'ملغي';
            $statusIcon = 'ban';
            break;
    }
@endphp
<span class="label label-{{ $statusClass }}" style="font-size: 13px; padding: 5px 10px;">
    <i class="fa fa-{{ $statusIcon }}"></i> {{ $statusText }}
</span>
