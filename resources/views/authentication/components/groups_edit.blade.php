<div class="modal fade" id="myModal-Component-Group-edit" data-keyboard="false" data-backdrop="static">
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
            <form id="form">
                {{ csrf_field() }}
            <div class="modal-body">

                <div class="form-group">
                    <label for="name">Component Group Name</label>
                    <div>
                        <input type="text" name="component_groups_name" value="{{ $component->component_groups_name }}" class="form-control input-lg" placeholder="">
                    </div>
                    <span class="text-error errors_name"></span>
                </div>

                <div class="form-group">
                    <label>Choose visibility of the group</label>
                    <select id="visibility_group" name="visibility_group" class="form-control">
                        <option value="1" @if($component->status == 1) selected @endif>Always expanded</option>
                        <option value="2" @if($component->status == 2) selected @endif>Collapse the group by default</option>
                        <option value="3" @if($component->status == 3) selected @endif>Collapse the group, but expand if there are issues</option>
                    </select>
                    <span class="text-error errors_visibility_group"></span>
                </div>

                <div class="form-group">
                    <label>Visibility</label>
                    <select id="status" name="status" class="form-control">
                        <option value="1" @if($component->status == 1) selected @endif>Publicat</option>
                        <option value="0" @if($component->status == 0) selected @endif>Draft</option>
                    </select>
                    <span class="text-error errors_status"></span>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="js--close-modal-component-groups btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="submit" id="save" class="btn btn-primary js--ajax-form-component-groups-update" data-id="{{ $component->id }}">Save</button>
            </div>
            </form>
        </div>
    </div>
</div>