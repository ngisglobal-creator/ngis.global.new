@extends(auth()->user()->panel_type == 'admin' ? 'layouts.master' : (view()->exists(auth()->user()->panel_type . '.layouts.master') ? auth()->user()->panel_type . '.layouts.master' : 'layouts.master'))

@section('title', 'الإشعارات')

@section('content')
<section class="content-header mb-4">
    <h1 class="fw-bold text-dark">الإشعارات <small class="text-muted fs-6">أحدث التنبيهات والطلبات</small></h1>
</section>

<div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 20px;">
    <div class="card-header bg-white border-bottom py-3 px-4 d-flex align-items-center justify-content-between">
        <h5 class="fw-bold mb-0">قائمة الإشعارات</h5>
        <form action="{{ route(auth()->user()->panel_type . '.notifications.mark-all-as-read') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-outline-primary btn-sm rounded-pill px-3 fw-bold">تحديد الكل كمقروء</button>
        </form>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-muted small fw-bold text-uppercase">
                    <tr>
                        <th class="ps-4 py-3" style="width: 70px;">الصورة</th>
                        <th class="py-3">العنوان</th>
                        <th class="py-3">الرسالة</th>
                        <th class="py-3 text-center" style="width: 150px;">التاريخ</th>
                        <th class="pe-4 py-3 text-end" style="width: 100px;">عرض</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($notifications as $notification)
                        <tr class="{{ $notification->unread() ? 'bg-light-primary fw-bold' : '' }}">
                            <td class="ps-4">
                                @if(auth()->user()->type == 'client' && isset($notification->data['product_image']))
                                    <img src="{{ $notification->data['product_image'] }}" 
                                         style="width: 35px !important; height: 35px !important; object-fit: cover; border-radius: 6px; border: 1px solid #eee;" 
                                         alt="Product">
                                @else
                                    <img src="{{ $notification->data['user_avatar'] ?? asset('dist/img/user2-160x160.jpg') }}" 
                                         class="rounded-circle" 
                                         style="width: 35px !important; height: 35px !important; object-fit: cover;" 
                                         alt="User">
                                @endif
                            </td>
                            <td>
                                <div class="text-dark small fw-bold">
                                    @if(auth()->user()->type == 'client' && isset($notification->data['product_name']))
                                        {{ $notification->data['product_name'] }}
                                    @else
                                        {{ $notification->data['user_name'] ?? 'تنبيه' }}
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="text-muted small text-truncate" style="max-width: 450px;">
                                    {{ $notification->data['message'] }}
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-light text-muted fw-normal">{{ $notification->created_at->diffForHumans() }}</span>
                            </td>
                            <td class="pe-4 text-end">
                                <a href="{{ route(auth()->user()->panel_type . '.notifications.show', $notification->id) }}" class="btn btn-light btn-sm rounded-circle border shadow-sm">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">لا توجد إشعارات حالياً.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($notifications->hasPages())
        <div class="card-footer bg-white border-0 py-3 text-center">
            {{ $notifications->links() }}
        </div>
    @endif
</div>

<style>
    .bg-light-primary { background-color: rgba(13, 110, 253, 0.03) !important; border-right: 4px solid #0d6efd !important; }
</style>

<style>
.unread-notification { font-weight: bold; }
.product-list-in-box > .item { padding: 15px; border-bottom: 1px solid #f4f4f4; }
.product-list-in-box > .item:last-child { border-bottom: 0; }
</style>
@endsection
