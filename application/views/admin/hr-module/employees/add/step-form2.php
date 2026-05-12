
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
.tab-inner-section {
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
.employee-profle-pic {
    height: 39px;
    width: 36px;
    background-color: #eaedf1;
    padding: 3px;
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
						<?php $this->load->view('admin/hr-module/employees/components/top-profile-section');?>
						<div class="step-wraper">
							<?php
								$active_step = 2;
								$nav_emp_id = isset($emp_detail->id) ? $emp_detail->id : null;
								$this->load->view('admin/hr-module/employees/components/add_step_navigation', compact('active_step', 'nav_emp_id'));
							?>
						</div>
						<?php echo form_open("admin/hr/employees/update/step-2", array("id" => "employee_form", "enctype" => "multipart/form-data", "class" => "form-label-left", "data-parsley-validate" => "")); ?>
							<input type="hidden" id="id" name="id" value="<?php echo $emp_detail->id;?>" required />
							<!---- Saudi Address ----->
							<div class="row tab-inner-section px-2 py-4">
								<h4 class="header-title">Address in Saudi</h4><hr>
								<?php 
									$saudiAddress = (isset($emp_detail->saudi_address)) ? json_decode($emp_detail->saudi_address) : '';
								?>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="sa_building_no">Building Number</label>
									<input type="text" class="form-control" id="sa_building_no" name="saudi_address[building_no]" value="<?php echo $saudiAddress->building_no;?>" />
								</div>

								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="sa_street_name">Street Name</label>
									<input type="text" class="form-control" id="sa_street_name" name="saudi_address[street_name]" maxlength="100" value="<?php echo $saudiAddress->street_name;?>" />
								</div>

								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="sa_district">District</label>
									<input type="text" class="form-control" id="sa_district" name="saudi_address[district]" maxlength="100" value="<?php echo $saudiAddress->district;?>" />
								</div>

								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="sa_city">City</label>
									<input type="text" class="form-control" id="sa_city" name="saudi_address[city]" maxlength="100" value="<?php echo $saudiAddress->city;?>" />
								</div>

								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="sa_additional_no">Additional Number</label>
									<input type="text" class="form-control" id="sa_additional_no" name="saudi_address[additional_no]" maxlength="100" value="<?php echo $saudiAddress->additional_no;?>" />
								</div>

								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="sa_pin_code">Pin Code</label>
									<input type="text" class="form-control" id="sa_pin_code" name="saudi_address[pin_code]" maxlength="6" value="<?php echo $saudiAddress->pin_code;?>" />
								</div>
							</div>
							<!---- Address in Home Country ----->
							<div class="row tab-inner-section px-2 py-4">
								<h4 class="header-title">Address in Home Country</h4><hr>
								<?php 
									$homeAddress = (isset($emp_detail->home_address)) ? json_decode($emp_detail->home_address) : '';
								?>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="home_address">Address</label>
									<input type="text" class="form-control" id="home_address" name="home_address[address]" value="<?php echo $homeAddress->address;?>" />
								</div>

								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="home_city">Town/City</label>
									<input type="text" class="form-control" id="home_city" name="home_address[city]" maxlength="100" value="<?php echo $homeAddress->city;?>" />
								</div>

								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="home_country">Country</label>
									<select name="home_address[country]" id="home_country" class="form-select select2">
										<option value="">Select Country</option>
										<?php foreach (masterCountries() as $country_list) { ?>
											<option value="<?php echo $country_list->id; ?>" data-id="<?php echo $country_list->id; ?>" <?php echo ($country_list->id == $homeAddress->country) ? ' selected ' : '' ?>><?php echo $country_list->name; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>

							<!---- Emergency Contact Details ----->
							<div class="row tab-inner-section px-2 py-4">
								<h4 class="header-title">Home Land Emergency Contact Details</h4>
								<hr>
								<table id="emergency_sections" class="table table-striped table-bordered table-hover">
									<thead>
										<tr>
											<td class="text-left">Contact Person Name</td>
											<td class="text-left">Contact Person Relationship</td>
											<td class="text-left">Contact Person Mobile</td>
											<td style="width: 5%;"></td>
										</tr>
									</thead>
									<tbody>
										<?php 
											$emergencyContacts = (isset($emp_detail->emergency_contact_detail)) ? json_decode($emp_detail->emergency_contact_detail) : '';
										?>
										<?php 
											$ec_count = 1;
											if(!empty($emergencyContacts)){ 
											foreach($emergencyContacts as $e_contact){ 
										?>
										<tr class="emergency-inner-section">
											<td class="text-left">
												<div class="input-group">
													<input type="text" name="emergency[<?php echo $ec_count;?>][name]" class="form-control" value="<?php echo $e_contact->name;?>" maxlength="100">
												</div>
											</td>
											<td class="text-left" style="width: 30%;">
												<select name="emergency[<?php echo $ec_count;?>][relationship]" class="form-select">
													<option value="">Select Relationship</option>
													<option value="Son" <?php echo ($e_contact->relationship == 'Son') ? ' selected ' : '' ?>>Son</option>
													<option value="Wife" <?php echo ($e_contact->relationship == 'Wife') ? ' selected ' : '' ?>>Wife</option>
													<option value="Daughter" <?php echo ($e_contact->relationship == 'Daughter') ? ' selected ' : '' ?>>Daughter</option>
													<option value="Mother" <?php echo ($e_contact->relationship == 'Mother') ? ' selected ' : '' ?>>Mother</option>
													<option value="Brother" <?php echo ($e_contact->relationship == 'Brother') ? ' selected ' : '' ?>>Brother</option>
													<option value="Sister" <?php echo ($e_contact->relationship == 'Sister') ? ' selected ' : '' ?>>Sister</option>
													<option value="Mother in Law" <?php echo ($e_contact->relationship == 'Mother in Law') ? ' selected ' : '' ?>>Mother in Law</option>
													<option value="Father in Law" <?php echo ($e_contact->relationship == 'Father in Law') ? ' selected ' : '' ?>>Father in Law</option>
													<option value="Uncle" <?php echo ($e_contact->relationship == 'Uncle') ? ' selected ' : '' ?>>Uncle</option>
													<option value="Aunt" <?php echo ($e_contact->relationship == 'Aunt') ? ' selected ' : '' ?>>Aunt</option>
												</select>
											</td>
											<td class="text-left">
												<div class="input-group">
													<input type="text" name="emergency[<?php echo $ec_count;?>][contact_no]" class="form-control" maxlength="10" value="<?php echo $e_contact->contact_no;?>">
												</div>
											</td>
											<td class="text-right">
												<a href="javascript:;" class="btn btn-danger btn-sm float-end remove"><i class="fa fa-minus-circle"></i></a>
											</td>
										</tr>
										<?php $ec_count++;} } ?>
									</tbody>

									<tfoot>
										<tr>
											<td colspan="6" class="text-right">
												<a href="javascript:;" class='btn btn-success btn-sm addemergencysection'><i class="fa fa-plus-circle"></i> Add More</a>
											</td>
										</tr>
									</tfoot>
								</table>
							</div>
							
							<!--- Family Information ---->
							<div class="row tab-inner-section px-2 py-4">
								<h4 class="header-title">Family Member Information</h4><hr>
								<div id="family_sections" class="col-md-12">
									<?php 
										$familyMembers = (isset($emp_detail->family_contact_detail)) ? json_decode($emp_detail->family_contact_detail) : '';
									?>
									<?php 
										$fdc_count = 1;
										if(!empty($familyMembers)){ 
										foreach($familyMembers as $fam_contact){ 
									?>
									<div class="row family-inner-section">
										<div class="col-md-4 col-sm-12 mb-2 form-group">
											<label for="fam_name">Name in English</label>
											<input type="text" class="form-control" onKeyPress="return Alpha(event);" name="family[<?php echo $fdc_count;?>][name]" value="<?php echo $fam_contact->name;?>" maxlength="150" />
										</div>
										<div class="col-md-4 col-sm-12 mb-2 form-group">
											<label for="fam_name_ar">Name in Arabic</label>
											<input type="text" class="form-control rtl-input" name="family[<?php echo $fdc_count;?>][name_ar]" maxlength="150" value="<?php echo $fam_contact->name_ar;?>" />
										</div>
										
										<div class="col-md-4 col-sm-12 mb-2 form-group">
											<label for="fam_gender">Gender</label>
											<select name="family[<?php echo $fdc_count;?>][gender]" class="form-select select2">
												<option value="">Select Gender</option>
												<option value="male" <?php echo ($fam_contact->gender == 'male') ? ' selected ' : '' ?>>Male</option>
												<option value="female" <?php echo ($fam_contact->gender == 'female') ? ' selected ' : '' ?>>Female</option>
												<option value="other" <?php echo ($fam_contact->gender == 'other') ? ' selected ' : '' ?>>Other</option>
											</select>
										</div>
										<div class="col-md-4 col-sm-12 mb-2 form-group">
											<label for="fam_relationship">Relationship</label>
											<input type="text" class="form-control" name="family[<?php echo $fdc_count;?>][relationship]" value="<?php echo $fam_contact->relationship;?>" maxlength="150" />
										</div>
										<div class="col-md-4 col-sm-12 mb-2 form-group">
											<label for="fam_nationality">Nationality</label>
											<select class="form-select select2" name="family[<?php echo $fdc_count;?>][nationality]">
												<option value="">Select Nationality</option>
												<?php foreach(nationalityList() as $nation) { ?>
												<option value="<?php echo $nation->id; ?>" <?php echo ($nation->id == $fam_contact->nationality) ? ' selected ' : '' ?>><?php echo $nation->name; ?></option>
												<?php } ?>
											</select>
										</div>
										<div class="col-md-4 col-sm-12 mb-2 form-group">
											<label for="fam_marital_status">Marital Status</label>
											<select name="family[<?php echo $fdc_count;?>][marital_status]" class="form-select select2">
												<option value="">Select Marital Status</option>
												<option value="Single" <?php echo ($fam_contact->marital_status == 'Single') ? ' selected ' : '' ?>>Single</option>
												<option value="Married" <?php echo ($fam_contact->marital_status == 'Married') ? ' selected ' : '' ?>>Married</option>
												<option value="Divorced" <?php echo ($fam_contact->marital_status == 'Divorced') ? ' selected ' : '' ?>>Divorced</option>
											</select>
										</div>
										<div class="col-md-4 col-sm-12 mb-2 form-group">
											<label for="fam_dob">Date of Birth (Gregorian)</label>
											<input type="date" class="form-control" name="family[<?php echo $fdc_count;?>][dob]" max="<?php echo date("Y-m-d"); ?>" value="<?php echo $fam_contact->dob;?>" />
										</div>
										<div class="col-md-4 col-sm-12 mb-2 form-group">
											<label for="fam_iqama_no">ID/Iqama Number</label>
											<input type="text" class="form-control" name="family[<?php echo $fdc_count;?>][iqama_no]" minlength="<?= ICAMA_LENGTH ;?>" maxlength="<?= ICAMA_LENGTH ;?>" value="<?php echo $fam_contact->iqama_no;?>" />
										</div>
										<div class="col-md-4 col-sm-12 mb-2 form-group">
											<label for="fam_iqama_issue_date">ID/Iqama Issue Date (Gregorian)</label>
											<input type="date" class="form-control" name="family[<?php echo $fdc_count;?>][iqama_issue_date]" value="<?php echo $fam_contact->iqama_issue_date;?>" />
										</div>

										<div class="col-md-4 col-sm-12 mb-2 form-group">
											<label for="fam_iqama_expiry_date">ID/Iqama Expiry Date (Gregorian)</label>
											<input type="date" name="family[<?php echo $fdc_count;?>][iqama_expiry_date]" class="form-control" value="<?php echo $fam_contact->iqama_expiry_date;?>">
										</div>
										<div class="col-md-4 col-sm-12 mb-2 form-group">
											<label for="fam_iqama_issue_date_hijri">ID/Iqama Expiry Date (Hijri)</label>
											<input type="text" name="family[<?php echo $fdc_count;?>][iqama_issue_date_hijri]" class="form-control input-mask" placeholder="dd-mm-yyyy" data-inputmask="'alias': 'datetime'" data-inputmask-inputformat="dd-mm-yyyy" value="<?php echo (isset($fam_contact->iqama_issue_date_hijri) && ($fam_contact->iqama_issue_date_hijri !== '0000-00-00')) ? date('d-m-Y', strtotime($fam_contact->iqama_issue_date_hijri)) : '';?>" />
										</div>
										<div class="col-md-4 col-sm-12 mb-2 form-group">
											<label for="fam_passport_no">Passport Number</label>
											<input type="text" class="form-control" name="family[<?php echo $fdc_count;?>][passport_no]" minlength="8" maxlength="<?= PASSPORT_LENGTH;?>" value="<?php echo $fam_contact->passport_no;?>" />
										</div>
										<div class="col-md-4 col-sm-12 mb-2 form-group">
											<label for="passport_expiry_date">Passport Expiry Date (Gregorian)</label>
											<input type="date" name="family[<?php echo $fdc_count;?>][passport_expiry_date]" class="form-control" value="<?php echo $fam_contact->passport_expiry_date;?>">
										</div>
										<div class="col-md-4 col-sm-12 mb-2 form-group">
											<label for="fam_medical_expiry_date">Medical Insurance Expiry Date (Gregorian)</label>
											<input type="date" name="family[<?php echo $fdc_count;?>][medical_expiry_date]" class="form-control" value="<?php echo $fam_contact->medical_expiry_date;?>">
										</div>
										<div class="col-md-4 col-sm-12 mb-2 form-group">
											<label for="fam_insurance_no">Insurance Number</label>
											<input type="text" class="form-control" name="family[<?php echo $fdc_count;?>][insurance_no]" value="<?php echo $fam_contact->insurance_no;?>" />
										</div>
										<p><a type="button" href="javascript:;" class="btn btn-danger btn-sm remove float-end"><i class="fas fa-minus-square"></i> Remove</a></p>
									</div>
									<?php $fdc_count++;} } ?>
								</div>
								<div class="col-md-12">
								<p><a href="javascript:;" class='btn btn-success btn-sm addfamsection'><i class="fas fa-plus"></i> Add More</a></p>
								</div>
							</div>
							<div class="twitter-bs-wizard">
								<ul class="pager wizard twitter-bs-wizard-pager-link">
									<li class="previous"><a href="<?php echo ($emp_detail->id > 0) ? base_url('admin/hr/employees/edit/step-1/'.$emp_detail->id) : base_url('admin/hr/employees/add/step-1'); ?>" class="btn btn-custom-success"><i class="mdi mdi-arrow-left me-1"></i> Prevoius </a></li>
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

<?php $this->load->view('admin/home/footer');?>

<script type="text/javascript">
	$('.dropify').dropify();

	function submitButton() {
		window.onbeforeunload = null;
	}
	
	$(document).ready(function () {
		$('#employee_form').data('initial-state', $('#employee_form').serialize()); // On load save form current state

		$('#employee_form').on('change input', function () {
			if ($('#employee_form').serialize() !== $('#employee_form').data('initial-state')) {
				window.onbeforeunload = function () {
					return 'You have unsaved changes! If you leave this page, your changes will be lost.';
				};
			} else {
				window.onbeforeunload = null;
			}
		});
	});

	Parsley.addValidator('allselected',
    function (value) {
        return true==(value != '-1')
    });

	function checkField(u){
		var id = $("#"+u).val();
		if(id == ""){
			$("#"+u).addClass("alert_text");
		}
		else{
			$("#"+u).removeClass("alert_text");
		}
	}
	
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

	//Add Emergency Contacts
	
	//define counter
	var ecCount = "<?php echo $ec_count;?>";
	//add new section
	$("body").on("click", ".addemergencysection", function() {
		//increment
		var sectionsCount = ++ecCount;
		var template = `<tr class="emergency-inner-section">
			<td class="text-left">
				<div class="input-group">
					<input type="text" name="emergency[${sectionsCount}][name]" class="form-control" maxlength="100">
				</div>
			</td>
			<td class="text-left" style="width: 30%;">
				<select name="emergency[${sectionsCount}][relationship]" class="form-select">
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
					<input type="text" name="emergency[${sectionsCount}][contact_no]" class="form-control" maxlength="10">
				</div>
			</td>
			<td class="text-right">
				<a href="javascript:;" class="btn btn-danger btn-sm float-end remove"><i class="fa fa-minus-circle"></i></a>
			</td>
		</tr>`;
		//loop through each input
		$('#emergency_sections tbody').append(template);
		return false;
	});

	//remove section
	$("#emergency_sections").on("click", ".remove", function() {
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

	//Add Family Members
	
	//define counter
	var fmCount = "<?php echo $fdc_count;?>"
	//add new section
	$("body").on("click", ".addfamsection", function() {
		//increment
		var memCount = ++fmCount;
		var template2 = `<div class="row family-inner-section">
			<div class="col-md-4 col-sm-12 mb-2 form-group">
				<label for="fam_name">Name in English</label>
				<input type="text" class="form-control" onKeyPress="return Alpha(event);" name="family[${memCount}][name]" maxlength="150" />
			</div>
			<div class="col-md-4 col-sm-12 mb-2 form-group">
				<label for="fam_name_ar">Name in Arabic</label>
				<input type="text" class="form-control rtl-input" name="family[${memCount}][name_ar]" maxlength="150" />
			</div>
			
			<div class="col-md-4 col-sm-12 mb-2 form-group">
				<label for="fam_gender">Gender</label>
				<select name="family[${memCount}][gender]" class="form-select select2">
					<option value="">Select Gender</option>
					<option value="male">Male</option>
					<option value="female">Female</option>
					<option value="other">Other</option>
				</select>
			</div>
			<div class="col-md-4 col-sm-12 mb-2 form-group">
				<label for="fam_relationship">Relationship</label>
				<input type="text" class="form-control" name="family[${memCount}][relationship]" maxlength="150" />
			</div>
			<div class="col-md-4 col-sm-12 mb-2 form-group">
				<label for="fam_nationality">Nationality</label>
				<select class="form-select select2" name="family[${memCount}][nationality]">
					<option value="">Select Nationality</option>
					<?php foreach(nationalityList() as $nation) { ?>
					<option value="<?php echo $nation->id; ?>"><?php echo $nation->name; ?></option>
					<?php } ?>
				</select>
			</div>
			<div class="col-md-4 col-sm-12 mb-2 form-group">
				<label for="fam_marital_status">Marital Status</label>
				<select name="family[${memCount}][marital_status]" class="form-select select2">
					<option value="">Select Marital Status</option>
					<option value="Single">Single</option>
					<option value="Married">Married</option>
					<option value="Divorced">Divorced</option>
				</select>
			</div>
			<div class="col-md-4 col-sm-12 mb-2 form-group">
				<label for="fam_dob">Date of Birth (Gregorian)</label>
				<input type="date" class="form-control" name="family[${memCount}][dob]" max="<?php echo date("Y-m-d"); ?>" />
			</div>
			<div class="col-md-4 col-sm-12 mb-2 form-group">
				<label for="fam_iqama_no">ID/Iqama Number</label>
				<input type="text" class="form-control" name="family[${memCount}][iqama_no]" minlength="<?= ICAMA_LENGTH ;?>" maxlength="<?= ICAMA_LENGTH ;?>" />
			</div>
			<div class="col-md-4 col-sm-12 mb-2 form-group">
				<label for="fam_iqama_issue_date">ID/Iqama Issue Date (Gregorian)</label>
				<input type="date" class="form-control" name="family[${memCount}][iqama_issue_date]" />
			</div>

			<div class="col-md-4 col-sm-12 mb-2 form-group">
				<label for="fam_iqama_expiry_date">ID/Iqama Expiry Date (Gregorian)</label>
				<input type="date" name="family[${memCount}][iqama_expiry_date]" class="form-control">
			</div>
			<div class="col-md-4 col-sm-12 mb-2 form-group">
				<label for="fam_iqama_issue_date_hijri">ID/Iqama Expiry Date (Hijri)</label>
				<input type="text" name="family[${memCount}][iqama_issue_date_hijri]" class="form-control input-mask" placeholder="dd-mm-yyyy" data-inputmask="'alias': 'datetime'" data-inputmask-inputformat="dd-mm-yyyy" />
			</div>
			<div class="col-md-4 col-sm-12 mb-2 form-group">
				<label for="fam_passport_no">Passport Number</label>
				<input type="text" class="form-control" name="family[${memCount}][passport_no]" minlength="8" maxlength="<?= PASSPORT_LENGTH;?>" />
			</div>
			<div class="col-md-4 col-sm-12 mb-2 form-group">
				<label for="passport_expiry_date">Passport Expiry Date (Gregorian)</label>
				<input type="date" name="family[${memCount}][passport_expiry_date]" class="form-control">
			</div>
			<div class="col-md-4 col-sm-12 mb-2 form-group">
				<label for="fam_medical_expiry_date">Medical Insurance Expiry Date (Gregorian)</label>
				<input type="date" name="family[${memCount}][medical_expiry_date]" class="form-control">
			</div>
			<div class="col-md-4 col-sm-12 mb-2 form-group">
				<label for="fam_insurance_no">Insurance Number</label>
				<input type="text" class="form-control" name="family[${memCount}][insurance_no]" />
			</div>
			<p><a type="button" href="javascript:;" class="btn btn-danger btn-sm remove float-end"><i class="fas fa-minus-square"></i> Remove</a></p>
		</div>`;
		$('#family_sections').append(template2);
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
