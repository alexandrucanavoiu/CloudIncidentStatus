@extends('authentication.layouts.app')
@section('title')
    Faild Jobs
@endsection
@section('scripts-header')
@endsection
@section('content')
    <section class="content-header">
        <h1>
            Failed Jobs
            <small>List</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('authenticated.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">FAILED JOBS</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
        <div class="col-lg-12">
        <div class="box">
            <div class="box-header">
                <div class="box-tools">
                </div>
                <br /><br />
            </div>
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-striped">
                            <tbody>
                            <tr class="top-table">
                                <th class="center">ID</th>
                                <th class="center">Connection</th>
                                <th class="center">Queue Name</th>
                                <th class="center">PlayLoad</th>
                                <th class="center">Exception</th>
                                <th class="center">Failed At</th>
                            </tr>
                            @foreach($faild_jobs as $incident)
                            <tr id="incidents-list-failed-jobs" class="incidents-number-{{ $incident->id }}">
                                <td class="center"><div class="padding-10">{{$incident->id}}</div></td>
                                <td class="center"><div class="padding-10">{{$incident->connection}}</div></td>
                                <td class="center"><div class="padding-10">{{$incident->queue}}</div></td>
                                <td class="center"><a href="#" data-id="{{ $incident->id }}" data-toggle="modal"  data-target="#myModal-FailedJobsPlayLoad-view" class="js--FailedJobsPlayLoad-view btn bg-purple btn-xs margin">View</a></td>
                                <td class="center"><a href="#" data-id="{{ $incident->id }}" data-toggle="modal"  data-target="#myModal-FailedJobsException-view" class="js--FailedJobsException-view btn bg-purple btn-xs margin">View</a></td>
                                <td class="center"><div class="padding-10">{{ $incident->failed_at->format('d/m/Y H:i:s') }}</div></td>
                            </tr>
                            @endforeach
                            </tbody></table>
                        <div class="no-incidents-index @if($faild_jobs->count() === 0)show @else hide @endif"><span><h4 class="box-title">No failed jobs yet!</h4>Great Job!</span></div>
                    </div>
        </div>
        </div>
        </div>
        <div class="modal inmodal" id="myModal-Incidents-delete" tabindex="-1" role="dialog" aria-hidden="true">
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

    </section>
@endsection
@section('scripts-footer')
@endsection