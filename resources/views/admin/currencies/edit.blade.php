@extends('layouts.master')

@section('title', 'تعديل عملة')

@section('content')
<section class="content-header">
    <h1>تعديل عملة <small>{{ $currency->code }}</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> الرئيسية</a></li>
        <li><a href="{{ route('admin.currencies.index') }}">العملات</a></li>
        <li class="active">تعديل</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-edit"></i> تعديل بيانات العملة</h3>
                </div>
                <form action="{{ route('admin.currencies.update', $currency) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="box-body">
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>رمز العملة (Code) <span class="text-danger">*</span></label>
                                    <input type="text" name="code" value="{{ old('code', $currency->code) }}" class="form-control" required maxlength="10" style="text-transform: uppercase;">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>الرمز المختصر (Symbol) <span class="text-danger">*</span></label>
                                    <input type="text" name="symbol" value="{{ old('symbol', $currency->symbol) }}" class="form-control" required maxlength="10">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>اسم العملة بالعربية <span class="text-danger">*</span></label>
                                    <input type="text" name="name_ar" value="{{ old('name_ar', $currency->name_ar) }}" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>اسم العملة بالإنجليزية <span class="text-danger">*</span></label>
                                    <input type="text" name="name_en" value="{{ old('name_en', $currency->name_en) }}" class="form-control" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="is_active" value="1" {{ $currency->is_active ? 'checked' : '' }}>
                                    تفعيل العملة
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-warning btn-lg">
                            <i class="fa fa-save"></i> حفظ التعديلات
                        </button>
                        <a href="{{ route('admin.currencies.index') }}" class="btn btn-default btn-lg">إلغاء</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
