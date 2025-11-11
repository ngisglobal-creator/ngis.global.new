@extends('layouts.master')

@section('title', 'إضافة مستخدم جديد')

@section('content')
<div class="container">
    <h1>إضافة مستخدم جديد</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('users.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label>الاسم</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="form-group">
            <label>البريد الإلكتروني</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="form-group">
            <label>كلمة المرور</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="form-group">
            <label>تأكيد كلمة المرور</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>

        <div class="form-group">
            <label>الأدوار</label>
            <select name="roles[]" class="form-control" multiple>
                @foreach($roles as $role)
                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>الصلاحيات</label>
            <select name="permissions[]" class="form-control" multiple>
                @foreach($permissions as $permission)
                    <option value="{{ $permission->name }}">{{ $permission->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="mt-2 btn btn-primary">إنشاء المستخدم</button>
    </form>
</div>
@endsection
