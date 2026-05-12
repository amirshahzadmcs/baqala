<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8" />
	<base href="<?php echo base_url(); ?>" />
	<meta content="width=device-width, initial-scale=1.0" name="viewport" />
	<meta content="ie=edge" http-equiv="X-UA-Compatible" />
	<title>Team Leader | Login</title>
	<link rel="shortcut icon" href="<?php echo base_url('assets/image/favicon.png'); ?>" />
	<link href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet" />
	<link href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" rel="stylesheet" />
	<link rel="stylesheet" href="<?php echo base_url('store_assets/css/teamleader_mobile.css'); ?>">
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

		.main-heading {
			color: #005500;
		}

		.form-container {
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

		.form-container form label {
			font-weight: 400;
			font-size: 18px;
			color: #4e4e4e;
		}

		.form-container form input {
			height: 50px;
		}

		.theme-color {
			color: #005500;
		}

		@media (min-width: 1200px) {
			.main-heading {
				font-size: 1.2rem;
			}
		}

		@media (max-width: 768px) {
			.login100-form {
				width: 100%;
			}

			.login100-more {
				display: none;
			}

			h1.main-heading {
				font-size: 1rem;
			}

			.header-logo {
				text-align: center;
			}
		}

		@media (max-width: 425px) {
			h1.main-heading {
				font-size: 1rem;
			}

			.login100-form {
				padding: 20px 15px 12px;
			}
		}

		@media (max-width: 320px) {
			h1.main-heading {
				font-size: 1rem;
			}

			.login100-form {
				padding: 20px 15px 12px;
			}
		}

		.message-toast {
			position: absolute;
			bottom: 20px;
		}
	</style>
</head>

<body>
	<div class="main-container_web">
		<div class="login100-form">
			<div class="header">
				<div class="header-logo">
					<img src="<?= base_url('assets/image/logo.png'); ?>">
				</div>
			</div>
			<div class="form-container" id="signup-form">
				<div class="message-toast">
					<?php if ($this->teamleader->getInfo()) {
						$info = explode("--", $this->teamleader->getInfo());
						$info_type = $info[0];
						$msg_data = $info[1];
						if ($info_type == 2) {
					?>
							<div class="alert alert-danger alert-dismissible fade show" role="alert">
								<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
								<strong>Error!</strong> <?php echo $msg_data; ?>
							</div>
						<?php } else { ?>
							<div class="alert alert-success alert-dismissible fade show" role="alert">
								<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
								<strong>Success!</strong> <?php echo $msg_data; ?>
							</div>
					<?php }
					}
					$this->teamleader->removeInfo(); ?>
				</div>
				<form class="validate-form" method="POST" action="<?= base_url('team-leader/login-submit'); ?>">
					<div class="pt-5">
						<h1 class="main-heading">Welcome Back Team Leader</h1>
						<p class="text-muted">Secure a sustainable form of income in a place where you are most appreciated</p>
					</div>
					<div class="form-group mb-3">
						<label class="mb-1">Username<span class="text-danger">*</span></label>
						<input type="text" id="username" name="username" class="form-control" placeholder="Enter Your Username" maxlength="55" autocomplete="off" required autofocus />
					</div>
					<div class="form-group mb-3">
						<label class="mb-1">Password<span class="text-danger">*</span></label>
						<input type="password" id="password" name="password" class="form-control" placeholder="Enter Password" minlength="6" maxlength="55" autocomplete="off" required autofocus />
					</div>

					<div class="d-grid gap-2 py-2">
						<button class="btn btn-success btn-lg btn-block" type="submit">Login</button>
					</div>
				</form>
				<p class="mt-2 text-center">Don't remember your password? <a href="<?= base_url('hiring-agency'); ?>" class="theme-color">Forgot Password</a></p>
			</div>
		</div>
		<div class="login100-more" style="background-image: url('images/teamLeader.jpg'); background-position:center;"></div>
	</div>
	<div class="main-container">
	<div class="message-toast">
					<?php if ($this->teamleader->getInfo()) {
						$info = explode("--", $this->teamleader->getInfo());
						$info_type = $info[0];
						$msg_data = $info[1];
						if ($info_type == 2) {
					?>
							<div class="alert alert-danger alert-dismissible fade show" role="alert">
								<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
								<strong>Error!</strong> <?php echo $msg_data; ?>
							</div>
						<?php } else { ?>
							<div class="alert alert-success alert-dismissible fade show" role="alert">
								<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
								<strong>Success!</strong> <?php echo $msg_data; ?>
							</div>
					<?php }
					}
					$this->teamleader->removeInfo(); ?>
				</div>
		<div class="login100-form">
			<div class="header">
				<div class="header-logo">
					<img src="<?= base_url('assets/image/logo.png'); ?>">
				</div>
				<div class="title-heading-login">
					<h1>BS Team Leader</h1>
					<p>Login</p>
				</div>
			</div>
			<div class="form-container" id="signup-form">
				<!-- <div class="message-toast"><div class="alert alert-success alert-dismissible fade show" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button><strong>Success!</strong> Successfully Logout							
                    </div></div> -->
				<form class="validate-form" method="POST" action="<?= base_url('team-leader/login-submit'); ?>">
					<div class="form-group mb-3">
						<label class="mb-1">Employed Id <span class="text-danger">*</span>
						</label>
						<input type="text" id="username" name="username" class="form-control" placeholder="Enter Your Username"
							maxlength="55" autocomplete="off" required="" autofocus="">
					</div>
					<div class="form-group mb-3">
						<label class="mb-1">Password <span class="text-danger">*</span>
						</label>
						<input type="password" id="password" name="password" class="form-control" placeholder="Enter Password"
							minlength="6" maxlength="55" autocomplete="off" required="" autofocus="">
					</div>
					<div class="d-grid gap-2 py-2">
						<button class="btn btn-success btn-lg btn-block theme-btn" type="submit">Login</button>
					</div>
				</form>
				<!-- <p class="mt-2 text-center">Don't remember your password? <a href="https://www.demo5.arinfotech.co/hiring-agency" class="theme-color">Forgot Password</a></p> -->
			</div>
		</div>
		<div class="login100-more" style="background-image: url('images/teamLeader.jpg'); background-position:center;">
		</div>
	</div>
	<script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
</body>

</html>