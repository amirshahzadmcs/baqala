<?php $this->load->view('admin/home/header'); ?>

<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Employment Types</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/hr/master/employment-types">Employment Types</a></li>
						<li class="breadcrumb-item active">Create / Edit</li>
					</ol>
				</div>
			</div>
			<?php $admin_id = $this->session->userdata('admin_id'); ?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<?php if ($this->customer->userd($admin_id)->role == "Admin") { ?>
						<a class="btn btn-sm btn-custom pull-right" title="Back" href="<?php echo base_url(); ?>admin/hr/master/employment-types"><i class="fa fa-reply"></i> Back</a>
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
						<?php echo form_open("admin/hr/master/employment-types/submit", array("id" => "demo-form2", "enctype" => "multipart/form-data", "class" => "form-label-left", "data-parsley-validate" => "")); ?>
						<input type="hidden" id="id" name="id" value="<?php echo $id; ?>" />

						<div class="row">
							<div class="col-md-4 col-sm-12 mb-3 form-group">
								<label for="name">Employment Types <span class="required-field">*</span></label>
								<input type="text" class="form-control" id="name" name="name" maxlength="150" value="<?php echo $name; ?>" required />
							</div>
							<div class="col-md-4 col-sm-12 form-group mb-2">
								<label class="control-label" for="arabic_name">Employment Types (Arabic)</label>
								<input type="text" id="arabic_name" name="arabic_name" value="<?php echo $arabic_name; ?>" class="form-control rtl-input">
							</div>
							<div class="col-md-4 col-sm-12 form-group mb-3">
								<label for="status-select" class="form-label">Status</label>
								<select id="status-select" name="status" class="form-select" required>
									<option value="active" <?php echo ($status == 'active') ? "selected":"";?>>Active</option>
									<option value="inactive" <?php echo ($status == 'inactive') ? "selected":"";?>>Inactive</option>
								</select>
								<div class="invalid-feedback">
									Please provide a status.
								</div>
							</div>
							<div class="col-md-12 col-sm-12 form-group mb-2">
								<label class="control-label" for="description">Description</label>
								<textarea id="description" class="form-control" name="description" rows="3" placeholder="Write description here."><?php echo $description;?></textarea>
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

<?php $this->load->view('admin/home/footer'); ?>

<script type="text/javascript">
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
