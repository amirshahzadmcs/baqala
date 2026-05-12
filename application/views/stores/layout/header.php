<?php $this->load->helper('text'); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title><?php $sess_firm_name = $this->session->userdata('stores_name');echo word_limiter($sess_firm_name,5);?> | <?php echo WEBSITE_NAME; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesdesign" name="author" />
		<base href="<?php echo base_url();?>" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="<?php echo base_url('store_assets/images/favicon.ico');?>" />

        <!-- plugin css -->
        <link href="<?php echo base_url('store_assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css');?>" rel="stylesheet" type="text/css" />

        <!-- Bootstrap Css -->
        <link href="<?php echo base_url('store_assets/css/bootstrap.min.css');?>" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="<?php echo base_url('store_assets/css/icons.min.css');?>" rel="stylesheet" type="text/css" />
		<!-- Lightbox css -->
         <link href="<?php echo base_url('store_assets/libs/magnific-popup/magnific-popup.css');?>" rel="stylesheet" type="text/css" />
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
		
		<link href="https://fonts.googleapis.com/css2?family=Exo:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
		<style>
			body {
				font-family: 'Poppins', sans-serif !important;
			}
			.dt-buttons.btn-group.flex-wrap{
				float: left;
				margin-right: 20px;
			}
			.dataTables_length{
				float: left;
			}
			table.dataTable.dtr-inline.collapsed>tbody>tr.parent>td.dtr-control:before, table.dataTable.dtr-inline.collapsed>tbody>tr.parent>th.dtr-control:before {
				content: '-';
				background-color: #d33333;
				border-radius: 25px;
				padding: 0px 5px;
				color: #fff;
				font-weight: 800;
			}
			@media (min-width: 1200px){
				body[data-layout=horizontal] .container-fluid, body[data-layout=horizontal] .navbar-header {
					max-width: 100% !important;
				}
			}
			.topnav{
				margin-top: 50px;
			}
			.topnav .navbar-nav .nav-link {
				padding: 0.6rem 0.9rem !important;
			}
			.navbar-header {
				height: 50px!important;
			}
			.logo {
				line-height: 50px;
			}
			.header-item {
    			height: 50px;
			}
			.header-profile-user {
				height: 30px;
				width: 30px;
			}
			body[data-layout=horizontal] .page-content{
				margin-top: 35px;
			}
			.flash-message{
                position: fixed;
                float: right;
                right: 22px;
                top: 70px;
                z-index: 9999;
			}
		</style>
    </head>

    <body data-topbar="dark" data-layout="horizontal">
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
                        <div class="navbar-brand-box">
                            <a href="<?php echo base_url('store'); ?>" class="logo logo-dark text-light" style="font-size: 17px;">
                                <span class="logo-sm">
                                    <?php $sess_firm_name = $this->session->userdata('stores_name');echo word_limiter($sess_firm_name,5);?>
                                </span>
                                <span class="logo-lg">
                                    <?php $sess_firm_name = $this->session->userdata('stores_name');echo word_limiter($sess_firm_name,5);?>
                                </span>
                            </a>

                            <a href="<?php echo base_url('store'); ?>" class="logo logo-light text-light" style="font-size: 17px;">
                                <span class="logo-sm">
                                    <!--<img src="<?php //echo base_url('store_assets/images/logo-sm.png');?>" alt="" height="22" />-->
									<i class="dripicons-store font-size-20"></i>
                                </span>
                                <span class="logo-lg">
                                    <i class="dripicons-store font-size-24"></i> &nbsp;&nbsp;<span style="vertical-align: top;"><?php $sess_firm_name = $this->session->userdata('stores_name');echo word_limiter($sess_firm_name,5);?></span>
                                </span>
                            </a>
                        </div>
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
                                <span class="badge bg-danger rounded-pill">3</span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-notifications-dropdown">
                                <div class="p-3">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h6 class="m-0">Notifications</h6>
                                        </div>
                                        <div class="col-auto">
                                            <a href="#!" class="small"> View All</a>
                                        </div>
                                    </div>
                                </div>
                                <div data-simplebar style="max-height: 230px;">
                                    <a href="" class="text-reset notification-item">
                                        <div class="media">
                                            <div class="avatar-xs me-3">
                                                <span class="avatar-title bg-primary rounded-circle font-size-16">
                                                    <i class="mdi mdi-cart text-white"></i>
                                                </span>
                                            </div>
                                            <div class="media-body">
                                                <h6 class="mt-0 mb-1">Your order is placed</h6>
                                                <div class="font-size-13 text-muted">
                                                    <p class="mb-1">If several languages coalesce the grammar</p>
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
                                <img class="rounded-circle header-profile-user" src="<?php echo base_url('store_assets/images/users/avatar.png');?>" alt="<?php echo $this->session->userdata('stores_name');?>" />
                                <span class="d-none d-xl-inline-block ms-1"><?php echo $this->session->userdata('stores_name');?></span>
                                <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- item-->
                                <a class="dropdown-item" href="<?php echo base_url('store/profile')?>"><i class="mdi mdi-account-circle-outline font-size-16 align-middle me-1"></i> Profile</a>
                                <a class="dropdown-item d-block" href="<?php echo base_url('store/change-password')?>"><i class="mdi mdi-cog-outline font-size-16 align-middle me-1"></i> Change Password</a>
                                <!--<a class="dropdown-item" href="javascript: void(0);"><i class="mdi mdi-lock-open-outline font-size-16 align-middle me-1"></i> Lock screen</a>-->
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger" href="<?php echo base_url('store/logout')?>"><i class="mdi mdi-power font-size-16 align-middle me-1 text-danger"></i> Logout</a>
                            </div>
                        </div>
				
                    </div>
                </div>
            </header>
			
			<div class="topnav">
				<div class="container-fluid">
					<nav class="navbar navbar-light navbar-expand-lg topnav-menu">
		
						<div class="collapse navbar-collapse" id="topnav-menu-content">
							<ul class="navbar-nav">
								<li class="nav-item">
									<a class="nav-link" href="<?php echo base_url('store'); ?>">
										<i class="dripicons-home me-2"></i> Dashboard
									</a>
								</li>
								
								<li class="nav-item dropdown">
									<a class="nav-link dropdown-toggle arrow-none" href="javascript:;" id="topnav-apps" role="button">
										<i class="dripicons-archive me-2"></i> Master <div class="arrow-down"></div>
									</a>
									<div class="dropdown-menu" aria-labelledby="topnav-apps">
										<a href="<?php echo base_url('store/rack/list');?>" class="dropdown-item">Add Rack</a>
										<a href="<?php echo base_url('store/shelf/list');?>" class="dropdown-item">Add Shelves</a>
									</div>
								</li>
								
								<li class="nav-item dropdown">
									<a class="nav-link dropdown-toggle arrow-none" href="javascript:;" id="topnav-apps" role="button">
										<i class="dripicons-stack me-2"></i> Inventory <div class="arrow-down"></div>
									</a>
									<div class="dropdown-menu" aria-labelledby="topnav-apps">
									    <a href="<?php echo base_url('store/inventory');?>" class="dropdown-item">Add Inventory</a>
										<a href="<?php echo base_url('store/inventory/manage-inventory');?>" class="dropdown-item">Store Inventory</a>
										<a href="<?php echo base_url('store/inventory/inventory-logs');?>" class="dropdown-item">Inventory Logs</a>
										<a href="javascript:;" class="dropdown-item">Out of Stock</a>
									</div>
								</li>
								
								<li class="nav-item dropdown">
									<a class="nav-link" href="<?php echo base_url('store/order/dashboard'); ?>">
										<i class="dripicons-cart me-2"></i> Orders
									</a>
								</li>
								
								<!-- <li class="nav-item dropdown">
									<a class="nav-link dropdown-toggle arrow-none" href="javascript:;" id="topnav-apps" role="button">
										<i class="dripicons-user me-2"></i> Users <div class="arrow-down"></div>
									</a>
									<div class="dropdown-menu" aria-labelledby="topnav-apps">
										<a href="javascript:;" class="dropdown-item">Customer</a>
										<div class="dropdown">
											<a class="dropdown-item dropdown-toggle arrow-none" href="javascript:;" id="topnav-ecommerce"
												role="button">
												Test <div class="arrow-down"></div>
											</a>
											<div class="dropdown-menu" aria-labelledby="topnav-ecommerce">
												<a href="javascript:;" class="dropdown-item">Test 1</a>
												<a href="javascript:;" class="dropdown-item">Test 2</a>
												<a href="javascript:;" class="dropdown-item">Test 3</a>
											</div>
										</div>

									</div>
								</li> -->
								
								<li class="nav-item dropdown">
									<a class="nav-link dropdown-toggle arrow-none" href="javascript:;" id="topnav-uielement" role="button">
										<i class="dripicons-suitcase me-2"></i> Reports <div class="arrow-down"></div>
									</a>
									<div class="dropdown-menu" aria-labelledby="topnav-apps">
										<div class="dropdown">
											<a class="dropdown-item dropdown-toggle arrow-none" href="javascript:;" id="topnav-ecommerce"
												role="button">
												Report 1 <div class="arrow-down"></div>
											</a>
											<div class="dropdown-menu" aria-labelledby="topnav-ecommerce">
												<a href="javascript:;" class="dropdown-item">Report 1-1</a>
												<a href="javascript:;" class="dropdown-item">Report 1-2</a>
												<a href="javascript:;" class="dropdown-item">Report 1-3</a>
											</div>
										</div>

									</div>
								</li>
								
								<!-- <li class="nav-item dropdown">
									<a class="nav-link dropdown-toggle arrow-none" href="javascript:;" id="topnav-form" role="button">
										<i class="fas fa-warehouse me-2"></i> Warehouse <div class="arrow-down"></div>
									</a>
									<div class="dropdown-menu" aria-labelledby="topnav-apps">
										<a href="<?= base_url('store/warehouse/dashboard');?>" class="dropdown-item">Dashboard</a>
										<a href="<?= base_url('store/warehouse/stock-request');?>" class="dropdown-item">Stock Request</a>
										<a href="javascript:;" class="dropdown-item">Rejected Logs</a>
										<a href="javascript:;" class="dropdown-item">Damages</a>
									</div>
								</li> -->
								<li class="nav-item">
									<a class="nav-link" href="<?php echo base_url('store/profile'); ?>">
										<i class="dripicons-home me-2"></i> Store Setting
									</a>
								</li>
								<!-- <li class="nav-item dropdown">
									<a class="nav-link dropdown-toggle arrow-none" href="javascript:;" id="topnav-form" role="button">
										<i class="dripicons-toggles me-2"></i> Store Setting <div class="arrow-down"></div>
									</a>
									<div class="dropdown-menu" aria-labelledby="topnav-apps">
										<a href="javascript:;" class="dropdown-item">Setting 1</a>
										<a href="javascript:;" class="dropdown-item">Setting 2</a>
									</div>
								</li>-->
		
							</ul>
						</div>
					</nav>
				</div>
			</div>

            
        
