@extends('layouts.master')

@section('title', 'إعطاء توثيقات للمستخدمين')

@section('content')
<section class="content-header">
  <h1>
    إعطاء توثيقات
    <small>إسناد صور التوثيق للمستخدمين حسب النوع</small>
  </h1>
</section>

<section class="content">
  <div class="box box-primary">
    <div class="box-body">
      @if(session('success'))
        <div class="alert alert-success alert-dismissible">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          {{ session('success') }}
        </div>
      @endif

      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th style="width: 50px;">الصورة</th>
            <th>اسم المستخدم</th>
            <th>النوع</th>
            <th>الباقة</th>
            <th>صورة الباقة</th>
            <th>التقييم</th>
            <th>التوثيقات الحالية</th>
            <th style="width: 100px;">التحكم</th>
          </tr>
        </thead>
        <tbody>
          @foreach($users as $user)
          <tr>
            <td>
              <img src="{{ $user->avatar ? \Illuminate\Support\Facades\Storage::url($user->avatar) : asset('dist/img/user2-160x160.jpg') }}" 
                   class="img-circle" style="width: 40px; height: 40px; object-fit: cover;">
            </td>
            <td><strong>{{ $user->name }}</strong><br><small class="text-muted">{{ $user->email }}</small></td>
            <td>
              <span class="label label-default">{{ $types[$user->type] ?? $user->type }}</span>
            </td>
            <td>
              @if($user->package)
                <span class="label label-success">{{ $user->package->title_ar }}</span>
              @else
                <span class="text-muted">-</span>
              @endif
            </td>
            <td>
              @if($user->package)
                <img src="{{ $user->package->image_url }}" style="height: 35px; border-radius: 3px; border: 1px solid #eee;">
              @else
                -
              @endif
            </td>
            <td>
              @for($i = 1; $i <= 5; $i++)
                <i class="fa {{ $i <= $user->stars ? 'fa-star text-yellow' : 'fa-star-o text-gray' }}"></i>
              @endfor
            </td>
            <td>
              @foreach($user->verifications as $v)
                <img src="{{ $v->image_url }}" title="{{ $v->type }}" style="height: 30px; margin-right: 5px; border: 1px solid #ddd; border-radius: 3px;">
              @endforeach
            </td>
            <td>
              <a href="{{ route('admin.user-verifications.edit', $user->id) }}" class="btn btn-primary btn-sm btn-block">
                <i class="fa fa-hand-pointer-o"></i> إعطاء
              </a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</section>
@endsection
