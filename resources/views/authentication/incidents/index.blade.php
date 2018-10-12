@extends('authentication/layouts/app')
@section('title')
    Incidents
@endsection
@section('scripts-header')
@endsection
@section('content')
    <section class="content-header">
        <h1>
            Incidents
            <small>List</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('authenticated.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">INCIDENTS</li>
        </ol>
    </section>
    <section class="content">
        <div class="box">
            <div class="box-header">
                <div class="box-tools">
                    <div class="input-group input-group-sm" style="width: 150px;">
                        <button type="button" class="btn bg-olive btn-flat margin add-incidents" data-toggle="modal" data-target="#myModal-Incidents-add">Add a new Incident</button>
                    </div>
                </div>
                <br /><br />
            </div>
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tbody>
                            <tr class="top-table">
                                <th class="center">ID</th>
                                <th>Title</th>
                                <th class="center">Components</th>
                                <th class="center">Incident Status</th>
                                <th class="center">Last Update</th>
                                <th class="center">Visibility</th>
                                <th class="center">Actions</th>
                            </tr>
                            @foreach($incidents as $incident)
                            <tr id="incidents-list" class="incidents-number-{{ $incident->id }}">
                                <td class="center" width="5%"><div class="padding-10">{{$incident->id}}</div></td>
                                <td class="incidents-title-{{$incident->id}}" width="20%"><div class="padding-10">{{$incident->incident_title}}</div></td>
                                <td class="center incident-component-name" width="15%"><div class="padding-10">
                                        @foreach($incident->incident_components as $incident_component)
                                            {{ $loop->first ? '' : ', ' }}
                                            {{ $incident_component->component_name->component_name }}
                                        @endforeach
                                    </div>
                                </td>
                                <td class="center" width="15%"><div class="padding-10"><span class="label @switch($incident->incident_statuses_id) @case(5)label-primary @break @case(1)label-warning @break @case(2)label-primary @break @case(3)label-primary @break @case(4)label-success @break @defaultlabel-primary @endswitch">{{ $incident->incident_status->incident_name }}</span></div></td>
                                <td class="center" width="10%"><div class="padding-10">{{ $incident->updated_at->format('d/m/Y H:i:s') }}</div></td>
                                <td class="center" width="10%"><div class="padding-10">@if($incident->incidents_status == 1) Published @else Hidden @endif</div></td>
                                <td width="25%" class="center">
                                    <a href="{{ route('authenticated.incidents.update.index', $incident->id) }}" class="btn btn-success btn-xs margin">Update Incident</a>
                                    <a href="#" data-id="{{ $incident->id }}" data-toggle="modal"  data-target="#myModal-Incidents-view" class="js--incidents-view btn bg-purple btn-xs margin">View</a>
                                    <a href="#" data-id="{{ $incident->id }}" data-toggle="modal"  data-target="#myModal-Incidents-edit" class="js--incidents-edit btn bg-navy btn-xs margin">Edit</a>
                                    <a href="#" data-id="{{ $incident->id }}" data-toggle="modal"  data-target="#myModal-Incidents-delete" class="js--incidents-delete js--add-value-id btn bg-red btn-xs margin">Delete</a>
                                </td>
                            </tr>
                            @endforeach
                            </tbody></table>
                        <div class="no-incidents-index @if($incidents->count() === 0)show @else hide @endif"><span><h4 class="box-title">No incident yet!</h4>Great Job!</span></div>
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