@extends('client.layouts.master')

@section('title', 'منتجات الموقع')

@section('content')
<section class="content-header">
    <h1>منتجات الموقع <small>تصفح جميع المنتجات المتاحة</small></h1>
</section>

<section class="content">
    <!-- Advanced Filter Box -->
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-filter"></i> تصفية متقدمة</h3>
        </div>
        <div class="box-body">
            <form action="{{ route('site.products.index') }}" method="GET" id="filterForm">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>القطاع</label>
                            <select name="sector_id" id="sector_id" class="form-control select2">
                                <option value="">كل القطاعات</option>
                                @foreach($sectors as $sector)
                                    <option value="{{ $sector->id }}" {{ request('sector_id') == $sector->id ? 'selected' : '' }}>
                                        {{ $sector->name_ar }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>الفرع</label>
                            <select name="branch_id" id="branch_id" class="form-control select2">
                                <option value="">كل الفروع</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>القسم</label>
                            <select name="category_id" id="category_id" class="form-control select2">
                                <option value="">كل الأقسام</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>بحث بالاسم ووصف</label>
                            <input type="text" name="search" class="form-control" value="{{ request('search') }}" placeholder="ابحث هنا...">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>من تاريخ</label>
                            <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>إلى تاريخ</label>
                            <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                        </div>
                    </div>
                    <div class="col-md-6 text-left" style="margin-top: 25px;">
                        <button type="submit" class="btn btn-primary btn-lg"><i class="fa fa-search"></i> بحث وتصفية</button>
                        <a href="{{ route('site.products.index') }}" class="btn btn-default btn-lg">إعادة تعيين</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Recommended Products Section -->
    @if($recommendedProducts->count() > 0 && !request()->hasAny(['sector_id', 'search', 'branch_id']))
        <div class="box box-solid box-info">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-star text-yellow"></i> منتجات مقترحة لك</h3>
            </div>
            <div class="box-body" style="background: #f4f7f6;">
                <div class="row">
                    @foreach($recommendedProducts as $product)
                        <div class="col-md-4 col-sm-6">
                            @include('client.products.partials.product_card', ['product' => $product, 'isRecommended' => true])
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <!-- All Products Section -->
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">جميع المنتجات</h3>
        </div>
        <div class="box-body">
            <div class="row">
                @forelse($allProducts as $product)
                    <div class="col-md-3 col-sm-6">
                        @include('client.products.partials.product_card', ['product' => $product])
                    </div>
                @empty
                    <div class="col-md-12 text-center" style="padding: 50px;">
                        <i class="fa fa-search fa-5x text-muted"></i>
                        <h3>لا توجد منتجات تطابق بحثك حالياً</h3>
                    </div>
                @endforelse
            </div>
            <div class="text-center">
                {{ $allProducts->links() }}
            </div>
        </div>
    </div>
</section>

@include('client.products.partials.detail_modal')

@endsection

@push('scripts')
<style>
    /* Product Page Premium Overrides */
    .product-card {
        border-radius: 12px !important;
        border: 1px solid #f1f5f9 !important;
        box-shadow: 0 2px 10px rgba(0,0,0,0.02) !important;
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
    }
    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 50px rgba(0,0,0,0.12) !important;
    }
    .product-card .zoom-img {
        transition: transform 0.6s ease;
    }
    .product-card:hover .zoom-img {
        transform: scale(1.1);
    }
    
    /* Advanced Filter Box Polish */
    #filterForm label {
        font-weight: 800;
        font-size: 13px;
        color: #1e3a5f;
        margin-bottom: 8px;
    }
    .select2-container--default .select2-selection--single {
        border-radius: 8px !important;
        height: 45px !important;
        border: 1px solid #e2e8f0 !important;
        padding-top: 8px !important;
    }
    input[type="text"].form-control, input[type="date"].form-control {
        border-radius: 8px !important;
        height: 45px !important;
        border: 1px solid #e2e8f0 !important;
    }
</style>
<script>
$(document).ready(function() {
    $('.select2').select2({ width: '100%' });

    // Dynamic filtering logic
    $('#sector_id').on('change', function() {
        const sectorId = $(this).val();
        $('#branch_id').empty().append('<option value="">جاري التحميل...</option>');
        $('#category_id').empty().append('<option value="">كل الأقسام</option>');
        
        if (sectorId) {
            $.get(`/api/branches/${sectorId}`, function(data) {
                $('#branch_id').empty().append('<option value="">كل الفروع</option>');
                data.forEach(branch => {
                    $('#branch_id').append(`<option value="${branch.id}">${branch.name_ar}</option>`);
                });
            });
        } else {
            $('#branch_id').empty().append('<option value="">كل الفروع</option>');
        }
    });

    $('#branch_id').on('change', function() {
        const branchId = $(this).val();
        $('#category_id').empty().append('<option value="">جاري التحميل...</option>');
        
        if (branchId) {
            $.get(`/api/categories/${branchId}`, function(data) {
                $('#category_id').empty().append('<option value="">كل الأقسام</option>');
                data.forEach(cat => {
                    $('#category_id').append(`<option value="${cat.id}">${cat.name_ar}</option>`);
                });
            });
        } else {
            $('#category_id').empty().append('<option value="">كل الأقسام</option>');
        }
    });

    // Preset filters if they are in the URL
    @if(request('sector_id'))
        const currentSector = "{{ request('sector_id') }}";
        $.get(`/api/branches/${currentSector}`, function(data) {
            $('#branch_id').empty().append('<option value="">كل الفروع</option>');
            data.forEach(branch => {
                const selected = "{{ request('branch_id') }}" == branch.id ? 'selected' : '';
                $('#branch_id').append(`<option value="${branch.id}" ${selected}>${branch.name_ar}</option>`);
            });
            
            @if(request('branch_id'))
                const currentBranch = "{{ request('branch_id') }}";
                $.get(`/api/categories/${currentBranch}`, function(data) {
                    $('#category_id').empty().append('<option value="">كل الأقسام</option>');
                    data.forEach(cat => {
                        const selected = "{{ request('category_id') }}" == cat.id ? 'selected' : '';
                        $('#category_id').append(`<option value="${cat.id}" ${selected}>${cat.name_ar}</option>`);
                    });
                });
            @endif
        });
    @endif
});
</script>
@endpush
