@extends('layouts.app_front')
@section('title')Status @endsection
@section('content')
    @if($schedule !== null)
        @if($schedule->count() > 0)
    <div class="container margin-top-30">
        <div class="row">
            <div class="col-lg-12">
                <div class="card maintenance-card">
                    <div class="card-header background-maintenance">{{ $schedule->scheduled_title }} on {{ $schedule->scheduled_start->format('F d, H:i T') }}</div>
                    <div class="card-body">
                        <div class="card-text">{!! $schedule->scheduled_description !!}</div>
                        <div><strong>This Maintenance affected:
                                @foreach($schedule->schedule_components as $component)
                                    {{ $loop->first ? '' : ', ' }}
                                    {{ $component->component_name->component_name }}
                                @endforeach
                            </strong></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        @endif
   @endif
<div class="row components-status">
    @if($components->count() > 0 && $components_count > 0)
    <div class="col-4">
        <div id="accordion">
                @foreach($components as $component)
                    <div class="card margin-botton-10">
                        <div class="card-header">
                            <a class="component-group-title" data-toggle="collapse"  aria-expanded="true" href="#collapse-{{ $component->id }}">{{ $component->component_groups_name }}</a>
                        </div>
                        <div id="collapse-{{ $component->id }}" class="collapse show multi-collapse">
                            @foreach($component->components->sortBy('position', SORT_NATURAL) as $comp)
                                <div class="card-body components-name"><span class="name">{{ $comp->component_name }}</span><span class="float-right status-{{ $comp->component_statuses_id }}">@if($comp->component_statuses_id == 1 || $comp->component_statuses_id == 2)<i class="fas fa-check-circle" data-toggle="tooltip" title="{{ $comp->component_status->component_status_name }}"></i>@elseif($comp->component_statuses_id == 3) <i class="fas fa-heartbeat" data-toggle="tooltip" title="{{ $comp->component_status->component_status_name }}"></i> @else <i class="fas fa-exclamation-triangle" data-toggle="tooltip" title="{{ $comp->component_status->component_status_name }}"></i> @endif</span> </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach

        </div>
    </div>
        @else
        <div class="col-4">
            <div id="accordion">
                    <div class="card margin-botton-10">
                        <div class="card-header">
                            <a class="component-group-title" data-toggle="collapse"  aria-expanded="true" href="#collapse-1">No component group found</a>
                        </div>
                        <div id="collapse-1" class="collapse show multi-collapse">
                                <div class="card-body components-name"><span class="name">No Component found</span><span class="float-right status-1"></span> </div>
                        </div>
                    </div>

            </div>
        </div>
    @endif

    <div class="col-8">
        <div><a class="font-largest no-link" id="past-incidents-front" href="#"><strong>Incident History</strong></a></div>
        @foreach($all_incidents as $key =>  $incident)
            @if(empty($incident))
                <div class="card margin-bottom-10">
                    <h5 class="card-header date-title">{{ $key }}</h5>
                    <div class="card-body">
                        <p class="card-text text-incidents">No incidents reported.</p>
                    </div>
                </div>
            @else
                <div class="card margin-bottom-10">
                    <h5 class="card-header date-title">{{ $key }}</h5>
                    <div class="card-body">
                        @foreach($incident->sortByDesc('updated_at') as $report)
                            <div class="margin-bottom-25">
                                <h5 class="card-title"><strong>{{ $report->incident_title }}</strong></h5>
                                <p class="card-text text-incidents"><strong>{{ $report->incident_status->incident_name }}</strong> - {{  strip_tags($report->update_incident_sort_by_id->first()['incidents_description']) }}</p>
                                <div class="text-date-front">{{ $report->updated_at->format('d M, H:i T') }}</div>
                                <div><a class="incidents-details-link" href="{{ route('incident-code', $report->code) }}">Incident Details</a></div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @endforeach
        <a class="btn btn-light" href="{{ route('history', \Carbon\Carbon::now()->format('Y-m') ) }}"><i class="fas fa-long-arrow-alt-left"></i> Full History of Incidents</a>
    </div>
</div>
@endsection