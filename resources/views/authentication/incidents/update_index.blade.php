@extends('authentication/layouts/app')
@section('title')
    Incident {{ $incident->incident_title }}
@endsection
@section('scripts-header')
@endsection
@section('content')
    <section class="content-header">
        <h1>
            Incident "{{ $incident->incident_title }}" (#{{$incident->code}})</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('authenticated.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="{{ route('authenticated.incidents') }}">INCIDENTS</a></li>
            <li class="active">INCIDENT {{ strtoupper($incident->incident_title) }}</li>
        </ol>
    </section>
    <section class="content">
        <div class="box">
            <div class="box-header">
                <div class="box-tools">
                    <div class="input-group input-group-sm" style="width: 150px;">
                        <button data-id="{{ $incident->id }}" type="button" class="btn bg-olive btn-flat margin add-incidents-update-new" data-toggle="modal" data-target="#myModal-Incidents-update-new">
                            Add a new update
                        </button>
                    </div>
                </div>
                <br /><br />
            </div>

            <div class="row">
                <div class="col-lg-8 col-md-offset-2">
                    <div class="col-md-6 col-sm-6">
                        <div class="info-box background-change-component @if($incident->component_statuses_id == 1) bg-green @elseif($incident->component_statuses_id == 4) bg-red @else bg-yellow @endif">
                            <span class="info-box-icon"><i class="fa fa-bookmark-o"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Affected Component</span>
                                <span class="info-box-number">{{ $components_name }}</span>
                                <div class="progress">
                                    @if($incident->component_statuses_id == 1)
                                    <div class="progress-bar progress-bar-component-status" style="width: 100%"></div>
                                        @elseif($incident->component_statuses_id == 2)
                                        <div class="progress-bar progress-bar-component-status" style="width: 75%"></div>
                                        @elseif($incident->component_statuses_id == 3)
                                        <div class="progress-bar progress-bar-component-status" style="width: 50%"></div>
                                        @else
                                        <div class="progress-bar progress-bar-component-status" style="width: 25%"></div>
                                    @endif
                                </div>
                                <span class="progress-description component-status-name">Status: {{ $incident->component_status->component_status_name }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="info-box background-change-incident-status @if($last_incident_status == 4 ) bg-green @elseif($last_incident_status == 5) bg-blue @elseif($last_incident_status == 3) bg-blue @elseif($last_incident_status == 2) bg-blue @else bg-yellow @endif">
                            <span class="info-box-icon"><i class="fa fa-bookmark-o"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Incident Name</span>
                                <span class="info-box-number incident-name">{{ $incident->incident_title }}</span>
                                <div class="progress">
                                    @if($incident->incident_statuses_id == 1)
                                        <div class="progress-bar progress-bar-tichet-status" style="width: 25%"></div>
                                    @elseif($incident->incident_statuses_id == 2)
                                        <div class="progress-bar progress-bar-tichet-status" style="width: 50%"></div>
                                    @elseif($incident->incident_statuses_id == 3)
                                        <div class="progress-bar progress-bar-tichet-status" style="width: 75%"></div>
                                    @elseif($incident->incident_statuses_id == 5)
                                            <div class="progress-bar progress-bar-tichet-status" style="width: @if($last_incident_status == 1) 25% @elseif($last_incident_status == 2) 50% @elseif($last_incident_status == 3) 75% @elseif($last_incident_status == 4) 100% @else 25% @endif"></div>
                                    @else
                                        <div class="progress-bar progress-bar-tichet-status" style="width: 100%"></div>
                                    @endif
                                </div>
                                <span class="progress-description  incident-status-name">Status: {{ $incident->incident_status->incident_name }}</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <br />
            @if($incident->incidents_status == 0)<div class="center text-red">This incident is not public. Only the admins can see it. If you want it to be public, please edit the incident and change the status.</div><br />@endif

            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <tbody>
                    <tr class="top-table">
                        <th class="center">ID</th>
                        <th class="center">Description</th>
                        <th class="center">Incident Status</th>
                        <th class="center">Last Update</th>
                        <th class="center">Actions</th>
                    </tr>
                    @foreach($incident->update_incident->sortByDesc('id') as $updates)
                        <tr id="incidents-list" class="incidents-number-{{ $updates->id }}">
                            <td class="center" width="5%"><div class="padding-10">{{$updates->id}}</div></td>
                            <td class="incidents-title-{{$updates->id}}" width="30%"><div class="padding-10">{!! $updates->incidents_description !!}</div></td>
                            <td class="center" width="15%"><div class="padding-10"><span class="label @switch($updates->incident_statuses_id) @case(1)label-warning @break @case(2)label-primary @break @case(3)label-primary @break @case(4)label-success @break @case(5)label-primary @break @defaultlabel-primary @endswitch">{{ $updates->incident_status->incident_name }}</span></div></td>
                            <td class="center" width="10%"><div class="padding-10">{{ $updates->updated_at->format('d/m/Y H:i:s') }}</div></td>
                            <td width="15%" class="center">
                                <a href="#" data-incident-id="{{ $updates->incidents_id }}" data-id="{{ $updates->id }}" data-toggle="modal"  data-target="#myModal-Incidents-update-edit" class="js--incidents-update-edit btn bg-navy btn-xs margin">Edit</a>
                                <a href="#" data-incident-id="{{ $updates->incidents_id }}" data-id="{{ $updates->id }}" data-toggle="modal"  data-target="#myModal-Incidents-update-delete" class="js--incidents-update-delete js--add-value-id-update-id-incident btn bg-red btn-xs margin">Delete</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody></table>
            </div>
        </div>
        <div class="modal inmodal" id="myModal-Incidents-update-delete" tabindex="-1" role="dialog" aria-hidden="true">
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