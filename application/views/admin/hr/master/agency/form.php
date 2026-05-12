<?php $this->load->view('admin/home/header');?>
<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Manage Master Agency</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin');?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="javascript: void(0);">Master Agency</a></li>
						<li class="breadcrumb-item active">Edit</li>
					</ol>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="float-end d-none d-sm-block">
					<a class="btn btn-sm btn-custom-white pull-right me-1" title="Back" href="<?php echo base_url('admin/hr/master/agency/list');?>"><i class="fa fa-reply"></i> Back</a>
					<button form="agencyForm" type="submit" class="btn btn-sm btn-custom-success pull-right" title="Save"><i class="fa fa-save"></i> Save</button>
				</div>
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
						<form class="needs-validation" method="POST" action="<?php echo base_url('admin/hr/master/agency/save');?>" enctype="multipart/form-data" id="agencyForm" novalidate>
							<input type="hidden" id="id" name="id" value="">
							<div class="row size-inner-section px-2 py-4">
								<h4 class="header-title">General Information</h4>
								<hr>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="agency_code">Agency Code <span class="text-danger">*</span></label>
									<?php if(isset($agency_id->id)) { $new_id = $agency_id->id; } else { $new_id = 0; } ?>
									<?php $code_new = invoiceNmFormat($new_id+1); ?>
									<input type="text" class="form-control" id="agency_code" name="agency_code" maxlength="10" value="<?php echo !empty($code_new) ? $code_new : ''; ?>" readonly />
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<div class="mb-3">
										<label for="agency_name" class="form-label">Agency Name <span class="text-danger">*</span></label>
										<input type="text" class="form-control" id="agency_name" name="agency_name" required>
										<div class="invalid-feedback">
											Please provide a agency name.
										</div>
									</div>
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<div class="mb-3">
										<label for="agency_name_ar" class="form-label">Agency Name (Arabic)</label>
										<input type="text" class="form-control rtl-input" id="agency_name_ar" name="agency_name_ar" required>
										<div class="invalid-feedback">
											Please provide a agency name in arabic.
										</div>
									</div>
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="country_id">Agency Country <span class="text-danger">*</span></label>
									<select name="country_id" id="country_id" class="form-control select2" required>
										<option value="">Select Country</option>
										<?php foreach(masterCountries() as $nation) { ?>
											<option value="<?php echo $nation->id; ?>"><?php echo $nation->name; ?></option>
										<?php } ?>
									</select>
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<div class="mb-3">
										<label for="agency_city" class="form-label">Agency City <span class="text-danger">*</span></label>
										<input type="text" class="form-control" id="agency_city" name="agency_city" required>
										<div class="invalid-feedback">
											Please provide a agency city.
										</div>
									</div>
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<div class="mb-3">
										<label for="office_licence_no" class="form-label">Office License No <span class="text-danger">*</span></label>
										<input type="text" class="form-control" maxlength="55" id="office_licence_no" name="office_licence_no" required>
									</div>
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="agreement_s_date">Agreement Start Date</label>
									<input type="date" class="form-control" id="agreement_s_date" name="agreement_s_date" min="<?php echo date("Y-m-d"); ?>" />
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="agreement_e_date">Agreement End Date</label>
									<input type="date" class="form-control" id="agreement_e_date" name="agreement_e_date" min="<?php echo date("Y-m-d"); ?>" />
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="user_id">User ID <span class="text-danger">*</span></label>
									<input type="text" class="form-control" onKeyPress="return Alpha(event);" id="user_id" name="user_id" maxlength="150" required />
									<div class="invalid-feedback">
										Enter unique User ID
									</div>
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="password">Password <span class="text-danger">*</span></label>
									<div class="input-group bootstrap-touchspin bootstrap-touchspin-injected">
										<input type="password" id="password" class="form-control" minlength="6" name="password" autocomplete="off" required>
										<span class="input-group-btn input-group-append">
											<button class="btn btn-warning bootstrap-touchspin-up password-show" type="button" id="password_btn" onclick="passwordShow()"><i class="fa fa-eye"></i></button>
										</span>
									</div>
									<div class="invalid-feedback">
										Set password for this account
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group mb-3">
										<label for="status-select" class="form-label">Status <span class="text-danger">*</span></label>
										<select class="form-select" name="status" id="status-select" required>
											<option value="">--- Select Status ---</option>
											<option value="1">Active</option>
											<option value="2">Inactive</option>
											<option value="3">Contract Expired</option>
											<option value="4">Suspended</option>
										</select>
									</div>
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="upload_signed_contract">Upload Signed Contract</label>
									<input type="file" class="form-control" id="upload_signed_contract" name="upload_signed_contract" />
								</div>
							</div>
							
							<div class="row size-inner-section px-2 py-4">
								<h4 class="header-title">Contact Details</h4>
								<hr>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="contact_person_1">Name <span class="text-danger">*</span></label>
									<input type="text" class="form-control" onKeyPress="return Alpha(event);" id="contact_person_1" name="contact_person_1" maxlength="150" required />
									<p class="hint">Enter Person Name</p>
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="mobile_no_1">Mobile No. <span class="text-danger">*</span></label>
									<input type="text" onKeyPress="return numerics(event);" class="form-control" id="mobile_no_1" name="mobile_no_1" minlength="<?= MOB_LENGTH ;?>" maxlength="<?= MOB_LENGTH ;?>" required />
									<p class="hint">Enter Mobile Number</p>
								</div>
								
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="email_id_1">Email ID <span class="text-danger">*</span></label>
									<input type="email_id_1" class="form-control" id="email_id_1" name="email_id_1" required />
									<p class="hint">Enter Email</p>
								</div>
								
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="contact_person_2">Name</label>
									<input type="text" class="form-control" onKeyPress="return Alpha(event);" id="contact_person_2" name="contact_person_2" maxlength="150" />
									<p class="hint">Enter Person Name</p>
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="mobile_no_2">Mobile No.</label>
									<input type="text" onKeyPress="return numerics(event);" class="form-control" id="mobile_no_2" name="mobile_no_2" minlength="<?= MOB_LENGTH ;?>" maxlength="<?= MOB_LENGTH ;?>" />
									<p class="hint">Enter Mobile Number</p>
								</div>
								
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="email_id_2">Email ID </label>
									<input type="email_id_2" class="form-control" id="email_id_2" name="email_id_2" />
									<p class="hint">Enter Email</p>
								</div>
							</div>
							<div class="row size-inner-section px-2 py-4">
								<h4 class="header-title">Bank Details</h4>
								<hr>
								<div class="col-md-4 mb-3 form-group">
									<label for="account_name">Account Holder Name </label>
									<input type="text" class="form-control" id="account_name" name="account_name" maxlength="150" />
								</div>
								<div class="col-md-4 mb-3 form-group">
									<label for="bank_name">Bank Name </label>
									<input type="text" class="form-control" id="bank_name" name="bank_name" maxlength="150" />
								</div>
								<div class="col-md-4 mb-3 form-group">
									<label for="account_no">Bank Account No </label>
									<input type="text" class="form-control" id="account_no" name="account_no" onkeypress="return numerics(event);" maxlength="<?= BANK_ACCOUNT; ?>" />
								</div>
								<div class="col-md-4 mb-3 form-group">
									<label for="ifsc_code">IFSC Code </label>
									<input type="text" class="form-control" id="ifsc_code" name="ifsc_code" />
								</div>
								<div class="col-md-4 mb-3 form-group">
									<label for="swift_code">Swift Code </label>
									<input type="text" class="form-control" id="swift_code" name="swift_code" />
								</div>
								
								<div class="col-md-4 mb-3 form-group">
									<label for="bank_address">Bank Address </label>
									<input type="text" class="form-control" id="bank_address" name="bank_address" maxlength="300" />
								</div>
								
							</div>
							
						</form>

					</div>
				</div>
			</div> <!-- end col -->
		</div> <!-- end row -->
	</div>
</div>
<!-- container-fluid -->

<?php $this->load->view('admin/home/footer');?>
