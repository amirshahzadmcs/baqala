<?php $this->load->view('admin/home/header');?>

<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Store management</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin');?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url();?>admin/store/list">Stores List</a></li>
						<li class="breadcrumb-item active">Create / Edit</li>
					</ol>
				</div>
			</div>
			<?php  $admin_id= $this->session->userdata('admin_id'); ?>
			<div class="col-sm-6">
					<div class="float-end d-sm-block">
						<?php if($this->customer->userd($admin_id)->role=="Admin" ){?>
						<a class="btn btn-sm btn-custom pull-right" title="Back" href="<?php echo base_url();?>admin/store/list"><i class="fa fa-reply"></i> Back</a>
						<?php } ?>
						&nbsp;
						<button form="demo-form2" type="submit" class="btn btn-sm btn-custom-success pull-right" title="Save"><i class="fa fa-save"></i> Save</button>

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
					<!-- <div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="close">x</button><?php //echo $msg_data; ?></div> -->
					<?php } else{?>
					<div class="alert alert-info alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;top:90px;width:50%;" role="alert">
							<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
							<strong><?php echo $msg_data; ?></strong>
					</div>
					<!-- <div class="alert alert-info"><button type="button" class="close" data-dismiss="alert" aria-label="close">x</button><?php //echo $msg_data;?></div> -->
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
							<?php echo form_open("admin/store/submit", array("id"=>"demo-form2", "enctype"=>"multipart/form-data", "class"=>"form-label-left", "data-parsley-validate"=> "")); ?>
								<input type="hidden" id="id" name="id" value="<?php echo $id;?>" />
								<input type="hidden" id="store_type" name="store_type" value="1" />
								<div class="row">
									<div class="col-md-6 col-sm-12 mb-3 form-group">
										<label for="store_name">Display Name (English) <span class="required-field">*</span></label>
										<input type="text" class="form-control" id="store_name" name="store_name" onKeyPress="return Alpha(event);" maxlength="150" value="<?php echo $store_name;?>" required />
										<p class="hint">Enter display name for store</p>
									</div>
									<div class="col-md-6 col-sm-12 mb-3 form-group">
										<label for="store_name_arabic">Display Name (Arabic) <span class="required-field">*</span></label>
										<input type="text" class="form-control" id="store_name_arabic" name="store_name_arabic" value="<?php echo $store_name_arabic;?>" maxlength="150" required />
										<p class="hint">Enter display name for store in arabic</p>
									</div>
									<div class="col-md-6 col-sm-12 mb-3 form-group">
										<label for="store_id">Store ID <span class="required-field">*</span></label>
										<input type="text" class="form-control" id="store_id" name="store_id" value="<?php echo $store_id;?>" maxlength="150" required />
										<p class="hint">Enter store id for store</p>
									</div>
									<div class="col-md-6 col-sm-12 mb-3 form-group">
										<label for="store_incharge">Store Incharge Name <span class="required-field">*</span></label>
										<input type="text" class="form-control" id="store_incharge" name="store_incharge" value="<?php echo $store_incharge;?>" onKeyPress="return Alpha(event);" maxlength="150" required />
										<p class="hint">Enter store incharge name for store</p>
									</div>
									<div class="col-md-6 col-sm-12 mb-3 form-group">
										<label for="email">Email <span class="required-field">*</span></label>
										<input type="text" class="form-control" id="email" name="email" maxlength="150" value="<?php echo $email;?>" required />
										<p class="hint">Enter email for store</p>
									</div>
									<div class="col-md-6 col-sm-12 mb-3 form-group">
										<label for="contact_number">Store Contact Number <span class="required-field">*</span></label>
										<input type="text" class="form-control" id="contact_number" name="contact_number" onkeypress="return numerics(event);" maxlength="15" value="<?php echo $contact_number;?>" minlength="10" />
										<p class="hint">Format +966 51 234 5678</p>
									</div>
									<div class="col-md-6 col-sm-12 mb-3 form-group">
										<label for="google_coordinates_lat">Google Coordinates (Latitude)</label>
										<input type="text" class="form-control" id="google_coordinates_lat" name="google_coordinates_lat" maxlength="150" value="<?php echo $google_coordinates_lat;?>" />
										<p class="hint">Enter Google coordinates to define store</p>
									</div>
									<div class="col-md-6 col-sm-12 mb-3 form-group">
										<label for="google_coordinates_long">Google Coordinates (Longitude)</label>
										<input type="text" class="form-control" id="google_coordinates_long" name="google_coordinates_long" maxlength="150" value="<?php echo $google_coordinates_long;?>" />
										<p class="hint">Enter Google coordinates to define store</p>
									</div>
									<div class="col-md-6 col-sm-12 mb-3 form-group">
										<label for="status">Store Status<span class="required-field">*</span></label>
										<select name="status"  class="form-control">
											<option value="1" <?php echo ($status == '1') ? "selected":"" ?>>Enable</option>
											<option value="0" <?php echo ($status == '0') ? "selected":"" ?>>Disable</option>
										</select>
										<p class="hint">Set status for your store</p>
									</div>
									<div class="col-md-6 col-sm-12 mb-3 form-group">
										<label for="store_radius">Set Radius for Devlivery</label>
										<input type="number" class="form-control" id="store_radius" name="store_radius" min="1" max="50" value="<?php echo $store_radius;?>" required />
										<p class="hint">Enter delivery radius in KM for store</p>
									</div>
									<div class="col-md-12 col-sm-12 mb-3 form-group">
										<label for="store_location">Store Complete Location <span class="required-field">*</span></label>
										<textarea rows="2" class="form-control" id="store_location" name="store_location" maxlength="150" required><?php echo $store_location;?></textarea>
										<p class="hint">Enter location for store</p>
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
<?php $this->load->view('admin/home/footer');?>
