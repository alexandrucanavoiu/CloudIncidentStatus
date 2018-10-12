<div class="modal fade" id="myModal-Component-edit" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Edit Component</h4>
            </div>
            <div class="alert alert-danger print-error-msg" style="display:none">

                <ul></ul>

            </div>
            <form id="form">
                {{ csrf_field() }}
            <div class="modal-body">
                <div class="form-group">
                    <label for="component_name">Name of Component</label>
                    <input type="text" name="component_name" value="{{ $component->component_name }}" class="form-control input-lg" placeholder="">
                </div>

                <div class="form-group">
                    <label for="component_description">Name of Component</label>
                    <textarea class="form-control input-lg" rows="10" id="component_description" name="component_description">{{ $component->component_description }}</textarea>
                </div>

                <div class="form-group">
                    <label>Component Group</label>
                    <select id="component_groups_id" name="component_groups_id" class="form-control">
                        @foreach($component_groups as $component_group)
                            <option value="{{ $component_group->id }}" {{ $component_group->id === $component->component_groups_id ? 'selected' : '' }} >{{ $component_group->component_groups_name }}</option>
                        @endforeach
                    </select>
                </div>


                <div class="form-group">
                    <label>Component Status</label>
                    <select id="component_statuses_id" name="component_statuses_id" class="form-control">
                        @foreach($component_statues as $component_status)
                            <option value="{{ $component_status->id }}" {{ $component_status->id === $component->component_statuses_id ? 'selected' : '' }} >{{ $component_status->component_status_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Visibility</label>
                    <select id="status" name="status" class="form-control">
                        <option value="1" @if($component->status == 1) selected @endif>Publicat</option>
                        <option value="0" @if($component->status == 0) selected @endif>Draft</option>
                        <option value="0">Draft</option>>
                    </select>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="js--close-modal-component btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="submit" id="save" class="js--ajax-form-component-update btn btn-primary" data-id="{{ $component->id }}">Save</button>
            </div>
            </form>
        </div>
    </div>
</div>