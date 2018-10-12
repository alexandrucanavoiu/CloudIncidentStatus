<div class="modal fade" id="myModal-Incidents-edit" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Edit a Incident</h4>
            </div>
            <div class="alert alert-danger print-error-msg" style="display:none">

                <ul></ul>

            </div>
            <form id="form">
                {{ csrf_field() }}
            <div class="modal-body">
                <div class="form-group">
                    <label for="incident_title">Title</label>
                    <input type="text" name="incident_title" value="{{ $incident->incident_title }}" class="form-control input-lg" placeholder="">
                </div>

                <div class="form-group">
                    <label>Component Affected</label>
                    <select id="components_id" name="components_id[]" class="form-control select2" multiple="multiple" data-placeholder="Select a Component" style="width: 100%;">
                        @foreach($components as $component)
                            <option {{($searchcomponents->search($component->id)) ? 'selected' : ''}} value="{{ $component->id }}">{{ $component->component_name }} ({{ $component->component_group->component_groups_name }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Component Status</label>
                    <select id="component_statuses_id" name="component_statuses_id" class="form-control">
                        @foreach($component_statuses_id as $component_status)
                            <option @if($component_status->id == $incident->component_statuses_id) selected @endif value="{{ $component_status->id }}">{{ $component_status->component_status_name }} </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Visibility</label>
                    <select id="incidents_status" name="incidents_status" class="form-control">
                        <option value="1" @if($incident->incidents_status == 1) selected @endif>Published</option>
                        <option value="0" @if($incident->incidents_status == 0) selected @endif>Hidden</option>
                    </select>
                </div>

            </div>
            <br /><br /><br />
            <div class="modal-footer">
                <button type="button" class="js--close-modal-incident-add btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="submit" id="save" class="add-incidents-update btn btn-primary" data-id="{{ $incident->id }}">Save</button>
            </div>
            </form>
        </div>
    </div>
    <script>
        $('textarea').ckeditor();
        $(function () {
            $('.select2').select2()
        });
    </script>
</div>