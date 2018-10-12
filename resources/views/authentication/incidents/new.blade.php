<div class="modal fade" id="myModal-Incidents-add" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Add a Incident</h4>
            </div>
            <div class="alert alert-danger print-error-msg" style="display:none">

                <ul></ul>

            </div>
            {!! Form::open(array('route' => 'authenticated.incidents.new.store','method'=>'POST', 'id' => 'form', 'class' => 'js--ajax-form-incident-submit')) !!}

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
                    <label for="incident_title">Title</label>
                    <div> {!! Form::text('incident_title', null, array('placeholder' => 'Title', 'aria-required' => 'true', 'id' => 'incident_title', 'class' => 'form-control title input-lg')) !!}</div>
                </div>

                <div class="form-group">
                    <label>Component Affected</label>
                    <select id="components_id" name="components_id[]" class="form-control select2" multiple="multiple" data-placeholder="Select a Component" style="width: 100%;">
                        @foreach($components as $component)
                        <option value="{{ $component->id }}">{{ $component->component_name }} ({{ $component->component_group->component_groups_name }})</option>
                         @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Component Status</label>
                    <select id="component_statuses_id" name="component_statuses_id" class="form-control">
                        @foreach($components_status as $component_status)
                            <option value="{{ $component_status->id }}">{{ $component_status->component_status_name }}</option>
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
                            <option value="{{ $incident_statuses->id }}">{{ $incident_statuses->incident_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Visibility</label>
                    <select id="incidents_status" name="incidents_status" class="form-control">
                        <option value="1">Published</option>
                        <option value="0">None</option>>
                    </select>
                </div>

            </div>
            <br /><br /><br />
            <div class="modal-footer">
                <button type="button" class="js--close-modal-incident-add btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="submit" id="save" class="add-incidents-store btn btn-primary">Save</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
    <script>
        $('textarea').ckeditor();
        $(function () {
            $('.select2').select2()
        });
    </script>
</div>