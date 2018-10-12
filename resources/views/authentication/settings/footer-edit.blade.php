<div class="modal fade" id="myModal-Links-edit" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Add a new footer link</h4>
            </div>
            <div class="alert alert-danger print-error-msg" style="display:none">
                <ul></ul>
            </div>
            <form id="form">
                {{ csrf_field() }}
            <div class="modal-body">
                <div class="form-group">
                    <label for="footer_title">Title</label>
                    <input type="text" name="footer_title" value="{{ $link->footer_title }}" class="form-control input-lg" placeholder="">
                </div>
                <div class="form-group">
                    <label for="footer_url">Url</label>
                    <input type="text" name="footer_url" value="{{ $link->footer_url }}" class="form-control input-lg" placeholder="">
                </div>
                <div class="form-group">
                    <label>Target</label>
                    <select id="target_url" name="target_url" class="form-control">
                        <option @if($link->target_url === 1) selected @endif value="1">_blank</option>
                        <option @if($link->target_url === 0) selected @endif value="0">none</option>>
                    </select>
                </div>
            </div>
            <br /><br /><br />
            <div class="modal-footer">
                <button type="button" class="js--close-modal-links-update btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="submit" data-id="{{ $link->id }}" id="save" class="add-links-update btn btn-primary">Save</button>
            </div>
            </form>
        </div>
    </div>
</div>