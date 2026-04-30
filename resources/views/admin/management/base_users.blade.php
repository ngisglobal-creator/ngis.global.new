@extends('layouts.master')

@section('title', 'عرض المستخدمين')

@section('content')
<section class="content-header">
    <h1>إدارة المستخدمين <small>قائمة {{ $title ?? 'المستخدمين' }}</small></h1>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">قائمة المسجلين</h3>
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>الصورة</th>
                                <th>الاسم</th>
                                <th>البريد الإلكتروني</th>
                                <th>تاريخ الانضمام</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td style="width: 60px;"><img src="{{ $user->avatar_url }}" class="img-circle" style="width: 40px; height: 40px;"></td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->created_at->format('Y-m-d') }}</td>
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
