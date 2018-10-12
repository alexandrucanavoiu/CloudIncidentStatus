<div class="modal fade" id="myModal-Incidents-view">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <div class="update-index-title">
                <h3 class="modal-title center"><strong>{{ $incident->incident_title }} #{{ $incident->code }}</strong></h3>
                    <br />
                <div class="center">Incident Report</div>
                    <br />
                <div class="center">This incident affected: <strong>{{ $component_name }}</strong></div>
                </div>
            </div>
            <div class="alert alert-danger print-error-msg" style="display:none">
                <ul></ul>
            </div>
        @foreach($incident->update_incident->sortByDesc('created_at') as $update_incident)
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title"><strong>{{ $update_incident->incident_status->incident_name }}</strong></h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="edit" data-toggle="tooltip" title="" data-original-title="Edit">
                            <i class="fa fa-edit"></i></button>
                    </div>
                </div>
                <div class="box-body" style="">
                    {!!  $update_incident->incidents_description !!}
                </div>
                <!-- /.box-body -->
                <div class="box-footer" style="">
                    <div class="date-right">Date {{ $update_incident->created_at->format('d/m/Y H:i:s') }}</div>
                </div>
                <!-- /.box-footer-->
            </div>
            @endforeach
        </div>
    </div>
</div>