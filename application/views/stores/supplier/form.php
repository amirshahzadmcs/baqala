<?php $this->load->view('company/layout/header');?>
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
							<h4>Supplier</h4>
							<ol class="breadcrumb m-0">
								<li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
								<li class="breadcrumb-item"><a href="javascript: void(0);">Supplier</a></li>
								<li class="breadcrumb-item active">Add Supplier</li>
							</ol>
						</div>
                    </div>
					<div class="col-sm-6">
						<div class="float-end d-none d-sm-block">
							<a href="<?php echo base_url('supplier-list'); ?>" class="btn btn-primary"><i class="dripicons-chevron-left" style="vertical-align: middle;"></i> Go Back</a>
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
								<form class="needs-validation" method="POST" action="<?php echo base_url('submit-supplier');?>" novalidate>
									<input type="hidden" id="id" name="id" value="<?php echo $id;?>">
									<div class="row">
										<div class="col-md-6">
											<div class="mb-3">
												<label for="name" class="form-label">Supplier Name</label>
												<input type="text" maxlength="100" class="form-control" id="name" placeholder="Supplier name" name="name" value="<?php echo $name;?>" required>
												<div class="invalid-feedback">
													Please provide a supplier name.
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="mb-3">
												<label for="cr_no" class="form-label">CR Number</label>
												<input data-parsley-type="alphanum" type="text" maxlength="40" class="form-control" id="cr_no" placeholder="CR Number" name="cr_no"  value="<?php echo $cr_no;?>" required>
												<div class="invalid-feedback">
													Please provide a CR number.
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="mb-3">
												<label for="vat_no" class="form-label">VAT No</label>
												<input data-parsley-type="alphanum" type="text" maxlength="40" class="form-control" id="vat_no" value="<?php echo $vat_no;?>" placeholder="VAT No" name="vat_no" required>
												<div class="invalid-feedback">
													Please provide a VAT Number.
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="mb-3">
												<label for="address" class="form-label">Supplier Address</label>
												<input type="text" class="form-control" id="address" maxlength="250" value="<?php echo $address;?>" placeholder="Supplier Address" name="address" required>
												<div class="invalid-feedback">
													Please provide a valid address.
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="mb-3">
												<label for="email" class="form-label">Supplier Email</label>
												<input type="email" class="form-control" id="email" value="<?php echo $email;?>" placeholder="Supplier Email" parsley-type="email" name="email" required>
											</div>
										</div>
										<div class="col-md-6">
											<div class="mb-3">
												<label for="mobile" class="form-label">Supplier Mobile</label>
												<input data-parsley-type="digits" type="text" class="form-control" maxlength="15" id="mobile" value="<?php echo $mobile;?>" placeholder="Supplier Mobile" name="mobile" required>
												<div class="invalid-feedback">
													Please provide a supplier mobile number.
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="mb-3">
												<label for="status" class="form-label">Status</label>
												<select class="form-control select2" name="status" style="width: 100%;" required>
													<option value="1" <?php echo ($status == '1') ? "selected":"";?>>Active</option>
													<option value="0" <?php echo ($status == '0') ? "selected":"";?>>Pending</option>
												</select>
												<div class="invalid-feedback">
													Please provide a company status.
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

<?php $this->load->view('company/layout/footer');?>