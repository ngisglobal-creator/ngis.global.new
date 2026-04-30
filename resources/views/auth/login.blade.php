@extends('layouts.luxe')

@section('title', 'Login | NGIS Global')

@section('styles')
    <style>
        .auth-container {
            min-height: 80vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 80px 0;
        }
        .auth-card {
            width: 100%;
            max-width: 450px;
            position: relative;
        }
        .form-label-lux {
            font-size: 0.7rem;
            font-weight: 800;
            color: var(--gold-mid);
            text-transform: uppercase;
            letter-spacing: 1.2px;
            margin-bottom: 8px;
            display: block;
            opacity: 0.8;
        }
        .auth-icon-circle {
            width: 80px;
            height: 80px;
            background: rgba(212, 175, 55, 0.1);
            border: 1px solid var(--gold-mid);
            color: var(--gold-mid);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            margin: 0 auto 30px;
            box-shadow: 0 0 20px rgba(212, 175, 55, 0.1);
        }
    </style>
@endsection

@section('content')
    <div class="auth-container">
        <div class="container d-flex justify-content-center">
            <div class="auth-card premium-glass-card p-5" data-aos="fade-up">
                <div class="text-center">
                    <div class="auth-icon-circle">
                        <i class="ph-fill ph-lock-key fs-1"></i>
                    </div>
                    <h2 class="fw-bold mb-2">
                        <span class="lang-en">Welcome <span class="text-gold">Back</span></span>
                        <span class="lang-ar">مرحباً <span class="text-gold">بعودتك</span></span>
                    </h2>
                    <p class="text-muted small mb-5">
                        <span class="lang-en">Enter your credentials to access your portal</span>
                        <span class="lang-ar">أدخل بياناتك للوصول إلى البوابة الخاصة بك</span>
                    </p>
                </div>

                <x-auth-session-status class="mb-4 text-center text-gold small fw-bold" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-4">
                        <label class="form-label-lux">
                            <span class="lang-en">Email Address</span><span class="lang-ar">البريد الإلكتروني</span>
                        </label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus class="form-control-lux w-100" placeholder="user@ngis.ly" style="padding: 14px 20px;">
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger x-small fw-bold" />
                    </div>

                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <label class="form-label-lux mb-0">
                                <span class="lang-en">Password</span><span class="lang-ar">كلمة المرور</span>
                            </label>
                            @if (Route::has('password.request'))
                                <a class="x-small text-gold text-decoration-none fw-bold opacity-75" href="{{ route('password.request') }}">
                                    <span class="lang-en">Forgot?</span><span class="lang-ar">نسيت؟</span>
                                </a>
                            @endif
                        </div>
                        <input id="password" type="password" name="password" required class="form-control-lux w-100" placeholder="••••••••" style="padding: 14px 20px;">
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger x-small fw-bold" />
                    </div>

                    <div class="mb-4">
                        <div class="form-check">
                            <input id="remember_me" type="checkbox" name="remember" class="form-check-input bg-dark border-secondary">
                            <label class="form-check-label text-muted x-small fw-bold" for="remember_me">
                                <span class="lang-en">Remember my session</span><span class="lang-ar">تذكر جلستي</span>
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-gold btn-lg w-100 py-3 mb-4 shadow-lg mt-3">
                        <span class="lang-en">Sign In</span><span class="lang-ar">تسجيل الدخول</span>
                    </button>

                    <div class="text-center pt-4 border-top border-white-10 mt-2">
                        <p class="x-small text-muted mb-0">
                            <span class="lang-en">Don't have an account?</span><span class="lang-ar">ليس لديك حساب؟</span>
                            <a href="{{ route('register') }}" class="text-gold fw-black ms-1 text-decoration-none">
                                <span class="lang-en">Create One</span><span class="lang-ar">إنشاء حساب</span>
                            </a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
