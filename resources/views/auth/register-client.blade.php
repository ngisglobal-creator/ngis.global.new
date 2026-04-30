@extends('layouts.luxe')

@section('title', 'Register as Client | NGIS Global')

@section('styles')
    <style>
        .auth-container {
            min-height: 90vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 100px 0;
            background: #fbfbfb;
        }
        .auth-card {
            background: #fff;
            border-radius: 30px;
            overflow: hidden;
            border: 1px solid #f0f0f0;
            box-shadow: 0 20px 50px rgba(0,0,0,0.03);
            width: 100%;
            max-width: 550px;
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
                        <i class="ph-fill ph-user-plus fs-2"></i>
                    </div>
                    <h2 class="fw-bold mb-2">
                        <span class="lang-en">Join as <span class="text-gold">Client</span></span>
                        <span class="lang-ar">تسجيل <span class="text-gold">عميل جديد</span></span>
                    </h2>
                    <p class="text-muted small">
                        <span class="lang-en">Source high-quality products from verified suppliers</span>
                        <span class="lang-ar">احصل على منتجات عالية الجودة من موردين معتمدين</span>
                    </p>
                </div>

                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <input type="hidden" name="type" value="client">

                    <div class="mb-4">
                        <label class="form-label-lux">
                            <span class="lang-en">Full Name</span><span class="lang-ar">الاسم بالكامل</span>
                        </label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus class="form-control-lux w-100 px-4 py-3" placeholder="e.g. Ahmed Ali">
                        <x-input-error :messages="$errors->get('name')" class="mt-2 text-danger x-small fw-bold" />
                    </div>

                    <div class="mb-4">
                        <label class="form-label-lux">
                            <span class="lang-en">Email Address</span><span class="lang-ar">البريد الإلكتروني</span>
                        </label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required class="form-control-lux w-100 px-4 py-3" placeholder="user@example.com">
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger x-small fw-bold" />
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6 mb-4">
                            <label class="form-label-lux">
                                <span class="lang-en">Password</span><span class="lang-ar">كلمة المرور</span>
                            </label>
                            <input id="password" type="password" name="password" required class="form-control-lux w-100 px-4 py-3" placeholder="••••••••">
                            <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger x-small fw-bold" />
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label-lux">
                                <span class="lang-en">Confirm Password</span><span class="lang-ar">تأكيد كلمة المرور</span>
                            </label>
                            <input id="password_confirmation" type="password" name="password_confirmation" required class="form-control-lux w-100 px-4 py-3" placeholder="••••••••">
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-danger x-small fw-bold" />
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="form-check">
                            <input type="checkbox" required id="terms" class="form-check-input">
                            <label class="form-check-label text-muted x-small fw-bold" for="terms">
                                <span class="lang-en">I agree to the <a href="#" class="text-dark">Terms of Service</a></span>
                                <span class="lang-ar">أوافق على <a href="#" class="text-dark">شروط الخدمة</a></span>
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-gold btn-lg w-100 py-3 mb-4 shadow-sm">
                        <span class="lang-en">Register Account</span><span class="lang-ar">إنشاء الحساب</span>
                    </button>

                    <div class="text-center pt-3 border-top mt-2">
                        <p class="x-small text-muted mb-0">
                            <span class="lang-en">Already have an account?</span><span class="lang-ar">هل لديك حساب بالفعل؟</span>
                            <a href="{{ route('login.client') }}" class="text-dark fw-black ms-1 text-decoration-none">
                                <span class="lang-en">Sign In</span><span class="lang-ar">تسجيل الدخول</span>
                            </a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
