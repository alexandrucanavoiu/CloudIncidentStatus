@extends('authentication/layouts/app')
@section('title')
    Team Members
@endsection
@section('scripts-header')
@endsection
@section('content')
    <section class="content-header">
        <h1>
            Team Members
            <small> will be able to add, modify & edit components and incidents.</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('authenticated.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">USERS</li>
        </ol>
    </section>
    <section class="content">
        <div class="box">
            <div class="box-header">
                <div class="box-tools">
                    <div class="input-group input-group-sm" style="width: 150px;">
                        <button type="button" class="btn bg-olive btn-flat margin add-users" data-toggle="modal" data-target="#myModal-Users-add">
                            Add a new user
                        </button>
                    </div>
                </div>
                <br /><br />
            </div>
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tbody>
                            <tr class="top-table">
                                <th class="center">ID</th>
                                <th>Name</th>
                                <th class="center">Email</th>
                                <th class="center">Level</th>
                                <th class="center">Actions</th>
                            </tr>
                            @foreach($users as $user_display)
                                <tr id="users-list" class="users-number-{{ $user_display->id }}">
                                    <td class="center" width="5%"><div class="padding-10">{{$user_display->id}}</div></td>
                                    <td class="users-name-{{$user_display->id}}" width="20%"><div class="padding-10">{{$user_display->name}}</div></td>
                                    <td class="center users-email" width="15%"><div class="padding-10">{{ $user_display->email }}</div></td>
                                    <td class="center users-level" width="10%"><div class="padding-10">{{ $user_display->level }}</div></td>
                                    <td width="25%" class="center">
                                        <a href="#" data-id="{{ $user_display->id }}" data-toggle="modal"  data-target="#myModal-Users-edit" class="js--users-edit btn bg-navy btn-xs margin">Edit</a>
                                        <a href="#" data-id="{{ $user_display->id }}" data-toggle="modal"  data-target="#myModal-Users-delete" class="js--users-delete js--add-value-id btn bg-red btn-xs margin">Delete</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody></table>
                    </div>
        </div>
        <div class="modal inmodal" id="myModal-Users-delete" tabindex="-1" role="dialog" aria-hidden="true">
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
                        <a href="#" class="btn btn-danger" id="confirm-delete" data-id="{{ $user_display->id }}">Agree</a>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection
@section('scripts-footer')
@endsection