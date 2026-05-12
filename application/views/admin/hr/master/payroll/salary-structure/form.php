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
					<h4>Salary Structure </h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/hr/payroll/salary-structure">Salary Structure List</a></li>
						<li class="breadcrumb-item active">Create / Edit</li>
					</ol>
				</div>
			</div>
			<?php $admin_id = $this->session->userdata('admin_id'); ?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<?php if ($this->customer->userd($admin_id)->role == "Admin") { ?>
						<a class="btn btn-sm btn-custom pull-right" title="Back" href="<?php echo base_url(); ?>admin/hr/payroll/salary-structure"><i class="fa fa-reply"></i> Back</a>
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
								<h4 class="header-title">Salary Structure Information</h4>
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
									<label for="status"> <span class="required-field">Status*</span></label>
									<input type="text" class="form-control"  name="status" maxlength="150" value="" required />

								</div>
								<div class="col-md-3 col-sm-12 mb-3 form-group">
									<label for="arabic_status"> <span class="required-field">Status (Arabic)</span></label>
									<input type="text" class="form-control rtl-input" name="arabic_status" maxlength="150" value="" />

								</div>
								<div class="col-md-3 col-sm-12 mb-3 form-group">
									<label for="payroll-frequency"> <span class="required-field">Payroll Frequency*</span></label>
									<input type="text" class="form-control"  name="payroll_frequency" maxlength="150" value="" required />

								</div>
								<div class="col-md-3 col-sm-12 mb-3 form-group">
									<label for="arabic_frequency"> <span class="required-field">Payroll Frequency (Arabic)</span></label>
									<input type="text" class="form-control rtl-input"  name="arabic_frequency" maxlength="150" value="" />

								</div>
								
							
								<div class="col-md-3 col-sm-12 mb-3 form-group">
									<label for="description"> <span class="required-field">Description*</span></label>
									<textarea type="text" class="form-control " name="description" maxlength="150" value=""  row="4" columns="20" required ></textarea>

								</div>
								<div class="col-md-3 col-sm-12 mb-3 form-group">
									<label for="arabic_description"> <span class="required-field">Description(Arabic)</span></label>
									<textarea type="text" class="form-control rtl-input " name="arabic_description" maxlength="150" row="4" columns="20" value="" ></textarea>

								</div>
							</div>

					
							<div class="row size-inner-section px-2 py-4">
								<h4 class="header-title">Earning</h4>
								<hr>
							
						
								<div class="col-md-3 col-sm-12 mb-3 form-group">
									<label for="components"> <span class="required-field">Components*</span></label>
									<input type="text" class="form-control" name="components" maxlength="150" value="" required />

								</div>
								<div class="col-md-3 col-sm-12 mb-3 form-group">
									<label for="arabic_components"> <span class="required-field">Components (Arabic)</span></label>
									<input type="text" class="form-control rtl-input" name="arabic_components" maxlength="150" value="" />

								</div>
								<div class="col-md-3 col-sm-12 mb-3 form-group">
									<label for="formula"> <span class="required-field">Formula*</span></label>
									<input type="text" class="form-control" name="formula" maxlength="150" value="" required />

								</div>
								<div class="col-md-3 col-sm-12 mb-3 form-group">
									<label for="arabic_formula"> <span class="required-field">Formula (Arabic)</span></label>
									<input type="text" class="form-control rtl-input" name="arabic_formula" maxlength="150" value="" />

								</div>
								<div class="col-md-3 col-sm-12 mb-3 form-group">
									<label for="amount"> <span class="required-field">Amount*</span></label>
									<input type="text" class="form-control" name="amount" maxlength="150" value="" required />

								</div>
								<div class="col-md-3 col-sm-12 mb-3 form-group">
									<label for="arabic_amount"> <span class="required-field">Amount (Arabic)</span></label>
									<input type="text" class="form-control rtl-input" name="arabic_amount" maxlength="150" value="" />

								</div>
							</div>
					
							<div class="row size-inner-section px-2 py-4">
								<h4 class="header-title">Deduction</h4>
								<hr>
							
								<div class="col-md-3 col-sm-12 mb-3 form-group">
									<label for="dcomponents"> <span class="required-field">Components*</span></label>
									<input type="text" class="form-control" name="dcomponents" maxlength="150" value="" required />

								</div>
								<div class="col-md-3 col-sm-12 mb-3 form-group">
									<label for="arabic_dcomponents"> <span class="required-field">Components (Arabic)</span></label>
									<input type="text" class="form-control rtl-input" name="arabic_dcomponents" maxlength="150" value="" />

								</div>
								<div class="col-md-3 col-sm-12 mb-3 form-group">
									<label for="dformula"> <span class="required-field">Formula*</span></label>
									<input type="text" class="form-control" name="dformula" maxlength="150" value="" required />

								</div>
								<div class="col-md-3 col-sm-12 mb-3 form-group">
									<label for="arabic_dformula"> <span class="required-field">Formula (Arabic)</span></label>
									<input type="text" class="form-control rtl-input" name="arabic_dformula" maxlength="150" value="" />

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
