<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}" id="main-html">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>@yield('title', 'NGIS | Global Integrated Services')</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Premium Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Michroma&family=Montserrat:wght@400;600;800;900&family=Almarai:wght@300;400;700;800&display=swap" rel="stylesheet">
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- Phosphor Icons -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    
    <script>
        // Immediate language persistence check to prevent flicker
        (function() {
            const savedLang = localStorage.getItem('ngis_lang');
            if (savedLang && ['ar', 'en'].includes(savedLang)) {
                if (savedLang !== "{{ app()->getLocale() }}") {
                    document.documentElement.setAttribute('lang', savedLang);
                    document.documentElement.setAttribute('dir', savedLang === 'ar' ? 'rtl' : 'ltr');
                }
            }
        })();
    </script>
    
    <style>
        :root {
            --gold-light: #fbe69b;
            --gold-mid: #d4af37;
            --gold-dark: #aa771c;
            --bg-dark: #050d1f;
            --bg-light: #18335c;
            --ngis-gold: #d4af37;
            --ngis-black: #050d1f;
            --ngis-gray: rgba(255,255,255,0.6);
        }

        body {
            background: #050d1f !important;
            background: radial-gradient(circle at center, var(--bg-light) 0%, var(--bg-dark) 80%) !important;
            color: #ffffff !important;
            background-image: 
                radial-gradient(circle at center, var(--bg-light) 0%, var(--bg-dark) 80%),
                linear-gradient(rgba(255, 255, 255, 0.02) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.02) 1px, transparent 1px) !important;
            background-size: 100% 100%, 40px 40px, 40px 40px !important;
            background-blend-mode: overlay !important;
            background-attachment: fixed !important;
            font-family: 'Almarai', 'Montserrat', sans-serif !important;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
            min-height: 100vh;
        }

        /* Particles Background */
        #networkCanvas {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            pointer-events: none;
        }

        .main-content {
            position: relative;
            z-index: 10;
        }

        /* Typography */
        .brand-name-premium {
            font-family: 'Michroma', sans-serif;
            background: linear-gradient(to bottom, #fffadb 0%, #dfc067 40%, #a2751f 80%, #fffadb 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            text-transform: uppercase;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Almarai', 'Montserrat', sans-serif;
            font-weight: 800;
        }

        .text-gold { color: var(--gold-mid) !important; }

        /* Premium Glass Cards */
        .premium-glass-card {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(212, 175, 55, 0.1);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border-radius: 24px;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            overflow: hidden;
        }
        .premium-glass-card:hover {
            transform: translateY(-8px);
            border-color: var(--gold-mid);
            background: rgba(255, 255, 255, 0.05);
            box-shadow: 0 20px 40px rgba(0,0,0,0.4);
        }

        /* Buttons */
        .btn-gold {
            background: linear-gradient(135deg, var(--gold-mid), var(--gold-dark));
            color: #000 !important;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-radius: 50px;
            border: none;
            transition: all 0.3s ease;
        }
        .btn-gold:hover {
            transform: scale(1.05);
            box-shadow: 0 0 25px rgba(212, 175, 55, 0.4);
        }

        .btn-gold-outline {
            background: transparent;
            border: 2px solid var(--gold-mid);
            color: var(--gold-mid);
            border-radius: 50px;
            font-weight: 700;
        }
        .btn-gold-outline:hover {
            background: var(--gold-mid);
            color: #000;
        }

        /* Navbar Override */
        .navbar {
            background: rgba(5, 13, 31, 0.9) !important;
            backdrop-filter: blur(15px) !important;
            border-bottom: 1px solid rgba(212, 175, 55, 0.2) !important;
            padding: 15px 0;
        }
        .navbar-brand .logo-box {
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }
        .navbar-brand .logo-box img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
        .nav-link {
            color: #fff !important;
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            opacity: 0.7;
            transition: opacity 0.3s ease;
        }
        .nav-link:hover, .nav-link.active { opacity: 1; color: var(--gold-mid) !important; }

        /* Shared Component: Hero Badge */
        .hero-badge {
            display: inline-block;
            background: rgba(212, 175, 55, 0.1);
            color: var(--gold-mid);
            padding: 8px 18px;
            font-size: 0.7rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 2px;
            border-radius: 50px;
            border: 1px solid var(--gold-mid);
            margin-bottom: 25px;
        }

        /* Product Card Components */
        .product-image-wrapper {
            position: relative;
            overflow: hidden;
            height: 240px;
            background: #000;
        }
        .product-image-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.8s ease;
        }
        .premium-glass-card:hover .product-image-wrapper img { transform: scale(1.1); }
        
        .price-badge {
            background: var(--gold-mid);
            color: #000;
            font-weight: 900;
            padding: 6px 14px;
            border-radius: 0 0 0 16px;
            position: absolute;
            top: 0;
            right: 0;
            font-size: 0.85rem;
        }

        .avatar-circle {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: 1.5px solid var(--gold-mid);
            object-fit: cover;
        }

        .spec-label { color: rgba(255,255,255,0.4); font-size: 0.65rem; text-transform: uppercase; font-weight: 700; }
        .spec-value { color: #fff; font-weight: 700; font-size: 0.85rem; }

        /* Custom Form Controls */
        .form-control-lux {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            color: #fff;
            border-radius: 12px;
            padding: 12px 18px;
        }
        .form-control-lux:focus {
            background: rgba(255,255,255,0.08);
            border-color: var(--gold-mid);
            box-shadow: 0 0 15px rgba(212, 175, 55, 0.1);
            outline: none;
            color: #fff;
        }

        /* Language Controls */
        html[lang="ar"] .lang-en { display: none !important; }
        html[lang="en"] .lang-ar { display: none !important; }

        /* Global Bootstrap Overrides for Premium Dark Theme */
        .pagination { --bs-pagination-bg: rgba(255,255,255,0.03); --bs-pagination-border-color: rgba(212,175,55,0.1); --bs-pagination-color: #fff; --bs-pagination-hover-bg: rgba(212,175,55,0.1); --bs-pagination-hover-color: var(--gold-mid); --bs-pagination-active-bg: var(--gold-mid); --bs-pagination-active-border-color: var(--gold-mid); --bs-pagination-active-color: #000; --bs-pagination-disabled-bg: transparent; --bs-pagination-disabled-color: rgba(255,255,255,0.2); }
        .page-link { border-radius: 8px !important; margin: 0 3px; backdrop-filter: blur(10px); }

        .modal-content { background: #050d1f !important; background: radial-gradient(circle at center, #18335c 0%, #050d1f 80%) !important; border: 1px solid rgba(212,175,55,0.2) !important; border-radius: 24px !important; box-shadow: 0 25px 50px rgba(0,0,0,0.5) !important; }
        .modal-header { border-bottom: 1px solid rgba(212,175,55,0.1) !important; }
        .modal-footer { border-top: 1px solid rgba(212,175,55,0.1) !important; }
        .modal-backdrop.show { opacity: 0.8 !important; backdrop-filter: blur(10px) !important; }

        .dropdown-menu { background: rgba(5, 13, 31, 1) !important; border: 1px solid rgba(212, 175, 55, 0.2) !important; border-radius: 12px !important; padding: 10px !important; }
        .dropdown-item { color: rgba(255,255,255,0.8) !important; border-radius: 8px !important; transition: all 0.2s ease !important; }
        .dropdown-item:hover { background: var(--gold-mid) !important; color: #000 !important; }

        /* Mockup Specific Enhancements */
        .metallic-gold-gradient {
            background: linear-gradient(135deg, #fbe69b 0%, #d4af37 25%, #8a6d3b 50%, #d4af37 75%, #fbe69b 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 900;
        }
        
        .curvy-glass {
            background: linear-gradient(135deg, rgba(255,255,255,0.08) 0%, rgba(255,255,255,0) 100%);
            border: 1px solid rgba(212, 175, 55, 0.2);
            backdrop-filter: blur(20px);
            border-radius: 40px 10px 40px 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            transition: all 0.3s ease;
        }
        .curvy-glass:hover {
            border-color: var(--gold-mid);
            box-shadow: 0 0 20px rgba(212, 175, 55, 0.2);
        }

        .glowing-gold-border {
            border: 1.5px solid var(--gold-mid);
            box-shadow: 0 0 15px rgba(212, 175, 55, 0.3), inset 0 0 10px rgba(212, 175, 55, 0.2);
        }

        .luxe-search-field {
            background: rgba(0,0,0,0.5);
            border: 1px solid rgba(212, 175, 55, 0.3);
            border-radius: 30px;
            padding: 10px 20px;
            display: flex;
            align-items: center;
        }

        .luxe-search-btn {
            background: linear-gradient(to bottom, #fbe69b, #d4af37);
            border: none;
            border-radius: 20px;
            padding: 8px 25px;
            font-weight: 800;
            color: #000;
            text-transform: uppercase;
            box-shadow: 0 4px 15px rgba(212, 175, 55, 0.4);
        }

    </style>
    @yield('styles')
</head>
<body id="main-body">

    <canvas id="networkCanvas"></canvas>

    <div class="main-content">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg sticky-top">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center gap-3" href="{{ route('welcome') }}">
                    <div class="logo-box">
                        <img src="{{ asset('assets/images/logo-ngis.png') }}" alt="NGIS LOGO">
                    </div>
                    <div class="d-flex flex-column">
                        <span class="brand-name-premium" style="font-size: 1.4rem; letter-spacing: 3px; line-height: 1;">NGIS</span>
                        <span class="x-small text-gold tracking-widest fw-bold mt-1" style="font-size: 0.5rem;">GLOBAL INTEGRATED SERVICES</span>
                    </div>
                </a>
                
                <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <i class="ph ph-list text-white fs-2"></i>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav mx-auto">
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('welcome') ? 'active' : '' }}" href="{{ route('welcome') }}"><span class="lang-en">Home</span><span class="lang-ar">الرئيسية</span></a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('home.all-products') ? 'active' : '' }}" href="{{ route('home.all-products') }}"><span class="lang-en">Marketplace</span><span class="lang-ar">السوق</span></a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('home.ngis-products') ? 'active' : '' }}" href="{{ route('home.ngis-products') }}"><span class="lang-en">NGIS Hub</span><span class="lang-ar">منتجات NGIS</span></a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('home.factory-products') ? 'active' : '' }}" href="{{ route('home.factory-products') }}"><span class="lang-en">Factories</span><span class="lang-ar">المصانع</span></a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('home.supplier-products') ? 'active' : '' }}" href="{{ route('home.supplier-products') }}"><span class="lang-en">Suppliers</span><span class="lang-ar">الموردين</span></a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('home.shipping') ? 'active' : '' }}" href="{{ route('home.shipping') }}"><span class="lang-en">Shipping</span><span class="lang-ar">الشحن</span></a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('home.contact') ? 'active' : '' }}" href="{{ route('home.contact') }}"><span class="lang-en">Contact</span><span class="lang-ar">تواصل معنا</span></a></li>
                    </ul>
                    
                    <div class="d-flex align-items-center gap-3">
                        <button onclick="toggleLanguage()" class="btn btn-outline-light btn-sm rounded-pill px-3 border-opacity-25" style="font-size: 0.7rem;">
                            <span class="lang-text fw-bold">{{ app()->getLocale() == 'ar' ? 'EN' : 'AR' }}</span>
                        </button>
                        
                        @guest
                            <a href="{{ route('login') }}" class="nav-link text-white small p-0"><span class="lang-en">In</span><span class="lang-ar">دخول</span></a>
                            <a href="{{ route('register') }}" class="btn btn-gold btn-sm px-4">Join</a>
                        @else
                            <div class="dropdown">
                                <a class="nav-link dropdown-toggle p-0" href="#" data-bs-toggle="dropdown">
                                    <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) }}" class="avatar-circle">
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end p-2 border-0 shadow-lg" style="background: var(--bg-dark); border: 1px solid rgba(212,175,55,0.2) !important;">
                                    <li><a class="dropdown-item text-white small rounded" href="{{ route('dashboard') }}"><i class="ph ph-squares-four me-2"></i> Dashboard</a></li>
                                    <li><hr class="dropdown-divider opacity-10"></li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="dropdown-item text-danger small rounded"><i class="ph ph-sign-out me-2"></i> Logout</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        @endguest
                    </div>
                </div>
            </div>
        </nav>

        @yield('content')

        <!-- Premium Global Footer -->
        <footer class="py-5 mt-5 border-top border-white-10" style="background: rgba(5, 13, 31, 0.8);">
            <div class="container">
                <div class="row g-5">
                    <div class="col-lg-4">
                        <div class="d-flex align-items-center gap-3 mb-4">
                            <div class="logo-box" style="width: 40px; height: 40px;">
                                <img src="{{ asset('assets/images/logo-ngis.png') }}" alt="NGIS LOGO" style="width: 100%; height: 100%; object-fit: contain;">
                            </div>
                            <div class="brand-name-premium" style="font-size: 1.5rem;">NGIS GLOBAL</div>
                        </div>
                        <p class="text-muted small lh-lg">
                            Integrated corporate services providing end-to-end supply chain security and logistics for international trade. Global sourcing verified by NGIS Strategic Department.
                        </p>
                        <div class="d-flex gap-3 mt-4">
                            <a href="#" class="text-gold"><i class="ph-fill ph-linkedin-logo fs-4"></i></a>
                            <a href="#" class="text-white"><i class="ph-fill ph-twitter-logo fs-4"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-2 offset-lg-2">
                        <h6 class="fw-bold text-white mb-4">Platform</h6>
                        <ul class="list-unstyled d-flex flex-column gap-2 small">
                            <li><a href="{{ route('home.all-products') }}" class="text-muted text-decoration-none hover-white">Marketplace</a></li>
                            <li><a href="{{ route('home.factory-products') }}" class="text-muted text-decoration-none hover-white">Factories</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-2">
                        <h6 class="fw-bold text-white mb-4">Support</h6>
                        <ul class="list-unstyled d-flex flex-column gap-2 small">
                            <li><a href="{{ route('home.contact') }}" class="text-muted text-decoration-none hover-white">Contact Us</a></li>
                            <li><a href="#" class="text-muted text-decoration-none hover-white">Privacy Policy</a></li>
                        </ul>
                    </div>
                </div>
                <div class="pt-5 mt-5 border-top border-white-10 d-flex justify-content-between align-items-center">
                    <span class="x-small text-muted letter-spacing-1">© 2026 NGIS GLOBAL. ALL RIGHTS RESERVED.</span>
                </div>
            </div>
        </footer>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    <script>
        document.addEventListener("DOMContentLoaded", function() { AOS.init({ once: true, duration: 800 }); });

        function toggleLanguage() {
            const html = document.getElementById('main-html');
            const currentLang = html.getAttribute('lang');
            const newLang = currentLang === 'ar' ? 'en' : 'ar';
            html.setAttribute('lang', newLang);
            html.setAttribute('dir', newLang === 'ar' ? 'rtl' : 'ltr');
            document.querySelectorAll('.lang-text').forEach(el => el.innerText = newLang === 'ar' ? 'EN' : 'AR');
            localStorage.setItem('ngis_lang', newLang);
        }

        // Particle System
        (function() {
            const canvas = document.getElementById('networkCanvas');
            if (!canvas) return;
            const ctx = canvas.getContext('2d');
            let particlesArray = [];

            class Particle {
                constructor() {
                    this.x = Math.random() * canvas.width;
                    this.y = Math.random() * canvas.height;
                    const speed = (Math.random() * 0.4) + 0.1;
                    const angle = Math.random() * Math.PI * 2;
                    this.velocityX = Math.cos(angle) * speed;
                    this.velocityY = Math.sin(angle) * speed;
                    this.radius = Math.random() * 2 + 0.5;
                    this.rgbBase = Math.random() > 0.5 ? '212,175,55' : '120,160,255';
                    this.color = `rgba(${this.rgbBase}, ${Math.random() * 0.5 + 0.2})`;
                }
                draw() {
                    ctx.beginPath(); ctx.arc(this.x, this.y, this.radius, 0, Math.PI * 2);
                    ctx.fillStyle = this.color; ctx.fill();
                }
                update() {
                    if (this.x < 0 || this.x > canvas.width) this.velocityX *= -1;
                    if (this.y < 0 || this.y > canvas.height) this.velocityY *= -1;
                    this.x += this.velocityX; this.y += this.velocityY;
                    this.draw();
                }
            }

            function initCanvas() {
                canvas.width = window.innerWidth; canvas.height = window.innerHeight;
                particlesArray = [];
                const count = Math.min((canvas.width * canvas.height) / 12000, 100);
                for (let i = 0; i < count; i++) { particlesArray.push(new Particle()); }
            }

            function drawLines() {
                for (let i = 0; i < particlesArray.length; i++) {
                    for (let j = i; j < particlesArray.length; j++) {
                        const dx = particlesArray[i].x - particlesArray[j].x;
                        const dy = particlesArray[i].y - particlesArray[j].y;
                        const distance = Math.sqrt(dx * dx + dy * dy);
                        if (distance < 150) {
                            ctx.beginPath(); 
                            ctx.strokeStyle = `rgba(${particlesArray[i].rgbBase}, ${(1 - distance/150) * 0.15})`;
                            ctx.lineWidth = 0.5; ctx.moveTo(particlesArray[i].x, particlesArray[i].y);
                            ctx.lineTo(particlesArray[j].x, particlesArray[j].y); ctx.stroke();
                        }
                    }
                }
            }

            function animate() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                particlesArray.forEach(p => p.update());
                drawLines(); requestAnimationFrame(animate);
            }

            window.addEventListener('resize', initCanvas);
            initCanvas(); animate();
        })();
    </script>
    @yield('scripts')
</body>
</html>
