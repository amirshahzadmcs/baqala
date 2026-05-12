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
							<h4>Customer</h4>
							<ol class="breadcrumb m-0">
								<li class="breadcrumb-item"><a href="javascript: void(0);">Calcbook</a></li>
								<li class="breadcrumb-item"><a href="javascript: void(0);">Customer</a></li>
								<li class="breadcrumb-item active">Add Customer</li>
							</ol>
						</div>
                    </div>
					<div class="col-sm-6">
						<div class="float-end d-none d-sm-block">
							<a href="<?php echo base_url('customer-list'); ?>" class="btn btn-success"><i class="dripicons-chevron-left" style="vertical-align: middle;"></i> Go Back</a>
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
								<form class="needs-validation" method="POST" action="<?php echo base_url('submit-customer');?>" novalidate>
									<div class="row">
										<div class="col-md-4">
											<div class="mb-3">
												<label for="name" class="form-label">Customer Name</label>
												<input type="text" class="form-control" id="name" placeholder="Name" name="name" required>
												<div class="invalid-feedback">
													Please provide a valid name.
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="mb-3">
												<label for="mobile" class="form-label">Customer Mobile</label>
												<input type="text" class="form-control" id="mobile" placeholder="Mobile Number" name="mobile" required>
												<div class="invalid-feedback">
													Please provide a valid mobile number.
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="mb-3">
												<label for="email" class="form-label">Customer Email</label>
												<input type="text" class="form-control" id="company_email" placeholder="Email" name="email">
												<div class="invalid-feedback">
													Please provide a valid email.
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-4">
											<div class="mb-3">
												<label for="aadhar" class="form-label">Customer Aadhar Number</label>
												<input type="text" class="form-control" id="aadhar" placeholder="Aadhar Number" name="aadhar" required>
												<div class="invalid-feedback">
													Please provide a valid aadhar.
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="mb-3">
												<label for="address" class="form-label">Customer Address</label>
												<input type="text" class="form-control" id="address" placeholder="Locality" name="address" required>
												<div class="invalid-feedback">
													Please provide a valid address.
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="mb-3">
												<label for="city" class="form-label">City</label>
												<input type="text" class="form-control" id="city" placeholder="City name" name="city" required>
												<div class="invalid-feedback">
													Please provide a valid city.
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-4">
											<div class="mb-3">
												<label for="state" class="form-label">State</label>
												<input type="text" class="form-control" id="state" placeholder="State name" name="state" required>
												<div class="invalid-feedback">
													Please provide a valid state.
												</div>
											</div>
										</div>
										<div class="col-md-8">
											<div class="mb-3">
												<div class="row">
													<label for="options" class="form-label">Select Scheme Option</label>
													<div class="form-check col-md-2 m-2">
														<input class="form-check-input" type="radio" name="scheme_type" id="formRadios1" value="PMJJBY">
														<label class="form-check-label" for="formRadios1">
															PMJJBY
														</label>
													</div>
													<div class="form-check col-md-2 m-2">
														<input class="form-check-input" type="radio" name="scheme_type" id="formRadios2" value="PMSBY">
														<label class="form-check-label" for="formRadios2">
															PMSBY
														</label>
													</div>
													<div class="form-check col-md-2 m-2">
														<input class="form-check-input" type="radio" name="scheme_type" id="formRadios3" value="APY">
														<label class="form-check-label" for="formRadios3">
															APY
														</label>
													</div>
													<div class="form-check col-md-2 m-2">
														<input class="form-check-input" type="radio" name="scheme_type" id="formRadios4" value="None">
														<label class="form-check-label" for="formRadios4">
															None
														</label>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-4">
											<div class="mb-3">
												<label for="customer_status" class="form-label">Status</label>
												<select class="form-select" id="customer_status" name="status" required>
													<option value="">Choose...</option>
													<option value="1">Active</option>
													<option value="0">Deactive</option>
												</select>
												<div class="invalid-feedback">
													Please select a valid status.
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