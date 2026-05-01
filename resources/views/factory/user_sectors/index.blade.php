@extends('factory.layouts.master')

@section('title', 'اختيار القطاعات')

@section('content')
<section class="content-header">
    <h1>
        اختيار القطاعات
        <small>القطاعات التي تعمل بها</small>
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
                    <h3 class="box-title">بياناتي والقطاعات</h3>
                    <div class="box-tools">
                        <a href="{{ route('user-sectors.create') }}" class="btn btn-sm btn-success">
                            <i class="fa fa-plus"></i> تعديل اختيار القطاعات
                        </a>
                    </div>
                </div>
                
                <div class="box-body">
                    <div class="user-block" style="margin-bottom: 20px; border-bottom: 1px solid #f4f4f4; padding-bottom: 15px;">
                        <img class="img-circle img-bordered-sm" 
                             src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('img/default-avatar.png') }}" 
                             alt="user image" style="width: 50px; height: 50px;">
                        <span class="username" style="font-size: 18px; margin-right: 15px;">
                            {{ $user->name }}
                        </span>
                        <span class="description" style="margin-right: 15px;">{{ $user->email }}</span>
                    </div>

                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>اسم القطاع (بالعربي)</th>
                                <th>اسم القطاع (بالإنجليزي)</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sectors as $sector)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $sector->name_ar }}</td>
                                    <td>{{ $sector->name_en }}</td>
                                    <td>
                                        <form action="{{ route('user-sectors.destroy', $sector->id) }}" method="POST" 
                                              onsubmit="return confirm('هل أنت متأكد من إزالة هذا القطاع من قائمتك؟');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-xs">
                                                <i class="fa fa-trash"></i> حذف
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">لم تقم باختيار أي قطاعات بعد.</td>
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
