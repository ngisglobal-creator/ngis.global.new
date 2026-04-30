<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>@yield('title', 'لوحة تحكم NGIS | نظام الإدارة')</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  @include('layouts.styles')
  @stack('styles')
</head>
<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">
    @include('ngis.layouts.header')
    @include('ngis.layouts.sidebar')
    <div class="content-wrapper">
      <section class="content-header">
        @yield('content-header')
      </section>
      <section class="content">
        @yield('content')
      </section>
    </div>
    @include('layouts.footer')
    <div class="control-sidebar-bg"></div>
  </div>
  @include('layouts.scripts')
  @stack('scripts')
</body>
</html>
