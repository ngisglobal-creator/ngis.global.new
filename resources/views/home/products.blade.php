@extends('layouts.public')

@section('title', 'منتجات الموقع')

@section('content')
<section class="content-header">
    <h1 class="text-center" style="margin: 30px 0; font-weight: bold;">استكشف منتجاتنا <small>تصفح جميع المنتجات المتاحة من المصانع والشركات</small></h1>
</section>

<section class="content">
    <!-- Advanced Filter Box -->
    <div class="box box-primary" style="border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
        <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-filter"></i> تصفية متقدمة</h3>
        </div>
        <div class="box-body">
            <form action="{{ route('home.products') }}" method="GET" id="filterForm">
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
                        <a href="{{ route('home.products') }}" class="btn btn-default btn-lg">إعادة تعيين</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- All Products Section -->
    <div class="box box-default" style="border: none; background: transparent;">
        <div class="box-header with-border" style="background: transparent; border: none;">
            <h3 class="box-title" style="font-size: 24px; font-weight: bold;">أحدث المنتجات</h3>
        </div>
        <div class="box-body" style="padding: 20px 0;">
            <div class="row">
                @forelse($allProducts as $product)
                    <div class="col-md-5th col-sm-6">
                        @include('client.products.partials.product_card', ['product' => $product, 'public_view' => true])
                    </div>
                @empty
                    <div class="col-md-12 text-center" style="padding: 100px 50px; background: #fff; border-radius: 8px;">
                        <i class="fa fa-search fa-5x text-muted" style="margin-bottom: 20px;"></i>
                        <h3>لا توجد منتجات تطابق بحثك حالياً</h3>
                        <p class="text-muted">جرب تغيير شروط البحث للحصول على نتائج أفضل</p>
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
