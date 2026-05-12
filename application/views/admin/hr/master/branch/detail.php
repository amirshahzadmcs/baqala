<?php $this->load->view('admin/home/header');?>
<style>
.table th, .table td {
    vertical-align: middle;
	padding: 6px 10px;
}
input, textarea, select, select.select2{
    pointer-events: none;
}
span.required{
	color:red;
}
</style>
<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Master Branch</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin');?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url();?>admin/hr/master/branch">Branch List</a></li>
						<li class="breadcrumb-item active">Branch's Detail</li>
					</ol>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<a class="btn btn-sm btn-custom-white pull-right" title="Back" href="<?php echo base_url();?>admin/hr/master/branch"><i class="fa fa-reply"></i> Back</a>
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
				<?php } ?> <?php } $this->admin->removeInfo();?>

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
						<div class="row">
							<div class="col-md-6 col-sm-12 mb-3 form-group">
								<label for="branch_name">Branch Name</label>
								<input type="text" class="form-control" name="branch_name" maxlength="150" value="<?php echo $branch_name; ?>" required />
							</div>
							<div class="col-md-6 col-sm-12 form-group mb-2">
								<label class="control-label" for="branch_name_ar">Branch Name (Arabic)</label>
								<input type="text" id="branch_name_ar" name="branch_name_ar" value="<?php echo $branch_name_ar; ?>" class="form-control rtl-input">
							</div>
							<div class="col-md-12 col-sm-12 form-group mb-2">
								<label class="control-label" for="description">Description</label>
								<textarea id="description" class="form-control" name="description" rows="3" placeholder="Write description here."><?php echo $description;?></textarea>
							</div>
							<div class="col-md-6 col-sm-12 form-group mb-3">
								<label for="status-select" class="form-label">Status</label>
								<select id="status-select" name="status" class="form-select" required>
									<option value="active" <?php echo ($status == 'active') ? "selected":"";?>>Active</option>
									<option value="inactive" <?php echo ($status == 'inactive') ? "selected":"";?>>Inactive</option>
								</select>
							</div>
							
						</div>
					</div>
				</div>
			</div> <!-- end col -->
		</div> <!-- end row -->
	</div>
</div>

<?php $this->load->view('admin/home/footer');?>


