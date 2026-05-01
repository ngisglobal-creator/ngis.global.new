@extends('layouts.luxe')

@section('title', 'Supplier Access | NGIS Global')

@section('styles')
    <style>
        .auth-container {
            min-height: 80vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 80px 0;
            background: #fbfbfb;
        }
        .auth-card {
            background: #fff;
            border-radius: 30px;
            overflow: hidden;
            border: 1px solid #f0f0f0;
            box-shadow: 0 20px 50px rgba(0,0,0,0.03);
            width: 100%;
            max-width: 450px;
        }
        .form-label-lux {
            font-size: 0.7rem;
            font-weight: 800;
            color: var(--ngis-black);
            text-transform: uppercase;
            letter-spacing: 1.2px;
            margin-bottom: 8px;
            display: block;
        }
    </style>
@endsection

@section('content')
    <div class="auth-container">
        <div class="container d-flex justify-content-center">
            <div class="auth-card p-5" data-aos="fade-up">
                <div class="text-center mb-5">
                    <div class="logo-box bg-dark text-gold d-inline-flex align-items-center justify-content-center rounded-4 mb-4" style="width: 60px; height: 60px;">
                        <i class="ph-fill ph-buildings fs-2"></i>
                    </div>
                    <h2 class="fw-bold mb-2">
                        <span class="lang-en">Supplier <span class="text-gold">Login</span></span>
                        <span class="lang-ar">دخول <span class="text-gold">الشركات الموردة</span></span>
                    </h2>
                    <p class="text-muted small">
                        <span class="lang-en">Access your supply chain dashboard</span>
                        <span class="lang-ar">الوصول إلى لوحة مورد الشحنات الخاصة بك</span>
                    </p>
                </div>

                <x-auth-session-status class="mb-4 text-center text-success small fw-bold" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-4">
                        <label class="form-label-lux">
                            <span class="lang-en">Email Address</span><span class="lang-ar">البريد الإلكتروني</span>
                        </label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus class="form-control-lux w-100 px-4 py-3" placeholder="supplier@example.com">
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger x-small fw-bold" />
                    </div>

                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <label class="form-label-lux mb-0">
                                <span class="lang-en">Password</span><span class="lang-ar">كلمة المرور</span>
                            </label>
                            @if (Route::has('password.request'))
                                <a class="x-small text-muted text-decoration-none fw-bold" href="{{ route('password.request') }}">
                                    <span class="lang-en">Forgot?</span><span class="lang-ar">نسيت؟</span>
                                </a>
                            @endif
                        </div>
                        <input id="password" type="password" name="password" required class="form-control-lux w-100 px-4 py-3 mt-2" placeholder="••••••••">
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger x-small fw-bold" />
                    </div>

                    <div class="mb-4">
                        <div class="form-check">
                            <input id="remember_me" type="checkbox" name="remember" class="form-check-input">
                            <label class="form-check-label text-muted x-small fw-bold" for="remember_me">
                                <span class="lang-en">Remember my session</span><span class="lang-ar">تذكر جلستي</span>
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-gold btn-lg w-100 py-3 mb-4 shadow-sm">
                        <span class="lang-en">Sign In</span><span class="lang-ar">تسجيل الدخول</span>
                    </button>

                    <div class="text-center pt-3 border-top mt-2">
                        <p class="x-small text-muted mb-0">
                            <span class="lang-en">New supplier?</span><span class="lang-ar">مورد جديد؟</span>
                            <a href="{{ route('register.company') }}" class="text-dark fw-black ms-1 text-decoration-none">
                                <span class="lang-en">Register Now</span><span class="lang-ar">سجل الآن</span>
                            </a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
