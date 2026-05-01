@extends('layouts.master')

@section('title', 'تعديل القسم')

@section('content')
<section class="content-header">
  <h1>
    إدارة الأقسام
    <small>تعديل القسم</small>
  </h1>
</section>

<section class="content">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">تعديل القسم: {{ $category->name_ar }}</h3>
    </div>
    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
      @csrf
      @method('PUT')
      <div class="box-body">
        <div class="form-group">
          <label for="branch_id">الفرع</label>
          <select name="branch_id" id="branch_id" class="form-control" required>
            @foreach($branches as $branch)
              <option value="{{ $branch->id }}" {{ $category->branch_id == $branch->id ? 'selected' : '' }}>
                {{ $branch->name_ar }} ({{ $branch->name_en }})
              </option>
            @endforeach
          </select>
        </div>
        <div class="form-group">
          <label for="parent_id">القسم الأب (اختياري)</label>
          <select name="parent_id" id="parent_id" class="form-control">
            <option value="">بدون (قسم رئيسي)</option>
            @foreach($parentCategories as $parent)
              <option value="{{ $parent->id }}" {{ $category->parent_id == $parent->id ? 'selected' : '' }}>
                {{ $parent->name_ar }} ({{ $parent->name_en }})
              </option>
            @endforeach
          </select>
        </div>
        <div class="form-group">
          <label for="name_ar">الاسم (باللغة العربية)</label>
          <input type="text" name="name_ar" class="form-control" id="name_ar" value="{{ $category->name_ar }}" required>
        </div>
        <div class="form-group">
          <label for="name_en">الاسم (باللغة الإنجليزية)</label>
          <input type="text" name="name_en" class="form-control" id="name_en" value="{{ $category->name_en }}" required>
        </div>
        <div class="form-group">
          <label for="name_zh">الاسم (باللغة الصينية)</label>
          <input type="text" name="name_zh" class="form-control" id="name_zh" value="{{ $category->name_zh }}" required>
        </div>
      </div>
      <div class="box-footer">
        <button type="submit" class="btn btn-primary">تحديث</button>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-default">إلغاء</a>
      </div>
    </form>
  </div>
</section>
@endsection
