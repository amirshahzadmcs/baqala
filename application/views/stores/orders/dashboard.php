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
                            <h4>Orders Dashboard</h4>
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="<?php echo base_url('store'); ?>">Home</a></li>
                                <li class="breadcrumb-item active"><a href="<?php echo base_url('store/order/dashboard'); ?>">Orders</a></li>
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
					<div class="col-sm-12 col-lg-2">
						<div class="card">
							<div class="card-body">
								<a href="<?php echo base_url('store/order/new-orders'); ?>" target="_blank">
									<h1 class="card-title"><span class="text-info"><i class="ti-import"></i></span></h1>
									<h3 class="card-title"><span class="text-dark">5</span></h3>
									<p class="text-muted font-size-13 mb-0">New Orders</p>
								</a>
							</div>
						</div>
					</div>
					<div class="col-sm-12 col-lg-2">
						<div class="card">
							<div class="card-body">
								<a href="<?php echo base_url('store/order/in-process'); ?>" target="_blank">
									<h1 class="card-title"><span class="text-warning"><i class="ti-reload"></i></span></h1>
									<h3 class="card-title"><span class="text-dark">1</span></h3>
									<p class="text-muted font-size-13 mb-0">In Process</p>
								</a>
							</div>
						</div>
					</div>
					<div class="col-sm-12 col-lg-2">
						<div class="card">
							<div class="card-body">
								<a href="<?php echo base_url('store/order/delivered-orders'); ?>" target="_blank">
									<h1 class="card-title"><span class="text-success"><i class="ti-check-box"></i></span></h1>
									<h3 class="card-title"><span class="text-dark">1</span></h3>
									<p class="text-muted font-size-13 mb-0">Delivered Orders</p>
								</a>
							</div>
						</div>
					</div>
					<div class="col-sm-12 col-lg-2">
						<div class="card">
							<div class="card-body">
								<a href="<?php echo base_url('store/order/cancelled-orders'); ?>" target="_blank">
									<h1 class="card-title"><span class="text-dark"><i class="ti-alert"></i></span></h1>
									<h3 class="card-title"><span class="text-dark">1</span></h3>
									<p class="text-muted font-size-13 mb-0">Cancelled Orders</p>
								</a>
							</div>
						</div>
					</div>
					<div class="col-sm-12 col-lg-2">
						<div class="card">
							<div class="card-body">
								<a href="<?php echo base_url('store/order/returned-orders'); ?>" target="_blank">
									<h1 class="card-title"><span class="text-danger"><i class="ti-share-alt"></i></span></h1>
									<h3 class="card-title"><span class="text-dark">1</span></h3>
									<p class="text-muted font-size-13 mb-0">Returned Orders</p>
								</a>
							</div>
						</div>
					</div>
					<div class="col-sm-12 col-lg-2">
						<div class="card">
							<div class="card-body">
								<a href="<?php echo base_url('store/order/all-orders'); ?>" target="_blank">
									<h1 class="card-title"><span class="text-success"><i class="ti-server"></i></span></h1>
									<h3 class="card-title"><span class="text-dark">10</span></h3>
									<p class="text-muted font-size-13 mb-0">Total Orders</p>
								</a>
							</div>
						</div>
					</div>
				</div>
                <div class="row">
                    <div class="col-xl-8">
                        <div class="card">
							<div class="card-body">
								<h4 class="header-title mb-4">Revenue Stastics</h4>
								<div class="media">
									<h4>SAR 14,235 </h4>
									<div class="media-body ps-3">
										<div class="dropdown">
											<button class="btn btn-light btn-sm dropdown-toggle" type="button"
												id="dropdownMenuButton" data-bs-toggle="dropdown"
												aria-haspopup="true" aria-expanded="false">
												Today<i class="mdi mdi-chevron-down ms-1"></i>
											</button>
											<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
												<a class="dropdown-item" href="#">Yesterday</a>
												<a class="dropdown-item" href="#">Last Week</a>
												<a class="dropdown-item" href="#">last Month</a>
											</div>
										</div>
									</div>
								</div>

								<div class="mt-3">
									<div id="stastics-chart"></div>
								</div>

							</div>
						</div>
                    </div>

                    <div class="col-xl-4">
                        <div class="card">
							<div class="card-body">
								<h4 class="header-title mb-4">Earning Goal</h4>
								<div class="mt-2 text-center">
									<div class="row">
										<div class="col-md-6">
											<div class="mt-4 mt-sm-0">
												<div id="list-chart-1" class="apex-charts" dir="ltr"></div>
												<p class="text-muted mb-2 mt-2 pt-1">Total Earning:</p>
												<h5 class="font-size-18 mb-1">SAR 13,545.65</h5>
											</div>
										</div>

										<div class="col-md-6 dash-goal">
											<div class="mt-4 mt-sm-0">
												<div id="list-chart-2" class="apex-charts" dir="ltr"></div>
												<p class="text-muted mb-2 mt-2 pt-1">Earning Goal:</p>
												<h5 class="font-size-18 mb-1">SAR 84,265.45</h5>
											</div>
										</div>
									</div>
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

<?php $this->load->view('stores/layout/footer');?>
