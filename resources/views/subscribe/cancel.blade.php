<div class="modal fade" id="myModal-Subscribe-cancel"  data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><strong>Confirm Unsubscribe</strong></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            {!! Form::open(array('route' => ['manage-subscribe-cancel-confirm', $code],'method'=>'GET', 'id' => 'form')) !!}
            <div class="modal-body">
                <p>Click the confirm button below to unsubscribe {{ $email }} from all {{ $title_app }} updates..</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="js--close-modal-Subscribe-cancel btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="submit" data-code="{{ $code }}" id="save" class="subscribe-cancel-confirm btn btn-danger">UNSUBSCRIBE FROM UPDATES</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>