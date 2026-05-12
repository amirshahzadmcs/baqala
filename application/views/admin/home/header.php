<?php $this->load->helper('text');
$menus = role_permissions($this->session->userdata('role')); ?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<base href="<?php echo base_url(); ?>" />
	<!-- Meta, title, CSS, favicons, etc. -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Baqala Station</title>
	<link rel="shortcut icon" type="admin_assets/images/favicon.ico" href="favicon.ico" />

	<!-- Bootstrap Css -->
	<link href="<?php echo base_url('admin_assets/css/bootstrap.min.css'); ?>" id="bootstrap-style" rel="stylesheet" type="text/css" />
	<!-- Icons Css -->
	<link href="<?php echo base_url('admin_assets/css/icons.min.css'); ?>" rel="stylesheet" type="text/css" />
	<!-- select2 -->
	<link href="<?php echo base_url('admin_assets/libs/select2/css/select2.min.css'); ?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url('admin_assets/libs/spectrum-colorpicker2/spectrum.min.css'); ?>" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url('admin_assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css'); ?>" rel="stylesheet" />
	<!-- Sweet Alert-->
	<link href="<?php echo base_url('admin_assets/libs/sweetalert2/sweetalert2.min.css'); ?>" rel="stylesheet" type="text/css" />
	<!-- DataTables -->
	<link href="<?php echo base_url('admin_assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css'); ?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url('admin_assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css'); ?>" rel="stylesheet" type="text/css" />
	<!-- Responsive datatable examples -->
	<link href="<?php echo base_url('admin_assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css'); ?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url('admin_assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css'); ?>" rel="stylesheet">
	<!-- dropzone css -->
	<link href="<?php echo base_url('admin_assets/libs/dropzone/min/dropzone.min.css'); ?>" rel="stylesheet" type="text/css" />
	<!-- plugin css -->
	<link href="<?php echo base_url('admin_assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css'); ?>" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('admin_assets/plugins/dropify/dropify.min.css') ?>">
	<!-- App Css-->
	<link href="<?php echo base_url('admin_assets/libs/magnific-popup/magnific-popup.css'); ?>" id="app-style" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url('admin_assets/css/app.css'); ?>" id="app-style" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url('admin_assets/css/custom.css?v1.2'); ?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url('admin_assets/css/custom-accounting.css'); ?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url('admin_assets/css/assets.css'); ?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url('admin_assets/plugins/hijri-date-picker/css/bootstrap-datetimepicker.min.css'); ?>" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('admin_assets/plugins/easyui/themes/default/easyui.css') ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('admin_assets/plugins/easyui/themes/icon.css') ?>">
	<!--<link rel="stylesheet" type="text/css" href="admin_assets/plugins/easyui/demo.css">-->
	<!--<link rel="preconnect" href="https://fonts.googleapis.com">-->
	<!--<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>-->
	<!--<link href="https://fonts.googleapis.com/css2?family=Exo:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">-->
	<style>
		.list-items~.list-items::before {
			content: ", ";
		}

		input[type=text],
		input[type=select] {
			height: 39px !important;
		}

		/*-- Table Expand End --*/
		body {
			color: #052738;
		}

		.nav_menu {
			margin-bottom: 0px !important;
		}

		.right_col {
			min-height: 100vh !important;
			overflow: scroll !important;
		}

		table.jambo_table thead {
			background: rgb(108 111 129);
			color: #fff;
			font-size: 13px;
		}

		table.dataTable td {
			font-size: 13px;
		}

		.table th {
			font-weight: 500;
		}

		.hint {
			color: #9f9f9f;
			margin-top: 5px;
			margin-bottom: 2px;
		}

		.alert {
			position: relative;
		}

		.main_menu span.fa {
			font-size: 16px;
		}

		::-webkit-scrollbar {
			width: 5px;
		}

		::-webkit-scrollbar-thumb {
			background: #bbb;
		}

		.icon {
			font-size: 18px;
			padding-right: 8px;
		}

		.nav.side-menu>li>a {
			margin-bottom: 0px;
		}

		.mm-active .active i {
			color: #343434 !important;
		}

		.mm-active>a i {
			color: #005500 !important;
		}

		li.mm-active .mm-active>a {
			color: #005500 !important;
			font-weight: 500;
		}

		.nav-tabs-custom .nav-item .nav-link.active {
			color: #005500;
		}

		.nav-tabs-custom .nav-item .nav-link::after {
			background: #005500;
		}

		#sidebar-menu ul li a:hover i {
			color: #005500;
		}

		#sidebar-menu ul li a i {
			font-size: 19px !important;
			color: #0e0e0e;
		}

		#sidebar-menu ul li a {
			padding: 0.4rem 0.5rem;
			margin: 0 0px;
			font-weight: 500;
			font-size: 14px;
			border-radius: 0px;
			border-bottom: 1px solid #f0f0f0;
		}

		#sidebar-menu ul li ul.sub-menu li a:before {
			content: "" !important;
			padding-left: 13px;
		}

		#sidebar-menu ul li ul.sub-menu {
			padding: 0;
			box-shadow: inset 0 9px 15px -12px rgb(0 0 0 / 40%), inset 0 -9px 20px -15px rgb(0 0 0 / 40%);
			background: #fdfdfd;
		}

		#sidebar-menu ul li ul.sub-menu li a {
			padding: 0.6rem 1.5rem 0.6rem 0.5rem;
			font-size: 13px !important;
			color: #242424;
		}

		#sidebar-menu ul li ul.sub-menu li ul.sub-menu li a {
			padding: 0.6rem 1rem 0.6rem 1.5rem;
		}

		#sidebar-menu ul li ul.sub-menu li ul.sub-menu li ul.sub-menu li a {
			padding: 0.6rem 1rem 0.6rem 1.5rem;
		}

		.vertical-collpsed .vertical-menu #sidebar-menu>ul>li:hover>ul {
			width: 250px !important;
		}

		.vertical-collpsed .vertical-menu #sidebar-menu>ul>li:hover>ul a {
			width: 250px !important;
		}

		.vertical-collpsed .vertical-menu #sidebar-menu>ul>li:hover>a {
			width: calc(250px + 70px) !important;
		}

		.vertical-collpsed .vertical-menu #sidebar-menu>ul ul li:hover>ul {
			left: 250px !important;
			width: 250px !important;
		}

		.metismenu li {
			margin-top: 1px;
		}

		label {
			color: #2a2a2a;
		}

		.h1,
		.h2,
		.h3,
		.h4,
		.h5,
		.h6,
		h1,
		h2,
		h3,
		h4,
		h5,
		h6 {
			color: #262626;
		}

		#wait {
			width: 100%;
			height: 100%;
			position: fixed;
			padding: 2px;
			z-index: 9999;
			background: #ffffff26;
			text-align: center;
			padding-top: 17%;
			top: 0;
			bottom: 0;
			left: 0;
			right: 0;
			display: none;
		}

		/* easyui css */
		.tree-folder {
			background: url('https://www.jeasyui.com/easyui/themes/icons/folder.png');
		}

		.tree-file {
			background: url('https://www.jeasyui.com/easyui/themes/icons/file.png');
		}
	</style>

</head>
<input type="hidden" name="baseUrl" class="baseUrl" value="<?php echo base_url(); ?>">

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

	<div id="layout-wrapper">
		<header id="page-topbar">
			<div class="navbar-header">
				<div class="d-flex">
					<!-- LOGO -->
					<div class="navbar-brand-box d-flex justify-content-center">
						<a href="<?php echo base_url('admin'); ?>" class="logo logo-dark">
							<span class="logo-sm">
								<img src="admin_assets/images/favicon.ico" alt="" height="30" />
							</span>
							<span class="logo-lg" style="font-size: 24px;color: #005500;">
								<?php $sess_firm_name = 'Baqala Station';
								echo word_limiter($sess_firm_name, 2); ?>
							</span>
						</a>

						<a href="<?php echo base_url('admin'); ?>" class="logo logo-light">
							<span class="logo-sm">
								<img src="admin_assets/images/favicon.ico" alt="" height="22" />
							</span>
							<span class="logo-lg">
								<img src="admin_assets/images/favicon.ico" alt="" height="20" />
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
						<input id="sidebar-search" class="search-input form-control" placeholder="Search" />
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

					<?php
					$admin_id = $this->session->userdata('admin_id');
					$login_emp_id = $this->session->userdata('login_employee_id');
					$login_admin_info = $this->admin->adminName($admin_id);
					$admin_profile_pic = !empty($login_admin_info->image) ? base_url($login_admin_info->image) : base_url('admin_assets/images/avatar.png');
					?>
					<div class="dropdown d-inline-block">
						<button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<img class="rounded-circle header-profile-user" src="<?php echo $admin_profile_pic; ?>" />
							<span class="d-none d-xl-inline-block ms-1"><?= word_limiter($login_admin_info->name, 2); ?></span>
							<i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
						</button>
						<div class="dropdown-menu dropdown-menu-end">
							<a class="dropdown-item text-dark" href="<?php echo base_url('admin/common/change_password') ?>"><i class="mdi mdi-security font-size-16 align-middle me-1 text-dark"></i> Change Password</a>
							<a class="dropdown-item text-danger" href="<?php echo base_url('admin/common/logout') ?>"><i class="mdi mdi-power font-size-16 align-middle me-1 text-danger"></i> Logout</a>
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
							<img src="<?php echo $admin_profile_pic; ?>" width="30px" alt="" class="rounded-circle" />
							<span class="avatar-online bg-success"></span>
						</div>
						<div class="user-info">
							<h5 class="mt-3 font-size-16 text-dark">Maha Al Fala</h5>
							<span class="font-size-13 text-dark"><?= word_limiter($login_admin_info->name, 2); ?></span>
						</div>
					</div>
				</div>

				<!--- Sidemenu -->
				<div id="sidebar-menu">
					<!-- Left Menu Start -->
					<ul class="metismenu list-unstyled" id="side-menu">
						<li class="menu-title">General</li>
						<li>
							<a href="<?= base_url('admin'); ?>" class="waves-effect">
								<img src="admin_assets/icons/dashboard.png" alt="Store Management" width="24px" class="me-1" />
								<span>Dashboard</span>
							</a>
						</li>
						<?php if (permission_exists($menus, 'sales_management')) : ?>
							<li>
								<a href="javascript:void(0);" class="has-arrow waves-effect">
									<i class="ti-stats-up"></i>
									<span>Sales Management</span>
								</a>
								<ul class="sub-menu" aria-expanded="false">
									<?php if (permission_exists($menus, 'quotation')): ?>
										<li>
											<a href="<?= base_url('admin/quotation/list'); ?>" class="waves-effect">
												<span>Quotation</span>
											</a>
										</li>
									<?php endif;
									if (permission_exists($menus, 'order')): ?>
										<li>
											<a href="<?= base_url('admin/order/list'); ?>" class="waves-effect">
												<span>Orders</span>
											</a>
										</li>
									<?php endif;
									if (permission_exists($menus, 'invoices')): ?>
										<li>
											<a href="javascript:void(0);" class="waves-effect">
												<span>Invoices</span>
											</a>
										</li>
									<?php endif;
									if (permission_exists($menus, 'credit_invoices')): ?>
										<li>
											<a href="javascript:void(0);" class="waves-effect">
												<span>Credit Invoices</span>
											</a>
										</li>
									<?php endif;
									if (permission_exists($menus, 'ready_to_despatch')): ?>
										<li>
											<a href="javascript:void(0);" class="waves-effect">
												<span>Ready to Dispatch</span>
											</a>
										</li>
									<?php endif;
									if (permission_exists($menus, 'sales_return')): ?>
										<li>
											<a href="javascript:void(0);" class="waves-effect">
												<span>Sales Return</span>
											</a>
										</li>
									<?php endif;
									if (permission_exists($menus, 'clients_payments')): ?>
										<li>
											<a href="javascript:void(0);" class="waves-effect">
												<span>Clients Payments</span>
											</a>
										</li>
									<?php endif;
									if (permission_exists($menus, 'credit_notes')): ?>
										<li>
											<a href="javascript:void(0);" class="waves-effect">
												<span>Credit Notes</span>
											</a>
										</li>
									<?php endif; ?>
								</ul>
							</li>
						<?php endif;
						if (permission_exists($menus, 'client_management')): ?>
							<li>
								<a href="javascript: void(0);" class="has-arrow waves-effect">
									<i class="ti-user"></i>
									<span>Client Management</span>
								</a>
								<ul class="sub-menu" aria-expanded="false">
									<!--
									<li>
										<a href="<?= base_url('admin/user/individual-form'); ?>" class="waves-effect">
											<span> Add New Client</span>
										</a>
									</li>
									-->
									<?php if (permission_exists($menus, 'manage_corporate_clients')): ?>
										<li>
											<a href="<?= base_url('admin/business-user/list'); ?>" class="waves-effect">
												<span> Manage Corporate Clients</span>
											</a>
										</li>
									<?php endif;
									if (permission_exists($menus, 'manage_individual_clients')): ?>
										<li>
											<a href="<?= base_url('admin/user/list'); ?>" class="waves-effect">
												<span> Manage Individual Clients</span>
											</a>
										</li>
									<?php endif;
									if (permission_exists($menus, 'manage_credit_accounts')): ?>
										<li>
											<a href="<?= base_url('admin/credit-account/list'); ?>" class="waves-effect">
												<span> Manage Credit Accounts</span>
											</a>
										</li>
									<?php endif; ?>
								</ul>
							</li>
						<?php endif;
						if (permission_exists($menus, 'product_management')): ?>
							<li>
								<a href="javascript: void(0);" class="has-arrow waves-effect">
									<i class="ti-package"></i>
									<span>Product Management</span>
								</a>
								<ul class="sub-menu" aria-expanded="false">
									<!--
									<li>
										<a href="<?php echo base_url('admin/size') ?>" class="waves-effect">
											<span> Master Size</span>
										</a>
									</li>
									-->
									<?php if (permission_exists($menus, 'manage_rack')): ?>
										<li>
											<a href="<?php echo base_url('admin/rack/list') ?>" class="waves-effect">
												<span> Manage Rack</span>
											</a>
										</li>
									<?php endif;
									if (permission_exists($menus, 'manage_shelves')): ?>
										<li>
											<a href="<?php echo base_url('admin/shelf/list') ?>" class="waves-effect">
												<span> Manage Shelves</span>
											</a>
										</li>
									<?php endif;
									if (permission_exists($menus, 'manage_unit')): ?>
										<li>
											<a href="<?php echo base_url('admin/unit') ?>" class="waves-effect">
												<span> Manage Unit</span>
											</a>
										</li>
									<?php endif;
									if (permission_exists($menus, 'manage_brands')): ?>
										<li>
											<a href="<?php echo base_url('admin/brand') ?>" class="waves-effect">
												<span> Manage Brands</span>
											</a>
										</li>
									<?php endif;
									if (permission_exists($menus, 'manage_category')): ?>
										<li>
											<a href="<?php echo base_url('admin/category') ?>" class="waves-effect">
												<span> Manage Category</span>
											</a>
										</li>
									<?php endif;
									if (permission_exists($menus, 'manage_product')): ?>
										<li>
											<a href="<?php echo base_url('admin/product') ?>" class="waves-effect">
												<span> Manage Product</span>
											</a>
										</li>
									<?php endif;
									if (permission_exists($menus, 'deleted_product')): ?>
										<li>
											<a href="<?php echo base_url('admin/product/deleted-product') ?>" class="waves-effect">
												<span> Deleted Product</span>
											</a>
										</li>
									<?php endif; ?>
								</ul>
							</li>
						<?php endif;
						if (permission_exists($menus, 'purchase_management')): ?>
							<li>
								<a href="javascript: void(0);" class="has-arrow waves-effect">
									<i class="ti-receipt"></i>
									<span>Purchase Management</span>
								</a>
								<ul class="sub-menu" aria-expanded="false">
									<?php if (permission_exists($menus, 'manage_suppliers')): ?>
										<li>
											<a href="<?= base_url('admin/vendor/list'); ?>" class="waves-effect">
												<span> Manage Suppliers</span>
											</a>
										</li>
									<?php endif;
									if (permission_exists($menus, 'purchase_order_invoice')): ?>
										<li>
											<a href="<?= base_url('admin/purchase/list'); ?>" class="waves-effect">
												<span> Purchase Order / Invoice</span>
											</a>
										</li>
									<?php endif;
									if (permission_exists($menus, 'goods_received_voucher')): ?>
										<li>
											<a href="<?= base_url('admin/grv/list'); ?>" class="waves-effect">
												<span> Goods Received Voucher</span>
											</a>
										</li>
									<?php endif;
									if (permission_exists($menus, 'purchase_return')): ?>
										<li>
											<a href="<?= base_url('admin/pr/list'); ?>" class="waves-effect">
												<span> Purchase Return</span>
											</a>
										</li>
									<?php endif; ?>
								</ul>
							</li>
						<?php endif;
						if (permission_exists($menus, '3p_logistic_management')): ?>
							<li>
								<a href="javascript: void(0);" class="has-arrow waves-effect">
									<i class="ti-truck"></i>
									<span>3P Logistic Management</span>
								</a>
								<ul class="sub-menu" aria-expanded="false">
									<?php if (permission_exists($menus, '3p_logistic_partner')): ?>
										<li>
											<a href="<?php echo base_url('admin/logistic-partner/list') ?>" class="waves-effect">
												<span> 3P Logistic Partner</span>
											</a>
										</li>
									<?php endif;
									if (permission_exists($menus, '3p_rider')): ?>
										<li>
											<a href="<?php echo base_url('admin/3p-fleet/applications') ?>" class="waves-effect">
												<span> 3P Fleet Applications</span>
											</a>
										</li>
										<li>
											<a href="<?php echo base_url('admin/deliveryvehicle') ?>" class="waves-effect">
												<span> 3P Rider</span>
											</a>
										</li>
									<?php endif;
									if (permission_exists($menus, 'delivery_summary')): ?>
										<li>
											<a href="<?= base_url('admin/daily-delivery-summary/list'); ?>" class="waves-effect">
												<span> Delivery Summary</span>
											</a>
										</li>
									<?php endif;
									if (permission_exists($menus, 'attendance_summary')): ?>
										<li>
											<a href="<?= base_url('admin/attendance/list'); ?>" class="waves-effect">
												<span> Attendance Summary</span>
											</a>
										</li>
									<?php endif;
									if (permission_exists($menus, 'attendance_summary')): ?>
										<li>
											<a href="<?= base_url('admin/attendance/old-list'); ?>" class="waves-effect">
												<span> Old Attendance Summary</span>
											</a>
										</li>
									<?php endif;
									if (permission_exists($menus, 'delivery_setting')): ?>
										<li><a href="javascript: void(0);" class="has-arrow">Delivery Setting</a>
											<ul class="sub-menu" aria-expanded="false">
												<?php if (permission_exists($menus, 'delivery_area_master')): ?>
													<li>
														<a href="<?php echo base_url('admin/servicearea') ?>" class="waves-effect">
															<span> Delivery Area Master</span>
														</a>
													</li>
												<?php endif;
												if (permission_exists($menus, 'delivery_charges_master')): ?>
													<li>
														<a href="javascript:;" class="waves-effect">
															<span> Delivery Charges Master</span>
														</a>
													</li>
												<?php endif;
												if (permission_exists($menus, 'delivery_time_slot_master')): ?>
													<li>
														<a href="javascript:;" class="waves-effect">
															<span> Delivery Time Slot Master</span>
														</a>
													</li>
												<?php endif;
												if (permission_exists($menus, 'express_charges_master')): ?>
													<li>
														<a href="javascript:;" class="waves-effect">
															<span> Express Charges Master</span>
														</a>
													</li>
												<?php endif;
												if (permission_exists($menus, 'online_food_delivery_company')): ?>
													<li>
														<a href="<?php echo base_url('admin/ofd-company/list') ?>">
															<span>Online Food Delv. Company</span>
														</a>
													</li>
												<?php endif; ?>
											</ul>
										</li>
									<?php endif; ?>
								</ul>
							</li>
						<?php endif;
						if (permission_exists($menus, 'vehicle_management')): ?>
							<li>
								<a href="javascript: void(0);" class="has-arrow waves-effect">
									<i class="mdi mdi-car-cog" style="font-size:24px !important"></i>
									<span>Vehicle Management</span>
								</a>
								<ul class="sub-menu" aria-expanded="false">
									<!--
									<li>
										<a href="<?= base_url('admin/in-house-vehicle/list'); ?>" class="waves-effect">
											<span> Manage Van</span>
										</a>
									</li>
									-->
									<?php if (permission_exists($menus, 'vehicle_spare_parts')): ?>
										<li>
											<a href="<?= base_url('admin/spare-parts/list'); ?>" class="waves-effect">
												<span> Vehicle Spare Parts</span>
											</a>
										</li>
									<?php endif;
									if (permission_exists($menus, 'sp_requisition_master')): ?>
										<li>
											<a href="<?= base_url('admin/spare-parts/requisition/list'); ?>" class="waves-effect">
												<span> SP Requisition Master</span>
											</a>
										</li>
									<?php endif;
									if (permission_exists($menus, 'sp_purchase_order_master')): ?>
										<li>
											<a href="<?= base_url('admin/spare-parts/po/list'); ?>" class="waves-effect">
												<span> SP Purchase Order Master</span>
											</a>
										</li>
									<?php endif;
									if (permission_exists($menus, 'sp_mrv_master')): ?>
										<li>
											<a href="<?= base_url('admin/spare-parts/mrv/list'); ?>" class="waves-effect">
												<span> SP MRV Master</span>
											</a>
										</li>
									<?php endif;
									if (permission_exists($menus, 'job_cards')): ?>
										<li>
											<a href="<?= base_url('admin/job-card/list'); ?>" class="waves-effect">
												<span> Job Cards</span>
											</a>
										</li>
									<?php endif;
									if (permission_exists($menus, 'job_cards')): ?>
										<li>
											<a href="<?= base_url('admin/job-card/report'); ?>" class="waves-effect">
												<span> Job Cards Report</span>
											</a>
										</li>
									<?php endif;
									if (permission_exists($menus, 'setting_vehicle_management')): ?>
										<li><a href="javascript: void(0);" class="has-arrow">Setting Vehicle Management</a>
											<ul class="sub-menu" aria-expanded="true">
												<?php if (permission_exists($menus, 'vehicle_maker_master')): ?>
													<li>
														<a href="<?php echo base_url('admin/vehiclemake') ?>">
															<span> Vehicle Make Master</span>
														</a>
													</li>
												<?php endif;
												if (permission_exists($menus, 'vehicle_type_master')): ?>
													<li>
														<a href="<?php echo base_url('admin/vehicletype') ?>">
															<span> Vehicle Type Master</span>
														</a>
													</li>
												<?php endif; ?>
											</ul>
										</li>
									<?php endif; ?>
								</ul>
							</li>
						<?php endif; ?>

						<!-- <li>
							<a href="javascript: void(0);" class="has-arrow waves-effect">
								<i class="fas fa-hand-holding-usd"></i>
								<span>Assets Management</span>
							</a>
							<ul class="sub-menu" aria-expanded="false">
								<li>
									<a href="<?php echo base_url('admin/asset-manage/all-assets') ?>" class="waves-effect">
										<span> Assets</span>
									</a>
								</li>
							</ul>
							</li> -->
						<?php if (permission_exists($menus, 'fixed_assets_management')): ?>
							<li>
								<a href="javascript: void(0);" class="has-arrow waves-effect">
									<i class="fas fa-hand-holding-usd"></i>
									<span>Fixed Assets Management</span>
								</a>
								<ul class="sub-menu" aria-expanded="false">
									<?php if (permission_exists($menus, 'category')): ?>
										<li>
											<a href="<?= base_url('admin/assets/category/list'); ?>" class="waves-effect">
												<span> Category</span>
											</a>
										</li>
									<?php endif;
									if (permission_exists($menus, 'sub_category')): ?>
										<li>
											<a href="<?= base_url('admin/assets/sub-category/list'); ?>" class="waves-effect">
												<span> Sub Category</span>
											</a>
										</li>
									<?php endif;
									if (permission_exists($menus, 'fixed_assets')): ?>
										<li>
											<a href="<?= base_url('admin/assets/product/list'); ?>" class="waves-effect">
												<span> Fixed Assets</span>
											</a>
										</li>
									<?php endif; ?>
								</ul>
							</li>
						<?php endif;
						if (permission_exists($menus, 'bs_pay_management')): ?>
							<li>
								<a href="javascript: void(0);" class="has-arrow waves-effect">
									<i class="ti-wallet"></i>
									<span>BS Pay Management</span>
								</a>
								<ul class="sub-menu" aria-expanded="false">
									<?php if (permission_exists($menus, 'manage_bs_pay_vouchers')): ?>
										<li>
											<a href="javascript:;" class="waves-effect">
												<span> Manage BS Pay Vouchers</span>
											</a>
										</li>
									<?php endif;
									if (permission_exists($menus, 'manage_gift_cards')): ?>
										<li>
											<a href="javascript:;" class="waves-effect">
												<span> Manage Gift Cards</span>
											</a>
										</li>
									<?php endif;
									if (permission_exists($menus, 'bs_pay_utilization_report')): ?>
										<li>
											<a href="javascript:;" class="waves-effect">
												<span> BS Pay Utilization Report</span>
											</a>
										</li>
									<?php endif; ?>
								</ul>
							</li>
						<?php endif;
						if (permission_exists($menus, 'advertisement_media')): ?>
							<li>
								<a href="javascript: void(0);" class="has-arrow waves-effect">
									<i class="ti-gallery"></i>
									<span>Advertisement Media</span>
								</a>
								<ul class="sub-menu" aria-expanded="false">
									<li>
										<a href="javascript:;" class="waves-effect">
											<span> Home Banner</span>
										</a>
									</li>
									<li>
										<a href="javascript:;" class="waves-effect">
											<span> Push Notification</span>
										</a>
									</li>
									<li>
										<a href="javascript:;" class="waves-effect">
											<span> In-App Splash</span>
										</a>
									</li>
									<li>
										<a href="javascript:;" class="waves-effect">
											<span> Small Banner</span>
										</a>
									</li>
									<li>
										<a href="javascript:;" class="waves-effect">
											<span> Swimlane SKU Feature</span>
										</a>
									</li>
									<li>
										<a href="javascript:;" class="waves-effect">
											<span> Dedicated Swimlane</span>
										</a>
									</li>
									<li>
										<a href="javascript:;" class="waves-effect">
											<span> Category Icon</span>
										</a>
									</li>
									<li>
										<a href="javascript:;" class="waves-effect">
											<span> SKU uplifting in sub category</span>
										</a>
									</li>
									<li>
										<a href="javascript:;" class="waves-effect">
											<span> Sponsored search</span>
										</a>
									</li>
								</ul>
							</li>
						<?php endif;
						if (permission_exists($menus, 'promotion_management')): ?>
							<li>
								<a href="javascript: void(0);" class="has-arrow waves-effect">
									<i class="ti-gallery"></i>
									<span>Promotion Management</span>
								</a>
								<ul class="sub-menu" aria-expanded="false">
									<li>
										<a href="javascript:;" class="waves-effect">
											<span> Fixed Single Promo</span>
										</a>
									</li>
									<li>
										<a href="javascript:;" class="waves-effect">
											<span> Percent Single Promo</span>
										</a>
									</li>
									<li>
										<a href="javascript:;" class="waves-effect">
											<span> Multi Buy Promo (Same SKU)</span>
										</a>
									</li>
									<li>
										<a href="javascript:;" class="waves-effect">
											<span> Basket Discount Promo</span>
										</a>
									</li>
									<li>
										<a href="javascript:;" class="waves-effect">
											<span> Brand Discount</span>
										</a>
									</li>
									<li>
										<a href="javascript:;" class="waves-effect">
											<span> Multi-Groups Promo</span>
										</a>
									</li>
									<li>
										<a href="javascript:;" class="waves-effect">
											<span> Multi-Product Discount</span>
										</a>
									</li>
								</ul>
							</li>
						<?php endif;
						if (permission_exists($menus, 'news_letter')): ?>
							<li>
								<a href="javascript:;" class="waves-effect">
									<i class="ti-bell"></i>
									<span>News Letter</span>
								</a>
							</li>
						<?php endif;
						if (permission_exists($menus, 'referral_management')): ?>
							<li>
								<a href="javascript:;" class="waves-effect">
									<i class="ti-share"></i>
									<span>Referral Management</span>
								</a>
							</li>
						<?php endif; ?>
						<!--
						<li>
							<a href="javascript: void(0);" class="has-arrow waves-effect">
								<i class="dripicons-user-group"></i>
								<span>Human Resources</span>
							</a>
							<ul class="sub-menu" aria-expanded="true">
								<li>
									<a href="<?php echo base_url('admin/hr/dashboard'); ?>" class="waves-effect">Dashboard</a>
								</li>
								<li><a href="javascript: void(0);" class="has-arrow">Organizational Structure</a>
									<ul class="sub-menu" aria-expanded="true">
										<li><a href="<?php echo base_url('admin/hr/master/designations') ?>">Manage Designations</a></li>
										<li><a href="<?php echo base_url('admin/hr/master/department') ?>">Manage Departments</a></li>

										<li><a href="<?php echo base_url('admin/hr/master/employee-level') ?>">Manage Employee Levels</a></li>
										<li><a href="<?php echo base_url('admin/hr/master/employment-types') ?>">Manage Employment Types</a></li>
										<li><a href="<?php echo base_url('admin/hr/master/branch') ?>">Manage Branch</a></li>
										<li><a href="<?php echo base_url('admin/hr/master/package/list') ?>">Manage Packages</a></li>
									</ul>
								</li>

								<li><a href="javascript: void(0);" class="has-arrow">Employees</a>
									<ul class="sub-menu" aria-expanded="true">
										<li><a href="<?php echo base_url('admin/hr/master/employee') ?>">Manage Employees</a></li>
									</ul>
								</li>

								<li>
									<a href="javascript: void(0);" class="has-arrow">Roles & Permission</a>
									<ul class="sub-menu" aria-expanded="false">
										<li>
											<a href="<?php echo base_url('admin/modules/list') ?>" class="waves-effect">
												<span> Manage Modules</span>
											</a>
										</li>
										<li>
											<a href="<?php echo base_url('admin/roles/list') ?>" class="waves-effect">
												<span> Manage Roles</span>
											</a>
										</li>
										<li>
											<a href="<?php echo base_url('admin/roles/permission/list') ?>" class="waves-effect">
												<span> Manage Permissions</span>
											</a>
										</li>
									</ul>
								</li>
								<li><a href="javascript: void(0);" class="has-arrow">Payroll</a>
									<ul class="sub-menu" aria-expanded="true">
										<li><a href="<?php echo base_url('admin/hr/payroll/contract') ?>">Contract</a></li>
										<li><a href="<?php echo base_url('admin/hr/payroll/payrun') ?>">Pay Run</a></li>
										<li><a href="<?php echo base_url('admin/hr/payroll/payslip') ?>">Pay Slip</a></li>
										<li><a href="<?php echo base_url('admin/hr/payroll/loan') ?>">Loans</a></li>
										<li><a href="<?php echo base_url('admin/hr/payroll/salary-components') ?>">Salary Components</a></li>
										<li><a href="<?php echo base_url('admin/hr/payroll/salary-structure') ?>">Salary Structure</a></li>
										<li><a href="javascript:;">Settings</a></li>
									</ul>
								</li>
								<li><a href="javascript: void(0);" class="has-arrow">Attendance</a>
									<ul class="sub-menu" aria-expanded="true">
										<li><a href="<?php echo base_url('admin/attendance-logs/list') ?>">Attendance Logs</a></li>
										<li><a href="javascript:;">Attendance Days</a></li>
										<li><a href="javascript:;">Attendance Sheets</a></li>
										<li><a href="javascript:;">Attendance Permissions</a></li>
										<li><a href="<?php echo base_url('admin/attendance/shift-list') ?>">Shifts Management</a></li>
										<li><a href="javascript:;">Allocated Shifts</a></li>
										<li><a href="javascript:;">Attendance Log Sessions</a></li>
										<li><a href="<?php echo base_url('admin/hr/attendance/settings') ?>">Settings</a></li>
									</ul>
								</li>
								<li><a href="javascript: void(0);" class="has-arrow">HR Setting</a>
									<ul class="sub-menu" aria-expanded="true">
										<li><a href="<?php echo base_url('admin/hr/master/pay_head') ?>">Pay Head</a></li>
										<li><a href="<?php echo base_url('admin/hr/master/education') ?>">Education</a></li>
										<li><a href="<?php echo base_url('admin/hr/master/profession') ?>">Profession</a></li>
										<li><a href="<?php echo base_url('admin/hr/master/allowance') ?>">Allowance</a></li>
										<li><a href="<?php echo base_url('admin/hr/master/nationality') ?>">Nationality</a></li>
										<li><a href="<?php echo base_url('admin/hr/master/remuneration/list') ?>">Remunerations</a></li>
										<li><a href="<?php echo base_url('admin/master/streams') ?>">Major (Stream)</a></li>
										<li><a href="<?php echo base_url('admin/master/grade') ?>"><span> Grade</span></a></li>
										<li><a href="<?php echo base_url('admin/master/location') ?>"><span> Location</span></a></li>
										<li><a href="<?php echo base_url('admin/master/business-unit') ?>"><span> Business Unit</span></a></li>
										<li><a href="<?php echo base_url('admin/master/camps') ?>"><span> Camps</span></a></li>
										<li><a href="<?php echo base_url('admin/master/rooms') ?>"><span> Rooms</span></a></li>
										<li><a href="<?php echo base_url('admin/master/beds') ?>"><span> Beds</span></a></li>
										<li><a href="<?php echo base_url('admin/master/contract-status') ?>"><span> Contract Status</span></a></li>
										<li><a href="<?php echo base_url('admin/master/licence-type') ?>"><span> Licence Types</span></a></li>
										<li><a href="<?php echo base_url('admin/master/qiwa-status') ?>"><span> Qiwa Status</span></a></li>
										<li><a href="<?php echo base_url('admin/master/file-types') ?>"><span> File Types</span></a></li>
										<li><a href="<?php echo base_url('admin/master/transaction-type') ?>"><span> Transaction Types</span></a></li>
									</ul>
								</li>

									<li><a href="javascript: void(0);" class="has-arrow">Definition (Master)</a>
										<ul class="sub-menu" aria-expanded="true">
											<li><a href="javascript: void(0);" class="has-arrow">Master Code</a>
												<ul class="sub-menu" aria-expanded="true">
													<li><a href="<?php echo base_url('admin/hr/master/pay_head') ?>">Pay Head</a></li>
													<li><a href="<?php echo base_url('admin/hr/master/education') ?>">Education</a></li>
													<li><a href="<?php echo base_url('admin/hr/master/allowance') ?>">Allowance</a></li>
													<li><a href="<?php echo base_url('admin/hr/master/leave') ?>">Leave / Vacation</a></li>
													<li><a href="<?php echo base_url('admin/hr/master/nationality') ?>">Nationality</a></li>
													<li><a href="<?php echo base_url('admin/hr/master/agency/list') ?>">Hiring Agencies</a></li>
													<li><a href="<?php echo base_url('admin/hr/master/insurance-company/list') ?>">Insurance Companies</a></li>
													<li><a href="<?php echo base_url('admin/hr/master/insurance-type/list') ?>">Insurance Type</a></li>
													<li><a href="<?php echo base_url('admin/hr/master/remuneration/list') ?>">Remunerations</a></li>
												</ul>
											</li>
											<li><a href="javascript: void(0);">Working Hours</a></li>
										</ul>
									</li>
									<li><a href="javascript: void(0);" class="has-arrow">Recruitment</a>
										<ul class="sub-menu" aria-expanded="true">
											<li><a href="<?php echo base_url('admin/hr/recruitment/cv') ?>">Candidate CV</a></li>
											<li><a href="<?php echo base_url('admin/hr/master/employee') ?>">Employee Master</a></li>
											<li><a href="<?php echo base_url('admin/hr/recruitment/loi') ?>">Letter of Intent</a></li>-->
						<!--<li><a href="<?php echo base_url('admin/hr/recruitment/loui') ?>">Letter of Internship</a></li>
							<li><a href="<?php echo base_url('admin/hr/recruitment/ol') ?>">Offer Letter</a></li>
							<li><a href="<?php echo base_url('admin/hr/recruitment/cl') ?>">Contract with Employee</a></li>
							<li><a href="<?php echo base_url('admin/hr/recruitment/id_ack') ?>">ID card Acknowledgement</a></li>
							<li><a href="<?php echo base_url('admin/hr/recruitment/sim-card') ?>">Sim Card</a></li>
							<li><a href="javascript: void(0);">Termination Letter</a></li>
							<li><a href="<?php echo base_url('admin/hr/recruitment/exp-letter') ?>">Experience Letter</a></li>
							</ul>
							</li>
							<li><a href="javascript: void(0);" class="has-arrow">Remuneration</a>
								<ul class="sub-menu" aria-expanded="true">
									<li><a href="javascript: void(0);">Generate Time Sheet</a></li>
									<li><a href="javascript: void(0);">Generate Salary</a></li>
									<li><a href="javascript: void(0);">Pay Slip Modification</a></li>
									<li><a href="javascript: void(0);">No Due Certificate</a></li>
									<li><a href="javascript: void(0);">Traffic Violation</a></li>
									<li><a href="javascript: void(0);">Platform Violation</a></li>
								</ul>
							</li>
							<li><a href="javascript: void(0);" class="has-arrow">HR Services</a>
								<ul class="sub-menu" aria-expanded="true">
									<li><a href="javascript: void(0);" class="has-arrow">Request</a>
										<ul class="sub-menu" aria-expanded="true">
											<li><a href="javascript: void(0);">Leave Request</a></li>
											<li><a href="javascript: void(0);">Loan/Advance Request</a></li>
											<li><a href="javascript: void(0);">Business Trip Request</a></li>
											<li><a href="javascript: void(0);">Business Trip Exp Claim Request</a></li>
											<li><a href="javascript: void(0);">Resignation Request</a></li>
											<li><a href="javascript: void(0);">Salary Certificate Request</a></li>
											<li><a href="javascript: void(0);">Clearance Letter request</a></li>
											<li><a href="javascript: void(0);">GL A/c Statement Request</a></li>
										</ul>
									</li>
									<li><a href="javascript: void(0);" class="has-arrow">Approval</a>
										<ul class="sub-menu" aria-expanded="true">
											<li><a href="javascript: void(0);">Leave Request</a></li>
											<li><a href="javascript: void(0);">Loan/Advance Request</a></li>
											<li><a href="javascript: void(0);">Business Trip Request</a></li>
											<li><a href="javascript: void(0);">Business Trip Exp Claim Request</a></li>
											<li><a href="javascript: void(0);">Resignation Request</a></li>
											<li><a href="javascript: void(0);">Salary Certificate Request</a></li>
											<li><a href="javascript: void(0);">Clearance Letter request</a></li>
											<li><a href="javascript: void(0);">GL A/c Statement Request</a></li>
										</ul>
									</li>
								</ul>
							</li>
							<li><a href="javascript: void(0);" class="has-arrow">Reports</a>
								<ul class="sub-menu" aria-expanded="true">
									<li><a href="javascript: void(0);" class="has-arrow">Payroll</a>
										<ul class="sub-menu" aria-expanded="true">
											<li><a href="javascript: void(0);">Employee Master</a></li>
											<li><a href="javascript: void(0);">Allowance Register</a></li>
											<li><a href="javascript: void(0);">Working Hours</a></li>
											<li><a href="javascript: void(0);">Time Sheet</a></li>
											<li><a href="javascript: void(0);">Pay Register</a></li>
											<li><a href="javascript: void(0);">Pay Slip</a></li>
											<li><a href="javascript: void(0);">Leave /Vacation</a></li>
											<li><a href="javascript: void(0);">Loan</a></li>
											<li><a href="javascript: void(0);">Business Trip</a></li>
											<li><a href="javascript: void(0);">Business Trip Claim</a></li>
											<li><a href="javascript: void(0);">Traffic Violation</a></li>
											<li><a href="javascript: void(0);">Platform Penalty</a></li>
										</ul>
									</li>
									<li><a href="javascript: void(0);" class="has-arrow">Recruitment</a>
										<ul class="sub-menu" aria-expanded="true">
											<li><a href="javascript: void(0);">Candidate CV</a></li>
											<li><a href="javascript: void(0);">Letter of Intent</a></li>
											<li><a href="javascript: void(0);">Employee Contract</a></li>
											<li><a href="javascript: void(0);">ID card Acknowledgement</a></li>
											<li><a href="javascript: void(0);">Offer Letter</a></li>
											<li><a href="javascript: void(0);">Sim Card</a></li>
											<li><a href="javascript: void(0);">Bike Allotment</a></li>
											<li><a href="javascript: void(0);">Asset Handover</a></li>
										</ul>
									</li>
								</ul>
							</li>

							</ul>
						</li>
						-->
						<?php if (permission_exists($menus, 'human_resource')): ?>
							<li>
								<a href="javascript: void(0);" class="has-arrow waves-effect">
									<i class="mdi mdi-account-tie" style="font-size:24px !important"></i>
									<span>Human Resource</span>
								</a>
								<ul class="sub-menu" aria-expanded="false">
									<?php if (permission_exists($menus, 'talent_acquisition')): ?>
										<li>
											<a href="javascript: void(0);" class="has-arrow waves-effect">
												<span>Talent Acquisition</span>
											</a>
											<ul class="sub-menu" aria-expanded="truw">
												<?php if (permission_exists($menus, 'recruitment')): ?>
													<li><a href="javascript: void(0);" class="has-arrow">Recruitment </a>
														<ul class="sub-menu" aria-expanded="true">
															<?php if (permission_exists($menus, 'local')): ?>
																<li><a href="javascript: void(0);" class="has-arrow">Local </a>
																	<ul class="sub-menu" aria-expanded="true">
																		<?php if (permission_exists($menus, 'local_dashboard')): ?>
																		<li><a href="<?php echo base_url('admin/hr/recruitment/interview/dashboard'); ?>">Dashboard</a></li>
																		<?php endif; ?>
																		<?php if (permission_exists($menus, 'manage_interview')): ?>
																		<li><a href="<?php echo base_url('admin/hr/recruitment/interview') ?>">Manage Interview</a></li>
																		<?php endif; ?>
																	</ul>
																</li>
															<?php endif; ?>
														</ul>
													</li>
												<?php endif; ?>
												
											</ul>
										</li>
									<?php endif;
									if (permission_exists($menus, 'hr_module')): ?>
										<li>
											<a href="javascript: void(0);" class="has-arrow waves-effect">
												<span>HR Module</span>
											</a>
											<ul class="sub-menu" aria-expanded="false">
												<?php if (permission_exists($menus, 'hr_dashboard')): ?>
													<li>
														<a href="<?php echo base_url('admin/hr/dashboard'); ?>" class="waves-effect">
															<span> Dashboard</span>
														</a>
													</li>
												<?php endif;
												if (permission_exists($menus, 'request')): ?>
													<li><a href="javascript: void(0);" class="has-arrow">Request</a>
														<ul class="sub-menu" aria-expanded="true">
															<?php if (permission_exists($menus, 'your_requests')): ?>
																<li>
																	<a href="<?php echo base_url() ?>">
																		<span> Your Requests</span>
																	</a>
																</li>
															<?php endif;
															if (permission_exists($menus, 'tasks')): ?>
																<li>
																	<a href="<?php echo base_url() ?>">
																		<span> Tasks</span>
																	</a>
																</li>
															<?php endif;
															if (permission_exists($menus, 'team_request')): ?>
																<li>
																	<a href="<?php echo base_url('admin/hr-module/requests/team-requests/pending') ?>">
																		<span> Team Request</span>
																	</a>
																</li>
															<?php endif; ?>
														</ul>
													</li>
												<?php endif;
												if (permission_exists($menus, 'employees')): ?>
													<li><a href="javascript: void(0);" class="has-arrow">Employees</a>
														<ul class="sub-menu" aria-expanded="true">
															<?php if (permission_exists($menus, 'view_employees')): ?>
																<li>
																	<a href="<?php echo base_url('admin/hr/employees') ?>">
																		<span> View Employees</span>
																	</a>
																</li>
															<?php endif;
															if (permission_exists($menus, 'employees_payslip')): ?>
																<li>
																	<a href="<?php echo base_url('admin/hr/payslip/list') ?>">
																		<span> Employees Payslip</span>
																	</a>
																</li>
															<?php endif;
															if (permission_exists($menus, 'sanat_al_amar')): ?>
																<li>
																	<a href="<?php echo base_url('admin/hr-module/sanat-al-amar/list') ?>">
																		<span> Sanat Al Amar</span>
																	</a>
																</li>
															<?php endif;
															if (permission_exists($menus, 'clinical_visit_report')): ?>
																<li>
																	<a href="<?php echo base_url('admin/hr-module/clinical-report') ?>">
																		<span> Clinical Visit Report</span>
																	</a>
																</li>
															<?php endif;
															if (permission_exists($menus, 'iqama_renewal_list')): ?>
																<li>
																	<a href="<?php echo base_url('admin/hr-module/iqama-renewal-list') ?>">
																		<span> Iqama Renewal List</span>
																	</a>
																</li>
															<?php endif; ?>
															<li>
																<a href="<?php echo base_url('admin/hr/employee-transfer/index') ?>">
																	<span> Employees Transfer</span>
																</a>
															</li>
															<li>
																<a href="<?php echo base_url('admin/hr/change-profession/index') ?>">
																	<span> Change Profession</span>
																</a>
															</li>
														</ul>
													</li>
												<?php endif;
												if (permission_exists($menus, 'attendance')): ?>
													<li><a href="javascript: void(0);" class="has-arrow">Attendance</a>
														<ul class="sub-menu" aria-expanded="true">
															<?php if (permission_exists($menus, 'leave_balances')): ?>
																<li>
																	<a href="<?php echo base_url() ?>">
																		<span> Leave Balances</span>
																	</a>
																</li>
															<?php endif;
															if (permission_exists($menus, 'timesheet')): ?>
																<li>
																	<a href="<?= base_url('admin/vehicle/get-timesheet'); ?>">
																		<span> Attendance</span>
																	</a>
																</li>
															<?php endif;
															if (permission_exists($menus, 'new_attendance')): ?>
																<li>
																	<a href="<?= base_url('admin/hr/attendance/list'); ?>">
																		<span> New Attendance</span>
																	</a>
																</li>
															<?php endif;
															if (permission_exists($menus, 'manage_attendance')): ?>
																<li>
																	<a href="<?= base_url('admin/manage-attendance'); ?>">
																		<span>Manage Attendance</span>
																	</a>
																</li>
															<?php endif;
															if (permission_exists($menus, 'scheduler')): ?>
																<li>
																	<a href="<?php echo base_url() ?>">
																		<span> Scheduler</span>
																	</a>
																</li>
															<?php endif;
															if (permission_exists($menus, 'shifts_and_working_hours')): ?>
																<li>
																	<a href="<?php echo base_url() ?>">
																		<span> Shifts & Workings Hours</span>
																	</a>
																</li>
															<?php endif;
															if (permission_exists($menus, 'excuses_and_overtime')): ?>
																<li>
																	<a href="<?php echo base_url() ?>">
																		<span> Excuses & Overtime</span>
																	</a>
																</li>
															<?php endif;
															if (permission_exists($menus, 'reporting_methods')): ?>
																<li>
																	<a href="<?php echo base_url() ?>">
																		<span> Reporting Methods</span>
																	</a>
																</li>
															<?php endif; ?>
														</ul>
													</li>
												<?php endif;
												if (permission_exists($menus, 'payroll')): ?>
													<li><a href="javascript: void(0);" class="has-arrow">Payroll</a>
														<ul class="sub-menu" aria-expanded="true">
															<?php if (permission_exists($menus, 'payrolls')): ?>
																<li>
																	<a href="<?php echo base_url() ?>">
																		<span> Payroll</span>
																	</a>
																</li>
															<?php endif;
															if (permission_exists($menus, 'compliance')): ?>
																<li>
																	<a href="<?php echo base_url() ?>">
																		<span> Compliance</span>
																	</a>
																</li>
															<?php endif;
															if (permission_exists($menus, 'vacation_settlement')): ?>
																<li>
																	<a href="<?php echo base_url() ?>">
																		<span> Vacation Settlement</span>
																	</a>
																</li>
															<?php endif;
															if (permission_exists($menus, 'final_settlement')): ?>
																<li>
																	<a href="<?php echo base_url() ?>">
																		<span> Final Settlement</span>
																	</a>
																</li>
															<?php endif;
															if (permission_exists($menus, 'process_and_payment')): ?>
																<li>
																	<a href="<?php echo base_url() ?>">
																		<span> Process & Payment</span>
																	</a>
																</li>
															<?php endif; ?>
														</ul>
													</li>
												<?php endif;
												if (permission_exists($menus, 'report_and_statistics')): ?>
													<li><a href="javascript: void(0);" class="has-arrow">Report & Statistics</a>
														<ul class="sub-menu" aria-expanded="true">
															<?php if (permission_exists($menus, 'finance_reports')): ?>
																<li>
																	<a href="<?php echo base_url() ?>">
																		<span> Finance Reports</span>
																	</a>
																</li>
															<?php endif;
															if (permission_exists($menus, 'employee_reports')): ?>
																<li>
																	<a href="<?php echo base_url() ?>">
																		<span> Employee Reports</span>
																	</a>
																</li>
															<?php endif;
															if (permission_exists($menus, 'attendance_report')): ?>
																<li>
																	<a href="<?= base_url('admin/vehicle/get-daily-timesheet'); ?>">
																		<span> Attendance Report</span>
																	</a>
																</li>
															<?php endif;
															if (permission_exists($menus, 'leave_reports')): ?>
																<li>
																	<a href="<?php echo base_url() ?>">
																		<span> Leave Reports</span>
																	</a>
																</li>
															<?php endif; ?>
														</ul>
													</li>
												<?php endif;
												if (permission_exists($menus, 'company_profile')): ?>
													<li><a href="javascript: void(0);" class="has-arrow">Company Profile</a>
														<ul class="sub-menu" aria-expanded="true">
															<?php if (permission_exists($menus, 'company_profiles')): ?>
																<li>
																	<a href="<?php echo base_url() ?>">
																		<span> Company Profile</span>
																	</a>
																</li>
															<?php endif;
															if (permission_exists($menus, 'general_setting')): ?>
																<li>
																	<a href="<?php echo base_url() ?>">
																		<span> General Setting</span>
																	</a>
																</li>
															<?php endif;
															if (permission_exists($menus, 'company_documents')): ?>
																<li>
																	<a href="<?php echo base_url() ?>">
																		<span> Company Documents</span>
																	</a>
																</li>
															<?php endif;
															if (permission_exists($menus, 'notifications')): ?>
																<li>
																	<a href="<?php echo base_url() ?>">
																		<span> Notifications</span>
																	</a>
																</li>
															<?php endif; ?>
														</ul>
													</li>
												<?php endif;
												if (permission_exists($menus, 'organization')): ?>
													<li>
														<a href="javascript: void(0);" class="has-arrow waves-effect">
															<span>Organization</span>
														</a>
														<ul class="sub-menu" aria-expanded="true">
															<?php if (permission_exists($menus, 'employee_profile')): ?>
																<li>
																	<a href="<?php echo base_url() ?>">
																		<span> Employee Profile</span>
																	</a>
																</li>
															<?php endif;
															if (permission_exists($menus, 'bulk_import_or_export')): ?>
																<li>
																	<a href="<?php echo base_url() ?>">
																		<span> Bulk Import/Export</span>
																	</a>
																</li>
															<?php endif;
															if (permission_exists($menus, 'roles_and_permission')): ?>
																<li>
																	<a href="javascript: void(0);" class="has-arrow">Roles & Permission</a>
																	<ul class="sub-menu" aria-expanded="false">
																		<?php if (permission_exists($menus, 'users')): ?>
																			<li>
																				<a href="<?php echo base_url('admin/users/list') ?>" class="waves-effect">
																					<span> Users</span>
																				</a>
																			</li>
																		<?php endif;
																		if (permission_exists($menus, 'modules')): ?>
																			<li>
																				<a href="<?php echo base_url('admin/modules/list') ?>" class="waves-effect">
																					<span> Modules</span>
																				</a>
																			</li>
																		<?php endif;
																		if (permission_exists($menus, 'roles')): ?>
																			<li>
																				<a href="<?php echo base_url('admin/roles/list') ?>" class="waves-effect">
																					<span> Roles</span>
																				</a>
																			</li>
																		<?php endif;
																		if (permission_exists($menus, 'permissions')): ?>
																			<li>
																				<a href="<?php echo base_url('admin/roles/permission/list') ?>" class="waves-effect">
																					<span> Permissions</span>
																				</a>
																			</li>
																		<?php endif; ?>
																	</ul>
																</li>
															<?php endif; ?>
														</ul>
													</li>
												<?php endif;
												if (permission_exists($menus, 'leave_and_holidays')): ?>
													<li><a href="javascript: void(0);" class="has-arrow">Leave & Holidays</a>
														<ul class="sub-menu" aria-expanded="true">
															<?php if (permission_exists($menus, 'leave_types')): ?>
																<li>
																	<a href="<?php echo base_url('admin/hr-module/leave-types/annual-leave') ?>">
																		<span> Leave Types</span>
																	</a>
																</li>
															<?php endif;
															if (permission_exists($menus, 'public_holidays')): ?>
																<li>
																	<a href="<?php echo base_url('admin/hr-module/leave-types/holidays') ?>">
																		<span> Public Holidays</span>
																	</a>
																</li>
															<?php endif ?>
														</ul>
													</li>
												<?php endif;
												if (permission_exists($menus, 'request_and_approvals')): ?>
													<li><a href="javascript: void(0);" class="has-arrow">Request & Approvals</a>
														<ul class="sub-menu" aria-expanded="true">
															<?php if (permission_exists($menus, 'holidays_request')): ?>
																<li>
																	<a href="<?php echo base_url('admin/hr-module/request') ?>">
																		<span> Request</span>
																	</a>
																</li>
															<?php endif;
															if (permission_exists($menus, 'task')): ?>
																<li>
																	<a href="<?php echo base_url() ?>">
																		<span> Task</span>
																	</a>
																</li>
															<?php endif;
															if (permission_exists($menus, 'letters')): ?>
																<li>
																	<a href="<?php echo base_url() ?>">
																		<span> Letters</span>
																	</a>
																</li>
															<?php endif; ?>
														</ul>
													</li>
												<?php endif;
												if (permission_exists($menus, 'form_center')): ?>
													<li>
														<a href="<?php echo base_url('admin/form-center/list') ?>" class="waves-effect">
															<span> Form Center</span>
														</a>
													</li>
												<?php endif;
												if (permission_exists($menus, 'hr_masters')): ?>
													<li><a href="javascript: void(0);" class="has-arrow">HR Masters</a>
														<ul class="sub-menu" aria-expanded="true">
															<?php if (permission_exists($menus, 'allowance')): ?>
																<li><a href="<?php echo base_url('admin/hr/master/allowance') ?>">Allowance</a></li>
															<?php endif;
															if (permission_exists($menus, 'banks')): ?>
																<li><a href="<?php echo base_url('admin/masterbank') ?>">Banks</a></li>
															<?php endif;
															if (permission_exists($menus, 'beds')): ?>
																<li><a href="<?php echo base_url('admin/master/beds') ?>">Beds</a></li>
															<?php endif;
															if (permission_exists($menus, 'block_reasons')): ?>
																<li><a href="<?php echo base_url('admin/block-reasons') ?>">Block Reasons</a></li>
															<?php endif;
															if (permission_exists($menus, 'branches')): ?>
																<li><a href="<?php echo base_url('admin/hr/master/branch') ?>">Branches</a></li>
															<?php endif;
															if (permission_exists($menus, 'business_units')): ?>
																<li><a href="<?php echo base_url('admin/master/business-unit') ?>">Business Units</a></li>
															<?php endif;
															if (permission_exists($menus, 'camps')): ?>
																<li><a href="<?php echo base_url('admin/master/camps') ?>">Camps</a></li>
															<?php endif;
															if (permission_exists($menus, 'cities')): ?>
																<li><a href="<?php echo base_url('admin/master/city') ?>">Cities</a></li>
															<?php endif;
															if (permission_exists($menus, 'colors')): ?>
																<li><a href="<?php echo base_url('admin/vehiclecolor') ?>">Colors</a></li>
															<?php endif;
															if (permission_exists($menus, 'contract_status')): ?>
																<li><a href="<?php echo base_url('admin/master/contract-status') ?>">Contract Status</a></li>
															<?php endif;
															if (permission_exists($menus, 'countries')): ?>
																<li><a href="<?php echo base_url('admin/master/country') ?>">Countries</a></li>
															<?php endif;
															if (permission_exists($menus, 'majors')): ?>
																<li><a href="<?php echo base_url('admin/master/streams') ?>">Majors (Streams)</a></li>
															<?php endif;
															if (permission_exists($menus, 'grades')): ?>
																<li><a href="<?php echo base_url('admin/master/grade') ?>">Grades</a></li>
															<?php endif;
															if (permission_exists($menus, 'licence_types')): ?>
																<li><a href="<?php echo base_url('admin/master/licence-type') ?>">Licence Types</a></li>
															<?php endif;
															if (permission_exists($menus, 'locations')): ?>
																<li><a href="<?php echo base_url('admin/master/location') ?>">Locations</a></li>
															<?php endif;
															if (permission_exists($menus, 'departments')): ?>
																<li><a href="<?php echo base_url('admin/hr/master/department') ?>">Departments</a></li>
															<?php endif;
															if (permission_exists($menus, 'designations')): ?>
																<li><a href="<?php echo base_url('admin/hr/master/designations') ?>">Designations</a></li>
															<?php endif;
															if (permission_exists($menus, 'document_rejections')): ?>
																<li><a href="<?php echo base_url('admin/doc-rejection-reasons') ?>">Document Rejections</a></li>
															<?php endif;
															if (permission_exists($menus, 'educations')): ?>
																<li><a href="<?php echo base_url('admin/hr/master/education') ?>">Educations</a></li>
															<?php endif;
															if (permission_exists($menus, 'employment_types')): ?>
																<li><a href="<?php echo base_url('admin/hr/master/employment-types') ?>">Employment Types</a></li>
															<?php endif;
															if (permission_exists($menus, 'file_types')): ?>
																<li><a href="<?php echo base_url('admin/master/file-types') ?>">File Types</a></li>
															<?php endif;
															if (permission_exists($menus, 'nationalities')): ?>
																<li><a href="<?php echo base_url('admin/hr/master/nationality') ?>">Nationalities</a></li>
															<?php endif;
															if (permission_exists($menus, 'networks')): ?>
																<li><a href="<?php echo base_url('admin/network') ?>">Networks</a></li>
															<?php endif;
															if (permission_exists($menus, 'packages')): ?>
																<li><a href="<?php echo base_url('admin/hr/master/package/list') ?>">Packages</a></li>
															<?php endif;
															if (permission_exists($menus, 'pay_heads')): ?>
																<li><a href="<?php echo base_url('admin/hr/master/pay_head') ?>">Pay Heads</a></li>
															<?php endif;
															if (permission_exists($menus, 'plans')): ?>
																<li><a href="<?php echo base_url('admin/plan') ?>">Plans</a></li>
															<?php endif;
															if (permission_exists($menus, 'professions')): ?>
																<li><a href="<?php echo base_url('admin/hr/master/profession') ?>">Professions</a></li>
															<?php endif;
															if (permission_exists($menus, 'qiwa_status')): ?>
																<li><a href="<?php echo base_url('admin/master/qiwa-status') ?>">Qiwa Status</a></li>
															<?php endif;
															if (permission_exists($menus, 'regions')): ?>
																<li><a href="<?php echo base_url('admin/region') ?>">Regions</a></li>
															<?php endif;
															if (permission_exists($menus, 'remunerations')): ?>
																<li><a href="<?php echo base_url('admin/hr/master/remuneration/list') ?>">Remunerations</a></li>
															<?php endif;
															if (permission_exists($menus, 'rooms')): ?>
																<li><a href="<?php echo base_url('admin/master/rooms') ?>">Rooms</a></li>
															<?php endif;
															if (permission_exists($menus, 'sponsors')): ?>
																<li><a href="<?php echo base_url('admin/master/sponsors') ?>">Sponsors</a></li>
															<?php endif;
															if (permission_exists($menus, 'transaction_types')): ?>
																<li><a href="<?php echo base_url('admin/master/transaction-type') ?>">Transaction Types</a></li>
															<?php endif; ?>
														</ul>
													</li>
												<?php endif; ?>
											</ul>
										</li>
									<?php endif;
									if (permission_exists($menus, 'hr_services')): ?>
										<li>
											<a href="javascript: void(0);" class="has-arrow waves-effect">
												<span>HR Services</span>
											</a>
											<ul class="sub-menu" aria-expanded="false">
												<?php if (permission_exists($menus, 'sim_card_management')): ?>
													<li>
														<a href="javascript: void(0);" class="has-arrow waves-effect">
															<span>Sim Card Management</span>
														</a>
														<ul class="sub-menu" aria-expanded="false">
															<?php if (permission_exists($menus, 'sim_card')): ?>
																<li>
																	<a href="<?php echo base_url('admin/sim/list') ?>" class="waves-effect">
																		<span> Sim Card</span>
																	</a>
																</li>
															<?php endif;
															if (permission_exists($menus, 'port_inn_sim_card')): ?>
																<li>
																	<a href="<?php echo base_url('admin/sim/port-list') ?>" class="waves-effect">
																		<span> Port Inn Sim Card</span>
																	</a>
																</li>
															<?php endif;
															if (permission_exists($menus, 'recharge_management')): ?>
																<li><a href="javascript: void(0);" class="has-arrow">Recharge Management</a>
																	<ul class="sub-menu" aria-expanded="true">
																		<?php if (permission_exists($menus, 'vouchers')): ?>
																			<li><a href="<?php echo base_url('admin/sim/vouchers') ?>">Vouchers</a></li>
																		<?php endif;
																		if (permission_exists($menus, 'recharges')): ?>
																			<li><a href="<?php echo base_url('admin/prepaid-mobile-invoice/list') ?>">Recharges</a></li>
																		<?php endif;
																		if (permission_exists($menus, 'recharge_reports')): ?>
																			<li><a href="<?php echo base_url('admin/prepaid-mobile-invoice/consolidate-report') ?>">Reports</a></li>
																		<?php endif; ?>
																	</ul>
																</li>
															<?php endif;
															if (permission_exists($menus, 'invoice_management')): ?>
																<li><a href="javascript: void(0);" class="has-arrow">Invoice Management</a>
																	<ul class="sub-menu" aria-expanded="true">
																		<?php if (permission_exists($menus, 'sim_invoices')): ?>
																			<li><a href="<?php echo base_url('admin/mobile-invoice/list') ?>">Invoices</a></li>
																		<?php endif;
																		if (permission_exists($menus, 'invoice_reports')): ?>
																			<li><a href="<?php echo base_url('admin/mobile-invoice/consolidate-report') ?>">Reports</a></li>
																		<?php endif; ?>
																	</ul>
																</li>
															<?php endif; ?>
														</ul>
													</li>
												<?php endif;
												if (permission_exists($menus, 'driving_license_management')): ?>
													<li>
														<a href="javascript: void(0);" class="has-arrow waves-effect">
															<span>Driving License Management</span>
														</a>
														<ul class="sub-menu" aria-expanded="false">
															<?php if (permission_exists($menus, 'dl_request')): ?>
																<li>
																	<a href="<?php echo base_url('admin/dl-request/list') ?>" class="waves-effect">
																		<span> DL Request</span>
																	</a>
																</li>
															<?php endif;
															if (permission_exists($menus, 'dl_transactions')): ?>
																<li>
																	<a href="<?php echo base_url('admin/dl-transaction/list') ?>" class="waves-effect">
																		<span> DL Transactions</span>
																	</a>
																</li>
															<?php endif; ?>
														</ul>
													</li>
												<?php endif;
												if (permission_exists($menus, 'insurance_management')): ?>
													<li>
														<a href="javascript: void(0);" class="has-arrow waves-effect">
															<span>Insurance Management</span>
														</a>
														<ul class="sub-menu" aria-expanded="false">
															<?php if (permission_exists($menus, 'insurance_companies')): ?>
																<li><a href="<?php echo base_url('admin/master/insurance-company/list') ?>" class="waves-effect"><span>Insurance Companies</span></a></li>
															<?php endif;
															if (permission_exists($menus, 'insurance_policies')): ?>
																<li><a href="<?php echo base_url('admin/master/insurance-policies/list') ?>" class="waves-effect"><span>Insurance Policies</span></a></li>
															<?php endif;
															if (permission_exists($menus, 'insurance_policy_class')): ?>
																<li><a href="<?php echo base_url('admin/master/insurance-type/list') ?>" class="waves-effect"><span>Insurance Policy Class</span></a></li>
															<?php endif; ?>
														</ul>
													</li>
												<?php endif;
												if (permission_exists($menus, 'accident_management')): ?>
													<li>
														<a href="javascript: void(0);" class="has-arrow waves-effect">
															<span>Accident Management</span>
														</a>
														<ul class="sub-menu" aria-expanded="false">
															<?php if (permission_exists($menus, 'accident_list')): ?>
																<li>
																	<a href="<?php echo base_url('admin/hr/accidents') ?>">
																		<span> Accident List</span>
																	</a>
																</li>
																<li>
																	<a href="<?php echo base_url('admin/hr/accident-management') ?>">
																		<span> New Accident List</span>
																	</a>
																</li>
															<?php endif; ?>
														</ul>
													</li>
												<?php endif;
												if (permission_exists($menus, 'facility_management')): ?>
													<li>
														<a href="javascript: void(0);" class="has-arrow">Facility Management</a>
														<ul class="sub-menu" aria-expanded="false">
															<?php if (permission_exists($menus, 'property_list')): ?>
																<li><a href="<?php echo base_url('admin/facility-management/property/list') ?>" class="waves-effect">Property List</a></li>
															<li><a href="<?php echo base_url('admin/facility-management/bedding/list') ?>" class="waves-effect">Bedding List</a></li>
															<?php endif; ?>
														</ul>
													</li>
												<?php endif;
												if (permission_exists($menus, 'memos_and_announcements')): ?>
													<li>
														<a href="javascript: void(0);" class="has-arrow">Memos & Announcements</a>
														<ul class="sub-menu" aria-expanded="false">
															<?php if (permission_exists($menus, 'memos_list')): ?>
																<li><a href="<?php echo base_url('admin/hr/announcements') ?>" class="waves-effect">Memos List</a></li>
															<?php endif; ?>
														</ul>
													</li>
												<?php endif; ?>
											</ul>
										</li>
									<?php endif; ?>
								</ul>
							</li>
						<?php endif;
						if (permission_exists($menus, 'logistic_management')): ?>
							<li>
								<a href="javascript: void(0);" class="has-arrow waves-effect">
									<i class="mdi mdi-bike-fast"></i>
									<span>Logistic Management</span>
								</a>
								<ul class="sub-menu" aria-expanded="false">
									<?php if (permission_exists($menus, 'aggregator_id')): ?>
										<li><a href="<?php echo base_url('admin/logistic-management/platform-id/list') ?>" class="waves-effect">Aggregator ID</a></li>
									<?php endif;
									if (permission_exists($menus, 'rider_profile')): ?>
										<li><a href="<?php echo base_url('admin/logistic-management/rider/list') ?>" class="waves-effect">Rider Profile</a></li>
									<?php endif;
									if (permission_exists($menus, 'rider_log')): ?>
										<li><a href="javascript: void(0);" class="has-arrow">Rider Log</a>
											<ul class="sub-menu" aria-expanded="true">
												<?php if (permission_exists($menus, 'transfer_log')): ?>
													<li><a href="<?php echo base_url('admin/logistic-management/rider/transfer-log') ?>">Transfer Log</a></li>
												<?php endif;
												if (permission_exists($menus, 'suspend_log')): ?>
													<li><a href="<?php echo base_url('admin/logistic-management/rider/suspend-log') ?>">Suspend Log</a></li>
												<?php endif;
												if (permission_exists($menus, 'allotment_and_unallotment_log')): ?>
													<li><a href="<?php echo base_url('admin/logistic-management/rider/allot-unallot-log') ?>">Allotment / Unallotment Log</a></li>
												<?php endif; ?>
											</ul>
										</li>
									<?php endif;?>
									<li><a href="javascript: void(0);" class="has-arrow">Fuel Management</a>
										<ul class="sub-menu" aria-expanded="true">
											<li><a href="<?php echo base_url('admin/logistic-management/fuel-management/list') ?>">Vehicle List</a></li>
											<li><a href="<?php echo base_url('admin/logistic-management/fuel/list') ?>">Fuel Consumption</a></li>
										</ul>
									</li>
									<?php
									if (permission_exists($menus, 'hunger_station_performance')): ?>
										<li><a href="javascript: void(0);" class="has-arrow">Hunger Station Performance</a>
											<ul class="sub-menu" aria-expanded="true">
												<?php if (permission_exists($menus, 'rider_daily_performance')): ?>
													<li><a href="<?php echo base_url('admin/logistic-management/hunger/list') ?>">Rider Daily Performance</a></li>
												<?php endif;
												if (permission_exists($menus, 'hunger_compliance')): ?>
													<!-- <li><a href="javascript:;">Monthly Rider Performance</a></li>
										<li><a href="javascript:;">Monthly Company Performance</a></li> -->
													<li><a href="<?php echo base_url('admin/logistic-management/hunger/compliance-list') ?>">Compliance</a></li>
												<?php endif;
												if (permission_exists($menus, 'hunger_invoice')): ?>
													<li><a href="<?php echo base_url('admin/logistic-management/hunger/invoice-list') ?>">Hunger Invoice</a></li>
												<?php endif;
												if (permission_exists($menus, 'hunger_wallet_report')): ?>
													<li><a href="javascript: void(0);" class="has-arrow">Hunger Wallet Report</a>
														<ul class="sub-menu" aria-expanded="true">
															<?php if (permission_exists($menus, 'hunger_wallet_transaction')): ?>
																<li><a href="<?php echo base_url('admin/logistic-management/hunger/wallet-report') ?>">Hunger Wallet Transaction</a></li>
															<?php endif;
															if (permission_exists($menus, 'hunger_wallet_balances')): ?>
																<li><a href="javascript:;">Hunger Wallet Balances</a></li>
															<?php endif; ?>
														</ul>
													</li>
												<?php endif;
												if (permission_exists($menus, 'shift_management')): ?>
													<li><a href="<?php echo base_url('admin/logistic-management/hunger/rider-shift') ?>">Shift Management</a></li>
												<?php endif; ?>
											</ul>
										</li>
									<?php endif;
									if (permission_exists($menus, 'jahez_performance')): ?>
										<li><a href="javascript: void(0);" class="has-arrow">Jahez Performance</a>
											<ul class="sub-menu" aria-expanded="true">
												<?php if (permission_exists($menus, 'daily_performance')): ?>
													<li><a href="<?php echo base_url('admin/logistic-management/jahez/index') ?>">Daily Performance</a></li>
												<?php endif;
												if (permission_exists($menus, 'new_daily_performance')): ?>
													<li><a href="<?php echo base_url('admin/logistic-management/new-jahez/list') ?>">Daily Performance - New</a></li>
												<?php endif; ?>
											</ul>
										</li>
									<?php endif;
									if (permission_exists($menus, 'keeta_performance')): ?>
										<li><a href="javascript: void(0);" class="has-arrow">Keeta Performance</a>
											<ul class="sub-menu" aria-expanded="true">
												<?php if (permission_exists($menus, 'keeta_daily_performance')): ?>
													<li><a href="<?php echo base_url('admin/logistic-management/keeta/index') ?>">Daily Performance</a></li>
												<?php endif; ?>
											</ul>
										</li>
									<?php endif;
									if (permission_exists($menus, 'noon_performance')): ?>
										<li><a href="javascript: void(0);" class="has-arrow">Noon Performance</a>
											<ul class="sub-menu" aria-expanded="true">
												<?php if (permission_exists($menus, 'noon_daily_performance')): ?>
													<li><a href="<?php echo base_url('admin/logistic-management/noon/list') ?>">Daily Performance</a></li>
												<?php endif;
												if (permission_exists($menus, 'noon_daily_penelty')): ?>
													<li><a href="<?php echo base_url('admin/logistic-management/noon-penelty/list') ?>">Daily Penelty</a></li>
												<?php endif;
												if (permission_exists($menus, 'noon_cod_summary')): ?>
													<li><a href="<?php echo base_url('admin/logistic-management/noon-cod/list') ?>">COD Summary</a></li>
												<?php endif; ?>
											</ul>
										</li>
									<?php endif;
									if (permission_exists($menus, 'logistic_invoices')): ?>
										<li><a href="javascript: void(0);" class="has-arrow">Invoices </a>
											<ul class="sub-menu" aria-expanded="true">
												<?php if (permission_exists($menus, 'hunger')): ?>
													<li><a href="javascript: void(0);" class="has-arrow">Hunger</a>
														<ul class="sub-menu" aria-expanded="true">
															<?php if (permission_exists($menus, 'monthly_performance')): ?>
																<li><a href="<?php echo base_url('admin/logistic-management/invoices/hunger/list'); ?>">Monthly Performance</a></li>
															<?php endif;
															if (permission_exists($menus, 'sales_data')): ?>
																<li><a href="<?php echo base_url('admin/logistic-management/invoices/hunger-sales/list'); ?>">Sales Data</a></li>
															<?php endif;
															if (permission_exists($menus, 'sales_invoice')): ?>
																<li><a href="<?php echo base_url('admin/logistic-management/invoices/hunger-sales-invoice/list'); ?>">Sales Invoice</a></li>
															<?php endif; ?>
														</ul>
													</li>
												<?php endif;
												if (permission_exists($menus, 'keeta')): ?>
													<li><a href="javascript: void(0);" class="has-arrow">Keeta</a>
														<ul class="sub-menu" aria-expanded="true">
															<?php if (permission_exists($menus, 'keeta_monthly_performance')): ?>
																<li><a href="<?php echo base_url('admin/logistic-management/invoices/keeta/list'); ?>">Monthly Performance</a></li>
															<?php endif;
															if (permission_exists($menus, 'keeta_sales_data')): ?>
																<li><a href="<?php echo base_url('admin/logistic-management/invoices/keeta-sales/list'); ?>">Sales Data</a></li>
															<?php endif;
															if (permission_exists($menus, 'keeta_sales_invoice')): ?>
																<li><a href="<?php echo base_url('admin/logistic-management/invoices/keeta-sales-invoice/list'); ?>">Sales Invoice</a></li>
															<?php endif; ?>
														</ul>
													</li>
												<?php endif;
												if (permission_exists($menus, 'jahez')): ?>
													<li><a href="javascript: void(0);" class="has-arrow">Jahez</a>
														<ul class="sub-menu" aria-expanded="true">
															<?php if (permission_exists($menus, 'jahez_monthly_performance')): ?>
																<li><a href="<?php echo base_url('admin/logistic-management/invoices/jahez/list'); ?>">Monthly Performance</a></li>
															<?php endif;
															if (permission_exists($menus, 'jahez_sales_data')): ?>
																<li><a href="javascript:;">Sales Data</a></li>
															<?php endif;
															if (permission_exists($menus, 'jahez_sales_invoice')): ?>
																<li><a href="javascript:;">Sales Invoice</a></li>
															<?php endif; ?>
														</ul>
													</li>
												<?php endif; ?>
											</ul>
										</li>
									<?php endif; ?>
									<?php if (permission_exists($menus, 'jahez_rent')): ?>
									<li><a href="<?php echo base_url('admin/logistic-management/jahez-rent') ?>" class="waves-effect">Jahez Rent Agreement</a></li>
									<?php endif;?>
									<?php if (permission_exists($menus, 'riders_cash_collection')): ?>
										<li><a href="<?php echo base_url('admin/logistic-management/cash-collection/list') ?>" class="waves-effect">Riders Cash Collection</a></li>
									<?php endif;
									if (permission_exists($menus, 'logistic_settings')): ?>
										<li><a href="javascript: void(0);" class="has-arrow">Logistic Settings</a>
											<ul class="sub-menu" aria-expanded="true">
												<?php if (permission_exists($menus, 'delivery_target_and_incentive')): ?>
													<li><a href="<?php echo base_url('admin/incentives/list') ?>">Delivery Target & Incentive</a></li>
												<?php endif;
												if (permission_exists($menus, 'hunger_team')): ?>
													<li><a href="<?php echo base_url('admin/logistic-management/hunger/hunger-team') ?>">Hunger Team</a></li>
												<?php endif;
												if (permission_exists($menus, 'shift_master')): ?>
													<li><a href="<?php echo base_url('admin/logistic-management/hunger/hunger-shift') ?>">Shift Master</a></li>
												<?php endif;
												if (permission_exists($menus, 'area_master')): ?>
													<li><a href="<?php echo base_url('admin/logistic-management/hunger/hunger-area') ?>">Area Master</a></li>
												<?php endif;
												if (permission_exists($menus, 'cash_collection_reasons')): ?>
													<li><a href="<?php echo base_url('admin/master/cash-reason') ?>">Cash Collection Reasons</a></li>
												<?php endif;
												if (permission_exists($menus, 'suspend_reasons')): ?>
													<li><a href="<?php echo base_url('admin/master/master-reason') ?>">Suspend Reasons</a></li>
												<?php endif; ?>
											</ul>
										</li>
									<?php endif; ?>
									<!--
								<li><a href="<?php //echo base_url('admin/employed-rider/list') 
												?>" class="waves-effect">Manage Employed Riders</a></li>
								<li><a href="<?php //echo base_url('admin/no-dues') 
												?>" class="waves-effect"><span> Rider No Dues Certificate</span></a></li>
								<li><a href="<?php //echo base_url('admin/employed-rider/jahez/index') 
												?>" class="waves-effect">Jahez Order Summary</a></li>
								<li><a href="<?php //echo base_url('admin/employed-rider/jahez/get-report') 
												?>" class="waves-effect">Jahez Report</a></li>
								<li><a href="<?php //echo base_url('admin/employed-rider/hunger/index') 
												?>" class="waves-effect">Hunger Order Summary</a></li>
								<li><a href="<?php //echo base_url('admin/employed-rider/hunger/get-report') 
												?>" class="waves-effect">Hunger Report</a></li>
								<li><a href="<?php //echo base_url('admin/employed-rider/hunger/get-daywise-report') 
												?>" class="waves-effect">Hunger Daywise Report</a></li>
								<li><a href="<?php //echo base_url('admin/petrol-summary/index') 
												?>" class="waves-effect">Rider Petrol Summary</a></li>
								-->
								</ul>
							</li>
						<?php endif; ?>

						<?php if (permission_exists($menus, 'dispute_management')): ?>
							<li>
								<a href="javascript: void(0);" class="has-arrow waves-effect">
									<i class="dripicons-message"></i>
									<span>Dispute Management</span>
								</a>
								<ul class="sub-menu" aria-expanded="false">
									<?php if (permission_exists($menus, 'master_disputes_type')): ?>
										<li><a href="<?php echo base_url('admin/masters/dispute-types') ?>" class="waves-effect">Master Disputes Type</a></li>
									<?php endif;
									if (permission_exists($menus, 'dispute_list')): ?>
										<li><a href="<?php echo base_url('admin/disputes/list') ?>" class="waves-effect">Dispute List</a></li>
									<?php endif; ?>
								</ul>
							</li>
						<?php endif;
						if (permission_exists($menus, 'finance')): ?>
							<li>
								<a href="javascript: void(0);" class="has-arrow waves-effect">
									<i class="ti-credit-card"></i>
									<span>Finance</span>
								</a>
								<ul class="sub-menu" aria-expanded="false">
									<?php if (permission_exists($menus, 'finance')): ?>
										<li>
											<a href="javascript:;" class="waves-effect">
												<span> Expenses</span>
											</a>
										</li>
									<?php endif;
									if (permission_exists($menus, 'payment_request_form')): ?>
										<li>
											<a href="<?php echo base_url('admin/finance/payment-request') ?>" class="waves-effect">
												<span> Payment Request Form</span>
											</a>
										</li>
									<?php endif;
									if (permission_exists($menus, 'direct_expenses')): ?>
										<li>
											<a href="javascript:;" class="waves-effect">
												<span> Direct Expenses</span>
											</a>
										</li>
									<?php endif;
									if (permission_exists($menus, 'incomes')): ?>
										<li>
											<a href="javascript:;" class="waves-effect">
												<span> Incomes</span>
											</a>
										</li>
									<?php endif;
									if (permission_exists($menus, 'treasuries_bank_account')): ?>
										<li>
											<a href="javascript:;" class="waves-effect">
												<span> Treasuries & Bank Account</span>
											</a>
										</li>
									<?php endif;
									if (permission_exists($menus, 'finance_settings')): ?>
										<li>
											<a href="javascript:;" class="waves-effect">
												<span> Finance Settings</span>
											</a>
										</li>
									<?php endif; ?>
								</ul>
							</li>
						<?php endif;
						if (permission_exists($menus, 'accounting')): ?>
							<li>
								<a href="javascript: void(0);" class="has-arrow waves-effect">
									<i class="ti-bag"></i>
									<span>Accounting</span>
								</a>
								<ul class="sub-menu" aria-expanded="false">
									<?php if (permission_exists($menus, 'accounting')): ?>
										<li>
											<a href="<?php echo base_url('admin/accounting/journal/list') ?>" class="waves-effect">
												<span> Journal Entry</span>
											</a>
										</li>
									<?php endif;
									if (permission_exists($menus, 'only_for_admin')): ?>
										<li>
											<a href="<?php echo base_url('admin/chart-of-accounts'); ?>" class="waves-effect">
												<span> Chart of Accounts</span>
											</a>
										</li>
										<li>
											<a href="<?php echo base_url('admin/accounting/costcenters/list'); ?>" class="waves-effect">
												<span> Cost Center</span>
											</a>
										</li>
										<li>
											<a href="javascript:;" class="waves-effect">
												<span> Assets</span>
											</a>
										</li>
										<li>
											<a href="javascript:;" class="waves-effect">
												<span> Accounts Setting</span>
											</a>
										</li>
										<li>
											<a href="<?php echo base_url('admin/tax-setting/list'); ?>" class="waves-effect">
												<span> Tax Setting</span>
											</a>
										</li>
									<?php endif; ?>
								</ul>
							</li>
						<?php endif;
						if (permission_exists($menus, 'only_for_admin')): ?>
							<li>
								<a href="javascript: void(0);" class="has-arrow waves-effect">
									<i class="ti-bar-chart"></i>
									<span>Reports</span>
								</a>
								<ul class="sub-menu" aria-expanded="false">
									<li>
										<a href="<?php echo base_url('admin/sales-report') ?>" class="waves-effect">
											<span> Sales Report</span>
										</a>
									</li>
									<li>
										<a href="<?php echo base_url('admin/purchase-reports') ?>" class="waves-effect">
											<span> Purchase Reports</span>
										</a>
									</li>
									<li>
										<a href="<?php echo base_url('admin/credit-account/user-report') ?>" class="waves-effect">
											<span> Credit Reports</span>
										</a>
									</li>
									<li>
										<a href="javascript:;" class="waves-effect">
											<span> Account Reports</span>
										</a>
									</li>
									<li>
										<a href="javascript:;" class="waves-effect">
											<span> Attendance Reports</span>
										</a>
									</li>
									<li>
										<a href="<?php echo base_url('admin/payroll-reports') ?>" class="waves-effect">
											<span> Payroll Report</span>
										</a>
									</li>
									<li>
										<a href="javascript:;" class="waves-effect">
											<span> Point & Credit Reports</span>
										</a>
									</li>
									<li>
										<a href="javascript:;" class="waves-effect">
											<span> Memberships Reports</span>
										</a>
									</li>
									<li>
										<a href="javascript:;" class="waves-effect">
											<span> Workflow Reports</span>
										</a>
									</li>
									<li>
										<a href="javascript:;" class="waves-effect">
											<span> Work Order Reports</span>
										</a>
									</li>
									<li>
										<a href="javascript:;" class="waves-effect">
											<span> Clients Reports</span>
										</a>
									</li>
									<li>
										<a href="javascript:;" class="waves-effect">
											<span> Store Reports</span>
										</a>
									</li>
									<li>
										<a href="javascript:;" class="waves-effect">
											<span> Time-Tracking Reports</span>
										</a>
									</li>
									<li>
										<a href="javascript:;" class="waves-effect">
											<span> System Activity Reports</span>
										</a>
									</li>
								</ul>
							</li>

							<li>
								<a href="javascript: void(0);" class="has-arrow waves-effect">
									<i class="ti-panel"></i>
									<span>Setting</span>
								</a>
								<ul class="sub-menu" aria-expanded="false">
									<li>
										<a href="<?php echo base_url('admin/common/change_password') ?>" class="waves-effect">
											<span> Profile</span>
										</a>
									</li>
									<li>
										<a href="<?php echo base_url('admin/app-setting/dasboard') ?>" class="waves-effect">
											<span> App Management</span>
										</a>
									</li>
									<li>
										<a href="<?php echo base_url('admin/coupon/list') ?>" class="waves-effect">
											<span> Coupons Management</span>
										</a>
									</li>
									<li>
										<a href="javascript:;" class="waves-effect">
											<span> Meta Tag</span>
										</a>
									</li>
									<li>
										<a href="javascript:;" class="waves-effect">
											<span> CMS Pages</span>
										</a>
									</li>
									<li>
										<a href="javascript:;" class="waves-effect">
											<span> Download DB Backup</span>
										</a>
									</li>
									<li>
										<a href="javascript:;" class="waves-effect">
											<span> Google Play Store Link</span>
										</a>
									</li>
									<li>
										<a href="javascript:;" class="waves-effect">
											<span> App Store Link</span>
										</a>
									</li>
									<li>
										<a href="javascript:;" class="waves-effect">
											<span> Facebook</span>
										</a>
									</li>
									<li>
										<a href="javascript:;" class="waves-effect">
											<span> Twitter</span>
										</a>
									</li>
									<li>
										<a href="javascript:;" class="waves-effect">
											<span> Snap Chat</span>
										</a>
									</li>
									<li>
										<a href="javascript:;" class="waves-effect">
											<span> Instagram</span>
										</a>
									</li>
									<li>
										<a href="javascript:;" class="waves-effect">
											<span> iOS Developer Account</span>
										</a>
									</li>
									<li>
										<a href="javascript:;" class="waves-effect">
											<span> Android Developer Account</span>
										</a>
									</li>
								</ul>
							</li>
							<li>
								<a href="javascript: void(0);" class="has-arrow waves-effect">
									<img src="admin_assets/icons/location.png" alt="Store Management" width="24px" class="me-1" />
									<span>Store Management</span>
								</a>
								<ul class="sub-menu" aria-expanded="false">
									<li>
										<a href="<?php echo base_url('admin/store/list') ?>" class="waves-effect">
											<span> Manage Store</span>
										</a>
									</li>
									<li>
										<a href="<?php echo base_url('admin/stockrequest') ?>" class="waves-effect">
											<span> Manage Store Transfer Request</span>
										</a>
									</li>
									<li>
										<a href="javascript:;" class="waves-effect">
											<span> Manage Store Dispatches</span>
										</a>
									</li>

								</ul>
							</li>
						<?php endif;
						if (permission_exists($menus, 'warehouse_management')): ?>
							<li>
								<a href="javascript: void(0);" class="has-arrow waves-effect">
									<img src="admin_assets/icons/warehouse.png" alt="Store Management" width="22px" class="me-1" />
									<span>Warehouse Management</span>
								</a>
								<ul class="sub-menu" aria-expanded="false">
									<?php if (permission_exists($menus, 'manage_warehouse')): ?>
										<li>
											<a href="<?php echo base_url() ?>admin/warehouse" class="waves-effect">
												<span> Manage Warehouse</span>
											</a>
										</li>
									<?php endif;
									if (permission_exists($menus, 'add_new_warehouse')): ?>
										<li>
											<a href="javascript:;" class="waves-effect">
												<span> Add New Warehouse</span>
											</a>
										</li>
									<?php endif;
									if (permission_exists($menus, 'manage_inventory')): ?>
										<li>
											<a href="<?php echo base_url('admin/warehouse/inventory/list') ?>" class="waves-effect">
												<span> Manage Inventory</span>
											</a>
										</li>
									<?php endif; ?>
								</ul>
							</li>
						<?php endif;
						if (permission_exists($menus, 'assets_management')): ?>
							<!-- Assets Module -->
							<li>
								<a href="javascript: void(0);" class="has-arrow waves-effect">
									<img src="admin_assets/icons/warehouse.png" alt="Store Management" width="22px" class="me-1" />
									<span>Assets Management</span>
								</a>
								<ul class="sub-menu" aria-expanded="false">
									<?php if (permission_exists($menus, 'assets')): ?>
										<li>
											<a href="javascript: void(0);" class="has-arrow waves-effect">
												<span>Assets</span>
											</a>
											<ul class="sub-menu" aria-expanded="false">
												<?php if (permission_exists($menus, 'all_assets')): ?>
													<li>
														<a href="<?php echo base_url('admin/asset-manage/all-assets') ?>" class="waves-effect">
															<span>All Assets</span>
														</a>
													</li>
												<?php endif;
												if (permission_exists($menus, 'vehicles')): ?>
													<li>
														<a href="<?= base_url('admin/master-vehicle/list'); ?>" class="waves-effect">
															<span>Vehicles</span>
														</a>
													</li>
												<?php endif; ?>
												<?php if (permission_exists($menus, 'vehiclesstatusreasons')): ?>
													<li>
														<a href="<?= base_url('admin/master/vehicle-reason'); ?>" class="waves-effect">
															<span>Vehicles Status Reasons</span>
														</a>
													</li>
												<?php endif; ?>
											</ul>
										</li>
									<?php endif;
									if (permission_exists($menus, 'inventory')): ?>
										<li>
											<a href="javascript: void(0);" class="has-arrow waves-effect">
												<span>Inventory</span>
											</a>
											<ul class="sub-menu" aria-expanded="false">
												<?php if (permission_exists($menus, 'manage_item')): ?>
													<li>
														<a href="admin/asset/inventory/manage-items" class="waves-effect">
															<span>Manage Item</span>
														</a>
													</li>
												<?php endif;
												if (permission_exists($menus, 'manage_item')): ?>
													<li>
														<a href="<?php echo base_url('admin/asset/inventory/manage-inventory') ?>" class="waves-effect">
															<span>Manage Inventory</span>
														</a>
													</li>
												<?php endif;
												if (permission_exists($menus, 'inventory_setting')): ?>
													<li>
														<a href="javascript: void(0);" class="has-arrow waves-effect">
															<span>Inventory Setting</span>
														</a>
														<ul class="sub-menu" aria-expanded="false">
															<?php if (permission_exists($menus, 'unit')): ?>
																<li>
																	<a href="<?php echo base_url('admin/asset/inventory/all-units'); ?>" class="waves-effect">
																		<span>Unit</span>
																	</a>
																</li>
															<?php endif;
															if (permission_exists($menus, 'brand')): ?>
																<li>
																	<a href="<?php echo base_url() ?>admin/asset/all-brands" class="waves-effect">
																		<span>Brand</span>
																	</a>
																</li>
															<?php endif; ?>
														</ul>
													</li>
												<?php endif; ?>
											</ul>
										</li>
									<?php endif;
									if (permission_exists($menus, 'only_for_admin')): ?>
										<li>
											<a href="javascript: void(0);" class="has-arrow waves-effect">
												<span>Procurement</span>
											</a>
											<ul class="sub-menu" aria-expanded="false">
												<li>
													<a href="javascript: void(0);" class="has-arrow waves-effect">
														<span>Purchase Requisitions</span>
													</a>
												</li>
												<li>
													<a href="javascript: void(0);" class="has-arrow waves-effect">
														<span>Purchase Order</span>
													</a>
												</li>
												<li>
													<a href="javascript: void(0);" class="has-arrow waves-effect">
														<span>Purchase GRN</span>
													</a>
												</li>
												<li>
													<a href="javascript: void(0);" class="has-arrow waves-effect">
														<span>Procurement Settings</span>
													</a>
												</li>
											</ul>
										</li>
										<li>
											<a href="javascript: void(0);" class="has-arrow waves-effect">
												<span>Helpdesk and Maintenance</span>
											</a>
											<ul class="sub-menu" aria-expanded="false">
												<li>
													<a href="javascript: void(0);" class="has-arrow waves-effect">
														<span>Helpdesk</span>
													</a>
													<ul class="sub-menu" aria-expanded="false">
														<li>
															<a href="#" class="waves-effect">
																<span>Manage Dispute/Tickets</span>
															</a>
														</li>
													</ul>
												</li>
												<li>
													<a href="javascript: void(0);" class="has-arrow waves-effect">
														<span>Maintenence</span>
													</a>
													<ul class="sub-menu" aria-expanded="false">
														<li>
															<a href="#" class="waves-effect">
																<span>Manage Job Cards</span>
															</a>
														</li>
													</ul>
												</li>
											</ul>
										</li>
									<?php endif;
									if (permission_exists($menus, 'h_and_m_settings')): ?>
										<li>
											<a href="javascript: void(0);" class="has-arrow waves-effect">
												<span>H&M Settings</span>
											</a>
											<ul class="sub-menu" aria-expanded="false">
												<?php if (permission_exists($menus, 'categories')): ?>
													<li>
														<a href="<?php echo base_url() ?>admin/asset/all-categories" class="waves-effect">
															<span>Categories</span>
														</a>
													</li>
												<?php endif;
												if (permission_exists($menus, 'condition')): ?>
													<li>
														<a href="<?php echo base_url() ?>admin/asset/all-conditions" class="waves-effect">
															<span>Condition</span>
														</a>
													</li>
												<?php endif;
												if (permission_exists($menus, 'model')): ?>
													<li>
														<a href="<?php echo base_url() ?>admin/asset/all-models" class="waves-effect">
															<span>Model</span>
														</a>
													</li>
												<?php endif; ?>
											</ul>
										</li>
									<?php endif; ?>
								</ul>
							</li>
						<?php endif;
						if (permission_exists($menus, 'only_for_admin')): ?>
							<li>
								<a href="javascript: void(0);" class="has-arrow waves-effect">
									<i class="ti-headphone-alt"></i>
									<span>Customer Support</span>
								</a>
								<ul class="sub-menu" aria-expanded="false">
									<li>
										<a href="javascript:;" class="waves-effect">
											<span> Chat Support</span>
										</a>
									</li>
									<li>
										<a href="javascript:;" class="waves-effect">
											<span> Email Support</span>
										</a>
									</li>
									<li>
										<a href="javascript:;" class="waves-effect">
											<span> WhatsApp Support</span>
										</a>
									</li>

								</ul>
							</li>
						<?php endif; ?>
						<!--
							<li>
								<a href="<?php echo base_url() ?>admin/vendor" class="waves-effect">
									<i class="dripicons-user font-size-20"></i> --
									<img src="admin_assets/icons/vendor.png" alt="Store Management" width="24px" class="me-2" />
									<span>Vendors</span>
								</a>
							</li>
							-->

					</ul>
				</div>
				<!-- Sidebar -->
			</div>
		</div>
		<!-- Left Sidebar End -->

		<!-- ============================================================== -->
		<!-- Start right Content here -->
		<!-- ============================================================== -->
		<div class="main-content">
			<div class="page-content">