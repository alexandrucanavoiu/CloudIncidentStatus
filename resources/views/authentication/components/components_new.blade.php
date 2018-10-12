<div class="modal fade" id="myModal-Component-add" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Add a new Component</h4>
            </div>
            <div class="alert alert-danger print-error-msg" style="display:none">

                <ul></ul>

            </div>
            {!! Form::open(array('route' => 'authenticated.components.new.store','method'=>'POST', 'id' => 'form', 'class' => 'js--ajax-form-component-submit')) !!}
            <div class="modal-body">
                <div class="form-group">
                    <label for="component_name">Component Name</label>
                    <div> {!! Form::text('component_name', null, array('placeholder' => 'Name', 'aria-required' => 'true', 'class' => 'form-control title input-lg')) !!}</div>
                </div>

                <div class="form-group">
                    <label for="component_description">Description</label>
                    <div> {!! Form::textarea('component_description', null, array('placeholder' => 'Description', 'aria-required' => 'true', 'id' => 'component_description', 'class' => 'form-control')) !!}</div>
                </div>

                <div class="form-group">
                    <label>Component Group</label>
                    <select id="component_groups_id" name="component_groups_id" class="form-control">
                        @foreach($component_groups as $component_group)
                            <option value="{{ $component_group->id }}">{{ $component_group->component_groups_name }}</option>
                        @endforeach
                    </select>
                </div>


                <div class="form-group">
                    <label>Component Status</label>
                    <select id="component_statuses_id" name="component_statuses_id" class="form-control">
                        @foreach($component_statues as $component_status)
                            <option value="{{ $component_status->id }}">{{ $component_status->component_status_name }}</option>
                        @endforeach
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
                <button type="button" class="js--close-modal-component btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="submit" id="save" class="add-component-store btn btn-primary">Save</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>