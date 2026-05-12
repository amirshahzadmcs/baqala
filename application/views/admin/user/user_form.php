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
.nav-link {
    display: block;
    padding: 0.5rem 0.5rem;
}
/* Always set the map height explicitly to define the size of the div
   * element that contains the map. */
  #map{
		height: 40vh;
		margin-bottom: 10px;
		box-shadow: 0px 0px 5px #bbbbbb;
	}
  #description {
	font-family: Roboto;
	font-size: 15px;
	font-weight: 300;
  }

  #infowindow-content .title {
	font-weight: bold;
  }

  #infowindow-content {
	display: none;
  }

  #map #infowindow-content {
	display: inline;
  }

  .pac-card {
	margin: 0px;
    border-radius: 2px 0 0 2px;
    box-sizing: border-box;
    -moz-box-sizing: border-box;
    outline: none;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
    background-color: #fff;
    position: relative !important;
  }

  #pac-container {
	padding: 12px;
  }
  .pac-container {
	z-index: 99999 !important;
  }
  .pac-controls {
	display: inline-block;
	padding: 5px 11px;
  }

  .pac-controls label {
	font-family: Roboto;
	font-size: 13px;
	font-weight: 300;
  }

  #pac-input {
	background-color: #fff;
    font-size: 15px;
    font-weight: 300;
    padding: 0 10px;
    text-overflow: ellipsis;
    width: 100%;
	height: 30px;
    border: 1px solid #409844;
  }

  #pac-input:focus {
	border-color: #4d90fe;
  }
  p.hint{
	font-size: 12px;
  }
  .authorize-signs .form-check-input[type=checkbox] {
    border-radius: 0.25em;
    width: 20px;
    height: 20px;
    margin-right: 9px;
    margin-top: 0px;
}
</style>
<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Add Corporate Client</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin');?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="javascript:;">Client Management</a></li>
						<li class="breadcrumb-item active">Create or Edit</li>
					</ol>
				</div>
			</div>
			<?php  $admin_id= $this->session->userdata('admin_id'); ?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<?php if($this->customer->userd($admin_id)->role=="Admin" ){?>
					<a class="btn btn-sm btn-custom-white pull-right" title="Back" href="<?php echo base_url('admin/business-user/list');?>"><i class="fa fa-reply"></i> Back</a>
					<!--&nbsp;
					<a class="btn btn-sm btn-custom pull-right" title="Add Business Client" href="<?php echo base_url('admin/user/individual-form');?>"><i class="fa fa-plus"></i> Add Individual Client</a>-->
					&nbsp;
					<button form="bs-form2" type="submit" class="btn btn-sm btn-custom-success pull-right" title="Save"><i class="fa fa-save"></i> Save</button>
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
					<div class="card-body">
		 				<h5 class="scheduler-border">Corporate Client:</h5>
						<?php echo form_open("admin/business-user/submit-business-form", array("id"=>"bs-form2", "enctype"=>"multipart/form-data", "class"=>"form-horizontal form-label-left", "data-parsley-validate"=> "")); ?>
							<input type="hidden" id="id" name="id" value="<?php echo $id;?>">
							<input type="hidden" id="role_id" name="role_id" value="2">
							
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
											<span class="d-block d-sm-none"><i class="fas fa-landmark"></i></span>
											<span class="d-none d-sm-block">Bank Account</span>
										</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" data-bs-toggle="tab" href="#messages1" role="tab">
											<span class="d-block d-sm-none"><i class="fas fa-cloud-upload-alt"></i></span>
											<span class="d-none d-sm-block">Upload Documents</span>
										</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" data-bs-toggle="tab" href="#address" role="tab">
											<span class="d-block d-sm-none"><i class="fas fa-address-book"></i></span>
											<span class="d-none d-sm-block">Address Book</span>
										</a>
									</li>

									<li class="nav-item">
										<a class="nav-link" data-bs-toggle="tab" href="#user_login" role="tab">
											<span class="d-block d-sm-none"><i class="fa fa-key"></i></span>
											<span class="d-none d-sm-block">Staff's Login</span>
										</a>
									</li>
								</ul>

								<div class="tab-content py-3 text-muted">
									<div class="tab-pane active" id="home" role="tabpanel">
										<h4 class="header-title">Basic Information</h4>
										<p class="card-title-desc">Fill all information below</p>
										<div class="row size-inner-section px-2 py-4">
											<div class="col-md-3 col-sm-12 mb-3 form-group">
												<label for="customer_no">Client Account ID  <span class="required-field">*</span></label>
												<input type="text" class="form-control" id="customer_no" name="customer_no" maxlength="150" value="<?php echo $customer_no;?>" required readonly />
												<p class="hint">ID will be automatically generated</p>
											</div>

											<div class="col-md-3 col-sm-12 mb-3 form-group">
												<label for="account_manager">Client Account Manager<span class="required-field">*</span></label>
												<select name="account_manager" class="form-control select2" required>
													<option value="">Select Account Manager</option>
													<?php foreach(employeeListHelper() as $employee_list){ ?>
													<option value="<?= $employee_list->id;?>" <?php echo ($employee_list->id == $account_manager) ? "selected":"";?>><?= $employee_list->emp_no;?> - <?= $employee_list->full_name;?> (<?= $employee_list->designation_name;?>)</option>
													<?php } ?>
												</select>
												<p class="hint">Set account manager for your client</p>
											</div>
											
											<div class="col-md-3 col-sm-12 mb-3 form-group">
												<label for="agreement_start">Agreement Start Date<span class="required-field">*</span></label>
												<input type="date" class="form-control" id="agreement_start" name="agreement_start" max="<?php echo date("Y-m-d"); ?>" value="<?php echo $agreement_start;?>" required />
												<p class="hint">Enter Agreement Start Date for client</p>
											</div>

											<div class="col-md-3 col-sm-12 mb-3 form-group">
												<label for="agrement_expiry">Agreement Expiry<span class="required-field">*</span></label>
												<input type="date" class="form-control" id="agrement_expiry" name="agrement_expiry" min="<?php echo date("Y-m-d"); ?>" value="<?php echo $agrement_expiry;?>" required />
												<p class="hint">Enter Agreement Expiry Date for client</p>
											</div>

											<div class="col-md-3 col-sm-12 mb-3 form-group">
												<label for="company_name">Full Legal Name (English)<span class="required-field">*</span></label>
												<input type="text" class="form-control" id="company_name" name="company_name" maxlength="150" value="<?php echo $company_name;?>" required />
												<p class="hint">Enter company name for client</p>
											</div>

											<div class="col-md-3 col-sm-12 mb-3 form-group">
												<label for="company_arabic_name">Full Legal Name (Arabic)<span class="required-field">*</span></label>
												<input type="text" class="form-control rtl-input" id="company_arabic_name" name="company_arabic_name" maxlength="150" value="<?php echo $company_arabic_name;?>" required />
												<p class="hint">Enter company name for client</p>
											</div>

											<div class="col-md-3 col-sm-12 mb-3 form-group">
												<label for="cr_no">CR Number <span class="required-field">*</span></label>
												<input type="text" class="form-control" id="cr_no" name="cr_no" minlength="<?= CR_LENGTH; ?>" maxlength="<?= CR_LENGTH; ?>" value="<?php echo $cr_no;?>" required />
												<p class="hint">Enter CR Number for client</p>
											</div>

											<div class="col-md-3 col-sm-12 mb-3 form-group">
												<label for="cr_expiry">CR. Expiry </label>
												<input type="date" class="form-control" id="cr_expiry" name="cr_expiry" min="<?php echo date("Y-m-d"); ?>" value="<?php echo $cr_expiry;?>" />
												<p class="hint">Enter CR Expiry Date for client</p>
											</div>

											<div class="col-md-3 col-sm-12 mb-3 form-group">
												<label for="vat_no">VAT Number <span class="required-field">*</span></label>
												<input type="text" class="form-control" id="vat_no" name="vat_no" value="<?php echo $vat_no;?>" minlength="<?= VAT_LENGTH; ?>" maxlength="<?= VAT_LENGTH; ?>" required />
												<p class="hint">Enter VAT Number for client</p>
											</div>

											<div class="col-md-3 col-sm-12 mb-3 form-group">
												<label for="vat_expiry">VAT Expiry</label>
												<input type="date" class="form-control" id="vat_expiry" name="vat_expiry" min="<?php echo date("Y-m-d"); ?>" value="<?php echo $vat_expiry;?>" />
												<p class="hint">Enter VAT Expiry Date for client</p>
											</div>
											
											<div class="col-md-3 col-sm-12 mb-3 form-group">
												<label for="business_nature">Nature of Business<span class="required-field">*</span></label>
												<select name="business_nature"  class="form-control select2" required>
													<option value="">Select Nature of Business</option>
													<option value="Trading" <?php echo ($business_nature == 'Trading') ? "selected":"";?>>Trading</option>
													<option value="Manufacturing" <?php echo ($business_nature == 'Manufacturing') ? "selected":"";?>>Manufacturing</option>
													<option value="Service Provider" <?php echo ($business_nature == 'Service Provider') ? "selected":"";?>>Service Provider</option>
													<option value="Contracting" <?php echo ($business_nature == 'Contracting') ? "selected":"";?>>Contracting</option>
												</select>
												<p class="hint">Set nature of business for your client</p>
											</div>

											<div class="col-md-3 col-sm-12 mb-3 form-group">
												<label for="company_type">Type of Company<span class="required-field">*</span></label>
												<select name="company_type"  class="form-control select2" required>
													<option value="">Select Company Type</option>
													<option value="Establishment" <?php echo ($company_type == 'Establishment') ? "selected":"";?>>Establishment</option>
													<option value="SPC" <?php echo ($company_type == 'SPC') ? "selected":"";?>>SPC</option>
													<option value="Pvt. Ltd. Company" <?php echo ($company_type == 'Pvt. Ltd. Company') ? "selected":"";?>>Pvt. Ltd. Company</option>
													<option value="Partnership Company" <?php echo ($company_type == 'Partnership Company') ? "selected":"";?>>Partnership Company</option>
												</select>
												<p class="hint">Set company type for your client</p>
											</div>
											<!--
											<div class="col-md-3 col-sm-12 mb-3 form-group">
												<label for="name">Client Name <span class="required-field">*</span></label>
												<input type="text" class="form-control" id="name" name="name" onKeyPress="return Alpha(event);" maxlength="150" value="<?php echo $name;?>" required />
												<p class="hint">Enter display name for client</p>
											</div>
											-->
											<div class="col-md-3 col-sm-12 mb-3 form-group">
												<label for="mobile">Mobile Number <span class="required-field">*</span></label>
												<input type="text" class="form-control mobile" id="mobile" name="mobile" onkeypress="return numerics(event);" minlength="<?= MOB_LENGTH; ?>" maxlength="<?= MOB_LENGTH; ?>" value="<?php echo $mobile;?>" required />
												<p class="hint">Format 651 234 5678</p>
											</div>

											<div class="col-md-3 col-sm-12 mb-3 form-group">
												<label for="client_telephone">Telephone Number <span class="required-field">*</span></label>
												<input type="text" class="form-control mobile" id="client_telephone" name="client_telephone" onkeypress="return numerics(event);" minlength="<?= MOB_LENGTH; ?>" maxlength="<?= MOB_LENGTH; ?>" value="<?php echo $client_telephone;?>" required />
												<p class="hint">Format 651 234 5678</p>
											</div>

											<div class="col-md-3 col-sm-12 mb-3 form-group">
												<label for="client_fax">Fax Number <span class="required-field">*</span></label>
												<input type="text" class="form-control" id="client_fax" name="client_fax" onkeypress="return numerics(event);" minlength="<?= FAX_LENGTH; ?>" maxlength="<?= FAX_LENGTH; ?>" value="<?php echo $client_fax;?>" required />
												<p class="hint">Format 651 234 5678</p>
											</div>

											<div class="col-md-3 col-sm-12 mb-3 form-group">
												<label for="email">Email </label>
												<input type="email" id="email" name="email" maxlength="<?= EMAIL_LENGTH; ?>" value="<?php echo $email;?>" class="form-control" required >
												<p class="hint">Enter email address for client</p>
											</div>

											<div class="col-md-3 col-sm-12 mb-3 form-group">
												<label for="website">Website </label>
												<input type="text" class="form-control" id="website" name="website" value="<?php echo $website;?>" maxlength="120" />
												<p class="hint">Enter company website for client</p>
											</div>

											<div class="col-md-3 col-sm-12 mb-3 form-group">
												<label for="status">Status<span class="required-field">*</span></label>
												<select name="status"  class="form-control" required>
													<option value="1" <?php echo ($status == '1') ? "selected":"";?>>Active</option>
													<option value="0" <?php echo ($status == '0') ? "selected":"";?>>Inactive</option>
													<option value="2" <?php echo ($status == '2') ? "selected":"";?>>Block</option>
												</select>
												<p class="hint">Set status for your client</p>
											</div>
											
										</div>

										<div class="row size-inner-section px-2 py-4">
											<h5 class="scheduler-border">Tick if Authorize to Sign PO:</h5>
											<h5 class="scheduler-border mb-4" style="font-size: 13px;"><span class="text-danger">*</span>Select any two authorize person only</h5>
											<div class="row authorize-signs">
												<?php $authSignIds = explode(',',$authorize_ids);?>
												<div class="col-md-3 col-sm-12 mb-3 form-group">
													<div class="form-check mb-3">
														<input class="form-check-input" type="checkbox" id="authsign1" name="authsign[]" value="director1" <?php echo (in_array('director1', $authSignIds)) ? "checked":"";?>>
														<label class="form-check-label" for="authsign1">Owner/Director 1</label>
													</div>
												</div>
												<div class="col-md-3 col-sm-12 mb-3 form-group">
													<div class="form-check mb-3">
														<input class="form-check-input" type="checkbox" id="authsign2" name="authsign[]" value="director2" <?php echo (in_array('director2', $authSignIds)) ? "checked":"";?>>
														<label class="form-check-label" for="authsign2">Owner/Director 2</label>
													</div>
												</div>
												<div class="col-md-3 col-sm-12 mb-3 form-group">
													<div class="form-check mb-3">
														<input class="form-check-input" type="checkbox" id="authsign3" name="authsign[]" value="finance" <?php echo (in_array('finance', $authSignIds)) ? "checked":"";?>>
														<label class="form-check-label" for="authsign3">Finance Manager</label>
													</div>
												</div>
												<div class="col-md-3 col-sm-12 mb-3 form-group">
													<div class="form-check mb-3">
														<input class="form-check-input" type="checkbox" id="authsign4" name="authsign[]" value="procurement" <?php echo (in_array('procurement', $authSignIds)) ? "checked":"";?>>
														<label class="form-check-label" for="authsign4">Procurement Manager</label>
													</div>
												</div>
											</div>

											<h5 class="scheduler-border">Director's Contact Information:</h5>
											
											<div class="row">
												<h5 class="scheduler-border" style="font-size: 13px;">First Director Information:</h5>
												<div class="col-md-3 col-sm-12 mb-3 form-group">
													<label for="director_name1">Owner/Director Name 1 :</label>
													<input type="text" class="form-control" id="director_name1" name="director_name1" value="<?php echo $director_name1;?>" onKeyPress="return Alpha(event);" maxlength="150" />
												</div>
												<div class="col-md-3 col-sm-12 mb-3 form-group">
													<label for="director_id_no1">ID No Owner/Director 1 :</label>
													<input type="text" class="form-control" id="director_id_no1" name="director_id_no1" value="<?php echo $director_id_no1;?>" maxlength="40" />
												</div>
												<div class="col-md-3 col-sm-12 mb-3 form-group">
													<label for="director_mobile1">Mobile Owner/Director 1 :</label>
													<input type="text" class="form-control mobile" id="director_mobile1" name="director_mobile1" value="<?php echo $director_mobile1;?>" onkeypress="return numerics(event);" minlength="10" maxlength="10" />
												</div>
												<div class="col-md-3 col-sm-12 mb-3 form-group">
													<label for="director_email1">Email Owner/Director 1 :</label>
													<input type="email" class="form-control" id="director_email1" name="director_email1" value="<?php echo $director_email1;?>" maxlength="150" />
												</div>
											</div>
											<div class="row">
												<h5 class="scheduler-border" style="font-size: 13px;">Second Director Information:</h5>
												<div class="col-md-3 col-sm-12 mb-3 form-group">
													<label for="director_name2">Owner/Director Name 2 :</label>
													<input type="text" class="form-control" id="director_name2" name="director_name2" value="<?php echo $director_name2;?>" onKeyPress="return Alpha(event);" maxlength="150" />
												</div>
												<div class="col-md-3 col-sm-12 mb-3 form-group">
													<label for="director_id_no2">ID No Owner/Director 2 :</label>
													<input type="text" class="form-control" id="director_id_no2" name="director_id_no2" value="<?php echo $director_id_no2;?>" maxlength="40" />
												</div>
												<div class="col-md-3 col-sm-12 mb-3 form-group">
													<label for="director_mobile2">Mobile Owner/Director 2 :</label>
													<input type="text" class="form-control mobile" id="director_mobile2" name="director_mobile2" value="<?php echo $director_mobile2;?>" onkeypress="return numerics(event);" minlength="10" maxlength="10" />
												</div>
												<div class="col-md-3 col-sm-12 mb-3 form-group">
													<label for="director_email2">Email Owner/Director 2 :</label>
													<input type="email" class="form-control" id="director_email2" name="director_email2" value="<?php echo $director_email2;?>" maxlength="150" />
												</div>
											</div>
										</div>

										<div class="row size-inner-section px-2 py-4">
											<h5 class="scheduler-border">Client Contact Information:</h5>
											
											<div class="row">
												<h5 class="scheduler-border" style="font-size: 13px;">Sales Department:</h5>
												<div class="col-md-3 col-sm-12 mb-3 form-group">
													<label for="sales_name">Sales Manager Name :</label>
													<input type="text" class="form-control" id="sales_name" name="sales_name" value="<?php echo $sales_name;?>" onKeyPress="return Alpha(event);" maxlength="150" />
												</div>
												<div class="col-md-3 col-sm-12 mb-3 form-group">
													<label for="sales_id_no">ID No Sales Manager :</label>
													<input type="text" class="form-control" id="sales_id_no" name="sales_id_no" value="<?php echo $sales_id_no;?>" maxlength="40" />
												</div>
												<div class="col-md-3 col-sm-12 mb-3 form-group">
													<label for="sales_mobile">Mobile Sales Manager :</label>
													<input type="text" class="form-control mobile" id="sales_mobile" name="sales_mobile" value="<?php echo $sales_mobile;?>" onkeypress="return numerics(event);" minlength="10" maxlength="10" />
												</div>
												<div class="col-md-3 col-sm-12 mb-3 form-group">
													<label for="sales_email">Email Sales Manager :</label>
													<input type="email" class="form-control" id="sales_email" name="sales_email" value="<?php echo $sales_email;?>" maxlength="150" />
												</div>
											</div>
											<div class="row">
												<h5 class="scheduler-border" style="font-size: 13px;">Finance Department:</h5>
												<div class="col-md-3 col-sm-12 mb-3 form-group">
													<label for="finance_name">Finance Manager Name :</label>
													<input type="text" class="form-control" id="finance_name" name="finance_name" onKeyPress="return Alpha(event);" value="<?php echo $finance_name;?>" maxlength="150" />
												</div>
												<div class="col-md-3 col-sm-12 mb-3 form-group">
													<label for="finance_id_no">ID No Finance Manager :</label>
													<input type="text" class="form-control" id="finance_id_no" name="finance_id_no" value="<?php echo $finance_id_no;?>" maxlength="40" />
												</div>
												<div class="col-md-3 col-sm-12 mb-3 form-group">
													<label for="finance_mobile">Mobile Finance Manager :</label>
													<input type="text" class="form-control mobile" id="finance_mobile" name="finance_mobile" onkeypress="return numerics(event);" value="<?php echo $finance_mobile;?>" minlength="10" maxlength="10" />
												</div>
												<div class="col-md-3 col-sm-12 mb-3 form-group">
													<label for="finance_email">Email Finance Manager :</label>
													<input type="email" class="form-control" id="finance_email" name="finance_email" value="<?php echo $finance_email;?>" maxlength="150" />
												</div>
											</div>
											<div class="row">
												<h5 class="scheduler-border" style="font-size: 13px;">Legal Department:</h5>
												<div class="col-md-3 col-sm-12 mb-3 form-group">
													<label for="legal_name">Legal Person Name :</label>
													<input type="text" class="form-control" id="legal_name" name="legal_name" onKeyPress="return Alpha(event);" value="<?php echo $legal_name;?>" maxlength="150" />
												</div>
												<div class="col-md-3 col-sm-12 mb-3 form-group">
													<label for="legal_id_no">Legal Person ID No. :</label>
													<input type="text" class="form-control" id="legal_id_no" name="legal_id_no" value="<?php echo $legal_id_no;?>" maxlength="40" />
												</div>
												<div class="col-md-3 col-sm-12 mb-3 form-group">
													<label for="legal_mobile">Legal Mobile No :</label>
													<input type="text" class="form-control mobile" id="legal_mobile" name="legal_mobile" onkeypress="return numerics(event);" value="<?php echo $legal_mobile;?>" minlength="10" maxlength="10" />
												</div>
												<div class="col-md-3 col-sm-12 mb-3 form-group">
													<label for="legal_email">Legal Email ID :</label>
													<input type="email" class="form-control" id="legal_email" name="legal_email" value="<?php echo $legal_email;?>" maxlength="150" />
												</div>
											</div>
											<div class="row">
												<h5 class="scheduler-border" style="font-size: 13px;">Procurement Manager (if any):</h5>
												<div class="col-md-3 col-sm-12 mb-3 form-group">
													<label for="other_name">Procurement Manager Name :</label>
													<input type="text" class="form-control" id="other_name" name="other_name" onKeyPress="return Alpha(event);" value="<?php echo $other_name;?>" maxlength="150" />
												</div>
												<div class="col-md-3 col-sm-12 mb-3 form-group">
													<label for="other_id_no">ID No Procurement Manager :</label>
													<input type="text" class="form-control" id="other_id_no" name="other_id_no" value="<?php echo $other_id_no;?>" maxlength="40" />
												</div>
												<div class="col-md-3 col-sm-12 mb-3 form-group">
													<label for="other_mobile">Mobile Procurement Manager :</label>
													<input type="text" class="form-control mobile" id="other_mobile" name="other_mobile" onkeypress="return numerics(event);" value="<?php echo $other_mobile;?>" minlength="10" maxlength="10" />
												</div>
												<div class="col-md-3 col-sm-12 mb-3 form-group">
													<label for="other_email">Email Procurement Manager :</label>
													<input type="email" class="form-control" id="other_email" name="other_email" value="<?php echo $other_email;?>" maxlength="150" />
												</div>
											</div>
										</div>
										<div class="row size-inner-section px-2 py-4">
											<h5 class="scheduler-border">Client National Address:</h5>
											<div class="col-md-3 col-sm-12 mb-3 form-group">
												<label for="building_no">Building Number :</label>
												<input type="text" class="form-control" id="building_no" name="building_no" value="<?php echo $building_no;?>" />
											</div>
											<div class="col-md-3 col-sm-12 mb-3 form-group">
												<label for="street_name">Street Name :</label>
												<input type="text" class="form-control" id="street_name" name="street_name" value="<?php echo $street_name;?>" />
											</div>
											<div class="col-md-3 col-sm-12 mb-3 form-group">
												<label for="district">District Name :</label>
												<input type="text" class="form-control" id="district" name="district" onKeyPress="return Alpha(event);" value="<?php echo $district;?>" maxlength="150" />
											</div>

											<div class="col-md-3 col-sm-12 mb-3 form-group">
												<label for="region_id">Region <span class="required">*</span></label>
												<select id="region_id" name="region_id" class="form-control col-md-12 select2" required>
													<option value="">Select Region</option>
													<?php foreach($regions as $master_region){?>
													<option value="<?php echo $master_region->id;?>" data-id="<?php echo $master_region->id;?>" <?php echo ($master_region->id == $region_id) ? "selected":"";?>><?php echo $master_region->region_name;?></option>
													<?php } ?>
												</select>
											</div>

											<div class="col-md-3 col-sm-12 mb-3 form-group">
												<label for="city">City Name <span class="required">*</span></label>
												<select id="city" name="city" class="form-control col-md-12 select2" required>
													<option value="">Select Region First</option>
												</select>
											</div>

											<div class="col-md-3 col-sm-12 mb-3 form-group">
												<label for="country">Country :</label>
												<select id="country" name="country" class="form-control col-md-12 select2" required>
													<option value="">Selct Country</option>
													<option value="Saudi Arabia" <?php echo ($country == 'Saudi Arabia') ? "selected":"";?>>Saudi Arabia</option>
												</select>
											</div>
											<div class="col-md-3 col-sm-12 mb-3 form-group">
												<label for="postal_code">Zip Code :</label>
												<input type="text" class="form-control" id="postal_code" name="postal_code" value="<?php echo $postal_code;?>" onkeypress="return numerics(event);" minlength="<?= SAUDI_ZIP_LENGTH; ?>" maxlength="<?= SAUDI_ZIP_LENGTH; ?>" />
											</div>
											<div class="col-md-3 col-sm-12 mb-3 form-group">
												<label for="additional_no">Additional Number :</label>
												<input type="text" class="form-control" id="additional_no" name="additional_no" value="<?php echo $additional_no;?>" maxlength="15" />
											</div>
											<div class="col-md-3 col-sm-12 mb-3 form-group">
												<label for="unit_no">Unit Number :</label>
												<input type="text" class="form-control" id="unit_no" name="unit_no" value="<?php echo $unit_no;?>" maxlength="15" />
											</div>
											<div class="col-md-3 col-sm-12 mb-3 form-group">
												<label for="short_address">Short Address :</label>
												<input type="text" class="form-control" id="short_address" name="short_address" value="<?php echo $short_address;?>" maxlength="255" />
											</div>
										</div>
									</div>
									
									<div class="tab-pane" id="profile1" role="tabpanel">
										<div class="row size-inner-section px-2 py-4">
											<h5 class="scheduler-border">Payment & Delivery Information:</h5>
											<div class="col-md-4 mb-3 form-group">
												<label for="account_holder_name">Account Holder Name :</label>
												<input type="text" class="form-control" id="account_holder_name" name="account_holder_name" maxlength="150" value="<?php echo $account_holder_name;?>" />
											</div>
											<div class="col-md-4 mb-3 form-group">
												<label for="bank_account_no">Bank Account No :</label>
												<input type="text" class="form-control" id="bank_account_no" name="bank_account_no" onkeypress="return numerics(event);" maxlength="<?= BANK_ACCOUNT; ?>" value="<?php echo $bank_account_no;?>" />
											</div>
											<div class="col-md-4 mb-3 form-group">
												<label for="iban_number">IBAN Number :</label>
												<input type="text" class="form-control" id="iban_number" name="iban_number" minlength="<?= IBAN_LENGTH; ?>" maxlength="<?= IBAN_LENGTH; ?>" value="<?php echo $iban_number;?>" />
											</div>
											<div class="col-md-4 mb-3 form-group">
												<label for="bank_name">Bank Name :</label>
												<select id="bank_name" name="bank_name" class="form-control col-md-12 select2">
													<option value="">Select Bank</option>
													<?php foreach($master_banks as $master_bank){?>
													<option value="<?php echo $master_bank->id;?>" <?php echo ($bank_name == $master_bank->id) ? "selected":"";?>><?php echo $master_bank->bank_name;?></option>
													<?php } ?>
												</select>
											</div>
											<div class="col-md-4 mb-3 form-group">
												<label for="branch_name">Branch Name :</label>
												<input type="text" class="form-control" id="branch_name" name="branch_name" onKeyPress="return Alpha(event);" maxlength="250" value="<?php echo $branch_name;?>" />
											</div>
											
											<div class="col-md-4 mb-3 form-group">
												<label for="account_currency">Account Currency :</label>
												<select id="account_currency" name="account_currency" class="form-control col-md-12 select2">
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
												<label for="region">Region <span class="required">*</span></label>
												<select id="region" name="region" class="form-control col-md-12 select2">
													<option value="">Select Region</option>
													<?php foreach($regions as $master_region){?>
													<option value="<?php echo $master_region->id;?>" data-id="<?php echo $master_region->id;?>" <?php echo ($region == $master_region->id) ? "selected":"";?>><?php echo $master_region->region_name;?></option>
													<?php } ?>
												</select>
											</div>
											
											<div class="col-md-4 mb-3 form-group">
												<label for="bank_city">City Name <span class="required">*</span></label>
												<select id="bank_city" name="bank_city" class="form-control col-md-12 select2">
													<option value="">Select Region First</option>
												</select>
											</div>

										</div>
									</div>

									<div class="tab-pane" id="messages1" role="tabpanel">
										<div class="row size-inner-section p-2">
											<h5 class="scheduler-border">Upload Documents</h5>
											<div class="col-md-4 mb-3 form-group">
												<label for="cr_certificate">Commercial Registration Certificate :</label>
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
												<label for="iban_certificate">IBAN Certificate :</label>
												<input type="file" class="form-control" name="iban_certificate" />
												<input type="hidden" name="old_iban_certificate" value="<?php echo $iban_certificate;?>" />
												<?php if($iban_certificate){
													$fileExt = pathinfo($iban_certificate, PATHINFO_EXTENSION);
													if($fileExt == 'jpg' || $fileExt == 'png' || $fileExt == 'JPG' || $fileExt == 'PNG'){
														echo '<img src="'. base_url($iban_certificate) .'" class="img-fluid p-2" width="100px" />';
													}else{
														echo '<a href="'. base_url($iban_certificate) .'" target="_blank"><i class="fa fa-file-pdf-o fa-5x"></i></a>';
													}
												} ?>
											</div>
											
											<div class="col-md-4 mb-3 form-group">
												<label for="owner_id">Owner ID :</label>
												<input type="file" class="form-control" name="owner_id" />
												<input type="hidden" name="old_owner_id" value="<?php echo $owner_id;?>" />
												<?php if($owner_id){
													$fileExt = pathinfo($owner_id, PATHINFO_EXTENSION);
													if($fileExt == 'jpg' || $fileExt == 'png' || $fileExt == 'JPG' || $fileExt == 'PNG'){
														echo '<img src="'. base_url($owner_id) .'" class="img-fluid p-2" width="100px" />';
													}else{
														echo '<a href="'. base_url($owner_id) .'" target="_blank"><i class="fa fa-file-pdf-o fa-5x"></i></a>';
													}
												} ?>
											</div>

											<div class="col-md-4 mb-3 form-group">
												<label for="credit_agreement">Credit Agreement :</label>
												<input type="file" class="form-control" name="credit_agreement" />
												<input type="hidden" name="old_credit_agreement" value="<?php echo $credit_agreement;?>" />
												<?php if($credit_agreement){
													$fileExt = pathinfo($credit_agreement, PATHINFO_EXTENSION);
													if($fileExt == 'jpg' || $fileExt == 'png' || $fileExt == 'JPG' || $fileExt == 'PNG'){
														echo '<img src="'. base_url($credit_agreement) .'" class="img-fluid p-2" width="100px" />';
													}else{
														echo '<a href="'. base_url($credit_agreement) .'" target="_blank"><i class="fa fa-file-pdf-o fa-5x"></i></a>';
													}
												} ?>
											</div>
											
											<div class="col-md-4 mb-3 form-group">
												<label for="authorization_copy">Authorization Copy :</label>
												<input type="file" class="form-control" name="authorization_copy" />
												<input type="hidden" name="old_authorization_copy" value="<?php echo $authorization_copy;?>" />
												<?php if($authorization_copy){
													$fileExt = pathinfo($authorization_copy, PATHINFO_EXTENSION);
													if($fileExt == 'jpg' || $fileExt == 'png' || $fileExt == 'JPG' || $fileExt == 'PNG'){
														echo '<img src="'. base_url($authorization_copy) .'" class="img-fluid p-2" width="100px" />';
													}else{
														echo '<a href="'. base_url($authorization_copy) .'" target="_blank"><i class="fa fa-file-pdf-o fa-5x"></i></a>';
													}
												} ?>
											</div>
											<div class="col-md-4 mb-3 form-group">
												<label for="authorize_person_id">Authorized Person ID :</label>
												<input type="file" class="form-control" name="authorize_person_id" />
												<input type="hidden" name="old_authorize_person_id" value="<?php echo $authorize_person_id;?>" />
												<?php if($authorize_person_id){
													$fileExt = pathinfo($authorize_person_id, PATHINFO_EXTENSION);
													if($fileExt == 'jpg' || $fileExt == 'png' || $fileExt == 'JPG' || $fileExt == 'PNG'){
														echo '<img src="'. base_url($authorize_person_id) .'" class="img-fluid p-2" width="100px" />';
													}else{
														echo '<a href="'. base_url($authorize_person_id) .'" target="_blank"><i class="fa fa-file-pdf-o fa-5x"></i></a>';
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
										</div>
									</div>
									<div class="tab-pane" id="address" role="tabpanel">
										<div class="row size-inner-section p-2">
											<h5 class="scheduler-border">Address Book:<?php if($id > 0){?><a class="btn btn-sm btn-custom float-end" title="Add New Address" href="javascript:;" data-bs-toggle="modal" data-bs-target=".bs-address-modal-lg"><i class="fa fa-plus"></i> Add New Address</a> <?php } ?></h5>
											<hr>
											<?php if($id > 0){?>
											<?php foreach($corporate_address as $c_addresses){?>
											<div class="col-sm-12 col-lg-12">
												<div class="card text-dark bg-light border">
													<div class="card-body">
														<table class="table border bg-white">
															<tr>
																<td colspan="3">
																	<h4>
																		<?php echo $c_addresses->address_label;?>
																		<!--<a class="btn btn-sm btn-warning float-end ms-2" title="Edit Address" href="javascript:;" onClick="quickEditAddress('<?= $c_addresses->id;?>')"><i class="mdi mdi-pencil font-size-14"></i></a>-->
																		<a class="btn btn-sm btn-danger float-end" data-confirm="Are you sure you want to delete this address?" title="Delete Address" href="<?= base_url().'admin/business-user/delete-corporate-address?id='.$c_addresses->id;?>"><i class="mdi mdi-delete font-size-14"></i></a>
																	</h4>
																</td>
															</tr>
															<tr>
																<td><strong>Contact Person: </strong><?php echo $c_addresses->person_name;?></td>
																<td><strong>Mobile: </strong><?php echo $c_addresses->mobile;?></td>
																<td><strong>Email: </strong><?php echo $c_addresses->email;?></td>
															</tr>
															<tr>
																<td><strong>Country: </strong><?php echo $c_addresses->country;?></td>
																<td><strong>State: </strong><?php echo $c_addresses->state;?></td>
																<td><strong>City: </strong><?php echo $c_addresses->city;?></td>
															</tr>
															<tr>
																<td><strong>Street: </strong><?php echo $c_addresses->street;?></td>
																<td><strong>House Type: </strong><?php echo $c_addresses->address_type;?></td>
																<td><strong><?php echo $c_addresses->address_type;?> No.: </strong><?php echo $c_addresses->building_villa_no;?></td>
															</tr>
															<tr>
																<td><strong>Postal: </strong><?php echo $c_addresses->postal;?></td>
																<td><strong>Latitude: </strong><?php echo $c_addresses->shipping_lat;?></td>
																<td><strong>Longtitude: </strong><?php echo $c_addresses->shipping_lng;?></td>
															</tr>
															<tr>
																<td><strong>Phone: </strong><?php echo $c_addresses->phone;?></td>
																<td><strong>Extension: </strong><?php echo $c_addresses->extension;?></td>
																<td><strong>Reference: </strong><?php echo $c_addresses->reference;?></td>
															</tr>
															<tr>
																<td><strong>Added On: </strong><?php echo $c_addresses->created_at;?></td>
																<td><strong>Last updated: </strong><?php echo $c_addresses->updated_at;?></td>
															</tr>
														</table>
													</div>
												</div>
											</div>
											<?php } ?>
											<?php }else{
												echo '<h6>This feature only available when edit information, add user first</h6>';
											} ?>
										</div>
									</div>

									<!---- User Logins ----->

									<div class="tab-pane" id="user_login" role="tabpanel">
										<div class="row size-inner-section px-2 py-4">
											<h5 class="scheduler-border">Users Login:<?php if($id > 0){?><a class="btn btn-sm btn-custom float-end" title="Add New Login" href="javascript:;" onClick="quickLoginAdd('<?= $id;?>')"><i class="fa fa-plus"></i> Add New Login</a> <?php } ?></h5>
											<hr>
											<?php if($id > 0){?>
											<?php foreach($corporate_logins as $c_login){?>
												<div class="col-sm-12 col-lg-12">
													<div class="card text-dark bg-light border">
														<div class="card-body">
															<table class="table border bg-white">
																<tr>
																	<td colspan="3">
																		<h4>
																			<?php echo $c_login->display_name;?> <?php echo ($c_login->login_role == 'main') ? '<span class="badge badge-pill badge-soft-primary font-size-13">Main</span>' : '<span class="badge badge-pill badge-soft-info font-size-13">Staff</span>';?>
																			<a class="btn btn-sm btn-warning float-end ms-2" title="Edit Login" href="javascript:;" onClick="quickLoginEdit('<?= $c_login->id;?>')"><i class="mdi mdi-pencil font-size-14"></i></a>
																			<a class="btn btn-sm btn-danger float-end" data-confirm="Are you sure you want to delete this login?" title="Delete Address" href="<?= base_url().'admin/business-user/delete-corporate-login?id='.$c_login->id .'&main_id='.$c_login->main_id;?>"><i class="mdi mdi-delete font-size-14"></i></a>
																		</h4>
																	</td>
																</tr>
																<tr>
																	<td><strong>Display Name: </strong> <?php echo $c_login->display_name;?></td>
																	<td><strong>Corporate ID: </strong> <?php echo $c_login->corporate_id;?></td>
																</tr>
																<tr>
																	<td><strong>Email: </strong> <?php echo $c_login->login_email;?></td>
																	<td><strong>Username: </strong> <?php echo $c_login->username;?></td>
																</tr>
																<tr>
																	<td><strong>Phone: </strong> <?php echo $c_login->login_phone;?></td>
																	<td><strong>Password: </strong> <span id="encyp_pass<?= $c_login->id; ?>">**********</span> <a class="btn btn-sm btn-danger ms-4" onclick="loginDetail('<?= $c_login->id; ?>')">Show</a></td>
																</tr>
																<tr>
																	<td><strong>Last Login: </strong> <?php if($c_login->last_login){ echo date('d-m-Y h:i A', strtotime($c_login->last_login)); }else{ echo 'N/A';};?></td>
																	<td><strong>Login IP: </strong> <?php echo $c_login->login_ip;?></td>
																</tr>
																<tr>
																	<td><strong>Created On: </strong> <?php echo date('d-m-Y h:i A', strtotime($c_login->created_at));?></td>
																	<td><strong>Last Updated: </strong> <?php echo date('d-m-Y h:i A', strtotime($c_login->updated_at));?></td>
																</tr>
																<tr>
																	<td><strong>Status: </strong> <?php echo ($c_login->status == 'active') ? '<span class="badge badge-pill badge-soft-success font-size-13">Active</span>' : '<span class="badge badge-pill badge-soft-danger font-size-13">Inactive</span>';?></td>
																	<td><strong>Created/Updated By: </strong> <?php echo $c_login->added_by_name;?></td>
																</tr>
															</table>
														</div>
													</div>
												</div>
											<?php } ?>
											<?php }else{
												echo '<h6>This feature only available when edit information, add user first</h6>';
											} ?>
										</div>
									</div>

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
<!--  Modal content for the above example -->
<div class="modal fade bs-address-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myAddressModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title mt-0" id="myAddressModalLabel">Add New Address</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<?php echo form_open("admin/business-user/submit-corporate-address", array("id"=>"bs-add-address", "enctype"=>"multipart/form-data", "class"=>"form-horizontal form-label-left")); ?>
					<div class="row">
						<input type="hidden" name="customer_id" value="<?= $id;?>" required="required" />
						<input type="hidden" name="address_id" value="" />
						<div class="col-md-6  mb-3 form-group">
							<label for="s_person_name">Contact Person Name <span class="required">*</span></label>
							<input type="text" class="form-control" id="s_person_name" name="person_name" required="required" />
						</div>
						<div class="col-md-6  mb-3 form-group">
							<label for="s_mobile">Mobile <span class="required">*</span></label>
							<input type="text" class="form-control mobile" id="s_mobile" name="mobile" maxlength="15" required="required" />
						</div>
						<div class="col-md-6  mb-3 form-group">
							<label for="s_phone">Phone </label>
							<input type="text" class="form-control" id="s_phone" name="phone" maxlength="15" />
						</div>
						<div class="col-md-6  mb-3 form-group">
							<label for="s_extension">Extension </label>
							<input type="text" class="form-control" id="s_extension" name="extension" maxlength="255" />
						</div>
						<div class="col-md-6  mb-3 form-group">
							<label for="s_email">Email <span class="required">*</span></label>
							<input type="email" class="form-control" id="s_email" name="email" maxlength="255" required="required" />
						</div>
						<div class="col-md-6  mb-3 form-group">
							<label for="s_reference">Reference </label>
							<input type="text" class="form-control" id="s_reference" name="reference" maxlength="255" />
						</div>
						<div class="col-md-12 mb-3 form-group">
							<label>Shipping Address <span class="text-danger">*</span></label>
							<div id="map"></div>
							<div id="infowindow-content">
							<img src="" width="16" height="16" id="place-icon" />
							<span id="place-name" class="title"></span><br />
							<span id="place-address"></span>
							</div>
							<div class="pac-card" id="pac-card">
								<div id="pac-container">
									<input id="pac-input" type="text" placeholder="Search location name" />
								</div>
							</div>
						</div>
						<div class="col-md-6  mb-3 form-group">
							<label for="s_country">Country <span class="required">*</span></label>
							<select id="s_country" name="country" class="form-control col-md-12 select2" required="required">
								<option value="">Selct Country</option>
								<option value="Saudi Arabia" <?php echo ($country == 'Saudi Arabia') ? "selected":"";?>>Saudi Arabia</option>
							</select>
						</div>
						<div class="col-md-6 mb-3 form-group">
							<label for="s_city">City <span class="required">*</span></label>
							<input type="text" class="form-control" id="s_city" name="city" value="" required="required" />
						</div>
						<div class="col-md-6  mb-3 form-group">
							<label for="s_street">Street <span class="required">*</span></label>
							<input type="text" class="form-control" id="s_street" name="street" value="" required="required" />
						</div>
						<div class="col-md-6  mb-3 form-group">
							<label for="s_postal">Postal <span class="required">*</span></label>
							<input type="text" class="form-control" id="s_postal" name="postal" value="" onkeypress="return numerics(event);" minlength="<?= ZIP_LENGTH; ?>" maxlength="<?= ZIP_LENGTH; ?>" required="required" />
						</div>
						<input type="hidden" id="s_state" name="state" value="" />
						<input type="hidden" id="s_sector" name="sector" value="" />
						<input type="hidden" id="s_locality" name="locality" value="" />
						<input type="hidden" id="s_lat" name="lat" value="" />
						<input type="hidden" id="s_lng" name="lng" value="" />
						<input type="hidden" id="s_place_id" name="place_id" value="" />
						<input type="hidden" id="s_complete_address" name="complete_address" value="" />
						<div class="col-md-6 mb-3 form-group">
							<label class="form-label">Select Address Type <span class="text-danger">*</span></label><br/>
							<div class="row">
								<div class="col-md-6">
									<input class="form-check-input" type="radio" name="house_type" id="house_type1" value="Villa">
									<label class="form-check-label" for="house_type1">Villa</label>
								</div>
								<div class="col-md-6">
									<input class="form-check-input" type="radio" name="house_type" id="house_type2" value="Building">
									<label class="form-check-label" for="house_type2">Building</label>
								</div>
							</div>
						</div>
						<div class="col-md-6 mb-3 form-group">
							<label class="form-label" id="villa_label">Villa No. <span class="text-danger">*</span></label>
							<input name="villa_building" type="text" class="form-control" required="required" />
						</div>
						<div class="mb-3 col-md-6 form-group">
							<label style="width:100%">Save as <span class="text-danger">*</span></label>
							<div class="row">
								<div class="col-md-4">
									<label class="radio-label active"> <input type="radio" class="form-check-input" value="Home" name="address_type" id="option1" checked /> Home</label>
								</div>
								<div class="col-md-4">
									<label class="radio-label"> <input type="radio" class="form-check-input" value="Work" name="address_type" id="option2" /> Work</label>
								</div>
								<div class="col-md-4">
									<label class="radio-label"> <input type="radio" class="form-check-input" value="Other" name="address_type" id="option3" /> Other</label>
								</div>
							</div>
						</div>

						<div class="col-md-12 mb-3">
							<button type="submit" class="btn btn-md btn-custom-success float-end" title="Save"> Save Address </button>
						</div>
					</div>
				<?php echo form_close(); ?>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade bs-edit-address-modal-lg" tabindex="-1" aria-labelledby="#editAddressModalLabel" style="display: none;" aria-hidden="true">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h6 class="modal-title mt-0" id="editAddressModalLabel">Edit Address</h6>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="window.location.reload();"></button>
			</div>
			<div class="modal-body">
				
			</div>
			<div class="modal-footer">
				<button type="button" onclick="window.location.reload();" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!---- Login User ----->
<div class="modal fade bs-login-modal" tabindex="-1" aria-labelledby="#loginModalLabel" style="display: none;" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h6 class="modal-title mt-0" id="loginModalLabel">Add/Edit User Login</h6>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="window.location.reload();"></button>
			</div>
			<div class="modal-body">
				
			</div>
			<div class="modal-footer">
				<button type="button" onclick="window.location.reload();" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php $this->load->view('admin/home/footer');?>

<script type="text/javascript">
	
	$(function(){
		var dtToday = new Date();
		
		var month = dtToday.getMonth() + 1;
		var day = dtToday.getDate();
		var year = dtToday.getFullYear();
	   
		$('#vat_expiry').attr('min', maxDate);
		$('#cr_expiry').attr('min', maxDate);
		$('#agrement_expiry').attr('min', maxDate);
	});
	
	$(document).ready(function() {
	    var region_id = "<?= ($region_id == '') ? 'NULL' : $region_id; ?>";
		//console.log(region_id);
	    selectedCity(region_id);
		
		var bank_region_id = "<?= ($region == '') ? 'NULL' : $region; ?>";
		//console.log(bank_region_id);
	    selectedBankCity(bank_region_id);
		
	});

	$(".mobile").on("keypress",function(e){
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
	
	function selectedCity(region_id){
		var add_city_id = "<?= ($city == '') ? 'NULL' : $city; ?>";
		//alert(region_id);
		if(region_id !== 'NULL'){
			$.ajax({
				url: "<?php echo base_url(); ?>admin/Corporate_user/getCities",
				type: "POST",
				data: {'parent':region_id},
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

	$('#region_id').change(function() {
		var parent = $(this).find('option:selected').data('id');
		$.ajax({
			url: "<?php echo base_url(); ?>admin/Corporate_user/getCities",
			data: {
				parent: parent
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
	
	/*---- Bank Account Script ---*/

	$('#region').change(function() {
		var bank_sel_region = $(this).find('option:selected').data('id');
		$.ajax({
			url: "<?php echo base_url(); ?>admin/Corporate_user/getCities",
			data: {
				parent: bank_sel_region
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
	
	function selectedBankCity(bank_region_id){
		var bank_city = "<?= ($bank_city == '') ? 'NULL' : $bank_city; ?>";
		//alert(bank_region_id);
		if(bank_region_id !== 'NULL'){
			$.ajax({
				url: "<?php echo base_url(); ?>admin/Corporate_user/getCities",
				type: "POST",
				data: {'parent':bank_region_id},
				dataType: "json",
				success: function(data){
					var html = '<option value="">Select City</option>';
			
					if (Object.keys(data).length > 0) {
						$.each(data, function(index, item) {
							var isSelected = (bank_city == item.id ? 'selected' : '');
							html += '<option value="' + item.id + '" data-id="' + item.id + '" ' + isSelected + '>' + item.city_name + '</option>';
						});
					} else {
						var html = '<option value="">No city found</option>';
					}
					$('#bank_city').html(html);
				},
				error: function(){}
			});
		}
	}

	function quickEditAddress(address_id){
		if(address_id > 0){
			//alert(address_id);
			$.ajax({
				type: "post",
				url: "<?php echo base_url();?>admin/business-user/edit-corporate-address",
				data: {'id': address_id},
				//dataType: "json",
				success: function (response) {
					//console.log(response);
					$('.bs-edit-address-modal-lg .modal-body').html(response);
					$(".bs-edit-address-modal-lg").modal('show');
				},
				error: function (request, error) {
					//console.log(" Can't do because: " + JSON.stringify(request));
					$('.bs-edit-address-modal-lg .modal-body').html(JSON.stringify(request));
					$(".bs-edit-address-modal-lg").modal('show');
				},
			});
		}else{
			alert('Invalid request id!');
		}
	}

	function quickLoginAdd(main_id){
		if(main_id > 0){
			//alert(main_id);
			$.ajax({
				type: "post",
				url: "<?php echo base_url();?>admin/business-user/corporate-login-add",
				data: {'main_id': main_id},
				//dataType: "json",
				success: function (response) {
					//console.log(response);
					$('.bs-login-modal .modal-body').html(response);
					$(".bs-login-modal").modal('show');
				},
				error: function (request, error) {
					//console.log(" Can't do because: " + JSON.stringify(request));
					$('.bs-login-modal .modal-body').html(JSON.stringify(request));
					$(".bs-login-modal").modal('show');
				},
			});
		}else{
			alert('Invalid request id!');
		}
	}

	function quickLoginEdit(login_id){
		if(login_id > 0){
			//alert(login_id);
			$.ajax({
				type: "post",
				url: "<?php echo base_url();?>admin/business-user/corporate-login-edit",
				data: {'login_id': login_id},
				//dataType: "json",
				success: function (response) {
					//console.log(response);
					$('.bs-login-modal .modal-body').html(response);
					$(".bs-login-modal").modal('show');
				},
				error: function (request, error) {
					//console.log(" Can't do because: " + JSON.stringify(request));
					$('.bs-login-modal .modal-body').html(JSON.stringify(request));
					$(".bs-login-modal").modal('show');
				},
			});
		}else{
			alert('Invalid request id!');
		}
	}

	function loginDetail(id){
		var login_id = id;
		// alert(store_id);
		$.ajax({
			type: "post",
			url: "<?php echo base_url();?>admin/business-user/corporate-login-detail",
			data: {'login_id': login_id},
			dataType: "json",
			success: function (response) {
				//console.log(response);
				$('#encyp_pass'+id).html(response.password);
			}
		});
	}

	$(document).on('click', ':not(form)[data-confirm]', function(e){
		if(!confirm($(this).data('confirm'))){
			e.stopImmediatePropagation();
			e.preventDefault();
		}
	});

	$('input:radio[name="house_type"]').change(function() {
		if ($(this).val() == 'Villa') {
			$('#villa_label').html('Villa No.');
		} else {
			$('#villa_label').html('Floor & Flat No.');
		}
	});
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCL2JAl_JhBNZHOOm34cEN0jZb_TfVORSk&callback=initMap&libraries=places&v=weekly" defer></script>
<script>
	// This example requires the Places library. Include the libraries=places
	// parameter when you first load the API. For example:

	function initMap() {

		const map = new google.maps.Map(document.getElementById("map"), {
		  center: { lat: 23.885942, lng: 45.079163 },
		  zoom: 13,
		});
		const card = document.getElementById("pac-card");
		const input = document.getElementById("pac-input");
		map.controls[google.maps.ControlPosition.TOP_RIGHT].push(card);
		const autocomplete = new google.maps.places.Autocomplete(input);
		// Bind the map's bounds (viewport) property to the autocomplete object,
		// so that the autocomplete requests use the current map bounds for the
		// bounds option in the request.
		autocomplete.bindTo("bounds", map);
		// Set the data fields to return when the user selects a place.
		autocomplete.setFields([
		  "address_components",
		  "formatted_address",
		  "geometry",
		  "place_id",
		  "icon",
		  "name",
		]);
		const infowindow = new google.maps.InfoWindow();
		const infowindowContent = document.getElementById("infowindow-content");
		infowindow.setContent(infowindowContent);
		const marker = new google.maps.Marker({
			map,
			anchorPoint: new google.maps.Point(0, -29),
		});
		autocomplete.addListener("place_changed", () => {
		  infowindow.close();
		  marker.setVisible(false);
		  const place = autocomplete.getPlace();
		  $('#s_street').val('');
		  if (!place.geometry) {
			// User entered the name of a Place that was not suggested and
			// pressed the Enter key, or the Place Details request failed.
			window.alert(
			  "No details available for input: '" + place.name + "'"
			);
			return;
		  }

		  // If the place has a geometry, then present it on a map.
		  if (place.geometry.viewport) {
			map.fitBounds(place.geometry.viewport);
		  } else {
			map.setCenter(place.geometry.location);
			map.setZoom(17); // Why 17? Because it looks good.
		  }
		  marker.setPosition(place.geometry.location);
		  marker.setVisible(true);
		  let address = "";

		  if(place.address_components) {
			populateCard(place);
			address = [
			  (place.address_components[0] &&
				place.address_components[0].short_name) ||
				"",
			  (place.address_components[1] &&
				place.address_components[1].short_name) ||
				"",
			  (place.address_components[2] &&
				place.address_components[2].short_name) ||
				"",
			].join(" ");
		  }
		  infowindowContent.children["place-icon"].src = place.icon;
		  infowindowContent.children["place-name"].textContent = place.name;
		  infowindowContent.children["place-address"].textContent = address;
		  infowindow.open(map, marker);
		});

		// Sets a listener on a radio button to change the filter type on Places
		// Autocomplete.
		function setupClickListener(id, types) {
		  const radioButton = document.getElementById(id);
		  radioButton.addEventListener("click", () => {
			autocomplete.setTypes(types);
		  });
		}
		setupClickListener("changetype-all", []);
		setupClickListener("changetype-address", ["address"]);
		setupClickListener("changetype-establishment", ["establishment"]);
		setupClickListener("changetype-geocode", ["geocode"]);
		document
		  .getElementById("use-strict-bounds")
		  .addEventListener("click", function () {
			console.log("Checkbox clicked! New state=" + this.checked);
			autocomplete.setOptions({ strictBounds: this.checked });
		  });
	}

	populateCard = (geoResults) => {
		// check if a the container has a child node to force re-render of dom
		//removeAddressCards();
		//console.log(geoResults.geometry.location.lat());
		$("#s_complete_address").val(geoResults.formatted_address);
		//$("#formated_addr").html(geoResults.formatted_address);

		$("#s_lat").val(geoResults.geometry.location.lat());
		$("#s_lng").val(geoResults.geometry.location.lng());

		//$("#location_type").html(geoResults[0].geometry.location_type);
		$("#s_place_id").val(geoResults.place_id);

		var component = geoResults.address_components;

		component.map(componentResult => {
			const types = componentResult.types
			//console.log(types.includes('administrative_area_level_2'));
			/*
			if (types.includes('premise')) {
				$('#house_no').val(componentResult.long_name);
			}*/
			if (types.includes('sublocality_level_2')) {
				$('#s_street').val(componentResult.long_name);
			}
			if (types.includes('sublocality_level_1')) {
				$('#s_sector').val(componentResult.long_name);
			}
			if (types.includes('locality')) {
				$('#s_city').val(componentResult.long_name);
			}
			if (types.includes('administrative_area_level_2')) {
				$('#s_locality').val(componentResult.long_name);
			}
			if (types.includes('administrative_area_level_1')) {
				$('#s_state').val(componentResult.long_name);
			}
			/*
			if (types.includes('country')) {
				$('#s_country').val(componentResult.long_name);
			}*/
			if (types.includes('postal_code')) {
				$('#s_postal').val(componentResult.long_name);
			}
		})

		/*
		geoResults.map(geoResult => {
		})*/
	}
</script>
