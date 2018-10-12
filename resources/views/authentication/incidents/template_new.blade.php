<div class="modal fade" id="myModalIncidentTemplate-add" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Add a new Incident Template</h4>
            </div>
            <div class="alert alert-danger print-error-msg" style="display:none">

                <ul></ul>

            </div>
            {!! Form::open(array('route' => 'authenticated.templates.new.store','method'=>'POST', 'id' => 'form', 'class' => 'js--ajax-form-incident-template-submit')) !!}
            <div class="modal-body">
                <div class="form-group">
                    <label for="component_name">Component Name</label>
                    <div> {!! Form::text('incident_template_title', null, array('placeholder' => 'Name', 'aria-required' => 'true', 'class' => 'form-control title input-lg')) !!}</div>
                </div>

                <div class="form-group">
                    <label for="component_description">Description</label>
                    <div> {!! Form::textarea('incident_template_body', null, array('placeholder' => 'Description', 'aria-required' => 'true', 'id' => 'incident_template_body', 'class' => 'form-control')) !!}</div>
                </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="js--close-modal-incident-template btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="submit" id="save" class="add-incident-template-store btn btn-primary">Save</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
    <script>
        $('textarea').ckeditor();
    </script>
</div>