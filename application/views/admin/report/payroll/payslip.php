<?php $this->load->view('admin/home/header'); ?>
<style>
	.dataTables_wrapper::-webkit-scrollbar {
		display: none;
	}

	.nav-md .container.body .right_col {
		padding: 10px 10px 0;
		margin-left: 230px;
	}

	.roundCircle {
		/* background-color: rgba(35,197,143,.25)!important; */
		border-radius: 50%;
		width: 50px;
		height: 50px;
		padding: 12px 14px;
	}
	.input-group-text {
        padding: 0 0.75rem;
    }
</style>


<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Payslips</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/payroll-reports'); ?>">Payroll Report</a></li>
						<li class="breadcrumb-item active">Payslips</li>
					</ol>
				</div>
			</div>
			<?php $admin_id = $this->session->userdata('admin_id'); ?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<!-- <?php //if($this->customer->userd($admin_id)->role=="Admin" ){
							?>
							<button type="button" class="btn btn-custom-danger btn-sm pull-right" onclick="deleteAction()" title="Delete"><i class="fa fa-trash"></i> Delete</button>
							<?php //} 
							?> -->
					&nbsp;
					<a class="btn btn-custom-danger btn-sm pull-right me-1" title="Sales Report" href="<?php echo base_url('admin/payroll-reports') ?>"><i class="fa fa-chevron-left me-2"></i> Go back</a>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- end page title -->


<div class="container-fluid">
	<div class="page-content-wrapper">
		<div class="row">

			<div class="col-12 mb-3">
				<div class="card">
					<div class="card-body">
						<form action="<?php echo base_url('admin/report/payslips') ?>" method="get">
							<div class="row">
								<div class="form-group col-lg-2 col-md-4 col-12 mb-3">
									<label for="staff">Staff:</label>
									<select name="staff" id="staff" class="form-control select2 w-100" data-placeholder="Choose Staff...">
										<option value="">Select</option>
										<option value="1">ALL</option>
									</select>
								</div>
								<div class="form-group col-lg-2 col-md-4 col-12 mb-3">
									<label for="status">Status:</label>
									<select name="status" class="form-control select2 w-100" data-placeholder="Choose Status...">
										<option value="">Select</option>
										<option value="1">Generated</option>
										<option value="2">Approved</option>
										<option value="3">Paid</option>
									</select>
								</div>
								<div class="form-group col-lg-4 col-md-4 col-12 mb-3">
									<label for="date_range">Date Range:</label>
									<div class="input-daterange input-group" id="datepicker6" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container="#datepicker6">
										<input type="text" class="form-control" name="start" placeholder="Start Date">
                                            <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
										<input type="text" class="form-control" name="end" placeholder="End Date">
                                            <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
									</div>
								</div>
								<div class="form-group col-lg-2 col-md-4 col-12 mb-3 d-flex align-items-center">
									<div class="form-check form-switch" dir="ltr">
										<input type="checkbox" class="form-check-input" id="draft">
										<label class="form-check-label" for="draft">Hide Salary Components</label>
									</div>
								</div>
								<div class="form-group col-lg-2 col-md-4 col-12 mb-3">
									<label for="group_by">Group By:</label>
									<select name="group_by" id="group_by" class="form-control select2" data-placeholder="Choose Group by...">
										<option value="">Select</option>
										<option value="1">Employee</option>
										<option value="2">Yearly</option>
										<option value="3">Monthly</option>
										<option value="4">Department</option>
										<option value="5">Branch</option>
									</select>
								</div>
								<div class="form-group col-lg-2 col-md-4 col-12 mb-3">
									<label for="button"></label>
									<input type="submit" value="Show report" class="form-control btn btn-success mt-2" />
								</div>
							</div>
						</form>
					</div>
				</div>
			</div> <!-- end col -->

			<div class="col-9 mb-3 mx-auto">
				<div class="card">
					<div class="card-body bg-soft-warning text-center pb-2">
						<p class="fw-bold">No data match the supplied filters</p>
					</div>
				</div>
			</div> <!-- end col -->

		</div> <!-- end row -->
	</div>
</div>
<!-- container-fluid -->


<?php $this->load->view('admin/home/footer'); ?>
