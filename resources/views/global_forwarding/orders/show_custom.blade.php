@extends('layouts.master')

@section('title', 'تفاصيل الطلب الخاص #' . $order->id)

@section('content')
<section class="content-header">
    <h1>
        تفاصيل الطلب الخاص
        <small>#{{ $order->id }}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('global_forwarding.dashboard') }}"><i class="fa fa-dashboard"></i> الرئيسية</a></li>
        <li><a href="{{ route('global_forwarding.orders.custom') }}">الطلبات الخاصة</a></li>
        <li class="active">تفاصيل الطلب</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <!-- معلومات العميل والمنتج -->
        <div class="col-md-4">
            <div class="box box-primary">
                <div class="box-body box-profile">
                    <h3 class="profile-username text-center">{{ $order->user->name }}</h3>
                    <p class="text-muted text-center">{{ $order->user->panel_type_label ?? $order->user->type }}</p>
                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                            <b>رقم الطلب</b> <a class="pull-left">{{ $order->id }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>تاريخ الطلب</b> <a class="pull-left">{{ $order->created_at->format('Y-m-d H:i') }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>الحالة الحالية</b> <a class="pull-left"><span class="label label-{{ $order->status_color }}">{{ $order->status_label }}</span></a>
                        </li>
                    </ul>
                    <a href="#" class="btn btn-primary btn-block"><b>مراسلة العميل</b></a>
                </div>
            </div>

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">الملحقات الفنية</h3>
                </div>
                <div class="box-body">
                    <strong><i class="fa fa-file-pdf-o margin-r-5"></i> ملف المواصفات (PDF/CAD)</strong>
                    <p class="text-muted">
                        @if($order->spec_file)
                            <a href="{{ Storage::url($order->spec_file) }}" target="_blank" class="btn btn-default btn-xs">
                                <i class="fa fa-download"></i> تحميل الملف
                            </a>
                        @else
                            لا يوجد ملف مرفق
                        @endif
                    </p>
                    <hr>
                    <strong><i class="fa fa-link margin-r-5"></i> رابط مرجعي (Reference)</strong>
                    <p>
                        @if($order->reference_link)
                            <a href="{{ $order->reference_link }}" target="_blank" class="text-blue">{{ $order->reference_link }}</a>
                        @else
                            لا يوجد رابط
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <!-- تفاصيل المنتج والصور -->
        <div class="col-md-8">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#details" data-toggle="tab">تفاصيل المواصفات</a></li>
                    <li><a href="#images" data-toggle="tab">الصور المرفقة ({{ count($order->images ?? []) }})</a></li>
                    <li><a href="#logistics" data-toggle="tab">المعايير اللوجستية والجودة</a></li>
                </ul>
                <div class="tab-content">
                    <!-- Tab 1: Details -->
                    <div class="active tab-pane" id="details">
                        <h4 class="text-blue">{{ $order->title }}</h4>
                        <p class="well" style="background: #f4f4f4; border-right: 5px solid #3c8dbc;">
                            {{ $order->description }}
                        </p>
                        <table class="table table-bordered">
                            <tr>
                                <th style="width: 150px;">التصنيف</th>
                                <td>{{ ucfirst($order->category_type) }}</td>
                            </tr>
                            <tr>
                                <th>الكمية المطلوبة</th>
                                <td>{{ $order->quantity }} {{ $order->unit }}</td>
                            </tr>
                            <tr>
                                <th>السعر المستهدف</th>
                                <td>{{ number_format($order->target_price, 2) }} $</td>
                            </tr>
                        </table>
                    </div>

                    <!-- Tab 2: Images -->
                    <div class="tab-pane" id="images">
                        <div class="row">
                            @if($order->images && count($order->images) > 0)
                                @foreach($order->images as $image)
                                <div class="col-sm-4" style="margin-bottom: 15px;">
                                    <a href="{{ Storage::url($image) }}" target="_blank">
                                        <img src="{{ Storage::url($image) }}" class="img-responsive img-thumbnail" style="height: 150px; width: 100%; object-fit: cover;">
                                    </a>
                                </div>
                                @endforeach
                            @else
                                <div class="col-xs-12 text-center py-5">
                                    <i class="fa fa-image fa-5x text-gray"></i>
                                    <p>لا توجد صور مرفقة</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Tab 3: Logistics & Quality -->
                    <div class="tab-pane" id="logistics">
                        <div class="row">
                            <div class="col-md-6">
                                <h4><i class="fa fa-certificate text-yellow"></i> الشهادات المطلوبة</h4>
                                <ul class="list-unstyled">
                                    @if($order->certs && count($order->certs) > 0)
                                        @foreach($order->certs as $cert)
                                            <li><i class="fa fa-check-square-o text-green"></i> {{ $cert }}</li>
                                        @endforeach
                                    @else
                                        <li>لا توجد شهادات محددة</li>
                                    @endif
                                    @if($order->other_certs)
                                        <li class="text-muted"><small>أخرى: {{ $order->other_certs }}</small></li>
                                    @endif
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h4><i class="fa fa-globe text-blue"></i> بلد المنشأ المفضل</h4>
                                <p class="label label-info" style="font-size: 1.1em;">{{ ucfirst($order->origin) }}</p>
                                
                                <h4 style="margin-top: 20px;"><i class="fa fa-cube text-purple"></i> التغليف الخاص</h4>
                                <ul class="list-unstyled">
                                    @if($order->packaging && count($order->packaging) > 0)
                                        @foreach($order->packaging as $pkg)
                                            <li><i class="fa fa-archive text-purple"></i> {{ str_replace('_', ' ', $pkg) }}</li>
                                        @endforeach
                                    @else
                                        <li>تغليف عادي</li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- ملاحظات الإدارة -->
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">ملاحظات الإدارة والرد على العميل</h3>
                </div>
                <div class="box-body">
                    <form action="{{ route('global_forwarding.orders.custom.update', $order->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="form-group">
                            <textarea name="admin_notes" class="form-control" rows="4" placeholder="اكتب ردك هنا للعميل (سيظهر له في لوحة التحكم)...">{{ $order->admin_notes }}</textarea>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <select name="status" class="form-control">
                                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>قيد المراجعة</option>
                                    <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>جاري البحث الميداني</option>
                                    <option value="matched" {{ $order->status == 'matched' ? 'selected' : '' }}>تمت المطابقة</option>
                                    <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>تم الشحن</option>
                                    <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>مكتمل</option>
                                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>ملغي</option>
                                </select>
                            </div>
                            <div class="col-sm-8 text-left">
                                <button type="submit" class="btn btn-warning">تحديث الحالة وإرسال الملاحظات</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
