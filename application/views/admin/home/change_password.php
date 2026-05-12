<?php
$this->load->view('admin/home/header');
$msg = false;

 ?>


 	<!-- start page title -->
 	<div class="page-title-box">
 			<div class="container-fluid">
 			 <div class="row align-items-center">
 					 <div class="col-sm-6">
 							 <div class="page-title">
 									 <h4>Change password</h4>
 											 <ol class="breadcrumb m-0">
												 	<li class="breadcrumb-item"><a href="<?php echo base_url('admin');?>">Dashboard</a></li>
 													<li class="breadcrumb-item active">Change Password</li>
 											 </ol>
 							 </div>
 					 </div>
 					 <div class="col-sm-6">
 							<div class="float-end d-sm-block">
								<?php if($this->input->get('msg')){ ?>
									<div class="alert alert-info alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;top:90px;width:50%;" role="alert">
											<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
											<strong><?php echo $this->input->get('msg'); ?></strong>
									</div>
								<?php }?>
 							</div>
 					 </div>
 			 </div>
 			</div>
 	 </div>
 	 <!-- end page title -->

	 <div class="container-fluid">
			 <div class="page-content-wrapper">
	 <div class="row">
		 <div class="col-12">
			 <div class="card">
				 <div class="card-body">

					 <form method="post" action="<?php echo base_url()?>admin/common/check_change_password" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">

					 	<div class="form-group mb-3">
					 		<label class="control-label col-md-3 col-sm-3 col-xs-12" for="about-data">Old Password <span class="required">*</span>
					 		</label>
					 		<div class="col-md-6 col-sm-6 col-xs-12">
					 			<input type="password" id="name" name="old" required="required" class="form-control col-md-7 col-xs-12">
					 		</div>
					 	</div>

					 <div class="form-group mb-3">
					 		<label class="control-label col-md-3 col-sm-3 col-xs-12" for="about-data">New Password <span class="required">*</span>
					 		</label>
					 		<div class="col-md-6 col-sm-6 col-xs-12">
					 			<input type="password" id="email" name="new" required="required" class="form-control col-md-7 col-xs-12">
					 		</div>
					 	</div>

					 <div class="form-group mb-3">
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
		 </div> <!-- end col -->
	 </div> <!-- end row -->
			 </div>
	 </div>
	 <!-- container-fluid -->

<?php $this->load->view('admin/home/footer');?>
