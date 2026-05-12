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
							<h4>SALES</h4>
							<ol class="breadcrumb m-0">
								<li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
								<li class="breadcrumb-item"><a href="javascript: void(0);">Sales</a></li>
								<li class="breadcrumb-item active">Sales man form</li>
							</ol>
						</div>
                    </div>
					<div class="col-sm-6">
						<div class="float-end d-none d-sm-block">
							<a href="<?php echo base_url('sales-list'); ?>" class="btn btn-primary"><i class="dripicons-chevron-left" style="vertical-align: middle;"></i> Go Back</a>
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
								<form class="needs-validation custom-validation" method="POST" action="<?php echo base_url('submit-sales');?>" novalidate>
									<input type="hidden" id="id" name="id" value="<?php echo $id;?>">
									<div class="row">
										<div class="col-md-6">
											<div class="mb-3">
												<label for="name" class="form-label">Name</label>
												<input type="text" maxlength="100" class="form-control" id="name" name="name" placeholder="Name" value="<?php echo $name;?>" required>
												<div class="invalid-feedback">
													Please provide a name.
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="mb-3">
												<label for="email" class="form-label">Email</label>
												<input type="email" class="form-control" id="email" value="<?php echo $email;?>" placeholder="Email" parsley-type="email" name="email" required>
												<div class="invalid-feedback">
													Please provide a email.
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="mb-3">
												<label for="mobile" class="form-label">Mobile</label>
												<input data-parsley-type="digits" type="text" class="form-control" maxlength="15" id="mobile" value="<?php echo $mobile;?>" placeholder="Mobile" name="mobile" required>
												<div class="invalid-feedback">
													Please provide a mobile number.
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
										<?php if($id == ''){ ?>
										<div class="col-md-6">
											<div class="mb-3">
												<label>Password</label>
												<input type="password" id="pass2" name="password" value="<?php echo $password;?>" class="form-control" required placeholder="Password"/>
											</div>
										</div>
										<div class="col-md-6">
											<div class="mb-3">
												<label>Confirm Password</label>
												<input type="password" class="form-control" required data-parsley-equalto="#pass2" placeholder="Re-Type Password"/>
											</div>
										</div>
										<?php } ?>
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