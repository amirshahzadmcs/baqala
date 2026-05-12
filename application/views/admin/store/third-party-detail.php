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
input, textarea, select{
    pointer-events: none;
 }
.form-control {
	border: 1px solid #ededed !important;
 }
 .select2-container--default.select2-container--disabled .select2-selection--single {
    background-color: #fff !important;
    border-color: #eee !important;
}
</style>
<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Franchisee Management</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin');?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url();?>admin/store/list">Stores</a></li>
						<li class="breadcrumb-item active">Third Party Franchisee Detail</li>
					</ol>
				</div>
			</div>
			<?php  $admin_id= $this->session->userdata('admin_id'); ?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<a class="btn btn-custom-white btn-sm edit me-2 py-0 px-2" title="Print" href="admin/Store_third/print_third?id=<?php echo $id ?>" target="_blank"><i class="mdi mdi-printer font-size-18"></i></a>
					<a class="btn btn-sm btn-custom-white pull-right" title="Back" href="<?php echo base_url();?>admin/store/list"><i class="fa fa-reply"></i> Back</a>
					<a class="btn btn-sm btn-custom pull-right ms-1" onclick="loginDetail()" title="credentials" href="javascript:void(0)"><i class="fa fa-key"></i> Login Detail</a>
					<a class="btn btn-sm btn-custom-danger pull-right ms-1"  data-bs-toggle="modal" data-bs-target=".bs-changepassword-modal" href="javascript:void(0)"><i class="fa fa-key"></i> Change Password</a>
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
										<li class="nav-item">
											<a class="nav-link" data-bs-toggle="tab" href="#address" role="tab">
												<span class="d-block d-sm-none"><i class="fas fa-address-book"></i></span>
												<span class="d-none d-sm-block">Commision</span>
											</a>
										</li>
									</ul>

									<div class="tab-content py-3 text-muted">
										<div class="tab-pane active" id="home" role="tabpanel">
											<h4 class="header-title">Basic Information</h4>
											<p class="card-title-desc">Fill all information below</p>
											<input type="hidden" id="store_type" name="store_type" value="2" />
											<div class="row size-inner-section p-2">
												<h5 class="scheduler-border">Franchisee Legal Information:</h5>
												<div class="col-md-4  mb-3 form-group">
													<label for="store_name">Franchisee Name (English) <span class="required-field">*</span> :</label>
													<input type="text" class="form-control" id="store_name" name="store_name" onKeyPress="return Alpha(event);" value="<?php echo $store_name;?>" maxlength="150" required />
												</div>
												<div class="col-md-4  mb-3 form-group">
													<label for="store_name_arabic">Franchisee Name (Arabic) <span class="required-field">*</span> :</label>
													<input type="text" class="form-control" id="store_name_arabic" name="store_name_arabic" value="<?php echo $store_name_arabic;?>" maxlength="150" required />
												</div>
												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="store_id">Franchisee ID <span class="required-field">*</span></label>
													<input type="text" class="form-control" id="store_id" name="store_id" value="<?php echo $store_id;?>" maxlength="150" required />

												</div>
												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="store_incharge">Franchisee Incharge Name <span class="required-field">*</span></label>
													<input type="text" class="form-control" id="store_incharge" name="store_incharge" value="<?php echo $store_incharge;?>" onKeyPress="return Alpha(event);" maxlength="150" required />

												</div>
												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="brand_name">Brand Name <span class="required-field">*</span></label>
													<input type="text" class="form-control" id="brand_name" name="brand_name" value="<?php echo $brand_name;?>" onKeyPress="return Alpha(event);" maxlength="150" required />
												</div>
												
												<div class="col-md-4  mb-3 form-group">
													<label for="agrement_start">Agreement Start <span class="required-field">*</span></label>
													<input type="date" class="form-control" id="agrement_start" name="agrement_start" value="<?php echo $agrement_start;?>" required />
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
													<label for="contact_number">Franchisee Contact Number * :</label>
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
													<label for="status">Franchisee Status<span class="required-field">*</span></label>
													<select name="status"  class="form-control" disabled>
														<option value="1" <?php echo ($status == '1') ? "selected":"" ?>>Enable</option>
														<option value="0" <?php echo ($status == '0') ? "selected":"" ?>>Disable</option>
													</select>

												</div>
												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="store_radius">Set Radius for Devlivery</label>
													<input type="number" class="form-control" id="store_radius" placeholder="Enter delivery radius in KM for store" name="store_radius" min="1" max="50" value="<?php echo $store_radius;?>" required />

												</div>
												<?php if($id == ''){?>
												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="password">Set password for store</label>
													<input type="password" class="form-control" id="password" name="password" maxlength="120" required />

												</div>
												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="confirm_password">Confirm password for store</label>
													<input type="password" class="form-control" id="confirm_password" name="confirm_password" maxlength="120" required />
												</div>
												<?php } ?>
												<div class="col-md-8 col-sm-12 mb-3 form-group">
													<label for="store_location">Franchisee Complete Location <span class="required-field">*</span></label>
													<textarea rows="2" class="form-control" id="store_location" name="store_location" maxlength="150" required><?php echo $store_location;?></textarea>

												</div>
												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="email_invoice">Email For Invoicing <span class="required-field">*</span></label>
													<input type="email" class="form-control" id="email_invoice" name="email_invoice" value="<?php echo $email_invoice;?>" required>
												</div>
												<!-- <div class="col-md-8 col-sm-12 mb-3 form-group">
													<label for="trademark">Trademark <span class="required-field">*</span></label>
													<input type="text" class="form-control" id="trademark" name="trademark" maxlength="150" value="<?php echo $trademark;?>" required>
												</div> -->
												
											</div>
											<div class="row size-inner-section p-2">
												<h5 class="scheduler-border">Franchisee Contact Information:</h5>

												<div class="row">
													<h5 class="scheduler-border" style="font-size: 13px;">Owner:</h5>
													<div class="col-md-3  mb-3 form-group">
														<label for="other_name">Owner Name :</label>
														<input type="text" class="form-control" id="other_name" name="other_name" onKeyPress="return Alpha(event);" value="<?php echo $other_name;?>" maxlength="150" />
													</div>
													<div class="col-md-2  mb-3 form-group">
														<label for="other_position">Position :</label>
														<input type="text" class="form-control" id="other_position" name="other_position" onKeyPress="return Alpha(event);" value="<?php echo $other_position;?>" maxlength="150" />
													</div>
													<div class="col-md-2  mb-3 form-group">
														<label for="other_id">Id Number :</label>
														<input type="text" class="form-control" id="other_id" name="other_id" onkeypress="return numerics(event);" value="<?php echo $other_id;?>" maxlength="150" />
													</div>
													<div class="col-md-2  mb-3 form-group">
														<label for="other_mobile">Mobile No :</label>
														<input type="text" class="form-control" id="other_mobile" name="other_mobile" onkeypress="return numerics(event);" value="<?php echo $other_mobile;?>" maxlength="10" minlength="10" />
													</div>
													<div class="col-md-3  mb-3 form-group">
														<label for="other_email">Email ID :</label>
														<input type="email" class="form-control" id="other_email" name="other_email" value="<?php echo $other_email;?>" maxlength="150" />
													</div>
												</div>
												<div class="row">
													<h5 class="scheduler-border" style="font-size: 13px;">Sales Department:</h5>
													<div class="col-md-3  mb-3 form-group">
														<label for="sales_name">Person Name :</label>
														<input type="text" class="form-control" id="sales_name" name="sales_name" onKeyPress="return Alpha(event);" value="<?php echo $sales_name;?>" maxlength="150" />
													</div>
													<div class="col-md-2  mb-3 form-group">
														<label for="sales_position">Position :</label>
														<input type="text" class="form-control" id="sales_position" name="sales_position" onKeyPress="return Alpha(event);" value="<?php echo $sales_position;?>" maxlength="150" />
													</div>
													<div class="col-md-2  mb-3 form-group">
														<label for="sales_id">Id Number :</label>
														<input type="text" class="form-control" id="sales_id" name="sales_id" onkeypress="return numerics(event);" value="<?php echo $sales_id;?>" maxlength="150" />
													</div>
													<div class="col-md-2  mb-3 form-group">
														<label for="sales_mobile">Mobile No :</label>
														<input type="text" class="form-control" id="sales_mobile" name="sales_mobile" onkeypress="return numerics(event);" value="<?php echo $sales_mobile;?>" maxlength="15"  minlength="10" />
													</div>
													<div class="col-md-3  mb-3 form-group">
														<label for="sales_email">Email ID :</label>
														<input type="email" class="form-control" id="sales_email" name="sales_email" value="<?php echo $sales_email;?>" maxlength="150" />
													</div>
												</div>
												<div class="row">
													<h5 class="scheduler-border" style="font-size: 13px;">Finance Department:</h5>
													<div class="col-md-3  mb-3 form-group">
														<label for="finance_name">Person Name :</label>
														<input type="text" class="form-control" id="finance_name" name="finance_name" onKeyPress="return Alpha(event);" value="<?php echo $finance_name;?>" maxlength="150" />
													</div>
													<div class="col-md-2  mb-3 form-group">
														<label for="finance_position">Position :</label>
														<input type="text" class="form-control" id="finance_position" name="finance_position" onKeyPress="return Alpha(event);" value="<?php echo $finance_position;?>" maxlength="150" />
													</div>
													<div class="col-md-2  mb-3 form-group">
														<label for="finance_id">Id Number :</label>
														<input type="text" class="form-control" id="finance_id" name="finance_id" onkeypress="return numerics(event);" value="<?php echo $finance_id;?>" maxlength="150" />
													</div>
													<div class="col-md-2  mb-3 form-group">
														<label for="finance_mobile">Mobile No :</label>
														<input type="text" class="form-control" id="finance_mobile" name="finance_mobile" onkeypress="return numerics(event);" value="<?php echo $finance_mobile;?>"  maxlength="10"  minlength="10" />
													</div>
													<div class="col-md-3  mb-3 form-group">
														<label for="finance_email">Email ID :</label>
														<input type="email" class="form-control" id="finance_email" name="finance_email" value="<?php echo $finance_email;?>" maxlength="150" />
													</div>
												</div>
												<div class="row">
													<h5 class="scheduler-border" style="font-size: 13px;">Legal Department:</h5>
													<div class="col-md-3  mb-3 form-group">
														<label for="legal_name">Person Name :</label>
														<input type="text" class="form-control" id="legal_name" name="legal_name" onKeyPress="return Alpha(event);" value="<?php echo $legal_name;?>" maxlength="150" />
													</div>
													<div class="col-md-2  mb-3 form-group">
														<label for="legal_position">Position :</label>
														<input type="text" class="form-control" id="legal_position" name="legal_position" onKeyPress="return Alpha(event);" value="<?php echo $legal_position;?>" maxlength="150" />
													</div>
													<div class="col-md-2  mb-3 form-group">
														<label for="legal_id">Id Number :</label>
														<input type="text" class="form-control" id="legal_id" name="legal_id" onkeypress="return numerics(event);" value="<?php echo $legal_id;?>" maxlength="150" />
													</div>
													<div class="col-md-2  mb-3 form-group">
														<label for="legal_mobile">Mobile No :</label>
														<input type="text" class="form-control" id="legal_mobile" name="legal_mobile" onkeypress="return numerics(event);" value="<?php echo $legal_mobile;?>" maxlength="10"  minlength="10" />
													</div>
													<div class="col-md-3  mb-3 form-group">
														<label for="legal_email">Email ID :</label>
														<input type="email" class="form-control" id="legal_email" name="legal_email" value="<?php echo $legal_email;?>" maxlength="150" />
													</div>
												</div>
												
											</div>
											<div class="row size-inner-section p-2">
												<h5 class="scheduler-border">Franchisee National Address:</h5>
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
										</div>


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
															echo '<a href="'. base_url($cr_certificate) .'" target="_blank"><i class="fa fa-file-pdf fa-2x"></i></a>';
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
															echo '<a href="'. base_url($vat_certificate) .'" target="_blank"><i class="fa fa-file-pdf fa-2x"></i></a>';
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
															echo '<a href="'. base_url($national_address) .'" target="_blank"><i class="fa fa-file-pdf fa-2x"></i></a>';
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
															echo '<a href="'. base_url($iban_letter) .'" target="_blank"><i class="fa fa-file-pdf fa-2x"></i></a>';
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
															echo '<a href="'. base_url($credit_agreements) .'" target="_blank"><i class="fa fa-file-pdf fa-2x"></i></a>';
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
															echo '<a href="'. base_url($authorization) .'" target="_blank"><i class="fa fa-file-pdf fa-2x"></i></a>';
														}
													} ?>
												</div>
												<div class="col-md-4 mb-3 form-group">
													<label for="baladiya">Baladiya certificate :</label>
													<?php if($baladiya){
														$fileExt = pathinfo($baladiya, PATHINFO_EXTENSION);
														if($fileExt == 'jpg' || $fileExt == 'png' || $fileExt == 'JPG' || $fileExt == 'PNG'){
															echo '<img src="'. base_url($baladiya) .'" class="img-fluid p-2" width="100px" />';
														}else{
															echo '<a href="'. base_url($baladiya) .'" target="_blank"><i class="fa fa-file-pdf fa-2x"></i></a>';
														}
													} ?>
												</div>
												<div class="col-md-4 mb-3 form-group">
													<label for="franchisee">Franchisee Agreement :</label>
													<?php if($franchisee){
														$fileExt = pathinfo($franchisee, PATHINFO_EXTENSION);
														if($fileExt == 'jpg' || $fileExt == 'png' || $fileExt == 'JPG' || $fileExt == 'PNG'){
															echo '<img src="'. base_url($franchisee) .'" class="img-fluid p-2" width="100px" />';
														}else{
															echo '<a href="'. base_url($franchisee) .'" target="_blank"><i class="fa fa-file-pdf fa-2x"></i></a>';
														}
													} ?>
												</div>
											</div>
										</div>
										<div class="tab-pane" id="address" role="tabpanel">
											<div class="row size-inner-section p-2">
												<h5 class="scheduler-border">Commision:</h5>
												<hr>
												<div class="row">
													<h5 class="scheduler-border" style="font-size: 13px;">Slab 1:</h5>
													<div class="col-md-4  mb-3 form-group">
														<label for="cat_name_1">Name :</label>
														<input type="text" class="form-control" id="cat_name_1" name="cat_name_1" onKeyPress="return Alpha(event);" value="<?php echo $cat_name_1;?>" maxlength="150" />
													</div>
													<div class="col-md-4 mb-3 form-group">
														<label for="monthly_sub_1">Monthly Subscription :</label>
														<input type="text" class="form-control" id="monthly_sub_1" name="monthly_sub_1" minlength="1" maxlength="6" value="<?php echo $monthly_sub_1;?>" />
													</div>
													<div class="col-md-4 mb-3 form-group">
														<label for="online_payment_fee_1">Online Payment Fees :</label>
														<input type="text" class="form-control" id="online_payment_fee_1" name="online_payment_fee_1" minlength="1" maxlength="6" value="<?php echo $online_payment_fee_1;?>" />
													</div>
												</div>
												<div class="row">
													<h5 class="scheduler-border" style="font-size: 13px;">Slab 2:</h5>
													<div class="col-md-4  mb-3 form-group">
														<label for="cat_name_2">Name :</label>
														<input type="text" class="form-control" id="cat_name_2" name="cat_name_2" onKeyPress="return Alpha(event);" value="<?php echo $cat_name_2;?>" maxlength="150" />
													</div>
													<div class="col-md-4 mb-3 form-group">
														<label for="monthly_sub_2">Monthly Subscription :</label>
														<input type="text" class="form-control" id="monthly_sub_2" name="monthly_sub_2" minlength="1" maxlength="6" value="<?php echo $monthly_sub_2;?>" />
													</div>
													<div class="col-md-4 mb-3 form-group">
														<label for="online_payment_fee_2">Online Payment Fees :</label>
														<input type="text" class="form-control" id="online_payment_fee_2" name="online_payment_fee_2" minlength="1" maxlength="6" value="<?php echo $online_payment_fee_2;?>" />
													</div>
												</div>
												<div class="row">
													<h5 class="scheduler-border" style="font-size: 13px;">Slab 3:</h5>
													<div class="col-md-4  mb-3 form-group">
														<label for="cat_name_3">Name :</label>
														<input type="text" class="form-control" id="cat_name_3" name="cat_name_3" onKeyPress="return Alpha(event);" value="<?php echo $cat_name_3;?>" maxlength="150" />
													</div>
													<div class="col-md-4 mb-3 form-group">
														<label for="monthly_sub_3">Monthly Subscription :</label>
														<input type="text" class="form-control" id="monthly_sub_3" name="monthly_sub_3" minlength="1" maxlength="6" value="<?php echo $monthly_sub_3;?>" />
													</div>
													<div class="col-md-4 mb-3 form-group">
														<label for="online_payment_fee_3">Online Payment Fees :</label>
														<input type="text" class="form-control" id="online_payment_fee_3" name="online_payment_fee_3" minlength="1" maxlength="6" value="<?php echo $online_payment_fee_3;?>" />
													</div>
												</div>
												<div class="row">
													<h5 class="scheduler-border" style="font-size: 13px;">Slab 4:</h5>
													<div class="col-md-4  mb-3 form-group">
														<label for="cat_name_4">Name :</label>
														<input type="text" class="form-control" id="cat_name_4" name="cat_name_4" onKeyPress="return Alpha(event);" value="<?php echo $cat_name_4;?>" maxlength="150" />
													</div>
													<div class="col-md-4 mb-3 form-group">
														<label for="monthly_sub_4">Monthly Subscription :</label>
														<input type="text" class="form-control" id="monthly_sub_4" name="monthly_sub_4" minlength="1" maxlength="6" value="<?php echo $monthly_sub_4;?>" />
													</div>
													<div class="col-md-4 mb-3 form-group">
														<label for="online_payment_fee_4">Online Payment Fees :</label>
														<input type="text" class="form-control" id="online_payment_fee_4" name="online_payment_fee_4" minlength="1" maxlength="6" value="<?php echo $online_payment_fee_4;?>" />
													</div>
												</div>
											</div>
											<div class="row size-inner-section p-2">
												<h5 class="scheduler-border">Printers and Copy Services Fees:</h5>
												<hr>
												<div class="col-md-4 mb-3 form-group">
													<label for="price">Price :</label>
													<input type="text" class="form-control" id="price" name="price" maxlength="10" value="<?php echo $price;?>" onkeypress="return numerics(event);" />
												</div>
												<div class="col-md-4 mb-3 form-group">
													<label for="discount">Discount :</label>
													<input type="text" class="form-control" id="discount" name="discount" maxlength="10" value="<?php echo $discount;?>" onkeypress="return numerics(event);" />
												</div>
											</div>
										</div>

									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div> <!-- end col -->
		</div> <!-- end row -->
	</div>
</div>
<!-- container-fluid -->

<div class="col-md-12 col-sm-12 col-xs-12">

	<div class="x_panel">
		<div class="x_content">

		</div>
	</div>
</div>

<div class="modal fade bs-login-modal" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title mt-0">Login Credentials</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
					
				</button>
			</div>
			<div class="modal-body cred-modal-body">
				
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade bs-changepassword-modal" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title mt-0">Change Password</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<?php echo form_open("admin/store/password-change", array("id"=>"demo-form2", "class"=>"form-label-left", "data-parsley-validate"=> "")); ?>
					<input type="hidden" id="id" name="id" value="<?php echo $id;?>" />
					<input type="hidden" id="store_type" name="store_type" value="1" />
					<div class="row">
						<div class="col-md-12 col-sm-12 mb-3 form-group">
							<label for="password">Password <span class="required-field">*</span></label>
							<input type="password" class="form-control" id="password" name="password" minlength="6" maxlength="55" required />
							<p class="hint">Enter password minimum length 6.</p>
						</div>
						<div class="col-md-12 col-sm-12 mb-3 form-group">
							<label for="confirm_password">Confirm Password <span class="required-field">*</span></label>
							<input type="password" class="form-control" id="confirm_password" name="confirm_password" minlength="6" maxlength="55" required />
							<p class="hint">Enter confirm password.</p>
						</div>
						<div class="col-md-12 col-sm-12 mb-3 form-group">
							<button type="submit" class="btn btn-custom-success float-end">Change Password</button>
						</div>
					</div>
				<?php form_close();?>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php $this->load->view('admin/home/footer');?>
<script>
	function loginDetail(){
		var login_url = '<?php echo base_url('store/login') ?>';
		var store_id = '<?php echo $id;?>';
		// alert(store_id);
		$.ajax({
			type: "post",
			url: "<?php echo base_url();?>admin/store/login-detail",
			data: {'store_id': store_id},
			dataType: "json",
			success: function (response) {
				console.log(response);
				var content = '<p><strong>Login URL</strong>: '+ login_url +'</p><p><strong>Username:</strong> '+ response.user_id +'</p><p><strong>Password:</strong> '+ response.password +'</h5>';
				$('.bs-login-modal .cred-modal-body').html(content);
				//$("#login_d_btn").trigger("click");
				$(".bs-login-modal").modal('show');
			}
		});
	}
</script>
