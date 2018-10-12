<div class="modal fade" id="myModal-Users-edit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Edit User</h4>
            </div>
            <div class="alert alert-danger print-error-msg" style="display:none">
                <ul></ul>
            </div>
            <form id="form">
                {{ csrf_field() }}

            <div class="modal-body">

                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" name="name" id="users-full-name" value="{{ $get_user->name }}" class="form-control input-lg" placeholder="">
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="users-email" value="{{ $get_user->email }}" class="form-control input-lg" placeholder="">
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="users-password" value="" class="form-control input-lg" placeholder="">
                </div>

                <div class="form-group">
                    <label for="confirm_password">Confirm Password</label>
                    <input type="password" name="confirm_password" id="users-confirm-password" value="" class="form-control input-lg" placeholder="">
                </div>

                <div class="form-group">
                    <label>User Level</label>
                    <select id="level" name="level" class="form-control">
                        <option value="0" @if($get_user->level == 0) selected @endif>User</option>
                        <option value="10" @if($get_user->level == 10) selected @endif>Admin</option>>
                    </select>
                </div>

            </div>
            <br /><br /><br />
            <div class="modal-footer">
                <button type="button" class="js--close-modal-users-edit btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="submit" id="save" class="add-users-update btn btn-primary" data-id="{{ $get_user->id }}">Save</button>
            </div>
            </form>
        </div>
    </div>
</div>