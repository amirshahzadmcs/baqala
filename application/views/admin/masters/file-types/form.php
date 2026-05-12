<?php $this->load->view('admin/home/header');?>

	<!-- start page title -->
	<div class="page-title-box">
		<div class="container-fluid">
			<div class="row align-items-center">
				<div class="col-sm-6">
					<div class="page-title">
						<h4>Master File Types</h4>
						<ol class="breadcrumb m-0">
							<li class="breadcrumb-item"><a href="<?php echo base_url('admin');?>">Dashboard</a></li>
							<li class="breadcrumb-item"><a href="<?php echo base_url('admin/master/file-types');?>">Master File Types</a></li>
							<li class="breadcrumb-item active">Create Or Edit</li>
						</ol>
					</div>
				</div>
				<?php  $admin_id= $this->session->userdata('admin_id'); ?>
				<div class="col-sm-6">
					<div class="float-end d-sm-block">
						<a class="btn btn-sm btn-custom-white pull-right me-2" title="Back" href="<?php echo base_url();?>admin/master/file-types"><i class="fa fa-reply"></i> Back</a>
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
							<?php echo form_open("admin/master/file-types/save", array("id"=>"demo-form2", "class"=>"form-horizontal form-label-left")); ?>
								<input type="hidden" id="id" name="id" value="<?php echo $id;?>">

								<div class="row">
									<div class="col-md-6 col-sm-6 col-xs-12">
										<div class="form-group mb-2">
											<label class="control-label" for="file_types">File Type (EN)<span class="text-danger">*</span></label>
											<input type="text" id="file_types" name="file_types" value="<?php echo $file_types;?>" required="required" class="form-control">
										</div>
									</div>
									
									<div class="col-md-6 col-sm-6 col-xs-12">
										<div class="form-group mb-2">
											<label class="control-label" for="file_types_ar">File Type (AR)</label>
											<input type="text" id="file_types_ar" name="file_types_ar" value="<?php echo $file_types_ar;?>" class="form-control rtl-input">
										</div>
									</div>
									
									<div class="col-md-6 col-sm-6 col-xs-12">
										<div class="form-group mb-2">
											<label class="control-label" for="sort_order">Sort Order</label>
											<input type="number" id="sort_order" name="sort_order" value="<?php echo $sort_order;?>" class="form-control">
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
