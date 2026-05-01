<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>@yield('title', 'لوحة تحكم العميل | نظام الإدارة')</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  @include('layouts.styles')
  @stack('styles')
</head>
<body class="hold-transition skin-green sidebar-mini">
  <div class="wrapper">
    @include('client.layouts.header')
    @include('client.layouts.sidebar')
    <div class="content-wrapper">
      @yield('content')
    </div>
    @include('layouts.footer')
    @include('layouts.sidebar2')
    <div class="control-sidebar-bg"></div>
  </div>
  @include('layouts.scripts')
  @stack('scripts')
</body>
</html>
