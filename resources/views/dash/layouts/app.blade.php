<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="rtl">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>@yield('title')</title>
    <link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/vendors-rtl.min.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css-rtl/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css-rtl/bootstrap-extended.min.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css-rtl/components.min.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css-rtl/core/menu/menu-types/vertical-menu-modern.min.css">
    <link rel="stylesheet" type="text/css" href="/css/toastr.css">
    <link rel="stylesheet" href="/css/sweetalert2.min.css" />
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

<body class="vertical-layout vertical-menu-modern 2-columns fixed-navbar menu-collapsed" data-open="click" data-menu="vertical-menu-modern" data-col="2-columns"> @include('dash.layouts.nav') @include('dash.layouts.menu') <div class="app-content content">
    <div class="content-overlay"></div><div class="content-wrapper"><div class="content-header row"> </div><div class="content-body"> @yield('content') </div></div></div><div class="sidenav-overlay"></div><div class="drag-target"></div>
    <footer class="footer footer-static footer-light navbar-border navbar-shadow "><p class="clearfix blue-grey lighten-2 text-sm-center mb-0 px-2"><span class="float-md-left d-block d-md-inline-block">الحقوق محفوظة &copy; 2024 <a class="text-bold-800 grey darken-2" href="#" target="_blank">وزارة التنيمة الاجتماعية - غزة</a></span><span class="float-md-right d-none d-lg-block">...<span id="scroll-top"></span></span></p></footer>
    <script src="/app-assets/vendors/js/vendors.min.js"></script><script src="/app-assets/js/core/app-menu.min.js"></script><script src="/app-assets/js/core/app.min.js" defer></script><script src="/js/main.js"></script><script src="/js/toastr.js" defer></script><script src="/js/axios.min.js" defer></script><script src="/js/sweetalert2.min.js" defer></script> @stack('script')
</body>
</html>