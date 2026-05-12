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
					<h4>Pay Run </h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/hr/payroll/payrun">Pay Run
								List</a></li>
						<li class="breadcrumb-item active">Create / Edit</li>
					</ol>
				</div>
			</div>
			<?php $admin_id = $this->session->userdata('admin_id'); ?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<?php if ($this->customer->userd($admin_id)->role == "Admin") { ?>
						<a class="btn btn-sm btn-custom pull-right" title="Back"
							href="<?php echo base_url(); ?>admin/hr/payroll/payrun"><i class="fa fa-reply"></i> Back</a>
					<?php } ?>
					&nbsp;
					<button form="demo-form2" type="submit" class="btn btn-sm btn-custom-success pull-right"
						title="Save"><i class="fa fa-save"></i> Save</button>

				</div>
				<?php if ($this->admin->getInfo()) {
					$info = explode("--", $this->admin->getInfo());
					$info_type = $info[0];
					$msg_data = $info[1];
					if ($info_type == 2) {
						?>
						<div class="alert alert-danger alert-dismissible fade show"
							style="position:fixed;z-index:99;right:20px;top:90px;width:50%;" role="alert">
							<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
							<strong>
								<?php echo $msg_data; ?>
							</strong>
						</div>
						<!-- <div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="close">x</button><?php //echo $msg_data; ?></div> -->
					<?php } else { ?>
						<div class="alert alert-info alert-dismissible fade show"
							style="position:fixed;z-index:99;right:20px;top:90px;width:50%;" role="alert">
							<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
							<strong>
								<?php echo $msg_data; ?>
							</strong>
						</div>
						<!-- <div class="alert alert-info"><button type="button" class="close" data-dismiss="alert" aria-label="close">x</button><?php //echo $msg_data;?></div> -->
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
							<h4 class="header-title">General Information</h4>
							<hr>
							<div class="col-md-4 col-sm-12 mb-3 form-group">
								<label for="name">Name <span class="required-field">*</span></label>
								<input type="text" class="form-control" id="name" name="name" maxlength="150" value=""
									required />

							</div>
							<div class="col-md-4 col-sm-6 col-xs-12">
								<div class="form-group mb-2">
									<label class="control-label" for="arabic_name">Name (Arabic)</label>
									<input type="text" id="arabic_name" name="arabic_name" value=""
										class="form-control rtl-input">
								</div>
							</div>
							<div class="col-md-4 col-sm-12 mb-3 form-group">
								<label for="Date"> <span class="required-field">Posting Date*</span></label>
								<input type="date" class="form-control" id="date" name="posting_date" maxlength="150"
									value="" required />

							</div>

							<div class="col-md-4 col-sm-12 mb-3 form-group">
								<label for="start_date"> <span class="required-field">Start Date*</span></label>
								<input type="date" class="form-control" id="startdate" name="start_date" maxlength="150"
									value="" required />

							</div>

							<div class="col-md-4 col-sm-12 mb-3 form-group">
								<label for="end_date"> <span class="required-field">End Date*</span></label>
								<input type="date" class="form-control" id="enddate" name="end_date" maxlength="150"
									value="" required />

							</div>
						</div>
					</div>
					<div class="card-body">

						<div class="row size-inner-section px-2 py-4">
							<h4 class="header-title">Selection Rule</h4>
							<hr>


							<div class="col-md-3 col-sm-12 mb-3 form-group">
								<label for="branch"> <span class="required-field">Branch*</span></label>
								<input type="text" class="form-control " id="branch" name="branchname" maxlength="150"
									value="" required />
							</div>
							<div class="col-md-3 col-sm-12 mb-3 form-group">
								<label for="branch_arabic"> <span class="required-field">Branch (Arabic)</span></label>
								<input type="text" class="form-control rtl-input" id="branch_ar" name="branch_arabic"
									maxlength="150" value="" />
							</div>
							<div class="col-md-3 col-sm-12 mb-3 form-group">
								<label for="department"> <span class="required-field">Department*</span></label>
								<input type="text" class="form-control " name="department" maxlength="150" value=""
									required />
							</div>
							<div class="col-md-3 col-sm-12 mb-3 form-group">
								<label for="department_arabic"> <span class="required-field">Department
										(Arabic)</span></label>
								<input type="text" class="form-control rtl-input" id="department_ar"
									name="department_arabic" maxlength="150" value="" />
							</div>
							<div class="col-md-3 col-sm-12 mb-3 form-group">
								<label for="designation"> <span class="required-field">Designation*</span></label>
								<input type="text" class="form-control" name="designation" maxlength="150" value=""
									required />
							</div>
							<div class="col-md-3 col-sm-12 mb-3 form-group">
								<label for="designation_arabic"> <span class="required-field">Designation
										(Arabic)</span></label>
								<input type="text" class="form-control rtl-input" id="designation_ar"
									name="designation_arabic" maxlength="150" value="" />
							</div>
							<div class="col-md-3 col-sm-12 mb-3 form-group">
								<label for="pf"> <span class="required-field">Payroll Frequency*</span></label>
								<input type="text" class="form-control" name="payroll_frequency" maxlength="150"
									value="" required />
							</div>
							<div class="col-md-3 col-sm-12 mb-3 form-group">
								<label for="pf_arabic"> <span class="required-field">Payroll Frequency
										(Arabic)</span></label>
								<input type="text" class="form-control rtl-input" id="pf_ar"
									name="payroll_frequency_arabic" maxlength="150" value="" />
							</div>
							<div class="col-md-3 col-sm-12 mb-3 form-group">
								<label for="ex_employees"> <span class="required-field">Excluded
										Employees*</span></label>
								<input type="text" class="form-control" name="ex_employees" maxlength="150" value=""
									required />
							</div>
							<div class="col-md-3 col-sm-12 mb-3 form-group">
								<label for="ex_employees_arabic"> <span class="required-field">Payroll Frequency
										(Arabic)</span></label>
								<input type="text" class="form-control rtl-input" id="ex_employees_ar"
									name="ex_employees_arabic" maxlength="150" value="" />
							</div>
						</div>
					</div>
					<div class="card-body">
						<div class="row size-inner-section px-2 py-4">
							<h4 class="header-title">Employee Selection</h4>
							<hr>

							<div class="col-md-4 col-sm-12 mb-3 form-group">
								<label for="employee"> <span class="required-field">Employee*</span></label>
								<input type="text" class="form-control rtl-input" id="employee" name="employeename" maxlength="150" value="" required />
							</div>
							<div class="col-md-4 col-sm-12 mb-3 form-group">
								<label for="employee_arabic"> <span class="required-field">Employee  (Arabic)</span></label>
								<input type="text" class="form-control rtl-input" id="employee_ar" name="employee_arabic" maxlength="150" value=""  />
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