
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
	.cv-documents{
		border: 1px dashed #a9a9a9;
		padding: 6px;
		width: 140px;
		height: 150px;
	}
	.cv-documents p{
		margin-top: 3%;
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
		bottom: 0;
		width: 140px;
    	height: 150px;
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
		top: 30%;
		display: none;
	}
	a.document:hover {
		color: darkgreen;
	}
</style>
<div id="wait"><i class="fa fa-spinner fa-spin"></i><br>Updating..</div>
<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Edit Property</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/facility-management/property/list'); ?>">Facility Management</a></li>
						<li class="breadcrumb-item active">Edit Property</li>
					</ol>
				</div>
			</div>
			<?php $admin_id = $this->session->userdata('admin_id');?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<a class="btn btn-sm btn-custom-white pull-right me-2" title="Back" href="<?php echo base_url('admin/facility-management/property/list'); ?>"><i class="fa fa-reply"></i> Back</a>
					<button form="propertyForm" type="submit" class="btn btn-sm btn-custom-success pull-right" title="Save"><i class="fa fa-save"></i> Save</button>
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
						<?php echo form_open("admin/facility-management/property/update", array("id" => "propertyForm", "enctype" => "multipart/form-data", "class" => "form-label-left", "data-parsley-validate" => "")); ?>
							<input type="hidden" name="property_id" id="property_id" value="<?= $property['id'];?>" />
							<!-- Property Details -->
							<div class="row size-inner-section px-2 py-4">
								<h4 class="header-title">Property Details</h4><hr>
								<div class="col-md-4 mb-2">
									<label for="property_number" class="form-label">Property Number</label>
									<input type="text" class="form-control" id="property_number" name="property_number" maxlength="25"
										value="<?= htmlspecialchars($property['property_number']) ?>" readonly>
								</div>
								<div class="col-md-4 mb-2">
									<label for="property_name" class="form-label">Property Name</label>
									<input type="text" class="form-control" id="property_name" name="property_name" maxlength="225"
										value="<?= htmlspecialchars($property['property_name']) ?>" required>
								</div>
								<div class="col-md-4 mb-2">
									<label for="property_type" class="form-label">Property Type</label>
									<select name="property_type" id="property_type" class="form-select" required>
										<option value="">Select Property Type</option>
										<?php foreach(['Apartment', 'Building', 'Shop', 'Villa', 'Wharehouse'] as $type): ?>
											<option value="<?= $type ?>" <?= ($property['property_type'] === $type) ? 'selected' : '' ?>>
												<?= $type ?>
											</option>
										<?php endforeach; ?>
									</select>
								</div>
								<div class="col-md-4 mb-2">
									<label for="property_city" class="form-label">City</label>
									<select class="form-select select2" name="property_city" id="property_city" required>
										<option value="">Select City</option>
										<?php foreach($cities as $city): ?>
											<option value="<?= $city->id ?>" <?= ($property['property_city'] == $city->id) ? 'selected' : '' ?>>
												<?= $city->city_name ?>
											</option>
										<?php endforeach; ?>
									</select>
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="property_status">Property Status <span class="required-field">*</span></label>
									<select name="property_status" id="property_status" class="form-select" required>
										<option value="">Select Status</option>
										<option value="active" <?= ($property['property_status'] === 'active') ? 'selected' : '' ?>>Active</option>
										<option value="inactive" <?= ($property['property_status'] === 'inactive') ? 'selected' : '' ?>>Inactive</option>
									</select>
								</div>
							</div>

							<!-- Tenant Data -->
							<div class="row size-inner-section px-2 py-4">
								<h4 class="header-title">Tenant Data</h4><hr>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="tenant_company_id">Select Company Name/Founder</label>
									<select class="form-select select2" name="tenant_company_id" id="tenant_company_id">
										<option value="">Select Company Name</option>
										<?php foreach(sponsorsHelper() as $sponsor) { ?>
											<option value="<?php echo $sponsor['id']; ?>" data-tenant_cr_no="<?php echo $sponsor['employer_cr_no'];?>" <?= ($property['tenant_company_id'] == $sponsor['id']) ? 'selected' : '' ?>><?php echo $sponsor['employer_id'] .' - '. $sponsor['employer_name']; ?></option>
										<?php } ?>
									</select>
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="unified_number">Unified Number</label>
									<input type="text" class="form-control" id="unified_number" name="unified_number" value="<?= htmlspecialchars($property['tenant_unified_number']) ?>" maxlength="30" readonly />
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="cr_number">CR Number</label>
									<input type="text" class="form-control" id="cr_number" name="cr_number" value="<?= htmlspecialchars($property['tenant_cr_no']) ?>" maxlength="30" readonly />
								</div>
							</div>

							<!-- Brokerage Entity -->
							<div class="row size-inner-section px-2 py-4">
								<h4 class="header-title">Brokerage Entity and Broker Details</h4><hr>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="brokerage_entity_name">Brokerage Entity Name</label>
									<input type="text" class="form-control" id="brokerage_entity_name" name="brokerage_entity_name" value="<?= htmlspecialchars($property['brokerage_entity_name']) ?>" maxlength="250" />
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="brokerage_entity_address">Brokerage Entity Address</label>
									<input type="text" class="form-control" id="brokerage_entity_address" name="brokerage_entity_address" value="<?= htmlspecialchars($property['brokerage_entity_address']) ?>" maxlength="250" />
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="brokerage_landline_no">Brokerage Entity Landline No.</label>
									<input type="text" class="form-control" onKeyPress="return numerics(event);" id="brokerage_landline_no" name="brokerage_landline_no" value="<?= htmlspecialchars($property['brokerage_landline_no']) ?>" maxlength="25" />
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="brokerage_cr_no">Brokerage Entity CR No.</label>
									<input type="text" class="form-control" id="brokerage_cr_no" name="brokerage_cr_no" value="<?= htmlspecialchars($property['brokerage_cr_no']) ?>" maxlength="35" />
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="brokerage_vat_no">Brokerage Entity Vat Number</label>
									<input type="text" class="form-control" id="brokerage_vat_no" name="brokerage_vat_no" value="<?= htmlspecialchars($property['brokerage_vat_no']) ?>" maxlength="35" />
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="broker_name">Broker Name</label>
									<input type="text" class="form-control" id="broker_name" name="broker_name" value="<?= htmlspecialchars($property['broker_name']) ?>" maxlength="250" />
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="broker_nationality">Nationality <span class="required-field">*</span></label>
									<select class="form-select select2" name="broker_nationality" id="broker_nationality" required>
										<option value="">Select Nationality</option>
										<?php foreach(nationalityList() as $nation) { ?>
											<option value="<?php echo $nation->id; ?>" <?= ($property['broker_nationality'] == $nation->id) ? 'selected' : '' ?>><?php echo $nation->name; ?></option>
										<?php } ?>
									</select>
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="broker_id_no">Broker ID No.</label>
									<input type="text" class="form-control" id="broker_id_no" name="broker_id_no" value="<?= htmlspecialchars($property['broker_id_no']) ?>" maxlength="30" />
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="broker_person">Broker Person</label>
									<input type="text" class="form-control" id="broker_person" name="broker_person" value="<?= htmlspecialchars($property['broker_person']) ?>" maxlength="250" />
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="broker_mobile_no">Broker Mobile Number</label>
									<input type="tel" class="form-control" onKeyPress="return numerics(event);" id="broker_mobile_no" name="broker_mobile_no" value="<?= htmlspecialchars($property['broker_mobile_no']) ?>" maxlength="15" />
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="broker_email_id">Broker Email ID</label>
									<input type="email" class="form-control" id="broker_email_id" name="broker_email_id" value="<?= htmlspecialchars($property['broker_email_id']) ?>" maxlength="250" />
								</div>
							</div>

							<!-- Bank Details -->
							<div class="row size-inner-section px-2 py-4">
								<h4 class="header-title">Bank Details</h4><hr>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="account_name">Account Name <span class="required-field">*</span></label>
									<input type="text" class="form-control" onKeyPress="return Alpha(event);" id="account_name" name="account_name" value="<?= htmlspecialchars($property['account_name']) ?>" maxlength="250" required />
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="bank_name">Bank Name</label>
									<select name="bank_name" id="bank_name" class="form-select select2">
										<option value="">Select Bank</option>
										<?php foreach($banks as $bank): ?>
											<option value="<?= $bank->id ?>" <?= ($property['bank_name'] == $bank->id) ? 'selected' : '' ?>>
												<?= $bank->bank_name ?>
											</option>
										<?php endforeach; ?>
									</select>
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="iban">IBAN</label>
									<input type="text" class="form-control" id="iban" name="iban" value="<?= htmlspecialchars($property['iban']) ?>" maxlength="55" />
								</div>
							</div>

							<!-- Rent Details -->
							<div class="row size-inner-section px-2 py-4">
								<h4 class="header-title">Rent Details</h4><hr>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="ejar_contract_number">Ejar Contract Number <span class="required-field">*</span></label>
									<input type="text" class="form-control" id="ejar_contract_number" name="ejar_contract_number" value="<?= htmlspecialchars($property['ejar_contract_number']) ?>" maxlength="35" required />
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="ejar_contract_start_date">Ejar Contract Start Date</label>
									<input type="date" class="form-control" id="ejar_contract_start_date" name="ejar_contract_start_date" value="<?= htmlspecialchars($property['ejar_contract_start_date']) ?>" />
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="ejar_contract_end_date">Ejar Contract End Date</label>
									<input type="date" class="form-control" id="ejar_contract_end_date" name="ejar_contract_end_date" value="<?= htmlspecialchars($property['ejar_contract_end_date']) ?>" />
									<small id="ejar_date_error" class="text-danger"></small>
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="attach_ejar_contract">Attach Ejar Contract</label>
									<input type="file" name="attach_ejar_contract" id="attach_ejar_contract" class="dropify"
										data-default-file="<?= base_url($property['attach_ejar_contract']) ?>"
										accept=".pdf, .doc, .docx, .xls, .xlsx, .psd, application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document, application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/pdf, image/vnd.adobe.photoshop"
										data-max-file-size="2M" data-height="100">
									<a href="<?= base_url($property['attach_ejar_contract']) ?>" target="_blank" class="document">
										<small><?= basename($property['attach_ejar_contract']) ?></small>
									</a>
									<p><small>Allowed file types: pdf|doc|docx|xlsx|xls. Max size: 2MB</small></p>
								</div>
							</div>

							<div class="row size-inner-section px-2 py-4">
								<h4 class="header-title">Add Rent Payments</h4><hr>
								<div class="row p-2">
									<table id="rent-payments-table" class="table table-bordered w-100">
										<thead>
											<tr>
												<th>S.No.</th>
												<th>Rent Value</th>
												<th>VAT</th>
												<th>Services</th>
												<th>Total Value</th>
												<th>Issue Date (G)</th>
												<th>Due Date (G)</th>
												<th>Issue Date (H)</th>
												<th>Due Date (H)</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
											<?php if (!empty($rent_payments['schedule'])) : ?>
												<?php $scount=1; foreach ($rent_payments['schedule'] as $index => $rent) : ?>
													<tr>
														<td class="serial"><?= $scount++; ?></td>
														<td><input type="text" class="form-control input-mask text-left"
															data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'"
															autocomplete="off" name="rent_value[]" value="<?= $rent['rent_value'] ?>"></td>
														<td><input type="text" class="form-control input-mask text-left"
															data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'"
															autocomplete="off" name="vat[]" value="<?= $rent['vat'] ?>"></td>
														<td><input type="text" class="form-control input-mask text-left"
															data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'"
															autocomplete="off" name="service[]" value="<?= $rent['service'] ?>"></td>
														<td><input type="text" class="form-control input-mask text-left"
															data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'"
															autocomplete="off" name="total_value[]" value="<?= $rent['total_value'] ?>"></td>
														<td><input type="date" name="issue_date_g[]" class="form-control" value="<?= $rent['issue_date_g'] ?>"></td>
														<td><input type="date" name="due_date_g[]" class="form-control" value="<?= $rent['due_date_g'] ?>"></td>
														<td><input type="date" name="issue_date_h[]" class="form-control" value="<?= $rent['issue_date_h'] ?>"></td>
														<td><input type="date" name="due_date_h[]" class="form-control" value="<?= $rent['due_date_h'] ?>"></td>
														<td><button type="button" class="btn btn-danger btn-sm remove-rent-row">×</button></td>
													</tr>
												<?php endforeach; ?>
											<?php else: ?>
												<tr>
													<td class="serial">1</td>
													<td><input type="text" class="form-control input-mask text-left"
														data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'"
														autocomplete="off" name="rent_value[]" required /></td>
													<td><input type="text" class="form-control input-mask text-left"
														data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'"
														autocomplete="off" name="vat[]" required /></td>
													<td><input type="text" class="form-control input-mask text-left"
														data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'"
														autocomplete="off" name="service[]" required /></td>
													<td><input type="text" class="form-control input-mask text-left"
														data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'"
														autocomplete="off" name="total_value[]" required /></td>
													<td><input type="date" class="form-control" name="issue_date_g[]" /></td>
													<td><input type="date" class="form-control" name="due_date_g[]"></td>
													<td><input type="date" class="form-control" name="issue_date_h[]"></td>
													<td><input type="date" class="form-control" name="due_date_h[]"></td>
													<td><button type="button" class="btn btn-danger btn-sm remove-rent-row">×</button></td>
												</tr>
											<?php endif; ?>
										</tbody>
									</table>
									<div>
										<button type="button" class="btn btn-sm btn-secondary" id="add-rent-row">Add More Rent Schedule</button>
									</div>
								</div>
							</div>

							<div class="row size-inner-section px-2 py-4">
								<h4 class="header-title">Utility Bill Details</h4><hr>
								<div class="p-2">
									<div id="utility-section">
										<?php if (!empty($rent_payments['utilities'])): ?>
											<?php foreach ($rent_payments['utilities'] as $index => $utility): ?>
												<div class="row utility-item mb-2">
													<div class="col-md-6 form-group">
														<label>Water Bill Saddad Number</label>
														<input type="text" class="form-control" name="utility[<?= $index ?>][water]" value="<?= $utility['water'] ?? '' ?>">
													</div>
													<div class="col-md-5 form-group">
														<label>Electricity Bill Saddad Number</label>
														<input type="text" class="form-control" name="utility[<?= $index ?>][electricity]" value="<?= $utility['electricity'] ?? '' ?>">
													</div>
													<div class="col-md-1 form-group">
														<button type="button" class="btn btn-danger btn-sm position-absolute top-0 mt-4 remove-utility">×</button>
													</div>
												</div>
											<?php endforeach; ?>
										<?php else: ?>
											<div class="row utility-item mb-2">
												<div class="col-md-6 form-group">
													<label>Water Bill Saddad Number</label>
													<input type="text" class="form-control" name="utility[0][water]">
												</div>
												<div class="col-md-5 form-group">
													<label>Electricity Bill Saddad Number</label>
													<input type="text" class="form-control" name="utility[0][electricity]">
												</div>
											</div>
										<?php endif; ?>
									</div>
									<button type="button" class="btn btn-sm btn-secondary" onclick="addUtility()">Add More Utility Bill</button>
								</div>
							</div>

							<div class="row size-inner-section px-2 py-4">
								<h4 class="header-title">Facility Details</h4><hr>
								<div class="p-2">
									<div id="facility-section">
										<?php if (!empty($rent_payments['facilities'])): ?>
											<?php foreach ($rent_payments['facilities'] as $index => $facility): ?>
												<div class="row facility-item mb-2">
													<div class="col-md-3 form-group">
														<label>Floors</label>
														<select name="facility[<?= $index ?>][floors]" class="form-select" required>
															<option value="">Select Floors Type</option>
															<option value="Ground" <?= $facility['floors'] == 'Ground' ? 'selected' : '' ?>>Ground</option>
															<option value="First Floor" <?= $facility['floors'] == 'First Floor' ? 'selected' : '' ?>>First Floor</option>
															<option value="Second Floor" <?= $facility['floors'] == 'Second Floor' ? 'selected' : '' ?>>Second Floor</option>
															<option value="Third Floor" <?= $facility['floors'] == 'Third Floor' ? 'selected' : '' ?>>Third Floor</option>
														</select>
													</div>
													<div class="col-md-2 form-group">
														<label>Number of Rooms</label>
														<input type="number" class="form-control" name="facility[<?= $index ?>][rooms]" value="<?= $facility['rooms'] ?? '' ?>">
													</div>
													<div class="col-md-2 form-group">
														<label>Number of Kitchen</label>
														<input type="number" class="form-control" name="facility[<?= $index ?>][kitchen]" value="<?= $facility['kitchen'] ?? '' ?>">
													</div>
													<div class="col-md-2 form-group">
														<label>Parking Lots</label>
														<select name="facility[<?= $index ?>][parking]" class="form-select" required>
															<option value="">Select Parking Type</option>
															<option value="yes" <?= $facility['parking'] == 'yes' ? 'selected' : '' ?>>Yes</option>
															<option value="no" <?= $facility['parking'] == 'no' ? 'selected' : '' ?>>No</option>
														</select>
													</div>
													<div class="col-md-2 form-group">
														<label>Elevators</label>
														<select name="facility[<?= $index ?>][elevators]" class="form-select" required>
															<option value="">Select Elevator Type</option>
															<option value="yes" <?= $facility['elevators'] == 'yes' ? 'selected' : '' ?>>Yes</option>
															<option value="no" <?= $facility['elevators'] == 'no' ? 'selected' : '' ?>>No</option>
														</select>
													</div>
													<div class="col-md-1 form-group">
														<button type="button" class="btn btn-danger btn-sm position-absolute top-0 mt-4 remove-facility">×</button>
													</div>
												</div>
											<?php endforeach; ?>
										<?php else: ?>
											<div class="row facility-item mb-2">
												<div class="col-md-3 form-group">
													<label>Floors</label>
													<select name="facility[0][floors]" class="form-select" required>
														<option value="">Select Floors Type</option>
														<option value="Ground">Ground</option>
														<option value="First Floor">First Floor</option>
														<option value="Second Floor">Second Floor</option>
														<option value="Third Floor">Third Floor</option>
													</select>
												</div>
												<div class="col-md-2 form-group">
													<label>Number of Rooms</label>
													<input type="number" class="form-control" name="facility[0][rooms]">
												</div>
												<div class="col-md-2 form-group">
													<label>Number of Kitchen</label>
													<input type="number" class="form-control" name="facility[0][kitchen]">
												</div>
												<div class="col-md-2 form-group">
													<label>Parking Lots</label>
													<select name="facility[0][parking]" class="form-select" required>
														<option value="">Select Parking Type</option>
														<option value="yes">Yes</option>
														<option value="no">No</option>
													</select>
												</div>
												<div class="col-md-2 form-group">
													<label>Elevators</label>
													<select name="facility[0][elevators]" class="form-select" required>
														<option value="">Select Elevator Type</option>
														<option value="yes">Yes</option>
														<option value="no">No</option>
													</select>
												</div>
											</div>
										<?php endif; ?>
									</div>

									<button type="button" class="btn btn-sm btn-secondary" onclick="addFacility()">Add More Facility</button>
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

<script type="text/javascript">
	$('.dropify').dropify();

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
			toastr.error('You can enter only characters 0 to 9.');
			return false;
		} else return true;
	}

	$("select[name='tenant_company_id']").on('change',function(){
		var tenant_company_id = $(this).val();
		var tenant_cr_no = $("select[name='tenant_company_id'] option:selected").data('tenant_cr_no');
		var tenant_unified_number = $("select[name='tenant_company_id'] option:selected").data('employer_no');
		$('#unified_number').val(tenant_unified_number);
		$('#cr_number').val(tenant_cr_no);
	});
</script>
<script>
$(document).ready(function() {
    $('#propertyForm').on('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);

        // Validate contract dates
        let start = $('#ejar_contract_start_date').val();
        let end = $('#ejar_contract_end_date').val();
        if (start && end && end < start) {
            toastr.error('End date must be after start date.');
            return false;
        }

        $.ajax({
            url: '<?= base_url("admin/facility-management/property/update") ?>',
            type: 'POST',
            data: formData,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.status === 'success') {
                    toastr.success(response.message);
                    $('#propertyForm')[0].reset();
					setTimeout(function() {
						window.location.href = '<?= base_url("admin/facility-management/property/list") ?>';
					}, 1000);
                } else {
                    toastr.error(response.message);
                }
            },
            error: function() {
                toastr.error('Something went wrong.');
            }
        });
    });
});
</script>
<script>
$(document).ready(function () {

    function updateSerialNumbers() {
        $('#rent-payments-table tbody tr').each(function (index) {
            $(this).find('.serial').text(index + 1);
        });
    }

    // Add row
    $(document).on('click', '#add-rent-row', function () {
        let row = `
        <tr class="rent-payment-row">
            <td class="serial"></td>
            <td><input type="text" class="form-control input-mask text-left"
                data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'"
                autocomplete="off" name="rent_value[]" required></td>
            <td><input type="text" class="form-control input-mask text-left"
                data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'"
                autocomplete="off" name="vat[]" required></td>
            <td><input type="text" class="form-control input-mask text-left"
                data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'"
                autocomplete="off" name="service[]" required></td>
            <td><input type="text" class="form-control input-mask text-left"
                data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'"
                autocomplete="off" name="total_value[]" required></td>
            <td><input type="date" class="form-control" name="issue_date_g[]"></td>
            <td><input type="date" class="form-control" name="due_date_g[]"></td>
            <td><input type="date" class="form-control" name="issue_date_h[]"></td>
            <td><input type="date" class="form-control" name="due_date_h[]"></td>
            <td><button type="button" class="btn btn-danger btn-sm remove-rent-row">×</button></td>
        </tr>`;
        $('#rent-payments-table tbody').append(row);
        updateSerialNumbers();
    });

    // Remove row
    $(document).on('click', '.remove-rent-row', function () {
        const rowCount = $('#rent-payments-table tbody tr').length;
        if (rowCount > 1) {
            $(this).closest('tr').remove();
            updateSerialNumbers();
        } else {
            alert('At least one row is required.');
        }
    });

    // Initialize serials on load
    updateSerialNumbers();
});

$(document).on('click', '.remove-rent-row', function () {
	const rowCount = $('#rent-payments-table tbody tr').length; // <-- fixed ID here
	if (rowCount > 1) {
		$(this).closest('tr').remove();
	} else {
		alert('At least one row is required.');
	}
});

$('body').on('focus', '.input-mask', function () {
	$(this).inputmask({
		alias: 'numeric',
		digits: 2,
		digitsOptional: false,
		placeholder: '0'
	});
});

document.addEventListener('DOMContentLoaded', function () {
    let utilityIndex = document.querySelectorAll('.utility-item').length;
    let facilityIndex = document.querySelectorAll('.facility-item').length;

    // Add utility row
    window.addUtility = function () {
        const container = document.getElementById('utility-section');
        const html = `
            <div class="row utility-item mb-2">
                <div class="col-md-6 form-group">
                    <label>Water Bill Saddad Number</label>
                    <input type="text" class="form-control" name="utility[${utilityIndex}][water]">
                </div>
                <div class="col-md-5 form-group">
                    <label>Electricity Bill Saddad Number</label>
                    <input type="text" class="form-control" name="utility[${utilityIndex}][electricity]">
                </div>
                <div class="col-md-1 d-flex align-items-end">
                    <button type="button" class="btn btn-danger btn-sm remove-utility">X</button>
                </div>
            </div>`;
        container.insertAdjacentHTML('beforeend', html);
        utilityIndex++;
    };

	// Event delegation for utility and facility row removal
    document.getElementById('utility-section').addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-utility')) {
            const row = e.target.closest('.utility-item');
            if (document.querySelectorAll('.utility-item').length > 1) {
                row.remove();
                updateUtilityIndexes();
            }
        }
    });

	// Reindex utility inputs
    function updateUtilityIndexes() {
        const items = document.querySelectorAll('.utility-item');
        utilityIndex = items.length;
        items.forEach((item, index) => {
            const waterInput = item.querySelector('input[name^="utility"][name*="[water]"]');
            const electricityInput = item.querySelector('input[name^="utility"][name*="[electricity]"]');
            waterInput.name = `utility[${index}][water]`;
            electricityInput.name = `utility[${index}][electricity]`;
        });
    }

    // Add facility row
    window.addFacility = function () {
        const container = document.getElementById('facility-section');
        const html = `
            <div class="row facility-item mb-2">
				<div class="col-md-3 form-group">
					<label>Floors</label>
					<select name="facility[${facilityIndex}][floors]" class="form-select" required>
						<option value="">Select Floors Type</option>
						<option value="Ground">Ground</option>
						<option value="First Floor">First Floor</option>
						<option value="Second Floor">Second Floor</option>
						<option value="Third Floor">Third Floor</option>
					</select>
				</div>
				<div class="col-md-2 form-group">
					<label>Number of Rooms</label>
					<input type="number" class="form-control" name="facility[${facilityIndex}][rooms]">
				</div>
				<div class="col-md-2 form-group">
					<label>Number of Kitchen</label>
					<input type="number" class="form-control" name="facility[${facilityIndex}][kitchen]">
				</div>
				<div class="col-md-2 form-group">
					<label>Parking Lots</label>
					<select name="facility[${facilityIndex}][parking]" class="form-select" required>
						<option value="">Select Parking Type</option>
						<option value="yes">Yes</option>
						<option value="no">No</option>
					</select>
				</div>
				<div class="col-md-2 form-group">
					<label>Elevators</label>
					<select name="facility[${facilityIndex}][elevators]" class="form-select" required>
						<option value="">Select Elevator Type</option>
						<option value="yes">Yes</option>
						<option value="no">No</option>
					</select>
				</div>
				<div class="col-md-1 d-flex align-items-end">
					<button type="button" class="btn btn-danger btn-sm remove-facility">X</button>
				</div>
			</div>`;
        container.insertAdjacentHTML('beforeend', html);
        facilityIndex++;
    };

    document.getElementById('facility-section').addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-facility')) {
            const row = e.target.closest('.facility-item');
            if (document.querySelectorAll('.facility-item').length > 1) {
                row.remove();
                updateFacilityIndexes();
            }
        }
    });

    // Reindex facility inputs
    function updateFacilityIndexes() {
        const items = document.querySelectorAll('.facility-item');
        facilityIndex = items.length;
        items.forEach((item, index) => {
            item.querySelector('input[name^="facility"][name*="[type]"]').name = `facility[${index}][type]`;
            item.querySelector('input[name^="facility"][name*="[floors]"]').name = `facility[${index}][floors]`;
            item.querySelector('input[name^="facility"][name*="[rooms]"]').name = `facility[${index}][rooms]`;
            item.querySelector('input[name^="facility"][name*="[parking]"]').name = `facility[${index}][parking]`;
            item.querySelector('input[name^="facility"][name*="[elevators]"]').name = `facility[${index}][elevators]`;
        });
    }
});
</script>



