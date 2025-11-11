@extends('layouts.master')

@section('title', 'تعديل الدور')

@section('content')
<section class="content-header">
  <h1>تعديل الدور: {{ $role->name }}</h1>
</section>

<section class="content">
  <div class="box box-warning">
    <div class="box-body">
      <form action="{{ route('roles.update', $role->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
          <label>اسم الدور</label>
          <input type="text" name="name" value="{{ $role->name }}" class="form-control" required>
        </div>

        <div class="form-group">
          <label>الصلاحيات (چند انتخابی)</label>
          <select name="permissions[]" class="form-control select2" multiple="multiple" data-placeholder="اختر صلاحية أو أكثر" style="width: 100%;">
            @foreach($permissions as $perm)
              <option value="{{ $perm->name }}" @if($role->hasPermissionTo($perm->name)) selected @endif>
                {{ $perm->name }}
              </option>
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
