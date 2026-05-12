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
.employee-profle-pic {
    height: 39px;
    width: 36px;
    background-color: #eaedf1;
    padding: 3px;
}
/*---- Sidebar ----*/
.modal .modal-dialog-aside{
	width: 30%;
	max-width:80%; height: 100%; margin:0;
	transform: translate(0); transition: transform .2s;
}
#requestTable th:hover {
	background: #e9e9e9;
}

.modal .modal-dialog-aside .modal-content{  height: inherit; border:0; border-radius: 0;}
.modal .modal-dialog-aside .modal-content .modal-body{ overflow-y: auto }
.modal.fixed-left .modal-dialog-aside{ margin-left:auto;  transform: translateX(100%); }
.modal.fixed-right .modal-dialog-aside{ margin-right:auto; transform: translateX(-100%); }

.modal.show .modal-dialog-aside{ transform: translateX(0);  }

/*----- End ------*/
.form-control-plaintext {
	background-color: #fff;
    border: 1px solid #dee2e6;
    padding: 0.375rem 0.75rem;
    border-radius: 0.375rem;
    height: 38px;
    line-height: 26px;
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
											<option value="<?php echo $insPolicy->id; ?>" <?php echo ($insPolicy->id == $emp_info->insurance_policy_no) ? 'selected' : ''; ?>>
												<?php echo $insPolicy->policy_number; ?>
											</option>
										<?php } ?>
									</select>
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="insurance_company_name">Insurance Company Name</label>
									<select class="form-select" name="insurance_company_name" id="insurance_company_name" readonly>
										<option value="">Select Policy No. First</option>
									</select>
								</div>
								
                                <div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="insurance_issue_date">Insurance Issue Date</label>
									<input type="date" class="form-control" id="insurance_issue_date" name="insurance_issue_date" value="<?php echo $emp_info->insurance_issue_date;?>" readonly />
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="insurance_end_date">Insurance End Date</label>
									<input type="date" class="form-control" id="insurance_end_date" name="insurance_end_date" min="" value="<?php echo $emp_info->insurance_end_date;?>" readonly />
								</div>
                                <div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="category">Policy Class</label>
									<select class="form-select" name="category" id="category">
										<option value="">Select Policy No. First</option>
									</select>
								</div>
                                <div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="cost">Cost</label>
									<input type="text" class="form-control" id="cost" name="cost" maxlength="15" value="<?php echo $emp_info->cost;?>" />
								</div>
                                <div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="availability_in_cchi">Availability In CCHI</label>
									<select class="form-select select2" data-parsley-allselected="true" name="availability_in_cchi" id="availability_in_cchi">
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
									<!-- <input type="text" class="form-control" id="contact_duration" name="contact_duration" /> -->
                                    <div class="input-group">
										<input type="hidden" class="form-control" id="old_medical_attachment" name="old_medical_attachment" value="<?php echo $emp_info->medical_attachment;?>">
                                        <input type="file" class="form-control" id="medical_attachment" name="medical_attachment">
                                    </div>
									<?php if(isset($emp_info->medical_attachment)){?>
									<div class="pt-2"><a href="<?php echo base_url($emp_info->medical_attachment); ?>" class="btn btn-link" target="_blank">View Attachment</a></div>
									<?php } ?>
								</div>
							</div>

							<div class="row size-inner-section px-2 py-4 mx-2">
								<h4 class="header-title">Driving License Details <span class="badge rounded-pill bg-success float-end">Primary</span></h4><hr>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="driving_license_number">Driving License Number</label>
									<input type="text" class="form-control" id="driving_license_number" name="driving_license_number" maxlength="55" value="<?php echo $emp_info->driving_license_number;?>" />
								</div>
                                <div class="col-md-4 col-sm-12 mb-2">
									<label for="driving_license_type">Driving License Type</label>
									<select class="form-select select2" data-parsley-allselected="true" name="driving_license_type" id="driving_license_type">
										<option value="">Select Driving License Type</option>
										<?php foreach(licenceTypeHelper() as $insType) { ?>
											<option value="<?php echo $insType->licence_type; ?>" <?php echo ($insType->licence_type == $emp_info->driving_license_type) ? ' selected' : '' ?>><?php echo $insType->licence_type; ?></option>
										<?php } ?>
									</select>
                                </div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="driving_license_issue_country">Driving License Issue Country</label>
									<select class="form-select" name="driving_license_issue_country" id="driving_license_issue_country">
										<option value="">Select Country</option>
										<?php foreach(masterCountries() as $country) { ?>
										<option value="<?php echo $country->id; ?>" data-id="<?php echo $country->id; ?>" <?php echo ($country->id == $emp_info->driving_license_issue_country) ? 'selected' : '' ?>><?php echo $country->name; ?></option>
										<?php } ?>
									</select>
								</div>
                                
                                <div class="col-md-4 col-sm-12 mb-2">
									<label for="driving_license_issue_city">Driving License Issue City</label>
									<select class="form-select select2" data-parsley-allselected="true" name="driving_license_issue_city" id="driving_license_issue_city">
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
								<?php
									// Decode JSON safely
									$secondary_dl_details = [];
									if (!empty($emp_info->secondary_dl_details)) {
										$secondary_dl_details = json_decode($emp_info->secondary_dl_details, true);
									}
								?>
								<?php if (!empty($secondary_dl_details)) {
									foreach ($secondary_dl_details as $index => $dl): ?>
										<div class="col-md-12 mt-3">
											<div class="border rounded p-3 mb-4 bg-light position-relative dl-block" data-dl-index="<?= $index ?>">
												<h6 class="mb-3 text-primary">Driving License #<?= $index + 1 ?></h6>

												<!-- Delete Button -->
												<button type="button" class="btn position-absolute top-0 end-0 m-2 dl-delete-btn" title="Delete"
													data-empid="<?= $emp_detail->id ?>"
													data-index="<?= $index ?>">
													<i class="fa fa-trash text-danger"></i>
												</button>
												
												<div class="row">
													<div class="col-md-6 mb-3">
														<label class="form-label fw-semibold">License Number</label>
														<div class="form-control-plaintext"><?= htmlspecialchars($dl['driving_license_number'] ?? '-') ?></div>
													</div>
													<div class="col-md-6 mb-3">
														<label class="form-label fw-semibold">License Type</label>
														<div class="form-control-plaintext"><?= htmlspecialchars($dl['driving_license_type'] ?? '-') ?></div>
													</div>

													<div class="col-md-6 mb-3">
														<label class="form-label fw-semibold">Issue Country</label>
														<div class="form-control-plaintext"><?= countryDetailHelper($dl['driving_license_issue_country'])->name ?? '' ?></div>
													</div>
													<div class="col-md-6 mb-3">
														<label class="form-label fw-semibold">Issue City</label>
														<div class="form-control-plaintext"><?= cityDetailHelper($dl['driving_license_issue_city'])->city_name ?? '' ?></div>
													</div>

													<div class="col-md-6 mb-3">
														<label class="form-label fw-semibold">Issue Date</label>
														<div class="form-control-plaintext"><?= date('d-m-Y', strtotime($dl['driving_license_issue_date'] ?? '')) ?></div>
													</div>
													<div class="col-md-6 mb-3">
														<label class="form-label fw-semibold">Expiry Date</label>
														<div class="form-control-plaintext"><?= date('d-m-Y', strtotime($dl['driving_license_exp_date'] ?? '')) ?></div>
													</div>
												</div>
											</div>
										</div>
								<?php endforeach; } else { ?>
									<div class="col-md-12 mt-3"><div class="alert alert-warning">No secondary driving license details available.</div></div>
								<?php } ?>

								<?php if(!empty($emp_info->driving_license_number)){ ?>
								<div class="col-md-12">
									<button type="button" class="btn btn-custom-primary btn-sm float-end" data-empid="<?php echo $emp_detail->id;?>" onclick="addSecondaryDl(this)"><i class="fa fa-plus"></i> Add More DL</button>
								</div>
								<?php } ?>
							</div>
						    <div class="row size-inner-section px-2 py-4 mx-2">
								<h4 class="header-title">Driver Card Details</h4><hr>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="driver_card_no">Driver Card Number</label>
									<input type="text" class="form-control" id="driver_card_no" name="driver_card_no" maxlength="55" value="<?php echo $emp_info->driver_card_no;?>" />
								</div>
                                <div class="col-md-4 col-sm-12 mb-2">
									<label for="driver_card_type">Card Type</label>
									<select class="form-select select2" data-parsley-allselected="true" name="driver_card_type" id="driver_card_type">
										<option value="">Select Driver Card Type</option>
										<option value="Temporary" <?php echo ($emp_info->driver_card_type == 'Temporary') ? ' selected' : '' ?>>Temporary</option>
									</select>
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


<div class="modal fade fixed-left dlModal" aria-labelledby="#dlModalFullscreenLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-aside">
        <div class="modal-content">
            
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

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

	$(document).ready(function() {
		var selectedPolicyId = "<?php echo $emp_info->insurance_policy_no ?? ''; ?>";
		var selectedCompanyId = "<?php echo $emp_info->insurance_company_name ?? ''; ?>";
		var selectedCategoryId = "<?php echo $emp_info->category ?? ''; ?>";

		// If there's an existing policy number, load its details for edit mode
		if (selectedPolicyId) {
			loadPolicyDetails(selectedPolicyId, selectedCompanyId, selectedCategoryId);
		}

		// When a new policy is selected, load its details
		$('#insurance_policy_no').change(function() {
			var policy_id = $(this).val();
			loadPolicyDetails(policy_id, null, null);
		});

		function loadPolicyDetails(policy_id, selectedCompany, selectedCategory) {
			$('#insurance_company_name').html('<option value="">Select Policy No. First</option>');
			$('#insurance_issue_date').val('');
			$('#insurance_end_date').val('');
			$('#category').html('<option value="">Select Policy Class</option>');

			if (policy_id > 0) {
				$.ajax({
					url: "<?php echo base_url(); ?>admin/hr-module/employees/Employee/getPolicyDetail",
					data: { policy_id: policy_id },
					dataType: "json",
					type: "POST",
					success: function(data) {
						// Set Insurance Company Name
						var company_input = '<option value="'+data.id+'" '+(data.id == selectedCompany ? 'selected' : '')+'>'+data.company_name+'</option>';
						$('#insurance_company_name').html(company_input);

						// Set Policy Dates
						$('#insurance_issue_date').val(data.policy_date);
						$('#insurance_end_date').val(data.policy_expiry);

						// Populate Policy Class Dropdown
						var classSelectContainer = '<option value="">Select Policy Class</option>';
						if (data.insurance_type_details && data.insurance_type_details.length > 0) {
							$.each(data.insurance_type_details, function(index, insuranceType) {
								var selected = (insuranceType.id == selectedCategory) ? 'selected' : '';
								classSelectContainer += '<option value="'+insuranceType.id+'" '+selected+'>'+insuranceType.insurance_type+'</option>';
							});
						}
						$('#category').html(classSelectContainer);
					}
				});
			}
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

	function addSecondaryDl(identifier) {
		let emp_id = $(identifier).data('empid');

		$.ajax({
			type: "POST",
			url: "<?= base_url('admin/hr-module/employees/Employee/add_secondary_dl_form'); ?>",
			data: {
				'emp_id': emp_id
			},
			dataType: "json",
			success: function (response) {
				if (response.status === 'success') {
					$('.dlModal').modal('show');
					$('.dlModal .modal-content').html(response.html);
					$('#dlModalFullscreenLabel').html('Add New DL');
					// ✅ Initialize Select2 after content is loaded
					$('.dlModal select').select2({
						dropdownParent: $('.dlModal') // Ensures it appears inside modal
					});
				} else {
					toastr.error(response.message);
				}
			},
			error: function (xhr, status, error) {
				console.error("AJAX Error:", error);
				toastr.success("An unexpected error occurred.");
			}
		});
	}

	$(document).on('click', '.dl-delete-btn', function () {
        const $btn = $(this);
        const emp_id = $btn.data('empid');
        const dl_index = $btn.data('index');

        Swal.fire({
            title: 'Are you sure?',
            text: "This DL entry will be deleted permanently.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= base_url('admin/hr/employees/delete-secondary-dl') ?>',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        emp_id: emp_id,
                        dl_index: dl_index
                    },
                    success: function (res) {
                        if (res.status === 'success') {
                            toastr.success(res.message);
                            $btn.closest('.dl-block').remove();
                        } else {
                            toastr.error(res.message);
                        }
                    },
                    error: function () {
                        toastr.error("Something went wrong. Please try again.");
                    }
                });
            }
        });
    });

</script>
