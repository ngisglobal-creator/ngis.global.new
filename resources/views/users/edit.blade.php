@extends('layouts.master')

@section('title', 'تعديل المستخدم: ' . $user->name)

@section('content')
<style>
  /* Package Cards */
  .package-card {
    border: 2px solid #ddd;
    border-radius: 8px;
    padding: 10px;
    cursor: pointer;
    transition: all 0.3s;
    height: 100%;
    position: relative;
    background: #fff;
  }
  .package-card:hover {
    border-color: #3c8dbc;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
  }
  .package-card.selected {
    border-color: #00a65a;
    background-color: #f0fff4;
  }
  .package-card.selected::after {
    content: '\f058';
    font-family: 'FontAwesome';
    position: absolute;
    top: 5px;
    right: 5px;
    color: #00a65a;
    font-size: 20px;
  }
  .package-card img {
    width: 100%;
    height: 100px;
    object-fit: contain;
    margin-bottom: 10px;
  }
  .package-card .title {
    font-weight: bold;
    display: block;
    margin-bottom: 5px;
    text-align: center;
    font-size: 13px;
  }
  
  /* Star Rating */
  .star-rating {
    direction: rtl;
    display: inline-block;
  }
  .star-rating input {
    display: none;
  }
  .star-rating label {
    color: #bbb;
    font-size: 25px;
    padding: 0 2px;
    cursor: pointer;
    transition: all .3s ease-in-out;
  }
  .star-rating label:hover,
  .star-rating label:hover ~ label,
  .star-rating input:checked ~ label {
    color: #f2b600;
  }
</style>

<section class="content-header">
  <h1>تعديل المستخدم: <strong>{{ $user->name }}</strong></h1>
</section>

<section class="content">
  <div class="box box-success">
    <div class="box-body">

      @if(session('success'))
        <div class="alert alert-success alert-dismissible">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          {{ session('success') }}
        </div>
      @endif

      @if($errors->any())
        <div class="alert alert-danger alert-dismissible">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <ul class="mb-0">
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
          <div class="col-md-3 text-center">
            <div class="form-group">
              <label style="display: block;">الصورة الشخصية</label>
              <div class="avatar-upload" style="position: relative; display: inline-block;">
                <div class="avatar-preview" style="width: 150px; height: 150px; border-radius: 50%; border: 3px solid #f8f9fa; box-shadow: 0 0 10px rgba(0,0,0,0.1); overflow: hidden; background: #eee; margin-bottom: 10px;">
                  <img id="imagePreview" src="{{ $user->avatar_url }}" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
                <div class="avatar-edit" style="position: absolute; bottom: 15px; right: 5px;">
                  <input type='file' name="avatar" id="avatarUpload" accept=".png, .jpg, .jpeg" style="display: none;" />
                  <label for="avatarUpload" style="padding: 8px; background: #fff; border-radius: 50%; box-shadow: 0 2px 5px rgba(0,0,0,0.1); border: 1px solid #ddd; cursor: pointer; transition: all .2s ease-in-out;">
                    <i class="fa fa-camera text-primary"></i>
                  </label>
                </div>
              </div>
              <p class="text-muted small">JPG, PNG أو GIF (حد أقصى 2MB)</p>
            </div>
          </div>

          <div class="col-md-9">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label>الاسم</label>
                  <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required placeholder="أدخل اسم المستخدم">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>البريد الإلكتروني</label>
                  <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required placeholder="example@domain.com">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>البلاد</label>
                  <select name="country_id" id="country_id" class="form-control select2-countries">
                    <option value="">-- اختر البلاد --</option>
                    @foreach($countries as $country)
                      <option value="{{ $country->id }}" data-flag="{{ asset('vendor/flag-icons/flags/4x3/' . $country->flag_code . '.svg') }}" {{ old('country_id', $user->country_id) == $country->id ? 'selected' : '' }}>{{ $country->name_ar }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>كلمة المرور <small class="text-muted">(اتركها فارغة إذا لم تكن تريد تغييرها)</small></label>
                  <input type="password" name="password" class="form-control" placeholder="******">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>تأكيد كلمة المرور</label>
                  <input type="password" name="password_confirmation" class="form-control" placeholder="******">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>نوع المستخدم</label>
                  <select name="type" id="user_type" class="form-control" required>
                    <option value="">-- اختر النوع --</option>
                    @foreach($types as $key => $label)
                      <option value="{{ $key }}" {{ old('type', $user->type) == $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-6" id="stars_group" style="display: none;">
                <div class="form-group">
                  <label style="display: block;">التقييم (النجوم)</label>
                  <div class="star-rating">
                    @php $currentStars = old('stars', $user->stars); @endphp
                    <input type="radio" id="star5" name="stars" value="5" {{ $currentStars == 5 ? 'checked' : '' }} />
                    <label for="star5" title="5 stars"><i class="fa fa-star"></i></label>
                    <input type="radio" id="star4" name="stars" value="4" {{ $currentStars == 4 ? 'checked' : '' }} />
                    <label for="star4" title="4 stars"><i class="fa fa-star"></i></label>
                    <input type="radio" id="star3" name="stars" value="3" {{ $currentStars == 3 ? 'checked' : '' }} />
                    <label for="star3" title="3 stars"><i class="fa fa-star"></i></label>
                    <input type="radio" id="star2" name="stars" value="2" {{ $currentStars == 2 ? 'checked' : '' }} />
                    <label for="star2" title="2 stars"><i class="fa fa-star"></i></label>
                    <input type="radio" id="star1" name="stars" value="1" {{ $currentStars == 1 ? 'checked' : '' }} />
                    <label for="star1" title="1 star"><i class="fa fa-star"></i></label>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row" style="margin-top: 15px;">
           <!-- Package Visual Selection -->
          <div id="package_group" class="col-md-12" style="display: none;">
            <h4 class="page-header" style="margin-top: 5px; font-size: 16px; border-bottom: 1px solid #eee; padding-bottom: 5px;"><i class="fa fa-cubes text-success"></i> اختر الباقة</h4>
            <input type="hidden" name="package_id" id="selected_package_id" value="{{ old('package_id', $user->package_id) }}">
            <div class="row">
              @foreach($packages as $package)
              <div class="col-md-2 col-sm-4 col-xs-6 package-item" data-type="{{ $package->type }}" style="margin-bottom: 15px;">
                @php $selectedPackageId = old('package_id', $user->package_id); @endphp
                <div class="package-card {{ $selectedPackageId == $package->id ? 'selected' : '' }}" 
                     onclick="selectPackage({{ $package->id }}, this)">
                  <img src="{{ $package->image_url }}" alt="{{ $package->title_ar }}">
                  <span class="title">{{ $package->title_ar }}</span>
                </div>
              </div>
              @endforeach
            </div>
          </div>
        </div>

        <div class="row" style="margin-top: 10px;">
          <div class="col-md-6">
            <div class="form-group">
              <label>الأدوار (Roles)</label>
              <div class="mb-1">
                <button type="button" id="selectAllRoles" class="btn btn-xs btn-default mb-1">الكل</button>
                <button type="button" id="deselectAllRoles" class="btn btn-xs btn-default mb-1">إلغاء</button>
              </div>
              <select name="roles[]" class="form-control select2" multiple="multiple" style="width:100%;">
                @foreach($roles as $role)
                  @php $userRoles = old('roles', $user->getRoleNames()->toArray()); @endphp
                  <option value="{{ $role->name }}" {{ in_array($role->name, $userRoles) ? 'selected' : '' }}>{{ $role->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label>الصلاحيات (Permissions)</label>
              <div class="mb-1">
                <button type="button" id="selectAllPerms" class="btn btn-xs btn-default mb-1">الكل</button>
                <button type="button" id="deselectAllPerms" class="btn btn-xs btn-default mb-1">إلغاء</button>
              </div>
              <select name="permissions[]" class="form-control select2" multiple="multiple" style="width:100%;">
                @foreach($permissions as $perm)
                  @php $userPerms = old('permissions', $user->getDirectPermissions()->pluck('name')->toArray()); @endphp
                  <option value="{{ $perm->name }}" {{ in_array($perm->name, $userPerms) ? 'selected' : '' }}>{{ $perm->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
        </div>

        <div class="box-footer text-left" style="background: transparent; border-top: 1px solid #f4f4f4; padding: 20px 0 0 0;">
          <button type="submit" class="btn btn-success btn-lg px-5"><i class="fa fa-save"></i> حفظ التعديلات</button>
          <a href="{{ route('admin.users.index') }}" class="btn btn-default btn-lg px-5">إلغاء</a>
        </div>
      </form>

    </div>
  </div>
</section>
@endsection

@push('scripts')
<script>
function selectPackage(id, element) {
    document.querySelectorAll('.package-card').forEach(card => card.classList.remove('selected'));
    element.classList.add('selected');
    document.getElementById('selected_package_id').value = id;
}

$(document).ready(function() {
    $('.select2').select2({ allowClear: true });

    // Image Preview
    $("#avatarUpload").change(function() {
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#imagePreview').attr('src', e.target.result);
                $('#imagePreview').hide();
                $('#imagePreview').fadeIn(650);
            }
            reader.readAsDataURL(this.files[0]);
        }
    });

    $('#selectAllRoles').click(function() {
        $('select[name="roles[]"] option').prop('selected', true).parent().trigger('change');
    });
    $('#deselectAllRoles').click(function() {
        $('select[name="roles[]"] option').prop('selected', false).parent().trigger('change');
    });
    $('#selectAllPerms').click(function() {
        $('select[name="permissions[]"] option').prop('selected', true).parent().trigger('change');
    });
    $('#deselectAllPerms').click(function() {
        $('select[name="permissions[]"] option').prop('selected', false).parent().trigger('change');
    });

    function filterPackages() {
        const selectedType = $('#user_type').val();
        const $packageGroup = $('#package_group');
        const $starsGroup = $('#stars_group');

        if (['client', 'company', 'factory'].includes(selectedType)) {
            $packageGroup.show();
            $starsGroup.show();
            
            $('.package-item').each(function() {
                if ($(this).data('type') === selectedType) {
                    $(this).show();
                } else {
                    $(this).hide();
                    const $card = $(this).find('.package-card');
                    if ($card.hasClass('selected')) {
                        $card.removeClass('selected');
                        if (!$('#selected_package_id').val() == $(this).val()) {
                             // Only clear if the hidden value matches this hidden card (conceptually)
                             // Actually, simpler: if the card is hidden, it shouldn't be the selected one.
                        }
                    }
                }
            });
        } else {
            $packageGroup.hide();
            $starsGroup.hide();
            $('#selected_package_id').val('');
        }
    }

    function formatCountry(option) {
        if (!option.id) return option.text;
        var flag = $(option.element).data('flag');
        return $('<span style="display: flex; align-items: center; gap: 8px;"><img src="' + flag + '" style="width: 20px; height: 15px;"> ' + option.text + '</span>');
    }

    $('.select2-countries').select2({
        placeholder: '-- اختر البلاد --',
        allowClear: true,
        dir: 'rtl',
        templateResult: formatCountry,
        templateSelection: formatCountry
    });

    $('#user_type').on('change', filterPackages);
    filterPackages();
});
</script>
@endpush