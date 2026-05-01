<div class="row">
  <!-- User Information & Security -->
  <div class="col-md-6">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">{{ __('dashboard.personal_info') ?? 'Personal Information' }}</h3>
      </div>
      <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('patch')
        <div class="box-body">
          <!-- Avatar Preview & Upload -->
          <div class="form-group text-center">
            <div class="avatar-container" style="margin-bottom: 15px;">
              <img id="avatar-preview" src="{{ $user->avatar ? \Illuminate\Support\Facades\Storage::url($user->avatar) : asset('dist/img/user4-128x128.jpg') }}" 
                   alt="User Avatar" class="img-circle img-thumbnail" style="width: 120px; height: 120px; object-fit: cover;">
            </div>
            <input type="file" name="avatar" id="avatar_input" class="hidden" accept="image/*">
            <button type="button" class="btn btn-default btn-sm" onclick="document.getElementById('avatar_input').click();">
              <i class="fa fa-camera"></i> {{ __('dashboard.change_photo') ?? 'Change Photo' }}
            </button>
          </div>

          <div class="form-group">
            <label>{{ __('dashboard.name') ?? 'Name' }}</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
          </div>

          <div class="form-group">
            <label>{{ __('dashboard.email') ?? 'Email' }}</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
          </div>

          <hr>
          <h4>{{ __('dashboard.change_password') ?? 'Change Password' }}</h4>
          <p class="text-muted small">{{ __('dashboard.password_hint') ?? 'Leave blank if you do not want to change it' }}</p>
          
          <div class="form-group">
            <label>{{ __('dashboard.new_password') ?? 'New Password' }}</label>
            <input type="password" name="password" class="form-control">
          </div>

          <div class="form-group">
            <label>{{ __('dashboard.confirm_password') ?? 'Confirm Password' }}</label>
            <input type="password" name="password_confirmation" class="form-control">
          </div>
        </div>
        <div class="box-footer">
          <button type="submit" class="btn btn-primary pull-right">
            <i class="fa fa-save"></i> {{ __('dashboard.save') ?? 'Save Changes' }}
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- Documents & Certificates -->
  <div class="col-md-6">
    <div class="box box-success">
      <div class="box-header with-border">
        <h3 class="box-title">{{ __('dashboard.documents_and_certs') ?? 'Documents & Certificates' }}</h3>
      </div>
      <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('patch')
        <input type="hidden" name="name" value="{{ $user->name }}">
        <input type="hidden" name="email" value="{{ $user->email }}">

        <div class="box-body">
          <!-- PDF Upload -->
          <div class="form-group">
            <label>{{ __('dashboard.document_pdf') ?? 'PDF Document' }}</label>
            <input type="file" name="document_pdf" id="pdf_input" class="form-control" accept="application/pdf">
            <div id="pdf-preview-info" class="mt-2" style="margin-top: 10px;">
              @if($user->document_pdf)
                <div class="well well-sm">
                  <i class="fa fa-file-pdf-o text-danger" style="font-size: 20px;"></i> 
                  <span style="margin-left: 10px; font-weight: bold;">{{ basename($user->document_pdf) }}</span>
                  <a href="{{ \Illuminate\Support\Facades\Storage::url($user->document_pdf) }}" target="_blank" class="btn btn-info btn-xs pull-right">
                    <i class="fa fa-eye"></i> {{ __('dashboard.view_pdf') ?? 'View' }}
                  </a>
                </div>
              @endif
            </div>
          </div>

          <hr>
          
          @if($user->type !== 'admin')
            <!-- Passport Upload -->
            <div class="form-group">
              <label>{{ __('dashboard.passport') ?? 'Passport (Image or PDF)' }}</label>
              <input type="file" name="passport" id="passport_input" class="form-control" accept="image/*,application/pdf">
              <div id="passport-preview-info" class="mt-2" style="margin-top: 10px;">
                @if($user->passport)
                  @php $isPdf = Str::endsWith($user->passport, '.pdf'); @endphp
                  <div class="well well-sm">
                    @if($isPdf)
                      <i class="fa fa-file-pdf-o text-danger" style="font-size: 20px;"></i>
                    @else
                      <i class="fa fa-file-image-o text-primary" style="font-size: 20px;"></i>
                    @endif
                    <span style="margin-left: 10px; font-weight: bold;">{{ basename($user->passport) }}</span>
                    <a href="{{ \Illuminate\Support\Facades\Storage::url($user->passport) }}" target="_blank" class="btn btn-info btn-xs pull-right">
                      <i class="fa fa-eye"></i> {{ __('dashboard.view') ?? 'View' }}
                    </a>
                    @if(!$isPdf)
                      <div style="margin-top: 10px;">
                        <img src="{{ \Illuminate\Support\Facades\Storage::url($user->passport) }}" class="img-responsive img-thumbnail" style="max-height: 150px;">
                      </div>
                    @endif
                  </div>
                @endif
              </div>
            </div>
            <hr>
          @endif

          <!-- Certificates Multi-Upload -->
          <div class="form-group">
            <label>{{ __('dashboard.certificates') ?? 'Certificates (Multiple Images)' }}</label>
            <input type="file" name="certificates[]" id="certificates_input" class="form-control" multiple accept="image/*">
            <p class="help-block">{{ __('dashboard.multi_upload_hint') ?? 'You can select more than one image' }}</p>
            
            <div id="certificates-preview-container" class="row mt-3" style="margin-top: 15px;">
              @if($user->certificates && count($user->certificates) > 0)
                @foreach($user->certificates as $cert)
                  <div class="col-xs-4 mb-2" style="margin-bottom: 15px;">
                    <a href="{{ \Illuminate\Support\Facades\Storage::url($cert) }}" target="_blank">
                      <img src="{{ \Illuminate\Support\Facades\Storage::url($cert) }}" class="img-responsive img-thumbnail" style="height: 100px; width: 100%; object-fit: cover; cursor: pointer;">
                    </a>
                  </div>
                @endforeach
              @endif
            </div>
          </div>
        </div>
        <div class="box-footer">
          <button type="submit" class="btn btn-success pull-right">
            <i class="fa fa-upload"></i> {{ __('dashboard.upload_files') ?? 'Upload Files' }}
          </button>
        </div>
      </form>
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
            <div class="alert alert-info alert-dismissible" style="padding: 5px 30px 5px 10px; margin-bottom: 0;">
                <i class="fa fa-file-pdf-o"></i> ${this.files[0].name} (قيد الرفع...)
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
                <div class="alert alert-info alert-dismissible" style="padding: 5px 30px 5px 10px; margin-bottom: 0;">
                    <i class="fa ${isPdf ? 'fa-file-pdf-o' : 'fa-file-image-o'}"></i> ${file.name} (قيد الرفع...)
                </div>
            `;
            
            if (!isPdf && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewHtml += `
                        <div style="margin-top: 10px;">
                            <img src="${e.target.result}" class="img-responsive img-thumbnail" style="max-height: 150px;">
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
                div.className = 'col-xs-4 mb-2';
                div.style.marginBottom = '10px';
                div.innerHTML = `
                    <img src="${e.target.result}" class="img-responsive img-thumbnail" 
                         style="height: 100px; width: 100%; object-fit: cover;">
                `;
                container.appendChild(div);
            }
            reader.readAsDataURL(file);
        });
    }
});
</script>
@endpush
