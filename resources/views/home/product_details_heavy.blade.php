@extends('layouts.luxe')

@section('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        /* Shared Styles from product_details.blade.php */
        .gallery-container { display: flex; gap: 20px; }
        .thumb-strip { display: flex; flex-direction: column; gap: 12px; width: 80px; flex-shrink: 0; }
        .thumb-strip .thumb-item { width: 80px; height: 80px; border-radius: 16px; border: 1px solid rgba(255, 255, 255, 0.05); background: rgba(255, 255, 255, 0.03); overflow: hidden; cursor: pointer; transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1); padding: 8px; backdrop-filter: blur(5px); }
        .thumb-strip .thumb-item:hover, .thumb-strip .thumb-item.active { border-color: #d9534f; transform: translateX(5px); background: rgba(217, 83, 79, 0.1); }
        
        .product-gallery-main { flex-grow: 1; background: rgba(255, 255, 255, 0.02); border: 1px solid rgba(255, 255, 255, 0.05); border-radius: 32px; overflow: hidden; display: flex; align-items: center; justify-content: center; aspect-ratio: 16/9; box-shadow: 0 10px 40px rgba(0,0,0,0.2); position: relative; backdrop-filter: blur(20px); }
        .product-gallery-main img { max-height: 85%; width: auto; object-fit: contain; filter: drop-shadow(0 5px 15px rgba(0,0,0,0.5)); }
        
        .info-glass-panel { background: rgba(255, 255, 255, 0.03); border: 1px solid rgba(217, 83, 79, 0.2); backdrop-filter: blur(15px); border-radius: 32px; padding: 40px; }
        .heavy-spec-item { padding: 15px; background: rgba(255, 255, 255, 0.02); border-left: 3px solid #d9534f; border-radius: 8px; margin-bottom: 10px; }
        .heavy-spec-item .label { display: block; font-size: 10px; color: #888; text-transform: uppercase; margin-bottom: 2px; }
        .heavy-spec-item .value { color: #fff; font-weight: bold; font-size: 14px; }
        
        .logistics-premium-card { border-radius: 24px; border: 1px solid rgba(255, 255, 255, 0.05); background: rgba(255, 255, 255, 0.02); height: 100%; transition: all 0.3s ease; }
        .logistics-premium-card:hover { border-color: #d9534f; background: rgba(217, 83, 79, 0.05); transform: translateY(-5px); }

        @media (max-width: 768px) {
            .gallery-container { flex-direction: column-reverse; }
            .thumb-strip { flex-direction: row; width: 100%; overflow-x: auto; }
        }
    </style>
@endsection

@section('content')
    <main class="py-5">
        <div class="container px-lg-5">
            <!-- Breadcrumbs -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb" style="font-size: 0.7rem; font-weight: 800; text-transform: uppercase; letter-spacing: 2px;">
                    <li class="breadcrumb-item"><a href="{{ route('welcome') }}" class="text-white opacity-50">Home</a></li>
                    <li class="breadcrumb-item active text-danger">{{ $product->name }}</li>
                </ol>
            </nav>

            <div class="row g-5">
                <!-- Gallery Column -->
                <div class="col-lg-7">
                    <div class="gallery-container">
                        <div class="thumb-strip custom-scrollbar">
                            @foreach($product->images as $image)
                            <div class="thumb-item {{ $loop->first ? 'active' : '' }}" onclick="document.getElementById('mainImage').src='{{ asset('storage/' . $image->image_path) }}'; document.querySelectorAll('.thumb-item').forEach(i=>i.classList.remove('active')); this.classList.add('active');">
                                <img src="{{ asset('storage/' . $image->image_path) }}" style="width:100%; height:100%; object-fit: cover;">
                            </div>
                            @endforeach
                        </div>
                        <div class="product-gallery-main">
                            @php $firstImg = $product->images->first(); @endphp
                            <img src="{{ $firstImg ? asset('storage/' . $firstImg->image_path) : 'https://via.placeholder.com/800x600' }}" id="mainImage">
                        </div>
                    </div>

                    <!-- Heavy Specs Grid -->
                    @php $vInfo = $product->logistics_details['vehicle_info'] ?? []; @endphp
                    <div class="row g-3 mt-4">
                        <div class="col-md-4">
                            <div class="heavy-spec-item">
                                <span class="label">Manufacturer</span>
                                <span class="value">{{ $vInfo['manufacturer'] ?? '-' }}</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="heavy-spec-item">
                                <span class="label">Model</span>
                                <span class="value">{{ $vInfo['model'] ?? '-' }}</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="heavy-spec-item">
                                <span class="label">Year</span>
                                <span class="value english-nums">{{ $vInfo['manufacturing_year'] ?? '-' }}</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="heavy-spec-item">
                                <span class="label">Net Weight</span>
                                <span class="value english-nums">{{ number_format($product->piece_weight) }} KG</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="heavy-spec-item">
                                <span class="label">Engine Type</span>
                                <span class="value">{{ $vInfo['motor_type'] ?? '-' }}</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="heavy-spec-item">
                                <span class="label">Condition</span>
                                <span class="value">{{ $vInfo['condition'] ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Info Column -->
                <div class="col-lg-5">
                    <div class="info-glass-panel sticky-top" style="top: 100px;">
                        <span class="hero-badge mb-3" style="background: rgba(217,83,79,0.1); color: #d9534f; border: 1px solid rgba(217,83,79,0.2);">HEAVY EQUIPMENT INDUSTRIAL</span>
                        <h1 class="h2 fw-bold text-white mb-4">{{ $product->name }}</h1>
                        
                        <div class="d-flex align-items-baseline gap-3 mb-4 p-4 bg-white bg-opacity-5 rounded-4 border border-white border-opacity-10">
                            <span class="h1 fw-black text-white no-rtl mb-0 english-nums">{{ number_format($product->price, 2) }}</span>
                            <span class="h4 text-danger fw-bold mb-0">{{ $product->currency_code }}</span>
                        </div>

                        <div class="text-white opacity-50 lh-lg mb-5 small">
                            {!! $product->description !!}
                        </div>

                        <div class="pt-4 border-top border-white border-opacity-10">
                            @auth
                                <button class="btn btn-danger btn-lg w-100 py-3 rounded-pill fw-bold" data-bs-toggle="modal" data-bs-target="#orderModal" style="background: #c0392b; border: none;">
                                    <i class="ph-bold ph-truck me-2"></i> INITIATE PROCUREMENT
                                </button>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-outline-danger btn-lg w-100 py-3 rounded-pill fw-bold">
                                    LOGIN TO ORDER
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>

            <!-- 8 Containers Logistics Section -->
            <section class="mt-5 pt-5">
                <div class="text-center mb-5">
                    <h2 class="text-white fw-bold">Industrial <span class="text-danger">Logistics Grid</span></h2>
                    <p class="text-white opacity-50">Precision capacity mapping for non-standardized cargo across 8 protocols</p>
                    <div class="px-3 py-1 rounded-pill d-inline-block" style="background: rgba(220,53,69,0.1); border: 1px solid rgba(220,53,69,0.2); font-size: 0.6rem; color: #ff6b6b; font-weight: 800; letter-spacing: 2px;">CERTIFIED SOURCING ACTIVE</div>
                </div>

                <div class="row g-3">
                    @php
                        $L = $product->carton_length; 
                        $W = $product->carton_width;
                        $H = $product->carton_height;
                        
                        $BUMPER_GAP = 0.25;
                        $WALL_GAP = 0.10;
                        $ROOF_GAP = 0.15;

                        $allContainers = [
                            ['name' => '40ft Platform', 'cbm' => 70, 'color' => '#28a745', 'icon' => 'fa-th', 'intL' => 12.19, 'intW' => 2.44, 'intH' => 10, 'hasRoof' => false, 'hasWalls' => false],
                            ['name' => '20ft Platform', 'cbm' => 28, 'color' => '#28a745', 'icon' => 'fa-th', 'intL' => 6.06,  'intW' => 2.44, 'intH' => 10, 'hasRoof' => false, 'hasWalls' => false],
                            ['name' => '40ft Flat Rack', 'cbm' => 60, 'color' => '#fd7e14', 'icon' => 'fa-minus-square-o', 'intL' => 12.13, 'intW' => 2.40, 'intH' => 10, 'hasRoof' => false, 'hasWalls' => false],
                            ['name' => '20ft Flat Rack', 'cbm' => 28, 'color' => '#fd7e14', 'icon' => 'fa-minus-square-o', 'intL' => 5.94,  'intW' => 2.35, 'intH' => 10, 'hasRoof' => false, 'hasWalls' => false],
                            ['name' => '40ft Open Top', 'cbm' => 66, 'color' => '#007bff', 'icon' => 'fa-cube', 'intL' => 12.02, 'intW' => 2.35, 'intH' => 10, 'hasRoof' => false],
                            ['name' => '20ft Open Top', 'cbm' => 32, 'color' => '#007bff', 'icon' => 'fa-cube', 'intL' => 5.89,  'intW' => 2.35, 'intH' => 10, 'hasRoof' => false],
                            ['name' => 'RoRo (Direct)', 'cbm' => 0,  'color' => '#d81b60', 'icon' => 'fa-truck', 'roro' => true],
                            ['name' => '40ft Reefer',   'cbm' => 59, 'color' => '#17a2b8', 'icon' => 'fa-snowflake-o', 'intL' => 11.58, 'intW' => 2.29, 'intH' => 2.40]
                        ];

                        $productCbm = ($product->carton_length * $product->carton_width * $product->carton_height);
                        $productCbm = $productCbm > 0 ? $productCbm : 1;
                    @endphp

                    @foreach($allContainers as $c)
                        @php
                            $warning = null;
                            if (isset($c['roro'])) {
                                $req = 1;
                                $displayCap = 'DIRECT';
                                $capFlat = 1;
                            } else {
                                $hasRoof = $c['hasRoof'] ?? true;
                                $hasWalls = $c['hasWalls'] ?? true;
                                
                                $fitsW = !$hasWalls || (($W + ($WALL_GAP * 2)) <= $c['intW']);
                                $fitsH = !$hasRoof || (($H + $ROOF_GAP) <= $c['intH']);
                                
                                if ($fitsW && $fitsH && $L > 0) {
                                    $capFlat = floor(($c['intL'] + $BUMPER_GAP) / ($L + $BUMPER_GAP));
                                    $displayCap = $capFlat;
                                } else {
                                    $capFlat = 0; $displayCap = '---';
                                }
                                
                                $req = $c['cbm'] > 0 ? round($productCbm / $c['cbm'], 2) : 0;
                                if (!$fitsW || !$fitsH) $warning = "SIZE EXCEEDED";
                            }
                        @endphp
                        <div class="col-lg-3 col-md-6">
                            <div style="background: {{ $c['color'] }}; border-radius: 12px; overflow: hidden; color: white; height: 100%; border: 1px solid rgba(255,255,255,0.1); display: flex; flex-direction: column;">
                                <div class="p-3" style="background: rgba(0,0,0,0.15);">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <h6 class="m-0 fw-black text-uppercase small">{{ $c['name'] }}</h6>
                                        <i class="fa {{ $c['icon'] }} opacity-50"></i>
                                    </div>
                                    @if(!isset($c['roro']))
                                        <div class="english-nums opacity-50" style="font-size: 0.55rem;">L:{{ $c['intL'] }} W:{{ $c['intW'] }} H:{{ $c['intH'] }}</div>
                                    @endif
                                </div>
                                
                                <div class="p-3 d-flex flex-column flex-grow-1 gap-2">
                                    <div class="d-inline-flex align-items-center gap-1 px-2 py-1 rounded bg-white bg-opacity-20 mb-2" style="width: fit-content;">
                                        <i class="fa fa-shield small"></i>
                                        <span class="fw-bold" style="font-size: 0.55rem;">INDUSTRIAL SAFETY</span>
                                    </div>
                                    
                                    <div class="d-flex justify-content-between border-bottom border-white border-opacity-20 pb-1">
                                        <span class="small opacity-75">Required Containers:</span>
                                        <span class="fw-black english-nums">{{ $req }}</span>
                                    </div>
                                    
                                    <div class="d-flex flex-column gap-1 bg-black bg-opacity-10 p-2 rounded">
                                        <div class="d-flex justify-content-between x-small">
                                            <span class="opacity-50">Max Unit Capacity:</span>
                                            <span class="fw-bold english-nums">{{ $displayCap }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between x-small">
                                            <span class="opacity-50">Total Pieces:</span>
                                            <span class="fw-bold english-nums">1</span>
                                        </div>
                                        <div class="d-flex justify-content-between x-small border-top border-white border-opacity-10 mt-1 pt-1 fw-black">
                                            <span>UNIT PRICE:</span>
                                            <span class="english-nums">{{ number_format($product->price) }} {{ $product->currency_code }}</span>
                                        </div>
                                    </div>
                                    
                                    @if($warning)
                                        <div class="mt-auto pt-2 text-center fw-black small text-uppercase bg-black bg-opacity-20 rounded" style="font-size: 0.5rem; letter-spacing: 1px;">
                                            {{ $warning }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        </div>
    </main>
@endsection
