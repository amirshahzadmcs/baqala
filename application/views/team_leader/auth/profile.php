<?php $this->load->view('team_leader/layout/header'); ?>

<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="main-content">
	<div class="page-content">
		<!-- start page title -->
		<div class="page-title-box">
			<div class="container-fluid">
				<div class="row align-items-center">
					<div class="col-sm-6">
						<div class="page-title">
							<h4>Manage Password</h4>
							<ol class="breadcrumb m-0">
								<li class="breadcrumb-item"><a href="<?= base_url('team-leader'); ?>">Dashboard</a>
								</li>
								<li class="breadcrumb-item active">Change Password</li>
							</ol>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="float-end d-none d-sm-block">
							<a class="btn btn-sm btn-custom-white pull-right me-1" title="Back"
								href="<?php echo base_url('team-leader'); ?>"><i class="fa fa-reply"></i> Back</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- end page title -->
		<div class="container-fluid">
			<div class="page-content-wrapper">
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12">
						<div class="card">
							<div class="card-body">
								<div class="row profile-sidebar">
									<!-- SIDEBAR USERPIC -->
									<div class="col-md-2 profile-userpic text-center">
										<img src="<?= base_url('store_assets/images/users/avatar.png'); ?>"
											class="img-responsive" alt="user" style="width: 100px;">
									</div>
									<!-- END SIDEBAR USERPIC -->
									<!-- SIDEBAR USER TITLE -->
									<div class="col-md-10 profile-usertitle">
										<div class="profile-usertitle-name">
											<h5 class="text-left mt-3"><?= ($result->full_name !== '') ? $result->full_name : 'N/A'; ?></h5>
										</div>
										<div class="profile-usertitle-job">
											<h6 class="text-left"><?= $result->employee_arabic_name; ?></h6>
										</div>
										<div class="profile-usertitle-job">
											<a href="<?php echo base_url('team-leader/change-password'); ?>" type="button" class="btn btn-info btn-sm me-2">Change Password</a>
											<a href="<?php echo base_url('team-leader/logout'); ?>" type="button" class="btn btn-danger btn-sm me-2">Logout</a>
										</div>
									</div>
									<!-- END SIDEBAR USER TITLE -->
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-12 col-md-12 col-sm-12">
						<div class="card p-3">
							<div class="card-body" style="min-height: 506px;">
								<?php if (!empty($result)) { ?>
									<div class="row size-inner-section px-2 py-4">
										<h4 class="header-title">General Information</h4>
										<hr>
										<div class="col-md-4 col-sm-12 mb-2 form-group">
											<label for="Iqama_Number"> ID/ Iqama Number : </label>
											<input type="text" class="form-control" readonly id="Iqama_Number" name="Iqama_Number" maxlength="10" value="<?php echo !empty($result->iqama_no) ? $result->iqama_no : ''; ?>" readonly required />
										</div>

										<div class="col-md-4 col-sm-12 mb-2 form-group">
											<div class="mb-3">
												<label for="Nationality" class="form-label">Employee Nationality : </label>
												<input type="text" class="form-control" readonly id="Nationality" name="Nationality" value="<?php echo $result->nationality_name ?? ''; ?>" required>
												<div class="invalid-feedback">
													Please provide a team_leader name.
												</div>
											</div>
										</div>
										<div class="col-md-4 col-sm-12 mb-2 form-group">
											<div class="mb-3">
												<label for="Department" class="form-label">Department</label>
												<input type="text" class="form-control" id="Department" name="Department" value="<?php echo $result->department_name; ?>" readonly required>
												<div class="invalid-feedback">
													Please provide a team_leader name in arabic.
												</div>
											</div>
										</div>
										<div class="col-md-4 col-sm-12 mb-2 form-group">
											<label for="Designation">Designation</label>
											<input type="text" class="form-control" id="Designation" name="Designation" value="<?php echo $result->designation_name; ?>" readonly required>
											<div class="invalid-feedback">
												Please provide a team_leader name in arabic.
											</div>
										</div>
										<div class="col-md-4 col-sm-12 mb-2 form-group">
											<div class="mb-3">
												<label for="Joining Date" class="form-label">Joining Date</label>
												<input type="text" class="form-control" readonly id="Joining Date" name="Joining Date" value="<?php echo $result->work_joining_date; ?>" required>
												<div class="invalid-feedback">
													Please provide a team_leader city.
												</div>
											</div>
										</div>
										<div class="col-md-4 col-sm-12 mb-2 form-group">
											<div class="mb-3">
												<label for=" Mobile No." class="form-label"> Mobile No. </label>
												<input type="text" class="form-control" readonly maxlength="55" id=" Mobile No." name=" Mobile No." value="<?php echo $result->mobile; ?>" required>
											</div>
										</div>
										<div class="col-md-4 col-sm-12 mb-2 form-group">
											<label for=" Email ID"> Email ID</label>
											<input type="text" class="form-control" readonly id=" Email ID" name=" Email ID" min="<?php echo date("Y-m-d"); ?>" value="<?php echo $result->email; ?>" />
										</div>

									</div>
								<?php } else {
									echo '<h5>No data found</h5>';
								} ?>
							</div>
						</div>
					</div>
					<!-- end col -->
				</div>
				<!-- end row -->
			</div>
		</div>
		<!-- container-fluid -->
	</div>
	<!-- End Page-content -->
</div>
<!-- end page content-->
<?php $this->load->view('team_leader/layout/footer'); ?>