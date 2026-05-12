<?php $this->load->view('retailer/layout/header');?>
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
							<h4>Firm</h4>
							<ol class="breadcrumb m-0">
								<li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
								<li class="breadcrumb-item"><a href="javascript: void(0);">Firm</a></li>
								<li class="breadcrumb-item active">Add Company</li>
							</ol>
						</div>
                    </div>
					<div class="col-sm-6">
						<div class="float-end d-none d-sm-block">
							<a href="<?php echo base_url('company-list'); ?>" class="btn btn-success"><i class="dripicons-chevron-left" style="vertical-align: middle;"></i> Go Back</a>
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
								<form class="needs-validation" method="POST" action="<?php echo base_url('submit-company');?>" novalidate>
									<div class="row">
										<div class="col-md-6">
											<div class="mb-3">
												<label for="company_name" class="form-label">Firm Name</label>
												<input type="text" class="form-control" id="company_name"
													placeholder="First name" name="company_name" required>
												<div class="invalid-feedback">
													Please provide a firm name.
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="mb-3">
												<label for="company_email" class="form-label">Firm Email</label>
												<input type="text" class="form-control" id="company_email"
													placeholder="Last name" name="company_email" required>
												<div class="invalid-feedback">
													Please provide a firm email.
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="mb-3">
												<label for="company_mobile" class="form-label">Firm Mobile</label>
												<input type="text" class="form-control" id="company_mobile"
													placeholder="Last name" name="company_mobile" required>
												<div class="invalid-feedback">
													Please provide a firm mobile number.
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="mb-3">
												<label for="company_address" class="form-label">Firm Address</label>
												<input type="text" class="form-control" id="company_address"
													placeholder="City" name="company_address" required>
												<div class="invalid-feedback">
													Please provide a valid address.
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

<?php $this->load->view('retailer/layout/footer');?>
<script>
$(document).ready(function() {
    $("#datatable-buttons").DataTable({
        //lengthChange: !1,
        buttons: ["copy", "excel", "pdf", "colvis"]
    }).buttons().container().appendTo("#datatable-buttons_wrapper .col-md-6:eq(0)"), 
	$(".dataTables_length select").addClass("form-select form-select-sm")
});
</script>