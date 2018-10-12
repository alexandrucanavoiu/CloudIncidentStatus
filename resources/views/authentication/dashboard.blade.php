@extends('authentication.layouts.app')
@section('title')
    Dashboard - Status
@endsection
@section('scripts-header')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Dashboard
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
            <li class="active">Dashboard</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>{{ $count_incidents }}</h3>
                        <p>Total Incidents</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-info-circle"></i>
                    </div>
                    <a href="{{ route('authenticated.incidents') }}" class="small-box-footer">See the list <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- /.col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>{{ $count_components }}</h3>

                        <p>Total Components</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-cogs"></i>
                    </div>
                    <a href="{{ route('authenticated.components') }}" class="small-box-footer">See the list <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- /.col -->

            <!-- fix for small devices only -->
            <div class="clearfix visible-sm-block"></div>

            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>0</h3>

                        <p>Total Subscribers</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-users"></i>
                    </div>
                    <a href="{{ route('authenticated.subscribes') }}" class="small-box-footer">See the list <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- /.col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                @if($next_scheduled_maintenance == null)
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>none</h3>
                        <p>Next Scheduled Maintenance</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-calendar-minus-o"></i>
                    </div>
                    <a href="{{ route('authenticated.schedule') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
                @else
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3>{{ $next_scheduled_maintenance->scheduled_end->format('d-m-Y') }}</h3>
                        <p>Next Scheduled Maintenance</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-calendar-minus-o"></i>
                    </div>
                    <a href="{{ route('authenticated.schedule') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
                @endif
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->


        <div class="row">
            <div class="col-md-6">
                @if($component_groups->count() == 0)
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Components Group</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        No components yet added.
                    </div>
                </div>
                @else
        @foreach($component_groups->sortBy('position', SORT_NATURAL) as $group)
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Group {{ $group->component_groups_name }}</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table class="table table-bordered">
                            <tbody>
                            <tr>
                                <th width="50%">Component</th>
                                <th width="25%" class="center">Performance</th>
                                <th width="25%" class="center">Status</th>
                            </tr>
                            @foreach($group->components->sortBy('position', SORT_NATURAL) as $components)
                                @if($components->component_statuses_id == 1)
                                        <tr>
                                            <td>{{ $components->component_name }}</td>
                                            <td>
                                                <div class="progress progress-xs">
                                                    <div class="progress-bar progress-bar-green" style="width: 100%"></div>
                                                </div>
                                            </td>
                                            <td class="center">
                                                    <span class="badge bg-green">{{ $components->component_status->component_status_name }}</span>
                                            </td>
                                        </tr>
                                @elseif($components->component_statuses_id == 2)
                                            <tr>
                                                <td>{{ $components->component_name }}</td>
                                                <td>
                                                    <div class="progress progress-xs">
                                                        <div class="progress-bar progress-bar-blue" style="width: 75%"></div>
                                                    </div>
                                                </td>
                                                <td class="center">
                                                    <span class="badge bg-blue">{{ $components->component_status->component_status_name }}</span>
                                                </td>
                                            </tr>
                                @elseif($components->component_statuses_id == 3)
                                    <tr>
                                        <td>{{ $components->component_name }}</td>
                                        <td>
                                            <div class="progress progress-xs">
                                                <div class="progress-bar progress-bar-yellow" style="width: 50%"></div>
                                            </div>
                                        </td>
                                        <td class="center">
                                            <span class="badge bg-yellow">{{ $components->component_status->component_status_name }}</span>
                                        </td>
                                    </tr>
                                @else
                                    <tr>
                                        <td>{{ $components->component_name }}</td>
                                        <td>
                                            <div class="progress progress-xs">
                                                <div class="progress-bar progress-bar-red" style="width: 25%"></div>
                                            </div>
                                        </td>
                                        <td class="center">
                                            <span class="badge bg-red">{{ $components->component_status->component_status_name }}</span>
                                        </td>
                                    </tr>
                                @endif
                             @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
        @endforeach
                    @endif
            </div>
            <div class="col-md-6">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Last Incidents</h3>
                    </div>
                    <div class="box-body">
                        @if($incidents->count() > 0)
                        <table class="table table-bordered">
                            <tbody><tr>
                                <th width="10%">Incident</th>
                                <th width="35%">Title Incident</th>
                                <th width="35%">Components Affected</th>
                                <th width="20%" class="center">Status</th>
                            </tr>
                            @foreach($incidents as $incident)
                            <tr>
                                <td>{{ $incident->code }}</td>
                                <td>{{ $incident->incident_title }}</td>
                                {{--<td>{{ $incident->component->component_name }}</td>--}}
                                <td>
                                    @foreach($incident->incident_components as $incident_component)
                                        {{ $loop->first ? '' : ', ' }}
                                        {{ $incident_component->component_name->component_name }}
                                    @endforeach
                                </td>
                                <td class="center">{{ $incident->incident_status->incident_name }}</td>
                            </tr>
                             @endforeach
                            </tbody>
                        </table>
                            @else
                            <div class="center">No incidents yet! Great Job!</div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <!-- LINE CHART -->
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Incidents Report in the last years</h3>
                    </div>
                    <div class="box-body chart-responsive">
                        <div class="chart" id="line-chart" style="height: 300px;"></div>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts-footer')
    <script>
    $(function () {

        var incidents_this_year = '{{ $incidents_this_year }}';
        var incidents_one_year_ago = '{{ $incidents_one_year_ago }}';
        var incidents_two_year_ago = '{{ $incidents_two_year_ago }}';
        var incidents_three_years_ago = '{{ $incidents_three_years_ago }}';
        var incidents_four_years_ago = '{{ $incidents_four_years_ago }}';

        var line = new Morris.Line({
            element: 'line-chart',
            resize: true,
            data: [
                {y: '{{ $four_years_ago }}', item1: incidents_four_years_ago},
                {y: '{{ $three_years_ago }}', item1: incidents_three_years_ago},
                {y: '{{ $two_years_ago }}', item1: incidents_two_year_ago},
                {y: '{{ $one_year_ago }}', item1: incidents_one_year_ago},
                {y: '{{ $currently_year }}', item1: incidents_this_year}
            ],
            xkey: 'y',
            ykeys: ['item1'],
            labels: ['Incidents'],
            lineColors: ['#3c8dbc'],
            hideHover: 'auto'
        });

    });
    </script>
@endsection