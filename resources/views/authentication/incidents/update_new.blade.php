<div class="modal fade" id="myModal-Incidents-update-new" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Add an update for incident {{ $incident->incident_title }}</h4>
            </div>
            <div class="alert alert-danger print-error-msg" style="display:none">

                <ul></ul>

            </div>
            {!! Form::open(array('route' => ['authenticated.incidents.update.store', $incident->id],'method' => 'POST', 'id' => 'form')) !!}

            <div class="modal-body">

                <div class="form-group">
                    <label>Incident Template</label>
                    <select id="incident_template_select" name="incident_template" class="form-control">
                            <option value="0">-- select --</option>
                        @foreach($incident_templates as $template)
                            <option value="{{ $template->id }}">{{ $template->incident_template_title }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Component Status</label>
                    <select id="component_statuses_id" name="component_statuses_id" class="form-control">
                        @foreach($components_status as $component_status)
                            <option value="{{ $component_status->id }}" @if($component_status->id == $incident->component_statuses_id) selected @endif>{{ $component_status->component_status_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="incidents_description">Incident Description</label>
                    <div> {!! Form::textarea('incidents_description', null, array('placeholder' => 'Description', 'aria-required' => 'true', 'id' => 'incidents_description', 'class' => 'form-control')) !!}</div>
                </div>

                <div class="form-group">
                    <label>Incident Status</label>
                    <select id="incident_statuses_id" name="incident_statuses_id" class="form-control">
                        @foreach($incident_statuses_id as $incident_statuses)
                            <option value="{{ $incident_statuses->id }}" @if($incident_statuses->id == $incident->incidents_status) selected @endif>{{ $incident_statuses->incident_name }}</option>
                        @endforeach
                    </select>
                </div>


            </div>
            <br /><br /><br />
            <div class="modal-footer">
                <button type="button" class="js--close-modal-incident-updates btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="submit" id="save" class="add-incidents-update-new-store btn btn-primary" data-id="{{ $incident->id }}">Save</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
    <script>
        $('textarea').ckeditor();
    </script>
</div>