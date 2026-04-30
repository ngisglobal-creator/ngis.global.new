@extends('layouts.master')

@section('title', 'إضافة دولة جديدة')

@section('content')
<section class="content-header">
    <h1>
        إضافة دولة
        <small>إنشاء سجل جديد</small>
    </h1>
</section>

<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">بيانات الدولة</h3>
        </div>
        <form action="{{ route('admin.countries.store') }}" method="POST">
            @csrf
            <div class="box-body">
                <div class="form-group @error('name_ar') has-error @enderror">
                    <label>الاسم بالعربية</label>
                    <input type="text" name="name_ar" class="form-control" value="{{ old('name_ar') }}" required>
                    @error('name_ar') <span class="help-block">{{ $message }}</span> @enderror
                </div>
                <div class="form-group @error('name_en') has-error @enderror">
                    <label>الاسم بالإنجليزية</label>
                    <input type="text" name="name_en" class="form-control" value="{{ old('name_en') }}" required>
                    @error('name_en') <span class="help-block">{{ $message }}</span> @enderror
                </div>
                <div class="form-group @error('name_zh') has-error @enderror">
                    <label>الاسم بالصينية</label>
                    <input type="text" name="name_zh" class="form-control" value="{{ old('name_zh') }}" required>
                    @error('name_zh') <span class="help-block">{{ $message }}</span> @enderror
                </div>
                <div class="form-group @error('flag_code') has-error @enderror">
                    <label>رمز الدولة (ISO code - حرفين)</label>
                    <input type="text" name="flag_code" class="form-control" value="{{ old('flag_code') }}" placeholder="مثال: eg, us, cn" required maxlength="2">
                    @error('flag_code') <span class="help-block">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary">حفظ</button>
                <a href="{{ route('admin.countries.index') }}" class="btn btn-default">إلغاء</a>
            </div>
        </form>
    </div>
</section>
@endsection
