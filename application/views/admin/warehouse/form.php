<?php $this->load->view('admin/home/header');?>




<!-- start page title -->
<div class="page-title-box">
		<div class="container-fluid">
		 <div class="row align-items-center">
				 <div class="col-sm-6">
						 <div class="page-title">
								 <h4>Warehouse Management</h4>
								 <ol class="breadcrumb m-0">
										 <li class="breadcrumb-item"><a href="<?php echo base_url('admin');?>">Dashboard</a></li>
										 <li class="breadcrumb-item"><a href="<?php echo base_url();?>admin/warehouse">Warehouse List</a></li>
										 <li class="breadcrumb-item active">Create / Edit</li>
								 </ol>
						 </div>
				 </div>
				 <?php  $admin_id= $this->session->userdata('admin_id'); ?>
				 <div class="col-sm-6">
						<div class="float-end d-sm-block">
							<?php if($this->customer->userd($admin_id)->role=="Admin" ){?>
							<a class="btn btn-sm btn-danger pull-right" title="Back" href="<?php echo base_url();?>admin/warehouse"><i class="fa fa-reply"></i> Back</a>
							<?php } ?>
							<button form="demo-form2" type="submit" class="btn btn-sm btn-success pull-right" title="Save"><i class="fa fa-save"></i> Save</button>
						</div>
						<?php if($this->admin->getInfo()){
						$info = explode("--", $this->admin->getInfo());
						$info_type = $info[0];
						$msg_data = $info[1];
						if($info_type == 2){
						?>
						<div class="alert alert-danger alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;top:90px;width:50%;" role="alert">
								<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
								<strong><?php echo $msg_data;?></strong>
						</div>
						<?php } else{?>
						<div class="alert alert-info alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;top:90px;width:50%;" role="alert">
								<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
								<strong><?php echo $msg_data;?></strong>
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
									<?php echo form_open("admin/warehouse/add_warehouse", array("id"=>"demo-form2", "enctype"=>"multipart/form-data", "class"=>"form-label-left", "data-parsley-validate"=> "")); ?>
									<div class="row">
										<input type="hidden" id="id" name="id" value="<?php echo $id;?>" />
										<div class="col-md-6 col-sm-12 form-group mb-3">
											<label for="name_english">Display Name (English) <span class="required-field">*</span></label>
											<input type="text" class="form-control" id="name_english" name="name_english" onKeyPress="return Alpha(event);" maxlength="150" value="<?php echo $name_english;?>" required />
											<p class="hint">Enter display name for your warehouse</p>
										</div>
										<div class="col-md-6 col-sm-12 form-group mb-3">
											<label for="name_arabic">Display Name (Arabic) <span class="required-field">*</span></label>
											<input type="text" class="form-control" id="name_arabic" name="name_arabic" value="<?php echo $name_arabic;?>" maxlength="150" required />
											<p class="hint">Enter display name for your warehouse in arabic</p>
										</div>
										<div class="col-md-6 col-sm-12 form-group mb-3">
											<label for="contact_person">Contact Person Name <span class="required-field">*</span></label>
											<input type="text" class="form-control" id="contact_person" name="contact_person" value="<?php echo $contact_person;?>" onKeyPress="return Alpha(event);" maxlength="150" required />
											<p class="hint">Enter contact person's name for your warehouse</p>
										</div>
										<div class="col-md-6 col-sm-12 form-group mb-3">
											<label for="warehouse_email">Email <span class="required-field">*</span></label>
											<input type="text" class="form-control" id="warehouse_email" name="warehouse_email" value="<?php echo $warehouse_email;?>" maxlength="150" required />
											<p class="hint">Enter email for your warehouse</p>
										</div>
										<div class="col-md-6 col-sm-12 form-group mb-3">
											<label for="warehouse_phone">Contact Number <span class="required-field">*</span></label>
											<input type="text" class="form-control" id="warehouse_phone" name="warehouse_phone" value="<?php echo $warehouse_phone;?>" onkeypress="return numerics(event);" maxlength="15" minlength="10" />
											<p class="hint">Format +966 51 234 5678</p>
										</div>
										<div class="col-md-6 col-sm-12 form-group mb-3">
											<label for="partner_code">Partner Code</label>
											<input type="text" class="form-control" id="partner_code" name="partner_code" value="<?php echo $partner_code;?>" maxlength="150" required />
											<p class="hint">Enter partner code for your warehouse</p>
										</div>
										<div class="col-md-6 col-sm-12 form-group mb-3">
											<label for="processing_time">Processing Time</label>
											<input type="text" class="form-control" id="processing_time" name="processing_time" value="<?php echo $processing_time;?>" maxlength="150" required />
											<p class="hint">Enter processing time for your warehouse</p>
										</div>
										<div class="col-md-6 col-sm-12 form-group mb-3">
											<label for="status">Warehouse Status <span class="required-field">*</span></label>
											<select name="status" class="form-control">
												<option value="1" <?php echo ($status == '1') ? "selected":"" ?>>Enable</option>
												<option value="0" <?php echo ($status == '0') ? "selected":"" ?>>Disable</option>
											</select>
											<p class="hint">Set status for your warehouse</p>
										</div>
										<div class="col-md-12 col-sm-12 form-group mb-3">
											<label for="warehouse_map">Warehouse Map IFrame <span class="required-field">*</span></label>
											<textarea class="form-control" rows="3" id="warehouse_map" name="warehouse_map" maxlength="500" required><?php echo $warehouse_map;?></textarea>
											<p class="hint">Enter warehouse map iframe for your warehouse</p>
										</div>
										<div class="col-md-12 col-sm-12 form-group mb-3">
											<label for="complete_address">Warehouse Complete Address <span class="required-field">*</span></label>
											<input type="text" class="form-control" id="complete_address" name="complete_address" value="<?php echo $complete_address;?>" maxlength="255" required />
											<p class="hint">Enter warehouse location for your warehouse</p>
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
