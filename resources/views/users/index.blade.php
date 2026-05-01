@extends('layouts.master')

@section('title', 'المستخدمين')

@section('content')
<style>
  /* تصغير حجم الخط العام في الصفحة */
  body, table, th, td, h1, h2, h3, h4, h5, h6, .btn {
    font-size: 13px !important;
  }

  /* تحسين مظهر رأس الجدول */
  table thead {
    background-color: #3c8dbc;
    color: #fff;
    font-size: 13px;
  }

  table tbody td {
    font-size: 13px;
    vertical-align: middle;
  }

  /* تصغير أزرار التحكم */
  .btn-sm {
    padding: 4px 8px !important;
    font-size: 12px !important;
  }

  /* تصغير العنوان الفرعي */
  .content-header h1 small {
    font-size: 12px;
  }
</style>

<section class="content-header">
  <h1>
    إدارة المستخدمين
    <small>عرض جميع المستخدمين</small>
  </h1>
</section>

<section class="content">
  <div class="box box-primary">
    <div class="box-header with-border">
      <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm">
        <i class="fa fa-plus"></i> إضافة مستخدم
      </a>
    </div>
    <div class="box-body">
      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>الصورة</th>
            <th>الاسم</th>
            <th>البلاد</th>
            <th>البريد الإلكتروني</th>
            <th>النوع</th>
            <th>الباقة</th>
            <th>التقييم</th>
            <th>المستندات</th>
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
              @if($user->country)
                <img src="{{ asset('vendor/flag-icons/flags/4x3/' . $user->country->flag_code . '.svg') }}" style="width: 20px; height: 15px; margin-left: 5px;">
                {{ $user->country->name_ar }}
              @else
                -
              @endif
            </td>
            <td>{{ $user->email }}</td>
            <td>
              @php
                $types = ['client'=>'عميل','company'=>'شركة','factory'=>'مصنع','admin'=>'مدير','regional_office'=>'مكتب اقليم','china'=>'الصين'];
              @endphp
              {{ $types[$user->type] ?? '-' }}
            </td>
            <td>
              @if($user->package)
                <span class="label label-success">{{ $user->package->title_ar }}</span>
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
              @if($user->document_pdf)
                <a href="{{ $user->pdf_url }}" target="_blank" class="btn btn-default btn-xs" title="عرض PDF">
                  <i class="fa fa-file-pdf-o text-danger"></i>
                </a>
              @endif

              @if($user->certificates && count($user->certificates) > 0)
                <div style="display: flex; gap: 2px; margin-top: 5px;">
                  @foreach($user->certificate_urls as $url)
                    <a href="{{ $url }}" target="_blank">
                      <img src="{{ $url }}" style="width: 25px; height: 25px; object-fit: cover; border-radius: 2px;">
                    </a>
                  @endforeach
                </div>
              @endif
            </td>
            <td>
              <a href="{{ route('admin.users.edit', $user->id) }}" style="background-color: #3c8dbc; color: white;" class="btn btn-sm">
                <i class="fa fa-edit"></i>
              </a>
              <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline-block">
                @csrf
                @method('DELETE')
                <button onclick="return confirm('هل أنت متأكد من الحذف؟')" style="background-color: #3c8dbc; color: white;" class="btn btn-sm">
                  <i class="fa fa-trash"></i>
                </button>
              </form>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</section>
@endsection
