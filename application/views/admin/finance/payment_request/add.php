<?php $this->load->view('admin/home/header');?>
<style>
.size-inner-section {
	box-shadow: 0px 1px 4px #c5c5c5;
	border-radius: 5px;
	margin-bottom: 10px;
}
.form-check-label {
    vertical-align: text-top;
}
.input-group-text{
	line-height: 1.6;
	border-radius: 0rem;
}
</style>
<div id="wait"><i class="fa fa-spinner fa-spin"></i><br>Loading..</div>
<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Payment Request Form</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/finance/payment-request'); ?>">Payment Request</a></li>
						<li class="breadcrumb-item active">Add</li>
					</ol>
				</div>
			</div>
			<?php $admin_id = $this->session->userdata('admin_id');?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
				    <a class="btn btn-sm btn-custom-white pull-right ms-2" title="Back" href="<?php echo base_url('admin/finance/payment-request'); ?>"><i class="fa fa-reply"></i> Back</a>
					<button form="paymentForm" type="submit" class="btn btn-sm btn-custom-success pull-right ms-2" id="formSaveBtn" title="Save"><i class="fa fa-save"></i> Save</button>
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
						<?php echo form_open("admin/sim/submit", array("id" => "paymentForm", "enctype" => "multipart/form-data", "class" => "form-label-left", "data-parsley-validate" => "")); ?>
							<input type="hidden" id="id" name="id" value="" />

							<div class="row size-inner-section px-2 py-4 mx-1">
								<h4 class="header-title">Payment Information</h4><hr>
								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="method_of_payment">Method of Payment <span class="text-danger">*</span></label>
									<select name="method_of_payment" id="method_of_payment" class="form-select select2" required>
										<option value="">Select Payment Method</option>
										<option value="Bank Transfer">Bank Transfer</option>
										<option value="Cash">Cash</option>
										<option value="Cheque">Cheque</option>
										<option value="Wire Transfer">Wire Transfer</option>
									</select>
								</div>
								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="type_of_payment">Type of Payment <span class="text-danger">*</span></label>
									<select name="type_of_payment" id="type_of_payment" class="form-select select2" required>
										<option value="">Select Payment Type</option>
										<option value="Advance Payment">Advance Payment</option>
										<option value="Reimbursement">Reimbursement</option>
										<option value="Invoice Due">Invoice Due</option>
										<option value="Saddad Payment">Saddad Payment</option>
										<option value="Full">Full</option>
										<option value="Partial">Partial</option>
										<option value="Local">Local</option>
										<option value="International">International</option>
									</select>
								</div>
								<div class="col-md-4 col-sm-12 mb-3 form-group d-none" id="partial_percentage_container">
									<label for="partial_percentage">Percentage of Partial Payment <span class="text-danger">*</span></label>
									<div class="input-group mb-3">
										<input type="text" class="form-control" id="partial_percentage" name="partial_percentage" maxlength="5" aria-describedby="partial-addon2">
										<div class="input-group-prepend">
											<span class="input-group-text" id="partial-addon2">%</span>
										</div>
									</div>
								</div>
								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="request_for_type">Select Type <span class="text-danger">*</span></label>
									<div style="border: 1px dashed #ccc;padding: 7px;border-radius: 5px;">
										<div class="form-check form-check-inline">
											<input class="form-check-input" type="radio" name="request_for_type" id="request_for_employee" value="employee">
											<label class="form-check-label" for="request_for_employee">Employee</label>
										</div>
										<div class="form-check form-check-inline">
											<input class="form-check-input" type="radio" name="request_for_type" id="request_for_saddad" value="saddad">
											<label class="form-check-label" for="request_for_saddad">Saddad</label>
										</div>
										<div class="form-check form-check-inline">
											<input class="form-check-input" type="radio" name="request_for_type" id="request_for_vendor" value="vendor">
											<label class="form-check-label" for="request_for_vendor">Vendor</label>
										</div>
									</div>
								</div>
								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="request_for_id">Vendor Name / Employee Name <span class="text-danger">*</span></label>
									<select name="request_for_id" id="request_for_id" class="form-select select2" required>
										<option value="">Select Vendor / Employee</option>
									</select>
								</div>
								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="department">Department <span class="text-danger">*</span></label>
									<input type="hidden" id="department" name="department" required />
									<input type="text" class="form-control" id="department_name" name="department_name" maxlength="150" required disabled />
								</div>
								
								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="cost_center">Cost Center</label>
									<input type="text" class="form-control" id="cost_center" name="cost_center" maxlength="150" />
								</div>
								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="bank_name">Bank Name <span class="text-danger non-req-label">*</span></label>
									<div class="input-group">
										<input type="text" class="form-control" id="bank_name" name="bank_name" maxlength="150" required readonly />
										<button type="button" class="btn btn-secondary dropdown-toggle dropdown-toggle-split py-0 d-none" id="bankListBtn" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											<i class="mdi mdi-chevron-down font-size-22"></i>
										</button>
										<div class="dropdown-menu">
											
										</div>
									</div>
								</div>
								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="iban_no">IBAN <span class="text-danger non-req-label">*</span></label>
									<input type="text" class="form-control" id="iban_no" name="iban_no" maxlength="30" required readonly />
								</div>
								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="currency">Currency <span class="text-danger">*</span></label>
									<div style="border: 1px dashed #ccc;padding: 7px;border-radius: 5px;">
										<div class="form-check form-check-inline">
											<input class="form-check-input" type="radio" name="currency" id="currency_sar" value="sar">
											<label class="form-check-label" for="currency_sar">SAR</label>
										</div>
										<div class="form-check form-check-inline">
											<input class="form-check-input" type="radio" name="currency" id="currency_usd" value="usd">
											<label class="form-check-label" for="currency_usd">USD</label>
										</div>
										<div class="form-check form-check-inline">
											<input class="form-check-input" type="radio" name="currency" id="currency_inr" value="inr">
											<label class="form-check-label" for="currency_inr">INR</label>
										</div>
									</div>
								</div>

								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="amount">Amount <span class="text-danger">*</span></label>
									<input id="amount" name="amount" class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" inputmode="numeric" style="text-align: right;" required>
								</div>

								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="vendor_reference" id="vendor_label">Vendor Reference</label>
									<input type="text" class="form-control" id="vendor_reference" name="vendor_reference" maxlength="120" />
								</div>

								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="invoice_no">Quotation / PI / Invoice No</label>
									<input type="text" class="form-control" id="invoice_no" name="invoice_no" maxlength="120" />
								</div>

								<div class="col-md-12 col-sm-12 mb-3 form-group">
									<label for="instructions">Comments/Further Instructions</label>
									<div class="row">
										<div class="col-md-12">
											<div class="input-group mb-3">
												<div class="input-group-prepend">
													<span class="input-group-text" id="basic-addon1">1.</span>
												</div>
												<input type="text" class="form-control" id="instructions_1" name="instructions[]" maxlength="255" aria-describedby="basic-addon1">
											</div>
										</div>

										<div class="col-md-12">
											<div class="input-group mb-3">
												<div class="input-group-prepend">
													<span class="input-group-text" id="basic-addon2">2.</span>
												</div>
												<input type="text" class="form-control" id="instructions_2" name="instructions[]" maxlength="255" aria-describedby="basic-addon2">
											</div>
										</div>

										<div class="col-md-12">
											<div class="input-group mb-3">
												<div class="input-group-prepend">
													<span class="input-group-text" id="basic-addon3">3.</span>
												</div>
												<input type="text" class="form-control" id="instructions_3" name="instructions[]" maxlength="255" aria-describedby="basic-addon3">
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row size-inner-section px-2 py-4 mx-1">
								<h4 class="header-title">Requester Information</h4><hr>
								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="requester_id">Requester <span class="text-danger">*</span></label>
									<select name="requester_id" id="requester_id" class="form-select select2" required>
										<option value="">Select Requester</option>
										<?php foreach(employeeListHelper() as $empList){ ?>
										<option value="<?php echo $empList->id;?>" data-req_manager="<?php echo $empList->work_line_manager;?>" data-req_department="<?php echo $empList->department_head;?>"><?php echo $empList->emp_no .' - '. $empList->full_name .' ['. $empList->designation_name .']';?></option>
										<?php } ?>
									</select>
								</div>

								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="manager_id">Manager <span class="text-danger">*</span></label>
									<input type="hidden" id="manager_id" name="manager_id" required />
									<input type="text" class="form-control" id="requester_manager" name="requester_manager" maxlength="150" required disabled />
								</div>

								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="department_head">Department Head <span class="text-danger">*</span></label>
									<input type="hidden" id="department_head" name="department_head" required />
									<input type="text" class="form-control" id="requester_department_head" name="requester_department_head" maxlength="150" required disabled />
								</div>
							</div>

							<div class="row size-inner-section px-2 py-4 mx-1">
								<h4 class="header-title">Finance Department</h4><hr>
								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="finance_accountant">Accountant <span class="text-danger">*</span></label>
									<select name="finance_accountant" id="finance_accountant" class="form-select select2" required>
										<option value="">Select Accountant</option>
										<?php foreach(roleWiseEmpListHelper('8') as $empList){ ?>
										<option value="<?php echo $empList->id;?>" data-req_manager="<?php echo $empList->work_line_manager;?>" data-req_department="<?php echo $empList->department_head;?>"><?php echo $empList->emp_no .' - '. $empList->full_name .' ['. $empList->designation_name .']';?></option>
										<?php } ?>
									</select>
								</div>
								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="finance_manager">Finance Manager <span class="text-danger">*</span></label>
									<input type="hidden" class="form-control" id="finance_manager" name="finance_manager" required />
									<input type="text" class="form-control" id="finance_manager_name" name="finance_manager_name" maxlength="120" required disabled />
								</div>
								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="request_date">Request Date <span class="text-danger">*</span></label>
									<input type="date" class="form-control" id="request_date" name="request_date" max="<?php echo date('Y-m-d');?>" required />
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
<script>
	$(document).ready(function () {

		$('#type_of_payment').on('change', function() {
			$('input[name="request_for_type"]').prop('checked', false);
			$('#request_for_id').empty().trigger('change');
			var selectedPaymentType = $(this).val();
			if (selectedPaymentType === 'Partial') {
				$('#partial_percentage_container').removeClass('d-none');
				$('#partial_percentage').attr('required', true);
			} else {
				$('#partial_percentage_container').addClass('d-none');
				$('#partial_percentage').removeAttr('required');
			}
		});

		// Function to toggle visibility based on the selected request_for_type
		function toggleFields() {
			var selectedType = $('input[name="request_for_type"]:checked').val();

			if (selectedType === 'vendor' || selectedType === 'saddad') {
				// Hide department, remove required attribute
				$('#department').closest('.form-group').addClass('d-none');
				$('#department').removeAttr('required');
				$('#department').val('');
				$('#department_name').val('');
				$('#bankListBtn').removeClass('d-none');

				// Show vendor reference
				if(selectedType === 'saddad'){
					$('.non-req-label').html('');
					$('#bank_name').removeAttr('required');
					$('#iban_no').removeAttr('required');
					$('#vendor_label').html('Saddad Refrence');
				}else{
					$('.non-req-label').html('*');
					$('#bank_name').attr('required', true);
					$('#iban_no').attr('required', true);
					$('#vendor_label').html('Vendor Refrence');
				}
				$('#vendor_reference').closest('.form-group').removeClass('d-none');
			} else if (selectedType === 'employee') {
				// Show department, add required attribute
				$('#department').closest('.form-group').removeClass('d-none');
				$('#department').attr('required', true);
				$('.non-req-label').html('*');
				$('#bank_name').attr('required', true);
				$('#iban_no').attr('required', true);
				// Hide vendor reference
				$('#vendor_reference').closest('.form-group').addClass('d-none');
				$('#bankListBtn').addClass('d-none');
				$('#vendor_reference').val('');
			}
		}

		// Trigger toggleFields when the radio button is changed
		$('input[name="request_for_type"]').on('change', toggleFields);

		// Initial call to set the correct visibility on page load
		toggleFields();
	});

	$(document).ready(function () {
		// Function to update request_for_id based on request_for_type selection
		function updateRequestForIdOptions() {
			var selectedType = $('input[name="request_for_type"]:checked').val();
			var paymentType = $('#type_of_payment').find(':selected').val();
			$('#bank_name').val('');
			$('#iban_no').val('');
			$.ajax({
				url: "<?php echo base_url('admin/finance/payment-request/get-employees-vendor');?>",
				type: 'POST',
				data: {request_for_type: selectedType, type_of_payment: paymentType},
				dataType: 'json',
				success: function (response) {
					var $select = $('#request_for_id');
					$select.empty(); // Clear current options

					if (selectedType === 'employee') {
						// Populate select box with employee options
						$select.append('<option value="">Select Employee</option>');
						$.each(response, function (index, employee) {
							$select.append('<option value="' + employee.id + '" data-department_id="' + employee.department + '" data-department="' + employee.department_name + '">' + employee.emp_no + ' - ' + employee.full_name + ' [' + employee.designation_name + ']</option>');
						});
					} else if (selectedType === 'vendor' || selectedType === 'saddad') {
						// Populate select box with vendor options
						$select.append('<option value="">Select Vendor</option>');
						$.each(response, function (index, vendor) {
							$select.append('<option value="' + vendor.id + '">' + vendor.vendor_name + '</option>');
						});
					}
				},
				error: function (errors) {
					toastr.error('An error in fetching '+ selectedType +' list. Please try again.');
				}
			});
		}

		function updateBankDetails(selectedType, selectedRequestFor) {
			if (selectedType) {
				$.ajax({
					url: "<?php echo base_url('admin/finance/payment-request/get-bank-details'); ?>",
					type: 'POST',
					data: { requester_type: selectedType, requester_id: selectedRequestFor },
					dataType: 'json',
					success: function (response) {
						// Set the first bank detail as default
						$('#bank_name').val(response.bank_name);
						$('#iban_no').val(response.iban_no);

						// Populate the dropdown list with additional bank details
						var $dropdownMenu = $('#bankListBtn').next('.dropdown-menu');
						$dropdownMenu.empty(); // Clear current items

						$.each(response.bank_list, function(index, bankDetail) {
							var dropdownItem = $('<a class="dropdown-item bank-list-item" type="button">')
								.attr('data-bankname', bankDetail.bank_name)
        						.attr('data-iban', bankDetail.iban_no)
								.text(bankDetail.bank_name + ' - ' + bankDetail.iban_no)
								.click(function (e) {
									e.preventDefault();
									// Set the clicked bank detail to the inputs
									$('#bank_name').val(bankDetail.bank_name);
									$('#iban_no').val(bankDetail.iban_no);
								});
							$dropdownMenu.append(dropdownItem);
						});
					},
					error: function () {
						toastr.error('An error in fetching bank detail. Please try again.');
					}
				});
			} else {
				$('#bank_name').val('');
				$('#iban_no').val('');
			}
		}


		// Update the department select box based on selected employee
		$('#request_for_id').on('change', function () {
			var selectedRequestFor = $(this).find(':selected').val();
			var selectedType = $('input[name="request_for_type"]:checked').val();
			$('#bank_name').val('');
			$('#iban_no').val('');
			if (selectedType === 'employee') {
				var selectedDepartment = $(this).find(':selected').data('department');
				var selectedDepartmentId = $(this).find(':selected').data('department_id');
				if (selectedDepartment) {
					$('#department').val(selectedDepartmentId);
					$('#department_name').val(selectedDepartment);
				} else {
					$('#department').val('');
					$('#department_name').val('Department Not Found');
				}
			} else if (selectedType === 'vendor' || selectedType === 'saddad') {
				$('#department').val('');
				$('#department_name').val('Department Not Found');
			}
			updateBankDetails(selectedType,selectedRequestFor);
		});

		// Trigger updateRequestForIdOptions when request_for_type is changed
		$('input[name="request_for_type"]').on('change', updateRequestForIdOptions);

		// Initial load call
		updateRequestForIdOptions();

		// Requester Department & Manager
		function updateRequesterIdOptions() {
			var selectedRequester = $(this).find(':selected').val();
			var selectedReqMan = $(this).find(':selected').data('req_manager');
			var selectedReqDep = $(this).find(':selected').data('req_department');
			if (selectedReqMan && selectedReqDep) {
				$.ajax({
					url: "<?php echo base_url('admin/finance/payment-request/get-requester');?>",
					type: 'POST',
					data: {
						manager_id: selectedReqMan, 
						department_head_id: selectedReqDep
					},
					dataType: 'json',
					success: function (response) {
						$('#manager_id').val(selectedReqMan);
						$('#requester_manager').val(response.manager_name.full_name);
						$('#department_head').val(selectedReqDep);
						$('#requester_department_head').val(response.department_head_name.full_name);
					},
					error: function(errors) {
						$('#manager_id').val('');
						$('#requester_manager').val('');
						$('#department_head').val('');
						$('#requester_department_head').val('');
						toastr.error('An error occurred. Please try again.');
					}
				});
			} else {
				$('#manager_id').val('');
				$('#requester_manager').val('');
				$('#department_head').val('');
				$('#requester_department_head').val('');
			}
		}

		// Trigger Requester when requester_id is changed
		$('#requester_id').on('change', updateRequesterIdOptions);

		// Accountant Department & Manager
		function updateAccountantOptions() {
			var selectedAccountant = $('#finance_accountant').find(':selected').val();
			
			var selectedAccMan = $('#finance_accountant').find(':selected').data('req_manager');
			var selectedAccDep = $('#finance_accountant').find(':selected').data('req_department');
			
			if (selectedAccMan && selectedAccDep) {
				$.ajax({
					url: "<?php echo base_url('admin/finance/payment-request/get-requester');?>",
					type: 'POST',
					data: {
						manager_id: selectedAccMan, 
						department_head_id: selectedAccDep
					},
					dataType: 'json',
					success: function(response) {
						if (response && response.manager_name) {
							$('#finance_manager').val(selectedAccMan);
							$('#finance_manager_name').val(response.manager_name.full_name);
						} else {
							$('#finance_manager').val('');
							$('#finance_manager_name').val('');
							toastr.error('Manager name not found.');
						}
					},
					error: function(xhr, status, error) {
						console.error('AJAX Error:', error);
						$('#finance_manager').val('');
						$('#finance_manager_name').val('');
						toastr.error('An error occurred. Please try again.');
					}
				});
			} else {
				$('#finance_manager').val('');
				$('#finance_manager_name').val('');
			}
		}

		// Trigger Requester when requester_id is changed
		$('#finance_accountant').on('change', updateAccountantOptions);

	});

	// Handle form submission
	$('#paymentForm').submit(function(e) {
		e.preventDefault();
		
		// Check if either 'Vendor' or 'Employee' is selected
		var isTypeChecked = $('input[name="request_for_type"]:checked').length > 0;
		var isCurrencyChecked = $('input[name="currency"]:checked').length > 0;

		if (!isTypeChecked) {
			toastr.error('You must select vendor or employee.');
			return;
		}
		if (!isCurrencyChecked) {
			toastr.error('You must select currency type.');
			return;
		}

		var formData = new FormData($(this)[0]);
		$.ajax({
			url: '<?php echo base_url('admin/finance/payment-request/save');?>',
			type: 'POST',
			data: formData,
			dataType: 'json',
			processData: false,
			contentType: false,
			success: function(response) {
				// Handle server response
				if (response.type === 'success') {
					$('formSaveBtn').attr('disabled', true);
					toastr.success(response.message);
					// Redirect after 3 seconds
					setTimeout(function() {
						window.location.href = "<?php echo base_url('admin/finance/payment-request');?>";
					}, 2000); // 3000 milliseconds = 3 seconds
				} else {
					toastr.error(response.message);
				}
			},
			error: function() {
				toastr.error('An error occurred. Please try again.');
			}
		});
	});
</script>
