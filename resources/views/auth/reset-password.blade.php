@extends('layouts.luxe')

@section('title', 'Reset Password | NGIS Global')

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
            max-width: 500px;
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
                        <i class="ph-fill ph-password fs-2"></i>
                    </div>
                    <h2 class="fw-bold mb-3">
                        <span class="lang-en">Reset <span class="text-gold">Password</span></span>
                        <span class="lang-ar">إعادة تعيين <span class="text-gold">كلمة المرور</span></span>
                    </h2>
                    <p class="text-muted small">
                        <span class="lang-en">Enter your new secure password below to regain access.</span>
                        <span class="lang-ar">أدخل كلمة المرور الجديدة الآمنة أدناه لاستعادة الوصول.</span>
                    </p>
                </div>

                <form method="POST" action="{{ route('password.store') }}">
                    @csrf

                    <!-- Password Reset Token -->
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <div class="mb-4">
                        <label class="form-label-lux">
                            <span class="lang-en">Email Address</span><span class="lang-ar">البريد الإلكتروني</span>
                        </label>
                        <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus class="form-control-lux w-100" placeholder="user@ngis.ly" style="padding: 14px 20px;">
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger x-small fw-bold" />
                    </div>

                    <div class="mb-4">
                        <label class="form-label-lux">
                            <span class="lang-en">New Password</span><span class="lang-ar">كلمة المرور الجديدة</span>
                        </label>
                        <input id="password" type="password" name="password" required class="form-control-lux w-100" placeholder="••••••••" style="padding: 14px 20px;">
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger x-small fw-bold" />
                    </div>

                    <div class="mb-4">
                        <label class="form-label-lux">
                            <span class="lang-en">Confirm Password</span><span class="lang-ar">تأكيد كلمة المرور</span>
                        </label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required class="form-control-lux w-100" placeholder="••••••••" style="padding: 14px 20px;">
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-danger x-small fw-bold" />
                    </div>

                    <button type="submit" class="btn btn-gold btn-lg w-100 py-3 mb-4 shadow-lg mt-3">
                        <span class="lang-en">Reset Password</span><span class="lang-ar">حفظ كلمة المرور</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
