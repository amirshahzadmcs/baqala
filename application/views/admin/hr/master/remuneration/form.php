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
					<h4>Master Remuneration</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin');?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/hr/master/remuneration/list');?>">Master Remuneration</a></li>
						<li class="breadcrumb-item active">Edit</li>
					</ol>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="float-end d-none d-sm-block">
					<a class="btn btn-sm btn-custom-white pull-right me-1" title="Back" href="<?php echo base_url('admin/hr/master/remuneration/list');?>"><i class="fa fa-reply"></i> Back</a>
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
						<form class="needs-validation" method="POST" action="<?php echo base_url('admin/hr/master/remuneration/save');?>" novalidate>
							<input type="hidden" id="id" name="id" value="<?php echo $id;?>">
							<div class="row">
								<div class="col-md-6">
									<div class="mb-3">
										<label for="remuneration_name" class="form-label">Remuneration Name (English)</label>
										<input type="text" class="form-control" id="remuneration_name" value="<?php echo $remuneration_name;?>" name="remuneration_name" required>
										<div class="invalid-feedback">
											Please provide a remuneration name in english.
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="mb-3">
										<label for="remuneration_name_ar" class="form-label">Remuneration Name (Arabic)</label>
										<input type="text" class="form-control rtl-input" id="remuneration_name_ar" value="<?php echo $remuneration_name_ar;?>" name="remuneration_name_ar" required>
										<div class="invalid-feedback">
											Please provide a remuneration name in arabic.
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