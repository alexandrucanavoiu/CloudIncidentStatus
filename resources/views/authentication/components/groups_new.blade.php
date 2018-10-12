<div class="modal fade" id="myModal-Component-Group-add" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Add a new Component Group</h4>
            </div>
            <div class="alert alert-danger print-error-msg" style="display:none">

                <ul></ul>

            </div>
            {!! Form::open(array('route' => 'authenticated.components.groups.new','method'=>'POST', 'id' => 'form', 'class' => 'js--ajax-form-component-groups-submit')) !!}
            <div class="modal-body">
                <div class="form-group">
                    <label for="component_groups_name">Component Group Name</label>
                    <div> {!! Form::text('component_groups_name', null, array('placeholder' => 'Name', 'aria-required' => 'true', 'class' => 'form-control title input-lg')) !!}</div>
                </div>

                <div class="form-group">
                    <label>Choose visibility of the group</label>
                    <select id="visibility_group" name="visibility_group" class="form-control">
                        <option value="1">Always expanded</option>
                        <option value="2">Collapse the group by default</option>
                        <option value="3">Collapse the group, but expand if there are issues</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Visibility</label>
                    <select id="status" name="status" class="form-control">
                        <option value="1">Public</option>
                        <option value="0">Draft</option>>
                    </select>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="js--close-modal-component-groups btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="submit" id="save" class="add-component-groups-store btn btn-primary">Save</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>