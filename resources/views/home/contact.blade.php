@extends('layouts.luxe')

@section('styles')
    <style>
        .contact-header {
            padding: 120px 0 60px;
            position: relative;
        }
        .contact-info-card {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(212, 175, 55, 0.1);
            backdrop-filter: blur(15px);
            border-radius: 24px;
            padding: 40px;
            height: 100%;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            text-align: center;
        }
        .contact-info-card:hover {
            transform: translateY(-10px);
            border-color: var(--gold-mid);
            background: rgba(212, 175, 55, 0.05);
        }
        .contact-icon {
            width: 70px;
            height: 70px;
            background: rgba(212, 175, 55, 0.1);
            color: var(--gold-mid);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
            font-size: 1.8rem;
            border: 1px solid rgba(212, 175, 55, 0.2);
        }
        .form-glass {
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
    <header class="contact-header text-center">
        <div class="container">
            <span class="hero-badge" data-aos="fade-down">GLOBAL REACH & LOCAL SUPPORT</span>
            <h1 class="brand-name-premium mb-3" style="font-size: 3.5rem;" data-aos="fade-up">
                <span class="lang-en">Connect <span class="text-gold">Globally</span></span>
                <span class="lang-ar">تواصل <span class="text-gold">عالمياً</span></span>
            </h1>
            <p class="text-white opacity-75 mx-auto" style="max-width: 600px;" data-aos="fade-up">
                <span class="lang-en">Our elite global support teams are strategically positioned to handle your international trade requirements.</span>
                <span class="lang-ar">فرق الدعم العالمية لدينا متواجدة استراتيجياً للتعامل مع متطلبات تجارتك الدولية.</span>
            </p>
        </div>
    </header>

    <div class="container pb-5">
        <div class="row g-4 mb-5">
            <!-- Contact Info -->
            <div class="col-lg-4" data-aos="fade-up">
                <div class="contact-info-card">
                    <div class="contact-icon"><i class="ph-bold ph-envelope-simple"></i></div>
                    <h5 class="fw-bold text-white mb-3">
                        <span class="lang-en">Secure Email</span><span class="lang-ar">البريد الآمن</span>
                    </h5>
                    <p class="text-gold small mb-1">support@ngis-global.com</p>
                    <p class="text-white opacity-50 small">Encrypted Communication Only</p>
                </div>
            </div>
            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                <div class="contact-info-card">
                    <div class="contact-icon"><i class="ph-bold ph-headset"></i></div>
                    <h5 class="fw-bold text-white mb-3">
                        <span class="lang-en">Trade Hotline</span><span class="lang-ar">خط التجارة</span>
                    </h5>
                    <p class="text-gold small mb-1">+966 123 456 789</p>
                    <p class="text-white opacity-50 small">24/7 Global Response</p>
                </div>
            </div>
            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
                <div class="contact-info-card">
                    <div class="contact-icon"><i class="ph-bold ph-globe-hemisphere-east"></i></div>
                    <h5 class="fw-bold text-white mb-3">
                        <span class="lang-en">HQ Terminals</span><span class="lang-ar">المكاتب الرئيسية</span>
                    </h5>
                    <p class="text-gold small mb-1">Riyadh • Beijing • Guangzhou</p>
                    <p class="text-white opacity-50 small">International Logistics Hubs</p>
                </div>
            </div>
        </div>

        <!-- Contact Form -->
        <div class="row justify-content-center pt-5 mt-5">
            <div class="col-lg-9" data-aos="fade-up">
                <div class="form-glass">
                    <div class="text-center mb-5">
                        <span class="spec-label mb-2">SECURE MESSAGING PANEL</span>
                        <h3 class="fw-bold text-white">
                            <span class="lang-en">Direct <span class="text-gold">Sourcing Inquiry</span></span>
                            <span class="lang-ar">طلب <span class="text-gold">توريد مباشر</span></span>
                        </h3>
                    </div>
                    
                    <form action="#" method="POST">
                        @csrf
                        <div class="row g-4">
                            <div class="col-md-6">
                                <span class="spec-label mb-2 d-block">Full Name / Identity</span>
                                <input type="text" class="form-control-lux w-100" placeholder="Identity Verification Name">
                            </div>
                            <div class="col-md-6">
                                <span class="spec-label mb-2 d-block">Business Email</span>
                                <input type="email" class="form-control-lux w-100" placeholder="corporate@domain.com">
                            </div>
                            <div class="col-12">
                                <span class="spec-label mb-2 d-block">Service Sector</span>
                                <select class="form-control-lux form-select border-opacity-10 text-white">
                                    <option value="" class="bg-dark">Select Primary Inquiry Topic</option>
                                    <option value="inquiry" class="bg-dark">International Sourcing</option>
                                    <option value="logistics" class="bg-dark">Logistics & Shipping</option>
                                    <option value="verification" class="bg-dark">Factory Verification</option>
                                    <option value="partnership" class="bg-dark">Strategic Partnership</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <span class="spec-label mb-2 d-block">Detailed Requirement</span>
                                <textarea class="form-control-lux w-100" rows="6" placeholder="Please describe your sourcing or logistics requirements in detail..."></textarea>
                            </div>
                            <div class="col-12 text-center mt-5">
                                <button type="submit" class="btn btn-gold px-5 py-3 fs-6">
                                    <span class="lang-en">TRANSMIT SECURE MESSAGE</span><span class="lang-ar">إرسال الرسالة الآمنة</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
