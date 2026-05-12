
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
.cv-documents{
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
.employee_form input, .employee_form textarea, .employee_form select, .employee_form select.select2, .employee_form .form-control{
    pointer-events: none;
	background-color: #f5f5f5;
    border: 1px dotted #ced4da;
}
.modal input, .modal textarea, .modal select, .modal select.select2{
    pointer-events: auto;
}

/*----- Steps Css -----*/
.step-wraper {
  padding: 25px;
  text-align: center;
  width: 100%;
  margin: 10px auto;
}

.step-wraper-list {
  border-top: 2px solid #dadadb;
  display: flex;
  list-style: none;
  padding: 0;
  justify-content: space-between;
  align-items: stretch;
  align-content: stretch;
}

.step-link {
  position: relative;
  margin-top: 12px;
  width: 100%;
}

.step-link a {
  font-weight: bold;
  text-decoration: none;
  color: #a7a7a7;
  text-transform: uppercase;
  font-size: 10px;
}

.step-link:first-child {
  margin-left: -70px;
}

.step-link:last-child {
  margin-right: -70px;
}

.step-link a::after {
    content: "";
    width: 15px;
    height: 15px;
    background: #fff;
    position: absolute;
    border-radius: 10px;
    top: -20px;
    left: 50%;
    transform: translatex(-50%);
    border: 2px solid #aeb7bf;
}

.step-link.prev a::before {
    border: 2px solid #fdce43;
    width: 100%;
    content: "";
    background: #fff;
    position: absolute;
    border-radius: 0px;
    top: -14px;
    left: 50%;
}

.step-link.prev a::after {
  border: 2px solid #fdce43;
}

.step-link.prev a::after{
  background: #fdce43;
}

.step-link.active a::after {
  border: 2px solid #fdce43;
}

.step-link.active a::after,
.step-link a:hover::after {
  background: #fdce43;
}
.employee-profle-pic {
    height: 39px;
    width: 36px;
    background-color: #eaedf1;
    padding: 3px;
}
.twitter-bs-wizard .twitter-bs-wizard-pager-link li a {
    display: inline-block;
    padding: 0.47rem 0.75rem;
    background-color: #1ea77a;
    color: #fff;
    border-radius: 0.25rem;
}
.twitter-bs-wizard .twitter-bs-wizard-pager-link li a:hover {
    box-shadow: none;
}
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
			<?php $admin_id = $this->session->userdata('admin_id');?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<a class="btn btn-sm btn-custom-white pull-right me-2" title="Back" href="<?php echo base_url('admin/hr/employees'); ?>"><i class="fa fa-reply"></i> Back</a>
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
						<div class="employee-profile-pic text-center">
							<div class="rounded-circle mb-2" style="width: 100px;margin: auto;">
								<svg enable-background="new 0 0 73.9 73.9" viewBox="0 0 73.9 73.9" xmlns="http://www.w3.org/2000/svg"><circle cx="37" cy="28.4" fill="none" r="2.8"/><path d="m37 62.6c14.2 0 25.6-11.5 25.6-25.7s-11.5-25.6-25.7-25.6-25.6 11.5-25.6 25.7c0 14.1 11.5 25.6 25.7 25.6zm0-44.9c5.9 0 10.7 4.9 10.7 10.8s-4.9 10.7-10.8 10.7-10.7-4.9-10.7-10.8 4.9-10.7 10.8-10.7zm-17 32c8.8-9.4 23.5-9.9 32.9-1.1l1.1 1.1c.4.4.4 1 0 1.4-.4.4-1 .4-1.4 0-8-8.6-21.5-9-30.1-.9-.3.3-.6.6-.9.9-.4.4-1.1.5-1.5.1s-.5-1-.1-1.5z" fill="none"/><g fill="#a7a9ac"><path d="m37 64.6c15.3 0 27.6-12.4 27.6-27.7s-12.4-27.6-27.7-27.6c-15.2 0-27.6 12.4-27.6 27.7s12.4 27.6 27.7 27.6zm0-53.3c14.2 0 25.6 11.5 25.6 25.7s-11.5 25.7-25.7 25.6c-14.2 0-25.6-11.5-25.6-25.7 0-14.1 11.5-25.6 25.7-25.6z"/><path d="m37 39.2c5.9 0 10.7-4.9 10.7-10.8s-4.9-10.7-10.8-10.7-10.7 4.8-10.7 10.7c0 6 4.8 10.8 10.8 10.8zm0-19.5c4.8 0 8.7 4 8.7 8.8s-4 8.7-8.8 8.7-8.7-4-8.7-8.8 4-8.7 8.8-8.7z"/><path d="m21.4 51.1c8-8.6 21.5-9 30.1-.9l.9.9c.4.4 1 .4 1.4 0 .4-.4.4-1 0-1.4-8.8-9.4-23.5-9.8-32.9-1-.4.3-.7.7-1 1-.4.4-.4 1 0 1.4.5.4 1.1.4 1.5 0z"/></g></svg>
							</div>
							<h5 id="employeeName"><?php echo $emp_detail->full_name;?></h5>
						</div>
						<div class="step-wraper">
							<ul class="step-wraper-list">
								<li class="step-link active"><a href="<?php echo base_url('admin/hr/employees/view/step-2/'.$emp_detail->id);?>">Personal</a></li>
								<li class="step-link"><a href="<?php echo base_url('admin/hr/employees/view/step-2/'.$emp_detail->id);?>">Address & Contacts</a></li>
								<li class="step-link"><a href="<?php echo base_url('admin/hr/employees/view/step-3/'.$emp_detail->id);?>">Organization</a></li>
								<li class="step-link"><a href="<?php echo base_url('admin/hr/employees/view/step-4/'.$emp_detail->id);?>">Insurance & DL</a></li>
								<li class="step-link"><a href="<?php echo base_url('admin/hr/employees/view/step-5/'.$emp_detail->id);?>">Payments</a></li>
								<li class="step-link"><a href="<?php echo base_url('admin/hr/employees/view/step-6/'.$emp_detail->id);?>">Documents</a></li>
								<li class="step-link"><a href="<?php echo base_url('admin/hr/employees/view/step-7/'.$emp_detail->id);?>">Transactions</a></li>
								<li class="step-link"><a href="<?php echo base_url('admin/hr/employees/view/step-8/'.$emp_detail->id);?>">Team Members</a></li>
							</ul>
						</div>
						<div class="employee_form">
							<input type="hidden" id="id" name="id" value="<?php echo $emp_detail->id;?>" />
							<!-- Tab panes -->
							<div class="row size-inner-section px-2 py-4 mx-2">
								<h4 class="header-title">General Information</h4><hr>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="emp_no">Employee ID <span class="required-field">*</span></label>
									<input type="text" class="form-control" id="emp_no" name="emp_no" maxlength="25" value="<?php echo $emp_detail->emp_no;?>" required readonly />
									<small class="hint res-msg"></small>
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="first_name">First Name <span class="required-field">*</span></label>
									<input type="text" class="form-control" onKeyPress="return Alpha(event);" id="first_name" name="first_name" maxlength="150" value="<?php echo $emp_detail->first_name;?>" required />
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="second_name">Second Name</label>
									<input type="text" class="form-control" onKeyPress="return Alpha(event);" id="second_name" name="second_name" maxlength="150" value="<?php echo $emp_detail->second_name;?>" />
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="third_name">Third Name</label>
									<input type="text" class="form-control" onKeyPress="return Alpha(event);" id="third_name" name="third_name" maxlength="150" value="<?php echo $emp_detail->third_name;?>" />
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="last_name">Last Name</label>
									<input type="text" class="form-control" onKeyPress="return Alpha(event);" id="last_name" name="last_name" maxlength="150" value="<?php echo $emp_detail->last_name;?>" />
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="full_name">Full Name (EN)<span class="required-field">*</span></label>
									<input type="text" class="form-control" onKeyPress="return Alpha(event);" id="full_name" name="full_name" maxlength="150" value="<?php echo $emp_detail->full_name;?>" required />
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="employee_arabic_name">Full Name (AR)<span class="required-field">*</span></label>
									<input type="text" class="form-control rtl-input" id="employee_arabic_name" name="employee_arabic_name" value="<?php echo $emp_detail->employee_arabic_name;?>" maxlength="150" required />
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="dob">Date of Birth <span class="required-field">*</span></label>
									<input type="date" class="form-control" id="dob" name="dob" max="<?php echo date("Y-m-d"); ?>" value="<?php echo $emp_detail->dob;?>" required />
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="gender">Gender <span class="required-field">*</span></label>
									<select name="gender" id="gender" class="form-control" required>
										<option value="">Select Gender</option>
										<option value="male" <?php echo ($emp_detail->gender == 'male') ? ' selected ' : '' ?>>Male</option>
										<option value="female" <?php echo ($emp_detail->gender == 'female') ? ' selected ' : '' ?>>Female</option>
										<option value="other" <?php echo ($emp_detail->gender == 'other') ? ' selected ' : '' ?>>Other</option>
									</select>
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="marital_status">Marital Status <span class="required-field">*</span></label>
									<select name="marital_status" id="marital_status" class="form-control" required>
										<option value="">Select Marital Status</option>
										<option value="Single" <?php echo ($emp_detail->marital_status == 'Single') ? ' selected ' : '' ?>>Single</option>
										<option value="Married" <?php echo ($emp_detail->marital_status == 'Married') ? ' selected ' : '' ?>>Married</option>
										<option value="Divorced" <?php echo ($emp_detail->marital_status == 'Divorced') ? ' selected ' : '' ?>>Divorced</option>
										<option value="Widow" <?php echo ($emp_detail->marital_status == 'Widow') ? ' selected ' : '' ?>>Widow</option>
									</select>
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="religion">Religion <span class="required-field">*</span></label>
									<select name="religion" id="religion" class="form-control" required>
										<option value="">Select Religion</option>
										<option value="Muslim" <?php echo ($emp_detail->religion == 'Muslim') ? ' selected ' : '' ?>>Muslim</option>
										<option value="Non Muslim" <?php echo ($emp_detail->religion == 'Non Muslim') ? ' selected ' : '' ?>>Non Muslim</option>
									</select>
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="mobile">Mobile No. <span class="required-field">*</span></label>
									<input type="text" onKeyPress="return numerics(event);" class="form-control" id="mobile" name="mobile" minlength="<?= MOB_LENGTH ;?>" maxlength="<?= MOB_LENGTH ;?>" value="<?php echo $emp_detail->mobile;?>" required />
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="email">Email ID <span class="required-field">*</span></label>
									<input type="email" class="form-control" id="email" name="email" onBlur="checkDuplicateEmail()" value="<?php echo $emp_detail->email;?>" required />
									<small class="hint res-email"></small>
								</div>
							</div>

							<!---- Iqama Detail ----->
							<div class="row size-inner-section px-2 py-4 mx-2">
								<h4 class="header-title">ID/Iqama Details</h4><hr>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="iqama_no">ID/Iqama Number</label>
									<input type="text" class="form-control" id="iqama_no" name="iqama_no" minlength="<?= ICAMA_LENGTH ;?>" maxlength="<?= ICAMA_LENGTH ;?>" value="<?php echo $emp_detail->iqama_no;?>" />
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="iqama_name_en">Name as per Iqama (EN)</label>
									<input type="text" class="form-control" onKeyPress="return Alpha(event);" id="iqama_name_en" name="iqama_name_en" maxlength="150" value="<?php echo $emp_detail->iqama_name_en;?>" />
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="iqama_name_ar">Name as per Iqama (AR)</label>
									<input type="text" class="form-control rtl-input" onKeyPress="return Alpha(event);" id="iqama_name_ar" name="iqama_name_ar" maxlength="150" value="<?php echo $emp_detail->iqama_name_ar;?>" />
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="iqama_profession">Profession in Iqama</label>
									<select class="form-control" name="iqama_profession" id="iqama_profession">
										<option value="">Select Profession</option>
										<?php foreach(professionList() as $profession) { ?>
										<option value="<?php echo $profession->id; ?>" data-id="<?php echo $profession->id; ?>" <?php echo ($profession->id == $emp_detail->iqama_profession) ? ' selected ' : '' ?>><?php echo $profession->profession_name; ?> <?php echo (isset($profession->arabic_name)) ? '/ '.$profession->arabic_name : ''; ?></option>
										<?php } ?>
									</select>
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="iqama_issue_city">ID/Iqama Issue City</label>
									<select class="form-control" name="iqama_issue_city" id="iqama_issue_city">
										<option value="">Select City</option>
										<?php foreach(selectedCitiesHelp(6) as $cities) { ?>
										<option value="<?php echo $cities->id; ?>" data-id="<?php echo $cities->id; ?>" <?php echo ($cities->id == $emp_detail->iqama_issue_city) ? ' selected ' : '' ?>><?php echo $cities->city_name; ?></option>
										<?php } ?>
									</select>
								</div>

								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="iqama_issue_date_hijri">ID/Iqama Issue Date (Hijri)</label>
									<input id="iqama_issue_date_hijri" name="iqama_issue_date_hijri" class="form-control input-mask" placeholder="dd-mm-yyyy" data-inputmask="'alias': 'datetime'" data-inputmask-inputformat="dd-mm-yyyy" value="<?php echo (isset($emp_detail->iqama_issue_date_hijri) && ($emp_detail->iqama_issue_date_hijri !== '0000-00-00')) ? date('d-m-Y', strtotime($emp_detail->iqama_issue_date_hijri)) : '';?>">
								</div>

								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="iqama_issue_date">ID/Iqama Issue Date (Gregorian)</label>
									<input type="date" class="form-control" id="iqama_issue_date" name="iqama_issue_date" value="<?php echo $emp_detail->iqama_issue_date;?>" />
								</div>

								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="iqama_expiry_date">ID/Iqama Expiry Date (Gregorian)</label>
									<input type="date" class="form-control" id="iqama_expiry_date" name="iqama_expiry_date" value="<?php echo $emp_detail->iqama_expiry_date;?>" />
								</div>

								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="iqama_expiry_date_hijri">ID/ Iqama Expiry Date (Hijri)</label>
									<input id="iqama_expiry_date_hijri" name="iqama_expiry_date_hijri" class="form-control input-mask" placeholder="dd-mm-yyyy" data-inputmask="'alias': 'datetime'" data-inputmask-inputformat="dd-mm-yyyy" value="<?php echo (isset($emp_detail->iqama_expiry_date_hijri) && ($emp_detail->iqama_expiry_date_hijri !== '0000-00-00')) ? date('d-m-Y', strtotime($emp_detail->iqama_expiry_date_hijri)) : '';?>">
								</div>
								
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="iqama_status">ID/ Iqama Status</label>
									<select name="iqama_status" id="iqama_status" class="form-control">
										<option value="">Select Iqama Status</option>
										<option value="active" <?php echo ($emp_detail->iqama_status == 'active') ? ' selected ' : '' ?>>Active</option>
										<option value="expired" <?php echo ($emp_detail->iqama_status == 'expired') ? ' selected ' : '' ?>>Expired</option>
									</select>
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="emp_status">Status <span class="required-field">*</span></label>
									<select name="status" id="emp_status" class="form-select" required>
										<option value="">Select Status</option>
										<option value="Active" <?php echo ($emp_detail->status == 'Active') ? ' selected ' : '' ?>>Active</option>
										<option value="Inactive" <?php echo ($emp_detail->status == 'Inactive') ? ' selected ' : '' ?>>Inactive</option>
										<option value="Resigned" <?php echo ($emp_detail->status == 'Resigned') ? ' selected ' : '' ?>>Resigned</option>
										<option value="Absconded" <?php echo ($emp_detail->status == 'Absconded') ? ' selected ' : '' ?>>Absconded</option>
										<option value="Final Exit" <?php echo ($emp_detail->status == 'Final Exit') ? ' selected ' : '' ?>>Final Exit</option>
									</select>
								</div>
							</div>

							<!---- Passport Detail ----->
							<div class="row size-inner-section px-2 py-4 mx-2">
								<h4 class="header-title">Passport Details</h4><hr>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="nationality">Nationality <span class="required-field">*</span></label>
									<select class="form-control" data-parsley-allselected="true" name="nationality" id="nationality" required>
										<option value="">Select Nationality</option>
										<?php foreach(nationalityList() as $nation) { ?>
										<option value="<?php echo $nation->id; ?>" data-id="<?php echo $nation->id; ?>" <?php echo ($nation->id == $emp_detail->nationality) ? ' selected ' : '' ?>><?php echo $nation->name; ?></option>
										<?php } ?>
									</select>
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="passport_no">Passport Number <span class="required-field">*</span></label>
									<input type="text" class="form-control" id="passport_no" name="passport_no"  onBlur="checkDuplicatePassport()" minlength="8" maxlength="<?= PASSPORT_LENGTH;?>" value="<?php echo $emp_detail->passport_no;?>" required />
									<small class="hint passport-info"></small>
								</div>

								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="passport_issue_date">Passport Issue Date (Gregorian) <span class="required-field">*</span></label>
									<input type="date" class="form-control" id="passport_issue_date" name="passport_issue_date" value="<?php echo $emp_detail->passport_issue_date;?>" required />
								</div>

								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="passport_expiry_date">Passport Expiry Date (Gregorian) <span class="required-field">*</span></label>
									<input type="date" class="form-control" id="passport_expiry_date" name="passport_expiry_date" value="<?php echo $emp_detail->passport_expiry_date;?>" required />
								</div>
								
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="passport_issue_country">Passport Issue Country <span class="required-field">*</span></label>
									<select name="passport_issue_country" id="passport_issue_country" class="form-control" required>
										<option value="">Select Country</option>
										<?php foreach (masterCountries() as $country_list) { ?>
											<option value="<?php echo $country_list->id; ?>" data-id="<?php echo $country_list->id; ?>" <?php echo ($country_list->id == $emp_detail->passport_issue_country) ? ' selected ' : '' ?>><?php echo $country_list->name; ?></option>
										<?php } ?>
									</select>
								</div>
								
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="passport_issue_city">Passport Issuing City <span class="required-field">*</span></label>
									<select name="passport_issue_city" id="passport_issue_city" class="form-control" required>
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
									<li class="next"><a type="button" href="<?php echo base_url('admin/hr/employees/view/step-2/'.$emp_detail->id);?>" class="btn btn-custom-success">Next Step <i class="mdi mdi-arrow-right ms-1"></i></a></li>
								</ul>
							</div>
						</div>
						
					</div>
				</div>
			</div> <!-- end col -->
		</div> <!-- end row -->
	</div>
</div>
<!-- container-fluid -->

<?php $this->load->view('admin/home/footer');?>

<script type="text/javascript">
	
	$("#full_name").keyup(function(){
		var emp_input_name = $("#full_name").val();
		if(emp_input_name !== ''){
			$("#employeeName").html(emp_input_name);
		}else{
			$("#employeeName").html('Employee Name');
		}
	});

	function checkDuplicateEmpID() {
		var emp_id = $("#emp_no").val();
		if (emp_id !== "") {
			$.ajax({
				url: "<?php echo base_url('admin/hr/employees/check-empid');?>",
				type: "GET",
				data: "emp_no=" + $("#emp_no").val(),
				dataType: "json",
				success: function (data) {
					if(data.status == 'success'){
						$(".res-msg").html(data.msg);
					}else{
						$("#emp_no").val('');
						$(".res-msg").html(data.msg);
						return false;
					}
				},
				error: function (response) {
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
				url: "<?php echo base_url('admin/hr/employees/check-email');?>",
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

	function checkDuplicatePassport() {
		var passport_no = $("#passport_no").val();
		var id = $("#id").val();
		if (passport_no !== "") {
			$.ajax({
				url: "<?php echo base_url('admin/hr/employees/check-passport');?>",
				type: "POST",
				data: {
					passport_no: passport_no,
					id: id,
				},
				dataType: "json",
				success: function (data) {
					console.log(data);
					if(data.status == 'success'){
						$(".passport-info").html(data.msg);
						$("#passport_no").removeClass('parsley-error');
					}else{
						$("#passport_no").val('');
						$("#passport_no").addClass('parsley-error');
						$(".passport-info").html(data.msg);
						return false;
					}
				},
				error: function (response) {
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

	function checkField(u){
		var id = $("#"+u).val();
		if(id == ""){
			$("#"+u).addClass("alert_text");
		}
		else{
			$("#"+u).removeClass("alert_text");
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

</script>
