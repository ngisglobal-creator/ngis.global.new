@extends('layouts.luxe')

@section('title', 'Register | NGIS Global')

@section('styles')
    <style>
        .auth-container {
            min-height: 90vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 100px 0;
        }
        .auth-card {
            width: 100%;
            max-width: 550px;
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
            width: 70px;
            height: 70px;
            background: rgba(212, 175, 55, 0.1);
            border: 1px solid var(--gold-mid);
            color: var(--gold-mid);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            margin: 0 auto 25px;
            box-shadow: 0 0 20px rgba(212, 175, 55, 0.1);
        }
        select.form-control-lux option {
            background: var(--bg-dark);
            color: #fff;
        }
    </style>
@endsection

@section('content')
    <div class="auth-container">
        <div class="container d-flex justify-content-center">
            <div class="auth-card premium-glass-card p-5" data-aos="fade-up">
                <div class="text-center">
                    <div class="auth-icon-circle">
                        <i class="ph-fill ph-user-plus fs-2"></i>
                    </div>
                    <h2 class="fw-bold mb-2">
                        <span class="lang-en">Create <span class="text-gold">Account</span></span>
                        <span class="lang-ar">إنشاء <span class="text-gold">حساب جديد</span></span>
                    </h2>
                    <p class="text-muted small mb-5">
                        <span class="lang-en">Join our global professional community</span>
                        <span class="lang-ar">انضم إلى مجتمعنا المهني العالمي</span>
                    </p>
                </div>

                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="form-label-lux">
                            <span class="lang-en">Account Type</span><span class="lang-ar">نوع الحساب</span>
                        </label>
                        <select name="type" required class="form-select form-control-lux w-100" style="padding: 14px 20px;">
                            <option value="client">Client | عميل</option>
                            <option value="factory">Factory | مصنع</option>
                            <option value="company">Supplier | مورد</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label-lux">
                            <span class="lang-en">Full Name</span><span class="lang-ar">الاسم بالكامل</span>
                        </label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus class="form-control-lux w-100" placeholder="e.g. Ahmed Ali" style="padding: 14px 20px;">
                        <x-input-error :messages="$errors->get('name')" class="mt-2 text-danger x-small fw-bold" />
                    </div>

                    <div class="mb-4">
                        <label class="form-label-lux">
                            <span class="lang-en">Email Address</span><span class="lang-ar">البريد الإلكتروني</span>
                        </label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required class="form-control-lux w-100" placeholder="user@example.com" style="padding: 14px 20px;">
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger x-small fw-bold" />
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6 mb-4">
                            <label class="form-label-lux">
                                <span class="lang-en">Password</span><span class="lang-ar">كلمة المرور</span>
                            </label>
                            <input id="password" type="password" name="password" required class="form-control-lux w-100" placeholder="••••••••" style="padding: 14px 20px;">
                            <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger x-small fw-bold" />
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label-lux">
                                <span class="lang-en">Confirm Password</span><span class="lang-ar">تأكيد كلمة المرور</span>
                            </label>
                            <input id="password_confirmation" type="password" name="password_confirmation" required class="form-control-lux w-100" placeholder="••••••••" style="padding: 14px 20px;">
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-danger x-small fw-bold" />
                        </div>
                    </div>

                    <button type="submit" class="btn btn-gold btn-lg w-100 py-3 mb-4 shadow-lg mt-3">
                        <span class="lang-en">Register Account</span><span class="lang-ar">إنشاء الحساب</span>
                    </button>

                    <div class="text-center pt-4 border-top border-white-10 mt-2">
                        <p class="x-small text-muted mb-0">
                            <span class="lang-en">Already have an account?</span><span class="lang-ar">هل لديك حساب بالفعل؟</span>
                            <a href="{{ route('login') }}" class="text-gold fw-black ms-1 text-decoration-none">
                                <span class="lang-en">Sign In</span><span class="lang-ar">تسجيل الدخول</span>
                            </a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
