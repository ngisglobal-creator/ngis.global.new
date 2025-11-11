@extends('layouts.master')

@section('title', 'إضافة دور جديد')

@section('content')
<section class="content-header">
  <h1>إضافة دور جديد</h1>
</section>

<section class="content">
  <div class="box box-success">
    <div class="box-body">
      <form action="{{ route('roles.store') }}" method="POST">
        @csrf

        <div class="form-group">
          <label>اسم الدور</label>
          <input type="text" name="name" class="form-control" required>
        </div>

        <div class="form-group">
          <label>الصلاحيات (چند انتخابی)</label>
          <select name="permissions[]" class="form-control select2" multiple="multiple" data-placeholder="اختر صلاحية أو أكثر" style="width: 100%;">
            @foreach($permissions as $perm)
              <option value="{{ $perm->name }}">{{ $perm->name }}</option>
            @endforeach
          </select>
        </div>

        <button class="mt-2 btn btn-success"><i class="fa fa-save"></i> حفظ</button>
        <a href="{{ route('roles.index') }}" class="mt-2 btn btn-default">رجوع</a>
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
    });
</script>
@endpush
