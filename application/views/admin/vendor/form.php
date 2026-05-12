<?php $this->load->view('admin/home/header');?>
<style>
span.required{
	color:red;
}
.alert_text{
	border:2px red solid;
}
.d-none{
	display:none;
}
#wait{
	display: none;
    width: 100%;
    height: 100%;
    position: absolute;
    padding: 2px;
    z-index: 9;
    background: #ffffff96;
    text-align: center;
    padding-top: 17%;
    font-size: 30px;
}
ul.nav-pills li.nav-item{
	width:16.66% !important;
}
@media only screen and (max-width: 1240px) {
  	ul.nav-pills li.nav-item{
		width:24% !important;
	}
}
@media only screen and (max-width: 767px) {
  	ul.nav-pills li.nav-item{
		width:50% !important;
	}
}
.nav-pills .nav-link.active, .nav-pills .show>.nav-link {
	color: #fff !important;
    background-color: #005500!important;
}
.size-inner-section {
    box-shadow: 0px 1px 4px #c5c5c5;
    border-radius: 5px;
    margin-bottom: 10px;
}
.remove-section{
	border-radius: 50%;
    height: 30px;
    width: 30px;
    line-height: 25px;
    font-size: 19px;
    text-align: center;
    padding: 0;
}
</style>

<!-- start page title -->
<div class="page-title-box">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <div class="page-title">
                    <h4>Supplier Management</h4>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('admin');?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url();?>admin/vendor/list">Supplier</a></li>
                        <li class="breadcrumb-item active">Create / Edit</li>
                    </ol>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="float-end d-sm-block">
					<a class="btn btn-sm btn-custom-white pull-right" title="Back" href="<?php echo base_url();?>admin/vendor/list"><i class="fa fa-reply"></i> Back</a>
					<button form="demo-form2" type="submit" class="btn btn-sm btn-custom-success pull-right" title="Save"><i class="fa fa-save"></i> Save</button>
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
						<div class="row py-5">
							<div class="col-md-12">
							<?php echo form_open("admin/vendor/submit", array("id"=>"demo-form2", "enctype"=>"multipart/form-data", "class"=>"form-label-left", "data-parsley-validate"=> "")); ?>
								<div id="addproduct-nav-pills-wizard" class="twitter-bs-wizard">
									<ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
										<li class="nav-item">
											<a class="nav-link active" data-bs-toggle="tab" href="#home" role="tab">
												<span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
												<span class="d-none d-sm-block">Basic Information</span>
											</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" data-bs-toggle="tab" href="#profile1" role="tab">
												<span class="d-block d-sm-none"><i class="far fa-user"></i></span>
												<span class="d-none d-sm-block">Bank Account Information</span>
											</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" data-bs-toggle="tab" href="#messages1" role="tab">
												<span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
												<span class="d-none d-sm-block">Upload Documents</span>
											</a>
										</li>
									</ul>

									<div class="tab-content py-3 text-muted">
										<div class="tab-pane active" id="home" role="tabpanel">
											<h4 class="header-title">Basic Information</h4>
											<p class="card-title-desc">Fill all information below</p>
											<input type="hidden" id="id" name="id" value="<?php echo $id;?>" />
											<div class="row size-inner-section p-2">
												<h5 class="scheduler-border">Supplier Legal Information:</h5>
												<div class="col-md-4 col-sm-4 form-group mb-3">
													<label for="vendor_type">Supplier Type <span class="text-danger">*</span> :</label>
													<select id="vendor_type" name="vendor_type" class="form-control form-select initial-required" required>
														<option value="">Select Supplier Type</option>
														<option value="local" <?php echo ($vendor_type == 'local') ? "selected":"";?>>Local</option>
														<option value="international" <?php echo ($vendor_type == 'international') ? "selected":"";?>>International</option>
														<option value="saddad" <?php echo ($vendor_type == 'saddad') ? "selected":"";?>>Saddad</option>
													</select>
												</div>
												<div class="col-md-4 col-sm-4 form-group mb-3">
													<label for="vendor_name">Company Name (English) <span class="text-danger">*</span> :</label>
													<input type="text" class="form-control initial-required" id="vendor_name" name="vendor_name" value="<?php echo $vendor_name;?>" onKeyPress="return Alpha(event);" maxlength="150" required />
												</div>
												<div class="col-md-4 col-sm-4 form-group mb-3">
													<label for="vendor_arabic_name">Company Name (Arabic) <span class="text-danger">*</span> :</label>
													<input type="text" class="form-control initial-required" id="vendor_arabic_name" name="vendor_arabic_name" value="<?php echo $vendor_arabic_name;?>" maxlength="150" required />
												</div>
												<div class="col-md-4 col-sm-4 form-group mb-3">
													<label for="contact_person_name">Contact Person Name <span class="text-danger required-mark">*</span> :</label>
													<input type="text" class="form-control initial-required" id="contact_person_name" name="contact_person_name" value="<?php echo $contact_person_name;?>" onKeyPress="return Alpha(event);" maxlength="150" required />
												</div>
												<div class="col-md-4 col-sm-4 form-group mb-3">
													<label for="agrement_expiry">Agreement Expiry :</label>
													<input type="date" class="form-control" id="agrement_expiry" name="agrement_expiry" value="<?php echo $agrement_expiry;?>" />
												</div>
												<div class="col-md-4 col-sm-4 form-group mb-3">
													<label for="cr_no">CR Number <span class="text-danger opt-req required-mark">*</span> :</label>
													<input type="text" class="form-control initial-required" id="cr_no" name="cr_no" value="<?php echo $cr_no;?>" minlength="<?= CR_LENGTH; ?>" maxlength="<?= CR_LENGTH; ?>" required />
												</div>
												<div class="col-md-4 col-sm-4 form-group mb-3">
													<label for="cr_expiry">CR. Expiry :</label>
													<input type="date" class="form-control" id="cr_expiry" name="cr_expiry" min="<?php echo ($id > 0) ? '' : date("Y-m-d"); ?>" value="<?php echo $cr_expiry;?>" />
												</div>
												<div class="col-md-4 col-sm-4 form-group mb-3">
													<label for="fax">FAX :</label>
													<input type="text" class="form-control" id="fax" name="fax" value="<?php echo $fax;?>" maxlength="<?= FAX_LENGTH; ?>" />
												</div>
												<div class="col-md-4 col-sm-4 form-group mb-3">
													<label for="vat_no">VAT Number <span class="text-danger opt-req required-mark">*</span> :</label>
													<input type="text" class="form-control initial-required" id="vat_no" name="vat_no" value="<?php echo $vat_no;?>" minlength="<?= VAT_LENGTH; ?>" maxlength="<?= VAT_LENGTH; ?>" required />
												</div>
												<div class="col-md-4 col-sm-4 form-group mb-3">
													<label for="fullname">VAT Expiry :</label>
													<input type="date" class="form-control" id="vat_expiry" name="vat_expiry" min="<?php echo ($id > 0) ? '' : date("Y-m-d"); ?>" value="<?php echo $vat_expiry;?>" />
												</div>
												<div class="col-md-4 col-sm-4 form-group mb-3">
													<label for="telephone">Telephone :</label>
													<input type="text" class="form-control" id="telephone" name="telephone" value="<?php echo $telephone;?>" onkeypress="return numerics(event);" minlength="<?= MOB_LENGTH; ?>" maxlength="<?= MOB_LENGTH; ?>" />
												</div>
												<div class="col-md-4 col-sm-4 form-group mb-3">
													<label for="vendor_email">Email ID :</label>
													<input type="email" class="form-control" id="vendor_email" name="vendor_email" value="<?php echo $vendor_email;?>" maxlength="<?= EMAIL_LENGTH; ?>" />
												</div>
												<div class="col-md-4 col-sm-4 form-group mb-3">
													<label for="website">Website :</label>
													<input type="text" class="form-control" id="website" name="website" value="<?php echo $website;?>" maxlength="120" />
												</div>
												<div class="col-md-4  mb-3 form-group">
													<label for="spare_part_supplier">Spare Part Supplier <span class="text-danger required-mark">*</span> :</label>
													<select id="spare_part_supplier" name="spare_part_supplier" class="form-control form-select initial-required" required>
														<option value="">Select Spare Part Supplier</option>
														<option value="0" <?php echo ($spare_part_supplier == '0') ? "selected":"";?>>No</option>
														<option value="1" <?php echo ($spare_part_supplier == '1') ? "selected":"";?>>Yes</option>
													</select>
												</div>
											</div>
											<div class="row size-inner-section p-2">
												<h5 class="scheduler-border">Supplier Contact Information:</h5>
												
												<div class="row">
													<h5 class="scheduler-border" style="font-size: 13px;">Sales Department:</h5>
													<div class="col-md-4 col-sm-4 form-group mb-3">
														<label for="sales_name">Person Name :</label>
														<input type="text" class="form-control" id="sales_name" name="sales_name" value="<?php echo $sales_name;?>" onKeyPress="return Alpha(event);" maxlength="150" />
													</div>
													<div class="col-md-4 col-sm-4 form-group mb-3">
														<label for="sales_mobile">Mobile No :</label>
														<input type="text" class="form-control" id="sales_mobile" name="sales_mobile" value="<?php echo $sales_mobile;?>" onkeypress="return numerics(event);" minlength="<?= MOB_LENGTH; ?>" maxlength="<?= MOB_LENGTH; ?>" />
													</div>
													<div class="col-md-4 col-sm-4 form-group mb-3">
														<label for="sales_email">Email ID :</label>
														<input type="email" class="form-control" id="sales_email" name="sales_email" value="<?php echo $sales_email;?>" maxlength="<?= EMAIL_LENGTH; ?>" />
													</div>
												</div>
												<div class="row">
													<h5 class="scheduler-border" style="font-size: 13px;">Finance Department:</h5>
													<div class="col-md-4  mb-3 form-group">
														<label for="finance_name">Person Name :</label>
														<input type="text" class="form-control" id="finance_name" name="finance_name" onKeyPress="return Alpha(event);" value="<?php echo $finance_name;?>" maxlength="150" />
													</div>
													<div class="col-md-4  mb-3 form-group">
														<label for="finance_mobile">Mobile No :</label>
														<input type="text" class="form-control" id="finance_mobile" name="finance_mobile" onkeypress="return numerics(event);" value="<?php echo $finance_mobile;?>" minlength="<?= MOB_LENGTH; ?>" maxlength="<?= MOB_LENGTH; ?>" />
													</div>
													<div class="col-md-4  mb-3 form-group">
														<label for="finance_email">Email ID :</label>
														<input type="email" class="form-control" id="finance_email" name="finance_email" value="<?php echo $finance_email;?>" maxlength="<?= EMAIL_LENGTH; ?>" />
													</div>
												</div>
												<div class="row">
													<h5 class="scheduler-border" style="font-size: 13px;">Legal Department:</h5>
													<div class="col-md-4  mb-3 form-group">
														<label for="legal_name">Person Name :</label>
														<input type="text" class="form-control" id="legal_name" name="legal_name" onKeyPress="return Alpha(event);" value="<?php echo $legal_name;?>" maxlength="150" />
													</div>
													<div class="col-md-4  mb-3 form-group">
														<label for="legal_mobile">Mobile No :</label>
														<input type="text" class="form-control" id="legal_mobile" name="legal_mobile" onkeypress="return numerics(event);" value="<?php echo $legal_mobile;?>" minlength="<?= MOB_LENGTH; ?>" maxlength="<?= MOB_LENGTH; ?>" />
													</div>
													<div class="col-md-4  mb-3 form-group">
														<label for="legal_email">Email ID :</label>
														<input type="email" class="form-control" id="legal_email" name="legal_email" value="<?php echo $legal_email;?>" maxlength="<?= EMAIL_LENGTH; ?>" />
													</div>
												</div>
												<div class="row">
													<h5 class="scheduler-border" style="font-size: 13px;">Other (if any):</h5>
													<div class="col-md-4  mb-3 form-group">
														<label for="other_name">Person Name :</label>
														<input type="text" class="form-control" id="other_name" name="other_name" onKeyPress="return Alpha(event);" value="<?php echo $other_name;?>" maxlength="150" />
													</div>
													<div class="col-md-4  mb-3 form-group">
														<label for="other_mobile">Mobile No :</label>
														<input type="text" class="form-control" id="other_mobile" name="other_mobile" onkeypress="return numerics(event);" value="<?php echo $other_mobile;?>" minlength="<?= MOB_LENGTH; ?>" maxlength="<?= MOB_LENGTH; ?>" />
													</div>
													<div class="col-md-4  mb-3 form-group">
														<label for="other_email">Email ID :</label>
														<input type="email" class="form-control" id="other_email" name="other_email" value="<?php echo $other_email;?>" maxlength="<?= EMAIL_LENGTH; ?>" />
													</div>
												</div>
											</div>
											<div class="row size-inner-section p-2">
												<h5 class="scheduler-border">Supplier National Address:</h5>
												<div class="col-md-4  mb-3 form-group">
													<label for="building_no">Building Number :</label>
													<input type="text" class="form-control" id="building_no" name="building_no" value="<?php echo $building_no;?>" />
												</div>
												<div class="col-md-4  mb-3 form-group">
													<label for="street_name">Street Name :</label>
													<input type="text" class="form-control" id="street_name" name="street_name" value="<?php echo $street_name;?>" />
												</div>
												<div class="col-md-4  mb-3 form-group">
													<label for="district">District Name :</label>
													<input type="text" class="form-control" id="district" name="district" onKeyPress="return Alpha(event);" value="<?php echo $district;?>" maxlength="150" />
												</div>
												<div class="col-md-4  mb-3 form-group">
													<label for="city">City Name :</label>
													<select id="city" name="city" class="form-control col-md-12 select2">
														<option value="">Select City</option>
														<?php foreach($master_cities as $master_city){?>
														<option value="<?php echo $master_city->id;?>" <?php echo ($city == $master_city->id) ? "selected":"";?>><?php echo $master_city->city_name;?></option>
														<?php } ?>
													</select>
												</div>
												<div class="col-md-4  mb-3 form-group">
													<label for="country">Country :</label>
													<select id="country" name="country" class="form-control col-md-12 select2">
														<option value="">Selct Country</option>
														<option value="Saudi Arabia" <?php echo ($country == 'Saudi Arabia') ? "selected":"";?>>Saudi Arabia</option>
													</select>
												</div>
												<div class="col-md-4  mb-3 form-group">
													<label for="postal_code">Zip Code :</label>
													<input type="text" class="form-control" id="postal_code" name="postal_code" value="<?php echo $postal_code;?>" onkeypress="return numerics(event);" minlength="<?= ZIP_LENGTH; ?>" maxlength="<?= ZIP_LENGTH; ?>" />
												</div>
												<div class="col-md-4  mb-3 form-group">
													<label for="additional_no">Additional Number :</label>
													<input type="text" class="form-control" id="additional_no" name="additional_no" value="<?php echo $additional_no;?>" maxlength="15" />
												</div>
												<div class="col-md-4  mb-3 form-group">
													<label for="unit_no">Unit Number :</label>
													<input type="text" class="form-control" id="unit_no" name="unit_no" value="<?php echo $unit_no;?>" maxlength="15" />
												</div>
												<div class="col-md-4  mb-3 form-group">
													<label for="short_address">Short Address :</label>
													<input type="text" class="form-control" id="short_address" name="short_address" value="<?php echo $short_address;?>" maxlength="255" />
												</div>
											</div>
											<div class="row size-inner-section p-2">
												<h5 class="scheduler-border">Payment & Delivery Information:</h5>
												<div class="col-md-4  mb-3 form-group">
													<label for="payment_terms">Payment Terms <span class="text-danger required-mark">*</span> :</label>
													<select id="payment_terms" name="payment_terms" class="form-control col-md-12 select2 initial-required" required>
														<option value="">Select Payment Terms</option>
														<option value="Cash" <?php echo ($payment_terms == 'Cash') ? "selected":"";?>>Cash</option>
														<option value="Credit" <?php echo ($payment_terms == 'Credit') ? "selected":"";?>>Credit</option>
														<option value="Online" <?php echo ($payment_terms == 'Online') ? "selected":"";?>>Online</option>
													</select>
												</div>
												<div class="col-md-4  mb-3 form-group">
													<label for="order_currency">Order Currency :</label>
													<select id="order_currency" name="order_currency" class="form-control col-md-12 select2">
														<option value="">Select Currency</option>
														<option value="SAR" <?php echo ($order_currency == 'SAR') ? "selected":"";?>>SAR</option>
														<option value="INR" <?php echo ($order_currency == 'INR') ? "selected":"";?>>INR</option>
														<option value="USD" <?php echo ($order_currency == 'USD') ? "selected":"";?>>USD</option>
														<option value="EUR" <?php echo ($order_currency == 'EUR') ? "selected":"";?>>EUR</option>
													</select>
												</div>
												<div class="col-md-4  mb-3 form-group">
													<label for="credit_limit">Credit Limit :</label>
													<input type="text" class="form-control" id="credit_limit" name="credit_limit" onkeypress="return numerics(event);" maxlength="7" value="<?php echo $credit_limit;?>" />
												</div>
											</div>
										</div>

										<div class="tab-pane" id="profile1" role="tabpanel">
											<div id="section-container">
												<?php if (!empty($payment_info)) : ?>
													<?php foreach ($payment_info as $index => $payment) : ?>
														<div class="row size-inner-section px-2 py-4 mx-1 payment-section">
															<h5 class="scheduler-border">Payment & Delivery Information: 
																<button type="button" class="btn btn-danger remove-section float-end">
																	<i class="mdi mdi-close"></i>
																</button>
															</h5>
															<div class="col-md-4 mb-3 form-group">
																<label for="account_holder_name">Account Holder Name :</label>
																<input type="text" class="form-control" name="account_holder_name[<?php echo $index; ?>]" maxlength="150" value="<?php echo htmlspecialchars($payment['account_holder_name']); ?>" />
															</div>
															<div class="col-md-4 mb-3 form-group">
																<label for="bank_account_no">Bank Account No :</label>
																<input type="text" class="form-control" name="bank_account_no[<?php echo $index; ?>]" onkeypress="return numerics(event);" maxlength="<?= BANK_ACCOUNT; ?>" value="<?php echo htmlspecialchars($payment['bank_account_no']); ?>" />
															</div>
															<div class="col-md-4 mb-3 form-group">
																<label for="iban_number">IBAN Number :</label>
																<input type="text" class="form-control" name="iban_number[<?php echo $index; ?>]" minlength="<?= IBAN_LENGTH; ?>" maxlength="<?= IBAN_LENGTH; ?>" value="<?php echo htmlspecialchars($payment['iban_number']); ?>" />
															</div>
															<div class="col-md-4 mb-3 form-group">
																<label for="bank_name">Bank Name :</label>
																<select name="bank_name[<?php echo $index; ?>]" class="form-control col-md-12 select2">
																	<option value="">Select Bank</option>
																	<?php foreach ($master_banks as $master_bank) : ?>
																		<option value="<?php echo $master_bank->id; ?>" <?php echo ($payment['bank_name'] == $master_bank->id) ? "selected" : ""; ?>>
																			<?php echo $master_bank->bank_name; ?>
																		</option>
																	<?php endforeach; ?>
																</select>
															</div>
															<div class="col-md-4 mb-3 form-group">
																<label for="branch_name">Branch Name :</label>
																<input type="text" class="form-control" name="branch_name[<?php echo $index; ?>]" onkeypress="return Alpha(event);" maxlength="250" value="<?php echo htmlspecialchars($payment['branch_name']); ?>" />
															</div>
															<div class="col-md-4 mb-3 form-group">
																<label for="region">Region :</label>
																<select name="region[<?php echo $index; ?>]" class="form-control col-md-12 select2">
																	<option value="">Select Region</option>
																	<option value="Central Region" <?php echo ($payment['region'] == 'Central Region') ? "selected" : ""; ?>>Central Region</option>
																	<option value="Eastern Region" <?php echo ($payment['region'] == 'Eastern Region') ? "selected" : ""; ?>>Eastern Region</option>
																	<option value="Western Region" <?php echo ($payment['region'] == 'Western Region') ? "selected" : ""; ?>>Western Region</option>
																	<option value="Southern Region" <?php echo ($payment['region'] == 'Southern Region') ? "selected" : ""; ?>>Southern Region</option>
																</select>
															</div>
															<div class="col-md-4 mb-3 form-group">
																<label for="account_currency">Account Currency :</label>
																<select name="account_currency[<?php echo $index; ?>]" class="form-control col-md-12 select2">
																	<option value="">Select Currency</option>
																	<option value="SAR" <?php echo ($payment['account_currency'] == 'SAR') ? "selected" : ""; ?>>SAR</option>
																	<option value="INR" <?php echo ($payment['account_currency'] == 'INR') ? "selected" : ""; ?>>INR</option>
																	<option value="USD" <?php echo ($payment['account_currency'] == 'USD') ? "selected" : ""; ?>>USD</option>
																	<option value="EUR" <?php echo ($payment['account_currency'] == 'EUR') ? "selected" : ""; ?>>EUR</option>
																</select>
															</div>
															<div class="col-md-4 mb-3 form-group">
																<label for="swift_code">Swift / Sarie Code :</label>
																<input type="text" class="form-control" name="swift_code[<?php echo $index; ?>]" maxlength="50" value="<?php echo htmlspecialchars($payment['swift_code']); ?>" />
															</div>
															<div class="col-md-4 mb-3 form-group">
																<label for="bank_city">City :</label>
																<select name="bank_city[<?php echo $index; ?>]" class="form-control col-md-12 select2">
																	<option value="">Select City</option>
																	<?php foreach ($master_cities as $master_city) : ?>
																		<option value="<?php echo $master_city->id; ?>" <?php echo ($payment['bank_city'] == $master_city->id) ? "selected" : ""; ?>>
																			<?php echo $master_city->city_name; ?>
																		</option>
																	<?php endforeach; ?>
																</select>
															</div>
														</div>
													<?php endforeach; ?>
												<?php else : ?>
													<div class="row size-inner-section px-2 py-4 mx-1 payment-section">
														<h5 class="scheduler-border">Payment & Delivery Information: 
															<button type="button" class="btn btn-danger remove-section float-end">
																<i class="mdi mdi-close"></i>
															</button>
														</h5>
														<div class="col-md-4 mb-3 form-group">
															<label for="account_holder_name">Account Holder Name :</label>
															<input type="text" class="form-control" name="account_holder_name[]" maxlength="150" />
														</div>
														<div class="col-md-4 mb-3 form-group">
															<label for="bank_account_no">Bank Account No :</label>
															<input type="text" class="form-control" name="bank_account_no[]" onkeypress="return numerics(event);" maxlength="<?= BANK_ACCOUNT; ?>" />
														</div>
														<div class="col-md-4 mb-3 form-group">
															<label for="iban_number">IBAN Number :</label>
															<input type="text" class="form-control" name="iban_number[]" minlength="<?= IBAN_LENGTH; ?>" maxlength="<?= IBAN_LENGTH; ?>" />
														</div>
														<div class="col-md-4 mb-3 form-group">
															<label for="bank_name">Bank Name :</label>
															<select name="bank_name[]" class="form-control col-md-12 select2">
																<option value="">Select Bank</option>
																<?php foreach ($master_banks as $master_bank) : ?>
																	<option value="<?php echo $master_bank->id; ?>">
																		<?php echo $master_bank->bank_name; ?>
																	</option>
																<?php endforeach; ?>
															</select>
														</div>
														<div class="col-md-4 mb-3 form-group">
															<label for="branch_name">Branch Name :</label>
															<input type="text" class="form-control" name="branch_name[]" onkeypress="return Alpha(event);" maxlength="250" />
														</div>
														<div class="col-md-4 mb-3 form-group">
															<label for="region">Region :</label>
															<select name="region[]" class="form-control col-md-12 select2">
																<option value="">Select Region</option>
																<option value="Central Region">Central Region</option>
																<option value="Eastern Region">Eastern Region</option>
																<option value="Western Region">Western Region</option>
																<option value="Southern Region">Southern Region</option>
															</select>
														</div>
														<div class="col-md-4 mb-3 form-group">
															<label for="account_currency">Account Currency :</label>
															<select name="account_currency[]" class="form-control col-md-12 select2">
																<option value="">Select Currency</option>
																<option value="SAR">SAR</option>
																<option value="INR">INR</option>
																<option value="USD">USD</option>
																<option value="EUR">EUR</option>
															</select>
														</div>
														<div class="col-md-4 mb-3 form-group">
															<label for="swift_code">Swift / Sarie Code :</label>
															<input type="text" class="form-control" name="swift_code[]" maxlength="50" />
														</div>
														<div class="col-md-4 mb-3 form-group">
															<label for="bank_city">City :</label>
															<select name="bank_city[]" class="form-control col-md-12 select2">
																<option value="">Select City</option>
																<?php foreach ($master_cities as $master_city) : ?>
																	<option value="<?php echo $master_city->id; ?>">
																		<?php echo $master_city->city_name; ?>
																	</option>
																<?php endforeach; ?>
															</select>
														</div>
													</div>
												<?php endif; ?>
											</div>
											<button type="button" id="add-section" class="btn btn-success mt-1">Add More Payment Options</button>
										</div>

										<div class="tab-pane" id="messages1" role="tabpanel">
											<div class="row size-inner-section p-2">
												<h5 class="scheduler-border">Upload Documents</h5>
												<div class="col-md-4 mb-3 form-group">
													<label for="cr_certificate">CR. Certificate :</label>
													<input type="file" class="form-control" name="cr_certificate" />
													<input type="hidden" name="old_cr_certificate" value="<?php echo $cr_certificate;?>" />
													<?php if($cr_certificate){
														$fileExt = pathinfo($cr_certificate, PATHINFO_EXTENSION);
														if($fileExt == 'jpg' || $fileExt == 'png' || $fileExt == 'JPG' || $fileExt == 'PNG'){
															echo '<img src="'. base_url($cr_certificate) .'" class="img-fluid p-2" width="100px" />';
														}else{
															echo '<a href="'. base_url($cr_certificate) .'" target="_blank"><i class="fa fa-file-pdf-o fa-5x"></i></a>';
														}
													} ?>
												</div>
												<div class="col-md-4 mb-3 form-group">
													<label for="vat_certificate">VAT Certificate :</label>
													<input type="file" class="form-control" name="vat_certificate" />
													<input type="hidden" name="old_vat_certificate" value="<?php echo $vat_certificate;?>" />
													<?php if($vat_certificate){
														$fileExt = pathinfo($vat_certificate, PATHINFO_EXTENSION);
														if($fileExt == 'jpg' || $fileExt == 'png' || $fileExt == 'JPG' || $fileExt == 'PNG'){
															echo '<img src="'. base_url($vat_certificate) .'" class="img-fluid p-2" width="100px" />';
														}else{
															echo '<a href="'. base_url($vat_certificate) .'" target="_blank"><i class="fa fa-file-pdf-o fa-5x"></i></a>';
														}
													} ?>
												</div>
												<div class="col-md-4 mb-3 form-group">
													<label for="national_address">National Address :</label>
													<input type="file" class="form-control" name="national_address" />
													<input type="hidden" name="old_national_address" value="<?php echo $national_address;?>" />
													<?php if($national_address){
														$fileExt = pathinfo($national_address, PATHINFO_EXTENSION);
														if($fileExt == 'jpg' || $fileExt == 'png' || $fileExt == 'JPG' || $fileExt == 'PNG'){
															echo '<img src="'. base_url($national_address) .'" class="img-fluid p-2" width="100px" />';
														}else{
															echo '<a href="'. base_url($national_address) .'" target="_blank"><i class="fa fa-file-pdf-o fa-5x"></i></a>';
														}
													} ?>
												</div>
												<div class="col-md-4 mb-3 form-group">
													<label for="iban_letter">IBAN Letters :</label>
													<input type="file" class="form-control" name="iban_letter" />
													<input type="hidden" name="old_iban_letter" value="<?php echo $iban_letter;?>" />
													<?php if($iban_letter){
														$fileExt = pathinfo($iban_letter, PATHINFO_EXTENSION);
														if($fileExt == 'jpg' || $fileExt == 'png' || $fileExt == 'JPG' || $fileExt == 'PNG'){
															echo '<img src="'. base_url($iban_letter) .'" class="img-fluid p-2" width="100px" />';
														}else{
															echo '<a href="'. base_url($iban_letter) .'" target="_blank"><i class="fa fa-file-pdf-o fa-5x"></i></a>';
														}
													} ?>
												</div>
												<div class="col-md-4 mb-3 form-group">
													<label for="credit_agreements">Credit Agreements :</label>
													<input type="file" class="form-control" name="credit_agreements" />
													<input type="hidden" name="old_credit_agreements" value="<?php echo $credit_agreements;?>" />
													<?php if($credit_agreements){
														$fileExt = pathinfo($credit_agreements, PATHINFO_EXTENSION);
														if($fileExt == 'jpg' || $fileExt == 'png' || $fileExt == 'JPG' || $fileExt == 'PNG'){
															echo '<img src="'. base_url($credit_agreements) .'" class="img-fluid p-2" width="100px" />';
														}else{
															echo '<a href="'. base_url($credit_agreements) .'" target="_blank"><i class="fa fa-file-pdf-o fa-5x"></i></a>';
														}
													} ?>
												</div>
												<div class="col-md-4 mb-3 form-group">
													<label for="authorization">Authorization :</label>
													<input type="file" class="form-control" name="authorization" />
													<input type="hidden" name="old_authorization" value="<?php echo $authorization;?>" />
													<?php if($authorization){
														$fileExt = pathinfo($authorization, PATHINFO_EXTENSION);
														if($fileExt == 'jpg' || $fileExt == 'png' || $fileExt == 'JPG' || $fileExt == 'PNG'){
															echo '<img src="'. base_url($authorization) .'" class="img-fluid p-2" width="100px" />';
														}else{
															echo '<a href="'. base_url($authorization) .'" target="_blank"><i class="fa fa-file-pdf-o fa-5x"></i></a>';
														}
													} ?>
												</div>
											</div>
											
										</div>
									</div>
								</div>
								<?php echo form_close();?>
							</div>
						</div>
					</div>
				</div>
			</div> <!-- end col -->
		</div> <!-- end row -->
    </div>
</div> <!-- container-fluid -->

<?php $this->load->view('admin/home/footer');?>

<script type="text/javascript">
$(document).ready(function() {
    $("#number").on("keypress", function(e) {
        if ($(this).val().length <= '15') {
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {

                $("#errmsg").html("Digits Only").show();
                return false;
            }
        } else {
            $("#errmsg").html("Input Maxium 15 Digits Only").show();
            return false;
        }
    });
});
</script>
<script>
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
        alert(" You can enter only characters 0 to 9 ");
        return false;
    } else return true;
}

$(document).ready(function() {
	var vendor_type = "<?= ($vendor_type == '') ? 'NULL' : $vendor_type; ?>";
	vendorTypeReq(vendor_type);
});

$('#vendor_type').change(function() {
	var vendor_type = $(this).find('option:selected').val();
	vendorTypeReq(vendor_type);
});

function vendorTypeReq(vendor_type){
	if(vendor_type=='local'){
		$('#cr_no').prop('required',true);
		$('#vat_no').prop('required',true);
		$('.opt-req').html('*');
	}else{
		$('#cr_no').prop('required',false);
		$('#vat_no').prop('required',false);
		$('.opt-req').html('');
	}
}

$(document).ready(function() {
    function toggleRequiredAttributes() {
        var selectedType = $('#vendor_type').val();

        if (selectedType === 'saddad') {
            $('.required-mark').html('');
            $('input').not('#vendor_name, #vendor_arabic_name').removeAttr('required');
            $('select').not('#vendor_type').removeAttr('required');
        } else {
            // Add 'required' to initial fields
            $('.required-mark').html('*');
            $('input.initial-required').attr('required', 'required');
            $('select.initial-required').attr('required', 'required');
        }
    }

    // Initially check when the page is loaded
    toggleRequiredAttributes();

    // Listen for changes in the vendor_type select field
    $('#vendor_type').change(function() {
        toggleRequiredAttributes();
    });
});

$(document).ready(function() {
    let sectionCount = 1;

    // Initialize Select2 for dropdowns in a section
    function initializeSelect2(section) {
        section.find('.select2').select2({
            width: '100%' // Adjust the width if necessary
        });
    }

    // Initial Select2 initialization for the first dropdown
    initializeSelect2($('.payment-section:first'));

    $('#add-section').on('click', function() {
        // Clone the first payment section and reset values
        let clonedSection = $('.payment-section:first').clone();
        clonedSection.find('input, select').val('');
        
        // Update name attributes to ensure uniqueness
        clonedSection.find('input, select').each(function() {
            let name = $(this).attr('name').replace(/\[\d+\]/, `[${sectionCount}]`);
            $(this).attr('name', name);
        });

        // Remove any existing Select2 elements if initialized
        clonedSection.find('select').each(function() {
            if ($(this).hasClass('select2-hidden-accessible')) {
                $(this).select2('destroy'); // Only destroy if it's been initialized
            }
            $(this).removeClass('select2-hidden-accessible').next('.select2').remove(); // Cleanup
        });

        // Append the cloned section to the container
        $('#section-container').append(clonedSection);

        // Reinitialize Select2 on the newly cloned dropdowns
        clonedSection.find('select').addClass('select2');
        initializeSelect2(clonedSection);

        // Increment section counter
        sectionCount++;
    });

    // Remove section event handler
    $(document).on('click', '.remove-section', function() {
        if ($('.payment-section').length > 1) {
            $(this).closest('.payment-section').remove();
        } else {
            alert("At least one section is required.");
        }
    });
});


</script>
