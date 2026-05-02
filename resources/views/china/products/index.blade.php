@extends('china.layouts.master')

@section('title', 'منتجاتي')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold m-0 text-dark">منتجاتي <span class="text-muted fs-6 fw-normal ms-2">المنتجات التي قمت بإضافتها</span></h3>
    <a href="{{ route('products.create') }}" class="btn btn-primary">
        <i class="fa-solid fa-plus me-1"></i> إضافة منتج جديد
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 rounded-3" role="alert">
        <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4" style="width: 50px;">#</th>
                        <th>الصورة</th>
                        <th>اسم المنتج</th>
                        <th>التصنيف</th>
                        <th>الكمية</th>
                        <th>السعر</th>
                        <th>تاريخ الإضافة</th>
                        <th class="text-center" style="width: 120px;">الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr>
                        <td class="ps-4 fw-bold text-muted english-nums">{{ $loop->iteration }}</td>

                        {{-- صورة مصغرة --}}
                        <td>
                            @if($product->images->count() > 0)
                                <img src="{{ asset('storage/' . $product->images->first()->image_path) }}"
                                     alt="{{ $product->name }}"
                                     class="rounded-3 border"
                                     style="width: 56px; height: 56px; object-fit: cover;">
                            @else
                                <div class="rounded-3 border bg-light d-flex align-items-center justify-content-center text-muted"
                                     style="width: 56px; height: 56px;">
                                    <i class="fa-solid fa-image fa-sm"></i>
                                </div>
                            @endif
                        </td>

                        {{-- اسم المنتج --}}
                        <td>
                            <div class="fw-bold">{{ $product->name }}</div>
                            <div class="text-muted small" style="max-width: 220px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">
                                {!! Str::limit(strip_tags($product->description), 80) !!}
                            </div>
                        </td>

                        {{-- التصنيف --}}
                        <td>
                            <span class="badge bg-primary-subtle text-primary rounded-pill">{{ $product->sector->name_ar }}</span>
                            <div class="text-muted small mt-1">{{ $product->branch->name_ar }} › {{ $product->category->name_ar }}</div>
                        </td>

                        {{-- الكمية --}}
                        <td><span class="fw-bold english-nums fs-5">{{ $product->quantity }}</span></td>

                        {{-- السعر --}}
                        <td>
                            <span class="fw-bold english-nums">{{ number_format($product->price, 2) }}</span>
                            <small class="text-muted ms-1">ر.س</small>
                        </td>

                        {{-- التاريخ --}}
                        <td><span class="text-muted small english-nums">{{ $product->created_at->format('Y-m-d') }}</span></td>

                        {{-- الإجراءات --}}
                        <td class="text-center">
                            <div class="dropdown">
                                <button class="btn btn-light btn-sm border rounded-3 dropdown-toggle px-3"
                                        type="button"
                                        data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                    <i class="fa-solid fa-ellipsis-vertical"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-3">
                                    <li>
                                        <a class="dropdown-item py-2" href="{{ route('products.show', $product->id) }}">
                                            <i class="fa-solid fa-eye text-primary me-2"></i> عرض التفاصيل
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item py-2" href="{{ route('products.edit', $product->id) }}">
                                            <i class="fa-solid fa-pen-to-square text-success me-2"></i> تعديل
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider my-1"></li>
                                    <li>
                                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item py-2 text-danger">
                                                <i class="fa-solid fa-trash me-2"></i> حذف المنتج
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5">
                            <i class="fa-solid fa-box-open fa-3x text-muted opacity-25 mb-3 d-block"></i>
                            <p class="text-muted mb-3">لا توجد منتجات مضافة حالياً</p>
                            <a href="{{ route('products.create') }}" class="btn btn-primary btn-sm">
                                <i class="fa-solid fa-plus me-1"></i> أضف منتجك الأول
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'تأكيد الحذف',
                    text: 'هل أنت متأكد من حذف هذا المنتج؟',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'نعم، احذف',
                    cancelButtonText: 'إلغاء',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) { this.submit(); }
                });
            } else {
                if (confirm('هل أنت متأكد من حذف هذا المنتج؟')) this.submit();
            }
        });
    });
</script>
@endpush

@endsection
