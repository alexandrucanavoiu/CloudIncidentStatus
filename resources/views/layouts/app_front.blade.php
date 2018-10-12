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
    <title>@yield('title') - {{ \App\Helpers\Navigation::site_name() }}</title>
</head>
<body>
<div class="header custom-header">
    <div class="container">
        <div class="row">
            <div class="col-sm">
                <a href="/"><img src="/images/{{ $settings->settings_logo }}" /></a>
            </div>
            <button type="button" class="btn btn-primary active subscribe-new" data-toggle="modal" data-target="#myModal-Subscribe-new"><i class="fas fa-mail-bulk"></i> Subscribe for Updates</button>
        </div>
        <div class="row header-components-incidents">
            @if($components_status !== null)
                        @if($components_status->component_statuses_id == 1)
                            <div class="page-status-none">
                                <span class="status">All systems are operational</span>
                            </div>
                        @elseif($components_status->component_statuses_id == 2)
                                        <div class="page-status-blue">
                                            <span class="status">Some systems are experiencing issues</span>
                                        </div>
                         @elseif($components_status->component_statuses_id == 3)
                                    <div class="page-status-blue">
                                        <span class="status">Some systems are experiencing issues</span>
                                    </div>
                          @elseif($components_status->component_statuses_id == 4)
                                <div class="page-status-red">
                                    <span class="status">Some systems are experiencing issues</span>
                                </div>
                            @endif
                @else
                <div class="page-status-none">
                    <span class="status">No component added. </span>
                </div>
            @endif
@if((Route::getCurrentRoute()->uri() == '/'))
    @foreach($get_incidents_not_resolved->sortByDesc('updated_at') as $not_resolved)
                <div class="media top-incidents-details">
                    <div  class="align-self-start mr-3">
                        @if($not_resolved->incident_statuses_id === 3)
                            <i class="fas fa-3x fa-signature"></i>
                            @elseif($not_resolved->incident_statuses_id === 2)
                            <i class="fas fa-3x fa-fingerprint"></i>
                        @elseif($not_resolved->incident_statuses_id === 1)
                            <i class="fas fa-3x  fa-search"></i>
                        @elseif($not_resolved->incident_statuses_id === 0)
                            <i class="far fa-3x fa-sticky-note"></i>
                        @endif
                    </div>
                    <div class="media-body">
                        <h5 class="mt-0"><strong>{{ $not_resolved->incident_title }}</strong></h5>
                        <div class="media-body-p">
                            {{  strip_tags($not_resolved->update_incident_sort_by_id->first()['incidents_description']) }}
                        </div>
                        <div class="text-date-front">Last Updated {{ $not_resolved->updated_at->format('d M, H:i T') }}</div>
                        <div><a class="incidents-details-link" href="{{ route('incident-code', $not_resolved->code) }}">Incident Details</a></div>
                    </div>
                </div>
                @if (!($loop->last))<div class="separator-line-front">&nbsp;</div>@endif
    @endforeach
@endif
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
                            <a target="_blank" href="/history.atom" class="" >Atom Feed</a>
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
@include('layouts.message')
</body>
</html>