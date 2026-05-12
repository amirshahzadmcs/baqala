<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>User Login | Calcbook</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta content="Admin" name="description" />
        <meta content="Admin" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="<?php echo base_url('retailer_assets/images/favicon.ico');?>" />

        <!-- Bootstrap Css -->
        <link href="<?php echo base_url('retailer_assets/css/bootstrap.min.css');?>" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="<?php echo base_url('retailer_assets/css/icons.min.css');?>" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="<?php echo base_url('retailer_assets/css/app.min.css');?>" id="app-style" rel="stylesheet" type="text/css" />
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
                    <div class="home-btn">
                        <a href="<?php echo base_url();?>" class="text-white router-link-active"><i class="fas fa-home h2"></i></a>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-md-8 col-lg-6 col-xl-5">
                            <div class="card">
                                <div class="card-body">
                                    <div class="px-2 py-2">
                                        <div class="text-center pb-2">
                                            <a href="<?php echo base_url();?>">
                                                <img src="<?php echo base_url('retailer_assets/images/logo-dark.png');?>" width="50%" alt="logo" />
                                            </a>
                                            <h5 class="text-primary mb-2 mt-4">Free Register</h5>
											<p class="text-muted">Get your free calcbook account now.</p>
                                        </div>
										<div class="social-login text-center mb-4">
											<a href="<?php echo $loginURL; ?>" class="google-login">
												<img src="<?php echo base_url('assets/images/google-icon.svg');?>" style="padding-right: 10px;" />
												Continue with Google
											</a>
										</div>
										<div class="border-heading">
											<h4>Or</h4>
										</div>
										<?php if ($this->session->flashdata('msg')) { ?>
											<div class="alert alert-danger"> <?= $this->session->flashdata('msg') ?> </div>
										<?php } ?>
                                        <form class="form-horizontal" method="POST" action="<?php echo base_url('register_submit');?>">
											<div class="mb-3">
												<label for="name">Full Name</label>
												<input type="text" class="form-control" id="name" name="name" placeholder="Enter your name">
											</div>
											
                                            <div class="mb-3">
												<label for="useremail">Email</label>
												<input type="email" class="form-control" id="useremail" name="email" placeholder="Enter email">        
											</div>
											
                                            <div>
                                                <button class="btn btn-primary w-100 waves-effect waves-light" type="submit">Continue</button>
                                            </div>
											
											<div class="mt-4 text-center">
												<p class="mb-0">By registering you agree to the calcbook <a href="#" class="text-primary">Terms of Use</a></p>
											</div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-2 text-center text-white">
								<p class="mb-2">Already have an account ? <a href="login" class="fw-bold text-white"> Login </a> </p>
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
        <script src="<?php echo base_url('retailer_assets/libs/jquery/jquery.min.js');?>"></script>
        <script src="<?php echo base_url('retailer_assets/libs/bootstrap/js/bootstrap.bundle.min.js');?>"></script>
        <script src="<?php echo base_url('retailer_assets/libs/metismenu/metisMenu.min.js');?>"></script>
        <script src="<?php echo base_url('retailer_assets/libs/simplebar/simplebar.min.js');?>"></script>
        <script src="<?php echo base_url('retailer_assets/libs/node-waves/waves.min.js');?>"></script>

        <script src="<?php echo base_url('retailer_assets/js/app.js');?>"></script>
    </body>
</html>
