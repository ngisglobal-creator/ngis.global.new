<div class="row g-4">
    <!-- User Information & Security -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm" style="border-radius: 15px;">
            <div class="card-header bg-white border-bottom-0 pt-4 px-4">
                <h4 class="fw-bold text-dark mb-0"><i class="fa-solid fa-user-gear me-2 text-primary"></i> {{ __('dashboard.personal_info') ?? 'المعلومات الشخصية' }}</h4>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('patch')
                    
                    <!-- Avatar Preview & Upload -->
                    <div class="text-center mb-4">
                        <div class="position-relative d-inline-block">
                            <div class="avatar-wrapper shadow-sm" style="width: 130px; height: 130px; border-radius: 50%; padding: 5px; background: #fff; border: 2px solid #f8f9fa;">
                                <img id="avatar-preview" src="{{ $user->avatar ? \Illuminate\Support\Facades\Storage::url($user->avatar) : asset('dist/img/user4-128x128.jpg') }}" 
                                     alt="User Avatar" class="rounded-circle w-100 h-100" style="object-fit: cover;">
                            </div>
                            <button type="button" class="btn btn-primary btn-sm position-absolute bottom-0 end-0 rounded-circle shadow" 
                                    style="width: 35px; height: 35px; padding: 0;" onclick="document.getElementById('avatar_input').click();">
                                <i class="fa-solid fa-camera"></i>
                            </button>
                        </div>
                        <input type="file" name="avatar" id="avatar_input" class="d-none" accept="image/*">
                        <p class="text-muted small mt-2">{{ __('dashboard.change_photo') ?? 'تغيير الصورة الشخصية' }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">{{ __('dashboard.name') ?? 'الاسم الكامل' }}</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="fa-solid fa-user text-muted"></i></span>
                            <input type="text" name="name" class="form-control bg-light border-0 py-2" value="{{ old('name', $user->name) }}" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">{{ __('dashboard.email') ?? 'البريد الإلكتروني' }}</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="fa-solid fa-envelope text-muted"></i></span>
                            <input type="email" name="email" class="form-control bg-light border-0 py-2" value="{{ old('email', $user->email) }}" required>
                        </div>
                    </div>

                    <div class="bg-light rounded-3 p-3 mb-4">
                        <h5 class="fw-bold text-dark mb-2"><i class="fa-solid fa-key me-2 text-warning"></i> {{ __('dashboard.change_password') ?? 'تغيير كلمة المرور' }}</h5>
                        <p class="text-muted small mb-3">{{ __('dashboard.password_hint') ?? 'اترك الحقول فارغة إذا كنت لا ترغب في التغيير' }}</p>
                        
                        <div class="mb-3">
                            <label class="form-label small fw-bold">{{ __('dashboard.new_password') ?? 'كلمة المرور الجديدة' }}</label>
                            <input type="password" name="password" class="form-control border-0 py-2 shadow-sm">
                        </div>

                        <div class="mb-0">
                            <label class="form-label small fw-bold">{{ __('dashboard.confirm_password') ?? 'تأكيد كلمة المرور' }}</label>
                            <input type="password" name="password_confirmation" class="form-control border-0 py-2 shadow-sm">
                        </div>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary py-3 fw-bold shadow-sm" style="border-radius: 12px;">
                            <i class="fa-solid fa-floppy-disk me-2"></i> {{ __('dashboard.save') ?? 'حفظ التغييرات' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Documents & Certificates -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm" style="border-radius: 15px;">
            <div class="card-header bg-white border-bottom-0 pt-4 px-4">
                <h4 class="fw-bold text-dark mb-0"><i class="fa-solid fa-file-shield me-2 text-success"></i> {{ __('dashboard.documents_and_certs') ?? 'الوثائق والشهادات' }}</h4>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('patch')
                    <input type="hidden" name="name" value="{{ $user->name }}">
                    <input type="hidden" name="email" value="{{ $user->email }}">

                    <!-- PDF Upload -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">{{ __('dashboard.document_pdf') ?? 'ملف PDF الشخصي' }}</label>
                        <div class="custom-file-upload border-dashed p-4 text-center rounded-3 bg-light" style="border: 2px dashed #ddd; cursor: pointer;" onclick="document.getElementById('pdf_input').click();">
                            <i class="fa-solid fa-file-pdf text-danger fs-1 mb-2"></i>
                            <p class="mb-0 text-muted">{{ __('dashboard.click_to_upload') ?? 'اضغط لرفع ملف PDF' }}</p>
                            <input type="file" name="document_pdf" id="pdf_input" class="d-none" accept="application/pdf">
                        </div>
                        <div id="pdf-preview-info" class="mt-3">
                            @if($user->document_pdf)
                                <div class="d-flex align-items-center justify-content-between p-3 bg-white border rounded shadow-sm">
                                    <div class="d-flex align-items-center">
                                        <i class="fa-solid fa-file-pdf text-danger fs-4 me-3"></i> 
                                        <span class="fw-bold small text-truncate" style="max-width: 200px;">{{ basename($user->document_pdf) }}</span>
                                    </div>
                                    <a href="{{ \Illuminate\Support\Facades\Storage::url($user->document_pdf) }}" target="_blank" class="btn btn-outline-info btn-sm rounded-pill px-3">
                                        <i class="fa-solid fa-eye"></i> عرض
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <hr class="opacity-10 my-4">
                    
                    @if($user->type !== 'admin')
                        <!-- Passport Upload -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">{{ __('dashboard.passport') ?? 'جواز السفر (صورة أو PDF)' }}</label>
                            <input type="file" name="passport" id="passport_input" class="form-control bg-light border-0 py-2 mb-3" accept="image/*,application/pdf">
                            <div id="passport-preview-info">
                                @if($user->passport)
                                    @php $isPdf = Str::endsWith($user->passport, '.pdf'); @endphp
                                    <div class="p-3 bg-white border rounded shadow-sm">
                                        <div class="d-flex align-items-center justify-content-between mb-3">
                                            <div class="d-flex align-items-center">
                                                <i class="fa-solid {{ $isPdf ? 'fa-file-pdf text-danger' : 'fa-image text-primary' }} fs-4 me-3"></i>
                                                <span class="fw-bold small text-truncate" style="max-width: 200px;">{{ basename($user->passport) }}</span>
                                            </div>
                                            <a href="{{ \Illuminate\Support\Facades\Storage::url($user->passport) }}" target="_blank" class="btn btn-outline-info btn-sm rounded-pill px-3">
                                                <i class="fa-solid fa-eye"></i> عرض
                                            </a>
                                        </div>
                                        @if(!$isPdf)
                                            <img src="{{ \Illuminate\Support\Facades\Storage::url($user->passport) }}" class="img-fluid rounded" style="max-height: 150px; width: 100%; object-fit: cover;">
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                        <hr class="opacity-10 my-4">
                    @endif

                    <!-- Certificates Multi-Upload -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">{{ __('dashboard.certificates') ?? 'الشهادات (صور متعددة)' }}</label>
                        <input type="file" name="certificates[]" id="certificates_input" class="form-control bg-light border-0 py-2" multiple accept="image/*">
                        <p class="text-muted x-small mt-1"><i class="fa-solid fa-circle-info me-1"></i> {{ __('dashboard.multi_upload_hint') ?? 'يمكنك اختيار أكثر من صورة في وقت واحد' }}</p>
                        
                        <div id="certificates-preview-container" class="row g-2 mt-2">
                            @if($user->certificates && count($user->certificates) > 0)
                                @foreach($user->certificates as $cert)
                                    <div class="col-4">
                                        <div class="ratio ratio-1x1 shadow-sm rounded overflow-hidden position-relative group">
                                            <img src="{{ \Illuminate\Support\Facades\Storage::url($cert) }}" class="img-fluid object-fit-cover" style="cursor: pointer;" onclick="window.open(this.src, '_blank')">
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <div class="d-grid mt-5">
                        <button type="submit" class="btn btn-success py-3 fw-bold shadow-sm" style="border-radius: 12px;">
                            <i class="fa-solid fa-cloud-arrow-up me-2"></i> {{ __('dashboard.upload_files') ?? 'تحديث الوثائق' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Avatar Preview
document.getElementById('avatar_input').addEventListener('change', function(e) {
    const reader = new FileReader();
    reader.onload = function(e) {
        document.getElementById('avatar-preview').src = e.target.result;
    }
    if (this.files && this.files[0]) {
        reader.readAsDataURL(this.files[0]);
    }
});

// PDF Preview Info
document.getElementById('pdf_input').addEventListener('change', function(e) {
    const container = document.getElementById('pdf-preview-info');
    if (this.files && this.files[0]) {
        container.innerHTML = `
            <div class="alert alert-info border-0 shadow-sm d-flex align-items-center py-2 px-3" style="border-radius: 10px;">
                <i class="fa-solid fa-file-circle-check me-2"></i> 
                <span class="small">${this.files[0].name} (قيد الرفع...)</span>
            </div>
        `;
    }
});

// Passport Preview Info
const passportInput = document.getElementById('passport_input');
if (passportInput) {
    passportInput.addEventListener('change', function(e) {
        const container = document.getElementById('passport-preview-info');
        if (this.files && this.files[0]) {
            const file = this.files[0];
            const isPdf = file.type === 'application/pdf';
            
            let previewHtml = `
                <div class="alert alert-info border-0 shadow-sm d-flex align-items-center py-2 px-3 mb-3" style="border-radius: 10px;">
                    <i class="fa-solid ${isPdf ? 'fa-file-pdf' : 'fa-image'} me-2"></i> 
                    <span class="small">${file.name} (قيد الرفع...)</span>
                </div>
            `;
            
            if (!isPdf && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewHtml += `
                        <div class="rounded overflow-hidden shadow-sm">
                            <img src="${e.target.result}" class="img-fluid" style="max-height: 150px; width: 100%; object-fit: cover;">
                        </div>
                    `;
                    container.innerHTML = previewHtml;
                }
                reader.readAsDataURL(file);
            } else {
                container.innerHTML = previewHtml;
            }
        }
    });
}

// Certificates Multi-Preview
document.getElementById('certificates_input').addEventListener('change', function(e) {
    const container = document.getElementById('certificates-preview-container');
    container.innerHTML = ''; // Clear existing
    
    if (this.files) {
        Array.from(this.files).forEach(file => {
            if (!file.type.startsWith('image/')) return;
            
            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'col-4';
                div.innerHTML = `
                    <div class="ratio ratio-1x1 shadow-sm rounded overflow-hidden">
                        <img src="${e.target.result}" class="img-fluid object-fit-cover">
                    </div>
                `;
                container.appendChild(div);
            }
            reader.readAsDataURL(file);
        });
    }
});
</script>
@endpush
