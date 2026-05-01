@extends('china.layouts.master')

@section('title', 'العملاء | لوحة الصين')

@section('content')
<section class="content-header">
    <h1>إدارة العملاء <small>العملاء المرتبطين بالفواتير الموجهة</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('china/dashboard') }}"><i class="fa fa-dashboard"></i> الرئيسية</a></li>
        <li class="active">العملاء</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info" style="border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                <div class="box-header">
                    <h3 class="box-title">سجل العملاء</h3>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr style="background: #f4f4f4;">
                                    <th># ID</th>
                                    <th>الصورة</th>
                                    <th>اسم العميل</th>
                                    <th>البريد الإلكتروني</th>
                                    <th>الدولة</th>
                                    <th>عدد طلبات الاستيراد</th>
                                    <th>تاريخ التسجيل</th>
                                    <th>العمليات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($customers as $customer)
                                <tr>
                                    <td style="font-family: Arial; font-weight: bold; font-size: 16px; color: #000;">{{ $customer->id }}</td>
                                    <td>
                                        <img src="{{ $customer->avatar_url }}" width="50" height="50" class="img-circle">
                                    </td>
                                    <td style="font-weight: bold;">{{ $customer->name }}</td>
                                    <td style="font-family: Arial; color: #000;">{{ $customer->email }}</td>
                                    <td>{{ $customer->country->name_ar ?? '---' }}</td>
                                    <td>
                                        <span class="badge bg-aqua" style="font-family: Arial; font-size: 16px; font-weight: bold;">{{ $customer->orders->where('forward_to_china', true)->count() }}</span>
                                    </td>
                                    <td style="font-family: Arial; font-weight: bold; color: #000;">{{ $customer->created_at->format('Y-m-d') }}</td>
                                    <td>
                                        <a href="{{ route('china.customers.show', $customer) }}" class="btn btn-info btn-xs btn-flat"><i class="fa fa-eye"></i> عرض الملف</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">لا يوجد عملاء مرتبطين حالياً</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
