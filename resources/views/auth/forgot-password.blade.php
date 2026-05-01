@extends('layouts.luxe')

@section('title', 'Forgot Password | NGIS Global')

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
    </style>
@endsection

@section('content')
    <div class="auth-container">
        <div class="container d-flex justify-content-center">
            <div class="auth-card premium-glass-card p-5" data-aos="fade-up">
                <div class="text-center mb-5">
                    <div class="auth-icon-circle mx-auto mb-4" style="width: 70px; height: 70px; background: rgba(212, 175, 55, 0.1); border: 1px solid var(--gold-mid); color: var(--gold-mid); display: flex; align-items: center; justify-content: center; border-radius: 50%;">
                        <i class="ph-fill ph-key fs-2"></i>
                    </div>
                    <h2 class="fw-bold mb-3">
                        <span class="lang-en">Forgot <span class="text-gold">Password?</span></span>
                        <span class="lang-ar">نسيت <span class="text-gold">كلمة المرور؟</span></span>
                    </h2>
                    <p class="text-muted small">
                        <span class="lang-en">No problem. Just let us know your email address and we will email you a password reset link.</span>
                        <span class="lang-ar">لا توجد مشكلة. فقط أخبرنا ببريدك الإلكتروني وسنرسل لك رابطاً لإعادة تعيين كلمة المرور.</span>
                    </p>
                </div>

                <x-auth-session-status class="mb-4 text-center text-gold small fw-bold" :status="session('status')" />

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="mb-4">
                        <label class="form-label-lux">
                            <span class="lang-en">Email Address</span><span class="lang-ar">البريد الإلكتروني</span>
                        </label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus class="form-control-lux w-100" placeholder="user@ngis.ly" style="padding: 14px 20px;">
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger x-small fw-bold" />
                    </div>

                    <button type="submit" class="btn btn-gold btn-lg w-100 py-3 mb-4 shadow-lg mt-3">
                        <span class="lang-en">Send Reset Link</span><span class="lang-ar">إرسال رابط التعيين</span>
                    </button>

                    <div class="text-center pt-4 border-top border-white-10 mt-2">
                        <a href="{{ route('login') }}" class="text-gold x-small fw-bold text-decoration-none">
                            <i class="ph ph-arrow-left me-1"></i>
                            <span class="lang-en">Back to Login</span><span class="lang-ar">العودة لتسجيل الدخول</span>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
