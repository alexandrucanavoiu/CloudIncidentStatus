<div class="modal fade" id="myModal-Links-add" data-keyboard="false" data-backdrop="static">
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
            {!! Form::open(array('route' => 'authenticated.settings.links.new','method'=>'POST', 'id' => 'form', 'class' => 'js--ajax-form-links-submit')) !!}

            <div class="modal-body">

                <div class="form-group">
                    <label for="footer_title">Title</label>
                    <div> {!! Form::text('footer_title', null, array('placeholder' => 'Title', 'aria-required' => 'true', 'id' => 'footer_title', 'class' => 'form-control input-lg')) !!}</div>
                </div>

                <div class="form-group">
                    <label for="footer_url">Url</label>
                    <div> {!! Form::text('footer_url', null, array('placeholder' => 'URL', 'aria-required' => 'true', 'id' => 'footer_url', 'class' => 'form-control input-lg')) !!}</div>
                </div>

                <div class="form-group">
                    <label>Target</label>
                    <select id="target_url" name="target_url" class="form-control">
                        <option value="1">_blank</option>
                        <option value="0">none</option>>
                    </select>
                </div>

            </div>
            <br /><br /><br />
            <div class="modal-footer">
                <button type="button" class="js--close-modal-links-add btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="submit" id="save" class="add-links-store btn btn-primary">Save</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>