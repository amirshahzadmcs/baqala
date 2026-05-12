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
.main-profile-cover {
    background-image: url(<?php echo base_url('admin_assets/images/title-img.png');?>);
    background-size: cover;
    background-position: inherit;
    background-repeat: inherit;
    position: relative;
    z-index: 9;
}
.main-profile-cover .user-img .user-short-name {
    width: 80px;
    height: 80px;
    border: 3px solid #23c58f;
    padding: 10px;
    font-size: 36px;
    border-radius: 50%;
    display: block;
    text-align: center;
}
.main-profile-cover .user-img .avatar-online {
	position: absolute;
    bottom: 33px;
    width: 10px;
    height: 10px;
    z-index: 1;
    border: 2px solid transparent;
    border-radius: 50%;
    margin-left: 6px;
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
				<!-- Start::row-1 -->
				<div class="row">
					<div class="col-xxl-12 col-xl-12">
						<div class="card custom-card overflow-hidden">
							<div class="card-body d-sm-flex align-items-top p-4 main-profile-cover">
								<div class="user-img me-3 my-auto">
									<span class="user-short-name"><?php $short_name = explode(' ', $company_name);echo substr($short_name[0],0,1);?></span>
									<span class="avatar-online bg-success"></span>
								</div>
								<div class="flex-fill main-profile-info my-auto">
									<h5 class="fw-semibold mb-1"><?php echo $company_name;?></h5>
									<div>
										<p class="mb-1 text-muted"><?php echo $email;?></p>
										<div class="fs-12 op-7 mb-0 d-flex">
											<p class="me-3 mb-0"><i class="ri-building-line me-1 align-middle d-inline-flex"></i><?php echo $other_info['short_address'];?></p>
										</div>
									</div>
								</div>
								<div class="main-profile-info ms-auto">
									<div class="">
										<div class="d-flex align-items-center justify-content-between">
											<div class="d-flex mb-0 ms-auto">
												<div class="me-4">
													<p class="fw-bold fs-20 text-shadow mb-0"><?php echo count($rider_list); ?></p>
													<p class="mb-0 fs-12 text-muted">Total Riders</p>
												</div>
											</div>
										</div>
									</div>
									<div class="mb-0 mt-2 text-end">
										<a href="<?php echo base_url('logistic-partner/change-password'); ?>" class="btn btn-secondary btn-sm btn-wave waves-effect waves-light"><i class="ri-add-line me-1 align-middle"></i>Change Password</a>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-12">
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
													<label for="customer_no">Account ID  <span class="text-danger">*</span></label>
													<input type="text" class="form-control" id="customer_no" name="customer_no" maxlength="150" value="<?php echo $customer_no;?>" required readonly />
												</div>
												
												<div class="col-md-3 col-sm-12 mb-3 form-group">
													<label for="account_manager">Account Manager<span class="text-danger">*</span></label>
													<select name="account_manager" class="form-control" required>
														<option value="">Select Account Manager</option>
														<?php foreach(employeeListHelper() as $employee_list){ ?>
														<option value="<?= $employee_list->id;?>" <?php echo ($employee_list->id == $account_manager) ? "selected":"";?>><?= $employee_list->full_name;?> - <?= $employee_list->designation_name;?></option>
														<?php } ?>
													</select>
												</div>
												
												<div class="col-md-3 col-sm-12 mb-3 form-group">
													<label for="agreement_start">Agreement Start Date<span class="text-danger">*</span></label>
													<input type="date" class="form-control" id="agreement_start" name="agreement_start" max="<?php echo date("Y-m-d"); ?>" value="<?php echo $agreement_start;?>" required />
												</div>

												<div class="col-md-3 col-sm-12 mb-3 form-group">
													<label for="agrement_expiry">Agreement Expiry<span class="text-danger">*</span></label>
													<input type="date" class="form-control" id="agrement_expiry" name="agrement_expiry" min="<?php echo date("Y-m-d"); ?>" value="<?php echo $agrement_expiry;?>" required />
												</div>

												<div class="col-md-3 col-sm-12 mb-3 form-group">
													<label for="company_name">Full Legal Name (English)<span class="text-danger">*</span></label>
													<input type="text" class="form-control" id="company_name" name="company_name" maxlength="150" value="<?php echo $company_name;?>" required />
												</div>

												<div class="col-md-3 col-sm-12 mb-3 form-group">
													<label for="company_arabic_name">Full Legal Name (Arabic)<span class="text-danger">*</span></label>
													<input type="text" class="form-control rtl-input" id="company_arabic_name" name="company_arabic_name" maxlength="150" value="<?php echo $company_arabic_name;?>" required />
												</div>

												<div class="col-md-3 col-sm-12 mb-3 form-group">
													<label for="cr_no">CR Number <span class="text-danger">*</span></label>
													<div class="input-group bootstrap-touchspin bootstrap-touchspin-injected">
														<input type="text" class="form-control" id="cr_no" name="cr_no" minlength="<?= CR_LENGTH; ?>" maxlength="<?= CR_LENGTH; ?>" value="<?php echo $cr_no;?>" required />
													</div>
												</div>

												<div class="col-md-3 col-sm-12 mb-3 form-group">
													<label for="cr_expiry">CR. Expiry </label>
													<input type="date" class="form-control" id="cr_expiry" name="cr_expiry" min="<?php echo date("Y-m-d"); ?>" value="<?php echo $cr_expiry;?>" />

												</div>

												<div class="col-md-3 col-sm-12 mb-3 form-group">
													<label for="vat_no">VAT Number <span class="text-danger">*</span></label>
													<input type="text" class="form-control" id="vat_no" name="vat_no" value="<?php echo $vat_no;?>" minlength="<?= VAT_LENGTH; ?>" maxlength="<?= VAT_LENGTH; ?>" required />

												</div>

												<div class="col-md-3 col-sm-12 mb-3 form-group">
													<label for="vat_expiry">VAT Expiry</label>
													<input type="date" class="form-control" id="vat_expiry" name="vat_expiry" min="<?php echo date("Y-m-d"); ?>" value="<?php echo $vat_expiry;?>" />

												</div>
												
												<div class="col-md-3 col-sm-12 mb-3 form-group">
													<label for="business_nature">Nature of Business<span class="text-danger">*</span></label>
													<select name="business_nature" class="form-control" required>
														<option value="">Select Nature of Business</option>
														<option value="Trading" <?php echo ($business_nature == 'Trading') ? "selected":"";?>>Trading</option>
														<option value="Manufacturing" <?php echo ($business_nature == 'Manufacturing') ? "selected":"";?>>Manufacturing</option>
														<option value="Service Provider" <?php echo ($business_nature == 'Service Provider') ? "selected":"";?>>Service Provider</option>
														<option value="Contracting" <?php echo ($business_nature == 'Contracting') ? "selected":"";?>>Contracting</option>
													</select>
												</div>

												<div class="col-md-3 col-sm-12 mb-3 form-group">
													<label for="company_type">Type of Company<span class="text-danger">*</span></label>
													<select name="company_type"  class="form-control" required>
														<option value="">Select Company Type</option>
														<option value="Establishment" <?php echo ($company_type == 'Establishment') ? "selected":"";?>>Establishment</option>
														<option value="SPC" <?php echo ($company_type == 'SPC') ? "selected":"";?>>SPC</option>
														<option value="Pvt. Ltd. Company" <?php echo ($company_type == 'Pvt. Ltd. Company') ? "selected":"";?>>Pvt. Ltd. Company</option>
														<option value="Partnership Company" <?php echo ($company_type == 'Partnership Company') ? "selected":"";?>>Partnership Company</option>
													</select>
												</div>
												
												<div class="col-md-3 col-sm-12 mb-3 form-group">
													<label for="mobile">Mobile Number <span class="text-danger">*</span></label>
													<input type="text" class="form-control mobile" id="mobile" name="mobile" onkeypress="return numerics(event);" minlength="<?= MOB_LENGTH; ?>" maxlength="<?= MOB_LENGTH; ?>" value="<?php echo $mobile;?>" required />

												</div>

												<div class="col-md-3 col-sm-12 mb-3 form-group">
													<label for="client_telephone">Telephone Number <span class="text-danger">*</span></label>
													<input type="text" class="form-control mobile" id="client_telephone" name="client_telephone" onkeypress="return numerics(event);" minlength="<?= MOB_LENGTH; ?>" maxlength="<?= MOB_LENGTH; ?>" value="<?php echo $client_telephone;?>" required />

												</div>

												<div class="col-md-3 col-sm-12 mb-3 form-group">
													<label for="client_fax">Fax Number <span class="text-danger">*</span></label>
													<input type="text" class="form-control" id="client_fax" name="client_fax" onkeypress="return numerics(event);" minlength="<?= FAX_LENGTH; ?>" maxlength="<?= FAX_LENGTH; ?>" value="<?php echo $client_fax;?>" required />

												</div>

												<div class="col-md-3 col-sm-12 mb-3 form-group">
													<label for="email">Email <span class="text-danger">*</span></label>
													<input type="email" id="email" name="email" maxlength="<?= EMAIL_LENGTH; ?>" value="<?php echo $email;?>" class="form-control" required >

												</div>

												<div class="col-md-3 col-sm-12 mb-3 form-group">
													<label for="website">Website </label>
													<input type="text" class="form-control" id="website" name="website" value="<?php echo $other_info['website'];?>" maxlength="120" />

												</div>

												<div class="col-md-3 col-sm-12 mb-3 form-group">
													<label for="status">Status<span class="text-danger">*</span></label>
													<select name="status"  class="form-control">
														<option value="1" <?php echo ($status == '1') ? "selected":"";?>>Active</option>
														<option value="0" <?php echo ($status == '0') ? "selected":"";?>>Inactive</option>
														<option value="2" <?php echo ($status == '2') ? "selected":"";?>>Block</option>
													</select>
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
													<select id="region_id" name="region_id" class="form-control col-md-12" required>
														<option value="">Select Region</option>
														<?php foreach(getRegions() as $master_region){?>
														<option value="<?php echo $master_region->id;?>" data-id="<?php echo $master_region->id;?>" <?php echo ($other_info['region_id'] == $master_region->id) ? "selected":"";?>><?php echo $master_region->region_name;?></option>
														<?php } ?>
													</select>
												</div>

												<div class="col-md-3 mb-3 form-group">
													<label for="city">City Name <span class="text-danger">*</span></label>
													<select id="city" name="city" class="form-control col-md-12" required>
														<?php if($other_info['region_id'] > 0) { foreach(selectedCitiesHelp($other_info['region_id']) as $master_city){?>
														<option value="<?php echo $master_city->id;?>" data-id="<?php echo $master_city->id;?>" <?php echo ($other_info['city'] == $master_city->id) ? "selected":"";?>><?php echo $master_city->city_name;?></option>
														<?php }}else{ ?>
														<option value="">Select Region First</option>
														<?php } ?>
													</select>
												</div>

												<div class="col-md-3 col-sm-12 mb-3 form-group">
													<label for="country">Country <span class="text-danger">*</span></label>
													<select id="country" name="country" class="form-control col-md-12" required>
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
														<select style="height:410px;" name="bank_name" id="bank_name" class="form-control" required>
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
														<select id="account_currency" name="account_currency" class="form-control col-md-12">
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
														<select id="region" name="region" class="form-control col-md-12">
															<option value="">Select Region</option>
															<?php foreach(getRegions() as $master_region){?>
															<option value="<?php echo $master_region->id;?>" data-id="<?php echo $master_region->id;?>" <?php echo ($bank_info->region == $master_region->id) ? "selected":"";?>><?php echo $master_region->region_name;?></option>
															<?php } ?>
														</select>
													</div>
													
													<div class="col-md-4 mb-3 form-group">
														<label for="bank_city">City Name <span class="text-danger">*</span></label>
														<select id="bank_city" name="bank_city" class="form-control col-md-12" required>
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
													<strong>Alert!</strong>  Currently this tab is not accessible.
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
													<strong>Alert!</strong>  Currently this tab is not accessible.
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
													<strong>Alert!</strong>  Currently this tab is not accessible.
												</div>
											<?php } ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div> <!-- end col -->
				</div>
				<!--End::row-1 -->
			</div>
		</div>

    </div>
    <!-- End Page-content -->
</div>
<!-- end page content-->
<?php $this->load->view('logistic/layout/footer');?>
<script></script>
