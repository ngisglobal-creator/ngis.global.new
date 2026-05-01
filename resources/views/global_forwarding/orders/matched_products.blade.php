@extends('layouts.master')

@section('title', 'المنتجات المطابقة للطلبات')

@section('content')
<style>
    .product-card-img {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        transition: transform 0.3s ease;
    }
    .product-card-img:hover {
        transform: scale(1.1);
    }
    .badge-type {
        padding: 5px 10px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 11px;
        text-transform: uppercase;
    }
    .type-heavy { background: #fff4e6; color: #d9480f; }
    .type-light { background: #e7f5ff; color: #1971c2; }
    .type-carton { background: #f3f0ff; color: #6741d9; }
    .type-special { background: #ebfbee; color: #2b8a3e; }
    
    .client-info {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .client-avatar {
        width: 32px;
        height: 32px;
        background: #f1f3f5;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        color: #495057;
    }
    .order-link {
        color: #3c8dbc;
        font-weight: 600;
        text-decoration: none;
    }
    .order-link:hover {
        text-decoration: underline;
    }
</style>

<section class="content-header">
    <h1>
        المنتجات المطابقة للطلبات
        <small>قائمة بجميع المنتجات المرفوعة لمطابقة طلبات العملاء</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('global_forwarding.dashboard') }}"><i class="fa fa-dashboard"></i> لوحة التحكم</a></li>
        <li class="active">المنتجات المطابقة</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary" style="border-radius: 15px; overflow: hidden; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
                <div class="box-header with-border" style="background: #fff; padding: 20px;">
                    <h3 class="box-title" style="font-weight: bold;"><i class="fa fa-list text-primary"></i> قائمة المنتجات واللوجستيات</h3>
                </div>
                <div class="box-body no-padding">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped text-center" style="vertical-align: middle;">
                            <thead style="background: #f8f9fa;">
                                <tr>
                                    <th style="width: 200px;">المطابقة (طلب العميل ← المرفوع)</th>
                                    <th>المنتج / SKU</th>
                                    <th>النوع</th>
                                    <th>العميل</th>
                                    <th>الطلب الأصلي</th>
                                    <th>اللوجستيات (CBM/Weight)</th>
                                    <th>تاريخ الرفع</th>
                                    <th>إجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($products as $product)
                                    <tr>
                                        <td style="min-width: 180px;">
                                            <div style="display: flex; align-items: center; justify-content: center; gap: 8px;">
                                                <!-- Original Product (Customer) -->
                                                <div style="position: relative;" title="صورة طلب العميل">
                                                    @if($product->customOrder->images && count($product->customOrder->images) > 0)
                                                        <img src="{{ Storage::url($product->customOrder->images[0]) }}" class="product-card-img" style="border: 2px solid #ddd;" alt="Original">
                                                    @else
                                                        <div class="product-card-img" style="background: #eee; display: flex; align-items: center; justify-content: center; border: 2px solid #ddd;">
                                                            <i class="fa fa-question text-muted"></i>
                                                        </div>
                                                    @endif
                                                    <span style="position: absolute; top: -5px; right: -5px; background: #777; color: white; border-radius: 50%; width: 18px; height: 18px; font-size: 10px; display: flex; align-items: center; justify-content: center;" title="طلب العميل">
                                                        <i class="fa fa-user"></i>
                                                    </span>
                                                </div>

                                                <!-- Matching Arrow -->
                                                <div style="color: #3c8dbc; font-size: 18px; font-weight: bold;">
                                                    <i class="fa fa-long-arrow-left"></i>
                                                </div>

                                                <!-- Matched Product (Factory/Sourcing) -->
                                                <div style="position: relative;" title="المنتج المطابق المرفوع">
                                                    @if($product->images->count() > 0)
                                                        <img src="{{ Storage::url($product->images->first()->image_path) }}" class="product-card-img" style="border: 2px solid #3c8dbc;" alt="Matched">
                                                    @else
                                                        <div class="product-card-img" style="background: #eee; display: flex; align-items: center; justify-content: center; border: 2px solid #3c8dbc;">
                                                            <i class="fa fa-image text-muted"></i>
                                                        </div>
                                                    @endif
                                                    <span style="position: absolute; top: -5px; left: -5px; background: #3c8dbc; color: white; border-radius: 50%; width: 18px; height: 18px; font-size: 10px; display: flex; align-items: center; justify-content: center;" title="المنتج المطابق">
                                                        <i class="fa fa-check"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td style="text-align: right; padding-right: 20px;">
                                            <div style="font-weight: bold; color: #333;">{{ $product->name }}</div>
                                            <div style="font-size: 11px; color: #777;">SKU: {{ $product->sku }}</div>
                                        </td>
                                        <td>
                                            @php
                                                $typeLabel = 'منتج عادي';
                                                $typeClass = 'type-carton';
                                                if($product->vehicle_group == 'heavy') {
                                                    $typeLabel = 'معدة ثقيلة';
                                                    $typeClass = 'type-heavy';
                                                } elseif($product->vehicle_group == 'light') {
                                                    $typeLabel = 'مركبة خفيفة';
                                                    $typeClass = 'type-light';
                                                } elseif($product->carton_length == null) {
                                                    $typeLabel = 'منتج خاص';
                                                    $typeClass = 'type-special';
                                                }
                                            @endphp
                                            <span class="badge-type {{ $typeClass }}">{{ $typeLabel }}</span>
                                        </td>
                                        <td>
                                            <div class="client-info">
                                                <div class="client-avatar">
                                                    {{ mb_substr($product->customOrder->user->name ?? 'C', 0, 1) }}
                                                </div>
                                                <div style="text-align: right;">
                                                    <div style="font-weight: 600;">{{ $product->customOrder->user->name ?? 'عميل غير معروف' }}</div>
                                                    <div style="font-size: 10px; color: #999;">{{ $product->customOrder->user->email ?? '' }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="{{ route('global_forwarding.orders.custom.show', $product->custom_order_id) }}" class="order-link">
                                                #{{ $product->custom_order_id }} - {{ Str::limit($product->customOrder->title, 20) }}
                                            </a>
                                        </td>
                                        <td>
                                            <div style="font-weight: bold; color: #2b8a3e;">{{ $product->total_cbm ?? '0.00' }} CBM</div>
                                            <div style="font-size: 11px; color: #d9480f;">{{ $product->total_weight ?? '0.00' }} KG</div>
                                        </td>
                                        <td>
                                            <div style="font-size: 12px; color: #666;">{{ $product->created_at->format('Y-m-d') }}</div>
                                            <div style="font-size: 10px; color: #999;">{{ $product->created_at->format('H:i A') }}</div>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('products.show', $product->id) }}" class="btn btn-default btn-sm" title="عرض التفاصيل الكاملة">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-default btn-sm" title="تعديل">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" style="padding: 50px;">
                                            <i class="fa fa-info-circle text-muted" style="font-size: 40px; margin-bottom: 15px;"></i>
                                            <p style="color: #999;">لا توجد منتجات مطابقة حالياً.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="box-footer" style="background: #fff; padding: 15px 25px;">
                    <div class="pull-right">
                        <span style="color: #777;">إجمالي المنتجات: <strong>{{ $products->count() }}</strong></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
