@extends('layouts.master')

@section('title', 'تعديل حالة طلب')

@section('content')
<section class="content-header">
  <h1>
    تعديل حالة طلب
  </h1>
</section>

<section class="content">
  <div class="box box-primary">
    <form action="{{ route('admin.order-statuses.update', $orderStatus->id) }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')
      <div class="box-body">
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label>الاسم (عربي)</label>
              <input type="text" name="name_ar" class="form-control" value="{{ $orderStatus->name_ar }}" required>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>الاسم (EN)</label>
              <input type="text" name="name_en" class="form-control" value="{{ $orderStatus->name_en }}" required>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>الاسم (中文)</label>
              <input type="text" name="name_zh" class="form-control" value="{{ $orderStatus->name_zh }}" required>
            </div>
          </div>
        </div>

        <div class="form-group">
          <label>أيقونة / صورة الحالة</label>
          <input type="file" name="image" class="form-control">
          @if($orderStatus->image)
            <div class="mt-2">
              <img src="{{ asset('storage/' . $orderStatus->image) }}" alt="" style="width: 100px; height: 100px; object-fit: cover; margin-top: 10px; border: 1px solid #ddd;">
            </div>
          @endif
        </div>
      </div>

      <div class="box-footer">
        <button type="submit" class="btn btn-primary">تحديث</button>
        <a href="{{ route('admin.order-statuses.index') }}" class="btn btn-default">إلغاء</a>
      </div>
    </form>
  </div>
</section>
@endsection
