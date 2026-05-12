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
                    <div class="col-xl-8">
                        <div class="card">
							<div class="card-body">
								<h4 class="header-title mb-4">Recent Order History</h4>
								<div class="table-responsive">
									<table class="table table-centered table-nowrap mb-0">
										<thead class="thead-light">
											<tr>
												<th>ID</th>
												<th>Product</th>

												<th>Customer</th>
												<th>Price</th>
												<th>Invoice</th>
												<th>Status</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>#2356</td>
												<td><img src="assets/images/product/img-7.png" width="42" class="me-3" alt="">Green Chair</td>
												<td>Kenneth Gittens</td>
												<td>SAR 200.00</td>
												<td>42</td>
												<td><span
														class="badge badge-pill badge-soft-primary font-size-13">Pending</span>
												</td>
											</tr>

											<tr>
												<td>#2564</td>
												<td><img src="assets/images/product/img-8.png" width="42" class="me-3" alt="">Office Chair</td>
												<td>Alfred Gordon</td>
												<td>SAR 242.00</td>
												<td>54</td>
												<td><span
														class="badge badge-pill badge-soft-success font-size-13">Active</span>
												</td>
											</tr>

										   

											<tr>
												<td>#2125</td>
												<td><img src="assets/images/product/img-10.png" width="42" class="me-3" alt="">Gray Chair</td>
												<td>Keena Reyes</td>
												<td>SAR 320.00</td>
												<td>65</td>
												<td><span
														class="badge badge-pill badge-soft-success font-size-13">Active</span>
												</td>
											</tr>

											<tr>
												<td>#8587</td>
												<td><img src="assets/images/product/img-11.png" width="42" class="me-3" alt="">Steel Chair</td>
												<td>Timothy Zuniga</td>
												<td>SAR 342.00</td>
												<td>52</td>
												<td><span
														class="badge badge-pill badge-soft-primary font-size-13">Pending</span>
												</td>
											</tr>

											<tr>
												<td>#2354</td>
												<td><img src="assets/images/product/img-12.png" width="42" class="me-3" alt="">Home Chair</td>
												<td>Joann Wiliams</td>
												<td>SAR 320.00</td>
												<td>25</td>
												<td><span
														class="badge badge-pill badge-soft-primary font-size-13">Pending</span>
												</td>
											</tr>
											
											<tr>
												<td>#2354</td>
												<td><img src="assets/images/product/img-12.png" width="42" class="me-3" alt="">Home Chair</td>
												<td>Joann Wiliams</td>
												<td>SAR 320.00</td>
												<td>25</td>
												<td><span
														class="badge badge-pill badge-soft-primary font-size-13">Pending</span>
												</td>
											</tr>
											
											<tr><td colspan="6"><a href="javascript:;">View all</a></td></tr>

										</tbody>
									</table>
								</div>
								<!-- end table-responsive -->
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
                </div>
				<div class="row">
					<div class="col-xl-3 col-md-3">
						<div class="card">
							<a href="<?php echo base_url('store/order/all-orders'); ?>" target="_blank">
								<div class="card-body">
									<div class="text-center">
										<p class="font-size-16">Total Orders</p>
										<div class="mini-stat-icon mx-auto mb-4 mt-3">
											<span class="avatar-title rounded-circle bg-soft-primary">
												<i class="mdi mdi-cart-outline text-primary font-size-20"></i>
											</span>
										</div>
										<h5 class="font-size-22">58</h5>

										<div class="progress mt-3" style="height: 4px;">
											<div class="progress-bar progress-bar bg-primary" role="progressbar" style="width: 70%;" aria-valuenow="70" aria-valuemin="0" aria-valuemax="70"></div>
										</div>
									</div>
								</div>
							</a>
						</div>
					</div>

					<div class="col-xl-3 col-md-3">
						<div class="card">
							<a href="<?php echo base_url('store/order/new-orders'); ?>" target="_blank">
								<div class="card-body">
									<div class="text-center">
										<p class="font-size-16">New Orders</p>
										<div class="mini-stat-icon mx-auto mb-4 mt-3">
											<span class="avatar-title rounded-circle bg-soft-primary">
												<i class="mdi mdi-cart-outline text-primary font-size-20"></i>
											</span>
										</div>
										<h5 class="font-size-22">58</h5>

										<div class="progress mt-3" style="height: 4px;">
											<div class="progress-bar progress-bar bg-primary" role="progressbar" style="width: 70%;" aria-valuenow="70" aria-valuemin="0" aria-valuemax="70"></div>
										</div>
									</div>
								</div>
							</a>
						</div>
					</div>
					
					<div class="col-xl-3 col-md-3">
						<div class="card">
							<a href="<?php echo base_url('store/order/in-process'); ?>" target="_blank">
								<div class="card-body">
									<div class="text-center">
										<p class="font-size-16">In Process</p>
										<div class="mini-stat-icon mx-auto mb-4 mt-3">
											<span class="avatar-title rounded-circle bg-soft-primary">
												<i class="mdi mdi-cart-outline text-primary font-size-20"></i>
											</span>
										</div>
										<h5 class="font-size-22">58</h5>

										<div class="progress mt-3" style="height: 4px;">
											<div class="progress-bar progress-bar bg-primary" role="progressbar" style="width: 70%;" aria-valuenow="70" aria-valuemin="0" aria-valuemax="70"></div>
										</div>
									</div>
								</div>
							</a>
						</div>
					</div>
					
					<div class="col-xl-3 col-md-3">
						<div class="card">
							<a href="<?php echo base_url('store/order/delivered-orders'); ?>" target="_blank">
								<div class="card-body">
									<div class="text-center">
										<p class="font-size-16">Delivered Orders</p>
										<div class="mini-stat-icon mx-auto mb-4 mt-3">
											<span class="avatar-title rounded-circle bg-soft-primary">
												<i class="mdi mdi-cart-outline text-primary font-size-20"></i>
											</span>
										</div>
										<h5 class="font-size-22">58</h5>

										<div class="progress mt-3" style="height: 4px;">
											<div class="progress-bar progress-bar bg-primary" role="progressbar" style="width: 70%;" aria-valuenow="70" aria-valuemin="0" aria-valuemax="70"></div>
										</div>
									</div>
								</div>
							</a>
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
