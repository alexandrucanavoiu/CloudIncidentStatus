<div class="modal fade" id="myModalIncidentTemplate-edit" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Edit Incident Template</h4>
            </div>
            <div class="alert alert-danger print-error-msg" style="display:none">

                <ul></ul>

            </div>
            <form id="form">
                {{ csrf_field() }}
            <div class="modal-body">
                <div class="form-group">
                    <label for="incident_template_title">Template Title</label>
                    <input type="text" name="incident_template_title" value="{{ $component->incident_template_title }}" class="form-control input-lg" placeholder="">
                </div>

                <div class="form-group">
                    <label for="incident_template_body">Description</label>
                    <textarea id="incident_template_body" class="form-control textarea" rows="10"  name="incident_template_body" placeholder="">{{ $component->incident_template_body }}</textarea>
                </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="js--close-modal-incident-template btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="submit" id="save" class="js--ajax-form-incident-template-update btn btn-primary" data-id="{{ $component->id }}">Save</button>
            </div>
            </form>
        </div>
    </div>
    <script>
        $('textarea').ckeditor();
    </script>
</div>