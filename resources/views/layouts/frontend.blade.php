<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr">
<head>
    <meta charset="utf-8">
    <base href="frontend/">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">


    <link rel="icon" href="img/fav.ico" sizes="any">

    <!-- Template Styles Start -->
    <link rel="stylesheet" type="text/css" href="css/loaders/loader-light.css">
    <link rel="stylesheet" type="text/css" href="css/plugins.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/colors/color-light.css">
    <!-- Template Styles End -->

</head>

<body>

<!-- Main Section Start -->
<section id="main" class="main active-section">
    <div class="container-fluid p-0 fullheight">
        <div class="row g-0 fullheight">

            <!-- Main Section Intro (left on desktop) Start -->
            <div class="col-12 col-xl-6 main__intro">
                <!-- Main Intro SVG background -->
                <div class="color-layer color-layer-svg color-layer-svg-main"></div>

                <!-- Headline Start -->
                <div class="intro__headline">
                    @yield('content')
                </div>
                <!-- Headline End -->

                <div class="intro__socials">
                    <ul class="socials socials-text">
                        <li>
                            <a href="https://www.facebook.com/" target="_blank" class="link-s">Facebook</a>
                        </li>
                    </ul>
                </div>
                <div class="intro__copyright">
                    <p class="copyright">
                        <a href="javascript:;" target="_blank" class="link-s">&copy; {{date("Y")}}, </a> All rights reserved
                    </p>
                </div>

            </div>
            <div class="col-12 col-xl-6 main__media">
                <div class="media__content">
                    <div class="media__image media-bg-3"></div>
                    <div class="color-layer color-layer-gradient"></div>
                    <div class="media__countdown">
                        <div id="countdown">
                            @guest
                            <a style="color: #fff !important;" href="{{route('login')}}" class="btn btn-outline-primary btn-custom text-white">
                                Login
                            </a> <a class="btn btn-outline-primary" style="color: #fff !important;cursor: none;" href="javascript:void(0);"> / </a>
                            <a style="color: #fff !important;" href="{{route('register')}}" class="btn btn-outline-primary btn-custom text-white">
                                Register
                            </a>
                            @else
                                <a style="color: #fff !important;" class="btn btn-outline-primary btn-custom text-white" href="javascript:void(0);" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>
                                <a style="color: #e23e3d !important;font-size: 20px;" class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            @endguest
                        </div>
                    </div>

                </div>
                <div class="media__cover color-layer color-layer-gradient"></div>
            </div>


        </div>
    </div>
</section>
<!-- Main Section End -->

<div class="cursor"></div>
<script src="js/libs.min.js"></script>
<script src="js/gallery-init.js"></script>
<script src="js/custom.js"></script>
</body>
</html>
