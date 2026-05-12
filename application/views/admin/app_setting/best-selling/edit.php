<?php $this->load->view('admin/home/header');?>

<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Best Selling Categories</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin');?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/app-setting/dasboard');?>">App Setting</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/app/best-selling/list');?>">Best Selling Categories</a></li>
						<li class="breadcrumb-item active">Edit</li>
					</ol>
				</div>
			</div>
			<?php  $admin_id= $this->session->userdata('admin_id'); ?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<a class="btn btn-sm btn-custom-white pull-right me-2" title="Back" href="<?php echo base_url('admin/app/best-selling/list');?>"><i class="fa fa-reply"></i> Back</a>
					<button form="bannerForm" type="submit" class="btn btn-sm btn-custom-success pull-right" title="Save"><i class="fa fa-save"></i> Save</button>
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
						<?php echo form_open("admin/app/best-selling/update", array("id"=>"bannerForm", "enctype"=>"multipart/form-data", "class"=>"form-label-left", "data-parsley-validate"=> "")); ?>
							<input type="hidden" name="id" value="<?= $id; ?>" required />
							<div class="row">	
								<div class="col-md-6 mb-3 form-group">
									<label for="group_name">Group Name <span class="text-danger">*</span> (English)</label>
									<input type="text" class="form-control" id="group_name" name="group_name" value="<?php echo $group_name; ?>" maxlength="255" required />
								</div>
                                <div class="col-md-6 mb-3 form-group">
									<label for="group_name_arabic" class="float-end">Group Name (Arabic)</label>
									<input type="text" class="form-control rtl-input" id="group_name_arabic" name="group_name_arabic" value="<?php echo $group_name_arabic; ?>" maxlength="255" />
								</div>
								<div class="col-md-6 mb-3 form-group">
									<label class="control-label" for="category_id">Select Categories (<span class="text-info">Add max. 4 categories in a group</span>)</label>
									<select name="category_id[]" id="category_id" class="select2 form-control select2-multiple" multiple="multiple" data-placeholder="Choose Categories" required>
										<?php
										$catArray = explode(',',$category_id);
										foreach($categories as $category){?>
										<option value="<?php echo $category['id'];?>" <?php echo (in_array($category['id'], $catArray)) ? "selected":"";?>><?php echo $category['name'];?></option>
										<?php foreach($category['child'] as $child){?>
										<option value="<?php echo $child['id'];?>" <?php echo (in_array($child['id'], $catArray)) ? "selected":"";?>><?php echo $category['name'] . " > " . $child['name'];?></option>
										<?php foreach($child['child'] as $sub){?>
										<option value="<?php echo $sub['id'];?>" <?php echo (in_array($sub['id'], $catArray)) ? "selected":"";?>><?php echo $category['name'] . " > " . $child['name'] . " > " . $sub['name'];?></option>
										<?php }}}?>
									</select>
								</div>

								<div class="col-md-6 mb-3 form-group">
									<label for="sort_order">Sort Order <span class="text-danger">*</span></label>
									<input type="text" class="form-control" id="sort_order" name="sort_order" value="<?php echo $sort_order; ?>" onkeypress="return numerics(event);" required maxlength="5" />
									<small class="hint res-email"></small>
								</div>
								
								<div class="col-md-6 col-sm-12 mb-3 form-group">
									<label for="banner_status">Status<span class="text-danger">*</span></label>
									<select name="status" id="banner_status" class="form-select" required>
										<option value="active" <?php echo ($status == 'active') ? "selected":"";?>>Active</option>
										<option value="inactive" <?php echo ($status == 'inactive') ? "selected":"";?>>Inactive</option>
									</select>
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

<?php $this->load->view('admin/home/footer');?>

<script>

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
