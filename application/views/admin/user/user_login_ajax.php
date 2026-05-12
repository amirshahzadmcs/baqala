<?php echo form_open("admin/business-user/corporate-login-save", array("id"=>"bs-login-form", "class"=>"form-horizontal form-label-left")); ?>
    <div class="row">
        <input type="hidden" name="main_id" value="<?= $main_id;?>" required="required" />
        <input type="hidden" name="login_id" value="<?= $login_id;?>" />
        <div class="col-md-6  mb-3 form-group">
            <label for="display_name">Display Name <span class="required">*</span></label>
            <input type="text" class="form-control" id="display_name" name="display_name" value="<?= $display_name;?>" minlength="3" maxlength="99" required="required" />
        </div>
        <div class="col-md-6  mb-3 form-group">
            <label for="login_username">Username (Should be unique) <span class="required">*</span></label>
            <input type="text" class="form-control" id="login_username" name="username" value="<?= $username;?>" minlength="3" maxlength="55" required="required" />
        </div>
		<div class="col-md-6  mb-3 form-group">
            <label for="login_email">Email</label>
            <input type="email" class="form-control" id="login_email" name="login_email" value="<?= $login_email;?>" minlength="3" maxlength="99" />
        </div>
		<div class="col-md-6  mb-3 form-group">
            <label for="login_phone">Contact Number</label>
            <input type="text" class="form-control" id="login_phone" name="login_phone" value="<?= $login_phone;?>" onkeypress="return numerics(event);" minlength="10" maxlength="13" />
        </div>
        <div class="col-md-6  mb-3 form-group">
            <label for="login_role">Role <span class="required">*</span></label>
            <select id="login_role" name="login_role" class="form-control col-md-12 select2" required="required">
                <option value="">Select Role</option>
                <option value="main" <?php echo ($login_role == 'main') ? "selected":"";?>>Main</option>
                <option value="staff" <?php echo ($login_role == 'staff') ? "selected":"";?>>Staff</option>
            </select>
        </div>
        <div class="col-md-6  mb-3 form-group">
            <label for="login_status">Status <span class="required">*</span></label>
            <select id="login_status" name="login_status" class="form-control col-md-12 select2" required="required">
                <option value="">Select Status</option>
                <option value="active" <?php echo ($login_status == 'active') ? "selected":"";?>>Active</option>
                <option value="inactive" <?php echo ($login_status == 'inactive') ? "selected":"";?>>Inactive</option>
            </select>
        </div>
        <div class="col-md-12 mb-3">
            <button type="submit" class="btn btn-sm btn-custom-success float-end" title="Save"> Save Login </button>
        </div>
    </div>
<?php echo form_close(); ?>
