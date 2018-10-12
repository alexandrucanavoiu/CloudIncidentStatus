@extends('authentication/layouts/app')
@section('title')
    Incident Templates
@endsection
@section('scripts-header')
@endsection
@section('content')
    <section class="content-header">
        <h1>
            Incident Templates
            <small>List</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('authenticated.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">INCIDENTS TEMPLATE</li>
        </ol>
    </section>
    <section class="content">
        <div class="box">
            <div class="box-header">
                <div class="box-tools">
                    <div class="input-group input-group-sm" style="width: 150px;">
                        <button type="button" class="btn bg-olive btn-flat margin add-incident-template" data-toggle="modal" data-target="#myModalIncidentTemplate-add">
                            Add a new Incident Template
                        </button>
                    </div>
                </div>
                <br /><br />
            </div>
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tbody>
                            <tr class="top-table">
                                <th>ID</th>
                                <th>Title</th>
                                <th class="center">Actions</th>
                            </tr>
                            @foreach($templates as $template)
                            <tr id="templates-list" class="template-number-{{ $template->id }}">
                                <td class="2%">{{$template->id}}</td>
                                <td class="incident-template-title-{{$template->id}}" width="80%">{{$template->incident_template_title}}</td>
                                <td width="15%" class="center">
                                    <a href="#" data-id="{{ $template->id }}" data-toggle="modal"  data-target="#myModalIncidentTemplate-edit" class="js--incident-template-edit btn bg-navy btn-xs margin">Edit</a>
                                    <a href="#" data-id="{{ $template->id }}" data-toggle="modal"  data-target="#myModalIncidentTemplate-delete" class="js--incident-template-delete js--add-value-id btn bg-red btn-xs margin">Delete</a>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="box-footer clearfix center">
                            <?php echo $templates->render(); ?>
                        </div>
                        <div class="no-templates @if($templates->count() === 0)show @else hide @endif"><span><h4 class="box-title">No incident templates yet!</h4>It is a good idea to add some templates... please do it!</span></div>
                    </div>
        </div>
        <div class="modal inmodal" id="myModalIncidentTemplate-delete" tabindex="-1" role="dialog" aria-hidden="true">
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