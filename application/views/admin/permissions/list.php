<?php $this->load->view('admin/home/header');?>
<style>
	.permission-card .collapse.show{
		padding-left: 24px;
		margin-left: 24px;
		border-left: 1px dotted #969696;
	}
	.permission-card .categories-list {
		padding: 10px 25px;
	}
	.permission-card .categories-group-card {
		display: block;
		margin: 5px 0px;
	}
	.permission-card .categories-group-card .categories-list li{
		display: block;
	}
	.permission-card .categories-group-card .form-check-input {
		width: 1.3em;
		height: 1.3em;
		margin-top: 0.8em;
	}
	.permission-card .categories-group-list {
		display: block;
		color: #343a40;
		font-weight: 500;
		padding: 8px 16px;
		line-height: 24px;
		max-height: 40px;
		min-width: 215px;
	}
	.form-check-label{
		line-height: 44px;
		margin-left: 6px;
	}
	/*
	.permission-card .categories-list li a {
		display: inline;
		padding: 4px 16px;
		color: #495057;
	}*/
</style>
<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Manage Permissions</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin');?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/permissions/list');?>">Manage Permissions</a></li>
						<li class="breadcrumb-item active">Detail</li>
					</ol>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="float-end d-none d-sm-block">
					
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
						<div>
							<?php if($this->admin->getInfo()){ 
							$info = explode("--", $this->admin->getInfo());
							$info_type = $info[0];
							$msg_data = $info[1];
							if($info_type == 2){
							?>  
							<div class="alert alert-danger alert-dismissible fade show" role="alert">
								<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
								<strong>Error!</strong>  <?php echo $msg_data; ?>
							</div>
							<?php } else{?>
							<div class="alert alert-success alert-dismissible fade show" role="alert">
								<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
								<strong>Success!</strong>  <?php echo $msg_data; ?>
							</div>
							<?php } } $this->admin->removeInfo();?>
						</div>
						<div class="row">
								
							<div class="col-md-6">
								<div class="mb-3">
									<label for="role_select" class="form-label">Select Role <span class="text-danger">*</span></label>
									<select class="form-select" name="role" id="role_select" required>
										<option value="">--- Select One ---</option>
										<?php foreach($roles as $role){?>
										<option value="<?= $role['id']; ?>"><?= $role['name']; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							
						</div>

					</div>
				</div>
			</div>
			<div class="col-12">
				<div class="card">
					<div class="card-body permission-card">
						<h5>Select role to view permissions</h5>
					</div>
				</div>
			</div> <!-- end col -->
		</div> <!-- end row -->
	</div>
</div>
<!-- container-fluid -->

<?php $this->load->view('admin/home/footer');?>

<script>
$("#role_select").change(function() {
	var id = this.value;
	if(id > 0){
		$.ajax({
			type: "post",
			url: "<?php echo base_url('admin/roles/permission/quick-edit');?>",
			data: {'role_id': id},
			//dataType: "json",
			success: function (response) {
				//console.log(response);
				$('.permission-card').html(response);
			},
			error: function (request, error) {
				//console.log(" Can't do because: " + JSON.stringify(request));
				$('.permission-card').after(JSON.stringify(request));
			},
		});
	}else{
		alert('Invalid request id!');
	}
});
</script>
