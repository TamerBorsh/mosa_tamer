<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="rtl">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Modern admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities with bitcoin dashboard.">
    <meta name="keywords" content="admin template, modern admin template, dashboard template, flat admin template, responsive admin template, web app, crypto dashboard, bitcoin dashboard">
    <meta name="author" content="PIXINVENT">
    <title>تسجيل الدخول | وزارة التنمية الاجتماعية</title>
    <link rel="apple-touch-icon" href="/app-assets/images/ico/apple-icon-120.png">
    <link rel="shortcut icon" type="image/x-icon" href="/app-assets/images/ico/favicon.ico">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/vendors-rtl.min.css">
    <!-- <link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/forms/icheck/icheck.css"> -->
    <!-- <link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/forms/icheck/custom.css"> -->
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="/app-assets/css-rtl/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css-rtl/bootstrap-extended.min.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css-rtl/colors.min.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css-rtl/components.min.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css-rtl/custom-rtl.min.css">
    <!-- END: Theme CSS-->

    <!-- BEGIN: Page CSS-->
    <!-- <link rel="stylesheet" type="text/css" href="/app-assets/css-rtl/core/menu/menu-types/vertical-menu-modern.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css-rtl/core/colors/palette-gradient.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css-rtl/pages/login-register.css"> -->
    <!-- END: Page CSS-->
    <link rel="stylesheet" type="text/css" href="/css/toastr.css">
    <style>
        @font-face {
            font-family: 'JazeeraFont';
            src: url('/fonts/ar.otf');
        }
        body {
            font-family: 'JazeeraFont' !important;
        }
    </style>
</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern 1-column  bg-full-screen-image blank-page" data-open="click" data-menu="vertical-menu-modern" data-col="1-column">
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                @yield('content')
            </div>
        </div>
    </div>
    <!-- END: Content-->
    <!-- BEGIN: Vendor JS-->
    <script src="/app-assets/vendors/js/vendors.min.js"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <!-- <script src="/app-assets/vendors/js/forms/validation/jqBootstrapValidation.js"></script> -->
    <!-- <script src="/app-assets/vendors/js/forms/icheck/icheck.min.js"></script> -->
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <!-- <script src="/app-assets/js/core/app-menu.js"></script> -->
    <!-- <script src="/app-assets/js/core/app.js"></script> -->
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <script src="/app-assets/js/scripts/forms/form-login-register.js"></script>
    <!-- END: Page JS-->
    <script src="/js/toastr.js"></script>
    <script src="/js/axios.min.js"></script>
    @stack('script')
</body>
<!-- END: Body-->

</html>