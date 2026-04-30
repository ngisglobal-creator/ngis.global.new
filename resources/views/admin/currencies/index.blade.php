@extends('layouts.master')

@section('title', 'إدارة العملات')

@section('content')
<section class="content-header">
    <h1>قسم العملات <small>إدارة عملات النظام</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> الرئيسية</a></li>
        <li class="active">العملات</li>
    </ol>
</section>

<section class="content">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <i class="fa fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-money"></i> قائمة العملات</h3>
            <div class="box-tools pull-right">
                <a href="{{ route('admin.currencies.create') }}" class="btn btn-success btn-sm">
                    <i class="fa fa-plus"></i> إضافة عملة جديدة
                </a>
            </div>
        </div>
        <div class="box-body">
            <input type="text" id="searchInput" class="form-control" placeholder="🔍 بحث عن عملة..." style="margin-bottom: 15px; border-radius: 8px;">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="currenciesTable">
                    <thead style="background: #3c8dbc; color: white;">
                        <tr>
                            <th>#</th>
                            <th>الرمز (Code)</th>
                            <th>اسم العملة (عربي)</th>
                            <th>اسم العملة (English)</th>
                            <th>الرمز المختصر</th>
                            <th>الحالة</th>
                            <th>العمليات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($currencies as $currency)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><strong class="text-primary">{{ $currency->code }}</strong></td>
                                <td>{{ $currency->name_ar }}</td>
                                <td>{{ $currency->name_en }}</td>
                                <td><span class="label label-default" style="font-size: 14px;">{{ $currency->symbol }}</span></td>
                                <td>
                                    @if($currency->is_active)
                                        <span class="label label-success">مفعّل</span>
                                    @else
                                        <span class="label label-danger">معطّل</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.currencies.edit', $currency) }}" class="btn btn-warning btn-xs">
                                        <i class="fa fa-edit"></i> تعديل
                                    </a>
                                    <form action="{{ route('admin.currencies.destroy', $currency) }}" method="POST" style="display:inline;" onsubmit="return confirm('هل أنت متأكد من الحذف؟')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-xs">
                                            <i class="fa fa-trash"></i> حذف
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="text-center text-muted">لا توجد عملات مضافة بعد.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="box-footer text-muted">
            إجمالي العملات: <strong>{{ $currencies->count() }}</strong>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
$('#searchInput').on('keyup', function() {
    var value = $(this).val().toLowerCase();
    $('#currenciesTable tbody tr').filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
    });
});
</script>
@endpush
