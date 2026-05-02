@extends('client.layouts.master')

@section('title', 'إدارة الملف الشخصي')

@section('content')
<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="d-flex align-items-center justify-content-between mb-5">
        <div>
            <h2 class="fw-bold text-dark mb-1">إدارة الملف الشخصي</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('client.dashboard') }}" class="text-decoration-none">الرئيسية</a></li>
                    <li class="breadcrumb-item active" aria-current="page">ملفي الشخصي</li>
                </ol>
            </nav>
        </div>
        <div>
            <span class="badge bg-light text-primary px-3 py-2 rounded-pill border fw-bold">
                <i class="fa-solid fa-shield-halved me-1"></i> حساب موثق
            </span>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4" style="border-radius: 12px;">
            <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
        </div>
    @endif

    <div class="row g-4">
        <!-- Personal Info Card -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 20px;">
                <div class="card-body p-4 text-center">
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" id="avatarForm">
                        @csrf
                        @method('patch')
                        <div class="position-relative d-inline-block mb-4">
                            <div class="avatar-container shadow" style="width: 150px; height: 150px; border-radius: 50%; padding: 5px; background: #fff; border: 3px solid #f0f4f8;">
                                <img id="avatar-preview" src="{{ $user->avatar ? \Illuminate\Support\Facades\Storage::url($user->avatar) : asset('dist/img/user4-128x128.jpg') }}" 
                                     alt="User Avatar" class="rounded-circle w-100 h-100" style="object-fit: cover;">
                            </div>
                            <label for="avatar_input" class="btn btn-primary btn-sm position-absolute bottom-0 end-0 rounded-circle shadow" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; cursor: pointer; border: 3px solid #fff;">
                                <i class="fa-solid fa-camera"></i>
                            </label>
                            <input type="file" name="avatar" id="avatar_input" class="d-none" accept="image/*" onchange="submitAvatar()">
                        </div>
                    </form>
                    
                    <h4 class="fw-bold text-dark mb-1">{{ $user->name }}</h4>
                    <p class="text-muted mb-4">{{ $user->email }}</p>
                    
                    <div class="d-flex justify-content-center gap-2 mb-4">
                        <div class="px-3 py-2 bg-light rounded-3 text-center" style="min-width: 80px;">
                            <div class="fw-bold text-primary">{{ $user->orders_count ?? 0 }}</div>
                            <div class="x-small text-muted">طلباتي</div>
                        </div>
                        <div class="px-3 py-2 bg-light rounded-3 text-center" style="min-width: 80px;">
                            <div class="fw-bold text-success">{{ number_format($user->wallet_balance ?? 0, 2) }}</div>
                            <div class="x-small text-muted">المحفظة</div>
                        </div>
                    </div>

                    <hr class="opacity-10 my-4">
                    
                    <div class="text-start">
                        <h6 class="fw-bold text-dark mb-3 small text-uppercase tracking-wider">الحالة الأمنية</h6>
                        <div class="d-flex align-items-center mb-3">
                            <i class="fa-solid fa-circle-check text-success me-3"></i>
                            <div>
                                <div class="small fw-bold">البريد الإلكتروني موثق</div>
                                <div class="x-small text-muted">{{ $user->email_verified_at ? $user->email_verified_at->format('Y/m/d') : 'غير موثق' }}</div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="fa-solid fa-clock text-warning me-3"></i>
                            <div>
                                <div class="small fw-bold">آخر نشاط</div>
                                <div class="x-small text-muted">{{ now()->diffForHumans() }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Form Card -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm" style="border-radius: 20px;">
                <div class="card-header bg-white border-0 p-4 pb-0">
                    <ul class="nav nav-pills" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active rounded-pill px-4 fw-bold" id="pills-general-tab" data-bs-toggle="pill" data-bs-target="#pills-general" type="button" role="tab">المعلومات الأساسية</button>
                        </li>
                        <li class="nav-item ms-2" role="presentation">
                            <button class="nav-link rounded-pill px-4 fw-bold" id="pills-security-tab" data-bs-toggle="pill" data-bs-target="#pills-security" type="button" role="tab">الأمان وكلمة المرور</button>
                        </li>
                    </ul>
                </div>
                <div class="card-body p-4">
                    <div class="tab-content" id="pills-tabContent">
                        <!-- General Info Tab -->
                        <div class="tab-pane fade show active" id="pills-general" role="tabpanel">
                            <form action="{{ route('profile.update') }}" method="POST">
                                @csrf
                                @method('patch')
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold small">الاسم الكامل</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-0"><i class="fa-solid fa-user text-muted"></i></span>
                                            <input type="text" name="name" class="form-control bg-light border-0 py-2" value="{{ old('name', $user->name) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold small">البريد الإلكتروني</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-0"><i class="fa-solid fa-envelope text-muted"></i></span>
                                            <input type="email" name="email" class="form-control bg-light border-0 py-2" value="{{ old('email', $user->email) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold small">رقم الهاتف</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-0"><i class="fa-solid fa-phone text-muted"></i></span>
                                            <input type="text" name="phone" class="form-control bg-light border-0 py-2" value="{{ old('phone', $user->phone) }}" placeholder="+966 ...">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold small">الدولة</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-0"><i class="fa-solid fa-location-dot text-muted"></i></span>
                                            <input type="text" class="form-control bg-light border-0 py-2" value="{{ $user->country->name_ar ?? '-' }}" readonly disabled>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-5">
                                        <button type="submit" class="btn btn-primary px-5 py-3 fw-bold rounded-3 shadow-sm">
                                            <i class="fa-solid fa-floppy-disk me-2"></i> حفظ البيانات الشخصية
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Security Tab -->
                        <div class="tab-pane fade" id="pills-security" role="tabpanel">
                            <form action="{{ route('profile.update') }}" method="POST">
                                @csrf
                                @method('patch')
                                <input type="hidden" name="name" value="{{ $user->name }}">
                                <input type="hidden" name="email" value="{{ $user->email }}">
                                
                                <div class="bg-light rounded-4 p-4 mb-4">
                                    <div class="d-flex align-items-center mb-4">
                                        <div class="bg-white p-3 rounded-circle shadow-sm me-3">
                                            <i class="fa-solid fa-lock text-warning fs-4"></i>
                                        </div>
                                        <div>
                                            <h5 class="fw-bold mb-1">تحديث كلمة المرور</h5>
                                            <p class="text-muted small mb-0">تأكد من اختيار كلمة مرور قوية لحماية حسابك</p>
                                        </div>
                                    </div>
                                    
                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold small">كلمة المرور الجديدة</label>
                                            <input type="password" name="password" class="form-control border-0 py-2 shadow-sm" placeholder="********">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold small">تأكيد كلمة المرور</label>
                                            <input type="password" name="password_confirmation" class="form-control border-0 py-2 shadow-sm" placeholder="********">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="alert alert-warning border-0 small d-flex align-items-center" style="border-radius: 12px;">
                                    <i class="fa-solid fa-circle-info fs-4 me-3"></i>
                                    <div>عند تغيير كلمة المرور، سيتم توجيهك لتسجيل الدخول مرة أخرى لضمان أمان حسابك.</div>
                                </div>

                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary px-5 py-3 fw-bold rounded-3 shadow-sm">
                                        <i class="fa-solid fa-shield-halved me-2"></i> تحديث كلمة المرور
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .nav-pills .nav-link {
        color: #6c757d;
        background: #f8f9fa;
        border: 1px solid transparent;
        transition: all 0.3s ease;
    }
    .nav-pills .nav-link.active {
        color: #fff;
        background-color: #0d6efd;
        box-shadow: 0 4px 10px rgba(13, 110, 253, 0.3);
    }
    .x-small { font-size: 11px; }
    .form-control:focus {
        box-shadow: none;
        border-color: #0d6efd;
    }
    .avatar-container {
        transition: transform 0.3s ease;
    }
    .avatar-container:hover {
        transform: scale(1.02);
    }
</style>

@push('scripts')
<script>
    function submitAvatar() {
        const input = document.getElementById('avatar_input');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('avatar-preview').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
            
            // Auto submit form
            Swal.fire({
                title: 'تغيير الصورة الشخصية؟',
                text: "هل تريد حفظ الصورة المختارة كصورة شخصية جديدة؟",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#0d6efd',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'نعم، حفظ',
                cancelButtonText: 'إلغاء'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('avatarForm').submit();
                }
            });
        }
    }
</script>
@endpush
@endsection
