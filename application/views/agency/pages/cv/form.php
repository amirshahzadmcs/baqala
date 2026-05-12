<?php $this->load->view('agency/layout/header');?>

<style>
	.required-field{
		color: #f00;
	}
	.size-inner-section {
		box-shadow: 0px 1px 4px #c5c5c5;
		border-radius: 5px;
		margin-bottom: 10px;
	}
	.cv-documents{
		border: 1px dashed #a9a9a9;
    	padding: 6px;
		width: 100px;
		height: 100px;
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
		width: 100%;
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
		top: 16px;
		display: none;
	}
	
</style>
<div id="wait"><img src="<?= base_url('images/sample-loader.gif');?>" /><br>Loading..</div>
<!-- start page title -->
<div class="main-content">
    <div class="page-content">
        <!-- start page title -->
		<div class="page-title-box">
			<div class="container-fluid">
				<div class="row align-items-center">
					<div class="col-sm-6">
						<div class="page-title">
							<h4>Manage CV</h4>
							<ol class="breadcrumb m-0">
								<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
								<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>hiring-agency/cv/list">CV's</a></li>
								<li class="breadcrumb-item active">Create / Edit</li>
							</ol>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="float-end d-sm-block">
							<a class="btn btn-sm btn-custom pull-right me-2" title="Back" href="<?php echo base_url(); ?>hiring-agency/cv/list"><i class="fa fa-reply"></i> Back</a>
							<button form="demo-form2" type="submit" class="btn btn-sm btn-custom-success pull-right" title="Save"><i class="fa fa-save"></i> Save</button>
						</div>
						<?php $this->load->view('agency/partials/alert');?>
					</div>
				</div>
			</div>
		</div>
		<!-- end page title -->

		<div class="container-fluid">
			<div class="page-content-wrapper">
				<?php echo form_open("hiring-agency/cv/save", array("id" => "demo-form2", "enctype" => "multipart/form-data", "class" => "form-label-left", "data-parsley-validate" => "")); ?>
				<div class="row">
					<div class="col-12">
						<div class="card">
							<div class="card-body">
								<input type="hidden" id="id" name="id" value="<?php echo $id; ?>" />

								<!-- Tab panes -->
								<div class="tab-content p-3 text-muted">
									<div class="tab-pane active" id="home1" role="tabpanel">
										
										<div class="row size-inner-section px-2 py-4">
											<h4 class="header-title">General Information</h4>
											<hr>
											<div class="col-md-4 col-sm-12 mb-2 form-group">
												<label for="cv_no">CV Number <span class="required-field">*</span></label>
												<?php if(isset($cv_id->id)) { $new_id = $cv_id->id; } else { $new_id = 0; } ?>
												<?php $cv_new = date("Ym") . str_pad($new_id + 1, 4, 0, STR_PAD_LEFT); ?>
												<input type="text" class="form-control" id="cv_no" name="cv_no" maxlength="150" required value="<?php echo !empty($cv_no) ? $cv_no : $cv_new; ?>" readonly />
												<small class="hint">CV Number</small>
											</div>
											<div class="col-md-4 col-sm-12 mb-2 form-group">
												<label for="hiring_type">Hiring Type <span class="required-field">*</span></label>
												<select name="hiring_type" id="hiring_type" class="form-select select2" required data-placeholder="Choose Hiring Type...">
													<option value="Foreign" <?php echo ($hiring_type == 'Foreign') ? 'selected' : '' ?>>Foreign</option>
												</select>
												<small class="hint">Select hiring type</small>
											</div>
											<div class="col-md-4 col-sm-12 mb-2 form-group">
												<label for="applicant_country">Country <span class="required-field">*</span></label>
												<select class="form-select" name="applicant_country" id="applicant_country" required>
													<option value="">Select Country</option>
													<option value="<?php echo $agency_info->country_id; ?>" data-id="<?php echo $agency_info->country_id; ?>" selected><?php echo $agency_info->country_id; ?></option>
												</select>
												<small class="hint">Select Country</small>
											</div>
											<div class="col-md-4 col-sm-12 mb-2 form-group">
												<label for="applicant_type">Applicant Type <span class="required-field">*</span></label>
												<select class="form-select" name="applicant_type" id="applicant_type" required>
													<option value="">Select Type</option>
													<option value="Fresher" <?php echo ($applicant_type == 'Fresher') ? 'selected' : '' ?>>Fresher</option>
													<option value="Saudi Return" <?php echo ($applicant_type == 'Saudi Return') ? 'selected' : '' ?>>Saudi Return</option>
													<option value="GCC Return" <?php echo ($applicant_type == 'GCC Return') ? 'selected' : '' ?>>GCC Return</option>
												</select>
												<small class="hint">Select Applicant Type</small>
											</div>
											
											<div class="col-md-4 col-sm-12 mb-2 form-group">
												<label for="applied_for">Position Applied For <span class="required-field">*</span></label>
												<select name="applied_for" id="applied_for" class="form-select select2" required data-placeholder="Choose Position...">
													<option value="">Select Position</option>
													<?php foreach($positions as $pos) { ?>
														<option value="<?php echo $pos->id; ?>" <?php echo ($pos->id == $applied_for) ? 'selected' : '' ?>><?php echo $pos->name; ?></option>
													<?php } ?>
												</select>
												<small class="hint">Select Applied For</small>
											</div>
											<div class="col-md-4 col-sm-12 mb-2 form-group">
												<label for="documents">Upload Documents</label>
												<input type="file" class="form-control" id="documents" name="documents[]" multiple />
												<div class="col-md-12 mt-2">
													<?php 
														if(count($documents) > 0){ 
														foreach($documents as $cv_doc){
														if($cv_doc['doc_type'] == 'others'){ 
														$file_extension = pathinfo($cv_doc['document'], PATHINFO_EXTENSION);
													?>
													<div class="float-start text-center image-container mt-2 me-2" id="img_<?php echo $cv_doc['id'];?>">
														<img src="<?php echo ($file_extension == 'doc' || $file_extension == 'docx' || $file_extension == 'pdf') ? base_url('images/attached-file.png') : base_url($cv_doc['document']); ?>" class="cv-documents" />
														<div class="overlay"></div>
														<div class="edit"><a href="<?php echo base_url($cv_doc['document']);?>" class="btn btn-primary btn-sm" target="_blank"><i class="fa fa-eye"></i></a> <a type="button" class="btn btn-danger btn-sm remove-cv-image" data-id="<?php echo $cv_doc['id'];?>"><i class="fa fa-trash"></i></a></div>
													</div>
													<?php }}} ?>
												</div>
											</div>
										</div>
										<div class="row size-inner-section px-2 py-4">
											<h4 class="header-title">Profile</h4>
											<hr>
											<div class="col-md-4 col-sm-12 mb-2 form-group">
												<label for="first_name">First Name <span class="required-field">*</span></label>
												<input type="text" class="form-control" onKeyPress="return Alpha(event);" id="first_name" name="first_name" maxlength="150" value="<?php echo $first_name; ?>" required />
												<small class="hint">Enter Person First Name</small>
											</div>
											<div class="col-md-4 col-sm-12 mb-2 form-group">
												<label for="middle_name">Middle Name</label>
												<input type="text" class="form-control" onKeyPress="return Alpha(event);" id="middle_name" name="middle_name" maxlength="150" value="<?php echo $middle_name; ?>" />
												<small class="hint">Enter Person Middle Name</small>
											</div>
											<div class="col-md-4 col-sm-12 mb-2 form-group">
												<label for="third_name">Third Name</label>
												<input type="text" class="form-control" onKeyPress="return Alpha(event);" id="third_name" name="third_name" maxlength="150" value="<?php echo $third_name; ?>" />
												<small class="hint">Enter Person Third Name</small>
											</div>
											<div class="col-md-4 col-sm-12 mb-2 form-group">
												<label for="surname">Surname</label>
												<input type="text" class="form-control" onKeyPress="return Alpha(event);" id="surname" name="surname" maxlength="150" value="<?php echo $surname; ?>" />
												<small class="hint">Enter Person Surname</small>
											</div>
											<div class="col-md-4 col-sm-12 mb-2 form-group">
												<label for="candidate_arabic_name">Candidate Arabic Name <span class="required-field">*</span></label>
												<input type="text" class="form-control rtl-input" id="candidate_arabic_name" name="candidate_arabic_name" maxlength="150" value="<?php echo $candidate_arabic_name; ?>" required />
												<small class="hint">Enter Candidate Arabic Name</small>
											</div>
											<div class="col-md-4 col-sm-12 mb-2 form-group">
												<label for="dob">Date of Birth <span class="required-field">*</span></label>
												<input type="date" class="form-control" id="dob" name="dob" value="<?php echo $dob; ?>" max="<?php echo date("Y-m-d"); ?>" required />
												<small class="hint">Enter Date Of Birth</small>
											</div>
											<div class="col-md-4 col-sm-12 mb-2 form-group">
												<label for="age">Age <span class="required-field">(above 35 not accepted) *</span></label>
												<input type="number" class="form-control" id="age" name="age" value="<?php echo $age; ?>" required />
												<small class="hint">Write remarks if age is above 35.</small>
											</div>
											<div class="col-md-4 col-sm-12 mb-2 form-group">
												<label for="gender">Gender <span class="required-field">*</span></label>
												<select name="gender" id="gender" class="form-select select2" required data-placeholder="Choose Gender...">
													<option value="">Select</option>
													<option value="male" <?php echo ($gender == 'male') ? 'selected' : '' ?>>Male</option>
													<option value="female" <?php echo ($gender == 'female') ? 'selected' : '' ?>>Female</option>
													<option value="other" <?php echo ($gender == 'other') ? 'selected' : '' ?>>Other</option>
												</select>
												<small class="hint">Select Gender</small>
											</div>
											<div class="col-md-4 col-sm-12 mb-2 form-group">
												<label for="marital_status">Marital Status <span class="required-field">*</span></label>
												<select name="marital_status" id="marital_status" class="form-select select2" required data-placeholder="Choose Marital Status...">
													<option value="">Select</option>
													<option value="Single" <?php echo ($marital_status == 'Single') ? 'selected' : '' ?>>Single</option>
													<option value="Married" <?php echo ($marital_status == 'Married') ? 'selected' : '' ?>>Married</option>
													<option value="Divorced" <?php echo ($marital_status == 'Divorced') ? 'selected' : '' ?>>Divorced</option>
												</select>
												<small class="hint">Select Marital Status</small>
											</div>
											<div class="col-md-4 col-sm-12 mb-2 form-group">
												<label for="nationality">Nationality <span class="required-field">*</span></label>
												<select class="form-select" name="nationality" id="nationality" required>
													<option value="">Select Nationality</option>
													<?php foreach($nationalities as $nation) { ?>
													<option value="<?php echo $nation->name; ?>" data-id="<?php echo $nation->id; ?>" <?php echo ($nation->name == $nationality) ? ' selected ' : '' ?>><?php echo $nation->name; ?></option>
													<?php } ?>
												</select>
												<small class="hint">Select Nationality</small>
											</div>
											<div class="col-md-4 col-sm-12 mb-2 form-group">
												<label for="age_remarks">Remarks</label>
												<input type="text" class="form-control" id="age_remarks" name="age_remarks" maxlength="250" value="<?php echo $age_remarks; ?>" />
												<small class="hint">Write remarks if age is above 35.</small>
											</div>
										</div>
										<div class="row size-inner-section px-2 py-4">
											<h4 class="header-title">Homeland Contact Details</h4>
											<hr>
											<div class="col-md-4 col-sm-12 mb-2 form-group">
												<label for="mobile">Mobile No. <span class="required-field">*</span></label>
												<input type="text" onKeyPress="return numerics(event);" class="form-control" id="mobile" name="mobile" value="<?php echo $mobile; ?>" minlength="<?= MOB_LENGTH ;?>" maxlength="<?= MOB_LENGTH ;?>" required />
												<small class="hint">Enter Mobile Number</small>
											</div>
											
											<div class="col-md-4 col-sm-12 mb-2 form-group">
												<label for="imo_available">IMO Available <span class="required-field">*</span></label>
												<select name="imo_available" id="imo_available" class="form-select select2" required>
													<option value="">Select</option>
													<option value="yes" <?php echo ($imo_available == 'yes') ? 'selected' : '' ?>>Yes</option>
													<option value="no" <?php echo ($imo_available == 'no') ? 'selected' : '' ?>>No</option>
												</select>
												<small class="hint">Select 'Yes' if you are on IMO app.</small>
											</div>
											<div class="col-md-4 col-sm-12 mb-2 form-group">
												<label for="email">Personal Email ID</label>
												<input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>" />
												<small class="hint">Enter Email</small>
											</div>
										</div>
										
										<div class="row size-inner-section px-2 py-4">
											<h4 class="header-title">Passport & DL Details</h4>
											<hr>
											<div class="col-md-4 col-sm-12 mb-2 form-group">
												<label for="passport_issue_country">Passport Issue Country <span class="required-field">*</span></label>
												<select name="passport_issue_country" id="passport_issue_country" class="form-select select2" data-placeholder="Choose Passport Issue Country..." required>
													<option value="">Select Country</option>
													<?php foreach($nationalities as $nation) { ?>
														<option value="<?php echo $nation->name; ?>" <?php echo ($nation->name == $passport_issue_country) ? 'selected' : '' ?>><?php echo $nation->name; ?></option>
													<?php } ?>
												</select>
												<small class="hint">Select Country</small>
											</div>
											<div class="col-md-4 col-sm-12 mb-2 form-group">
												<label for="passport_issue_city">Passport Issue City <span class="required-field">*</span></label>
												<input type="text" class="form-control" id="passport_issue_city" name="passport_issue_city" maxlength="100" value="<?php echo $passport_issue_city; ?>" required />
												<small class="hint">Enter passport issue city</small>
											</div>
											<div class="col-md-4 col-sm-12 mb-2 form-group">
												<label for="passport_no">Passport Number <span class="required-field">*</span></label>
												<input type="text" class="form-control" id="passport_no" name="passport_no" minlength="8" maxlength="<?= PASSPORT_LENGTH;?>" value="<?php echo $passport_no; ?>" required />
												<small class="hint">Enter Passport Number</small>
											</div>
											<div class="col-md-4 col-sm-12 mb-2 form-group">
												<label for="passport_exp">Passport Expiry Date <span class="required-field">*</span></label>
												<input type="date" class="form-control" id="passport_exp" name="passport_exp" min="<?php echo date("Y-m-d"); ?>" value="<?php echo $passport_exp; ?>" required />
												<small class="hint">Enter Passport Expiry Date</small>
											</div>
											<div class="col-md-12 col-sm-12 mb-2 form-group">
												<input class="checkbox" type="checkbox" id="dl_available" name="dl_available"<?php echo ($dl_available == 'on') ? 'checked' : '' ?> style="vertical-align: sub;margin-right: 10px;">
												<label class="form-check-label" for="dl_available">
												Do you have Homeland Driving License
												</label>
												<small class="hint"> (Check if you have driving License.)</small>
											</div>
											<div id="dl-container" class="row d-none">
												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="dl_no">Driving License No</label>
													<input type="text" class="form-control" id="dl_no" name="dl_no" minlength="<?= DL_LENGTH ;?>" maxlength="<?= DL_LENGTH ;?>" value="<?= $dl_no; ?>" />
													<small class="hint">Enter driving license no</small>
													<span id="errmsgadhar" class="err-msg"></span>
												</div>
												
												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="dl_expiry">Driving License Expiry</label>
													<input type="date" class="form-control" id="dl_expiry" name="dl_expiry" min="<?php echo date("Y-m-d"); ?>" value="<?= $dl_expiry; ?>" />
													<small class="hint">Enter driving license expiry date</small>
												</div>

												<div class="col-md-4 col-sm-12 mb-2 form-group">
													<label for="dl_documents">Upload DL Documents</label>
													<input type="file" class="form-control" id="dl_documents" name="dl_documents[]" multiple />
													<div class="col-md-12 mt-2">
														<?php 
															if(count($documents) > 0){ 
															foreach($documents as $cv_doc){
															if($cv_doc['doc_type'] == 'dl'){ 
															$file_extension = pathinfo($cv_doc['document'], PATHINFO_EXTENSION);
														?>
														<div class="float-start text-center image-container mt-2 me-2" id="img_<?php echo $cv_doc['id'];?>">
															<img src="<?php echo ($file_extension == 'doc' || $file_extension == 'docx' || $file_extension == 'pdf') ? base_url('images/attached-file.png') : base_url($cv_doc['document']); ?>" class="cv-documents" />
															<div class="overlay"></div>
															<div class="edit"><a href="<?php echo base_url($cv_doc['document']);?>" class="btn btn-primary btn-sm" target="_blank"><i class="fa fa-eye"></i></a> <a type="button" class="btn btn-danger btn-sm remove-cv-image" data-id="<?php echo $cv_doc['id'];?>"><i class="fa fa-trash"></i></a></div>
														</div>
														<?php }}} ?>
													</div>
												</div>
											</div>
											
											<div class="col-md-12 col-sm-12 mb-2 form-group">
												<input class="checkbox" type="checkbox" id="saudi_dl_available" name="saudi_dl_available"<?php echo ($saudi_dl_available == 'on') ? 'checked' : '' ?> style="vertical-align: sub;margin-right: 10px;">
												<label class="form-check-label" for="saudi_dl_available">
												Do you have Saudi/GCC Driving License
												</label>
												<small class="hint"> (Check if you have Saudi driving License.)</small>
											</div>
											<div id="saudi-dl-container" class="row d-none">
												<div class="col-md-4 col-sm-12 mb-2 form-group">
													<label for="dl_type">Driving License Type</label>
													<select name="dl_type" id="dl_type" class="form-select select2">
														<option value="">Select Type</option>
														<option value="Saudi" <?php echo ($dl_type == 'Saudi') ? 'selected' : '' ?>>Saudi</option>
														<option value="GCC" <?php echo ($dl_type == 'GCC') ? 'selected' : '' ?>>GCC</option>
													</select>
												</div>
												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="current_dl">Driving License No</label>
													<input type="text" class="form-control" id="current_dl" name="current_dl" minlength="<?= DL_LENGTH ;?>" maxlength="<?= DL_LENGTH ;?>" value="<?= $current_dl; ?>" />
													<small class="hint">Enter saudi driving license no</small>
													<span id="errmsgadhar" class="err-msg"></span>
												</div>
												
												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="current_dl_expiry">Driving License Expiry</label>
													<input type="date" class="form-control" id="current_dl_expiry" name="current_dl_expiry" min="<?php echo date("Y-m-d"); ?>" value="<?= $current_dl_expiry; ?>" />
													<small class="hint">Enter saudi driving license expiry date</small>
												</div>

												<div class="col-md-4 col-sm-12 mb-2 form-group">
													<label for="saudi_dl_documents">Upload Saudi DL Documents</label>
													<input type="file" class="form-control" id="saudi_dl_documents" name="saudi_dl_documents[]" multiple />
													<div class="col-md-12 mt-2">
														<?php 
															if(count($documents) > 0){ 
															foreach($documents as $cv_doc){
															if($cv_doc['doc_type'] == 'saudi_dl'){ 
															$file_extension = pathinfo($cv_doc['document'], PATHINFO_EXTENSION);
														?>
														<div class="float-start text-center image-container mt-2 me-2" id="img_<?php echo $cv_doc['id'];?>">
															<img src="<?php echo ($file_extension == 'doc' || $file_extension == 'docx' || $file_extension == 'pdf') ? base_url('images/attached-file.png') : base_url($cv_doc['document']); ?>" class="cv-documents" />
															<div class="overlay"></div>
															<div class="edit"><a href="<?php echo base_url($cv_doc['document']);?>" class="btn btn-primary btn-sm" target="_blank"><i class="fa fa-eye"></i></a> <a type="button" class="btn btn-danger btn-sm remove-cv-image" data-id="<?php echo $cv_doc['id'];?>"><i class="fa fa-trash"></i></a></div>
														</div>
														<?php }}} ?>
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
				<?php echo form_close(); ?>
			</div>
		</div>
		<!-- container-fluid -->
	</div>
</div>
<?php $this->load->view('agency/layout/footer');?>

<script type="text/javascript">

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

	$(document).ready( function () {
		hideShowDl();
		hideShowSaudiDl();
		rejecteReason();
		showHideInterview();
	});

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
		//alert(cv_status);
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
			url: "<?php echo base_url(); ?>admin/RecruitmentMaster/getAgency",
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
		var cv_id = "<?php echo $this->input->get('id');?>";
		//alert(size_id);
		if(confirm('Are you sure want to delete?')) {
			if(img_id > 0){
				$.ajax({
					url: "<?php echo base_url('hiring-agency/cv/delete-image');?>",
					type: "POST",
					data: {
						img_id: img_id,
						cv_id: cv_id,
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
</script>
