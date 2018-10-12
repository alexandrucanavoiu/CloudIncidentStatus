@extends('authentication/layouts/app')
@section('title')
    Settings
@endsection
@section('scripts-header')
@endsection
@section('content')
    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
    <section class="content-header">
        <h1>
            Aplication Setup
            <small>you can change all default parameters.</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('authenticated.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Settings</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Status Incidents Platform</h3>
                    </div>
                    <div class="box box-primary">
                        <div class="box-body box-profile">
                            <div class="image-logo"><img src="/images/{{ $settings->settings_logo }}" alt="{{ $settings->title_app }}"></div>
                            <br />
                            <ul class="list-group list-group-unbordered">
                                <li class="list-group-item">
                                    <b>Site Name</b> <a class="pull-right">{{ $settings->title_app }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Site Timezone</b> <a class="pull-right">{{ $settings->time_zone_interface }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Days of Incidents to show</b> <a class="pull-right">{{ $settings->days_of_incidents }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Number of the Emails in a bulk</b> <a class="pull-right">{{ $settings->bulk_emails }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Job Sleep after sent a Bulk Email</b> <a class="pull-right">{{ $settings->bulk_emails_sleep }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Queue Name for Incidents</b> <a class="pull-right">{{ $settings->queue_name_incidents }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Queue Name for Maintenance</b> <a class="pull-right">{{ $settings->queue_name_maintenance }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>(Email) From Address</b> <a class="pull-right">{{ $settings->from_address }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>(Email)From Name</b> <a class="pull-right">{{ $settings->from_name }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Google Analytics code</b> <a class="pull-right">@if(empty($settings->google_analytics_code)) None @else {{ $settings->google_analytics_code }} @endif</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Site Language</b> <a class="pull-right">English</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Allow people to signup to email notifications?</b> <a class="pull-right">@if($settings->allow_subscribers == 1) Yes @else No @endif</a>
                                </li>
                            </ul>
                            <a href="#" data-id="{{ $settings->id }}" data-toggle="modal"  data-target="#myModal-Settings-edit" class="js--settings-edit js--add-value-id btn btn-primary btn-block">Edit Settings</a>
                        </div>
                    </div>
                </div>
                </div>
            </div>

        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="box">
                    <div class="box-header with-border">
                        <div class="col-8">
                        <button type="button" data-toggle="modal"  data-target="#myModal-Links-add" class="btn bg-olive btn-flat margin add-links btn-sm pull-right">Add a new footer link</button>
                        </div>
                    </div>
                    <div class="box box-primary">
                        <div class="box-body box-profile2">
                            <ul class="list-group list-group-unbordered" id="links-group-list">
                                @foreach($links as $link)
                                <li data-id="{{$link->id}}" class="list-group-item links-group-{{ $link->id }}">
                                    <i class="ion ion-drag"></i> <b>{{ $link->footer_title }}</b> ({{ $link->footer_url }}) <a href="#"  data-id="{{ $link->id }}" data-toggle="modal"  data-target="#myModal-Links-delete" class="js--links-group-delete pull-right js--add-value-id">Delete</a><a href="#" data-id="{{ $link->id }}" data-toggle="modal"  data-target="#myModal-Links-edit" class="js--links-group-edit pull-right padding-right-20">Edit</a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal inmodal" id="myModal-Links-delete" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content animated flipInY">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title"><i class="fa fa-exclamation-triangle text-danger"></i> Confirm Deletion </h4>
                    <small class="font-bold"></small>
                </div>
                <div class="modal-body">
                    <p>Please confirm this action.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                    <a href="#" class="btn btn-danger" id="confirm-delete">Agree</a>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts-footer')
@endsection