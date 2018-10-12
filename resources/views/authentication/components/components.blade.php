@extends('authentication/layouts/app')
@section('title')
    Components
@endsection
@section('scripts-header')
@endsection
@section('content')
    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">

    <section class="content-header">
        <h1>
            COMPONENTS
            <small>List</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('authenticated.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">COMPONENTS LIST</li>
        </ol>
    </section>


    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <div class="box-tools pull-right">
                    <button type="button" class="btn bg-olive btn-flat margin add-component" data-toggle="modal" data-target="#add-component">
                        Add a new Component
                    </button>
                </div>
            </div>
            <br />
            <div class="box-body">
                <ul id="component-list">
                @foreach($components->sortBy('position', SORT_NATURAL) as $component)
                    <li data-id="{{$component->id}}" class="components-list2 component-{{ $component->id }} @if($component->status === 0)div-disabled @endif">
                        <div class="sortable-button-left">
                            <h4><i class="ion ion-drag"></i> <span class="component-name-{{ $component->id }}">{{ $component->component_name }}</span></h4>
                            <span>Belong to the Group <span class="component-group-name-belong-{{ $component->id }}">{{ $component->component_group->component_groups_name }}</span></span>
                        </div>
                        <div class="sortable-button-right">
                            <a href="#" data-id="{{ $component->id }}" data-toggle="modal"  data-target="#myModal-Component-edit" class="js--component-edit btn bg-navy btn-flat margin">Edit</a>
                            <a href="#" data-id="{{ $component->id }}" data-toggle="modal"  data-target="#myModal-Component-delete" class="js--component-delete js--add-value-id btn bg-red btn-flat margin">Delete</a>
                        </div>
                    </li>
                    @endforeach
                </ul>
                <div class="no-components @if($components->count() === 0)show @else hide @endif"><span><h4 class="box-title">No components added yet!</h4>It is a good idea to add some components.</span></div>
            </div>
            </div>
        </div>
        <!-- /.box -->

        <div class="modal inmodal" id="myModal-Component-delete" tabindex="-1" role="dialog" aria-hidden="true">
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