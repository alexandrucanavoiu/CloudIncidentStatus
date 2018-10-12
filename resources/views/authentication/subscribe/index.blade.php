@extends('authentication/layouts/app')
@section('title')
    Subscribes
@endsection
@section('scripts-header')
@endsection
@section('content')
    <section class="content-header">
        <h1>
            Subscribes
            <small> will be able to modify & edit subscribes.</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('authenticated.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">SUBSCRIBES</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-8">
        <div class="box">
            <div class="box-header">
                <div class="box-tools">
                    <div class="input-group input-group-sm" style="width: 150px;">
                    </div>
                </div>
                <br /><br />
            </div>
                    <div class="box-body table-responsive no-padding">
                        @if($subscribes->count() > 0)
                        <table class="table table-hover">
                            <tbody>
                            <tr class="top-table">
                                <th class="center">Email</th>
                                <th class="center">Status</th>
                                <th class="center">Subscribe At</th>
                                <th class="center">Actions</th>
                            </tr>
                            @foreach($subscribes as $user_display)
                                <tr id="users-list" class="users-number-{{ $user_display->id }}">
                                    <td width="10%"><div class="padding-10">{{$user_display->email}}</div></td>
                                    <td class="center" width="5%"><div class="padding-10">@if($user_display->status == 1) Confirmed @else UnConfirmed @endif</div></td>
                                    <td class="center" width="10%"><div class="padding-10">{{$user_display->updated_at->format('F d, H:i T')}}</div></td>
                                    <td class="center" width="10%" class="center">
                                        <a target="_blank" href="{{ route('manage-subscribe', $user_display->code) }}" class="btn bg-purple btn-xs margin">View</a>
                                        <a target="_blank" href="{{ route('manage-subscribe-active', [$user_display->code, $user_display->code_security]) }}" class="btn bg-navy btn-xs margin">Confirm</a>
                                        <a href="#" data-id="{{ $user_display->id }}" data-toggle="modal"  data-target="#myModal-Subscribe-delete" class="js--users-delete js--add-value-id btn bg-red btn-xs margin">Delete</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        @else
                            <div class="center">No Subscribers yet.</div>
                        @endif
                        <div class="box-footer clearfix">
                            {{ $subscribes->links() }}
                        </div>
                    </div>
        </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <div class="info-box-subscribe">
                        <span class="info-box-text">Subscribed Users</span>
                        <span class="info-box-number">{{ $subscribes_total }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <div class="info-box-subscribe">
                        <span class="info-box-text">Unconfirmed</span>
                        <span class="info-box-number">{{ $subscribes_total_unconfirmed }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="box box-primary">
                    <div class="box-body box-profile">
                        <h3 class="profile-username text-center">Components Subscribed</h3>
                        <ul class="list-group list-group-unbordered">
                            @if(!empty($lists))
                            @foreach($lists as $item)
                            <li class="list-group-item">
                                <b>{{ $item['name'] }}</b> <a class="pull-right">{{ $item['count'] }}</a>
                            </li>
                            @endforeach
                                @else
                                <div class="center">No Components yet added.</div>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @if($subscribes->count() > 0)
        <div class="modal inmodal" id="myModal-Subscribe-delete" tabindex="-1" role="dialog" aria-hidden="true">
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
            @endif

    </section>
@endsection
@section('scripts-footer')
@endsection