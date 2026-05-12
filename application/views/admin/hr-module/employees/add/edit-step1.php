<?php $this->load->view('admin/home/header'); ?>

<style>
	.required-field {
		color: #f00;
	}

	.nav-pills .nav-link.active,
	.nav-pills .show>.nav-link {
		color: #fff !important;
		background-color: #005500 !important;
	}

	.nav-tabs-custom .nav-item .nav-link::after {
		content: "";
		background: #005500;
	}

	.nav-tabs-custom .nav-item .nav-link {
		background: #eee;
	}

	.size-inner-section {
		box-shadow: 0px 1px 4px #c5c5c5;
		border-radius: 5px;
		margin-bottom: 10px;
	}

	.cv-documents {
		border: 1px dashed #a9a9a9;
		padding: 6px;
		width: 130px;
		height: 130px;
		margin-top: -9px;
	}

	.image-container {
		position: relative;
		display: inline-block;
	}

	.image-container .overlay {
		opacity: 0;
	}

	.image-container:hover .overlay {
		background: #0006;
		opacity: .9;
		position: absolute;
		top: -9px;
		bottom: 0;
		width: 130px;
		height: 130px;
	}

	.image-container:hover .edit {
		display: block;
	}

	.image-container .edit {
		padding-top: 7px;
		padding-right: 7px;
		position: absolute;
		right: 0;
		left: 0;
		top: 20%;
		display: none;
	}
	.changePasswordModal .modal-dialog-aside{
		width: 30%;
		max-width:80%; height: 100%; margin:0;
		transform: translate(0); transition: transform .2s;
	}
	.changePasswordModal .modal-dialog-aside .modal-content{  height: inherit; border:0; border-radius: 0;}
	.changePasswordModal .modal-dialog-aside .modal-content .modal-body{ overflow-y: auto }
	.modal.fixed-left .modal-dialog-aside{ margin-left:auto;  transform: translateX(100%); }
	.modal.fixed-right .modal-dialog-aside{ margin-right:auto; transform: translateX(-100%); }

	.modal.show .modal-dialog-aside{ transform: translateX(0);  }
</style>
<div id="wait"><i class="fa fa-spinner fa-spin"></i><br>Updating..</div>
<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>New Employee</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/hr/employees'); ?>">Employees</a></li>
						<li class="breadcrumb-item active">New Employee</li>
					</ol>
				</div>
			</div>
			<?php $admin_id = $this->session->userdata('admin_id'); ?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<a class="btn btn-sm btn-custom-white pull-right me-2" title="Back" href="<?php echo base_url('admin/hr/employees'); ?>"><i class="fa fa-reply"></i> Back</a>
					<a type="button" class="btn btn-sm btn-custom-danger pull-right" title="Change Password" data-bs-toggle="modal" data-bs-target="#changePasswordModal"> Change Password</a>
					<?php if($emp_detail->send_credential == 'on'){ ?>
					<!--
					<a class="btn btn-sm btn-custom-danger pull-right ms-2" title="Send Credentials" href="<?php echo base_url('admin/hr/master/employee/send-credential?id='.$emp_detail->id); ?>"><i class="dripicons-export"></i> Send Credential</a>
					-->
					<?php } ?>
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
					<?php } else { ?>
						<div class="alert alert-info alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;top:90px;width:50%;" role="alert">
							<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
							<strong><?php echo $msg_data; ?></strong>
						</div>
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
						<?php $this->load->view('admin/hr-module/employees/components/top-profile-section');?>
						<div class="step-wraper">
							<?php
								$active_step = 1;
								$nav_emp_id = isset($emp_detail->id) ? $emp_detail->id : null;
								$this->load->view('admin/hr-module/employees/components/add_step_navigation', compact('active_step', 'nav_emp_id'));
							?>
						</div>
						<?php echo form_open("admin/hr/employees/update-step-1", array("id" => "employee_form", "enctype" => "multipart/form-data", "class" => "form-label-left", "data-parsley-validate" => "")); ?>
						<input type="hidden" id="id" name="id" value="<?php echo $emp_detail->id; ?>" />
						<!-- Tab panes -->
						<div class="row size-inner-section px-2 py-4 mx-2">
							<h4 class="header-title">General Information</h4>
							<hr>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="emp_no">Employee ID <span class="required-field">*</span></label>
								<input type="text" class="form-control" id="emp_no" name="emp_no" maxlength="25" value="<?php echo $emp_detail->emp_no; ?>" required readonly />
								<small class="hint res-msg"></small>
							</div>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="first_name">First Name <span class="required-field">*</span></label>
								<input type="text" class="form-control" onKeyPress="return Alpha(event);" id="first_name" name="first_name" maxlength="150" value="<?php echo $emp_detail->first_name; ?>" required />
							</div>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="second_name">Second Name</label>
								<input type="text" class="form-control" onKeyPress="return Alpha(event);" id="second_name" name="second_name" maxlength="150" value="<?php echo $emp_detail->second_name; ?>" />
							</div>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="third_name">Third Name</label>
								<input type="text" class="form-control" onKeyPress="return Alpha(event);" id="third_name" name="third_name" maxlength="150" value="<?php echo $emp_detail->third_name; ?>" />
							</div>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="last_name">Last Name</label>
								<input type="text" class="form-control" onKeyPress="return Alpha(event);" id="last_name" name="last_name" maxlength="150" value="<?php echo $emp_detail->last_name; ?>" />
							</div>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="full_name">Full Name (EN)<span class="required-field">*</span></label>
								<input type="text" class="form-control" onKeyPress="return Alpha(event);" id="full_name" name="full_name" maxlength="150" value="<?php echo $emp_detail->full_name; ?>" required />
							</div>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="employee_arabic_name">Full Name (AR)<span class="required-field">*</span></label>
								<input type="text" class="form-control rtl-input" id="employee_arabic_name" name="employee_arabic_name" value="<?php echo $emp_detail->employee_arabic_name; ?>" maxlength="150" required />
							</div>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="dob">Date of Birth <span class="required-field">*</span></label>
								<input type="date" class="form-control" id="dob" name="dob" max="<?php echo date("Y-m-d"); ?>" value="<?php echo $emp_detail->dob; ?>" required />
							</div>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="gender">Gender <span class="required-field">*</span></label>
								<select name="gender" id="gender" class="form-select" required>
									<option value="">Select Gender</option>
									<option value="male" <?php echo ($emp_detail->gender == 'male') ? ' selected ' : '' ?>>Male</option>
									<option value="female" <?php echo ($emp_detail->gender == 'female') ? ' selected ' : '' ?>>Female</option>
									<option value="other" <?php echo ($emp_detail->gender == 'other') ? ' selected ' : '' ?>>Other</option>
								</select>
							</div>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="marital_status">Marital Status <span class="required-field">*</span></label>
								<select name="marital_status" id="marital_status" class="form-select" required>
									<option value="">Select Marital Status</option>
									<option value="Single" <?php echo ($emp_detail->marital_status == 'Single') ? ' selected ' : '' ?>>Single</option>
									<option value="Married" <?php echo ($emp_detail->marital_status == 'Married') ? ' selected ' : '' ?>>Married</option>
									<option value="Divorced" <?php echo ($emp_detail->marital_status == 'Divorced') ? ' selected ' : '' ?>>Divorced</option>
									<option value="Widow" <?php echo ($emp_detail->marital_status == 'Widow') ? ' selected ' : '' ?>>Widow</option>
								</select>
							</div>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="religion">Religion <span class="required-field">*</span></label>
								<select name="religion" id="religion" class="form-select" required>
									<option value="">Select Religion</option>
									<option value="Muslim" <?php echo ($emp_detail->religion == 'Muslim') ? ' selected ' : '' ?>>Muslim</option>
									<option value="Non Muslim" <?php echo ($emp_detail->religion == 'Non Muslim') ? ' selected ' : '' ?>>Non Muslim</option>
								</select>
							</div>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="mobile">Mobile No.</label>
								<input type="text" class="form-control" id="mobile" name="mobile" value="<?php echo $alloted_mobile_no; ?>"  readonly />
							</div>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="personal_email">Personal Email ID</label>
								<input type="email" class="form-control" id="personal_email" name="personal_email" value="<?php echo $emp_detail->personal_email; ?>" />
							</div>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="email">Email ID <span class="required-field">*</span></label>
								<input type="email" class="form-control" id="email" name="email" onBlur="checkDuplicateEmail()" value="<?php echo $emp_detail->email; ?>" required />
								<small class="hint res-email"></small>
							</div>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="absher_mobile">Absher Mobile No. <span class="required-field">*</span></label>
								<input type="text" onKeyPress="return numerics(event);" class="form-control" id="absher_mobile" name="absher_mobile" minlength="<?= MOB_LENGTH ;?>" maxlength="<?= MOB_LENGTH ;?>" value="<?php echo $emp_detail->absher_mobile; ?>" required />
							</div>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="sponsor_id">
									Select Employer <span class="required-field">*</span>
								</label>
								<select class="form-control" name="sponsor_id" id="sponsor_id" required readonly style="pointer-events: none;">
									<option value="">Select Employer</option>
									<?php 
										if(count(sponsorsHelper()) > 0){
										foreach(sponsorsHelper() as $sponsor) { 
									?>
									<option value="<?php echo $sponsor['id']; ?>" data-id="<?php echo $sponsor['id']; ?>" <?php echo ($sponsor['id'] == $emp_detail->sponsor_id) ? ' selected ' : '' ?>><?php echo $sponsor['employer_cr_no'] .' - '. $sponsor['employer_name']; ?> <?php echo (isset($sponsor['employer_arabic_name'])) ? '/ '.$sponsor['employer_arabic_name'] : ''; ?></option>
									<?php }}else{ ?>
									<option value="" disabled>No Employer Found</option>
									<?php } ?>
								</select>
							</div>
						</div>

						<!---- Iqama Detail ----->
						<div class="row size-inner-section px-2 py-4 mx-2">
							<h4 class="header-title">ID/Iqama Details</h4>
							<hr>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="iqama_no">ID/Iqama Number</label>
								<input type="text" class="form-control" id="iqama_no" name="iqama_no" minlength="<?= ICAMA_LENGTH; ?>" maxlength="<?= ICAMA_LENGTH; ?>" value="<?php echo $emp_detail->iqama_no; ?>" />
							</div>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="iqama_name_en">Name as per Iqama (EN)</label>
								<input type="text" class="form-control" onKeyPress="return Alpha(event);" id="iqama_name_en" name="iqama_name_en" maxlength="150" value="<?php echo $emp_detail->iqama_name_en; ?>" />
							</div>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="iqama_name_ar">Name as per Iqama (AR)</label>
								<input type="text" class="form-control rtl-input" onKeyPress="return Alpha(event);" id="iqama_name_ar" name="iqama_name_ar" maxlength="150" value="<?php echo $emp_detail->iqama_name_ar; ?>" />
							</div>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="iqama_profession">Profession in Iqama</label>
								<select class="form-select select2" name="iqama_profession" id="iqama_profession">
									<option value="">Select Profession</option>
									<?php foreach (professionList() as $profession) { ?>
										<option value="<?php echo $profession->id; ?>" data-id="<?php echo $profession->id; ?>" <?php echo ($profession->id == $emp_detail->iqama_profession) ? ' selected ' : '' ?>><?php echo $profession->profession_name; ?> <?php echo (isset($profession->arabic_name)) ? '/ ' . $profession->arabic_name : ''; ?></option>
									<?php } ?>
								</select>
							</div>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="iqama_issue_city">ID/Iqama Issue City</label>
								<select class="form-select select2" name="iqama_issue_city" id="iqama_issue_city">
									<option value="">Select City</option>
									<?php foreach (selectedCitiesHelp(6) as $cities) { ?>
										<option value="<?php echo $cities->id; ?>" data-id="<?php echo $cities->id; ?>" <?php echo ($cities->id == $emp_detail->iqama_issue_city) ? ' selected ' : '' ?>><?php echo $cities->city_name; ?></option>
									<?php } ?>
								</select>
							</div>

							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="iqama_issue_date_hijri">ID/Iqama Issue Date (Hijri)</label>
								<input id="iqama_issue_date_hijri" type="text" class="form-control hijri-picker" name="iqama_issue_date_hijri" onkeydown="return false;" value="<?php echo (isset($emp_detail->iqama_issue_date_hijri) && ($emp_detail->iqama_issue_date_hijri !== '0000-00-00')) ? $emp_detail->iqama_issue_date_hijri : ''; ?>" />
							</div>

							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="iqama_issue_date">ID/Iqama Issue Date (Gregorian)</label>
								<input type="date" class="form-control" id="iqama_issue_date" name="iqama_issue_date" value="<?php echo $emp_detail->iqama_issue_date; ?>" />
							</div>

							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="iqama_expiry_date">ID/Iqama Expiry Date (Gregorian)</label>
								<input type="date" class="form-control" id="iqama_expiry_date" name="iqama_expiry_date" value="<?php echo $emp_detail->iqama_expiry_date; ?>" />
							</div>

							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="iqama_expiry_date_hijri">ID/ Iqama Expiry Date (Hijri)</label>
								<input type="text" id="iqama_expiry_date_hijri" name="iqama_expiry_date_hijri" class="form-control hijri-picker" onkeydown="return false;" value="<?php echo (isset($emp_detail->iqama_expiry_date_hijri) && ($emp_detail->iqama_expiry_date_hijri !== '0000-00-00')) ? $emp_detail->iqama_expiry_date_hijri : ''; ?>" />
							</div>
							<?php
								// Assuming you have fetched the iqama expiry date from the database
								$iqama_expiry_date = $emp_detail->iqama_expiry_date;

								// Convert the expiry date to a DateTime object
								$expiry_date = new DateTime($iqama_expiry_date);
								$current_date = new DateTime();

								$status_message = '';
								$status_class = '';

								if ($expiry_date < $current_date) {
									$status_message = 'Expired.';
									$status_class = 'alert-danger';
								} elseif ($expiry_date == $current_date) {
									$status_message = 'Expires Today.';
									$status_class = 'alert-warning';
								} else {
									$status_message = 'Active';
									$status_class = 'alert-success';
								}
								?>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="iqama_status">ID/ Iqama Status</label>
								<div id="iqama_status" class="py-2 alert <?php echo $status_class; ?>" style="display: block;">
									<?php echo $status_message; ?>
								</div>
							</div>
							
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="emp_status">Status</label>
								<div id="emp_status" class="py-2 alert <?php echo ($emp_detail->status === 'Active') ? ' alert-success ' : ' alert-danger '; ?>" style="display: block;">
									<?php echo $emp_detail->status; ?>
								</div>
							</div>
							<?php if ($emp_detail->status === 'Terminated') { ?>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="terminate_reason">Reason</label>
									<div id="terminate_reason" class="py-2 alert alert-secondary" style="display: block;">
										<?php echo $emp_detail->terminate_reason; ?>
									</div>
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="last_working_date">Last Working Date</label>
									<div id="last_working_date" class="py-2 alert alert-secondary" style="display: block;">
										<?php echo ($emp_detail->last_working_date !== NULL || $emp_detail->last_working_date !== '0000-00-00') ? date('d F Y', strtotime($emp_detail->last_working_date)) : ''; ?>
									</div>
								</div>
							<?php } ?>
							
						</div>

						<!---- Passport Detail ----->
						<div class="row size-inner-section px-2 py-4 mx-2">
							<h4 class="header-title">Passport Details</h4>
							<hr>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="nationality">Nationality <span class="required-field">*</span></label>
								<select class="form-select select2" data-parsley-allselected="true" name="nationality" id="nationality" required>
									<option value="">Select Nationality</option>
									<?php foreach (nationalityList() as $nation) { ?>
										<option value="<?php echo $nation->id; ?>" data-id="<?php echo $nation->id; ?>" <?php echo ($nation->id == $emp_detail->nationality) ? ' selected ' : '' ?>><?php echo $nation->name; ?></option>
									<?php } ?>
								</select>
							</div>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="passport_no">Passport Number <span class="required-field passport-label">*</span></label>
								<input type="text" class="form-control" id="passport_no" name="passport_no" onBlur="checkDuplicatePassport()" minlength="8" maxlength="<?= PASSPORT_LENGTH; ?>" value="<?php echo $emp_detail->passport_no; ?>" required />
								<small class="hint passport-info"></small>
							</div>

							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="passport_issue_date">Passport Issue Date (Gregorian) </label>
								<input type="date" class="form-control" id="passport_issue_date" name="passport_issue_date" value="<?php echo $emp_detail->passport_issue_date; ?>" />
							</div>

							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="passport_expiry_date">Passport Expiry Date (Gregorian) <span class="required-field passport-label">*</span></label>
								<input type="date" class="form-control" id="passport_expiry_date" name="passport_expiry_date" value="<?php echo $emp_detail->passport_expiry_date; ?>" required />
							</div>

							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="passport_issue_country">Passport Issue Country <span class="required-field passport-label">*</span></label>
								<select name="passport_issue_country" id="passport_issue_country" class="form-select select2" required>
									<option value="">Select Country</option>
									<?php foreach (masterCountries() as $country_list) { ?>
										<option value="<?php echo $country_list->id; ?>" data-id="<?php echo $country_list->id; ?>" <?php echo ($country_list->id == $emp_detail->passport_issue_country) ? ' selected ' : '' ?>><?php echo $country_list->name; ?></option>
									<?php } ?>
								</select>
							</div>

							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="passport_issue_city">Passport Issuing City <span class="required-field passport-label">*</span></label>
								<select name="passport_issue_city" id="passport_issue_city" class="form-select select2" required>
									<option value="">Select City</option>
									<?php foreach (selectedCitiesHelp($emp_detail->passport_issue_country) as $city_list) { ?>
										<option value="<?php echo $city_list->id; ?>" data-id="<?php echo $city_list->id; ?>" <?php echo ($city_list->id == $emp_detail->passport_issue_city) ? ' selected ' : '' ?>><?php echo $city_list->city_name; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>

						<div class="twitter-bs-wizard">
							<ul class="pager wizard twitter-bs-wizard-pager-link">
								<!-- <li class="previous"><a href="#"><i class="mdi mdi-arrow-left me-1"></i> Seller Details</a></li> -->
								<li class="next"><button type="save" class="btn btn-custom-success">Save and Continue <i class="mdi mdi-arrow-right ms-1"></i></button></li>
							</ul>
						</div>
						<?php echo form_close(); ?>

					</div>
				</div>
			</div> <!-- end col -->
		</div> <!-- end row -->
	</div>
</div>
<!-- container-fluid -->

<?php $this->load->view('admin/home/footer'); ?>

<div class="modal fade fixed-left changePasswordModal" id="changePasswordModal" aria-labelledby="#changePasswordModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-aside">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="changePasswordModalLabel">Change Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
				<form id="password_form" action="<?php echo base_url('admin/hr/employees/update-password'); ?>" method="POST" data-parsley-validate="">
					<input type="hidden" name="emp_id" value="<?php echo $emp_detail->id;?>" required>
					<div class="row">
						<div class="form-group col-lg-12 col-md-12 col-12 mb-3">
							<label for="password">New Password <span class="text-danger">*</span></label>
							<input type="password" class="form-control" id="password" name="password" minlength="6" maxlength="50" suggestion="on" autocomplete="on" required />
						</div>
						<div class="form-group col-lg-12 col-md-12 col-12 mb-3">
							<label for="confirm_password">Confirm New Password <span class="text-danger">*</span></label>
							<input type="password" class="form-control" id="confirm_password" name="confirm_password" minlength="6" maxlength="50" autocomplete="on" suggestion="on" required />
						</div>
						<div class="form-group col-lg-12 col-md-12 col-12 mb-1">
							<input class="checkbox" type="checkbox" id="send_credential" name="send_credential" style="vertical-align: sub;margin-right: 10px;">
							<label class="form-check-label" for="send_credential">
							Send credentials to user on email
							</label>
						</div>
						<p class="hint"> (Check if you want to send credential to Employee.)</p>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				<button type="submit" form="password_form" class="btn btn-custom-success">Change Password</button>
			</div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<script type="text/javascript">
	$('.dropify').dropify();

	function submitButton() {
		window.onbeforeunload = null;
	}

	$(document).ready(function() {
		$('#employee_form').data('initial-state', $('#employee_form').serialize()); // On load save form current state

		// Prevent user from leaving page with inputs with new values
		window.onbeforeunload = function() {
			if ($('#employee_form').serialize() != $('#employee_form').data('initial-state')) {
				return 'You have unsaved changes! If you leave this page, your changes will be lost.';
			}
		};
	});

	Parsley.addValidator('allselected',
		function(value) {
			return true == (value != '-1')
		});

	$("#full_name").keyup(function() {
		var emp_input_name = $("#full_name").val();
		if (emp_input_name !== '') {
			$("#employeeName").html(emp_input_name);
		} else {
			$("#employeeName").html('Employee Name');
		}
	});
	
	$(document).ready(function() {
		$('#iqama_expiry_date').on('change', function() {
			var selectedDate = new Date($(this).val());
			var currentDate = new Date();
			
			var statusElement = $('#iqama_status');
			statusElement.removeClass('alert-success alert-warning alert-danger');
			
			if (selectedDate < currentDate) {
				statusElement.addClass('alert-danger');
				statusElement.text('Expired.');
			} else if (selectedDate.getTime() === currentDate.getTime()) {
				statusElement.addClass('alert-warning');
				statusElement.text('Expires Today.');
			} else {
				statusElement.addClass('alert-success');
				statusElement.text('Active');
			}
			statusElement.show();
		});
	});

	function checkDuplicateEmpID() {
		var emp_id = $("#emp_no").val();
		if (emp_id !== "") {
			$.ajax({
				url: "<?php echo base_url('admin/hr/employees/check-empid'); ?>",
				type: "GET",
				data: "emp_no=" + $("#emp_no").val(),
				dataType: "json",
				success: function(data) {
					if (data.status == 'success') {
						$(".res-msg").html(data.msg);
					} else {
						$("#emp_no").val('');
						$(".res-msg").html(data.msg);
						return false;
					}
				},
				error: function(response) {
					$("#emp_no").val('');
					return false;
				},
			});
		} else {
			checkField("emp_no");
		}
	}

	function checkDuplicateEmail() {
		var email_id = $("#email").val();
		var id = $("#id").val();
		if (email_id !== "") {
			$.ajax({
				url: "<?php echo base_url('admin/hr/employees/check-email'); ?>",
				type: "GET",
				data: {
					email: email_id,
					id: id,
				},
				dataType: "json",
				success: function(data) {
					if (data.status == 'success') {
						$(".res-email").html(data.msg);
						$("#email").removeClass('parsley-error');
					} else {
						$("#email").val('');
						$("#email").addClass('parsley-error');
						$(".res-email").html(data.msg);
						return false;
					}
				},
				error: function() {
					$("#email").val('');
					$("#email").addClass('parsley-error');
					return false;
				},
			});
		} else {
			$("#email").addClass('parsley-error');
		}
	}

	function checkDuplicatePassport() {
		var passport_no = $("#passport_no").val();
		var id = $("#id").val();
		if (passport_no !== "") {
			$.ajax({
				url: "<?php echo base_url('admin/hr/employees/check-passport'); ?>",
				type: "POST",
				data: {
					passport_no: passport_no,
					id: id,
				},
				dataType: "json",
				success: function(data) {
					console.log(data);
					if (data.status == 'success') {
						$(".passport-info").html(data.msg);
						$("#passport_no").removeClass('parsley-error');
					} else {
						$("#passport_no").val('');
						$("#passport_no").addClass('parsley-error');
						$(".passport-info").html(data.msg);
						return false;
					}
				},
				error: function(response) {
					console.log(response);
					$("#passport_no").val('');
					$("#passport_no").addClass('parsley-error');
					return false;
				},
			});
		} else {
			$("#passport_no").addClass('parsley-error');
		}
	}

	function checkField(u) {
		var id = $("#" + u).val();
		if (id == "") {
			$("#" + u).addClass("alert_text");
		} else {
			$("#" + u).removeClass("alert_text");
		}
	}

	$('#passport_issue_country').change(function() {
		var country_id = $(this).find('option:selected').val();
		$.ajax({
			url: "<?php echo base_url(); ?>admin/hr-module/employees/Employee/getCities",
			data: {
				country_id: country_id
			},
			dataType: "json",
			type: "POST",
			success: function(data) {
				//console.log(data);
				var html = '<option value="">Select City</option>';
				if (Object.keys(data).length > 0) {
					$.each(data, function(index, item) {
						html += '<option value="' + item.id + '" data-id="' + item.id + '">' + item.city_name + '</option>';
					});
				} else {
					var html = '<option value="">No city found</option>';
				}
				$('#passport_issue_city').html(html);
			}
		});
	});

	function Alpha(evt) {
		var keyCode = (evt.which) ? evt.which : evt.keyCode
		if ((keyCode < 65 || keyCode > 90) && (keyCode < 97 || keyCode > 123) && keyCode != 32)

			return false;
		return true;
	}

	function numerics(key) {
		//getting key code of pressed key
		// alert($(this).val());
		var keycode = (key.which) ? key.which : key.keyCode;
		//comparing pressed keycodes

		if (keycode > 31 && (keycode < 48 || keycode > 57)) {
			alert("You can enter only characters 0 to 9 ");
			return false;
		} else return true;
	}

	$(document).ready(function() {
		var selectedNationality = $('#nationality').find("option:selected").val();
		passportReqFields(selectedNationality);
        $('#nationality').change(function() {
            var selectedNationality = $(this).find("option:selected").val();
            passportReqFields(selectedNationality);
        });
    });

	function passportReqFields(nationality_id) {
		if (nationality_id === "6") {
			$('#passport_no').removeAttr('required').val('');
			$('#passport_expiry_date').removeAttr('required').val('');
			$('#passport_issue_date').val('');
			$('#passport_issue_country').removeAttr('required').val('').trigger('change');
			$('#passport_issue_city').removeAttr('required').val('').trigger('change');

			$('.passport-label').hide();
		} else {
			$('#passport_no').attr('required', 'required');
			$('#passport_expiry_date').attr('required', 'required');
			$('#passport_issue_country').attr('required', 'required');
			$('#passport_issue_city').attr('required', 'required');

			$('.passport-label').show();
		}
	}

</script>
<script>
$(document).ready(function() {
	// Hijri to Gregorian: Issue Date
	$('#iqama_issue_date_hijri').on('dp.change', function (e) {
		let hijriDate = $(this).val(); // e.g. 17-09-1444
		if (hijriDate) {
			$.ajax({
				url: '<?= base_url("admin/hr-module/employees/Employee/getGregorianDateFormat") ?>',
				type: 'POST',
				data: { hijri_date: hijriDate },
				success: function (response) {
					$('#iqama_issue_date').val(response);
				}
			});
		}
	});

	// Gregorian to Hijri: Issue Date
	$('#iqama_issue_date').on('change', function () {
		let gregDate = $(this).val(); // yyyy-mm-dd
		if (gregDate) {
			$.ajax({
				url: '<?= base_url("admin/hr-module/employees/Employee/getHijriDateFormat") ?>',
				type: 'POST',
				data: { gregorian_date: gregDate },
				success: function (response) {
					console.log(response);
					$('#iqama_issue_date_hijri').val(response);
				}
			});
		}
	});

	// Hijri to Gregorian: Expiry Date
	$('#iqama_expiry_date_hijri').on('dp.change', function (e) {
		let hijriDate = $(this).val();
		if (hijriDate) {
			$.ajax({
				url: '<?= base_url("admin/hr-module/employees/Employee/getGregorianDateFormat") ?>',
				type: 'POST',
				data: { hijri_date: hijriDate },
				success: function (response) {
					console.log(response);
					$('#iqama_expiry_date').val(response);
				}
			});
		}
	});

	// Gregorian to Hijri: Expiry Date
	$('#iqama_expiry_date').on('change', function () {
		let gregDate = $(this).val();
		if (gregDate) {
			$.ajax({
				url: '<?= base_url("admin/hr-module/employees/Employee/getHijriDateFormat") ?>',
				type: 'POST',
				data: { gregorian_date: gregDate },
				success: function (response) {
					$('#iqama_expiry_date_hijri').val(response);
				}
			});
		}
	});
});
</script>
