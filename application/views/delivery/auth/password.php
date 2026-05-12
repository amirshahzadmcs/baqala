<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <base href="<?php echo base_url(); ?>" />
        <meta content="width=device-width, initial-scale=1.0" name="viewport" />
        <meta content="ie=edge" http-equiv="X-UA-Compatible" />
        <title>Delivery Partner | Signup</title>
        <link rel="shortcut icon" href="<?php echo base_url('assets/image/favicon.png');?>" />
        <link href="<?php echo base_url('assets/css/bootstrap.min.css');?>" rel="stylesheet" />
        <link href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" rel="stylesheet" />
        <style>
			.login100-form {
				width: 50%;
				min-height: 100vh;
				display: block;
				background-color: #ffffff;
				padding: 20px 55px 12px;
				float: left;
			}
			.login100-more {
				width: calc(100% - 50%);
				background-repeat: no-repeat;
				background-size: cover;
				background-position: center;
				position: relative;
				z-index: 1;
				float: right;
    			height: 100vh;
			}
			.main-heading{
				color: #005500;
			}
			.form-container{
				width: 25rem;
				max-width: 100%;
				margin: auto;
			}
			.form-container .btn-success {
				color: #fff;
				background-color: #005500;
				border-color: #005500;
			}
			.form-container .btn-success:hover {
				color: #fff;
				background-color: #000000;
				border-color: #000000;
			}
			.form-container form label{
				font-weight: 600;
				font-size: 18px;
    			color: #848484;
			}
			.form-container form input{
				height: 50px;
			}
			.theme-color{
				color:#005500;
			}
			@media (min-width: 1200px){
				.main-heading{
					font-size: 1.8rem;
				}
			}
			@media (max-width: 768px){
				.login100-form {
					width: 100%;
				}
				.login100-more {
					display: none;
				}
				h1.main-heading {
					font-size: 34px;
				}
				.header-logo {
					text-align: center;
				}
			}
			@media (max-width: 425px){
				h1.main-heading {
					font-size: 24px;
				}
				.login100-form {
					padding: 20px 15px 12px;
				}
			}
			@media (max-width: 320px){
				h1.main-heading {
					font-size: 22px;
				}
				.login100-form {
					padding: 20px 15px 12px;
				}
			}
        </style>
    </head>
    <body>
        <div class="main-container">
			<div class="login100-form">
				<div class="header">
					<div class="header-logo">
						<img src="<?= base_url('assets/image/logo.png');?>">
					</div>
				</div>
				<div class="form-container" id="signup-form">
					<div>
						<?php if($this->deliveryboy->getInfo()){ 
						$info = explode("--", $this->deliveryboy->getInfo());
						$info_type = $info[0];
						$msg_data = $info[1];
						if($info_type == 2){
						?>  
						<div class="alert alert-danger alert-dismissible fade show" role="alert">
							<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
							<strong>Error!</strong>  <?php echo $msg_data; ?>
						</div>
						<?php } else{?>
						<div class="alert alert-success alert-dismissible fade show" role="alert">
							<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
							<strong>Success!</strong>  <?php echo $msg_data; ?>
						</div>
						<?php } } $this->deliveryboy->removeInfo();?>
					</div>
					<form class="validate-form" method="POST" action="<?= base_url('delivery-partner/submit-registration');?>">
						<div class="pt-4">
							<h1 class="main-heading">Become a Baqala Station Delivery Boy</h1>
							<p class="text-muted">Secure a sustainable form of income in a place where you are most appreciated</p>
						</div>
						<input type="hidden" name="email" id="email" value="<?= $this->session->userdata('signup_email');?>" required />
						<div class="form-group mb-3">
							<label class="mb-1">Password</label>
							<input type="password" id="password" name="password" class="form-control" placeholder="Enter Password" minlength="6" maxlength="55" autocomplete="off" required autofocus />
						</div>
                        <div class="form-group mb-3">
							<label class="mb-1">Confirm Password</label>
							<input type="password" id="confirm_password" name="confirm_password" class="form-control" placeholder="Enter Password" minlength="6" maxlength="55" autocomplete="off" required autofocus />
						</div>
						<div id="message"></div>
						<div class="form-group mb-3">
							<input type="checkbox" class="custom-control-input" name="privacy" id="register-policy-2" value="1" required style="height: 13px;">
							<label class="custom-control-label" for="register-policy-2"><?php echo $this->lang->line('msg_agree_term_cond') ?> *</label>
						</div>
						<div class="d-grid gap-2">
							<button class="btn btn-success btn-lg btn-block" type="submit">Continue</button>
						</div>
					</form>
					<p class="mt-2 text-center">Already have an account? <a href="<?= base_url('delivery-partner/login');?>" class="theme-color">SignIn</a></p>
				</div>
			</div>
			<div class="login100-more" style="background-image: url('assets/image/delivery/delivery-signup.jpg');"></div>
        </div>
        <!-- /container -->
        <script src="<?php echo base_url('assets/js/jquery.min.js');?>"></script>
        <script src="<?php echo base_url('assets/js/bootstrap.min.js');?>"></script>
		<script type="text/javascript">
			$(document).ready(function(e) {
				$('#password, #confirm_password').on('keyup', function () {
				if ($('#password').val() == $('#confirm_password').val()) {
					$('#message').html('Matching').css('color', 'green');
				} else
					$('#message').html('Password and confirm password not match').css('color', 'red');
				});
			});
		</script>
    </body>
</html>
