
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
					<h4>LOUI Master</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/hr/recruitment/loui">LOUI List</a></li>
						<li class="breadcrumb-item active">Create / Edit</li>
					</ol>
				</div>
			</div>
			<?php $admin_id = $this->session->userdata('admin_id');?>
			<div class="col-sm-6">
					<div class="float-end d-sm-block">
						<?php if ($this->customer->userd($admin_id)->role == "Admin") {?>
						<a class="btn btn-sm btn-custom pull-right" title="Back" href="<?php echo base_url(); ?>admin/hr/recruitment/loui"><i class="fa fa-reply"></i> Back</a>
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
			<?php echo form_open("admin/hr/recruitment/loui/submit", array("id" => "demo-form2", "enctype" => "multipart/form-data", "class" => "form-label-left", "data-parsley-validate" => "")); ?>
 			 <div class="row">
 			 	<div class="col-12">
 			 		<div class="card">
 			 			<div class="card-body">
							<input type="hidden" id="id" name="id" value="<?php echo $id; ?>" />

							<div class="row">
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="loui_no">LOUI Number</label>
									<?php if(isset($loui_id->id)) { $new_id = $loui_id->id; } else { $new_id = 0; } ?>
									<?php $loui_new = date("Ym") . str_pad($new_id + 1, 4, 0, STR_PAD_LEFT); ?> 
									<input type="text" class="form-control" id="loui_no" name="loui_no" maxlength="150" value="<?php echo !empty($loui_no) ? $loui_no : $loui_new; ?>" readonly />
									<p class="hint">LOUI Number</p>
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="open_date">Open Date <span class="required-field">*</span></label>
									<input type="date" class="form-control" id="open_date" name="open_date" maxlength="150" value="<?php echo $open_date; ?>" required />
									<p class="hint">Enter LOUI Open Date</p>
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="loi">LOI Number</label>
									<select name="loi_no" id="loi" class="form-control select2" data-placeholder="Choose Position...">
										<option value="">select</option>
										<?php foreach($lois as $loi) { ?>
											<option value="<?php echo $loi->id; ?>" <?php echo ($loi->id == $loi_no) ? 'selected' : '' ?>><?php echo $loi->loi_no; ?></option>
										<?php } ?>
									</select>
									<p class="hint">Select LOI</p>
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="cv">CV Number</label>
									<input type="text" name="cv_no" id="cv_no" class="form-control" value="<?php echo $cv_no; ?>">
									<!-- <select name="cv_no" id="cv" class="form-control select2" data-placeholder="Choose Position...">
										<option value="">select</option>
										<?php foreach($cvs as $cv) { ?>
											<option value="<?php echo $cv->id; ?>" <?php //echo ($cv->id == $cv_no) ? 'selected' : '' ?>><?php echo $cv->cv_no; ?></option>
										<?php } ?>
									</select> -->
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
									<label for="iqama_no">Iqama Number <span class="required-field">*</span></label>
									<input type="text" class="form-control" id="iqama_no" name="iqama_no" value="<?php echo $iqama_no; ?>" required />
									<p class="hint">Enter Iqama Number</p>
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="print_date">LOI Print Date <span class="required-field">*</span></label>
									<input type="date" class="form-control" id="print_date" name="print_date" maxlength="150" value="<?php echo $print_date; ?>" required />
									<p class="hint">Enter Print Date</p>
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="valid_upto">LOI Valid Upto Date <span class="required-field">*</span></label>
									<input type="date" class="form-control" id="valid_upto" name="valid_upto" maxlength="150" value="<?php echo $valid_upto; ?>" required />
									<p class="hint">Enter Valid Upto</p>
								</div>
								
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="begin_date">Begin Date <span class="required-field">*</span></label>
									<input type="date" class="form-control" id="begin_date" name="begin_date" maxlength="150" value="<?php echo $begin_date; ?>" required />
									<p class="hint">Enter Begin Date</p>
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="end_date">End Date <span class="required-field">*</span></label>
									<input type="date" class="form-control" id="end_date" name="end_date" maxlength="150" value="<?php echo $end_date; ?>" required />
									<p class="hint">Enter End Date</p>
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="employer_name">Employer Name <span class="required-field">*</span></label>
									<input type="text" name="employer_name" id="employer_name" class="form-control" value="<?php echo $employer_name; ?>">
									<p class="hint">Enter Employer Name</p>
								</div>
								<div class="col-md-4 col-sm-12 mb-2 form-group">
									<label for="employer_position">Employer Position <span class="required-field">*</span></label>
									<input type="text" name="employer_position" id="employer_position" class="form-control" value="<?php echo $employer_position; ?>">
									<p class="hint">Enter Employer Position</p>
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

	$('#loi').on('change', function(){
		var id = $('#loi option:selected').val();
		// alert(id);
		$.ajax({
			url: "<?php echo base_url();?>admin/hr/recruitment/loui/getLoiDetail",
			type: "GET",
			data: {"id" : id},
			success: function (response) {
				// console.log(JSON.parse(response));
				var data = JSON.parse(response);
				$('#name').val(data.name);
				$('#mobile').val(data.mobile);
				$('#iqama_no').val(data.iqama_no);
				$('#cv_no').val(data.cv_num);
				$('#position').val(data.position);
				$('#print_date').val(data.print_date);
				// $('#open_date').val(data.open_date);
				$('#valid_upto').val(data.valid_upto);
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
