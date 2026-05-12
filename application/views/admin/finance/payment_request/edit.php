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
						<li class="breadcrumb-item active">Edit</li>
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
						<?php echo form_open("admin/finance/payment-request/update", array("id" => "paymentForm", "enctype" => "multipart/form-data", "class" => "form-label-left", "data-parsley-validate" => "")); ?>
							<input type="hidden" id="id" name="id" value="<?php echo $payment->id; ?>" />

							<div class="row size-inner-section px-2 py-4 mx-1">
								<h4 class="header-title">Payment Information</h4><hr>
								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="method_of_payment">Method of Payment <span class="text-danger">*</span></label>
									<select name="method_of_payment" id="method_of_payment" class="form-select select2" required>
										<option value="">Select Payment Method</option>
										<option value="Bank Transfer" <?php echo ($payment->method_of_payment == 'Bank Transfer') ? 'selected' : ''; ?>>Bank Transfer</option>
										<option value="Cash" <?php echo ($payment->method_of_payment == 'Cash') ? 'selected' : ''; ?>>Cash</option>
										<option value="Cheque" <?php echo ($payment->method_of_payment == 'Cheque') ? 'selected' : ''; ?>>Cheque</option>
										<option value="Wire Transfer" <?php echo ($payment->method_of_payment == 'Wire Transfer') ? 'selected' : ''; ?>>Wire Transfer</option>
									</select>
								</div>
								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="type_of_payment">Type of Payment <span class="text-danger">*</span></label>
									<select name="type_of_payment" id="type_of_payment" class="form-select select2" required>
										<option value="">Select Payment Type</option>
										<option value="Advance Payment" <?php echo ($payment->type_of_payment == 'Advance Payment') ? 'selected' : ''; ?>>Advance Payment</option>
										<option value="Reimbursement" <?php echo ($payment->type_of_payment == 'Reimbursement') ? 'selected' : ''; ?>>Reimbursement</option>
										<option value="Invoice Due" <?php echo ($payment->type_of_payment == 'Invoice Due') ? 'selected' : ''; ?>>Invoice Due</option>
										<option value="Saddad Payment" <?php echo ($payment->type_of_payment == 'Saddad Payment') ? 'selected' : ''; ?>>Saddad Payment</option>
										<option value="Full" <?php echo ($payment->type_of_payment == 'Full') ? 'selected' : ''; ?>>Full</option>
										<option value="Partial" <?php echo ($payment->type_of_payment == 'Partial') ? 'selected' : ''; ?>>Partial</option>
										<option value="Local" <?php echo ($payment->type_of_payment == 'Local') ? 'selected' : ''; ?>>Local</option>
										<option value="International" <?php echo ($payment->type_of_payment == 'International') ? 'selected' : ''; ?>>International</option>
									</select>
								</div>
								<div class="col-md-4 col-sm-12 mb-3 form-group <?php echo ($payment->type_of_payment != 'Partial') ? 'd-none' : ''; ?>" id="partial_percentage_container">
									<label for="partial_percentage">Percentage of Partial Payment <span class="text-danger">*</span></label>
									<div class="input-group mb-3">
									<input type="number" id="partial_percentage" name="partial_percentage" class="form-control" value="<?php echo $payment->partial_percentage; ?>" maxlength="5" aria-describedby="partial-addon2" <?php echo ($payment->type_of_payment == 'Partial') ? 'required' : ''; ?>>
										<div class="input-group-prepend">
											<span class="input-group-text" id="partial-addon2">%</span>
										</div>
									</div>
								</div>

								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="request_for_type">Select Type <span class="text-danger">*</span></label>
									<div style="border: 1px dashed #ccc;padding: 7px;border-radius: 5px;">
										<div class="form-check form-check-inline">
											<input class="form-check-input" type="radio" name="request_for_type" id="request_for_employee" value="employee" <?php echo ($payment->request_for_type == 'employee') ? 'checked' : ''; ?>>
											<label class="form-check-label" for="request_for_employee">Employee</label>
										</div>
										<div class="form-check form-check-inline">
											<input class="form-check-input" type="radio" name="request_for_type" id="request_for_saddad" value="saddad" <?php echo ($payment->request_for_type == 'saddad') ? 'checked' : ''; ?>>
											<label class="form-check-label" for="request_for_saddad">Saddad</label>
										</div>
										<div class="form-check form-check-inline">
											<input class="form-check-input" type="radio" name="request_for_type" id="request_for_vendor" value="vendor" <?php echo ($payment->request_for_type == 'vendor') ? 'checked' : ''; ?>>
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
								<?php
									if($payment->request_for_type == 'employee'){
										$deptDetail = departmentsDetailHelper($payment->department);
										$departName = $deptDetail->name;
									}else{
										$departName = 'No Department Found';
									}
								?>
								<div id="department_container" class="col-md-4 col-sm-12 mb-3 form-group <?php echo ($payment->request_for_type == 'vendor') ? 'd-none' : ''; ?>">
									<label for="department">Department</label>
									<input type="text" id="department_name" class="form-control" value="<?php echo $departName; ?>" readonly>
									<input type="hidden" id="department" name="department" value="<?php echo $payment->department; ?>">
								</div>
								
								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="cost_center">Cost Center</label>
									<input type="text" class="form-control" id="cost_center" name="cost_center" maxlength="150" value="<?php echo $payment->cost_center; ?>" />
								</div>
								
								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="bank_name">Bank Name <span class="text-danger non-req-label">*</span></label>
									<div class="input-group">
										<input type="text" class="form-control" id="bank_name" name="bank_name" maxlength="150" value="<?php echo $payment->bank_name; ?>" required readonly />
										<button type="button" class="btn btn-secondary dropdown-toggle dropdown-toggle-split py-0 d-none" id="bankListBtn" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											<i class="mdi mdi-chevron-down font-size-22"></i>
										</button>
										<div class="dropdown-menu">
											
										</div>
									</div>
								</div>
								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="iban_no">IBAN <span class="text-danger non-req-label">*</span></label>
									<input type="text" class="form-control" id="iban_no" name="iban_no" maxlength="30" value="<?php echo $payment->iban_no; ?>" required readonly />
								</div>

								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="currency">Currency <span class="text-danger">*</span></label>
									<div style="border: 1px dashed #ccc;padding: 7px;border-radius: 5px;">
										<div class="form-check form-check-inline">
											<input class="form-check-input" type="radio" name="currency" id="currency_sar" value="sar" <?php echo ($payment->currency == 'sar') ? 'checked' : ''; ?>>
											<label class="form-check-label" for="currency_sar">SAR</label>
										</div>
										<div class="form-check form-check-inline">
											<input class="form-check-input" type="radio" name="currency" id="currency_usd" value="usd" <?php echo ($payment->currency == 'usd') ? 'checked' : ''; ?>>
											<label class="form-check-label" for="currency_usd">USD</label>
										</div>
										<div class="form-check form-check-inline">
											<input class="form-check-input" type="radio" name="currency" id="currency_inr" value="inr" <?php echo ($payment->currency == 'inr') ? 'checked' : ''; ?>>
											<label class="form-check-label" for="currency_inr">INR</label>
										</div>
									</div>
								</div>

								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="amount">Amount <span class="text-danger">*</span></label>
									<input id="amount" name="amount" class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" inputmode="numeric" value="<?php echo $payment->amount; ?>" style="text-align: right;" required>
								</div>

								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="vendor_reference" id="vendor_label">Vendor Reference</label>
									<input type="text" class="form-control" id="vendor_reference" name="vendor_reference" value="<?php echo $payment->vendor_reference; ?>" maxlength="120" />
								</div>

								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="invoice_no">Quotation / PI / Invoice No</label>
									<input type="text" class="form-control" id="invoice_no" name="invoice_no" value="<?php echo $payment->invoice_no; ?>" maxlength="120" />
								</div>

								<div class="col-md-12 col-sm-12 mb-3 form-group">
									<label for="instructions">Comments/Further Instructions</label>
									<?php
										// Decode the instructions JSON into a PHP array
										$instructions = json_decode($payment->instructions, true);
									?>

									<div class="row">
										<?php for ($i = 0; $i < 3; $i++): ?>
											<div class="col-md-12">
												<div class="input-group mb-3">
													<div class="input-group-prepend">
														<span class="input-group-text" id="basic-addon<?php echo $i + 1; ?>"><?php echo $i + 1; ?>.</span>
													</div>
													<input type="text" class="form-control" id="instructions_<?php echo $i + 1; ?>" name="instructions[]" maxlength="255" aria-describedby="basic-addon<?php echo $i + 1; ?>"
													<?php if (isset($instructions[$i])): ?>
														value="<?php echo htmlspecialchars($instructions[$i]); ?>"
													<?php endif; ?>
													>
												</div>
											</div>
										<?php endfor; ?>
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
										<option value="<?php echo $empList->id;?>" data-req_manager="<?php echo $empList->work_line_manager;?>" data-req_department="<?php echo $empList->department_head;?>" <?php echo ($payment->requester_id == $empList->id) ? 'selected' : ''; ?>><?php echo $empList->emp_no .' - '. $empList->full_name .' ['. $empList->designation_name .']';?></option>
										<?php } ?>
									</select>
								</div>

								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="manager_id">Manager <span class="text-danger">*</span></label>
									<input type="hidden" id="manager_id" name="manager_id" value="<?php echo $payment->manager_id; ?>" required />
									<?php $managerDetail = employeeDetailHelper($payment->manager_id);?>
									<input type="text" class="form-control" id="requester_manager" name="requester_manager" maxlength="150" value="<?php echo $managerDetail->emp_no .' - '. $managerDetail->full_name .' ['. $managerDetail->designation_name .']';?>" required disabled />
								</div>

								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="department_head">Department Head <span class="text-danger">*</span></label>
									<input type="hidden" id="department_head" name="department_head" value="<?php echo $payment->department_head; ?>" required />
									<?php $departmentHeadDetail = employeeDetailHelper($payment->department_head);?>
									<input type="text" class="form-control" id="requester_department_head" name="requester_department_head" maxlength="150" value="<?php echo $departmentHeadDetail->emp_no .' - '. $departmentHeadDetail->full_name .' ['. $departmentHeadDetail->designation_name .']';?>" required disabled />
								</div>
							</div>

							<div class="row size-inner-section px-2 py-4 mx-1">
								<h4 class="header-title">Finance Department</h4><hr>
								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="finance_accountant">Accountant <span class="text-danger">*</span></label>
									<select name="finance_accountant" id="finance_accountant" class="form-select select2" required>
										<option value="">Select Accountant</option>
										<?php foreach(roleWiseEmpListHelper('8', $payment->finance_accountant) as $empList){ ?>
										<option value="<?php echo $empList->id;?>" data-req_manager="<?php echo $empList->work_line_manager;?>" data-req_department="<?php echo $empList->department_head;?>" <?php echo ($payment->finance_accountant == $empList->id) ? 'selected' : ''; ?>><?php echo $empList->emp_no .' - '. $empList->full_name .' ['. $empList->designation_name .']';?></option>
										<?php } ?>
									</select>
								</div>
								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="finance_manager">Finance Manager <span class="text-danger">*</span></label>
									<input type="hidden" class="form-control" id="finance_manager" name="finance_manager" value="<?php echo $payment->finance_manager; ?>" required />
									<?php $financeManagerDetail = employeeDetailHelper($payment->finance_manager);?>
									<input type="text" class="form-control" id="finance_manager_name" name="finance_manager_name" maxlength="120" value="<?php echo $financeManagerDetail->emp_no .' - '. $financeManagerDetail->full_name .' ['. $financeManagerDetail->designation_name .']';?>" required disabled />
								</div>
								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="request_date">Request Date <span class="text-danger">*</span></label>
									<input type="date" class="form-control" id="request_date" name="request_date" max="<?php echo date('Y-m-d');?>" value="<?php echo $payment->request_date; ?>" required />
								</div>
								<!--
								<h4 class="header-title">Payment Details</h4><hr>
								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="finance_Payment_details">Bank <span class="text-danger">*</span></label>
									<div style="border: 1px dashed #ccc;padding: 7px;border-radius: 5px;">
										<div class="form-check form-check-inline">
											<input class="form-check-input" type="radio" name="finance_Payment_bank" id="bank1" value="Al Rajhi" <?php echo ($payment->finance_Payment_bank == 'Al Rajhi') ? 'checked' : ''; ?>>
											<label class="form-check-label" for="bank1">Al Rajhi</label>
										</div>
										<div class="form-check form-check-inline">
											<input class="form-check-input" type="radio" name="finance_Payment_bank" id="bank2" value="STC Bank" <?php echo ($payment->finance_Payment_bank == 'STC Bank') ? 'checked' : ''; ?>>
											<label class="form-check-label" for="bank2">STC Bank</label>
										</div>
										<div class="form-check form-check-inline">
											<input class="form-check-input" type="radio" name="finance_Payment_bank" id="bank3" value="Petty Cash" <?php echo ($payment->finance_Payment_bank == 'Petty Cash') ? 'checked' : ''; ?>>
											<label class="form-check-label" for="bank3">Petty Cash</label>
										</div>
									</div>
								</div>

								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="bank_ref_no">Bank Reference No</label>
									<input type="text" class="form-control" id="bank_ref_no" name="finance_bank_ref" maxlength="120" value="<?php echo $payment->finance_bank_ref; ?>" />
								</div>

								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="finance_payment_date">Bank Payment Date <span class="text-danger">*</span></label>
									<input type="date" class="form-control" id="finance_payment_date" name="finance_payment_date" max="<?php echo date('Y-m-d');?>" value="<?php echo $payment->finance_payment_date; ?>" required />
								</div>

								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="daftra_reference">Daftra Reference</label>
									<input type="text" class="form-control" id="daftra_reference" name="daftra_reference" maxlength="120" value="<?php echo $payment->daftra_reference; ?>" />
								</div>

								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="request_status">Status  <span class="text-danger">*</span></label>
									<select name="request_status" id="request_status" class="form-select select2" required>
										<option value="">Select Status Type</option>
										<option value="new" <?php echo ($payment->request_status == 'new') ? 'selected' : ''; ?>>New</option>
										<option value="processed" <?php echo ($payment->request_status == 'processed') ? 'selected' : ''; ?>>Processed</option>
									</select>
								</div>
								-->
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
$(document).ready(function() {
    updateRequestForIdOptions();
    $('#request_for_id').val("<?php echo $payment->request_for_id; ?>");

    // Payment Type Toggle (Show/hide percentage field)
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

    // Toggle fields based on selected vendor/employee
    function toggleFields() {
        var selectedType = $('input[name="request_for_type"]:checked').val();

        if (selectedType === 'vendor' || selectedType === 'saddad') {
            $('#department_container').addClass('d-none');
            $('#department').removeAttr('required').val('');
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
            $('#vendor_reference_container').removeClass('d-none');
        } else if (selectedType === 'employee') {
            $('#department_container').removeClass('d-none');
            $('#department').attr('required', true);
            $('#vendor_reference_container').addClass('d-none');
			$('#bankListBtn').addClass('d-none');
            $('#vendor_reference').val('');
        }
    }
	
	// Trigger toggleFields when the radio button is changed
	$('input[name="request_for_type"]').on('change', toggleFields);

	// Initial call to set the correct visibility on page load
	toggleFields();

    // AJAX for fetching employee/vendor list
    function updateRequestForIdOptions() {
        var selectedType = $('input[name="request_for_type"]:checked').val();
		var paymentType = $('#type_of_payment').find(':selected').val();
        var selectedUser = '<?php echo $payment->request_for_id;?>';
        $.ajax({
            url: "<?php echo base_url('admin/finance/payment-request/get-employees-vendor'); ?>",
            type: 'POST',
			data: {request_for_type: selectedType, type_of_payment: paymentType},
            dataType: 'json',
            success: function(response) {
                var $select = $('#request_for_id');
                $select.empty();
                
                if (selectedType === 'employee') {
                    $select.append('<option value="">Select Employee</option>');
                    $.each(response, function(index, employee) {
						var isSelected = (selectedUser === employee.id) ? ' selected="selected"' : '';
                        $select.append('<option value="' + employee.id + '" data-department_id="' + employee.department + '" data-department="' + employee.department_name + '"' + isSelected + '>' + employee.emp_no + ' - ' + employee.full_name + ' [' + employee.designation_name + ']</option>');
                    });
                } else if (selectedType === 'vendor' || selectedType === 'saddad') {
                    $select.append('<option value="">Select Vendor</option>');
                    $.each(response, function(index, vendor) {
						var isSelected = (selectedUser === vendor.id) ? ' selected="selected"' : '';
                        $select.append('<option value="' + vendor.id + '"' + isSelected + '>' + vendor.vendor_name + '</option>');
                    });
                }
            },
            error: function() {
                toastr.error('An error occurred while fetching data.');
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
					console.log(response);
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

	// Requester Department & Manager
	function updateRequesterIdOptions() {
		var selectedRequester = $(this).find(':selected').val();
		var selectedReqMan = $(this).find(':selected').data('req_manager'); // Get data-req_manager
		var selectedReqDep = $(this).find(':selected').data('req_department'); // Get data-req_department
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
		
		var selectedAccMan = $('#finance_accountant').find(':selected').data('req_manager'); // Get data-req_manager
		var selectedAccDep = $('#finance_accountant').find(':selected').data('req_department'); // Get data-req_department
		
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
	
	
    // Handle form submission
    $('#paymentForm').submit(function(e) {
        e.preventDefault();
        var formData = new FormData($(this)[0]);
        $.ajax({
            url: '<?php echo base_url('admin/finance/payment-request/update'); ?>',
            type: 'POST',
            data: formData,
            dataType: 'json',
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.type === 'success') {
                    toastr.success(response.message);
                    setTimeout(function() {
                        window.location.href = "<?php echo base_url('admin/finance/payment-request'); ?>";
                    }, 2000);
                } else {
                    toastr.error(response.message);
                }
            },
            error: function() {
                toastr.error('An error occurred. Please try again.');
            }
        });
    });
});

$(document).ready(function() {
    setBankDetails();
});

function setBankDetails() {
	var selectedRequestFor = <?php echo $payment->request_for_id;?>;
	var selectedType = $('input[name="request_for_type"]:checked').val();
	
	console.log('Request: ' + selectedRequestFor + ' Type: ' + selectedType);
	
	if (selectedType && selectedRequestFor) {
		$.ajax({
			url: "<?php echo base_url('admin/finance/payment-request/get-bank-details'); ?>",
			type: 'POST',
			data: { requester_type: selectedType, requester_id: selectedRequestFor },
			dataType: 'json',
			success: function (response) {
				var $dropdownMenu = $('#bankListBtn').next('.dropdown-menu');
				$dropdownMenu.empty();

				if (response.bank_list && response.bank_list.length > 0) {
					$.each(response.bank_list, function(index, bankDetail) {
						var dropdownItem = $('<a class="dropdown-item bank-list-item" type="button">')
							.attr('data-bankname', bankDetail.bank_name)
							.attr('data-iban', bankDetail.iban_no)
							.text(bankDetail.bank_name + ' - ' + bankDetail.iban_no)
							.click(function (e) {
								e.preventDefault();
								$('#bank_name').val(bankDetail.bank_name);
								$('#iban_no').val(bankDetail.iban_no);
							});
						$dropdownMenu.append(dropdownItem);
					});
				} else {
					// Handle case where no bank details are available
					var noItem = $('<a class="dropdown-item" href="#">No bank details available</a>');
					$dropdownMenu.append(noItem);
				}
			},
			error: function () {
				toastr.error('An error occurred while fetching bank details. Please try again.');
			}
		});
	} else {
		console.log("Either requester type or requester ID is missing.");
	}
}

</script>
