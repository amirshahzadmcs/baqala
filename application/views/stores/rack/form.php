<?php $this->load->view('stores/layout/header');?>
<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="main-content">
    <div class="page-content">
        <!-- start page title -->
        <div class="page-title-box">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <div class="page-title">
							<h4>Manage Racks</h4>
							<ol class="breadcrumb m-0">
								<li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
								<li class="breadcrumb-item"><a href="javascript: void(0);">Racks</a></li>
								<li class="breadcrumb-item active">Add or Edit</li>
							</ol>
						</div>
                    </div>
					<div class="col-sm-6">
						<div class="float-end d-none d-sm-block">
							<a href="<?php echo base_url('store/rack'); ?>" class="btn btn-success btn-sm"><i class="dripicons-chevron-left" style="vertical-align: middle;"></i> Go Back</a>
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
								<form class="needs-validation" method="POST" action="<?php echo base_url('store/rack/add_rack');?>" novalidate>
									<input type="hidden" id="id" name="id" value="<?php echo $id;?>">
									<div class="row">
										<div class="col-md-6">
											<div class="mb-3">
												<label for="rack_name" class="form-label">Rack Name</label>
												<input type="text" class="form-control" id="rack_name" value="<?php echo $rack_name;?>" placeholder="First name" name="rack_name" required>
												<div class="invalid-feedback">
													Please provide a rack name.
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="mb-3">
												<label for="status-select" class="form-label">Status</label>
												<select id="status-select" name="status" class="form-control" required>
													<option value="1" <?php echo ($status == '1') ? "selected":"";?>>Active</option>
													<option value="0" <?php echo ($status == '0') ? "selected":"";?>>Deactive</option>
												</select>
												<div class="invalid-feedback">
													Please provide a status.
												</div>
											</div>
										</div>
									</div>
									<div>
										<button class="btn btn-primary" type="submit">Submit form</button>
									</div>
								</form>

							</div>
						</div>
					</div> <!-- end col -->
				</div> <!-- end row -->
            </div>
        </div>
        <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
</div>
<!-- end page content-->

<?php $this->load->view('stores/layout/footer');?>
<script>
$(document).ready(function() {
    $("#datatable-buttons").DataTable({
        //lengthChange: !1,
        buttons: ["copy", "excel", "pdf", "colvis"]
    }).buttons().container().appendTo("#datatable-buttons_wrapper .col-md-6:eq(0)"), 
	$(".dataTables_length select").addClass("form-select form-select-sm")
});
</script>