<?php $this->load->view('logistic/layout/header');?>
<style>
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
.size-inner-section {
    box-shadow: 0px 1px 4px #c5c5c5;
    border-radius: 5px;
    margin-bottom: 10px;
}
.custom-label{
	min-height: 28px;
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
.tab-pane input, .tab-pane textarea, .tab-pane select, .tab-pane .select2{
    pointer-events: none;
	background-color: #edf1f5;
}
.form-control {
	border: 1px solid #ededed !important;
 }
 .select2-container--default.select2-container--disabled .select2-selection--single {
    background-color: #fff !important;
    border-color: #eee !important;
	pointer-events: none;
}
.select2-selection__arrow{
	display:none;
}
.select2-container--default.select2-container--disabled .select2-selection--single .change-password-modal input{
	pointer-events: initial;
}
.select2-container .select2-selection--single {
    border: 1px solid #ececec;
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
<div id="wait"><img src="<?= base_url('images/sample-loader.gif');?>" /><br>Loading..</div>
<div class="main-content">
    <div class="page-content">
		<!-- start page title -->
		<div class="page-title-box">
			<div class="container-fluid">
				<div class="row align-items-center">
					<div class="col-sm-6">
						<div class="page-title">
							<h4>Rider Management</h4>
							<ol class="breadcrumb m-0">
								<li class="breadcrumb-item"><a href="<?php echo base_url('logistic');?>">Dashboard</a></li>
								<li class="breadcrumb-item"><a href="<?php echo base_url();?>logistic-partner/rider/list">Riders</a></li>
								<li class="breadcrumb-item active">Create or Edit</li>
							</ol>
						</div>
					</div>
					<?php  $logistic_id= $this->session->userdata('logistic_id'); ?>
					<div class="col-sm-6">
						<div class="float-end d-sm-block">
							<a class="btn btn-sm btn-custom-white pull-right" title="Back" href="<?php echo base_url();?>logistic-partner/rider/list"><i class="fa fa-reply"></i> Back</a>
							
						</div>
						<?php $this->load->view('logistic/partials/alert');?>
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
							<div class="card-body" style="min-height: 506px;">
								<?php echo iqamaExpAlert($iqama_exp);?>
								<?php echo dlExpAlert($dl_expiry);?>
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
										<li class="nav-item">
											<a class="nav-link" data-bs-toggle="tab" href="#salaryTab" role="tab">
												<span class="d-block d-sm-none"><i class="dripicons-wallet"></i></span>
												<span class="d-none d-sm-block">Salary Structure</span>
											</a>
										</li>
									</ul>

									<div class="tab-content py-3 text-muted">
										<div class="tab-pane active" id="profileTab" role="tabpanel">
											
											<div class="row size-inner-section p-2">
												<?php if($profile_info_status == '0'){?>
												<div class="alert alert-info" role="alert">Incomplete basic information.</div>
												<?php } ?>
												<h4 class="header-title">Fill rquired Information</h4>
												
												<div class="col-md-4 mb-3 form-group">
        											<label for="did">Driver ID <span class="text-danger">*</span></label>
        											<input type="text" class="form-control" id="did" name="driver_id" value="<?= $driver_id; ?>" required />
        										</div>
        										
												<div class="col-md-4 mb-3 form-group">
													<label for="region_id">Region <span class="text-danger">*</span></label>
													<select id="region_id" name="region_id" class="form-control col-md-12" required>
														<option value="">Select Region</option>
														<?php foreach(getRegions() as $master_region){?>
														<option value="<?php echo $master_region->id;?>" data-id="<?php echo $master_region->id;?>" <?php echo ($region_id == $master_region->id) ? "selected":"";?>><?php echo $master_region->region_name;?></option>
														<?php } ?>
													</select>
												</div>

												<div class="col-md-4 mb-3 form-group">
													<label for="city">City Name <span class="text-danger">*</span></label>
													<select id="city" name="city" class="form-control col-md-12" required>
														<option value="">Select Region First</option>
													</select>
												</div>

												<div class="col-md-4 mb-3 form-group">
													<label for="district">District Name <span class="text-danger">*</span></label>
													<input type="text" class="form-control" id="district" name="district" onKeyPress="return Alpha(event);" value="<?= $district; ?>" required maxlength="150" />
												</div>

												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="name">Rider Name (English) <span class="required-field text-danger">*</span></label>
													<input type="text" class="form-control" id="name" name="name" onKeyPress="return Alpha(event);" value="<?= $name; ?>" maxlength="150"  required />
													<small class="hint">Enter display name for Rider</small>
												</div>
												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="arabic_name">Rider Name (Arabic) <span class="required-field text-danger">*</span></label>
													<input type="text" class="form-control rtl-input" id="arabic_name" name="arabic_name" value="<?= $arabic_name; ?>" maxlength="150" required />
													<small class="hint">Enter display name for Rider in arabic</small>
												</div>

												<div class="col-md-4 mb-3 form-group">
													<label for="email">Rider Email <span class="text-danger">*</span></label>
													<input type="email" class="form-control" id="email" name="email" value="<?= $email; ?>" required maxlength="150" />
												</div>
												
												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="mobile">Mobile Number <span class="required-field text-danger">*</span></label>
													<input type="text" class="form-control" id="mobile" name="mobile" onkeypress="return numerics(event);" value="<?= $mobile; ?>" minlength="<?= MOB_LENGTH ;?>" maxlength="<?= MOB_LENGTH ;?>"  required />
													<small class="hint">Format 651 234 5678</small>
												</div>
												
												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="imei_no">IMEI Number</label>
													<input type="text" class="form-control" id="imei_no" name="imei_no" value="<?= $imei_no; ?>" maxlength="20" />
													<small class="hint">Format AA-BBBBBB-CCCCCC-D</small>
												</div>
												
												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="dob">Date of Birth <span class="required-field text-danger">*</span></label>
													<input type="date" class="form-control" id="dob" name="dob" max="<?php echo date("Y-m-d"); ?>" value="<?= $dob; ?>" required />
													<small class="hint">Enter date of birth</small>
												</div>
												
												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="marital_status">Marital Status<span class="required-field text-danger">*</span></label>
													<select name="marital_status"  class="form-control" required>
														<option value="">Select Marital Status</option>
														<option value="1" <?php echo ($marital_status == '1') ? "selected":"";?>>Single</option>
														<option value="0" <?php echo ($marital_status == '0') ? "selected":"";?>>Married</option>
														<!-- <option value="2" <?php //echo ($marital_status == '2') ? "selected":"";?>>Divorced</option> -->
													</select>
													<small class="hint">Set marital status for your Rider</small>
												</div>

												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="nationality">Nationality <span class="required-field text-danger">*</span></label>
													<select id="nationality" name="nationality" class="form-control col-md-12" required>
														<option value="">Select Nationality</option>
														<?php foreach(nationalityList() as $master_nationality){?>
														<option value="<?php echo $master_nationality->name;?>" data-id="<?php echo $master_nationality->name;?>" <?php echo ($nationality == $master_nationality->name) ? "selected":"";?>><?php echo $master_nationality->name;?></option>
														<?php } ?>
													</select>
													<small class="hint">Select rider nationality</small>
												</div>
												
												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="passport">Passport Number <span class="required-field text-danger">*</span></label>
													<input type="text" class="form-control" id="passport" name="passport"  minlength="8" maxlength="<?= PASSPORT_LENGTH;?>" value="<?= $passport; ?>" required="required" />
													<small class="hint">Enter passport number</small>
													<span id="errmsgadhar" class="err-msg"></span>
												</div>
												
												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="passport_expiry">Passport Expiry Date <span class="required-field text-danger">*</span></label>
													<input type="date" class="form-control" id="passport_expiry" name="passport_expiry" min="<?php echo date("Y-m-d"); ?>" value="<?= $passport_expiry; ?>" required />
													<small class="hint">Enter passport expiry date</small>
												</div>

												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="passport_issued_city">Passport Issued City (English)</label>
													<input type="text" class="form-control" id="passport_issued_city" name="passport_issued_city" maxlength="100" value="<?= $passport_issued_city; ?>" />
													<small class="hint">Enter city name where passport issued (EN)</small>
												</div>

												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="passport_issued_city_ar">Passport Issued City (Arabic)</label>
													<input type="text" class="form-control rtl-input" id="passport_issued_city_ar" name="passport_issued_city_ar" maxlength="100" value="<?= $passport_issued_city_ar; ?>" />
													<small class="hint">Enter city name where passport issued (AR)</small>
												</div>
												
												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="iqama_no">Iqama No <span class="required-field text-danger">*</span></label>
													<input type="text" class="form-control" id="iqama_no" name="iqama_no"  minlength="<?= ICAMA_LENGTH ;?>" maxlength="<?= ICAMA_LENGTH ;?>" value="<?= $iqama_no; ?>" required />
													<small class="hint">Enter Iqama No for delivery boy</small>
												</div>

												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="iqama_exp">Iqama Expiry Date <span class="required-field text-danger">*</span></label>
													<input type="date" class="form-control" id="iqama_exp" name="iqama_exp" min="<?php echo date("Y-m-d"); ?>" value="<?= $iqama_exp; ?>" required />
													<small class="hint">Enter Iqama expiry date</small>
												</div>
												
												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="dl_no">Driving License No <span class="required-field text-danger">*</span></label>
													<input type="text" class="form-control" id="dl_no" name="dl_no" minlength="<?= DL_LENGTH ;?>" maxlength="<?= DL_LENGTH ;?>" value="<?= $dl_no; ?>" required="required" />
													<small class="hint">Enter driving license no</small>
													<span id="errmsgadhar" class="err-msg"></span>
												</div>
												
												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="dl_expiry">Driving License Expiry <span class="required-field text-danger">*</span></label>
													<input type="date" class="form-control" id="dl_expiry" name="dl_expiry" min="<?php echo date("Y-m-d"); ?>" value="<?= $dl_expiry; ?>" required />
													<small class="hint">Enter driving license expiry date</small>
												</div>
												
												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="sponsor_name">Sponsor Name <span class="text-danger">*</span></label>
													<input type="text" id="sponsor_name" name="sponsor_name" maxlength="198"  class="form-control" value="<?= $sponsor_name; ?>" required>
													<small class="hint">Enter sponsor name for Rider</small>
												</div>

												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="profession">Profession <span class="text-danger">*</span></label>
													<select style="height:410px;" name="profession" id="profession" class="form-control" required>
														<option value="">Select Profession</option>
														<?php foreach(professionList() as $professions){?>
														<option value="<?php echo $professions->id;?>" <?php echo ($profession == $professions->id) ? "selected":"";?>><?php echo $professions->profession_name;?></option>
														<?php } ?>
													</select>
													<small class="hint">Enter profession for Rider</small>
												</div>

												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="doj">Date Of Joining <span class="text-danger">*</span></label>
													<input type="date" class="form-control" id="doj" name="doj" value="<?php echo $doj;?>" required="required" />
													<small class="hint">Enter rider date of joining</small>
													<span id="errmsgadhar" class="err-msg"></span>
												</div>

												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="partner_id">Logistic Partner <span class="text-danger">*</span></label>
													<select style="height:410px;" name="partner_id" id="partner_id" class="form-control" required>
														<option value="">Select Partner</option>
														<?php foreach(logisticPartnerList() as $partners){?>
														<option value="<?php echo $partners->id;?>" <?php echo ($partners->id == $partner_id) ? "selected":"";?>><?php echo $partners->company_name;?></option>
														<?php } ?>
													</select>
													<small class="hint">Select logistic partner belong to Rider</small>
												</div>

												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="service_area">Service Area <span class="text-danger">*</span></label>
													<select name="service_area" id="service_area" class="form-control" required>
														<option value="">Select Service Area</option>
														<?php foreach(areaList() as $areas){?>
														<option value="<?php echo $areas->id;?>" <?php echo ($areas->id == $service_area) ? "selected":"";?>><?php echo $areas->area_name;?></option>
														<?php } ?>
													</select>
													<small class="hint">Enter service area for Rider</small>
												</div>

												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="status">Status</label>
													<select name="status" class="form-control" required>
														<option value="">Select Status</option>
														<option value="1" <?php echo ($status == '1') ? "selected":"";?>>Enable</option>
														<option value="0" <?php echo ($status == '0') ? "selected":"";?>>Disable</option>
														<option value="2" <?php echo ($status == '2') ? "selected":"";?>>Block</option>
													</select>
													<small class="hint">Set status for your Rider</small>
												</div>

												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="encyp_pass">Password <span class="text-danger">*</span></label>
													<div class="input-group bootstrap-touchspin bootstrap-touchspin-injected">
														<input type="text" id="encyp_pass" value="**************" class="form-control">
														<span class="input-group-btn input-group-append">
															<button class="btn btn-warning bootstrap-touchspin-up password-show" type="button" data-id="<?= $id; ?>"><i class="fa fa-eye"></i></button>
														</span>
													</div>
													<small class="hint">Want to change password <button class="btn btn-link text-danger btn-sm" data-bs-toggle="modal" data-bs-target=".change-password-modal">Click Here</button></small>
												</div>
												
											</div>
											
										</div>

										<div class="tab-pane" id="vehicleTab" role="tabpanel">
											
											<div class="row size-inner-section p-2">
												<?php if($vehicle_info_status == '0'){?>
												<div class="alert alert-info" role="alert">Incomplete vehicle information.</div>
												<?php } ?>
												<h4 class="header-title">Fill vehicle information</h4>
												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="service_type">Service Type<span class="required-field text-danger">*</span></label>
													<select name="service_type" id="service_type" class="form-control" required>
														<option value="">Select Service</option>
														<option value="bike" <?php echo ($service_type == 'bike') ? "selected":"";?>>Bike</option>
														<option value="car" <?php echo ($service_type == 'car') ? "selected":"";?>>Car</option>
													</select>
													<small class="hint">Select service type</small>
												</div>

												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="van_no">Vehicle Plate Number <span class="text-danger">*</span></label>
													<input type="text" id="van_no" name="van_no" minlength="7" maxlength="7" required="required" value="<?= $van_no; ?>" class="form-control">
													<small class="hint">Enter vehicle plate number</small>
												</div>

												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="vehicle_expiry">Vehicle Expiry Date <span class="required-field text-danger">*</span></label>
													<input type="date" class="form-control" id="vehicle_expiry" name="vehicle_expiry" min="<?php echo date("Y-m-d"); ?>" value="<?= $vehicle_expiry; ?>" required />
													<small class="hint">Enter vehicle expiry date</small>
												</div>

												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="vehicle_year">Vehicle Year <span class="text-danger">*</span></label>
													<select name="vehicle_year" id="vehicle_year" class="form-control" required>
														<option value="">Select Vehicle Year</option>
														<?php 
															//$year_start  = 2001;
															$year_start  = (date('Y') - 6);
															$year_end = date('Y'); // current Year
															$vehicle_year = $vehicle_year; // user selected date
														
															for ($i_year = $year_end; $i_year >= $year_start; $i_year--) {
																$selected = ($vehicle_year == $i_year ? ' selected' : '');
																echo '<option value="'.$i_year.'"'.$selected.'>'.$i_year.'</option>'."\n";
															}
														?>
													</select>
													<small class="hint">Enter vehicle year of Rider</small>
												</div>

												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="van_make">Vehicle Make <span class="text-danger">*</span></label>
													<select name="van_make" id="van_make" class="form-control" required>
														<option value="">Select Service Type First</option>
													</select>
													<small class="hint">Select vehicle make of Rider</small>
												</div>

												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="van_model">Vehicle Type <span class="text-danger">*</span></label>
													<select name="van_model" id="van_model" class="form-control" required>
														<option value="">Select Vehicle Make First</option>
													</select>
													<small class="hint">Select vehicle type</small>
												</div>

												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="van_color">Vehicle Color <span class="text-danger">*</span></label>
													<select name="van_color" id="van_color" class="form-control" required>
														<option value="">Select Vehicle Color</option>
														<?php foreach(colorList() as $color){?>
														<option value="<?php echo $color->id;?>" <?php echo ($van_color == $color->id) ? "selected":"";?>><?php echo $color->color_name;?></option>
														<?php } ?>
													</select>
													<small class="hint">Enter vehicle colour of Rider</small>
												</div>

												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="purchse_date">Vehicle Purchase Date</label>
													<input type="date" class="form-control" id="purchse_date" name="purchse_date" max="<?php echo date("Y-m-d"); ?>" value="<?= $purchse_date; ?>" />
													<small class="hint">Enter vehicle purcase date</small>
												</div>

												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="chassis_no">Vehicle chassis Number</label>
													<input type="text" id="chassis_no" name="chassis_no" maxlength="35" value="<?= $chassis_no; ?>" class="form-control">
													<small class="hint">Enter vehicle chassis number</small>
												</div>

												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="insurance_no">Vehicle Insurance Number</label>
													<input type="text" id="insurance_no" name="insurance_no" maxlength="35" value="<?= $insurance_no; ?>" class="form-control">
													<small class="hint">Enter vehicle insurance number</small>
												</div>

												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="insurance_expiry">Vehicle Insurance Expiry Date</label>
													<input type="date" class="form-control" id="insurance_expiry" name="insurance_expiry" min="<?php echo date("Y-m-d"); ?>" value="<?= $insurance_expiry; ?>" />
													<small class="hint">Enter vehicle insurance exp. date</small>
												</div>

												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="sequel_no">Vehicle Sequel Number</label>
													<input type="text" id="sequel_no" name="sequel_no" maxlength="35" value="<?= $sequel_no; ?>" class="form-control">
													<small class="hint">Enter vehicle sequel number</small>
												</div>
												
											</div>
											
										</div>

										<div class="tab-pane" id="bankTab" role="tabpanel">
											
											<div class="row size-inner-section p-2">
												<?php if($bank_info_status == '0'){?>
												<div class="alert alert-info" role="alert">Incomplete bank information.</div>
												<?php } ?>
												<h4 class="header-title">Fill your required bank information</h4>

												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="bank_name">Bank Name <span class="required-field text-danger">*</span></label>
													<select style="height:410px;" name="bank_name" id="bank_name" class="form-control" required>
														<option value="">Select Bank</option>
														<?php foreach(bankList() as $banks){?>
														<option value="<?php echo $banks->id;?>" <?php echo ($bank_name == $banks->id) ? "selected":"";?>><?php echo $banks->bank_name;?></option>
														<?php } ?>
													</select>
													<small class="hint">Enter bank name belong to Rider</small>
												</div>
												
												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="iban">IBAN No <span class="required-field text-danger">*</span></label>
													<input type="text" class="form-control" id="iban" name="iban" minlength="<?= IBAN_LENGTH ;?>" maxlength="<?= IBAN_LENGTH ;?>" value="<?= $iban;?>" required />
													<small class="hint">Enter IBAN No of Rider</small>
												</div>

												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="stc_pay_no">STC Pay No <span class="required-field text-danger">*</span></label>
													<input type="text" class="form-control" id="stc_pay_no" name="stc_pay_no" minlength="<?= STC_PAY_LENGTH ;?>" maxlength="<?= STC_PAY_LENGTH ;?>" value="<?= $stc_pay_no;?>" required="required" />
													<small class="hint">Enter STC Pay number</small>
													<span id="errmsgadhar" class="err-msg"></span>
												</div>
												
											</div>
										</div>

										<div class="tab-pane" id="documentsTab" role="tabpanel">
											<div class="row size-inner-section p-2">
												<?php if($doc_info_status == '0'){?>
												<div class="alert alert-warning" role="alert">Unverified documents.</div>
												<?php } ?>
												<div class="col-md-12 px-2 pb-4 mx-2">
													<div class="row size-inner-section pt-3">
														<h5 class="scheduler-border">Document verification:</h5>
														<div class="col-md-3 col-sm-12 mb-3 form-group">
															<label for="doc_info_status">Document Status<span class="text-danger" required>*</span></label>
															<select name="doc_info_status" class="form-control" required>
																<option value="">Select Status</option>
																<option value="0" <?php echo ($doc_info_status == '0') ? "selected":"";?>>Pending</option>
																<option value="1" <?php echo ($doc_info_status == '1') ? "selected":"";?>>Approved</option>
																<option value="2" <?php echo ($doc_info_status == '2') ? "selected":"";?>>Rejected</option>
															</select>
														</div>

														<div class="col-md-6 col-sm-12 mb-3 form-group <?php echo ($doc_info_status == 2) ? '' : 'd-none'; ?>" id="docReason">
															<label for="doc_reason">Document Rejection Reason<span class="text-danger" required>*</span></label>
															<select name="doc_reason" id="doc_reason" class="form-control">
																<option value="">Select Rejection Reason</option>
																<?php foreach( docReasonsHelper() as $item) { ?>
																	<option value="<?php echo $item->name; ?>" <?php echo ($doc_reason == $item->name) ? "selected":"";?>><?php echo $item->name .' ( '.$item->name_ar.' )'; ?></option>
																<?php } ?>												
															</select>
														</div>
													</div>
												</div>
												<h4 class="header-title mb-3">Upload required documents:</h4>
												<div class="col-md-3 col-sm-12 mb-3 form-group">
													<div class="upload-div">
														<label class="font-size-11 custom-label">Profile Picture (white background) <span class="text-danger">*</span></label>
														<div class="prfile-preview"><img id="fileInputphoto" src="<?= (!empty($documents->profile_picture)) ? base_url($documents->profile_picture) : base_url('images/no-image-icon.png');?>" /></div>
														<!-- File upload form -->
														
													</div>
												</div>

												<div class="col-md-3 col-sm-12 mb-3 form-group">
													<div class="upload-div">
														<!-- File upload form -->
														<label class="font-size-11 custom-label">Iqama Image Front <span class="text-danger">*</span></label>
														<div class="prfile-preview"><img id="fileInput1photo" src="<?= (!empty($documents->iqama_image_front)) ? base_url($documents->iqama_image_front) : base_url('images/no-image-icon.png');?>" /></div>
														
													</div>
												</div>

												<div class="col-md-3 col-sm-12 mb-3 form-group">
													<div class="upload-div">
														<!-- File upload form -->
														<label class="font-size-11 custom-label">Driving Licence Front <span class="text-danger">*</span></label>
														<div class="prfile-preview"><img id="fileInput3photo" src="<?= (!empty($documents->driving_licence_front)) ? base_url($documents->driving_licence_front) : base_url('images/no-image-icon.png');?>" /></div>
														
													</div>
													
												</div>

												<div class="col-md-3 col-sm-12 mb-3 form-group">
													<div class="upload-div">
														<!-- File upload form -->
														<label class="mb-2 font-size-11 custom-label">IBAN Certificate (Account name and bank name must be clear) <span class="text-danger">*</span></label>
														<div class="prfile-preview"><img id="fileInput5photo" src="<?= (!empty($documents->iban_certificate)) ? base_url($documents->iban_certificate) : base_url('images/no-image-icon.png');?>" /></div>
														
													</div>
												</div>
											</div>
											<div class="row size-inner-section p-2">
												<h4 class="header-title mb-3">Vehicle information:</h4>
												<div class="col-md-3 col-sm-12 mb-3 form-group">
													<div class="upload-div">
														<!-- File upload form -->
														<label class="mb-2 font-size-11 custom-label"><span class="vehicle-type">Car</span> Registration Front (Serial no. must be clear) <span class="text-danger">*</span></label>
														<div class="prfile-preview"><img id="fileInput6photo" src="<?= (!empty($documents->car_registration_front)) ? base_url($documents->car_registration_front) : base_url('images/no-image-icon.png');?>" /></div>
														
													</div>
												</div>

											</div>
										</div>

										<div class="tab-pane" id="salaryTab" role="tabpanel">
											
											<div class="row size-inner-section p-2">
												<h4 class="header-title">Fill your required salary information</h4>

												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="rider_payout_structure">Salary Payout Structure</label>
													<select name="rider_payout_structure" id="rider_payout_structure" class="form-control" required>
														<option value="">Select Salary Payout</option>
														<option value="freelancer" <?php echo ($salary->rider_payout_structure == 'freelancer') ? "selected":"";?>>Freelancer</option>
														<option value="salaried" <?php echo ($salary->rider_payout_structure == 'salaried') ? "selected":"";?>>Salaried</option>
													</select>
													<small class="hint">Set salary structure for your Rider</small>
												</div>

												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="total_salary">Total Salary (in SAR)<span class="required-field">*</span></label>
													<input type="text" class="form-control" id="total_salary" name="total_salary" value="<?php echo $salary->total_salary;?>" required="required" />
													<p class="hint">Enter rider total salary</p>
												</div>

												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="basic">Basic Salary (in SAR)<span class="required-field">*</span></label>
													<input type="text" class="form-control" id="basic" name="basic" value="<?php echo $salary->basic;?>" required="required" />
													<p class="hint">Enter rider basic salary</p>
												</div>

												<div class="col-md-4 col-sm-6 mb-3 form-group">
													<label for="housing">Housing Allowance</label>
													<input class="form-control" type="text" name="housing" id="housing" value="<?php echo $salary->housing;?>">
													<p class="hint">Enter housing allowance</p>
												</div>

												<div class="col-md-4 col-sm-6 mb-3 form-group">
													<label for="housing_ar">Housing Allowance (Arabic)</label>
													<input class="form-control rtl-input" type="text" name="housing_ar" id="housing_ar" value="<?php echo $salary->housing_ar;?>">
													<p class="hint">Enter housing allowance in arabic</p>
												</div>

												<div class="col-md-4 col-sm-6 mb-3 form-group">
													<label for="transport_allowance">Transportation Allowance</label>
													<input class="form-control" type="text" name="transport_allowance" id="transport_allowance" value="<?php echo $salary->transport_allowance;?>">
													<p class="hint">Enter transportation allowance</p>
												</div>

												<div class="col-md-4 col-sm-6 mb-3 form-group">
													<label for="transport_allowance_ar">Transportation Allowance (Arabic)</label>
													<input class="form-control rtl-input" type="text" name="transport_allowance_ar" id="transport_allowance_ar" value="<?php echo $salary->transport_allowance_ar;?>">
													<p class="hint">Enter transportation allowance in arabic</p>
												</div>

												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="food">Food Allowance (in SAR)<span class="required-field">*</span></label>
													<input type="text" class="form-control" id="food" name="food" value="<?php echo $salary->food;?>" onKeyPress="return numerics(event);" required="required" />
													<p class="hint">Enter rider food allowence</p>
												</div>

												<div class="col-md-4 col-sm-6 mb-3 form-group">
													<label for="internet">Internet Allowance</label>
													<input class="form-control" type="text" name="internet" id="internet" value="<?php echo $salary->internet;?>">
													<p class="hint">Enter internet allowance</p>
												</div>

												<div class="col-md-4 col-sm-6 mb-3 form-group">
													<label for="internet_ar">Internet Allowance (Arabic)</label>
													<input class="form-control rtl-input" type="text" name="internet_ar" id="internet_ar" value="<?php echo $salary->internet_ar;?>">
													<p class="hint">Enter internet allowance in arabic</p>
												</div>

												<div class="col-md-4 col-sm-6 mb-3 form-group">
													<label for="bike_allowance">Bike Allowance</label>
													<input class="form-control" type="text" name="bike_allowance" id="bike_allowance" value="<?php echo $salary->bike_allowance;?>">
													<p class="hint">Enter bike allowance</p>
												</div>

												<div class="col-md-4 col-sm-6 mb-3 form-group">
													<label for="bike_allowance_ar">Bike Allowance (Arabic)</label>
													<input class="form-control rtl-input" type="text" name="bike_allowance_ar" id="bike_allowance_ar" value="<?php echo $salary->bike_allowance_ar;?>">
													<p class="hint">Enter bike allowance in arabic</p>
												</div>

												<div class="col-md-4 col-sm-6 mb-3 form-group">
													<label for="bike_maintain">Bike Maintenance</label>
													<input class="form-control" type="text" name="bike_maintain" id="bike_maintain" value="<?php echo $salary->bike_maintain;?>">
													<p class="hint">Enter bike maintenance</p>
												</div>

												<div class="col-md-4 col-sm-6 mb-3 form-group">
													<label for="bike_maintain_ar">Bike Maintenance (Arabic)</label>
													<input class="form-control rtl-input" type="text" name="bike_maintain_ar" id="bike_maintain_ar" value="<?php echo $salary->bike_maintain_ar;?>">
													<p class="hint">Enter bike maintenance in arabic</p>
												</div>

												<div class="col-md-4 col-sm-6 mb-3 form-group">
													<label for="petrol">Petrol Allowance</label>
													<input class="form-control" type="text" name="petrol" id="petrol" value="<?php echo $salary->petrol;?>">
													<p class="hint">Enter petrol allowance</p>
												</div>

												<div class="col-md-4 col-sm-6 mb-3 form-group">
													<label for="petrol_ar">Petrol Allowance (Arabic)</label>
													<input class="form-control rtl-input" type="text" name="petrol_ar" id="petrol_ar" value="<?php echo $salary->petrol_ar;?>">
													<p class="hint">Enter petrol allowance in arabic</p>
												</div>

												<div class="col-md-4 col-sm-6 mb-3 form-group">
													<label for="annual_vacation">Annual Vacation</label>
													<input class="form-control" type="text" name="annual_vacation" id="annual_vacation" value="<?php echo $salary->annual_vacation;?>">
													<p class="hint">Enter annual vacation</p>
												</div>

												<div class="col-md-4 col-sm-6 mb-3 form-group">
													<label for="annual_vacation_ar">Annual Vacation (Arabic)</label>
													<input class="form-control rtl-input" type="text" name="annual_vacation_ar" id="annual_vacation_ar" value="<?php echo $salary->annual_vacation_ar;?>">
													<p class="hint">Enter annual vacation in arabic</p>
												</div>

												<div class="col-md-4 col-sm-6 mb-3 form-group">
													<label for="medical_insurance">Medical Insurance</label>
													<input class="form-control" type="text" name="medical_insurance" id="medical_insurance" value="<?php echo $salary->medical_insurance;?>">
													<p class="hint">Enter medical insurance</p>
												</div>

												<div class="col-md-4 col-sm-6 mb-3 form-group">
													<label for="medical_insurance_ar">Medical Insurance (Arabic)</label>
													<input class="form-control rtl-input" type="text" name="medical_insurance_ar" id="medical_insurance_ar" value="<?php echo $salary->medical_insurance_ar;?>">
													<p class="hint">Enter medical insurance in arabic</p>
												</div>

												<div class="col-md-4 col-sm-6 mb-3 form-group">
													<label for="contract_period">Contract Period</label>
													<input class="form-control" type="text" name="contract_period" id="contract_period" value="<?php echo $salary->contract_period;?>">
													<p class="hint">Enter contract period of rider</p>
												</div>

												<div class="col-md-4 col-sm-6 mb-3 form-group">
													<label for="contract_period_ar">Contract Period (Arabic)</label>
													<input class="form-control rtl-input" type="text" name="contract_period_ar" id="contract_period_ar" value="<?php echo $salary->contract_period_ar;?>">
													<p class="hint">Enter contract period of rider in arabic</p>
												</div>

												<div class="col-md-4 col-sm-6 mb-3 form-group">
													<label for="deduction">Deduction</label>
													<input class="form-control" type="text" name="deduction" id="deduction" value="<?php echo $salary->deduction;?>">
													<p class="hint">Enter deduction of rider</p>
												</div>

												<div class="col-md-4 col-sm-6 mb-3 form-group">
													<label for="deduction_ar">Deduction (Arabic)</label>
													<input class="form-control rtl-input" type="text" name="deduction_ar" id="deduction_ar" value="<?php echo $salary->deduction_ar;?>">
													<p class="hint">Enter deduction of rider in arabic</p>
												</div>

												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="daily_orders">Minimum Orders (Daily Target)<span class="required-field">*</span></label>
													<input type="text" class="form-control" id="daily_orders" name="daily_orders" value="<?php echo $salary->daily_orders;?>" onKeyPress="return numerics(event);" required="required" />
													<p class="hint">Enter rider minimum orders daily</p>
													<span id="errmsgadhar" class="err-msg"></span>
												</div>
												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="monthly_orders">Minimum Orders (Monthly Target)<span class="required-field">*</span></label>
													<input type="text" class="form-control" id="monthly_orders" name="monthly_orders" value="<?php echo $salary->monthly_orders;?>" onKeyPress="return numerics(event);" required="required" />
													<p class="hint">Enter rider minimum orders monthly</p>
													<span id="errmsgadhar" class="err-msg"></span>
												</div>
												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="rejection_rate">Rejection Rate of Orders (In %)<span class="required-field">*</span></label>
													<input type="text" class="form-control" id="rejection_rate" name="rejection_rate" value="<?php echo $salary->rejection_rate;?>" onKeyPress="return numerics(event);" required="required" />
													<p class="hint">Enter rejection rate of orders allowed</p>
													<span id="errmsgadhar" class="err-msg"></span>
												</div>
												
												<div class="col-md-4 col-sm-12 mb-3 form-group">
													<label for="daily_commision">Bonus Commision (In SAR Per Delivery) <span class="required-field">*</span></label>
													<input type="text" class="form-control" id="daily_commision" name="daily_commision" value="<?php echo $salary->daily_commision;?>" onKeyPress="return numerics(event);" required="required" />
													<p class="hint">Enter rider bonus commision after minimum orders</p>
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
	</div>
</div>

<!--- Change password modal ---->
<div class="modal fade change-password-modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title mt-0">Change Password</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="alert_msg"></div>
				<form method="post" action="logistic/riders/change_password" id="password_form" data-parsley-validate="" class="form-horizontal">
					<input type="hidden" name="id" value="<?php echo $id;?>" />
					<div class="col-md-12 col-sm-12 mb-3 form-group">
						<label for="password">New Password<span class="text-danger">*</span></label>
						<input type="password" id="password" name="password" required="required" class="form-control" minlength="6" maxlength="55" />
					</div>
					<div class="col-md-12 col-sm-12 mb-3 form-group">
						<label for="confirm_password">Confirm Password<span class="text-danger">*</span></label>
						<input type="password" id="confirm_password" name="confirm_password" required="required" class="form-control" minlength="6" maxlength="55" />
					</div>

					<div class="form-group">
						<div class="col-sm-12">
							<button type="submit" class="btn btn-danger float-end">Submit</button>
						</div>
					</div>
				</form>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php $this->load->view('logistic/layout/footer');?>
<script type="text/javascript">
	var base_url = '<?= base_url();?>';
</script>
<script>
	$(document).ready(function(){
		$(document).ajaxStart(function(){
			$("#wait").css("display", "block");
		});
		$(document).ajaxComplete(function(){
			$("#wait").css("display", "none");
		});
		$(document).ajaxError(function(){
			$("#wait").css("display", "none");
		});
	});

	$('.password-show').click(function() {
		var login_id = $(this).data('id');
		//alert(login_id);
		$.ajax({
			type: "post",
			url: "<?php echo base_url();?>logistic/riders/getLoginDetail",
			data: {'login_id': login_id},
			dataType: "json",
			success: function (response) {
				//console.log(response);
				$('#encyp_pass').val(response.password);
				//$('.password-show').html('<i class="fa fa-eye-slash"></i>');
			}
		});
	});

	$(document).ready(function() {
	    var region_id = "<?= ($region_id == '') ? 'NULL' : $region_id; ?>";
		//console.log(region_id);
	    selectedCity(region_id);
		
		var service_type = "<?= ($service_type == '') ? 'NULL' : $service_type; ?>";
	    selectedVehicleMake(service_type);

		var van_make = "<?= ($van_make == '') ? 'NULL' : $van_make; ?>";
	    selectedVehicleModel(van_make);
		
	});

	function selectedCity(region_id){
		var add_city_id = "<?= ($city == '') ? 'NULL' : $city; ?>";
		//alert(region_id);
		if(region_id !== 'NULL'){
			$.ajax({
				url: "<?php echo base_url(); ?>logistic/riders/get_region_cities",
				type: "POST",
				data: {'region_id':region_id},
				dataType: "json",
				success: function(data){
					var html = '<option value="">Select City</option>';
			
					if (Object.keys(data).length > 0) {
						$.each(data, function(index, item) {
							var isSelected = (add_city_id == item.id ? 'selected' : '');
							html += '<option value="' + item.id + '" data-id="' + item.id + '" ' + isSelected + '>' + item.city_name + '</option>';
						});
					} else {
						var html = '<option value="">No city found</option>';
					}
					$('#city').html(html);
				},
				error: function(){}
			});
		}
	}

	function selectedVehicleMake(service_type){
		var make_id = "<?= ($van_make == '') ? 'NULL' : $van_make; ?>";
		if(service_type == 'bike'){
			$(".vehicle-type").html("Bike");
		}else{
			$(".vehicle-type").html("Car");
		}
		if(service_type !== 'NULL'){
			$.ajax({
				url: "<?php echo base_url(); ?>logistic/riders/vehicle_make_list",
				data: {
					service_id: service_type
				},
				dataType: "json",
				type: "post",
				success: function(data) {
					//alert(JSON.stringify(data, null, 4));
					var html = '<option value="">Select Vehicle Make</option>';
			
					if (Object.keys(data).length > 0) {
						$.each(data, function(index, item) {
							var isSelected = (make_id == item.id ? 'selected' : '');
							html += '<option value="' + item.id + '" data-id="' + item.id + '" ' + isSelected + '>' + item.make_name + '</option>';
						});
					} else {
						var html = '<option value="">No vehicle make found</option>';
					}
					$('#van_make').html(html);
				}
			});
		}
	}

	function selectedVehicleModel(van_make){
		var van_model = "<?= ($van_model == '') ? 'NULL' : $van_model; ?>";
		if(van_make !== 'NULL'){
			$.ajax({
				url: "<?php echo base_url(); ?>logistic/riders/get_vehicle_type",
				data: {
					make_id: van_make
				},
				dataType: "json",
				type: "post",
				success: function(data) {
					var html = '<option value="">Select Vehicle Type</option>';
			
					if (Object.keys(data).length > 0) {
						$.each(data, function(index, item) {
							var isSelected = (van_model == item.vehicle_type ? 'selected' : '');
							html += '<option value="' + item.vehicle_type + '" data-id="' + item.id + '" ' + isSelected + '>' + item.vehicle_type + '</option>';
						});
					} else {
						var html = '<option value="">No vehicle type found</option>';
					}
					$('#van_model').html(html);
				}
			});
		}
	}

	$('#region_id').change(function() {
		var region_id = $(this).find('option:selected').data('id');
		$.ajax({
			url: "<?php echo base_url(); ?>logistic/riders/get_region_cities",
			data: {
				region_id: region_id
			},
			dataType: "json",
			type: "post",
			success: function(data) {
				//console.log(data);
				var html = '<option value="">Select City</option>';
		
				if (Object.keys(data).length > 0) {
					$.each(data, function(index, item) {
						html += '<option value="' + item.id + '" data-id="' + item.id + '">' + item.city_name + '</option>';
					});
				} else {
					var html = '<option value="">No city found</option>';
				}
				$('#city').html(html);
			}
		});
	});

	$('#service_type').change(function() {
		var service_id = $(this).find('option:selected').val();
		$.ajax({
			url: "<?php echo base_url(); ?>logistic/riders/vehicle_make_list",
			data: {
				service_id: service_id
			},
			dataType: "json",
			type: "post",
			success: function(data) {
				var html = '<option value="">Select Vehicle Make</option>';
		
				if (Object.keys(data).length > 0) {
					$.each(data, function(index, item) {
						html += '<option value="' + item.id + '" data-id="' + item.id + '">' + item.make_name + '</option>';
					});
				} else {
					var html = '<option value="">No vehicle make found</option>';
				}
				$('#van_make').html(html);
			}
		});
	});

	$('#van_make').change(function() {
		var make_id = $(this).find('option:selected').val();
		$.ajax({
			url: "<?php echo base_url(); ?>logistic/riders/get_vehicle_type",
			data: {
				make_id: make_id
			},
			dataType: "json",
			type: "post",
			success: function(data) {
				var html = '<option value="">Select Vehicle Type</option>';
		
				if (Object.keys(data).length > 0) {
					$.each(data, function(index, item) {
						html += '<option value="' + item.vehicle_type + '" data-id="' + item.id + '">' + item.vehicle_type + '</option>';
					});
				} else {
					var html = '<option value="">No vehicle type found</option>';
				}
				$('#van_model').html(html);
			}
		});
	});

	$("#mobile").on("keypress",function(e){
		if($(this).val().length<='10'){
			if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
				
				$("#errmsg1").html("Digits Only").show();
				return false;
			}
		}else{
			$("#errmsg1").html("Maximum input 10 Digits Only").show();
			return false;
		}
	});
	
	$("#adhar").on("keypress",function(e){
		if($(this).val().length<='12'){
			if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
				
				$("#errmsgadhar").html("Aadhar number not valid").show();
				return false;
			}
		}else{
			$("#errmsgadhar").html("Maximum input 12 Digits Only").show();
			return false;
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

	function verifyAction(e) {
		if (confirm("Do you sure want to verify this rider?") == true) {
			var uID = (e.getAttribute("data-id"));
			if(uID > 0){
				$.ajax({
					url: '<?php echo base_url();?>logistic/riders/verify',
					type: 'POST',
					dataType: 'json',
					data: {id: uID},
					success: function(data){
						alert(data.succ);
						location.reload();
					},
					error:function(data){
						console.log(data);
					}
				});
			}else{
				alert('Invalid rider ID');
			}
		} else {
			userPreference = "Action Cancelled!";
		}
	}

	$('#password_form').on('submit', (function(e) {
		//alert('test');
		e.preventDefault();
		$.ajax({
			url: '<?php echo base_url();?>logistic/riders/change_password',
			type: "POST",
			data:  new FormData(this),
			contentType: false,
			cache: false,
			processData:false,
			success: 
			//showResponse,
			function(data){
				//$result = JSON.stringify(data);
				$("#password").val('');
				$("#confirm_password").val('');
				$(".alert_msg").html(data);
				$(".change-password-modal").hide();
			},
			error: function(data){
				alert(JSON.stringify(data));
			}
		});
	}));
</script>
