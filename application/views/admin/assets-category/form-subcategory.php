<?php $this->load->view('admin/home/header');?>
<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Manage Assets Category</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin');?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="javascript: void(0);">Assets Category</a></li>
						<li class="breadcrumb-item active">Edit</li>
					</ol>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="float-end d-none d-sm-block">
					<a class="btn btn-sm btn-custom-white pull-right me-1" title="Back" href="<?php echo base_url('admin/assets/sub-category/list');?>"><i class="fa fa-reply"></i> Back</a>
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
						<form class="needs-validation" method="POST" action="<?php echo base_url('admin/assets/sub-category/submit');?>" novalidate>
							<input type="hidden" id="id" name="id" value="<?php echo $id;?>">
							<div class="row">
								<div class="col-md-12">
									<div class="mb-3">
										<label for="parent_id" class="form-label">Select Parent Category</label>
										<select class="form-select" name="parent_id" id="parent_id" required>
											<option value="">--- Select Category ---</option>
											<?php 
											foreach($categories as $pcat){?>
											<option value="<?php echo $pcat->id;?>" <?php echo ($parent_id == $pcat->id) ? "selected":"";?>><?php echo $pcat->category_name;?></option>
											<?php } ?>
										</select>
										<div class="invalid-feedback">
											Please select a parent category.
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="mb-3">
										<label for="subcategory_name" class="form-label">Category Name</label>
										<input type="text" class="form-control" id="subcategory_name" value="<?php echo $subcategory_name;?>" placeholder="Category Name" name="subcategory_name" required>
										<div class="invalid-feedback">
											Please provide a category name.
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="mb-3">
										<label for="status-select" class="form-label">Status</label>
										<select id="status-select" name="status" class="form-control" required>
											<option value="active" <?php echo ($status == 'active') ? "selected":"";?>>Active</option>
											<option value="inactive" <?php echo ($status == 'inactive') ? "selected":"";?>>Deactive</option>
										</select>
										<div class="invalid-feedback">
											Please provide a status.
										</div>
									</div>
								</div>
							</div>
							<div>
								<button class="btn btn-custom-success" type="submit">Submit form</button>
							</div>
						</form>

					</div>
				</div>
			</div> <!-- end col -->
		</div> <!-- end row -->
	</div>
</div>
<!-- container-fluid -->

<?php $this->load->view('admin/home/footer');?>
<script>
$(document).ready(function() {
    $("#datatable-buttons").DataTable({
        //lengthChange: !1,
        buttons: ["copy", "excel", "pdf", "colvis"]
    }).buttons().container().appendTo("#datatable-buttons_wrapper .col-md-6:eq(0)"), 
	$(".dataTables_length select").addClass("form-select form-select-sm")
});
</script>