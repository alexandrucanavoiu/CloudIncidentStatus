<div class="modal fade" id="myModal-Subscribe-new" tabindex="-1" role="dialog" aria-labelledby="myModal-Subscribe-new" aria-hidden="true"  data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="alert alert-danger print-error-msg" style="display:none">
                <ul></ul>
            </div>
            {!! Form::open(array('route' => 'post-subscribe','method'=>'POST', 'id' => 'form')) !!}
            <div class="modal-body">
                <p>Receive email notifications whenever new incidents are created, updated or resolved.</p>
                <div class="form-group">
                    <div> {!! Form::email('email', null, array('placeholder' => 'Email', 'aria-required' => 'true', 'class' => 'form-control title input-lg')) !!}</div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="js--close-modal-Subscribe-new btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="submit" id="save" class="subscribe-new-store btn btn-primary">Subscribe via Email</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>