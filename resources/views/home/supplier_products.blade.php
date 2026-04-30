@extends('layouts.luxe')

@section('styles')
    <style>
        .page-header {
            padding: 120px 0 60px;
            position: relative;
        }
        .filter-glass {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(212, 175, 55, 0.1);
            backdrop-filter: blur(15px);
            border-radius: 20px;
            padding: 25px;
            margin-bottom: 60px;
        }
        .pagination .page-link {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            color: #fff;
            margin: 0 3px;
        }
        .pagination .page-item.active .page-link {
            background: var(--gold-mid);
            color: #000;
            border-color: var(--gold-mid);
        }
    </style>
@endsection

@section('content')
    <!-- Page Header -->
    <header class="page-header text-center">
        <div class="container">
            <span class="hero-badge" data-aos="fade-down">CERTIFIED WHOLESALE NETWORK</span>
            <h1 class="brand-name-premium mb-3" style="font-size: 3.2rem;" data-aos="fade-up">
                <span class="lang-en">Supplier <span class="text-gold">Hub</span></span>
                <span class="lang-ar">منتجات <span class="text-gold">الموردين</span></span>
            </h1>
            <p class="text-white opacity-75 mx-auto" style="max-width: 600px;" data-aos="fade-up" data-aos-delay="100">
                <span class="lang-en">Elite wholesale opportunities from our global network of verified suppliers and strategic partners.</span>
                <span class="lang-ar">فرص متميزة للجملة من شبكتنا العالمية من الموردين المعتمدين والشركاء الاستراتيجيين.</span>
            </p>
        </div>
    </header>

    <!-- Filter Bar -->
    <section class="mb-5">
        <div class="container">
            <div class="filter-glass" data-aos="zoom-in">
                <form action="{{ route('home.supplier-products') }}" method="GET">
                    <div class="row g-4 align-items-center">
                        <div class="col-lg-5">
                            <span class="spec-label mb-2 d-block">Search Supplier Catalog</span>
                            <div class="position-relative">
                                <i class="ph ph-magnifying-glass position-absolute top-50 translate-middle-y {{ app()->getLocale() == 'ar' ? 'me-3' : 'ms-3' }}" style="{{ app()->getLocale() == 'ar' ? 'right: 0;' : 'left: 0;' }} color: var(--gold-mid);"></i>
                                <input type="text" name="search" value="{{ request('search') }}" class="form-control-lux w-100 ps-5" placeholder="Search products, suppliers...">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <span class="spec-label mb-2 d-block">Industry Sector</span>
                            <select name="sector_id" class="form-control-lux form-select border-opacity-10">
                                <option value="">All Industrial Sectors</option>
                                @foreach($sectors as $sector)
                                    <option value="{{ $sector->id }}" {{ request('sector_id') == $sector->id ? 'selected' : '' }}>
                                        {{ $sector->name_ar }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <span class="spec-label mb-2 d-block">Listed Since</span>
                            <input type="date" name="date_from" value="{{ request('date_from') }}" class="form-control-lux w-100">
                        </div>
                        <div class="col-lg-1 text-end">
                            <button type="submit" class="btn btn-gold w-100" style="height: 48px; margin-top: 25px;">
                                <i class="ph ph-arrow-right {{ app()->getLocale() == 'ar' ? 'rotate-180' : '' }}"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <div class="container pb-5">
        <!-- Results Grid -->
        <div class="row g-4 row-cols-2 row-cols-md-3 row-cols-xl-4">
            @forelse($allProducts as $product)
            <div class="col" data-aos="fade-up">
                <div class="premium-glass-card h-100 d-flex flex-column">
                    <div class="product-image-wrapper">
                        @php $productImg = $product->images->first(); @endphp
                        <img src="{{ $productImg ? asset('storage/' . $productImg->image_path) : 'https://via.placeholder.com/600x400' }}" alt="{{ $product->name }}">
                        <div class="price-badge">{{ $product->currency_code }} {{ number_format($product->price) }}</div>
                        <div class="position-absolute bottom-0 end-0 p-2 bg-dark bg-opacity-75">
                            <i class="ph-fill ph-buildings text-gold small"></i>
                        </div>
                    </div>
                    
                    <div class="p-4 flex-grow-1 d-flex flex-column">
                        <span class="text-gold fw-bold x-small text-uppercase mb-2" style="font-size: 0.65rem;">{{ $product->sector->name_ar }}</span>
                        <h6 class="fw-bold text-white mb-3 line-clamp-2" style="font-size: 0.95rem; min-height: 2.5rem;">{{ $product->name }}</h6>
                        
                        <div class="d-flex align-items-center gap-2 mb-4 mt-auto">
                            <img src="{{ $product->user->avatar ? asset('storage/' . $product->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($product->user->name) }}" class="avatar-circle">
                            <span class="x-small fw-bold text-white text-truncate">{{ $product->user->name }}</span>
                        </div>

                        <div class="pt-3 border-top border-white-10">
                            <a href="{{ route('home.products.show', $product->id) }}" class="btn btn-gold btn-sm w-100 py-2">
                                <span class="lang-en">DETAILS</span><span class="lang-ar">التفاصيل</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 py-5 text-center opacity-50">
                <i class="ph ph-buildings display-1 mb-3"></i>
                <h4 class="">No Supplier Stock</h4>
                <p>Try resetting your filters or search keywords.</p>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-5 d-flex justify-content-center">
            {{ $allProducts->links('vendor.pagination.bootstrap-5') }}
        </div>
    </div>
@endsection
