<?php $this->load->view('admin/home/header');?>
<div class="page-title">
              <div class="title_left">
                <h3>Users</h3>
			  </div>
			  <div class="title_right">
			  <a class="btn btn-sm btn-default pull-right"  data-toggle="tooltip" title="Back" href="<?php echo base_url();?>admin/user"><i class="fa fa-reply"></i></a>
				<button form="demo-form2" type="submit" class="btn btn-sm btn-info pull-right"  data-toggle="tooltip" title="Save"><i class="fa fa-save"></i></button>
              </div>
			  </div>
			  <div class="clearfix"></div>
			  
			  
<div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h5><i class="fa fa-pencil"></i> UPDATE USERNAME / PASSWORD</h5>
                       <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                    <?php echo form_open("admin/user/update_user", array("id"=>"demo-form2", "enctype"=>"multipart/form-data", "class"=>"form-horizontal form-label-left")); ?>
						
                          <input type="hidden" id="id" name="id" value="<?php echo $id;?>">
						
					  <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">UserName <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="username" name="username" value="<?php echo $username;?>" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
					  <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Password 
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="password" id="password" name="password" class="form-control col-md-7 col-xs-12">
                        </div>
						<div class="col-md-3 col-sm-3 col-xs-12">
                         <span style="color:red">* You can leave it blank if you don't want to change password.</span> 
						 </div>
                      </div>
					  
					  <div class="form-group">

                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">role_id <span class="required">*</span>

                        </label>

                        <div class="col-md-6 col-sm-6 col-xs-12">

                          <select id="role_id" name="role_id" required="required" class="form-control col-md-7 col-xs-12">

							<option value="">Select User Role</option>

							<option value="1" <?php echo ($role_id == '1') ? "selected":"";?>>Operator</option>

							<option value="2" <?php echo ($role_id == '2') ? "selected":"";?>>Sales Representative</option>

							<option value="3" <?php echo ($role_id == '3') ? "selected":"";?>>Authorised</option>

							<option value="4" <?php echo ($role_id == '4') ? "selected":"";?>>UnAuthorised</option>

							</select>

                        </div>

                      </div>

					  

					  <div class="form-group">

                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Password Remaining Days (In Days)<span class="required">*</span>

                        </label>

                        <div class="col-md-6 col-sm-6 col-xs-12">

                          <input type="text" id="password_till" name="password_till" value="<?php echo $days_left;?>" required="required" class="form-control col-md-7 col-xs-12">

                        </div>

                      </div>
					  
                    <?php echo form_close(); ?>
                  </div>
                </div>
              </div>
            </div>
			<?php $this->load->view('admin/home/footer');?>