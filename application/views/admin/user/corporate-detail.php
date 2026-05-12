<?php $this->load->view('admin/home/header');?>
<style>
.table th, .table td {
    vertical-align: middle;
	padding: 6px 10px;
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
input, textarea, select, .select2, .form-check-input, .form-check-label{
    pointer-events: none;
}
.form-control {
	border: 1px solid #ededed !important;
}

.select2-container--default.select2-container--disabled .select2-selection--single {
    background-color: #fff !important;
    border-color: #eee !important;
}
input#wallet, input#remarks, select#credit_status, .modal input, .modal select{
	pointer-events: all;
	border: 1px solid #d6d6d6 !important;
}
.address-desc{
	width: 30%;
	vertical-align: top !important;
}
</style>
<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Corporate Client Details</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin');?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/business-user/list');?>">Corporate Client Management</a></li>
						<li class="breadcrumb-item active">Client's Detail</li>
					</ol>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<a class="btn btn-sm btn-custom-white pull-right me-2" title="Back" target="_blank" href="<?php echo base_url('admin/business-user/print-credit-application?id='.$id);?>"><i class="fa fa-print"></i> Print</a>
					<a class="btn btn-sm btn-custom-white pull-right" title="Back" href="<?php echo base_url('admin/business-user/list');?>"><i class="fa fa-reply"></i> Back</a>&nbsp;
					<?php if($role_id == '2'){?>
					<?php if($credit_account == '0'){?>
						<button type="button" class="btn btn-custom-danger btn-sm waves-effect waves-light pull-right" data-bs-toggle="modal" data-bs-target=".creditModal">Add Credit Account</button>
					<?php } }?>
				</div>
			</div>
		</div>
	</div>
 </div>
 <!-- end page title -->
 <?php
	$pending = 0;
	$delivered = 0;
	$canceled = 0;
	$total_revenue = 0;
	if(!empty($orders)){
		foreach($orders as $order){
			$orderStatus = $order->order_status_id;
			if($orderStatus == '1' || $orderStatus == '2' || $orderStatus == '4' || $orderStatus == '5'){
				$pending++;
			}
			if($orderStatus == '6'){
				$delivered++;
				$total_revenue += $order->order_total;
			}
			if($orderStatus == '3' || $orderStatus == '7' || $orderStatus == '8' || $orderStatus == '9'){
				$canceled++;
			}
		}
	}
?>
<div class="container-fluid">
	<div class="page-content-wrapper">
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-body">
						<div class="row">
							<div class="color-box bg-primary m-2 col-md-2 p-2 rounded text-center">
								<h6 class="my-2 text-white">Total Revenue</h6>
								<h4 class="my-2 text-white"><?php echo $total_revenue; ?></h4>
								<a class="my-2 text-white font-size-12" href="javascript:;">VIEW ALL</a>
							</div>
							<div class="color-box bg-success m-2 col-md-2 p-2 rounded text-center">
								<h6 class="my-2 text-white">Total Orders</h6>
								<h4 class="my-2 text-white"><?php echo count($orders); ?></h4>
								<a class="my-2 text-white font-size-12" href="<?php echo base_url('admin/user/orders?id='. $id); ?>" target="_blank">VIEW ALL</a>
							</div>
							<div class="color-box bg-info m-2 col-md-2 p-2 rounded text-center">
								<h6 class="my-2 text-white">Pending Orders</h6>
								<h4 class="my-2 text-white"><?php echo $pending ?></h4>
								<a class="my-2 text-white font-size-12" href="<?php echo base_url('admin/user/orders?id='. $id .'&status=1'); ?>" target="_blank">VIEW ALL</a>
							</div>
							<div class="color-box bg-warning m-2 col-md-2 p-2 rounded text-center">
								<h6 class="my-2 text-white">Completed Orders</h6>
								<h4 class="my-2 text-white"><?php echo $delivered ?></h4>
								<a class="my-2 text-white font-size-12" href="<?php echo base_url('admin/user/orders?id='. $id .'&status=6'); ?>" target="_blank">VIEW ALL</a>
							</div>
							<div class="color-box bg-danger m-2 col-md-2 p-2 rounded text-center">
								<h6 class="my-2 text-white">Cancel Orders</h6>
								<h4 class="my-2 text-white"><?php echo $canceled ?></h4>
								<a class="my-2 text-white font-size-12" href="<?php echo base_url('admin/user/orders?id='. $id .'&status=9'); ?>" target="_blank">VIEW ALL</a>
							</div>
							<?php if($role_id == '2'){?>
							<?php if($credit_account !== '0'){?>
							<?php if(!empty($credit_account_info)){?>
							<div class="color-box bg-primary m-2 col-md-2 p-2 rounded text-center">
								<h6 class="my-2 text-white">Available Credit</h6>
								<h4 class="my-2 text-white"><?php echo $credit_account_info->credit_avilable; ?></h4>
								<a class="my-2 text-white font-size-12" href="<?php echo base_url('admin/Credit_account/report?id='. $id); ?>" target="_blank">VIEW ALL</a>
							</div>
							<div class="color-box bg-success m-2 col-md-2 p-2 rounded text-center">
								<h6 class="my-2 text-white">Max. Credit Limit</h6>
								<h4 class="my-2 text-white"><?php echo $credit_account_info->max_credit_limit; ?></h4>
								<a class="my-2 text-white font-size-12" href="<?php echo base_url('admin/Credit_account/report?id='. $id); ?>" target="_blank">VIEW ALL</a>
							</div>
							<?php }}} ?>
						</div>
					</div>
				</div>
			</div> <!-- end col -->
			<div class="col-12">
				<div class="card">
					<div class="card-body">
						<h5 class="scheduler-border">Individual Client Details:</h5>
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
										<span class="d-none d-sm-block">Bank Account</span>
									</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" data-bs-toggle="tab" href="#messages1" role="tab">
										<span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
										<span class="d-none d-sm-block">Upload Documents</span>
									</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" data-bs-toggle="tab" href="#messages2" role="tab">
										<span class="d-block d-sm-none"><i class="far fa-credit-card"></i></span>
										<span class="d-none d-sm-block">Wallet/Credit</span>
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
									<div class="row size-inner-section p-2">
										<div class="col-md-3 col-sm-12 mb-3 form-group">
											<label for="customer_no">Client Account ID  <span class="required-field">*</span></label>
											<input type="text" class="form-control" id="customer_no" name="customer_no" maxlength="150" value="<?php echo $customer_no;?>" required readonly />
										</div>

										<div class="col-md-3 col-sm-12 mb-3 form-group">
											<label for="account_manager">Client Account Manager<span class="required-field">*</span></label>
											<select name="account_manager" class="form-control select2" required>
												<option value="">Select Account Manager</option>
												<?php foreach(employeeListHelper() as $employee_list){ ?>
												<option value="<?= $employee_list->id;?>" <?php echo ($employee_list->id == $account_manager) ? "selected":"";?>><?= $employee_list->name;?> - <?= $employee_list->position;?></option>
												<?php } ?>
											</select>
										</div>
										
										<div class="col-md-3 col-sm-12 mb-3 form-group">
											<label for="agreement_start">Agreement Start Date<span class="required-field">*</span></label>
											<input type="date" class="form-control" id="agreement_start" name="agreement_start" max="<?php echo date("Y-m-d"); ?>" value="<?php echo $agreement_start;?>" required />
											
										</div>

										<div class="col-md-3 col-sm-12 mb-3 form-group">
											<label for="agrement_expiry">Agreement Expiry<span class="required-field">*</span></label>
											<input type="date" class="form-control" id="agrement_expiry" name="agrement_expiry" min="<?php echo date("Y-m-d"); ?>" value="<?php echo $agrement_expiry;?>" required />
											
										</div>

										<div class="col-md-3 col-sm-12 mb-3 form-group">
											<label for="company_name">Full Legal Name (English)<span class="required-field">*</span></label>
											<input type="text" class="form-control" id="company_name" name="company_name" maxlength="150" value="<?php echo $company_name;?>" required />
											
										</div>

										<div class="col-md-3 col-sm-12 mb-3 form-group">
											<label for="company_arabic_name">Full Legal Name (Arabic)<span class="required-field">*</span></label>
											<input type="text" class="form-control rtl-input" id="company_arabic_name" name="company_arabic_name" maxlength="150" value="<?php echo $company_arabic_name;?>" required />
											
										</div>

										<div class="col-md-3 col-sm-12 mb-3 form-group">
											<label for="cr_no">CR Number <span class="required-field">*</span></label>
											<input type="text" class="form-control" id="cr_no" name="cr_no" minlength="<?= CR_LENGTH; ?>" maxlength="<?= CR_LENGTH; ?>" value="<?php echo $cr_no;?>" required />
											
										</div>

										<div class="col-md-3 col-sm-12 mb-3 form-group">
											<label for="cr_expiry">CR. Expiry </label>
											<input type="date" class="form-control" id="cr_expiry" name="cr_expiry" min="<?php echo date("Y-m-d"); ?>" value="<?php echo $cr_expiry;?>" />
											
										</div>

										<div class="col-md-3 col-sm-12 mb-3 form-group">
											<label for="vat_no">VAT Number <span class="required-field">*</span></label>
											<input type="text" class="form-control" id="vat_no" name="vat_no" value="<?php echo $vat_no;?>" minlength="<?= VAT_LENGTH; ?>" maxlength="<?= VAT_LENGTH; ?>" required />
											<p class="hint">Enter VAT Number for client</p>
										</div>

										<div class="col-md-3 col-sm-12 mb-3 form-group">
											<label for="vat_expiry">VAT Expiry</label>
											<input type="date" class="form-control" id="vat_expiry" name="vat_expiry" min="<?php echo date("Y-m-d"); ?>" value="<?php echo $vat_expiry;?>" />
											
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
											
										</div>
										
										<div class="col-md-3 col-sm-12 mb-3 form-group">
											<label for="mobile">Mobile Number <span class="required-field">*</span></label>
											<input type="text" class="form-control mobile" id="mobile" name="mobile" onkeypress="return numerics(event);" minlength="<?= MOB_LENGTH; ?>" maxlength="<?= MOB_LENGTH; ?>" value="<?php echo $mobile;?>" required />
										</div>

										<div class="col-md-3 col-sm-12 mb-3 form-group">
											<label for="client_telephone">Telephone Number <span class="required-field">*</span></label>
											<input type="text" class="form-control mobile" id="client_telephone" name="client_telephone" onkeypress="return numerics(event);" minlength="<?= MOB_LENGTH; ?>" maxlength="<?= MOB_LENGTH; ?>" value="<?php echo $client_telephone;?>" required />
											
										</div>

										<div class="col-md-3 col-sm-12 mb-3 form-group">
											<label for="client_fax">Fax Number <span class="required-field">*</span></label>
											<input type="text" class="form-control" id="client_fax" name="client_fax" onkeypress="return numerics(event);" minlength="<?= FAX_LENGTH; ?>" maxlength="<?= FAX_LENGTH; ?>" value="<?php echo $client_fax;?>" required />
											
										</div>

										<div class="col-md-3 col-sm-12 mb-3 form-group">
											<label for="email">Email </label>
											<input type="email" id="email" name="email" maxlength="<?= EMAIL_LENGTH; ?>" value="<?php echo $email;?>" class="form-control" required >
											
										</div>

										<div class="col-md-3 col-sm-12 mb-3 form-group">
											<label for="website">Website </label>
											<input type="text" class="form-control" id="website" name="website" value="<?php echo $website;?>" maxlength="120" />
											
										</div>

										<div class="col-md-3 col-sm-12 mb-3 form-group">
											<label for="status">Status<span class="required-field">*</span></label>
											<select name="status"  class="form-control" required>
												<option value="1" <?php echo ($status == '1') ? "selected":"";?>>Active</option>
												<option value="0" <?php echo ($status == '0') ? "selected":"";?>>Inactive</option>
												<option value="2" <?php echo ($status == '2') ? "selected":"";?>>Block</option>
											</select>
											
										</div>
										
									</div>

									<div class="row size-inner-section p-2">
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

									<div class="row size-inner-section p-2">
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
									<div class="row size-inner-section p-2">
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
											<input type="text" class="form-control" id="postal_code" name="postal_code" value="<?php echo $postal_code;?>" onkeypress="return numerics(event);" minlength="<?= ZIP_LENGTH; ?>" maxlength="<?= ZIP_LENGTH; ?>" />
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
									<div class="row size-inner-section p-2">
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
											<select id="bank_name" name="bank_name" class="form-control col-md-12 select2" disabled>
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
											<label for="region">Region <span class="required">*</span></label>
											<select id="region" name="region" class="form-control col-md-12 select2" disabled>
												<option value="">Select Region</option>
												<?php foreach($regions as $master_region){?>
												<option value="<?php echo $master_region->id;?>" data-id="<?php echo $master_region->id;?>" <?php echo ($region == $master_region->id) ? "selected":"";?>><?php echo $master_region->region_name;?></option>
												<?php } ?>
											</select>
										</div>
										
										<div class="col-md-4 mb-3 form-group">
											<label for="bank_city">City Name <span class="required">*</span></label>
											<select id="bank_city" name="bank_city" class="form-control col-md-12 select2" disabled>
												<option value="">Select Region First</option>
											</select>
										</div>

									</div>
								</div>

								<div class="tab-pane" id="messages1" role="tabpanel">
									<div class="row size-inner-section p-2">
										<h5 class="scheduler-border">Upload Documents</h5>
										<div class="col-md-4 mb-3 form-group">
											<label for="cr_certificate">Commercial Registration Certificate :</label><br>
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
											<label for="iban_certificate">IBAN Certificate :</label><br>
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
											<label for="owner_id">Owner ID :</label><br>
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
											<label for="credit_agreement">Credit Agreement :</label><br>
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
											<label for="authorization_copy">Authorization Copy :</label><br>
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
											<label for="authorize_person_id">Authorized Person ID :</label><br>
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
											<label for="vat_certificate">VAT Certificate :</label><br>
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
								
								<div class="tab-pane" id="messages2" role="tabpanel">
									<div class="row size-inner-section p-2">
										<h5 class="scheduler-border">Wallet/Credit Information</h5>
										<table id="example" class="table table-bordered">
    										<thead>
												<tr>
													<th>Wallet</th>
													<td>
														<h5>Available Balance: <?php echo $wallet;?> SAR</h5>
														<a href="<?php echo base_url().'admin/user/wallet_report?id='.$id; ?>" class="btn btn-primary btn-sm" style="float: right;margin-top: -27px;" target="_blank">view wallet report</a>
														<div class="row">
															<?php echo form_open("admin/user/update_wallet", array("id"=>"wallet_form"));?>
															<input type="hidden" name="uid" value="<?php echo $id;?>" required>
															<div class="form-group col-md-12">
																<label for="wallet">Wallet Amount</label>
																<input type="number" id="wallet" name="wallet" class="form-control" required />
															</div>
															<div class="form-group col-md-12">
																<label for="remarks">Remarks</label>
																<input type="text" id="remarks" name="remarks" maxlength="250" class="form-control" required />
															</div>
															<div class="col-md-12">
																<button type="submit" class="btn btn-success btn-sm btn-block float-end" style="margin-top: 10px;">Update</button>
															</div>
															<?php echo form_close(); ?>
														</div>
													</td>
												</tr>

												<tr><th>Credit A/C Status</th>
													<td>
														<?php
														if ($credit_account == '0') {
															echo '<span class="badge badge-pill badge-soft-primary font-size-13">Not Open Yet</span>';
														} else if ($credit_account == '1') {
															echo '<span class="badge badge-pill badge-soft-warning font-size-13">Not Active</span>';
														} else if ($credit_account == '2') {
															echo '<span class="badge badge-pill badge-soft-success font-size-13">Active</span>';
														} else {
															echo '<span class="badge badge-pill badge-soft-danger font-size-13">Suspended</span>';
														}
														?>
														<?php if($credit_account > 0){?>
														<div class="row mt-2">
															<p style="line-height: 10px;"><strong>Max. Credit Limit:</strong> <?php echo $credit_account_info->max_credit_limit;?></p>
															<p style="line-height: 10px;"><strong>Available Credit:</strong> <?php echo $credit_account_info->credit_avilable;?></p>
															<p style="line-height: 10px;"><strong>Overdue Days:</strong> <?php echo $credit_account_info->credit_days;?> Days</p>
															<?php echo form_open("admin/Credit_account/setStatus", array("id"=>"credit_form"));?>
															<input type="hidden" name="uid" value="<?php echo $id;?>" required>
															<div class="form-group col-md-4">
																<label for="credit_status">Credit Account Status</label>
																<select id="credit_status" name="credit_status" class="form-control">
																	<option value="1" <?php echo ($credit_account == '1') ? 'selected':''; ?>>Not Active</option>
																	<option value="2" <?php echo ($credit_account == '2') ? 'selected':''; ?>>Active</option>
																	<option value="3" <?php echo ($credit_account == '3') ? 'selected':''; ?>>Suspend</option>
																</select>
															</div>
															<div class="col-md-3">
																<button type="submit" class="btn btn-success btn-md btn-block" style="margin-top: 22px;">Update</button>
															</div>
															<?php echo form_close(); ?>
														</div>
														<?php } ?>
													</td>
												</tr>
											</thead>
										</table>
									</div>
								</div>

								<div class="tab-pane" id="address" role="tabpanel">
									<div class="row size-inner-section p-2">
										<h5 class="scheduler-border">Address Book:</h5>
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
																</h4>
															</td>
														</tr>
														<tr>
															<td class="address-desc"><strong>Contact Person: </strong><?php echo $c_addresses->person_name;?></td>
															<td class="address-desc"><strong>Mobile: </strong><?php echo $c_addresses->mobile;?></td>
															<td class="address-desc"><strong>Email: </strong><?php echo $c_addresses->email;?></td>
														</tr>
														<tr>
															<td class="address-desc"><strong>Country: </strong><?php echo $c_addresses->country;?></td>
															<td class="address-desc"><strong>State: </strong><?php echo $c_addresses->state;?></td>
															<td class="address-desc"><strong>City: </strong><?php echo $c_addresses->city;?></td>
														</tr>
														<tr>
															<td class="address-desc"><strong>Street: </strong><?php echo $c_addresses->street;?></td>
															<td class="address-desc"><strong>House Type: </strong><?php echo $c_addresses->address_type;?></td>
															<td class="address-desc"><strong><?php echo $c_addresses->address_type;?> No.: </strong><?php echo $c_addresses->building_villa_no;?></td>
														</tr>
														<tr>
															<td class="address-desc"><strong>Postal: </strong><?php echo $c_addresses->postal;?></td>
															<td class="address-desc"><strong>Latitude: </strong><?php echo $c_addresses->shipping_lat;?></td>
															<td class="address-desc"><strong>Longtitude: </strong><?php echo $c_addresses->shipping_lng;?></td>
														</tr>
														<tr>
															<td class="address-desc"><strong>Phone: </strong><?php echo $c_addresses->phone;?></td>
															<td class="address-desc"><strong>Extension: </strong><?php echo $c_addresses->extension;?></td>
															<td class="address-desc"><strong>Reference: </strong><?php echo $c_addresses->reference;?></td>
														</tr>
														<tr>
															<td class="address-desc"><strong>Added On: </strong><?php echo $c_addresses->created_at;?></td>
															<td class="address-desc"><strong>Last updated: </strong><?php echo $c_addresses->updated_at;?></td>
														</tr>
													</table>
												</div>
											</div>
										</div>
										<?php } ?>
										<?php }else{
											echo '<h6>No address added</h6>';
										} ?>
									</div>
								</div>

								<!---- User Logins ----->
								<div class="tab-pane" id="user_login" role="tabpanel">
									<div class="row size-inner-section p-2">
										<h5 class="scheduler-border">Users Login</h5>
										<hr>
										<?php foreach($corporate_logins as $c_login){?>
										<div class="col-sm-12 col-lg-12">
											<div class="card text-dark bg-light border">
												<div class="card-body">
													<table class="table border bg-white">
														<tr>
															<td colspan="3">
																<h4>
																	<?php echo $c_login->display_name;?> <?php echo ($c_login->login_role == 'main') ? '<span class="badge badge-pill badge-soft-primary font-size-13">Main</span>' : '<span class="badge badge-pill badge-soft-info font-size-13">Staff</span>';?>
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
															<td><strong>Password: </strong> <span id="encyp_pass<?= $c_login->id; ?>">**********</span> <button class="btn btn-sm btn-danger ms-4" onclick="loginDetail('<?= $c_login->id; ?>')">Show</button></td>
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

<div class="modal fade creditModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title mt-0">Credit Account Form</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
					
				</button>
			</div>
			<div class="modal-body">
				<div id="errmsg1"></div>
                <?php echo form_open("admin/Credit_account/add_credits", array("id"=>"submit_form"));?>
					<input type="hidden" id="uid" name="user_id" value="<?php echo $id;?>" required>
					<div class="row">
						<div class="form-group">
							<label for="max_credit_limit">Max Credit Limit <span class="text-danger">*</span></label>
							<input type="text" id="max_credit_limit" min="1" name="max_credit_limit" class="form-control" placeholder="Max credit limit in numbers" required />
						</div>
						<div class="form-group mt-2">
							<label for="credit_avilable">Credit Available <span class="text-danger">*</span></label>
							<input type="text" id="credit_avilable" min="1" name="credit_avilable" class="form-control" placeholder="Credit available in numbers" required="required" readonly />
						</div>
						<div class="form-group mt-2">
							<label for="credit_days">Credit Overdue Days <span class="text-danger">*</span> (No. of Days)</label>
							<input type="number" id="credit_days" min="1" max="99" name="credit_days" class="form-control" placeholder="Enter numeric value" required />
						</div>
						<!--
						<div class="form-group mt-2">
							<label>Status <span class="text-danger">*</span></label>
							<select name="status" class="form-control" required>
								<option value="1">Enable</option>
								<option value="0">Disable</option>
							</select>
						</div>
						-->
						<div class="form-group mt-2">
							<button type="submit" form="submit_form" class="btn btn-success btn-md btn-block float-end">Save</button>
						</div>
					</div>
				<?php echo form_close();?>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php $this->load->view('admin/home/footer');?>

<script>
$(document).ready(function() {
	var region_id = "<?= ($region_id == '') ? 'NULL' : $region_id; ?>";
	//console.log(region_id);
	selectedCity(region_id);
	
	var bank_region_id = "<?= ($region == '') ? 'NULL' : $region; ?>";
	//console.log(bank_region_id);
	selectedBankCity(bank_region_id);
	
});

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

$('#submit_form').on('submit', (function(e) {
	//alert('test');
	e.preventDefault();
	$.ajax({
		url: '<?php echo base_url();?>admin/Credit_account/add_credits',
		type: "POST",
		data:  new FormData(this),
		contentType: false,
		cache: false,
		processData:false,
		success: 
		//showResponse,
		function(data){
			//$result = JSON.stringify(data)
			//$(".cred_box").load(location.href);
			window.location.reload();
			$("#errmsg1").html(data).show();
		},
		error: function(data){
			//alert(JSON.stringify(data));
		}
	});
}));

$('#credit_form').on('submit', (function(e) {
	//alert('test');
	e.preventDefault();
	$.ajax({
		url: '<?php echo base_url();?>admin/Credit_account/setStatus',
		type: "POST",
		data:  new FormData(this),
		contentType: false,
		cache: false,
		processData:false,
		success: 
		//showResponse,
		function(data){
			//$result = JSON.stringify(data)
			//$(".cred_box").load(location.href);
			window.location.reload();
			$("#errmsg2").html(data).show();
		},
		error: function(data){
			//alert(JSON.stringify(data));
		}
	});
}));

$('#rewards_form').on('submit', (function(e) {
	//alert('test');
	e.preventDefault();
	$.ajax({
		url: '<?php echo base_url();?>admin/Corporate_user/update_rewards',
		type: "POST",
		data:  new FormData(this),
		contentType: false,
		cache: false,
		processData:false,
		success: 
		//showResponse,
		function(data){
			//$result = JSON.stringify(data)
			//$(".cred_box").load(location.href);
			window.location.reload();
			$("#errmsg2").html(data).show();
		},
		error: function(data){
			alert(JSON.stringify(data));
		}
	});
}));

$('#wallet_form').on('submit', (function(e) {
	//alert('test');
	e.preventDefault();
	$.ajax({
		url: '<?php echo base_url();?>admin/Corporate_user/update_wallet',
		type: "POST",
		data:  new FormData(this),
		contentType: false,
		cache: false,
		processData:false,
		success: 
		//showResponse,
		function(data){
			//$result = JSON.stringify(data)
			//$(".cred_box").load(location.href);
			window.location.reload();
			$("#errmsg2").html(data).show();
		},
		error: function(data){
			alert(JSON.stringify(data));
		}
	});
}));

$("#max_credit_limit").on('change keydown paste input', function(e){
    var max_credit_limit = $('#max_credit_limit').val();
	$('#credit_avilable').val(max_credit_limit);
});

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

</script>
