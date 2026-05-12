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
p.hint {
    font-size: 12px;
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
					<h4>3P Logistic Management</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin');?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/logistic-partner/list');?>">3P Logistic Management</a></li>
						<li class="breadcrumb-item active">Add or Edit</li>
					</ol>
				</div>
			</div>
			<?php  $admin_id= $this->session->userdata('admin_id'); ?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<?php if($this->customer->userd($admin_id)->role=="Admin" ){?>
					<a class="btn btn-sm btn-custom-white pull-right" title="Back" href="<?php echo base_url('admin/logistic-partner/list');?>"><i class="fa fa-reply"></i> Back</a>
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
						<?php if($application_status == 'unverified'){?>
						<div class="alert alert-warning" role="alert">
							This account in waiting for verification, please review detail before click verified <a type="button" onclick="verifyAction(this)" data-id="<?php echo $id;?>" class="alert-link text-danger ps-2"><u>Click to verify</u></a>.
						</div>
						<?php } ?>
						<div id="addproduct-nav-pills-wizard" class="twitter-bs-wizard">
							<ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
								<li class="nav-item">
									<a class="nav-link active" data-bs-toggle="tab" href="#profileTab" role="tab">
										<span class="d-block d-sm-none"><i class="mdi mdi-account-box"></i></span>
										<span class="d-none d-sm-block">Basic Information</span>
									</a>
								</li>
								
								<li class="nav-item">
									<a class="nav-link" data-bs-toggle="tab" href="#bankTab" role="tab">
										<span class="d-block d-sm-none"><i class="mdi mdi-bank-transfer"></i></span>
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
									<a class="nav-link" data-bs-toggle="tab" href="#commissionTab" role="tab">
										<span class="d-block d-sm-none"><i class="dripicons-document"></i></span>
										<span class="d-none d-sm-block">Commission Structure</span>
									</a>
								</li>
							</ul>

							<div class="tab-content py-3 text-muted">
								<div class="tab-pane active" id="profileTab" role="tabpanel">
									
									<?php echo form_open("admin/logistic-partner/save", array("id"=>"application-form", "enctype"=>"multipart/form-data", "class"=>"form-label-left", "data-parsley-validate"=> "")); ?>
									<div class="row size-inner-section p-2">
										<?php if($partner_basic_status == '0'){?>
										<div class="alert alert-info" role="alert">Incomplete basic information.</div>
										<?php } ?>
										<h4 class="header-title">Fill rquired Information</h4>
										<input type="hidden" id="id" name="id" value="<?php echo $id;?>">
										<div class="col-md-3 col-sm-12 mb-3 form-group">
											<label for="customer_no">Partner Account ID  <span class="text-danger">*</span></label>
											<input type="text" class="form-control" id="customer_no" name="customer_no" maxlength="150" value="<?php echo $customer_no;?>" required readonly />
											<p class="hint">ID will be automatically generated</p>
										</div>
										
										<div class="col-md-3 col-sm-12 mb-3 form-group">
											<label for="account_manager">Client Account Manager<span class="text-danger">*</span></label>
											<select name="account_manager" class="form-control select2" required>
												<option value="">Select Account Manager</option>
												<?php foreach(employeeListHelper() as $employee_list){ ?>
												<option value="<?= $employee_list->id;?>" <?php echo ($employee_list->id == $account_manager) ? "selected":"";?>><?= $employee_list->full_name;?> - <?= $employee_list->designation_name;?></option>
												<?php } ?>
											</select>
											<p class="hint">Set account manager for your client</p>
										</div>
										
										<div class="col-md-3 col-sm-12 mb-3 form-group">
											<label for="agreement_start">Agreement Start Date<span class="text-danger">*</span></label>
											<input type="date" class="form-control" id="agreement_start" name="agreement_start" max="<?php echo date("Y-m-d"); ?>" value="<?php echo $agreement_start;?>" required />
											<p class="hint">Enter Agreement Start Date for client</p>
										</div>

										<div class="col-md-3 col-sm-12 mb-3 form-group">
											<label for="agrement_expiry">Agreement Expiry<span class="text-danger">*</span></label>
											<input type="date" class="form-control" id="agrement_expiry" name="agrement_expiry" min="<?php echo date("Y-m-d"); ?>" value="<?php echo $agrement_expiry;?>" required />
											<p class="hint">Enter Agreement Expiry Date for client</p>
										</div>

										<div class="col-md-3 col-sm-12 mb-3 form-group">
											<label for="company_name">Full Legal Name (English)<span class="text-danger">*</span></label>
											<input type="text" class="form-control" id="company_name" name="company_name" maxlength="150" value="<?php echo $company_name;?>" required />
											<p class="hint">Enter company name for client</p>
										</div>

										<div class="col-md-3 col-sm-12 mb-3 form-group">
											<label for="company_arabic_name">Full Legal Name (Arabic)<span class="text-danger">*</span></label>
											<input type="text" class="form-control rtl-input" id="company_arabic_name" name="company_arabic_name" maxlength="150" value="<?php echo $company_arabic_name;?>" required />
											<p class="hint">Enter company name for client</p>
										</div>

										<div class="col-md-3 col-sm-12 mb-3 form-group">
											<label for="cr_no">CR Number <span class="text-danger">*</span></label>
											<input type="text" class="form-control" id="cr_no" name="cr_no" minlength="<?= CR_LENGTH; ?>" maxlength="<?= CR_LENGTH; ?>" value="<?php echo $cr_no;?>" required />
											<p class="hint">Enter CR Number for client</p>
										</div>

										<div class="col-md-3 col-sm-12 mb-3 form-group">
											<label for="cr_expiry">CR. Expiry </label>
											<input type="date" class="form-control" id="cr_expiry" name="cr_expiry" min="<?php echo date("Y-m-d"); ?>" value="<?php echo $cr_expiry;?>" />
											<p class="hint">Enter CR Expiry Date for client</p>
										</div>

										<div class="col-md-3 col-sm-12 mb-3 form-group">
											<label for="vat_no">VAT Number <span class="text-danger">*</span></label>
											<input type="text" class="form-control" id="vat_no" name="vat_no" value="<?php echo $vat_no;?>" minlength="<?= VAT_LENGTH; ?>" maxlength="<?= VAT_LENGTH; ?>" required />
											<p class="hint">Enter VAT Number for client</p>
										</div>

										<div class="col-md-3 col-sm-12 mb-3 form-group">
											<label for="vat_expiry">VAT Expiry</label>
											<input type="date" class="form-control" id="vat_expiry" name="vat_expiry" min="<?php echo date("Y-m-d"); ?>" value="<?php echo $vat_expiry;?>" />
											<p class="hint">Enter VAT Expiry Date for client</p>
										</div>
										
										<div class="col-md-3 col-sm-12 mb-3 form-group">
											<label for="business_nature">Nature of Business<span class="text-danger">*</span></label>
											<select name="business_nature" class="form-control select2" required>
												<option value="">Select Nature of Business</option>
												<option value="Trading" <?php echo ($business_nature == 'Trading') ? "selected":"";?>>Trading</option>
												<option value="Manufacturing" <?php echo ($business_nature == 'Manufacturing') ? "selected":"";?>>Manufacturing</option>
												<option value="Service Provider" <?php echo ($business_nature == 'Service Provider') ? "selected":"";?>>Service Provider</option>
												<option value="Contracting" <?php echo ($business_nature == 'Contracting') ? "selected":"";?>>Contracting</option>
											</select>
											<p class="hint">Set nature of business for your client</p>
										</div>

										<div class="col-md-3 col-sm-12 mb-3 form-group">
											<label for="company_type">Type of Company<span class="text-danger">*</span></label>
											<select name="company_type"  class="form-control select2" required>
												<option value="">Select Company Type</option>
												<option value="Establishment" <?php echo ($company_type == 'Establishment') ? "selected":"";?>>Establishment</option>
												<option value="SPC" <?php echo ($company_type == 'SPC') ? "selected":"";?>>SPC</option>
												<option value="Pvt. Ltd. Company" <?php echo ($company_type == 'Pvt. Ltd. Company') ? "selected":"";?>>Pvt. Ltd. Company</option>
												<option value="Partnership Company" <?php echo ($company_type == 'Partnership Company') ? "selected":"";?>>Partnership Company</option>
											</select>
											<p class="hint">Set company type for your client</p>
										</div>
										
										<div class="col-md-3 col-sm-12 mb-3 form-group">
											<label for="mobile">Mobile Number <span class="text-danger">*</span></label>
											<input type="text" class="form-control mobile" id="mobile" name="mobile" onkeypress="return numerics(event);" minlength="<?= MOB_LENGTH; ?>" maxlength="<?= MOB_LENGTH; ?>" value="<?php echo $mobile;?>" required />
											<p class="hint">Format 651 234 5678</p>
										</div>

										<div class="col-md-3 col-sm-12 mb-3 form-group">
											<label for="client_telephone">Telephone Number <span class="text-danger">*</span></label>
											<input type="text" class="form-control mobile" id="client_telephone" name="client_telephone" onkeypress="return numerics(event);" minlength="<?= MOB_LENGTH; ?>" maxlength="<?= MOB_LENGTH; ?>" value="<?php echo $client_telephone;?>" required />
											<p class="hint">Format 651 234 5678</p>
										</div>

										<div class="col-md-3 col-sm-12 mb-3 form-group">
											<label for="client_fax">Fax Number <span class="text-danger">*</span></label>
											<input type="text" class="form-control" id="client_fax" name="client_fax" onkeypress="return numerics(event);" minlength="<?= FAX_LENGTH; ?>" maxlength="<?= FAX_LENGTH; ?>" value="<?php echo $client_fax;?>" required />
											<p class="hint">Format 651 234 5678</p>
										</div>

										<div class="col-md-3 col-sm-12 mb-3 form-group">
											<label for="email">Email <span class="text-danger">*</span></label>
											<input type="email" id="email" name="email" maxlength="<?= EMAIL_LENGTH; ?>" value="<?php echo $email;?>" class="form-control" required >
											<p class="hint">Enter email address for client</p>
										</div>

										<div class="col-md-3 col-sm-12 mb-3 form-group">
											<label for="website">Website </label>
											<input type="text" class="form-control" id="website" name="website" value="<?php echo $other_info['website'];?>" maxlength="120" />
											<p class="hint">Enter company website for client</p>
										</div>

										<div class="col-md-3 col-sm-12 mb-3 form-group">
											<label for="status">Status<span class="text-danger">*</span></label>
											<select name="status"  class="form-control">
												<option value="1" <?php echo ($status == '1') ? "selected":"";?>>Active</option>
												<option value="0" <?php echo ($status == '0') ? "selected":"";?>>Inactive</option>
												<option value="2" <?php echo ($status == '2') ? "selected":"";?>>Block</option>
											</select>
											<p class="hint">Set status for your client</p>
										</div>
									</div>

									<div class="row size-inner-section px-2 py-4">
										<h5 class="scheduler-border">Director's Contact Information:</h5>
										<div class="row">
											<h5 class="scheduler-border" style="font-size: 13px;">First Director Information:</h5>
											<div class="col-md-3 col-sm-12 mb-3 form-group">
												<label for="director_name1">Owner/Director Name 1 :</label>
												<input type="text" class="form-control" id="director_name1" name="director_name1" value="<?php echo $other_info['director_name1'];?>" onKeyPress="return Alpha(event);" maxlength="150" />
											</div>
											<div class="col-md-3 col-sm-12 mb-3 form-group">
												<label for="director_id_no1">ID No Owner/Director 1 :</label>
												<input type="text" class="form-control" id="director_id_no1" name="director_id_no1" value="<?php echo $other_info['director_id_no1'];?>" maxlength="40" />
											</div>
											<div class="col-md-3 col-sm-12 mb-3 form-group">
												<label for="director_mobile1">Mobile Owner/Director 1 :</label>
												<input type="text" class="form-control mobile" id="director_mobile1" name="director_mobile1" value="<?php echo $other_info['director_mobile1'];?>" onkeypress="return numerics(event);" minlength="10" maxlength="10" />
											</div>
											<div class="col-md-3 col-sm-12 mb-3 form-group">
												<label for="director_email1">Email Owner/Director 1 :</label>
												<input type="email" class="form-control" id="director_email1" name="director_email1" value="<?php echo $other_info['director_email1'];?>" maxlength="150" />
											</div>
										</div>
										<div class="row">
											<h5 class="scheduler-border" style="font-size: 13px;">Second Director Information:</h5>
											<div class="col-md-3 col-sm-12 mb-3 form-group">
												<label for="director_name2">Owner/Director Name 2 :</label>
												<input type="text" class="form-control" id="director_name2" name="director_name2" value="<?php echo $other_info['director_name2'];?>" onKeyPress="return Alpha(event);" maxlength="150" />
											</div>
											<div class="col-md-3 col-sm-12 mb-3 form-group">
												<label for="director_id_no2">ID No Owner/Director 2 :</label>
												<input type="text" class="form-control" id="director_id_no2" name="director_id_no2" value="<?php echo $other_info['director_id_no2'];?>" maxlength="40" />
											</div>
											<div class="col-md-3 col-sm-12 mb-3 form-group">
												<label for="director_mobile2">Mobile Owner/Director 2 :</label>
												<input type="text" class="form-control mobile" id="director_mobile2" name="director_mobile2" value="<?php echo $other_info['director_mobile2'];?>" onkeypress="return numerics(event);" minlength="10" maxlength="10" />
											</div>
											<div class="col-md-3 col-sm-12 mb-3 form-group">
												<label for="director_email2">Email Owner/Director 2 :</label>
												<input type="email" class="form-control" id="director_email2" name="director_email2" value="<?php echo $other_info['director_email2'];?>" maxlength="150" />
											</div>
										</div>
									</div>

									<div class="row size-inner-section px-2 py-4">
										<h5 class="scheduler-border">Client Contact Information:</h5>
										
										<div class="row">
											<h5 class="scheduler-border" style="font-size: 13px;">Operations Department:</h5>
											<div class="col-md-3 col-sm-12 mb-3 form-group">
												<label for="sales_name">Operations Manager Name :</label>
												<input type="text" class="form-control" id="sales_name" name="sales_name" value="<?php echo $other_info['sales_name'];?>" onKeyPress="return Alpha(event);" maxlength="150" />
											</div>
											<div class="col-md-3 col-sm-12 mb-3 form-group">
												<label for="sales_id_no">ID No Operations Manager :</label>
												<input type="text" class="form-control" id="sales_id_no" name="sales_id_no" value="<?php echo $other_info['sales_id_no'];?>" maxlength="40" />
											</div>
											<div class="col-md-3 col-sm-12 mb-3 form-group">
												<label for="sales_mobile">Mobile Operations Manager :</label>
												<input type="text" class="form-control mobile" id="sales_mobile" name="sales_mobile" value="<?php echo $other_info['sales_mobile'];?>" onkeypress="return numerics(event);" minlength="10" maxlength="10" />
											</div>
											<div class="col-md-3 col-sm-12 mb-3 form-group">
												<label for="sales_email">Email Operations Manager :</label>
												<input type="email" class="form-control" id="sales_email" name="sales_email" value="<?php echo $other_info['sales_email'];?>" maxlength="150" />
											</div>
										</div>
										<div class="row">
											<h5 class="scheduler-border" style="font-size: 13px;">Finance Department:</h5>
											<div class="col-md-3 col-sm-12 mb-3 form-group">
												<label for="finance_name">Finance Manager Name :</label>
												<input type="text" class="form-control" id="finance_name" name="finance_name" onKeyPress="return Alpha(event);" value="<?php echo $other_info['finance_name'];?>" maxlength="150" />
											</div>
											<div class="col-md-3 col-sm-12 mb-3 form-group">
												<label for="finance_id_no">ID No Finance Manager :</label>
												<input type="text" class="form-control" id="finance_id_no" name="finance_id_no" value="<?php echo $other_info['finance_id_no'];?>" maxlength="40" />
											</div>
											<div class="col-md-3 col-sm-12 mb-3 form-group">
												<label for="finance_mobile">Mobile Finance Manager :</label>
												<input type="text" class="form-control mobile" id="finance_mobile" name="finance_mobile" onkeypress="return numerics(event);" value="<?php echo $other_info['finance_mobile'];?>" minlength="10" maxlength="10" />
											</div>
											<div class="col-md-3 col-sm-12 mb-3 form-group">
												<label for="finance_email">Email Finance Manager :</label>
												<input type="email" class="form-control" id="finance_email" name="finance_email" value="<?php echo $other_info['finance_email'];?>" maxlength="150" />
											</div>
										</div>
									</div>
									<div class="row size-inner-section px-2 py-4">
										<h5 class="scheduler-border">Client National Address:</h5>
										<div class="col-md-3 col-sm-12 mb-3 form-group">
											<label for="building_no">Building Number </label>
											<input type="text" class="form-control" id="building_no" name="building_no" value="<?php echo $other_info['building_no'];?>" />
										</div>
										<div class="col-md-3 col-sm-12 mb-3 form-group">
											<label for="street_name">Street Name </label>
											<input type="text" class="form-control" id="street_name" name="street_name" value="<?php echo $other_info['street_name'];?>" />
										</div>
										<div class="col-md-3 col-sm-12 mb-3 form-group">
											<label for="district">District Name </label>
											<input type="text" class="form-control" id="district" name="district" onKeyPress="return Alpha(event);" value="<?php echo $other_info['district'];?>" maxlength="150" />
										</div>

										<div class="col-md-3 mb-3 form-group">
											<label for="region_id">Region <span class="text-danger">*</span></label>
											<select id="region_id" name="region_id" class="form-control col-md-12 select2" required>
												<option value="">Select Region</option>
												<?php foreach(getRegions() as $master_region){?>
												<option value="<?php echo $master_region->id;?>" data-id="<?php echo $master_region->id;?>" <?php echo ($other_info['region_id'] == $master_region->id) ? "selected":"";?>><?php echo $master_region->region_name;?></option>
												<?php } ?>
											</select>
										</div>

										<div class="col-md-3 mb-3 form-group">
											<label for="city">City Name <span class="text-danger">*</span></label>
											<select id="city" name="city" class="form-control col-md-12 select2" required>
												<?php if($other_info['region_id'] > 0) { 
												foreach(selectedCitiesHelp($other_info['region_id']) as $master_city){?>
												<option value="<?php echo $master_city->id;?>" data-id="<?php echo $master_city->id;?>" <?php echo ($other_info['city'] == $master_city->id) ? "selected":"";?>><?php echo $master_city->city_name;?></option>
												<?php }}else{ ?>
												<option value="">Select Region First</option>
												<?php } ?>
											</select>
										</div>

										<div class="col-md-3 col-sm-12 mb-3 form-group">
											<label for="country">Country <span class="text-danger">*</span></label>
											<select id="country" name="country" class="form-control col-md-12 select2" required>
												<option value="">Selct Country</option>
												<option value="Saudi Arabia" <?php echo ($other_info['country'] == 'Saudi Arabia') ? "selected":"";?>>Saudi Arabia</option>
											</select>
										</div>
										<div class="col-md-3 col-sm-12 mb-3 form-group">
											<label for="postal_code">Zip Code </label>
											<input type="text" class="form-control" id="postal_code" name="postal_code" value="<?php echo $other_info['postal_code'];?>" onkeypress="return numerics(event);" minlength="<?= ZIP_LENGTH; ?>" maxlength="<?= ZIP_LENGTH; ?>" />
										</div>
										<div class="col-md-3 col-sm-12 mb-3 form-group">
											<label for="additional_no">Additional Number </label>
											<input type="text" class="form-control" id="additional_no" name="additional_no" value="<?php echo $other_info['additional_no'];?>" maxlength="15" />
										</div>
										<div class="col-md-3 col-sm-12 mb-3 form-group">
											<label for="unit_no">Unit Number </label>
											<input type="text" class="form-control" id="unit_no" name="unit_no" value="<?php echo $other_info['unit_no'];?>" maxlength="15" />
										</div>
										<div class="col-md-3 col-sm-12 mb-3 form-group">
											<label for="short_address">Short Address </label>
											<input type="text" class="form-control" id="short_address" name="short_address" value="<?php echo $other_info['short_address'];?>" maxlength="255" />
										</div>

										<div class="col-md-12 col-sm-12 mb-3 form-group">
											<button class="btn btn-success btn-md float-end" type="submit">Update</button>
										</div>
									</div>
									<?= form_close();?>
									
								</div>


								<div class="tab-pane" id="bankTab" role="tabpanel">
									<?php if($partner_basic_status > 0){ ?>
									<?php echo form_open("admin/logistic-partner/save-bank", array("id"=>"bank-form", "enctype"=>"multipart/form-data", "class"=>"form-label-left", "data-parsley-validate"=> "")); ?>
										<input type="hidden" id="partner_id" name="partner_id" value="<?php echo $id;?>" required>
										<div class="row size-inner-section p-2">
											<?php if($partner_bank_status == '0'){?>
											<div class="alert alert-info" role="alert">Incomplete bank information.</div>
											<?php } ?>
											<h4 class="header-title">Fill your required bank information</h4>

											<div class="col-md-4 mb-3 form-group">
												<label for="account_holder_name">Account Holder Name </label>
												<input type="text" class="form-control" id="account_holder_name" name="account_holder_name" maxlength="150" value="<?php echo $bank_info->account_holder_name;?>" />
											</div>
											<div class="col-md-4 mb-3 form-group">
												<label for="bank_account_no">Bank Account No </label>
												<input type="text" class="form-control" id="bank_account_no" name="bank_account_no" onkeypress="return numerics(event);" maxlength="<?= BANK_ACCOUNT; ?>" value="<?php echo $bank_info->bank_account_no;?>" />
											</div>
											<div class="col-md-4 mb-3 form-group">
												<label for="iban_number">IBAN Number </label>
												<input type="text" class="form-control" id="iban_number" name="iban_number" minlength="<?= IBAN_LENGTH; ?>" maxlength="<?= IBAN_LENGTH; ?>" value="<?php echo $bank_info->iban_number;?>" />
											</div>

											<div class="col-md-4 col-sm-12 mb-3 form-group">
												<label for="bank_name">Bank Name <span class="text-danger text-danger">*</span></label>
												<select style="height:410px;" name="bank_name" id="bank_name" class="form-control select2" required>
													<option value="">Select Bank</option>
													<?php foreach(bankList() as $banks){?>
													<option value="<?php echo $banks->id;?>" <?php echo ($bank_info->bank_name == $banks->id) ? "selected":"";?>><?php echo $banks->bank_name;?></option>
													<?php } ?>
												</select>
												<small class="hint">Enter bank name belong to Rider</small>
											</div>
											
											<div class="col-md-4 mb-3 form-group">
												<label for="branch_name">Branch Name </label>
												<input type="text" class="form-control" id="branch_name" name="branch_name" onKeyPress="return Alpha(event);" maxlength="250" value="<?php echo $bank_info->branch_name;?>" />
											</div>
											
											<div class="col-md-4 mb-3 form-group">
												<label for="account_currency">Account Currency </label>
												<select id="account_currency" name="account_currency" class="form-control col-md-12 select2">
													<option value="">Select Currency</option>
													<option value="SAR" <?php echo ($bank_info->account_currency == 'SAR') ? "selected":"";?>>SAR</option>
													<option value="INR" <?php echo ($bank_info->account_currency == 'INR') ? "selected":"";?>>INR</option>
													<option value="USD" <?php echo ($bank_info->account_currency == 'USD') ? "selected":"";?>>USD</option>
													<option value="EUR" <?php echo ($bank_info->account_currency == 'EUR') ? "selected":"";?>>EUR</option>
												</select>
											</div>
											<div class="col-md-4 mb-3 form-group">
												<label for="swift_code">Swift / Sarie Code </label>
												<input type="text" class="form-control" id="swift_code" name="swift_code" maxlength="50" value="<?php echo $bank_info->swift_code;?>" />
											</div>

											<div class="col-md-4 mb-3 form-group">
												<label for="region">Region <span class="required">*</span></label>
												<select id="region" name="region" class="form-control col-md-12 select2">
													<option value="">Select Region</option>
													<?php foreach(getRegions() as $master_region){?>
													<option value="<?php echo $master_region->id;?>" data-id="<?php echo $master_region->id;?>" <?php echo ($bank_info->region == $master_region->id) ? "selected":"";?>><?php echo $master_region->region_name;?></option>
													<?php } ?>
												</select>
											</div>
											
											<div class="col-md-4 mb-3 form-group">
												<label for="bank_city">City Name <span class="text-danger">*</span></label>
												<select id="bank_city" name="bank_city" class="form-control col-md-12 select2" required>
													<?php if($bank_info->region > 0) { foreach(selectedCitiesHelp($bank_info->region) as $master_city){?>
													<option value="<?php echo $master_city->id;?>" data-id="<?php echo $master_city->id;?>" <?php echo ($bank_info->bank_city == $master_city->id) ? "selected":"";?>><?php echo $master_city->city_name;?></option>
													<?php }}else{ ?>
													<option value="">Select Region First</option>
													<?php } ?>
												</select>
											</div>

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

								<div class="tab-pane" id="documentsTab" role="tabpanel">
									<?php if($partner_basic_status > 0 && $partner_bank_status > 0){ ?>
										<div class="row size-inner-section p-2">
											<?php if($partner_docs_status == '0'){?>
											<div class="alert alert-info" role="alert">Incomplete documents.</div>
											<?php } ?>
											<h4 class="header-title mb-3">Upload required documents:</h4>
											<div class="col-md-3 col-sm-12 mb-3 form-group">
												<div class="upload-div">
													<label class="font-size-11" style="margin-bottom: 27px;">CR Certificate (Picture must be clear)<span class="text-danger">*</span></label>
													<div class="prfile-preview"><img id="fileInputphoto" src="<?= (!empty($documents->cr_certificate)) ? base_url($documents->cr_certificate) : base_url('images/no-image-icon.png');?>" /></div>
													<!-- File upload form -->
													<form id="uploadForm" enctype="multipart/form-data" method="POST">
														<input type="hidden" id="id" name="id" value="<?php echo $id;?>" required>
														<input type="hidden" name="o_cr_certificate" value="<?php echo (!empty($documents->cr_certificate)) ? $documents->cr_certificate : '';?>">
														<input type="file" name="cr_certificate" id="fileInput" onchange="document.getElementById('fileInputphoto').src = window.URL.createObjectURL(this.files[0])" required>
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
													<label class="font-size-11" style="margin-bottom: 27px;">VAT Certificate (Picture must be clear)<span class="text-danger">*</span></label>
													<div class="prfile-preview"><img id="fileInput1photo" src="<?= (!empty($documents->vat_certificate)) ? base_url($documents->vat_certificate) : base_url('images/no-image-icon.png');?>" /></div>
													<form id="uploadForm1" enctype="multipart/form-data" method="POST">
														<input type="hidden" id="id" name="id" value="<?php echo $id;?>" required>
														<input type="hidden" name="o_vat_certificate" value="<?php echo (!empty($documents->vat_certificate)) ? $documents->vat_certificate : '';?>">
														<input type="file" name="vat_certificate" id="fileInput1" onchange="document.getElementById('fileInput1photo').src = window.URL.createObjectURL(this.files[0])" required>
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
													<label class="font-size-11" style="margin-bottom: 27px;">IBAN Certificate (Account name and bank name must be clear)<span class="text-danger">*</span></label>
													<div class="prfile-preview"><img id="fileInput2photo" src="<?= (!empty($documents->iban_certificate)) ? base_url($documents->iban_certificate) : base_url('images/no-image-icon.png');?>" /></div>
													<form id="uploadForm2" enctype="multipart/form-data" method="POST">
														<input type="hidden" id="id" name="id" value="<?php echo $id;?>" required>
														<input type="hidden" name="o_iban_certificate" value="<?php echo (!empty($documents->iban_certificate)) ? $documents->iban_certificate : '';?>">
														<input type="file" name="iban_certificate" id="fileInput2" onchange="document.getElementById('fileInput2photo').src = window.URL.createObjectURL(this.files[0])" required>
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
													<label class="font-size-11" style="margin-bottom: 27px;">Owner ID (Picture must be clear)<span class="text-danger">*</span></label>
													<div class="prfile-preview"><img id="fileInput3photo" src="<?= (!empty($documents->owner_id)) ? base_url($documents->owner_id) : base_url('images/no-image-icon.png');?>" /></div>
													<form id="uploadForm3" enctype="multipart/form-data" method="POST">
														<input type="hidden" id="id" name="id" value="<?php echo $id;?>" required>
														<input type="hidden" name="o_owner_id" value="<?php echo (!empty($documents->owner_id)) ? $documents->owner_id : '';?>">
														<input type="file" name="owner_id" id="fileInput3" onchange="document.getElementById('fileInput3photo').src = window.URL.createObjectURL(this.files[0])" required>
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
													<label class="font-size-11">Credit Agreement (Picture must be clear)<span class="text-danger">*</span></label>
													<div class="prfile-preview"><img id="fileInput4photo" src="<?= (!empty($documents->credit_agreement)) ? base_url($documents->credit_agreement) : base_url('images/no-image-icon.png');?>" /></div>
													<form id="uploadForm4" enctype="multipart/form-data" method="POST">
														<input type="hidden" id="id" name="id" value="<?php echo $id;?>" required>
														<input type="hidden" name="o_credit_agreement" value="<?php echo (!empty($documents->credit_agreement)) ? $documents->credit_agreement : '';?>">
														<input type="file" name="credit_agreement" id="fileInput4" onchange="document.getElementById('fileInput4photo').src = window.URL.createObjectURL(this.files[0])" required>
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
													<label class="mb-2 font-size-11">Authorize Person ID (Picture must be clear)<span class="text-danger">*</span></label>
													<div class="prfile-preview"><img id="fileInput5photo" src="<?= (!empty($documents->authorization_copy)) ? base_url($documents->authorization_copy) : base_url('images/no-image-icon.png');?>" /></div>
													<form id="uploadForm5" enctype="multipart/form-data" method="POST">
														<input type="hidden" id="id" name="id" value="<?php echo $id;?>" required>
														<input type="hidden" name="o_authorization_copy" value="<?php echo (!empty($documents->authorization_copy)) ? $documents->authorization_copy : '';?>">
														<input type="file" name="authorization_copy" id="fileInput5" onchange="document.getElementById('fileInput5photo').src = window.URL.createObjectURL(this.files[0])" required>
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

											<div class="col-md-3 col-sm-12 mb-3 form-group">
												<div class="upload-div">
													<!-- File upload form -->
													<label class="mb-2 font-size-11">Authorize Person ID (Picture must be clear)<span class="text-danger">*</span></label>
													<div class="prfile-preview"><img id="fileInput6photo" src="<?= (!empty($documents->authorize_person_id)) ? base_url($documents->authorize_person_id) : base_url('images/no-image-icon.png');?>" /></div>
													<form id="uploadForm6" enctype="multipart/form-data" method="POST">
														<input type="hidden" id="id" name="id" value="<?php echo $id;?>" required>
														<input type="hidden" name="o_authorize_person_id" value="<?php echo (!empty($documents->authorize_person_id)) ? $documents->authorize_person_id : '';?>">
														<input type="file" name="authorize_person_id" id="fileInput6" onchange="document.getElementById('fileInput6photo').src = window.URL.createObjectURL(this.files[0])" required>
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
										</div>
										
										<?php }else{ ?>
											<div class="alert alert-danger show" role="alert">
												<strong>Alert!</strong>  Fill all information first to access this tab.
											</div>
										<?php } ?>
									</div>
									<div class="tab-pane" id="commissionTab" role="tabpanel">
										<?php if($partner_basic_status > 0){ ?>
											<div class="row size-inner-section px-2 py-4">
												<h4 class="header-title mb-3">Riders Commission Structure:</h4>
												<?php echo form_open("admin/logistic-partner/save-commission", array("id"=>"commission-form", "class"=>"form-label-left", "data-parsley-validate"=> "")); ?>
												<input type="hidden" id="partner_id" name="partner_id" value="<?php echo $id;?>" required>
												<table id="commission_sections" class="table table-striped table-bordered table-hover" style="max-width: 500px;">
													<thead>
														<tr>
															<td class="text-left">Range (Min) <span class="required-field">*</span></td>
															<td class="text-left">Range (Max) <span class="required-field">*</span></td>
															<td class="text-left">Amount <span class="required-field">*</span></td>
														</tr>
													</thead>
													<tbody>
														<?php if(count($commissions) > 0){ ?>
														<tr class="family-inner-section">
															<td class="text-left" style="width: 15%;">
																<input type="number" name="min_range[]" class="form-control" value="<?php echo $commissions[0]['min_range'];?>" min="1" maxlength="1000" required readonly>
															</td>
															<td class="text-left" style="width: 15%;">
																<div class="input-group">
																	<input type="number" name="max_range[]" class="form-control" value="<?php echo $commissions[0]['max_range'];?>" min="1" maxlength="1000" required readonly>
																</div>
															</td>
															<td class="text-left" style="width: 15%;">
																<div class="input-group">
																	<input name="comm_amount[]" class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" value="<?php echo $commissions[0]['comm_amount'];?>" required>
																</div>
															</td>
														</tr>
														<tr class="family-inner-section">
															<td class="text-left" style="width: 15%;">
																<input type="number" name="min_range[]" class="form-control" value="<?php echo $commissions[1]['min_range'];?>" min="1" maxlength="1000" required readonly>
															</td>
															<td class="text-left" style="width: 15%;">
																<div class="input-group">
																	<input type="number" name="max_range[]" class="form-control" value="<?php echo $commissions[1]['max_range'];?>" min="1" maxlength="1000" required readonly>
																</div>
															</td>
															<td class="text-left" style="width: 15%;">
																<div class="input-group">
																	<input name="comm_amount[]" class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" value="<?php echo $commissions[1]['comm_amount'];?>" required>
																</div>
															</td>
														</tr>
														<tr class="family-inner-section">
															<td class="text-left" style="width: 15%;">
																<input type="number" name="min_range[]" class="form-control" value="<?php echo $commissions[2]['min_range'];?>" min="1" maxlength="1000" required readonly>
															</td>
															<td class="text-left" style="width: 15%;">
																<div class="input-group">
																	<input type="number" name="max_range[]" class="form-control" value="<?php echo $commissions[2]['max_range'];?>" min="1" maxlength="1000" required readonly>
																</div>
															</td>
															<td class="text-left" style="width: 15%;">
																<div class="input-group">
																	<input name="comm_amount[]" class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" value="<?php echo $commissions[2]['comm_amount'];?>" required>
																</div>
															</td>
														</tr>
														<tr class="family-inner-section">
															<td class="text-left" style="width: 15%;">
																<input type="number" name="min_range[]" class="form-control" value="<?php echo $commissions[3]['min_range'];?>" min="1" maxlength="1000" required readonly>
															</td>
															<td class="text-left" style="width: 15%;">
																<div class="input-group">
																	<input type="number" name="max_range[]" class="form-control" value="<?php echo $commissions[3]['max_range'];?>" min="1" maxlength="1000" required readonly>
																</div>
															</td>
															<td class="text-left" style="width: 15%;">
																<div class="input-group">
																	<input name="comm_amount[]" class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" value="<?php echo $commissions[3]['comm_amount'];?>" required>
																</div>
															</td>
														</tr>
														<?php }else{ ?>
														<tr class="family-inner-section">
															<td class="text-left" style="width: 15%;">
																<input type="number" name="min_range[]" class="form-control" value="1" min="1" maxlength="1000" required readonly>
															</td>
															<td class="text-left" style="width: 15%;">
																<div class="input-group">
																	<input type="number" name="max_range[]" class="form-control" value="150" min="1" maxlength="1000" required readonly>
																</div>
															</td>
															<td class="text-left" style="width: 15%;">
																<div class="input-group">
																	<input name="comm_amount[]" class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" required>
																</div>
															</td>
														</tr>
														<tr class="family-inner-section">
															<td class="text-left" style="width: 15%;">
																<input type="number" name="min_range[]" class="form-control" value="151" min="1" maxlength="1000" required readonly>
															</td>
															<td class="text-left" style="width: 15%;">
																<div class="input-group">
																	<input type="number" name="max_range[]" class="form-control" value="300" min="1" maxlength="1000" required readonly>
																</div>
															</td>
															<td class="text-left" style="width: 15%;">
																<div class="input-group">
																	<input name="comm_amount[]" class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" required>
																</div>
															</td>
														</tr>
														<tr class="family-inner-section">
															<td class="text-left" style="width: 15%;">
																<input type="number" name="min_range[]" class="form-control" value="301" min="1" maxlength="1000" required readonly>
															</td>
															<td class="text-left" style="width: 15%;">
																<div class="input-group">
																	<input type="number" name="max_range[]" class="form-control" value="400" min="1" maxlength="1000" required readonly>
																</div>
															</td>
															<td class="text-left" style="width: 15%;">
																<div class="input-group">
																	<input name="comm_amount[]" class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" required>
																</div>
															</td>
														</tr>
														<tr class="family-inner-section">
															<td class="text-left" style="width: 15%;">
																<input type="number" name="min_range[]" class="form-control" value="401" min="1" maxlength="1000" required readonly>
															</td>
															<td class="text-left" style="width: 15%;">
																<div class="input-group">
																	<input type="number" name="max_range[]" class="form-control" value="1000" min="0" maxlength="1000" required readonly>
																</div>
															</td>
															<td class="text-left" style="width: 15%;">
																<div class="input-group">
																	<input name="comm_amount[]" class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" required>
																</div>
															</td>
														</tr>
														<?php } ?>
													</tbody>
												</table>
												<div class="col-md-12 col-sm-12 mb-3 form-group" style="max-width: 500px;">
													<button class="btn btn-success btn-md float-end">Update</button>
												</div>
												<?php echo form_close(); ?>
											</div>
										<?php }else{ ?>
											<div class="alert alert-danger show" role="alert">
												<strong>Alert!</strong>  Fill basic information first to access this tab.
											</div>
										<?php } ?>
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

<?php $this->load->view('admin/home/footer');?>
<script>
	/*
	$(function(){
		var dtToday = new Date();
		
		var month = dtToday.getMonth() + 1;
		var day = dtToday.getDate();
		var year = dtToday.getFullYear();
	   
		$('#date').attr('min', maxDate);
		$('#iqama_exp').attr('min', maxDate);
	});
	*/
	var base_url = '<?= base_url();?>';

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
	
	function Alpha(evt)
    {
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
		}
		else return true;
	}

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
	
	$('#region_id').change(function() {
		var region_id = $(this).find('option:selected').data('id');
		$.ajax({
			url: "<?php echo base_url(); ?>admin/helper/get_region_cities",
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

	$('#region').change(function() {
		var bank_sel_region = $(this).find('option:selected').data('id');
		$.ajax({
			url: "<?php echo base_url(); ?>admin/helper/get_region_cities",
			data: {
				region_id: bank_sel_region
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
				$('#bank_city').html(html);
			}
		});
	});

	function verifyAction(e) {
		if (confirm("Do you sure want to verify this partner?") == true) {
			var uID = (e.getAttribute("data-id"));
			if(uID > 0){
				$.ajax({
					url: '<?php echo base_url();?>admin/logistic_partner/verify',
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
				alert('Invalid Partner ID');
			}
		} else {
			userPreference = "Action Cancelled!";
		}
	}

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
			url: base_url+"admin/logistic_partner/upload_cr_certificate",
			data: new FormData(this),
			contentType: false,
			cache: false,
			processData:false,
			beforeSend: function(){
				console.log('send');
				$(".progress-bar").width('0%');
				$('#uploadStatus').html('<i class="fa fa-spinner spin" aria-hidden="true"></i>');
			},
			success: function(resp){
				if(resp == 'ok'){
					console.log('success');
					$('#uploadForm')[0].reset();
					$('#uploadForm').remove();
					$('#uploadStatus').html('<p style="color:#28A74B;font-size: 13px;">File has been uploaded successfully!</p>');
				}else if(resp == 'err'){
					console.log('fail');
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

	/*----- Upload VAT ----*/
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
			url: base_url+"admin/logistic_partner/upload_vat_certificate",
			data: new FormData(this),
			contentType: false,
			cache: false,
			processData:false,
			beforeSend: function(){
				console.log('send');
				$(".progress-bar-1").width('0%');
				$('#uploadStatus1').html('<i class="fa fa-spinner spin" aria-hidden="true"></i>');
			},
			success: function(resp){
				if(resp == 'ok'){
					console.log('success');
					$('#uploadForm1')[0].reset();
					$('#uploadForm1').remove();
					$('#uploadStatus1').html('<p style="color:#28A74B;font-size: 13px;">File has been uploaded successfully!</p>');
				}else if(resp == 'err'){
					console.log('fail');
					$('#uploadStatus1').html('<p style="color:#EA4335;font-size: 14px;">Please select a valid file to upload.</p>');
				}
			},
			error:function(resp){
				console.log(resp);
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

	/*----- Upload IBAN ----*/
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
			url: base_url+"admin/logistic_partner/upload_iban_certificate",
			data: new FormData(this),
			contentType: false,
			cache: false,
			processData:false,
			beforeSend: function(){
				console.log('send');
				$(".progress-bar-2").width('0%');
				$('#uploadStatus2').html('<i class="fa fa-spinner spin" aria-hidden="true"></i>');
			},
			success: function(resp){
				if(resp == 'ok'){
					console.log('success');
					$('#uploadForm2')[0].reset();
					$('#uploadForm2').remove();
					$('#uploadStatus2').html('<p style="color:#28A74B;font-size: 13px;">File has been uploaded successfully!</p>');
				}else if(resp == 'err'){
					console.log('fail');
					$('#uploadStatus2').html('<p style="color:#EA4335;font-size: 14px;">Please select a valid file to upload.</p>');
				}
			},
			error:function(resp){
				console.log(resp);
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

	/*----- Upload Owner ID ----*/
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
			url: base_url+"admin/logistic_partner/upload_owner_id",
			data: new FormData(this),
			contentType: false,
			cache: false,
			processData:false,
			beforeSend: function(){
				console.log('send');
				$(".progress-bar-3").width('0%');
				$('#uploadStatus3').html('<i class="fa fa-spinner spin" aria-hidden="true"></i>');
			},
			success: function(resp){
				if(resp == 'ok'){
					console.log('success');
					$('#uploadForm3')[0].reset();
					$('#uploadForm3').remove();
					$('#uploadStatus3').html('<p style="color:#28A74B;font-size: 13px;">File has been uploaded successfully!</p>');
				}else if(resp == 'err'){
					console.log('fail');
					$('#uploadStatus3').html('<p style="color:#EA4335;font-size: 14px;">Please select a valid file to upload.</p>');
				}
			},
			error:function(resp){
				console.log(resp);
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

	/*----- Upload Credir Agreement ----*/
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
			url: base_url+"admin/logistic_partner/upload_credit_agreement",
			data: new FormData(this),
			contentType: false,
			cache: false,
			processData:false,
			beforeSend: function(){
				console.log('send');
				$(".progress-bar-4").width('0%');
				$('#uploadStatus4').html('<i class="fa fa-spinner spin" aria-hidden="true"></i>');
			},
			success: function(resp){
				if(resp == 'ok'){
					console.log('success');
					$('#uploadForm4')[0].reset();
					$('#uploadForm4').remove();
					$('#uploadStatus4').html('<p style="color:#28A74B;font-size: 13px;">File has been uploaded successfully!</p>');
				}else if(resp == 'err'){
					console.log('fail');
					$('#uploadStatus4').html('<p style="color:#EA4335;font-size: 14px;">Please select a valid file to upload.</p>');
				}
			},
			error:function(resp){
				console.log(resp);
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

	/*----- Upload Authorization ----*/
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
			url: base_url+"admin/logistic_partner/upload_authorization_copy",
			data: new FormData(this),
			contentType: false,
			cache: false,
			processData:false,
			beforeSend: function(){
				console.log('send');
				$(".progress-bar-5").width('0%');
				$('#uploadStatus5').html('<i class="fa fa-spinner spin" aria-hidden="true"></i>');
			},
			success: function(resp){
				if(resp == 'ok'){
					console.log('success');
					$('#uploadForm5')[0].reset();
					$('#uploadForm5').remove();
					$('#uploadStatus5').html('<p style="color:#28A74B;font-size: 13px;">File has been uploaded successfully!</p>');
				}else if(resp == 'err'){
					console.log('fail');
					$('#uploadStatus5').html('<p style="color:#EA4335;font-size: 14px;">Please select a valid file to upload.</p>');
				}
			},
			error:function(resp){
				console.log(resp);
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

	/*----- Upload Authorize Person ID ----*/
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
			url: base_url+"admin/logistic_partner/upload_authorize_person_id",
			data: new FormData(this),
			contentType: false,
			cache: false,
			processData:false,
			beforeSend: function(){
				console.log('send');
				$(".progress-bar-6").width('0%');
				$('#uploadStatus6').html('<i class="fa fa-spinner spin" aria-hidden="true"></i>');
			},
			success: function(resp){
				if(resp == 'ok'){
					console.log('success');
					$('#uploadForm6')[0].reset();
					$('#uploadForm6').remove();
					$('#uploadStatus6').html('<p style="color:#28A74B;font-size: 13px;">File has been uploaded successfully!</p>');
				}else if(resp == 'err'){
					console.log('fail');
					$('#uploadStatus6').html('<p style="color:#EA4335;font-size: 14px;">Please select a valid file to upload.</p>');
				}
			},
			error:function(resp){
				console.log(resp);
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
</script>
