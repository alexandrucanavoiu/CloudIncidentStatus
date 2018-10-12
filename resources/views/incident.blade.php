@extends('layouts.app_front')
@section('title')Incident {{ $incident->incident_title }}@endsection
@section('content')
<div class="row components-status">
    <div class="col-12">
        <div class="incident-page-header">
            <div class="title-incident-front">{{ $incident->incident_title }}</div>
            <div class="sub-title-incident-front">Incident Report for {{ $settings->title_app }}</div>
        </div>
        <div class="col-md-8 offset-md-2">
        <div class="component-affected-incident-front">This incident affected:
            @foreach($incident->incident_components as $incident_component)
                {{ $loop->first ? '' : ', ' }}
                {{ $incident_component->component_name->component_name }}
            @endforeach
        </div>
        </div>

        <div class="col-lg-12 offset-md-1 margin-top-30 incident-update-front">
            @foreach($incident->update_incident->sortByDesc('incident_statuses_id') as $update)
                <div class="row margin-bottom-25">
                    <div class="col-2"><strong>{{ $update->incident_status->incident_name }}</strong></div>
                    <div class="col-8">
                     <div>{!! $update->incidents_description !!}</div>
                        <div class="incident-update-time">Posted about {{ $update->created_at->diffForHumans() }}. {{ $update->created_at->format('d M Y, H:i T') }}</div>
                    </div>
                </div>
            @endforeach
        </div>


            <a class="btn btn-light" href="/"><i class="fas fa-long-arrow-alt-left"></i> Current Status</a>
    </div>
</div>
@endsection