<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <base href="<?php echo base_url(); ?>" />
        <meta content="width=device-width, initial-scale=1.0" name="viewport" />
        <meta content="ie=edge" http-equiv="X-UA-Compatible" />
        <title>Delivery Partner | Login</title>
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
					<form class="validate-form" method="POST" action="<?= base_url('delivery-partner/login-submit');?>">
						<div class="pt-4">
							<h1 class="main-heading">Become a Baqala Station<br> Delivery Boy</h1>
							<p class="text-muted">Secure a sustainable form of income in a place where you are most appreciated</p>
						</div>
						<div class="form-group mb-3">
							<label class="mb-1">Email</label>
							<input type="text" id="email" name="email" class="form-control" placeholder="Enter Your Email" maxlength="155" autocomplete="off" required autofocus />
						</div>
						<div class="form-group mb-3">
							<label class="mb-1">Password</label>
							<input type="password" id="password" name="password" class="form-control" placeholder="Enter Password" minlength="6" maxlength="55" autocomplete="off" required autofocus />
						</div>
                        
						<div class="d-grid gap-2">
							<button class="btn btn-success btn-lg btn-block" type="submit">Login</button>
						</div>
					</form>
					<p class="mt-2 text-center">Don't have an account? <a href="<?= base_url('delivery-partner/registation');?>" class="theme-color">SignUp</a></p>
				</div>
			</div>
			<div class="login100-more" style="background-image: url('assets/image/delivery/delivery-signup.jpg');"></div>
        </div>
        <!-- /container -->
        <script src="<?php echo base_url('assets/js/jquery.min.js');?>"></script>
        <script src="<?php echo base_url('assets/js/bootstrap.min.js');?>"></script>
    </body>
</html>
