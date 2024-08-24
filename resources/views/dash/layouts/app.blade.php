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
    <title>@yield('title')</title>
    <link rel="apple-touch-icon" href="/app-assets/images/ico/apple-icon-120.png">
    <link rel="shortcut icon" type="image/x-icon" href="/app-assets/images/ico/favicon.ico">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/vendors-rtl.min.css">

    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="/app-assets/css-rtl/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css-rtl/bootstrap-extended.min.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css-rtl/colors.min.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css-rtl/components.min.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css-rtl/custom-rtl.min.css">
    <!-- END: Theme CSS-->

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="/app-assets/css-rtl/core/menu/menu-types/vertical-menu-modern.min.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css-rtl/core/colors/palette-gradient.min.css">
    <!-- END: Page CSS-->
    <link rel="stylesheet" type="text/css" href="/css/toastr.css">
    <link rel="stylesheet" href="/css/sweetalert2.min.css" />
    <link rel="stylesheet" href="/datatables-bs5/main.css" />

    @yield('stylesheet')
    <style>
        @font-face {
            font-family: 'JazeeraFont';
            src: url('/fonts/ar.otf') format('opentype');
        }

        body,
        .card-body h6,
        li.nav-item,
        h4,
        h3.brand-text,
        h2#swal2-title,
        h5#selectionModalLabel {
            font-family: 'JazeeraFont' !important;
        }

        div#user-table_filter,
        div.dataTables_wrapper div.dataTables_filter {
            float: left;
            text-align: left !important;
        }

        table {
            width: 100% !important;
        }

        li.nav-item.dropdown {
            list-style: none;
        }

        a.nav-link.dropdown-toggle {
            padding: 0;
        }

        .dropdown-toggle::after {
            display: none;
        }
    </style>
</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern 2-columns fixed-navbar menu-collapsed" data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">
<!-- collapsed -->
    <!-- BEGIN: Header-->
    @include('dash.layouts.nav')
    @include('dash.layouts.menu')
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

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

    <!-- BEGIN: Footer-->
    <footer class="footer footer-static footer-light navbar-border navbar-shadow ">
        <p class="clearfix blue-grey lighten-2 text-sm-center mb-0 px-2"><span class="float-md-left d-block d-md-inline-block">الحقوق محفوظة &copy; 2024 <a class="text-bold-800 grey darken-2" href="#" target="_blank">وزارة التنيمة الاجتماعية - غزة</a></span><span class="float-md-right d-none d-lg-block">...<span id="scroll-top"></span></span></p>
    </footer>
    <!-- END: Footer-->

    <!-- BEGIN: Vendor JS-->
    <script src="/app-assets/vendors/js/vendors.min.js"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="/app-assets/js/core/app-menu.min.js"></script>
    <script src="/app-assets/js/core/app.min.js" defer></script>
    <!-- END: Theme JS-->

    <script src="/js/main.js"></script>
    <script src="/js/toastr.js" defer></script>
    <script src="/js/axios.min.js" defer></script>
    <script src="/js/sweetalert2.min.js" defer></script>
    <script src="/datatables-bs5/datatables-bootstrap5.js" defer></script>
    @stack('script')
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const body = document.body;
        const navToggle = document.querySelector('.nav-toggle');

        // استرجاع حالة القائمة من localStorage وتطبيقها على <body>
        const isMenuCollapsed = localStorage.getItem('menu-collapsed');

        // إذا كانت قيمة القائمة محفوظة في localStorage، قم بتطبيقها
        if (isMenuCollapsed === 'false') {
            body.classList.remove('menu-collapsed');
        }

        // إضافة مستمع للضغط على زر القائمة
        navToggle.addEventListener('click', function() {
            // التبديل بين إضافة/إزالة الكلاس "menu-collapsed"
            body.classList.toggle('menu-collapsed');

            // تحديث الحالة في localStorage بناءً على وجود الكلاس
            localStorage.setItem('menu-collapsed', body.classList.contains('menu-collapsed'));
        });
    });
</script>
</body>
<!-- END: Body-->
</html>