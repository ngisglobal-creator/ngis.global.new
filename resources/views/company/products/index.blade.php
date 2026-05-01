@extends('company.layouts.master')

@section('title', 'منتجاتي')

@section('content')
<style>
    .table td {
        vertical-align: middle !important;
    }
</style>
<section class="content-header">
    <h1>
        منتجاتي
        <small>المنتجات التي قمت بإضافتها</small>
    </h1>
</section>

<section class="content">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-check"></i> نجاح!</h4>
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">قائمة المنتجات</h3>
                    <div class="box-tools">
                        <a href="{{ route('products.create') }}" class="btn btn-sm btn-success">
                            <i class="fa fa-plus"></i> إضافة منتج جديد
                        </a>
                    </div>
                </div>
                
                <div class="box-body table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>صورة المنتج</th>
                                <th>اسم المنتج</th>
                                <th>التصنيف</th>
                                <th>الكمية</th>
                                <th>النوع</th>
                                <th>السعر</th>
                                <th>صاحب المنتج</th>
                                <th>تاريخ الإضافة</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $product)
                                <tr>
                                    <td class="english-nums" style="font-weight: bold;">{{ $loop->iteration }}</td>
                                    <td>
                                        @if($product->images->count() > 0)
                                            <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" 
                                                 class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;">
                                        @else
                                            <span class="label label-default">لا توجد صورة</span>
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{ $product->name }}</strong><br>
                                        <div class="text-muted" style="font-size: 12px; max-height: 40px; overflow: hidden;">
                                            {!! Str::limit(strip_tags($product->description), 100) !!}
                                        </div>
                                    </td>
                                    <td>
                                        <span class="label label-info">{{ $product->sector->name_ar }}</span><br>
                                        <small>{{ $product->branch->name_ar }} > {{ $product->category->name_ar }}</small>
                                    </td>
                                    <td class="english-nums" style="font-weight: 900; font-size: 16px;">{{ $product->quantity }}</td>
                                    <td>
                                        @if($product->vehicle_group === 'light')
                                            <span class="label label-warning"><i class="fa fa-car"></i> مركبة خفيفة</span>
                                        @elseif($product->vehicle_group === 'heavy')
                                            <span class="label label-danger"><i class="fa fa-truck"></i> معدات ثقيلة</span>
                                        @else
                                            <span class="label label-default"><i class="fa fa-cube"></i> منتج عادي</span>
                                        @endif
                                    </td>
                                    <td class="english-nums" style="font-weight: 900; font-size: 16px;">{{ number_format($product->price, 2) }}</td>
                                    <td>
                                        <div class="user-block">
                                            <img class="img-circle img-bordered-sm" 
                                                 src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('img/default-avatar.png') }}" 
                                                 alt="user image">
                                            <span class="username" style="font-size: 13px;">
                                                <a href="#">{{ $user->name }}</a>
                                            </span>
                                            <span class="description" style="font-size: 11px;">{{ $user->type == 'company' ? 'شركة' : 'مصنع' }}</span>
                                        </div>
                                    </td>
                                    <td class="english-nums" style="font-weight: bold; color: #555;">{{ $product->created_at->format('Y-m-d') }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                                <i class="fa fa-cog"></i> <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-right">
                                                <li><a href="{{ route('products.show', $product->id) }}"><i class="fa fa-eye text-green"></i> تفاصيل المنتج</a></li>
                                                <li><a href="{{ route('products.edit', $product->id) }}"><i class="fa fa-edit text-blue"></i> تعديل</a></li>
                                                <li>
                                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" 
                                                          onsubmit="return confirm('هل أنت متأكد من حذف هذا المنتج؟');" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" style="background:none; border:none; padding: 3px 20px; width: 100%; text-align: right;">
                                                            <i class="fa fa-trash text-red"></i> حذف
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">لا توجد منتجات مضافة حالياً.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
