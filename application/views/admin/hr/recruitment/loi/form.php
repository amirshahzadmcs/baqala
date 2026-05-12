
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
					<h4>LOI Master</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/hr/recruitment/loi">LOI List</a></li>
						<li class="breadcrumb-item active">Create / Edit</li>
					</ol>
				</div>
			</div>
			<?php $admin_id = $this->session->userdata('admin_id');?>
			<div class="col-sm-6">
					<div class="float-end d-sm-block">
						<?php if ($this->customer->userd($admin_id)->role == "Admin") {?>
						<a class="btn btn-sm btn-custom pull-right" title="Back" href="<?php echo base_url(); ?>admin/hr/recruitment/loi"><i class="fa fa-reply"></i> Back</a>
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
			<?php echo form_open("admin/hr/recruitment/loi/submit", array("id" => "demo-form2", "enctype" => "multipart/form-data", "class" => "form-label-left", "data-parsley-validate" => "")); ?>
 			 <div class="row">
 			 	<div class="col-12">
 			 		<div class="card">
 			 			<div class="card-body">
							<input type="hidden" id="id" name="id" value="<?php echo $id; ?>" />

							<div class="row">
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="loi_no">LOI Number</label>
									<?php if(isset($loi_id->id)) { $new_id = $loi_id->id; } else { $new_id = 0; } ?>
									<?php $loi_new = date("Ym") . str_pad($new_id + 1, 4, 0, STR_PAD_LEFT);  ?> 
									<input type="text" class="form-control" id="loi_no" name="loi_no" maxlength="150" value="<?php echo !empty($loi_no) ? $loi_no : $loi_new; ?>" readonly />
									<p class="hint">LOI Number</p>
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="open_date">Open Date <span class="required-field">*</span></label>
									<input type="date" class="form-control" id="open_date" name="open_date" maxlength="150" value="<?php echo $open_date; ?>" required />
									<p class="hint">Enter LOI Open Date</p>
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="cv">CV Number</label>
									<select name="cv_no" id="cv" class="form-control select2" data-placeholder="Choose Position...">
										<option value="">select</option>
										<?php foreach($cvs as $cv) { ?>
											<option value="<?php echo $cv->id; ?>" <?php echo ($cv->id == $cv_no) ? 'selected' : '' ?>><?php echo $cv->cv_no; ?></option>
										<?php } ?>
									</select>
									<p class="hint">Select CV</p>
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
									<!-- <input type="text" name="position" id="position" class="form-control" value="<?php echo $position; ?>"> -->
									<select name="position" id="position" class="form-control select2" required data-placeholder="Choose Position...">
										<option value="">select</option>
										<?php foreach($positions as $pos) { ?>
											<option value="<?php echo $pos->name; ?>" <?php echo ($pos->name == $position) ? 'selected' : '' ?>><?php echo $pos->name; ?></option>
										<?php } ?>
									</select>
									<p class="hint">Select Position</p>
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="iqama_no">Iqama Number <span class="required-field">*</span></label>
									<input type="text" class="form-control" id="iqama_no" name="iqama_no" value="<?php echo $iqama_no; ?>" required />
									<p class="hint">Enter Iqama Number</p>
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="interview_date">Interview Date <span class="required-field">*</span></label>
									<input type="date" class="form-control" id="interview_date" name="interview_date" maxlength="150" value="<?php echo $interview_date; ?>" required />
									<p class="hint">Enter Interview Date</p>
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="joining_date">Joining Date <span class="required-field">*</span></label>
									<input type="date" class="form-control" id="joining_date" name="joining_date" maxlength="150" value="<?php echo $joining_date; ?>" required />
									<p class="hint">Enter Joining Date</p>
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="print_date">Print Date <span class="required-field">*</span></label>
									<input type="date" class="form-control" id="print_date" name="print_date" maxlength="150" value="<?php echo $print_date; ?>" required />
									<p class="hint">Enter Print Date</p>
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="valid_upto">Valid Upto <span class="required-field">*</span></label>
									<input type="date" class="form-control" id="valid_upto" name="valid_upto" maxlength="150" value="<?php echo $valid_upto; ?>" required />
									<p class="hint">Enter Valid Upto</p>
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

	$('#cv').on('change', function(){
		var id = $('#cv option:selected').val();
		// alert(id);
		$.ajax({
			url: "<?php echo base_url();?>admin/hr/recruitment/loi/getCvDetail",
			type: "GET",
			data: {"id" : id},
			success: function (response) {
				// console.log(JSON.parse(response));
				var data = JSON.parse(response);
				$('#name').val(data.name);
				$('#mobile').val(data.mobile);
				$('#iqama_no').val(data.iqama_no);
				$('#position').val(data.pos_name);
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
