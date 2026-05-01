@extends('layouts.master')

@section('title', 'إدارة الدول')

@section('content')
<section class="content-header">
    <h1>
        الدول
        <small>عرض جميع الدول</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('admin') }}"><i class="fa fa-dashboard"></i> الرئيسية</a></li>
        <li class="active">الدول</li>
    </ol>
</section>

<section class="content">
    <div class="row" style="margin-bottom: 10px;">
        <div class="col-xs-12">
            <a href="{{ route('admin.countries.create') }}" class="btn btn-success">
                <i class="fa fa-plus"></i> إضافة دولة جديدة
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-check"></i> نجاح!</h4>
        {{ session('success') }}
    </div>
    @endif

    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">قائمة الدول</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tr>
                            <th>العلم</th>
                            <th>الاسم بالعربية</th>
                            <th>الاسم بالإنجليزية</th>
                            <th>الاسم بالصينية</th>
                            <th>رمز الدولة</th>
                            <th>العمليات</th>
                        </tr>
                        @foreach($countries as $country)
                        <tr>
                            <td>
                                <img
                                    src="{{ asset('vendor/flag-icons/flags/4x3/' . $country->flag_code . '.svg') }}"
                                    alt="{{ $country->name_en }}"
                                    style="width:40px; height:28px; border:1px solid #ddd; border-radius:3px; box-shadow:0 1px 3px rgba(0,0,0,0.12); object-fit:cover;"
                                >
                            </td>
                            <td>{{ $country->name_ar }}</td>
                            <td>{{ $country->name_en }}</td>
                            <td>{{ $country->name_zh }}</td>
                            <td><span class="label label-primary">{{ strtoupper($country->flag_code) }}</span></td>
                            <td>
                                <a href="{{ route('admin.countries.edit', $country->id) }}" class="btn btn-warning btn-xs">
                                    <i class="fa fa-edit"></i> تعديل
                                </a>
                                <form action="{{ route('admin.countries.destroy', $country->id) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-xs" onclick="return confirm('هل أنت متأكد من الحذف؟')">
                                        <i class="fa fa-trash"></i> حذف
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .fi {
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        border-radius: 2px;
        display: inline-block;
        width: 1.5em; /* Adjusted width */
        height: 1.125em; /* Explicit height */
        background-size: contain;
        background-position: center;
        background-repeat: no-repeat;
        vertical-align: middle;
    }
</style>
@endpush
