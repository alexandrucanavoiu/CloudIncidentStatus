<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Log in</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="/login_files/css/bootstrap.min.css">
    <link rel="stylesheet" href="/login_files/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/login_files/Ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="/login_files/css/login.min.css">
    <link rel="stylesheet" href="/login_files/iCheck/square/blue.css">
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
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
</head>
<body class="hold-transition login-page">
@yield('content')
<script src="/login_files/js/jquery.min.js"></script>
<script src="/login_files/js/bootstrap.min.js"></script>
<script src="/login_files/iCheck/icheck.min.js"></script>
<script>
    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' /* optional */
        });
    });
</script>
</body>
</html>
