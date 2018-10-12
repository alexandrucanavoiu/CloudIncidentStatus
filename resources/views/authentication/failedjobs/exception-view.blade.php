<div class="modal fade" id="myModal-FailedJobsException-view" tabindex="-1" role="dialog" aria-labelledby="myModal-FailedJobsException-view" aria-hidden="true"  data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="alert alert-danger print-error-msg" style="display:none">
                <ul></ul>
            </div>
            <div class="modal-body">
                <pre>
                    {!!  var_dump($exception_failed_view->exception) !!}
                </pre>
            </div>
            <div class="modal-footer">
                <button type="button" class="js--close-modal-failed-view btn btn-default pull-left" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>