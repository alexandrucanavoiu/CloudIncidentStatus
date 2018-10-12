<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/app.css">
    <link href="/files/fontawesome/all.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/sweetalert2.min.css">
    <link href="https://fonts.googleapis.com/css?family=Work+Sans" rel="stylesheet">
    <title>@yield('title') - {{ \App\Helpers\Navigation::site_name() }}</title>
</head>
<body>
<div class="header-subscribe custom-header">
    <div class="container">
        <div class="row">
            <div class="col-sm">
                <a href="/"><img src="/images/{{ $settings->settings_logo }}" /></a>
            </div>
            <button type="button" class="btn btn-primary active subscribe-new" data-toggle="modal" data-target="#myModal-Subscribe-new"><i class="fas fa-mail-bulk"></i> Subscribe for Updates</button>
        </div>
    </div>
</div>

    <div class="container">
        @yield('content')
    </div>

    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="margin-10">
                    <ul class="list-inline">
                        @foreach($footer_url as $footer)
                        <li>
                            <a class="" target="_blank" href="{{ $footer->footer_url }}">{{ $footer->footer_title }}</a>
                        </li>
                        @endforeach
                        <li>
                            <a target="_blank" href="https://status.marketingromania.ro/history.atom" class="" >Atom Feed</a>
                        </li>
                    </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>
<script src="/js/jquery-3.1.1.min.js"></script>
<script src="/js//popper.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script src="/js/sweetalert2.all.min.js"></script>
<script src="/js/all.js"></script>
<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
@include('layouts.message')
</body>
</html>