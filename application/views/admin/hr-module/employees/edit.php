
<?php $this->load->view('admin/home/header');?>

<style>
	.required-field{
		color:#f00;
	}
	.size-inner-section {
		box-shadow: 0px 1px 4px #c5c5c5;
		border-radius: 5px;
		margin-bottom: 10px;
	}
	.nav-pills .nav-link.active, .nav-pills .show>.nav-link {
		color: #fff !important;
		background-color: #005500!important;
	}
	.nav-tabs-custom .nav-item .nav-link::after {
		content: "";
		background: #005500;
	}
	.nav-tabs-custom .nav-item .nav-link {
		background: #eee;
	}
	.cv-documents{
		border: 1px dashed #a9a9a9;
		padding: 6px;
		width: 140px;
		height: 150px;
	}
	.cv-documents p{
		margin-top: 3%;
	}
	.image-container {
		position: relative;
		display: inline-block;
	}
	.image-container .overlay{
		opacity: 0;
	}
	.image-container:hover .overlay{
		background: #0006;
		opacity: .9;
		position: absolute;
		bottom: 0;
		width: 140px;
    	height: 150px;
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
		top: 30%;
		display: none;
	}
	a.document:hover {
		color: darkgreen;
	}
</style>
<div id="wait"><i class="fa fa-spinner fa-spin"></i><br>Updating..</div>
<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Employee Master</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/hr/master/employee'); ?>">Employee List</a></li>
						<li class="breadcrumb-item active">Edit</li>
					</ol>
				</div>
			</div>
			<?php $admin_id = $this->session->userdata('admin_id');?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<?php if ($this->customer->userd($admin_id)->role == "Admin") {?>
					<a class="btn btn-sm btn-custom-white pull-right" title="Back" href="<?php echo base_url(); ?>admin/hr/master/employee"><i class="fa fa-reply"></i> Back</a>
					<?php }?>
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
				<?php } else {?>
				<div class="alert alert-info alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;top:90px;width:50%;" role="alert">
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
						<strong><?php echo $msg_data; ?></strong>
				</div>
				<?php }}
				$this->admin->removeInfo();?>
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
						<?php echo form_open("admin/hr/master/employee/submit", array("id" => "demo-form2", "enctype" => "multipart/form-data", "class" => "form-label-left", "data-parsley-validate" => "")); ?>
							<input type="hidden" id="id" name="id" value="<?php echo $emp_detail->id; ?>" />
							<div id="addproduct-nav-pills-wizard" class="twitter-bs-wizard">
								<ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
									<li class="nav-item">
										<a class="nav-link active" data-bs-toggle="tab" href="#profileTab" role="tab">
											<span class="d-block d-sm-none"><i class="fas fa-user"></i></span>
											<span class="d-none d-sm-block">Profile</span>
										</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" data-bs-toggle="tab" href="#documentsTab" role="tab">
											<span class="d-block d-sm-none"><i class="dripicons-document"></i></span>
											<span class="d-none d-sm-block">Documents</span>
										</a>
									</li>
								</ul>
								<!-- Tab panes -->
								<div class="tab-content p-3 text-muted">
									<div class="tab-pane active" id="profileTab" role="tabpanel">
										<div class="row size-inner-section px-2 py-4">
											<h4 class="header-title">Fill Information</h4><hr>
											<div class="col-md-4 col-sm-12 mb-2 form-group">
												<label for="emp_no">Employee Number</label>
												<input type="text" class="form-control" id="emp_no" name="emp_no" maxlength="25" value="<?php echo $emp_detail->emp_no; ?>" readonly />
											</div>
											<div class="col-md-4 col-sm-12 mb-2 form-group">
												<label for="cv_no">CV No <span class="required-field">*</span></label>
												<input type="text" class="form-control" id="cv_no" name="cv_no" maxlength="25" value="<?php echo $emp_detail->cv_num; ?>" readonly />
											</div>
										</div>
										<div class="row size-inner-section px-2 py-4">
											<h4 class="header-title">General Information</h4>
											<hr>
											<div class="col-md-4 col-sm-12 mb-2 form-group">
												<label for="hiring_type">Hiring Type <span class="required-field">*</span></label>
												<select name="hiring_type" id="hiring_type" class="form-select select2" required data-placeholder="Choose Hiring Type...">
													<option value="Local - Saudi" <?php echo ($emp_detail->hiring_type == 'Local - Saudi') ? 'selected' : '' ?>>Local - Saudi</option>
													<option value="Local - Non-Saudi" <?php echo ($emp_detail->hiring_type == 'Local - Non-Saudi') ? 'selected' : '' ?>>Local - Non-Saudi</option>
													<option value="Foreign" <?php echo ($emp_detail->hiring_type == 'Foreign') ? 'selected' : '' ?>>Foreign</option>
												</select>
												<small class="hint">Select hiring type</small>
											</div>
											<div class="col-md-4 col-sm-12 mb-2 form-group">
												<label for="applicant_country">Country <span class="required-field">*</span></label>
												<select class="form-select" name="applicant_country" id="applicant_country" required>
													<option value="">Select Country</option>
													<?php foreach($nationalities as $nation) { ?>
													<option value="<?php echo $nation->name; ?>" data-id="<?php echo $nation->id; ?>" <?php echo ($nation->name == $emp_detail->applicant_country) ? 'selected' : '' ?>><?php echo $nation->name; ?></option>
													<?php } ?>
												</select>
												<small class="hint">Select Country</small>
											</div>
											<div class="col-md-4 col-sm-12 mb-2 form-group <?php echo ($emp_detail->hiring_type == 'local') ? 'd-none' : '';?>" id="agency-container">
												<label for="agency_name">Agency Name</label>
												<select name="agency_name" id="agency_name" class="form-control select2" data-placeholder="Choose Agency...">
													<option value="">Select Agency</option>
													<?php foreach (agencyCountrywiseHelper($emp_detail->applicant_country) as $key => $value) { ?>
														<option value="<?php echo $value->id;?>" <?php echo ($emp_detail->agency_name == $value->id) ? 'selected' : '' ?>><?php echo $value->agency_name;?></option>
													<?php } ?>
												</select>
												<p class="hint">Choose Agency Name</p>
											</div>
											<div class="col-md-4 col-sm-12 mb-2 form-group">
												<label for="applicant_type">Applicant Type <span class="required-field">*</span></label>
												<select class="form-select" name="applicant_type" id="applicant_type" required>
													<option value="">Select Type</option>
													<option value="Fresher" <?php echo ($emp_detail->applicant_type == 'Fresher') ? 'selected' : '' ?>>Fresher</option>
													<option value="Saudi Return" <?php echo ($emp_detail->applicant_type == 'Saudi Return') ? 'selected' : '' ?>>Saudi Return</option>
													<option value="GCC Return" <?php echo ($emp_detail->applicant_type == 'GCC Return') ? 'selected' : '' ?>>GCC Return</option>
												</select>
												<small class="hint">Select Applicant Type</small>
											</div>
											<div class="col-md-4 col-sm-12 mb-2 form-group">
												<label for="line_manager">Line Manager</label>
												<select name="line_manager" id="line_manager" class="form-control select2">
													<option value="">Select Line Manager</option>
													<?php foreach(employeeListHelper() as $emp_list) { ?>
														<option value="<?php echo $emp_list->id; ?>" <?php echo ($emp_list->id == $emp_detail->line_manager) ? ' selected' : '' ?>><?php echo $emp_list->full_name; ?> (<?php echo $emp_list->designation_name; ?>) - <?php echo $emp_list->emp_no; ?></option>
													<?php } ?>
												</select>
												<small class="hint">Select Line Manager</small>
											</div>
										</div>
										<div class="row size-inner-section px-2 py-4">
											<h4 class="header-title">Personal Information</h4>
											<hr>
											<div class="col-md-4 col-sm-12 mb-2 form-group">
												<label for="first_name">First Name <span class="required-field">*</span></label>
												<input type="text" class="form-control" onKeyPress="return Alpha(event);" id="first_name" name="first_name" maxlength="150" value="<?php echo $emp_detail->first_name; ?>" required />
												<small class="hint">Enter Person First Name</small>
											</div>
											<div class="col-md-4 col-sm-12 mb-2 form-group">
												<label for="middle_name">Middle Name</label>
												<input type="text" class="form-control" onKeyPress="return Alpha(event);" id="middle_name" name="middle_name" maxlength="150" value="<?php echo $emp_detail->middle_name; ?>" />
												<small class="hint">Enter Person Middle Name</small>
											</div>
											<div class="col-md-4 col-sm-12 mb-2 form-group">
												<label for="third_name">Third Name</label>
												<input type="text" class="form-control" onKeyPress="return Alpha(event);" id="third_name" name="third_name" maxlength="150" value="<?php echo $emp_detail->third_name; ?>" />
												<small class="hint">Enter Person Third Name</small>
											</div>
											<div class="col-md-4 col-sm-12 mb-2 form-group">
												<label for="surname">Surname</label>
												<input type="text" class="form-control" onKeyPress="return Alpha(event);" id="surname" name="surname" maxlength="150" value="<?php echo $emp_detail->surname; ?>" />
												<small class="hint">Enter Person Surname</small>
											</div>
											<div class="col-md-4 col-sm-12 mb-2 form-group">
    											<label for="employee_arabic_name">Employee Arabic Name <span class="required-field">*</span></label>
    											<input type="text" class="form-control rtl-input" id="employee_arabic_name" name="employee_arabic_name" maxlength="150" value="<?php echo $emp_detail->employee_arabic_name; ?>" required />
    											<small class="hint">Enter Employee Arabic Name</small>
    										</div>
											<div class="col-md-4 col-sm-12 mb-2 form-group">
												<label for="dob">Date of Birth <span class="required-field">*</span></label>
												<input type="date" class="form-control" id="dob" name="dob" value="<?php echo $emp_detail->dob; ?>" max="<?php echo date("Y-m-d"); ?>" required />
												<small class="hint">Enter Date Of Birth</small>
											</div>
											<div class="col-md-4 col-sm-12 mb-2 form-group">
												<label for="age">Age <small class="required-field">(above 35 not accepted) *</small></label>
												<input type="number" class="form-control" id="age" name="age" value="<?php echo $emp_detail->age; ?>" required />
												<small class="hint">Write remarks if age is above 35.</small>
											</div>
											<div class="col-md-4 col-sm-12 mb-2 form-group">
												<label for="gender">Gender <span class="required-field">*</span></label>
												<select name="gender" id="gender" class="form-select select2" required data-placeholder="Choose Gender...">
													<option value="">Select</option>
													<option value="male" <?php echo ($emp_detail->gender == 'male') ? 'selected' : '' ?>>Male</option>
													<option value="female" <?php echo ($emp_detail->gender == 'female') ? 'selected' : '' ?>>Female</option>
													<option value="other" <?php echo ($emp_detail->gender == 'other') ? 'selected' : '' ?>>Other</option>
												</select>
												<small class="hint">Select Gender</small>
											</div>
											<div class="col-md-4 col-sm-12 mb-2 form-group">
												<label for="marital_status">Marital Status <span class="required-field">*</span></label>
												<select name="marital_status" id="marital_status" class="form-select select2" required data-placeholder="Choose Marital Status...">
													<option value="">Select</option>
													<option value="Single" <?php echo ($emp_detail->marital_status == 'Single') ? 'selected' : '' ?>>Single</option>
													<option value="Married" <?php echo ($emp_detail->marital_status == 'Married') ? 'selected' : '' ?>>Married</option>
													<option value="Divorced" <?php echo ($emp_detail->marital_status == 'Divorced') ? 'selected' : '' ?>>Divorced</option>
												</select>
												<small class="hint">Select Marital Status</small>
											</div>
											<div class="col-md-4 col-sm-12 mb-2 form-group">
												<label for="age_remarks">Remarks</label>
												<input type="text" class="form-control" id="age_remarks" name="age_remarks" maxlength="250" value="<?php echo $emp_detail->age_remarks; ?>" />
												<small class="hint">Write remarks if age is above 35.</small>
											</div>
											<div class="col-md-4 col-sm-12 mb-2 form-group">
												<label for="nationality">Nationality <span class="required-field">*</span></label>
												<select class="form-select" name="nationality" id="nationality" required>
													<option value="">Select Nationality</option>
													<?php foreach($nationalities as $nation) { ?>
													<option value="<?php echo $nation->name; ?>" data-id="<?php echo $nation->id; ?>" <?php echo ($nation->name == $emp_detail->nationality) ? ' selected ' : '' ?>><?php echo $nation->name; ?></option>
													<?php } ?>
												</select>
												<small class="hint">Select Nationality</small>
											</div>
											<div class="col-md-4 col-sm-12 mb-2 form-group">
												<label for="mobile">Mobile No.</label>
												<input type="text" onKeyPress="return numerics(event);" class="form-control" id="mobile" name="mobile" value="<?php echo $emp_detail->mobile; ?>" minlength="<?= MOB_LENGTH ;?>" maxlength="<?= MOB_LENGTH ;?>" />
												<small class="hint">Enter Mobile Number</small>
											</div>
											<div class="col-md-4 col-sm-12 mb-2 form-group">
												<label for="email">Email ID <span class="required-field">*</span></label>
												<input type="email" class="form-control" id="email" name="email" value="<?php echo $emp_detail->email; ?>" onBlur="checkDuplicateEmail()" required />
												<small class="hint res-email">Enter Email</small>
											</div>
											<div class="col-md-4 col-sm-12 mb-2 form-group">
												<label for="status">Status <span class="required-field">*</span></label>
												<select name="status" id="emp_status" class="form-select" required>
													<option value="">Select</option>
													<option value="active" <?php echo ($emp_detail->status == 'active') ? 'selected' : '' ?>>Active</option>
													<option value="inactive" <?php echo ($emp_detail->status == 'inactive') ? 'selected' : '' ?>>Inactive</option>
												</select>
												<small class="hint">Select status for employee.</small>
											</div>
											<div class="col-md-4 col-sm-12 mb-2 form-group">
												<label for="employee_mode">Employee Mode</label>
												<select name="employee_mode" id="employee_mode" class="form-select" required data-placeholder="Employee Mode...">
													<option value="">Select Mode</option>
													<option value="employee" <?php echo ($emp_detail->employee_mode == 'employee') ? 'selected' : '' ?>>Employee</option>
													<option value="user" <?php echo ($emp_detail->employee_mode == 'user') ? 'selected' : '' ?>>User</option>
												</select>
												<small class="hint">Enter Employee Mode</small>
											</div>
											<div class="col-md-6 col-sm-12 mb-2 form-group">
												<input class="checkbox" type="checkbox" id="allow_access" name="allow_access" <?php echo ($emp_detail->allow_access == 'on') ? ' checked' : '' ?> <?php echo ($emp_detail->employee_mode == 'user') ? '' : ' disabled' ?> style="vertical-align: sub;margin-right: 10px;">
												<label class="form-check-label" for="allow_access">
												Allow access to the system
												</label>
												<small class="hint"> (Check if allow access to the system.)</small>
											</div>
											<div class="col-md-6 col-sm-12 access-checked <?php echo ($emp_detail->allow_access == 'on') ? '' : 'd-none';?>">
												<div class="form-group mb-2">
													<input class="checkbox" type="checkbox" id="send_credential" name="send_credential" <?php echo ($emp_detail->send_credential == 'on') ? 'checked' : '' ?> style="vertical-align: sub;margin-right: 10px;">
													<label class="form-check-label" for="send_credential">
													Send credentials to user on email
													</label>
												</div>
												<small class="hint"> (Check if you want to send credential.)</small>
											</div>
											<div class="row access-checked <?php echo ($emp_detail->allow_access == 'on') ? '' : 'd-none';?>">
												<div class="col-md-4 col-sm-12 mb-2 form-group">
													<label for="display_language">Display Language <span class="required-field">*</span></label>
													<select name="display_language" id="display_language" class="form-select">
														<option value="">Select Language</option>
														<option value="1" <?php echo ($emp_detail->display_language == '1') ? 'selected' : '' ?>>Arabic</option>
														<option value="2" <?php echo ($emp_detail->display_language == '2') ? 'selected' : '' ?>>English</option>
													</select>
													<small class="hint">Select Display Language</small>
												</div>
												<div class="col-md-4 col-sm-12 mb-2 form-group">
													<label for="employee_role">Role <span class="required-field">*</span></label>
													<select name="employee_role" id="employee_role" class="form-select select2" data-placeholder="Employee Role...">
														<option value="">Select Role</option>
														<?php foreach(rolesList() as $roles){ ?>
														<option value="<?php echo $roles->id; ?>" <?php echo ($roles->id == $emp_detail->employee_role) ? 'selected' : '' ?>><?php echo $roles->name; ?></option>
														<?php } ?>
													</select>
													<small class="hint">Select Employee Role</small>
												</div>
												<div class="col-md-4 col-sm-12 mb-2 form-group">
													<label for="branches">Accessible Branches <span class="required-field">*</span></label>
													<select name="branches" id="branches" class="form-select select2" data-placeholder="Employee Accessible Branches...">
														<option value="">Select Accessible Branches</option>
														<?php foreach(branchHelper() as $mbranch) { ?>
															<option value="<?php echo $mbranch->id; ?>" <?php echo ($mbranch->id == $emp_detail->branches) ? 'selected' : '' ?>><?php echo $mbranch->branch_name; ?></option>
														<?php } ?>
													</select>
													<small class="hint">Select Accessible Branches</small>
												</div>
											</div>
										</div>
										<div class="row size-inner-section px-2 py-4">
											<h4 class="header-title">Iqama & DL Details</h4>
											<hr>
											<div class="col-md-4 col-sm-12 mb-2 form-group">
												<label for="iqama_no">Iqama Number</label>
												<input type="text" class="form-control" id="iqama_no" name="iqama_no" minlength="<?= ICAMA_LENGTH ;?>" maxlength="<?= ICAMA_LENGTH ;?>" value="<?php echo $emp_detail->iqama_no; ?>" />
												<small class="hint">Enter Iqama Number</small>
											</div>
											<div class="col-md-4 col-sm-12 mb-2 form-group">
												<label for="iqama_exp">Iqama Expiry Date</label>
												<input type="date" class="form-control" id="iqama_exp" name="iqama_exp" min="<?php echo date("Y-m-d"); ?>" value="<?php echo $emp_detail->iqama_exp; ?>" />
												<small class="hint">Enter Iqama Expiry Date</small>
											</div>
											
											<div class="col-md-4 col-sm-12 mb-2 form-group">
												<label for="iqama_issue_city">City of Issue</label>
												<input type="text" class="form-control" id="iqama_issue_city" name="iqama_issue_city" maxlength="100" value="<?php echo $emp_detail->iqama_issue_city; ?>" />
												<small class="hint">Select City of Issue</small>
											</div>
											
											<div class="col-md-4 col-sm-12 mb-2 form-group">
												<label for="iqama_issue_country">Country</label>
												<select name="iqama_issue_country" id="iqama_issue_country" class="form-control select2" data-placeholder="Choose Country..." required>
													<option value="">Select</option>
													<?php foreach($nationalities as $nation) { ?>
														<option value="<?php echo $nation->name; ?>" <?php echo ($nation->name == 'Saudi Arabia') ? 'selected' : '' ?>><?php echo $nation->name; ?></option>
													<?php } ?>
												</select>
												<small class="hint">Select Country</small>
											</div>

											<div class="col-md-4 col-sm-12 mb-2 form-group">
												<label class="form-check-label mb-3 d-block" for="saudi_dl_available">Do you have Saudi/GCC Driving License</label>
												<input class="checkbox" type="checkbox" id="saudi_dl_available" name="saudi_dl_available" <?php echo ($emp_detail->saudi_dl_available == 'on') ? 'checked' : '' ?> style="vertical-align: sub;margin-right: 10px;">
												<small class="hint"> (Check if you have Saudi driving License.)</small>
											</div>

											
											<div id="saudi-dl-container" class="row">
												<div class="col-md-4 col-sm-12 mb-2 form-group">
													<label for="dl_issuing_authority">Driving License Issuing Authority</label>
													<select name="dl_issuing_authority" id="dl_issuing_authority" class="form-select select2">
														<option value="">Select Type</option>
														<option value="Saudi" <?php echo ($emp_detail->dl_issuing_authority == 'Saudi') ? 'selected' : '' ?>>Saudi</option>
														<option value="GCC" <?php echo ($emp_detail->dl_issuing_authority == 'GCC') ? 'selected' : '' ?>>GCC</option>
													</select>
												</div>
												<div class="col-md-4 col-sm-12 mb-2 form-group">
													<label for="dl_type">Driving License Type</label>
													<select name="dl_type" id="dl_type" class="form-select select2">
														<option value="">Select Type</option>
														<option value="Bike" <?php echo ($emp_detail->dl_type == 'Bike') ? 'selected' : '' ?>>Bike</option>
														<option value="Car" <?php echo ($emp_detail->dl_type == 'Car') ? 'selected' : '' ?>>Car</option>
														<option value="Truck" <?php echo ($emp_detail->dl_type == 'Truck') ? 'selected' : '' ?>>Truck</option>
													</select>
												</div>
												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="current_dl">Driving License No</label>
													<input type="text" class="form-control" id="current_dl" name="current_dl" minlength="<?= DL_LENGTH ;?>" maxlength="<?= DL_LENGTH ;?>" value="<?= $emp_detail->current_dl; ?>" />
													<small class="hint">Enter saudi driving license no</small>
													<span id="errmsgadhar" class="err-msg"></span>
												</div>
												
												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="current_dl_expiry">Driving License Expiry</label>
													<input type="date" class="form-control" id="current_dl_expiry" name="current_dl_expiry" min="<?php echo date("Y-m-d"); ?>" value="<?= $emp_detail->current_dl_expiry; ?>" />
													<small class="hint">Enter saudi driving license expiry date</small>
												</div>
												
											</div>
											
										</div>
										<div class="row size-inner-section px-2 py-4">
											<h4 class="header-title">Work Information</h4>
											<hr>
											<div class="col-md-4 col-sm-12 mb-2 form-group">
												<label for="designation">Designation <span class="required-field">*</span></label>
												<select name="designation" id="designation" class="form-select select2" required data-placeholder="Choose Designation...">
													<option value="">Select Designation</option>
													<?php foreach($positions as $pos) { ?>
														<option value="<?php echo $pos->id; ?>" <?php echo ($pos->id == $emp_detail->designation) ? 'selected' : '' ?>><?php echo $pos->name; ?></option>
													<?php } ?>
												</select>
												<small class="hint">Select employee designation</small>
											</div>
											<div class="col-md-4 col-sm-12 mb-2 form-group">
												<label for="department">Department <span class="required-field">*</span></label>
												<select name="department" id="department" class="form-select select2" required data-placeholder="Choose Department...">
													<option value="">Select Department</option>
													<?php foreach($departments as $department) { ?>
														<option value="<?php echo $department->id; ?>" <?php echo ($department->id == $emp_detail->department) ? 'selected' : '' ?>><?php echo $department->name; ?></option>
													<?php } ?>
												</select>
												<small class="hint">Select employee department</small>
											</div>
											
											<div class="col-md-4 col-sm-12 mb-2 form-group">
												<label for="joining_date">Joining Date <span class="required-field">*</span></label>
												<input type="date" class="form-control" id="joining_date" name="joining_date" max="<?php echo date("Y-m-d"); ?>" value="<?= $emp_detail->joining_date; ?>" required />
												<small class="hint">Enter Joinning Date</small>
											</div>
											<div class="col-md-4 col-sm-12 mb-2 form-group">
												<label for="branch">Branch <span class="required-field">*</span></label>
												<select name="branch" id="branch" class="form-select select2" required data-placeholder="Choose Branch...">
													<option value="">Select Branch</option>
													<?php foreach(branchHelper() as $mbranch) { ?>
														<option value="<?php echo $mbranch->id; ?>" <?php echo ($mbranch->id == $emp_detail->branch) ? 'selected' : '' ?>><?php echo $mbranch->branch_name; ?></option>
													<?php } ?>
												</select>
												<small class="hint">Select branch</small>
											</div>
											<div class="col-md-4 col-sm-12 mb-2 form-group">
												<label for="work_type">Work Type <span class="required-field">*</span></label>
												<select name="work_type" id="work_type" class="form-select select2" required data-placeholder="Choose Work Type...">
													<option value="">Select Work Type</option>
													<option value="Full Time" <?php echo ('Full Time' == $emp_detail->work_type) ? ' selected' : '' ?>>Full Time</option>
													<option value="Part Time" <?php echo ('Part Time' == $emp_detail->work_type) ? ' selected' : '' ?>>Part Time</option>
												</select>
												<small class="hint">Select Work Type</small>
											</div>
											<div class="col-md-4 col-sm-12 mb-2 form-group">
												<label for="insurance_number">Insurance Number</label>
												<input type="text" class="form-control" id="insurance_number" name="insurance_number" maxlength="50" value="<?= $emp_detail->insurance_number; ?>" />
												<small class="hint">Enter Insurance Number</small>
											</div>
											<div class="col-md-4 col-sm-12 mb-2 form-group">
												<label for="insurance_expiry">Insurance Expiry Date</label>
												<input type="date" class="form-control" id="insurance_expiry" name="insurance_expiry" min="<?php echo date("Y-m-d"); ?>" value="<?= $emp_detail->insurance_expiry; ?>" />
												<small class="hint">Enter Insurance Expiry Date</small>
											</div>
										</div>

										<div class="row size-inner-section px-2 py-4">
											<h4 class="header-title">Attendance Information</h4>
											<hr>
											<div class="col-md-4 col-sm-12 mb-2 form-group">
												<label for="attendance_shift">Attendance Shift</label>
												<select name="attendance_shift" id="attendance_shift" class="form-select select2" data-placeholder="Choose Attendance Shift...">
													<option value="">Select Attendance Shift</option>
													<?php foreach (getAddtendaceShift() as $key => $value) { ?>
														<option value="<?php echo $value['id']; ?>" <?php echo ($emp_detail->attendance_shift == $value['id']) ? ' selected' : ''; ?>><?php echo $value['name']; ?></option>';
													<?php } ?>
												</select>
												<small class="hint">Select employee attendance shift</small>
											</div>
											<div class="col-md-4 col-sm-12 mb-2 form-group">
												<label for="leave_policy">Leave Policy</label>
												<select name="leave_policy" id="leave_policy" class="form-select select2" data-placeholder="Choose Leave Policy...">
													<option value="">Select Leave Policy</option>
													<?php foreach (getLeavePolicy() as $key => $value) { ?>
														<option value="<?php echo $value['id']; ?>" <?php echo ($emp_detail->leave_policy == $value['id']) ? ' selected' : ''; ?>><?php echo $value['name']; ?></option>';
													<?php } ?>
												</select>
												<small class="hint">Select employee leave policy</small>
											</div>
											<div class="col-md-4 col-sm-12 mb-2 form-group">
												<label for="holiday_list">Holiday List</label>
												<select name="holiday_list" id="holiday_list" class="form-select select2" data-placeholder="Choose Holiday List...">
													<option value="">Select Holiday List</option>
													<?php foreach (getHolidayList() as $key => $value) { ?>
														<option value="<?php echo $value['id']; ?>" <?php echo ($emp_detail->holiday_list == $value['id']) ? ' selected' : ''; ?>><?php echo $value['group_title']; ?></option>';
													<?php } ?>
												</select>
												<small class="hint">Select employee holiday list</small>
											</div>
											<div class="col-md-4 col-sm-12 mb-2 form-group">
												<label for="attendance_restriction">Attendance Restriction</label>
												<select name="attendance_restriction" id="attendance_restriction" class="form-select select2" data-placeholder="Choose Attendance Restriction...">
													<option value="">Select Attendance Restriction</option>
													<?php foreach (getAttendanceRestriction() as $key => $value) { ?>
														<option value="<?php echo $value['id']; ?>" <?php echo ($emp_detail->attendance_restriction == $value['id']) ? ' selected' : ''; ?>><?php echo $value['name']; ?></option>';
													<?php } ?>
												</select>
												<small class="hint">Select attendance restriction</small>
											</div>
										</div>

										<div class="row size-inner-section p-2">
											<h4 class="header-title">Fill your required bank information</h4>

											<div class="col-md-4 col-sm-12 mb-3 form-group">
												<label for="bank_name">Bank Name</label>
												<select style="height:410px;" name="bank_name" id="bank_name" class="form-control select2">
													<option value="">Select Bank</option>
													<?php foreach(bankList() as $banks){?>
													<option value="<?php echo $banks->id;?>" <?php echo ($banks->id == $emp_detail->bank_name) ? 'selected' : '' ?>><?php echo $banks->bank_name;?></option>
													<?php } ?>
												</select>
												<small class="hint">Select bank name</small>
											</div>
											
											<div class="col-md-4 col-sm-12 mb-3 form-group" id="iban_cont">
												<label for="iban">IBAN No</label>
												<input type="text" class="form-control" id="iban" name="iban" minlength="<?= IBAN_LENGTH ;?>" maxlength="<?= IBAN_LENGTH ;?>" value="<?php echo $emp_detail->iban;?>" />
												<small class="hint">Enter IBAN No of Employee</small>
											</div>
											
                                        	<div class="col-md-4 col-sm-12 mb-3 form-group" id="iban_cont">
												<label for="stc_pay_no">STC Pay No</label>
												<input type="text" class="form-control" id="stc_pay_no" name="stc_pay_no" minlength="<?= STC_PAY_LENGTH ;?>" maxlength="<?= STC_PAY_LENGTH ;?>" value="<?php echo $emp_detail->stc_pay_no;?>" />
												<small class="hint">Enter STC No of Employee</small>
											</div>
										</div>
										<div class="row size-inner-section px-2 py-4">
											<h4 class="header-title">Family Information</h4><hr>
											<table id="family_sections" class="table table-striped table-bordered table-hover">
												<thead>
													<tr>
														<td class="text-left">Iqama/ID No <span class="required-field">*</span></td>
														<td class="text-left">Name <span class="required-field">*</span></td>
														<td class="text-left">Relationship <span class="required-field">*</span></td>
														<td class="text-left">Date of Birth <span class="required-field">*</span></td>
														<td class="text-left">Medical Insurance <span class="required-field">*</span></td>
														<td style="width: 5%;"></td>
													</tr>
												</thead>
												<tbody>
													<?php if(count($family_members) > 0){ ?>
													<?php foreach($family_members as $fmembers){ ?>
													<tr class="family-inner-section">
														<td class="text-left" style="width: 15%;">
															<input type="text" name="family_iqama[]" class="form-control" value="<?php echo $fmembers['family_iqama'];?>" minlength="<?= ICAMA_LENGTH ;?>" maxlength="<?= ICAMA_LENGTH ;?>">
														</td>
														<td class="text-left">
															<div class="input-group">
																<input type="text" name="family_name[]" class="form-control" value="<?php echo $fmembers['family_name'];?>" maxlength="100">
															</div>
														</td>
														<td class="text-left" style="width: 20%;">
															<select name="family_relation[]" class="form-select">
																<option value="">Select Relationship</option>
																<option value="Son" <?php echo ($fmembers['family_relation'] == 'Son') ? ' selected' : '' ?>>Son</option>
																<option value="Wife" <?php echo ($fmembers['family_relation'] == 'Wife') ? ' selected' : '' ?>>Wife</option>
																<option value="Daughter" <?php echo ($fmembers['family_relation'] == 'Daughter') ? ' selected' : '' ?>>Daughter</option>
																<option value="Mother" <?php echo ($fmembers['family_relation'] == 'Mother') ? ' selected' : '' ?>>Mother</option>
																<option value="Mother in Law" <?php echo ($fmembers['family_relation'] == 'Mother in Law') ? ' selected' : '' ?>>Mother in Law</option>
																<option value="Father in Law" <?php echo ($fmembers['family_relation'] == 'Father in Law') ? ' selected' : '' ?>>Father in Law</option>
															</select>
														</td>
														<td class="text-left" style="width: 15%;">
															<div class="input-group">
																<input type="date" name="family_dob[]" value="<?php echo $fmembers['family_dob'];?>" class="form-control" max="<?php echo date("Y-m-d"); ?>">
															</div>
														</td>
														<td class="text-left">
															<div class="input-group">
																<input type="text" name="family_insurance[]" class="form-control" value="<?php echo $fmembers['family_insurance'];?>" maxlength="120">
															</div>
														</td>
														<td class="text-right">
															<a href="javascript:;" class="btn btn-danger btn-sm float-end remove"><i class="fa fa-minus-circle"></i></a>
														</td>
													</tr>
													<?php }}else{ ?>
													<tr class="family-inner-section">
														<td class="text-left" style="width: 15%;">
															<input type="text" name="family_iqama[]" class="form-control" minlength="<?= ICAMA_LENGTH ;?>" maxlength="<?= ICAMA_LENGTH ;?>">
														</td>
														<td class="text-left">
															<div class="input-group">
																<input type="text" name="family_name[]" class="form-control" maxlength="100">
															</div>
														</td>
														<td class="text-left" style="width: 20%;">
															<select name="family_relation[]" class="form-select">
																<option value="">Select Relationship</option>
																<option value="Son">Son</option>
																<option value="Wife">Wife</option>
																<option value="Daughter">Daughter</option>
																<option value="Mother">Mother</option>
																<option value="Mother in Law">Mother in Law</option>
																<option value="Father in Law">Father in Law</option>
															</select>
														</td>
														<td class="text-left" style="width: 15%;">
															<div class="input-group">
																<input type="date" name="family_dob[]" class="form-control" max="<?php echo date("Y-m-d"); ?>">
															</div>
														</td>
														<td class="text-left">
															<div class="input-group">
																<input type="text" name="family_insurance[]" class="form-control" maxlength="120">
															</div>
														</td>
														<td class="text-right">
															<a href="javascript:;" class="btn btn-danger btn-sm float-end remove"><i class="fa fa-minus-circle"></i></a>
														</td>
													</tr>
													<?php } ?>
												</tbody>

												<tfoot>
													<tr>
														<td colspan="6" class="text-right">
															<a href="javascript:;" class='btn btn-success btn-sm addsection'><i class="fa fa-plus-circle"></i> Add More</a>
														</td>
													</tr>
												</tfoot>
											</table>
										</div>

										<div class="row size-inner-section px-2 py-4">
											<h4 class="header-title">Passport & DL Details</h4>
											<hr>
											
											<div class="col-md-4 col-sm-12 mb-2 form-group">
												<label for="passport_issue_country">Passport Issue Country <span class="required-field">*</span></label>
												<select name="passport_issue_country" id="passport_issue_country" class="form-select select2" data-placeholder="Choose Passport Issue Country..." required>
													<option value="">Select Country</option>
													<?php foreach($nationalities as $nation) { ?>
														<option value="<?php echo $nation->name; ?>" <?php echo ($nation->name == $emp_detail->passport_issue_country) ? 'selected' : '' ?>><?php echo $nation->name; ?></option>
													<?php } ?>
												</select>
												<small class="hint">Select Country</small>
											</div>
											<div class="col-md-4 col-sm-12 mb-2 form-group">
												<label for="passport_issue_city">Passport Issue City <span class="required-field">*</span></label>
												<input type="text" class="form-control" id="passport_issue_city" name="passport_issue_city" value="<?php echo $emp_detail->passport_issue_city; ?>" maxlength="100" required />
												<small class="hint">Enter passport issue city</small>
											</div>
											<div class="col-md-4 col-sm-12 mb-2 form-group">
												<label for="passport_no">Passport Number <span class="required-field">*</span></label>
												<input type="text" class="form-control" id="passport_no" name="passport_no" minlength="8" maxlength="<?= PASSPORT_LENGTH;?>" value="<?php echo $emp_detail->passport_no; ?>" required />
												<small class="hint">Enter Passport Number</small>
											</div>
											<div class="col-md-4 col-sm-12 mb-2 form-group">
												<label for="passport_exp">Passport Expiry Date <span class="required-field">*</span></label>
												<input type="date" class="form-control" id="passport_exp" name="passport_exp" min="<?php echo date("Y-m-d"); ?>" value="<?php echo $emp_detail->passport_exp; ?>" required />
												<small class="hint">Enter Passport Expiry Date</small>
											</div>
											<div class="col-md-12 col-sm-12 mb-2 form-group">
												<input class="checkbox" type="checkbox" id="dl_available" name="dl_available" <?php echo ($emp_detail->dl_available == 'on') ? 'checked' : '' ?> style="vertical-align: sub;margin-right: 10px;">
												<label class="form-check-label" for="dl_available">
												Do you have Homeland Driving License
												</label>
												<small class="hint"> (Check if you have driving License.)</small>
											</div>
											
											<div id="dl-container" class="row">
												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="dl_no">Driving License No</label>
													<input type="text" class="form-control" id="dl_no" name="dl_no" minlength="<?= DL_LENGTH ;?>" maxlength="<?= DL_LENGTH ;?>" value="<?= $emp_detail->dl_no; ?>" />
													<small class="hint">Enter driving license no</small>
													<span id="errmsgadhar" class="err-msg"></span>
												</div>
												
												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="dl_expiry">Driving License Expiry</label>
													<input type="date" class="form-control" id="dl_expiry" name="dl_expiry" min="<?php echo date("Y-m-d"); ?>" value="<?= $emp_detail->dl_expiry; ?>" />
													<small class="hint">Enter driving license expiry date</small>
												</div>

											</div>
										</div>

									</div>
									<div class="tab-pane" id="documentsTab" role="tabpanel">
										<div class="row size-inner-section px-2 py-4">

											<div class="col-md-4 col-sm-12 mb-2 form-group mb-4">
												<label for="documents">Documents (Pre Hiring Document)</label>
												<div class="col-md-12">
													<?php 
														if(count($documents) > 0){ 
														if (in_array("others", array_column($documents,'doc_type'))){
														foreach($documents as $cv_doc){
														if($cv_doc['doc_type'] == 'others'){ 
														$file_extension = pathinfo($cv_doc['document'], PATHINFO_EXTENSION);
													?>
													<div class="float-start text-center image-container mt-2 me-2" id="img_<?php echo $cv_doc['id'];?>">
														<img src="<?php echo ($file_extension == 'doc' || $file_extension == 'docx' || $file_extension == 'pdf') ? base_url('images/attached-file.png') : base_url($cv_doc['document']); ?>" class="cv-documents" />
														<div class="overlay"></div>
														<div class="edit"><a type="button" onclick="viewCertificate(this)" class="btn btn-primary btn-sm" target="_blank" title="View" data-doc="<?php echo base_url($cv_doc['document']);?>" data-type="Documents"><i class="fa fa-eye"></i></a> <a type="button" class="btn btn-danger btn-sm remove-cv-image" data-id="<?php echo $cv_doc['id'];?>"><i class="fa fa-trash"></i></a></div>
													</div>
													<?php }}}else{ ?>
														<div class="float-start text-center cv-documents mt-2 me-2">
															<p>Document Not Uploaded</p>
															<a class="document-form btn btn-light" onclick="uploadDocuments(this)" data-heading="Upload Documents" data-type="others"><i class="mdi mdi-cloud-upload-outline font-size-18"></i> Upload Documents</a>
														</div>
													<?php }} ?>
												</div>
											</div>

											<div class="col-md-4 col-sm-12 mb-2 form-group mb-4">
												<label for="documents">Profile Picture</label>
												<div class="col-md-12">
													<?php 
														if(count($documents) > 0){ 
														if (in_array("profile_pic", array_column($documents,'doc_type'))){
														foreach($documents as $cv_doc){
														if($cv_doc['doc_type'] == 'profile_pic'){ 
														$file_extension = pathinfo($cv_doc['document'], PATHINFO_EXTENSION);
													?>
													<div class="float-start text-center image-container mt-2 me-2" id="img_<?php echo $cv_doc['id'];?>">
														<img src="<?php echo ($file_extension == 'doc' || $file_extension == 'docx' || $file_extension == 'pdf') ? base_url('images/attached-file.png') : base_url($cv_doc['document']); ?>" class="cv-documents" />
														<div class="overlay"></div>
														<div class="edit"><a type="button" onclick="viewCertificate(this)" class="btn btn-primary btn-sm" target="_blank" title="View" data-doc="<?php echo base_url($cv_doc['document']);?>" data-type="Profile Picture"><i class="fa fa-eye"></i></a> <a type="button" class="btn btn-danger btn-sm remove-cv-image" data-id="<?php echo $cv_doc['id'];?>"><i class="fa fa-trash"></i></a></div>
													</div>
													<?php }}}else{ ?>
														<div class="float-start text-center cv-documents mt-2 me-2">
															<p>Profile Picture Not Uploaded</p>
															<a class="document-form btn btn-light" onclick="uploadDocuments(this)" data-heading="Upload Profile Picture" data-type="profile_pic"><i class="mdi mdi-cloud-upload-outline font-size-18"></i> Upload Profile Picture</a>
														</div>
													<?php }} ?>
												</div>
											</div>
											
											<div class="col-md-4 col-sm-12 mb-2 form-group mb-4">
												<label for="saudi_dl_documents">Saudi DL Documents</label>
												<div class="col-md-12">
													<?php 
														if(count($documents) > 0){ 
														if (in_array("saudi_dl", array_column($documents,'doc_type'))){
														foreach($documents as $cv_doc){
														if($cv_doc['doc_type'] == 'saudi_dl'){ 
														$file_extension = pathinfo($cv_doc['document'], PATHINFO_EXTENSION);
													?>
													<div class="float-start text-center image-container mt-2 me-2" id="img_<?php echo $cv_doc['id'];?>">
														<img src="<?php echo ($file_extension == 'doc' || $file_extension == 'docx' || $file_extension == 'pdf') ? base_url('images/attached-file.png') : base_url($cv_doc['document']); ?>" class="cv-documents" />
														<div class="overlay"></div>
														<div class="edit"><a type="button" onclick="viewCertificate(this)" class="btn btn-primary btn-sm" target="_blank" title="View" data-doc="<?php echo base_url($cv_doc['document']);?>" data-type="Saudi DL"><i class="fa fa-eye"></i></a> <a type="button" class="btn btn-danger btn-sm remove-cv-image" data-id="<?php echo $cv_doc['id'];?>"><i class="fa fa-trash"></i></a></div>
													</div>
													<?php }}}else{ ?>
														<div class="float-start text-center cv-documents mt-2 me-2">
															<p>Saudi DL Not Uploaded</p>
															<a class="document-form btn btn-light" onclick="uploadDocuments(this)" data-heading="Upload Saudi DL" data-type="saudi_dl"><i class="mdi mdi-cloud-upload-outline font-size-18"></i> Upload Saudi DL</a>
														</div>
													<?php }} ?>
												</div>
											</div>
											
											<div class="col-md-4 col-sm-12 mb-2 form-group mb-4">
												<label for="iqama_documents">Iqama Certificate</label>
												<div class="col-md-12">
													<?php 
														if(count($documents) > 0){ 
														if (in_array("iqama", array_column($documents,'doc_type'))){
														foreach($documents as $cv_doc){
														if($cv_doc['doc_type'] == 'iqama'){ 
														$file_extension = pathinfo($cv_doc['document'], PATHINFO_EXTENSION);
													?>
													<div class="float-start text-center image-container mt-2 me-2" id="img_<?php echo $cv_doc['id'];?>">
														<img src="<?php echo ($file_extension == 'doc' || $file_extension == 'docx' || $file_extension == 'pdf') ? base_url('images/attached-file.png') : base_url($cv_doc['document']); ?>" class="cv-documents" />
														<div class="overlay"></div>
														<div class="edit"><a type="button" onclick="viewCertificate(this)" class="btn btn-primary btn-sm" target="_blank" title="View" data-doc="<?php echo base_url($cv_doc['document']);?>" data-type="Iqama"><i class="fa fa-eye"></i></a> <a type="button" class="btn btn-danger btn-sm remove-cv-image" data-id="<?php echo $cv_doc['id'];?>"><i class="fa fa-trash"></i></a></div>
													</div>
													<?php }}}else{ ?>
														<div class="float-start text-center cv-documents mt-2 me-2">
															<p>Iqama Not Uploaded</p>
															<a class="document-form btn btn-light" onclick="uploadDocuments(this)" data-heading="Upload Iqama" data-type="iqama"><i class="mdi mdi-cloud-upload-outline font-size-18"></i> Upload Iqama</a>
														</div>
													<?php }} ?>
												</div>
											</div>
											
											<div class="col-md-4 col-sm-12 mb-2 form-group mb-4">
												<label for="dl_documents">DL Documents</label>
												<div class="col-md-12">
													<?php 
														if(count($documents) > 0){ 
														if (in_array("dl_documents", array_column($documents,'doc_type'))){
														foreach($documents as $cv_doc){
														if($cv_doc['doc_type'] == 'dl_documents'){ 
														$file_extension = pathinfo($cv_doc['document'], PATHINFO_EXTENSION);
													?>
													<div class="float-start text-center image-container mt-2 me-2" id="img_<?php echo $cv_doc['id'];?>">
														<img src="<?php echo ($file_extension == 'doc' || $file_extension == 'docx' || $file_extension == 'pdf') ? base_url('images/attached-file.png') : base_url($cv_doc['document']); ?>" class="cv-documents" />
														<div class="overlay"></div>
														<div class="edit"><a type="button" onclick="viewCertificate(this)" class="btn btn-primary btn-sm" target="_blank" title="View" data-doc="<?php echo base_url($cv_doc['document']);?>" data-type="DL Documents"><i class="fa fa-eye"></i></a> <a type="button" class="btn btn-danger btn-sm remove-cv-image" data-id="<?php echo $cv_doc['id'];?>"><i class="fa fa-trash"></i></a></div>
													</div>
													<?php }}}else{ ?>
														<div class="float-start text-center cv-documents mt-2 me-2">
															<p>DL Documents Not Uploaded</p>
															<a class="document-form btn btn-light" onclick="uploadDocuments(this)" data-heading="Upload DL Documents" data-type="dl_documents"><i class="mdi mdi-cloud-upload-outline font-size-18"></i> Upload DL Documents</a>
														</div>
													<?php }} ?>
												</div>
											</div>

											<div class="col-md-4 col-sm-12 mb-2 form-group mb-4">
												<label for="offer_letter">Offer Letter</label>
												<div class="col-md-12">
													<?php 
														if(count($documents) > 0){ 
														if (in_array("offer_letter", array_column($documents,'doc_type'))){
														foreach($documents as $cv_doc){
														if($cv_doc['doc_type'] == 'offer_letter'){ 
														$file_extension = pathinfo($cv_doc['document'], PATHINFO_EXTENSION);
													?>
													<div class="float-start text-center image-container mt-2 me-2" id="img_<?php echo $cv_doc['id'];?>">
														<img src="<?php echo ($file_extension == 'doc' || $file_extension == 'docx' || $file_extension == 'pdf') ? base_url('images/attached-file.png') : base_url($cv_doc['document']); ?>" class="cv-documents" />
														<div class="overlay"></div>
														<div class="edit"><a type="button" onclick="viewCertificate(this)" class="btn btn-primary btn-sm" target="_blank" title="View" data-doc="<?php echo base_url($cv_doc['document']);?>" data-type="Offer Letter"><i class="fa fa-eye"></i></a> <a type="button" class="btn btn-danger btn-sm remove-cv-image" data-id="<?php echo $cv_doc['id'];?>"><i class="fa fa-trash"></i></a></div>
													</div>
													<?php }}}else{ ?>
														<div class="float-start text-center cv-documents mt-2 me-2">
															<p>Offer Letter Not Uploaded</p>
															<a class="document-form btn btn-light" onclick="uploadDocuments(this)" data-heading="Upload Offer Letter" data-type="offer_letter"><i class="mdi mdi-cloud-upload-outline font-size-18"></i> Upload Offer Letter</a>
														</div>
													<?php }} ?>
												</div>
											</div>

											<div class="col-md-4 col-sm-12 mb-2 form-group mb-4">
												<label for="medical">Medical Certificate</label>
												<div class="col-md-12">
													<?php 
														if(count($documents) > 0){ 
														if (in_array("medical", array_column($documents,'doc_type'))){
														foreach($documents as $cv_doc){
														if($cv_doc['doc_type'] == 'medical'){ 
														$file_extension = pathinfo($cv_doc['document'], PATHINFO_EXTENSION);
													?>
													<div class="float-start text-center image-container mt-2 me-2" id="img_<?php echo $cv_doc['id'];?>">
														<img src="<?php echo ($file_extension == 'doc' || $file_extension == 'docx' || $file_extension == 'pdf') ? base_url('images/attached-file.png') : base_url($cv_doc['document']); ?>" class="cv-documents" />
														<div class="overlay"></div>
														<div class="edit"><a type="button" onclick="viewCertificate(this)" class="btn btn-primary btn-sm" target="_blank" title="View" data-doc="<?php echo base_url($cv_doc['document']);?>" data-type="Medical Certificate"><i class="fa fa-eye"></i></a> <a type="button" class="btn btn-danger btn-sm remove-cv-image" data-id="<?php echo $cv_doc['id'];?>"><i class="fa fa-trash"></i></a></div>
													</div>
													<?php }}}else{ ?>
														<div class="float-start text-center cv-documents mt-2 me-2">
															<p>Medical Not Uploaded</p>
															<a class="document-form btn btn-light" onclick="uploadDocuments(this)" data-heading="Upload Medical Certificate" data-type="medical"><i class="mdi mdi-cloud-upload-outline font-size-18"></i> Upload Medical</a>
														</div>
													<?php }} ?>
												</div>
											</div>

											<div class="col-md-4 col-sm-12 mb-2 form-group mb-4">
												<label for="visa">Visa Copy</label>
												<div class="col-md-12">
													<?php 
														if(count($documents) > 0){ 
														if (in_array("visa", array_column($documents,'doc_type'))){
														foreach($documents as $cv_doc){
														if($cv_doc['doc_type'] == 'visa'){ 
														$file_extension = pathinfo($cv_doc['document'], PATHINFO_EXTENSION);
													?>
													<div class="float-start text-center image-container mt-2 me-2" id="img_<?php echo $cv_doc['id'];?>">
														<img src="<?php echo ($file_extension == 'doc' || $file_extension == 'docx' || $file_extension == 'pdf') ? base_url('images/attached-file.png') : base_url($cv_doc['document']); ?>" class="cv-documents" />
														<div class="overlay"></div>
														<div class="edit"><a type="button" onclick="viewCertificate(this)" class="btn btn-primary btn-sm" target="_blank" title="View" data-doc="<?php echo base_url($cv_doc['document']);?>" data-type="Visa Copy"><i class="fa fa-eye"></i></a> <a type="button" class="btn btn-danger btn-sm remove-cv-image" data-id="<?php echo $cv_doc['id'];?>"><i class="fa fa-trash"></i></a></div>
													</div>
													<?php }}}else{ ?>
														<div class="float-start text-center cv-documents mt-2 me-2">
															<p>Visa Copy Not Uploaded</p>
															<a class="document-form btn btn-light" onclick="uploadDocuments(this)" data-heading="Upload Visa Copy" data-type="visa"><i class="mdi mdi-cloud-upload-outline font-size-18"></i> Upload Visa Copy</a>
														</div>
													<?php }} ?>
												</div>
											</div>
                                            <?php
                                            	if(count($documents) > 0){ 
												if (in_array("warning_letter", array_column($documents,'doc_type'))){
                                            ?>
                                            <div class="col-md-4 col-sm-12 mb-2 form-group mb-4">
												<label for="warning_letter">Warning Letter</label>
												<div class="col-md-12">
													<?php 
														foreach($documents as $cv_doc){
														if($cv_doc['doc_type'] == 'warning_letter'){ 
														$file_extension = pathinfo($cv_doc['document'], PATHINFO_EXTENSION);
													?>
													<div class="float-start text-center image-container mt-2 me-2" id="img_<?php echo $cv_doc['id'];?>">
														<img src="<?php echo ($file_extension == 'doc' || $file_extension == 'docx' || $file_extension == 'pdf') ? base_url('images/attached-file.png') : base_url($cv_doc['document']); ?>" class="cv-documents" />
														<div class="overlay"></div>
														<div class="edit"><a type="button" onclick="viewCertificate(this)" class="btn btn-primary btn-sm" target="_blank" title="View" data-doc="<?php echo base_url($cv_doc['document']);?>" data-type="Warning Letter"><i class="fa fa-eye"></i></a> <a type="button" class="btn btn-danger btn-sm remove-cv-image" data-id="<?php echo $cv_doc['id'];?>"><i class="fa fa-trash"></i></a></div>
													</div>
													<?php }} ?>
												</div>
											</div>
											<?php } } ?>
											
											<?php
                                            	if(count($documents) > 0){ 
												if (in_array("termination_letter", array_column($documents,'doc_type'))){
                                            ?>
                                            <div class="col-md-4 col-sm-12 mb-2 form-group mb-4">
												<label for="termination_letter">Warning Letter</label>
												<div class="col-md-12">
													<?php 
														foreach($documents as $cv_doc){
														if($cv_doc['doc_type'] == 'termination_letter'){ 
														$file_extension = pathinfo($cv_doc['document'], PATHINFO_EXTENSION);
													?>
													<div class="float-start text-center image-container mt-2 me-2" id="img_<?php echo $cv_doc['id'];?>">
														<img src="<?php echo ($file_extension == 'doc' || $file_extension == 'docx' || $file_extension == 'pdf') ? base_url('images/attached-file.png') : base_url($cv_doc['document']); ?>" class="cv-documents" />
														<div class="overlay"></div>
														<div class="edit"><a type="button" onclick="viewCertificate(this)" class="btn btn-primary btn-sm" target="_blank" title="View" data-doc="<?php echo base_url($cv_doc['document']);?>" data-type="Warning Letter"><i class="fa fa-eye"></i></a> <a type="button" class="btn btn-danger btn-sm remove-cv-image" data-id="<?php echo $cv_doc['id'];?>"><i class="fa fa-trash"></i></a></div>
													</div>
													<?php }} ?>
												</div>
											</div>
											<?php } } ?>
											
											<?php
                                            	if(count($documents) > 0){ 
												if (in_array("termination_letter", array_column($documents,'doc_type'))){
                                            ?>
                                            <div class="col-md-4 col-sm-12 mb-2 form-group mb-4">
												<label for="termination_letter">Termination Letter</label>
												<div class="col-md-12">
													<?php 
														foreach($documents as $cv_doc){
														if($cv_doc['doc_type'] == 'termination_letter'){ 
														$file_extension = pathinfo($cv_doc['document'], PATHINFO_EXTENSION);
													?>
													<div class="float-start text-center image-container mt-2 me-2" id="img_<?php echo $cv_doc['id'];?>">
														<img src="<?php echo ($file_extension == 'doc' || $file_extension == 'docx' || $file_extension == 'pdf') ? base_url('images/attached-file.png') : base_url($cv_doc['document']); ?>" class="cv-documents" />
														<div class="overlay"></div>
														<div class="edit"><a type="button" onclick="viewCertificate(this)" class="btn btn-primary btn-sm" target="_blank" title="View" data-doc="<?php echo base_url($cv_doc['document']);?>" data-type="Termination Letter"><i class="fa fa-eye"></i></a> <a type="button" class="btn btn-danger btn-sm remove-cv-image" data-id="<?php echo $cv_doc['id'];?>"><i class="fa fa-trash"></i></a></div>
													</div>
													<?php }} ?>
												</div>
											</div>
											<?php } } ?>
											
											<?php
                                            	if(count($documents) > 0){ 
												if (in_array("admin_others", array_column($documents,'doc_type'))){
                                            ?>
                                            <div class="col-md-4 col-sm-12 mb-2 form-group mb-4">
												<label for="admin_others">Others Documents</label>
												<div class="col-md-12">
													<?php 
														foreach($documents as $cv_doc){
														if($cv_doc['doc_type'] == 'admin_others'){ 
														$file_extension = pathinfo($cv_doc['document'], PATHINFO_EXTENSION);
													?>
													<div class="float-start text-center image-container mt-2 me-2" id="img_<?php echo $cv_doc['id'];?>">
														<img src="<?php echo ($file_extension == 'doc' || $file_extension == 'docx' || $file_extension == 'pdf') ? base_url('images/attached-file.png') : base_url($cv_doc['document']); ?>" class="cv-documents" />
														<div class="overlay"></div>
														<div class="edit"><a type="button" onclick="viewCertificate(this)" class="btn btn-primary btn-sm" target="_blank" title="View" data-doc="<?php echo base_url($cv_doc['document']);?>" data-type="Others Documents"><i class="fa fa-eye"></i></a> <a type="button" class="btn btn-danger btn-sm remove-cv-image" data-id="<?php echo $cv_doc['id'];?>"><i class="fa fa-trash"></i></a></div>
													</div>
													<?php }} ?>
												</div>
											</div>
											<?php } } ?>
											<div class="col-md-12 col-sm-12 mb-2 form-group mb-4">
												<button type="button" class="btn btn-custom-danger btn-sm waves-effect waves-light" data-bs-toggle="modal" data-bs-target=".bs-more-document-upload-modal">Upload More Documents</button>
											</div>
										</div>
									</div>
								</div>
							</div>
						<?php echo form_close(); ?>
					</div>
				</div>
			</div> <!-- end col -->
		</div> <!-- end row -->
	</div>
</div>
<!-- container-fluid -->

<?php $this->load->view('admin/home/footer');?>
<div class="modal fade show-image-modal" role="dialog" aria-labelledby="ModalFullscreenLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h6 class="modal-title mt-0" id="summaryModalFullscreenLabel">Show</h6>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body" id="summary_body_modal">
                
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade bs-document-upload-modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title mt-0 document-title">Upload Documents</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body upload-doc-body">
				
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade bs-more-document-upload-modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title mt-0">Upload Documents</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form id="upload_form" action="<?php echo base_url('admin/hr/master/employee/submit-documents'); ?>" method="POST" enctype="multipart/form-data">
					<input type="hidden" name="emp_id" value="<?php echo $this->input->get('id');?>" required>
					<div class="row">
						<div class="form-group col-lg-12 col-md-12 col-12 mb-3">
							<label for="attachments">Upload File <span class="text-danger">*</span></label>
							<input type="file" class="form-control" id="attachments" required name="attachments[]" multiple />
						</div>
						<div class="form-group col-lg-12 col-md-12 col-12 mb-3">
							<label for="doc_type">Select Category <span class="text-danger">*</span></label>
							<select name="doc_type" id="doc_type" class="form-select" required>
								<option value="others">Pre Hiring Document</option>
								<option value="profile_pic">Profile Picture</option>
								<option value="dl">DL Documents</option>
								<option value="saudi_dl">Saudi DL Documents</option>
								<option value="medical">Medical Certificate</option>
								<option value="visa">Visa</option>
								<option value="ticket">Ticket</option>
								<option value="iqama">Iqama</option>
								<option value="warning_letter">Warning Letter</option>
								<option value="termination_letter">Termination Letter</option>
								<option value="admin_others">Others</option>
							</select>
						</div>
						<div class="form-group col-lg-12 col-md-12 col-12 mb-3">
							<label for="doc_category">Select Folder Location <span class="text-danger">*</span></label>
							<select name="doc_category" id="doc_category" class="form-select" required>
								<option value="my_documents">My Documents</option>
								<option value="shared_documents">Shared Documents</option>
								<option value="my_hr_letter">My Hr Letter</option>
							</select>
						</div>
						<div class="form-group col-lg-12 col-md-12 col-12 mb-3">
							<input type="submit" value="Upload" class="btn btn-custom-success float-end" />
						</div>
					</div>
				</form>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">
	
	//Add Family
	var template = $("#family_sections .family-inner-section:first").clone();
	//define counter
	var sectionsCount = 1;
	//add new section
	$("body").on("click", ".addsection", function () {
		//increment
		sectionsCount++;

		//loop through each input
		var section = template
			.clone()
			.find(":input").val("")
			.each(function () {
				//set id to store the updated section number
				var newId = this.id + sectionsCount;
				//alert(newId);
				$(this).prev().attr("for", newId);
				this.id = newId;
			})
			.end()
			//inject new section
			.appendTo("#family_sections");
		return false;
	});

	//remove section
	$("#family_sections").on("click", ".remove", function () {
		//fade out section
		$(this)
			.parent()
			.fadeOut(300, function () {
				//remove parent element (main section)
				$(this).parent().empty();
				return false;
			});
		return false;
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

	$("select[name='hiring_type']").on('change',function(){
		var value = $("select[name='hiring_type'] option:selected").val();
		if (value == 'Foreign') {
			$('#applicant_country').val('');
			$('#country').val('');
			$('#applicant_country option').removeAttr('selected').filter('[value="Saudi Arabia"]').attr('disabled', true);
			$('#country option').removeAttr('selected').filter('[value="Saudi Arabia"]').attr('disabled', true);
			$('#agency-container').removeClass('d-none');
			//$('#agency_name').attr('required',true);
		} else {
			$('#applicant_country option').removeAttr('disabled');
			$('#country option').removeAttr('disabled');
			$('#applicant_country').val('Saudi Arabia');
			$('#country').val('Saudi Arabia');
			$('#applicant_country option').removeAttr('selected').filter('[value="Saudi Arabia"]').attr('selected', true);
			$('#country option').removeAttr('selected').filter('[value="Saudi Arabia"]').attr('selected', true);
			$('#agency-container').addClass('d-none');
			//$('#agency_name').attr('required',false);
			$('#agency_name').val('');
		}
	});

	$("select[name='employee_mode']").on('change',function(){
		var value = $("select[name='employee_mode'] option:selected").val();
		$('.access-checked input').val('');
		$('.access-checked input[type="checkbox"]:checked').prop('checked',false);
		$(".access-checked select").val(null).trigger("change");
		if (value == 'user') {
			$('#allow_access').prop('disabled', false);
		} else {
			$('#allow_access').prop('disabled', true);
			$('#allow_access').prop('checked', false);
		}
	});
	
	$('#allow_access').on('click', function() {
		$(".access-checked select").val(null).trigger("change");
		$('.access-checked input[type="checkbox"]:checked').prop('checked',false);
		$("#send_credential").val('');
		if($("#allow_access").is(":checked")) {
			$('.access-checked').removeClass('d-none');
			$('#display_language').prop('required',true);
			$('#employee_role').prop('required',true);
			$('#branches').prop('required',true);
		}else{
			$('.access-checked').addClass('d-none');
			$('#display_language').prop('required',false);
			$('#employee_role').prop('required',false);
			$('#branches').prop('required',false);
		}    
	});
	
	$('#extra_members').on('click', function() {
		$(".family-inner-section input").val('');
		if($("#extra_members").is(":checked")) {
			$('.family-container').removeClass('d-none');
			$('#family_iqama').prop('required',true);
			$('#family_name').prop('required',true);
			$('#family_relation').prop('required',true);
			$('#family_dob').prop('required',true);
			$('#family_insurance').prop('required',true);
		}else{
			$('.family-container').addClass('d-none');
			$('#family_iqama').prop('required',false);
			$('#family_name').prop('required',false);
			$('#family_relation').prop('required',false);
			$('#family_dob').prop('required',false);
			$('#family_insurance').prop('required',false);
		}    
	});

	$(document).ready( function () {
		hideShowDl();
		hideShowSaudiDl();
		rejecteReason();
		showHideInterview();
		hideAccessCont();
	});

	function hideAccessCont() { 
		if($("#allow_access").is(":checked")) {
			$('.access-checked').removeClass('d-none');
			$('#display_language').prop('required',true);
			$('#employee_role').prop('required',true);
			$('#branches').prop('required',true);
		}else{
			$('.access-checked').addClass('d-none');
			$('#display_language').prop('required',false);
			$('#employee_role').prop('required',false);
			$('#branches').prop('required',false);
		}
	}

	$('#dl_available').click(function() {
		hideShowDl()
	});

	function hideShowDl() { 
		if($("#dl_available").is(':checked')){
			$('#dl-container').removeClass('d-none');
			//$('#dl_no').attr('required',true);
		}else{
			$('#dl-container').addClass('d-none');
			//$('#dl_no').attr('required',false);
		}
	}
	
	$('#saudi_dl_available').click(function() {
		hideShowSaudiDl()
	});

	function hideShowSaudiDl() { 
		if($("#saudi_dl_available").is(':checked')){
			$('#saudi-dl-container').removeClass('d-none');
		}else{
			$('#saudi-dl-container').addClass('d-none');
		}
	}
	
	$('#interview_status').change(function() {
		rejecteReason();
	});

	function rejecteReason() { 
		var interview_status = $('#interview_status').find('option:selected').val();
		if(interview_status == 'rejected'){
			$('#rejection_container').removeClass('d-none');
			$('#interview_status').attr('required',true);
		}else{
			$('#rejection_container').addClass('d-none');
			$('#interview_status').attr('required',false);
		}
	}

	$('#cv_status').change(function() {
		showHideInterview();
	});

	function showHideInterview() { 
		var cv_status = $('#cv_status').find('option:selected').val();
		if(cv_status !== 'new'){
			$('.interview-container').removeClass('d-none');
		}else{
			$('.interview-container').addClass('d-none');
		}
	}

	$('#marital_status').change(function() {
		var marital_status = $(this).find('option:selected').val();
		if(marital_status == 'Single'){
			$('.spouse_field').addClass('d-none');
		}else{
			$('.spouse_field').removeClass('d-none');
		}
	});
	
	$('#applicant_country').change(function() {
		var country_id = $(this).find('option:selected').val();
		$.ajax({
			url: "<?php echo base_url(); ?>admin/Cv_controller/getAgency",
			data: {
				country_id: country_id
			},
			dataType: "json",
			type: "POST",
			success: function(data) {
				//console.log(data);
				var html = '<option value="">Select Agency</option>';
				if (Object.keys(data).length > 0) {
					$.each(data, function(index, item) {
						html += '<option value="' + item.id + '" data-id="' + item.id + '">' + item.agency_name + '</option>';
					});
				} else {
					var html = '<option value="">No agency found</option>';
				}
				$('#agency_name').html(html);
			}
		});
	});

	$('.remove-cv-image').click(function() {
		var img_id = $(this).data('id');
		var emp_id = "<?php echo $this->input->get('id');?>";
		//alert(size_id);
		if(confirm('Are you sure want to delete?')) {
			if(img_id > 0){
				$.ajax({
					url: "<?php echo base_url('admin/hr/master/employee/delete-image');?>",
					type: "POST",
					data: {
						img_id: img_id,
						emp_id: emp_id,
					},
					dataType: "json",
					success: function (data) {
						if(data.type == 'success'){
							$('#img_'+img_id).remove();
							Swal.fire({
								icon: 'success',
								title: 'Success',
								text: data.message,
								timer: 1500
							});
						}else{
							Swal.fire({
								icon: 'error',
								title: 'Error',
								text: data.message,
								timer: 1500
							});
						}
					},
					error: function (data) {
						console.log(data);
					},
				});
			}else{
				return false;
			}
		}else{
			return false;
		}
		return false;
	});

	function uploadDocuments(identifier) {
		let empid = '<?php echo $emp_detail->id; ?>';
		let type = $(identifier).data('type');
		let heading = $(identifier).data('heading');
		if(empid > 0){
			$.ajax({
				type: "post",
				url: "<?php echo base_url('admin/hr/master/employee/upload-form');?>",
				data: {'empid': empid, 'type': type},
				dataType: "json",
				success: function (response) {
					console.log(response);
					$('.document-title').html(heading);
					$('.bs-document-upload-modal').modal('show');
					if(response.type == 'success'){
						$('.upload-doc-body').html(response.message);
					}else{
						$('.upload-doc-body').html('<h5 class="text-danger">'+response.message+'</h5>');
					}
					//$('#summaryModalFullscreenLabel').html('UPLOAD '+ type.toUpperCase());
				},
				error: function (request, error) {
					console.log(" Can't do because: " + JSON.stringify(request));
					$('#summary_body_modal').after(JSON.stringify(request));
				},
			});
		}else{
			alert('Invalid request id!');
		}
	}

	function viewCertificate(identifier) {
		let doc = $(identifier).data('doc');
		let type = $(identifier).data('type');
		if(doc !== ''){
			$('.show-image-modal').modal('show');
			$('#summary_body_modal').html('<object data="'+doc+'#view=Fit" width="100%" height="600px" style="object-fit: scale-down;"><p>It appears your Web browser is not configured to display PDF files. No worries, just <a href="your_file.pdf">click here to download the PDF file.</a></p></object>');
			$('#summaryModalFullscreenLabel').html(type.toUpperCase());
		}else{
			alert('Invalid document type!');
		}
	}
	
	function checkDuplicateEmail() {
		var email_id = $("#email").val();
		var id = $("#id").val();
		if (email_id !== "") {
			$.ajax({
				url: "<?php echo base_url();?>admin/hr/master/employee/check-email",
				type: "GET",
				data: {
					email: email_id,
					id: id,
				},
				dataType: "json",
				success: function (data) {
					if(data.status == 'success'){
						$(".res-email").html(data.msg);
						$("#email").removeClass('parsley-error');
					}else{
						$("#email").val('');
						$("#email").addClass('parsley-error');
						$(".res-email").html(data.msg);
						return false;
					}
				},
				error: function () {
					$("#email").val('');
					$("#email").addClass('parsley-error');
					return false;
				},
			});
		} else {
			$("#email").addClass('parsley-error');
		}
	}
</script>
