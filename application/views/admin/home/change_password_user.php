<?php
$this->load->view('admin/home/header');
$msg = false;

 ?>
          

<div class="page-title">
              <div class="title_left">
                <h3>Administrator</h3>
              </div>

              <div class="title_right">
                <?php if($this->input->get('msg')){ ?> <div class="alert alert-info"><button type="button" class="close" data-dismiss="alert" aria-label="close">x</button>
				<?php echo $this->input->get('msg'); ?> </div><?php }?>
              </div>
            </div>
            <div class="clearfix"></div>
			 <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                          <div class="x_content">
						  <h2>Change Password User </h2>
                  
                    <div class="clearfix"></div>
						  
                    <br />
                    <form method="post" action="<?php echo base_url()?>admin/common/check_change_password_user" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
					
                     <input type="hidden"  name="id" value="<?php echo $id; ?>" class="form-control col-md-7 col-xs-12">
					  
					  <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="about-data">New Password <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="password" id="email" name="new" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
					  
					  <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="about-data">Confirm Password <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="password" id="mobile" name="confirm" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
					  
	
                    
                      <div class="ln_solid"></div>
					
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                         <button class="btn btn-primary" type="reset">Reset</button>
                          <input type="submit" name="submit" class="btn btn-success">
                        </div>
                      </div>

                    </form>
                  </div>
                        </div>
                        </div>
                      </div>
<?php $this->load->view('admin/home/footer');?>