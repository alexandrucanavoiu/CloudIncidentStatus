@extends('authentication/layouts/app')
@section('title')
    Scheduled Maintenance
@endsection
@section('scripts-header')
@endsection
@section('content')
    <section class="content-header">
        <h1>
            Scheduled Maintenance
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('authenticated.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">SCHEDULED MAINTENANCE</li>
        </ol>
    </section>


    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <div class="box-tools pull-right">
                    <button type="button" class="btn bg-olive btn-flat margin add-schedule" data-toggle="modal" data-target="#add-schedule">
                        Add a new Scheduled Maintenance
                    </button>
                </div>
            </div>
            <br /><br /><br />
            <div class="box-body">
                <ul id="schedule-list">
                    <div><strong>Upcoming Maintenance</strong></div>
                    <li class="hide"></li>
                    @foreach($scheduleds as $schedule)
                        <li data-id="{{$schedule->id}}" class="schedules-list2 schedule-{{ $schedule->id }} @if($schedule->archived === 1)div-disabled @endif">
                            <div class="sortable-button-left">
                                <h4><span class="glyphicon glyphicon-cloud-download padding-right-20"></span> <span class="schedule-name-{{ $schedule->id }}"><strong>{{ $schedule->scheduled_title }}</strong>  <span class="scheduled_date_time">(from {{ $schedule->scheduled_start->format('Y-m-d H:i:s') }} to {{ $schedule->scheduled_end->format('Y-m-d H:i:s') }})</span></span></h4>
                            </div>
                            <div class="sortable-button-right">
                                <a href="#" data-id="{{ $schedule->id }}" data-toggle="modal"  data-target="#myModal-Schedule-edit" class="js--schedule-edit btn bg-navy btn-flat btn-xs margin">Edit</a>
                                <a href="#" data-id="{{ $schedule->id }}" data-toggle="modal"  data-target="#myModal-Schedule-delete" class="js--schedule-delete js--add-value-id btn bg-red btn-flat btn-xs margin">Delete</a>
                            </div>
                        </li>
                    @endforeach
                    {{ $scheduleds->links() }}
                </ul>
                <div class="no-schedule @if($scheduleds->count() === 0)show @else hide @endif"><span><h4 class="box-title">No schedules</h4>Good Work!</span></div>
            </div>

            <div class="box-body">
                <ul id="schedule-list-old">
                    <div><strong>Old Maintenance</strong></div>
                    <li class="hide"></li>
                    @if($scheduleds_archived->count() > 0)
                    @foreach($scheduleds_archived as $schedule)
                        <li data-id="{{$schedule->id}}" class="schedules-list2 schedule-{{ $schedule->id }} @if($schedule->archived === 1)div-disabled @endif">
                            <div class="sortable-button-left">
                                <h4><span class="glyphicon glyphicon-cloud-download padding-right-20"></span> <span class="schedule-name-{{ $schedule->id }}"><strong>{{ $schedule->scheduled_title }}</strong>  <span class="scheduled_date_time">(from {{ $schedule->scheduled_start->format('Y-m-d H:i:s') }} to {{ $schedule->scheduled_end->format('Y-m-d H:i:s') }})</span></span></h4>
                            </div>
                            <div class="sortable-button-right">
                                <a href="#" data-id="{{ $schedule->id }}" data-toggle="modal"  data-target="#myModal-Schedule-edit" class="js--schedule-edit btn bg-navy btn-flat btn-xs margin">Edit</a>
                                <a href="#" data-id="{{ $schedule->id }}" data-toggle="modal"  data-target="#myModal-Schedule-delete" class="js--schedule-delete js--add-value-id btn bg-red btn-flat btn-xs margin">Delete</a>
                            </div>
                        </li>
                    @endforeach
                    {{ $scheduleds_archived->links() }}

                        @else
                    <div class="center">No old maintenance scheduled</div>
                    @endif
                </ul>
            </div>

            </div>
        </div>
        <!-- /.box -->

        <div class="modal inmodal" id="myModal-Schedule-delete" tabindex="-1" role="dialog" aria-hidden="true">
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