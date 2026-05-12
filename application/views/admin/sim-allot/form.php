<?php $this->load->view('admin/home/header'); ?>
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
</style>
<div id="wait"><img src="<?= base_url('images/sample-loader.gif'); ?>" /><br>Loading..</div>

<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Allot Sim Card</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/allot-sim/list">Alloted Sim Card List</a></li>
						<li class="breadcrumb-item active">Create / Edit</li>
					</ol>
				</div>
			</div>
			<?php $admin_id = $this->session->userdata('admin_id'); ?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<?php if ($this->customer->userd($admin_id)->role == "Admin") { ?>
						<a class="btn btn-sm btn-custom pull-right" title="Back" href="<?php echo base_url(); ?>admin/allot-sim/list"><i class="fa fa-reply"></i> Back</a>
					<?php } ?>
					&nbsp;
					<button form="demo-form2" type="submit" class="btn btn-sm btn-custom-success pull-right" title="Save"><i class="fa fa-save"></i> Save</button>

				</div>
				<?php if ($this->admin->getInfo()) {
					$info = explode("--", $this->admin->getInfo());
					$info_type = $info[0];
					$msg_data = $info[1];
					if ($info_type == 2) {
				?>
						<div class="alert alert-danger alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;top:90px;width:50%;" role="alert">
							<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
							<strong><?php echo $msg_data; ?></strong>
						</div>
						<!-- <div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="close">x</button><?php //echo $msg_data; 
																																					?></div> -->
					<?php } else { ?>
						<div class="alert alert-info alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;top:90px;width:50%;" role="alert">
							<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
							<strong><?php echo $msg_data; ?></strong>
						</div>
						<!-- <div class="alert alert-info"><button type="button" class="close" data-dismiss="alert" aria-label="close">x</button><?php //echo $msg_data;
																																					?></div> -->
				<?php }
				}
				$this->admin->removeInfo(); ?>
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
						<?php echo form_open("admin/allot-sim/submit", array("id" => "demo-form2", "enctype" => "multipart/form-data", "class" => "form-label-left", "data-parsley-validate" => "")); ?>
						<input type="hidden" id="id" name="id" value="<?php echo $id; ?>" />

						<div class="row">
							<div class="col-md-6 col-sm-12 mb-3 form-group">
								<label for="allotment_date">Date Of Allotment <span class="required-field">*</span></label>
								<input type="date" class="form-control" id="allotment_date" name="allotment_date" maxlength="150" value="<?php echo $allotment_date; ?>" required />
								<p class="hint">Enter date of allotment of sim</p>
							</div>
							<div class="col-md-6 col-sm-12 mb-3 form-group">
								<label for="user_type">User Type<span class="required-field">*</span></label>
								<select name="user_type" class="form-control user_type select2" data-placeholder="Choose User...">
									<option value="">Select User</option>
									<option value="1" <?php echo ($user_type == '1') ? "selected" : "" ?>>Rider / Driver</option>
									<option value="0" <?php echo ($user_type == '0') ? "selected" : "" ?>>Employee</option>
								</select>
								<p class="hint">Set user type for sim allotment</p>
							</div>
							<div class="col-md-6 col-sm-12 mb-3 form-group">
								<label for="user_no">User <span class="required-field">*</span></label>
								<input type="hidden" name="table_name" id="table_name" value="<?php echo $table_name; ?>">
								<input type="hidden" name="position" id="position" value="<?php echo $position; ?>">
								<select name="user_no" class="form-control select2" id="user_no" data-placeholder="Choose User...">
									<option value="">-- select --</option>

								</select>
								<p class="hint">Select Rider to allot sim</p>
							</div>
							<div class="col-md-6 col-sm-12 mb-3 form-group">
								<label for="sim_no">Sim Card <span class="required-field">*</span></label>
								<!-- <input type="text" class="form-control" id="network" name="network" onKeyPress="return Alpha(event);" maxlength="150" value="" required /> -->
								<select name="sim_no" class="form-control select2" id="sim_no" data-placeholder="Choose Sim card...">
									<option value="">-- select --</option>
									<?php if (!empty($sim)) {
										foreach ($sim as $key => $item) { ?>
											<option value="<?php echo $sim[$key]->mobile; ?>" <?php echo ($item->mobile == $sim_no) ? 'selected' : ''; ?>><?php echo $sim[$key]->mobile; ?></option>
										<?php }
									} else { ?>
										<option value="" disabled>Add Rider First</option>
									<?php } ?>
								</select>
								<p class="hint">Select Rider to allot sim</p>
							</div>

							<div class="col-md-6 col-sm-12 mb-3 form-group">
								<label for="status">Allotment Status<span class="required-field">*</span></label>
								<select name="status" class="form-control">
									<option value="1" <?php echo ($status == '1') ? "selected" : "" ?>>Alloted</option>
									<option value="0" <?php echo ($status == '0') ? "selected" : "" ?>>Unlloted</option>
									<option value="2" <?php echo ($status == '2') ? "selected" : "" ?>>Return</option>
								</select>
								<p class="hint">Set status for your store</p>
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




<div class="col-md-12 col-sm-12 col-xs-12">

	<div class="x_panel">
		<div class="x_content">

		</div>
	</div>
</div>
<?php $this->load->view('admin/home/footer'); ?>

<script type="text/javascript">
	
	$(document).ready(function() {
		$(document).ajaxStart(function() {
			$("#wait").css("display", "block");
		});
		$(document).ajaxComplete(function() {
			$("#wait").css("display", "none");
		});
		$(document).ajaxError(function() {
			$("#wait").css("display", "none");
		});
	});

	$(function() {
		var dtToday = new Date();

		var month = dtToday.getMonth() + 1;
		var day = dtToday.getDate();
		var year = dtToday.getFullYear();

		$('#vat_expiry').attr('min', maxDate);
		$('#cr_expiry').attr('min', maxDate);
		$('#agrement_expiry').attr('min', maxDate);
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

	$(document).ready(function() {
		var val = '<?php echo $user_type; ?>';
		var user_no = '<?php echo $user_no; ?>';
		$('#table_name').val('');
		// alert(val);
		$.ajax({
			url: "<?php echo base_url() ?>admin/Sim_allot/getuser",
			data: {
				"id": val,
				"user_no": user_no
			},
			//dataType:"html",
			type: "get",
			success: function(data) {
				if (val === '1') {
					var data = JSON.parse(data);
					$('#user_no').html(data);
					$('#table_name').val('delivery_vehicles');
				} else {
					var data = JSON.parse(data);
					$('#user_no').html(data);
					$('#table_name').val('master_employee');
				}
				// $('#plan').append(data);
				// console.log(data);
			},
			error: function(response) {
				console.log(response);
			}
		});
	});

	$('.user_type').on('change', function() {
		var val = $('.user_type option:selected').val();
		var user_no = '<?php echo $user_no; ?>';
		$('#table_name').val('');
		// alert(val);
		$.ajax({
			url: "<?php echo base_url() ?>admin/Sim_allot/getuser",
			data: {
				"id": val,
				"user_no": user_no
			},
			//dataType:"html",
			type: "get",
			success: function(data) {
				if (val === '1') {
					var data = JSON.parse(data);
					$('#user_no').html(data);
					$('#table_name').val('delivery_vehicles');
				} else {
					var data = JSON.parse(data);
					$('#user_no').html(data);
					$('#table_name').val('master_employee');
				}
				// $('#plan').append(data);
				// console.log(data);
			},
			error: function(response) {
				console.log(response);
			}
		});
	});

	$('#user_no').on('change', function() {
		$('#position').val('');
		var pos = $('#user_no option:selected').data('position');
		// alert(pos);
		$('#position').val(pos);
	});
</script>
