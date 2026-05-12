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
.employee-profle-pic {
    height: 39px;
    width: 36px;
    background-color: #eaedf1;
    padding: 3px;
}
.twitter-bs-wizard .twitter-bs-wizard-pager-link li a {
    display: inline-block;
    padding: 0.47rem 0.75rem;
	color: #222;
    background-color: #e9e9e9 !important;
    border-color: #efefef;
    box-shadow: 2px 2px 3px #525252;
    border-radius: 0.25rem;
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
							<?php
								$active_step = 4;
								$nav_emp_id = isset($emp_detail->id) ? $emp_detail->id : null;
								$this->load->view('admin/hr-module/employees/components/add_step_navigation', compact('active_step', 'nav_emp_id'));
							?>
						</div>
						<?php echo form_open("admin/hr/employees/update/step-4", array("id" => "employee_form", "enctype" => "multipart/form-data", "class" => "form-label-left", "data-parsley-validate" => "")); ?>
							<input type="hidden" id="id" name="id" value="<?php echo $emp_detail->id;?>" required />
							<!-- Tab panes -->
							<div class="row size-inner-section px-2 py-4 mx-2">
								<h4 class="header-title">Medical Insurance Details</h4><hr>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="insurance_policy_no">Select Insurance Policy No</label>
									<select class="form-select select2" data-parsley-allselected="true" name="insurance_policy_no" id="insurance_policy_no">
										<option value="">Select Policy No.</option>
										<?php foreach(empPolicyList() as $insPolicy) { ?>
											<option value="<?php echo $insPolicy->id; ?>"><?php echo $insPolicy->policy_number; ?></option>
										<?php } ?>
									</select>
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="insurance_company_name">Insurance Company Name</label>
									<select class="form-control" data-parsley-allselected="true" name="insurance_company_name" id="insurance_company_name" readonly>
										<option value="">Select Policy No. First</option>
									</select>
								</div>
								
                                <div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="insurance_issue_date">Insurance Issue Date</label>
									<input type="date" class="form-control" id="insurance_issue_date" name="insurance_issue_date" readonly />
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="insurance_end_date">Insurance End Date</label>
									<input type="date" class="form-control" id="insurance_end_date" name="insurance_end_date" min="" value="<?php echo $emp_info->insurance_end_date;?>" readonly />
								</div>
                                <div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="category">Policy Class</label>
									<select class="form-select" data-parsley-allselected="true" name="category" id="category">
										<option value="">Select Policy No. First</option>
									</select>
								</div>
                                <div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="cost">Cost</label>
									<input type="text" class="form-control" id="cost" name="cost" maxlength="15" />
								</div>
                                <div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="availability_in_cchi">Availability In CCHI</label>
									<select class="form-select select2" data-parsley-allselected="true" name="availability_in_cchi" id="availability_in_cchi">
										<option value="">Select Availability In CCHI</option>
										<option value="Yes">Yes</option>
										<option value="No">No</option>
									</select>
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="cchi_effective_date">CCHI effective date</label>
									<input type="date" class="form-control" id="cchi_effective_date" name="cchi_effective_date" />
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="medical_attachment">Attachment</label>
									<!-- <input type="text" class="form-control" id="contact_duration" name="contact_duration" /> -->
                                    <div class="input-group">
										<input type="hidden" class="form-control" id="old_medical_attachment" name="old_medical_attachment">
                                        <input type="file" class="form-control" id="medical_attachment" name="medical_attachment">
                                    </div>
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
									<select class="form-select select2" data-parsley-allselected="true" name="driving_license_type" id="driving_license_type">
										<option value="">Select Driving License Type</option>
										<?php foreach(licenceTypeHelper() as $insType) { ?>
											<option value="<?php echo $insType->licence_type; ?>"><?php echo $insType->licence_type; ?></option>
										<?php } ?>
									</select>
                                </div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="driving_license_issue_country">Driving License Issue Country</label>
									<select class="form-select" name="driving_license_issue_country" id="driving_license_issue_country">
										<option value="">Select Country</option>
										<?php foreach(masterCountries() as $country) { ?>
										<option value="<?php echo $country->id; ?>" data-id="<?php echo $country->id; ?>"><?php echo $country->name; ?></option>
										<?php } ?>
									</select>
								</div>
                                
                                <div class="col-md-4 col-sm-12 mb-2">
									<label for="driving_license_issue_city">Driving License Issue City</label>
									<select class="form-select select2" data-parsley-allselected="true" name="driving_license_issue_city" id="driving_license_issue_city">
										<option value="">Select Driving License Issue City</option>
										<?php foreach(selectedCitiesHelp($emp_info->driving_license_issue_country) as $cities) { ?>
											<option value="<?php echo $cities->id; ?>"><?php echo $cities->city_name; ?></option>
										<?php } ?>
									</select>
                                </div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="driving_license_issue_date">Driving License Issue Date</label>
									<input type="date" class="form-control" id="driving_license_issue_date" name="driving_license_issue_date" />
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="driving_license_exp_date">Driving License Expiry Date</label>
									<input type="date" class="form-control" id="driving_license_exp_date" name="driving_license_exp_date" />
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="driving_license_exp_date_hijri">Driving License Expiry Date Hijri</label>
									<input id="driving_license_exp_date_hijri" name="driving_license_exp_date_hijri" class="form-control input-mask" placeholder="dd-mm-yyyy" data-inputmask="'alias': 'datetime'" data-inputmask-inputformat="dd-mm-yyyy">
								</div>
							</div>
							<div class="row size-inner-section px-2 py-4 mx-2">
								<h4 class="header-title">Driver Card Details</h4><hr>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="driver_card_no">Driver Card Number</label>
									<input type="text" class="form-control" id="driver_card_no" name="driver_card_no" maxlength="55" />
								</div>
                                <div class="col-md-4 col-sm-12 mb-2">
									<label for="driver_card_type">Card Type</label>
									<select class="form-select select2" data-parsley-allselected="true" name="driver_card_type" id="driver_card_type">
										<option value="">Select Driver Card Type</option>
										<option value="Temporary">Temporary</option>
									</select>
                                </div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="driver_card_issue_date">Driver Card Issue Date</label>
									<input type="date" class="form-control" id="driver_card_issue_date" name="driver_card_issue_date" />
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="driver_card_expiry_date">Driver Card Expiry Date</label>
									<input type="date" class="form-control" id="driver_card_expiry_date" name="driver_card_expiry_date" />
								</div>
							</div>
							<div class="twitter-bs-wizard">
								<ul class="pager wizard twitter-bs-wizard-pager-link">
									<li class="previous"><a href="<?php echo ($emp_detail->id > 0) ? base_url('admin/hr/employees/add/step-3/'.$emp_detail->id) : base_url('admin/hr/employees/add/step-1'); ?>" class="btn btn-custom-success"><i class="mdi mdi-arrow-left me-1"></i> Prevoius </a></li>
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

		// Prevent user from leaving page with inputs with new values
		window.onbeforeunload = function() {
			if ($('#employee_form').serialize() != $('#employee_form').data('initial-state')) {
				return 'You have unsaved changes! If you leave this page, your changes will be lost.';
			}
		};
	});

	Parsley.addValidator('allselected',
    function (value) {
        return true==(value != '-1')
    });

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

	$('#insurance_policy_no').change(function() {
		var policy_id = $(this).find('option:selected').val();
		$('#insurance_company_name').html('<option value="">Select Policy No. First</option>');
		$('#insurance_issue_date').val('');
		$('#insurance_end_date').val('');
		$('#category').html('<option value="">Select Policy Class</option>');
		if(policy_id > 0){
			$.ajax({
				url: "<?php echo base_url(); ?>admin/hr-module/employees/Employee/getPolicyDetail",
				data: {
					policy_id: policy_id
				},
				dataType: "json",
				type: "POST",
				success: function(data) {
					//console.log(data);

					// Update company name
					var company_input = '<option value="'+data.id+'">'+data.company_name+'</option>';
					$('#insurance_company_name').html(company_input);

					// Update policy dates
					$('#insurance_issue_date').val(data.policy_date);
					$('#insurance_end_date').val(data.policy_expiry);

					// Update policy class dropdown
					var classSelectContainer = '<option value="">Select Policy Class</option>';
					if (data.insurance_type_details && data.insurance_type_details.length > 0) {
						$.each(data.insurance_type_details, function(index, insuranceType) {
							classSelectContainer += '<option value="'+insuranceType.id+'">'+insuranceType.insurance_type+'</option>';
						});
					}
					$('#category').html(classSelectContainer);
				}
			});
		}
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

	function validateInsDates() {
		$('#insurance_end_date').val('');
        var startDate = $('#insurance_issue_date').val();
        var endDateInput = document.getElementById("insurance_end_date");
        endDateInput.min = startDate;
        return true;
    }

</script>
