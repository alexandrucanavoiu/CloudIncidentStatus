<div class="modal fade" id="myModal-schedule-edit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Edit Schedule</h4>
            </div>
            <div class="alert alert-danger print-error-msg" style="display:none">

                <ul></ul>

            </div>
            <form id="form">
                {{ csrf_field() }}
            <div class="modal-body">
                <div class="form-group">
                    <label for="scheduled_title">Title</label>
                    <input type="text" name="scheduled_title" value="{{ $schedule->scheduled_title }}" class="form-control input-lg" placeholder="">
                </div>

                <div class="form-group">
                    <label>Component Affected</label>
                    <select id="components_id" name="components_id[]" class="form-control select2" multiple="multiple" data-placeholder="Select a Component" style="width: 100%;">
                        @foreach($components as $component)
                            <option {{($searchcomponents->search($component->id)) ? 'selected' : ''}} value="{{ $component->id }}">{{ $component->component_name }} ({{ $component->component_group->component_groups_name }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="scheduled_description">Description Schedule</label>
                    <textarea id="scheduled_description" class="form-control textarea" rows="10"  name="scheduled_description" placeholder="">{{ $schedule->scheduled_description }}</textarea>
                </div>

                <div class="col-md-6">
                <div class="form-group">
                    <label for="scheduled_start">Schedule Start</label>
                <div class="input-append date form_datetime" data-date="{{ $schedule->scheduled_start->format('Y-m-d H:i:s') }}">
                    <input id="scheduled_start" name="scheduled_start" class="form-control" size="16" value="{{ $schedule->scheduled_start->format('Y-m-d H:i:s') }}" type="text" readonly>
                    <span class="add-on"><i class="icon-remove"></i></span>
                    <span class="add-on"><i class="icon-calendar"></i></span>
                </div>
                </div>
                </div>

                <div class="col-md-6">
                <div class="form-group">
                    <label for="scheduled_end">Schedule End</label>
                    <div class="input-append date form_datetime" data-date={{ $schedule->scheduled_end->format('Y-m-d H:i:s') }}">
                        <input id="scheduled_end" name="scheduled_end" class="form-control" size="16" value="{{ $schedule->scheduled_end->format('Y-m-d H:i:s') }}" type="text" readonly>
                        <span class="add-on"><i class="icon-remove"></i></span>
                        <span class="add-on"><i class="icon-calendar"></i></span>
                    </div>
                </div>
                </div>

                <div class="form-group">
                    <label>Visibility</label>
                    <select id="archived" name="archived" class="form-control">
                        <option value="1" @if($schedule->archived == 1) selected @endif>Archived</option>
                        <option value="0" @if($schedule->archived == 0) selected @endif>Visible</option>
                    </select>
                </div

            </div>
            <br /><br /><br />
            <div class="modal-footer">
                <button type="button" class="js--close-modal-schedule btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="submit" id="save" class="add-schedule-update btn btn-primary"  data-id="{{ $schedule->id }}">Save</button>
            </div>
            </form>
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