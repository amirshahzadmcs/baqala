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
	.attendance-setting .mini-stat-icon {
		width: 150px;
		height: 150px;
	}
	.attendance-setting .mini-stat-icon i{
		font-size: 100px;
	}
	.attendance-setting .card:hover {
		box-shadow: 3px 5px 5px #ddd;
	}
	.attendance-setting .avatar-title i {
		color: #005500ad !important;
	}
</style>

<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>App Management</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item active">App Management</li>
					</ol>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- end page title -->

	<div class="container-fluid">
		<div class="page-content-wrapper">
			<div class="row attendance-setting">
				<div class="col-xl-4 col-md-4">
					<a href="<?php echo base_url('admin/app/banner/list'); ?>" target="_blank">
						<div class="card">
							<div class="card-body">
								<div class="text-center">
									<div class="mini-stat-icon mx-auto mb-4 mt-3">
										<span class="avatar-title rounded-circle bg-soft-primary">
											<i class="mdi mdi-camera-burst text-primary"></i>
										</span>
									</div>
									<p class="font-size-18">Home Slider</p>
								</div>
							</div>
						</div>
					</a>
				</div>

				<div class="col-xl-4 col-md-4">
					<a href="<?php echo base_url('admin/app/best-selling/list'); ?>" target="_blank">
						<div class="card">
							<div class="card-body">
								<div class="text-center">
									<div class="mini-stat-icon mx-auto mb-4 mt-3">
										<span class="avatar-title rounded-circle bg-soft-primary">
											<i class="mdi mdi-trending-up text-primary"></i>
										</span>
									</div>
									<p class="font-size-18">Best Selling Category</p>
								</div>
							</div>
						</div>
					</a>
				</div>

				<div class="col-xl-4 col-md-4">
					<a href="<?php echo base_url('admin/app/product-groups/list'); ?>" target="_blank">
						<div class="card">
							<div class="card-body">
								<div class="text-center">
									<div class="mini-stat-icon mx-auto mb-4 mt-3">
										<span class="avatar-title rounded-circle bg-soft-primary">
											<i class="mdi mdi-timer-outline text-primary"></i>
										</span>
									</div>
									<p class="font-size-18">Deals/Trending Products</p>
								</div>
							</div>
						</div>
					</a>
				</div>

				<div class="col-xl-4 col-md-4">
					<a href="<?php echo base_url('admin/app/trending-offers/list'); ?>" target="_blank">
						<div class="card">
							<div class="card-body">
								<div class="text-center">
									<div class="mini-stat-icon mx-auto mb-4 mt-3">
										<span class="avatar-title rounded-circle bg-soft-primary">
											<i class="mdi mdi-flash text-primary"></i>
										</span>
									</div>
									<p class="font-size-18">Trending Offers</p>
								</div>
							</div>
						</div>
					</a>
				</div>

				<div class="col-xl-4 col-md-4">
					<a href="<?php echo base_url('admin/app/offers/list'); ?>" target="_blank">
						<div class="card">
							<div class="card-body">
								<div class="text-center">
									<div class="mini-stat-icon mx-auto mb-4 mt-3">
										<span class="avatar-title rounded-circle bg-soft-primary">
											<i class="mdi mdi-brightness-percent text-primary"></i>
										</span>
									</div>
									<p class="font-size-18">Offer Banner</p>
								</div>
							</div>
						</div>
					</a>
				</div>
			</div> <!-- main row ends -->
		</div> <!-- page content wrapper ends -->
	</div> <!-- container fluid ends -->

<?php $this->load->view('admin/home/footer'); ?>
