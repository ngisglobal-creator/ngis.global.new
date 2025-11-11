<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>@yield('title', 'لوحة التحكم | نظام الإدارة')</title>

  <!-- إعداد العرض المتجاوب لجميع الشاشات -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <!-- استدعاء ملف التنسيقات العامة -->
  @include('layouts.styles')
 
  <!-- إمكانية إضافة CSS إضافي من الصفحات -->
  @stack('styles')
</head>

<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">

    {{-- رأس الصفحة (Header) --}}
    @include('layouts.header')

    {{-- الشريط الجانبي (Sidebar) --}}
    @include('layouts.sidebar')

    {{-- المحتوى الرئيسي للصفحة --}}
    <div class="content-wrapper">
      @yield('content')
    </div>

    {{-- التذييل (Footer) --}}
    @include('layouts.footer')

    {{-- الشريط الجانبي الثاني (Sidebar Control Panel) --}}
    @include('layouts.sidebar2')

    <!-- خلفية القائمة الجانبية للتحكم -->
    <div class="control-sidebar-bg"></div>
  </div>

  {{-- ملفات السكربتات (JavaScript) --}}
  @include('layouts.scripts')
</body>
</html>
