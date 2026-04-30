@extends('layouts.master')

@section('title', 'إعدادات باقات المستخدمين')

@section('content')
<section class="content-header">
  <h1>
    إعدادات باقات المستخدمين
    <small>تخصيص الباقات والتقييمات</small>
  </h1>
</section>

<section class="content">
  <div class="box box-primary">
    <div class="box-body">
      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>الصورة</th>
            <th>الاسم</th>
            <th>النوع</th>
            <th>صورة الباقة</th>
            <th>الباقة الحالية</th>
            <th>التقييم (النجوم)</th>
            <th>التحكم</th>
          </tr>
        </thead>
        <tbody>
          @foreach($users as $user)
          <tr>
            <td class="text-center">
              <img src="{{ $user->avatar_url }}" class="img-circle" style="width: 40px; height: 40px; object-fit: cover; border: 1px solid #ddd;">
            </td>
            <td>{{ $user->name }}</td>
            <td>
              @php
                $types = ['client'=>'عميل','company'=>'شركة','factory'=>'مصنع','admin'=>'مدير','regional_office'=>'مكتب اقليم','china'=>'الصين'];
              @endphp
              {{ $types[$user->type] ?? $user->type }}
            </td>
            <td class="text-center">
              @if($user->package)
                <img src="{{ $user->package->image_url }}" style="height: 40px; border-radius: 4px; border: 1px solid #eee;">
              @else
                -
              @endif
            </td>
            <td>
              @if($user->package)
                <span class="label label-success">
                  <i class="fa fa-cube"></i> {{ $user->package->title_ar }}
                </span>
              @else
                <span class="label label-default">لا توجد باقة</span>
              @endif
            </td>
            <td>
              @for($i = 1; $i <= 5; $i++)
                <i class="fa {{ $i <= $user->stars ? 'fa-star text-yellow' : 'fa-star-o text-gray' }}"></i>
              @endfor
            </td>
            <td>
              <a href="{{ route('admin.user-packages.edit', $user->id) }}" class="btn btn-primary btn-xs">
                <i class="fa fa-edit"></i> تعديل الباقة والنجوم
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
