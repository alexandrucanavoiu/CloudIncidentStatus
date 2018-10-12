@extends('layouts.app_subscribe')
@section('title') Manage Subscribe @endsection
@section('content')
<div class="row components-status">
    <div class="col-12">
        <div class="incident-page-header">
            <div class="title-incident-front">{{ $settings->title_app }}</div>
            <div class="sub-title-incident-front">Notifications Subscription</div>
        </div>

                @if($subscribe->status == 0)
                    <br /><br />
                    <div class="col-md-8 offset-md-2">
                        <div class="component-affected-incident-front"><i class="fas color-yellow fa-exclamation-triangle"></i> You need to check your email and confirm your subscription before you will start receiving email notifications. <a href="{{ route('manage-subscribe-confirm', $subscribe->code) }}">Re-send confirmation link</a></div>
                    </div>
                @endif

        <div class="col-md-8 offset-md-2 margin-top-30 text-center">
            <div class="component-affected-incident-front">
            <div>Email</div>
                <div><h5><strong>{{ $subscribe->email }}</strong></h5></div>
                <div class="text-red-cancel-subscription"><a data-code="{{ $subscribe->code }}" href="#" class="subscribe-cancel" data-toggle="modal" data-target="#myModal-Subscribe-cancel">Cancel Subscription</a></div>
            </div>
        </div>

        {!! Form::open(array('route' => ['manage-subscribe-store', $subscribe->code],'method'=>'POST', 'id' => 'form')) !!}
        <div class="col-md-8 offset-md-2 margin-top-30 incident-update-front">
                <div id="accordion">
                    @foreach($components as $component)
                        <div class="card margin-botton-10">
                            <div class="card-header">
                                <a class="component-group-title" data-toggle="collapse"  aria-expanded="true" href="#collapse-{{ $component->id }}">{{ $component->component_groups_name }}</a>
                            </div>
                            <div id="collapse-{{ $component->id }}" class="collapse show multi-collapse">
                                @foreach($component->components->sortBy('position', SORT_NATURAL) as $comp)
                                    <div class="card-body components-name">
                                        <span class="name">{{ $comp->component_name }}</span>
                                        <span class="float-right status-{{ $comp->component_statuses_id }}">
                                            <div class="form-check">
                                              <input class="form-check-input" value="{{ $comp->id }}" name="components_id[]" type="checkbox"  id="components_id" {{ ($searchcomponents->search($comp->id)) ? 'checked' : '' }}>
                                              </label>
                                            </div>
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            <div><button type="submit" id="submit" class="btn btn-primary">Update Preferences</button></div>
        </div>
        {!! Form::close() !!}
            <a class="btn btn-light" href="/"><i class="fas fa-long-arrow-alt-left"></i> Current Status</a>
    </div>
</div>
@endsection