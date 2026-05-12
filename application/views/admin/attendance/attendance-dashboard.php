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
					<h4>Dashboard</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Home</a></li>
						<li class="breadcrumb-item active">Attendance Settings</li>
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
					<a href="<?php echo base_url('admin/attendance/holidays-list'); ?>">
						<div class="card">
							<div class="card-body">
								<div class="text-center">
									<div class="mini-stat-icon mx-auto mb-4 mt-3">
										<span class="avatar-title rounded-circle bg-soft-primary">
											<i class="mdi mdi-beach text-primary"></i>
										</span>
									</div>
									<p class="font-size-18">Holiday Lists</p>
								</div>
							</div>
						</div>
					</a>
				</div>

				<div class="col-xl-4 col-md-4">
					<a href="<?php echo base_url('admin/hr/attendance/settings'); ?>">
						<div class="card">
							<div class="card-body">
								<div class="text-center">
									<div class="mini-stat-icon mx-auto mb-4 mt-3">
										<span class="avatar-title rounded-circle bg-soft-primary">
											<i class="mdi mdi-flag-outline text-primary"></i>
										</span>
									</div>
									<p class="font-size-18">Attendance Flags</p>
								</div>
							</div>
						</div>
					</a>
				</div>

				<div class="col-xl-4 col-md-4">
					<a href="<?php echo base_url('admin/attendance/leave-list'); ?>">
						<div class="card">
							<div class="card-body">
								<div class="text-center">
									<div class="mini-stat-icon mx-auto mb-4 mt-3">
										<span class="avatar-title rounded-circle bg-soft-primary">
											<i class="mdi mdi-cursor-pointer text-primary"></i>
										</span>
									</div>
									<p class="font-size-18">Leave Types</p>
								</div>
							</div>
						</div>
					</a>
				</div>

				<div class="col-xl-4 col-md-4">
					<a href="<?php echo base_url('admin/attendance/leave-policy'); ?>">
						<div class="card">
							<div class="card-body">
								<div class="text-center">
									<div class="mini-stat-icon mx-auto mb-4 mt-3">
										<span class="avatar-title rounded-circle bg-soft-primary">
											<i class="mdi mdi-file-document-multiple-outline text-primary"></i>
										</span>
									</div>
									<p class="font-size-18">Leave Policies</p>
								</div>
							</div>
						</div>
					</a>
				</div>

				<div class="col-xl-4 col-md-4">
					<a href="<?php echo base_url('admin/attendance/restriction-list'); ?>">
						<div class="card">
							<div class="card-body">
								<div class="text-center">
									<div class="mini-stat-icon mx-auto mb-4 mt-3">
										<span class="avatar-title rounded-circle bg-soft-primary">
											<i class="mdi mdi-shield-link-variant text-primary"></i>
										</span>
									</div>
									<p class="font-size-18">Attendance Restriction</p>
								</div>
							</div>
						</div>
					</a>
				</div>
			</div> <!-- main row ends -->
		</div> <!-- page content wrapper ends -->
	</div> <!-- container fluid ends -->

<?php $this->load->view('admin/home/footer'); ?>
