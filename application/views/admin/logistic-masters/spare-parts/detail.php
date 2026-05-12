<?php $this->load->view('admin/home/header');?>
<style>
input, textarea, select, .select2{
    pointer-events: none;
}
</style>
<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
			<div class="page-title">
				<h4>Spare Part Master</h4>
				<ol class="breadcrumb m-0">
					<li class="breadcrumb-item"><a href="<?php echo base_url('admin');?>">Dashboard</a></li>
					<li class="breadcrumb-item"><a href="<?php echo base_url('admin/spare-parts/list');?>">Spare Part Master</a></li>
					<li class="breadcrumb-item active">Detail</li>
				</ol>
			</div>
			</div>
			<?php  $admin_id= $this->session->userdata('admin_id'); ?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<a class="btn btn-sm btn-custom-white pull-right" title="Back" href="<?php echo base_url('admin/spare-parts/list'); ?>"><i class="fa fa-reply"></i> Back</a>
				</div>
				<?php if($this->admin->getInfo()){
				$info = explode("--", $this->admin->getInfo());
				$info_type = $info[0];
				$msg_data = $info[1];
				if($info_type == 1){
				?>
				<div class="alert alert-success alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;width:50%;top:90px;" role="alert">
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					<strong><?php echo $msg_data; ?></strong>
				</div>
				
				<?php } else{?>
				<div class="alert alert-danger alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;width:50%;top:90px;" role="alert">
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
					<div class="card-header">Spare Part Detail</div>
					<div class="card-body">
						<div class="row">
							<div class="col-md-4 col-sm-12 mb-3 form-group">
								<label for="vehicle_make">Vehicle Make <span class="text-danger">*</span></label>
								<input type="text" id="item_code" name="item_code" value="<?php echo ucfirst($service_type);?>" required="required" class="form-control">
							</div>
							<div class="col-md-4 col-sm-12 mb-3 form-group">
								<label for="vehicle_make">Vehicle Make <span class="text-danger">*</span></label>
								<input type="text" id="item_code" name="item_code" value="<?php echo $make_name;?>" required="required" class="form-control">
							</div>
							
							<div class="col-md-4 col-sm-12 mb-3 form-group">
								<label for="vehicle_model">Vehicle Type <span class="text-danger">*</span></label>
								<input type="text" id="item_code" name="item_code" value="<?php echo $vehicle_model;?>" required="required" class="form-control">
							</div>

							<div class="col-md-4 col-sm-6 col-xs-12">
								<div class="form-group mb-2">
									<label class="control-label" for="item_code">Part No <span class="text-danger">*</span></label>
									<input type="text" id="item_code" name="item_code" value="<?php echo $item_code;?>" required="required" class="form-control">
								</div>
							</div>

							<div class="col-md-4 col-sm-6 col-xs-12">
								<div class="form-group mb-2">
									<label class="control-label" for="part_name_en">Particular Name (English) <span class="text-danger">*</span></label>
									<input type="text" id="part_name_en" name="part_name_en" value="<?php echo $part_name_en;?>" required="required" class="form-control">
								</div>
							</div>

							<div class="col-md-4 col-sm-6 col-xs-12">
								<div class="form-group mb-2">
									<label class="control-label" for="part_name_ar">Particular Name (Arabic) <span class="text-danger">*</span></label>
									<input type="text" id="part_name_ar" name="part_name_ar" value="<?php echo $part_name_ar;?>" required="required" class="form-control rtl-input">
								</div>
							</div>
							
							<div class="col-md-4 col-sm-6 col-xs-12">
								<div class="form-group mb-2">
									<label class="control-label">Status <span class="text-danger">*</span></label>
									<input type="text" id="item_code" name="item_code" value="<?php echo ($status == 'active') ? 'Active':'Inactive';?>" required="required" class="form-control">
								</div>
							</div>
							<div class="col-md-4 col-sm-6 col-xs-12">
								<div class="form-group mb-2">
									<label class="control-label">Created At <span class="text-danger">*</span></label>
									<input type="text" name="created_at" value="<?php echo date('d-m-Y H:i:s', strtotime($created_at));?>" required="required" class="form-control">
								</div>
							</div>
							<div class="col-md-4 col-sm-6 col-xs-12">
								<div class="form-group mb-2">
									<label class="control-label">Updated At <span class="text-danger">*</span></label>
									<input type="text" name="updated_at" value="<?php echo (isset($updated_at)) ? date('d-m-Y H:i:s', strtotime($updated_at)) : 'NA';?>" required="required" class="form-control">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div> <!-- end col -->
		</div> <!-- end row -->
	</div>
 </div>
 <!-- container-fluid -->

<?php $this->load->view('admin/home/footer');?>

