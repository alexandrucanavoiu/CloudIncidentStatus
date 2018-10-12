<div class="modal fade" id="myModal-Schedule-add">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Add a Schedule</h4>
            </div>
            <div class="alert alert-danger print-error-msg" style="display:none">

                <ul></ul>

            </div>
            {!! Form::open(array('route' => 'authenticated.schedule.new.store','method'=>'POST', 'id' => 'form', 'class' => 'js--ajax-form-schedule-submit')) !!}
            <div class="modal-body">
                <div class="form-group">
                    <label for="scheduled_title">Title</label>
                    <div> {!! Form::text('scheduled_title', null, array('placeholder' => 'Name', 'aria-required' => 'true', 'id' => 'scheduled_title', 'class' => 'form-control title input-lg')) !!}</div>
                </div>

                <div class="form-group">
                    <label>Component(s) Affected</label>
                    <select id="components_id" name="components_id[]" class="form-control select2" multiple="multiple" data-placeholder="Select a Component" style="width: 100%;">
                        @foreach($components as $component)
                            <option value="{{ $component->id }}">{{ $component->component_name }} ({{ $component->component_group->component_groups_name }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="scheduled_description">Description Schedule</label>
                    <div> {!! Form::textarea('scheduled_description', null, array('placeholder' => 'Description', 'aria-required' => 'true', 'id' => 'scheduled_description', 'class' => 'form-control')) !!}</div>
                </div>

                <div class="col-md-6">
                <div class="form-group">
                    <label for="scheduled_start">Schedule Start</label>
                <div class="input-append date form_datetime" data-date="{{ $current_date_time->toDateTimeString() }}">
                    <input id="scheduled_start" name="scheduled_start" class="form-control" size="16" value="{{ $current_date_time->toDateTimeString() }}" type="text" readonly>
                    <span class="add-on"><i class="icon-remove"></i></span>
                    <span class="add-on"><i class="icon-calendar"></i></span>
                </div>
                </div>
                </div>

                <div class="col-md-6">
                <div class="form-group">
                    <label for="scheduled_end">Schedule End</label>
                    <div class="input-append date form_datetime" data-date="{{ $current_date_time->toDateTimeString() }}">
                        <input id="scheduled_end" name="scheduled_end" class="form-control" size="16" value="{{ $current_date_time->toDateTimeString() }}" type="text" readonly>
                        <span class="add-on"><i class="icon-remove"></i></span>
                        <span class="add-on"><i class="icon-calendar"></i></span>
                    </div>
                </div>
                </div>

                <div class="form-group">
                    <label>Visibility</label>
                    <select id="archived" name="archived" class="form-control">
                        <option value="0">Visible</option>>
                        <option value="1">Archived</option>
                    </select>
                </div

            </div>
            <br /><br /><br />
            <div class="modal-footer">
                <button type="button" class="js--close-modal-schedule btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="submit" id="save" class="add-schedule-store btn btn-primary">Save</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
    <script>
        $('textarea').ckeditor();
    </script>
    <script type="text/javascript">
        $(".form_datetime").datetimepicker({
            format: "yyyy-mm-dd hh:ii:ss",
            autoclose: true,
            todayBtn: true,
            startDate: "2018-09-13 10:00:00",
            minuteStep: 5
        });
        $(function () {
            $('.select2').select2()
        });
    </script>
</div>