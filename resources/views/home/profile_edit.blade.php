@extends('layouts.luxe')

@section('styles')
    <style>
        .edit-header-lux {
            background: linear-gradient(rgba(5, 13, 31, 0.8), rgba(5, 13, 31, 1)), url('{{ $user->cover_image ? asset('storage/' . $user->cover_image) : 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&q=80&w=2000' }}');
            background-size: cover;
            background-position: center;
            padding: 80px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }
        .avatar-edit-wrapper {
            position: relative;
            width: 150px;
            height: 150px;
            margin: 0 auto;
            border: 4px solid var(--gold-mid);
            border-radius: 50%;
            overflow: hidden;
            box-shadow: 0 0 30px rgba(212, 175, 55, 0.2);
        }
        .avatar-edit-overlay {
            position: absolute;
            inset: 0;
            background: rgba(0,0,0,0.6);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: all 0.3s ease;
            cursor: pointer;
            color: #fff;
            gap: 5px;
        }
        .avatar-edit-wrapper:hover .avatar-edit-overlay {
            opacity: 1;
        }
        .form-section-lux {
            background: rgba(255, 255, 255, 0.02);
            backdrop-filter: blur(20px);
            border-radius: 32px;
            border: 1px solid rgba(255, 255, 255, 0.05);
            padding: 40px;
            margin-bottom: 35px;
        }
        .section-title-lux {
            font-size: 0.7rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: var(--gold-mid);
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .section-title-lux::after {
            content: '';
            flex: 1;
            height: 1px;
            background: rgba(255, 255, 255, 0.05);
        }

        .sticky-actions-lux {
            position: sticky;
            bottom: 30px;
            z-index: 1000;
            background: rgba(10, 20, 45, 0.8);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 25px;
            padding: 20px 30px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.5);
        }
    </style>
@endsection

@section('content')
    <form action="{{ route('home.profile.update', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <!-- Edit Hero -->
        <header class="edit-header-lux text-center">
            <div class="container">
                <div class="avatar-edit-wrapper mb-4">
                    <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) }}" class="w-100 h-100 object-fit-cover" id="avatarPreview">
                    <label class="avatar-edit-overlay">
                        <i class="ph-bold ph-camera fs-3"></i>
                        <span class="x-small fw-bold">EDIT AVATAR</span>
                        <input type="file" name="avatar" class="hidden" accept="image/*" onchange="previewImage(this, 'avatarPreview')">
                    </label>
                </div>
                <h1 class="display-6 fw-bold text-white mb-2 brand-name-premium" style="background: none; -webkit-background-clip: initial; color: white;">{{ $user->name }}</h1>
                <p class="text-gold small uppercase tracking-widest fw-bold">ELITE IDENTITY MANAGEMENT</p>
                
                <div class="mt-4">
                    <label class="btn btn-outline-light btn-sm px-4 rounded-pill border-opacity-25">
                        <i class="ph-bold ph-image me-2"></i>REPLACE COVER ASSET
                        <input type="file" name="cover_image" class="hidden" accept="image/*">
                    </label>
                </div>
            </div>
        </header>

        <div class="container py-5">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    
                    <!-- Basic Information -->
                    <div class="form-section-lux" data-aos="fade-up">
                        <h6 class="section-title-lux"><i class="ph-fill ph-identification-card"></i>STRATEGIC IDENTITY</h6>
                        <div class="row g-4">
                            <div class="col-12">
                                <span class="spec-label mb-2 d-block">PUBLIC ENTITY NAME</span>
                                <input type="text" name="name" value="{{ $user->name }}" class="form-control-lux w-100 font-premium">
                            </div>
                            <div class="col-md-6">
                                <span class="spec-label mb-2 d-block">OFFICIAL CHANNEL (READ-ONLY)</span>
                                <input type="text" value="{{ $user->email }}" class="form-control-lux w-100 opacity-50" readonly disabled>
                            </div>
                            <div class="col-md-6">
                                <span class="spec-label mb-2 d-block">DIRECT LINE / WHATSAPP</span>
                                <input type="text" name="phone" value="{{ $user->phone }}" class="form-control-lux w-100" placeholder="+86 ...">
                            </div>
                        </div>
                    </div>

                    <!-- About / Bio -->
                    <div class="form-section-lux" data-aos="fade-up" data-aos-delay="100">
                        <h6 class="section-title-lux"><i class="ph-fill ph-text-align-left"></i>CORPORATE PROFILE DNA</h6>
                        <div class="space-y-4">
                            <div class="mb-4">
                                <span class="spec-label mb-2 d-block">EXECUTIVE SUMMARY (ARABIC)</span>
                                <textarea name="about_ar" rows="5" class="form-control-lux w-100">{{ $user->about_ar }}</textarea>
                            </div>
                            <div>
                                <span class="spec-label mb-2 d-block">EXECUTIVE SUMMARY (ENGLISH)</span>
                                <textarea name="about_en" rows="5" class="form-control-lux w-100" dir="ltr">{{ $user->about_en }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Media & News -->
                    <div class="form-section-lux" data-aos="fade-up" data-aos-delay="200">
                        <h6 class="section-title-lux"><i class="ph-fill ph-images"></i>DIGITAL ASSET MANAGEMENT</h6>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <span class="spec-label mb-2 d-block">FACILITY GALLERY (IMAGE BATCH)</span>
                                <input type="file" name="gallery_images[]" multiple class="form-control-lux w-100 py-2" accept="image/*">
                                <small class="text-white opacity-25 mt-2 d-block x-small">Upload high-resolution images of production floors & infrastructure.</small>
                            </div>
                            <div class="col-md-6">
                                <span class="spec-label mb-2 d-block">CORPORATE SHOWREEL (VIDEO)</span>
                                <input type="file" name="profile_video" class="form-control-lux w-100 py-2" accept="video/*">
                                <small class="text-white opacity-25 mt-2 d-block x-small">Max resolution cinematic overview of operations.</small>
                            </div>
                        </div>
                        
                        <div class="mt-5 p-5 rounded-4" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05);">
                            <h6 class="fw-bold text-white mb-4 x-small tracking-widest uppercase"><i class="ph ph-megaphone-simple me-2 text-gold"></i>INSTANT MARKET BROADCAST</h6>
                            <div class="row g-3">
                                <div class="col-12">
                                    <span class="spec-label mb-2 d-block">ANNOUNCEMENT TOPIC</span>
                                    <input type="text" name="news_title_ar" class="form-control-lux w-100" placeholder="Title of the strategic update...">
                                </div>
                                <div class="col-12">
                                    <span class="spec-label mb-2 d-block">BROADCAST CONTENT</span>
                                    <textarea name="news_content_ar" rows="3" class="form-control-lux w-100" placeholder="Details of the announcement..."></textarea>
                                </div>
                                <div class="col-12">
                                    <span class="spec-label mb-2 d-block">SUPPLEMENTARY VISUAL</span>
                                    <input type="file" name="news_images[]" class="form-control-lux w-100 py-2" accept="image/*">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="sticky-actions-lux mt-5">
                        <div class="d-flex gap-3 align-items-center">
                            <button type="submit" class="btn btn-gold btn-lg flex-grow-1 py-3 fw-bold">
                                <i class="ph-fill ph-floppy-disk me-2"></i>SYNCHRONIZE ALL CHANGES
                            </button>
                            <a href="{{ route('home.profile', $user->id) }}" class="btn btn-outline-light btn-lg px-5 py-3 border-opacity-25 x-small fw-bold">ABORT</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </form>
@endsection

@section('scripts')
<script>
    function previewImage(input, previewId) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById(previewId).src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
@endsection

@section('scripts')
<script>
    function previewImage(input, previewId) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById(previewId).src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
