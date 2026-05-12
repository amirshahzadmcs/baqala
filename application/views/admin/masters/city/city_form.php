<?php $this->load->view('admin/home/header');?>

	<!-- start page title -->
	<div class="page-title-box">
		<div class="container-fluid">
			<div class="row align-items-center">
				<div class="col-sm-6">
					<div class="page-title">
						<h4>Master City</h4>
						<ol class="breadcrumb m-0">
							<li class="breadcrumb-item"><a href="<?php echo base_url('admin');?>">Dashboard</a></li>
							<li class="breadcrumb-item"><a href="<?php echo base_url('admin/master/city');?>">Master City</a></li>
							<li class="breadcrumb-item active">Create Or Edit</li>
						</ol>
					</div>
				</div>
				<?php  $admin_id= $this->session->userdata('admin_id'); ?>
				<div class="col-sm-6">
					<div class="float-end d-sm-block">
						<a class="btn btn-sm btn-custom-white pull-right me-2" title="Back" href="<?php echo base_url();?>admin/master/city"><i class="fa fa-reply"></i> Back</a>
						<button form="demo-form2" type="submit" class="btn btn-sm btn-custom-success pull-right" title="Save"><i class="fa fa-save"></i> Save</button>
					</div>
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
							<?php echo form_open("admin/master/city/save", array("id"=>"demo-form2", "class"=>"form-horizontal form-label-left")); ?>
								<input type="hidden" id="id" name="id" value="<?php echo $id;?>">

								<div class="row">
									<div class="col-md-6 col-sm-6 col-xs-12">
										<div class="form-group mb-2">
											<label for="country_id">Select Country<span class="text-danger">*</span></label>
											<select id="country_id" name="country_id" class="form-control col-md-12 select2" required>
												<option value="">Select Country</option>
												<?php foreach($countries as $mc){?>
												<option value="<?php echo $mc->id;?>" <?php echo ($country_id == $mc->id) ? "selected":"";?>><?php echo $mc->name;?></option>
												<?php } ?>
											</select>
										</div>
									</div>
									
									<div class="col-md-6 col-sm-6 col-xs-12">
										<div class="form-group mb-2">
											<label class="control-label" for="city_name">City Name<span class="text-danger">*</span></label>
											<input type="text" id="city_name" name="city_name" value="<?php echo $city_name;?>" required="required" class="form-control col-md-7 col-xs-12">
										</div>
									</div>
									
									<div class="col-md-6 col-sm-6 col-xs-12">
										<div class="form-group mb-2">
											<label class="control-label" for="arabic_name">City Name (Arabic)</label>
											<input type="text" id="arabic_name" name="arabic_name" value="<?php echo $arabic_name;?>" class="form-control rtl-input">
										</div>
									</div>

									<div class="col-md-6 col-sm-6 col-xs-12">
										<div class="form-group mb-2">
											<label class="control-label" for="status">Status</label>
											<select name="status" class="form-control col-md-7 col-xs-12">
												<option value="1" <?php echo ($status == '1') ? "selected":"";?>>Active</option>
												<option value="0" <?php echo ($status == '0') ? "selected":"";?>>Deactive</option>
											</select>
										</div>
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
