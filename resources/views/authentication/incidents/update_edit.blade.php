<div class="modal fade" id="myModal-Incidents-update-edit" data-keyboard="false" data-backdrop="static">
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
                    <textarea class="form-control input-lg" rows="10" id="incidents_description" name="incidents_description">{{ $incident->incidents_description }}</textarea>
                </div>

                <div class="form-group">
                    <label>Incident Status</label>
                    <select id="incident_statuses_id" name="incident_statuses_id" class="form-control">
                        @foreach($incident_statuses_id as $incident_statuses)
                            <option value="{{ $incident_statuses->id }}" @if($incident_statuses->id == $incident->incident_statuses_id) selected @endif>{{ $incident_statuses->incident_name }}</option>
                        @endforeach
                    </select>
                </div>


            </div>
            <br /><br /><br />
            <div class="modal-footer">
                <button type="button" class="js--close-modal-incident-updates btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="submit" id="save" class="add-incidents-update-edit-update btn btn-primary" data-incident-id="{{ $incident->incidents_id }}" data-id="{{ $incident->id }}">Save</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
    <script>
        $('textarea').ckeditor();
    </script>
</div>