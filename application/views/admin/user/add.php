<?php $this->load->view('admin/home/header');?>
<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Add New Client</h4>
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
					
					<?php } ?>
					<a class="btn btn-sm btn-custom-white pull-right" title="Back" href="<?php echo base_url('admin/user/list');?>"><i class="fa fa-reply"></i> Back</a>
					
					&nbsp;
					<button form="bs-form2" type="submit" class="btn btn-sm btn-custom-success pull-right" title="Save"><i class="fa fa-save"></i> Save</button>
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
		 				<h5 class="scheduler-border">Individual Client:</h5>
						<?php echo form_open("admin/user/submit-form", array("id"=>"bs-form2", "enctype"=>"multipart/form-data", "class"=>"form-horizontal form-label-left")); ?>
							<input type="hidden" id="id" name="id" value="<?php echo $id;?>">
							<input type="hidden" id="role_id" name="role_id" value="1">
							
							<div class="row">
								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="name">Client Name <span class="required-field">*</span></label>
									<input type="text" class="form-control" id="name" name="name" onKeyPress="return Alpha(event);" maxlength="150" value="<?php echo $name;?>" required />
									<p class="hint">Enter display name for client</p>
								</div>
								
								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="mobile">Mobile Number <span class="required-field">*</span></label>
									<input type="text" class="form-control" id="mobile" name="mobile" onkeypress="return numerics(event);" minlength="10" maxlength="10" value="<?php echo $mobile;?>" required />
									<p class="hint">Format 651 234 5678</p>
								</div>
								
								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="email">Email <span class="required-field">*</span></label>
									<input type="email" id="email" name="email" maxlength="198" value="<?php echo $email;?>" class="form-control" required <?php if($id !== ''){ echo 'readonly';}?> >
									<p class="hint">Enter email address for client</p>
								</div>

								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="status">Status<span class="required-field">*</span></label>
									<select name="status" class="form-control">
										<option value="1" <?php echo ($status == '1') ? "selected":"";?>>Active</option>
										<option value="0" <?php echo ($status == '0') ? "selected":"";?>>Inactive</option>
										<option value="2" <?php echo ($status == '2') ? "selected":"";?>>Block</option>
									</select>
									<p class="hint">Set status for your client</p>
								</div>
								
								<?php if($id == ''){?>
								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="password">Set password <span class="required-field">*</span></label>
									<input type="password" class="form-control" id="password" name="password" maxlength="120" required />
									<p class="hint">Enter password for client</p>
								</div>
								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="confirm_password">Confirm password <span class="required-field">*</span></label>
									<input type="password" class="form-control" id="confirm_password" name="confirm_password" maxlength="120" required />
									<p class="hint">Enter confirm password for client</p>
								</div>
							</div>
							<?php } ?>
						<?php echo form_close(); ?>
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
</script>
