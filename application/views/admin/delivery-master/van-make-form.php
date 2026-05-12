<?php $this->load->view('admin/home/header');?>

	<!-- start page title -->
	<div class="page-title-box">
		<div class="container-fluid">
			<div class="row align-items-center">
				<div class="col-sm-6">
					<div class="page-title">
						<h4>Master Vehicle Make</h4>
						<ol class="breadcrumb m-0">
							<li class="breadcrumb-item"><a href="<?php echo base_url('admin');?>">Dashboard</a></li>
							<li class="breadcrumb-item"><a href="<?php echo base_url('admin/vehiclemake');?>">Master Vehicle Make</a></li>
							<li class="breadcrumb-item active">Create Or Edit</li>
						</ol>
					</div>
				</div>
				<?php  $admin_id= $this->session->userdata('admin_id'); ?>
				<div class="col-sm-6">
					<div class="float-end d-sm-block">
						<a class="btn btn-sm btn-custom-white pull-right" title="Back" href="<?php echo base_url();?>admin/vehiclemake"><i class="fa fa-reply"></i> Back</a>
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
							<?php echo form_open("admin/vehiclemake/save", array("id"=>"demo-form2", "enctype"=>"multipart/form-data", "class"=>"form-horizontal form-label-left")); ?>
								<input type="hidden" id="id" name="id" value="<?php echo $id;?>">

								<div class="row">
									<div class="col-md-4 col-sm-12 mb-3 form-group">
										<label for="service_type">Service Type<span class="text-danger">*</span></label>
										<select name="service_type" class="form-control select2" required>
											<option value="">Select Service</option>
											<option value="bike" <?php echo ($service_type == 'bike') ? "selected":"";?>>Bike</option>
											<option value="car" <?php echo ($service_type == 'car') ? "selected":"";?>>Car</option>
										</select>
									</div>
									<div class="col-md-4 col-sm-12 col-xs-12">
										<div class="form-group mb-2">
											<label class="control-labe" for="vehicle_make">Vehicle Make<span class="text-danger">*</span>
											</label>
											<input type="text" id="vehicle_make" name="make_name" value="<?php echo $make_name;?>" required="required" class="form-control col-md-7 col-xs-12">
										</div>
									</div>
									
									<div class="col-md-4 col-sm-12 col-xs-12">
										<div class="form-group mb-2">
											<label class="control-labe" for="status">Status</label>
											<select name="status" class="form-control col-md-7 col-xs-12">
												<option value="1" <?php echo ($status == '1') ? "selected":"";?>>Active</option>
												<option value="0" <?php echo ($status == '0') ? "selected":"";?>>Inactive</option>
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
