@extends('layouts.luxe')

@section('title', $user->name . ' | Manufacturer Profile')

@section('styles')
    <style>
        .profile-hero {
            background: linear-gradient(rgba(255,255,255,0.95), rgba(255,255,255,0.85)), url('{{ $user->cover_image ? asset('storage/' . $user->cover_image) : 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&q=80&w=2000' }}');
            background-size: cover;
            background-position: center;
            padding: 80px 0;
            border-bottom: 1px solid #eee;
        }
        .factory-badge-container {
            position: relative;
            width: 150px;
            height: 150px;
            margin: 0 auto;
        }
        .factory-badge-hex {
            background: linear-gradient(135deg, #FFD700, #D4AF37);
            width: 100px;
            height: 120px;
            clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            box-shadow: 0 10px 25px rgba(212, 175, 55, 0.3);
            margin: 0 auto;
        }
        .inspection-card {
            background: #fff;
            border: 1px solid #eee;
            border-radius: 20px;
            padding: 25px;
            height: 100%;
        }
        .mini-stat-card {
            background: var(--ngis-light);
            border-radius: 15px;
            padding: 20px;
            text-align: center;
            border: 1px solid transparent;
            transition: all 0.3s ease;
        }
        .mini-stat-card:hover {
            border-color: var(--ngis-gold);
            background: #fff;
            transform: translateY(-5px);
        }
        .info-stripe {
            background: var(--ngis-black);
            color: #fff;
            padding: 15px 0;
            margin-top: -30px;
            z-index: 5;
            position: relative;
            border-radius: 50px;
            width: fit-content;
            margin-left: auto;
            margin-right: auto;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
    </style>
@endsection

@section('content')
    <!-- Profile Hero -->
    <header class="profile-hero overflow-hidden">
        <div class="container">
            <div class="row g-4 align-items-center">
                <!-- Left: Inspection -->
                <div class="col-lg-3 d-none d-lg-block" data-aos="fade-right">
                    <div class="inspection-card shadow-sm">
                        <span class="spec-label mb-3">Field Inspection</span>
                        <ul class="list-unstyled x-small fw-bold text-muted space-y-2">
                            <li class="mb-2"><i class="ph-bold ph-check text-gold me-2"></i> CAPACITY: HIGH VOLUME</li>
                            <li class="mb-2"><i class="ph-bold ph-check text-gold me-2"></i> PROTOCOL: ZERO DELAY</li>
                            <li class="mb-2"><i class="ph-bold ph-check text-gold me-2"></i> OVERSIGHT: CONTINUOUS</li>
                        </ul>
                    </div>
                </div>

                <!-- Center: Main Profile Info -->
                <div class="col-lg-6 text-center" data-aos="zoom-in">
                    <div class="factory-badge-container mb-4">
                        <div class="factory-badge-hex">
                            <span class="x-small fw-black text-dark opacity-50">NGIS</span>
                            <span class="fw-black text-dark" style="font-size: 0.7rem; line-height: 1;">VERIFIED<br>SUPPLIER</span>
                            <hr class="w-50 mx-auto my-1 border-dark opacity-20">
                            <span class="x-small fw-black text-dark tracking-widest">GOLD</span>
                        </div>
                    </div>
                    <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) }}" class="avatar-circle shadow-lg mb-3" style="width: 100px; height: 100px; border: 4px solid #fff;">
                    <h1 class="display-6 fw-bold text-dark mb-1">{{ $user->name }}</h1>
                    <p class="text-gold fw-bold tracking-widest x-small uppercase mb-1">CERTIFIED GLOBAL MANUFACTURER</p>
                </div>

                <!-- Right: Stats -->
                <div class="col-lg-3 d-none d-lg-block" data-aos="fade-left">
                    <div class="inspection-card shadow-sm">
                        <span class="spec-label mb-3">Performance Hub</span>
                        <div class="d-flex flex-column gap-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="x-small fw-bold text-muted">EFFICIENCY</span>
                                <span class="badge bg-gold text-dark rounded-pill shadow-sm">98%</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="x-small fw-bold text-muted">RELIABILITY</span>
                                <span class="badge bg-dark text-gold rounded-pill shadow-sm">ELITE</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="x-small fw-bold text-muted">EXPORT TIER</span>
                                <span class="badge bg-light text-dark border rounded-pill shadow-sm">GLOBAL</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Info Stripe -->
    <div class="info-stripe px-5" data-aos="fade-up">
        <div class="d-flex gap-4 gap-md-5 x-small fw-bold tracking-widest uppercase">
            <span><i class="ph-fill ph-map-pin text-gold me-2"></i>{{ $user->country->name_ar ?? 'Global' }}</span>
            <span class="d-none d-md-inline"><i class="ph-fill ph-calendar text-gold me-2"></i>Since {{ $user->created_at->format('Y') }}</span>
            <span><i class="ph-fill ph-phone text-gold me-2"></i>{{ $user->phone ?? 'Verified' }}</span>
        </div>
    </div>

    <div class="container py-5 mt-4">
        <div class="row g-5">
            <!-- Sidebar -->
            <aside class="col-lg-3">
                <div class="sticky-top" style="top: 100px;">
                    <div class="bg-white p-4 rounded-4 border shadow-sm mb-4">
                        <h6 class="fw-bold text-dark mb-3"><i class="ph-fill ph-info me-2 text-gold"></i>About Manufacturer</h6>
                        <p class="small text-muted mb-4 lh-lg">
                            {{ $user->about_ar ?? 'Trusted global partner providing high-end industrial solutions and premium quality products.' }}
                        </p>
                        <div class="pt-3 border-top">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="x-small text-muted fw-bold">RATING</span>
                                <div class="text-gold x-small">
                                    <i class="ph-fill ph-star"></i><i class="ph-fill ph-star"></i><i class="ph-fill ph-star"></i><i class="ph-fill ph-star"></i><i class="ph-fill ph-star"></i>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="x-small text-muted fw-bold">VERIFIED</span>
                                <i class="ph-fill ph-check-circle text-success fs-5"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-4 rounded-4 border shadow-sm">
                        <h6 class="fw-bold text-dark mb-3"><i class="ph-fill ph-funnel me-2 text-gold"></i>Filter Products</h6>
                        <form action="{{ route('home.profile', $user->id) }}" method="GET" class="space-y-3">
                            <input type="text" name="search" value="{{ request('search') }}" class="form-control-lux w-100 mb-3 small" placeholder="Search in collection...">
                            <select name="sector_id" class="form-select form-control-lux mb-3 small">
                                <option value="">All Sectors</option>
                                @foreach($sectors as $sector)
                                <option value="{{ $sector->id }}" {{ request('sector_id') == $sector->id ? 'selected' : '' }}>{{ $sector->name_ar }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-gold w-100 py-2 small fw-bold shadow-sm">APPLY FILTERS</button>
                        </form>
                    </div>
                </div>
            </aside>

            <!-- Main Content: Product Grid -->
            <main class="col-lg-9">
                <div class="d-flex justify-content-between align-items-center mb-5 pb-3 border-bottom">
                    <h3 class="fw-bold text-dark mb-0"><i class="ph-fill ph-package me-2 text-gold"></i>Manufacturer <span class="text-gold">Portfolio</span></h3>
                    <span class="badge bg-light text-dark rounded-pill px-3 py-2 border small fw-bold">{{ $allProducts->total() }} Products</span>
                </div>

                <div class="row g-4">
                    @forelse($allProducts as $product)
                    <div class="col-md-6 col-xl-4" data-aos="fade-up" data-aos-delay="{{ $loop->index % 3 * 100 }}">
                        <div class="product-card h-100">
                            <div class="product-image-wrapper">
                                @php $productImg = $product->images->first(); @endphp
                                <img src="{{ $productImg ? asset('storage/' . $productImg->image_path) : 'https://via.placeholder.com/600x600?text=Premium+Product' }}" alt="{{ $product->name }}">
                                <div class="price-badge">{{ $product->currency_code }} {{ number_format($product->price) }}</div>
                                <div class="position-absolute top-2 start-2">
                                    <span class="badge bg-white text-dark shadow-sm x-small rounded-pill">{{ $product->sector->name_ar }}</span>
                                </div>
                            </div>
                            <div class="p-4">
                                <h6 class="fw-bold text-dark mb-3 line-clamp-2" style="min-height: 2.5rem;">{{ $product->name }}</h6>
                                <div class="d-flex justify-content-between align-items-center pt-3 border-top mt-auto">
                                    <span class="x-small fw-bold text-muted uppercase">Min Order: {{ $product->min_order_quantity }}</span>
                                    <a href="{{ route('home.products.show', $product->id) }}" class="btn btn-gold-outline btn-sm px-4">VIEW</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12 py-5 text-center">
                        <div class="bg-light p-5 rounded-4 border border-dashed text-center">
                            <i class="ph ph-package display-1 text-muted opacity-25"></i>
                            <h4 class="text-muted mt-3">No products available in this selection</h4>
                            <a href="{{ route('home.profile', $user->id) }}" class="btn btn-gold-outline mt-3">Reset Filters</a>
                        </div>
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
