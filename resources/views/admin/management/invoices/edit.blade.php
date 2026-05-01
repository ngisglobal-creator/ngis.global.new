@extends('layouts.master')

@section('title', 'تعديل البيانات المالية | ' . $order->product->name)

@section('content')
<section class="content-header">
    <h1>تعديل البيانات المالية <small style="color: #000; font-family: Arial; font-weight: bold; font-size: 16px;">الطلب رقم #{{ $order->id }}</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> الرئيسية</a></li>
        <li><a href="{{ route('admin.invoices.index') }}">الفواتير</a></li>
        <li class="active">تعديل المالية</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="box box-warning" style="border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-edit"></i> تحرير المعلومات المالية</h3>
                </div>
                <form action="{{ route('admin.invoices.update', $order) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    
                    <div class="box-body" style="padding: 25px;">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>المبلغ المدفوع (ر.س)</label>
                                    <input type="number" name="paid_amount" step="0.01" class="form-control" 
                                           value="{{ old('paid_amount', $order->paid_amount) }}" 
                                           style="font-family: Arial; font-size: 24px; font-weight: bold; color: #000; height: 50px;" required>
                                    <p class="text-muted"><small>السعر الكلي للمنتج: <strong style="font-family: Arial; color: #000;">{{ number_format($order->product->price, 2) }}</strong></small></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>حالة الدفع</label>
                                    <select name="payment_status" class="form-control" style="height: 50px; font-weight: bold;">
                                        <option value="unpaid" {{ old('payment_status', $order->payment_status) == 'unpaid' ? 'selected' : '' }}>غير مدفوع</option>
                                        <option value="partial" {{ old('payment_status', $order->payment_status) == 'partial' ? 'selected' : '' }}>دفع جزئي</option>
                                        <option value="paid" {{ old('payment_status', $order->payment_status) == 'paid' ? 'selected' : '' }}>مدفوع بالكامل</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><i class="fa fa-file-pdf-o"></i> ملف العقد (PDF أو صورة)</label>
                                    <input type="file" name="contract_file" class="form-control">
                                    @if($order->contract_file)
                                        <p class="help-block"><a href="{{ asset('storage/'.$order->contract_file) }}" target="_blank" class="text-primary"><i class="fa fa-link"></i> عرض الملف الحالي</a></p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><i class="fa fa-file-text-o"></i> ملف الفاتورة (PDF أو صورة)</label>
                                    <input type="file" name="invoice_file" class="form-control">
                                    @if($order->invoice_file)
                                        <p class="help-block"><a href="{{ asset('storage/'.$order->invoice_file) }}" target="_blank" class="text-warning"><i class="fa fa-link"></i> عرض الملف الحالي</a></p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="callout callout-info" style="margin-top: 20px; border-radius: 8px;">
                            <h4>تنبيه التنسيق</h4>
                            <p>جميع الأرقام المدخلة ستظهر باللغة الإنجليزية وبخط واضح كما هو محدد في سياسة العرض الجديدة.</p>
                        </div>
                    </div>

                    <div class="box-footer" style="background: #f9f9f9; padding: 20px; display: flex; gap: 10px;">
                        <button type="submit" class="btn btn-warning btn-lg btn-flat" style="flex: 2; border-radius: 6px; font-weight: bold;">
                            <i class="fa fa-save"></i> حفظ التغييرات المالية
                        </button>
                        <a href="{{ route('admin.invoices.show', $order) }}" class="btn btn-default btn-lg btn-flat" style="flex: 1; border-radius: 6px;">
                            إلغاء
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
