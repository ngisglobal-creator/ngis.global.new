@extends(view()->exists(auth()->user()->panel_type . '.layouts.master') ? auth()->user()->panel_type . '.layouts.master' : 'layouts.master')

@section('title', 'استقبال الطلبات')

@section('content')
<!-- Import modern font for numbers -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet">
@php
    $orderStatuses = \App\Models\OrderStatus::orderBy('id')->get();
@endphp
<section class="content-header">
    <h1>استقبال الطلبات <small>عرض طلبات العملاء لمنتجاتك</small></h1>
</section>

<section class="content">
                    @php
                        $heavyOrders = $orders->filter(fn($o) => $o->product->vehicle_group === 'heavy');
                        $standardOrders = $orders->filter(fn($o) => $o->product->vehicle_group !== 'heavy');
                    @endphp

                    @if($standardOrders->isNotEmpty())
                        <h4 style="font-weight: bold; color: #3c8dbc; margin-bottom: 20px;"><i class="fa fa-shopping-basket"></i> طلبات المنتجات العامة (Standard)</h4>
                        <table class="table table-bordered table-striped" style="margin-bottom: 40px;">
                            <thead>
                                <tr style="background: #f4f4f4;">
                                    <th>صورة المنتج</th>
                                    <th>اسم المنتج</th>
                                    <th>تفاصيل العميل</th>
                                    <th>المعلومات العامة</th>
                                    <th style="min-width: 380px;">نتائج اللوجستيات (سعة الحاوية المختارة المعتمدة للطلب)</th>
                                    <th>تاريخ الطلب</th>
                                    <th>الحالة</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($standardOrders as $order)
                                    <tr>
                                        <!-- Copy of original row for standard -->
                                        <td style="width: 100px;">
                                            @php $firstImage = $order->product->images->first(); @endphp
                                            <img src="{{ $firstImage ? asset('storage/' . $firstImage->image_path) : asset('dist/img/boxed-bg.jpg') }}" 
                                                 style="width: 80px; height: 80px; object-fit: cover; border-radius: 4px;">
                                        </td>
                                        <td>
                                            <strong style="font-size: 16px;">{{ $order->product->name }}</strong><br>
                                            <span class="text-muted english-nums">السعر: {{ number_format($order->product->price, 2) }} {{ $order->product->currency_code }}</span>
                                        </td>
                                        <td>
                                            <div style="display: flex; align-items: center;">
                                                <img src="{{ $order->user->avatar_url }}" class="img-circle" style="width: 40px; height: 40px; border: 1px solid #ddd;">
                                                <div style="margin-right: 10px;">
                                                    <strong style="display: block;">{{ $order->user->name }}</strong>
                                                    <small class="text-muted">{{ $order->user->email }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div style="background: #fff; border: 1px solid #e0e0e0; border-radius: 8px; padding: 12px; min-width: 350px;">
                                                <div style="display: flex; align-items: center; margin-bottom: 10px; border-bottom: 1px solid #f0f0f0; padding-bottom: 5px;">
                                                    <i class="fa fa-info-circle text-info" style="margin-left: 5px;"></i>
                                                    <span style="font-weight: bold; color: #444; font-size: 13px;">توزيع الطلب على وحدة الشحن المحددة ({{ $order->shipping_unit_type }})</span>
                                                </div>
                                                <div class="row text-center" style="display: flex; justify-content: space-between; margin: 0;">
                                                    <div style="flex: 1; border-left: 1px solid #eee;">
                                                        <div style="font-size: 11px; color: #888;">CBM</div>
                                                        <div style="font-weight: 800; color: #3c8dbc; font-size: 14px;" class="english-nums">{{ number_format($order->total_cbm, 3) }}</div>
                                                    </div>
                                                    <div style="flex: 1; border-left: 1px solid #eee;">
                                                        <div style="font-size: 11px; color: #888;">الوزن</div>
                                                        <div style="font-weight: 800; color: #f39c12; font-size: 14px;" class="english-nums">{{ $order->total_weight > 1000 ? number_format($order->total_weight / 1000, 2) . ' Ton' : number_format($order->total_weight) . ' KG' }}</div>
                                                    </div>
                                                    <div style="flex: 1; border-left: 1px solid #eee;">
                                                        <div style="font-size: 11px; color: #888;">كرتون</div>
                                                        <div style="font-weight: 800; color: #d9534f; font-size: 14px;" class="english-nums">{{ number_format($order->cartons_count) }}</div>
                                                    </div>
                                                    <div style="flex: 1; border-left: 1px solid #eee;">
                                                        <div style="font-size: 11px; color: #888;">قطع</div>
                                                        <div style="font-weight: 800; color: #28a745; font-size: 14px;" class="english-nums">{{ number_format($order->quantity) }}</div>
                                                    </div>
                                                    <div style="flex: 1;">
                                                        <div style="font-size: 11px; color: #888;">السعر الإجمالي</div>
                                                        <div style="font-weight: 800; color: #856404; font-size: 13px;" class="english-nums">{{ number_format($order->total_cost ?: ($order->quantity * $order->product->price), 2) }} <span style="font-size: 10px;">{{ $order->product->currency_code }}</span></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="english-nums">{{ $order->created_at->format('Y/m/d H:i') }}</td>
                                        <td>
                                            @include('orders.partials.status_label', ['status' => $order->status])
                                        </td>
                                        <td>
                                            <a href="{{ route('orders.received.show', $order) }}" class="btn btn-info btn-sm" title="عرض التفاصيل">
                                                <i class="fa fa-eye"></i> عرض
                                            </a>
                                            @if(in_array($order->status, ['pending', 'pending_approval']))
                                                <form action="{{ route('orders.update-status', $order) }}" method="POST" style="display: inline-block;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="accepted">
                                                    <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-check"></i> قبول</button>
                                                </form>
                                            @endif
                                            <form action="{{ route('orders.destroy', $order) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('هل أنت متأكد من حذف هذا الطلب؟ لا يمكن التراجع عن هذا الإجراء.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" title="حذف الطلب">
                                                    <i class="fa fa-trash"></i> حذف
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="9" style="background-color: #fcfcfc; padding: 25px 40px; border-bottom: 2px solid #3c8dbc;">
                                            @include('partials.order_stepper', ['order' => $order, 'orderStatuses' => $orderStatuses])
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif

                    @if($heavyOrders->isNotEmpty())
                        <h4 style="font-weight: bold; color: #c0392b; margin-bottom: 20px;"><i class="fa fa-truck"></i> طلبات المعدات الثقيلة (Heavy Equipment)</h4>
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr style="background: #fdf2f2;">
                                    <th>صورة المعدة</th>
                                    <th>اسم المعدة</th>
                                    <th>تفاصيل العميل</th>
                                    <th>المعلومات العامة</th>
                                    <th style="min-width: 380px;">نتائج اللوجستيات (سعة الشحن المختارة المعتمدة للطلب)</th>
                                    <th>تاريخ الطلب</th>
                                    <th>الحالة</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($heavyOrders as $order)
                                    <tr>
                                        <td style="width: 100px;">
                                            @php $firstImage = $order->product->images->first(); @endphp
                                            <img src="{{ $firstImage ? asset('storage/' . $firstImage->image_path) : asset('dist/img/boxed-bg.jpg') }}" 
                                                 style="width: 80px; height: 80px; object-fit: cover; border-radius: 4px; border: 1px solid #fee;">
                                        </td>
                                        <td>
                                            <strong style="font-size: 16px; color: #c0392b;">{{ $order->product->name }}</strong><br>
                                            <span class="text-muted english-nums">سعر الوحدة: {{ number_format($order->product->price, 2) }}</span>
                                        </td>
                                        <td>
                                            <div style="display: flex; align-items: center;">
                                                <img src="{{ $order->user->avatar_url }}" class="img-circle" style="width: 40px; height: 40px; border: 1px solid #ddd;">
                                                <div style="margin-right: 10px;">
                                                    <strong style="display: block;">{{ $order->user->name }}</strong>
                                                    <small class="text-muted">{{ $order->user->email }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div style="background: #fff; border: 1px solid #f5c6cb; border-radius: 8px; padding: 12px; min-width: 350px;">
                                                <div style="display: flex; align-items: center; margin-bottom: 10px; border-bottom: 1px solid #fbdfd3; padding-bottom: 5px;">
                                                    <i class="fa fa-truck text-danger" style="margin-left: 5px;"></i>
                                                    <span style="font-weight: bold; color: #c0392b; font-size: 13px;">توزيع الطلب على وحدة الشحن المحددة ({{ $order->shipping_unit_type }})</span>
                                                </div>
                                                <div class="row text-center" style="display: flex; justify-content: space-between; margin: 0;">
                                                    <div style="flex: 1; border-left: 1px solid #eee;">
                                                        <div style="font-size: 11px; color: #888;">CBM</div>
                                                        <div style="font-weight: 800; color: #3c8dbc; font-size: 14px;" class="english-nums">{{ number_format($order->total_cbm, 3) }}</div>
                                                    </div>
                                                    <div style="flex: 1; border-left: 1px solid #eee;">
                                                        <div style="font-size: 11px; color: #888;">الوزن</div>
                                                        <div style="font-weight: 800; color: #f39c12; font-size: 14px;" class="english-nums">{{ $order->total_weight > 1000 ? number_format($order->total_weight / 1000, 2) . ' Ton' : number_format($order->total_weight) . ' KG' }}</div>
                                                    </div>
                                                    <div style="flex: 1; border-left: 1px solid #eee;">
                                                        <div style="font-size: 11px; color: #888;">العدد</div>
                                                        <div style="font-weight: 800; color: #28a745; font-size: 14px;" class="english-nums">{{ number_format($order->quantity) }}</div>
                                                    </div>
                                                    <div style="flex: 1;">
                                                        <div style="font-size: 11px; color: #888;">السعر الإجمالي</div>
                                                        <div style="font-weight: 800; color: #856404; font-size: 13px;" class="english-nums">{{ number_format($order->total_cost ?: ($order->quantity * $order->product->price), 2) }} <span style="font-size: 10px;">{{ $order->product->currency_code }}</span></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="english-nums">{{ $order->created_at->format('Y/m/d H:i') }}</td>
                                        <td>
                                            @include('orders.partials.status_label', ['status' => $order->status])
                                        </td>
                                        <td>
                                            <a href="{{ route('orders.received.show', $order) }}" class="btn btn-info btn-sm" title="عرض التفاصيل">
                                                <i class="fa fa-eye"></i> عرض
                                            </a>
                                            @if(in_array($order->status, ['pending', 'pending_approval']))
                                                <form action="{{ route('orders.update-status', $order) }}" method="POST" style="display: inline-block;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="accepted">
                                                    <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-check"></i> قبول</button>
                                                </form>
                                            @endif
                                            <form action="{{ route('orders.destroy', $order) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('هل أنت متأكد من حذف هذا الطلب؟ لا يمكن التراجع عن هذا الإجراء.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" title="حذف الطلب">
                                                    <i class="fa fa-trash"></i> حذف
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="9" style="background-color: #fffaf0; padding: 25px 40px; border-bottom: 2px solid #c0392b;">
                                            @include('partials.order_stepper', ['order' => $order, 'orderStatuses' => $orderStatuses])
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif

                    @if($orders->isEmpty())
                        <div class="text-center" style="padding: 50px;">
                            <i class="fa fa-folder-open-o" style="font-size: 80px; color: #eee;"></i>
                            <h4 class="text-muted">لا توجد طلبات مستلمة حتى الآن.</h4>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    function convertToWesternNumerals(str) {
        const arabicNumerals = [/٠/g, /١/g, /٢/g, /٣/g, /٤/g, /٥/g, /٦/g, /٧/g, /٨/g, /٩/g];
        const westernNumerals = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        if (typeof str === 'string') {
            for (let i = 0; i < 10; i++) {
                str = str.replace(arabicNumerals[i], westernNumerals[i]);
            }
        }
        return str;
    }

    function processTextNodes(node) {
        if (node.nodeName === 'SCRIPT' || node.nodeName === 'STYLE') return;
        if (node.nodeType === 3) {
            const originalValue = node.nodeValue;
            const convertedValue = convertToWesternNumerals(originalValue);
            if (originalValue !== convertedValue) {
                node.nodeValue = convertedValue;
            }
        } else {
            for (var i = 0; i < node.childNodes.length; i++) {
                processTextNodes(node.childNodes[i]);
            }
        }
    }

    processTextNodes(document.body);
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            mutation.addedNodes.forEach(function(node) {
                processTextNodes(node);
            });
        });
    });
    observer.observe(document.body, { childList: true, subtree: true });
});
</script>
<style>
.english-nums {
    font-family: 'Inter', sans-serif !important;
}
</style>
@endpush
