<?php $this->load->view('admin/home/header');?>

<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			 <div class="col-sm-6">
				 <div class="page-title">
					<h4>Size Management</h4>
					 <ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin');?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url();?>admin/size">Brands List</a></li>
						<li class="breadcrumb-item active">Create / Edit</li>
					 </ol>
				 </div>
			 </div>
			 <?php  $admin_id= $this->session->userdata('admin_id'); ?>
			 <div class="col-sm-6">
				<div class="float-end d-sm-block">
					<a class="btn btn-sm btn-custom-white pull-right" title="Back" href="<?php echo base_url();?>admin/size"><i class="fa fa-reply"></i> Back</a>
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
						<?php echo form_open("admin/size/add_size", array("id"=>"demo-form2", "enctype"=>"multipart/form-data", "class"=>"form-horizontal form-label-left")); ?>
							<input type="hidden" id="id" name="id" value="<?php echo $id;?>">
							<div class="row">
								<div class="col-md-6 col-sm-6 col-xs-12">
									<div class="form-group">
										<label class="control-labe" for="size_name">Size Name <span class="required">*</span>
										</label>
										<input type="text" id="size_name" name="size_name" value="<?php echo $size_name;?>" required="required" class="form-control col-md-7 col-xs-12">
									</div>
								</div>
								
								<div class="col-md-6 col-sm-6 col-xs-12">
									<div class="form-group">
										<label class="control-labe" for="sort_order">Sort Order <span class="required">*</span>
										</label>
										<input type="number" id="sort_order" name="sort_order" value="<?php echo $sort_order;?>" required="required" class="form-control col-md-7 col-xs-12">
									</div>
								</div>
								
								<div class="col-md-6 col-sm-6 col-xs-12">
									<div class="form-group">
										<label class="control-labe" for="status">Status
										</label>
										<select name="status" class="form-control col-md-7 col-xs-12">
											<option value="active" <?php echo ($status == 'active') ? "selected":"";?>>Active</option>
											<option value="deactive" <?php echo ($status == 'deactive') ? "selected":"";?>>Deactive</option>
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
