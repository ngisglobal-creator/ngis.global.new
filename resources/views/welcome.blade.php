@extends('layouts.luxe')

@section('title', 'NGIS | Global Trade Hub')

@section('styles')
    <style>
        /* Specific Home Page adjustments */
        #globe-container {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            z-index: 1;
            pointer-events: all;
        }

        .hero-section {
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            padding-top: 150px;
            overflow: hidden;
            background: transparent;
            z-index: 2;
        }

        /* Mockup Header & Search */
        .premium-header-bar {
            background: rgba(5, 13, 31, 0.4);
            backdrop-filter: blur(10px);
            border-bottom: 2px solid rgba(212, 175, 55, 0.3);
            border-radius: 0 0 40px 40px;
            padding: 10px 0;
            position: relative;
            z-index: 1000;
        }

        .luxe-search-container {
            position: relative;
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
        }

        .luxe-search-input {
            width: 100%;
            background: rgba(0,0,0,0.6) !important;
            border: 1px solid rgba(212,175,55,0.4) !important;
            border-radius: 12px;
            padding: 10px 100px 10px 45px;
            color: #fff !important;
            font-size: 0.9rem;
        }

        .search-btn-embed {
            position: absolute;
            right: 5px;
            top: 5px;
            bottom: 5px;
            background: linear-gradient(to bottom, #fbe69b, #d4af37);
            border: none;
            border-radius: 8px;
            padding: 0 25px;
            font-weight: 800;
            color: #000;
            text-transform: uppercase;
            font-size: 0.75rem;
        }

        /* Nav Shield Logo */
        .nav-shield-logo {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 140px;
            height: 80px;
            background: rgba(5, 13, 31, 0.8);
            border: 1px solid rgba(212,175,55,0.5);
            border-top: none;
            border-radius: 0 0 70px 70px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
            z-index: 1001;
        }

        .shield-wings {
            position: absolute;
            width: 100%;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--gold-mid), transparent);
            top: 0;
            left: 0;
        }

        /* Floating Info Labels */
        .globe-label {
            background: rgba(5, 13, 31, 0.8);
            border: 1px solid var(--gold-mid);
            color: #fff;
            padding: 4px 12px;
            border-radius: 4px;
            font-size: 0.7rem;
            font-weight: 800;
            white-space: nowrap;
            display: flex;
            align-items: center;
            gap: 8px;
            pointer-events: none;
            box-shadow: 0 0 15px rgba(212,175,55,0.3);
        }

        .portal-card-premium {
            background: linear-gradient(135deg, rgba(255,255,255,0.05) 0%, rgba(255,255,255,0) 100%);
            border: 1px solid rgba(212, 175, 55, 0.2);
            backdrop-filter: blur(20px);
            border-radius: 30px 10px 30px 10px;
            padding: 40px 30px;
            text-align: center;
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
        }
        .portal-card-premium:hover {
            border-color: var(--gold-mid);
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.5);
        }

        .portal-icon-luxe {
            width: 80px;
            height: 80px;
            margin: 0 auto 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(212, 175, 55, 0.1);
            border: 1px solid rgba(212, 175, 55, 0.3);
            border-radius: 20px;
            color: var(--gold-mid);
            font-size: 2.5rem;
        }

        /* Product Showcase Layout */
        .showcase-tabs {
            background: rgba(0,0,0,0.3);
            border-radius: 50px;
            padding: 5px;
            display: inline-flex;
            gap: 5px;
            border: 1px solid rgba(212, 175, 55, 0.2);
        }
        .tab-btn {
            padding: 8px 25px;
            border-radius: 40px;
            border: none;
            background: transparent;
            color: #fff;
            font-weight: 800;
            font-size: 0.75rem;
            text-transform: uppercase;
            transition: all 0.3s ease;
        }
        .tab-btn.active { background: var(--gold-mid); color: #000; }

        /* Tracking Mini Side Widget */
        .tracking-widget-luxe {
            background: rgba(5, 13, 31, 0.7);
            border: 1px solid rgba(212, 175, 55, 0.3);
            border-radius: 20px;
            padding: 25px;
            margin-top: 30px;
        }

    </style>
@endsection

@section('content')

    {{-- 3D Globe Background --}}
    <div id="globe-container"></div>

    {{-- Premium Floating Header --}}
    <div class="premium-header-bar sticky-top">
        <div class="container d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-3">
                <img src="{{ asset('assets/images/logo-ngis.png') }}" style="height: 40px;">
                <div class="lh-1">
                    <div class="brand-name-premium fs-4">NGIS</div>
                    <div class="x-small text-gold fw-bold">GLOBAL INTEGRATED</div>
                </div>
            </div>

            <div class="luxe-search-container d-none d-lg-block">
                <i class="ph ph-magnifying-glass position-absolute text-gold" style="left: 15px; top: 12px; z-index: 10;"></i>
                <input type="text" class="luxe-search-input" placeholder="Search for products, factories, vehicles...">
                <button class="search-btn-embed">SEARCH</button>
            </div>

            <div class="d-flex align-items-center gap-4">
                <div class="text-white small d-none d-md-block">
                    <span class="text-gold me-2">CHINA ➔ BENGHAZI:</span> $1,200/TEU
                </div>
                <div class="dropdown">
                    <button class="btn btn-gold btn-sm px-4 rounded-3 dropdown-toggle" data-bs-toggle="dropdown">
                        <i class="ph-fill ph-user-circle me-1"></i> ACCOUNT
                    </button>
                    <ul class="dropdown-menu">
                        @guest
                            <li><a class="dropdown-item" href="{{ route('login') }}">Login</a></li>
                            <li><a class="dropdown-item" href="{{ route('register') }}">Join NGIS</a></li>
                        @else
                            <li><a class="dropdown-item" href="{{ route('dashboard') }}">Dashboard</a></li>
                        @endguest
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Nav with Shield --}}
    <div class="ecosystem-bar py-3" style="border-bottom: 2px solid rgba(212,175,55,0.1); position: relative; z-index: 999;">
        <div class="container d-flex justify-content-center gap-5">
            <a href="#" class="ecosystem-link active">GLOBAL ECOSYSTEM</a>
            <a href="#" class="ecosystem-link">AUTOMOTIVE DIVISION</a>
            <div class="mx-3" style="width: 140px;"></div> {{-- Space for shield --}}
            <a href="#" class="ecosystem-link">PARTNER FACTORIES</a>
            <a href="#" class="ecosystem-link">LOGISTICS HUB</a>
        </div>

        <div class="nav-shield-logo">
            <div class="shield-wings"></div>
            <img src="{{ asset('assets/images/logo-ngis.png') }}" style="height: 50px; filter: drop-shadow(0 0 10px var(--gold-mid));">
        </div>
    </div>

    <header class="hero-section">
        <div class="container text-center">
            <div class="row justify-content-center">
                <div class="col-lg-10" data-aos="fade-up">
                    <div class="hero-badge mb-4">ACTIVE GLOBAL TRADE ROUTES</div>
                    <h1 class="brand-name-premium mb-4" style="font-size: 5rem; letter-spacing: 15px; text-shadow: 0 0 30px rgba(212,175,55,0.3);">
                        NGIS HUB
                    </h1>
                    <div class="d-flex justify-content-center gap-4 mb-5 fs-5 text-white-50 letter-spacing-2">
                        <span>FACTORIES</span> <span class="text-gold">|</span> <span>OEM</span> <span class="text-gold">|</span> <span>EXPORT</span>
                    </div>

                    {{-- Mockup Floating Marker Replication --}}
                    <div class="d-flex justify-content-center gap-5 mt-5">
                        <div class="globe-label glowing-gold-border" style="transform: translateY(-100px) translateX(-200px);">
                            <img src="https://flagcdn.com/w20/cn.png" width="20"> CHINA MANUFACTURING HUB
                        </div>
                        <div class="globe-label" style="transform: translateY(-50px) translateX(200px);">
                            <img src="https://flagcdn.com/w20/sa.png" width="20"> RIYADH REGIONAL HUB
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>    {{-- PORTAL CARDS --}}
    <section class="portal-overlap">
        <div class="container">
            <div class="row g-4 px-lg-5">
                {{-- Factories --}}
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="portal-card-premium">
                        <div class="portal-icon-luxe">
                            <i class="ph ph-factory"></i>
                        </div>
                        <h4 class="fw-bold mb-3 text-white">FACTORIES PORTAL</h4>
                        <p class="text-white-50 small mb-4">Join & Get Certified. Access direct manufacturing lines globally.</p>
                        <a href="{{ route('register.factory') }}" class="luxe-search-btn text-decoration-none d-inline-block">REGISTER FACTORY</a>
                    </div>
                </div>
                {{-- Vendors --}}
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="portal-card-premium glowing-gold-border">
                        <div class="portal-icon-luxe bg-gold text-black" style="background: var(--gold-mid) !important; color: #000 !important;">
                            <i class="ph ph-buildings"></i>
                        </div>
                        <h4 class="fw-bold mb-3 text-white">VENDORS PORTAL</h4>
                        <p class="text-white-50 small mb-4">Expand Your Business. Connect with verified strategic partners.</p>
                        <a href="{{ route('register.company') }}" class="luxe-search-btn text-decoration-none d-inline-block">REGISTER VENDOR</a>
                    </div>
                </div>
                {{-- Traders --}}
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="portal-card-premium">
                        <div class="portal-icon-luxe">
                            <i class="ph ph-shopping-cart"></i>
                        </div>
                        <h4 class="fw-bold mb-3 text-white">TRADERS PORTAL</h4>
                        <p class="text-white-50 small mb-4">Buy Wholesale. Direct access to verified product catalogs.</p>
                        <a href="{{ route('register.client') }}" class="luxe-search-btn text-decoration-none d-inline-block">REGISTER TRADER</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- PRODUCT SHOWCASE --}}
    <section class="py-5 mt-5">
        <div class="container">
            <div class="d-flex justify-content-between align-items-end mb-5">
                <div>
                    <h2 class="section-title mb-2 fs-1">Verified <span class="text-gold">Products</span> Showcase</h2>
                    <div class="showcase-tabs">
                        <button class="tab-btn active">Vehicles</button>
                        <button class="tab-btn">Heavy Equipment</button>
                        <button class="tab-btn">General Goods</button>
                        <button class="tab-btn">Electronics</button>
                    </div>
                </div>
            </div>

            <div class="row g-4 scroll-horizontal-mobile">
                @foreach($ngisProducts->take(4) as $product)
                <div class="col-lg-3 col-md-6" data-aos="fade-up">
                    <div class="curvy-glass p-0 overflow-hidden h-100 d-flex flex-column">
                        <div class="product-image-wrapper">
                             @php $firstImage = $product->images->first(); @endphp
                            <img src="{{ $firstImage ? asset('storage/' . $firstImage->image_path) : 'https://via.placeholder.com/400x300' }}" style="height: 200px; width: 100%; object-fit: cover;">
                            <div class="price-badge">{{ $product->currency_code }} {{ number_format($product->price) }}</div>
                        </div>
                        <div class="p-4 flex-grow-1">
                            <h6 class="fw-bold text-white mb-2">{{ $product->name }}</h6>
                            <div class="d-flex align-items-center gap-2 mb-3">
                                <img src="https://flagcdn.com/w20/cn.png" width="16">
                                <span class="x-small text-white-50">Shanghai Stock</span>
                            </div>
                            <button class="luxe-search-btn w-100 py-2 fs-smaller" style="font-size: 0.7rem;">REQUEST SPECS</button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- FACTORY SHOWCASE --}}
    <section class="py-5" style="background: rgba(255,255,255,0.02); border-top: 1px solid rgba(212,175,55,0.1);">
        <div class="container py-4">
            <div class="d-flex justify-content-between align-items-end mb-5">
                <div>
                    <h2 class="section-title mb-1 fs-2">Strategic <span class="text-gold">Partner</span> Factories</h2>
                    <p class="text-white-50 small">Direct manufacturing lines with verified NGIS quality control.</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('home.factory-products') }}" class="tab-btn px-4 text-decoration-none" style="border: 1px solid var(--gold-mid); color: #fff;">VIEW ALL</a>
                </div>
            </div>

            <div class="row g-4 row-cols-2 row-cols-md-3 row-cols-lg-5">
                @php $factoryProducts = $recommendedProducts->where('user.type', 'factory')->take(5); @endphp
                @foreach($factoryProducts as $product)
                <div class="col" data-aos="fade-up">
                    <div class="curvy-glass h-100 d-flex flex-column p-0">
                        <div class="product-image-wrapper">
                            @php $firstImage = $product->images->first(); @endphp
                            <img src="{{ $firstImage ? asset('storage/' . $firstImage->image_path) : 'https://via.placeholder.com/400x300' }}" style="height: 180px; width: 100%; object-fit: cover;">
                            <div class="price-badge">{{ $product->currency_code }} {{ number_format($product->price) }}</div>
                        </div>
                        <div class="p-3 flex-grow-1 d-flex flex-column">
                            <span class="text-gold fw-bold mb-1 uppercase" style="font-size: 0.55rem; letter-spacing: 1px;">VERIFIED FACTORY</span>
                            <h6 class="fw-bold text-white text-truncate mb-3" style="font-size: 0.85rem;">{{ $product->name }}</h6>
                            <div class="d-flex align-items-center gap-2 mt-auto pt-3 border-top border-white-10">
                                <img src="{{ $product->user->avatar ? asset('storage/' . $product->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($product->user->name) }}" class="avatar-circle" style="width: 22px; height: 22px;">
                                <span class="x-small text-white-50 text-truncate" style="font-size: 0.65rem;">{{ $product->user->name }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- SUPPLIER SHOWCASE --}}
    <section class="py-5">
        <div class="container py-4">
            <div class="d-flex justify-content-between align-items-end mb-5">
                <div>
                    <h2 class="section-title mb-1 fs-2">Supplier <span class="text-gold">Market</span> Hub</h2>
                    <p class="text-white-50 small">Premium wholesale sourcing and distribution for global traders.</p>
                </div>
                <a href="{{ route('home.all-products') }}" class="luxe-search-btn text-decoration-none">EXPLORE MARKET</a>
            </div>

            <div class="row g-4 row-cols-2 row-cols-md-3 row-cols-lg-5">
                @php $companyProducts = $recommendedProducts->where('user.type', 'company')->take(5); @endphp
                @foreach($companyProducts as $product)
                <div class="col" data-aos="fade-up">
                    <div class="curvy-glass h-100 d-flex flex-column p-0">
                        <div class="product-image-wrapper">
                            @php $firstImage = $product->images->first(); @endphp
                            <img src="{{ $firstImage ? asset('storage/' . $firstImage->image_path) : 'https://via.placeholder.com/400x300' }}" style="height: 180px; width: 100%; object-fit: cover;">
                            <div class="price-badge">{{ $product->currency_code }} {{ number_format($product->price) }}</div>
                        </div>
                        <div class="p-3 flex-grow-1 d-flex flex-column">
                            <span class="text-gold fw-bold mb-1 uppercase" style="font-size: 0.55rem; letter-spacing: 1px;">STRATEGIC VENDOR</span>
                            <h6 class="fw-bold text-white text-truncate mb-3" style="font-size: 0.85rem;">{{ $product->name }}</h6>
                            <div class="d-flex align-items-center justify-content-between mt-auto pt-3 border-top border-white-10">
                                <span class="x-small text-white-50" style="font-size: 0.65rem;">MOQ: {{ $product->min_order_quantity }}</span>
                                <a href="{{ route('home.products.show', $product->id) }}" class="text-gold"><i class="ph ph-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- TRACKING SIDEBAR MOCKUP SECTION --}}
    <section class="py-5 mb-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-7" data-aos="fade-right">
                    <div class="curvy-glass p-5">
                        <h2 class="fw-bold mb-4">Track Your <span class="text-gold">Shipment</span></h2>
                        <div class="luxe-search-field mb-4">
                            <i class="ph ph-barcode text-gold me-3"></i>
                            <input type="text" class="bg-transparent border-0 text-white w-100" placeholder="Enter Bill of Lading / Tracking No.">
                            <button class="luxe-search-btn py-2 px-4 shadow-none">TRACK NOW</button>
                        </div>
                        <div class="tracking-widget-luxe">
                            <div class="d-flex justify-content-between mb-3 small fw-bold">
                                <span><i class="ph ph-map-pin text-gold"></i> BENGHAZI</span>
                                <span class="text-white-50">IN TRANSIT</span>
                                <span>JEDDAH <i class="ph ph-anchor text-gold"></i></span>
                            </div>
                            <div class="progress bg-dark-card mb-2" style="height: 6px; border-radius: 10px;">
                                <div class="progress-bar bg-gold" style="width: 67%;"></div>
                            </div>
                            <div class="text-end x-small text-gold fw-bold">67% COMPLETED</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5" data-aos="fade-left">
                     {{-- Animated Mini Map or Image --}}
                     <div class="curvy-glass p-1 glowing-gold-border overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1494412574643-ff11b0a5c1c3?auto=format&fit=crop&q=80&w=800" class="w-100 rounded-4 shadow-lg" style="filter: brightness(0.6);">
                     </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('scripts')
    {{-- Three.js Libraries --}}
    <script src="https://unpkg.com/three@0.159.0/build/three.min.js"></script>
    <script src="https://unpkg.com/three-globe@2.30.0/dist/three-globe.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const globeContainer = document.getElementById('globe-container');
            if (!globeContainer) return;

            const Globe = new ThreeGlobe()
                .globeImageUrl('//unpkg.com/three-globe/example/img/earth-night.jpg')
                .bumpImageUrl('//unpkg.com/three-globe/example/img/earth-topology.png')
                .atmosphereColor('#18335c')
                .atmosphereAltitude(0.2);

            // Setup custom arcs (Trade Routes)
            const arcsData = [
                { startLat: 31.23, startLng: 121.47, endLat: 32.11, endLng: 20.06, color: ['#d4af37', '#fff'] }, // Shanghai -> Benghazi
                { startLat: 31.23, startLng: 121.47, endLat: 21.48, endLng: 39.19, color: ['#d4af37', '#fff'] }, // Shanghai -> Jeddah
                { startLat: 31.23, startLng: 121.47, endLat: 24.71, endLng: 46.67, color: ['#d4af37', '#fff'] }, // Shanghai -> Riyadh
            ];

            Globe.arcsData(arcsData)
                .arcColor('color')
                .arcDashLength(0.4)
                .arcDashGap(2)
                .arcDashAnimateTime(1500)
                .arcStroke(0.5);

            // Add Markers
            const markersData = [
                { lat: 31.23, lng: 121.47, name: 'CHINA HUB', color: '#d4af37', size: 2.0 },
                { lat: 21.48, lng: 39.19, name: 'JEDDAH', color: '#fff', size: 1.0 },
                { lat: 32.11, lng: 20.06, name: 'BENGHAZI', color: '#fff', size: 1.0 },
                { lat: 24.71, lng: 46.67, name: 'RIYADH', color: '#fff', size: 1.5 }
            ];

            Globe.pointsData(markersData)
                .pointColor('color')
                .pointRadius('size')
                .pointsTransitionDuration(1000);

            // Setup Renderer
            const renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
            renderer.setSize(window.innerWidth, window.innerHeight);
            renderer.setPixelRatio(window.devicePixelRatio);
            globeContainer.appendChild(renderer.domElement);

            // Scene and Camera
            const scene = new THREE.Scene();
            scene.add(Globe);
            scene.add(new THREE.AmbientLight(0xbbbbbb, 1.5));
            scene.add(new THREE.DirectionalLight(0xffffff, 1.0));

            const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
            camera.position.z = 300;

            // Simple Auto-rotation
            function animate() {
                Globe.rotation.y += 0.001;
                renderer.render(scene, camera);
                requestAnimationFrame(animate);
            }

            window.addEventListener('resize', () => {
                camera.aspect = window.innerWidth / window.innerHeight;
                camera.updateProjectionMatrix();
                renderer.setSize(window.innerWidth, window.innerHeight);
            });

            animate();
        });
    </script>
@endsection