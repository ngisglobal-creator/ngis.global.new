@extends('layouts.luxe')

@section('styles')
    <style>
        .shipping-header {
            padding: 120px 0 60px;
            position: relative;
        }
        .service-glass-card {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(212, 175, 55, 0.1);
            backdrop-filter: blur(15px);
            border-radius: 30px;
            padding: 50px;
            height: 100%;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            overflow: hidden;
        }
        .service-glass-card:hover {
            transform: translateY(-10px);
            border-color: var(--gold-mid);
            background: rgba(212, 175, 55, 0.05);
        }
        .service-icon {
            width: 70px;
            height: 70px;
            background: rgba(212, 175, 55, 0.1);
            color: var(--gold-mid);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 30px;
            font-size: 2rem;
            border: 1px solid rgba(212, 175, 55, 0.2);
        }
        .step-badge-premium {
            width: 40px;
            height: 40px;
            background: var(--gold-mid);
            color: #000;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 900;
            margin-bottom: 25px;
            font-family: 'Michroma', sans-serif;
            box-shadow: 0 5px 15px rgba(212, 175, 55, 0.3);
        }
        .tracking-panel {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(20px);
            border-radius: 32px;
            padding: 60px;
        }
    </style>
@endsection

@section('content')
    <!-- Header -->
    <header class="shipping-header text-center">
        <div class="container">
            <span class="hero-badge" data-aos="fade-down">ELITE SUPPLY CHAIN SOLUTIONS</span>
            <h1 class="brand-name-premium mb-3" style="font-size: 3.5rem;" data-aos="fade-up">
                <span class="lang-en">Logistics <span class="text-gold">Network</span></span>
                <span class="lang-ar">شبكة <span class="text-gold">الخدمات اللوجستية</span></span>
            </h1>
            <p class="text-white opacity-75 mx-auto" style="max-width: 600px;" data-aos="fade-up">
                <span class="lang-en">Secure, end-to-end global distribution managed by our strategic logistics department.</span>
                <span class="lang-ar">توزيع عالمي آمن ومتكامل يتم إدارته من قبل قسم اللوجستيات الاستراتيجي لدينا.</span>
            </p>
        </div>
    </header>

    <div class="container pb-5">
        <!-- Services Section -->
        <div class="row g-4 mb-5">
            <div class="col-lg-4" data-aos="fade-up">
                <div class="service-glass-card">
                    <div class="service-icon"><i class="ph-bold ph-airplane-tilt"></i></div>
                    <h4 class="fw-bold text-white mb-3">
                        <span class="lang-en">Air Priority</span><span class="lang-ar">الخدمة الجوية</span>
                    </h4>
                    <p class="text-white opacity-50 small lh-lg">
                        <span class="lang-en">Next-gen rapid air freight for high-value components and time-sensitive materials.</span>
                        <span class="lang-ar">شحن جوي سريع من الجيل القادم للمكونات عالية القيمة والمواد الحساسة للوقت.</span>
                    </p>
                </div>
            </div>
            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                <div class="service-glass-card">
                    <div class="service-icon"><i class="ph-bold ph-anchor"></i></div>
                    <h4 class="fw-bold text-white mb-3">
                        <span class="lang-en">Ocean Freight</span><span class="lang-ar">الشحن البحري</span>
                    </h4>
                    <p class="text-white opacity-50 small lh-lg">
                        <span class="lang-en">Strategic maritime solutions for high-volume trade routes with full container tracking.</span>
                        <span class="lang-ar">حلول بحرية استراتيجية لمسارات التجارة ذات الأحجام الكبيرة مع تتبع كامل للحاويات.</span>
                    </p>
                </div>
            </div>
            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
                <div class="service-glass-card">
                    <div class="service-icon"><i class="ph-bold ph-truck"></i></div>
                    <h4 class="fw-bold text-white mb-3">
                        <span class="lang-en">Land Transport</span><span class="lang-ar">النقل البري</span>
                    </h4>
                    <p class="text-white opacity-50 small lh-lg">
                        <span class="lang-en">Precision regional delivery and last-mile connectivity powered by our secure fleet.</span>
                        <span class="lang-ar">توصيل إقليمي دقيق واتصال للنقاط النهائية مدعوم بأسطولنا الآمن.</span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Tracking Section -->
        <div class="tracking-panel mb-5 mt-5" data-aos="fade-up">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <span class="spec-label mb-2 d-block">REAL-TIME TELEMETRY</span>
                    <h2 class="fw-bold text-white mb-4">
                        <span class="lang-en">Cargo <span class="text-gold">Intelligence</span></span>
                        <span class="lang-ar">ذكاء <span class="text-gold">الشحن</span></span>
                    </h2>
                    <p class="text-white opacity-50 mb-4">
                        <span class="lang-en">Monitor every stage of your shipment's journey through our integrated global satellite tracking.</span>
                        <span class="lang-ar">راقب كل مرحلة من رحلة شحنتك من خلال تتبعنا العالمي المدمج عبر الأقمار الصناعية.</span>
                    </p>
                    <div class="d-flex gap-2" style="max-width: 450px;">
                        <input type="text" class="form-control-lux flex-grow-1" placeholder="Enter Tracking ID: NGIS-HUB-XXXX">
                        <button class="btn btn-gold px-4">
                            <i class="ph-bold ph-magnifying-glass me-2"></i>TRACK
                        </button>
                    </div>
                </div>
                <div class="col-lg-5 offset-lg-1 d-none d-lg-block">
                    <div class="premium-glass-card p-0 overflow-hidden" style="border-radius: 20px;">
                        <img src="https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?auto=format&fit=crop&q=80&w=800" class="img-fluid opacity-75" alt="Tracking">
                    </div>
                </div>
            </div>
        </div>

        <!-- Process Section -->
        <div class="pt-5" data-aos="fade-up">
            <div class="text-center mb-5">
                <h3 class="fw-bold text-white">
                    <span class="lang-en">Strategic <span class="text-gold">Sourcing Flow</span></span>
                    <span class="lang-ar">مسار <span class="text-gold">التوريد الاستراتيجي</span></span>
                </h3>
            </div>
            <div class="row g-5 mt-2">
                <div class="col-md-3">
                    <div class="step-badge-premium">01</div>
                    <h6 class="fw-bold text-white mb-3">Procurement Booking</h6>
                    <p class="text-white opacity-50 small">Define requirements and secure logistics slots via our trade portal.</p>
                </div>
                <div class="col-md-3">
                    <div class="step-badge-premium">02</div>
                    <h6 class="fw-bold text-white mb-3">Origin Audit</h6>
                    <p class="text-white opacity-50 small">On-site verification and quality control by NGIS regional inspectors.</p>
                </div>
                <div class="col-md-3">
                    <div class="step-badge-premium">03</div>
                    <h6 class="fw-bold text-white mb-3">Global Clearance</h6>
                    <p class="text-white opacity-50 small">Automated documentation and customs handling for rapid transit.</p>
                </div>
                <div class="col-md-3">
                    <div class="step-badge-premium">04</div>
                    <h6 class="fw-bold text-white mb-3">Final Terminal</h6>
                    <p class="text-white opacity-50 small">Secure delivery to your destination with full compliance data.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
