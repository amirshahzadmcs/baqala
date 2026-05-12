<?php $this->load->view('admin/home/header'); ?>
<style>
	.size-inner-section {
		box-shadow: 0px 1px 4px #c5c5c5;
		border-radius: 5px;
		margin-bottom: 10px;
	}
</style>
<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Salary Components </h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/hr/payroll/salary-components">salary Components List</a></li>
						<li class="breadcrumb-item active">Create / Edit</li>
					</ol>
				</div>
			</div>
			<?php $admin_id = $this->session->userdata('admin_id'); ?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<?php if ($this->customer->userd($admin_id)->role == "Admin") { ?>
						<a class="btn btn-sm btn-custom pull-right" title="Back" href="<?php echo base_url(); ?>admin/hr/payroll/salary-components"><i class="fa fa-reply"></i> Back</a>
					<?php } ?>
					&nbsp;
					<button form="demo-form2" type="submit" class="btn btn-sm btn-custom-success pull-right" title="Save"><i class="fa fa-save"></i> Save</button>

				</div>
				<?php if ($this->admin->getInfo()) {
					$info = explode("--", $this->admin->getInfo());
					$info_type = $info[0];
					$msg_data = $info[1];
					if ($info_type == 2) {
				?>
						<div class="alert alert-danger alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;top:90px;width:50%;" role="alert">
							<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
							<strong><?php echo $msg_data; ?></strong>
						</div>
						<!-- <div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="close">x</button><?php //echo $msg_data; 
																																					?></div> -->
					<?php } else { ?>
						<div class="alert alert-info alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;top:90px;width:50%;" role="alert">
							<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
							<strong><?php echo $msg_data; ?></strong>
						</div>
						<!-- <div class="alert alert-info"><button type="button" class="close" data-dismiss="alert" aria-label="close">x</button><?php //echo $msg_data;
																																					?></div> -->
				<?php }
				}
				$this->admin->removeInfo(); ?>
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

						<input type="hidden" id="id" name="id" value="" />

						
							<div class="row size-inner-section px-2 py-4">
								<h4 class="header-title">Salary Component Information</h4>
								<hr>
								<div class="col-md-3 col-sm-12 mb-3 form-group">
									<label for="name">Name <span class="required-field">*</span></label>
									<input type="text" class="form-control" id="name" name="name" maxlength="150" value="" required />

								</div>
								<div class="col-md-3 col-sm-6 col-xs-12">
									<div class="form-group mb-2">
										<label class="control-label" for="arabic_name">Name (Arabic)</label>
										<input type="text" id="arabic_name" name="arabic_name" value="" class="form-control rtl-input">
									</div>
								</div>
								<div class="col-md-3 col-sm-12 mb-3 form-group">
									<label for="type"> <span class="required-field">Type*</span></label>
									<input type="text" class="form-control" name="type" maxlength="150" value="" required />

								</div>
								<div class="col-md-3 col-sm-12 mb-3 form-group">
									<label for="arabic_type"> <span class="required-field">Type (Arabic)</span></label>
									<input type="text" class="form-control rtl-input" name="arabic_type" maxlength="150" value="" />

								</div>
								<div class="col-md-3 col-sm-12 mb-3 form-group">
									<label for="status"> <span class="required-field">Status*</span></label>
									<input type="text" class="form-control" name="status" maxlength="150" value="" required />

								</div>
								<div class="col-md-3 col-sm-12 mb-3 form-group">
									<label for="arabic_status"> <span class="required-field">Status(Arabic)</span></label>
									<input type="text" class="form-control rtl-input" id="arabic_status" name="arabic_startdate" maxlength="150" value="" />

								</div>
								<div class="col-md-3 col-sm-12 mb-3 form-group">
									<label for="description"> <span class="required-field">Description*</span></label>
									<textarea type="text" class="form-control " name="description" maxlength="150" value="" row="4" columns="20" required></textarea>

								</div>
								<div class="col-md-3 col-sm-12 mb-3 form-group">
									<label for="arabic_desc"> <span class="required-field">Description(Arabic)</span></label>
									<textarea type="text" class="form-control rtl-input " name="arabic_desc" maxlength="150" row="4" columns="20" value=""></textarea>

								</div>
							</div>


					
							
							<div class="row size-inner-section px-2 py-4">
								<h4 class="header-title">Salary Component value</h4>
								<hr>
								<div class="col-md-3 col-sm-12 mb-3 form-group">
									<label for="defaultac"> <span class="required-field">Default Account*</span></label>
									<input type="text" class="form-control " name="acc_default" maxlength="150" value="" required />
								</div>

								<div class="col-md-3 col-sm-12 mb-3 form-group">
										<label for="acc_default_arabic"> <span class="required-field">Default Account (Arabic)</span></label>
										<input type="text" class="form-control rtl-input" name="acc_default_ar" maxlength="150" value="" />
								</div>

								<div class="col-md-3 col-sm-12 mb-3 form-group">
									<label for="referenceval"> <span class="required-field">Reference Value*</span></label>
									<input type="text" class="form-control" name="referenceval" maxlength="150" value="" required />
								</div>
								<div class="col-md-3 col-sm-12 mb-3 form-group">
									<label for="referenceval_arabic"> <span class="required-field">Reference Value (Arabic)</span></label>
									<input type="text" class="form-control rtl-input" name="referenceval_ar" maxlength="150" value="" />
								</div>
								<div class="row  px-2 py-4">
								<h4 class="header-title">Amount</h4>
								<hr>
							
								<div class="col-md-5 col-sm-12 mb-3 form-group">
									<label for="amount"> <span class="required-field">Enter Amount*</span></label>
									<input type="text" class="form-control rtl-input" name="amount" maxlength="150" value="" required />
								</div>
								<div class="col-md-5 col-sm-12 mb-3 form-group">
									<label for="amount_arabic"> <span class="required-field">Enter Amount (Arabic)</span></label>
									<input type="text" class="form-control rtl-input" name="amount_arabic" maxlength="150" value="" />
								</div>
							</div>			
							<div class="row  px-2 py-4">
								<h4 class="header-title">Condition</h4>
								<hr>
							
								<div class="col-md-5 col-sm-12 mb-3 form-group">
									<label for="condition"> <span class="required-field">Enter Condition*</span></label>
									<input type="text" class="form-control rtl-input" name="condition" maxlength="150" value="" required />
								</div>
								<div class="col-md-5 col-sm-12 mb-3 form-group">
									<label for="condition_arabic"> <span class="required-field">Enter Condition (Arabic)</span></label>
									<input type="text" class="form-control rtl-input" name="amount_condition" maxlength="150" value="" />
								</div>
							</div>
						</div>

					</div>


				</div>
			</div>
		</div>
	</div>
</div> <!-- end col -->
</div> <!-- end row -->
</div>
</div>
<!-- container-fluid -->




<div class="col-md-12 col-sm-12 col-xs-12">

	<div class="x_panel">
		<div class="x_content">

		</div>
	</div>
</div>
<?php $this->load->view('admin/home/footer'); ?>
