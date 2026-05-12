<?php $this->load->view('admin/home/header');?>
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
@media (max-width: 425px){
	#wait img {
		margin-top: 40%;
	}
}
</style>
<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>3P Rider Management</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin');?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/deliveryvehicle');?>">3P Rider</a></li>
						<li class="breadcrumb-item active">Add or Edit</li>
					</ol>
				</div>
			</div>
			<?php  $admin_id= $this->session->userdata('admin_id'); ?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<?php if($this->customer->userd($admin_id)->role=="Admin" ){?>
					<a class="btn btn-sm btn-custom-white pull-right" title="Back" href="<?php echo base_url();?>admin/deliveryvehicle"><i class="fa fa-reply"></i> Back</a>
					<?php } ?>
				</div>
				<?php if($this->admin->getInfo()){
				$info = explode("--", $this->admin->getInfo());
				$info_type = $info[0];
				$msg_data = $info[1];
				if($info_type == 2){
				?>
				<div class="alert alert-danger alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;top:90px;width:50%;" role="alert">
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					<strong><?php echo $msg_data; ?></strong>
				</div>
				<?php } else{?>
				<div class="alert alert-info alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;top:90px;width:50%;" role="alert">
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					<strong><?php echo $msg_data; ?></strong>
				</div>
				<?php }} $this->admin->removeInfo();  ?>
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
						<?php if($application_status == 'unverified'){?>
						<div class="alert alert-warning" role="alert">
							This account in waiting for verification, please review detail before click verified <a type="button" onclick="verifyAction(this)" data-id="<?php echo $id;?>" class="alert-link text-danger ps-2"><u>Click to verify</u></a>.
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
								<li class="nav-item">
									<a class="nav-link" data-bs-toggle="tab" href="#salaryTab" role="tab">
										<span class="d-block d-sm-none"><i class="dripicons-wallet"></i></span>
										<span class="d-none d-sm-block">Salary Structure</span>
									</a>
								</li>
							</ul>

							<div class="tab-content py-3 text-muted">
								<div class="tab-pane active" id="profileTab" role="tabpanel">
									
									<?php echo form_open("admin/deliveryvehicle/save_basic_info", array("id"=>"application-form", "enctype"=>"multipart/form-data", "class"=>"form-label-left", "data-parsley-validate"=> "")); ?>
									<div class="row size-inner-section p-2">
										<?php if($profile_info_status == '0'){?>
										<div class="alert alert-info" role="alert">Incomplete basic information.</div>
										<?php } ?>
										<h4 class="header-title">Fill rquired Information</h4>
										<input type="hidden" id="id" name="id" value="<?php echo $id;?>">
										<div class="col-md-4 mb-3 form-group">
											<label for="region_id">Region <span class="text-danger">*</span></label>
											<select id="region_id" name="region_id" class="form-control col-md-12 select2" required>
												<option value="">Select Region</option>
												<?php foreach(getRegions() as $master_region){?>
												<option value="<?php echo $master_region->id;?>" data-id="<?php echo $master_region->id;?>" <?php echo ($region_id == $master_region->id) ? "selected":"";?>><?php echo $master_region->region_name;?></option>
												<?php } ?>
											</select>
										</div>

										<div class="col-md-4 mb-3 form-group">
											<label for="city">City Name <span class="text-danger">*</span></label>
											<select id="city" name="city" class="form-control col-md-12 select2" required>
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
											<select id="nationality" name="nationality" class="form-control col-md-12 select2" required>
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
											<input type="date" class="form-control" id="iqama_exp" name="iqama_exp" min="<?php echo isset($id) ? '' : date("Y-m-d"); ?>" value="<?= $iqama_exp; ?>" required />
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
											<select style="height:410px;" name="profession" id="profession" class="form-control select2" required>
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
											<select style="height:410px;" name="partner_id" id="partner_id" class="form-control select2" required>
												<option value="">Select Partner</option>
												<?php foreach(logisticPartnerList() as $partners){?>
												<option value="<?php echo $partners->id;?>" <?php echo ($partners->id == $partner_id) ? "selected":"";?>><?php echo $partners->company_name;?></option>
												<?php } ?>
											</select>
											<small class="hint">Select logistic partner belong to Rider</small>
										</div>

										<div class="col-md-4 col-sm-12 mb-3 form-group">
											<label for="service_area">Service Area <span class="text-danger">*</span></label>
											<select name="service_area" id="service_area" class="form-control select2" required>
												<option value="">Select Service Area</option>
												<?php foreach(areaList() as $areas){?>
												<option value="<?php echo $areas->id;?>" <?php echo ($areas->id == $service_area) ? "selected":"";?>><?php echo $areas->area_name;?></option>
												<?php } ?>
											</select>
											<small class="hint">Enter service area for Rider</small>
										</div>
										<div class="col-md-4 col-sm-12 mb-3 form-group">
											<label for="rider_type">Rider Type<span class="text-danger" required>*</span></label>
											<select name="rider_type" class="form-control select2" required>
												<option value="">Select Rider Type</option>
												<option value="Inhouse" <?php echo ($rider_type == 'Inhouse') ? "selected":"";?>>Inhouse</option>
												<option value="Third Party" <?php echo ($rider_type == 'Third Party') ? "selected":"";?>>Third Party</option>
											</select>
											<small class="hint">Set rider type for your Rider</small>
										</div>
										<div class="col-md-4 col-sm-12 mb-3 form-group">
											<label for="status">Status<span class="text-danger" required>*</span></label>
											<select name="status" class="form-control select2" required>
												<option value="">Select Status</option>
												<option value="1" <?php echo ($status == '1') ? "selected":"";?>>Enable</option>
												<option value="0" <?php echo ($status == '0') ? "selected":"";?>>Disable</option>
												<option value="2" <?php echo ($status == '2') ? "selected":"";?>>Block</option>
											</select>
											<small class="hint">Set status for your Rider</small>
										</div>
										
										<div class="col-md-4 col-sm-12 mb-3 form-group <?php echo ($status == 2) ? '' : 'd-none'; ?>" id="blockReason">
											<label for="block_reason">Block Reason<span class="text-danger" required>*</span></label>
											<select name="block_reason" id="block_reason" class="form-control select2">
												<option value="">Select Block Reason</option>
												<?php foreach( blockReasonsHelper() as $item) { ?>
													<option value="<?php echo $item->name; ?>" <?php echo ($block_reason == $item->name) ? "selected":"";?>><?php echo $item->name .' ( '.$item->name_ar.' )'; ?></option>
												<?php } ?>												
											</select>
											<small class="hint">Set block reason for your Rider</small>
										</div>
										
										<div class="col-md-12 col-sm-12 mb-3 form-group">
											<button class="btn btn-success btn-md float-end" type="submit">Update</button>
										</div>
									</div>
									<?= form_close();?>
									
								</div>

								<div class="tab-pane" id="vehicleTab" role="tabpanel">
									<?php if($profile_info_status > 0){ ?>
									<?php echo form_open("admin/deliveryvehicle/save_vehicle_info", array("id"=>"vehicle-form", "enctype"=>"multipart/form-data", "class"=>"form-label-left", "data-parsley-validate"=> "")); ?>
										<input type="hidden" id="id" name="id" value="<?php echo $id;?>" required>
										<div class="row size-inner-section p-2">
											<?php if($vehicle_info_status == '0'){?>
											<div class="alert alert-info" role="alert">Incomplete vehicle information.</div>
											<?php } ?>
											<h4 class="header-title">Fill vehicle information</h4>
											<?php if($rider_type == 'Inhouse'){ ?>
											<!---- In house ---->
											<div class="col-md-4 col-sm-12 mb-3 form-group">
												<label class="control-label" for="vehicle_no" style="width:100%">Select Bike <span class="text-danger">*</span></label>
												<select id="vehicle_no" name="van_no" class="form-control col-md-12 select2" required>
													<option value="">Select Vehicle</option>
													<?php foreach($vehicles_list as $vehicle){?>
													<option value="<?php echo $vehicle->vehicle_no;?>" data-id="<?php echo $vehicle->id;?>" <?php echo ($van_no == $vehicle->vehicle_no) ? "selected":"";?> <?php echo ($vehicle->allotment_status == 'alloted' && $van_no !== $vehicle->vehicle_no) ? "disabled":"";?>><?php echo $vehicle->vehicle_no .' ('. $vehicle->vehicle_type .')';?><?php echo ($vehicle->allotment_status == 'alloted') ? " - Alloted":"";?></option>
													<?php } ?>
												</select>
											</div>
											
											<div class="col-md-4 mb-3 form-group">
												<label class="control-label" for="service_type">Service Type <span class="text-danger">*</span></label>
												<input type="text" class="form-control" maxlength="4" name="service_type" id="service_type" value="<?= $service_type; ?>" required readonly />
											</div>

											<input type="hidden" id="vehicle_make" name="van_make" required="required" value="<?= $van_make; ?>">
											<input type="hidden" id="vehicle_color" name="van_color" required="required" value="<?= $van_color; ?>">

											<div class="col-md-4 mb-3 form-group">
												<label class="control-label" for="vehicle_year">Vehicle Year <span class="text-danger">*</span></label>
												<input type="text" class="form-control" maxlength="4" name="vehicle_year" id="vehicle_year" value="<?= $vehicle_year; ?>" required readonly />
											</div>

											<div class="col-md-4 col-sm-12 mb-3 form-group">
												<label for="purchse_date">Vehicle Purchase Date</label>
												<input type="date" class="form-control" id="purchse_date" name="purchse_date" max="<?php echo date("Y-m-d"); ?>" value="<?= $purchse_date; ?>" readonly />
												<small class="hint">Enter vehicle purcase date</small>
											</div>

											<div class="col-md-4 col-sm-12 mb-3 form-group">
												<label for="vehicle_expiry">Vehicle Expiry Date <span class="required-field text-danger">*</span></label>
												<input type="date" class="form-control" id="vehicle_expiry" name="vehicle_expiry" min="<?php echo date("Y-m-d"); ?>" value="<?= $vehicle_expiry; ?>" required readonly />
												<small class="hint">Enter vehicle expiry date</small>
											</div>

											<div class="col-md-4 mb-3 form-group">
												<label class="control-label" for="vehicle_make_demo">Vehicle Make <span class="text-danger">*</span></label>
												<input type="text" class="form-control" maxlength="120" name="van_make_demo" id="vehicle_make_demo" value="<?= $make_name; ?>" required readonly />
											</div>

											<div class="col-md-4 mb-3 form-group">
												<label class="control-label" for="vehicle_type">Vehicle Type <span class="text-danger">*</span></label>
												<input type="text" class="form-control" maxlength="120" name="van_model" id="vehicle_type" value="<?= $van_model; ?>" required readonly />
											</div>

											<div class="col-md-4 mb-3 form-group">
												<label class="control-label" for="vehicle_color">Vehicle Color <span class="text-danger">*</span></label>
												<input type="text" class="form-control" maxlength="120" name="vehicle_color_demo" id="vehicle_color_demo" value="<?= $color_name; ?>" required readonly />
											</div>

											<div class="col-md-4 col-sm-12 mb-3 form-group">
												<label for="chassis_no">Vehicle chassis Number</label>
												<input type="text" id="chassis_no" name="chassis_no" maxlength="35" value="<?= $chassis_no; ?>" class="form-control" readonly>
												<small class="hint">Enter vehicle chassis number</small>
											</div>

											<div class="col-md-4 col-sm-12 mb-3 form-group">
												<label for="insurance_no">Vehicle Insurance Number</label>
												<input type="text" id="insurance_no" name="insurance_no" maxlength="35" value="<?= $insurance_no; ?>" class="form-control" readonly>
												<small class="hint">Enter vehicle insurance number</small>
											</div>

											<div class="col-md-4 col-sm-12 mb-3 form-group">
												<label for="insurance_expiry">Vehicle Insurance Expiry Date</label>
												<input type="date" class="form-control" id="insurance_expiry" name="insurance_expiry" min="<?php echo date("Y-m-d"); ?>" value="<?= $insurance_expiry; ?>" readonly />
												<small class="hint">Enter vehicle insurance exp. date</small>
											</div>

											<div class="col-md-4 col-sm-12 mb-3 form-group">
												<label for="sequel_no">Vehicle Sequel Number</label>
												<input type="text" id="sequel_no" name="sequel_no" maxlength="35" value="<?= $sequel_no; ?>" class="form-control" readonly>
												<small class="hint">Enter vehicle sequel number</small>
											</div>
											<hr />
											<h4 class="header-title mb-3">Alloted/Unallotted/Return Vehicle Form</h4>
											<div class="col-md-4 col-sm-12 mb-3 form-group">
												<label for="vehicle_status">Select Status<span class="required-field text-danger">*</span></label>
												<select name="vehicle_status" id="vehicle_status" class="form-control select2" required>
													<option value="">Select Service</option>
													<option value="alloted" <?php echo ($vehicle_status == 'alloted') ? "selected":"";?>>Alloted</option>
													<option value="unalloted" <?php echo ($vehicle_status == 'unalloted') ? "selected":"";?>>Unallotted</option>
													<option value="return" <?php echo ($vehicle_status == 'return') ? "selected":"";?>>Return</option>
												</select>
												<small class="hint">Select vehicle status</small>
											</div>
											
											<div class="col-md-4 col-sm-12 mb-3 form-group">
												<label for="meter_reading">Meter Reading</label>
												<input type="text" id="meter_reading" name="meter_reading" value="<?= $meter_reading; ?>" class="form-control">
												<small class="hint">Enter meter reading (While status changed)</small>
											</div>

											<div class="col-md-4 col-sm-12 mb-3 form-group">
												<label for="vehicle_remarks">Remarks</label>
												<select name="vehicle_remarks" id="vehicle_remarks" class="form-control select2">
													<option value="">Select Remark</option>
													<option value="Accident" <?php echo ($vehicle_remarks == 'Accident') ? "selected":"";?>>Accident</option>
													<option value="Stolen" <?php echo ($vehicle_remarks == 'Stolen') ? "selected":"";?>>Stolen</option>
													<option value="Resigned" <?php echo ($vehicle_remarks == 'Resigned') ? "selected":"";?>>Resigned</option>
													<option value="Other" <?php echo ($vehicle_remarks == 'Other') ? "selected":"";?>>Other</option>
												</select>
												<small class="hint">Write remarks (if any)</small>
											</div>
											<?php }else{ ?>
											<!---- Third Party ---->
											<div class="col-md-4 col-sm-12 mb-3 form-group">
												<label for="service_type">Service Type<span class="required-field text-danger">*</span></label>
												<select name="service_type" id="service_type" class="form-control select2" required>
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
												<select style="height:410px;" name="vehicle_year" id="vehicle_year" class="form-control select2" required>
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
												<select style="height:410px;" name="van_make" id="van_make" class="form-control select2" required>
													<option value="">Select Service Type First</option>
												</select>
												<small class="hint">Select vehicle make of Rider</small>
											</div>

											<div class="col-md-4 col-sm-12 mb-3 form-group">
												<label for="van_model">Vehicle Type <span class="text-danger">*</span></label>
												<select style="height:410px;" name="van_model" id="van_model" class="form-control select2" required>
													<option value="">Select Vehicle Make First</option>
												</select>
												<small class="hint">Select vehicle type</small>
											</div>

											<div class="col-md-4 col-sm-12 mb-3 form-group">
												<label for="van_color">Vehicle Color <span class="text-danger">*</span></label>
												<select style="height:410px;" name="van_color" id="van_color" class="form-control select2" required>
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
											<?php } ?>
											<div class="col-md-12 col-sm-12 mb-3 form-group">
												<button class="btn btn-success btn-md float-end">Update</button>
											</div>
										</div>
									<?= form_close();?>
									<?php }else{ ?>
										<div class="alert alert-danger show" role="alert">
											<strong>Alert!</strong>  Fill basic information first to access this tab.
										</div>
									<?php } ?>
								</div>

								<div class="tab-pane" id="bankTab" role="tabpanel">
									<?php if($profile_info_status > 0 && $vehicle_info_status > 0){ ?>
									<?php echo form_open("admin/deliveryvehicle/save_bank_info", array("id"=>"bank-form", "enctype"=>"multipart/form-data", "class"=>"form-label-left", "data-parsley-validate"=> "")); ?>
										<input type="hidden" name="id" value="<?php echo $id;?>" required>
										<div class="row size-inner-section p-2">
											<?php if($bank_info_status == '0'){?>
											<div class="alert alert-info" role="alert">Incomplete bank information.</div>
											<?php } ?>
											<h4 class="header-title">Fill your required bank information</h4>

											<div class="col-md-4 col-sm-12 mb-3 form-group">
												<label for="bank_name">Bank Name <span class="required-field text-danger">*</span></label>
												<select style="height:410px;" name="bank_name" id="bank_name" class="form-control select2" required>
													<option value="">Select Bank</option>
													<?php foreach(bankList() as $banks){?>
													<option value="<?php echo $banks->id;?>" <?php echo ($bank_name == $banks->id) ? "selected":"";?>><?php echo $banks->bank_name;?></option>
													<?php } ?>
												</select>
												<small class="hint">Enter bank name belong to Rider</small>
											</div>
											
											<div class="col-md-4 col-sm-12 mb-3 form-group d-none" id="iban_cont">
												<label for="iban">IBAN No <span class="required-field text-danger">*</span></label>
												<input type="text" class="form-control" id="iban" name="iban" minlength="<?= IBAN_LENGTH ;?>" maxlength="<?= IBAN_LENGTH ;?>" value="<?= $iban;?>" />
												<small class="hint">Enter IBAN No of Rider</small>
											</div>

											<div class="col-md-4 col-sm-12 mb-3 form-group d-none" id="stcpay_cont">
												<label for="stc_pay_no">STC Pay No <span class="required-field text-danger">*</span></label>
												<input type="text" class="form-control" id="stc_pay_no" name="stc_pay_no" minlength="<?= STC_PAY_LENGTH ;?>" maxlength="<?= STC_PAY_LENGTH ;?>" value="<?= $stc_pay_no;?>" />
												<small class="hint">Enter STC Pay number</small>
												<span id="errmsgadhar" class="err-msg"></span>
											</div>
											<div class="col-md-12 col-sm-12 mb-3 form-group">
												<button class="btn btn-success btn-md float-end">Update</button>
											</div>
										</div>
									<?= form_close();?>
									<?php }else{ ?>
										<div class="alert alert-danger show" role="alert">
											<strong>Alert!</strong>  Fill vehicle information first to access this tab.
										</div>
									<?php } ?>
								</div>

								<div class="tab-pane" id="documentsTab" role="tabpanel">
								<?php if($profile_info_status > 0 && $vehicle_info_status > 0 && $bank_info_status > 0){ ?>
									<div class="row size-inner-section p-2">
										<?php if($doc_info_status == '0'){?>
										<div class="alert alert-warning" role="alert">Unverified documents.</div>
										<?php } ?>
										<div class="col-md-12 px-2 pb-4 mx-2">
											<?php echo form_open("admin/deliveryvehicle/document_verify", array("id"=>"doc_status_form", "class"=>"form-label-left", "data-parsley-validate"=> "")); ?>
												<input type="hidden" id="id" name="id" value="<?php echo $id;?>" required>
												<div class="row size-inner-section pt-3">
													<h5 class="scheduler-border">Document verification:</h5>
													<div class="col-md-3 col-sm-12 mb-3 form-group">
														<label for="doc_info_status">Document Status<span class="text-danger" required>*</span></label>
														<select name="doc_info_status" class="form-control select2" required>
															<option value="">Select Status</option>
															<option value="0" <?php echo ($doc_info_status == '0') ? "selected":"";?>>Pending</option>
															<option value="1" <?php echo ($doc_info_status == '1') ? "selected":"";?>>Approved</option>
															<option value="2" <?php echo ($doc_info_status == '2') ? "selected":"";?>>Rejected</option>
														</select>
														<small class="hint">Set document status for your Rider</small>
													</div>

													<div class="col-md-6 col-sm-12 mb-3 form-group <?php echo ($doc_info_status == 2) ? '' : 'd-none'; ?>" id="docReason">
														<label for="doc_reason">Document Rejection Reason<span class="text-danger" required>*</span></label>
														<select name="doc_reason" id="doc_reason" class="form-control select2">
															<option value="">Select Rejection Reason</option>
															<?php foreach( docReasonsHelper() as $item) { ?>
																<option value="<?php echo $item->name; ?>" <?php echo ($doc_reason == $item->name) ? "selected":"";?>><?php echo $item->name .' ( '.$item->name_ar.' )'; ?></option>
															<?php } ?>												
														</select>
														<small class="hint">Set document rejection reason for your Rider</small>
													</div>

													<div class="col-md-3 col-sm-12 mt-4">
														<button class="btn btn-success btn-md mt-1">Update Status</button>
													</div>
												</div>
											<?php echo form_close();?>
										</div>
										<h4 class="header-title mb-3">Upload required documents:</h4>
										<div class="col-md-3 col-sm-12 mb-3 form-group">
											<div class="upload-div">
												<label class="font-size-11 custom-label">Profile Picture (white background) <span class="text-danger">*</span></label>
												<div class="prfile-preview"><img id="fileInputphoto" src="<?= (!empty($documents->profile_picture)) ? base_url($documents->profile_picture) : base_url('images/no-image-icon.png');?>" /></div>
												<!-- File upload form -->
												<form id="uploadForm" enctype="multipart/form-data" method="POST">
													<input type="hidden" id="id" name="id" value="<?php echo $id;?>" required>
													<input type="hidden" name="o_profile_picture" value="<?php echo (!empty($documents->profile_picture)) ? $documents->profile_picture : '';?>">
													<input type="file" name="profile_picture" id="fileInput" onchange="document.getElementById('fileInputphoto').src = window.URL.createObjectURL(this.files[0])" required>
													<label for="fileInput">choose a file</label>
													<div>
													<input type="submit" class="btn btn-custom-success btn-sm mt-2 w-100" name="submit" value="Upload"/>
													</div>
												</form>
												<!-- Progress bar -->
												<div class="progress mt-3">
													<div class="progress-bar"></div>
												</div>
												<!-- Display upload status -->
												<div class="mt-2">
													<div id="uploadStatus"></div>
												</div>
											</div>
										</div>

										<div class="col-md-3 col-sm-12 mb-3 form-group">
											<div class="upload-div">
												<!-- File upload form -->
												<label class="font-size-11 custom-label">Iqama Image Front <span class="text-danger">*</span></label>
												<div class="prfile-preview"><img id="fileInput1photo" src="<?= (!empty($documents->iqama_image_front)) ? base_url($documents->iqama_image_front) : base_url('images/no-image-icon.png');?>" /></div>
												<form id="uploadForm1" enctype="multipart/form-data" method="POST">
													<input type="hidden" id="id" name="id" value="<?php echo $id;?>" required>
													<input type="hidden" name="o_iqama_image_front" value="<?php echo (!empty($documents->iqama_image_front)) ? $documents->iqama_image_front : '';?>">
													<input type="file" name="iqama_image_front" id="fileInput1" onchange="document.getElementById('fileInput1photo').src = window.URL.createObjectURL(this.files[0])" required>
													<label for="fileInput1">choose a file</label>
													<div>
													<input type="submit" class="btn btn-custom-success btn-sm mt-2 w-100" name="submit" value="Upload"/>
													</div>
												</form>
												<!-- Progress bar -->
												<div class="progress mt-3">
													<div class="progress-bar-1"></div>
												</div>
												<!-- Display upload status -->
												<div class="mt-2">
													<div id="uploadStatus1"></div>
												</div>
											</div>
										</div>

										<div class="col-md-3 col-sm-12 mb-3 form-group">
											<div class="upload-div">
												<!-- File upload form -->
												<label class="font-size-11 custom-label">Iqama Image Back <span class="text-danger">*</span></label>
												<div class="prfile-preview"><img id="fileInput2photo" src="<?= (!empty($documents->iqama_image_back)) ? base_url($documents->iqama_image_back) : base_url('images/no-image-icon.png');?>" /></div>
												<form id="uploadForm2" enctype="multipart/form-data" method="POST">
													<input type="hidden" id="id" name="id" value="<?php echo $id;?>" required>
													<input type="hidden" name="o_iqama_image_back" value="<?php echo (!empty($documents->iqama_image_back)) ? $documents->iqama_image_back : '';?>">
													<input type="file" name="iqama_image_back" id="fileInput2" onchange="document.getElementById('fileInput2photo').src = window.URL.createObjectURL(this.files[0])" required>
													<label for="fileInput2">choose a file</label>
													<div>
													<input type="submit" class="btn btn-custom-success btn-sm mt-2 w-100" name="submit" value="Upload"/>
													</div>
												</form>
												<!-- Progress bar -->
												<div class="progress mt-3">
													<div class="progress-bar-2"></div>
												</div>
												<!-- Display upload status -->
												<div class="mt-2">
													<div id="uploadStatus2"></div>
												</div>
											</div>
										</div>

										<div class="col-md-3 col-sm-12 mb-3 form-group">
											<div class="upload-div">
												<!-- File upload form -->
												<label class="font-size-11 custom-label">Driving Licence Front <span class="text-danger">*</span></label>
												<div class="prfile-preview"><img id="fileInput3photo" src="<?= (!empty($documents->driving_licence_front)) ? base_url($documents->driving_licence_front) : base_url('images/no-image-icon.png');?>" /></div>
												<form id="uploadForm3" enctype="multipart/form-data" method="POST">
													<input type="hidden" id="id" name="id" value="<?php echo $id;?>" required>
													<input type="hidden" name="o_driving_licence_front" value="<?php echo (!empty($documents->driving_licence_front)) ? $documents->driving_licence_front : '';?>">
													<input type="file" name="driving_licence_front" id="fileInput3" onchange="document.getElementById('fileInput3photo').src = window.URL.createObjectURL(this.files[0])" required>
													<label for="fileInput3">choose a file</label>
													<div>
													<input type="submit" class="btn btn-custom-success btn-sm mt-2 w-100" name="submit" value="Upload"/>
													</div>
												</form>
												<!-- Progress bar -->
												<div class="progress mt-3">
													<div class="progress-bar-3"></div>
												</div>
												<!-- Display upload status -->
												<div class="mt-2">
													<div id="uploadStatus3"></div>
												</div>
											</div>
											
										</div>

										<div class="col-md-3 col-sm-12 mb-3 form-group">
											<div class="upload-div">
												<!-- File upload form -->
												<label class="font-size-11 custom-label">Driving Licence Back <span class="text-danger">*</span></label>
												<div class="prfile-preview"><img id="fileInput4photo" src="<?= (!empty($documents->driving_licence_back)) ? base_url($documents->driving_licence_back) : base_url('images/no-image-icon.png');?>" /></div>
												<form id="uploadForm4" enctype="multipart/form-data" method="POST">
													<input type="hidden" id="id" name="id" value="<?php echo $id;?>" required>
													<input type="hidden" name="o_driving_licence_back" value="<?php echo (!empty($documents->driving_licence_back)) ? $documents->driving_licence_back : '';?>">
													<input type="file" name="driving_licence_back" id="fileInput4" onchange="document.getElementById('fileInput4photo').src = window.URL.createObjectURL(this.files[0])" required>
													<label for="fileInput4">choose a file</label>
													<div>
													<input type="submit" class="btn btn-custom-success btn-sm mt-2 w-100" name="submit" value="Upload"/>
													</div>
												</form>
												<!-- Progress bar -->
												<div class="progress mt-3">
													<div class="progress-bar-4"></div>
												</div>
												<!-- Display upload status -->
												<div class="mt-2">
													<div id="uploadStatus4"></div>
												</div>
											</div>
										</div>
										
										<div class="col-md-3 col-sm-12 mb-3 form-group">
											<div class="upload-div">
												<!-- File upload form -->
												<label class="mb-2 font-size-11 custom-label">IBAN Certificate (Account name and bank name must be clear) <span class="text-danger">*</span></label>
												<div class="prfile-preview"><img id="fileInput5photo" src="<?= (!empty($documents->iban_certificate)) ? base_url($documents->iban_certificate) : base_url('images/no-image-icon.png');?>" /></div>
												<form id="uploadForm5" enctype="multipart/form-data" method="POST">
													<input type="hidden" id="id" name="id" value="<?php echo $id;?>" required>
													<input type="hidden" name="o_iban_certificate" value="<?php echo (!empty($documents->iban_certificate)) ? $documents->iban_certificate : '';?>">
													<input type="file" name="iban_certificate" id="fileInput5" onchange="document.getElementById('fileInput5photo').src = window.URL.createObjectURL(this.files[0])" required>
													<label for="fileInput5">choose a file</label>
													<div>
													<input type="submit" class="btn btn-custom-success btn-sm mt-2 w-100" name="submit" value="Upload"/>
													</div>
												</form>
												<!-- Progress bar -->
												<div class="progress mt-3">
													<div class="progress-bar-5"></div>
												</div>
												<!-- Display upload status -->
												<div class="mt-2">
													<div id="uploadStatus5"></div>
												</div>
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
												<form id="uploadForm6" enctype="multipart/form-data" method="POST">
													<input type="hidden" id="id" name="id" value="<?php echo $id;?>" required>
													<input type="hidden" name="o_car_registration_front" value="<?php echo (!empty($documents->car_registration_front)) ? $documents->car_registration_front : '';?>">
													<input type="file" name="car_registration_front" id="fileInput6" onchange="document.getElementById('fileInput6photo').src = window.URL.createObjectURL(this.files[0])" required>
													<label for="fileInput6">choose a file</label>
													<div>
													<input type="submit" class="btn btn-custom-success btn-sm mt-2 w-100" name="submit" value="Upload"/>
													</div>
												</form>
												<!-- Progress bar -->
												<div class="progress mt-3">
													<div class="progress-bar-6"></div>
												</div>
												<!-- Display upload status -->
												<div class="mt-2">
													<div id="uploadStatus6"></div>
												</div>
											</div>
										</div>

										<div class="col-md-3 col-sm-12 mb-3 form-group">
											<div class="upload-div">
												<!-- File upload form -->
												<label class="mb-2 font-size-11 custom-label"><span class="vehicle-type">Car</span> Registration Back (Picture must be clear) <span class="text-danger">*</span></label>
												<div class="prfile-preview"><img id="fileInput7photo" src="<?= (!empty($documents->car_registration_back)) ? base_url($documents->car_registration_back) : base_url('images/no-image-icon.png');?>" /></div>
												<form id="uploadForm7" enctype="multipart/form-data" method="POST">
													<input type="hidden" id="id" name="id" value="<?php echo $id;?>" required>
													<input type="hidden" name="o_car_registration_back" value="<?php echo (!empty($documents->car_registration_back)) ? $documents->car_registration_back : '';?>">
													<input type="file" name="car_registration_back" id="fileInput7" onchange="document.getElementById('fileInput7photo').src = window.URL.createObjectURL(this.files[0])" required>
													<label for="fileInput7">choose a file</label>
													<div>
													<input type="submit" class="btn btn-custom-success btn-sm mt-2 w-100" name="submit" value="Upload"/>
													</div>
												</form>
												<!-- Progress bar -->
												<div class="progress mt-3">
													<div class="progress-bar-7"></div>
												</div>
												<!-- Display upload status -->
												<div class="mt-2">
													<div id="uploadStatus7"></div>
												</div>
											</div>
										</div>

										<div class="col-md-3 col-sm-12 mb-3 form-group">
											<div class="upload-div">
												<!-- File upload form -->
												<label class="font-size-11 custom-label"><span class="vehicle-type">Car</span> Insurance Picture <span class="text-danger">*</span></label>
												<div class="prfile-preview"><img id="fileInput8photo" src="<?= (!empty($documents->car_insurance_picture)) ? base_url($documents->car_insurance_picture) : base_url('images/no-image-icon.png');?>" /></div>
												<form id="uploadForm8" enctype="multipart/form-data" method="POST">
													<input type="hidden" id="id" name="id" value="<?php echo $id;?>" required>
													<input type="hidden" name="o_car_insurance_picture" value="<?php echo (!empty($documents->car_insurance_picture)) ? $documents->car_insurance_picture : '';?>">
													<input type="file" name="car_insurance_picture" id="fileInput8" onchange="document.getElementById('fileInput8photo').src = window.URL.createObjectURL(this.files[0])" required>
													<label for="fileInput8">choose a file</label>
													<div>
													<input type="submit" class="btn btn-custom-success btn-sm mt-2 w-100" name="submit" value="Upload"/>
													</div>
												</form>
												<!-- Progress bar -->
												<div class="progress mt-3">
													<div class="progress-bar-8"></div>
												</div>
												<!-- Display upload status -->
												<div class="mt-2">
													<div id="uploadStatus8"></div>
												</div>
											</div>
										</div>

										<div class="col-md-3 col-sm-12 mb-3 form-group <?php echo ($service_type == 'bike') ? "d-none":"";?>" id="vehicleFront">
											<div class="upload-div">
												<!-- File upload form -->
												<label class="mb-2 font-size-11 custom-label">A front-side photo of your <span class="vehicle-type">Car</span> with the plate no. visible <span class="text-danger">*</span></label>
												<div class="prfile-preview"><img id="fileInput9photo" src="<?= (!empty($documents->car_front_side)) ? base_url($documents->car_front_side) : base_url('images/no-image-icon.png');?>" /></div>
												<form id="uploadForm9" enctype="multipart/form-data" method="POST">
													<input type="hidden" id="id" name="id" value="<?php echo $id;?>" required>
													<input type="hidden" name="o_car_front_side" value="<?php echo (!empty($documents->car_front_side)) ? $documents->car_front_side : '';?>">
													<input type="file" name="car_front_side" id="fileInput9" onchange="document.getElementById('fileInput9photo').src = window.URL.createObjectURL(this.files[0])" required>
													<label for="fileInput9">choose a file</label>
													<div>
													<input type="submit" class="btn btn-custom-success btn-sm mt-2 w-100" name="submit" value="Upload"/>
													</div>
												</form>
												<!-- Progress bar -->
												<div class="progress mt-3">
													<div class="progress-bar-9"></div>
												</div>
												<!-- Display upload status -->
												<div class="mt-2">
													<div id="uploadStatus9"></div>
												</div>
											</div>
										</div>

										<div class="col-md-3 col-sm-12 mb-3 form-group">
											<div class="upload-div">
												<!-- File upload form -->
												<label class="mb-2 font-size-11 custom-label">A back-side photo of your <span class="vehicle-type">Car</span> with the plate no. visible <span class="text-danger">*</span></label>
												<div class="prfile-preview"><img id="fileInput10photo" src="<?= (!empty($documents->car_back_side)) ? base_url($documents->car_back_side) : base_url('images/no-image-icon.png');?>" /></div>
												<form id="uploadForm10" enctype="multipart/form-data" method="POST">
													<input type="hidden" id="id" name="id" value="<?php echo $id;?>" required>
													<input type="hidden" name="o_car_back_side" value="<?php echo (!empty($documents->car_back_side)) ? $documents->car_back_side : '';?>">
													<input type="file" name="car_back_side" id="fileInput10" onchange="document.getElementById('fileInput10photo').src = window.URL.createObjectURL(this.files[0])" required>
													<label for="fileInput10">choose a file</label>
													<div>
													<input type="submit" class="btn btn-custom-success btn-sm mt-2 w-100" name="submit" value="Upload"/>
													</div>
												</form>
												<!-- Progress bar -->
												<div class="progress mt-3">
													<div class="progress-bar-10"></div>
												</div>
												<!-- Display upload status -->
												<div class="mt-2">
													<div id="uploadStatus10"></div>
												</div>
											</div>
										</div>

										<div class="col-md-3 col-sm-12 mb-3 form-group <?php echo ($service_type == 'bike') ? "d-none":"";?>" id="vehicleRight">
											<div class="upload-div">
												<!-- File upload form -->
												<label class="font-size-11 custom-label" style="margin-bottom: 27px;">A right-side photo of your <span class="vehicle-type">Car</span> <span class="text-danger">*</span></label>
												<div class="prfile-preview"><img id="fileInput11photo" src="<?= (!empty($documents->car_right_side)) ? base_url($documents->car_right_side) : base_url('images/no-image-icon.png');?>" /></div>
												<form id="uploadForm11" enctype="multipart/form-data" method="POST">
													<input type="hidden" id="id" name="id" value="<?php echo $id;?>" required>
													<input type="hidden" name="o_car_right_side" value="<?php echo (!empty($documents->car_right_side)) ? $documents->car_right_side : '';?>">
													<input type="file" name="car_right_side" id="fileInput11" onchange="document.getElementById('fileInput11photo').src = window.URL.createObjectURL(this.files[0])" required>
													<label for="fileInput11">choose a file</label>
													<div>
													<input type="submit" class="btn btn-custom-success btn-sm mt-2 w-100" name="submit" value="Upload"/>
													</div>
												</form>
												<!-- Progress bar -->
												<div class="progress mt-3">
													<div class="progress-bar-11"></div>
												</div>
												<!-- Display upload status -->
												<div class="mt-2">
													<div id="uploadStatus11"></div>
												</div>
											</div>
											
										</div>

										<div class="col-md-3 col-sm-12 mb-3 form-group <?php echo ($service_type == 'bike') ? 'd-none':'';?>" id="vehicleLeft">
											<div class="upload-div">
												<!-- File upload form -->
												<label class="font-size-11 custom-label" style="margin-bottom: 27px;">A left-side photo of your <span class="vehicle-type">Car</span> <span class="text-danger">*</span></label>
												<div class="prfile-preview"><img id="fileInput12photo" src="<?= (!empty($documents->car_left_side)) ? base_url($documents->car_left_side) : base_url('images/no-image-icon.png');?>" /></div>
												<form id="uploadForm12" enctype="multipart/form-data" method="POST">
													<input type="hidden" id="id" name="id" value="<?php echo $id;?>" required>
													<input type="hidden" name="o_car_left_side" value="<?php echo (!empty($documents->car_left_side)) ? $documents->car_left_side : '';?>">
													<input type="file" name="car_left_side" id="fileInput12" onchange="document.getElementById('fileInput12photo').src = window.URL.createObjectURL(this.files[0])" required>
													<label for="fileInput12">choose a file</label>
													<div>
													<input type="submit" class="btn btn-custom-success btn-sm mt-2 w-100" name="submit" value="Upload"/>
													</div>
												</form>
												<!-- Progress bar -->
												<div class="progress mt-3">
													<div class="progress-bar-12"></div>
												</div>
												<!-- Display upload status -->
												<div class="mt-2">
													<div id="uploadStatus12"></div>
												</div>
											</div>
										</div>
									</div>
									<?php }else{ ?>
										<div class="alert alert-danger show" role="alert">
											<strong>Alert!</strong>  Fill all information first to access this tab.
										</div>
									<?php } ?>
								</div>

								<div class="tab-pane" id="salaryTab" role="tabpanel">
									<?php if($profile_info_status > 0 && $vehicle_info_status > 0 && $bank_info_status > 0){ ?>
									<?php echo form_open("admin/deliveryvehicle/save_salary_info", array("id"=>"salary-form", "enctype"=>"multipart/form-data", "class"=>"form-label-left", "data-parsley-validate"=> "")); ?>
										<input type="hidden" id="id" name="id" value="<?php echo $id;?>" required>
										<div class="row size-inner-section p-2">
											<h4 class="header-title">Fill your required salary information</h4>

											<div class="col-md-4 col-sm-12 mb-3 form-group">
												<label for="rider_payout_structure">Salary Payout Structure<span class="text-danger" required>*</span></label>
												<select name="rider_payout_structure" id="rider_payout_structure" class="form-control select2" required>
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
											
											<div class="col-md-12 col-sm-12 mb-3 form-group">
												<button class="btn btn-success btn-md float-end">Update</button>
											</div>
										</div>
									<?= form_close();?>
									<?php }else{ ?>
										<div class="alert alert-danger show" role="alert">
											<strong>Alert!</strong>  Fill all information first to access this tab.
										</div>
									<?php } ?>
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

<?php $this->load->view('admin/home/footer');?>
<script type="text/javascript">
	var base_url = '<?= base_url();?>';
</script>
<script>
	$(function(){
		var dtToday = new Date();
		
		var month = dtToday.getMonth() + 1;
		var day = dtToday.getDate();
		var year = dtToday.getFullYear();
	   
		//$('#cr_expiry').attr('min', maxDate);
		//$('#agrement_expiry').attr('min', maxDate);
		//$('#vehicle_expiry').attr('min', maxDate);
		//$('#passport_exp').attr('min', maxDate);
	});

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

	$(document).ready(function() {
	    var region_id = "<?= ($region_id == '') ? 'NULL' : $region_id; ?>";
		//console.log(region_id);
	    selectedCity(region_id);
		
		var service_type = "<?= ($service_type == '') ? 'NULL' : $service_type; ?>";
	    selectedVehicleMake(service_type);

		var van_make = "<?= ($van_make == '') ? 'NULL' : $van_make; ?>";
	    selectedVehicleModel(van_make);

		var bankId = "<?= ($bank_name == '') ? 'NULL' : $bank_name; ?>";
	    bankFields(bankId);
		
	});

	function selectedCity(region_id){
		var add_city_id = "<?= ($city == '') ? 'NULL' : $city; ?>";
		//alert(region_id);
		if(region_id !== 'NULL'){
			$.ajax({
				url: "<?php echo base_url(); ?>admin/deliveryvehicle/get_region_cities",
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
			$("#van_no").attr("maxlength", "5");
			$("#van_no").attr("minlength", "5");
			$(".vehicle-type").html("Bike");
		}else{
			$("#van_no").attr("maxlength", "7");
			$("#van_no").attr("minlength", "7");
			$(".vehicle-type").html("Car");
		}
		if(service_type !== 'NULL'){
			$.ajax({
				url: "<?php echo base_url(); ?>admin/deliveryvehicle/vehicle_make_list",
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
				url: "<?php echo base_url(); ?>admin/deliveryvehicle/get_vehicle_type",
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
			url: "<?php echo base_url(); ?>admin/deliveryvehicle/get_region_cities",
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
		if(service_id == 'bike'){
			$("#van_no").attr("maxlength", "5");
			$("#van_no").attr("minlength", "5");
			$(".vehicle-type").html("Bike");
			$("#vehicleFront").removeClass("d-none").addClass(' d-none');
			$("#vehicleRight").removeClass("d-none").addClass(' d-none');
			$("#vehicleLeft").removeClass("d-none").addClass(' d-none');
		}else{
			$("#van_no").attr("maxlength", "7");
			$("#van_no").attr("minlength", "7");
			$(".vehicle-type").html("Car");
			$("#vehicleFront").removeClass("d-none");
			$("#vehicleRight").removeClass("d-none");
			$("#vehicleLeft").removeClass("d-none");
		}
		$.ajax({
			url: "<?php echo base_url(); ?>admin/deliveryvehicle/vehicle_make_list",
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
			url: "<?php echo base_url(); ?>admin/deliveryvehicle/get_vehicle_type",
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
					url: '<?php echo base_url();?>admin/deliveryvehicle/verify',
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

	$('#bank_name').change(function() {
		var bank_id = $(this).find('option:selected').val();
		$('#iban').val('');
		$('#stc_pay_no').val('');
		bankFields(bank_id);
	});

	function bankFields(bank_id){
		if(bank_id == '3'){
			$('#iban_cont').addClass('d-none').removeClass('d-block');
			$('#iban').prop('required',false);

			$('#stcpay_cont').addClass('d-block').removeClass('d-none');
			$('#stc_pay_no').prop('required',true);
		}else{
			$('#stcpay_cont').addClass('d-none').removeClass('d-block');
			$('#stc_pay_no').prop('required',false);

			$('#iban_cont').addClass('d-block').removeClass('d-none');
			$('#iban').prop('required',true);
		}
	}

	$('#vehicle_no').on('change', function() {
		var vehicleid = $( "#vehicle_no option:selected" ).data("id");
		//alert(clientid);
		get_bike_detail(vehicleid);
	});

	function get_bike_detail(u){
		$.ajax({
			url: '<?php echo base_url();?>admin/deliveryvehicle/vehicle_detail',
			type: "GET",
			data: {'id':u},
			success: function(data){ 
				var result = JSON.parse(data);
				console.log(result);
				if(result){
					$("#service_type").val(result.vehicle_type);
					$("#vehicle_make").val(result.vehicle_make);
					$("#vehicle_color").val(result.vehicle_color);

					$("#vehicle_year").val(result.vehicle_year);
					$("#purchse_date").val(result.purchase_date);
					$("#vehicle_expiry").val(result.vehicle_expiry);
					$("#vehicle_make_demo").val(result.make_name);
					$("#vehicle_type").val(result.vehicle_model);
					$("#vehicle_color_demo").val(result.color_name);
					$("#chassis_no").val(result.chassis_no);
					$("#insurance_no").val(result.insurance_no);
					$("#insurance_expiry").val(result.insurance_expiry);
					$("#sequel_no").val(result.sequel_no);
					
				}else{
					//alert('Data not found');
					$("#service_type").val('');
					$("#van_make").val('');
					$("#vehicle_color").val('');
					$("#vehicle_year").val('');
					$("#purchse_date").val('');
					$("#vehicle_expiry").val('');
					$("#vehicle_make_demo").val('');
					$("#vehicle_type").val('');
					$("#vehicle_color_demo").val('');
					$("#chassis_no").val('');
					$("#insurance_no").val('');
					$("#insurance_expiry").val('');
					$("#sequel_no").val('');
				}
			},
			error: function(data){
				alert(data);
			}
		});
	}
</script>

<script>
/*----- Upload File Ajax ----*/
$("#uploadForm").on('submit', function(e){
	
	e.preventDefault();
	$.ajax({
		xhr: function() {
			var xhr = new window.XMLHttpRequest();
			xhr.upload.addEventListener("progress", function(evt) {
				if (evt.lengthComputable) {
					var percentComplete = ((evt.loaded / evt.total) * 100);
					$(".progress-bar").width(percentComplete + '%');
					$(".progress-bar").html(percentComplete+'%');
				}
			}, false);
			return xhr;
		},
		type: 'POST',
		url: base_url+"admin/deliveryvehicle/upload_profile_pic",
		data: new FormData(this),
		contentType: false,
		cache: false,
		processData:false,
		beforeSend: function(){
			//console.log('send');
			$(".progress-bar").width('0%');
			$('#uploadStatus').html('<i class="fa fa-spinner spin" aria-hidden="true"></i>');
		},
		success: function(resp){
			if(resp == 'ok'){
				//console.log('success');
				$('#uploadForm')[0].reset();
				$('#uploadForm').remove();
				$('#uploadStatus').html('<p style="color:#28A74B;font-size: 13px;">File has been uploaded successfully!</p>');
			}else if(resp == 'err'){
				//console.log('fail');
				$('#uploadStatus').html('<p style="color:#EA4335;font-size: 14px;">Please select a valid file to upload.</p>');
			}
		},
		error:function(resp){
			//console.log(resp);
			$('#uploadStatus').html('<p style="color:#EA4335;font-size: 14px;">File upload failed, please try again.</p>');
		}
	});
});

// File type validation
$("#fileInput").change(function(){
	var allowedTypes = ['application/pdf', 'application/msword', 'application/vnd.ms-office', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'image/jpeg', 'image/png', 'image/jpg', 'image'];
	var file = this.files[0];
	var fileType = file.type;
	if(!allowedTypes.includes(fileType)){
		alert('Please select a valid file (PDF/DOC/DOCX/JPEG/JPG/PNG).');
		$("#fileInput").val('');
		return false;
	}
});

/*----- Upload Iqama Front ----*/
$("#uploadForm1").on('submit', function(e){
	e.preventDefault();
	$.ajax({
		xhr: function() {
			var xhr = new window.XMLHttpRequest();
			xhr.upload.addEventListener("progress", function(evt) {
				if (evt.lengthComputable) {
					var percentComplete = ((evt.loaded / evt.total) * 100);
					$(".progress-bar-1").width(percentComplete + '%');
					$(".progress-bar-1").html(percentComplete+'%');
				}
			}, false);
			return xhr;
		},
		type: 'POST',
		url: base_url+"admin/deliveryvehicle/upload_iqama_front",
		data: new FormData(this),
		contentType: false,
		cache: false,
		processData:false,
		beforeSend: function(){
			//console.log('send');
			$(".progress-bar-1").width('0%');
			$('#uploadStatus1').html('<i class="fa fa-spinner spin" aria-hidden="true"></i>');
		},
		success: function(resp){
			if(resp == 'ok'){
				//console.log('success');
				$('#uploadForm1')[0].reset();
				$('#uploadForm1').remove();
				$('#uploadStatus1').html('<p style="color:#28A74B;font-size: 13px;">File has been uploaded successfully!</p>');
			}else if(resp == 'err'){
				//console.log('fail');
				$('#uploadStatus1').html('<p style="color:#EA4335;font-size: 14px;">Please select a valid file to upload.</p>');
			}
		},
		error:function(resp){
			//console.log(resp);
			$('#uploadStatus1').html('<p style="color:#EA4335;font-size: 14px;">File upload failed, please try again.</p>');
		}
	});
});

// File type validation
$("#fileInput1").change(function(){
	var allowedTypes = ['application/pdf', 'application/msword', 'application/vnd.ms-office', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'image/jpeg', 'image/png', 'image/jpg', 'image'];
	var file = this.files[0];
	var fileType = file.type;
	if(!allowedTypes.includes(fileType)){
		alert('Please select a valid file (PDF/DOC/DOCX/JPEG/JPG/PNG).');
		$("#fileInput1").val('');
		return false;
	}
});

/*----- Upload Iqama Back ----*/
$("#uploadForm2").on('submit', function(e){
	e.preventDefault();
	$.ajax({
		xhr: function() {
			var xhr = new window.XMLHttpRequest();
			xhr.upload.addEventListener("progress", function(evt) {
				if (evt.lengthComputable) {
					var percentComplete = ((evt.loaded / evt.total) * 100);
					$(".progress-bar-2").width(percentComplete + '%');
					$(".progress-bar-2").html(percentComplete+'%');
				}
			}, false);
			return xhr;
		},
		type: 'POST',
		url: base_url+"admin/deliveryvehicle/upload_iqama_back",
		data: new FormData(this),
		contentType: false,
		cache: false,
		processData:false,
		beforeSend: function(){
			//console.log('send');
			$(".progress-bar-2").width('0%');
			$('#uploadStatus2').html('<i class="fa fa-spinner spin" aria-hidden="true"></i>');
		},
		success: function(resp){
			if(resp == 'ok'){
				//console.log('success');
				$('#uploadForm2')[0].reset();
				$('#uploadForm2').remove();
				$('#uploadStatus2').html('<p style="color:#28A74B;font-size: 13px;">File has been uploaded successfully!</p>');
			}else if(resp == 'err'){
				//console.log('fail');
				$('#uploadStatus2').html('<p style="color:#EA4335;font-size: 14px;">Please select a valid file to upload.</p>');
			}
		},
		error:function(resp){
			//console.log(resp);
			$('#uploadStatus2').html('<p style="color:#EA4335;font-size: 14px;">File upload failed, please try again.</p>');
		}
	});
});

// File type validation
$("#fileInput2").change(function(){
	var allowedTypes = ['application/pdf', 'application/msword', 'application/vnd.ms-office', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'image/jpeg', 'image/png', 'image/jpg', 'image'];
	var file = this.files[0];
	var fileType = file.type;
	if(!allowedTypes.includes(fileType)){
		alert('Please select a valid file (PDF/DOC/DOCX/JPEG/JPG/PNG).');
		$("#fileInput2").val('');
		return false;
	}
});

/*----- Upload Driving Licence ----*/
$("#uploadForm3").on('submit', function(e){
	e.preventDefault();
	$.ajax({
		xhr: function() {
			var xhr = new window.XMLHttpRequest();
			xhr.upload.addEventListener("progress", function(evt) {
				if (evt.lengthComputable) {
					var percentComplete = ((evt.loaded / evt.total) * 100);
					$(".progress-bar-3").width(percentComplete + '%');
					$(".progress-bar-3").html(percentComplete+'%');
				}
			}, false);
			return xhr;
		},
		type: 'POST',
		url: base_url+"admin/deliveryvehicle/upload_licence_front",
		data: new FormData(this),
		contentType: false,
		cache: false,
		processData:false,
		beforeSend: function(){
			//console.log('send');
			$(".progress-bar-3").width('0%');
			$('#uploadStatus3').html('<i class="fa fa-spinner spin" aria-hidden="true"></i>');
		},
		success: function(resp){
			if(resp == 'ok'){
				//console.log('success');
				$('#uploadForm3')[0].reset();
				$('#uploadForm3').remove();
				$('#uploadStatus3').html('<p style="color:#28A74B;font-size: 13px;">File has been uploaded successfully!</p>');
			}else if(resp == 'err'){
				//console.log('fail');
				$('#uploadStatus3').html('<p style="color:#EA4335;font-size: 14px;">Please select a valid file to upload.</p>');
			}
		},
		error:function(resp){
			//console.log(resp);
			$('#uploadStatus3').html('<p style="color:#EA4335;font-size: 14px;">File upload failed, please try again.</p>');
		}
	});
});

// File type validation
$("#fileInput3").change(function(){
	var allowedTypes = ['application/pdf', 'application/msword', 'application/vnd.ms-office', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'image/jpeg', 'image/png', 'image/jpg', 'image'];
	var file = this.files[0];
	var fileType = file.type;
	if(!allowedTypes.includes(fileType)){
		alert('Please select a valid file (PDF/DOC/DOCX/JPEG/JPG/PNG).');
		$("#fileInput2").val('');
		return false;
	}
});

/*----- Upload Driving Licence Back ----*/
$("#uploadForm4").on('submit', function(e){
	e.preventDefault();
	$.ajax({
		xhr: function() {
			var xhr = new window.XMLHttpRequest();
			xhr.upload.addEventListener("progress", function(evt) {
				if (evt.lengthComputable) {
					var percentComplete = ((evt.loaded / evt.total) * 100);
					$(".progress-bar-4").width(percentComplete + '%');
					$(".progress-bar-4").html(percentComplete+'%');
				}
			}, false);
			return xhr;
		},
		type: 'POST',
		url: base_url+"admin/deliveryvehicle/upload_licence_back",
		data: new FormData(this),
		contentType: false,
		cache: false,
		processData:false,
		beforeSend: function(){
			//console.log('send');
			$(".progress-bar-4").width('0%');
			$('#uploadStatus4').html('<i class="fa fa-spinner spin" aria-hidden="true"></i>');
		},
		success: function(resp){
			if(resp == 'ok'){
				//console.log('success');
				$('#uploadForm4')[0].reset();
				$('#uploadForm4').remove();
				$('#uploadStatus4').html('<p style="color:#28A74B;font-size: 13px;">File has been uploaded successfully!</p>');
			}else if(resp == 'err'){
				//console.log('fail');
				$('#uploadStatus4').html('<p style="color:#EA4335;font-size: 14px;">Please select a valid file to upload.</p>');
			}
		},
		error:function(resp){
			//console.log(resp);
			$('#uploadStatus4').html('<p style="color:#EA4335;font-size: 14px;">File upload failed, please try again.</p>');
		}
	});
});

// File type validation
$("#fileInput4").change(function(){
	var allowedTypes = ['application/pdf', 'application/msword', 'application/vnd.ms-office', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'image/jpeg', 'image/png', 'image/jpg', 'image'];
	var file = this.files[0];
	var fileType = file.type;
	if(!allowedTypes.includes(fileType)){
		alert('Please select a valid file (PDF/DOC/DOCX/JPEG/JPG/PNG).');
		$("#fileInput4").val('');
		return false;
	}
});

/*----- Upload IBAN Certificate ----*/
$("#uploadForm5").on('submit', function(e){
	e.preventDefault();
	$.ajax({
		xhr: function() {
			var xhr = new window.XMLHttpRequest();
			xhr.upload.addEventListener("progress", function(evt) {
				if (evt.lengthComputable) {
					var percentComplete = ((evt.loaded / evt.total) * 100);
					$(".progress-bar-5").width(percentComplete + '%');
					$(".progress-bar-5").html(percentComplete+'%');
				}
			}, false);
			return xhr;
		},
		type: 'POST',
		url: base_url+"admin/deliveryvehicle/upload_iban",
		data: new FormData(this),
		contentType: false,
		cache: false,
		processData:false,
		beforeSend: function(){
			//console.log('send');
			$(".progress-bar-5").width('0%');
			$('#uploadStatus5').html('<i class="fa fa-spinner spin" aria-hidden="true"></i>');
		},
		success: function(resp){
			if(resp == 'ok'){
				//console.log('success');
				$('#uploadForm5')[0].reset();
				$('#uploadForm5').remove();
				$('#uploadStatus5').html('<p style="color:#28A74B;font-size: 13px;">File has been uploaded successfully!</p>');
			}else if(resp == 'err'){
				//console.log('fail');
				$('#uploadStatus5').html('<p style="color:#EA4335;font-size: 14px;">Please select a valid file to upload.</p>');
			}
		},
		error:function(resp){
			//console.log(resp);
			$('#uploadStatus5').html('<p style="color:#EA4335;font-size: 14px;">File upload failed, please try again.</p>');
		}
	});
});

// File type validation
$("#fileInput5").change(function(){
	var allowedTypes = ['application/pdf', 'application/msword', 'application/vnd.ms-office', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'image/jpeg', 'image/png', 'image/jpg', 'image'];
	var file = this.files[0];
	var fileType = file.type;
	if(!allowedTypes.includes(fileType)){
		alert('Please select a valid file (PDF/DOC/DOCX/JPEG/JPG/PNG).');
		$("#fileInput5").val('');
		return false;
	}
});

/*----- Upload Car Registration Front ----*/
$("#uploadForm6").on('submit', function(e){
	e.preventDefault();
	$.ajax({
		xhr: function() {
			var xhr = new window.XMLHttpRequest();
			xhr.upload.addEventListener("progress", function(evt) {
				if (evt.lengthComputable) {
					var percentComplete = ((evt.loaded / evt.total) * 100);
					$(".progress-bar-6").width(percentComplete + '%');
					$(".progress-bar-6").html(percentComplete+'%');
				}
			}, false);
			return xhr;
		},
		type: 'POST',
		url: base_url+"admin/deliveryvehicle/upload_car_reg_front",
		data: new FormData(this),
		contentType: false,
		cache: false,
		processData:false,
		beforeSend: function(){
			//console.log('send');
			$(".progress-bar-6").width('0%');
			$('#uploadStatus6').html('<i class="fa fa-spinner spin" aria-hidden="true"></i>');
		},
		success: function(resp){
			if(resp == 'ok'){
				//console.log('success');
				$('#uploadForm6')[0].reset();
				$('#uploadForm6').remove();
				$('#uploadStatus6').html('<p style="color:#28A74B;font-size: 13px;">File has been uploaded successfully!</p>');
			}else if(resp == 'err'){
				//console.log('fail');
				$('#uploadStatus6').html('<p style="color:#EA4335;font-size: 14px;">Please select a valid file to upload.</p>');
			}
		},
		error:function(resp){
			//console.log(resp);
			$('#uploadStatus6').html('<p style="color:#EA4335;font-size: 14px;">File upload failed, please try again.</p>');
		}
	});
});

// File type validation
$("#fileInput6").change(function(){
	var allowedTypes = ['application/pdf', 'application/msword', 'application/vnd.ms-office', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'image/jpeg', 'image/png', 'image/jpg', 'image'];
	var file = this.files[0];
	var fileType = file.type;
	if(!allowedTypes.includes(fileType)){
		alert('Please select a valid file (PDF/DOC/DOCX/JPEG/JPG/PNG).');
		$("#fileInput6").val('');
		return false;
	}
});

/*----- Upload Car Registration Back ----*/
$("#uploadForm7").on('submit', function(e){
	e.preventDefault();
	$.ajax({
		xhr: function() {
			var xhr = new window.XMLHttpRequest();
			xhr.upload.addEventListener("progress", function(evt) {
				if (evt.lengthComputable) {
					var percentComplete = ((evt.loaded / evt.total) * 100);
					$(".progress-bar-7").width(percentComplete + '%');
					$(".progress-bar-7").html(percentComplete+'%');
				}
			}, false);
			return xhr;
		},
		type: 'POST',
		url: base_url+"admin/deliveryvehicle/upload_car_reg_back",
		data: new FormData(this),
		contentType: false,
		cache: false,
		processData:false,
		beforeSend: function(){
			//console.log('send');
			$(".progress-bar-7").width('0%');
			$('#uploadStatus7').html('<i class="fa fa-spinner spin" aria-hidden="true"></i>');
		},
		success: function(resp){
			if(resp == 'ok'){
				//console.log('success');
				$('#uploadForm7')[0].reset();
				$('#uploadForm7').remove();
				$('#uploadStatus7').html('<p style="color:#28A74B;font-size: 13px;">File has been uploaded successfully!</p>');
			}else if(resp == 'err'){
				//console.log('fail');
				$('#uploadStatus7').html('<p style="color:#EA4335;font-size: 14px;">Please select a valid file to upload.</p>');
			}
		},
		error:function(resp){
			//console.log(resp);
			$('#uploadStatus7').html('<p style="color:#EA4335;font-size: 14px;">File upload failed, please try again.</p>');
		}
	});
});

// File type validation
$("#fileInput7").change(function(){
	var allowedTypes = ['application/pdf', 'application/msword', 'application/vnd.ms-office', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'image/jpeg', 'image/png', 'image/jpg', 'image'];
	var file = this.files[0];
	var fileType = file.type;
	if(!allowedTypes.includes(fileType)){
		alert('Please select a valid file (PDF/DOC/DOCX/JPEG/JPG/PNG).');
		$("#fileInput7").val('');
		return false;
	}
});

/*----- Upload Car Insurance ----*/
$("#uploadForm8").on('submit', function(e){
	e.preventDefault();
	$.ajax({
		xhr: function() {
			var xhr = new window.XMLHttpRequest();
			xhr.upload.addEventListener("progress", function(evt) {
				if (evt.lengthComputable) {
					var percentComplete = ((evt.loaded / evt.total) * 100);
					$(".progress-bar-8").width(percentComplete + '%');
					$(".progress-bar-8").html(percentComplete+'%');
				}
			}, false);
			return xhr;
		},
		type: 'POST',
		url: base_url+"admin/deliveryvehicle/upload_car_insurance",
		data: new FormData(this),
		contentType: false,
		cache: false,
		processData:false,
		beforeSend: function(){
			//console.log('send');
			$(".progress-bar-8").width('0%');
			$('#uploadStatus8').html('<i class="fa fa-spinner spin" aria-hidden="true"></i>');
		},
		success: function(resp){
			if(resp == 'ok'){
				//console.log('success');
				$('#uploadForm8')[0].reset();
				$('#uploadForm8').remove();
				$('#uploadStatus8').html('<p style="color:#28A74B;font-size: 13px;">File has been uploaded successfully!</p>');
			}else if(resp == 'err'){
				//console.log('fail');
				$('#uploadStatus8').html('<p style="color:#EA4335;font-size: 14px;">Please select a valid file to upload.</p>');
			}
		},
		error:function(resp){
			//console.log(resp);
			$('#uploadStatus8').html('<p style="color:#EA4335;font-size: 14px;">File upload failed, please try again.</p>');
		}
	});
});

// File type validation
$("#fileInput8").change(function(){
	var allowedTypes = ['application/pdf', 'application/msword', 'application/vnd.ms-office', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'image/jpeg', 'image/png', 'image/jpg', 'image'];
	var file = this.files[0];
	var fileType = file.type;
	if(!allowedTypes.includes(fileType)){
		alert('Please select a valid file (PDF/DOC/DOCX/JPEG/JPG/PNG).');
		$("#fileInput8").val('');
		return false;
	}
});

/*----- Upload Car Front ----*/
$("#uploadForm9").on('submit', function(e){
	e.preventDefault();
	$.ajax({
		xhr: function() {
			var xhr = new window.XMLHttpRequest();
			xhr.upload.addEventListener("progress", function(evt) {
				if (evt.lengthComputable) {
					var percentComplete = ((evt.loaded / evt.total) * 100);
					$(".progress-bar-9").width(percentComplete + '%');
					$(".progress-bar-9").html(percentComplete+'%');
				}
			}, false);
			return xhr;
		},
		type: 'POST',
		url: base_url+"admin/deliveryvehicle/upload_car_front",
		data: new FormData(this),
		contentType: false,
		cache: false,
		processData:false,
		beforeSend: function(){
			//console.log('send');
			$(".progress-bar-9").width('0%');
			$('#uploadStatus9').html('<i class="fa fa-spinner spin" aria-hidden="true"></i>');
		},
		success: function(resp){
			if(resp == 'ok'){
				//console.log('success');
				$('#uploadForm9')[0].reset();
				$('#uploadForm9').remove();
				$('#uploadStatus9').html('<p style="color:#28A74B;font-size: 13px;">File has been uploaded successfully!</p>');
			}else if(resp == 'err'){
				//console.log('fail');
				$('#uploadStatus9').html('<p style="color:#EA4335;font-size: 14px;">Please select a valid file to upload.</p>');
			}
		},
		error:function(resp){
			//console.log(resp);
			$('#uploadStatus9').html('<p style="color:#EA4335;font-size: 14px;">File upload failed, please try again.</p>');
		}
	});
});

// File type validation
$("#fileInput9").change(function(){
	var allowedTypes = ['application/pdf', 'application/msword', 'application/vnd.ms-office', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'image/jpeg', 'image/png', 'image/jpg', 'image'];
	var file = this.files[0];
	var fileType = file.type;
	if(!allowedTypes.includes(fileType)){
		alert('Please select a valid file (PDF/DOC/DOCX/JPEG/JPG/PNG).');
		$("#fileInput9").val('');
		return false;
	}
});

/*----- Upload Car Back ----*/
$("#uploadForm10").on('submit', function(e){
	e.preventDefault();
	$.ajax({
		xhr: function() {
			var xhr = new window.XMLHttpRequest();
			xhr.upload.addEventListener("progress", function(evt) {
				if (evt.lengthComputable) {
					var percentComplete = ((evt.loaded / evt.total) * 100);
					$(".progress-bar-10").width(percentComplete + '%');
					$(".progress-bar-10").html(percentComplete+'%');
				}
			}, false);
			return xhr;
		},
		type: 'POST',
		url: base_url+"admin/deliveryvehicle/upload_car_back",
		data: new FormData(this),
		contentType: false,
		cache: false,
		processData:false,
		beforeSend: function(){
			//console.log('send');
			$(".progress-bar-10").width('0%');
			$('#uploadStatus10').html('<i class="fa fa-spinner spin" aria-hidden="true"></i>');
		},
		success: function(resp){
			if(resp == 'ok'){
				//console.log('success');
				$('#uploadForm10')[0].reset();
				$('#uploadForm10').remove();
				$('#uploadStatus10').html('<p style="color:#28A74B;font-size: 13px;">File has been uploaded successfully!</p>');
			}else if(resp == 'err'){
				//console.log('fail');
				$('#uploadStatus10').html('<p style="color:#EA4335;font-size: 14px;">Please select a valid file to upload.</p>');
			}
		},
		error:function(resp){
			//console.log(resp);
			$('#uploadStatus10').html('<p style="color:#EA4335;font-size: 14px;">File upload failed, please try again.</p>');
		}
	});
});

// File type validation
$("#fileInput10").change(function(){
	var allowedTypes = ['application/pdf', 'application/msword', 'application/vnd.ms-office', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'image/jpeg', 'image/png', 'image/jpg', 'image'];
	var file = this.files[0];
	var fileType = file.type;
	if(!allowedTypes.includes(fileType)){
		alert('Please select a valid file (PDF/DOC/DOCX/JPEG/JPG/PNG).');
		$("#fileInput10").val('');
		return false;
	}
});

/*----- Upload Car Left ----*/
$("#uploadForm11").on('submit', function(e){
	e.preventDefault();
	$.ajax({
		xhr: function() {
			var xhr = new window.XMLHttpRequest();
			xhr.upload.addEventListener("progress", function(evt) {
				if (evt.lengthComputable) {
					var percentComplete = ((evt.loaded / evt.total) * 100);
					$(".progress-bar-11").width(percentComplete + '%');
					$(".progress-bar-11").html(percentComplete+'%');
				}
			}, false);
			return xhr;
		},
		type: 'POST',
		url: base_url+"admin/deliveryvehicle/upload_car_right",
		data: new FormData(this),
		contentType: false,
		cache: false,
		processData:false,
		beforeSend: function(){
			//console.log('send');
			$(".progress-bar-11").width('0%');
			$('#uploadStatus11').html('<i class="fa fa-spinner spin" aria-hidden="true"></i>');
		},
		success: function(resp){
			if(resp == 'ok'){
				//console.log('success');
				$('#uploadForm11')[0].reset();
				$('#uploadForm11').remove();
				$('#uploadStatus11').html('<p style="color:#28A74B;font-size: 13px;">File has been uploaded successfully!</p>');
			}else if(resp == 'err'){
				//console.log('fail');
				$('#uploadStatus11').html('<p style="color:#EA4335;font-size: 14px;">Please select a valid file to upload.</p>');
			}
		},
		error:function(resp){
			//console.log(resp);
			$('#uploadStatus11').html('<p style="color:#EA4335;font-size: 14px;">File upload failed, please try again.</p>');
		}
	});
});

// File type validation
$("#fileInput11").change(function(){
	var allowedTypes = ['application/pdf', 'application/msword', 'application/vnd.ms-office', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'image/jpeg', 'image/png', 'image/jpg', 'image'];
	var file = this.files[0];
	var fileType = file.type;
	if(!allowedTypes.includes(fileType)){
		alert('Please select a valid file (PDF/DOC/DOCX/JPEG/JPG/PNG).');
		$("#fileInput11").val('');
		return false;
	}
});

/*----- Upload Car Right ----*/
$("#uploadForm12").on('submit', function(e){
	e.preventDefault();
	$.ajax({
		xhr: function() {
			var xhr = new window.XMLHttpRequest();
			xhr.upload.addEventListener("progress", function(evt) {
				if (evt.lengthComputable) {
					var percentComplete = ((evt.loaded / evt.total) * 100);
					$(".progress-bar-12").width(percentComplete + '%');
					$(".progress-bar-12").html(percentComplete+'%');
				}
			}, false);
			return xhr;
		},
		type: 'POST',
		url: base_url+"admin/deliveryvehicle/upload_car_left",
		data: new FormData(this),
		contentType: false,
		cache: false,
		processData:false,
		beforeSend: function(){
			//console.log('send');
			$(".progress-bar-12").width('0%');
			$('#uploadStatus12').html('<i class="fa fa-spinner spin" aria-hidden="true"></i>');
		},
		success: function(resp){
			if(resp == 'ok'){
				//console.log('success');
				$('#uploadForm12')[0].reset();
				$('#uploadForm12').remove();
				$('#uploadStatus12').html('<p style="color:#28A74B;font-size: 13px;">File has been uploaded successfully!</p>');
			}else if(resp == 'err'){
				//console.log('fail');
				$('#uploadStatus12').html('<p style="color:#EA4335;font-size: 14px;">Please select a valid file to upload.</p>');
			}
		},
		error:function(resp){
			//console.log(resp);
			$('#uploadStatus12').html('<p style="color:#EA4335;font-size: 14px;">File upload failed, please try again.</p>');
		}
	});
});

// File type validation
$("#fileInput12").change(function(){
	var allowedTypes = ['application/pdf', 'application/msword', 'application/vnd.ms-office', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'image/jpeg', 'image/png', 'image/jpg', 'image'];
	var file = this.files[0];
	var fileType = file.type;
	if(!allowedTypes.includes(fileType)){
		alert('Please select a valid file (PDF/DOC/DOCX/JPEG/JPG/PNG).');
		$("#fileInput12").val('');
		return false;
	}
});

$(document).ready(function(){
    $('.nav-link').removeClass('active');
    $('.tab-pane').removeClass('active');
    
    if ((<?php echo $profile_info_status; ?> == 0) && (<?php echo $vehicle_info_status; ?> == 0) && (<?php echo $bank_info_status; ?> == 0) && (<?php echo $doc_info_status; ?> == 0)) {
        $('.nav-link[href="#profileTab"]').addClass('active');
        $('#profileTab').addClass('active');
    } else if ((<?php echo $profile_info_status; ?> == 1) && (<?php echo $vehicle_info_status; ?> == 0) && (<?php echo $bank_info_status; ?> == 0) && (<?php echo $doc_info_status; ?> == 0)) {
        $('.nav-link[href="#vehicleTab"]').addClass('active');
        $('#vehicleTab').addClass('active');
    } else if ((<?php echo $profile_info_status; ?> == 1) && (<?php echo $vehicle_info_status; ?> == 1) && (<?php echo $bank_info_status; ?> == 0) && (<?php echo $doc_info_status; ?> == 0)) {
        $('.nav-link[href="#bankTab"]').addClass('active');
        $('#bankTab').addClass('active');
    } else if ((<?php echo $profile_info_status; ?> == 1) && (<?php echo $vehicle_info_status; ?> == 1) && (<?php echo $bank_info_status; ?> == 1) && (<?php echo $doc_info_status; ?> == 0)) {
        $('.nav-link[href="#documentsTab"]').addClass('active');
        $('#documentsTab').addClass('active');
    } else {
        $('.nav-link[href="#profileTab"]').addClass('active');
        $('#profileTab').addClass('active');
    }
});

$('select[name=status]').on('change',function(){
	var value = $('select[name=status] option:selected').val();
	// alert(value);
	if (value === '2') {
		$('#blockReason').removeClass('d-none');
		$('#block_reason').attr('required',true);
	} else {
		$('#blockReason').addClass('d-none');
		$('#block_reason').attr('required',false);
	}
});

$('select[name=doc_info_status]').on('change',function(){
	var value = $('select[name=doc_info_status] option:selected').val();
	// alert(value);
	if (value === '2') {
		$('#docReason').removeClass('d-none');
		$('#doc_reason').attr('required',true);
	} else {
		$('#docReason').addClass('d-none');
		$('#doc_reason').attr('required',false);
	}
});

</script>
