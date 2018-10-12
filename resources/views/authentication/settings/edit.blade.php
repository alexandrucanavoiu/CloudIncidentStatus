<div class="modal fade" id="myModal-Settings-edit" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Edit Settings</h4>
            </div>
            <div class="alert alert-danger print-error-msg" style="display:none">
                <ul></ul>
            </div>
            <form id="form" enctype="multipart/form-data">
                {{ csrf_field() }}
            <div class="modal-body">
                <div class="form-group">
                    <label for="title_app">Site Name</label>
                    <input type="text" name="title_app" id="title-app" value="{{ $setting->title_app }}" class="form-control input-lg" placeholder="">
                </div>

                <div class="form-group">
                    <label for="title_app">Site Timezone</label>
                <select name="time_zone_interface" id="time-zone-interface" class="form-control">
                    @foreach (timezone_identifiers_list() as $timezone)
                        <option value="{{ $timezone }}"{{ $timezone == $setting->time_zone_interface ? ' selected' : '' }}>{{ $timezone }}</option>
                    @endforeach
                </select>
                </div>

                <div class="form-group">
                    <label for="days_of_incidents">Days of Incidents to show</label>
                    <select id="days-of-incidents" name="days_of_incidents" class="form-control">
                        <option value="1" @if($setting->days_of_incidents == 1) selected @endif>1</option>
                        <option value="2" @if($setting->days_of_incidents == 2) selected @endif>2</option>
                        <option value="3" @if($setting->days_of_incidents == 3) selected @endif>3</option>
                        <option value="4" @if($setting->days_of_incidents == 4) selected @endif>4</option>
                        <option value="5" @if($setting->days_of_incidents == 5) selected @endif>5</option>
                        <option value="6" @if($setting->days_of_incidents == 6) selected @endif>6</option>
                        <option value="7" @if($setting->days_of_incidents == 7) selected @endif>7</option>
                        <option value="8" @if($setting->days_of_incidents == 8) selected @endif>8</option>
                        <option value="9" @if($setting->days_of_incidents == 9) selected @endif>9</option>
                        <option value="10" @if($setting->days_of_incidents == 10) selected @endif>10</option>
                        <option value="11" @if($setting->days_of_incidents == 11) selected @endif>11</option>
                        <option value="12" @if($setting->days_of_incidents == 12) selected @endif>12</option>
                        <option value="13" @if($setting->days_of_incidents == 13) selected @endif>13</option>
                        <option value="14" @if($setting->days_of_incidents == 14) selected @endif>14</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="bulk_emails">Number of the Emails in a bulk</label>
                    <input type="text" name="bulk_emails" id="bulk_emails" value="{{ $setting->bulk_emails }}" class="form-control input-lg" placeholder="">
                </div>

                <div class="form-group">
                    <label for="bulk_emails_sleep">Job Sleep after sent a Bulk Email</label>
                    <input type="text" name="bulk_emails_sleep" id="bulk_emails_sleep" value="{{ $setting->bulk_emails_sleep }}" class="form-control input-lg" placeholder="">
                </div>

                <div class="form-group">
                    <label for="queue_name_incidents">Queue Name for Incidents</label>
                    <input type="text" name="queue_name_incidents" id="queue_name_incidents" value="{{ $setting->queue_name_incidents }}" class="form-control input-lg" placeholder="">
                </div>

                <div class="form-group">
                    <label for="queue_name_maintenance">Queue Name for Maintenance</label>
                    <input type="text" name="queue_name_maintenance" id="queue_name_maintenance" value="{{ $setting->queue_name_maintenance }}" class="form-control input-lg" placeholder="">
                </div>

                <div class="form-group">
                    <label for="from_address">(Email) From Address</label>
                    <input type="text" name="from_address" id="from_address" value="{{ $setting->from_address }}" class="form-control input-lg" placeholder="">
                </div>

                <div class="form-group">
                    <label for="from_name">(Email)From Name</label>
                    <input type="text" name="from_name" id="from_name" value="{{ $setting->from_name }}" class="form-control input-lg" placeholder="">
                </div>
                <div class="form-group">
                    <label for="google_analytics_code">Google Analytics code</label>
                    <input type="text" name="google_analytics_code" id="google-analytics-code" value="{{ $setting->google_analytics_code }}" class="form-control input-lg" placeholder="">
                </div>


                <div class="form-group">
                    <label>Allow people to signup to email notifications?</label>
                    <select id="allow-subscribers" name="allow_subscribers" class="form-control">
                        <option value="1" @if($setting->allow_subscribers == 1) selected @endif>Yes</option>
                        <option value="0" @if($setting->allow_subscribers == 0) selected @endif>No</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Logo</label>
                    <div id="settings-logo2"><img width="200px" src="/images/{{ $setting->settings_logo }}" /></div>

                    <br /><br /><br />

                    <label>Replace the Logo</label>
                <div id="settings-logo" class="well settings-logo" data-bind="fileDrag: fileData">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <img style="height: 125px;" class="img-rounded thumb" data-bind="attr: { src: fileData().dataURL }, visible: fileData().dataURL">
                            <div data-bind="ifnot: fileData().dataURL">
                                <label class="drag-label">Drag file here</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <input name="settings_logo" id="settings-logo" type="file" data-bind="fileInput: fileData, customFileInput: {
              buttonClass: 'btn btn-success',
              fileNameClass: 'disabled form-control',
              onClear: onClear,
            }" accept="image/*">
                        </div>
                    </div>
                </div>
                </div>


            </div>
            <br /><br /><br />
            <div class="modal-footer">
                <button type="button" class="js--close-settings-update btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="submit" id="save" class="settings-update btn btn-primary">Save</button>
            </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(function(){
        if($('#settings-logo')[0] !== undefined){
            <!-- ko template: 'Image' -->
            var element = $('#settings-logo')[0];
            ko.cleanNode(element);
            var viewModel = {};
            viewModel.fileData = ko.observable({
                dataURL: ko.observable()
            });
            viewModel.onClear = function(fileData){
                if(confirm('Are you sure?')){
                    fileData.clear && fileData.clear();
                }
            };
            ko.applyBindings(viewModel, document.getElementById('settings-logo'));
            <!-- /ko -->
        }
    });
</script>