<?php
use \App\Components\Helper;
$identity=auth()->guest() ? null : auth()->user();
?>
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr">
<head>
    <meta charset="UTF-8">
    <base href="{{Helper::withAppUrl('backend/')}}">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Favicon -->
    <link rel="icon" href="{{Helper::frontendWithBaseUrl('img/fav.ico')}}" type="image/x-icon"/>
    <link rel="shortcut icon" type="image/x-icon" href="{{Helper::frontendWithBaseUrl('img/fav.ico')}}" />

    <!-- Title -->
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!--Bootstrap.min css-->
    <link rel="stylesheet" href="assets/plugins/bootstrap/css/bootstrap.min.css">

    <!-- Dashboard css -->
    <link href="assets/css/style.css" rel="stylesheet" />

    <!-- Custom scroll bar css-->
    <link href="assets/plugins/scroll-bar/jquery.mCustomScrollbar.css" rel="stylesheet" />

    <!-- Sidemenu css -->
    <link href="assets/plugins/toggle-sidebar/full-sidemenu.css" rel="stylesheet" />

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

    <link rel="stylesheet" href="//cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">
    <link href="assets/css/main.css?v={{env('APP_VERSION')}}" rel="stylesheet">
    @yield('pageCss')

</head>

<body class="app sidebar-mini rtl">

<!--Global-Loader-->
<div id="global-loader">
    <img src="assets/images/icons/loader.svg" alt="loader">
</div>

<div class="page">
    <div class="page-main">
        <!--app-header-->
        <div class="app-header header d-flex">
            <div class="container-fluid">
                <div class="d-flex">
                    <a class="header-brand" href="{{Helper::dashboardLink()}}">
                        <img src="{{Helper::frontendWithBaseUrl('img/logo.png')}}" class="header-brand-img main-logo" alt="{{env('APP_NAME')}}">
                        <img src="{{Helper::frontendWithBaseUrl('img/fav.ico')}}" class="header-brand-img icon-logo" alt="{{env('APP_NAME')}}">
                    </a><!-- logo-->
                    <a aria-label="Hide Sidebar" class="app-sidebar__toggle" data-toggle="sidebar"
                       href="javascript:void(0);"></a>

                    <div class="d-flex order-lg-2 ml-auto header-rightmenu">
                        <div class="dropdown">
                            <a  class="nav-link icon full-screen-link" id="fullscreen-button">
                                <i class="fe fe-maximize-2"></i>
                            </a>
                        </div><!-- full-screen -->
                        <div class="dropdown header-notify">
                            {{-- <a class="nav-link icon" data-toggle="dropdown" aria-expanded="false">
                                <i class="fe fe-bell "></i>
                                <span class="pulse bg-success"></span>
                            </a> --}}
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow ">
                                <a href="#" class="dropdown-item text-center">4 New Notifications</a>
                                <div class="dropdown-divider"></div>
                                <a href="#" class="dropdown-item d-flex pb-3">
                                    <div class="notifyimg bg-green">
                                        <i class="fe fe-mail"></i>
                                    </div>
                                    <div>
                                        <strong>Message Sent.</strong>
                                        <div class="small text-muted">12 mins ago</div>
                                    </div>
                                </a>
                                <a href="#" class="dropdown-item d-flex pb-3">
                                    <div class="notifyimg bg-pink">
                                        <i class="fe fe-shopping-cart"></i>
                                    </div>
                                    <div>
                                        <strong>Order Placed</strong>
                                        <div class="small text-muted">2  hour ago</div>
                                    </div>
                                </a>
                                <a href="#" class="dropdown-item d-flex pb-3">
                                    <div class="notifyimg bg-blue">
                                        <i class="fe fe-calendar"></i>
                                    </div>
                                    <div>
                                        <strong> Event Started</strong>
                                        <div class="small text-muted">1  hour ago</div>
                                    </div>
                                </a>
                                <a href="#" class="dropdown-item d-flex pb-3">
                                    <div class="notifyimg bg-orange">
                                        <i class="fe fe-monitor"></i>
                                    </div>
                                    <div>
                                        <strong>Your Admin Lanuch</strong>
                                        <div class="small text-muted">2  days ago</div>
                                    </div>
                                </a>
                                <div class="dropdown-divider"></div>
                                <a href="#" class="dropdown-item text-center">View all Notifications</a>
                            </div>
                        </div><!-- notifications -->

                        {{-- <div class="dropdown header-user">
                            <a class="nav-link leading-none siderbar-link" href="javascript:void(0);"  data-toggle="sidebar-right" data-target=".sidebar-right">
                                <span class="mr-3 d-none d-lg-block ">
                                    <span class="text-gray-white"><span class="ml-2">{{__($identity ? $identity->displayName : 'Guest')}}</span></span>
                                </span>
                                <span class="avatar avatar-md brround"><img src="{{__($identity ? $identity->profilePic : 'assets/images/users/female/33.png')}}" alt="Profile-img" class="avatar avatar-md brround"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                <div class="header-user text-center mt-4 pb-4">
                                    <span class="avatar avatar-xxl brround"><img src="{{__($identity ? $identity->profilePic : 'assets/images/users/female/33.png')}}" alt="Profile-img" class="avatar avatar-xxl brround"></span>
                                    <a href="javascript:void(0);" class="dropdown-item text-center font-weight-semibold user h3 mb-0">{{__($identity ? $identity->displayName : 'Guest')}}</a>
                                    <small>{{__($identity ? $identity->role->name : 'Guest')}}</small>
                                </div>
                                <div class="card-body border-top">
                                    <div class="row">
                                        <div class="col-6 text-center">
                                            <a class="" href="{{Helper::dashboardLink()}}"><i class="dropdown-icon mdi  mdi-message-outline fs-30 m-0 leading-tight"></i></a>
                                            <div>Dashboard</div>
                                        </div>
                                        <div class="col-6 text-center">
                                            <a class="" href="javascript:void(0);" onclick="logout();"><i class="dropdown-icon mdi mdi-logout-variant fs-30 m-0 leading-tight"></i></a>
                                            <div>Logout</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>  --}}
                        {{-- <div class="dropdown">
                            <a  class="nav-link icon siderbar-link" data-toggle="sidebar-right" data-target=".sidebar-right">
                                <i class="fe fe-more-horizontal"></i>
                            </a>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
        <!--app-header end-->

        <!-- Sidebar menu-->
        <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
        <aside class="app-sidebar toggle-sidebar">
            <div class="app-sidebar__user pb-0">
                <div class="user-body">
                    <span class="avatar avatar-xxl brround text-center cover-image" data-image-src="{{__($identity ? $identity->profilePic : 'assets/images/users/female/33.png')}}"></span>
                </div>
                {{-- <div class="user-info">
                    <a href="{{Helper::dashboardLink()}}" class="ml-2">
                        <span class="text-dark app-sidebar__user-name font-weight-semibold">{{__($identity ? $identity->displayName : 'Guest')}}</span><br>
                        <span class="text-muted app-sidebar__user-name text-sm"> {{__($identity ? $identity->role->name : 'Guest')}}</span>
                    </a>
                </div> --}}
            </div>

            <div class="tab-menu-heading siderbar-tabs border-0  p-0">
                <div class="tabs-menu ">
                    <!-- Tabs -->
                    <ul class="nav panel-tabs">
                        {{-- <li class="">
                            <a href="{{Helper::dashboardLink()}}"><i class="fa fa-home fs-17"></i></a>
                        </li> --}}
                        <li><a href="{{route('profile')}}"><i class="fa fa-user fs-17"></i></a></li>
                        <li><a href="javascript:void(0);" onclick="logout();" title="logout"><i class="fa fa-power-off fs-17"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="panel-body tabs-menu-body side-tab-body p-0 border-0 ">
                <div class="tab-content">
                    <div class="tab-pane active " id="index1">
                        <ul class="side-menu toggle-menu">
                            <?php
                            if($identity) {
                                ?>
                                {{-- <li>
                                    <a class="side-menu__item" href="{{Helper::dashboardLink()}}">
                                        <i class="side-menu__icon typcn typcn-device-desktop"></i><span class="side-menu__label">Dashboard</span>
                                    </a>
                                </li> --}}
                                <?php
                                if($identity->role->id==\App\Constants\UserConstants::ROLE_ADMIN) {
                                    ?>
                                    <li>
                                        <a class="side-menu__item" href="{{route('user.index')}}">
                                            <i class="side-menu__icon fa fa-users fs-17"></i><span class="side-menu__label">Users</span>
                                        </a>
                                    </li>

                                    <li>
                                        <a class="side-menu__item" href="{{route('parties')}}">
                                            <i class="side-menu__icon fa fa-users fs-17"></i><span class="side-menu__label">Parties</span>
                                        </a>
                                    </li>


                                    <li>
                                        <a class="side-menu__item" href="{{route('state')}}">
                                            <i class="side-menu__icon fa fa-users fs-17"></i><span class="side-menu__label">State & City</span>
                                        </a>
                                    </li>

                                    {{-- <li>
                                        <a class="side-menu__item" href="{{route('setting.index')}}">
                                            <i class="side-menu__icon fa fa-gears fs-17"></i><span class="side-menu__label">Global Settings</span>
                                        </a>
                                    </li> --}}
                                    <?php
                                }
                                ?>
                                <li>
                                    <a class="side-menu__item" href="javascript:void(0);" onclick="logout();" title="logout">
                                        <i class="side-menu__icon fa fa-power-off fs-17"></i>
                                        <span class="side-menu__label">Logout</span>
                                    </a>
                                </li>
                                <?php
                            }
                            ?>
                            <!--<li class="slide">
                                <a class="side-menu__item" data-toggle="slide" href="#"><i class="side-menu__icon typcn typcn-info-outline"></i><span class="side-menu__label">Error Pages</span><i class="angle fa fa-angle-right"></i></a>
                                <ul class="slide-menu">
                                    <li><a href="400.html" class="slide-item"> 400 Error</a></li>
                                    <li><a href="401.html" class="slide-item"> 401 Error</a></li>
                                    <li><a href="403.html" class="slide-item"> 403 Error</a></li>
                                    <li><a href="404.html" class="slide-item"> 404 Error</a></li>
                                    <li><a href="500.html" class="slide-item"> 500 Error</a></li>
                                    <li><a href="503.html" class="slide-item"> 503 Error</a></li>
                                </ul>
                            </li>-->
                        </ul>
                    </div>
                </div>
            </div>
        </aside>
        <!--sidemenu end-->

        <!-- app-content-->
        <div class="app-content  my-3 my-md-5 toggle-content">

            @yield('content')
            <!-- Right-sidebar-->
            <div class="sidebar sidebar-right sidebar-animate">
                <div class="panel-body tabs-menu-body side-tab-body p-0 border-0 ">
                    <div class="tab-content border-top">
                        <div class="tab-pane active" id="tab">
                            <div class="card-body p-0">
                                <div class="header-user text-center mt-4 pb-4">
                                    <span class="avatar avatar-xxl brround"><img src="{{__($identity ? $identity->profilePic : 'assets/images/users/female/33.png')}}" alt="Profile-img" class="avatar avatar-xxl brround"></span>
                                    <div class="dropdown-item text-center font-weight-semibold user h3 mb-0">{{__($identity ? $identity->displayName : 'Guest')}}</div>
                                    <small>{{__($identity ? $identity->role->name : 'Guest')}}</small>
                                </div>
                                <div class="card-body border-top">
                                    <div class="row">
                                        <div class="col-4 text-center">
                                            <a class="" href="{{Helper::dashboardLink()}}"><i class="dropdown-icon mdi  mdi-view-dashboard fs-30 m-0 leading-tight"></i></a>
                                            <div>Dashboard</div>
                                        </div>
                                        <div class="col-4 text-center">
                                            <a class="" href="{{route('setting.index')}}"><i class="dropdown-icon mdi mdi-tune fs-30 m-0 leading-tight"></i></a>
                                            <div>Settings</div>
                                        </div>
                                        <div class="col-4 text-center">
                                            <a class="" href="javascript:void(0);" onclick="logout();"><i class="dropdown-icon mdi mdi-logout-variant fs-30 m-0 leading-tight"></i></a>
                                            <div>Sign out</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- End Rightsidebar-->

            <!--footer-->
            <footer class="footer">
                <div class="container">
                    <div class="row align-items-center flex-row-reverse">
                        {{-- <div class="col-lg-12 col-sm-12   text-center">
                            Copyright © {{date("Y")}} <a href="#">{{env('APP_NAME')}}</a>. Developed by <a target="_blank" href="https://teamOxio.com/">teamOxio Technologies Pvt. Ltd.</a> All rights reserved.
                        </div> --}}
                    </div>
                </div>
            </footer>
            <!-- End Footer-->

        </div>
        <!-- End app-content-->
    </div>
</div>
<!-- End Page -->

<!-- Back to top -->
<a href="#top" id="back-to-top"><i class="fa fa-angle-up"></i></a>

<!-- Jquery js-->
<script src="assets/js/vendors/jquery-3.2.1.min.js"></script>

<!--Bootstrap.min js-->
<script src="assets/plugins/bootstrap/popper.min.js"></script>
<script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>

<!--Jquery Sparkline js-->
<script src="assets/js/vendors/jquery.sparkline.min.js"></script>

<!-- Chart Circle js-->
<script src="assets/js/vendors/circle-progress.min.js"></script>

<!-- Star Rating js-->
<script src="assets/plugins/rating/jquery.rating-stars.js"></script>

<!--Moment js-->
<script src="assets/plugins/moment/moment.min.js"></script>

<!-- Daterangepicker js-->
<script src="assets/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>

<!--Side-menu js-->
<script src="assets/plugins/toggle-sidebar/sidemenu.js"></script>

<!-- Sidebar Accordions js -->
<script src="assets/plugins/accordion1/js/easyResponsiveTabs.js"></script>

<!-- Custom scroll bar js-->
<script src="assets/plugins/scroll-bar/jquery.mCustomScrollbar.concat.min.js"></script>

<!-- Rightsidebar js -->
<script src="assets/plugins/sidebar/sidebar.js"></script>

<!--Time Counter js-->
<script src="assets/plugins/counters/jquery.missofis-countdown.js"></script>
<script src="assets/plugins/counters/counter.js"></script>

<!-- Charts js-->
<script src="assets/plugins/chart/chart.bundle.js"></script>
<script src="assets/plugins/chart/utils.js"></script>

<!--Peitychart js-->
<script src="assets/plugins/peitychart/jquery.peity.min.js"></script>
<script src="assets/plugins/peitychart/peitychart.init.js"></script>

<!-- Custom-charts js-->
<script src="assets/js/index3.js"></script>

<!-- Custom js-->
<script src="assets/js/custom.js"></script>

@include('layouts._backend')

@yield('pageJs')
</body>
</html>
