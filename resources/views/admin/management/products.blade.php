@extends('layouts.master')

@section('title', 'منتجات ' . $typeName)

@section('content')
<section class="content-header">
    <h1>إدارة المنتجات <small>قائمة منتجات {{ $typeName }}</small></h1>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">إجمالي المنتجات المرفوعة</h3>
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>الصورة</th>
                                <th>اسم المنتج</th>
                                <th>صاحب المنتج</th>
                                <th>القطاع</th>
                                <th>السعر</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                            <tr>
                                <td style="width: 80px;">
                                    @php $firstImage = $product->images->first(); @endphp
                                    <img src="{{ $firstImage ? asset('storage/' . $firstImage->image_path) : asset('dist/img/boxed-bg.jpg') }}" 
                                         style="width: 60px; height: 60px; object-fit: cover; border-radius: 4px;">
                                </td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->user->name }}</td>
                                <td>{{ $product->sector->name_ar }}</td>
                                <td>{{ number_format($product->price, 2) }} ر.س</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
