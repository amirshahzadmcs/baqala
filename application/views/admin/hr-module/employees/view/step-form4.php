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
					<h4>Employee</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/hr/employees'); ?>">Employees</a></li>
						<li class="breadcrumb-item active">Detail</li>
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
								$active_step = 4;
								$nav_emp_id = isset($emp_detail->id) ? $emp_detail->id : null;
								$this->load->view('admin/hr-module/employees/components/view_step_navigation', compact('active_step', 'nav_emp_id'));
							?>
						</div>
						<div class="employee_form">
							<input type="hidden" id="id" name="id" value="<?php echo $emp_detail->id;?>" required />
							<!-- Tab panes -->
							<div class="row size-inner-section px-2 py-4 mx-2">
								<h4 class="header-title">Medical Insurance Details</h4><hr>
								
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="insurance_policy_no">Insurance Policy No</label>
									<input type="text" class="form-control" id="insurance_policy_no" name="insurance_policy_no" maxlength="55" value="<?php echo $emp_info->insurance_policy_no;?>" />
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="insurance_company_name">Insurance Company Name</label>
									<select class="form-control" data-parsley-allselected="true" name="insurance_company_name" id="insurance_company_name">
										<option value="">Select Insurance Company Name</option>
										<?php foreach(insuCompanyHelper() as $insCompany) { ?>
											<option value="<?php echo $insCompany->id; ?>" <?php echo ($insCompany->id == $emp_info->insurance_company_name) ? ' selected' : '' ?>><?php echo $insCompany->company_name; ?></option>
										<?php } ?>
									</select>
								</div>
                                <div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="insurance_issue_date">Insurance Issue Date</label>
									<input type="date" class="form-control" id="insurance_issue_date" name="insurance_issue_date" value="<?php echo $emp_info->insurance_issue_date;?>" />
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="insurance_end_date">Insurance End Date</label>
									<input type="date" class="form-control" id="insurance_end_date" name="insurance_end_date" value="<?php echo $emp_info->insurance_end_date;?>" />
								</div>
                                <div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="category">Policy Class</label>
									<select class="form-select" data-parsley-allselected="true" name="category" id="category">
										<option value="">Select Policy No. First</option>
										<?php foreach(insuTypeHelper() as $insType) { ?>
											<option value="<?php echo $insType->id; ?>" <?php echo ($insType->id == $emp_info->category) ? ' selected' : '' ?>><?php echo $insType->insurance_type; ?></option>
										<?php } ?>
									</select>
								</div>
                                <div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="cost">Cost</label>
									<input type="text" class="form-control" id="cost" name="cost" maxlength="15" value="<?php echo $emp_info->cost;?>" />
								</div>
                                <div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="availability_in_cchi">Availability In CCHI</label>
									<select class="form-control" data-parsley-allselected="true" name="availability_in_cchi" id="availability_in_cchi">
										<option value="">Select Availability In CCHI</option>
										<option value="Yes" <?php echo ($emp_info->availability_in_cchi = 'Yes') ? ' selected' : '' ?>>Yes</option>
										<option value="No" <?php echo ($emp_info->availability_in_cchi = 'No') ? ' selected' : '' ?>>No</option>
									</select>
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="cchi_effective_date">CCHI effective date</label>
									<input type="date" class="form-control" id="cchi_effective_date" name="cchi_effective_date" value="<?php echo $emp_info->cchi_effective_date;?>" />
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="medical_attachment">Attachment</label>
									<?php if(isset($emp_info->medical_attachment)){?>
									<div class="pt-2 border"><a href="<?php echo base_url($emp_info->medical_attachment); ?>" class="btn btn-link" target="_blank">View Attachment</a></div>
									<?php } ?>
								</div>
							</div>

							<div class="row size-inner-section px-2 py-4 mx-2">
								<h4 class="header-title">Driving License Details</h4><hr>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="driving_license_number">Driving License Number</label>
									<input type="text" class="form-control" id="driving_license_number" name="driving_license_number" maxlength="55" value="<?php echo $emp_info->driving_license_number;?>" />
								</div>
                                <div class="col-md-4 col-sm-12 mb-2">
									<label for="driving_license_type">Driving License Type</label>
									<select class="form-control" data-parsley-allselected="true" name="driving_license_type" id="driving_license_type">
										<option value="">Select Driving License Type</option>
										<?php foreach(licenceTypeHelper() as $insType) { ?>
											<option value="<?php echo $insType->licence_type; ?>" <?php echo ($insType->licence_type == $emp_info->driving_license_type) ? ' selected' : '' ?>><?php echo $insType->licence_type; ?></option>
										<?php } ?>
									</select>
                                </div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="driving_license_issue_country">Driving License Issue Country</label>
									<select class="form-control" name="driving_license_issue_country" id="driving_license_issue_country">
										<option value="">Select Country</option>
										<?php foreach(masterCountries() as $country) { ?>
										<option value="<?php echo $country->id; ?>" data-id="<?php echo $country->id; ?>" <?php echo ($country->id == $emp_info->driving_license_issue_country) ? 'selected' : '' ?>><?php echo $country->name; ?></option>
										<?php } ?>
									</select>
								</div>
                                
                                <div class="col-md-4 col-sm-12 mb-2">
									<label for="driving_license_issue_city">Driving License Issue City</label>
									<select class="form-control" data-parsley-allselected="true" name="driving_license_issue_city" id="driving_license_issue_city">
										<option value="">Select Driving License Issue City</option>
										<?php foreach(selectedCitiesHelp($emp_info->driving_license_issue_country) as $cities) { ?>
											<option value="<?php echo $cities->id; ?>" <?php echo ($cities->id == $emp_info->driving_license_issue_city) ? ' selected' : '' ?>><?php echo $cities->city_name; ?></option>
										<?php } ?>
									</select>
                                </div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="driving_license_issue_date">Driving License Issue Date</label>
									<input type="date" class="form-control" id="driving_license_issue_date" name="driving_license_issue_date" value="<?php echo $emp_info->driving_license_issue_date;?>" />
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="driving_license_exp_date">Driving License Expiry Date</label>
									<input type="date" class="form-control" id="driving_license_exp_date" name="driving_license_exp_date" value="<?php echo $emp_info->driving_license_exp_date;?>" />
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="driving_license_exp_date_hijri">Driving License Expiry Date Hijri</label>
									<input id="driving_license_exp_date_hijri" name="driving_license_exp_date_hijri" class="form-control input-mask" placeholder="dd-mm-yyyy" data-inputmask="'alias': 'datetime'" data-inputmask-inputformat="dd-mm-yyyy" value="<?php echo $emp_info->driving_license_exp_date_hijri;?>">
								</div>
							</div>
							
							<div class="row size-inner-section px-2 py-4 mx-2">
								<h4 class="header-title">Driver Card Details</h4><hr>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="driver_card_no">Driver Card Number</label>
									<input type="text" class="form-control" id="driver_card_no" name="driver_card_no" maxlength="55" value="<?php echo $emp_info->driver_card_no;?>" />
								</div>
                                <div class="col-md-4 col-sm-12 mb-2">
									<label for="driver_card_type">Card Type</label>
									<input type="text" class="form-control" id="driver_card_type_input" name="driver_card_type_input" maxlength="55" value="<?php echo $emp_info->driver_card_type;?>" readonly />
                                </div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="driver_card_issue_date">Driver Card Issue Date</label>
									<input type="date" class="form-control" id="driver_card_issue_date" name="driver_card_issue_date" value="<?php echo $emp_info->driver_card_issue_date;?>" />
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="driver_card_expiry_date">Driver Card Expiry Date</label>
									<input type="date" class="form-control" id="driver_card_expiry_date" name="driver_card_expiry_date" value="<?php echo $emp_info->driver_card_expiry_date;?>" />
								</div>
							</div>
							
							<div class="twitter-bs-wizard">
								<ul class="pager wizard twitter-bs-wizard-pager-link">
									<li class="previous"><a href="<?php echo ($emp_detail->id > 0) ? base_url('admin/hr/employees/view/step-3/'.$emp_detail->id) : base_url('admin/hr/employees'); ?>" class="btn btn-custom-secondary"><i class="mdi mdi-arrow-left me-1"></i> Prevoius </a></li>
									<li class="next"><a type="button" href="<?php echo base_url('admin/hr/employees/view/step-5/'.$emp_detail->id);?>" class="btn btn-custom-success">Next Step <i class="mdi mdi-arrow-right ms-1"></i></a></li>
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
	$('.dropify').dropify();
	$('#driving_license_issue_country').change(function() {
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
				var html = '<option value="">Select Driving License Issue City</option>';
				if (Object.keys(data).length > 0) {
					$.each(data, function(index, item) {
						html += '<option value="' + item.id + '" data-id="' + item.id + '">' + item.city_name + '</option>';
					});
				} else {
					var html = '<option value="">No city found</option>';
				}
				$('#driving_license_issue_city').html(html);
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
