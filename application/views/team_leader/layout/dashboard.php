<?php $this->load->view('team_leader/layout/header'); ?>
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
					<?php $this->load->view('agency/partials/alert'); ?>
					<div class="col-xl-12">
						<div class="card">
							<div class="card-body">
								<div class="card-title mb-4 mx-3">
									<h4 class="header-title">Team Leader Dashboard</h4>
									<small>Here you can manage your Team and Shifts</small>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xl-4 col-md-6">
						<div class="card">
							<div class="card-body">
								<div class="text-center">
									<a href="<?php echo base_url('hiring-agency/cv/list'); ?>">
										<p class="font-size-16">Your Team</p>
									</a>
									<div class="mini-stat-icon mx-auto mb-4 mt-3">
										<span class="avatar-title rounded-circle bg-soft-success">
											<i class="mdi mdi-file-document-edit-outline text-success font-size-20"></i>
										</span>
									</div>
									<h5 class="font-size-22"><?php echo $team; ?></h5>
								</div>
							</div>
						</div>
					</div>

					<div class="col-xl-4 col-md-6">
						<div class="card">
							<div class="card-body">
								<div class="text-center">
									<a href="<?php echo base_url('hiring-agency/cv/filter/shortlisted'); ?>">
										<p class="font-size-16">Today Shift</p>
									</a>
									<div class="mini-stat-icon mx-auto mb-4 mt-3">
										<span class="avatar-title rounded-circle bg-soft-success">
											<i class="mdi mdi-file-check text-success font-size-20"></i>
										</span>
									</div>
									<h5 class="font-size-22"><?php echo $today_shift; ?></h5>
								</div>
							</div>
						</div>
					</div>

					<div class="col-xl-4 col-md-6">
						<div class="card">
							<div class="card-body">
								<div class="text-center">
									<a href="<?php echo base_url('hiring-agency/cv/filter/shortlisted'); ?>">
										<p class="font-size-16">Today Delivery</p>
									</a>
									<div class="mini-stat-icon mx-auto mb-4 mt-3">
										<span class="avatar-title rounded-circle bg-soft-success">
											<i class="mdi mdi-file-check text-success font-size-20"></i>
										</span>
									</div>
									<h5 class="font-size-22">0</h5>
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

<?php $this->load->view('team_leader/layout/footer'); ?>

<?php $this->load->view('team_leader/layout/mobile_header'); ?>
<div class="header-part">
	<div class="d-flex justify-content-between align-items-center">
		<div class="title-part">
			<h2>
				<b>BS</b> Team Leader
			</h2>
			<p>Dashboard</p>
		</div>
		<div class="dropdown d-inline-block">
			<button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
					<circle cx="18" cy="15" r="4.5" fill="#35B366"></circle>
					<circle cx="18" cy="18" r="13.5" stroke="#FFCD02" stroke-width="1.2"></circle>
					<path d="M26.8078 28.2124C26.9233 28.1202 26.9699 27.9654 26.9178 27.827C26.354 26.3277 25.2201 25.0059 23.6721 24.0499C22.0449 23.0448 20.0511 22.5 18 22.5C15.9489 22.5 13.9551 23.0448 12.3279 24.0498C10.7799 25.0059 9.64599 26.3277 9.08216 27.827C9.03013 27.9654 9.07672 28.1202 9.1922 28.2124C14.3429 32.3279 21.6571 32.3279 26.8078 28.2124Z" fill="white" stroke="#35B366" stroke-width="1.2" stroke-linecap="round"></path>
				</svg>
				<i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
			</button>
			<div class="dropdown-menu dropdown-menu-end">
				<!-- item-->
				<a class="dropdown-item" href="javascript:void(0)">
					<i class="mdi mdi-account-circle-outline font-size-16 align-middle me-1"></i> Profile </a>
				<a class="dropdown-item d-block" href="javascript:void(0)">
					<i class="mdi mdi-cog-outline font-size-16 align-middle me-1"></i> Change Password </a>
				<!--<a class="dropdown-item" href="javascript: void(0);"><i class="mdi mdi-lock-open-outline font-size-16 align-middle me-1"></i> Lock screen</a>-->
				<div class="dropdown-divider"></div>
				<a class="dropdown-item text-danger" href="<?php echo base_url('team-leader/logout') ?>">
					<i class="mdi mdi-power font-size-16 align-middle me-1 text-danger"></i> Logout </a>
			</div>
		</div>
	</div>
</div>
<div class="container mt-3">
	<div class="row">
		<div class="col-sm-6 w-50 p-1">
			<div class="item-1 text-center">
				<div class="svg">
					<svg width="35" height="35" viewBox="0 0 35 35" fill="none" xmlns="http://www.w3.org/2000/svg">
						<circle cx="17.5" cy="11.6667" r="3.875" stroke="#35B366" stroke-linecap="round" />
						<path d="M19.8798 9.36457C20.1909 8.82574 20.6548 8.39126 21.2128 8.11608C21.7708 7.84089 22.3979 7.73736 23.0148 7.81857C23.6316 7.89978 24.2106 8.16209 24.6784 8.57233C25.1461 8.98256 25.4818 9.5223 25.6428 10.1233C25.8038 10.7243 25.783 11.3595 25.5831 11.9487C25.3831 12.5379 25.0128 13.0545 24.5192 13.4332C24.0256 13.812 23.4308 14.0359 22.8099 14.0766C22.1891 14.1173 21.5701 13.973 21.0313 13.6619" stroke="#35B366" />
						<path d="M15.1202 9.36457C14.8091 8.82574 14.3452 8.39126 13.7872 8.11608C13.2292 7.84089 12.6021 7.73736 11.9852 7.81857C11.3684 7.89978 10.7894 8.16209 10.3216 8.57233C9.85385 8.98256 9.51822 9.5223 9.35719 10.1233C9.19616 10.7243 9.21695 11.3595 9.41695 11.9487C9.61694 12.5379 9.98716 13.0545 10.4808 13.4332C10.9744 13.812 11.5692 14.0359 12.1901 14.0766C12.8109 14.1173 13.4299 13.973 13.9687 13.6619" stroke="#35B366" />
						<path d="M17.5 18.2292C23.8382 18.2292 25.1679 23.6931 25.4468 25.9855C25.5135 26.5338 25.0731 26.9792 24.5208 26.9792H10.4792C9.92688 26.9792 9.4865 26.5338 9.55321 25.9855C9.83213 23.6931 11.1618 18.2292 17.5 18.2292Z" stroke="#35B366" stroke-linecap="round" />
						<path d="M28.2549 22.9751L27.7659 23.0791L27.7659 23.0791L28.2549 22.9751ZM19.0853 18.3545L18.7161 18.0173L18.0957 18.6969L19.0034 18.8477L19.0853 18.3545ZM25.0561 24.0625L24.5758 24.2015L24.6802 24.5625H25.0561V24.0625ZM22.6042 17.2708C24.3191 17.2708 25.4863 18.1846 26.3008 19.3906C27.1243 20.6098 27.5551 22.0881 27.7659 23.0791L28.744 22.8711C28.5224 21.8295 28.0581 20.2057 27.1295 18.8309C26.192 17.4429 24.7499 16.2708 22.6042 16.2708V17.2708ZM19.4546 18.6916C20.2199 17.8534 21.2321 17.2708 22.6042 17.2708V16.2708C20.9042 16.2708 19.6367 17.009 18.7161 18.0173L19.4546 18.6916ZM19.0034 18.8477C22.4842 19.4261 23.949 22.0351 24.5758 24.2015L25.5364 23.9236C24.8606 21.5876 23.1975 18.531 19.1673 17.8612L19.0034 18.8477ZM27.3325 23.5625H25.0561V24.5625H27.3325V23.5625ZM27.7659 23.0791C27.816 23.315 27.6393 23.5625 27.3325 23.5625V24.5625C28.2089 24.5625 28.94 23.7925 28.744 22.8711L27.7659 23.0791Z" fill="#35B366" />
						<path d="M15.9147 18.3545L15.9966 18.8477L16.9043 18.6969L16.2839 18.0173L15.9147 18.3545ZM6.74506 22.9751L7.23411 23.0791L7.23411 23.0791L6.74506 22.9751ZM9.94394 24.0625V24.5625H10.3198L10.4242 24.2015L9.94394 24.0625ZM12.3958 17.2708C13.7679 17.2708 14.7801 17.8534 15.5454 18.6916L16.2839 18.0173C15.3633 17.009 14.0958 16.2708 12.3958 16.2708V17.2708ZM7.23411 23.0791C7.44493 22.0881 7.87568 20.6098 8.69918 19.3906C9.51375 18.1846 10.6809 17.2708 12.3958 17.2708V16.2708C10.2501 16.2708 8.80805 17.4429 7.8705 18.8309C6.94187 20.2057 6.47758 21.8295 6.256 22.871L7.23411 23.0791ZM7.6675 23.5625C7.36066 23.5625 7.18393 23.315 7.23411 23.0791L6.256 22.871C6.05998 23.7925 6.7911 24.5625 7.6675 24.5625V23.5625ZM9.94394 23.5625H7.6675V24.5625H9.94394V23.5625ZM10.4242 24.2015C11.051 22.0351 12.5158 19.4261 15.9966 18.8477L15.8327 17.8612C11.8025 18.531 10.1394 21.5876 9.46364 23.9236L10.4242 24.2015Z" fill="#35B366" />
					</svg>
				</div>
				<h4>Your Team</h4>
				<p><?php echo $team; ?></p>
			</div>
		</div>
		<div class=" col-sm-6 w-50 p-1">
			<div class="item-1 text-center">
				<div class="svg">
					<svg width="35" height="35" viewBox="0 0 35 35" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path fill-rule="evenodd" clip-rule="evenodd" d="M10.8958 5.83658C8.08873 5.8564 6.55378 5.99771 5.54657 7.00492C4.375 8.17649 4.375 10.0621 4.375 13.8333V14.0833C4.375 14.319 4.375 14.4369 4.44822 14.5101C4.52145 14.5833 4.6393 14.5833 4.875 14.5833H30.125C30.3607 14.5833 30.4786 14.5833 30.5518 14.5101C30.625 14.4369 30.625 14.319 30.625 14.0833V13.8333C30.625 10.0621 30.625 8.17649 29.4534 7.00492C28.4462 5.99771 26.9113 5.8564 24.1042 5.83658L24.1042 9.47917C24.1042 10.3076 23.4326 10.9792 22.6042 10.9792C21.7757 10.9792 21.1042 10.3076 21.1042 9.47918L21.1042 5.83334H13.8958L13.8958 9.47917C13.8958 10.3076 13.2243 10.9792 12.3958 10.9792C11.5674 10.9792 10.8958 10.3076 10.8958 9.47918L10.8958 5.83658Z" fill="#35B366" />
						<path d="M4.375 16.5417C4.375 16.306 4.375 16.1881 4.44822 16.1149C4.52145 16.0417 4.6393 16.0417 4.875 16.0417H30.125C30.3607 16.0417 30.4786 16.0417 30.5518 16.1149C30.625 16.1881 30.625 16.306 30.625 16.5417V21.1667C30.625 24.9379 30.625 26.8235 29.4534 27.9951C28.2819 29.1667 26.3962 29.1667 22.625 29.1667H12.375C8.60376 29.1667 6.71815 29.1667 5.54657 27.9951C4.375 26.8235 4.375 24.9379 4.375 21.1667V16.5417Z" fill="#7E869E" fill-opacity="0.25" />
						<path d="M12.3958 3.64584L12.3958 9.47918" stroke="#222222" stroke-linecap="round" />
						<path d="M22.6042 3.64584L22.6042 9.47918" stroke="#222222" stroke-linecap="round" />
					</svg>
				</div>
				<h4>Today Shift</h4>
				<p><?php echo $today_shift; ?></p>
			</div>
		</div>
		<div class="col-sm-6 w-50 mt-2 p-1">
			<div class="item-1 text-center">
				<svg width="35" height="35" viewBox="0 0 35 35" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M13.125 17.5C13.125 18.6603 13.5859 19.7731 14.4064 20.5936C15.2269 21.4141 16.3397 21.875 17.5 21.875C18.6603 21.875 19.7731 21.4141 20.5936 20.5936C21.4141 19.7731 21.875 18.6603 21.875 17.5" stroke="#35B366" stroke-linecap="round" />
					<path d="M6.5625 12.1486C6.5625 11.5475 6.5625 11.2469 6.64832 10.9635C6.73413 10.6801 6.90085 10.43 7.2343 9.9298L8.2917 8.3437C8.87299 7.47177 9.16363 7.0358 9.60582 6.79915C10.048 6.5625 10.572 6.5625 11.6199 6.5625H23.3801C24.428 6.5625 24.952 6.5625 25.3942 6.79915C25.8364 7.0358 26.127 7.47177 26.7083 8.3437L27.7657 9.9298C28.0991 10.43 28.2659 10.6801 28.3517 10.9635C28.4375 11.2469 28.4375 11.5475 28.4375 12.1486V24.4375C28.4375 26.3231 28.4375 27.2659 27.8517 27.8517C27.2659 28.4375 26.3231 28.4375 24.4375 28.4375H10.5625C8.67688 28.4375 7.73407 28.4375 7.14829 27.8517C6.5625 27.2659 6.5625 26.3231 6.5625 24.4375V12.1486Z" stroke="#35B366" />
					<path d="M6.5625 13.8542H28.4375" stroke="#35B366" stroke-linecap="round" />
				</svg>
				<h4>Today Delivery</h4>
				<p>0</p>
			</div>
		</div>
		<div class=" col-sm-6 w-50 mt-2 p-1">
			<a href="<?php echo base_url('team-leader/hunger/team'); ?>" class="backfire">
				<div class="item-1 back-2 text-center">
					<h4>View Team</h4>
				</div>
			</a>
		</div>
	</div>
</div>
<?php $this->load->view('team_leader/layout/mobile_footer'); ?>