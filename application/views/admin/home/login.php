<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Login | <?php echo WEBSITE_NAME; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta content="Company" name="description" />
        <meta content="Company" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="<?php echo base_url('admin_assets/images/favicon.ico');?>" />

        <!-- Bootstrap Css -->
        <link href="<?php echo base_url('admin_assets/css/bootstrap.min.css');?>" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="<?php echo base_url('admin_assets/css/icons.min.css');?>" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="<?php echo base_url('admin_assets/css/app.min.css');?>" id="app-style" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url('admin_assets/css/custom.css');?>" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
                        <div class="col-md-5 col-lg-5 col-xl-5">
                            <div class="card">
                                <div class="card-body">
                                    <div class="px-2 py-3">
                                        <div class="text-center">
                                            <a href="<?php echo base_url();?>">
                                                <img src="<?php echo base_url('admin_assets/images/logo.png');?>"  width="50%" alt="logo" />
                                            </a>
                                            <h5 class="text-primary mb-2 mt-4">Welcome Back !</h5>
                                            <p class="text-muted">Enter your email and password to login to your account.</p>
                                        </div>
										<?php if($this->session->flashdata('login_error')) { ?>
											<?php if($this->session->flashdata('is_success') == '1') { ?>
												<div class="alert alert-success alert-dismissible fade show" role="alert"><?= $this->session->flashdata('login_error') ?> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>
											<?php }else{ ?>
												<div class="alert alert-danger alert-dismissible fade show" role="alert"><?= $this->session->flashdata('login_error') ?> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>
											<?php } ?>
										<?php } ?>
                                        <form class="form-horizontal" method="POST" action="<?php echo base_url('admin/check-login');?>" id="loginForm">
                                            <div class="mb-3">
                                                <input type="email" class="form-control" id="username" name="username" placeholder="Enter your email" required />
                                            </div>
                                            <div class="mb-3">
                                                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" autocomplete="current-password" required />
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
                                                <button class="btn btn-custom-success w-100 waves-effect waves-light" type="submit">Sign In</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-1 text-center text-white">
                                <p class="text-dark">
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
        <script src="<?php echo base_url('admin_assets/libs/jquery/jquery.min.js');?>"></script>
        <script src="<?php echo base_url('admin_assets/js/app.js');?>"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script> 
            $(document).ready(function () {
                $('#loginForm').on('submit', function (e) {
                    e.preventDefault();
                    const form = $(this);
                    const url = form.attr('action');
                    const username = $('#username').val();
                    const password = $('#password').val();
                    // Show a loader or disable the button while processing (optional)
                    const submitButton = form.find('button[type="submit"]');
                    submitButton.prop('disabled', true).text('Processing...');

                    // AJAX request
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            username: username,
                            password: password,
                        },
                        success: function (response) {
                            // Manually parse if it's a raw string
                            let res = typeof response === 'string' ? JSON.parse(response) : response;
                            if (res.success) {
                                window.location.href = res.redirect_url;
                            } else {
                                toastr.error(res.message || 'Invalid Email | Username');
                            }
                        },
                        error: function (xhr, status, error) {
                            // Handle server or network errors
                            console.error(xhr.responseText);
                            toastr.error('An unexpected error occurred. Please try again.');
                        },
                        complete: function () {
                            // Re-enable the button
                            submitButton.prop('disabled', false).text('Sign In');
                        },
                    });
                });
            });
        </script>
    </body>
</html>
