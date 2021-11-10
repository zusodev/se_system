<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <?php
    $appName = config('app.name', '');
    ?>
    <title>{{ $appName }}</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset("css/materialdesignicons.min.css") }}">
    <link rel="stylesheet" href="{{ asset("css/vendor.bundle.base.css") }}">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset("css/style.css") }}">
    <link rel="stylesheet" href="{{ asset("css/jquery.toast.min.css") }}">
    @yield('head')
</head>
<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-stretch auth auth-img-bg">
                <div class="row flex-grow">
                    <div class="col-lg-6 d-flex align-items-center justify-content-center">
                        @yield('content')
                    </div>
                    <div class="col-lg-6 d-flex flex-row @yield('bg')">
                        <p class="text-white font-weight-medium text-center flex-grow align-self-end">
                        {{env("LOGIN_TEXT")}}
<!--                            Copyright © 2020 ZUSO Generation 如梭世代有限公司({{env("LOGIN_TEXT")}}) All rights reserved.-->
                        </p>
                    </div>
                </div>
            </div>
            <!-- content-wrapper ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="{{ asset("js/vendor.bundle.base.js") }}"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="{{ asset("js/off-canvas.js") }}"></script>
    <script src="{{ asset("js/hoverable-collapse.js") }}"></script>
    <script src="{{ asset("js/template.js") }}"></script>
    <script src="{{ asset("js/settings.js") }}"></script>
    <script src="{{ asset("js/todolist.js") }}"></script>
    <script src="{{ asset("js/jquery.toast.min.js") }}"></script>
    <!-- endinject -->
    @yield("javascripts")
</body>
</html>
