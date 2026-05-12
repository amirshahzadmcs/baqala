<?php $this->load->view('admin/home/header');?>
<style>
    fieldset {
        display: block;
        margin-inline-start: 2px;
        margin-inline-end: 2px;
        padding-block-start: 0.35em;
        padding-inline-start: 0.75em;
        padding-inline-end: 0.75em;
        padding-block-end: 0.625em;
        min-inline-size: min-content;
        border-width: 2px;
        border-style: solid;
        border-color: rgb(211 211 211);
        border-image: initial;
        border-radius: 5px;
    }
    legend {
        display: block;
        padding-inline-start: 2px;
        padding-inline-end: 2px;
        background: #fff0;
        margin-top: -26px;
    }
    legend span{
        padding: 0px 15px;
        font-size: 17px;
        font-weight: 700;
        background: #fff;
    }
</style>
<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Banner Management</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin');?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/app-setting/dasboard');?>">App Setting</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/app/banner/list');?>">Banners</a></li>
						<li class="breadcrumb-item active">Add</li>
					</ol>
				</div>
			</div>
			<?php  $admin_id= $this->session->userdata('admin_id'); ?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<a class="btn btn-sm btn-custom-white pull-right me-2" title="Back" href="<?php echo base_url('admin/app/banner/list');?>"><i class="fa fa-reply"></i> Back</a>
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
						<?php echo form_open("admin/app/banner/save", array("id"=>"bannerForm", "enctype"=>"multipart/form-data", "class"=>"form-label-left", "data-parsley-validate"=> "")); ?>
							<input type="hidden" id="banner_type" name="banner_type" value="slider" required />
							<fieldset>
                                <legend><span>Banner Detail English:</span></legend>
    							<div class="row">	
    								<div class="col-md-6 mb-3 form-group">
    									<label for="banner_name">Banner Name <span class="text-danger">*</span></label>
    									<input type="text" class="form-control" id="banner_name" name="banner_name" required maxlength="255" />
    								</div>
    
    								<div class="col-md-6 mb-3 form-group">
    									<label for="banner_title">Banner Title</label>
    									<input type="text" class="form-control" id="banner_title" name="banner_title" maxlength="255" />
    								</div>
    
    								<div class="col-md-6 mb-3 form-group">
    									<label for="banner_subtitle">Banner Sub Title</label>
    									<input type="text" class="form-control" id="banner_subtitle" name="banner_subtitle" maxlength="255" />
    								</div>
    								
    								<div class="col-md-6 mb-3 form-group box">
    									<label for="banner_image">Banner Image</label>
    									<input type="file" class="form-control" name="banner_image" onchange="document.getElementById('input_image').src = window.URL.createObjectURL(this.files[0])" />
    									<img id="input_image" width="300" src="" style="float:left;margin-top:10px;" />
    								</div>
    							</div>
    						</fieldset>
    						<fieldset class="my-3">
                                <legend><span>Banner Detail Arabic:</span></legend>
    							<div class="row">	
    								<div class="col-md-6 mb-3 form-group">
    									<label for="banner_name_ar">Banner Name</label>
    									<input type="text" class="form-control rtl-input" id="banner_name_ar" name="banner_name_ar" maxlength="255" />
    								</div>
    
    								<div class="col-md-6 mb-3 form-group">
    									<label for="banner_title_ar">Banner Title</label>
    									<input type="text" class="form-control rtl-input" id="banner_title_ar" name="banner_title_ar" maxlength="255" />
    								</div>
    
    								<div class="col-md-6 mb-3 form-group">
    									<label for="banner_subtitle_ar">Banner Sub Title</label>
    									<input type="text" class="form-control rtl-input" id="banner_subtitle_ar" name="banner_subtitle_ar" maxlength="255" />
    								</div>
    								<div class="col-md-6 mb-3 form-group box">
    									<label for="banner_image_ar">Banner Image</label>
    									<input type="file" class="form-control" name="banner_image_ar" onchange="document.getElementById('input_image2').src = window.URL.createObjectURL(this.files[0])" />
    									<img id="input_image2" width="300" src="" style="float:left;margin-top:10px;" />
    								</div>
    								
    							</div>
    						</fieldset>
    						<div class="row">
								<div class="col-md-6 mb-3 form-group">
									<label for="linked_category">Select Category <span class="text-danger">*</span> (Linked to Page)</label>
									<select style="height:410px;" name="linked_category" id="linked_category" class="form-control select2" required>
										<option value="">Select </option>
										<?php
										foreach($categories as $category){?>
										<option value="<?php echo $category['id'];?>"><?php echo $category['name'];?></option>
										<?php foreach($category['child'] as $child){?>
										<option value="<?php echo $child['id'];?>"><?php echo $category['name'] . " > " . $child['name'];?></option>
										<?php foreach($child['child'] as $sub){?>
										<option value="<?php echo $sub['id'];?>"><?php echo $category['name'] . " > " . $child['name'] . " > " . $sub['name'];?></option>
										<?php }}}?>
									</select>
								</div>
								
								<div class="col-md-6 mb-3 form-group">
									<label for="sort_order">Sort Order <span class="text-danger">*</span></label>
									<input type="text" class="form-control" id="sort_order" name="sort_order" onkeypress="return numerics(event);" required maxlength="5" />
								</div>
								
								<div class="col-md-6 col-sm-12 mb-3 form-group">
									<label for="banner_status">Status<span class="text-danger">*</span></label>
									<select name="status" class="form-control" required>
										<option value="active">Active</option>
										<option value="inactive">Inactive</option>
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
