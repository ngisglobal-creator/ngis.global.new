<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>@yield('title', 'المنتجات | نظام الإدارة')</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  @include('layouts.styles')
  <style>
      .main-header .navbar {
          margin-left: 0 !important;
      }
      .content-wrapper {
          margin-left: 0 !important;
      }
      .main-footer {
          margin-left: 0 !important;
      }
      @media (max-width: 767px) {
          .content-wrapper, .main-footer {
              margin-left: 0 !important;
          }
      }
      .col-md-5th {
          width: 20%;
          float: right;
          position: relative;
          min-height: 1px;
          padding-right: 15px;
          padding-left: 15px;
      }
      @media (max-width: 1200px) {
          .col-md-5th {
              width: 25%;
          }
      }
      @media (max-width: 991px) {
          .col-md-5th {
              width: 33.3333%;
          }
      }
      @media (max-width: 767px) {
          .col-md-5th {
              width: 50%;
          }
      }
      @media (max-width: 480px) {
          .col-md-5th {
              width: 100%;
          }
      }
  </style>
  @stack('styles')
</head>
<body class="hold-transition skin-blue layout-top-nav">
<div class="wrapper">
  @include('layouts.public_header')
  
  <div class="content-wrapper">
    <div class="container-fluid">
      @yield('content')
    </div>
  </div>
  
  @include('layouts.footer')
</div>

@include('layouts.scripts')
@stack('scripts')
</body>
</html>
