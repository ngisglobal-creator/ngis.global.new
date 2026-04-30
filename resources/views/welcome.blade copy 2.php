<!DOCTYPE html>
<html lang="ar" dir="rtl" id="main-html">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>NGIS Global Integrated Services</title>
    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>

    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- Premium Icons (Phosphor) -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        primary: "#D4AF37",
                        "primary-dark": "#AA7A00",
                        dark: "#050505",
                        "dark-card": "#0F0F0F",
                        "dark-border": "#1A1A1A",
                    },
                    fontFamily: {
                        display: ["Arial", "sans-serif"],
                    },
                    boxShadow: {
                        'premium': '0 20px 40px -10px rgba(0,0,0,0.8)',
                        'glow': '0 0 20px rgba(212, 175, 55, 0.15)',
                    }
                },
            },
        };

        function toggleLanguage() {
            const html = document.getElementById('main-html');
            const currentLang = html.getAttribute('lang');
            if (currentLang === 'ar') {
                html.setAttribute('lang', 'en');
                html.setAttribute('dir', 'ltr');
                document.getElementById('lang-text').innerText = 'EN';
            } else {
                html.setAttribute('lang', 'ar');
                html.setAttribute('dir', 'rtl');
                document.getElementById('lang-text').innerText = 'AR';
            }
        }
    </script>
    <style>
        body {
            background-color: #050505;
            color: #E5E5E5;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .gold-gradient-text {
            color: #ffffff;
            font-weight: 700;
        }

        .gold-bg-gradient {
            background: rgba(255, 255, 255, 1);
            color: #050505 !important;
        }

        /* Refined Borders */
        .premium-border {
            position: relative;
        }
        .premium-border::before {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: inherit;
            padding: 1px;
            background: linear-gradient(to bottom right, rgba(212,175,55,0.4), rgba(255,255,255,0.02));
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            pointer-events: none;
        }

        /* Header blur */
        .glass-header {
            background: rgba(5, 5, 5, 0.85);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        }

        /* Glass Panel for generic cards */
        .glass-panel {
            background: rgba(15, 15, 15, 0.6);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        /* Language display rules */
        html[lang="ar"] .lang-en { display: none; }
        html[lang="en"] .lang-ar { display: none; }
        
        /* Flip icons for RTL */
        html[lang="ar"] i.ph:not(.no-rtl),
        html[lang="ar"] i.ph-fill:not(.no-rtl) {
            transform: scaleX(-1);
        }

        /* Custom minimal scrollbar */
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: #050505; }
        ::-webkit-scrollbar-thumb { background: #222; border-radius: 0; }
        ::-webkit-scrollbar-thumb:hover { background: #D4AF37; }

        .avatar-circle {
            border-radius: 50% !important;
        }
        
        /* Input styling specifically for search */
        .lux-input {
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.1);
            color: #fff;
            transition: all 0.3s ease;
        }
        .lux-input:focus {
            outline: none;
            background: rgba(255,255,255,0.05);
            border-color: rgba(212,175,55,0.5);
            box-shadow: 0 0 0 1px rgba(212,175,55,0.2);
        }
    </style>
</head>
<body class="font-display">

    <!-- Header -->
    <header class="fixed top-0 w-full z-50 glass-header transition-all duration-300">
        <!-- Top bar (Ticker) -->
        <div class="bg-dark border-b border-dark-border py-2 px-6 overflow-hidden">
            <div class="container mx-auto flex justify-between items-center text-[10px] uppercase tracking-widest text-gray-500 font-semibold">
                <div class="flex items-center gap-4">
                    <span class="text-white"><i class="ph-fill ph-airplane-takeoff mr-1"></i> <span class="lang-en">Freight Rates:</span><span class="lang-ar">أسعار الشحن:</span></span>
                    <div class="flex items-center gap-2 text-gray-400">
                        <span class="lang-en">China <i class="ph-bold ph-caret-right text-white mx-1"></i> Benghazi: <span class="text-white">$1200/TEU</span></span>
                        <span class="lang-ar">الصين <i class="ph-bold ph-caret-left text-white mx-1"></i> بنغازي: <span class="text-white">$1200/TEU</span></span>
                        <span class="text-green-500 ml-2 no-rtl">+</span>
                    </div>
                </div>
                <div class="hidden md:flex items-center gap-6 text-gray-400">
                    <div class="flex items-center gap-2">
                        <i class="ph-fill ph-check-circle text-green-500"></i>
                        <span class="lang-en">Container Arrived at Benghazi Port</span>
                        <span class="lang-ar">وصلت الحاوية إلى ميناء بنغازي</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Nav -->
        <div class="container mx-auto px-6 lg:px-12 py-3 flex items-center justify-between">
            <div class="flex items-center justify-between w-full lg:w-auto gap-8 rtl:space-x-reverse">
                <!-- Logo -->
                <a href="{{ route('welcome') }}" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 flex items-center justify-center border border-white/20 rounded-none group-hover:border-white transition-colors bg-gradient-to-br from-dark-card to-dark">
                        <i class="ph-fill ph-hexagon text-white text-xl"></i>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-white font-bold text-lg leading-tight tracking-wider">NGIS</span>
                    </div>
                </a>
                
                <!-- Main Links -->
                <nav class="hidden lg:flex items-center gap-8 rtl:space-x-reverse">
                    <a href="{{ route('welcome') }}" class="text-sm font-medium text-white flex items-center gap-2">
                        <i class="ph-fill ph-house text-lg text-white"></i>
                        <span class="lang-en relative after:absolute after:-bottom-1 after:left-0 after:w-full after:h-[2px] after:bg-white">Home</span>
                        <span class="lang-ar relative after:absolute after:-bottom-1 after:left-0 after:w-full after:h-[2px] after:bg-white">الرئيسية</span>
                    </a>
                    <a href="{{ route('home.all-products') }}" class="text-sm font-medium text-gray-400 hover:text-white transition-colors flex items-center gap-2">
                        <i class="ph ph-package text-lg"></i>
                        <span class="lang-en">Products</span><span class="lang-ar">المنتجات</span>
                    </a>
                    <a href="{{ route('home.ngis-products') }}" class="text-sm font-medium text-gray-400 hover:text-white transition-colors flex items-center gap-2">
                        <i class="ph ph-package text-lg"></i>
                        <span class="lang-en">NGIS Products</span><span class="lang-ar">منتجات NGIS</span>
                    </a>
                </nav>
            </div>
            
            <!-- Global Search Bar -->
            <div class="hidden lg:flex flex-1 max-w-xl mx-8 relative">
                <i class="ph ph-magnifying-glass absolute top-1/2 -translate-y-1/2 text-gray-500 left-4 rtl:left-auto rtl:right-4"></i>
                <input type="text" 
                       class="lux-input w-full rounded-none py-2.5 pl-12 pr-24 rtl:pr-12 rtl:pl-24 text-sm lang-en" 
                       placeholder="Search products, factories...">
                <input type="text" 
                       class="lux-input w-full rounded-none py-2.5 pl-12 pr-24 rtl:pr-12 rtl:pl-24 text-sm lang-ar" 
                       placeholder="بحث عن منتجات، مصانع..." dir="rtl">
                <button class="absolute top-1 bottom-1 right-1 rtl:right-auto rtl:left-1 bg-white text-dark font-bold px-6 rounded-none text-xs shadow-lg hover:shadow-[0_0_20px_rgba(255,255,255,0.3)] transition-all">
                    <span class="lang-en">Search</span><span class="lang-ar">بحث</span>
                </button>
            </div>

            <div class="flex items-center gap-6 rtl:space-x-reverse">
                <button onclick="toggleLanguage()" class="flex items-center gap-2 text-sm font-medium text-gray-400 hover:text-white transition-colors">
                    <i class="ph ph-globe text-lg"></i>
                    <span id="lang-text">AR</span>
                </button>
                <div class="h-4 w-px bg-white/10 hidden sm:block"></div>
                <button class="flex items-center gap-2 text-sm font-medium text-white hover:text-gray-300 transition-colors">
                    <i class="ph-fill ph-user text-lg text-white"></i>
                    <span class="lang-en uppercase tracking-wider text-xs hidden sm:block">Account</span>
                    <span class="lang-ar text-xs hidden sm:block">حسابي</span>
                </button>
            </div>
        </div>

        <!-- Sub Nav -->
        <div class="border-t border-white/5 bg-dark-card/50">
            <div class="container mx-auto px-6">
                <ul class="flex items-center gap-8 overflow-x-auto py-3 text-xs font-semibold uppercase tracking-widest text-gray-400 scrollbar-hide">
                    <li class="flex items-center gap-1 cursor-pointer hover:text-white transition-colors whitespace-nowrap">
                        <span class="lang-en">Global Ecosystem</span><span class="lang-ar">النظام البيئي العالمي</span>
                        <i class="ph-bold ph-caret-down"></i>
                    </li>
                    <li class="w-1 h-1 rounded-none bg-white/10 shrink-0"></li>
                    <li class="cursor-pointer hover:text-white transition-colors whitespace-nowrap">
                        <span class="lang-en">Automotive</span><span class="lang-ar">السيارات</span>
                    </li>
                    <li class="w-1 h-1 rounded-none bg-white/10 shrink-0"></li>
                    <li class="cursor-pointer hover:text-white transition-colors whitespace-nowrap">
                        <span class="lang-en">Partner Factories</span><span class="lang-ar">المصانع الشريكة</span>
                    </li>
                    <li class="w-1 h-1 rounded-none bg-white/10 shrink-0"></li>
                    <li class="cursor-pointer hover:text-white transition-colors whitespace-nowrap">
                        <span class="lang-en">Logistics</span><span class="lang-ar">الخدمات اللوجستية</span>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <main class="flex-1 flex flex-col items-center w-full pt-[136px] pb-20">
        
        <!-- Full-width Edge-to-Edge Hero Banner -->
        <div class="w-full relative h-[600px] lg:h-[700px] bg-dark flex flex-col items-center justify-center mb-16 overflow-hidden">
            <!-- 3D Global Logistics Background -->
            <div class="absolute inset-0 bg-[url('{{ asset('storage/hero/ngis.png') }}')] bg-cover bg-center"></div>
            
            <!-- Gradient Overlay (Lightened for better image visibility) -->
            <div class="absolute inset-0 bg-dark/40"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-dark via-dark/20 to-transparent"></div>
            
            <div class="relative z-10 container mx-auto px-6 text-center flex flex-col items-center -mt-16 sm:-mt-24" data-aos="fade-up" data-aos-duration="1000">
                <span class="inline-flex px-4 py-1.5 rounded-none border border-white/50 bg-black/40 backdrop-blur-md text-white text-[10px] sm:text-xs font-bold uppercase tracking-widest mb-6 shadow-lg">
                    <span class="lang-en">Global B2B Trading Platform</span>
                    <span class="lang-ar">المنصة اللوجستية وتجارة B2B العالمية</span>
                </span>
                
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-light text-white mb-6 leading-tight max-w-5xl drop-shadow-2xl">
                    <span class="lang-en"><strong class="font-bold text-white drop-shadow-[0_0_15px_rgba(255,255,255,0.5)]">NGIS</strong> For Securing & Delivering Global Cargo</span>
                    <span class="lang-ar"><strong class="font-bold text-white drop-shadow-[0_0_15px_rgba(255,255,255,0.5)]">NGIS</strong> لتأمين وشحن المنتجات إلى كافة أنحاء العالم</span>
                </h1>
                
                <p class="text-sm md:text-base lg:text-lg text-gray-200 mb-10 max-w-3xl font-light leading-relaxed drop-shadow-md">
                    <span class="lang-en">Seamless procurement, verified vendors, and integrated supply chain management—securing your products from factory to doorstep.</span>
                    <span class="lang-ar">مشتريات سلسة، موردون معتمدون، إدارة متكاملة لسلسلة التوريد، وتأمين شامل لوصول منتجاتك بأمان من المصنع.</span>
                </p>
                
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('home.all-products') }}" class="bg-white text-dark font-bold text-xs uppercase tracking-widest py-3 sm:py-4 px-8 sm:px-10 rounded-none shadow-lg hover:shadow-[0_0_25px_rgba(255,255,255,0.4)] transition-all flex items-center justify-center gap-2">
                        <span class="lang-en">Explore Catalog</span><span class="lang-ar">تصفح المنتجات</span>
                        <i class="ph-bold ph-arrow-right no-rtl rtl:rotate-180"></i>
                    </a>
                    <a href="#" class="bg-black/50 backdrop-blur-sm border border-white/20 text-white hover:bg-white/20 hover:border-white/50 font-bold text-xs uppercase tracking-widest py-3 sm:py-4 px-8 sm:px-10 rounded-none transition-all flex items-center justify-center gap-2">
                        <span class="lang-en">Become a Partner</span><span class="lang-ar">انضم كشريك</span>
                    </a>
                </div>
            </div>

            <!-- Subtle Data Points (Decorations) -->
            <div class="absolute top-1/4 left-1/4 hidden md:flex flex-col items-center animate-pulse z-10 drop-shadow-lg">
                <div class="w-2 h-2 bg-primary rounded-none shadow-[0_0_15px_#D4AF37] mb-2 relative">
                    <div class="absolute inset-0 bg-primary rounded-none animate-ping opacity-60"></div>
                </div>
                <span class="text-[10px] uppercase tracking-widest text-white font-bold bg-black/40 px-2 py-0.5 rounded-none backdrop-blur-sm"><span class="lang-en">Beijing</span><span class="lang-ar">بكين</span></span>
            </div>
            <div class="absolute bottom-1/3 right-1/4 hidden md:flex flex-col items-center z-10 drop-shadow-lg">
                <div class="w-2 h-2 bg-green-500 rounded-none shadow-[0_0_15px_#22c55e] mb-2 relative">
                    <div class="absolute inset-0 bg-green-500 rounded-none animate-ping opacity-40"></div>
                </div>
                <span class="text-[10px] uppercase tracking-widest text-white font-bold bg-black/40 px-2 py-0.5 rounded-none backdrop-blur-sm"><span class="lang-en">Riyadh</span><span class="lang-ar">الرياض</span></span>
            </div>
            
            <!-- Bottom Fade to merge with next section -->
            <div class="absolute bottom-0 inset-x-0 h-32 bg-gradient-to-t from-dark to-transparent pointer-events-none"></div>
        </div>

        <!-- Portals Section -->
        <div class="container mx-auto px-6 mb-20 relative z-20 -mt-24 lg:-mt-32">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Factories Portal -->
                <div class="bg-dark-card border border-dark-border rounded-none shadow-premium hover:border-primary/30 transition-all group overflow-hidden flex flex-col" data-aos="fade-up" data-aos-delay="100">
                    <div class="h-32 bg-[url('https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&q=80&w=800')] bg-cover bg-center relative group-hover:scale-105 transition-transform duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-dark-card to-transparent pointer-events-none"></div>
                    </div>
                    <div class="p-6 pt-0 relative flex-1 flex flex-col">
                        <div class="w-12 h-12 rounded-none bg-dark flex flex-col items-center justify-center mb-4 border border-dark-border drop-shadow-xl -mt-6 relative z-10 group-hover:border-white/50 transition-colors">
                            <i class="ph-fill ph-factory text-2xl text-gray-400 group-hover:text-white transition-colors"></i>
                        </div>
                        <h3 class="text-base font-semibold text-white mb-2 group-hover:text-white transition-colors">
                            <span class="lang-en">Factories Portal</span><span class="lang-ar">بوابة المصانع</span>
                        </h3>
                        <p class="text-xs text-gray-500 mb-6 font-light leading-relaxed flex-1">
                            <span class="lang-en">Join our global network, showcase products, and scale your manufacturing.</span>
                            <span class="lang-ar">انضم لشبكتنا العالمية، اعرض منتجاتك، ووسع نطاق تصنيعك.</span>
                        </p>
                        <a href="{{ route('register.factory') }}" class="w-full bg-dark border border-white/10 text-white font-semibold text-[10px] sm:text-xs uppercase tracking-widest py-3 sm:py-3.5 rounded-none hover:border-white hover:text-white transition-all text-center">
                            <span class="lang-en">Register Factory</span><span class="lang-ar">تسجيل المصنع</span>
                        </a>
                    </div>
                </div>
                
                <!-- Supplying Companies Portal -->
                <div class="bg-dark-card border border-white/10 bg-gradient-to-br from-dark-card to-dark rounded-none shadow-premium hover:border-white/30 transition-all group overflow-hidden flex flex-col relative" data-aos="fade-up" data-aos-delay="200">
                    <div class="absolute inset-0 bg-gradient-to-br from-white/5 to-transparent pointer-events-none z-0"></div>
                    <div class="h-32 bg-[url('https://images.unsplash.com/photo-1553413077-190dd305871c?auto=format&fit=crop&q=80&w=800')] bg-cover bg-center relative group-hover:scale-105 transition-transform duration-700">
                        <div class="absolute inset-0 bg-dark/60 mix-blend-multiply pointer-events-none"></div>
                        <div class="absolute inset-0 bg-gradient-to-t from-dark-card to-transparent pointer-events-none"></div>
                    </div>
                    <div class="p-6 pt-0 relative z-10 flex-1 flex flex-col">
                        <div class="w-12 h-12 rounded-none bg-dark flex flex-col items-center justify-center mb-4 border border-white/20 shadow-lg -mt-6 relative z-10 group-hover:border-white transition-colors">
                            <i class="ph-fill ph-buildings text-2xl text-white drop-shadow-[0_0_10px_rgba(255,255,255,0.3)]"></i>
                        </div>
                        <h3 class="text-base font-semibold text-white mb-2">
                            <span class="lang-en">Supplying Companies</span><span class="lang-ar">بوابة الشركات الموردة</span>
                        </h3>
                        <p class="text-xs text-gray-400 mb-6 font-light leading-relaxed flex-1">
                            <span class="lang-en">Connect with top buyers and streamline your wholesale operations globally.</span>
                            <span class="lang-ar">تواصل مع كبار المشترين وبسّط عمليات البيع بالجملة والتوريد عالميًا.</span>
                        </p>
                        <a href="{{ route('register.company') }}" class="block w-full bg-white text-dark font-bold text-[10px] sm:text-xs uppercase tracking-widest py-3 sm:py-3.5 rounded-none shadow-lg hover:shadow-[0_0_15px_rgba(255,255,255,0.4)] transition-all text-center">
                            <span class="lang-en">Register Company</span><span class="lang-ar">تسجيل شركة موردة</span>
                        </a>
                    </div>
                </div>

                <!-- Clients Portal -->
                <div class="bg-dark-card border border-dark-border rounded-none shadow-premium hover:border-white/30 transition-all group overflow-hidden flex flex-col" data-aos="fade-up" data-aos-delay="300">
                    <div class="h-32 bg-[url('https://images.unsplash.com/photo-1600880292203-757bb62b4baf?auto=format&fit=crop&q=80&w=800')] bg-cover bg-center relative group-hover:scale-105 transition-transform duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-dark-card to-transparent pointer-events-none"></div>
                    </div>
                    <div class="p-6 pt-0 relative flex-1 flex flex-col">
                        <div class="w-12 h-12 rounded-none bg-dark flex flex-col items-center justify-center mb-4 border border-dark-border drop-shadow-xl -mt-6 relative z-10 group-hover:border-white/50 transition-colors">
                            <i class="ph-fill ph-users text-2xl text-gray-400 group-hover:text-white transition-colors"></i>
                        </div>
                        <h3 class="text-base font-semibold text-white mb-2 group-hover:text-white transition-colors">
                            <span class="lang-en">Clients Portal</span><span class="lang-ar">بوابة العملاء</span>
                        </h3>
                        <p class="text-xs text-gray-500 mb-6 font-light leading-relaxed flex-1">
                            <span class="lang-en">Source high-quality products directly from verified manufacturers and suppliers.</span>
                            <span class="lang-ar">احصل على منتجات عالية الجودة مباشرة من المصانع والشركات الموردة المعتمدة.</span>
                        </p>
                        <a href="{{ route('register.client') }}" class="w-full bg-dark border border-white/10 text-white font-semibold text-[10px] sm:text-xs uppercase tracking-widest py-3 sm:py-3.5 rounded-none hover:border-white hover:text-white transition-all text-center">
                            <span class="lang-en">Register Client</span><span class="lang-ar">تسجيل عميل</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- NGIS Products Section -->
        @if(isset($ngisProducts) && count($ngisProducts) > 0)
        <div class="container mx-auto px-6 mb-20">
            <div class="flex flex-col md:flex-row justify-between items-end mb-10 gap-6" data-aos="fade-up">
                <div>
                    <h2 class="text-3xl font-light text-white mb-2 flex items-center gap-3">
                        <span class="lang-en">NGIS <strong class="font-bold">Products</strong></span>
                        <span class="lang-ar">منتجات <strong class="font-bold">NGIS</strong></span>
                        <i class="ph-fill ph-sketch-logo text-white text-2xl"></i>
                    </h2>
                    <p class="text-sm text-gray-500 font-light">
                        <span class="lang-en">Exclusive products directly from our global office network.</span>
                        <span class="lang-ar">منتجات حصرية تقدمها شبكة مكاتبنا العالمية مباشرة.</span>
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 max-w-[90%] mx-auto">
                @foreach($ngisProducts as $index => $product)
                    <div class="bg-dark-card premium-border rounded-none overflow-hidden group flex flex-col" data-aos="fade-up" data-aos-delay="{{ 50 + ($index * 50) }}">
                        <!-- Image Container -->
                        <div class="relative h-36 bg-black">
                            @php $firstImage = $product->images->first(); @endphp
                            <img alt="{{ $product->name }}" 
                                 class="w-full h-full object-cover opacity-80 group-hover:opacity-100 group-hover:scale-105 transition-all duration-700" 
                                 src="{{ $firstImage ? asset('storage/' . $firstImage->image_path) : 'https://via.placeholder.com/400x300?text=No+Image' }}"/>
                            <div class="absolute inset-0 bg-gradient-to-t from-dark-card to-transparent pointer-events-none"></div>
                        </div>
                        
                        <!-- Details -->
                        <div class="p-5 pt-2 flex flex-col flex-1 relative z-10 bg-dark-card">
                            <span class="text-xs uppercase tracking-widest text-white mb-2 font-semibold">{{ $product->sector->name_ar }}</span>
                            <h3 class="text-white font-bold text-base mb-3 line-clamp-2 leading-snug group-hover:text-gray-300 transition-colors" title="{{ $product->name }}">
                                {{ $product->name }}
                            </h3>
                            
                            <!-- User/Office Info -->
                            <div class="flex items-center gap-4 mb-6 mt-auto">
                                <div class="w-10 h-10 border border-white/20 overflow-hidden bg-black shrink-0 avatar-circle">
                                    <img src="{{ $product->user->avatar ? asset('storage/' . $product->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($product->user->name) . '&background=fff&color=000' }}" 
                                         class="w-full h-full object-cover">
                                </div>
                                <div class="flex flex-col min-w-0">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('home.profile', $product->user->id) }}" class="text-sm font-bold text-white hover:text-gray-300 truncate transition-colors">
                                            {{ $product->user->name }}
                                        </a>
                                    </div>
                                    <div class="flex items-center text-[10px] text-gray-500 font-medium">
                                        <i class="ph-fill ph-map-pin text-white/70 mr-1.5"></i>
                                        {{ $product->user->country->name_ar ?? 'N/A' }}
                                    </div>
                                </div>
                            </div>

                            <!-- Footer/Price -->
                            <div class="flex justify-between items-center pt-4 border-t border-white/5">
                                <div class="flex flex-col">
                                    <span class="text-xs text-gray-500 uppercase tracking-widest font-semibold"><span class="lang-en">Min Order</span><span class="lang-ar">الحد الأدنى</span></span>
                                    <span class="text-sm text-gray-200 font-bold">{{ number_format($product->min_order_quantity) }}</span>
                                </div>
                                <div class="flex flex-col items-end">
                                    <span class="text-xs text-gray-500 uppercase tracking-widest font-semibold"><span class="lang-en">Price</span><span class="lang-ar">السعر</span></span>
                                    <span class="text-xl font-black text-white no-rtl">{{ number_format($product->price, 2) }} <span class="text-xs font-medium text-gray-400 uppercase tracking-tighter">{{ $product->currency_code }}</span></span>
                                </div>
                            </div>

                            <!-- Hover Action Layer -->
                            <div class="absolute inset-0 bg-dark/95 backdrop-blur-sm flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none p-6">
                                <a href="{{ route('home.products.show', $product->id) }}" class="pointer-events-auto bg-white text-dark font-bold text-[10px] uppercase tracking-widest py-3 px-6 rounded-none shadow-lg hover:shadow-[0_0_20px_rgba(255,255,255,0.4)] transition-all flex items-center gap-2">
                                    <span class="lang-en">View Details</span><span class="lang-ar">عرض التفاصيل</span>
                                    <i class="ph-bold ph-arrow-right no-rtl rtl:rotate-180"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Verified Products Showcase -->
        <div class="container mx-auto px-6 mb-20">
            <div class="flex flex-col md:flex-row justify-between items-end mb-10 gap-6" data-aos="fade-up">
                <div>
                    <h2 class="text-3xl font-light text-white mb-2 flex items-center gap-3">
                        <span class="lang-en">Verified <strong class="font-bold">Showcase</strong></span>
                        <span class="lang-ar">المعرض <strong class="font-bold">المعتمد</strong></span>
                        <i class="ph-fill ph-seal-check text-white text-2xl"></i>
                    </h2>
                    <p class="text-sm text-gray-500 font-light">
                        <span class="lang-en">Premium products from certified global factories.</span>
                        <span class="lang-ar">منتجات مميزة من مصانع عالمية معتمدة.</span>
                    </p>
                </div>
                <div class="flex gap-2">
                    <button class="w-10 h-10 rounded-none border border-white/10 flex items-center justify-center hover:bg-white/5 transition-colors">
                        <i class="ph-bold ph-caret-left text-gray-400 no-rtl rtl:rotate-180"></i>
                    </button>
                    <button class="w-10 h-10 rounded-none border border-white/50 flex items-center justify-center hover:bg-white/10 text-white transition-colors">
                        <i class="ph-bold ph-caret-right no-rtl rtl:rotate-180"></i>
                    </button>
                </div>
            </div>

            <!-- Categories Tabs -->
            <div class="flex gap-2 mb-8 overflow-x-auto scrollbar-hide pb-2" data-aos="fade-up" data-aos-delay="100">
                <button class="bg-white/10 text-white border border-white/20 px-6 py-2 rounded-none text-xs font-semibold uppercase tracking-widest shrink-0">
                    <span class="lang-en">All Categories</span><span class="lang-ar">كل التصنيفات</span>
                </button>
                <button class="bg-transparent hover:bg-white/5 text-gray-400 border border-transparent px-6 py-2 rounded-none text-xs font-semibold uppercase tracking-widest shrink-0 transition-colors">
                    <span class="lang-en">Vehicles</span><span class="lang-ar">مركبات</span>
                </button>
                <button class="bg-transparent hover:bg-white/5 text-gray-400 border border-transparent px-6 py-2 rounded-none text-xs font-semibold uppercase tracking-widest shrink-0 transition-colors">
                    <span class="lang-en">Machinery</span><span class="lang-ar">معدات</span>
                </button>
                <button class="bg-transparent hover:bg-white/5 text-gray-400 border border-transparent px-6 py-2 rounded-none text-xs font-semibold uppercase tracking-widest shrink-0 transition-colors">
                    <span class="lang-en">Electronics</span><span class="lang-ar">إلكترونيات</span>
                </button>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 max-w-[90%] mx-auto">
                @forelse($recommendedProducts as $index => $product)
                    <div class="bg-dark-card premium-border rounded-none overflow-hidden group flex flex-col" data-aos="fade-up" data-aos-delay="{{ 100 + ($index * 100) }}">
                        <!-- Image Container -->
                        <div class="relative h-36 bg-black">
                            @php $firstImage = $product->images->first(); @endphp
                            <img alt="{{ $product->name }}" 
                                 class="w-full h-full object-cover opacity-80 group-hover:opacity-100 group-hover:scale-105 transition-all duration-700" 
                                 src="{{ $firstImage ? asset('storage/' . $firstImage->image_path) : 'https://via.placeholder.com/400x300?text=No+Image' }}"/>
                            <div class="absolute inset-0 bg-gradient-to-t from-dark-card to-transparent pointer-events-none"></div>
                            
                            @if($product->user->verifications->count() > 0)
                                <div class="absolute top-3 right-3 flex gap-1 z-10">
                                    @foreach($product->user->verifications as $v)
                                        <div class="w-6 h-6 rounded-none bg-dark-card/80 backdrop-blur-md border border-white/10 flex items-center justify-center" title="{{ $v->type }}">
                                            <img src="{{ $v->image_url }}" class="w-4 h-4 object-contain">
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        
                        <!-- Details -->
                        <div class="p-5 pt-2 flex flex-col flex-1 relative z-10 bg-dark-card">
                            <span class="text-xs uppercase tracking-widest text-white mb-2 font-semibold">{{ $product->sector->name_ar }}</span>
                            <h3 class="text-white font-bold text-base mb-3 line-clamp-2 leading-snug group-hover:text-gray-300 transition-colors" title="{{ $product->name }}">
                                {{ $product->name }}
                            </h3>
                            
                            <!-- Factory Info -->
                            <div class="flex items-center gap-4 mb-6 mt-auto">
                                <div class="w-10 h-10 border border-white/20 overflow-hidden bg-black shrink-0 avatar-circle">
                                    <img src="{{ $product->user->avatar ? asset('storage/' . $product->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($product->user->name) . '&background=fff&color=000' }}" 
                                         class="w-full h-full object-cover">
                                </div>
                                <div class="flex flex-col min-w-0">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('home.profile', $product->user->id) }}" class="text-sm font-bold text-white hover:text-gray-300 truncate transition-colors">
                                            {{ $product->user->name }}
                                        </a>
                                        <div class="flex items-center gap-1 shrink-0">
                                            @foreach($product->user->verifications as $v)
                                                <img src="{{ $v->image_url }}" title="{{ $v->type }}" class="h-4 w-4 object-contain">
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="flex items-center text-[10px] text-gray-500 font-medium">
                                        <i class="ph-fill ph-map-pin text-white/70 mr-1.5"></i>
                                        {{ $product->user->country->name_ar ?? 'N/A' }}
                                    </div>
                                </div>
                            </div>

                            <!-- Footer/Price -->
                            <div class="flex justify-between items-center pt-4 border-t border-white/5">
                                <div class="flex flex-col">
                                    <span class="text-xs text-gray-500 uppercase tracking-widest font-semibold"><span class="lang-en">Min Order</span><span class="lang-ar">الحد الأدنى</span></span>
                                    <span class="text-sm text-gray-200 font-bold">{{ number_format($product->min_order_quantity) }}</span>
                                </div>
                                <div class="flex flex-col items-end">
                                    <span class="text-xs text-gray-500 uppercase tracking-widest font-semibold"><span class="lang-en">Price</span><span class="lang-ar">السعر</span></span>
                                    <span class="text-xl font-black text-white no-rtl">{{ number_format($product->price, 2) }} <span class="text-xs font-medium text-gray-400 uppercase tracking-tighter">{{ $product->currency_code }}</span></span>
                                </div>
                            </div>

                            <!-- Hover Action Layer -->
                            <div class="absolute inset-0 bg-dark/95 backdrop-blur-sm flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none p-6">
                                <a href="{{ route('home.products.show', $product->id) }}" class="pointer-events-auto bg-white text-dark font-bold text-[10px] uppercase tracking-widest py-3 px-6 rounded-none shadow-lg hover:shadow-[0_0_20px_rgba(255,255,255,0.4)] transition-all flex items-center gap-2">
                                    <span class="lang-en">View Details</span><span class="lang-ar">عرض التفاصيل</span>
                                    <i class="ph-bold ph-arrow-right no-rtl rtl:rotate-180"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-16 flex flex-col items-center justify-center text-gray-500 bg-dark-card border border-dark-border rounded-none">
                        <i class="ph ph-package text-4xl mb-4 opacity-50"></i>
                        <span class="text-sm uppercase tracking-widest font-semibold">
                            <span class="lang-en">No verified products available.</span>
                            <span class="lang-ar">لا توجد منتجات معتمدة حالياً.</span>
                        </span>
                    </div>
                @endforelse
            </div>
            
            <div class="mt-12 flex justify-center" data-aos="fade-up">
                <a href="{{ route('home.all-products') }}" class="inline-flex items-center gap-2 text-xs font-bold text-white uppercase tracking-widest border border-white/20 rounded-none px-8 py-3 hover:bg-white hover:text-black transition-all">
                    <span class="lang-en">View All Products</span><span class="lang-ar">عرض جميع المنتجات</span>
                </a>
            </div>
        </div>

        <!-- Integrated Logistics Tracker -->
        <div class="container mx-auto px-6" data-aos="fade-up">
            <div class="premium-border bg-dark-card rounded-none overflow-hidden shadow-premium grid grid-cols-1 lg:grid-cols-2">
                <!-- Tracker Form -->
                <div class="p-8 lg:p-12 flex flex-col justify-center">
                    <div class="inline-flex items-center gap-2 bg-white/5 border border-white/10 rounded-none px-3 py-1 text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-6 w-max">
                        <i class="ph-fill ph-globe-hemisphere-west text-white"></i>
                        <span class="lang-en">Supply Chain</span><span class="lang-ar">سلسلة التوريد</span>
                    </div>
                    <h2 class="text-3xl font-light text-white mb-4">
                        <span class="lang-en">Track Your <strong class="font-bold">Shipment</strong></span>
                        <span class="lang-ar">تتبع <strong class="font-bold">شحنتك</strong></span>
                    </h2>
                    <p class="text-sm text-gray-500 font-light mb-8 max-w-sm leading-relaxed">
                        <span class="lang-en">Monitor your cargo in real-time across global trade routes with our integrated logistics system.</span>
                        <span class="lang-ar">راقب شحنتك بشكل مباشر عبر طرق التجارة العالمية من خلال نظامنا اللوجستي المتكامل.</span>
                    </p>
                    
                    <div class="flex flex-col sm:flex-row gap-3">
                        <div class="relative flex-1">
                            <i class="ph ph-barcode absolute top-1/2 -translate-y-1/2 left-4 rtl:left-auto rtl:right-4 text-gray-500 text-lg"></i>
                            <input type="text" class="lux-input w-full rounded-none py-4 pl-12 pr-4 rtl:pr-12 rtl:pl-4 text-sm" placeholder="Tracking Number / B/L" dir="auto">
                        </div>
                        <button class="bg-white text-dark font-bold text-[10px] uppercase tracking-widest py-4 px-8 rounded-none shadow-lg hover:shadow-[0_0_20px_rgba(255,255,255,0.4)] transition-all whitespace-nowrap">
                            <span class="lang-en">Track</span><span class="lang-ar">تتبع</span>
                        </button>
                    </div>
                </div>
                
                <!-- Tracker Visual -->
                <div class="relative bg-black min-h-[300px] lg:min-h-full overflow-hidden border-t lg:border-t-0 lg:border-l border-white/5 rtl:lg:border-l-0 rtl:lg:border-r">
                    <div class="absolute inset-0 opacity-40 bg-[url('https://images.unsplash.com/photo-1494412574643-ff11b0a5c1c3?auto=format&fit=crop&q=80&w=800')] bg-cover bg-center mix-blend-luminosity"></div>
                    <div class="absolute inset-0 bg-gradient-to-r from-dark-card via-transparent to-transparent"></div>
                    
                    <div class="absolute inset-0 p-8 flex flex-col justify-end z-10">
                        <div class="bg-dark/80 backdrop-blur-md border border-white/10 rounded-none p-6">
                            <div class="flex justify-between items-center mb-6 text-white">
                                <div class="flex flex-col gap-1">
                                    <i class="ph-fill ph-boat text-gray-400"></i>
                                    <span class="text-sm font-bold">Shanghai</span>
                                    <span class="text-[10px] text-gray-500 uppercase tracking-widest">Origin</span>
                                </div>
                                <div class="flex-1 flex items-center px-4">
                                    <div class="h-px bg-white/20 w-full relative">
                                        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-dark border border-white text-white text-[10px] py-1 px-3 rounded-none font-bold uppercase tracking-widest whitespace-nowrap">In Transit</div>
                                    </div>
                                </div>
                                <div class="flex flex-col gap-1 items-end text-right">
                                    <i class="ph-fill ph-anchor text-white"></i>
                                    <span class="text-sm font-bold">Jeddah</span>
                                    <span class="text-[10px] text-gray-500 uppercase tracking-widest">Destination</span>
                                </div>
                            </div>
                            
                            <!-- Progress -->
                            <div class="flex justify-between text-[10px] font-bold text-white uppercase tracking-widest mb-2">
                                <span>Progress</span>
                                <span class="text-white">65%</span>
                            </div>
                            <div class="h-1.5 w-full bg-white/5 rounded-none overflow-hidden">
                                <div class="h-full bg-white rounded-none" style="width: 65%;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>

    <!-- Ultra-Minimal Footer -->
    <footer class="border-t border-dark-border bg-dark pt-16 pb-8">
        <div class="container mx-auto px-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-8 mb-12">
                <div class="flex items-center gap-4">
                    <i class="ph-fill ph-hexagon text-4xl text-white"></i>
                    <div class="flex flex-col">
                        <span class="text-white text-sm font-bold uppercase tracking-widest">NGIS Global</span>
                        <span class="text-gray-500 text-xs mt-1">Integrated Corporate Services</span>
                    </div>
                </div>
                
                <div class="flex gap-8 text-xs font-semibold text-gray-400 uppercase tracking-widest">
                    <a href="#" class="hover:text-white transition-colors">About</a>
                    <a href="#" class="hover:text-white transition-colors">Partners</a>
                    <a href="#" class="hover:text-white transition-colors">Contact</a>
                    <a href="#" class="hover:text-white transition-colors">Legal</a>
                </div>
            </div>
            
            <div class="flex flex-col md:flex-row justify-between items-center gap-4 pt-8 border-t border-white/5 text-[10px] text-gray-600 uppercase tracking-widest">
                <span>&copy; 2026 NGIS Global. <span class="lang-en">All Rights Reserved.</span><span class="lang-ar">جميع الحقوق محفوظة.</span></span>
                <div class="flex gap-4 text-gray-500">
                    <i class="ph-fill ph-linkedin-logo text-lg hover:text-white cursor-pointer transition-colors"></i>
                    <i class="ph-fill ph-twitter-logo text-lg hover:text-white cursor-pointer transition-colors"></i>
                    <i class="ph-fill ph-envelope-simple text-lg hover:text-white cursor-pointer transition-colors"></i>
                </div>
            </div>
        </div>
    </footer>

    <!-- Init AOS Animation -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            AOS.init({
                once: true,
                offset: 50,
            });
            
            // Sync language logic (Ensure texts are correct on load based on default RTL/AR)
            const html = document.getElementById('main-html');
            if(html.getAttribute('lang') === 'ar') {
                document.getElementById('lang-text').innerText = 'AR';
            } else {
                document.getElementById('lang-text').innerText = 'EN';
            }
        });
    </script>
</body>
</html>