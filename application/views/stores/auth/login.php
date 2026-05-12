<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Store Login | <?php echo WEBSITE_NAME; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta content="Company" name="description" />
        <meta content="Company" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="<?php echo base_url('store_assets/images/favicon.ico');?>" />

        <!-- Bootstrap Css -->
        <link href="<?php echo base_url('store_assets/css/bootstrap.min.css');?>" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="<?php echo base_url('store_assets/css/icons.min.css');?>" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="<?php echo base_url('store_assets/css/app.min.css');?>" id="app-style" rel="stylesheet" type="text/css" />
		<style>
			.social-login .google-login{
				color: #5f5d5d;
				font-weight: 700;
				background: #ffffff;
				padding: 7px 56px;
				box-shadow: 0px 0px 3px;
				text-align: center;
				font-size: 18px;
			}
			.google-login:hover{
				text-decoration:none;
				color: #000;
			}
			.border-heading h4 {
			  display: flex;
			  align-items: center;
			  padding: 10px 0px;
			  font-size: 16px;
			}

			.border-heading h4:before,
			.border-heading h4:after {
			  content: "";
			  width: 100%;
			  height: 1px;
				background: #c3c3c3;
			}

			.border-heading h4:before{
			  margin: 0 40px 0 0;
			}

			.border-heading h4:after{
			  margin: 0 0 0 40px;
			}
		</style>
    </head>

    <body class="authentication-bg bg-primary">
        <div class="home-center">
            <div class="home-desc-center">
                <div class="container">
                    <div class="home-btn pt-lg-5">
                        <a href="<?php echo base_url();?>" class="text-white router-link-active"><i class="fas fa-home h2"></i></a>
                    </div>

                    <div class="row justify-content-center pt-5">
                        <div class="col-md-5 col-lg-5 col-xl-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="px-2 py-3">
                                        <div class="text-center">
                                            <a href="<?php echo base_url();?>">
                                                <img src="<?php echo base_url('store_assets/images/logo.png');?>"  width="50%" alt="logo" />
                                            </a>
                                            <h5 class="text-primary mb-2 mt-4">Welcome Back !</h5>
                                            <p class="text-muted">Sign in to continue company account.</p>
                                        </div>
										<?php if($this->session->flashdata('msg')) { ?>
											<?php if($this->session->flashdata('is_success') == '1') { ?>
												<div class="alert alert-success alert-dismissible fade show" role="alert"><?= $this->session->flashdata('msg') ?> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></div>
											<?php }else{ ?>
												<div class="alert alert-danger alert-dismissible fade show" role="alert"><?= $this->session->flashdata('msg') ?> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></div>
											<?php } ?>
										<?php } ?>
                                        <form class="form-horizontal" method="POST" action="<?php echo base_url('store/submit-login');?>">
                                            <div class="mb-3">
                                                <label for="username">Username</label>
                                                <input type="text" class="form-control" id="username" name="username" placeholder="Enter username" required />
                                            </div>

                                            <div class="mb-3">
                                                <label for="userpassword">Password</label>
                                                <input type="password" class="form-control" id="userpassword" name="password" placeholder="Enter password" required />
                                            </div>
											<!--
                                            <div class="mb-3">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="customControlInline" />
                                                    <label class="form-label" for="customControlInline">Remember me</label>
                                                </div>
                                            </div>
											-->
                                            <div>
                                                <button class="btn btn-primary w-100 waves-effect waves-light" type="submit">Log In</button>
                                            </div>
											<!--
                                            <div class="mt-4 text-center">
                                                <a href="<?php echo base_url('admin/common/password_request');?>" class="text-muted"><i class="mdi mdi-lock me-1"></i> Forgot your password?</a>
                                            </div>
											-->
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-1 text-center text-white">
                                <p>
                                    ©
                                    <script>
                                        document.write(new Date().getFullYear());
                                    </script>
                                     All Rights Reserved. <?php echo WEBSITE_NAME; ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Log In page -->
        </div>

        <!-- JAVASCRIPT -->
        <script src="<?php echo base_url('store_assets/js/app.js');?>"></script>
    </body>
</html>
