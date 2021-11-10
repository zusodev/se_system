<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <?php
    $appName = isset($appName) ? $appName : config('app.name', 'Laravel');
    ?>
    <title>{{ $appName }}</title>
    <link rel="stylesheet" href="{{ asset("css/materialdesignicons.min.css") }}">
    <link rel="stylesheet" href="{{ asset("css/vendor.bundle.base.css") }}">
    <link rel="stylesheet" href="{{ asset("css/style.css") }}">
    <link rel="stylesheet" href="{{ asset("fontawesome/all.min.css") }}">
    <link rel="stylesheet" href="{{ asset("css/custom.css") }}">
    @yield("head")
</head>
<body id="page-top">
<?php
$routeName = request()->route()->getName();
$routeName = explode(".", $routeName);
?>

<div class="container-scroller" id="layout-content">
    <!-- partial:../../partials/_horizontal-navbar.html -->
    <div class="horizontal-menu">
        <nav class="navbar top-navbar col-lg-12 col-12 p-0">
            <div class="container">
                @include("layouts.layout-template.header")
            </div>
        </nav>
        @include("layouts.layout-template.menu")
    </div>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
        <div class="main-panel">
            <div class="content-wrapper">
                @yield("content")
            </div>
            <!-- content-wrapper ends -->
            <!-- partial:../../partials/_footer.html -->
        @include("layouts.layout-template.footer")
        <!-- partial -->
        </div>
        <!-- main-panel ends -->
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
{{--
template.js 解析 menu
--}}
<script src="{{ asset("js/template.js") }}"></script>
<script src="{{ asset("js/settings.js") }}"></script>
<script src="{{ asset("js/todolist.js") }}"></script>
<!-- endinject -->
<!-- Custom js for this page-->
<script src="{{ asset("js/file-upload.js") }}"></script>

<!-- End custom js for this page-->
<script src="{{ asset("js/ramda.min.js") }}"></script>

@yield("javascript")
</body>
</html>
