<?php $this->load->view('agency/layout/header');?>

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
                            <h4>Manage Password</h4>
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="<?= base_url('hiring-agency');?>">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active">Change Password</li>
                            </ol>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="float-end d-none d-sm-block">
                            <a class="btn btn-sm btn-custom-white pull-right me-1" title="Back"
                                href="<?php echo base_url('hiring-agency');?>"><i class="fa fa-reply"></i> Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="container-fluid">
            <div class="page-content-wrapper">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
						<div class="card">
							<div class="card-body">
								<div class="row profile-sidebar">
									<!-- SIDEBAR USERPIC -->
									<div class="col-md-2 profile-userpic text-center">
										<img src="<?= base_url('store_assets/images/users/avatar.png'); ?>"
											class="img-responsive" alt="user" style="width: 100px;">
									</div>
									<!-- END SIDEBAR USERPIC -->
									<!-- SIDEBAR USER TITLE -->
									<div class="col-md-10 profile-usertitle">
										<div class="profile-usertitle-name">
											<h5 class="text-left mt-3"><?= ($result->agency_name !== '') ? $result->agency_name : 'N/A';?></h5>
										</div>
										<div class="profile-usertitle-job">
											<h6 class="text-left"><?= $result->user_id;?></h6>
										</div>
										<div class="profile-usertitle-job">
											<a href="<?php echo base_url('hiring-agency/change-password'); ?>" type="button" class="btn btn-info btn-sm me-2">Change Password</a>
											<a href="<?php echo base_url('hiring-agency/logout'); ?>" type="button" class="btn btn-danger btn-sm me-2">Logout</a>
										</div>
									</div>
									<!-- END SIDEBAR USER TITLE -->
								</div>
							</div>
						</div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="card p-3">
                            <div class="card-body" style="min-height: 506px;">
							<?php if(!empty($result)){?>
							<div class="row size-inner-section px-2 py-4">
								<h4 class="header-title">General Information</h4>
								<hr>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="agency_code">Agency Code </label>
									<input type="text" class="form-control" readonly id="agency_code" name="agency_code" maxlength="10" value="<?php echo !empty($result->agency_code) ? $result->agency_code : ''; ?>" readonly required />
								</div>
								
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<div class="mb-3">
										<label for="agency_name" class="form-label">Agency Name </label>
										<input type="text" class="form-control" readonly id="agency_name" name="agency_name" value="<?php echo $result->agency_name;?>" required>
										<div class="invalid-feedback">
											Please provide a agency name.
										</div>
									</div>
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<div class="mb-3">
										<label for="agency_name_ar" class="form-label">Agency Name (Arabic)</label>
										<input type="text" class="form-control rtl-input" id="agency_name_ar" name="agency_name_ar" value="<?php echo $result->agency_name_ar;?>" readonly required>
										<div class="invalid-feedback">
											Please provide a agency name in arabic.
										</div>
									</div>
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="country_id">Agency Country </label>
									<select name="country_id" id="country_id" class="form-control" readonly required>
										<option value="">Select Country</option>
										<?php foreach(nationalityList() as $nation) { ?>
											<option value="<?php echo $nation->name; ?>" <?php echo ($nation->name == $result->country_id) ? 'selected' : '' ?>><?php echo $nation->name; ?></option>
										<?php } ?>
									</select>
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<div class="mb-3">
										<label for="agency_city" class="form-label">Agency City </label>
										<input type="text" class="form-control" readonly id="agency_city" name="agency_city" value="<?php echo $result->agency_city;?>" required>
										<div class="invalid-feedback">
											Please provide a agency city.
										</div>
									</div>
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<div class="mb-3">
										<label for="office_licence_no" class="form-label">Office License No </label>
										<input type="text" class="form-control" readonly maxlength="55" id="office_licence_no" name="office_licence_no" value="<?php echo $result->office_licence_no;?>" required>
									</div>
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="agreement_s_date">Agreement Start Date</label>
									<input type="date" class="form-control" readonly id="agreement_s_date" name="agreement_s_date" min="<?php echo date("Y-m-d"); ?>" value="<?php echo $result->agreement_s_date;?>" />
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="agreement_e_date">Agreement End Date</label>
									<input type="date" class="form-control" readonly id="agreement_e_date" name="agreement_e_date" min="<?php echo date("Y-m-d"); ?>" value="<?php echo $result->agreement_e_date;?>" />
								</div>
								<div class="col-md-4">
									<div class="form-group mb-3">
										<label for="status-select" class="form-label">Status </label>
										<select class="form-control" name="status" id="status-select" readonly>
											<?php echo ($result->status == '1') ? '<option value="1" selected>Active</option>':'';?>
											<?php echo ($result->status == '2') ? '<option value="1" selected>Inactive</option>':'';?>
											<?php echo ($result->status == '3') ? '<option value="1" selected>Contract Expired</option>':'';?>
											<?php echo ($result->status == '4') ? '<option value="1" selected>Suspended</option>':'';?>
										</select>
									</div>
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="user_id">User ID </label>
									<input type="text" class="form-control" readonly onKeyPress="return Alpha(event);" id="user_id" name="user_id" maxlength="150" value="<?php echo !empty($result->user_id) ? $result->user_id : ''; ?>" readonly required />
								</div>
								
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<div class="form-group">
										<label for="upload_signed_contract">Signed Contract</label>
										<?php if(!empty($result->upload_signed_contract)){ ?><p><a type="button" class="btn btn-info" href="<?php echo base_url($result->upload_signed_contract); ?>" target="_blank">View File</a></p></small><?php } ?>
									</div>
								</div>
							</div>
							
							<div class="row size-inner-section px-2 py-4">
								<h4 class="header-title">Contact Details</h4>
								<hr>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="contact_person_1">Name </label>
									<input type="text" class="form-control" readonly onKeyPress="return Alpha(event);" id="contact_person_1" name="contact_person_1" value="<?php echo $result->contact_person_1;?>" maxlength="150" required />
									<p class="hint">Enter Person Name</p>
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="mobile_no_1">Mobile No. </label>
									<input type="text" onKeyPress="return numerics(event);" class="form-control" readonly id="mobile_no_1" name="mobile_no_1" value="<?php echo $result->mobile_no_1;?>" minlength="<?= MOB_LENGTH ;?>" maxlength="<?= MOB_LENGTH ;?>" required />
									<p class="hint">Enter Mobile Number</p>
								</div>
								
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="email_id_1">Email ID </label>
									<input type="email_id_1" class="form-control" readonly id="email_id_1" name="email_id_1" value="<?php echo $result->email_id_1;?>" required />
									<p class="hint">Enter Email</p>
								</div>
								
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="contact_person_2">Name</label>
									<input type="text" class="form-control" readonly onKeyPress="return Alpha(event);" id="contact_person_2" name="contact_person_2" value="<?php echo $result->contact_person_2;?>" maxlength="150" />
									<p class="hint">Enter Person Name</p>
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="mobile_no_2">Mobile No.</label>
									<input type="text" onKeyPress="return numerics(event);" class="form-control" readonly id="mobile_no_2" name="mobile_no_2" minlength="<?= MOB_LENGTH ;?>" maxlength="<?= MOB_LENGTH ;?>" value="<?php echo $result->mobile_no_2;?>" />
									<p class="hint">Enter Mobile Number</p>
								</div>
								
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="email_id_2">Email ID </label>
									<input type="email_id_2" class="form-control" readonly id="email_id_2" name="email_id_2" value="<?php echo $result->email_id_2;?>" />
									<p class="hint">Enter Email</p>
								</div>
							</div>
							<div class="row size-inner-section px-2 py-4">
								<h4 class="header-title">Bank Details</h4>
								<hr>
								<div class="col-md-4 mb-3 form-group">
									<label for="account_name">Account Holder Name </label>
									<input type="text" class="form-control" readonly id="account_name" name="account_name" maxlength="150" value="<?php echo $result->account_name;?>" />
								</div>
								<div class="col-md-4 mb-3 form-group">
									<label for="bank_name">Bank Name </label>
									<input type="text" class="form-control" readonly id="bank_name" name="bank_name" maxlength="150" value="<?php echo $result->bank_name;?>" />
								</div>
								<div class="col-md-4 mb-3 form-group">
									<label for="account_no">Bank Account No </label>
									<input type="text" class="form-control" readonly id="account_no" name="account_no" onkeypress="return numerics(event);" maxlength="<?= BANK_ACCOUNT; ?>" value="<?php echo $result->account_no;?>" />
								</div>
								<div class="col-md-4 mb-3 form-group">
									<label for="ifsc_code">IFSC Code </label>
									<input type="text" class="form-control" readonly id="ifsc_code" name="ifsc_code" value="<?php echo $result->ifsc_code;?>" />
								</div>
								<div class="col-md-4 mb-3 form-group">
									<label for="swift_code">Swift Code </label>
									<input type="text" class="form-control" readonly id="swift_code" name="swift_code" value="<?php echo $result->swift_code;?>" />
								</div>
								
								<div class="col-md-4 mb-3 form-group">
									<label for="bank_address">Bank Address </label>
									<input type="text" class="form-control" readonly id="bank_address" name="bank_address" maxlength="300" value="<?php echo $result->bank_address;?>" />
								</div>
							</div>
							<?php }else{ echo '<h5>No data found</h5>';} ?>
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
<?php $this->load->view('agency/layout/footer');?>
