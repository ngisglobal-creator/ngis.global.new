@extends('layouts.luxe')

@section('styles')
    <style>
        .page-header {
            padding: 120px 0 60px;
            position: relative;
        }
        .sidebar-glass {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(212, 175, 55, 0.1);
            backdrop-filter: blur(15px);
            border-radius: 24px;
            padding: 25px;
            position: sticky;
            top: 100px;
        }
        .sidebar-link {
            display: flex;
            align-items: center;
            padding: 14px 18px;
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-radius: 12px;
            transition: all 0.3s ease;
            margin-bottom: 6px;
        }
        .sidebar-link:hover, .sidebar-link.active {
            background: rgba(212, 175, 55, 0.1);
            color: var(--gold-mid);
            border: 1px solid rgba(212, 175, 55, 0.2);
        }
        .sidebar-link.active { border-color: var(--gold-mid); }
        .sidebar-link i { font-size: 1.1rem; margin-right: 12px; }
        html[lang="ar"] .sidebar-link i { margin-right: 0; margin-left: 12px; }

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
            <span class="hero-badge" data-aos="fade-down">NGIS GLOBAL COLLECTION</span>
            <h1 class="brand-name-premium mb-3" style="font-size: 3.2rem;" data-aos="fade-up">
                <span class="lang-en">Exclusive <span class="text-gold">Sourcing</span></span>
                <span class="lang-ar">توريد <span class="text-gold">حصري</span></span>
            </h1>
            <p class="text-white opacity-75 mx-auto" style="max-width: 600px;" data-aos="fade-up">
                <span class="lang-en">Elite products curated and verified directly by our regional global offices.</span>
                <span class="lang-ar">منتجات متميزة يتم اختيارها والتحقق منها مباشرة من خلال مكاتبنا الإقليمية العالمية.</span>
            </p>
        </div>
    </header>

    <div class="container pb-5">
        <div class="row g-5">
            
            <!-- Sidebar -->
            <aside class="col-lg-3">
                <div class="sidebar-glass" data-aos="fade-right">
                    <span class="spec-label mb-4 d-block">Regional Offices</span>
                    <div class="nav flex-column">
                        <a href="{{ route('home.ngis-products') }}" class="sidebar-link {{ !request('user_id') ? 'active' : '' }}">
                            <i class="ph ph-globe"></i>
                            <span class="lang-en">All Hubs</span><span class="lang-ar">جميع المكاتب</span>
                        </a>

                        @foreach($ngisUsers as $user)
                        <a href="{{ route('home.ngis-products', ['user_id' => $user->id]) }}" class="sidebar-link {{ request('user_id') == $user->id ? 'active' : '' }}">
                            <i class="ph ph-map-pin"></i>
                            <span>{{ $user->name }}</span>
                        </a>
                        @endforeach
                    </div>

                    <div class="pt-4 mt-4 border-top border-white-10">
                        <div class="premium-glass-card p-3" style="background: rgba(212,175,55,0.05);">
                            <span class="x-small fw-bold text-gold d-block mb-1">SECURE LOGISTICS</span>
                            <p class="x-small text-white opacity-50 mb-0">All NGIS hub products include end-to-end audit trails.</p>
                        </div>
                    </div>
                </div>
            </aside>

            <!-- Main Content -->
            <main class="col-lg-9">
                <!-- Meta -->
                <div class="d-flex justify-content-between align-items-end mb-5 border-bottom border-white-10 pb-4">
                    <div>
                        <h4 class="fw-bold text-white mb-1">Portfolio Highlights</h4>
                        <p class="text-muted small mb-0">{{ $allProducts->total() }} Strategic items verified by NGIS offices</p>
                    </div>
                    <div class="d-none d-md-block">
                        <div class="position-relative" style="width: 250px;">
                            <input type="text" class="form-control-lux w-100 ps-5 py-2 small" placeholder="Search portfolio...">
                            <i class="ph ph-magnifying-glass position-absolute top-50 translate-middle-y ms-3" style="left:0; color: var(--gold-mid);"></i>
                        </div>
                    </div>
                </div>

                <!-- Products Grid -->
                <div class="row g-4">
                    @forelse($allProducts as $product)
                    <div class="col-md-6 col-xl-4" data-aos="fade-up">
                        <div class="premium-glass-card h-100 d-flex flex-column">
                            <div class="product-image-wrapper">
                                @php $productImg = $product->images->first(); @endphp
                                <img src="{{ $productImg ? asset('storage/' . $productImg->image_path) : 'https://via.placeholder.com/600x400' }}" alt="{{ $product->name }}">
                                <div class="price-badge">{{ $product->currency_code }} {{ number_format($product->price) }}</div>
                                <div class="position-absolute bottom-0 start-0 p-3 bg-dark bg-opacity-75 backdrop-blur-sm" style="border-top-right-radius: 12px;">
                                    <span class="x-small text-gold fw-black">{{ $product->user->name }}</span>
                                </div>
                            </div>
                            
                            <div class="p-4 flex-grow-1 d-flex flex-column">
                                <h6 class="fw-bold text-white mb-3 line-clamp-2" style="font-size: 1rem; min-height: 2.5rem;">{{ $product->name }}</h6>
                                
                                <div class="mt-auto pt-4 border-top border-white-10">
                                    <div class="row g-0 align-items-center">
                                        <div class="col-8">
                                            <div class="d-flex align-items-center gap-2">
                                                <i class="ph-fill ph-seal-check text-gold"></i>
                                                <span class="x-small text-white opacity-75 fw-bold uppercase">Certified Hub Stock</span>
                                            </div>
                                        </div>
                                        <div class="col-4 text-end">
                                            <a href="{{ route('home.products.show', $product->id) }}" class="btn btn-gold btn-sm px-3">
                                                <i class="ph ph-arrow-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12 py-5 text-center opacity-50">
                        <i class="ph ph-package-open display-1 mb-3"></i>
                        <h4 class="">Empty Collection</h4>
                        <p>No products available for this regional hub yet.</p>
                    </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                <div class="mt-5 d-flex justify-content-center">
                    {{ $allProducts->links('vendor.pagination.bootstrap-5') }}
                </div>
            </main>

        </div>
    </div>
@endsection
