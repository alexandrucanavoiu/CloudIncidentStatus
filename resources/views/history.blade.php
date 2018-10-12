@extends('layouts.app_front')
@section('title')Status @endsection
@section('content')
<div class="row components-status">
    <div class="col-12">

        <nav aria-label="Navigation">
            <ul class="pagination">
                <li class="page-item"> <a class="page-link" href="{{ route('history', $forward_date) }}"><i class="fas fa-angle-left"></i> {{ \Carbon\Carbon::parse($forward_date)->format('F Y') }} </a></li>
                @if( $date_id !== date("Y-m") )
                    <li class="page-item"><span class="page-to"></span></li>
                    <li class="page-item"><a class="page-link" href="{{ route('history', $next_date) }}">{{ \Carbon\Carbon::parse($next_date)->format('F Y') }} <i class="fas fa-angle-right"></i></a></li>
                @endif
            </ul>
        </nav>

        @foreach($all_incidents as $key =>  $incident)
            @if(empty($incident))
                <div class="card margin-bottom-10">
                    <h5 class="card-header date-title">{{ $key }}</h5>
                    <div class="card-body">
                        <p class="card-text text-incidents">No incidents reported for this month.</p>
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
        <a class="btn btn-light" href="/"><i class="fas fa-long-arrow-alt-left"></i> Current Status</a>
    </div>
</div>
@endsection