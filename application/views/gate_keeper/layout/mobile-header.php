<?php $this->load->helper('text'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Gate Keeper | <?php echo WEBSITE_NAME; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <base href="<?php echo base_url(); ?>" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?php echo base_url('store_assets/images/favicon.ico'); ?>" />

    <!-- plugin css -->
    <link href="<?php echo base_url('store_assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css'); ?>" rel="stylesheet" type="text/css" />

    <!-- Bootstrap Css -->
    <link href="<?php echo base_url('store_assets/css/bootstrap.min.css'); ?>" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="<?php echo base_url('store_assets/css/icons.min.css'); ?>" rel="stylesheet" type="text/css" />

    <!-- select2  -->
    <link href="<?php echo base_url('store_assets/libs/select2/css/select2.min.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('store_assets/libs/spectrum-colorpicker2/spectrum.min.css'); ?>" rel="stylesheet" type="text/css">
    <!-- dropzone css -->
    <link href="<?php echo base_url('store_assets/libs/dropzone/min/dropzone.min.css'); ?>" rel="stylesheet" type="text/css" />
    <!-- Sweet Alert-->
    <link href="<?php echo base_url('store_assets/libs/sweetalert2/sweetalert2.min.css'); ?>" rel="stylesheet" type="text/css" />
    <!-- DataTables -->
    <link href="<?php echo base_url('store_assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('store_assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css'); ?>" rel="stylesheet" type="text/css" />
    <!-- Responsive datatable examples -->
    <link href="<?php echo base_url('store_assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('store_assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css'); ?>" rel="stylesheet">
    <!-- App Css-->
    <link href="<?php echo base_url('store_assets/css/app.css'); ?>" id="app-style" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('store_assets/css/custom.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('store_assets/css/progress-bar.css'); ?>" rel="stylesheet" type="text/css" />

    <link href="https://fonts.googleapis.com/css2?family=Exo:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <style>
        .menubar-area.footer-fixed {
            position: fixed !important;
            bottom: 0;
            left: 0;
            width: 100%;
            z-index: 99 !important;
        }

        @media only screen and (max-width: 2024px) {
            .main-content {
                display: none;
            }

            footer.footer {
                display: none;
            }

            .menubar-area .toolbar-inner {
                padding-left: 0;
                padding-right: 0;
                display: flex;
                max-width: 1000px;
                margin-right: auto;
                margin-left: auto;
                align-items: center;
                justify-content: space-around;
                background: #FFFFFF;
                box-shadow: 0px -12px 37px rgba(230, 235, 243, 0.5);
                border-radius: 15px 15px 0px 0px;

            }

            .nav-link {
                text-align: center;
                display: grid;
                padding-top: 10px;
                padding-bottom: 10px;
                font-size: 12px;
                color: #000;
            }

            .navbar-header {
                display: none;
            }

            .title-part h2 {
                font-size: 20px;
                margin-bottom: 0px;
                color: #000;
                position: relative;
                font-weight: 400;
            }

            .title-part h2 b {
                color: #35b366;
            }

            .header-part {
                padding: 10px 10px;
            }

            .w-50 {
                width: 50%;
            }

            .item-1 {
                /* Group 6841 */

                /* Rectangle 4196 */



                background: #FFFFFF;
                box-shadow: -1px 1px 4px 2px rgba(0, 0, 0, 0.04);
                border-radius: 19px;



            }

            .item-1.text-center h4 {
                color: #000;
                font-size: 13px;
                padding-top: 10px;
                margin-bottom: 0px;
            }

            .item-1.text-center p {
                color: #000;
                margin-bottom: 0px;
            }

            .item-1 {
                padding-top: 15px;
                padding-bottom: 15px;
            }

            .custom-button.side-1 button {
                background: #35B366 !important;
                box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25) !important;
                border-radius: 38px !important;
                border: 0px !important;
                padding: 10px 24px 10px 18px !important;
                width: 80%;
                margin: 0 auto;
                font-size: 14px;
                /* padding-top: 4px; */
                margin-top: 38px;
            }

            .title-part h2:before {
                content: "";
                position: absolute;
                left: 0;
                bottom: 0;
                width: 24px;
                height: 2px;
                background: #35b366;
            }

            a.nav-link.active i svg rect {
                stroke: #35B366;
            }

            a.nav-link.active i svg path {
                stroke: #35B366;
            }

            a.nav-link.active {
                color: #35B366;
            }

            a.nav-link i svg rect {
                stroke: #000;
            }

            .item-1 .svg {
                min-height: 40px;
            }

            .web-none {
                display: block !important;
            }

            .header-part {
                display: block !important;
            }

            .custom-button.side-1 {
                display: block !important;
                text-align: center;
            }

            .main-content-2 {
                display: block !important;
            }

        }

        .web-none {
            display: none;
        }

        .header-part {
            display: none;
        }

        .main-content-2 {
            display: none;
        }
    </style>
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
    <?php $sess_logistic_name = $this->session->userdata('emp_name'); ?>
    <div class="main-content-2">
        <div class="header-part">
            <div class="d-flex justify-content-between align-items-center">
                <div class="title-part">
                    <h2><b>BS</b> Gate Keeper</h2>
                </div>
                <div class="dropdown d-inline-block">
                    <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="18" cy="15" r="4.5" fill="#35B366" />
                            <circle cx="18" cy="18" r="13.5" stroke="#FFCD02" stroke-width="1.2" />
                            <path d="M26.8078 28.2124C26.9233 28.1202 26.9699 27.9654 26.9178 27.827C26.354 26.3277 25.2201 25.0059 23.6721 24.0499C22.0449 23.0448 20.0511 22.5 18 22.5C15.9489 22.5 13.9551 23.0448 12.3279 24.0498C10.7799 25.0059 9.64599 26.3277 9.08216 27.827C9.03013 27.9654 9.07672 28.1202 9.1922 28.2124C14.3429 32.3279 21.6571 32.3279 26.8078 28.2124Z" fill="white" stroke="#35B366" stroke-width="1.2" stroke-linecap="round" />
                        </svg>
                        <span class="d-none d-xl-inline-block ms-1"><?php echo $sess_logistic_name; ?></span>
                        <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <!-- item-->
                        <a class="dropdown-item" href="<?php echo base_url('gate-keeper/profile') ?>"><i class="mdi mdi-account-circle-outline font-size-16 align-middle me-1"></i> Profile</a>
                        <a class="dropdown-item d-block" href="<?php echo base_url('gate-keeper/change-password') ?>"><i class="mdi mdi-cog-outline font-size-16 align-middle me-1"></i> Change Password</a>
                        <!--<a class="dropdown-item" href="javascript: void(0);"><i class="mdi mdi-lock-open-outline font-size-16 align-middle me-1"></i> Lock screen</a>-->
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item text-danger" href="<?php echo base_url('gate-keeper/logout') ?>"><i class="mdi mdi-power font-size-16 align-middle me-1 text-danger"></i> Logout</a>
                    </div>
                </div>
            </div>
        </div>