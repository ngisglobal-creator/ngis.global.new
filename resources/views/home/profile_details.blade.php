@extends('layouts.luxe')

@section('styles')
    <style>
        .profile-hero-lux {
            background: linear-gradient(rgba(5, 13, 31, 0.8), rgba(5, 13, 31, 1)), url('{{ $user->cover_image ? asset('storage/' . $user->cover_image) : 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&q=80&w=2000' }}');
            background-size: cover;
            background-position: center;
            padding: 80px 0 120px 0;
            position: relative;
        }
        .factory-badge-container {
            position: relative;
            width: 140px;
            height: 140px;
            margin: 0 auto;
        }
        .factory-badge-hex-lux {
            background: linear-gradient(135deg, var(--gold-mid), var(--gold-deep));
            width: 80px;
            height: 95px;
            clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            box-shadow: 0 10px 25px rgba(212, 175, 55, 0.3);
            margin: 0 auto;
            border: 2px solid rgba(255, 255, 255, 0.2);
        }
        .info-stripe-lux {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #fff;
            padding: 18px 45px;
            margin-top: -36px;
            z-index: 5;
            position: relative;
            border-radius: 60px;
            width: fit-content;
            margin-left: auto;
            margin-right: auto;
            box-shadow: 0 20px 40px rgba(0,0,0,0.4);
        }
        .media-glass-card {
            background: rgba(255, 255, 255, 0.03);
            border-radius: 32px;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.05);
            margin-bottom: 35px;
            backdrop-filter: blur(15px);
        }
        .gallery-grid-lux {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 20px;
        }
        .gallery-item-lux {
            aspect-ratio: 1/1;
            border-radius: 20px;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.05);
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            background: rgba(255, 255, 255, 0.02);
            padding: 5px;
        }
        .gallery-item-lux img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 15px;
            filter: brightness(0.8);
            transition: all 0.3s ease;
        }
        .gallery-item-lux:hover {
            transform: scale(1.05) translateY(-5px);
            border-color: var(--gold-mid);
        }
        .gallery-item-lux:hover img {
            filter: brightness(1);
        }
        
        .news-article-lux {
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            padding-bottom: 40px;
            margin-bottom: 40px;
            position: relative;
        }
        .news-article-lux:last-child {
            border-bottom: none;
        }
        .news-tag-lux {
            font-size: 0.6rem;
            font-weight: 800;
            padding: 6px 16px;
            border-radius: 50px;
            text-transform: uppercase;
            letter-spacing: 2px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .premium-stat-box {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 24px;
            padding: 25px;
            transition: all 0.3s ease;
        }
        .premium-stat-box:hover {
            background: rgba(212, 175, 55, 0.05);
            border-color: rgba(212, 175, 55, 0.2);
        }

        /* Modal Polish */
        .modal-content-glass {
            background: rgba(5, 13, 31, 0.85);
            backdrop-filter: blur(25px);
            border: 1px solid rgba(212, 175, 55, 0.2);
            border-radius: 32px;
            overflow: hidden;
            box-shadow: 0 25px 50px rgba(0,0,0,0.6);
        }
        .lux-modal-header {
            padding: 25px 40px;
            background: rgba(212, 175, 55, 0.1);
            border-bottom: 1px solid rgba(212, 175, 55, 0.1);
        }
    </style>
@endsection

@section('content')
    <!-- Profile Hero -->
    <header class="profile-hero-lux overflow-hidden">
        <div class="container">
            <div class="row g-4 align-items-center">
                <!-- Left: Inspection -->
                <div class="col-lg-3 d-none d-lg-block" data-aos="fade-right">
                    <div class="premium-glass-card border-opacity-10 p-4">
                        <span class="spec-label mb-3 d-block border-bottom border-white border-opacity-10 pb-2">Operational Oversight</span>
                        <ul class="list-unstyled mb-0" style="font-size: 0.65rem; color: rgba(255,255,255,0.6);">
                            <li class="mb-3 d-flex align-items-center fw-bold"><i class="ph-bold ph-check text-gold me-2"></i> CAPACITY: HIGH VOLUME</li>
                            <li class="mb-3 d-flex align-items-center fw-bold"><i class="ph-bold ph-check text-gold me-2"></i> PROTOCOL: ZERO DELAY</li>
                            <li class="d-flex align-items-center fw-bold"><i class="ph-bold ph-check text-gold me-2"></i> OVERSIGHT: CONTINUOUS</li>
                        </ul>
                    </div>
                </div>

                <!-- Center: Main Profile Info -->
                <div class="col-lg-6 text-center" data-aos="zoom-in">
                    <div class="factory-badge-container mb-4">
                        <div class="factory-badge-hex-lux">
                            <span class="x-small fw-black text-dark opacity-50" style="font-size: 0.4rem;">NGIS</span>
                            <span class="fw-black text-dark" style="font-size: 0.5rem; line-height: 1.1;">ELITE<br>SOURCE</span>
                            <span class="x-small fw-black text-dark tracking-widest mt-1" style="font-size: 0.4rem;">PLATINUM</span>
                        </div>
                    </div>
                    <div class="position-relative d-inline-block mb-3">
                        <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) }}" class="avatar-circle shadow-lg" style="width: 120px; height: 120px; border: 4px solid var(--gold-mid); object-fit: cover; filter: drop-shadow(0 0 15px rgba(212,175,55,0.3));">
                    </div>
                    <h1 class="display-6 fw-bold text-white mb-1 brand-name-premium" style="background: none; -webkit-background-clip: initial; color: white;">{{ $user->name }}</h1>
                    <p class="text-gold fw-bold tracking-widest x-small uppercase mb-1">CERTIFIED GLOBAL MANUFACTURER • TIER 1</p>
                    
                    @if(Auth::check() && Auth::id() == $user->id)
                    <div class="mt-4 d-flex justify-content-center gap-2 flex-wrap">
                        <a href="{{ route('home.profile.edit', $user->id) }}" class="btn btn-gold btn-sm px-4 rounded-pill">
                            <i class="ph-bold ph-pencil me-2"></i>
                            <span class="lang-en">EDIT PAGE</span><span class="lang-ar">تعديل الصفحة</span>
                        </a>
                        <button onclick="openNewsModal()" class="btn btn-outline-light btn-sm px-4 rounded-pill border-opacity-25">
                            <i class="ph-bold ph-megaphone me-2"></i>
                            <span class="lang-en">NEW AD</span><span class="lang-ar">إعلان جديد</span>
                        </button>
                    </div>
                    @endif
                </div>

                <!-- Right: Stats -->
                <div class="col-lg-3 d-none d-lg-block" data-aos="fade-left">
                    <div class="premium-glass-card border-opacity-10 p-4">
                        <span class="spec-label mb-3 d-block border-bottom border-white border-opacity-10 pb-2">Global Reliability</span>
                        <div class="d-flex flex-column gap-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="spec-label mb-0" style="font-size: 0.55rem;">EFFICIENCY</span>
                                <span class="badge bg-gold-mid bg-opacity-10 text-gold rounded-pill px-3 border border-gold border-opacity-20">98.4%</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="spec-label mb-0" style="font-size: 0.55rem;">EXPORT TIER</span>
                                <span class="badge bg-white bg-opacity-5 text-white rounded-pill px-3 border border-white border-opacity-10">ELITE</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Info Stripe -->
    <div class="info-stripe-lux px-5" data-aos="fade-up">
        <div class="d-flex gap-4 gap-md-5 spec-label mb-0 align-items-center flex-wrap justify-content-center" style="font-size: 0.65rem;">
            <span><i class="ph-fill ph-map-pin text-gold me-2"></i>{{ $user->country->name_ar ?? 'Global Operations' }}</span>
            <span class="d-none d-md-inline"><i class="ph-fill ph-calendar text-gold me-2"></i>ESTABLISHED {{ $user->created_at->format('Y') }}</span>
            <span><i class="ph-fill ph-phone text-gold me-2"></i>{{ $user->phone ?? 'SECURE LINE' }}</span>
        </div>
    </div>

    <div class="container py-5 mt-4">
        <div class="row g-5">
            <!-- Sidebar -->
            <aside class="col-lg-3">
                <div class="sticky-top" style="top: 100px;">
                    <div class="premium-glass-card p-4 mb-4 border-opacity-10">
                        <h6 class="spec-label mb-3 d-block border-bottom border-white border-opacity-10 pb-2"><i class="ph-fill ph-info me-2 text-gold"></i>Entity DNA</h6>
                        <p class="small text-white opacity-50 mb-4 lh-lg" style="font-size: 0.8rem;">
                            <span class="lang-ar">{{ $user->about_ar ?? 'شريك عالمي موثوق يقدم حلولًا صناعية متطورة ومنتجات عالية الجودة.' }}</span>
                            <span class="lang-en d-none">{{ $user->about_en ?? 'Trusted global partner providing high-end industrial solutions and premium quality products.' }}</span>
                        </p>
                        <div class="pt-3 border-top border-white border-opacity-10">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="spec-label" style="font-size: 0.55rem;">LIVE PORTFOLIO</span>
                                <span class="text-white fw-bold x-small">{{ $allProducts->total() }}</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="spec-label" style="font-size: 0.55rem;">NGIS STATUS</span>
                                <i class="ph-fill ph-check-circle text-gold fs-5"></i>
                            </div>
                        </div>
                    </div>

                    <div class="premium-glass-card p-4 mb-4 border-opacity-10">
                        <h6 class="spec-label mb-3 d-block border-bottom border-white border-opacity-10 pb-2"><i class="ph-fill ph-funnel me-2 text-gold"></i>Portfolio Navigation</h6>
                        <form action="{{ route('home.profile', $user->id) }}" method="GET" class="space-y-3">
                            <input type="text" name="search" value="{{ request('search') }}" class="form-control-lux w-100 mb-3 small" placeholder="Search portfolio...">
                            <select name="sector_id" class="form-control-lux w-100 mb-3 small">
                                <option value="">All Industrial Sectors</option>
                                @foreach($sectors as $sector)
                                <option value="{{ $sector->id }}" {{ request('sector_id') == $sector->id ? 'selected' : '' }} class="bg-dark">{{ $sector->name_ar }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-gold w-100 py-2 small fw-bold">REFINE RESULTS</button>
                        </form>
                    </div>
                </div>
            </aside>

            <!-- Main Content -->
            <main class="col-lg-9">
                <!-- Portfolio Section -->
                <div class="mb-5 pb-3 border-bottom border-white border-opacity-10 d-flex justify-content-between align-items-center">
                    <h3 class="fw-bold text-white mb-0 brand-name-premium" style="background: none; -webkit-background-clip: initial; color: white; font-size: 1.2rem;">PRODUCT PORTFOLIO</h3>
                    <span class="hero-badge mb-0 px-3">{{ $allProducts->total() }} ASSETS</span>
                </div>
                
                <div class="row g-3 mb-5">
                    @forelse($allProducts as $product)
                    <div class="col-md-6 col-xl-4" data-aos="fade-up" data-aos-delay="{{ $loop->index % 3 * 100 }}">
                        <div class="premium-glass-card h-100 border-opacity-10">
                            <div class="product-image-wrapper" style="aspect-ratio: 1/1;">
                                @php $productImg = $product->images->first(); @endphp
                                <img src="{{ $productImg ? asset('storage/' . $productImg->image_path) : 'https://via.placeholder.com/600x600?text=Premium+Product' }}" alt="{{ $product->name }}">
                                <div class="price-badge">{{ $product->currency_code }} {{ number_format($product->price) }}</div>
                            </div>
                            <div class="p-4">
                                <h6 class="fw-bold text-white mb-3 line-clamp-1 small">{{ $product->name }}</h6>
                                <div class="d-flex justify-content-between align-items-center pt-3 border-top border-white border-opacity-10 mt-auto">
                                    <span class="spec-label mb-0" style="font-size: 0.55rem;">MOQ: {{ $product->min_order_quantity }}</span>
                                    <a href="{{ route('home.products.show', $product->id) }}" class="btn btn-gold-outline btn-sm px-3 x-small fw-black py-1">DETAILS</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12 py-5 text-center">
                        <i class="ph ph-package display-4 text-white opacity-10"></i>
                        <h5 class="text-white opacity-50 mt-3 x-small fw-bold uppercase">No matching assets found in portfolio</h5>
                    </div>
                    @endforelse
                </div>
                
                <div class="mt-4 mb-5 pb-5 d-flex justify-content-center border-bottom border-white border-opacity-10">
                    {{ $allProducts->links('vendor.pagination.bootstrap-5') }}
                </div>

                <!-- Industrial Media Showcase -->
                <div class="mb-5 pb-3 border-bottom border-white border-opacity-10">
                    <h3 class="fw-bold text-white mb-0 brand-name-premium" style="background: none; -webkit-background-clip: initial; color: white; font-size: 1.2rem;">INDUSTRIAL MEDIA SHOWCASE</h3>
                </div>

                @if($user->profile_video)
                <div class="media-glass-card shadow-lg bg-black mb-4 overflow-hidden" data-aos="fade-up">
                    <video src="{{ asset('storage/' . $user->profile_video) }}" class="w-100" style="max-height: 500px; object-fit: cover;" controls></video>
                </div>
                @endif

                @if($user->gallery_images && count($user->gallery_images) > 0)
                <div class="media-glass-card p-5" data-aos="fade-up">
                    <h6 class="spec-label mb-4 d-block"><i class="ph-fill ph-images me-2 text-gold"></i>PROCESS & FACILITY GALLERY</h6>
                    <div class="gallery-grid-lux">
                        @foreach($user->gallery_images as $img)
                        <div class="gallery-item-lux">
                            <img src="{{ asset('storage/' . $img) }}">
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Timeline Updates -->
                <div class="mb-5 pb-3 border-bottom border-white border-opacity-10">
                    <h3 class="fw-bold text-white mb-0 brand-name-premium" style="background: none; -webkit-background-clip: initial; color: white; font-size: 1.2rem;">STRATEGIC UPDATES</h3>
                </div>

                <div class="premium-glass-card p-5 border-opacity-10 mb-5">
                    @forelse($user->news as $item)
                    <article class="news-article-lux">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="d-flex align-items-center gap-3">
                                <span class="spec-label mb-0">{{ $item->created_at->format('M d, Y') }}</span>
                                <div class="vr bg-white opacity-10" style="height: 15px;"></div>
                                @php 
                                    $tagStyle = 'background: rgba(255,255,255,0.05); color: #fff;';
                                    if($item->type == 'promotion') $tagStyle = 'background: rgba(212,175,55,0.1); color: var(--gold-mid); border-color: rgba(212,175,55,0.2);';
                                @endphp
                                <span class="news-tag-lux" style="{{ $tagStyle }}">{{ $item->type }}</span>
                            </div>
                        </div>
                        <h4 class="fw-bold text-white mb-3" style="font-size: 1.1rem;">
                            <span class="lang-ar">{{ $item->title_ar }}</span>
                            <span class="lang-en d-none">{{ $item->title_en ?? $item->title_ar }}</span>
                        </h4>
                        <div class="text-white opacity-50 lh-lg mb-4 small">
                            <span class="lang-ar">{{ $item->content_ar }}</span>
                            <span class="lang-en d-none">{{ $item->content_en ?? $item->content_ar }}</span>
                        </div>
                        @if($item->video)
                        <div class="rounded-4 overflow-hidden border border-white border-opacity-10 mb-4 shadow-sm">
                            <video src="{{ asset('storage/' . $item->video) }}" class="w-100" controls></video>
                        </div>
                        @endif
                        @if($item->images && count($item->images) > 0)
                        <div class="row g-2">
                            @foreach($item->images as $img)
                            <div class="col-4">
                                <img src="{{ asset('storage/' . $img) }}" class="w-100 rounded-3 border border-white border-opacity-10 h-100" style="aspect-ratio: 4/3; object-fit: cover; filter: brightness(0.8);">
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </article>
                    @empty
                    <div class="text-center py-5">
                        <i class="ph ph-megaphone-simple display-4 text-white opacity-10"></i>
                        <h5 class="text-white opacity-50 mt-3 x-small fw-bold uppercase">No strategic updates broadcast yet</h5>
                    </div>
                    @endforelse
                </div>
            </main>
        </div>
    </div>

    <!-- Modals -->
    @if(Auth::check() && Auth::id() == $user->id)
    <div class="modal fade" id="newsModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content-glass">
                <div class="lux-modal-header d-flex justify-content-between align-items-center">
                    <h5 class="modal-title fw-bold text-white brand-name-premium" style="background: none; -webkit-background-clip: initial; color: white; font-size: 1rem;">
                        <i class="ph-fill ph-megaphone me-2 text-gold"></i> BROADCAST NEW UPDATE
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('home.profile.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body p-5">
                        <div class="mb-4">
                            <span class="spec-label mb-2 d-block">BROADCAST CATEGORY</span>
                            <select name="news_type" class="form-control-lux w-100 fw-bold">
                                <option value="news" class="bg-dark">System Protocol: News Update</option>
                                <option value="advertisement" class="bg-dark">Market Directive: Advertisement</option>
                                <option value="promotion" class="bg-dark">Special Allocation: Promotion</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <span class="spec-label mb-2 d-block">BROADCAST TITLE (ARABIC)</span>
                            <input type="text" name="news_title_ar" required class="form-control-lux w-100">
                        </div>
                        <div class="mb-4">
                            <span class="spec-label mb-2 d-block">BROADCAST CONTENT (ARABIC)</span>
                            <textarea name="news_content_ar" rows="4" required class="form-control-lux w-100"></textarea>
                        </div>
                        <div class="mb-4">
                            <span class="spec-label mb-2 d-block">MEDIA ASSETS (MULTIPLE)</span>
                            <input type="file" name="news_images[]" multiple class="form-control-lux w-100 py-2">
                        </div>
                        
                        <input type="hidden" name="name" value="{{ $user->name }}">
                        <input type="hidden" name="profile_products_count" value="{{ $user->profile_products_count ?? 12 }}">
                    </div>
                    <div class="modal-footer border-top border-white border-opacity-10 p-4">
                        <button type="submit" class="btn btn-gold btn-lg w-100 fw-bold">TRANSMIT BROADCAST</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

@endsection

@section('scripts')
<script>
    function openNewsModal() {
        const modal = new bootstrap.Modal(document.getElementById('newsModal'));
        modal.show();
    }
</script>
@endsection
