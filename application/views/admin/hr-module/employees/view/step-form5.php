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
.bank-detail-left{
	display: flex;
    flex-direction: column;
    justify-content: center;
    width: 50%;
    border-right: 1px solid #ddd;
	padding: 20px;
}
.bank-detail-right{
	display: flex;
    flex-direction: column;
    justify-content: center;
    width: 50%;
	padding: 20px;
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
								$active_step = 5;
								$nav_emp_id = isset($emp_detail->id) ? $emp_detail->id : null;
								$this->load->view('admin/hr-module/employees/components/view_step_navigation', compact('active_step', 'nav_emp_id'));
							?>
						</div>
						<div class="employee_form">
							<input type="hidden" id="id" name="id" value="<?php echo $emp_detail->id;?>" required />
							<!-- Tab panes -->
							
							<div class="row size-inner-section px-2 py-4 mx-2">
								<h4 class="header-title">Payment Details</h4><hr>
                                <div class="col-md-8 col-sm-12 mb-2 form-group">
									<label for="bank_account_type">Payment Type</label>
									<div class="">
										<div class="mb-3">
											<input class="form-check-input" type="radio" value="Cash" <?php echo ($emp_detail->payment_type == 'Cash') ? ' checked ' : '' ?> style="vertical-align: top;margin-right: 3px;">
											<label class="form-check-label">
											Cash
											</label>
											<input class="form-check-input ms-3" type="radio" value="Bank" <?php echo ($emp_detail->payment_type == 'Bank') ? ' checked ' : '' ?> style="vertical-align: top;margin-right: 3px;">
											<label class="form-check-label">
											Bank
											</label>
											<input class="form-check-input ms-3" type="radio" value="Cheque" <?php echo ($emp_detail->payment_type == 'Cheque') ? ' checked ' : '' ?> style="vertical-align: top;margin-right: 3px;">
											<label class="form-check-label">
											Cheque
											</label>
											<input class="form-check-input ms-3" type="radio" value="International Transfer" <?php echo ($emp_detail->payment_type == 'International Transfer') ? ' checked ' : '' ?> style="vertical-align: top;margin-right: 3px;">
											<label class="form-check-label">
											International Transfer
											</label>
											<input class="form-check-input ms-3" type="radio" value="STC Pay" <?php echo ($emp_detail->payment_type == 'STC Pay') ? ' checked ' : '' ?> style="vertical-align: top;margin-right: 3px;">
											<label class="form-check-label">
											STC Pay
											</label>
											<input class="form-check-input ms-3" type="radio" value="" <?php echo ($emp_detail->payment_type == '') ? ' checked ' : '' ?> style="vertical-align: top;margin-right: 3px;">
											<label class="form-check-label">
											None
											</label>
										</div>
									</div>
								</div>
                                <div class="col-md-12 col-sm-12 mb-2 form-group">
									<div id="payment_type_detail">
										<?php 
											$paymentTypeDetail = (isset($emp_detail->payment_type_detail)) ? json_decode($emp_detail->payment_type_detail) : '';
										?>
										<?php if($emp_detail->payment_type == 'Bank'){ ?>
										<div class="row border">
											<h5 class="header-title py-3 border-bottom mb-0">Bank</h5>

											<div class="bank-detail-left">
												<label for="payment_type_detail">Account type for the employee</label>
												<select class="form-control" data-parsley-allselected="true" name="payment_type_detail[account_type]" id="account_type" onchange="getAccType(this)" required>
													<option value="">Select Bank Name</option>
													<option value="Bank Account" <?php echo ($paymentTypeDetail->account_type == 'Bank Account') ? ' selected' : '' ?>>Bank Account</option>
													<option value="Salary Card" <?php echo ($paymentTypeDetail->account_type == 'Salary Card') ? ' selected' : '' ?>>Salary Card</option>
												</select>
											</div>

											<div class="bank-detail-right">
												<?php if($paymentTypeDetail->account_type == 'Bank Account'){?>
												<div class="row">
													<div class="col-md-12 col-sm-12 mb-3">
														<label for="bank_name">Bank Name</label>
														<select class="form-control" data-parsley-allselected="true" name="payment_type_detail[bank_name]" id="bank_name">
															<option value="">Select Bank Name</option>
															<?php foreach(bankList() as $banks) { ?>
																<option value="<?php echo $banks->bank_name; ?>" <?php echo ($banks->bank_name == $paymentTypeDetail->bank_name) ? ' selected' : '' ?>><?php echo $banks->bank_name; ?></option>
															<?php } ?>
														</select>
													</div>
													<div class="col-md-12 col-sm-12 mb-2">
														<label for="iban_no">IBAN No</label>
														<input type="text" class="form-control" id="iban_no" name="payment_type_detail[iban_no]" maxlength="150" value="<?php echo $paymentTypeDetail->iban_no;?>" />
													</div>
												</div>
												<?php } ?>
												<?php if($paymentTypeDetail->account_type == 'Salary Card'){?>
												<div class="row">
													<div class="col-md-12 col-sm-12 mb-3 form-group">
														<label for="salary_bank_name">Bank Name</label>
														<select class="form-control" data-parsley-allselected="true" name="payment_type_detail[salary_bank_name]" id="salary_bank_name">
															<option value="">Select Bank Name</option>
															<?php foreach(bankList() as $banks) { ?>
																<option value="<?php echo $banks->bank_name; ?>" <?php echo ($banks->bank_name == $paymentTypeDetail->salary_bank_name) ? ' selected' : '' ?>><?php echo $banks->bank_name; ?></option>
															<?php } ?>
														</select>
													</div>
													<div class="col-md-12 col-sm-12 mb-2 form-group">
														<label for="salary_card_number">Salary Card Number</label>
														<input type="text" class="form-control" id="salary_card_number" name="payment_type_detail[salary_card_number]" maxlength="35" value="<?php echo $paymentTypeDetail->salary_card_number;?>" />
													</div>
												</div>
												<?php } ?>
											</div>
										</div>
										<?php } ?>
										<?php if($emp_detail->payment_type == 'International Transfer'){ ?>
										<div class="row border">
											<h5 class="header-title py-3 border-bottom mb-3">International Transfer</h5>
											<div class="col-md-4 col-sm-12 mb-2 form-group">
												<label for="int_bank_name">Bank Name</label>
												<input type="text" class="form-control" id="int_bank_name" name="payment_type_detail[bank_name]" maxlength="35" value="<?php echo $paymentTypeDetail->bank_name;?>" required />
											</div>
											<div class="col-md-4 col-sm-12 mb-2 form-group">
												<label for="account_holder">Account Holder Name</label>
												<input type="text" class="form-control" id="account_holder" name="payment_type_detail[account_holder]" maxlength="35" value="<?php echo $paymentTypeDetail->account_holder;?>" required />
											</div>
											<div class="col-md-4 col-sm-12 mb-2 form-group">
												<label for="account_holder_ar">Account Holder Name (Arabic)</label>
												<input type="text" class="form-control" id="account_holder_ar" name="payment_type_detail[account_holder_ar]" maxlength="35" value="<?php echo $paymentTypeDetail->account_holder_ar;?>" />
											</div>
											<div class="col-md-4 col-sm-12 mb-2 form-group">
												<label for="branch_name">Branch Name</label>
												<input type="text" class="form-control" id="branch_name" name="payment_type_detail[branch_name]" maxlength="35" value="<?php echo $paymentTypeDetail->branch_name;?>" required />
											</div>
											<div class="col-md-4 col-sm-12 mb-2 form-group">
												<label for="branch_name_ar">Branch Name (Arabic)</label>
												<input type="text" class="form-control" id="branch_name_ar" name="payment_type_detail[branch_name_ar]" maxlength="35" value="<?php echo $paymentTypeDetail->branch_name_ar;?>" />
											</div>
											<div class="col-md-4 col-sm-12 mb-2 form-group">
												<label for="swift_code">Swift Code</label>
												<input type="text" class="form-control" id="swift_code" name="payment_type_detail[swift_code]" maxlength="35" value="<?php echo $paymentTypeDetail->swift_code;?>" />
											</div>
											<div class="col-md-4 col-sm-12 mb-2 form-group">
												<label for="sort_code">Sort Code</label>
												<input type="text" class="form-control" id="sort_code" name="payment_type_detail[sort_code]" maxlength="35" value="<?php echo $paymentTypeDetail->sort_code;?>" />
											</div>
											<div class="col-md-4 col-sm-12 mb-2 form-group">
												<label for="bank_country">Country</label>
												<select class="form-control" name="payment_type_detail[country]" id="bank_country">
													<option value="">Select Country</option>
													<?php foreach(masterCountries() as $country) { ?>
													<option value="<?php echo $country->name; ?>" data-id="<?php echo $country->id; ?>" <?php echo ($country->name == $paymentTypeDetail->country) ? 'selected' : '' ?> required><?php echo $country->name; ?></option>
													<?php } ?>
												</select>
											</div>
											<div class="col-md-4 col-sm-12 mb-2 form-group">
												<label for="bank_account_no">Account Number</label>
												<input type="text" class="form-control" id="bank_account_no" name="payment_type_detail[account_number]" maxlength="35" value="<?php echo $paymentTypeDetail->account_number;?>" required />
											</div>
											<div class="col-md-4 col-sm-12 mb-2 form-group">
												<label for="bank_iban">IBAN</label>
												<input type="text" class="form-control" id="bank_iban" name="payment_type_detail[iban]" maxlength="35" value="<?php echo $paymentTypeDetail->iban;?>" />
											</div>
										</div>
										<?php } ?>
										<?php if($emp_detail->payment_type == 'STC Pay'){ ?>
										<div class="row border d-none">
											<h5 class="header-title py-3 border-bottom mb-0">STC Pay</h5>

											<div class="bank-detail-left">
												<label for="stc_pay_no">STC Pay Number</label>
												<input type="text" class="form-control" id="stc_pay_no" name="payment_type_detail[stc_pay_no]" maxlength="150" value="<?php echo $paymentTypeDetail->stc_pay_no;?>" required />
											</div>

										</div>
										<?php } ?>
									</div>
								</div>
							</div>

							<div class="row size-inner-section px-2 py-4 mx-2">
								<h4 class="header-title">GOSI Information</h4><hr>
                                <div class="col-md-4 col-sm-12 mb-2">
									<label for="gosi_contract_status">Gosi Contract Status</label>
									<select class="form-control" data-parsley-allselected="true" name="gosi_contract_status" id="gosi_contract_status">
										<option value="">Select Gosi Contract Status</option>
										<option value="active" <?php echo ($emp_info->gosi_contract_status == 'active') ? ' selected' : '' ?>>Active</option>
										<option value="inactive" <?php echo ($emp_info->gosi_contract_status == 'inactive') ? ' selected' : '' ?>>Inactive</option>
									</select>
                                </div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="gosi_contract_sign_date">Gosi Contract Sign Date</label>
									<input type="date" class="form-control" id="gosi_contract_sign_date" name="gosi_contract_sign_date" value="<?php echo $emp_info->gosi_contract_sign_date;?>" />
								</div>
                                <div class="col-md-4 col-sm-12 mb-2">
									<label for="gosi_deductible">Gosi Deductible</label>
									<select class="form-control" data-parsley-allselected="true" name="gosi_deductible" id="gosi_deductible">
										<option value="">Select Gosi Deductible</option>
										<option value="yes" <?php echo ($emp_info->gosi_deductible == 'yes') ? ' selected' : '' ?>>Yes</option>
										<option value="no" <?php echo ($emp_info->gosi_deductible == 'no') ? ' selected' : '' ?>>No</option>
									</select>
                                </div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="gosi_id">GOSI ID</label>
									<input type="text" class="form-control" id="gosi_id" name="gosi_id" maxlength="35" value="<?php echo $emp_info->gosi_id;?>" />
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="employee_share">Employee Share</label>
									<input type="text" class="form-control" id="employee_share" name="employee_share" maxlength="99" value="<?php echo $emp_info->employee_share;?>" />
								</div>
								
							</div>
							<div class="row size-inner-section px-2 py-4 mx-2">
								<h4 class="header-title">QIWA Information</h4><hr>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="qiwa_contract_no">Qiwa Contract No.</label>
									<input type="text" class="form-control" id="qiwa_contract_no" name="qiwa_contract_no" maxlength="35" value="<?php echo $emp_info->qiwa_contract_no;?>" />
								</div>
                                <div class="col-md-4 col-sm-12 mb-2">
									<label for="qiwa_contract_status">Qiwa Contract Status</label>
									<select class="form-control" data-parsley-allselected="true" name="qiwa_contract_status" id="qiwa_contract_status">
										<option value="">Select Gosi Contract Status</option>
										<?php foreach(QiwaStatusHelper() as $qstatus) { ?>
											<option value="<?php echo $qstatus->id; ?>" <?php echo ($qstatus->id == $emp_info->qiwa_contract_status) ? ' selected' : '' ?>><?php echo $qstatus->qiwa_status_name; ?></option>
										<?php } ?>
									</select>
                                </div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="qiwa_contract_sign_date">Qiwa Contract Sign Date</label>
									<input type="date" class="form-control" id="qiwa_contract_sign_date" name="qiwa_contract_sign_date" value="<?php echo $emp_info->qiwa_contract_sign_date;?>" />
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="qiwa_contract_end_date">Qiwa Contract End Date</label>
									<input type="date" class="form-control" id="qiwa_contract_end_date" name="qiwa_contract_end_date" value="<?php echo $emp_info->qiwa_contract_end_date;?>" />
								</div>
							</div>
							<div class="twitter-bs-wizard">
								<ul class="pager wizard twitter-bs-wizard-pager-link">
									<li class="previous"><a href="<?php echo ($emp_detail->id > 0) ? base_url('admin/hr/employees/view/step-4/'.$emp_detail->id) : base_url('admin/hr/employees'); ?>" class="btn btn-custom-secondary"><i class="mdi mdi-arrow-left me-1"></i> Prevoius </a></li>
									<li class="next"><a type="button" href="<?php echo base_url('admin/hr/employees/view/step-6/'.$emp_detail->id);?>" class="btn btn-custom-success">Next Step <i class="mdi mdi-arrow-right ms-1"></i></a></li>
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
	$('input[type=radio][name=bank_account_type]').change(function() {
		var bank_html = '';
		if (this.value == 'Bank') {
			bank_html = `<div class="row border">
						<h5 class="header-title py-3 border-bottom mb-0">Bank</h5>

						<div class="bank-detail-left">
							<label for="account_type">Account type for the employee</label>
							<select class="form-select" data-parsley-allselected="true" name="payment_type_detail[account_type]" id="account_type" onchange="getAccType(this)" required>
								<option value="">Select Bank Name</option>
								<option value="Bank Account">Bank Account</option>
								<option value="Salary Card">Salary Card</option>
							</select>
						</div>

						<div class="bank-detail-right">
							
						</div>
					</div>`;
		}
		else if (this.value == 'International Transfer') {
			bank_html = `<div class="row border">
				<h5 class="header-title py-3 border-bottom mb-3">International Transfer</h5>
				<div class="col-md-4 col-sm-12 mb-2 form-group">
					<label for="int_bank_name">Bank Name</label>
					<input type="text" class="form-control" id="int_bank_name" name="payment_type_detail[bank_name]" maxlength="120" value="" required />
				</div>
				<div class="col-md-4 col-sm-12 mb-2 form-group">
					<label for="account_holder">Account Holder Name</label>
					<input type="text" class="form-control" id="account_holder" name="payment_type_detail[account_holder]" maxlength="120" value="" required />
				</div>
				<div class="col-md-4 col-sm-12 mb-2 form-group">
					<label for="account_holder_ar">Account Holder Name (Arabic)</label>
					<input type="text" class="form-control" id="account_holder_ar" name="payment_type_detail[account_holder_ar]" maxlength="120" value="" />
				</div>
				<div class="col-md-4 col-sm-12 mb-2 form-group">
					<label for="branch_name">Branch Name</label>
					<input type="text" class="form-control" id="branch_name" name="payment_type_detail[branch_name]" maxlength="120" value="" required />
				</div>
				<div class="col-md-4 col-sm-12 mb-2 form-group">
					<label for="branch_name_ar">Branch Name (Arabic)</label>
					<input type="text" class="form-control" id="branch_name_ar" name="payment_type_detail[branch_name_ar]" maxlength="120" value="" />
				</div>
				<div class="col-md-4 col-sm-12 mb-2 form-group">
					<label for="swift_code">Swift Code</label>
					<input type="text" class="form-control" id="swift_code" name="payment_type_detail[swift_code]" maxlength="35" value="" />
				</div>
				<div class="col-md-4 col-sm-12 mb-2 form-group">
					<label for="sort_code">Sort Code</label>
					<input type="text" class="form-control" id="sort_code" name="payment_type_detail[sort_code]" maxlength="35" value="" />
				</div>
				<div class="col-md-4 col-sm-12 mb-2 form-group">
					<label for="bank_country">Country</label>
					<select class="form-select" name="payment_type_detail[country]" id="bank_country" required>
						<option value="">Select Country</option>
						<?php foreach(masterCountries() as $country) { ?>
						<option value="<?php echo $country->name; ?>" data-id="<?php echo $country->id; ?>"><?php echo $country->name; ?></option>
						<?php } ?>
					</select>
				</div>
				<div class="col-md-4 col-sm-12 mb-2 form-group">
					<label for="bank_account_no">Account Number</label>
					<input type="text" class="form-control" id="bank_account_no" name="payment_type_detail[account_number]" maxlength="55" value="" required />
				</div>
				<div class="col-md-4 col-sm-12 mb-2 form-group">
					<label for="bank_iban">IBAN</label>
					<input type="text" class="form-control" id="bank_iban" name="payment_type_detail[iban]" maxlength="55" value="" />
				</div>
			</div>`;
		}
		else if (this.value == 'STC Pay') {
			bank_html = `<div class="row border">
				<h5 class="header-title py-3 border-bottom mb-0">STC Pay</h5>
				<div class="bank-detail-left">
					<label for="stc_pay_no">STC Pay Number</label>
					<input type="text" class="form-control" id="stc_pay_no" name="payment_type_detail[stc_pay_no]" maxlength="55" value="" required />
				</div>
			</div>`;
		}
		$('#payment_type_detail').html(bank_html);
	});

	function getAccType(sel){
		var bank_html2 = '';
		if (sel.value == 'Bank Account') {
			bank_html2 = `<div class="row">
				<div class="col-md-12 col-sm-12 mb-3">
					<label for="bank_name">Bank Name</label>
					<select class="form-select" data-parsley-allselected="true" name="payment_type_detail[bank_name]" id="bank_name">
						<option value="">Select Bank Name</option>
						<?php foreach(bankList() as $banks) { ?>
							<option value="<?php echo $banks->bank_name; ?>"><?php echo $banks->bank_name; ?></option>
						<?php } ?>
					</select>
				</div>
				<div class="col-md-12 col-sm-12 mb-2">
					<label for="iban_no">IBAN No</label>
					<input type="text" class="form-control" id="iban_no" name="payment_type_detail[iban_no]" maxlength="150" value="" />
				</div>
			</div>`;
		}
		else if (sel.value == 'Salary Card') {
			bank_html2 = `<div class="row">
				<div class="col-md-12 col-sm-12 mb-3 form-group">
					<label for="salary_bank_name">Bank Name</label>
					<select class="form-select" data-parsley-allselected="true" name="payment_type_detail[salary_bank_name]" id="salary_bank_name">
						<option value="">Select Bank Name</option>
						<?php foreach(bankList() as $banks) { ?>
							<option value="<?php echo $banks->bank_name; ?>"><?php echo $banks->bank_name; ?></option>
						<?php } ?>
					</select>
				</div>
				<div class="col-md-12 col-sm-12 mb-2 form-group">
					<label for="salary_card_number">Salary Card Number</label>
					<input type="text" class="form-control" id="salary_card_number" name="payment_type_detail[salary_card_number]" maxlength="35" value="" />
				</div>
			</div>`;
		}
		$('.bank-detail-right').html(bank_html2);
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

</script>
