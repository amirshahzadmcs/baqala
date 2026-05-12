<?php $this->load->view('logistic/layout/header');?>
<style>
#wait{
	display: none;
    width: 100%;
    height: 100%;
    position: fixed;
    padding: 2px;
    z-index: 9999;
    background: #ffffffde;
    text-align: center;
    padding-top: 17%;
    top: 0;
    bottom: 0;
}
.page-content-wrapper label {
    color: #252525;
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
/*---- Image Upload -----*/
.upload-div{
	margin:auto;
	background-color: #fff;
	color: #333;
    padding: 12px;
	box-shadow: 0 0px 10px 1px rgba(0,0,0,0.16), 0 2px 10px 0 rgba(0,0,0,0.12);
	font-size: 16px;
}
.upload-div h4{
	text-align: center;
	text-transform: uppercase;
	font-size: 18px;
	color: #666;
	margin-top: 0;
}

.upload-div [type="file"] + label {
    background: #e3e3e3;
    border: none;
    border-radius: 5px;
    color: #1e1e1e;
    cursor: pointer;
    display: inline-block;
    font-size: 14px;
    font-weight: 500;
    outline: none;
    padding: 5px 10px;
    position: relative;
    transition: all 0.3s;
    vertical-align: middle;
    width: 100%;
    text-align: center;
}
.upload-div [type="file"] + label:hover {
	background: #ffc107;
	content: 'Select File';
}
.upload-div input[type="file"] {
	height: 0;
	overflow: hidden;
	width: 0;
}
.upload-div input[type="file"]:focus {
    color: #495057;
    background-color: #fff;
    border-color: #80bdff;
    outline: 0;
    box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
}
.prfile-preview {
    height: 130px;
    border: 1px dashed #aaa;
	text-align: center;
}
.prfile-preview img{
	width: 120px;
	height: 120px;
	text-align: center;
	vertical-align: middle;
}
.progress {
    display: -ms-flexbox;
    display: flex;
    height: 20px;
    overflow: hidden;
    font-size: .75rem;
    background-color: #e9ecef;
    border-radius: .25rem;
	margin-top: 10px;
}
.progress-bar, .progress-bar-1, .progress-bar-2, .progress-bar-3, .progress-bar-4, .progress-bar-5, .progress-bar-6, .progress-bar-7, .progress-bar-8, .progress-bar-9, .progress-bar-10, .progress-bar-11, .progress-bar-12 {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-direction: column;
    flex-direction: column;
    -ms-flex-pack: center;
    justify-content: center;
    overflow: hidden;
    color: #fff;
    text-align: center;
    white-space: nowrap;
    background-color: #28a745;
    transition: width .6s ease;
	font-size: 16px;
	text-align: center;
}

#uploadStatus, #uploadStatus1, #uploadStatus2, #uploadStatus3, #uploadStatus4, #uploadStatus5, #uploadStatus6, #uploadStatus7, #uploadStatus8, #uploadStatus9, #uploadStatus10, #uploadStatus11, #uploadStatus12{
	/*padding: 10px 20px;
    margin-top: 10px;*/
	font-size:18px;
	text-align: center;
}

.uploaded-preview{
	height: 279px;
	border: 1px dashed #aaa;
	text-align: center;	
	padding: 10px;
	vertical-align: middle;
	overflow: hidden;
}
input, textarea, select, .select2{
    pointer-events: none;
}
.form-control {
	border: 1px solid #ededed !important;
 }
 .select2-container--default.select2-container--disabled .select2-selection--single {
    background-color: #fff !important;
    border-color: #eee !important;
	pointer-events: none;
}
.change-password-modal input{
	pointer-events: initial;
}
.change-password-modal .form-control{
	border: 1px solid #cfcfcf !important;
}
@media (max-width: 425px){
	#wait img {
		margin-top: 40%;
	}
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
                                <li class="breadcrumb-item"><a href="<?= base_url('logistic-partner');?>">Dashboard</a></li>
                                <li class="breadcrumb-item active">Profile</li>
                            </ol>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="float-end d-none d-sm-block">
							<a class="btn btn-sm btn-custom-white pull-right me-1" title="Back" href="<?php echo base_url('logistic-partner');?>"><i class="fa fa-reply"></i> Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="container-fluid">
            <div class="page-content-wrapper">
                <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-12"><?php $this->load->view('logistic/layout/profile-sidebar');?></div>
                    <div class="col-lg-9 col-md-9 col-sm-12">
                        <div class="card">
							<div class="card-body" style="min-height: 506px;">
								<?php if($application_status == 'unverified'){?>
								<div class="alert alert-warning" role="alert">
									This account in waiting for verification.
								</div>
								<?php } ?>
								<div id="addproduct-nav-pills-wizard" class="twitter-bs-wizard">
									<ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
										<li class="nav-item">
											<a class="nav-link active" data-bs-toggle="tab" href="#profileTab" role="tab">
												<span class="d-block d-sm-none"><i class="fas fa-user"></i></span>
												<span class="d-none d-sm-block">Profile</span>
											</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" data-bs-toggle="tab" href="#vehicleTab" role="tab">
												<span class="d-block d-sm-none"><i class="fas fa-car"></i></span>
												<span class="d-none d-sm-block">Vehicle</span>
											</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" data-bs-toggle="tab" href="#bankTab" role="tab">
												<span class="d-block d-sm-none"><i class="fas fa-university"></i></span>
												<span class="d-none d-sm-block">Bank Account</span>
											</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" data-bs-toggle="tab" href="#documentsTab" role="tab">
												<span class="d-block d-sm-none"><i class="dripicons-document"></i></span>
												<span class="d-none d-sm-block">Documents</span>
											</a>
										</li>
									</ul>

									<div class="tab-content py-3 text-muted">
										<div class="tab-pane active" id="profileTab" role="tabpanel">
											
											<div class="row size-inner-section p-2">
												<?php if($profile_info_status == '0'){?>
												<div class="alert alert-info" role="alert">Incomplete basic information.</div>
												<?php } ?>
												<div class="col-md-4 mb-3 form-group">
													<label for="region_id">Region </label>
													<select id="region_id" name="region_id" class="form-control col-md-12" required>
														<option value="">Select Region</option>
														<?php foreach(getRegions() as $master_region){?>
														<option value="<?php echo $master_region->id;?>" data-id="<?php echo $master_region->id;?>" <?php echo ($region_id == $master_region->id) ? "selected":"";?>><?php echo $master_region->region_name;?></option>
														<?php } ?>
													</select>
												</div>

												<div class="col-md-4 mb-3 form-group">
													<label for="city">City Name </label>
													<input type="text" class="form-control" value="<?= $city_name; ?>" />
												</div>

												<div class="col-md-4 mb-3 form-group">
													<label for="district">District Name </label>
													<input type="text" class="form-control" id="district" name="district" onKeyPress="return Alpha(event);" value="<?= $district; ?>" required maxlength="150" />
												</div>

												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="name">Rider Name (English)</label>
													<input type="text" class="form-control" id="name" name="name" onKeyPress="return Alpha(event);" value="<?= $name; ?>" maxlength="150"  required />
													<small class="hint">Enter display name for Rider</small>
												</div>
												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="arabic_name">Rider Name (Arabic)</label>
													<input type="text" class="form-control rtl-input" id="arabic_name" name="arabic_name" value="<?= $arabic_name; ?>" maxlength="150" required />
													<small class="hint">Enter display name for Rider in arabic</small>
												</div>

												<div class="col-md-4 mb-3 form-group">
													<label for="email">Rider Email </label>
													<input type="email" class="form-control" id="email" name="email" value="<?= $email; ?>" required maxlength="150" />
												</div>
												
												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="mobile">Mobile Number</label>
													<input type="text" class="form-control" id="mobile" name="mobile" onkeypress="return numerics(event);" value="<?= $mobile; ?>" minlength="<?= MOB_LENGTH ;?>" maxlength="<?= MOB_LENGTH ;?>"  required />
													<small class="hint">Format 651 234 5678</small>
												</div>
												
												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="dob">Date of Birth</label>
													<input type="text" class="form-control" id="dob" name="dob" max="<?php echo date("Y-m-d"); ?>" value="<?= $dob; ?>" required />
													<small class="hint">Enter date of birth</small>
												</div>
												
												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="marital_status">Marital Status</label>
													<select name="marital_status"  class="form-control" required>
														<option value="">Select Marital Status</option>
														<option value="1" <?php echo ($marital_status == '1') ? "selected":"";?>>Single</option>
														<option value="0" <?php echo ($marital_status == '0') ? "selected":"";?>>Married</option>
														<!-- <option value="2" <?php //echo ($marital_status == '2') ? "selected":"";?>>Divorced</option> -->
													</select>
													<small class="hint">Set marital status for your Rider</small>
												</div>

												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="nationality">Nationality</label>
													<select id="nationality" name="nationality" class="form-control col-md-12" required>
														<option value="">Select Nationality</option>
														<?php foreach(nationalityList() as $master_nationality){?>
														<option value="<?php echo $master_nationality->name;?>" data-id="<?php echo $master_nationality->name;?>" <?php echo ($nationality == $master_nationality->name) ? "selected":"";?>><?php echo $master_nationality->name;?></option>
														<?php } ?>
													</select>
													<small class="hint">Select rider nationality</small>
												</div>
												
												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="passport">Passport Number</label>
													<input type="text" class="form-control" id="passport" name="passport"  minlength="8" maxlength="<?= PASSPORT_LENGTH;?>" value="<?= $passport; ?>" required="required" />
													<small class="hint">Enter passport number</small>
													<span id="errmsgadhar" class="err-msg"></span>
												</div>
												
												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="passport_expiry">Passport Expiry Date</label>
													<input type="text" class="form-control" id="passport_expiry" name="passport_expiry" min="<?php echo date("Y-m-d"); ?>" value="<?= $passport_expiry; ?>" required />
													<small class="hint">Enter passport expiry date</small>
												</div>

												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="iqama_no">Iqama No</label>
													<input type="text" class="form-control" id="iqama_no" name="iqama_no"  minlength="<?= ICAMA_LENGTH ;?>" maxlength="<?= ICAMA_LENGTH ;?>" value="<?= $iqama_no; ?>" required />
													<small class="hint">Enter Iqama No for delivery boy</small>
												</div>

												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="iqama_exp">Iqama Expiry Date</label>
													<input type="text" class="form-control" id="iqama_exp" name="iqama_exp" min="<?php echo date("Y-m-d"); ?>" value="<?= $iqama_exp; ?>" required />
													<small class="hint">Enter Iqama expiry date</small>
												</div>
												
												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="dl_no">Driving License No</label>
													<input type="text" class="form-control" id="dl_no" name="dl_no" minlength="<?= DL_LENGTH ;?>" maxlength="<?= DL_LENGTH ;?>" value="<?= $dl_no; ?>" required="required" />
													<small class="hint">Enter driving license no</small>
													<span id="errmsgadhar" class="err-msg"></span>
												</div>
												
												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="dl_expiry">Driving License Expiry</label>
													<input type="text" class="form-control" id="dl_expiry" name="dl_expiry" min="<?php echo date("Y-m-d"); ?>" value="<?= $dl_expiry; ?>" required />
													<small class="hint">Enter driving license expiry date</small>
												</div>
												
												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="sponsor_name">Sponsor Name </label>
													<input type="text" id="sponsor_name" name="sponsor_name" maxlength="198"  class="form-control" value="<?= $sponsor_name; ?>" required>
													<small class="hint">Enter sponsor name for Rider</small>
												</div>

												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="profession">Profession </label>
													<select name="profession" id="profession" class="form-control" required>
														<option value="">Select Profession</option>
														<?php foreach(professionList() as $professions){?>
														<option value="<?php echo $professions->id;?>" <?php echo ($profession == $professions->id) ? "selected":"";?>><?php echo $professions->profession_name;?></option>
														<?php } ?>
													</select>
													<small class="hint">Enter profession for Rider</small>
												</div>

												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="doj">Date Of Joining </label>
													<input type="text" class="form-control" id="doj" name="doj" value="<?php echo $doj;?>" required="required" />
													<small class="hint">Enter rider date of joining</small>
													<span id="errmsgadhar" class="err-msg"></span>
												</div>

												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="partner_id">Logistic Partner </label>
													<select name="partner_id" id="partner_id" class="form-control" required>
														<option value="">Not Assigned</option>
														<?php foreach(logisticPartnerList() as $partners){?>
														<option value="<?php echo $partners->id;?>" <?php echo ($partners->id == $partner_id) ? "selected":"";?>><?php echo $partners->cname;?></option>
														<?php } ?>
													</select>
													<small class="hint">Select logistic partner belong to Rider</small>
												</div>

												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="service_area">Service Area </label>
													<select name="service_area" id="service_area" class="form-control" required>
														<option value="">Not Assigned</option>
														<?php foreach(areaList() as $areas){?>
														<option value="<?php echo $areas->id;?>" <?php echo ($areas->id == $service_area) ? "selected":"";?>><?php echo $areas->area_name;?></option>
														<?php } ?>
													</select>
													<small class="hint">Enter service area for Rider</small>
												</div>

												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="status">Status</label>
													<select class="form-control" required>
														<option value="">Select Status</option>
														<option value="1" <?php echo ($status == '1') ? "selected":"";?>>Active</option>
														<option value="0" <?php echo ($status == '0') ? "selected":"";?>>Deactive</option>
														<option value="2" <?php echo ($status == '2') ? "selected":"";?>>Block</option>
													</select>
													<small class="hint">Set status for your Rider</small>
												</div>
												
											</div>
											
										</div>

										<div class="tab-pane" id="vehicleTab" role="tabpanel">
											
											<div class="row size-inner-section p-2">
												<?php if($vehicle_info_status == '0'){?>
												<div class="alert alert-info" role="alert">Incomplete vehicle information.</div>
												<?php } ?>
												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="service_type">Service Type</label>
													<select name="service_type" id="service_type" class="form-control" required>
														<option value="">Select Service</option>
														<option value="bike" <?php echo ($service_type == 'bike') ? "selected":"";?>>Bike</option>
														<option value="car" <?php echo ($service_type == 'car') ? "selected":"";?>>Car</option>
													</select>
													<small class="hint">Select service type</small>
												</div>

												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="van_no">Vehicle Plate Number </label>
													<input type="text" id="van_no" name="van_no" minlength="7" maxlength="7" required="required" value="<?= $van_no; ?>" class="form-control">
													<small class="hint">Enter vehicle plate number</small>
												</div>
												
												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="vehicle_expiry">Vehicle Expiry Date</label>
													<input type="text" class="form-control" id="vehicle_expiry" name="vehicle_expiry" min="<?php echo date("Y-m-d"); ?>" value="<?= $vehicle_expiry; ?>" required />
													<small class="hint">Enter vehicle expiry date</small>
												</div>
												
												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="vehicle_year">Vehicle Year </label>
													<select name="vehicle_year" id="vehicle_year" class="form-control" required>
														<option value="">Select Vehicle Year</option>
														<?php 
															//$year_start  = 2001;
															$year_start  = (date('Y') - 6);
															$year_end = date('Y'); // current Year
															$vehicle_year = $vehicle_year; // user selected date
														
															for ($i_year = $year_start; $i_year <= $year_end; $i_year++) {
																$selected = ($vehicle_year == $i_year ? ' selected' : '');
																echo '<option value="'.$i_year.'"'.$selected.'>'.$i_year.'</option>'."\n";
															}
														?>
													</select>
													<small class="hint">Enter vehicle year of Rider</small>
												</div>
												
												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="van_make">Vehicle Make </label>
													<input type="text" id="van_make" name="van_make" value="<?= $make_name; ?>" class="form-control">
													<small class="hint">Vehicle make of Rider</small>
												</div>
												
												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="van_model">Vehicle Type </label>
													<input type="text" id="van_model" name="van_model" value="<?= $van_model; ?>" class="form-control">
													<small class="hint">Vehicle type</small>
												</div>

												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="van_color">Vehicle Color </label>
													<select name="van_color" id="van_color" class="form-control" required>
														<option value="">Select Vehicle Color</option>
														<?php foreach(colorList() as $color){?>
														<option value="<?php echo $color->id;?>" <?php echo ($van_color == $color->id) ? "selected":"";?>><?php echo $color->color_name;?></option>
														<?php } ?>
													</select>
													<small class="hint">Enter vehicle colour of Rider</small>
												</div>
												
											</div>
											
										</div>

										<div class="tab-pane" id="bankTab" role="tabpanel">
											
											<div class="row size-inner-section p-2">
												<?php if($bank_info_status == '0'){?>
												<div class="alert alert-info" role="alert">Incomplete bank information.</div>
												<?php } ?>

												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="bank_name">Bank Name</label>
													<select name="bank_name" id="bank_name" class="form-control" required>
														<option value="">Select Bank</option>
														<?php foreach(bankList() as $banks){?>
														<option value="<?php echo $banks->id;?>" <?php echo ($bank_name == $banks->id) ? "selected":"";?>><?php echo $banks->bank_name;?></option>
														<?php } ?>
													</select>
													<small class="hint">Enter bank name belong to Rider</small>
												</div>
												
												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="iban">IBAN No</label>
													<input type="text" class="form-control" id="iban" name="iban" minlength="<?= IBAN_LENGTH ;?>" maxlength="<?= IBAN_LENGTH ;?>" value="<?= $iban;?>" required />
													<small class="hint">Enter IBAN No of Rider</small>
												</div>

												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="stc_pay_no">STC Pay No</label>
													<input type="text" class="form-control" id="stc_pay_no" name="stc_pay_no" minlength="<?= STC_PAY_LENGTH ;?>" maxlength="<?= STC_PAY_LENGTH ;?>" value="<?= $stc_pay_no;?>" required="required" />
													<small class="hint">Enter STC Pay number</small>
													<span id="errmsgadhar" class="err-msg"></span>
												</div>
												
											</div>
										</div>

										<div class="tab-pane" id="documentsTab" role="tabpanel">
											<div class="row size-inner-section p-2">
												<?php if($doc_info_status == '0'){?>
												<div class="alert alert-info" role="alert">Incomplete documents.</div>
												<?php } ?>
												<div class="col-md-3 col-sm-12 mb-3 form-group">
													<div class="upload-div">
														<label class="font-size-11" style="margin-bottom: 27px;">Profile Picture (white background) </label>
														<div class="prfile-preview"><img id="fileInputphoto" src="<?= (!empty($documents->profile_picture)) ? base_url($documents->profile_picture) : base_url('images/no-image-icon.png');?>" /></div>
														<!-- File upload form -->
														
													</div>
												</div>

												<div class="col-md-3 col-sm-12 mb-3 form-group">
													<div class="upload-div">
														<!-- File upload form -->
														<label class="font-size-11" style="margin-bottom: 27px;">Iqama Image Front </label>
														<div class="prfile-preview"><img id="fileInput1photo" src="<?= (!empty($documents->iqama_image_front)) ? base_url($documents->iqama_image_front) : base_url('images/no-image-icon.png');?>" /></div>
														
													</div>
												</div>

												<div class="col-md-3 col-sm-12 mb-3 form-group">
													<div class="upload-div">
														<!-- File upload form -->
														<label class="font-size-11" style="margin-bottom: 27px;">Iqama Image Back </label>
														<div class="prfile-preview"><img id="fileInput2photo" src="<?= (!empty($documents->iqama_image_back)) ? base_url($documents->iqama_image_back) : base_url('images/no-image-icon.png');?>" /></div>
														
													</div>
												</div>

												<div class="col-md-3 col-sm-12 mb-3 form-group">
													<div class="upload-div">
														<!-- File upload form -->
														<label class="font-size-11" style="margin-bottom: 27px;">Driving Licence Front </label>
														<div class="prfile-preview"><img id="fileInput3photo" src="<?= (!empty($documents->driving_licence_front)) ? base_url($documents->driving_licence_front) : base_url('images/no-image-icon.png');?>" /></div>
														
													</div>
													
												</div>

												<div class="col-md-3 col-sm-12 mb-3 form-group">
													<div class="upload-div">
														<!-- File upload form -->
														<label class="font-size-11" style="margin-bottom: 27px;">Driving Licence Back </label>
														<div class="prfile-preview"><img id="fileInput4photo" src="<?= (!empty($documents->driving_licence_back)) ? base_url($documents->driving_licence_back) : base_url('images/no-image-icon.png');?>" /></div>
														
													</div>
												</div>
												
												<div class="col-md-3 col-sm-12 mb-3 form-group">
													<div class="upload-div">
														<!-- File upload form -->
														<label class="mb-2 font-size-11">IBAN Certificate (Account name and bank name must be clear) </label>
														<div class="prfile-preview"><img id="fileInput5photo" src="<?= (!empty($documents->iban_certificate)) ? base_url($documents->iban_certificate) : base_url('images/no-image-icon.png');?>" /></div>
														
													</div>
												</div>
											</div>
											<div class="row size-inner-section p-2">
												<h4 class="header-title mb-3">Vehicle information:</h4>
												<div class="col-md-3 col-sm-12 mb-3 form-group">
													<div class="upload-div">
														<!-- File upload form -->
														<label class="mb-2 font-size-11">Car Registration Front (Serial no. must be clear) </label>
														<div class="prfile-preview"><img id="fileInput6photo" src="<?= (!empty($documents->car_registration_front)) ? base_url($documents->car_registration_front) : base_url('images/no-image-icon.png');?>" /></div>
														
													</div>
												</div>

												<div class="col-md-3 col-sm-12 mb-3 form-group">
													<div class="upload-div">
														<!-- File upload form -->
														<label class="mb-2 font-size-11">Car Registration Back (Picture must be clear) </label>
														<div class="prfile-preview"><img id="fileInput7photo" src="<?= (!empty($documents->car_registration_back)) ? base_url($documents->car_registration_back) : base_url('images/no-image-icon.png');?>" /></div>
														
													</div>
												</div>

												<div class="col-md-3 col-sm-12 mb-3 form-group">
													<div class="upload-div">
														<!-- File upload form -->
														<label class="font-size-11" style="margin-bottom: 27px;">Car Insurance Picture </label>
														<div class="prfile-preview"><img id="fileInput8photo" src="<?= (!empty($documents->car_insurance_picture)) ? base_url($documents->car_insurance_picture) : base_url('images/no-image-icon.png');?>" /></div>
														
													</div>
												</div>

												<div class="col-md-3 col-sm-12 mb-3 form-group">
													<div class="upload-div">
														<!-- File upload form -->
														<label class="mb-2 font-size-11">A front-side photo of your car with the plate no. visible </label>
														<div class="prfile-preview"><img id="fileInput9photo" src="<?= (!empty($documents->car_front_side)) ? base_url($documents->car_front_side) : base_url('images/no-image-icon.png');?>" /></div>
														
													</div>
												</div>

												<div class="col-md-3 col-sm-12 mb-3 form-group">
													<div class="upload-div">
														<!-- File upload form -->
														<label class="mb-2 font-size-11">A back-side photo of your car with the plate no. visible </label>
														<div class="prfile-preview"><img id="fileInput10photo" src="<?= (!empty($documents->car_back_side)) ? base_url($documents->car_back_side) : base_url('images/no-image-icon.png');?>" /></div>
														
													</div>
												</div>

												<div class="col-md-3 col-sm-12 mb-3 form-group">
													<div class="upload-div">
														<!-- File upload form -->
														<label class="font-size-11" style="margin-bottom: 27px;">A right-side photo of your car </label>
														<div class="prfile-preview"><img id="fileInput11photo" src="<?= (!empty($documents->car_right_side)) ? base_url($documents->car_right_side) : base_url('images/no-image-icon.png');?>" /></div>
														
													</div>
													
												</div>

												<div class="col-md-3 col-sm-12 mb-3 form-group">
													<div class="upload-div">
														<!-- File upload form -->
														<label class="font-size-11" style="margin-bottom: 27px;">A left-side photo of your car </label>
														<div class="prfile-preview"><img id="fileInput12photo" src="<?= (!empty($documents->car_left_side)) ? base_url($documents->car_left_side) : base_url('images/no-image-icon.png');?>" /></div>
														
													</div>
												</div>
											</div>
										</div>

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
<?php $this->load->view('logistic/layout/footer');?>
<script></script>
