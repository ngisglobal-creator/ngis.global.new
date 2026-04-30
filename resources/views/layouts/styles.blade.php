<!-- Bootstrap 3.3.7 -->
<link rel="stylesheet" href="{{ asset('dist/css/bootstrap-theme.css') }}">

<!-- Bootstrap RTL -->
<link rel="stylesheet" href="{{ asset('dist/css/rtl.css') }}">

<!-- Persian Date Picker -->
<link rel="stylesheet" href="{{ asset('dist/css/persian-datepicker-0.4.5.min.css') }}">

<!-- Font Awesome -->
<link rel="stylesheet" href="{{ asset('vendor/flag-icons/css/flag-icons.min.css') }}">
<link rel="stylesheet" href="{{ asset('bower_components/font-awesome/css/font-awesome.min.css') }}">

<link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}">
<!-- Ionicons -->
<link rel="stylesheet" href="{{ asset('bower_components/Ionicons/css/ionicons.min.css') }}">

<!-- Theme style -->
<link rel="stylesheet" href="{{ asset('dist/css/AdminLTE.css') }}">

<!-- AdminLTE Skins -->
<link rel="stylesheet" href="{{ asset('dist/css/skins/_all-skins.min.css') }}">

<!-- Morris chart -->
<link rel="stylesheet" href="{{ asset('bower_components/morris.js/morris.css') }}">

<!-- jvectormap -->
<link rel="stylesheet" href="{{ asset('bower_components/jvectormap/jquery-jvectormap.css') }}">

<!-- Daterange picker -->
<link rel="stylesheet" href="{{ asset('bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">

<!-- bootstrap wysihtml5 -->
<link rel="stylesheet" href="{{ asset('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}">

<!-- Google Font -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&family=Cairo:wght@400;600;700;900&family=Almarai:wght@300;400;700;800&display=swap" rel="stylesheet">

<style>
    /* ============================================
       BULLETPROOF: Force Western (Latin) Digits
       Prevents Arabic fonts from showing ١٢٣
    ============================================ */

    /*
     * Step 1: Declare a virtual font that ONLY applies to digit characters.
     *         The browser will use Inter (a Latin font) for 0-9 digits,
     *         even when the surrounding text is in Arabic.
     */
    @font-face {
        font-family: 'LatinDigits';
        src: local('Inter'), local('Arial'), local('Helvetica');
        unicode-range: U+0030-0039, U+002E, U+002C, U+0025, U+0020;
    }

    /* استخدام خط Cairo كخط أساسي داكن وعادي */
    *, *::before, *::after {
        font-family: 'LatinDigits', 'Inter', 'Cairo', 'Almarai', sans-serif;
    }

    body {
        font-variant-numeric: lining-nums !important;
        -webkit-font-feature-settings: "lnum" 1 !important;
        font-feature-settings: "lnum" 1 !important;
        color: #111111 !important; /* لون نص داكن وواضح */
    }

    /* تحسين مظهر الأيقونات الخاصة بالمشروع */
    .fa, .ion {
        color: #2b6688; /* لون أيقونات احترافي */
        margin-left: 5px;
    }

    .sidebar-menu .fa {
        color: #cbd5e1; /* لون أخف للأيقونات في الشريط الجانبي */
    }

    .active .fa {
        color: #ffffff !important;
    }

    /*
     * Step 3: Explicit class for 100% guarantee on important numeric elements.
     */
    .english-nums, .price, .count, .qty, .amount {
        font-family: 'LatinDigits', 'Inter', Arial, sans-serif !important;
        font-variant-numeric: lining-nums tabular-nums !important;
        -webkit-font-feature-settings: "lnum" 1, "tnum" 1 !important;
        font-feature-settings: "lnum" 1, "tnum" 1 !important;
        direction: ltr;
        unicode-bidi: isolate;
    }
    /* Modern Premium UI Overrides */
    .box {
        border-radius: 12px !important;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06) !important;
        border: 1px solid rgba(0,0,0,0.02) !important;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        overflow: hidden;
    }
    .box-header {
        border-bottom: 1px solid #f4f7f6 !important;
        padding: 15px 20px !important;
    }
    .box-title {
        font-weight: 800 !important;
        letter-spacing: -0.5px;
    }
    .main-sidebar {
        box-shadow: 10px 0 30px rgba(0,0,0,0.03);
    }
    .content-wrapper {
        background-color: #f8fafc !important;
    }
    .btn {
        border-radius: 8px !important;
        font-weight: 600 !important;
        padding: 8px 20px !important;
        transition: all 0.2s;
    }
    .btn-primary {
        background: linear-gradient(135deg, #3c8dbc 0%, #2b6688 100%) !important;
        border: none !important;
        box-shadow: 0 4px 12px rgba(60, 141, 188, 0.25);
    }
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(60, 141, 188, 0.35);
    }
    
    /* Modern Tables */
    .table-bordered {
        border-radius: 10px !important;
        overflow: hidden;
        border: 1px solid #eee !important;
    }
    .table thead th {
        background: #f1f5f9 !important;
        border-bottom: 2px solid #e2e8f0 !important;
        text-transform: uppercase;
        font-size: 11px;
        letter-spacing: 0.5px;
        color: #64748b;
    }

    /* Fix Content Distortion */
    .content-header {
        padding: 25px 15px 10px 15px !important;
    }
    .content {
        padding: 15px !important;
    }
</style>



<!-- bootstrap datepicker -->
<link rel="stylesheet" href="{{ asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">

<!-- iCheck for checkboxes and radio inputs -->
<link rel="stylesheet" href="{{ asset('plugins/iCheck/all.css') }}">

<!-- Bootstrap Color Picker -->
<link rel="stylesheet" href="{{ asset('bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}">

<!-- Bootstrap time Picker -->
<link rel="stylesheet" href="{{ asset('plugins/timepicker/bootstrap-timepicker.min.css') }}">
