@extends('client.layouts.master')

@section('title', 'طلباتي الخاصة - Sourcing')

@section('content')
    <!-- Import modern font for numbers -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet">

    <section class="content-header">
        <h1 style="font-weight: 900; color: #1a202c;">
            طلباتي الخاصة <small>Global Sourcing & Procurement</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('client.dashboard') }}"><i class="fa fa-dashboard"></i> الرئيسية</a></li>
            <li class="active">طلباتي الخاصة</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info"
                    style="border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); border-top: 5px solid #00c0ef;">
                    <div class="box-header with-border" style="padding: 15px 20px;">
                        <h3 class="box-title" style="font-weight: 700;">سجل طلبات التوريد الميداني</h3>
                        <div class="box-tools">
                            <a href="{{ route('client.special_order') }}" class="btn btn-primary"
                                style="border-radius: 20px; font-weight: 700; padding: 8px 20px;">
                                <i class="fa fa-plus-circle"></i> تقديم طلب جديد
                            </a>
                        </div>
                    </div>
                    <div class="box-body table-responsive">
                        <table class="table table-bordered table-striped" style="vertical-align: middle;">
                            <thead>
                                <tr class="bg-navy">
                                    <th style="width: 80px;">الصورة</th>
                                    <th>معلومات المنتج</th>
                                    <th>التصنيف والمنشأ</th>
                                    <th style="min-width: 250px;">التفاصيل اللوجستية</th>
                                    <th>الحالة</th>
                                    <th>تاريخ الطلب</th>
                                    <th style="width: 150px;">العمليات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
                                    <tr>
                                        <td class="text-center">
                                            @if($order->images && count($order->images) > 0)
                                                <img src="{{ Storage::url($order->images[0]) }}"
                                                    style="width: 70px; height: 70px; object-fit: cover; border-radius: 8px; border: 1px solid #eee;">
                                            @else
                                                <div
                                                    style="width: 70px; height: 70px; background: #f4f4f4; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #ccc;">
                                                    <i class="fa fa-image fa-2x"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            <strong style="font-size: 16px; color: #2c3e50;">{{ $order->title }}</strong><br>
                                            <small class="text-muted"><i class="fa fa-info-circle"></i>
                                                {{ Str::limit($order->description, 50) }}</small>
                                        </td>
                                        <td>
                                            <span class="label label-primary"
                                                style="display: inline-block; margin-bottom: 5px;">{{ ucfirst($order->category_type) }}</span><br>
                                            <span class="text-muted"><i class="fa fa-globe"></i> المنشأ:
                                                {{ ucfirst($order->origin) }}</span>
                                        </td>
                                        <td>
                                            <div
                                                style="background: #fff; border: 1px solid #e2e8f0; border-radius: 10px; padding: 10px; display: flex; justify-content: space-between;">
                                                <div class="text-center" style="flex: 1; border-left: 1px solid #f0f0f0;">
                                                    <div style="font-size: 10px; color: #718096; font-weight: bold;">الكمية
                                                    </div>
                                                    <div style="font-weight: 800; color: #3182ce;" class="english-nums">
                                                        {{ $order->quantity }}</div>
                                                    <div style="font-size: 9px; color: #a0aec0;">{{ $order->unit }}</div>
                                                </div>
                                                <div class="text-center" style="flex: 1;">
                                                    <div style="font-size: 10px; color: #718096; font-weight: bold;">السعر
                                                        المستهدف</div>
                                                    <div style="font-weight: 800; color: #38a169;" class="english-nums">
                                                        {{ number_format($order->target_price, 2) }}</div>
                                                    <div style="font-size: 9px; color: #a0aec0;">USD</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="label label-{{ $order->status_color }}"
                                                style="font-size: 12px; padding: 5px 10px;">
                                                {{ $order->status_label }}
                                            </span>
                                            @if($order->admin_notes)
                                                <div style="margin-top: 5px; font-size: 11px; color: #3c8dbc;">
                                                    <i class="fa fa-commenting" style="color: #3c8dbc;"></i> تم الرد من الإدارة
                                                </div>
                                            @endif
                                        </td>
                                        <td class="english-nums" style="font-size: 13px; color: #4a5568;">
                                                                            <td>
                                    <div class="btn-group" style="display: flex; gap: 5px;">
                                        <button class="btn btn-action-white btn-special-detail" 
                                            data-order="{{ json_encode($order) }}"
                                            data-images="{{ json_encode(array_map(fn($img) => Storage::url($img), $order->images ?? [])) }}"
                                            data-spec="{{ $order->spec_file ? Storage::url($order->spec_file) : '' }}"
                                            title="عرض التفاصيل">
                                            عرض
                                        </button>
                                        <a href="{{ route('client.special_orders.edit', $order->id) }}" class="btn btn-action-white" title="تعديل">
                                            تعديل
                                        </a>
                                        <form action="{{ route('client.special_orders.delete', $order->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('هل أنت متأكد؟')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-action-white" title="حذف">
                                                حذف
                                            </button>
                                        </form>
                                    </div>
                                </td>
                                    </tr>
                                    <!-- Stepper Row -->
                                    <tr>
                                        <td colspan="7"
                                            style="background: #f9fafb; padding: 30px 50px; border-bottom: 3px solid #00c0ef;">
                                            @include('partials.special_order_stepper', ['order' => $order])
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-5">
                                            <div style="padding: 50px;">
                                                <i class="fa fa-folder-open-o fa-5x text-gray"></i>
                                                <h3 class="text-muted">لا توجد طلبات خاصة حالياً</h3>
                                                <a href="{{ route('client.special_order') }}" class="btn btn-primary btn-lg"
                                                    style="margin-top: 15px; border-radius: 30px;">ابدأ أول طلب الآن</a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Special Order Details Modal -->
    <div class="modal fade" id="specialDetailModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="border-radius: 15px; overflow: hidden; border: none;">
                <div class="modal-header bg-navy" style="padding: 20px;">
                    <button type="button" class="close" data-dismiss="modal"
                        style="color: white; opacity: 1;">&times;</button>
                    <h4 class="modal-title" style="font-weight: 800;"><i class="fa fa-magic"></i> تفاصيل طلب الاستيراد
                        المخصص</h4>
                </div>
                <div class="modal-body" style="padding: 30px;">
                    <div class="row">
                        <div class="col-md-6">
                            <div id="modalMainImgContainer"
                                style="height: 350px; border: 1px solid #edf2f7; border-radius: 12px; overflow: hidden; background: #f8fafc; margin-bottom: 15px;">
                                <img id="modalMainImg" src="" style="width: 100%; height: 100%; object-fit: contain;">
                            </div>
                            <div id="modalThumbContainer" class="row"></div>
                        </div>
                        <div class="col-md-6">
                            <h3 id="modalTitle" style="font-weight: 900; color: #1a202c; margin-top: 0;"></h3>
                            <div style="margin-bottom: 20px;">
                                <span id="modalCategory" class="label label-primary" style="font-size: 14px;"></span>
                                <span id="modalOrigin" class="label label-info"
                                    style="font-size: 14px; margin-right: 5px;"></span>
                            </div>

                            <div class="well well-sm"
                                style="background: #fff; border-right: 4px solid #00c0ef; font-size: 15px; color: #4a5568;">
                                <strong style="display: block; margin-bottom: 5px; color: #2d3748;">المواصفات
                                    الفنية:</strong>
                                <p id="modalDesc"></p>
                            </div>

                            <div class="row text-center" style="margin-top: 20px;">
                                <div class="col-xs-6">
                                    <div
                                        style="padding: 15px; background: #ebf8ff; border-radius: 12px; border: 1px solid #bee3f8;">
                                        <div style="color: #2b6cb0; font-size: 12px; font-weight: bold;">الكمية المطلوبة
                                        </div>
                                        <div id="modalQty" style="font-size: 24px; font-weight: 900; color: #2c5282;"
                                            class="english-nums"></div>
                                        <div id="modalUnit" style="font-size: 11px; color: #4a5568;"></div>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div
                                        style="padding: 15px; background: #f0fff4; border-radius: 12px; border: 1px solid #c6f6d5;">
                                        <div style="color: #2f855a; font-size: 12px; font-weight: bold;">السعر المستهدف
                                        </div>
                                        <div id="modalPrice" style="font-size: 24px; font-weight: 900; color: #276749;"
                                            class="english-nums"></div>
                                        <div style="font-size: 11px; color: #4a5568;">USD</div>
                                    </div>
                                </div>
                            </div>

                            <div
                                style="margin-top: 25px; padding: 15px; background: #fffaf0; border-radius: 12px; border: 1px solid #feebc8;">
                                <strong style="color: #9c4221;"><i class="fa fa-commenting"></i> رد الإدارة
                                    والملاحظات:</strong>
                                <p id="modalAdminNotes" style="margin-top: 10px; color: #7b341e; font-style: italic;"></p>
                            </div>

                            <div style="margin-top: 20px;">
                                <a id="modalSpecLink" href="" target="_blank" class="btn btn-default btn-block"
                                    style="border-radius: 8px; text-align: right; display: none;">
                                    <i class="fa fa-file-pdf-o text-red"></i> عرض ملف المواصفات المرفق (PDF/CAD)
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="background: #f8fafc; border-top: 1px solid #edf2f7; padding: 20px;">
                    <div class="pull-right">
                        <span style="font-weight: bold; color: #718096; margin-left: 10px;">حالة الطلب الحالية:</span>
                        <span id="modalStatusLabel" class="label"
                            style="font-size: 16px; padding: 8px 20px; border-radius: 20px;"></span>
                    </div>
                    <button type="button" class="btn btn-default" data-dismiss="modal"
                        style="border-radius: 8px; font-weight: 700;">إغلاق</button>
                </div>
            </div>
        </div>
    </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function () {
                $('.btn-special-detail').on('click', function () {
                    let order = $(this).data('order');
                    let images = $(this).data('images');
                    let specUrl = $(this).data('spec');

                    $('#modalTitle').text(order.title);
                    $('#modalDesc').text(order.description);
                    $('#modalCategory').text(order.category_type.toUpperCase());
                    $('#modalOrigin').text(order.origin.toUpperCase());
                    $('#modalQty').text(order.quantity);
                    $('#modalUnit').text(order.unit);
                    $('#modalPrice').text(parseFloat(order.target_price).toLocaleString());
                    $('#modalAdminNotes').text(order.admin_notes || 'لم يتم كتابة ملاحظات من الإدارة بعد. طلبك قيد المراجعة.');

                    let statusMap = {
                        'pending': { label: 'قيد المراجعة', class: 'label-warning' },
                        'processing': { label: 'جاري البحث الميداني', class: 'label-info' },
                        'matched': { label: 'تمت المطابقة', class: 'label-primary' },
                        'shipped': { label: 'تم الشحن', class: 'label-success' },
                        'completed': { label: 'مكتمل', class: 'label-success' },
                        'cancelled': { label: 'ملغي', class: 'label-danger' }
                    };

                    let status = statusMap[order.status] || { label: order.status, class: 'label-default' };
                    $('#modalStatusLabel').text(status.label).removeClass().addClass('label ' + status.class);

                    if (specUrl) {
                        $('#modalSpecLink').attr('href', specUrl).show();
                    } else {
                        $('#modalSpecLink').hide();
                    }

                    // Images
                    if (images && images.length > 0) {
                        $('#modalMainImg').attr('src', images[0]);
                        let thumbs = '';
                        images.forEach((img, i) => {
                            thumbs += `
                            <div class="col-xs-3" style="padding: 5px;">
                                <img src="${img}" class="img-thumbnail" style="height: 60px; width: 100%; object-fit: cover; cursor: pointer; ${i == 0 ? 'border-color: #00c0ef' : ''}" onclick="$('#modalMainImg').attr('src', '${img}'); $('.img-thumbnail').css('border-color', '#ddd'); $(this).css('border-color', '#00c0ef')">
                            </div>
                        `;
                        });
                        $('#modalThumbContainer').html(thumbs);
                    } else {
                        $('#modalMainImg').attr('src', '');
                        $('#modalThumbContainer').empty();
                    }

                    $('#specialDetailModal').modal('show');
                });
            });
        </script>
        <style>
            .english-nums {
                font-family: 'Inter', sans-serif !important;
            }

            .table>tbody>tr>td {
                vertical-align: middle !important;
            }

            .btn-action-white {
                background: #ffffff !important;
                color: #000000 !important;
                border: 2px solid #000000 !important;
                border-radius: 8px !important;
                padding: 6px 12px !important;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1) !important;
                transition: all 0.2s !important;
            }

            .btn-action-white i, 
            .btn-action-white i::before, 
            .btn-action-white i::after {
                color: #000000 !important;
            }

            .btn-action-white:hover {
                background: #000000 !important;
                color: #ffffff !important;
                transform: translateY(-2px) !important;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2) !important;
            }
            .btn-action-white:hover i, 
            .btn-action-white:hover i::before {
                color: #ffffff !important;
            }
        </style>
    @endpush
@endsection