@extends('layouts.luxe')

@section('title', 'Marketplace | NGIS Global Sourcing')

@section('styles')
    <style>
        .marketplace-hero {
            padding: 120px 0 80px;
            position: relative;
        }
        .filter-section {
            margin-top: -50px;
            z-index: 20;
            position: relative;
        }
        .pagination .page-link {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            color: #fff;
            margin: 0 3px;
            border-radius: 8px;
        }
        .pagination .page-item.active .page-link {
            background: var(--gold-mid);
            color: #000;
            border-color: var(--gold-mid);
        }
    </style>
@endsection

@section('content')
    <!-- Marketplace Hero -->
    <header class="marketplace-hero">
        <div class="container text-center">
            <span class="hero-badge" data-aos="fade-down">GLOBAL LOGISTICS & TRADE</span>
            <h1 class="brand-name-premium mb-3" style="font-size: 3.5rem;" data-aos="fade-up">
                <span class="lang-en">Elite <span class="text-gold">Marketplace</span></span>
                <span class="lang-ar">سوق <span class="text-gold">النخبة</span></span>
            </h1>
            <p class="text-white opacity-75 mx-auto" style="max-width: 650px;" data-aos="fade-up" data-aos-delay="100">
                <span class="lang-en">Direct access to verified global suppliers, premium manufacturing lines, and secure international trade channels.</span>
                <span class="lang-ar">وصول مباشر إلى الموردين العالميين المعتمدين، خطوط التصنيع الممتازة، وقنوات التجارة الدولية الآمنة.</span>
            </p>
        </div>
    </header>

    <!-- Filter Section -->
    <section class="filter-section mb-5">
        <div class="container">
            <div class="premium-glass-card p-4 p-lg-5" data-aos="zoom-in">
                <form action="{{ route('home.all-products') }}" method="GET">
                    <div class="row g-4 align-items-end">
                        <div class="col-lg-4">
                            <span class="spec-label mb-2 d-block">Search Global Catalog</span>
                            <div class="position-relative">
                                <i class="ph ph-magnifying-glass position-absolute top-50 translate-middle-y {{ app()->getLocale() == 'ar' ? 'me-3' : 'ms-3' }}" style="{{ app()->getLocale() == 'ar' ? 'right:0;' : 'left:0;' }} color: var(--gold-mid);"></i>
                                <input type="text" name="search" value="{{ request('search') }}" class="form-control-lux w-100 ps-5" placeholder="Search products, materials...">
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
                        <div class="col-lg-2">
                            <span class="spec-label mb-2 d-block">Date From</span>
                            <input type="date" name="date_from" value="{{ request('date_from') }}" class="form-control-lux w-100">
                        </div>
                        <div class="col-lg-3 d-flex gap-2">
                            <div class="flex-grow-1">
                                <span class="spec-label mb-2 d-block">Date To</span>
                                <input type="date" name="date_to" value="{{ request('date_to') }}" class="form-control-lux w-100">
                            </div>
                            <button type="submit" class="btn btn-gold px-4" style="height: 48px; margin-top: 25px;">
                                <i class="ph-bold ph-funnel"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- Results Section -->
    <main class="container pb-5" style="margin-top: 50px;">
        <div class="d-flex justify-content-between align-items-end mb-5 border-bottom border-white-10 pb-4">
            <div>
                <h3 class="fw-bold text-white mb-1">
                    <span class="lang-en">Sourced <span class="text-gold">Results</span></span>
                    <span class="lang-ar">نتائج <span class="text-gold">التوريد</span></span>
                </h3>
                <p class="text-muted small mb-0">{{ $allProducts->total() }} Certified items matched your criteria</p>
            </div>
            <div class="d-none d-md-block">
                <span class="badge bg-dark border border-gold-mid text-gold px-3 py-2">SECURE TRADE ACTIVE</span>
            </div>
        </div>

        <div class="row g-4 row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5">
            @forelse($allProducts as $product)
            <div class="col" data-aos="fade-up">
                <div class="premium-glass-card h-100 d-flex flex-column">
                    <div class="product-image-wrapper">
                        @php $productImg = $product->images->first(); @endphp
                        <img src="{{ $productImg ? asset('storage/' . $productImg->image_path) : 'https://via.placeholder.com/600x800' }}" alt="{{ $product->name }}">
                        <div class="price-badge">{{ $product->currency_code }} {{ number_format($product->price) }}</div>
                        <div class="position-absolute top-2 start-2">
                            <img src="https://cdn-icons-png.flaticon.com/512/12713/12713831.png" class="verify-badge-sm" style="width: 20px;" title="Verified">
                        </div>
                    </div>
                    
                    <div class="p-4 flex-grow-1 d-flex flex-column">
                        <span class="text-gold fw-bold x-small text-uppercase mb-2" style="font-size: 0.65rem;">{{ $product->sector->name_ar }}</span>
                        <h6 class="fw-bold text-white text-truncate mb-3" style="font-size: 0.95rem;">{{ $product->name }}</h6>
                        
                        <div class="d-flex align-items-center gap-2 mb-4 mt-auto">
                            <img src="{{ $product->user->avatar ? asset('storage/' . $product->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($product->user->name) }}" class="avatar-circle">
                            <span class="x-small fw-bold text-white text-truncate">{{ $product->user->name }}</span>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center pt-3 border-top border-white-10">
                            <div>
                                <span class="spec-label">MOQ</span>
                                <div class="spec-value">{{ $product->min_order_quantity }}</div>
                            </div>
                            <a href="{{ route('home.products.show', $product->id) }}" class="btn btn-gold btn-sm px-3">
                                <i class="ph ph-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 py-5 text-center opacity-50">
                <i class="ph ph-package display-1 mb-3"></i>
                <h4 class="">No Matching Products</h4>
                <p>Verify your filters or search terms.</p>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-5 d-flex justify-content-center">
            {{ $allProducts->links('vendor.pagination.bootstrap-5') }}
        </div>
    </main>
@endsection
