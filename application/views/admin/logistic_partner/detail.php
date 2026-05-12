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
						<li class="breadcrumb-item active">Detail</li>
					</ol>
				</div>
			</div>
			<?php  $admin_id= $this->session->userdata('admin_id'); ?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<?php if($this->customer->userd($admin_id)->role=="Admin" ){?>
					<a class="btn btn-sm btn-custom-white pull-right" title="Back" href="<?php echo base_url('admin/logistic-partner/list');?>"><i class="fa fa-reply"></i> Back</a>
					<?php } ?>
					<a class="btn btn-sm btn-custom-danger pull-right ms-2" title="Send Credentials" href="<?php echo base_url('admin/logistic-partner/send-welcome-mail?id='.$id); ?>"><i class="dripicons-export"></i> Send Credential</a>
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
										<span class="d-none d-sm-block">Profile</span>
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
									<a class="nav-link" data-bs-toggle="tab" href="#riderTab" role="tab">
										<span class="d-block d-sm-none"><i class="mdi mdi-bike"></i></span>
										<span class="d-none d-sm-block">Rider List</span>
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
											<div class="input-group bootstrap-touchspin bootstrap-touchspin-injected">
												<input type="text" class="form-control" id="cr_no" name="cr_no" minlength="<?= CR_LENGTH; ?>" maxlength="<?= CR_LENGTH; ?>" value="<?php echo $cr_no;?>" required />
												<span class="input-group-btn input-group-append">
													<button class="btn btn-warning bootstrap-touchspin-up copy-cr" type="button"><i class="fa fa-copy"></i></button>
												</span>
											</div>
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

										<div class="col-md-4 col-sm-12 mb-3 form-group">
											<label for="encyp_pass">Password <span class="text-danger">*</span></label>
											<div class="input-group bootstrap-touchspin bootstrap-touchspin-injected">
												<input type="text" id="encyp_pass" value="**************" class="form-control">
												<span class="input-group-btn input-group-append">
													<button class="btn btn-warning bootstrap-touchspin-up password-show" type="button" data-id="<?= $id; ?>"><i class="fa fa-eye"></i></button>
													<button class="btn btn-warning bootstrap-touchspin-up d-none taptocopy" type="button"><i class="fa fa-copy"></i></button>
												</span>
											</div>
											<small class="hint">Want to change password <button class="btn btn-link text-danger btn-sm" data-bs-toggle="modal" data-bs-target=".change-password-modal">Click Here</button></small>
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
												<?php if($other_info['region_id'] > 0) { foreach(selectedCitiesHelp($other_info['region_id']) as $master_city){?>
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
									</div>
									
								</div>

								<div class="tab-pane" id="bankTab" role="tabpanel">
									<?php if($partner_basic_status > 0){ ?>
										<div class="row size-inner-section p-2">
											<?php if($partner_bank_status == '0'){?>
											<div class="alert alert-info" role="alert">Incomplete bank information.</div>
											<?php } ?>

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
												<label for="bank_name">Bank Name <span class="required-field text-danger">*</span></label>
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

										</div>
									<?php }else{ ?>
										<div class="alert alert-danger show" role="alert">
											<strong>Alert!</strong>  Fill vehicle information first to access this tab.
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
												<label class="font-size-11 custom-label">CR Certificate (Picture must be clear)<span class="text-danger">*</span></label>
												<div class="prfile-preview"><img id="fileInputphoto" src="<?= (!empty($documents->cr_certificate)) ? base_url($documents->cr_certificate) : base_url('images/no-image-icon.png');?>" /></div>
												
											</div>
										</div>

										<div class="col-md-3 col-sm-12 mb-3 form-group">
											<div class="upload-div">
												<!-- File upload form -->
												<label class="font-size-11 custom-label">VAT Certificate (Picture must be clear)<span class="text-danger">*</span></label>
												<div class="prfile-preview"><img id="fileInput1photo" src="<?= (!empty($documents->vat_certificate)) ? base_url($documents->vat_certificate) : base_url('images/no-image-icon.png');?>" /></div>
												
											</div>
										</div>

										<div class="col-md-3 col-sm-12 mb-3 form-group">
											<div class="upload-div">
												<!-- File upload form -->
												<label class="font-size-11 custom-label">IBAN Certificate (Account name and bank name must be clear)<span class="text-danger">*</span></label>
												<div class="prfile-preview"><img id="fileInput2photo" src="<?= (!empty($documents->iban_certificate)) ? base_url($documents->iban_certificate) : base_url('images/no-image-icon.png');?>" /></div>
												
											</div>
										</div>

										<div class="col-md-3 col-sm-12 mb-3 form-group">
											<div class="upload-div">
												<!-- File upload form -->
												<label class="font-size-11 custom-label">Owner ID (Picture must be clear)<span class="text-danger">*</span></label>
												<div class="prfile-preview"><img id="fileInput3photo" src="<?= (!empty($documents->owner_id)) ? base_url($documents->owner_id) : base_url('images/no-image-icon.png');?>" /></div>
												
											</div>
											
										</div>

										<div class="col-md-3 col-sm-12 mb-3 form-group">
											<div class="upload-div">
												<!-- File upload form -->
												<label class="font-size-11 custom-label">Credit Agreement (Picture must be clear)<span class="text-danger">*</span></label>
												<div class="prfile-preview"><img id="fileInput4photo" src="<?= (!empty($documents->credit_agreement)) ? base_url($documents->credit_agreement) : base_url('images/no-image-icon.png');?>" /></div>
												
											</div>
										</div>
										
										<div class="col-md-3 col-sm-12 mb-3 form-group">
											<div class="upload-div">
												<!-- File upload form -->
												<label class="mb-2 font-size-11 custom-label">Authorize Person ID (Picture must be clear)<span class="text-danger">*</span></label>
												<div class="prfile-preview"><img id="fileInput5photo" src="<?= (!empty($documents->authorization_copy)) ? base_url($documents->authorization_copy) : base_url('images/no-image-icon.png');?>" /></div>
												
											</div>
										</div>

										<div class="col-md-3 col-sm-12 mb-3 form-group">
											<div class="upload-div">
												<!-- File upload form -->
												<label class="mb-2 font-size-11 custom-label">Authorize Person ID (Picture must be clear)<span class="text-danger">*</span></label>
												<div class="prfile-preview"><img id="fileInput6photo" src="<?= (!empty($documents->authorize_person_id)) ? base_url($documents->authorize_person_id) : base_url('images/no-image-icon.png');?>" /></div>
												</form>
											</div>
										</div>
									</div>
									
									<?php }else{ ?>
										<div class="alert alert-danger show" role="alert">
											<strong>Alert!</strong>  Fill all information first to access this tab.
										</div>
									<?php } ?>
								</div>

								<div class="tab-pane" id="riderTab" role="tabpanel">
									<h4 class="header-title">Riders List</h4>
									<?php if($partner_basic_status > 0){ ?>
										<div class="row p-2">
											<div class="col-md-12">
												<table id="riderTable" class="table table-striped table-bordered jambo_table bulk_action">
													<thead>
														<tr>
															<th>#</th>
															<th>Rider Name</th>
															<th>Mobile</th>
															<th>Iqama No.</th>
															<th>Status</th>
															<th>Appl. Status</th>
															<th>Reg. Date</th>
															<th>Action</th>
														</tr>
													</thead>
													<body>
														<?php $rider_count = 1;foreach($rider_list as $rider){ ?>
														<tr>
															<td><?= $rider_count++;?></td>
															<td><?= $rider->name;?></td>
															<td><?= $rider->mobile;?></td>
															<td><?= $rider->iqama_no;?></td>
															<td><?= ($rider->status == '0') ? '<span class="badge badge-pill badge-soft-secondary font-size-13">Deactive</span>' : (($rider->status == '1') ? '<span class="badge badge-pill badge-soft-success font-size-13">Active</span>' : (($rider->status == '2') ? '<span class="badge badge-pill badge-soft-danger font-size-13">Blocked</span>' : '<span class="badge badge-pill badge-soft-info font-size-13">NULL</span>'));?></td>
															<td><?= ($rider->application_status == 'verified') ? '<span class="badge badge-pill badge-soft-success font-size-13">Verified</span>':'<span class="badge badge-pill badge-soft-danger font-size-13">Unverified</span>';?></td>
															<td><?= date("d-m-y h:i A", strtotime($rider->created_at));?></td>
															<td><?= '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" data-toggle="tooltip" title="Detail" target="_blank" href="'.base_url().'admin/deliveryvehicle/detail?id='.$rider->id.'"><i class="mdi mdi-stretch-to-page-outline font-size-18"></i></a>';?></td>
														</tr>
														<?php } ?>
													</tbody>
												</table>
											</div>
										</div>
									<?php }else{ ?>
										<div class="alert alert-danger show" role="alert">
											<strong>Alert!</strong>  Fill vehicle information first to access this tab.
										</div>
									<?php } ?>
								</div>
								
								<div class="tab-pane" id="commissionTab" role="tabpanel">
									<?php if($partner_basic_status > 0){ ?>
										<div class="row size-inner-section px-2 py-4">
											<h4 class="header-title mb-3">Riders Commission Structure:</h4>
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
																<input name="comm_amount[]" class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" value="<?php echo $commissions[0]['comm_amount'];?>" required readonly>
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
																<input name="comm_amount[]" class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" value="<?php echo $commissions[1]['comm_amount'];?>" required readonly>
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
																<input name="comm_amount[]" class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" value="<?php echo $commissions[2]['comm_amount'];?>" required readonly>
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
																<input name="comm_amount[]" class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" value="<?php echo $commissions[3]['comm_amount'];?>" required readonly>
															</div>
														</td>
													</tr>
													<?php } ?>
												</tbody>
											</table>
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
			</div> <!-- end col -->
		 </div> <!-- end row -->
	</div>
</div>
<!-- container-fluid -->

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
				<form method="post" action="admin/logistic_partner/change_password" id="password_form" data-parsley-validate="" class="form-horizontal">
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
<?php $this->load->view('admin/home/footer');?>
<script>
	
	var base_url = '<?= base_url();?>';
    
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
	
    $('.password-show').click(function() {
		var login_id = $(this).data('id');
		//alert(login_id);
		$.ajax({
			type: "post",
			url: "<?php echo base_url();?>admin/logistic_partner/getLoginDetail",
			data: {'login_id': login_id},
			dataType: "json",
			success: function (response) {
				//console.log(response);
				$('#encyp_pass').val(response.password);
				$('.password-show').addClass(' d-none');
				$('.taptocopy').removeClass('d-none');
			}
		});
	});
    /*
    $('#password_form').on('submit', (function(e) {
		//alert('test');
		e.preventDefault();
		$.ajax({
			url: '<?php echo base_url();?>admin/logistic_partner/change_password',
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
    */
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

	$('.taptocopy').click(function (e) {
		e.preventDefault();
		var copyText = $('#encyp_pass').val();

		document.addEventListener('copy', function(e) {
			e.clipboardData.setData('text/plain', copyText);
			e.preventDefault();
		}, true);

		document.execCommand('copy');
		alert('Password successfully copied');
	});

	$('.copy-cr').click(function (e) {
		e.preventDefault();
		var copyText = $('#cr_no').val();
		document.addEventListener('copy', function(e) {
			e.clipboardData.setData('text/plain', copyText);
			e.preventDefault();
		}, true);

		document.execCommand('copy');
		alert('CR Number successfully copied');
	});
	
	$(document).ready(function(){
		$('#riderTable').dataTable({
			"lengthMenu": [[25, 50, 100, 500], [25, 50, 100, 500]],
			order: [[0, 'DESC']],
			dom: 'Blfrtip',
			buttons: [
				{
					extend: "csv",
					className: "btn-md"
				},
				{
					extend: "excel",
					className: "btn-md"
				},
				{
					extend: "pdfHtml5",
					className: "btn-md"
				},
				{
					extend: "print",
					className: "btn-md"
				},
			],
			fixedHeader: true,
			"order":[],
			"columnDefs":[
				{
				"targets":[0,1],
				"orderable":false
				},
			]
		});
	});
</script>
