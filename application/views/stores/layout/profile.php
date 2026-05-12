<?php $this->load->view('stores/layout/header');?>
<style>
input, textarea, select{
    pointer-events: none;
}
.nav-pills .nav-link.active, .nav-pills .show>.nav-link {
	color: #fff !important;
    background-color: #005500!important;
}
.nav-tabs-custom .nav-item .nav-link::after {
    content: "";
    background: #005500;
}
</style>
<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="main-content">
    <div class="page-content">
        <!-- start page title -->
        <div class="page-title-box">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <div class="page-title">
                            <h4>Manage Profile</h4>
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Profile</a></li>
                                <li class="breadcrumb-item active">Detail</li>
                            </ol>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="float-end d-none d-sm-block">
                            <!--<a href="<?php echo base_url('add-company');?>" class="btn btn-success btn-sm">Add Racks</a>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="container-fluid">
            <div class="page-content-wrapper">
                <div class="row">
                    <div class="col-3"><?php $this->load->view('stores/layout/profile-sidebar');?></div>
                    <div class="col-9">
                        <div class="card">
                            <div class="card-body" style="min-height: 506px;">
							<div id="addproduct-nav-pills-wizard" class="twitter-bs-wizard">
									<ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
										<li class="nav-item">
											<a class="nav-link active" data-bs-toggle="tab" href="#home" role="tab">
												<span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
												<span class="d-none d-sm-block">Basic Information</span>
											</a>
										</li>
										<?php if($store_type == '2'){?>
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
										<?php } ?>
									</ul>

									<div class="tab-content py-3 text-muted">
										<div class="tab-pane active" id="home" role="tabpanel">
											<div class="row size-inner-section p-2">
												<h4 class="header-title">Basic Information</h4>
												<h5 class="scheduler-border">Store Legal Information:</h5>
												<div class="col-md-4  mb-3 form-group">
													<label for="store_name">Store Name (English) <span class="required-field">*</span> :</label>
													<input type="text" class="form-control" id="store_name" name="store_name" onKeyPress="return Alpha(event);" value="<?php echo $store_name;?>" maxlength="150" required />
												</div>
												<div class="col-md-4  mb-3 form-group">
													<label for="store_name_arabic">Store Name (Arabic) <span class="required-field">*</span> :</label>
													<input type="text" class="form-control" id="store_name_arabic" name="store_name_arabic" value="<?php echo $store_name_arabic;?>" maxlength="150" required />
												</div>
												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="store_id">Store ID <span class="required-field">*</span></label>
													<input type="text" class="form-control" id="store_id" name="store_id" value="<?php echo $store_id;?>" maxlength="150" required />

												</div>
												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="store_incharge">Store Incharge Name <span class="required-field">*</span></label>
													<input type="text" class="form-control" id="store_incharge" name="store_incharge" value="<?php echo $store_incharge;?>" onKeyPress="return Alpha(event);" maxlength="150" required />

												</div>
												<div class="col-md-4  mb-3 form-group">
													<label for="agrement_expiry">Agreement Expiry :</label>
													<input type="date" class="form-control" id="agrement_expiry" name="agrement_expiry" value="<?php echo $agrement_expiry;?>" />
												</div>
												<div class="col-md-4  mb-3 form-group">
													<label for="cr_no">CR Number <span class="required-field">*</span> :</label>
													<input type="text" class="form-control" id="cr_no" name="cr_no" maxlength="30" value="<?php echo $cr_no;?>" required />
												</div>
												<div class="col-md-4  mb-3 form-group">
													<label for="cr_expiry">CR. Expiry :</label>
													<input type="date" class="form-control" id="cr_expiry" name="cr_expiry" value="<?php echo $cr_expiry;?>" />
												</div>
												<div class="col-md-4  mb-3 form-group">
													<label for="fax">FAX :</label>
													<input type="text" class="form-control" id="fax" name="fax" maxlength="15" value="<?php echo $fax;?>" />
												</div>
												<div class="col-md-4  mb-3 form-group">
													<label for="vat_no">VAT Number <span class="required-field">*</span> :</label>
													<input type="text" class="form-control" id="vat_no" name="vat_no" value="<?php echo $vat_no;?>" maxlength="30" required />
												</div>
												<div class="col-md-4  mb-3 form-group">
													<label for="fullname">VAT Expiry :</label>
													<input type="date" class="form-control" id="vat_expiry" name="vat_expiry" value="<?php echo $vat_expiry;?>" />
												</div>
												<div class="col-md-4  mb-3 form-group">
													<label for="contact_number">Store Contact Number * :</label>
													<input type="text" class="form-control" id="contact_number" name="contact_number" onkeypress="return numerics(event);" maxlength="15" value="<?php echo $contact_number;?>" />
												</div>
												<div class="col-md-4  mb-3 form-group">
													<label for="email">Email ID :</label>
													<input type="email" class="form-control" id="email" name="email" value="<?php echo $email;?>" maxlength="150" />
												</div>
												<div class="col-md-4 mb-3 form-group">
													<label for="website">Website :</label>
													<input type="text" class="form-control" id="website" name="website" value="<?php echo $website;?>" maxlength="150" />
												</div>
												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="google_coordinates_lat">Google Coordinates (Latitude)</label>
													<input type="text" class="form-control" id="google_coordinates_lat" name="google_coordinates_lat" maxlength="150" value="<?php echo $google_coordinates_lat;?>" />

												</div>
												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="google_coordinates_long">Google Coordinates (Longitude)</label>
													<input type="text" class="form-control" id="google_coordinates_long" name="google_coordinates_long" maxlength="150" value="<?php echo $google_coordinates_long;?>" />

												</div>
												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="status">Store Status<span class="required-field">*</span></label>
													<select name="status"  class="form-control" disabled>
														<option value="1" <?php echo ($status == '1') ? "selected":"" ?>>Enable</option>
														<option value="0" <?php echo ($status == '0') ? "selected":"" ?>>Disable</option>
													</select>

												</div>
												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="store_radius">Set Radius for Devlivery</label>
													<input type="number" class="form-control" id="store_radius" placeholder="Enter delivery radius in KM for store" name="store_radius" min="1" max="50" value="<?php echo $store_radius;?>" required />

												</div>
												
												<div class="col-md-8 col-sm-12 mb-3 form-group">
													<label for="store_location">Store Complete Location <span class="required-field">*</span></label>
													<textarea rows="2" class="form-control" id="store_location" name="store_location" maxlength="150" required><?php echo $store_location;?></textarea>

												</div>
												
											</div>
											<?php if($store_type == '2'){?>
											<div class="row size-inner-section p-2">
												<h5 class="scheduler-border">Store Contact Information:</h5>
												
												<div class="row">
													<h5 class="scheduler-border" style="font-size: 13px;">Sales Department:</h5>
													<div class="col-md-4  mb-3 form-group">
														<label for="sales_name">Person Name :</label>
														<input type="text" class="form-control" id="sales_name" name="sales_name" onKeyPress="return Alpha(event);" value="<?php echo $sales_name;?>" maxlength="150" />
													</div>
													<div class="col-md-4  mb-3 form-group">
														<label for="sales_mobile">Mobile No :</label>
														<input type="text" class="form-control" id="sales_mobile" name="sales_mobile" onkeypress="return numerics(event);" value="<?php echo $sales_mobile;?>" maxlength="15"  minlength="10" />
													</div>
													<div class="col-md-4  mb-3 form-group">
														<label for="sales_email">Email ID :</label>
														<input type="email" class="form-control" id="sales_email" name="sales_email" value="<?php echo $sales_email;?>" maxlength="150" />
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
														<input type="text" class="form-control" id="finance_mobile" name="finance_mobile" onkeypress="return numerics(event);" value="<?php echo $finance_mobile;?>"  maxlength="15"  minlength="10" />
													</div>
													<div class="col-md-4  mb-3 form-group">
														<label for="finance_email">Email ID :</label>
														<input type="email" class="form-control" id="finance_email" name="finance_email" value="<?php echo $finance_email;?>" maxlength="150" />
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
														<input type="text" class="form-control" id="legal_mobile" name="legal_mobile" onkeypress="return numerics(event);" value="<?php echo $legal_mobile;?>" maxlength="15"  minlength="10" />
													</div>
													<div class="col-md-4  mb-3 form-group">
														<label for="legal_email">Email ID :</label>
														<input type="email" class="form-control" id="legal_email" name="legal_email" value="<?php echo $legal_email;?>" maxlength="150" />
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
														<input type="text" class="form-control" id="other_mobile" name="other_mobile" onkeypress="return numerics(event);" value="<?php echo $other_mobile;?>" maxlength="15" minlength="10" />
													</div>
													<div class="col-md-4  mb-3 form-group">
														<label for="other_email">Email ID :</label>
														<input type="email" class="form-control" id="other_email" name="other_email" value="<?php echo $other_email;?>" maxlength="150" />
													</div>
												</div>
											</div>
											<div class="row size-inner-section p-2">
												<h5 class="scheduler-border">Store National Address:</h5>
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
													<select id="city" name="city" class="form-control col-md-12 select2" disabled>
														<option value="">Select City</option>
														<?php foreach($master_cities as $master_city){?>
														<option value="<?php echo $master_city->id;?>" <?php echo ($city == $master_city->id) ? "selected":"";?>><?php echo $master_city->city_name;?></option>
														<?php } ?>
													</select>
												</div>
												<div class="col-md-4  mb-3 form-group">
													<label for="country">Country :</label>
													<select id="country" name="country" class="form-control col-md-12 select2" disabled>
														<option value="">Selct Country</option>
														<option value="Saudi Arabia" <?php echo ($country == 'Saudi Arabia') ? "selected":"";?>>Saudi Arabia</option>
													</select>
												</div>
												<div class="col-md-4  mb-3 form-group">
													<label for="postal_code">Zip Code :</label>
													<input type="text" class="form-control" id="postal_code" name="postal_code" value="<?php echo $postal_code;?>" onkeypress="return numerics(event);" maxlength="7" minlength="5" />
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
													<label for="payment_terms">Payment Terms <span class="required-field">*</span> :</label>
													<select id="payment_terms" name="payment_terms" class="form-control col-md-12 select2" disabled>
														<option value="">Select Payment Terms</option>
														<option value="Cash" <?php echo ($payment_terms == 'Cash') ? "selected":"";?>>Cash</option>
														<option value="Credit" <?php echo ($payment_terms == 'Credit') ? "selected":"";?>>Credit</option>
														<option value="Online" <?php echo ($payment_terms == 'Online') ? "selected":"";?>>Online</option>
													</select>
												</div>
												<div class="col-md-4  mb-3 form-group">
													<label for="order_currency">Order Currency :</label>
													<select id="order_currency" name="order_currency" class="form-control col-md-12 select2" disabled>
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
											<?php } ?>
										</div>

										<?php if($store_type == '2'){?>
										<div class="tab-pane" id="profile1" role="tabpanel">
											<div class="row size-inner-section p-2">
												<h5 class="scheduler-border">Payment & Delivery Information:</h5>
												<div class="col-md-4 mb-3 form-group">
													<label for="account_holder_name">Account Holder Name :</label>
													<input type="text" class="form-control" id="account_holder_name" name="account_holder_name" maxlength="150" value="<?php echo $account_holder_name;?>" />
												</div>
												<div class="col-md-4 mb-3 form-group">
													<label for="bank_account_no">Bank Account No :</label>
													<input type="text" class="form-control" id="bank_account_no" name="bank_account_no" onkeypress="return numerics(event);" maxlength="50" value="<?php echo $bank_account_no;?>" />
												</div>
												<div class="col-md-4 mb-3 form-group">
													<label for="iban_number">IBAN Number :</label>
													<input type="text" class="form-control" id="iban_number" name="iban_number" maxlength="50" value="<?php echo $iban_number;?>" />
												</div>
												<div class="col-md-4 mb-3 form-group">
													<label for="bank_name">Bank Name :</label>
													<select id="bank_name" name="bank_name" class="form-control col-md-12 select2" disabled>
														<option value="">Select Bank</option>
														<option value="Al Rajhi Bank" <?php echo ($bank_name == 'Al Rajhi Bank') ? "selected":"";?>>Al Rajhi Bank</option>
														<option value="Alinma bank" <?php echo ($bank_name == 'Alinma bank') ? "selected":"";?>>Alinma bank</option>
														<option value="Arab National Bank" <?php echo ($bank_name == 'Arab National Bank') ? "selected":"";?>>Arab National Bank</option>
														<option value="Bank AlBilad" <?php echo ($bank_name == 'Bank AlBilad') ? "selected":"";?>>Bank AlBilad</option>
														<option value="Bank AlJazira" <?php echo ($bank_name == 'Bank AlJazira') ? "selected":"";?>>Bank AlJazira</option>
														<option value="Banque Saudi Fransi" <?php echo ($bank_name == 'Banque Saudi Fransi') ? "selected":"";?>>Banque Saudi Fransi</option>
														<option value="Gulf International Bank Saudi Arabia (GIB-SA)" <?php echo ($bank_name == 'Gulf International Bank Saudi Arabia (GIB-SA)') ? "selected":"";?>>Gulf International Bank Saudi Arabia (GIB-SA)</option>
														<option value="Riyad Bank" <?php echo ($bank_name == 'Riyad Bank') ? "selected":"";?>>Riyad Bank</option>
														<option value="Saudi Investment Bank" <?php echo ($bank_name == 'Saudi Investment Bank') ? "selected":"";?>>Saudi Investment Bank</option>
														<option value="Saudi National Bank" <?php echo ($bank_name == 'Saudi National Bank') ? "selected":"";?>>Saudi National Bank</option>
														<option value="The Saudi British Bank (SABB)" <?php echo ($bank_name == 'The Saudi British Bank (SABB)') ? "selected":"";?>>The Saudi British Bank (SABB)</option>
													</select>
												</div>
												<div class="col-md-4 mb-3 form-group">
													<label for="branch_name">Branch Name :</label>
													<input type="text" class="form-control" id="branch_name" name="branch_name" onKeyPress="return Alpha(event);" maxlength="250" value="<?php echo $branch_name;?>" />
												</div>
												<div class="col-md-4 mb-3 form-group">
													<label for="region">Region :</label>
													<select id="region" name="region" class="form-control col-md-12 select2" disabled>
														<option value="">Select Region</option>
														<option value="Central Region" <?php echo ($region == 'Central Region') ? "selected":"";?>>Central Region</option>
														<option value="Eastern Region" <?php echo ($region == 'Eastern Region') ? "selected":"";?>>Eastern Region</option>
														<option value="Western Region" <?php echo ($region == 'Western Region') ? "selected":"";?>>Western Region</option>
														<option value="Southern Region" <?php echo ($region == 'Southern Region') ? "selected":"";?>>Southern Region</option>
													</select>
												</div>
												<div class="col-md-4 mb-3 form-group">
													<label for="account_currency">Account Currency :</label>
													<select id="account_currency" name="account_currency" class="form-control col-md-12 select2" disabled>
														<option value="">Select Currency</option>
														<option value="SAR" <?php echo ($account_currency == 'SAR') ? "selected":"";?>>SAR</option>
														<option value="INR" <?php echo ($account_currency == 'INR') ? "selected":"";?>>INR</option>
														<option value="USD" <?php echo ($account_currency == 'USD') ? "selected":"";?>>USD</option>
														<option value="EUR" <?php echo ($account_currency == 'EUR') ? "selected":"";?>>EUR</option>
													</select>
												</div>
												<div class="col-md-4 mb-3 form-group">
													<label for="swift_code">Swift / Sarie Code :</label>
													<input type="text" class="form-control" id="swift_code" name="swift_code" maxlength="50" value="<?php echo $swift_code;?>" />
												</div>
												<div class="col-md-4 mb-3 form-group">
													<label for="bank_city">City :</label>
													<select id="bank_city" name="bank_city" class="form-control col-md-12 select2" disabled>
														<option value="">Select City</option>
														<?php foreach($master_cities as $master_city){?>
														<option value="<?php echo $master_city->id;?>" <?php echo ($bank_city == $master_city->id) ? "selected":"";?>><?php echo $master_city->city_name;?></option>
														<?php } ?>
													</select>
												</div>
											</div>
										</div>

										<div class="tab-pane" id="messages1" role="tabpanel">
											<div class="row size-inner-section p-2">
												<h5 class="scheduler-border">Upload Documents</h5>
												<div class="col-md-4 mb-3 form-group">
													<label for="cr_certificate">CR. Certificate :</label>
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
										<?php } ?>
									</div>
								</div>
							</div>
                        </div>
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>
        </div>
        <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
</div>
<!-- end page content-->
<?php $this->load->view('stores/layout/footer');?>

<script></script>
