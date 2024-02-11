<?php
use \App\Components\Helper;
?>
    <!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <base href="backend/">
    <!-- Favicon -->
    <link rel="icon" href="{{Helper::frontendWithBaseUrl('img/fav.ico')}}" type="image/x-icon"/>
    <link rel="shortcut icon" type="image/x-icon" href="{{Helper::frontendWithBaseUrl('img/fav.ico')}}" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!--Bootstrap.min css-->
    <link rel="stylesheet" href="assets/plugins/bootstrap/css/bootstrap.min.css">

    <!-- Dashboard css -->
    <link href="assets/css/style.css" rel="stylesheet" />

    <!-- Custom scroll bar css-->
    <link href="assets/plugins/scroll-bar/jquery.mCustomScrollbar.css" rel="stylesheet" />

    <!-- Sidemenu css -->
    <link href="assets/plugins/toggle-sidebar/full-sidemenu-dark.css" rel="stylesheet" />

    <!--Daterangepicker css-->
    <link href="assets/plugins/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet" />

    <!-- Sidebar Accordions css -->
    <link href="assets/plugins/accordion1/css/easy-responsive-tabs.css" rel="stylesheet">

    <!-- Rightsidebar css -->
    <link href="assets/plugins/sidebar/sidebar.css" rel="stylesheet">

    <!---Font icons css-->
    <link href="assets/plugins/iconfonts/plugin.css" rel="stylesheet" />
    <link href="assets/plugins/iconfonts/icons.css" rel="stylesheet" />
    <link  href="assets/fonts/fonts/font-awesome.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(to bottom right, #D7BBEA, #65A8F1);
        }
        .page::before, .page::after {
            background: none !important;
        }
    </style>
</head>
<body class="bg-account">
<!-- page -->
<div class="page">
    @yield('content')
</div>
<!-- page End-->

<!-- Jquery js-->
<script src="assets/js/vendors/jquery-3.2.1.min.js"></script>

<!--Bootstrap.min js-->
<script src="assets/plugins/bootstrap/popper.min.js"></script>
<script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>


<!-- Custom js-->
<script src="assets/js/custom.js"></script>
</body>
</html>
