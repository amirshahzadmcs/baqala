
<?php $this->load->view('admin/home/header');?>

<style>
	.required-field{
		color: #f00;
	}
</style>
<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Sim Card Master</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/hr/recruitment/sim-card">Sim Card List</a></li>
						<li class="breadcrumb-item active">Create / Edit</li>
					</ol>
				</div>
			</div>
			<?php $admin_id = $this->session->userdata('admin_id');?>
			<div class="col-sm-6">
					<div class="float-end d-sm-block">
						<?php if ($this->customer->userd($admin_id)->role == "Admin") {?>
						<a class="btn btn-sm btn-custom pull-right" title="Back" href="<?php echo base_url(); ?>admin/hr/recruitment/sim-card"><i class="fa fa-reply"></i> Back</a>
						<?php }?>
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
					<!-- <div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="close">x</button><?php //echo $msg_data; ?></div> -->
					<?php } else {?>
					<div class="alert alert-info alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;top:90px;width:50%;" role="alert">
							<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
							<strong><?php echo $msg_data; ?></strong>
					</div>
					<!-- <div class="alert alert-info"><button type="button" class="close" data-dismiss="alert" aria-label="close">x</button><?php //echo $msg_data;?></div> -->
					<?php }}
$this->admin->removeInfo();?>
				</div>
		</div>
	</div>
</div>
 <!-- end page title -->


  <div class="container-fluid">
  		<div class="page-content-wrapper">
			<?php echo form_open("admin/hr/recruitment/sim-card/submit", array("id" => "demo-form2", "enctype" => "multipart/form-data", "class" => "form-label-left", "data-parsley-validate" => "")); ?>
 			 <div class="row">
 			 	<div class="col-12">
 			 		<div class="card">
 			 			<div class="card-body">
							<input type="hidden" id="id" name="id" value="<?php echo $id; ?>" />

							<div class="row">
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="ref_no">Ref No <span class="required-field">*</span></label>
									<input type="text" class="form-control" id="ref_no" name="ref_no" maxlength="150" value="<?php echo $ref_no; ?>" required />
									<p class="hint">Enter Ref No</p>
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="ref_date">Ref Date <span class="required-field">*</span></label>
									<input type="date" class="form-control" id="ref_date" name="ref_date" maxlength="150" value="<?php echo $ref_date; ?>" required />
									<p class="hint">Enter Ref Date</p>
								</div>
								
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="emp_no">Employee Number <span class="required-field">*</span></label>
									<!-- <input type="text" name="cv_no" id="cv_no" class="form-control" value="<?php echo $cv_no; ?>"> -->
									<select name="emp_no" id="emp_no" class="form-control select2" required data-placeholder="Choose Position...">
										<option value="">select</option>
										<?php foreach($employees as $cv) { ?>
											<option value="<?php echo $cv->id; ?>" <?php echo ($cv->id == $emp_no) ? 'selected' : '' ?>><?php echo $cv->emp_no; ?></option>
										<?php } ?>
									</select>
									<p class="hint">Select Employee</p>
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="name">Name <span class="required-field">*</span></label>
									<input type="text" class="form-control" onKeyPress="return Alpha(event);" id="name" name="name" maxlength="150" value="<?php echo $name; ?>" required />
									<p class="hint">Enter Employee Name</p>
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="mobile">Mobile <span class="required-field">*</span></label>
									<input type="text" onKeyPress="return numerics(event);" class="form-control" id="mobile" name="mobile" value="<?php echo $mobile; ?>" required />
									<p class="hint">Enter Mobile Number</p>
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="position">Position <span class="required-field">*</span></label>
									<input type="text" name="position" id="position" class="form-control" value="<?php echo $position; ?>">
									<!-- <select name="position" id="position" class="form-control select2" required data-placeholder="Choose Position...">
										<option value="">select</option>
										<?php foreach($positions as $pos) { ?>
											<option value="<?php echo $pos->id; ?>" <?php //echo ($pos->id == $position) ? 'selected' : '' ?>><?php echo $pos->name; ?></option>
										<?php } ?>
									</select> -->
									<p class="hint">Select Position</p>
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="joining_date">Joining Date <span class="required-field">*</span></label>
									<input type="date" class="form-control" id="joining_date" name="joining_date" value="<?php echo $joining_date; ?>" required />
									<p class="hint">Enter Joining Date</p>
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="location">Location <span class="required-field">*</span></label>
									<input type="text" class="form-control" id="location" name="location" value="<?php echo $location; ?>" required />
									<p class="hint">Enter Location</p>
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="fname">Father Name <span class="required-field">*</span></label>
									<input type="text" class="form-control" id="fname" name="fname" value="<?php echo $fname; ?>" required />
									<p class="hint">Enter Father Name</p>
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="network">Network <span class="required-field">*</span></label>
									<select name="network" id="network" class="form-control select2" required data-placeholder="Choose Position...">
										<option value="">select</option>
										<?php foreach($networks as $pos) { ?>
											<option value="<?php echo $pos->id; ?>" <?php echo ($pos->id == $network) ? 'selected' : '' ?>><?php echo $pos->network_name; ?></option>
										<?php } ?>
									</select>
									<p class="hint">Select Network</p>
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="sim_no">Sim <span class="required-field">*</span></label>
									<select name="sim_no" id="sim_no" class="form-control select2" required data-placeholder="Choose Position...">
										<option value="">select</option>
										<?php foreach($sims as $sim) { ?>
											<option value="<?php echo $pos->id; ?>" <?php echo ($sim->id == $sim_no) ? 'selected' : '' ?>><?php echo $sim->sim_no .' ('.$sim->mobile.')'; ?></option>
										<?php } ?>
									</select>
									<p class="hint">Select Sim</p>
								</div>
							</div>
 			 			</div>
 			 		</div>
 			 	</div> <!-- end col -->
 			 </div> <!-- end row -->
			<?php echo form_close(); ?>
  		</div>
  </div>
  <!-- container-fluid -->




<div class="col-md-12 col-sm-12 col-xs-12">

	<div class="x_panel">
		<div class="x_content">

		</div>
	</div>
</div>
<?php $this->load->view('admin/home/footer');?>

<script type="text/javascript">

	$('#emp_no').on('change', function(){
		var id = $('#emp_no option:selected').val();
		// alert(id);
		$.ajax({
			url: "<?php echo base_url();?>admin/hr/recruitment/sim-card/getEmpDetail",
			type: "GET",
			data: {"id" : id},
			success: function (response) {
				console.log(response);
				var data = JSON.parse(response);
				$('#name').val(data.name);
				$('#mobile').val(data.mobile);
				$('#location').val(data.location);
				$('#joining_date').val(data.joining_date);
				$('#fname').val(data.fname);
				$('#position').val(data.position);
			},
			error: function (response) {
				console.log(response);
				// alert(response);
				// location.reload();
			},
		});
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
