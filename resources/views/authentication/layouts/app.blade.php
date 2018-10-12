<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title') | {{ \App\Helpers\Navigation::site_name() }}</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="/authentication/css/bootstrap.min.css">
    <link rel="stylesheet" href="/authentication/css/admintheme.css">
    <link rel="stylesheet" href="/authentication/css/skin-blue.css">
    <link rel="stylesheet" href="/authentication/css/custom.css">
    <link rel="stylesheet" href="/authentication/css/select2.min.css">
    <link rel="stylesheet" href="/authentication/plugins/iCheck/square/blue.css">
    <link rel="stylesheet" href="/authentication/plugins/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/authentication/plugins/Ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="/authentication/plugins/morris.js/morris.css">
    <link rel="stylesheet" href="/authentication/plugins/toastr/toastr.min.css">
    <link rel="stylesheet" href="/authentication/plugins/datetimepicker/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" href="/authentication/plugins/knockout-file-bindings/knockout-file-bindings.css">
    <link rel="stylesheet" href="/authentication/plugins/jvectormap/jquery-jvectormap.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    @if(\App\Helpers\Navigation::google_analytics_code() !== null || !empty(\App\Helpers\Navigation::google_analytics_code()))
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
        ga('create', '{{ \App\Helpers\Navigation::google_analytics_code() }}', 'auto');
        ga('send', 'pageview');
    </script>
    @endif
    @yield('scripts-header')
    <![endif]-->
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
    <header class="main-header">
        <a href="/admin/dashboard" class="logo">
            <span class="logo-mini"><b>S</b>YS</span>
           <span class="logo-lg"><img src="/authentication/images/logo.png" width="90%"></span>
        </a>
    </header>
    @include('authentication.layouts.menu')
    <div class="content-wrapper">
        @yield('content')
    </div>
    @include('authentication.layouts.footer')
    <div class="control-sidebar-bg"></div>
</div>
<script src="/authentication/js/jquery.min.js"></script>
<script src="/authentication/plugins/jquery-ui.js"></script>
<script src="/authentication/js/bootstrap.min.js"></script>
<script src="/authentication/js/admintheme.min.js"></script>
<script src="/authentication/plugins/toastr/toastr.min.js"></script>
<script src="/authentication/plugins/datetimepicker/bootstrap-datetimepicker.min.js"></script>
<script src="/authentication/plugins/fastclick/lib/fastclick.js"></script>
<script src="/authentication/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="/authentication/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<script src="/authentication/plugins/knockout/knockout-min.js"></script>
<script src="/authentication/plugins/knockout/knockout-file-bindings.js"></script>
<script src="/authentication/plugins/html5shiv.min.js"></script>
<script src="/authentication/plugins/respond.min.js"></script>
<script src="/authentication/js/custom.js"></script>
<script src="/authentication/js/select2.full.min.js"></script>
<script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
<script src="/vendor/unisharp/laravel-ckeditor/adapters/jquery.js"></script>
<script src="/authentication/js/jquery.sparkline.min.js"></script>
<script src="/authentication/js/jquery.slimscroll.min.js"></script>
<script src="/authentication/plugins/morris.js/morris.min.js"></script>
<script src="/authentication/plugins/raphael/raphael.min.js"></script>
@yield('scripts-footer')
@include('authentication.layouts.message')
</body>
</html>
