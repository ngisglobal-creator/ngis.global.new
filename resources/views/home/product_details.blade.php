@extends('layouts.luxe')

@section('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        /* Amazon Style Gallery - Premium Dark Update */
        .gallery-container {
            display: flex;
            gap: 20px;
        }
        .thumb-strip {
            display: flex;
            flex-direction: column;
            gap: 12px;
            width: 80px;
            flex-shrink: 0;
        }
        .thumb-strip .thumb-item {
            width: 80px;
            height: 80px;
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.05);
            background: rgba(255, 255, 255, 0.03);
            overflow: hidden;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
            padding: 8px;
            backdrop-filter: blur(5px);
        }
        .thumb-strip .thumb-item img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            filter: brightness(0.9);
        }
        .thumb-strip .thumb-item:hover, .thumb-strip .thumb-item.active {
            border-color: var(--gold-mid);
            transform: translateX(5px);
            background: rgba(212, 175, 55, 0.1);
        }
        
        .product-gallery-main {
            flex-grow: 1;
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 32px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            aspect-ratio: 1/1;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            position: relative;
            backdrop-filter: blur(20px);
        }
        .product-gallery-main img {
            max-height: 85%;
            width: auto;
            object-fit: contain;
            transition: transform 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);
            filter: drop-shadow(0 5px 15px rgba(0,0,0,0.5));
        }
        .product-gallery-main:hover img {
            transform: scale(1.05);
        }
        
        /* Layout Tuning */
        .info-glass-panel {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(212, 175, 55, 0.1);
            backdrop-filter: blur(15px);
            border-radius: 32px;
            padding: 40px;
        }
        .spec-glass-item {
            padding: 24px;
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 20px;
            height: 100%;
            transition: all 0.3s ease;
        }
        .spec-glass-item:hover {
            background: rgba(212, 175, 55, 0.05);
            border-color: var(--gold-mid);
            transform: translateY(-5px);
        }
        
        .shipping-premium-card {
            border-radius: 24px;
            border: 1px solid rgba(212, 175, 55, 0.1);
            overflow: hidden;
            background: rgba(255, 255, 255, 0.03);
            height: 100%;
            backdrop-filter: blur(10px);
        }
        .shipping-premium-header {
            background: rgba(212, 175, 55, 0.1);
            border-bottom: 1px solid rgba(212, 175, 55, 0.2);
            padding: 20px 25px;
        }

        .shipping-stat-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }
        .shipping-stat-row:last-child { border-bottom: none; }
        
        .modal-content-glass { 
            background: rgba(5, 13, 31, 0.95);
            backdrop-filter: blur(30px);
            border-radius: 32px; 
            border: 1px solid rgba(212, 175, 55, 0.2); 
            overflow: hidden; 
        }
        .lux-modal-header { 
            background: rgba(212, 175, 55, 0.05); 
            border-bottom: 1px solid rgba(212, 175, 55, 0.1);
            padding: 30px 40px; 
        }

        /* Mobile Adjustments */
        @media (max-width: 768px) {
            .gallery-container { flex-direction: column-reverse; }
            .thumb-strip { flex-direction: row; width: 100%; overflow-x: auto; padding-bottom: 10px; }
            .thumb-strip .thumb-item:hover, .thumb-strip .thumb-item.active { transform: translateY(-5px); }
        }
    </style>
@endsection

@section('content')
    <main class="py-5">
        <div class="container px-lg-5">
            <!-- Breadcrumbs -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb" style="font-size: 0.7rem; font-weight: 800; text-transform: uppercase; letter-spacing: 2px;">
                    <li class="breadcrumb-item">
                        <a href="{{ route('welcome') }}" class="text-white opacity-50 text-decoration-none hover-white">
                            <span class="lang-en">Home</span><span class="lang-ar">الرئيسية</span>
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('home.all-products') }}" class="text-white opacity-50 text-decoration-none hover-white">
                            <span class="lang-en">Marketplace</span><span class="lang-ar">سوق المنتجات</span>
                        </a>
                    </li>
                    <li class="breadcrumb-item active text-gold" aria-current="page">{{ $product->name }}</li>
                </ol>
            </nav>

            <div class="row g-5">
                <!-- Gallery Column -->
                <div class="col-lg-7" data-aos="fade-right">
                    <div class="gallery-container">
                        <!-- Vertical Thumbnails -->
                        <div class="thumb-strip custom-scrollbar">
                            @foreach($product->images as $image)
                            <div class="thumb-item {{ $loop->first ? 'active' : '' }}" onclick="changeImage('{{ asset('storage/' . $image->image_path) }}', this)">
                                <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $product->name }}">
                            </div>
                            @endforeach
                        </div>
                        
                        <!-- Main Preview -->
                        <div class="product-gallery-main">
                            @php $firstImg = $product->images->first(); @endphp
                            <img src="{{ $firstImg ? asset('storage/' . $firstImg->image_path) : 'https://via.placeholder.com/800x600?text=No+Image' }}" id="mainImage" alt="{{ $product->name }}">
                        </div>
                    </div>

                    <!-- Market Insights Badge -->
                    <div class="mt-4 p-4 premium-glass-card border-opacity-10 d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-3">
                            <div class="p-2 bg-gold-mid bg-opacity-10 text-gold rounded-circle border border-gold border-opacity-20"><i class="ph-bold ph-trend-up"></i></div>
                            <div>
                                <span class="spec-label d-block">
                                    <span class="lang-en">Market Demand</span><span class="lang-ar">طلب السوق</span>
                                </span>
                                <span class="text-white fw-bold small">
                                    <span class="lang-en">High volume sourcing available</span><span class="lang-ar">متوفر بكميات كبيرة</span>
                                </span>
                            </div>
                        </div>
                        <div class="vr mx-3 opacity-10"></div>
                        <div class="d-flex align-items-center gap-3">
                            <div class="p-2 bg-white bg-opacity-5 text-gold rounded-circle border border-white border-opacity-10"><i class="ph-bold ph-shield-check"></i></div>
                            <div>
                                <span class="spec-label d-block">
                                    <span class="lang-en">Sourcing Protocol</span><span class="lang-ar">بروتوكول التوريد</span>
                                </span>
                                <span class="text-white fw-bold small">
                                    <span class="lang-en">Verified NGIS Source</span><span class="lang-ar">مصدر معتمد من NGIS</span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Info Column -->
                <div class="col-lg-5" data-aos="fade-left">
                    <div class="info-glass-panel sticky-top" style="top: 100px;">
                        <span class="hero-badge mb-3">{{ $product->sector->name_ar }}</span>
                        <h1 class="h3 fw-bold text-white mb-4 brand-name-premium" style="background: none; -webkit-background-clip: initial; color: white; border-bottom: 2px solid var(--gold-mid); display: inline-block; padding-bottom: 5px;">{{ $product->name }}</h1>
                        
                        <div class="d-flex align-items-baseline gap-3 mb-4 p-4 bg-white bg-opacity-5 rounded-4 border border-white border-opacity-10">
                            <span class="spec-label mb-0">
                                <span class="lang-en">Base Price:</span><span class="lang-ar">السعر الأساسي:</span>
                            </span>
                            <span class="h1 fw-black text-white no-rtl mb-0">{{ number_format($product->price, 2) }}</span>
                            <span class="h4 text-gold fw-bold mb-0">
                                <span class="lang-en">{{ $product->currency_code }}</span><span class="lang-ar">{{ $product->currency_code == 'USD' ? 'دولار' : $product->currency_code }}</span>
                            </span>
                        </div>

                        <div class="text-white opacity-50 lh-lg mb-4 small" style="display: -webkit-box; -webkit-line-clamp: 4; -webkit-box-orient: vertical; overflow: hidden;">
                            {!! $product->description !!}
                        </div>

                        <!-- Technical Highlights -->
                        <div class="row g-2 mb-5">
                            <div class="col-6">
                                <div class="spec-glass-item p-3 text-center">
                                    <span class="spec-label d-block border-bottom border-white border-opacity-10 pb-2 mb-2">
                                        <span class="lang-en">Minimum Order</span><span class="lang-ar">أقل طلب</span>
                                    </span>
                                    <span class="text-white h5 fw-bold mb-0">{{ number_format($product->min_order_quantity) }} 
                                        <small class="opacity-50 fs-6">
                                            <span class="lang-en">{{ $product->shipping_unit_type }}</span>
                                            <span class="lang-ar">كرتون</span>
                                        </small>
                                    </span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="spec-glass-item p-3 text-center">
                                    <span class="spec-label d-block border-bottom border-white border-opacity-10 pb-2 mb-2">
                                        <span class="lang-en">Unit Capacity</span><span class="lang-ar">سعة الوحدة</span>
                                    </span>
                                    <span class="text-white h5 fw-bold mb-0">{{ $product->carton_volume_cbm }} 
                                        <small class="opacity-50 fs-6">
                                            <span class="lang-en">CBM</span><span class="lang-ar">CBM</span>
                                        </small>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="pt-4 border-top border-white border-opacity-10">
                            @auth
                                <button class="btn btn-gold btn-lg w-100 py-3 rounded-pill fw-bold" data-bs-toggle="modal" data-bs-target="#orderModal">
                                    <i class="ph-bold ph-factory me-2"></i> 
                                    <span class="lang-en">INITIATE PRODUCTION</span><span class="lang-ar">بدء التصنيع</span>
                                </button>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-gold-outline btn-lg w-100 py-3 rounded-pill fw-bold">
                                    <span class="lang-en">LOGIN TO ORDER</span><span class="lang-ar">سجل الدخول للطلب</span>
                                </a>
                            @endguest
                            
                            <div class="d-flex align-items-center justify-content-center gap-3 py-3">
                                <i class="ph-fill ph-check-circle text-gold fs-5"></i>
                                <span class="spec-label">
                                    <span class="lang-en">100% SECURE GLOBAL TRANSACTION</span><span class="lang-ar">عملية توريد آمنة بالكامل</span>
                                </span>
                            </div>
                        </div>

                        <!-- Vendor Mini-Card -->
                        <div class="mt-4 p-3 bg-white bg-opacity-5 rounded-4 d-flex align-items-center gap-3 border border-white border-opacity-5">
                            <img src="{{ $product->user->avatar ? asset('storage/' . $product->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($product->user->name) }}" class="avatar-circle" style="width: 44px; height: 44px;">
                            <div class="flex-grow-1">
                                <span class="spec-label d-block">
                                    <span class="lang-en">ENTITY TYPE</span><span class="lang-ar">نوع الكيان</span>
                                </span>
                                <a href="{{ route('home.profile', $product->user->id) }}" class="text-white fw-bold text-decoration-none small">{{ $product->user->name }}</a>
                            </div>
                            <a href="{{ route('home.profile', $product->user->id) }}" class="btn btn-outline-light btn-sm rounded-pill border-opacity-25 px-3" style="font-size: 0.65rem;">
                                <span class="lang-en">VIEW PROFILE</span><span class="lang-ar">الملف</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Shipping Capacity Section -->
            <section class="mt-5 pt-5">
                <div class="text-center mb-5" data-aos="fade-up">
                    <span class="spec-label mb-2">LOGISTICS PERFORMANCE INDEX</span>
                    <h2 class="fw-bold text-white">
                        <span class="lang-en">Shipping <span class="text-gold">Intelligence</span></span>
                        <span class="lang-ar">ذكاء <span class="text-gold">الشحن</span></span>
                    </h2>
                </div>

                <div class="row g-4 mb-5">
                    @php
                        $cbm = $product->carton_volume_cbm > 0 ? $product->carton_volume_cbm : 1;
                        $containers = [
                            ['name' => '20ft Lite Terminal', 'cap' => 28, 'icon' => 'ph-shipping-container'],
                            ['name' => '40ft Trade Center', 'cap' => 40, 'icon' => 'ph-shipping-container'],
                            ['name' => '40ft HQ Fortress', 'cap' => 68, 'icon' => 'ph-shipping-container'],
                            ['name' => '45ft Global Terminal', 'cap' => 78, 'icon' => 'ph-shipping-container']
                        ];
                    @endphp

                    @foreach($containers as $container)
                    <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        <div class="shipping-premium-card">
                            <div class="shipping-premium-header d-flex justify-content-between align-items-center">
                                <h6 class="fw-bold text-white mb-0 x-small uppercase tracking-widest"><i class="ph-bold {{ $container['icon'] }} me-2 text-gold"></i>{{ $container['name'] }}</h6>
                            </div>
                            <div class="p-4">
                                @php
                                    $cartons = floor($container['cap'] / $cbm);
                                    $totalPieces = $cartons * $product->product_piece_count;
                                @endphp
                                <div class="shipping-stat-row">
                                    <span class="spec-label">Capacity</span>
                                    <span class="text-gold fw-bold">{{ $container['cap'] }} CBM</span>
                                </div>
                                <div class="shipping-stat-row">
                                    <span class="spec-label">Total Units</span>
                                    <span class="text-white fw-bold">{{ number_format($cartons) }} CTNS</span>
                                </div>
                                <div class="shipping-stat-row">
                                    <span class="spec-label">Payload Pcs</span>
                                    <span class="text-white fw-bold">{{ number_format($totalPieces) }}</span>
                                </div>
                                <div class="mt-4 p-3 bg-gold-mid bg-opacity-5 rounded-3 d-flex justify-content-between align-items-center border border-gold border-opacity-10">
                                    <span class="spec-label text-gold">TOTAL MARKET VALUE</span>
                                    <span class="fw-black h6 mb-0 text-white">{{ number_format($totalPieces * $product->price, 2) }} 
                                        <small class="text-gold">{{ $product->currency_code }}</small>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </section>

            <!-- Technical Table -->
            <section class="mt-5">
                <div class="premium-glass-card p-0 border-opacity-10 overflow-hidden">
                    <div class="p-4 bg-white bg-opacity-5 text-white d-flex justify-content-between align-items-center border-bottom border-white border-opacity-10">
                        <h5 class="mb-0 fw-bold brand-name-premium" style="background: none; -webkit-background-clip: initial; color: white; font-size: 0.9rem;">LOGISTICAL SPECIFICATIONS</h5>
                        <span class="hero-badge mb-0 py-1" style="font-size: 0.55rem; background: rgba(0,255,0,0.05); color: #00ff00; border-color: rgba(0,255,0,0.2);">VERIFIED DATA POINT</span>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-dark table-hover align-middle mb-0 bg-transparent">
                            <thead class="bg-white bg-opacity-5 spec-label">
                                <tr>
                                    <th class="px-4 py-3 border-0">Product Identity</th>
                                    <th class="px-4 py-3 border-0">Unit Valuation</th>
                                    <th class="px-4 py-3 border-0 text-center">Density (%)</th>
                                    <th class="px-4 py-3 border-0 text-center">Net Mass</th>
                                    <th class="px-4 py-3 border-0 text-center">Transit MOQ</th>
                                    <th class="px-4 py-3 border-0 text-gold text-center">VOL (CBM)</th>
                                    <th class="px-4 py-3 border-0 bg-gold bg-opacity-5 text-gold text-center">20FT</th>
                                    <th class="px-4 py-3 border-0 bg-gold bg-opacity-5 text-gold text-center">40FT</th>
                                    <th class="px-4 py-3 border-0 bg-gold bg-opacity-5 text-gold text-center">40HQ</th>
                                    <th class="px-4 py-3 border-0 bg-gold bg-opacity-5 text-gold text-center">45FT</th>
                                </tr>
                            </thead>
                            <tbody class="small fw-semibold text-white text-opacity-75">
                                <tr>
                                    <td class="px-4 py-4">{{ $product->name }}</td>
                                    <td class="px-4 py-4">{{ number_format($product->price, 2) }} {{ $product->currency_code }}</td>
                                    <td class="px-4 py-4 text-center">{{ $product->product_piece_count }} Pcs</td>
                                    <td class="px-4 py-4 text-center">{{ $product->piece_weight }} KG</td>
                                    <td class="px-4 py-4 text-center">{{ $product->min_order_quantity }}</td>
                                    <td class="px-4 py-4 text-gold fw-bold text-center">{{ $product->carton_volume_cbm }}</td>
                                    <td class="px-4 py-4 bg-gold bg-opacity-5 text-white fw-black text-center">{{ number_format(floor(28 / $cbm)) }}</td>
                                    <td class="px-4 py-4 bg-gold bg-opacity-5 text-white fw-black text-center">{{ number_format(floor(40 / $cbm)) }}</td>
                                    <td class="px-4 py-4 bg-gold bg-opacity-5 text-white fw-black text-center">{{ number_format(floor(68 / $cbm)) }}</td>
                                    <td class="px-4 py-4 bg-gold bg-opacity-5 text-white fw-black text-center">{{ number_format(floor(78 / $cbm)) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="p-3 bg-white bg-opacity-5 border-top border-white border-opacity-10 spec-label d-flex gap-4">
                        <span><strong>DIMENSIONAL PROFILE:</strong> {{ $product->carton_length }} • {{ $product->carton_width }} • {{ $product->carton_height }} CM</span>
                        <span class="ms-auto opacity-50"><i class="ph ph-warning-circle me-1"></i> Data subject to post-production inspection audit</span>
                    </div>
                </div>
            </section>
        </div>

        <!-- Related Products Section -->
        @if(isset($relatedProducts) && count($relatedProducts) > 0)
        <section class="py-5 bg-white bg-opacity-5 border-top border-white border-opacity-5 mt-5">
            <div class="container px-lg-5">
                <div class="d-flex justify-content-between align-items-center mb-5" data-aos="fade-up">
                    <h2 class="section-title text-white mb-0">
                        <span class="lang-en">Strategic <span class="text-gold">Alternatives</span></span>
                        <span class="lang-ar">خيارات <span class="text-gold">استراتيجية</span></span>
                    </h2>
                    <a href="{{ route('home.all-products') }}" class="btn btn-outline-light btn-sm rounded-pill px-4 border-opacity-25 fw-bold">
                        <span class="lang-en">EXPLORE ALL</span><span class="lang-ar">استكشف الكل</span>
                    </a>
                </div>

                <div class="row g-4 row-cols-2 row-cols-md-3 row-cols-lg-5">
                    @foreach($relatedProducts as $rel)
                    <div class="col" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        <div class="premium-glass-card h-100">
                            <div class="product-image-wrapper">
                                @php $relImg = $rel->images->first(); @endphp
                                <img src="{{ $relImg ? asset('storage/' . $relImg->image_path) : 'https://via.placeholder.com/400x300' }}" alt="{{ $rel->name }}">
                                <div class="price-badge">{{ $rel->currency_code }} {{ number_format($rel->price) }}</div>
                            </div>
                            <div class="p-3">
                                <h6 class="fw-bold text-white text-truncate mb-1" style="font-size: 0.85rem;">{{ $rel->name }}</h6>
                                <p class="spec-label mb-3" style="font-size: 0.55rem;">CAPACITY MOQ: {{ $rel->min_order_quantity }}</p>
                                
                                <div class="d-flex align-items-center gap-2 mb-3">
                                    <img src="{{ $rel->user->avatar ? asset('storage/' . $rel->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($rel->user->name) }}" class="avatar-circle" style="width: 28px; height: 28px;">
                                    <span class="spec-label text-truncate" style="font-size: 0.6rem;">{{ $rel->user->name }}</span>
                                </div>
                                
                                <a href="{{ route('home.products.show', $rel->id) }}" class="btn btn-gold w-100 btn-sm py-2">
                                    <span class="lang-en">ACCESS SPECS</span><span class="lang-ar">دخول البيانات</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif
    </main>

    <!-- Order Modal -->
    <div class="modal fade" id="orderModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content-glass">
                <div class="lux-modal-header d-flex justify-content-between align-items-center">
                    <h5 class="modal-title fw-bold text-white brand-name-premium" style="background: none; -webkit-background-clip: initial; color: white; font-size: 1rem;">
                        <i class="ph ph-shopping-bag-open me-2 text-gold"></i>
                        <span class="lang-en">CONFIRM PROCUREMENT REQUEST</span><span class="lang-ar">تأكيد طلب التوريد</span>
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-5">
                    <form id="orderForm">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        
                        <div class="row g-4">
                            <div class="col-md-12">
                                <span class="spec-label mb-2 d-block">PROCUREMENT BASIS</span>
                                <select name="shipping_unit_type" id="order_unit_type" class="form-control-lux w-100 fw-bold">
                                    <option value="Cartons" class="bg-dark">System Optimization: Order by Cartons</option>
                                    <option value="Pieces" class="bg-dark">Piece-Based Individual Order</option>
                                    @if(Auth::check() && (Auth::user()->type == 'merchant' || Auth::user()->type == 'company_owner'))
                                        <option value="Container20" class="bg-dark">Container Terminal: 20ft Unit</option>
                                        <option value="Container40" class="bg-dark">Container Terminal: 40ft Unit</option>
                                        <option value="Container40HQ" class="bg-dark">Container Terminal: 40ft HQ Unit</option>
                                        <option value="Container45" class="bg-dark">Container Terminal: 45ft Unit</option>
                                    @endif
                                </select>
                            </div>

                            <div class="col-md-4" id="container_input_wrapper" style="display: none;">
                                <span class="spec-label mb-2 d-block">CONTAINER QTY</span>
                                <input type="number" id="order_containers" value="1" min="0.1" step="0.1" class="form-control-lux w-100 fw-bold">
                            </div>

                            <div class="col-md-4" id="carton_input_wrapper">
                                <span class="spec-label mb-2 d-block" id="label_cartons">CARTON CAPACITY</span>
                                <input type="number" id="order_cartons" value="{{ ceil($product->min_order_quantity / max($product->product_piece_count, 1)) }}" min="{{ ceil($product->min_order_quantity / max($product->product_piece_count, 1)) }}" class="form-control-lux w-100 fw-bold">
                            </div>

                            <div class="col-md-4" id="piece_input_wrapper">
                                <span class="spec-label mb-2 d-block" id="label_pieces">TOTAL PIECE PAYLOAD</span>
                                <input type="number" name="quantity" id="order_quantity" value="{{ $product->min_order_quantity }}" min="{{ $product->min_order_quantity }}" class="form-control-lux w-100 bg-white bg-opacity-5 fw-bold" readonly>
                            </div>

                            <!-- Live Results Grid -->
                            <div class="col-md-4">
                                <div class="p-3 bg-white bg-opacity-5 rounded-4 text-center border border-white border-opacity-5">
                                    <span class="spec-label mb-1 d-block" style="font-size: 0.6rem;">TELEMETRY VOL</span>
                                    <div class="h5 fw-black text-gold mb-0"><span id="order_cbm">0.00</span> <small class="x-small">CBM</small></div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="p-3 bg-white bg-opacity-5 rounded-4 text-center border border-white border-opacity-5">
                                    <span class="spec-label mb-1 d-block" style="font-size: 0.6rem;">NET MASS</span>
                                    <div class="h5 fw-black text-white mb-0"><span id="order_weight">0.00</span> <small class="x-small">KG</small></div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="p-3 bg-gold bg-opacity-10 rounded-4 text-center border border-gold border-opacity-20 shadow-inner">
                                    <span class="spec-label text-gold mb-1 d-block" style="font-size: 0.6rem;">VALUATION TOTAL</span>
                                    <div class="h5 fw-black text-white mb-0"><span id="order_total">0.00</span> <small class="x-small text-gold">{{ $product->currency_code }}</small></div>
                                </div>
                            </div>

                            <div class="col-12 mt-4">
                                <span class="spec-label mb-2 d-block">LOGISTICS NOTES / SECURE INSTRUCTIONS</span>
                                <textarea name="notes" class="form-control-lux w-100" rows="3" placeholder="Specify discharge port, secure labeling requirements, or handling instructions..."></textarea>
                            </div>
                        </div>

                        <div class="mt-5 pt-4 border-top border-white border-opacity-10">
                            <button type="submit" id="submitOrder" class="btn btn-gold btn-lg w-100 py-3 rounded-pill fw-bold">
                                <i class="ph-bold ph-paper-plane-tilt me-2"></i> 
                                <span class="lang-en">TRANSMIT PRODUCTION REQUEST</span><span class="lang-ar">إرسال طلب التصنيع</span>
                            </button>
                            <p class="text-center x-small text-white opacity-25 mt-3 letter-spacing-1">
                                [ SYSTEM NOTE: FINAL PROCUREMENT QUOTATION SUBJECT TO AGENT VERIFICATION ]
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const pieceCount = {{ $product->product_piece_count > 0 ? $product->product_piece_count : 1 }};
    const cbmPerCarton = {{ $product->carton_volume_cbm > 0 ? $product->carton_volume_cbm : 1 }};
    const unitPrice = {{ $product->price }};
    const pieceWeight = {{ $product->piece_weight }};
    const currency = '{{ $product->currency_code }}';

    function changeImage(src, el) {
        document.getElementById('mainImage').src = src;
        document.querySelectorAll('.thumb-item').forEach(i => i.classList.remove('active'));
        el.classList.add('active');
    }

    const containerCaps = {
        'Container20': 28,
        'Container40': 40,
        'Container40HQ': 68,
        'Container45': 78
    };

    function calculateOrder(source) {
        let qty = 0;
        let cartons = 0;
        let containers = 0;
        
        const unitType = document.getElementById('order_unit_type').value;

        if (source === 'containers') {
            containers = parseFloat(document.getElementById('order_containers').value) || 0;
            const cap = containerCaps[unitType] || 28;
            cartons = Math.floor((containers * cap) / cbmPerCarton);
            qty = cartons * pieceCount;
            document.getElementById('order_cartons').value = cartons;
            document.getElementById('order_quantity').value = qty;
        } else if (source === 'cartons') {
            cartons = parseInt(document.getElementById('order_cartons').value) || 0;
            qty = cartons * pieceCount;
            document.getElementById('order_quantity').value = qty;
        } else if (source === 'pieces') {
            qty = parseInt(document.getElementById('order_quantity').value) || 0;
            cartons = Math.ceil(qty / pieceCount);
            document.getElementById('order_cartons').value = cartons;
        } else {
            // Initial load
            qty = parseInt(document.getElementById('order_quantity').value) || 0;
            cartons = Math.ceil(qty / pieceCount);
            document.getElementById('order_cartons').value = cartons;
        }

        const totalCbm = (cartons * cbmPerCarton).toFixed(3);
        const totalWeight = (qty * pieceWeight).toFixed(2);
        const totalCost = (qty * unitPrice).toLocaleString(undefined, {minimumFractionDigits: 2});

        document.getElementById('order_cbm').innerText = totalCbm;
        document.getElementById('order_weight').innerText = totalWeight;
        document.getElementById('order_total').innerText = totalCost;

        // Update container loading stats
        const cap20 = document.getElementById('cap20');
        if (cap20) {
            document.getElementById('cap20').innerText = (totalCbm / 28).toFixed(2);
            document.getElementById('cap40').innerText = (totalCbm / 40).toFixed(2);
            document.getElementById('cap40hq').innerText = (totalCbm / 68).toFixed(2);
            document.getElementById('cap45').innerText = (totalCbm / 78).toFixed(2);
        }
    }

    document.getElementById('order_unit_type').addEventListener('change', function() {
        const type = this.value;
        const containerWrapper = document.getElementById('container_input_wrapper');
        const cartonsWrapper = document.getElementById('carton_input_wrapper');
        const piecesWrapper = document.getElementById('piece_input_wrapper');

        if (type.startsWith('Container')) {
            containerWrapper.style.display = 'block';
            cartonsWrapper.classList.replace('col-md-6', 'col-md-4');
            piecesWrapper.classList.replace('col-md-6', 'col-md-4');
            
            document.getElementById('order_containers').readOnly = false;
            document.getElementById('order_cartons').readOnly = true;
            document.getElementById('order_cartons').style.background = 'rgba(255,255,255,0.02)';
            document.getElementById('order_cartons').style.border = '1px solid rgba(255,255,255,0.05)';
            document.getElementById('order_quantity').readOnly = true;
            document.getElementById('order_quantity').style.background = 'rgba(255,255,255,0.02)';
            document.getElementById('order_quantity').style.border = '1px solid rgba(255,255,255,0.05)';
            calculateOrder('containers');
        } else if (type === 'Cartons') {
            containerWrapper.style.display = 'none';
            cartonsWrapper.classList.replace('col-md-4', 'col-md-6');
            piecesWrapper.classList.replace('col-md-4', 'col-md-6');

            document.getElementById('order_cartons').readOnly = false;
            document.getElementById('order_cartons').style.background = 'rgba(255,255,255,0.05)';
            document.getElementById('order_cartons').style.border = '1px solid rgba(212,175,55,0.2)';
            document.getElementById('order_quantity').readOnly = true;
            document.getElementById('order_quantity').style.background = 'rgba(255,255,255,0.02)';
            document.getElementById('order_quantity').style.border = '1px solid rgba(255,255,255,0.05)';
            calculateOrder('cartons');
        } else {
            containerWrapper.style.display = 'none';
            cartonsWrapper.classList.replace('col-md-4', 'col-md-6');
            piecesWrapper.classList.replace('col-md-4', 'col-md-6');

            document.getElementById('order_cartons').readOnly = true;
            document.getElementById('order_cartons').style.background = 'rgba(255,255,255,0.02)';
            document.getElementById('order_cartons').style.border = '1px solid rgba(255,255,255,0.05)';
            document.getElementById('order_quantity').readOnly = false;
            document.getElementById('order_quantity').style.background = 'rgba(255,255,255,0.05)';
            document.getElementById('order_quantity').style.border = '1px solid rgba(212,175,55,0.2)';
            calculateOrder('pieces');
        }
    });

    document.getElementById('order_containers').addEventListener('input', () => calculateOrder('containers'));
    document.getElementById('order_cartons').addEventListener('input', () => calculateOrder('cartons'));
    document.getElementById('order_quantity').addEventListener('input', () => calculateOrder('pieces'));
    window.addEventListener('load', () => calculateOrder());

    $('#orderForm').on('submit', function(e) {
        e.preventDefault();
        const btn = $('#submitOrder');
        const isAr = document.documentElement.lang === 'ar';
        
        const loadingText = isAr ? '<span class="spinner-border spinner-border-sm"></span> جاري الإرسال...' : '<span class="spinner-border spinner-border-sm"></span> SENDING...';
        btn.prop('disabled', true).html(loadingText);

        $.ajax({
            url: "{{ route('orders.store') }}",
            method: 'POST',
            data: $(this).serialize(),
            success: function(res) {
                Swal.fire({
                    icon: 'success',
                    title: isAr ? 'تم إرسال الطلب' : 'ORDER SENT',
                    text: isAr ? 'لقد استلم المصنع طلبك بنجاح. يمكنك متابعة الطلب من لوحة التحكم.' : 'The factory has received your request. You can track it in your dashboard.',
                    confirmButtonText: isAr ? 'حسناً' : 'OK',
                    confirmButtonColor: '#D4AF37'
                }).then(() => {
                    location.reload();
                });
            },
            error: function(err) {
                btn.prop('disabled', false).text('SUBMIT ORDER TO FACTORY');
                Swal.fire({
                    icon: 'error',
                    title: 'FAILED',
                    text: 'Could not send order. Please check your data.',
                    confirmButtonColor: '#000'
                });
            }
        });
    });
</script>
@endsection
