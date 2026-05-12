<?php $this->load->view('admin/home/header'); ?>
<style>
	.tile-stats h3 {
		font-weight: 700;
	}

	.table-box {
		border-top: 3px solid #00c0ef;
		box-shadow: 0px 2px 5px #ddd;
		margin: 10px;
	}
</style>


<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Dashboard</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item active">Home</li>
					</ol>
				</div>
			</div>
			<!-- <div class="col-sm-6">
				<div class="float-end d-none d-sm-block">
					<a href="" class="btn btn-success">Add Widget</a>
				</div>
				</div> -->
		</div>
	</div>
</div>
<!-- end page title -->

<?php //print_r($total_users[0]['total']);exit();
?>

<div class="container-fluid">

	<div class="page-content-wrapper">

		<div class="row">
			<?php if (check_action_permission(get_user_role(), 'dashboard', 'view')) {?>
			<div class="col-xl-12">

				<div class="row">

					<div class="col-xl-3 col-md-3">
						<div class="card">

							<div class="card-body">
								<div class="text-center">
									<!-- <a href="<?php //echo base_url();
													?>admin/user"><p class="font-size-16">Stores</p></a> -->
									<a href="<?php echo base_url(); ?>admin/store/list">
										<p class="font-size-16">Stores</p>
									</a>
									<div class="mini-stat-icon mx-auto mb-4 mt-3">
										<span class="avatar-title rounded-circle bg-soft-success">
											<i class="fas fa-store text-success font-size-20"></i>
										</span>
									</div>
									<!-- <h5 class="font-size-22"><?php //echo $total_users[0]['total']; 
																	?></h5> -->
									<h5 class="font-size-22">1</h5>
									<!-- <div class="progress mt-3" style="height: 4px;">
										<div class="progress-bar progress-bar bg-primary" role="progressbar" style="width: {{count(DB::table('orders')->get())}}%;" aria-valuenow="{{count(DB::table('orders')->get())}}" aria-valuemin="0" aria-valuemax="{{count(DB::table('orders')->get())}}"></div>
										</div> -->
								</div>
							</div>

						</div>
					</div>

					<div class="col-xl-3 col-md-3">
						<div class="card">

							<div class="card-body">
								<div class="text-center">
									<a href="<?php echo base_url(); ?>admin/brand">
										<p class="font-size-16">Brands</p>
									</a>
									<div class="mini-stat-icon mx-auto mb-4 mt-3">
										<span class="avatar-title rounded-circle bg-soft-success">
											<i class="fab fa-gg text-success font-size-20"></i>
										</span>
									</div>
									<h5 class="font-size-22">1</h5>
									<!-- <div class="progress mt-3" style="height: 4px;">
										<div class="progress-bar progress-bar bg-primary" role="progressbar" style="width: {{count(DB::table('orders')->get())}}%;" aria-valuenow="{{count(DB::table('orders')->get())}}" aria-valuemin="0" aria-valuemax="{{count(DB::table('orders')->get())}}"></div>
										</div> -->
								</div>
							</div>

						</div>
					</div>
					<div class="col-xl-3 col-md-3">
						<div class="card">
							<div class="card-body">
								<div class="text-center">
									<a href="<?php echo base_url(); ?>admin/category">
										<p class="font-size-16">Category</p>
									</a>
									<div class="mini-stat-icon mx-auto mb-4 mt-3">
										<span class="avatar-title rounded-circle bg-soft-success">
											<i class="fas fa-sitemap text-success font-size-20"></i>
										</span>
									</div>
									<h5 class="font-size-22"><?php echo $total_category[0]['total']; ?></h5>
									<!-- <div class="progress mt-3" style="height: 4px;">
										<div class="progress-bar progress-bar bg-primary" role="progressbar" style="width: {{count(DB::table('orders')->get())}}%;" aria-valuenow="{{count(DB::table('orders')->get())}}" aria-valuemin="0" aria-valuemax="{{count(DB::table('orders')->get())}}"></div>
										</div> -->
								</div>
							</div>

						</div>
					</div>


					<div class="col-xl-3 col-md-3">
						<div class="card">

							<div class="card-body">
								<div class="text-center">
									<a href="<?php echo base_url(); ?>admin/product">
										<p class="font-size-16">Products</p>
									</a>
									<div class="mini-stat-icon mx-auto mb-4 mt-3">
										<span class="avatar-title rounded-circle bg-soft-success">
											<i class="fa fa-gift text-success font-size-20"></i>
										</span>
									</div>
									<h5 class="font-size-22"><?php echo $total_product[0]['total']; ?></h5>
									<!-- <div class="progress mt-3" style="height: 4px;">
										<div class="progress-bar progress-bar bg-primary" role="progressbar" style="width: {{count(DB::table('orders')->get())}}%;" aria-valuenow="{{count(DB::table('orders')->get())}}" aria-valuemin="0" aria-valuemax="{{count(DB::table('orders')->get())}}"></div>
										</div> -->
								</div>
							</div>
						</div>
					</div>


				</div> <!-- row 1 ends -->

				<!-- <div class="row">

					<div class="col-xl-3 col-md-3">
						<div class="card">

							<div class="card-body">
								<div class="text-center">
									<a href="<?php echo base_url(); ?>admin/partner"><p class="font-size-16">Partners</p></a>
									<div class="mini-stat-icon mx-auto mb-4 mt-3">
										<span class="avatar-title rounded-circle bg-soft-primary">
										<i class="fas fa-truck text-primary font-size-20"></i>
										</span>
									</div>
									<h5 class="font-size-22"><?php echo $total_partner[0]['total']; ?></h5>

								</div>
							</div>
						</div>
					</div>

					<div class="col-xl-3 col-md-3">
						<div class="card">

							<div class="card-body">
								<div class="text-center">
									<a href="<?php echo base_url(); ?>admin/Credit_account"><p class="font-size-16">Credit Accounts</p></a>
									<div class="mini-stat-icon mx-auto mb-4 mt-3">
										<span class="avatar-title rounded-circle bg-soft-primary">
										<i class="far fa-credit-card text-primary font-size-20"></i>
										</span>
									</div>
									<h5 class="font-size-22"><?php echo $total_credit_ac[0]['total']; ?></h5>

								</div>
							</div>
						</div>
					</div>


					</div> -->
				<!-- row 2 ends -->

				<div class="row">
					<?php if (check_action_permission($this->session->userdata('role'), 'order', 'index')): ?>
						<div class="col-xl-9">
							<div class="card">
								<div class="card-body">
									<div class="row">
										<div class="col-xl-10">
											<h4 class="header-title mb-4">New Orders</h4>
										</div>
										<div class="col-xl-2">
											<div class="float-sm-end">
												<ul class="nav nav-pills">
													<li class="nav-item">
														<a class="nav-link active btn-sm" href="<?php echo base_url(); ?>admin/order_process">View All</a>
													</li>
												</ul>
											</div>
										</div>


									</div>


									<div class="table-responsive">
										<table class="table table-centered table-nowrap mb-0">
											<thead class="thead-light">
												<tr>
													<th style="width: 10px;">#</th>
													<th>Order ID</th>
													<th>Customer Name</th>
													<th>Total Price</th>
													<th>Payment Method</th>
													<th style="width: 40px;">Status</th>
												</tr>
											</thead>
											<tbody>
												<?php if (count($new_orders) > 0) { ?>
													<?php $o_count = 1;
													foreach ($new_orders as $neworder) { ?>
														<tr>
															<td><?php echo $o_count; ?></td>
															<td><?php echo $neworder->id; ?></td>
															<td><?php echo $neworder->name; ?></td>
															<td><?php echo $neworder->order_total; ?></td>
															<td><?php echo $neworder->payment_method; ?></td>
															<td>
																<?php if ($neworder->order_status_id == '0') {
																	echo '<div class="badge bg-info p-2">Payment Pending</div>';
																}
																if ($neworder->order_status_id == '1') {
																	echo '<div class="badge bg-primary p-2">Recieved</div>';
																}

																if ($neworder->order_status_id == '2') {
																	echo '<div class="badge bg-primary">Accepted</div>';
																}
																if ($neworder->order_status_id == '3') {
																	echo '<div class="badge bg-danger">Cancel By Admin</div>';
																}
																if ($neworder->order_status_id == '4') {
																	echo '<div class="badge bg-primary">Van Assigned</div>';
																}
																if ($neworder->order_status_id == '5') {
																	echo '<div class="badge bg-info">Dispatched</div>';
																}

																if ($neworder->order_status_id == '6') {
																	echo '<div class="badge bg-success">Delivered</div>';
																}

																if ($neworder->order_status_id == '7') {
																	echo '<div class="badge bg-warning">Cancel On Delivery</div>';
																}

																if ($neworder->order_status_id == '8') {
																	echo '<div class="badge bg-warning">Refund</div>';
																}

																if ($neworder->order_status_id == '9') {
																	echo '<div class="badge bg-danger">Cancel By Customer</div>';
																}

																?>
														</tr>
													<?php $o_count++;
													}
												} else { ?>
													<tr>
														<td colspan="6" align="center">No new orders</td>
													</tr>
												<?php } ?>
											</tbody>
										</table>
									</div>
									<!-- end table-responsive -->
								</div>

							</div>
						<?php endif; ?>
						</div>

						<div class="col-xl-3 col-md-3">
							<div class="card">


								<div class="card-body">
									<div class="text-center">
										<a href="<?php echo base_url(); ?>admin/order_process">
											<p class="font-size-16">Orders</p>
										</a>
										<div class="mini-stat-icon mx-auto mb-4 mt-3">
											<span class="avatar-title rounded-circle bg-soft-success">
												<i class="ti-shopping-cart text-success font-size-20"></i>
											</span>
										</div>
										<h5 class="font-size-22"><?php echo $total_orders[0]['total']; ?></h5>
										<!-- <div class="progress mt-3" style="height: 4px;">
										<div class="progress-bar progress-bar bg-primary" role="progressbar" style="width: {{count(DB::table('orders')->get())}}%;" aria-valuenow="{{count(DB::table('orders')->get())}}" aria-valuemin="0" aria-valuemax="{{count(DB::table('orders')->get())}}"></div>
										</div> -->
									</div>
								</div>
							</div>
						</div>
				</div> <!-- New Products Ends -->

				<div class="row">
					<div class="col-xl-12">
						<div class="card">
							<div class="card-body">



								<h4 class="header-title mb-4 float-sm-start">Quick Summary</h4>

								<div class="float-sm-end">
									<ul class="nav nav-pills">
										<li class="nav-item">
											<a class="nav-link" href="javascript:;">Day</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" href="javascript:;">Week</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" href="javascript:;">Month</a>
										</li>
										<li class="nav-item">
											<a class="nav-link active" href="javascript:;">Year</a>
										</li>
									</ul>
								</div>

								<div class="clearfix"></div>


								<div class="row align-items-center">
									<div class="col-xl-9">

										<div>
											<div id="stacked-column-chart" class="apex-charts" dir="ltr"></div>
										</div>

									</div>


									<div class="col-xl-3">
										<div class="dash-info-widget mt-4 mt-lg-0 py-4 px-3 rounded">



											<div class="media dash-main-border pb-2 mt-2">
												<div class="avatar-sm mb-3 mt-2">
													<span class="avatar-title rounded-circle bg-white shadow">
														<i class="mdi mdi-currency-rial text-success font-size-18"></i>
													</span>
												</div>
												<div class="media-body ps-3">

													<h4 class="font-size-20"><i class="mdi mdi-currency-rial text-success font-size-18"></i> 2354</h4>
													<p class="text-muted">Earning <a href="javascript:;" class="text-success">Withdraw <i class="mdi mdi-arrow-right"></i></a>
													</p>

												</div>

											</div>





											<div class="media mt-4 dash-main-border pb-2">
												<div class="avatar-sm mb-3 mt-2">
													<span class="avatar-title rounded-circle bg-white shadow">
														<i class="mdi mdi-credit-card-outline text-success font-size-18"></i>
													</span>
												</div>
												<div class="media-body ps-3">
													<h4 class="font-size-20"><i class="mdi mdi-currency-rial text-success font-size-18"></i> 1598</h4>
													<p class="text-muted">To Paid <a href="javascript:;" class="text-success">Pay <i class="mdi mdi-arrow-right"></i></a></p>
												</div>
											</div>



											<div class="media mt-4">
												<div class="avatar-sm mb-2 mt-2">
													<span class="avatar-title rounded-circle bg-white shadow">
														<i class="mdi mdi-eye-outline text-success font-size-18"></i>
													</span>
												</div>
												<div class="media-body ps-3">
													<h4 class="font-size-20">1230</h4>
													<p class="text-muted mb-0">To Online <a href="javascript:;" class="text-success">View <i class="mdi mdi-arrow-right"></i></a></p>
												</div>
											</div>
										</div>
									</div>


								</div>


							</div>
						</div>
					</div>
					<div class="col-xl-6">
						<div class="card">
							<div class="card-body">
								<h4 class="header-title mb-4">Revenue Stastics</h4>

								<div class="media">

									<h4><i class="mdi mdi-currency-rial text-success font-size-18"></i> 14,235 </h4>


									<div class="media-body ps-3">

										<div class="dropdown">
											<button class="btn btn-light btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												Today<i class="mdi mdi-chevron-down ms-1"></i>
											</button>
											<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
												<a class="dropdown-item" href="javascript:;">Yesterday</a>
												<a class="dropdown-item" href="javascript:;">Last Week</a>
												<a class="dropdown-item" href="javascript:;">last Month</a>
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
					<div class="col-xl-6">
						<div class="card">
							<div class="card-body">
								<h4 class="header-title mb-4">Earning Goal</h4>
								<div class="mt-2 text-center">

									<div class="row">
										<div class="col-md-6">
											<div class="mt-4 mt-sm-0">
												<div id="list-chart-1" class="apex-charts" dir="ltr"></div>
												<p class="text-muted mb-2 mt-2 pt-1">Total Earning:</p>
												<h5 class="font-size-18 mb-1"><i class="mdi mdi-currency-rial text-success font-size-18"></i> 13,545.65</h5>
											</div>
										</div>

										<div class="col-md-6 dash-goal">
											<div class="mt-4 mt-sm-0">
												<div id="list-chart-2" class="apex-charts" dir="ltr"></div>
												<p class="text-muted mb-2 mt-2 pt-1">Earning Goal:</p>
												<h5 class="font-size-18 mb-1"><i class="mdi mdi-currency-rial text-success font-size-18"></i> 84,265.45</h5>
											</div>
										</div>
									</div>

								</div>

							</div>
						</div>
					</div>
				</div>
			</div> <!-- Quick summary ends -->
			<?php } ?>
		</div><!-- col xs-12 ends -->
	</div> <!-- main row ends -->

</div> <!-- page content wrapper ends -->

<?php $this->load->view('admin/home/footer'); ?>