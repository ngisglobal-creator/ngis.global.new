@extends('layouts.master')

@section('title', 'تعديل الفرع')

@section('content')
<section class="content-header">
  <h1>
    إدارة فروع القطاعات
    <small>تعديل الفرع</small>
  </h1>
</section>

<section class="content">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">تعديل الفرع: {{ $branch->name_ar }}</h3>
    </div>
    <form action="{{ route('admin.branches.update', $branch->id) }}" method="POST">
      @csrf
      @method('PUT')
      <div class="box-body">
        <div class="form-group">
          <label for="sector_id">القطاع الرئيسي</label>
          <select name="sector_id" id="sector_id" class="form-control" required>
            @foreach($sectors as $sector)
              <option value="{{ $sector->id }}" {{ $branch->sector_id == $sector->id ? 'selected' : '' }}>
                {{ $sector->name_ar }} ({{ $sector->name_en }})
              </option>
            @endforeach
          </select>
        </div>
        <div class="form-group">
          <label for="name_ar">الاسم (باللغة العربية)</label>
          <input type="text" name="name_ar" class="form-control" id="name_ar" value="{{ $branch->name_ar }}" required>
        </div>
        <div class="form-group">
          <label for="name_en">الاسم (باللغة الإنجليزية)</label>
          <input type="text" name="name_en" class="form-control" id="name_en" value="{{ $branch->name_en }}" required>
        </div>
        <div class="form-group">
          <label for="name_zh">الاسم (باللغة الصينية)</label>
          <input type="text" name="name_zh" class="form-control" id="name_zh" value="{{ $branch->name_zh }}" required>
        </div>
      </div>
      <div class="box-footer">
        <button type="submit" class="btn btn-primary">تحديث</button>
        <a href="{{ route('admin.branches.index') }}" class="btn btn-default">إلغاء</a>
      </div>
    </form>
  </div>
</section>
@endsection
