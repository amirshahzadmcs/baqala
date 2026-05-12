<?php $this->load->view('admin/home/header');?>
<style>
input, select, textarea{
	pointer-events: none;
}
.change-password-modal input, .change-password-modal select, .change-password-modal textarea{
	pointer-events: all;
}
</style>
<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Manage Master Agency</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin');?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="javascript: void(0);">Master Agency</a></li>
						<li class="breadcrumb-item active">Detail</li>
					</ol>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="float-end d-none d-sm-block">
					<a class="btn btn-sm btn-custom-white pull-right me-1" title="Back" href="<?php echo base_url('admin/hr/master/agency/list');?>"><i class="fa fa-reply"></i> Back</a>
				</div>
				<?php $this->load->view('admin/partials/message');?>
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
					<?php if(!empty($result)){?>
						<div class="row size-inner-section px-2 py-4">
							<h4 class="header-title">General Information</h4>
							<hr>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="agency_code">Agency Code <span class="text-danger">*</span></label>
								<input type="text" class="form-control" id="agency_code" name="agency_code" maxlength="10" value="<?php echo !empty($result->agency_code) ? $result->agency_code : ''; ?>" readonly required />
							</div>
							
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<div class="mb-3">
									<label for="agency_name" class="form-label">Agency Name <span class="text-danger">*</span></label>
									<input type="text" class="form-control" id="agency_name" name="agency_name" value="<?php echo $result->agency_name;?>" required>
									<div class="invalid-feedback">
										Please provide a agency name.
									</div>
								</div>
							</div>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<div class="mb-3">
									<label for="agency_name_ar" class="form-label">Agency Name (Arabic)</label>
									<input type="text" class="form-control rtl-input" id="agency_name_ar" name="agency_name_ar" value="<?php echo $result->agency_name_ar;?>" required>
									<div class="invalid-feedback">
										Please provide a agency name in arabic.
									</div>
								</div>
							</div>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="country_id">Agency Country <span class="text-danger">*</span></label>
								<select name="country_id" id="country_id" class="form-control" required>
									<option value="">Select Country</option>
									<?php foreach(masterCountries() as $nation) { ?>
										<option value="<?php echo $nation->id; ?>" <?php echo ($nation->id == $result->country_id) ? 'selected' : '' ?>><?php echo $nation->name; ?></option>
									<?php } ?>
								</select>
							</div>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<div class="mb-3">
									<label for="agency_city" class="form-label">Agency City <span class="text-danger">*</span></label>
									<input type="text" class="form-control" id="agency_city" name="agency_city" value="<?php echo $result->agency_city;?>" required>
									<div class="invalid-feedback">
										Please provide a agency city.
									</div>
								</div>
							</div>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<div class="mb-3">
									<label for="office_licence_no" class="form-label">Office License No <span class="text-danger">*</span></label>
									<input type="text" class="form-control" maxlength="55" id="office_licence_no" name="office_licence_no" value="<?php echo $result->office_licence_no;?>" required>
								</div>
							</div>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="agreement_s_date">Agreement Start Date</label>
								<input type="date" class="form-control" id="agreement_s_date" name="agreement_s_date" min="<?php echo date("Y-m-d"); ?>" value="<?php echo $result->agreement_s_date;?>" />
							</div>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="agreement_e_date">Agreement End Date</label>
								<input type="date" class="form-control" id="agreement_e_date" name="agreement_e_date" min="<?php echo date("Y-m-d"); ?>" value="<?php echo $result->agreement_e_date;?>" />
							</div>
							<div class="col-md-4">
								<div class="form-group mb-3">
									<label for="status-select" class="form-label">Status <span class="text-danger">*</span></label>
									<select class="form-select" name="status" id="status-select" required>
										<option value="">--- Select Status ---</option>
										<option value="1" <?php echo ($result->status == '1') ? "selected":"";?>>Active</option>
										<option value="2" <?php echo ($result->status == '2') ? "selected":"";?>>Inactive</option>
										<option value="3" <?php echo ($result->status == '3') ? "selected":"";?>>Contract Expired</option>
										<option value="4" <?php echo ($result->status == '4') ? "selected":"";?>>Suspended</option>
									</select>
								</div>
							</div>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="user_id">User ID <span class="text-danger">*</span></label>
								<input type="text" class="form-control" onKeyPress="return Alpha(event);" id="user_id" name="user_id" maxlength="150" value="<?php echo !empty($result->user_id) ? $result->user_id : ''; ?>" readonly required />
							</div>
							<div class="col-md-4 col-sm-12 mb-3 form-group">
								<label for="encyp_pass">Password <span class="text-danger">*</span></label>
								<div class="input-group bootstrap-touchspin bootstrap-touchspin-injected">
									<input type="text" id="encyp_pass" value="**************" class="form-control">
									<span class="input-group-btn input-group-append">
										<button class="btn btn-warning bootstrap-touchspin-up password-show" type="button" data-id="<?= $result->id; ?>"><i class="fa fa-eye"></i></button>
									</span>
								</div>
								<small class="hint">Want to change password <button class="btn btn-link text-danger btn-sm" data-bs-toggle="modal" data-bs-target=".change-password-modal">Click Here</button></small>
							</div>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<div class="form-group">
									<label for="upload_signed_contract">Upload Signed Contract</label>
									<input type="file" class="form-control" id="upload_signed_contract" name="upload_signed_contract" />
									<input type="hidden" id="old_signed_contract" name="old_signed_contract" value="<?php echo $result->upload_signed_contract;?>" />
								</div>
								<?php if(!empty($result->upload_signed_contract)){ ?><p><a href="<?php echo base_url($result->upload_signed_contract); ?>" target="_blank">View File</a></p></small><?php } ?>
							</div>
						</div>
						
						<div class="row size-inner-section px-2 py-4">
							<h4 class="header-title">Contact Details</h4>
							<hr>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="contact_person_1">Name <span class="text-danger">*</span></label>
								<input type="text" class="form-control" onKeyPress="return Alpha(event);" id="contact_person_1" name="contact_person_1" value="<?php echo $result->contact_person_1;?>" maxlength="150" required />
								<p class="hint">Enter Person Name</p>
							</div>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="mobile_no_1">Mobile No. <span class="text-danger">*</span></label>
								<input type="text" onKeyPress="return numerics(event);" class="form-control" id="mobile_no_1" name="mobile_no_1" value="<?php echo $result->mobile_no_1;?>" minlength="<?= MOB_LENGTH ;?>" maxlength="<?= MOB_LENGTH ;?>" required />
								<p class="hint">Enter Mobile Number</p>
							</div>
							
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="email_id_1">Email ID <span class="text-danger">*</span></label>
								<input type="email_id_1" class="form-control" id="email_id_1" name="email_id_1" value="<?php echo $result->email_id_1;?>" required />
								<p class="hint">Enter Email</p>
							</div>
							
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="contact_person_2">Name</label>
								<input type="text" class="form-control" onKeyPress="return Alpha(event);" id="contact_person_2" name="contact_person_2" value="<?php echo $result->contact_person_2;?>" maxlength="150" />
								<p class="hint">Enter Person Name</p>
							</div>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="mobile_no_2">Mobile No.</label>
								<input type="text" onKeyPress="return numerics(event);" class="form-control" id="mobile_no_2" name="mobile_no_2" minlength="<?= MOB_LENGTH ;?>" maxlength="<?= MOB_LENGTH ;?>" value="<?php echo $result->mobile_no_2;?>" />
								<p class="hint">Enter Mobile Number</p>
							</div>
							
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="email_id_2">Email ID </label>
								<input type="email_id_2" class="form-control" id="email_id_2" name="email_id_2" value="<?php echo $result->email_id_2;?>" />
								<p class="hint">Enter Email</p>
							</div>
						</div>
						<div class="row size-inner-section px-2 py-4">
							<h4 class="header-title">Bank Details</h4>
							<hr>
							<div class="col-md-4 mb-3 form-group">
								<label for="account_name">Account Holder Name </label>
								<input type="text" class="form-control" id="account_name" name="account_name" maxlength="150" value="<?php echo $result->account_name;?>" />
							</div>
							<div class="col-md-4 mb-3 form-group">
								<label for="bank_name">Bank Name </label>
								<input type="text" class="form-control" id="bank_name" name="bank_name" maxlength="150" value="<?php echo $result->bank_name;?>" />
							</div>
							<div class="col-md-4 mb-3 form-group">
								<label for="account_no">Bank Account No </label>
								<input type="text" class="form-control" id="account_no" name="account_no" onkeypress="return numerics(event);" maxlength="<?= BANK_ACCOUNT; ?>" value="<?php echo $result->account_no;?>" />
							</div>
							<div class="col-md-4 mb-3 form-group">
								<label for="ifsc_code">IFSC Code </label>
								<input type="text" class="form-control" id="ifsc_code" name="ifsc_code" value="<?php echo $result->ifsc_code;?>" />
							</div>
							<div class="col-md-4 mb-3 form-group">
								<label for="swift_code">Swift Code </label>
								<input type="text" class="form-control" id="swift_code" name="swift_code" value="<?php echo $result->swift_code;?>" />
							</div>
							
							<div class="col-md-4 mb-3 form-group">
								<label for="bank_address">Bank Address </label>
								<input type="text" class="form-control" id="bank_address" name="bank_address" maxlength="300" value="<?php echo $result->bank_address;?>" />
							</div>
						</div>
						<?php }else{ echo '<h5>No data found</h5>';} ?>
					</div>
				</div>
			</div> <!-- end col -->
		</div> <!-- end row -->
	</div>
</div>
<!-- container-fluid -->
<?php $this->load->view('admin/home/footer');?>
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
				<form method="post" action="admin/hr/master/agency/change_password" id="password_form" data-parsley-validate="" class="form-horizontal">
					<input type="hidden" name="id" value="<?php echo $result->id?>" />
					<div class="col-md-12 col-sm-12 mb-3 form-group">
						<label for="password">New Password<span class="text-danger">*</span></label>
						<input type="password" id="password" name="password" required="required" class="form-control" minlength="6" maxlength="55" autocomplete="off" />
					</div>
					<div class="col-md-12 col-sm-12 mb-3 form-group">
						<label for="confirm_password">Confirm Password<span class="text-danger">*</span></label>
						<input type="password" id="confirm_password" name="confirm_password" required="required" class="form-control" minlength="6" maxlength="55" autocomplete="off" />
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
<script>
	$('.password-show').click(function() {
		var login_id = $(this).data('id');
		//alert(login_id);
		$.ajax({
			type: "post",
			url: "<?php echo base_url();?>admin/hr/master/hiring_agency/getLoginDetail",
			data: {'login_id': login_id},
			dataType: "json",
			success: function (response) {
				//console.log(response);
				$('#encyp_pass').val(response.password);
				//$('.password-show').html('<i class="fa fa-eye-slash"></i>');
			}
		});
	});

	$('#password_form').on('submit', (function(e) {
		//alert('test');
		e.preventDefault();
		$.ajax({
			url: '<?php echo base_url();?>admin/hr/master/hiring_agency/change_password',
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
				alert(data);
				$(".btn-close").click();
			},
			error: function(data){
				alert(JSON.stringify(data));
			}
		});
	}));
</script>
