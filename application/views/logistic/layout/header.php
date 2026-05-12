<?php $this->load->helper('text'); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Logistic Partner | <?php echo WEBSITE_NAME; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta content="" name="description" />
        <meta content="" name="author" />
		<base href="<?php echo base_url();?>" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="<?php echo base_url('store_assets/images/favicon.ico');?>" />

        <!-- plugin css -->
        <link href="<?php echo base_url('store_assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css');?>" rel="stylesheet" type="text/css" />

        <!-- Bootstrap Css -->
        <link href="<?php echo base_url('store_assets/css/bootstrap.min.css');?>" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="<?php echo base_url('store_assets/css/icons.min.css');?>" rel="stylesheet" type="text/css" />
		
		<!-- select2  -->
		<link href="<?php echo base_url('store_assets/libs/select2/css/select2.min.css');?>" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url('store_assets/libs/spectrum-colorpicker2/spectrum.min.css');?>" rel="stylesheet" type="text/css">
		<!-- dropzone css -->
		<link href="<?php echo base_url('store_assets/libs/dropzone/min/dropzone.min.css');?>" rel="stylesheet" type="text/css" />
		<!-- Sweet Alert-->
		<link href="<?php echo base_url('store_assets/libs/sweetalert2/sweetalert2.min.css');?>" rel="stylesheet" type="text/css" />
		<!-- DataTables -->
		<link href="<?php echo base_url('store_assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css');?>" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url('store_assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css');?>" rel="stylesheet" type="text/css" />
		<!-- Responsive datatable examples -->
		<link href="<?php echo base_url('store_assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css');?>" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url('store_assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css');?>" rel="stylesheet">
		<!-- App Css-->
		<link href="<?php echo base_url('store_assets/css/app.css');?>" id="app-style" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url('store_assets/css/custom.css');?>" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url('store_assets/css/progress-bar.css');?>" rel="stylesheet" type="text/css" />
		
		<link href="https://fonts.googleapis.com/css2?family=Exo:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    </head>

    <body data-topbar="light" data-layout="vertical">
        <!-- Loader -->
        <div id="preloader">
            <div id="status">
                <div class="spinner-chase">
                    <div class="chase-dot"></div>
                    <div class="chase-dot"></div>
                    <div class="chase-dot"></div>
                    <div class="chase-dot"></div>
                    <div class="chase-dot"></div>
                    <div class="chase-dot"></div>
                </div>
            </div>
        </div>
        <!-- Begin page -->
        <div id="layout-wrapper">
            <header id="page-topbar">
                <div class="navbar-header">
                    <div class="d-flex">
                        <!-- LOGO -->
                        <div class="navbar-brand-box d-flex justify-content-center">
                            <?php $sess_logistic_name = $this->session->userdata('logistic_name');?>
                            <a href="<?php echo base_url('logistic-partner'); ?>" class="logo logo-dark" style="font-size: 25px;">
                                <span class="logo-sm">
                                    <img src="<?php echo base_url('admin_assets/images/favicon.ico');?>" alt="" height="22" />
                                </span>
                                <span class="logo-lg">
                                    <span style="vertical-align: top;">Baqala Station</span>
                                </span>
                            </a>
                        </div>
                        <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect" id="vertical-menu-btn">
							<i class="mdi mdi-menu"></i>
						</button>
                    </div>

                    <!-- Search input -->
                    <div class="search-wrap" id="search-wrap">
                        <div class="search-bar">
                            <input class="search-input form-control" placeholder="Search" />
                            <a href="javascript:;" class="close-search toggle-search" data-target="#search-wrap">
                                <i class="mdi mdi-close-circle"></i>
                            </a>
                        </div>
                    </div>

                    <div class="d-flex">
                        <div class="dropdown d-none d-lg-inline-block">
                            <button type="button" class="btn header-item toggle-search noti-icon waves-effect" data-target="#search-wrap">
                                <i class="mdi mdi-magnify"></i>
                            </button>
                        </div>

                        <div class="dropdown d-none d-lg-inline-block ms-1">
                            <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                                <i class="mdi mdi-fullscreen"></i>
                            </button>
                        </div>

                        <div class="dropdown d-inline-block">
                            <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="mdi mdi-bell-outline bx-tada"></i>
                                <span class="badge bg-danger rounded-pill">1</span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-notifications-dropdown">
                                <div class="p-3">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h6 class="m-0">Notifications</h6>
                                        </div>
                                        <div class="col-auto">
                                            <a href="javasript:;" class="small"> View All</a>
                                        </div>
                                    </div>
                                </div>
                                <div data-simplebar style="max-height: 230px;">
                                    <a href="javasript:;" class="text-reset notification-item">
                                        <div class="media">
                                            <div class="avatar-xs me-3">
                                                <span class="avatar-title bg-primary rounded-circle font-size-16">
                                                    <i class="mdi mdi-receipt text-white"></i>
                                                </span>
                                            </div>
                                            <div class="media-body">
                                                <h6 class="mt-0 mb-1">Your Pending</h6>
                                                <div class="font-size-13 text-muted">
                                                    <p class="mb-1">Your application is pending, please complete your application</p>
                                                    <p class="mb-0"><i class="mdi mdi-clock-outline"></i> 3 min ago</p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                    
                                </div>
                                <div class="p-2 border-top">
                                    <a class="btn btn-sm btn-link font-size-14 w-100 text-center" href="javascript:void(0)"> <i class="mdi mdi-arrow-right-circle me-1"></i> View More.. </a>
                                </div>
                            </div>
                        </div>

                        <div class="dropdown d-inline-block">
                            <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="rounded-circle header-profile-user" src="<?php echo base_url('store_assets/images/users/avatar.png');?>" alt="<?php echo $sess_logistic_name;?>" />
                                <span class="d-none d-xl-inline-block ms-1"><?php echo $sess_logistic_name;?></span>
                                <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- item-->
                                <a class="dropdown-item" href="<?php echo base_url('logistic-partner/profile')?>"><i class="mdi mdi-account-circle-outline font-size-16 align-middle me-1"></i> Profile</a>
                                <a class="dropdown-item d-block" href="<?php echo base_url('logistic-partner/change-password')?>"><i class="mdi mdi-cog-outline font-size-16 align-middle me-1"></i> Change Password</a>
                                <!--<a class="dropdown-item" href="javascript: void(0);"><i class="mdi mdi-lock-open-outline font-size-16 align-middle me-1"></i> Lock screen</a>-->
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger" href="<?php echo base_url('logistic-partner/logout')?>"><i class="mdi mdi-power font-size-16 align-middle me-1 text-danger"></i> Logout</a>
                            </div>
                        </div>
				
                    </div>
                </div>
            </header>
            <!-- ========== Left Sidebar Start ========== -->
			<div class="vertical-menu">
				<div data-simplebar class="h-100">
					<div class="user-sidebar text-center">
						<div class="dropdown">
							<div class="user-img">
								<img src="admin_assets/images/favicon.ico" width="30px" alt="" class="rounded-circle" />
								<span class="avatar-online bg-success"></span>
							</div>
							<?php $admin_id= $this->session->userdata('admin_id'); ?>
							<div class="user-info">
								<h5 class="mt-3 font-size-16 text-dark"><?php $sess_logistic_name = $this->session->userdata('logistic_name');echo word_limiter($sess_logistic_name,5);?></h5>
								<span class="font-size-13 text-dark">Logistic Partner</span>
							</div>
						</div>
					</div>

					<!--- Sidemenu -->
					<div id="sidebar-menu">
						<!-- Left Menu Start -->
						<ul class="metismenu list-unstyled" id="side-menu">
							<li class="menu-title">General</li>

							<li>
								<a href="<?php echo base_url('logistic-partner'); ?>" class="waves-effect">
									<i class="dripicons-view-thumb"></i><span>Dashboard</span>
								</a>
							</li>
                            <li>
								<a href="<?= base_url('logistic-partner/org-tracking'); ?>" class="waves-effect">
									<i class="mdi mdi-car-arrow-right"></i><span>Org Tracking</span>
								</a>
							</li>
                            <li>
								<a href="<?= base_url('logistic-partner/organization-payment'); ?>" class="waves-effect">
									<i class="mdi mdi-wallet-outline"></i><span>Payment</span>
								</a>
							</li>
                            <li>
								<a href="<?= base_url('logistic-partner/account-payment-report'); ?>" class="waves-effect">
									<i class="mdi mdi-script-text-outline"></i><span>Payment Reports</span>
								</a>
							</li>
                            <li>
								<a href="<?= base_url('logistic-partner/sdp/dashboard'); ?>" class="waves-effect">
									<i class="ti-dashboard"></i><span>Dashboard SDP</span>
								</a>
							</li>
                            <li>
								<a href="<?= base_url('logistic-partner/sdp/report'); ?>" class="waves-effect">
									<i class="ti-receipt"></i><span>Reports Sdp</span>
								</a>
							</li>
							<li>
								<a href="<?= base_url('logistic-partner/rider/list'); ?>" class="waves-effect">
									<i class="mdi mdi-badge-account-outline"></i><span>Driver Management</span>
								</a>
							</li>
                            
						</ul>
					</div>
					<!-- Sidebar -->
				</div>
			</div>
			<!-- Left Sidebar End -->
        
