
<?php $this->load->view('admin/home/header');?>

<style>
.required-field{
	color:#f00;
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
.image-container .overlay{
	opacity: 0;
}
.image-container:hover .overlay{
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
					<button onclick="submitButton()" form="employee_form" type="submit" class="btn btn-sm btn-custom-success pull-right" title="Save"><i class="fa fa-save"></i> Save</button>
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
						<div class="step-wraper">
							<ul class="step-wraper-list">
								<li class="step-link prev"><a href="<?php echo base_url('admin');?>">Step 1</a></li>
								<li class="step-link prev"><a href="<?php echo base_url('admin');?>">Step 2</a></li>
								<li class="step-link active"><a href="<?php echo base_url('admin');?>">Step 3</a></li>
								<li class="step-link"><a href="<?php echo base_url('admin');?>">Step 4</a></li>
								<li class="step-link"><a href="<?php echo base_url('admin');?>">Step 5</a></li>
								<li class="step-link"><a href="<?php echo base_url('admin');?>">Step 6</a></li>
								<li class="step-link"><a href="<?php echo base_url('admin');?>">Step 7</a></li>
								<li class="step-link"><a href="<?php echo base_url('admin');?>">Step 8</a></li>
								<li class="step-link"><a href="<?php echo base_url('admin');?>">Step 9</a></li>
								<li class="step-link"><a href="<?php echo base_url('admin');?>">Step 10</a></li>
							</ul>
						</div>
						<?php echo form_open("admin/hr/employees/submit", array("id" => "employee_form", "enctype" => "multipart/form-data", "class" => "form-label-left", "data-parsley-validate" => "")); ?>
							<input type="hidden" id="id" name="id" value="" />
							<!-- Tab panes -->
							<div class="row size-inner-section px-2 py-4">
								<h4 class="header-title">General Information</h4><hr>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="emp_no">Employee ID <span class="required-field">*</span></label>
									<input type="text" class="form-control" id="emp_no" name="emp_no" maxlength="25" onBlur="checkDuplicateEmpID()" required />
									<small class="hint res-msg">Enter Unique Employee ID</small>
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="first_name">First Name <span class="required-field">*</span></label>
									<input type="text" class="form-control" onKeyPress="return Alpha(event);" id="first_name" name="first_name" maxlength="150" value="" required />
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="second_name">Second Name</label>
									<input type="text" class="form-control" onKeyPress="return Alpha(event);" id="second_name" name="second_name" maxlength="150" value="" />
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="third_name">Third Name</label>
									<input type="text" class="form-control" onKeyPress="return Alpha(event);" id="third_name" name="third_name" maxlength="150" value="" />
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="last_name">Last Name</label>
									<input type="text" class="form-control" onKeyPress="return Alpha(event);" id="last_name" name="last_name" maxlength="150" value="" />
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="first_name">Full Name (EN)<span class="required-field">*</span></label>
									<input type="text" class="form-control" onKeyPress="return Alpha(event);" id="first_name" name="first_name" maxlength="150" value="" required />
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="employee_arabic_name">Full Name (AR)<span class="required-field">*</span></label>
									<input type="text" class="form-control rtl-input" id="employee_arabic_name" name="employee_arabic_name" maxlength="150" value="<?php echo $emp_detail->employee_arabic_name; ?>" required />
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="dob">Date of Birth <span class="required-field">*</span></label>
									<input type="date" class="form-control" id="dob" name="dob" value="<?php echo $emp_detail->dob; ?>" max="<?php echo date("Y-m-d"); ?>" required />
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="gender">Gender <span class="required-field">*</span></label>
									<select name="gender" id="gender" class="form-select select2" required>
										<option value="">Select Gender</option>
										<option value="male">Male</option>
										<option value="female">Female</option>
										<option value="other">Other</option>
									</select>
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="marital_status">Marital Status <span class="required-field">*</span></label>
									<select name="marital_status" id="marital_status" class="form-select select2" required>
										<option value="">Select Marital Status</option>
										<option value="Single">Single</option>
										<option value="Married">Married</option>
										<option value="Divorced">Divorced</option>
									</select>
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="marital_status">Religion <span class="required-field">*</span></label>
									<select name="marital_status" id="marital_status" class="form-select select2" required>
										<option value="">Select Religion</option>
										<option value="Muslim">Muslim</option>
										<option value="Non Muslim">Non Muslim</option>
									</select>
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="mobile">Mobile No.</label>
									<input type="text" onKeyPress="return numerics(event);" class="form-control" id="mobile" name="mobile" minlength="<?= MOB_LENGTH ;?>" maxlength="<?= MOB_LENGTH ;?>" />
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="email">Email ID <span class="required-field">*</span></label>
									<input type="email" class="form-control" id="email" name="email" onBlur="checkDuplicateEmail()" required />
								</div>
							</div>

							<!---- Iqama Detail ----->
							<div class="row size-inner-section px-2 py-4">
								<h4 class="header-title">ID/Iqama Details</h4><hr>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="emp_no">ID/Iqama Number <span class="required-field">*</span></label>
									<input type="text" class="form-control" id="iqama_no" name="iqama_no" minlength="<?= ICAMA_LENGTH ;?>" maxlength="<?= ICAMA_LENGTH ;?>" />
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="first_name">Name as per Iqama (EN) <span class="required-field">*</span></label>
									<input type="text" class="form-control" onKeyPress="return Alpha(event);" id="first_name" name="first_name" maxlength="150" value="" required />
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="second_name">Name as per Iqama (AR)</label>
									<input type="text" class="form-control" onKeyPress="return Alpha(event);" id="second_name" name="second_name" maxlength="150" value="" />
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="third_name">Profession in Iqama</label>
									<input type="text" class="form-control" onKeyPress="return Alpha(event);" id="third_name" name="third_name" maxlength="150" value="" />
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="iqama_issue_city">ID/Iqama Issue City</label>
									<input type="text" class="form-control" onKeyPress="return Alpha(event);" id="iqama_issue_city" name="iqama_issue_city" maxlength="150" value="" />
								</div>

								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="iqama_issue_date_hijri">ID/Iqama Issue Date (Hijri)</label>
									<input id="iqama_issue_date_hijri" name="iqama_issue_date_hijri" class="form-control input-mask" placeholder="dd-mm-yyyy" data-inputmask="'alias': 'datetime'" data-inputmask-inputformat="dd-mm-yyyy">
								</div>

								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="iqama_issue_date">ID/Iqama Issue Date (Gregorian)</label>
									<input type="date" class="form-control" id="iqama_issue_date" name="iqama_issue_date" />
								</div>

								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="iqama_expiry_date_hijri">ID/Iqama Expiry Date (Gregorian)</label>
									<input id="iqama_expiry_date_hijri" name="iqama_expiry_date_hijri" class="form-control input-mask" placeholder="dd-mm-yyyy" data-inputmask="'alias': 'datetime'" data-inputmask-inputformat="dd-mm-yyyy">
								</div>

								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="iqama_expiry_date">ID/ Iqama Expiry Date (Hijri)</label>
									<input type="date" class="form-control" id="iqama_expiry_date" name="iqama_expiry_date" />
								</div>
								
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="marital_status">ID/ Iqama Status <span class="required-field">*</span></label>
									<select name="marital_status" id="marital_status" class="form-select select2" required>
										<option value="">Select Iqama Status</option>
										<option value="active">Active</option>
										<option value="expired">Expired</option>
									</select>
								</div>
							</div>

							<!---- Passport Detail ----->
							<div class="row size-inner-section px-2 py-4">
								<h4 class="header-title">Passport Details</h4><hr>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="nationality">Nationality <span class="required-field">*</span></label>
									<select class="form-select select2" name="nationality" id="nationality" required>
										<option value="">Select Nationality</option>
										<?php foreach($nationalities as $nation) { ?>
										<option value="<?php echo $nation->name; ?>" data-id="<?php echo $nation->id; ?>"><?php echo $nation->name; ?></option>
										<?php } ?>
									</select>
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="passport_no">Passport Number <span class="required-field">*</span></label>
									<input type="text" class="form-control" id="passport_no" name="passport_no" minlength="8" maxlength="<?= PASSPORT_LENGTH;?>" required />
								</div>

								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="iqama_issue_date">Passport Issue Date (Gregorian)</label>
									<input type="date" class="form-control" id="iqama_issue_date" name="iqama_issue_date" />
								</div>

								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="iqama_expiry_date_hijri">Passport Expiry Date (Gregorian)</label>
									<input id="iqama_expiry_date_hijri" name="iqama_expiry_date_hijri" class="form-control input-mask" placeholder="dd-mm-yyyy" data-inputmask="'alias': 'datetime'" data-inputmask-inputformat="dd-mm-yyyy">
								</div>
								
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="passport_issue_country">Passport Issue Country <span class="required-field">*</span></label>
									<select name="passport_issue_country" id="passport_issue_country" class="form-select select2" required>
										<option value="">Passport Issue Country</option>
										<?php foreach (masterCountries() as $country_list) { ?>
											<option value="<?php echo $country_list->id; ?>" data-id="<?php echo $country_list->id; ?>"><?php echo $country_list->name; ?></option>
										<?php } ?>
									</select>
								</div>
								
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="last_name">ID/Iqama Issue City</label>
									<input type="text" class="form-control" onKeyPress="return Alpha(event);" id="last_name" name="last_name" maxlength="150" value="" />
								</div>
							</div>

							<!---- Saudi Address ----->
							<div class="row size-inner-section px-2 py-4">
								<h4 class="header-title">Address in Saudi</h4><hr>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="sa_building_no">Building Number</label>
									<input type="text" class="form-control" id="sa_building_no" name="sa_building_no" />
								</div>

								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="sa_street_name">Street Name</label>
									<input type="text" class="form-control" id="sa_street_name" name="sa_street_name" maxlength="100" />
								</div>

								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="sa_district">District</label>
									<input type="text" class="form-control" id="sa_district" name="sa_district" maxlength="100" />
								</div>

								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="sa_city">City</label>
									<input type="text" class="form-control" id="sa_city" name="sa_city" maxlength="100" />
								</div>

								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="sa_additional_no">Additional Number</label>
									<input type="text" class="form-control" id="sa_additional_no" name="sa_additional_no" maxlength="100" />
								</div>

								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="sa_pin_code">Pin Code</label>
									<input type="text" class="form-control" id="sa_pin_code" name="sa_pin_code" maxlength="6" />
								</div>
							</div>

							<!---- Address in Home Country ----->
							<div class="row size-inner-section px-2 py-4">
								<h4 class="header-title">Address in Home Country</h4><hr>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="home_address">Address</label>
									<input type="text" class="form-control" id="home_address" name="home_address" />
								</div>

								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="home_city">Town/City</label>
									<input type="text" class="form-control" id="home_city" name="home_city" maxlength="100" />
								</div>

								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="home_country">Country</label>
									<select name="home_country" id="home_country" class="form-select select2" required>
										<option value="">Select Country</option>
										<?php foreach (masterCountries() as $country_list) { ?>
											<option value="<?php echo $country_list->id; ?>" data-id="<?php echo $country_list->id; ?>"><?php echo $country_list->name; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>

							<!---- Emergency Contact Details ----->
							<div class="row size-inner-section px-2 py-4">
								<h4 class="header-title">Home Land Emergency Contact Details</h4>
								<hr>
								<table id="family_sections" class="table table-striped table-bordered table-hover">
									<thead>
										<tr>
											<td class="text-left">Contact Person Name <span class="required-field">*</span></td>
											<td class="text-left">Contact Person Relationship <span class="required-field">*</span></td>
											<td class="text-left">Contact Person Mobile <span class="required-field">*</span></td>
											<td style="width: 5%;"></td>
										</tr>
									</thead>
									<tbody>
										<tr class="family-inner-section">
											<td class="text-left">
												<div class="input-group">
													<input type="text" name="person_name[]" class="form-control" maxlength="100">
												</div>
											</td>
											<td class="text-left" style="width: 30%;">
												<select name="relationship[]" class="form-select">
													<option value="">Select Relationship</option>
													<option value="Son">Son</option>
													<option value="Wife">Wife</option>
													<option value="Daughter">Daughter</option>
													<option value="Mother">Mother</option>
													<option value="Brother">Brother</option>
													<option value="Sister">Sister</option>
													<option value="Mother in Law">Mother in Law</option>
													<option value="Father in Law">Father in Law</option>
													<option value="Uncle">Uncle</option>
													<option value="Aunt">Aunt</option>
												</select>
											</td>
											<td class="text-left">
												<div class="input-group">
													<input type="text" name="contact_no[]" class="form-control" maxlength="10">
												</div>
											</td>
											<td class="text-right">
												<a href="javascript:;" class="btn btn-danger btn-sm float-end remove"><i class="fa fa-minus-circle"></i></a>
											</td>
										</tr>
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
							
							<!--- Family Information ---->
							<div class="row size-inner-section px-2 py-4">
								<h4 class="header-title">Family Member Information</h4><hr>
								
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="first_name">Name in English</label>
									<input type="text" class="form-control" onKeyPress="return Alpha(event);" id="first_name" name="first_name" maxlength="150" value="" required />
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="employee_arabic_name">Name in Arabic</label>
									<input type="text" class="form-control rtl-input" id="employee_arabic_name" name="employee_arabic_name" maxlength="150" required />
								</div>
								
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="gender">Gender</label>
									<select name="gender" id="gender" class="form-select select2">
										<option value="">Select Gender</option>
										<option value="male">Male</option>
										<option value="female">Female</option>
										<option value="other">Other</option>
									</select>
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="employee_arabic_name">Relationship</label>
									<input type="text" class="form-control" id="employee_arabic_name" name="employee_arabic_name" maxlength="150" />
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="nationality">Nationality</label>
									<select class="form-select select2" name="nationality" id="nationality">
										<option value="">Select Nationality</option>
										<?php foreach($nationalities as $nation) { ?>
										<option value="<?php echo $nation->name; ?>" data-id="<?php echo $nation->id; ?>"><?php echo $nation->name; ?></option>
										<?php } ?>
									</select>
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="marital_status">Marital Status</label>
									<select name="marital_status" id="marital_status" class="form-select select2">
										<option value="">Select Marital Status</option>
										<option value="Single">Single</option>
										<option value="Married">Married</option>
										<option value="Divorced">Divorced</option>
									</select>
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="dob">Date of Birth (Gregorian)</label>
									<input type="date" class="form-control" id="dob" name="dob" max="<?php echo date("Y-m-d"); ?>" />
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="emp_no">ID/Iqama Number</label>
									<input type="text" class="form-control" id="iqama_no" name="iqama_no" minlength="<?= ICAMA_LENGTH ;?>" maxlength="<?= ICAMA_LENGTH ;?>" />
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="iqama_issue_date">ID/Iqama Issue Date (Gregorian)</label>
									<input type="date" class="form-control" id="iqama_issue_date" name="iqama_issue_date" />
								</div>

								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="iqama_expiry_date_hijri">ID/Iqama Expiry Date (Gregorian)</label>
									<input id="iqama_expiry_date_hijri" name="iqama_expiry_date_hijri" class="form-control input-mask" placeholder="dd-mm-yyyy" data-inputmask="'alias': 'datetime'" data-inputmask-inputformat="dd-mm-yyyy">
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="iqama_issue_date_hijri">ID/Iqama Expiry Date (Hijri)</label>
									<input id="iqama_issue_date_hijri" name="iqama_issue_date_hijri" class="form-control input-mask" placeholder="dd-mm-yyyy" data-inputmask="'alias': 'datetime'" data-inputmask-inputformat="dd-mm-yyyy">
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="passport_no">Passport Number</label>
									<input type="text" class="form-control" id="passport_no" name="passport_no" minlength="8" maxlength="<?= PASSPORT_LENGTH;?>" required />
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="iqama_expiry_date_hijri">Passport Expiry Date (Gregorian)</label>
									<input id="iqama_expiry_date_hijri" name="iqama_expiry_date_hijri" class="form-control input-mask" placeholder="dd-mm-yyyy" data-inputmask="'alias': 'datetime'" data-inputmask-inputformat="dd-mm-yyyy">
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="medical_expiry_date">Medical Insurance Expiry Date (Gregorian)</label>
									<input id="medical_expiry_date" name="medical_expiry_date" class="form-control input-mask" placeholder="dd-mm-yyyy" data-inputmask="'alias': 'datetime'" data-inputmask-inputformat="dd-mm-yyyy">
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="insurance_no">Insurance Number</label>
									<input type="text" class="form-control" id="insurance_no" name="insurance_no" required />
								</div>

								<!--- Work Information ---->
								<div class="row size-inner-section px-2 py-4">
									<h4 class="header-title">Work Details</h4>
									<hr>
									<div class="col-md-4 col-sm-12 mb-2 form-group">
										<label for="joining_date">Joining Date (Gregorian)</label>
										<input type="date" class="form-control" id="joining_date" name="joining_date" max="<?php echo date("Y-m-d"); ?>" required />
									</div>
									<div class="col-md-4 col-sm-12 mb-2 form-group">
										<label for="medical_expiry_date">Joining Date (Hijri)</label>
										<input id="medical_expiry_date" name="medical_expiry_date" class="form-control input-mask" placeholder="dd-mm-yyyy" data-inputmask="'alias': 'datetime'" data-inputmask-inputformat="dd-mm-yyyy">
									</div>
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
<script type="text/javascript">
	
	function submitButton() {
		window.onbeforeunload = null;
	}
	
	$(document).ready(function () {
		$('#employee_form').data('initial-state', $('#employee_form').serialize()); // On load save form current state

		// Prevent user from leaving page with inputs with new values
		window.onbeforeunload = function() {
			if ($('#employee_form').serialize() != $('#employee_form').data('initial-state')) {
				return 'You have unsaved changes! If you leave this page, your changes will be lost.';
			}
		};
	});

	function checkDuplicateEmpID() {
		var emp_id = $("#emp_no").val();
		if (emp_id !== "") {
			$.ajax({
				url: "<?php echo base_url();?>admin/hr/master/employee/check-empid",
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
				error: function () {
					$("#emp_no").val('');
					return false;
				},
			});
		} else {
			checkField("emp_no");
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
	
	$('#cv_no').on('change', function(){
		var id = $('#cv_no option:selected').val();
		// alert(id);
		$.ajax({
			url: "<?php echo base_url();?>admin/hr/master/employee/get-cv-detail",
			type: "GET",
			data: {"id" : id},
			success: function (response) {
				//console.log(response);
				$('#employee_info').html(response);
			},
			error: function (response) {
				console.log(response);
				// alert(response);
			},
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

	//Add Family
	var template = $("#family_sections .family-inner-section:first").clone();
	//define counter
	var sectionsCount = 1;
	//add new section
	$("body").on("click", ".addsection", function() {
		//increment
		sectionsCount++;

		//loop through each input
		var section = template
			.clone()
			.find(":input").val("")
			.each(function() {
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
	$("#family_sections").on("click", ".remove", function() {
		//fade out section
		$(this)
			.parent()
			.fadeOut(300, function() {
				//remove parent element (main section)
				$(this).parent().empty();
				return false;
			});
		return false;
	});
</script>
