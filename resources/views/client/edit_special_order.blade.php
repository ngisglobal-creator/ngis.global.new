@extends('client.layouts.master')

@section('title', 'تعديل الطلب الخاص #' . $order->id)

@section('content')
<section class="content-header">
    <h1 style="font-weight: 900; color: #1a202c;">
        تعديل الطلب الخاص <small>#{{ $order->id }}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('client.dashboard') }}"><i class="fa fa-dashboard"></i> الرئيسية</a></li>
        <li><a href="{{ route('client.special_orders.index') }}">طلباتي الخاصة</a></li>
        <li class="active">تعديل</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <form action="{{ route('client.special_orders.update', $order->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <!-- 1. البيانات التعريفية -->
                <div class="box box-primary" style="border-radius: 15px;">
                    <div class="box-header with-border">
                        <h3 class="box-title">تعديل بيانات المنتج</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>اسم المنتج</label>
                                    <input type="text" name="title" class="form-control" value="{{ $order->title }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>تصنيف السلعة</label>
                                    <select name="category_type" class="form-control" required>
                                        <option value="industrial" {{ $order->category_type == 'industrial' ? 'selected' : '' }}>صناعي</option>
                                        <option value="commercial" {{ $order->category_type == 'commercial' ? 'selected' : '' }}>تجاري</option>
                                        <option value="raw_materials" {{ $order->category_type == 'raw_materials' ? 'selected' : '' }}>مواد خام</option>
                                        <option value="electronics" {{ $order->category_type == 'electronics' ? 'selected' : '' }}>إلكترونيات</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>المواصفات الفنية</label>
                            <textarea name="description" class="form-control" rows="4" required>{{ $order->description }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- 2. الملحقات -->
                <div class="box box-info" style="border-radius: 15px;">
                    <div class="box-header with-border">
                        <h3 class="box-title">الملحقات (اتركها فارغة إذا كنت لا تريد التغيير)</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label>تحديث الصور</label>
                                <input type="file" name="images[]" multiple class="form-control" accept="image/*">
                                @if($order->images)
                                    <div style="margin-top: 10px; display: flex; gap: 5px;">
                                        @foreach($order->images as $img)
                                            <img src="{{ Storage::url($img) }}" style="width: 40px; height: 40px; border-radius: 4px;">
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <label>تحديث ملف المواصفات (PDF)</label>
                                <input type="file" name="spec_file" class="form-control" accept=".pdf">
                                @if($order->spec_file)
                                    <p style="margin-top: 10px;"><i class="fa fa-file-pdf-o text-red"></i> {{ basename($order->spec_file) }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-center" style="margin-top: 30px;">
                    <button type="submit" class="btn btn-primary btn-lg" style="padding: 10px 60px; border-radius: 50px;">حفظ التغييرات</button>
                    <a href="{{ route('client.special_orders.index') }}" class="btn btn-default btn-lg" style="padding: 10px 40px; border-radius: 50px; margin-right: 10px;">إلغاء</a>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
