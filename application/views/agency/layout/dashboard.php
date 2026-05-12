<?php $this->load->view('agency/layout/header');?>
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
                            <h4>Hi, welcome back!</h4>
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="container-fluid">
            <div class="page-content-wrapper">
                <div class="row">
                    <?php $this->load->view('agency/partials/alert');?>
                    <div class="col-xl-12">
                        <div class="card">
							<div class="card-body">
								<div class="card-title mb-4 mx-3">
									<h4 class="header-title">Hiring Partner Dashboard</h4>
									<small>Here you can manage your candidates cv and your profile.</small>
								</div>
							</div>
						</div>
                    </div>
					<div class="col-xl-3 col-md-3">
						<div class="card">
							<div class="card-body">
								<div class="text-center">
									<a href="<?php echo base_url('hiring-agency/cv/list'); ?>">
										<p class="font-size-16">CV submitted</p>
									</a>
									<div class="mini-stat-icon mx-auto mb-4 mt-3">
										<span class="avatar-title rounded-circle bg-soft-success">
											<i class="mdi mdi-file-document-edit-outline text-success font-size-20"></i>
										</span>
									</div>
									<h5 class="font-size-22"><?php echo $total_cv['total']; ?></h5>
								</div>
							</div>
						</div>
					</div>

					<div class="col-xl-3 col-md-3">
						<div class="card">
							<div class="card-body">
								<div class="text-center">
									<a href="<?php echo base_url('hiring-agency/cv/filter/shortlisted'); ?>">
										<p class="font-size-16">CV Shortlisted</p>
									</a>
									<div class="mini-stat-icon mx-auto mb-4 mt-3">
										<span class="avatar-title rounded-circle bg-soft-success">
											<i class="mdi mdi-file-check text-success font-size-20"></i>
										</span>
									</div>
									<h5 class="font-size-22"><?php echo $shortlisted_cv['total']; ?></h5>
								</div>
							</div>
						</div>
					</div>

					<div class="col-xl-3 col-md-3">
						<div class="card">
							<div class="card-body">
								<div class="text-center">
									<a href="<?php echo base_url('hiring-agency/cv/filter/rejected'); ?>">
										<p class="font-size-16">CV Rejected</p>
									</a>
									<div class="mini-stat-icon mx-auto mb-4 mt-3">
										<span class="avatar-title rounded-circle bg-soft-success">
											<i class="mdi mdi-file-cancel-outline text-success font-size-20"></i>
										</span>
									</div>
									<h5 class="font-size-22"><?php echo $rejected_cv['total']; ?></h5>
								</div>
							</div>
						</div>
					</div>

					<div class="col-xl-3 col-md-3">
						<div class="card">
							<div class="card-body">
								<div class="text-center">
									<a href="<?php echo base_url('hiring-agency/cv/filter/selected'); ?>">
										<p class="font-size-16">Hired</p>
									</a>
									<div class="mini-stat-icon mx-auto mb-4 mt-3">
										<span class="avatar-title rounded-circle bg-soft-success">
											<i class="mdi mdi-file-account-outline text-success font-size-20"></i>
										</span>
									</div>
									<h5 class="font-size-22"><?php echo $hired['total']; ?></h5>
								</div>
							</div>
						</div>
					</div>
                </div>
            </div>
        </div>
        <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
</div>
<!-- end page content-->

<?php $this->load->view('agency/layout/footer');?>
