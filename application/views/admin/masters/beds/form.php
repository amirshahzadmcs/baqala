<?php $this->load->view('admin/home/header');?>

	<!-- start page title -->
	<div class="page-title-box">
		<div class="container-fluid">
			<div class="row align-items-center">
				<div class="col-sm-6">
					<div class="page-title">
						<h4>Master Beds</h4>
						<ol class="breadcrumb m-0">
							<li class="breadcrumb-item"><a href="<?php echo base_url('admin');?>">Dashboard</a></li>
							<li class="breadcrumb-item"><a href="<?php echo base_url('admin/master/beds');?>">Master Beds</a></li>
							<li class="breadcrumb-item active">Create Or Edit</li>
						</ol>
					</div>
				</div>
				<?php  $admin_id= $this->session->userdata('admin_id'); ?>
				<div class="col-sm-6">
					<div class="float-end d-sm-block">
						<a class="btn btn-sm btn-custom-white pull-right me-2" title="Back" href="<?php echo base_url();?>admin/master/beds"><i class="fa fa-reply"></i> Back</a>
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
							<?php echo form_open("admin/master/beds/save", array("id"=>"demo-form2", "class"=>"form-horizontal form-label-left")); ?>
								<input type="hidden" id="id" name="id" value="<?php echo $id;?>">
								
								<div class="row">
									<div class="col-md-4 col-sm-12 mb-2 form-group">
										<label for="room">Select Room<span class="text-danger">*</span></label>
										<select class="form-select select2" data-parsley-allselected="true" name="room_id" id="room_id" required>
											<option value="">Select Room</option>
											<?php foreach(masterRoomHelper() as $rooms) { ?>
												<option value="<?php echo $rooms->id; ?>" <?php echo ($rooms->id == $room_id) ? ' selected' : '' ?>><?php echo $rooms->camp_name; ?> - <?php echo $rooms->room_name; ?></option>
											<?php } ?>
										</select>
									</div>
									<div class="col-md-4 col-sm-6 col-xs-12">
										<div class="form-group mb-2">
											<label class="control-labe" for="bed_name">Bed Name (EN)<span class="text-danger">*</span></label>
											<input type="text" id="bed_name" name="bed_name" value="<?php echo $bed_name;?>" required="required" class="form-control">
										</div>
									</div>
									
									<div class="col-md-4 col-sm-6 col-xs-12">
										<div class="form-group mb-2">
											<label class="control-labe" for="bed_name_ar">Bed Name (AR)</label>
											<input type="text" id="bed_name_ar" name="bed_name_ar" value="<?php echo $bed_name_ar;?>" class="form-control rtl-input">
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
