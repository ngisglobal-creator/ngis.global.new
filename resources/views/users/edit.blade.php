@extends('layouts.master')

@section('title', 'إضافة مستخدم جديد')

@section('content')
<section class="content-header">
  <h1>إضافة مستخدم جديد</h1>
</section>

<section class="content">
  <div class="box box-success">
    <div class="box-body">

      <!-- عرض رسالة flash -->
      @if(session('success'))
        <div class="alert alert-success alert-dismissible">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          {{ session('success') }}
        </div>
      @endif

      <form action="{{ route('users.store') }}" method="POST">
        @csrf

        <div class="mt-2 form-group">
            <label>الاسم</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mt-2 form-group">
            <label>البريد الإلكتروني</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mt-2 form-group">
            <label>كلمة المرور</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mt-2 form-group">
            <label>تأكيد كلمة المرور</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>

        <div class="mt-2 form-group">
            <label>الأدوار</label>
            <div class="mb-1">
              <button type="button" id="selectAllRoles" class="btn btn-sm btn-info">اختيار الكل</button>
              <button type="button" id="deselectAllRoles" class="btn btn-sm btn-warning">إلغاء الكل</button>
            </div>
            <select name="roles[]" class="form-control select2" multiple="multiple" data-placeholder="اختر دورًا أو أكثر" style="width: 100%;">
                @foreach($roles as $role)
                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mt-2 form-group">
            <label>الصلاحيات</label>
            <div class="mb-1">
              <button type="button" id="selectAllPerms" class="btn btn-sm btn-info">اختيار الكل</button>
              <button type="button" id="deselectAllPerms" class="btn btn-sm btn-warning">إلغاء الكل</button>
            </div>
            <select name="permissions[]" class="form-control select2" multiple="multiple" data-placeholder="اختر صلاحية أو أكثر" style="width: 100%;">
                @foreach($permissions as $perm)
                    <option value="{{ $perm->name }}">{{ $perm->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="mt-2 btn btn-success"><i class="fa fa-save"></i> إنشاء المستخدم</button>
      </form>
    </div>
  </div>
</section>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('.select2').select2({
        placeholder: $(this).data('placeholder'),
        allowClear: true
    });

    // اختيار الكل للأدوار
    $('#selectAllRoles').click(function() {
        var allOptions = $('.select2[name="roles[]"] option');
        allOptions.prop('selected', true);
        $('.select2[name="roles[]"]').trigger('change');
    });

    // إلغاء الكل للأدوار
    $('#deselectAllRoles').click(function() {
        var allOptions = $('.select2[name="roles[]"] option');
        allOptions.prop('selected', false);
        $('.select2[name="roles[]"]').trigger('change');
    });

    // اختيار الكل للصلاحيات
    $('#selectAllPerms').click(function() {
        var allOptions = $('.select2[name="permissions[]"] option');
        allOptions.prop('selected', true);
        $('.select2[name="permissions[]"]').trigger('change');
    });

    // إلغاء الكل للصلاحيات
    $('#deselectAllPerms').click(function() {
        var allOptions = $('.select2[name="permissions[]"] option');
        allOptions.prop('selected', false);
        $('.select2[name="permissions[]"]').trigger('change');
    });
});
</script>
@endpush
  